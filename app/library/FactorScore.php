<?php
	/**
	 * 用于因子分数计算，
	 * @param int $examinee_id;
	 * @author Wangyaohui
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
		if(self::ifStartCalFactor($examinee_id)){
			$question_ans_list = QuestionAns::getListByExamineeId($examinee_id);
			$ans_array  = self::getAnswers($question_ans_list);
// 			print_r($ans_array);
// 			echo "<hr />";
			unset($question_ans_list);
			$rtn_array = array();
			foreach($ans_array[$examinee_id] as $key => $ans_record){
				$paper_name =  Paper::getListById($key)->name;
				$rtn_array_paper = null;
				switch($paper_name){
					case 'EPQA': $rtn_array_paper = self::calEPQA($ans_record);break;
					case 'EPPS': $rtn_array_paper = self::calEPQA($ans_record);break;
					case 'CPI' : $rtn_array_paper = self::calEPQA($ans_record);break;
					case 'SCL' : $rtn_array_paper = self::calSCL($ans_record); break;
				}
				if(!empty($rtn_array_paper)) {
					foreach($rtn_array_paper as $key =>$value ){
						$rtn_array[$key] = $value;
					}
				}
				unset($rtn_array_paper);
			}
			echo "<pre>";
			print_r($rtn_array);
			echo "</pre>";
			exit();
			exit();
			$factor_list = Factor::queryCache();
			echo "<pre>";
			print_r($ans_array);
			echo "</pre>";
			exit();
		}else{
			throw new Exception('question scores are not finished');
		}
	}
	
	/**
	 * 返回一个数组 [$examinee_id][$paper_id][$question_number];
	 * @param unknown $array
	 * @return Ambigous <multitype:, unknown>
	 */
	public static function getAnswers(&$array){
		$rtn_array = array();
		foreach($array as $record){
			$number_list = explode('|', $record->question_number_list);
			$score_list  = explode('|', $record->score);
			foreach($number_list as $key => $number ){
				$score = $score_list[$key];
				$rtn_array[$record->examinee_id][$record->paper_id][$number] =$score;
			}
		}
		return $rtn_array;
		
	}
	
	/**
	 * EPQA, EPPS, CPI 匹配
	 * @param unknown $array
	 * @return multitype:
	 */
	public static function calEPQA(&$array){
		 $rt = array_count_values ($array);
		 unset($rt['']);
		 return $rt;
	}
	
	public static function calSCL(&$array){
		$paper_id = Paper::getListByName('SCL')->id;
		$factor = Factor::queryCache($paper_id);
		foreach($factor as $factor_record){
			echo $factor_record->name;echo "<br />";
			echo $factor_record->children;echo "<br />";
			echo $factor_record->children_type;echo "<br />";
			echo $factor_record->action;echo "<br />";
		}
		echo $paper_id;
		print_r($array);
		
	}
	
	
	
	
	
	
	
	
}