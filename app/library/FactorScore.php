<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * @usage 写入因子成绩
	 * @state 2~3
	 * @author Wangyaohui
	 * @notice 1.内存表的加载需首先完成
	 * 		   2.Examinee表中存有examinee_id, 及相应的project_id , state, QuestionAns表中有相应记录
	 * 		   3.对比project_detail
	 * @Date 2015-9-1
	 */
class FactorScore{
	
	private static $error_state = 2;
	/**
	 * @usage 添加静态变避免在一次请求中重复加载内存表
	 * @var boolean
	 */
	private static $memory_state = false;
	/**
	 * @usage 缓存到本地的用户信息  id sex 1男性 0女性  project_id
	 * @var array 
	 */
	private static $examinee_info = array();
	/**
	 * @usage 缓存到本地的所有需要填写的因子,二维数组,试卷名-因子名
	 * @var array
	 */
	private static $factors_list_all = array();
	/**
	 * @usage 在计算基础得分之前，首先加载内存表
	 * @throws Exception
	 * @return boolean
	 */
	protected static function loadMemoryTable(){
		self::$memory_state =  MemoryTable::loader();	
		return self::$memory_state;
	}
	/**
	 * @usage 获取被试的个人信息, 成功则返回数组/性别/年龄, 失败则返回false表示这一层已经完成 异常则表示底层没有完成 
	 * @param int $examinee_id
	 */
	protected static function getExamineeInfo($examinee_id){
		$examinee_info = Examinee::findFirst(
			array(
			"id = :examinee_id:",
			'bind' => array('examinee_id' =>$examinee_id)
		)
		);
		if(!isset($examinee_info->id)){
			throw new Exception(self::$error_state."-不存在id号-".$examinee_id);
		}else{
			if($examinee_info->state == 2){
				$rt_array = array();
				#examinee表中性别：1男性 0女性
				if($examinee_info->sex != 1 && $examinee_info->sex != 0){
					throw new Exception(self::$error_state."-性别不明-".$examinee_info->sex);
				}
				$rt_array['sex'] = $examinee_info->sex;
				$rt_array['age'] = self::calAge($examinee_info->birthday, $examinee_info->last_login);
				$rt_array['project_id'] = $examinee_info->project_id;
				self::$examinee_info = $rt_array;
				if(isset($rt_array)){unset($rt_array);}
				if(isset($examinee_info)){unset($examinee_info);};
				return true;
				
			}else if($examinee_info->state <= 1 ){
				throw new Exception(self::$error_state.'-下层计算还未完成-'.'id-'.$examinee_id.'-state-'.$examinee_info->state);
			}else{
				return false;
			}
		}	
	}
	/**
	 * @usage 年龄计算函数
	 * @param time $birthday
	 * @param time $today
	 * @throws Exception
	 * @return string
	 * 有效的时间戳通常从 Fri, 13 Dec 1901 20:45:54 GMT 到 Tue, 19 Jan 2038 03:14:07 GMT（对应于 32 位有符号整数的最小值和最大值）
	 */
	public static function calAge($birthday, $today){
			$pattern = '/^\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])$/';
			if( preg_match($pattern, $birthday) == 0 ){
				throw new Exception(self::$error_state.'-生日有误-'.$birthday);
			}
			$startdate=strtotime($birthday);
			$enddate=strtotime($today);
			if($enddate <= $startdate){
				throw new Exception(self::$state."-The age is not avilable-".$birthday.'-'.$today);
			}
			$days=($enddate-$startdate)/3600/24 ;
			$age = sprintf("%.2f",$days/365);
			return $age;
	}
	
