<?php
	/**
	 * @usage 被试答案提交
	 * @state 0~1
	 * @author Wangyaohui
	 * @notice  1.Examinee中存在examinee_id
	 * 		    2.paper_name合理性与答案的范围及题号的数量的合理性
	 *          3.对照project_detail判断题号与答案
	 * @date 2015-8-31
	 */

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class QuestionIC {
	
	private static $error_state = 0;
	
	private static $array_values = array(
		'SCL' =>array( 'a', 'b', 'c', 'd', 'e' ),
		'CPI' =>array( 'a', 'b' ),
		'16PF'=>array('a','b','c'),
		'EPQA'=>array('a','b'),
		'EPPS'=>array('a','b')			
	);
	
	#1
	/**
	 * @usage 被试状态判断,需要计算则返回project_id，计算完成的不再计算返回false
	 * @param int $examinee_id
	 * @throws Exception
	 */
	protected static function getProjectId($examinee_id){
		$examinee_info = Examinee::findFirst(
		array("id = :id:",
		'bind'=>array('id'=>$examinee_id)
		)
		);
		#如果examinee_id为空，这种处理也合适
		if(isset($examinee_info->project_id)){
			if($examinee_info->state == 0){
				return $examinee_info->project_id;
			}else {
				return false;
			}
		}else{
			throw new Exception(self::$error_state.'-不存在该账号-'.$examinee_id);
		}
	}
	#选项：前24项abc edf 后36项abcd efgh | 题目数量  60
	protected static function checkSPM($option_str, &$number_array, $project_id){
		$value_array_24 = array('a','b','c','d','e','f');
		$value_array_36 = array('a','b','c','d','e','f','g','h');
		$project_detail_json = MemoryCache::getProjectDetail($project_id);
		$project_detail = json_decode($project_detail_json->exam_json, true);
		$question_count = count($project_detail['SPM']);
		if( $question_count == count( $number_array ) && !array_diff(  $project_detail['SPM'] , $number_array ) ) {
			$option_array = explode('|', $option_str);
			if(count($option_array) == $question_count){
				foreach($option_array as $key =>$value ){
					if($number_array[$key] <= 24 ){
						if(!in_array($value, $value_array_24)){
							throw new Exception(self::$error_state.'-答案不在选项范围内-'.$value.'-'.$number_array[$key]);
						}
					}else{
					if(!in_array($value, $value_array_36)){
							throw new Exception(self::$error_state.'-答案不在选项范围内-'.$value.'-'.$number_array[$key]);
						}
					}
				}	
			}else{
				throw new Exception(self::$error_state.'-答案数量与题目数量不符-'.$question_count.'-'.substr_count($option_str, '|'));
			}
		}else{
			throw new Exception(self::$error_state.'-题目数量与题库不符-'.print_r(array_diff( $project_detail['SPM'] , $number_array ),true));
		}
	}
	#选项：abcde | 题目数量 90
	protected static function checkSCL($option_str, &$number_array, $project_id){
		$paper_name = 'SCL';
		self::check($option_str, $number_array, $project_id, $paper_name, self::$array_values[$paper_name]);
	}
	#选项：ab | 题目数量 225
	protected static function checkEPPS($option_str, &$number_array, $project_id){
		$paper_name = 'EPPS';
		self::check($option_str, $number_array, $project_id, $paper_name, self::$array_values[$paper_name]);
	}
	#选项：ab | 题目数量 88
	protected static function checkEPQA($option_str, &$number_array, $project_id){
		$paper_name = 'EPQA';
		self::check($option_str, $number_array, $project_id, $paper_name, self::$array_values[$paper_name]);
	}
	#选项：abc | 题目数量  187
	protected static function checkKS($option_str, &$number_array, $project_id){
		$paper_name = '16PF';
		self::check($option_str, $number_array, $project_id, $paper_name, self::$array_values[$paper_name]);
	}
	#选项：ab | 题目数量 230
	protected static function checkCPI($option_str, &$number_array, $project_id){
		$paper_name = 'CPI';
		self::check($option_str, $number_array, $project_id, $paper_name, self::$array_values[$paper_name]);
	}
	private static function check($option_str, &$number_array, $project_id, $paper_name, $paper_value_array){
		$array_value_ks = $paper_value_array;
		$project_detail_json = MemoryCache::getProjectDetail($project_id);
		$project_detail = json_decode($project_detail_json->exam_json, true);
		$question_count = count($project_detail[$paper_name]);
		if( $question_count == count( $number_array ) && !array_diff(  $project_detail[$paper_name] , $number_array ) ) {
			$option_array = explode('|', $option_str);
			if(count($option_array) == $question_count){
				$option_array = array_flip(array_count_values($option_array));
				if(!array_diff($option_array, $array_value_ks)){
					return true;
				}else{
					throw new Exception(self::$error_state.'-答案不在选项范围内-'.print_r(array_diff($option_array, $array_value_ks),true));
				}
		
			}else{
				throw new Exception(self::$error_state.'-答案数量与题目数量不符-'.$question_count.'-'.substr_count($option_str, '|'));
			}
		}else{
			throw new Exception(self::$error_state.'-题目数量与题库不符-'.print_r(array_diff( $project_detail[$paper_name] , $number_array ),true));
		}
	}
	/**
	 * @usage 写入被试的答卷信息
	 * @param int $examinee_id
	 * @param string $paper_name
	 * @param string $option_str
	 * @param array $number_array
	 * @throws Exception
	 * @return boolean
	 */
	public static function insertQuestionAns($examinee_id, $paper_name, $option_str, $number_array,$time){
		$project_id = self::getProjectId($examinee_id);
		if(!$project_id){
			return false;
		}
		$paper_name = strtoupper($paper_name);
		switch($paper_name){
			case 'EPQA': self::checkEPQA($option_str, $number_array,$project_id); break;
			case 'EPPS': self::checkEPPS($option_str, $number_array,$project_id); break;
			case 'CPI' : self::checkCPI($option_str, $number_array, $project_id); break;
			case '16PF': self::checkKS($option_str, $number_array,  $project_id) ; break;
			case 'SCL' : self::checkSCL($option_str, $number_array, $project_id); break;
			case 'SPM' : self::checkSPM($option_str, $number_array, $project_id); break;
			default : throw new Exception(self::$error_state.'-不存在试卷-'.$paper_name);
 		}
 		$paper_id = MemoryCache::getPaperDetail($paper_name)->id;
		try{
			// Create a transaction manager
			$manager     = new TxManager();
			// Request a transaction
			$transaction = $manager->get();
			
			$question_ans = new QuestionAns();
			#将事务设置到每一次的new之后
			$question_ans->setTransaction($transaction);
			$question_ans->option = $option_str;
			$question_ans->paper_id = $paper_id;
			$question_ans->examinee_id = $examinee_id;
			$question_ans->question_number_list =implode("|",$number_array);
			$question_ans->time = $time;
			if( $question_ans->save() == false ){
				$transaction->rollback(self::$error_state.'-数据库插入失败-'.print_r($question_ans,true));
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
   			throw new Exception($e->getMessage());
		}
	}
	
	/**
	 * @usage 完成答卷后的被试状态转换
	 * @param int $examinee_id
	 * @param int $exam_time
	 * @throws Exception
	 * @return boolean
	 */
	public static function finishedExam($examinee_id, $exam_time){
		if(!is_int($exam_time) ||  $exam_time <= 0){
			throw new Exception(self::$error_state.'-答题时间的数据错误-'.var_dump($exam_time));
		}
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
				$examinee_info->state = 1;
				$examinee_info->exam_time = $exam_time;
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