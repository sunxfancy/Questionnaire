<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * @usage 写入个人基础成绩
	 * @state 1~2 
	 * @author Wangyaohui
	 * @notice  1.内存表的加载需首先完成
	 * 			2.Examinee表中存有examinee_id, 及相应的project_id , state, QuestionAns表中有相应记录
	 * 			3.对比project_detail
	 * @date 2015-9-1
	 */
class BasicScore {
	
	private static $error_state = 1;
	/**
	 * @usage 添加静态变避免在一次请求中重复加载内存表
	 * @var boolean
	 */
	private static $memory_state = false;
	/**
	 * @usage 加载内存表
	 * @throws Exception
	 * @return boolean
	 */
	protected static function loadMemoryTable(){
		self::$memory_state =  MemoryTable::loader();	
		return self::$memory_state;
	}
	/**
	 * @usage 被试状态判断,需要计算则返回project_id，计算完成则返回false，其他抛出异常
	 * @param int $examinee_id
	 * @throws Exception
	 */
	protected static function getExamineeInfo($examinee_id){
		$examinee_info = Examinee::findFirst(
				array("id = :id:",
						'bind'=>array('id'=>$examinee_id)
				)
		);
		#如果examinee_id为空，这种处理也合适
		if(isset($examinee_info->state)){
			if($examinee_info->state == 1){
				return $examinee_info->project_id;
			}else if($examinee_info->state == 0 ){
				throw new Exception(self::$error_state.'-下层计算还未完成-'.$examinee_info->state);
			}else{
				return false;
			}
		}else{
			throw new Exception(self::$error_state.'-不存在该账号的用户-'.$examinee_id);
		}
	}
	/**
	 * @usage 获取被试的试卷信息，判断试卷是否全部完成，成功则返回试卷信息
	 * @param int $project_id
	 * @param int $examinee_id
	 * @throws Exception
	 * @return unknown
	 */
	protected static function getPapers($project_id, $examinee_id){
		$project_detail_json = MemoryCache::getProjectDetail($project_id);
		$project_detail = json_decode($project_detail_json->exam_json, true);
		$papers_tmp = QuestionAns::find(
				array(
						"examinee_id = :examinee_id:",
						'bind' => array('examinee_id'=>$examinee_id)
				)
		);
		if( count($papers_tmp) != count($project_detail) ){
			throw new Exception(self::$error_state.'-答卷数量不正确-'.count($papers_tmp).'-'.count($project_detail));
		}
		$papers_id_tmp = array();
		foreach($papers_tmp as $value){
			$papers_id_tmp[] = $value->paper_id;
		}
		$project_papers_id = array();
		foreach($project_detail as $key=>$value){
			$project_papers_id[] = MemoryCache::getPaperDetail($key)->id;
		}
		if(!array_diff(  $papers_id_tmp , $project_papers_id) ) {
			return $papers_tmp;
		}else{
			throw new Exception(self::$error_state.'-答卷信息与题库信息不符-'.print_r($papers_id_tmp,true).print_r($project_papers_id,true));
		}
	}
	