	protected static function getPapersByExamineeId($examinee_id){
		$rt_list = QuestionAns::find(
				array(
						"examinee_id = :examinee_id:",
						'bind' => array('examinee_id'=>$examinee_id)
				)
		);
		if(empty(self::$factors_list_all)){
			self::getFactorsAll($examinee_id);
		}
		if(count($rt_list) != count(self::$factors_list_all)){
			throw new Exception(self::$error_state.'-答卷数量不正确-'.count($rt_list).'-'.count(self::$factors_list_all));
		}
		$papers_id_tmp = array();
		foreach($rt_list as $value){
			$papers_id_tmp[] = $value->paper_id;
		}
		$project_papers_id = array();
		foreach(self::$factors_list_all as $key=>$value){
			$project_papers_id[] = MemoryCache::getPaperDetail($key)->id;
		}
		if(!array_diff(  $papers_id_tmp , $project_papers_id) ) {
			return $rt_list;
		}else{
			throw new Exception(self::$error_state.'-答卷信息与题库信息不符-'.print_r($papers_id_tmp,true).print_r($project_papers_id,true));
		}
	}
	/**
	 * @usage 返回被试应该写入的所有因子得分
	 * @param int $examinee_id
	 */
	protected static function getFactorsAll($examinee_id){
		if(empty(self::$examinee_info)){
			self::getExamineeInfo($examinee_id);
		}
		$project_info = MemoryCache::getProjectDetail(self::$examinee_info['project_id']);
		self::$factors_list_all = json_decode($project_info->factor_names, true);
	}
	/**
	 * @usage 计算因子得分并写入到库的关键，采取个人按试卷记录插入操作
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function handleFactors($examinee_id){
		#加载内存表
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		if(empty(self::$examinee_info)){
			#false表示已经写入完成
			if(!self::getExamineeInfo($examinee_id)){
				return false;
			}
		}
		#读取project_detail
		if(empty(self::$factors_list_all)){
			self::getFactorsAll($examinee_id);
		}
		#读取questionAns
		$papers_list = self::getPapersByExamineeId($examinee_id);
		foreach($papers_list as $question_ans_record){
				$paper_name= $question_ans_record->Paper->name;
				$rtn_array_paper = null;
				switch(strtoupper($paper_name)){
					case "EPQA" : $rtn_array_paper = self::calEPQA($question_ans_record); break;
					case 'EPPS' : $rtn_array_paper = self::calEPPS($question_ans_record); break;
					case 'CPI'  : $rtn_array_paper = self::calCPI($question_ans_record); break;
					case 'SCL'  : $rtn_array_paper = self::calSCL($question_ans_record); break;
					case '16PF' : $rtn_array_paper = self::calKS($question_ans_record); break;
					case 'SPM'  : $rtn_array_paper = self::calSPM($question_ans_record); break;
					default : throw new Exception (self::$error_state."-不存在试卷-$paper_name");
				}	
				if(is_bool($rtn_array_paper) || empty($rtn_array_paper)){
						continue;
				}
				try{
					$manager     = new TxManager();
					$transaction = $manager->get();
					foreach ( $rtn_array_paper as $key => $value ) {
						#写入之前先行判断是否已经被写入过
						$isWrited = FactorAns::findFirst(
						array(
							"examinee_id=:examinee_id: AND factor_id = :factor_id:",
							'bind'=>array('examinee_id'=>$examinee_id, 'factor_id'=>$key)
						)
						);
						if(isset($isWrited->factor_id)){
							continue;
						}
						$factor_ans = new FactorAns();
						$factor_ans->setTransaction($transaction);
						$factor_ans->examinee_id = $examinee_id;
						$factor_ans->factor_id = $key;
						$factor_ans->score = $value['score'];
						$factor_ans->std_score = $value['std_score'];
						$factor_ans->ans_score = $value['ans_score'];
						if($factor_ans->save() == false){
							$transaction->rollback(self::$error_state."插入数据失败".print_r($factor_ans));
						}
					}
					$transaction->commit();
				}catch (TxFailed $e) {
					throw new Exception($e->getMessage());
				}
			}
			return true;
	}
	
	/**
	 * @usage EPQA计算
	 */
	protected static function calEPQA(&$resultsets){
		#首先判断是否需要写入epqa相关的因子分数
		if(empty(self::$factors_list_all)){
			self::getFactorsAll($resultsets->examinee_id);
		}
		if(!isset(self::$factors_list_all['EPQA'])){
			#true 表示不用写入EPQA的相关因子
			return true;
		}
		#计算全部因子的得分
		$score_array  = explode('|', $resultsets->score);
		$score_array  = array_count_values($score_array);
		unset($score_array['']);
		#标准分及最终分计算
		#确保加载内存表
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		if(empty(self::$examinee_info)){
			self::getExamineeInfo($resultsets->examinee_id);
		}
		$dage =  self::$examinee_info['age'];
		if($dage < 16 ||  $dage >= 150){
			throw new Exception(self::$error_state."EPQA年龄范围超限（16~150）".$dage);
		}
		$dsex =  self::$examinee_info['sex'] == 1? 1 : 2;
		#根据$factors_list_all['epqa'];
		$rt_array = array();
		foreach(self::$factors_list_all['EPQA'] as $key=>$value){
			$rt_array_record = array();
			#判断要写入的因子是否存在于之前的结果集中，若不存在，则置为0
			$score = 0;
			if(isset($score_array[$value])){
				$score = $score_array[$value];
			}
		 	$m  = 0;
			$sd = 0;
			$std_score = 0;
		 	$ans_score = 0;
		 	$epqamd = EpqamdMemory::findFirst(array(
		 		'DAGEL <= :age: AND DAGEH > :age: AND DSEX = :sex:',
		 		'bind'=>array('age'=>$dage,'sex'=>$dsex)));
		 	if(!isset($epqamd->DSEX)){
		 		throw new Exception(self::$error_state."-EPQAmd不存在记录-".'age-'.$dage.'-sex-'.$dsex);
		 	}
			switch($value){
		 		case 'epqae':
		 			$m = $epqamd->EM;
		 			$sd = $epqamd->ESD;
		 			$std_score = sprintf("%.2f",50 + (10 * ($score - $m)) / $sd);
		 			$ans_score = sprintf("%.2f",$std_score/10);
		 		    break;
		 		case 'epqan':
		 			$m = $epqamd->NM;
		 			$sd = $epqamd->NSD;
		 			$std_score = sprintf("%.2f",50 + (10 * ($score - $m)) / $sd);
		 			$ans_score = sprintf("%.2f",10 - $std_score/10);
		 			break;
		 		case 'epqap':
		 			$m = $epqamd->PM;
		 			$sd = $epqamd->PSD;
		 			$std_score = sprintf("%.2f",50 + (10 * ($score - $m)) / $sd);
		 			$ans_score = sprintf("%.2f",10 - $std_score/10);
		 			break;
		 		case 'epqal':
		 			$m = $epqamd->LM;
		 			$sd = $epqamd->LSD;
		 			$std_score = sprintf("%.2f",50 + (10 * ($score - $m)) / $sd);
		 			$ans_score = sprintf("%.2f",10 - $std_score/10);
		 			break;
		 		default:throw new Exception(self::$error_state.'-EPQAmd不存在因子-'.$value);
		 	}
		 $rt_array_record['score'] = floatval($score);
		 $rt_array_record['std_score'] = floatval($std_score);
		 $rt_array_record['ans_score'] = floatval($ans_score);
		 $rt_array[$key] = $rt_array_record;
		}
		return $rt_array;
	}
	/**
	 * EPPS 匹配sum  
	 */
	protected static function calEPPS(&$resultsets){
		#首先判断是否需要写入epps相关的因子分数
		if(empty(self::$factors_list_all)){
			self::getFactorsAll($resultsets->examinee_id);
		}
		if(!isset(self::$factors_list_all['EPPS'])){
			#true 表示不用写入EPPS的相关因子
			return true;
		}
		#计算全部因子的得分
		$score_array = explode('|', $resultsets->score);
		$score_array = array_count_values ($score_array);
		unset($score_array['']);
		$score_array['con'] = self::getEPPSCon($resultsets);
		#根据$factors_list_all['epps'];
		$rt_array = array();
		foreach(self::$factors_list_all['EPPS'] as $key => $value){
			$rt_array_record = array();
			#判断要写入的因子是否存在于之前的结果集中，若不存在，则置为0
			$score = 0;
			if(isset($score_array[$value])){
				if($value == 'con'){
					$score = $score_array[$value];
				}else{
					$score = $score_array[$value]-1;
				}
			}
			$std_score = $score;
			$ans_score = 0;
		 	if($value != 'con'){
		 		$ans_score = sprintf("%.2f",$std_score/2.8);
		 	}else{
		 		if ($std_score == 1) $ans_score = 9;
		 		else  if ($std_score == 2) $ans_score = 8;
		 		else  if ($std_score == 3) $ans_score = 7;
		 		else  if ($std_score == 4) $ans_score = 5;
		 		else  if ($std_score ==6 ) $ans_score = 2;
		 		else $ans_score = 1;
		 	}
		 	$rt_array_record['score'] = floatval($score);
		 	$rt_array_record['std_score'] = floatval($std_score);
		 	$rt_array_record['ans_score'] = floatval($ans_score);
		 	$rt_array[$key] = $rt_array_record;		 	
		}
		return $rt_array;
	}
	/**
	 * CPI 匹配 sum
	 */
	protected static function calCPI(&$resultsets){
		#首先判断是否需要写入cpi相关的因子分数
		if(empty(self::$factors_list_all)){
			self::getFactorsAll($resultsets->examinee_id);
		}
		if(!isset(self::$factors_list_all['CPI'])){
			#true 表示不用写入CPI的相关因子
			return true;
		}
		$string = str_replace('-', '|', $resultsets->score);
		$score_array = explode('|', $string);
		$score_array = array_count_values ($score_array);
		unset($score_array['']);
		#确保加载内存表
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		if(empty(self::$examinee_info)){
			self::getExamineeInfo($resultsets->examinee_id);
		}
		$dm =  self::$examinee_info['sex'] == 1? 1 : 2;
		$rt_array = array();
		foreach(self::$factors_list_all['CPI'] as $key => $value){
			$rt_array_record = array();
			#判断要写入的因子是否存在于之前的结果集中，若不存在，则置为0
			$score = 0;
			if(isset($score_array[$value])){
				$score = $score_array[$value];
			}
			$m = 0;
			$sd = 0;
			$std_score = 0;
		 	$ans_score = 0;
		 	#标准分
		 	$cpimd = CpimdMemory::findFirst(
				array(
		 		"DM = :dm: AND YZ = :yz:",
				'bind' => array('dm'=>$dm, 'yz' =>strtoupper($value))
		 	)
		 	);
		 	if(!isset($cpimd->DM)){
		 		throw new Exception(self::$error_state.'-CPI不存在记录-'.'-DM-'.$dm.'-YZ-'.$value);
		 	}
		 	$m =  $cpimd->M;
		 	$sd = $cpimd->SD;
		 	if($m != 0 && $sd != 0){
		 		$std_score = sprintf("%.2f",50 + (10 * ($score - $m)) / $sd);
		 	}
		 	#最终分
		 	if($value !='fx'){
		 		$ans_score = sprintf("%.2f",$std_score/10);
		 	}else{
		 		if ($std_score == 100) $ans_score = 10;
		 		else if ($std_score > 80) $ans_score = 9;
		 		else if ($std_score > 65) $ans_score = 8;
		 		else if ($std_score > 30) $ans_score = 5;
		 		else if ($std_score > 10) $ans_score = 2;
		 		else $ans_score = 1;
		 	}
		 	$array_record['score'] = floatval($score);
		 	$array_record['std_score'] = floatval($std_score);
		 	$array_record['ans_score'] = floatval($ans_score);
		 	$rt_array[$key] = $array_record;
		}
		return $rt_array;
	}
	/**
	 * SCL : svg
	 */
	protected static function calSCL(&$resultsets){
		#首先判断是否需要写入scl相关的因子分数
		if(empty(self::$factors_list_all)){
			self::getFactorsAll($resultsets->examinee_id);
		}
		if(!isset(self::$factors_list_all['SCL'])){
			#true 表示不用写入SCL的相关因子
			return true;
		}
		#整理SCL题目答案
		$question_ans_array = self::getAnswers($resultsets);
		#计算SCL因子的原始分，标准分，最终分
		$rt_array = array();
		foreach(self::$factors_list_all['SCL'] as $key=>$value){
			$factor_info = MemoryCache::getFactorDetail($value);
			$question_array = explode(',',$factor_info->children);
			$score = 0;
			$std_score = 0;
			$factor_total_score = 0;
			$question_number = 0;
			foreach($question_array as $skey){
				if(isset($question_ans_array[$skey])){
					$factor_total_score += $question_ans_array[$skey];
					$question_number++;
				}
			}
			if( $question_number!=0 ){
				$score = sprintf("%.2f",$factor_total_score/$question_number);
			}
			$std_score  = $score;
			$ans_score = 0;
			if ($std_score == 1) $ans_score = 9;
			else if ($std_score < 1.1) $ans_score = 8;
			else if ($std_score < 1.3) $ans_score = 7;
			else if ($std_score < 1.4) $ans_score = 6;
			else if ($std_score < 1.6 ) $ans_score = 4;
			else if ($std_score < 2) $ans_score = 3;
			else if ($std_score < 4) $ans_score = 2;
			else $ans_score = 1;
			$array_record['score'] = floatval($score);
			$array_record['std_score'] = floatval($std_score);
			$array_record['ans_score'] = floatval($ans_score);
			$rt_array[$key] = $array_record;
		}
		return $rt_array;	
	}
	/**
	 * 16PF
	 */
	protected static function calKS(&$resultsets){
		#首先判断是否需要写入16PF相关的因子分数
		if(empty(self::$factors_list_all)) {
			self::getFactorsAll($resultsets->examinee_id);
		}
		if(!isset(self::$factors_list_all['16PF'])) {
			#true 表示不用写入16PF的相关因子
			return true;
		}
		#确保加载内存表
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		#确保个人信息
		if(empty(self::$examinee_info)){
			self::getExamineeInfo($resultsets->examinee_id);
		}
		$dm =  self::$examinee_info['sex'] == 1? 8 : 9;
		#整理16PF题目答案
		$question_ans_array = self::getAnswers($resultsets);
// 		/**
// 		 * 注： 此处由于因子中存在包含因子的情况，因此，如果我们按照直接求所需因子的得分，那么能会遗漏包含着的但不需要的因子，因此采取最大集，之后与所需相匹配
// 		 */
// 		$factors_in_paper = MemoryCache::getFactors($resultsets->paper_id);
		
		#确定所有涉及的因子，不再进行全局遍历
		$array_all_use = array();
		foreach(self::$factors_list_all['16PF'] as $key=>$value) {
			$factor_detail = MemoryCache::getFactorDetail($value);
			if($factor_detail->action == 'sum'){
				if(!in_array($value, $array_all_use)){
					$array_all_use[$key] = $value;
				}
			}else{
				if(!in_array($value, $array_all_use)){
					$array_all_use[$key] = $value;
				}
				$child_factor_str = $factor_detail->children;
				$child_factor_array = explode(',', $child_factor_str);
				foreach($child_factor_array as $fvalue){
					if(!in_array($fvalue, $array_all_use)){
						$fvalue_tmp = MemoryCache::getFactorDetail($fvalue);
						$fkey = $fvalue_tmp->id;
						$array_all_use[$fkey] = $fvalue;
					}
				}
			}
		}
		ksort($array_all_use);
		#得到一个完全有效数组
		#返回数组
		$rt_array = array();
		#保存基础数组
		$basic_array = array();
		#前16项简单因子处理完毕
		foreach($array_all_use as $key => $value){
			$factor_record = MemoryCache::getFactorDetail($value);
			if($factor_record -> action == 'sum'){
				$array_record = array();
				#前16项(至多) 简单因子的原始得分，标准分，及最终得分
				$factor_record_number_array = explode(',',$factor_record->children);
				$score = 0;
				foreach( $factor_record_number_array as $skey){
					if(isset($question_ans_array[$skey])){
						$score += $question_ans_array[$skey];
					}
				}
				$std_score = 0;
				$ans_score = 0;
				$ksmd = KsmdMemory::findFirst(array(
						'DM=:dm: AND YZ=:yz: AND QSF <= :score: AND ZZF >= :score:',
						'bind'=>array('dm'=>$dm, 'yz' =>$value, 'score'=>$score)
				));
				if(!isset($ksmd->BZF)){
					throw new Exception(self::$error_state.'-Ksmd 不存在记录-'.'DM-'.$dm.'-YZ-'.$value.'-QSF-'.$score);
				}
				$std_score =  $ksmd->BZF;
				if($value != 'Q4'){
					$ans_score = $std_score;
				}else{
					$ans_score = 10 - $std_score;
				}
				$basic_array[$value] = $std_score;
				$array_record['score'] = $score;
				$array_record['std_score'] = $std_score;
				$array_record['ans_score'] = $ans_score;
				$rt_array[$key] = $array_record;
			}
		}
		#后8项(至多)复杂因子计算
		foreach($array_all_use as $key => $value){
			$factor_record = MemoryCache::getFactorDetail($value);
			if($factor_record->action != 'sum'){
				$array_record = array();
				$std_score = 0;
				$ans_score = 0;
				$score = 0;
				$code = preg_replace('/[A-Z][0-9]?/', '\$basic_array[\'$0\']', $factor_record->action);
				$code =  "\$score = sprintf(\"%.2f\",$code);";
				eval($code);
				$score = floatval($score);
				if($value != 'Y3'){
					$std_score = $score;
				}else{
					$ksmd = KsmdMemory::findFirst(array(
							'YZ=:yz: AND QSF <= :score: AND ZZF >= :score:',
							'bind'=>array( 'yz' =>$value, 'score'=>$score)
					));
					if(!isset($ksmd->BZF)){
						throw new Exception(self::$error_state.'-Ksmd不存在记录-'.'YZ-'.$value.'-QSF-'.$score);
					}
					$std_score =  $ksmd->BZF;
				}
				if($value == 'X1'){
					$ans_score = 10 - $std_score;
				}else if( $value == 'Y1' || $value == 'Y4'){
					$ans_score = sprintf("%.2f",$std_score/4);
				}else if ($value == 'Y2'){
					$ans_score = sprintf("%.2f",$std_score/7.5);
				}else{
					$ans_score = $std_score;
				}
				$array_record['score'] = floatval($score);
				$array_record['std_score'] = floatval($std_score);
				$array_record['ans_score'] = floatval($ans_score);
				$rt_array[$key] = $array_record;
			}
		}
		#对简单因子的再处理，由于之前出现的简单因子可能在总体需要的因子表中并不存在，我们现在需要对照project_detail取出需要的简单因子，而复杂因子只要出现了，那么就肯定要包含
		#rt_array >= $factor_list_all['16PF'];
		foreach($rt_array as $key=>$value){
			if (!array_key_exists($key, self::$factors_list_all['16PF'])){
				unset($rt_array[$key]);
			}
		}
		return $rt_array;
	}
	/**
	 * SPM
	 */
	protected static function calSPM(&$resultsets){
		#首先判断是否需要写入SPM相关的因子分数
		if(empty(self::$factors_list_all)) {
			self::getFactorsAll($resultsets->examinee_id);
		}
		if(!isset(self::$factors_list_all['SPM'])) {
			#true 表示不用写入SPM的相关因子
			return true;
		}
		#确保加载内存表
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		#确保个人信息
		if(empty(self::$examinee_info)){
		self::getExamineeInfo($resultsets->examinee_id);
		}
		#整理SPM题目答案
		$question_ans_array = self::getAnswers($resultsets);
		#确定所有涉及的因子，不再进行全局遍历
		$array_all_use = array();
		foreach(self::$factors_list_all['SPM'] as $key=>$value) {
			$factor_detail = MemoryCache::getFactorDetail($value);
			if($factor_detail->action == 'sum'){
				if(!in_array($value, $array_all_use)){
					$array_all_use[$key] = $value;
				}
			}else{
				if(!in_array($value, $array_all_use)){
					$array_all_use[$key] = $value;
				}
				$child_factor_str = $factor_detail->children;
				$child_factor_array = explode(',', $child_factor_str);
				foreach($child_factor_array as $fvalue){
					if(!in_array($fvalue, $array_all_use)){
						$fvalue_tmp = MemoryCache::getFactorDetail($fvalue);
						$fkey = $fvalue_tmp->id;
						$array_all_use[$fkey] = $fvalue;
					}
				}
			}
		}
		ksort($array_all_use);
		#得到一个完全有效数组
		#返回数组
		$rt_array = array();
		#保存基础数组
		$basic_array = array();
		#简单因子先处理，复杂因子后处理，由于复杂因子使用简单因子的原始分，那么我们次序对其进行运算
		foreach($array_all_use as $key => $value){
			$factor_record = MemoryCache::getFactorDetail($value);
			$score = 0;
			if($factor_record -> action == 'sum'){
				#前5项(至多) 简单因子的原始得分
				$factor_record_number_array = explode(',',$factor_record->children);
				foreach( $factor_record_number_array as $skey){
					if(isset($question_ans_array[$skey])){
						$score += $question_ans_array[$skey];
					}
				}
				$basic_array[$value] = $score;
			}else{
				#至多2项
				$code = preg_replace('/[a-z]+/', '\$basic_array[\'$0\']', $factor_record->action);
				$code =  "\$score = $code;";
				eval($code);
				$basic_array[$value] = $score;
			}
		}
		#basic_array >= $factor_list_all['SPM'];
		foreach($basic_array as $key=>$value){
			if (!in_array($key, self::$factors_list_all['SPM'])){
				unset($basic_array[$key]);
			}
		}
		#现在的$basic_array为有效数组的原始的分
		$age = self::$examinee_info['age'];
		#spm的年龄区间 5.25~110
		if($age <5.25 || $age>=110){
			throw new Exception(self::$error_state."SPM年龄范围越界".$age);
		}
		foreach($basic_array as $key=>$score){
			$factor_record = MemoryCache::getFactorDetail($key);
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			if($key == 'spm'){
				$spmmd = SpmmdMemory::findFirst(array(
						'NLH >= :age: AND NLL <= :age:',
						'bind'=>array('age'=>$age)));
				if(!isset($spmmd->NLH)){
					throw new Exception(self::$error_state.'-Spmmd不存在记录-'.'age-'.$age);
				}
				if ($score >= $spmmd->B95) {
					$std_score = 195;
				}else if ($score >= $spmmd->B90) {
					$std_score = 290;
				}else if ($score >= $spmmd->B75) {
					$std_score = 275;
				}else if ($score >= $spmmd->B50) {
					$std_score = 350;
				}else if ($score >= $spmmd->B25) {
					$std_score = 325;
				}else if ($score >= $spmmd->B10) {
					$std_score = 410;
				}else if ($score >= $spmmd->B5) {
					$std_score = 45;
				}else{
					$std_score = 50;
				}
				$flag = substr($std_score,0,1);
				if ($flag == 1) { $ans_score = 9; 
				}else if ($flag == 2) {$ans_score = 7.5; 
				}else if ($flag == 3) {$ans_score = 6; 
				}else if ($flag == 4) {$ans_score = 5; 
				}else if ($flag == 5) {$ans_score = 4; 
				}else {$ans_score = 1;
				}
			}else{
				$std_score = $score;
				if($key == 'spmabc'){
					$ans_score = sprintf("%.2f",$std_score/3.6);
				}else{
					$ans_score = sprintf("%.2f",$std_score/1.2);
				}
			}
			$array_record['score'] = floatval($score);
			$array_record['std_score'] = floatval($std_score);
			$array_record['ans_score'] = floatval($ans_score);
			$rt_array[$factor_record->id] = $array_record;
		}
		return $rt_array;
	}
	/**
	 * 返回一个数组[$question_number] = score;
	 * @param array $array
	 * @return array
	 */
	private static function getAnswers(&$array){
		$rtn_array = array();
		$number_list = explode('|', $array->question_number_list);
		$score_list  = explode('|', $array->score);
		foreach($number_list as $key => $number ){
			$score = $score_list[$key];
			$rtn_array[$number] =$score;
		}
		return $rtn_array;
	
	}
	
