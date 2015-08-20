<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * 调用BasicScore 写入被试的score
	 * @author Wangyaohui
	 * finished 2015-8-20
	 *
	 */
class BasicScore {
	private static $mysql_memory_list = array(
			'cpidf' , 'eppsdf', 'epqadf', 'ksdf','spmdf'
	);
	public static function start(){
		try{
			foreach(self::$mysql_memory_list as $record){
				MemoryManagement::startMysqlMemoryTable($record);
			}
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		return true;
	}
	/**
	 * @param int $examinee_id
	 * @return boolean
	 * table: examinee
	 */
	public static function ifExamineeFinished($examinee_id){
		try{
		$finished_state = Examinee::checkIsExamedByExamineeId($examinee_id);
		if($finished_state){
			return true;
		}else{
			return false;
		}
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	/**
	 * 返回一个人的所回答的全部试卷的答案数组
	 * @param integer $examinee_id
	 * @throws Exception
	 * @return array , false
	 * table question_ans
	 */
	public static function getPapersByExamineeId($examinee_id){
		if(!self::ifExamineeFinished($examinee_id)){
			return false;
		}else{
		try{
		$papers_list = QuestionAns::getListByExamineeId($examinee_id);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		if(count($papers_list) != 0){
			return $papers_list;
		}else{
			throw new Exception("The papers' question_ans for $examinee_id is null");
		}
		}
	}
	/**
	 * 计算得分并写入的关键
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function handlePapers($examinee_id){
		$papers_ans_data = null;
		try{
			$papers_ans_data = self::getPapersByExamineeId($examinee_id);
		}catch(Exception $e){
				echo $e->getMessage();
				return false;
		}
		if(!$papers_ans_data){
				echo '<br />Failed';
				return false;
		}else{
			#获取到被试的所有答题记录
			 foreach($papers_ans_data as $paper_ans_data ){
			 	#判断被试的答题是否已经被写入分数，若未写入，则进行处理，否则，不处理
			 	if( empty( $paper_ans_data->score ) ){
			 		#根据外键关系找到对应的paper name
			 		$paper_info = $paper_ans_data->getPaper(array(
					"id = :paper_id:",
			 		'bind' => array('paper_id'=>$paper_ans_data->paper_id)
			 		));
			 		isset($paper_info->name)?$paper_name=$paper_info->name : $paper_name = null;
			 		unset($paper_info);
			 		if(!empty($paper_name)){
			 			$score_line = null;
			 			try{
			 			switch(strtoupper($paper_name)){
			 				case 'EPQA' : $score_line = self::handleEPQA($paper_ans_data); break;
			 				case 'EPPS' : $score_line = self::handleEPPS($paper_ans_data); break;
			 				case 'CPI' :  $score_line = self::handleCPI($paper_ans_data); break;
			 				case '16PF' : $score_line = self::handle16PF($paper_ans_data); break;
			 				case 'SCL' : $score_line = self::handleSCL($paper_ans_data); break;
			 				case 'SPM' : $score_line = self::handleSPM($paper_ans_data); break;
			 				default :  throw new Exception('wrong paper_name from table paper');
			 			}
			 			}catch(Exception $e){
			 				throw new Exception($e->getMessage());
			 			}
			 			#获取到score_line 写入到数据库中
			 			if(!empty($score_line)){
			 			try{
			 				#这里的数据处理进行单条处理，失败则回滚，尽量减少数据库的重复操作
			 				#如果对整体进行的话，可能会重复的计算数据
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
			 			 throw new Exception('no this type paper, the question_ans\'s paper_id is wrong!');
			 		}	
			 	}else{
			 		#说明已经写入过不再写入
			 	}
			}
			return true;	
		}
	}

	#处理SPM得分
	public static function handleSPM($array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		$memory_state = false;
		try{
			$memory_state = MemoryManagement::startMysqlMemoryTable('SPMDF');
		}catch(Exception $e){
			echo $e->getMessage();
			$memory_state = false;
		}
		//判断已经加载到内存表中
		if($memory_state){
			$rtn_array = array();
			foreach($array_list as $array_record){
				$rtn_array[] = SpmdfMemory::getRecord(intval($array_record[0]), intval(ord($array_record[1])-ord('a')+1));	
			}
			return implode('|', $rtn_array);
		}else{
		#内存加载失败
		$spmdf_list_object = Spmdf::find();
		$spmdf_list = array();
		foreach($spmdf_list_object as $spmdf_record){
			$record = array();
			$record['XH'] = $spmdf_record->XH;
			$record['BZ'] = $spmdf_record->BZ;
			$spmdf_list[] = $record;
			$record = null;
		}
		$record_list = array();
		foreach ($array_list as $record){
			$tmp_record = array();
			$tmp_record['XH'] = $record[0];
			$tmp_record['BZ'] = ord($record[1])-ord('a')+1;
			$rt_state = self::multidimensinal_search($spmdf_list, $tmp_record);
			if ( $rt_state ){
				$record_list[] = 1;
			}else{
				$record_list[] = 0;
			}
		}
		return implode('|', $record_list);
	}}
	#处理16PF得分(KS)
	public static function handle16PF($array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		$memory_state = false;
		try{
			$memory_state = MemoryManagement::startMysqlMemoryTable('KSDF');
		}catch(Exception $e){
			echo $e->getMessage();
			$memory_state = false;
		}
		//判断已经加载到内存表中
		if($memory_state){
			$rtn_array = array();
			foreach($array_list as $array_record){
				$rtn_array[] = KsdfMemory::getRecord(intval($array_record[0]), strtoupper(trim(($array_record[1]))));	
			}
			return implode('|', $rtn_array);
		}else{
		#内存表加载失败
			$ksdf_list_object = Ksdf::find();
			$ksdf_list = array();
			foreach($ksdf_list_object as $ksdf_record){
				$record = array();
				$record['TH'] = $ksdf_record->TH;
				$record['A'] = $ksdf_record->A;
				$record['B'] = $ksdf_record->B;
				$record['C'] = $ksdf_record->C;
				$ksdf_list[] = $record;
				$record = null;
			}
			$record_list = array();
			foreach ($array_list as $record){
				$rtn_array = self::findInTwodemensianalArray($ksdf_list, 'TH', $record[0]);
				$rtn_score = $rtn_array[strtoupper($record[1])];
				$record_list[] = $rtn_score;
			
			}
			return implode('|', $record_list);
		}
	}
	#处理SCL得分
	public static function handleSCL($array){
		/**
		 * scl 得分 A -1 B-2 C-3 D-4 E-5 与题号无关，与因子无关
		 * 因此直接进行正则匹配替换
		 */
		$pattern = array('/a/','/b/','/c/','/d/','/e/');
		$replece = array(1,2,3,4,5);
		return preg_replace($pattern, $replece, strtolower($array->option));	
	}
	/**
	 * 计算得分时使用内存表，如果加载不了使用源数据表
	 * @param unknown $array
	 * @return string
	 */
	public static function handleEPQA($array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		$memory_state = false;
		try{
			$memory_state = MemoryManagement::startMysqlMemoryTable('EPQADF');
		}catch(Exception $e){
			echo $e->getMessage();
			$memory_state = false;
		}
		//判断已经加载到内存表中
		if($memory_state){
			$rtn_array = array();
			foreach($array_list as $array_record){
				$rtn_array[] = EpqadfMemory::getRecord(intval($array_record[0]), intval(ord($array_record[1])-ord('a')+1));	
			}
			return implode('|', $rtn_array);
		}else{
		#内存表加载失败
			$epqa_list_object = Epqadf::find();
			$epqa_list = array();
			foreach($epqa_list_object as $epqa_record){
				$record = array();
				$record['TH'] = $epqa_record->TH;
				$record['XZ'] = $epqa_record->XZ;
				$record['E'] = $epqa_record->E;
				$record['N'] = $epqa_record->N;
				$record['P'] = $epqa_record->P;
				$record['L'] = $epqa_record->L;
				$epqa_list[] = $record;
			}
			$record_list = array();
			foreach( $array_list as $record ){
				$tmp_record = array();
				$tmp_record['TH'] = intval($record[0]);
				$tmp_record['XZ'] = intval(ord($record[1])-ord('a')+1);
				$rt_array = self::multidimensinal_search_v2($epqa_list, $tmp_record);
				$rt_str = Self::readScoreFromArray($rt_array);
				$record_list[] = $rt_str;
			}
			$record_list = self::reEPQAList($record_list);
			return implode('|', $record_list);
		}
		
	}
	#处理CPI得分
	public static function handleCPI($array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		$memory_state = false;
		try{
			$memory_state = MemoryManagement::startMysqlMemoryTable('CPIDF');
		}catch(Exception $e){
			echo $e->getMessage();
			$memory_state = false;
		}
		//判断已经加载到内存表中
		if($memory_state){
			$rtn_array = array();
			foreach($array_list as $array_record){
				$rtn_array[] = CpidfMemory::getRecord(intval($array_record[0]), intval(ord($array_record[1])-ord('a')+1));
			}
			return implode('|', $rtn_array);
		}else{
		#内存加载失败
		$cpi_list_object = Cpidf::find();
		$cpi_list = array();
		foreach($cpi_list_object as $cpi_record){
			$record = array();
			$record['TH'] = $cpi_record->TH;
			$record['XZ'] = $cpi_record->XZ;
			$record['DO'] = $cpi_record->DO;
			$record['CS'] = $cpi_record->CS;
			$record['SY'] = $cpi_record->SY;
			$record['SP'] = $cpi_record->SP;
			$record['SA'] = $cpi_record->SA;
			$record['WB'] = $cpi_record->WB;
			$record['RE'] = $cpi_record->RE;
			$record['SO'] = $cpi_record->SO;
			$record['SC'] = $cpi_record->SC;
			$record['PO'] = $cpi_record->PO;
			$record['GI'] = $cpi_record->GI;
			$record['CM'] = $cpi_record->CM;
			$record['AC'] = $cpi_record->AC;
			$record['AI'] = $cpi_record->AI;
			$record['IE'] = $cpi_record->IE;
			$record['PY'] = $cpi_record->PY;
			$record['FX'] = $cpi_record->FX;
			$record['FE'] = $cpi_record->FE;
			$cpi_list[] = $record;
		}
		$record_list = array();
		foreach( $array_list as $record ){
			$tmp_record = array();
			$tmp_record['TH'] = $record[0];
			$tmp_record['XZ'] = ord($record[1])-ord('a')+1;
			$rt_array = self::multidimensinal_search_v2($cpi_list, $tmp_record);			
			$rt_str = self::readScoreFromArray($rt_array);
			#添加标准转换
			$record_list[] = strtolower($rt_str);
		}

		return implode('|', $record_list);
		}
	}
	#处理EPPS得分
	public static function handleEPPS($array){
		$array_list = self::strDivideToArray($array->option, $array->question_number_list);
		$memory_state = false;
		try{
			$memory_state = MemoryManagement::startMysqlMemoryTable('EPPSDF');
		}catch(Exception $e){
			echo $e->getMessage();
			$memory_state = false;
		}
		//判断已经加载到内存表中
		if($memory_state){
			$rtn_array = array();
			foreach($array_list as $array_record){
				$rtn_array[] = EppsdfMemory::getRecord(intval($array_record[0]), strtoupper(trim(($array_record[1]))));	
			}
			return implode('|', $rtn_array);
		}else{
			#内存表加载失败
			$epps_list_object = Eppsdf::find();
			$epps_list = array();
			foreach($epps_list_object as $epps_record){
				$record = array();
				$record['TH'] = $epps_record->TH;
				$record['A'] = $epps_record->A;
				$record['B'] = $epps_record->B;
				$epps_list[] = $record;
			}
			$record_list =array();
			foreach ($array_list as $record){
				$rtn_array = self::findInTwodemensianalArray($epps_list, 'TH', $record[0]);
				$choice_ab = ord($record[1])-ord('a')+1;
				$record_list[] = self::readScoreFromArray_v2($rtn_array, $choice_ab);	
			}
			$record_list = self::reEPPSList($record_list);
			return implode('|', $record_list);
			}
	}
	/**
	 * 解析题号(|)字符串与选项(|)字符串，return array(题号=>选项)
	 * 题号 数值型     8|34|36|37|38|40|41|42|43|45|46|48|49
	 * 选项 字符型 i.e . a|a|a|a|a|a|a|a|
	 * return array( number , option)
	 */
	public static function strDivideToArray($str1_option, $str2_number){
		$str1_array = explode('|', $str1_option);
		$str2_array = explode('|', $str2_number);
		$count = count($str1_array);
		if( $count != count($str2_array)){
			throw new Exception("The two strings are not appropriate in count");
		}else{
			$rtn = array();
			for($i = 0; $i<$count; $i++){
				$tmp = array();
				if(preg_match('/^\d+$/', $str2_array[$i]) && preg_match('/^\w+$/',$str1_array[$i])){
					$tmp[] = $str2_array[$i];
					//全部确定为小写字母
					$tmp[] = strtolower(trim($str1_array[$i]));
					$rtn[] = $tmp;
				}else{
					if(isset($rtn)){ unset($rtn);}
					throw new Exception("The two strings are not appropriate in type");
				}
			}
			return $rtn;
		}		
	}
	
# 用于内存表加载失败之后的处理

	/**
	 * EPQA使用联合主键 TH-XZ
	 * 通过这两个来查找相应的数组项返回 use for EPQA, CPI
	 */
	public static function multidimensinal_search_v2($parents, $needle) {
		foreach ( $parents as $key => $value ){
			$flag = 1;
			foreach( $needle as $skey => $svalue ){
				if($value[$skey] != $svalue){
					if($flag == 1) {
						break;
					}
				}else{
					if($flag == 1){
						$flag = 2;
					}else{
						return $value;
					}
				}
			}
		}
	}
	

	/**
	 * use for EPQA, CPI 返回值数组的读取,并转为字符串
	 * 字符串格式为 name-score
	 */
	public static function readScoreFromArray($array){
		if (!is_array($array)) {
			throw new Exception('$array is not an array');
		}
		$rtn_array = array();
		foreach ($array as $key => $value){
			if($key =='TH' || $key == 'XZ'){
				continue;
			}
			if( !empty($value)&&$value !=0 ){
				$rtn_array[] = $key;
			}
		}
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}
	
	/**
	 * 在二维数组中按照第二层的键值来查找对应的数组项后返回 use for 16PF, SCL, EPPS
	 */
	public static function findInTwodemensianalArray($parents, $key, $value){
		foreach ($parents as  $skey => $svalue ){
			if ( $svalue[$key] == $value ){
				return $svalue;
			}
		}
		throw new Exception("can not find the answer In Two demensianal\n key:$key value:$value");
	}
	
	/**
	 * use for epps
	 * 根据 A B 选项为不同的因子算分
	 *
	 */
	public static function readScoreFromArray_v2($array,$choice){
		if($choice == 1){
			return $array['A'];
		}else if ($choice == 2 )
		{
			return $array['B'];
		}
	}
	
	public static function reEPPSList($epps_result_array){
		$rt_array = array();
		foreach($epps_result_array as $value){
			switch($value){
				case 1: $rt_array[] = 'ach'; break;
				case 2: $rt_array[] = 'def'; break;
				case 3: $rt_array[] = 'ord'; break;
				case 4: $rt_array[] = 'exh'; break;
				case 5: $rt_array[] = 'aut'; break;
				case 6: $rt_array[] = 'aff'; break;
				case 7: $rt_array[] = 'int'; break;
				case 8: $rt_array[] = 'suc'; break;
				case 9: $rt_array[] = 'dom'; break;
				case 10: $rt_array[] = 'aba'; break;
				case 11: $rt_array[] = 'nur'; break;
				case 12: $rt_array[] = 'chg'; break;
				case 13: $rt_array[] = 'end'; break;
				case 14: $rt_array[] = 'het'; break;
				case 15: $rt_array[] = 'agg'; break;
			}
		}
		return $rt_array;
	}
	
	/**
	 * 比较一个一位数组是否在一个二维数组中 use for SPM
	 * parents
	 *
	 */
	public static function multidimensinal_search($parents, $needle) {
		foreach ( $parents as $key => $value ){
			$flag = 1;
			foreach( $needle as $skey => $svalue ){
				if($value[$skey] != $svalue){
					if($flag == 1) {
						break;
					}else{
						return false;
					}
				}else{
					if($flag == 1){
						$flag = 2;
					}else{
						return true;
					}
				}
			}
		}
	}
	
	public static function reEPQAList($epqa_result_array){
		$rt_array = array();
		foreach($epqa_result_array as $value){
			switch($value){
				case 'E': $rt_array[] = 'epqae';break;
				case 'P': $rt_array[] = 'epqap';break;
				case 'N': $rt_array[] = 'epqan';break;
				case 'L': $rt_array[] = 'epqal';break;
				default : $rt_array[]=null;
			}
		}
		return $rt_array;
			
	}
	
}