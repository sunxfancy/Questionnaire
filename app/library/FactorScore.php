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
			$rtn_array = array();
			foreach($question_ans_list as $question_ans_record){
				//缓存到本地
				$paper = Paper::queryPaperInfo($question_ans_record->paper_id);
				switch (strtoupper($paper->name)){
					case "EPQA" : $rtn_array_paper = self::calE($question_ans_record->score); break;
					case 'EPPS' : $rtn_array_paper = self::calE($question_ans_record->score); break;
					case 'CPI'  : $rtn_array_paper = self::calC($question_ans_record->score); break;
					case 'SCL'  : $rtn_array_paper = self::calS($question_ans_record); break;
					case '16PF' : $rtn_array_paper = self::calK($question_ans_record); break;
					case 'SPM'  : $rtn_array_paper = self::calM($question_ans_record); break;
					default : echo "OL";
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
		}else{
			throw new Exception('question scores are not finished');
		}
	}
	
	/**
	 * EPQA, EPPS,  匹配 sum
	 * @param unknown $string
	 * @return multitype:
	 */
	public static function calE($string){
		 $array = explode('|', $string);
		 $rt = array_count_values ($array);
		 unset($rt['']);
		 return $rt;
	}
	/**
	 * CPI 匹配 sum
	 * @param unknown $string
	 */
	public static function calC($string){
		$string = str_replace('-', '|', $string);
		$array = explode('|', $string);
		$rt = array_count_values ($array);
		unset($rt['']);
		return $rt;
	}
	
	/**
	 * SCL : svg
	 * @param unknown $array
	 */
	public static function calS(&$array){
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
	return $rt;		
	}
	/**
	 * 16PF
	 */
	public static function calK(&$array){
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
		
		return $rt;
	}
	
	/**
	 * SPM
	 */
	public static function calM(&$array){
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
		
		return $rt;
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
	
	
	
	
	
	
	
	
}