	/**
	 * @usage 计算得分并写入到库的关键，计算一次插入数据一次 true 表示写入完成，false表示已经写入过，此次只是扫库
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function handlePapers($examinee_id){
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		#表示已经完成了这一层计算，不必再算
		$project_id = self::getExamineeInfo($examinee_id);
		if(!$project_id){
			return false;
		}
		$papers_list = self::getPapers($project_id, $examinee_id);
		$papers_count = count($papers_list);
		$ignore_count = 0;
		foreach($papers_list as $paper_ans_data ){
		 	#判断被试的答题是否已经被写入分数，若未写入，则进行处理，否则，不处理
		 	if(empty( $paper_ans_data->score )){
		 		$paper_name = $paper_ans_data->Paper->name;
		 		$score_line = null;
		 		switch(strtoupper($paper_name)){
 				case 'EPQA' : $score_line = self::handleEPQA($paper_ans_data); break;
 				case 'EPPS' : $score_line = self::handleEPPS($paper_ans_data); break;
 				case 'CPI' :  $score_line = self::handleCPI($paper_ans_data); break;
 				case '16PF' : $score_line = self::handle16PF($paper_ans_data); break;
 				case 'SCL' : $score_line = self::handleSCL($paper_ans_data); break;
 				case 'SPM' : $score_line = self::handleSPM($paper_ans_data); break;
 				default :  throw new Exception(self::$error_state.'-不存在试卷-'.$paper_name);
	 		}
	 		#获取到score_line 写入到数据库中
	 		if(!empty($score_line)){
	 			try{
	 			#这里的数据处理进行单条处理，失败则回滚，尽量减少数据库的重复操作
	 			$manager     = new TxManager();
	 			$transaction = $manager->get();
	 			$paper_ans_data->setTransaction($transaction);
	 			$paper_ans_data->score = $score_line;
	 			if($paper_ans_data->save() == false){
	 				 $transaction->rollback(self::$error_state."插入数据库失败".print_r($paper_ans_data,true));
	 			}
			 	$transaction->commit();
			 	}catch (TxFailed $e) {
    				 throw new Exception($e->getMessage());
    			}
		 	 }else{
		 			throw new Exception (self::$error_state."-成绩字符串为空");
		 	 }
		 	}else{
		 		#说明已经写入过score
		 		$ignore_count ++;
		 	}
		}
		if($papers_count != $ignore_count){
			return true;
		}else{
			return false;
		}
		
	}
	/**
	 * 计算SPM基础得分
	 * @param \Phalcon\Mvc\Model\Resultsets\Simple $array
	 * @return string
	 */
	protected static function handleSPM(&$array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		#判断内存表状态
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		$rtn_array = array();
		foreach($array_list as $array_record){
			$rtn_array[] = SpmdfMemory::getRecord(intval($array_record['number']),  intval(ord($array_record['option'])-ord('a')+1));
		}
		return implode('|', $rtn_array);
	}
	/**
	 * 计算KS基础得分
	 * @param \Phalcon\Mvc\Model\Resultsets\Simple $array
	 * @return string
	 */
	protected static function handle16PF(&$array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		#判断内存表状态
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		$rtn_array = array();
		foreach($array_list as $array_record){
			$rtn_array[] = KsdfMemory::getRecord(intval($array_record['number']),  strtoupper($array_record['option']));
		}
		return implode('|', $rtn_array);
	}
	/**
	 * 计算SCL基础得分
	 * @param \Phalcon\Mvc\Model\Resultsets\Simple $array
	 * @return string
	 */
	protected static function handleSCL(&$array){
		/**
		 * scl 得分 A -1 B-2 C-3 D-4 E-5 与题号无关，与因子无关
		 * 因此直接进行正则匹配替换
		 */
		$pattern = array('/a/','/b/','/c/','/d/','/e/');
		$replece = array(1,2,3,4,5);
		return preg_replace($pattern, $replece, strtolower($array->option));	
	}
	/**
	 * 计算EPQA基础得分
	 * @param \Phalcon\Mvc\Model\Resultsets\Simple $array
	 * @return string
	 */
	protected static function handleEPQA(&$array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		#判断内存表状态
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		$rtn_array = array();
		foreach($array_list as $array_record){
			$rtn_array[] = EpqadfMemory::getRecord(intval($array_record['number']), intval(ord($array_record['option'])-ord('a')+1));	
		}
		return implode('|', $rtn_array);
	}
	/**
	 * 计算CPI基础得分
	 * @param \Phalcon\Mvc\Model\Resultsets\Simple $array
	 * @return string
	 */
	protected static function handleCPI(&$array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		#判断内存表状态
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		$rtn_array = array();
		foreach($array_list as $array_record){
			$rtn_array[] = CpidfMemory::getRecord(intval($array_record['number']), ord($array_record['option'])-ord('a')+1);
		}
		return implode('|', $rtn_array);
	}
	/**
	 * 计算EPPS基础得分
	 * @param \Phalcon\Mvc\Model\Resultsets\Simple $array
	 * @return string
	 */
	protected static function handleEPPS(&$array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		#判断内存表状态
		if(!self::$memory_state){
			self::loadMemoryTable();
		}
		$rtn_array = array();
		foreach($array_list as $array_record){
			$rtn_array[] = EppsdfMemory::getRecord(intval($array_record['number']),  strtoupper(trim($array_record['option'])));
		}
		return implode('|', $rtn_array);
	}
	/**
	 * @usage 用于解析题号与选项的字符串，返回题号与选项对应的数组
	 * @param string $str_option
	 * @param string $str_number
	 * @throws Exception
	 */
	private static function strDivideToArray($str_option, $str_number){
		$str_option_array = explode('|', $str_option);
		$str_number_array = explode('|', $str_number);
		$count = count($str_option_array);
		if( $count != count($str_number_array)){
			throw new Exception("The two strings are not appropriate in count-".$count.'-'.$count($str_number_array).'-'.$str_option.'-'.$str_number);
		}else{
			$rtn = array();
			for($i = 0; $i<$count; $i++){
				$tmp = array();
				#因为题目为单选 题号与单选项
				if(preg_match('/^\d+$/', $str_number_array[$i]) && preg_match('/^\w+$/',$str_option_array[$i])){
					$tmp['number'] = $str_number_array[$i];
					//全部确定为小写字母
					$tmp['option'] = strtolower(trim($str_option_array[$i]));
					$rtn[] = $tmp;
				}else{
					if(isset($rtn)){ unset($rtn);}
					throw new Exception("The two strings are not appropriate in type".$str_number_array[$i].$str_option_array[$i]);
				}
			}
			return $rtn;
		}		
	}
	/**
	 * @usage 完成基础得分计算后的被试状态转换
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function finishedBasic($examinee_id){
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
				$examinee_info->state = 2;
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