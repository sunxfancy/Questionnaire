<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	public function indexAction(){
		$examinee_id = 12;
		self::getPapersByExamineeId($examinee_id);
	}
	/**
	 * : 根据被试人员id查取试卷记录
	 * 抛出Exception 1 ： 被试人员没有答题，quesion_ans 中记录为空，获取不到相应信息
	 * 			    2:数据库中的选项-题号 两个字段记录不一致
	 * */
	public function getPapersByExamineeId($examinee_id){
		 $papers = QuestionAns::find(array(
		 	"examinee_id = :examinee_id:",
		 	'bind'=>array('examinee_id' => $examinee_id)
		 ));
		 $papers_array = self::getPaperList($papers);
		 if (empty($papers_array)){
		 	throw new Exception("No examinee_id exists!");
		 }
		 //遍历$papers_array,根据paper_id 查paper表确定paper_name;
		 $i = 0;
		 
		 foreach($papers_array as $paper_array){
		 	$paper_info = Paper::findfirst(array(
		 		"id = :id:",
		 		'bind' => array('id'=>$paper_array['paper_id']) 
		 	));
		 	$papers_array[$i++]['paper_name'] = $paper_info->name;	
		 	$papers_array[$i-1]['score'] = null;
		 	switch(strtoupper($paper_info->name)){
		 		case "16PF" : $papers_array[$i-1]['score']  = self::handle16PF($paper_array); break;
		 		case "SPM"  : $papers_array[$i-1]['score']  = self::handleSPM($paper_array); break;
		 		case "SCL"  : $papers_array[$i-1]['score']  = self::handleSCL($paper_array); break;
		 		//case "EPQA" : $papers_array[$i-1]['score']  = self::handleEPQA($paper_array); break;
		 		//case "EPPS" : $papers_array[$i-1]['score']  = self::handleEPPS($paper_array); break;
		 		//case "CPI"  : $papers_array[$i-1]['score']  = self::handleCPI($paper_array); break;
		 		//default : throw(new Exception("No this type paper"));
		 	}
		 }		 $i = null;
		 echo "<pre>";
		 print_r($papers_array);
		 echo "</pre>"; 
	}
	/**
	 * 对试卷记录进行分割合成数组
	 * @param unknown $papers
	 * @return multitype:multitype:NULL
	 */
	public function getPaperList($papers){
		$papers_array = array();
        foreach ($papers as $paper) {
        	$paper_info = array();
        	$paper_info['paper_id'] = $paper->paper_id;
        	$paper_info['option'] = $paper->option;
        	$paper_info['question_number_list'] = $paper->question_number_list;
            $papers_array[]  = $paper_info;
        }
        return $papers_array;  
	}
	
	
	#处理SPM得分
	public function handleSPM($array){
		$list = Score::strDivideToArray($array['option'],$array['question_number_list']);
		/**
		 * 从数据库中读取spmdf表至内存中，之后再查表
		 */
		
		/**
		 * 在SPM中答案表中存 标准答案的序号 1 2 3 4 5 6 7 8
		 * 需要从字符到数字转换
		 */
		$sql = "select * from Spmdf";
		$spmdf_list_object = $this->modelsManager->executeQuery($sql);
		$spmdf_list = array();
		foreach($spmdf_list_object as $spmdf_record){
			$record = array();
			$record['XH'] = $spmdf_record->XH;
			$record['BZ'] = $spmdf_record->BZ;
			$spmdf_list[] = $record;
			$record = null;
		}
		$record_list = array();
		foreach ($list as $record){
			$tmp_record = array();
			$tmp_record['XH'] = $record['number'];
			$tmp_record['BZ'] = ord($record['option'])-64;
			/**
			 * SPM 只有标准答案算1分，其余为0分，
			 * 
			 */
			$rt_state = Score::multidimensinal_search($spmdf_list, $tmp_record);
			if ( $rt_state ){
				$record_list[] = 1;
			}else{
				$record_list[] = 0;
			}
		}
		return implode('|', $record_list);
	}
	#处理16PF得分(KS)
	public function handle16PF($array){
		$list = Score::strDivideToArray($array['option'],$array['question_number_list']);
		/**
		 * 在16PF(KS)中答案表中存 标准答案的序号 A B　C
		 * 
		 */
		$sql = "select * from Ksdf";
		$ksdf_list_object = $this->modelsManager->executeQuery($sql);
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
		foreach ($list as $record){
			/**
			 * KS中ABC三个选项各有不同的得分
			 * 
			 */
			$rtn_array = Score::findInTwodemensianalArray($ksdf_list, 'TH', $record['number']);
			$rtn_score = $rtn_array[$record['option']];
			$record_list[] = $rtn_score;
			
		}
		return implode('|', $record_list);
		
	}
	#处理SCL得分
	public function handleSCL($array){
		$list = Score::strDivideToArray($array['option'],$array['question_number_list']);
		/**
		 * 在SCL中答案表中存 标准答案的序号 A B　C D E
		 *
		*/
		$sql = "select * from Scldf";
		$scldf_list_object = $this->modelsManager->executeQuery($sql);
		$scldf_list = array();
		foreach($scldf_list_object as $scldf_record){
			$record = array();
			$record['TH'] = $scldf_record->TH;
			$record['A'] = $scldf_record->A;
			$record['B'] = $scldf_record->B;
			$record['C'] = $scldf_record->C;
			$record['D'] = $scldf_record->D;
			$record['E'] = $scldf_record->E;
			$scldf_list[] = $record;
			$record = null;
		}
		$record_list = array();
		foreach ($list as $record){
			/**
			 * SCL中ABCDE三个选项各有不同的得分
			 *
			 */
			$rtn_array = Score::findInTwodemensianalArray($scldf_list, 'TH', $record['number']);
			$rtn_score = $rtn_array[$record['option']];
			$record_list[] = $rtn_score;
				
		}
		return implode('|', $record_list);
		
	}
	#处理EPQA得分
	public function handleEPQA($array){
		
	}
	#处理CPI得分
	public function handleCPI($array){
		
	}
	#处理EPPS得分
	public function handleEPPS($array){
		
	}
	
}