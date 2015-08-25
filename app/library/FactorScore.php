<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * 用于因子分数计算，
	 * @param int $examinee_id;
	 * @author Wangyaohui
	 * @Date: 2015-8-24
	 *
	 */
class FactorScore {
	public static function ifStartCalFactor($examinee_id){
		try{
			$handle_state = BasicScore::handlePapers($examinee_id);
			if($handle_state){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){
			echo "Failed: reason is ".$e->getMessage();
			return false;
		}
	}
	public static function handleFactors($examinee_id){
		if(FactorAns::checkIfFinished($examinee_id)){
			return true;
		}
		if(self::ifStartCalFactor($examinee_id)){
			$question_ans_list = QuestionAns::getListByExamineeId($examinee_id);
			$examinee = Examinee::findFirst($examinee_id);
			$age = self::calAge($examinee->birthday,$examinee->last_login);
			$examinee->age = $age;
			$rtn_array = array();
			foreach($question_ans_list as $question_ans_record){
				//缓存到本地
				$paper = Paper::queryPaperInfo($question_ans_record->paper_id);
				switch (strtoupper($paper->name)){
					case "EPQA" : $rtn_array_paper = self::calEPQA($question_ans_record->score,$examinee); break;
					case 'EPPS' : $rtn_array_paper = self::calEPPS($question_ans_record); break;
					case 'CPI'  : $rtn_array_paper = self::calCPI($question_ans_record->score,$examinee); break;
					case 'SCL'  : $rtn_array_paper = self::calSCL($question_ans_record); break;
					case '16PF' : $rtn_array_paper = self::calKS($question_ans_record,$examinee); break;
					case 'SPM'  : $rtn_array_paper = self::calSPM($question_ans_record,$examinee); break;
					default : throw new Exception ("no this type paper: $paper->name");
				}
				if(!empty($rtn_array_paper)) {
					foreach($rtn_array_paper as $key =>$value ){
						$rtn_array[$key] = $value;
					}
				}
				unset($rtn_array_paper);
				
			}
			unset($question_ans_list);
// 			echo "<pre>";
// 			print_r($rtn_array);
// 			echo "</pre>";
// 			exit();
			#插入到因子表
			try{
				$manager     = new TxManager();
				$transaction = $manager->get();
				foreach ( $rtn_array as $key => $value ) {
					$factor_ans = new FactorAns();
					$factor_id = Factor::findFirst( array("name = :factor_name:",'bind'=>array('factor_name'=>$key) ))->id;
					$factor_ans->examinee_id = $examinee_id;
					$factor_ans->factor_id = $factor_id;
					$factor_ans->score = $value['score'];
					$factor_ans->std_score = $value['std_score'];
					$factor_ans->ans_score = $value['ans_score'];

					if($factor_ans->save() == false){
							$transaction->rollback("Cannot update table FactorAns' score");
					}
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
						throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}else{
			throw new Exception('question scores are not finished');
		}
	}
	
	/**
	 * EPQA,  匹配 sum
	 * @param unknown $string
	 * @return multitype:
	 */
	public static function calEPQA($string,$examinee){
		 $tmp_array = array(); 
		 $array = explode('|', $string);
		 $tmp_array = array_count_values ($array);
		 unset($tmp_array['']);
		 $dage = $examinee->age;
		 $dm = ($examinee->sex ==0) ? 2 : 1;
		 $rt_array = array();
		 foreach($tmp_array as $key=>$score){
		 $array_record = array();
		 $m  = 0;
		 $sd = 0;
		 $ans_score = 0;
		 $epqamd = Epqamd::findFirst(array(
		 		'DAGEL <= :age: AND DAGEH >= :age: AND DSEX = :sex:',
		 		'bind'=>array('age'=>$dage,'sex'=>$dm)));
		 switch($key){
		 	case 'epqae':
		 		$m = $epqamd->EM;
		 		$sd = $epqamd->ESD;
		 		$ans_score = $score/10;
		 		break;
		 	case 'epqan':
		 		$m = $epqamd->NM;
		 		$sd = $epqamd->NSD;
		 		$ans_score = 10 - $score/10;
		 		break;
		 	case 'epqap':
		 		$m = $epqamd->PM;
		 		$sd = $epqamd->PSD;
		 		$ans_score = 10 - $score/10;
		 		break;
		 	case 'epqal':
		 		$m = $epqamd->LM;
		 		$sd = $epqamd->LSD;
		 		$ans_score = 10 - $score/10;
		 		break;
		 	default:throw new Exception("not found");
		 }
		 $std_score = sprintf("%.2f",50 + (10 * ($score - $m)) / $sd);
		 $array_record['score'] = $score;
		 $array_record['std_score'] = $std_score;
		 $array_record['ans_score'] = $ans_score;
		 $rt_array[$key] = $array_record;
		 }
		 return $rt_array;
	}
	/**
	 * EPPS 匹配sum  添加稳定系数
	 * @param unknown $array
	 */
	public static function calEPPS($array){
		$array_15 = explode('|', $array->score);
		$rt = array_count_values ($array_15);
		unset($rt['']);
		#计算稳定系数con
		$rt['con'] = self::getEPPSCon($array);
		$rt_array = array();
		foreach($rt as $key => $score){
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			if($key != 'con'){
				$std_score = $score;
				$ans_score = ($score-1)/2.8;
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
				$ans_score = $score/10;
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
			}else{
				$factor_score = 0;
				//$args = preg_replace('/[A-Z][0-9]?/', '\$rt[\'$0\']', $factor_record['children']);
				$code = preg_replace('/[A-Z][0-9]?/', '\$rt[\'$0\']', $factor_record['action']);
				$code =  "\$factor_score = $code;";
				eval($code);
				$rt[$factor_record['name']] = sprintf('%.2f',$factor_score);
			}
		}
		
		$factor_ignore = array(
				'X1','X2','X3','X4','Y1','Y2','Y4'
		);
		$dm = ($examinee->sex ==0) ? 2 : 1;
		$rt_array = array();
		foreach($rt as $key => $score){
			$array_record = array();
			$std_score = 0;
			$ans_score = 0;
			if (in_array($key, $factor_ignore)){
				$std_score = $score;
			}else if($key == 'Y3'){
				$ksmd = Ksmd::find(array(
						'YZ=?1',
						'bind'=>array(1=>$key)));
				foreach ($ksmd as $ksmds ) {
					if ($score <= $ksmds->ZZF && $score >= $ksmds->QSF) {
						$std_score = $ksmds->BZF;
					}
				}
			}else{
				$ksmd = Ksmd::find(array(
						'DM=?0 AND YZ=?1',
						'bind'=>array(0=>$dm,1=>$key)));
				foreach ($ksmd as $ksmds ) {
					if ($score <= $ksmds->ZZF && $score >= $ksmds->QSF) {
						$std_score = $ksmds->BZF;
					}
				}
			}
			if($key =='Q4' || $key == 'X1'){
				$ans_score = 10-$score;
			}else if ($key == 'Y1' || $key == 'Y4' ){
				$ans_score = $score/4;
			}else if ($key == 'Y2'){
				$ans_score = $score/7.5;
			}else{
				$ans_score = $score;
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
	
	protected static function calAge($birthdays,$todays){
		$today_temp = array();
		$birthday = $birthdays;
		$today_temp = explode(' ',$todays);
		$today = $today_temp[0];
		$startdate=strtotime("$birthday");
		$enddate=strtotime("$today");
		$days=round(($enddate-$startdate)/3600/24) ;
		$age = sprintf("%.2f",$days/365);
		return $age;
	}
	
	
	
	
	
	
	
	
}