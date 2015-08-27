<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * @usage 使用条件在BasicScore完成handlePapers后,开始执行handleFactors($examinee_id);
	 * @param int $examinee_id;
	 * @author Wangyaohui
	 * @Date 2015-8-26
	 */
class FactorScore {
	/**
	 * @usage 添加静态变避免在一次请求中重复加载内存表
	 * @var boolean
	 */
	protected static $memory_state = false;
	/**
	 * @usage 缓存本地的带有成绩的试卷信息
	 * @var \Phalcon\Mvc\Model\Resultset\Simple
	 */
	private static $papers_list = null;
	/**
	 * @usage 缓存到本地已经写入过的因子
	 * @var  array 
	 */
	private static $factors_list_finished = null;
	/**
	 * @usage 缓存到本地的用户信息  id sex 1男性 0女性  project_id
	 * @var array 
	 */
	private static $examinee_info = null;
	/**
	 * @usage 缓存到本地的所有需要填写的因子,二维数组,试卷名-因子名
	 * @var array
	 */
	private static $factors_list_all = null;
	/**
	 * @usage 在计算基础得分之前，首先加载内存表
	 * @throws Exception
	 * @return boolean
	 */
	public static function beforeStart(){
		try{
			self::$memory_state =  MemoryTable::loader();
			return self::$memory_state;
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * @usage 用于查验FactorAns表中已经写入的factor成绩,并将写过的因子名称传给$factor_list;
	 * @param int $examinee_id
	 */
	protected static function getFinishedFactors($examinee_id){
		$results_from_factor_ans =  FactorAns::find(
			array(
			"examinee_id = :examinee_id:",
			'bind' => array ('examinee_id' =>$examinee_id)
		)
		);
		$rt_array = array();
		foreach ($results_from_factor_ans as $value){
			$rt_array[]  = $value->Factor->name;
		}
		self::$factors_list_finished = $rt_array;
		unset($results_from_factor_ans);
	}
	/**
	 * @usage 获取被试的个人信息,主要是两个:性别/年龄
	 * @param int $examinee_id
	 */
	protected static function getExamineeInfo($examinee_id){
		$results_from_examinee = Examinee::findFirst(
			array(
			"id = :examinee_id:",
			'bind' => array('examinee_id' =>$examinee_id)
		)
		);
		$rt_array = array();
		#examinee表中性别：1男性 0女性 
		if(empty($results_from_examinee->sex)){
			throw new Exception("The sex is null");
		}
		$rt_array['sex'] = $results_from_examinee->sex;
		$rt_array['age'] = self::calAge($results_from_examinee->birthday, $results_from_examinee->last_login);
		if($rt_array['age'] < 16 || $rt_array['age'] >= 150){
			throw new Exception("The age is not appropriate!");
		}
		$rt_array['project_id'] = $results_from_examinee->Project->id;
		self::$examinee_info = $rt_array;
		unset($rt_array);
		unset($results_from_examinee);
	}
	/**
	 * @usage 年龄计算函数
	 * @param time $birthday
	 * @param time $today
	 * @return string
	 */
	private static function calAge($birthday, $today){
			$startdate=strtotime($birthday);
			$enddate=strtotime($today);
			$days=round(($enddate-$startdate)/3600/24) ;
			$age = sprintf("%.2f",$days/365);
			return $age;
		}
	
	/**
	 * @usage 返回被试的全部答卷的得分信息，并写入到类的静态变量$papers_list中
	 * @param int $examinee_id
	 */
	protected static function getPapersByExamineeId($examinee_id){
		self::$papers_list = QuestionAns::find(
				array(
						"examinee_id = :examinee_id:",
						'bind' => array('examinee_id'=>$examinee_id)
				)
		);
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
		try {
			if(empty(self::$papers_list)){
				self::getPapersByExamineeId($examinee_id);
			}
			foreach(self::$papers_list as $question_ans_record){
				$paper_name= $question_ans_record->Paper->name;
				$rtn_array_paper = null;
				switch(strtoupper($paper_name)){
					case "EPQA" : $rtn_array_paper = self::calEPQA($question_ans_record); break;
					case 'EPPS' : $rtn_array_paper = self::calEPPS($question_ans_record); break;
// 					case 'CPI'  : $rtn_array_paper = self::calCPI($question_ans_record->score); break;
// 					case 'SCL'  : $rtn_array_paper = self::calSCL($question_ans_record); break;
// 					case '16PF' : $rtn_array_paper = self::calKS($question_ans_record); break;
// 					case 'SPM'  : $rtn_array_paper = self::calSPM($question_ans_record); break;
// 					default : throw new Exception ("no this type paper:$paper_name");
				}	
				echo "<pre>";
				var_dump($rtn_array_paper);
				echo "</pre>";
// 				if(is_bool($rtn_array_paper) || empty($rtn_array_paper)){
// 						continue;
// 				}
// 				try{
// 					$manager     = new TxManager();
// 					$transaction = $manager->get();
// 					foreach ( $rtn_array_paper as $key => $value ) {
// 						$factor_ans = new FactorAns();
// 						$factor_ans->examinee_id = $examinee_id;
// 						$factor_ans->factor_id = $key;
// 						$factor_ans->score = $value['score'];
// 						$factor_ans->std_score = $value['std_score'];
// 						$factor_ans->ans_score = $value['ans_score'];
// 						if($factor_ans->save() == false){
// 								$transaction->rollback("Cannot update table FactorAns' score");
// 						}
// 					}
// 					$transaction->commit();
// 				}catch (TxFailed $e) {
// 					throw new Exception("Failed, reason: ".$e->getMessage());
// 				}
			}
		return true;
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	
	/**
	 * @usage EPQA计算
	 * @param unknown $string
	 * @return multitype:
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
		#其次判断epqa相关的因子分数是否已经写入
		if(empty(self::$factors_list_finished)){
			self::getFinishedFactors($resultsets->examinee_id);
		}
		if(in_array('epqan',self::$factors_list_finished) || in_array('epqap',self::$factors_list_finished) || in_array('epqae',self::$factors_list_finished) || in_array('epqal',self::$factors_list_finished) ) {
			#false表示EPQA的因子已经写入完成
			return false;
		}
		#计算全部因子的得分
		$score_string = $resultsets->score;
		$score_array  = explode('|', $score_string);
		$score_array  = array_count_values($score_array);
		unset($score_array['']);
		#标准分及最终分计算
		#确保加载内存表
		if(!self::$memory_state){
			self::beforeStart();
		}
		if(empty(self::$examinee_info)){
			self::getExamineeInfo($resultsets->examinee_id);
		}
		$dage =  self::$examinee_info['age'];
		$dsex =  self::$examinee_info['sex'] == 1? 1 : 2;
		#根据$factors_list_all['epqa'];
		$rt_array = array();
		foreach(self::$factors_list_all['EPQA'] as $key=>$value){
			$factor_id = MemoryCache::getFactorDetail($value) ->id;
			$rt_array_record = array();
			$score = $score_array[$value];
		 	$m  = 0;
			$sd = 0;
			$std_score = 0;
		 	$ans_score = 0;
		 	$epqamd = EpqamdMemory::findFirst(array(
		 		'DAGEL <= :age: AND DAGEH > :age: AND DSEX = :sex:',
		 		'bind'=>array('age'=>$dage,'sex'=>$dsex)));
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
		 		default:throw new Exception("not found");
		 	}
		 $rt_array_record['score'] = floatval($score);
		 $rt_array_record['std_score'] = floatval($std_score);
		 $rt_array_record['ans_score'] = floatval($ans_score);
		 $rt_array[$factor_id] = $rt_array_record;
		}
		return $rt_array;
	}
	/**
	 * EPPS 匹配sum  
	 * @param unknown $array
	 */
	public static function calEPPS(&$resultsets){
		$array_15 = explode('|', $resultsets->option);
		$rt = array_count_values ($array_15);
		unset($rt['']);
		#计算稳定系数con
		$rt['con'] = self::getEPPSCon($array);
		$rt_array = array();
		foreach($rt as $key => $score){
			if($key !='con'){ 
				$score -=1;
			}
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			if($key != 'con'){
				$std_score = $score;
				$ans_score = $score/2.8;
			}else{
				if ($score == 1) $ans_score = 9; 
				else  if ($score == 2) $ans_score = 8; 
				else  if ($score == 3) $ans_score = 7; 
				else  if ($score == 4) $ans_score = 5; 
				else  if ($score ==6 ) $ans_score = 2; 
				else $ans_score = 1;
			}
			$array_record['score'] = $score;
			$array_record['std_score'] = $std_score;
			$array_record['ans_score'] = $ans_score;
			$rt_array[$key] = $array_record;
		}
		return $rt_array;
	}
	/**
	 * CPI 匹配 sum
	 * @param unknown $string
	 */
	public static function calCPI($string, $examinee){
		$string = str_replace('-', '|', $string);
		$array = explode('|', $string);
		$rt = array_count_values ($array);
		unset($rt['']);
		$dm = ($examinee->sex ==0) ? 2 : 1;
		$rt_array = array();
		foreach($rt as $key => $score) {
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;			
			$cpimd = Cpimd::findFirst(array(
					'DM=?0 and YZ=?1',
					'bind'=>array(0=>$dm,1=>$key)));
			$m = 0;
			$sd = 0;
			if(isset($cpimd->M)){
				$m =  $cpimd->M;
			}
			if(isset($cpimd->SD)){
				$sd = $cpimd->SD;
			}
			if($m != 0 && $sd != 0){
				$std_score = 50 + (10 * ($score - $m)) / $sd;
			}
			if ($key != 'fx'){
				$ans_score = $std_score/10;
			}else{
				if ($score == 100) $ans_score = 10; 
				else if ($score > 80) $ans_score = 9; 
				else if ($score > 65) $ans_score = 8; 
				else if ($score > 30) $ans_score = 5; 
				else if ($score > 10) $ans_score = 2;
				else $ans_score = 1;
			}
			$array_record['score'] = $score;
			$array_record['std_score'] = sprintf("%.2f", $std_score);
			$array_record['ans_score'] = $ans_score;
			$rt_array[$key] = $array_record;
		}
		return $rt_array;
	}
	
	/**
	 * SCL : svg
	 * @param unknown $array
	 */
	public static function calSCL(&$array){
		$number_array = self::getAnswers($array);
		$paper_id = Paper::getListByName('SCL')->id;
		$factor = Factor::queryCache($paper_id);
		$rt = array();
		foreach($factor as $factor_record){
			#遍历时为数组
			$factor_record_number_array = explode(',',$factor_record['children']);
			$factor_score = 0;
			$factor_number_count = 0;
			foreach( $factor_record_number_array as $skey){
				if(isset($number_array[$skey]) && $number_array[$skey] != 0){
					$factor_score += $number_array[$skey];
					$factor_number_count++;
				}
			}
			if($factor_score != 0 ){
				$rt[$factor_record['name']] = sprintf("%.2f",$factor_score/$factor_number_count);
			}
// 			$rt[$factor_record['name']] = $factor_score;
		}
		$rt_array = array();
		foreach($rt as $key => $score){
			$array_record = array();
			$std_score = 0;
			$std_score = $score;
			$ans_score = 0;
			if ($score == 1) $ans_score = 9; 
			else if ($score < 1.1) $ans_score = 8; 
			else if ($score < 1.3) $ans_score = 7; 
			else if ($score < 1.4) $ans_score = 6; 
			else if ($score < 1.6 ) $ans_score = 4;
			else if ($score < 2) $ans_score = 3; 
			else if ($score < 4) $ans_score = 2; 
			else $ans_score = 1;
			$array_record['score'] = $score;
			$array_record['std_score'] = $std_score;
			$array_record['ans_score'] = $ans_score;
			$rt_array[$key] = $array_record;
		}
		return $rt_array;	
	}
	/**
	 * 16PF
	 */
	public static function calKS(&$array,$examinee){
		$number_array = self::getAnswers($array);
		$paper_id = Paper::getListByName('16PF')->id;
		$factor = Factor::queryCache($paper_id);
		$rt = array();
		#前16项因子原始分
		foreach($factor as $factor_record) {
			if($factor_record['action'] == 'sum'){
				#循环16次
				$factor_record_number_array = explode(',',$factor_record['children']);
				$factor_score = 0;
				foreach( $factor_record_number_array as $skey){
					if(isset($number_array[$skey])){
						$factor_score += $number_array[$skey];
					}
				}
				$rt[$factor_record['name']] = $factor_score;
				#先遍历完简单因子的结果	
			}
		}
		$dm = ($examinee->sex ==0) ? 9 : 8;
		#前16项标准分 及最终得分
		$rt_array = array();
		foreach ($rt as $key => $score ){
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			$ksmd = Ksmd::find(array(
					'DM=?0 AND YZ=?1',
					'bind'=>array(0=>$dm,1=>$key)));
			foreach ($ksmd as $ksmds ) {
				if ($score <= $ksmds->ZZF && $score >= $ksmds->QSF) {
					$std_score = $ksmds->BZF;
				}
			}
			if($key =='Q4'){
				$ans_score = 10-$std_score;
			}else{
				$ans_score = $std_score;
			}
			$array_record['score'] = $score;
			$array_record['std_score'] = $std_score;
			$array_record['ans_score'] = $ans_score;
			$rt_array[$key] = $array_record;
			
		}
		unset($rt);
		$rt = array();
		#后8项原始得分
		foreach($factor as $factor_record) {
			if($factor_record['action'] != 'sum'){
				$factor_score = 0;
			//$args = preg_replace('/[A-Z][0-9]?/', '\$rt[\'$0\']', $factor_record['children']);
			$code = preg_replace('/[A-Z][0-9]?/', '\$rt_array[\'$0\'][\'std_score\']', $factor_record['action']);
			$code =  "\$factor_score = $code;";
			eval($code);
			$rt[$factor_record['name']] = sprintf('%.2f',$factor_score);
			}
		}
		#后八项标准得分
		$factor_ignore = array(
				'X1','X2','X3','X4','Y1','Y2','Y4'
		);
		foreach ($rt as $key => $score ){
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			if (in_array($key, $factor_ignore)){
				$std_score = $score;
			}else if ($key == 'Y3'){
				$ksmd = Ksmd::find(array(
						'YZ=?1',
						'bind'=>array(1=>$key)));
				foreach ($ksmd as $ksmds ) {
					if ($score <= $ksmds->ZZF && $score >= $ksmds->QSF) {
						$std_score = $ksmds->BZF;
					}
				}
			}else{
				#no 
			}
			if($key == 'X1'){
				$ans_score = 10-$std_score;
			}else if ($key == 'Y1' || $key == 'Y4' ){
				$ans_score = $std_score/4;
			}else if ($key == 'Y2'){
				$ans_score = $std_score/7.5;
			}else{
				$ans_score = $std_score;
			}
			
			$array_record['score'] = $score;
			$array_record['std_score'] = $std_score;
			$array_record['ans_score'] = $ans_score;
			$rt_array[$key] = $array_record;
				
		}
		return $rt_array;
	}
	/**
	 * SPM
	 */
	public static function calSPM(&$array,$examinee){
		$number_array = self::getAnswers($array);
		$paper_id = Paper::getListByName('SPM')->id;
		$factor = Factor::queryCache($paper_id);
		$rt = array();
		foreach($factor as $factor_record) {
			if(strlen($factor_record['name']) == 4){
				#循环16次
				$factor_record_number_array = explode(',',$factor_record['children']);
				$factor_score = 0;
				foreach( $factor_record_number_array as $skey){
					if(isset($number_array[$skey])){
						$factor_score += $number_array[$skey];
					}
				}
				$rt[$factor_record['name']] = $factor_score;
				#先遍历完简单因子的结果	
			}else{
				$factor_score = 0;
				//$args = preg_replace('/[A-Z][0-9]?/', '\$rt[\'$0\']', $factor_record['children']);
				$action = str_replace(',', '+', $factor_record['children']);
				$code = preg_replace('/[a-z]+/', '\$rt[\'$0\']',$action);
				$code =  "\$factor_score = $code;";
				eval($code);
				$rt[$factor_record['name']] = $factor_score;
			}
		}
		$age = $examinee->age;
		$rt_array = array();
		foreach($rt as $key => $score){
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			if ($key == 'spm'){
				$spmmd = Spmmd::findFirst(array(
						'NLH >= :age: AND NLL <= :age:',
						'bind'=>array('age'=>$age)));
				foreach ($spmmd as $spmmds) {
					if ($score >= $spmmd->B95) {
						$std_score = 1;
					}
					else if ($score >= $spmmd->B75) {
						$std_score =2;
					}
					else if ($score >= $spmmd->B25) {
						$std_score = 3;
					}
					else if ($score >= $spmmd->B5) {
						$std_score = 4;
					}
					else{
						$std_score = 5;
					}
				}
				$ans_score = ($rt_array['spma']['ans_score']+$rt_array['spmb']['ans_score']+$rt_array['spmc']['ans_score']+$rt_array['spmd']['ans_score']+$rt_array['spme']['ans_score'])/5;
			}
			else if ($key == 'spmabc') {
				$std_score = $score;
				$ans_score = ($rt_array['spma']['ans_score']+ $rt_array['spmb']['ans_score']+$rt_array['spmc']['ans_score'])/3;
				
			}else{
				$std_score = $score;
				$ans_score = $std_score/2;
			}
			$array_record['score'] = $score;
			$array_record['std_score'] = $std_score;
			$array_record['ans_score'] = $ans_score;
			$rt_array[$key] = $array_record;
		}
		return $rt_array;
	}
	/**
	 * 返回一个数组[$paper_id][$question_number];
	 * @param unknown $array
	 * @return Ambigous <multitype:, unknown>
	 */
	public static function getAnswers(&$array){
		$rtn_array = array();
		$number_list = explode('|', $array->question_number_list);
		$score_list  = explode('|', $array->score);
		foreach($number_list as $key => $number ){
			$score = $score_list[$key];
			$rtn_array[$number] =$score;
		}
		return $rtn_array;
	
	}
	
	/**use for EPPS con
	 * 返回一个$array[$question_number] = choice;
	 */
	public static function getEPPSCon(&$array){
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
	
}