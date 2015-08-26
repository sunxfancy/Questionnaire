<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * @usage 首先调用beforeStart(),导入内存表,之后调用handlePapers($exmainee_id),写入个人基础成绩
	 * @time_comsuming 
	 * @notice 内存表的加载需首先完成
	 * @author Wangyaohui
	 * @date 2015-8-26
	 */
class BasicScore {
	/**
	 * @usage 添加静态变避免在一次请求中重复加载内存表
	 * @var boolean
	 */
	protected static $memory_state = false;
	/**
	 * @ usage 本地缓存被试的答卷信息
	 * @var  \Phalcon\Mvc\Model\Resultset\Simple | null
	 */
	protected static $papers_list = null;
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
	 * @usage 查examinee表判断该被试是否已经答完题
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	protected static function ifExamineeFinished($examinee_id){
		try{
			$finished_state = Examinee::checkIsExamedByExamineeId($examinee_id);
		if($finished_state){
			return true;
		}else{
			return false;
		}
		}catch(Exception $e){
			throw new Exception( $e->getMessage() );
		}
	}
	/**
	 * @usage 返回被试的全部答卷信息，并写入到类的静态变量$papers_list中
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	protected static function getPapersByExamineeId($examinee_id){
		try{
			if(!self::ifExamineeFinished($examinee_id)){
				return false;
			}else{
				self::$papers_list = QuestionAns::getListByExamineeId($examinee_id);	
				return true;
			}
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * @usage 计算得分并写入到库的关键，采取个人按记录插入操作
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function handlePapers($examinee_id){
		try {
			#写入$papers_list;
			if(empty(self::$papers_list)){
				self::getPapersByExamineeId($examinee_id);
			}
			#若$paper_list 中的有效数据为空，则会跳过以下循环---对phalcon对象数组
			foreach(self::$papers_list as $paper_ans_data ){
			 	#判断被试的答题是否已经被写入分数，若未写入，则进行处理，否则，不处理
			 	if(empty( $paper_ans_data->score )){
			 		$paper_name = $paper_ans_data->Paper->name;
			 		$score_line = null;
			 		switch(strtoupper(trim($paper_name))){
			 				case 'EPQA' : $score_line = self::handleEPQA($paper_ans_data); break;
			 				case 'EPPS' : $score_line = self::handleEPPS($paper_ans_data); break;
			 				case 'CPI' :  $score_line = self::handleCPI($paper_ans_data); break;
			 				case '16PF' : $score_line = self::handle16PF($paper_ans_data); break;
			 				case 'SCL' : $score_line = self::handleSCL($paper_ans_data); break;
			 				case 'SPM' : $score_line = self::handleSPM($paper_ans_data); break;
			 				default :  throw new Exception('wrong paper_name from table paper');
			 		}
			 		#获取到score_line 写入到数据库中
			 		if(!empty($score_line)){
			 			try{
			 			#这里的数据处理进行单条处理，失败则回滚，尽量减少数据库的重复操作
			 			$manager     = new TxManager();
			 			$transaction = $manager->get();
			 			$question_ans_record = new QuestionAns();
			 			$question_ans_record->score = $score_line;
			 			$question_ans_record->paper_id = $paper_ans_data->paper_id;
			 			$question_ans_record->examinee_id = $paper_ans_data->examinee_id;
			 			$question_ans_record->option = $paper_ans_data->option;
			 			$question_ans_record->question_number_list =$paper_ans_data->question_number_list;
			 			if($question_ans_record->update() == false){
			 				 $transaction->rollback("Cannot update table Question_ans' score");
			 				}
			 			$transaction->commit();
			 			}catch (TxFailed $e) {
    						throw new Exception("Failed, reason: ".$e->getMessage());
    					}
			 		}else{
			 			throw new Exception ("The string of score result is null");
			 		}
			 	}else{
			 		#说明已经写入过score
			 	}
			}
			return true;	
		}catch (Exception $e){
			throw new Exception($e->getMessage());
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
			self::beforeStart();
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
			self::beforeStart();
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
			self::beforeStart();
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
			self::beforeStart();
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
			self::beforeStart();
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
	 * @return multitype:multitype:string Ambigous <>
	 */
	private static function strDivideToArray($str_option, $str_number){
		$str_option_array = explode('|', $str_option);
		$str_number_array = explode('|', $str_number);
		$count = count($str_option_array);
		if( $count != count($str_number_array)){
			throw new Exception("The two strings are not appropriate in count");
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
					throw new Exception("The two strings are not appropriate in type");
				}
			}
			return $rtn;
		}		
	}
}