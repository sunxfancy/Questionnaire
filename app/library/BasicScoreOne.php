<?php
class BasicScoreOne {
	/**
	 * : 根据被试人员id查取试卷记录
	 * 抛出Exception 1 ： 被试人员没有答题，quesion_ans 中记录为空，获取不到相应信息
	 * 			    2:数据库中的选项-题号 两个字段记录不一致
	 */
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
		 		case "EPQA" : $papers_array[$i-1]['score']  = self::handleEPQA($paper_array); break;
		 		case "EPPS" : $papers_array[$i-1]['score']  = self::handleEPPS($paper_array); break;
		 		case "CPI"  : $papers_array[$i-1]['score']  = self::handleCPI($paper_array); break;
		 		//default : throw(new Exception("No this type paper"));
		 	}
		 }		 $i = null;
		 return $papers_array;
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
// 		$sql = "select * from spmdf";
// 		$spmdf_list_object = $this->modelsManager->executeQuery($sql);
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
		foreach ($list as $record){
			$tmp_record = array();
			$tmp_record['XH'] = $record['number'];
			$tmp_record['BZ'] = ord($record['option'])-ord('a')+1;
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
// 		$sql = "select * from ksdf";
// 		$ksdf_list_object = $this->modelsManager->executeQuery($sql);
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
		foreach ($list as $record){
			/**
			 * KS中ABC三个选项各有不同的得分
			 * 
			 */
			$rtn_array = Score::findInTwodemensianalArray($ksdf_list, 'TH', $record['number']);
			$rtn_score = $rtn_array[strtoupper($record['option'])];
			//print_r($rtn_array);
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
// 		$sql = "select * from scldf";
// 		$scldf_list_object = $this->modelsManager->executeQuery($sql);
		$scldf_list_object = Scldf::find();
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
			$rtn_score = $rtn_array[strtoupper($record['option'])];
			$record_list[] = $rtn_score;
				
		}
		return implode('|', $record_list);
		
	}
	#处理EPQA得分
	public function handleEPQA($array){
		/**
		 * EPQA A B 两个选项 88道题
		 */
		$list = Score::strDivideToArray($array['option'],$array['question_number_list']);
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
		foreach( $list as $record ){
			$tmp_record = array();
			$tmp_record['TH'] = $record['number'];
			$tmp_record['XZ'] = ord($record['option'])-ord('a')+1;
			$rt_array = Score::multidimensinal_search_v2($epqa_list, $tmp_record);
			$rt_str = Score::readScoreFromArray($rt_array);
			$record_list[] = $rt_str;			
		}
		$record_list = Score::reEPQAList($record_list);
		return implode('|', $record_list);
	}
	#处理CPI得分
	public function handleCPI($array){
		/**
		 * CPI A B 选项  230道题
		 */
		$list = Score::strDivideToArray($array['option'],$array['question_number_list']);
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
		foreach( $list as $record ){
			$tmp_record = array();
			$tmp_record['TH'] = $record['number'];
			$tmp_record['XZ'] = ord($record['option'])-ord('a')+1;
			$rt_array = Score::multidimensinal_search_v2($cpi_list, $tmp_record);			
			$rt_str = Score::readScoreFromArray($rt_array);
			#添加标准转换
			$record_list[] = strtolower($rt_str);
		}

		return implode('|', $record_list);
	}
	#处理EPPS得分
	public function handleEPPS($array){
		/**
		 * EPPS AB 225道题
		 */
		$list = Score::strDivideToArray($array['option'],$array['question_number_list']);
		$epps_list_object = Eppsdf::find();
		$epps_list = array();
		foreach($epps_list_object as $epps_record){
			$record = array();
			$record['TH'] = $epps_record->TH;
			$record['X'] = $epps_record->X;
			$record['Y'] = $epps_record->Y;
			$epps_list[] = $record;
		}
		$record_list =array();
		foreach ($list as $record){
			$rtn_array = Score::findInTwodemensianalArray($epps_list, 'TH', $record['number']);
			$choice_ab = ord($record['option'])-ord('a')+1;
			$record_list[] = Score::readScoreFromArray_v2($rtn_array, $choice_ab);	
		}
		$record_list = Score::reEPPSList($record_list);
		return implode('|', $record_list);
	}
	
}