	/**
	 * use for EPPS con
	 * 返回一个$array[$question_number] = choice;
	 */
	private static function getEPPSCon(&$array){
		$rtn_array = array();
		$number_list = explode('|', $array->question_number_list);
		$choice_list = explode('|', $array->option);
		foreach($number_list as $key=>$number){
			$option = $choice_list[$key];
			$rtn_array[$number] = $option;
		}
		asort($rtn_array);
		#计算EPPS con
		$con_score = 0;
		#3次比照
		for($i = 1; $i<=25;$i+=6){
			if(isset($rtn_array[$i]) && isset($rtn_array[$i+150])){
				if($rtn_array[$i] != $rtn_array[$i+150]){
					$con_score += 1;
				}
			}
		}
		for($i = 26; $i<=50; $i+=6){
			if(isset($rtn_array[$i]) && isset($rtn_array[$i+75])){
				if($rtn_array[$i] != $rtn_array[$i+75]){
					$con_score += 1;
				}
			}
		}
		for($i = 51; $i<=75; $i+=6 ){
			if(isset($rtn_array[$i]) && isset($rtn_array[$i+150])){
				if($rtn_array[$i] != $rtn_array[$i+150]){
					$con_score += 1;
				}
			}
		}
		return $con_score;
	}
	
	/**
	 * @usage 完成因子得分计算后的被试状态转换
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function finishedFactor($examinee_id){
		$examinee_info = Examinee::findFirst(
				array("id = :id:",
						'bind'=>array('id'=>$examinee_id)
				)
		);
		#如果examinee_id为空，这种处理也合适
		if(isset($examinee_info->id)){
			try{
				$manager     = new TxManager();
				$transaction = $manager->get();
				$examinee_info->setTransaction($transaction);
				$examinee_info->state = 3;
				if($examinee_info->save() == false){
					$transaction->rollback(self::$error_state.'-数据库插入失败-'.print_r($examinee_info,true));
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception($e->getMessage());
			}
		}else{
			throw new Exception(self::$error_state.'-不存在该账号的用户-'.$examinee_id);
		}
	
	}
	
}