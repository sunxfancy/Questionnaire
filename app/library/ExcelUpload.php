<?php
	/**
	 * use for upload Excel and return the Data
	 * @author Wangyaohui
	 *finished 2015-8-18
	 */


class  ExcelUpload {
	/*设定操作对象*/
	private static $objPHPExcel = null;

	public function __construct($file_path) {
		require_once("../app/classes/PHPExcel.php");
		#将单元格序列化后再进行Gzip压缩，然后保存在内存中
		PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);  
		$file_type = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($file_type);
		self::$objPHPExcel = $objReader->load($file_path);
	}

	/*
	 * 处理TH与NR的相关题库 SCL EPQA CPI
	 * SCL  90道题 91行
	 * EPQA 88道题  89行
	 * CPI  230道题 231行
	 * 
	* */



	public function handleTestExaminee(){
			$currentSheet = self::$objPHPExcel->getSheet();
			$data = array();
			$data[0]['sex']	 = trim($currentSheet->getCell("D2")->getValue())=="男"?1:0;
			$data[0]['native'] = '';
			$data[0]['education'] = ''; 
			$data[0]['degree'] = '';
			$data[0]['birthday'] = trim($currentSheet->getCell("P2")->getValue());
			$data[0]['last_login']= trim($currentSheet->getCell("F2")->getValue());
			$data[0]['politics']=  '';
			$data[0]['professional']=  '';
			$data[0]['team']= '';
			$data[0]['employer']=  '';
			$data[0]['unit']= '';
			$data[0]['duty']=  '';
			$tmp_array = array();
			$tmp_array['education'] = array();
			$tmp_array['work'] = array();
			$data[0]['other'] = $tmp_array;
			$tmp_array_2 = array();
			foreach($data[0] as $key=>$value){
				if ($key == 'sex'){
					$value = $value == 1 ?'男':'女';
				}
				$tmp_array_2[$key] = $value;
			}
			$data[0]['init_data'] = json_encode($tmp_array_2, JSON_UNESCAPED_UNICODE);
			$data[0]['other'] = json_encode($tmp_array, JSON_UNESCAPED_UNICODE);
			
			return $data;

	}

	public function handleOption($location){
		$option_table=array('','a','b','c','d','e','f','g','h');
		$currentSheet = self::$objPHPExcel->getSheet();
		$option = trim($currentSheet->getCell($location)->getValue());
		$option=strtolower($option);
		$option=str_split($option);
		$number=array();
		foreach ($option as $key => $option_single) {
			# code...
				if(intval($option[$key]!=0)){
					$option[$key]=$option_table[intval($option_single)];
				}
				$number[]=$key+1;
			}
		
		$ret=array();
		$ret[0]=implode("|", $option);
		$ret[1]=implode("|", $number);

		return $ret;
		

	}
	public function handleSheetOne($type){
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$columnCount = $currentSheet->getHighestColumn();
		$rowCount = $currentSheet->getHighestRow();
		if ($columnCount != 'B'){
			throw new Exception("Please ensure the excel content 1");
		}else{
			$rtn_data = null;
			switch (strtoupper($type)){
				case 'SCL': if($rowCount!=91){throw new Exception("Please ensure the excel content 2"); } break;
				case 'EPQA' : if($rowCount!=89){throw new Exception("Please ensure the excel content 2"); } break;
				case 'CPI':if($rowCount!=231){throw new Exception("Please ensure the excel content 2"); } break;
				default: throw new Exception("Please ensure the excel content 3");
				}
			if( $currentSheet->getCellByColumnAndRow(0,1) != 'TH' ||$currentSheet->getCellByColumnAndRow(1,1) != 'NR'){
				throw new Exception("Please ensure the excel content 4");
			}
			$data  = array();
			for($currentRow = 2; $currentRow<=$rowCount; $currentRow++ ){
				$val = array();
				for( $currentColumn = 'A'; $currentColumn <=$columnCount; $currentColumn++){
					$val[] = $currentSheet->getCellByColumnAndRow(ord($currentColumn)-ord('A'), $currentRow)->getValue();
				}
				$data[] = $val;
				$val = null;
			}
			return $data;
			}
	}
	/*
	 * 处理EPPS表
	 * TH(题号)  NRA (选项Ａ) NRB（内容Ｂ）
	 * EPPS：225道题 226行
	 */
	public function handleSheetTwo($type){
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$columnCount = $currentSheet->getHighestColumn();
		$rowCount = $currentSheet->getHighestRow();
		if ($columnCount != 'C'){
			throw new Exception("Please ensure the excel content 1");
		}else{
			$rtn_data = null;
			if($type != 'EPPS'){
				throw new Exception("Please ensure the excel content 2");
			}
			if( $currentSheet->getCellByColumnAndRow(0,1) != 'TH' ||$currentSheet->getCellByColumnAndRow(1,1) != 'NRA' || $currentSheet->getCellByColumnAndRow(2,1)!= 'NRB' ){
				throw new Exception("Please ensure the excel content 4");
			}
			$data  = array();
			for($currentRow = 2; $currentRow<=$rowCount; $currentRow++ ){
				$val = array();
				for( $currentColumn = 'A'; $currentColumn <=$columnCount; $currentColumn++){
					$val[] = $currentSheet->getCellByColumnAndRow(ord($currentColumn)-ord('A'), $currentRow)->getValue();
				}
				$data[] = $val;
				$val = null;
			}
			return $data;
		}
	}
		
	/*
	 * 处理KS(16PF)表
	 * TH	TM	XZ1	XZ2	XZ3
	 * 16PF:187道题 188行
	 * */
	public function handleSheetThree($type='KS'){
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$columnCount = $currentSheet->getHighestColumn();
		$rowCount = $currentSheet->getHighestRow();
		if ($columnCount != 'E'){
			throw new Exception("Please ensure the excel content 1");
		}else{
			$rtn_data = null;
			if($type != 'KS'){
				throw new Exception("Please ensure the excel content 2");
			}
			if( $currentSheet->getCellByColumnAndRow(0,1) != 'TH' ||$currentSheet->getCellByColumnAndRow(1,1) != 'TM' || $currentSheet->getCellByColumnAndRow(2,1)!= 'XZ1' || $currentSheet->getCellByColumnAndRow(3,1)!='XZ2'|| $currentSheet->getCellByColumnAndRow(4,1)!='XZ3' ){
				throw new Exception("Please ensure the excel content 4");
			}
			$data  = array();
			for($currentRow = 2; $currentRow<=$rowCount; $currentRow++ ){
				$val = array();
				for( $currentColumn = 'A'; $currentColumn <=$columnCount; $currentColumn++){
					$val[] = $currentSheet->getCellByColumnAndRow(ord($currentColumn)-ord('A'), $currentRow)->getValue();
				}
				$data[] = $val;
				$val = null;
			}
			return $data;
		}
	}


	/**
	* 处理需求量表上传
	* 此处需按照模板来改动
	*/
	public function handleInquery(){
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$rowCount = $currentSheet->getHighestRow();
		$columnMax = $currentSheet->getHighestColumn();
		$start = 3;
		$ans = array();
		for( $currentRow = $start; $currentRow <= $rowCount; $currentRow ++ ){
			$record = array();
			$choices = array();
			for ($column = 'A'; $column <= $columnMax; $column++) {
				//列数是以A列开始
	            $value = $currentSheet->getCell($column.$currentRow)->getValue();
	            $value = trim($value);
	            if(empty($value)){
	             	//行结束
	             	break;
           		}
	            if( $column == 'A'){
	             	$record['id'] = $value;
	             	continue;
	            }
	            if( $column == 'B'){
	             	$record['topic'] = $value;
	             	continue;
	            }
	            if ( $column == 'C'){
	             	$record['is_radio'] = $value =='是'? 1 : 0;
	             	continue;
	            }
	            $choices[] = $value;
    		}
	    	$record['options'] = implode('|', $choices);
	    	$ans[] = $record;
		}
		return $ans;
	}
	/**
	 * 被试信息上传
	 * 由于被试信息表数据量不定，因此采取逐条插入的方式
	 */
	public function handleExaminee(){
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$rowCount = $currentSheet->getHighestRow();
		$columnMax = $currentSheet->getHighestColumn();
		$start = 3;
		$ans = array();
		for( $currentRow = $start; $currentRow <= $rowCount; $currentRow ++ ){
			$value1 = trim($currentSheet->getCell('C'.$currentRow)->getValue());
			if (empty($value1)){
				break;
			}
			$record = array();
			$record['name'] = $value1;
			$record['sex']  =  trim($currentSheet->getCell('D'.$currentRow)->getValue()) == '男' ? 1:0;
			$record['native'] = trim($currentSheet->getCell('E'.$currentRow)->getValue());
			$record['education'] = trim($currentSheet->getCell('F'.$currentRow)->getValue());
			$record['degree'] = trim($currentSheet->getCell('G'.$currentRow)->getValue());
			$record['birthday'] =  trim($currentSheet->getCell('H'.$currentRow)->getValue());
			$record['politics']=  trim($currentSheet->getCell('I'.$currentRow)->getValue());
			$record['professional']=  trim($currentSheet->getCell('J'.$currentRow)->getValue());
			$record['team']=  trim($currentSheet->getCell('K'.$currentRow)->getValue());
			$record['employer']=  trim($currentSheet->getCell('L'.$currentRow)->getValue());
			$record['unit']=  trim($currentSheet->getCell('M'.$currentRow)->getValue());
			$record['duty']=  trim($currentSheet->getCell('N'.$currentRow)->getValue());
			$flag = false;
			$tmp_array = array();
			$tmp_array['education'] = array();
			$tmp_array['work'] = array();
			for ($column = 'O'; $column != $columnMax; $column++) {
				//列数是以O列开始
				$in_array = array();
				$value = $currentSheet->getCell($column.$currentRow)->getValue();
				$value = trim($value);
				//表示前者完成
				if ($value == 'end'){
					$flag = true;
					continue;
				}
				if (empty($value) && $flag){
					break;
				}
				if (empty($value)){
					continue;
				}
				if(!$flag){
					$in_array['school'] = trim($value);
					$in_array['profession'] = trim($currentSheet->getCell((++$column).$currentRow)->getValue());
					$in_array['degree'] = trim($currentSheet->getCell((++$column).$currentRow)->getValue());
					$in_array['date'] =  trim($currentSheet->getCell((++$column).$currentRow)->getValue());
					$tmp_array['education'][] = $in_array;
				}
				else {
					$in_array['employer'] = $value;
					$in_array['unit'] = trim($currentSheet->getCell((++$column).$currentRow)->getValue());
					$in_array['duty'] = trim($currentSheet->getCell((++$column).$currentRow)->getValue());
					$in_array['date'] = trim($currentSheet->getCell((++$column).$currentRow)->getValue());
					$tmp_array['work'][] = $in_array;
				}
				
			}
			//对输入的教育和工作经历进行时间上的规范排序
			$educations = $tmp_array['education'];
			$works =$tmp_array['work'];
			$count  =  count($educations);
			$time_array = array();
			if (!empty($educations)){
				foreach($educations as $key=>$value){
					$time_array[] = $value['date'];
				}
				array_multisort($time_array,SORT_DESC,$educations);
			}
			$count  =  count($works);
			$time_array = array();
			if (!empty($works)){
				foreach($works as $key=>$value){
					$time_array[] = $value['date'];
				}
				array_multisort($time_array,SORT_DESC,$works);
			}
			$tmp_array = array();
			$tmp_array['education'] = $educations;
			$tmp_array['work'] = $works;
			//end sort
			$tmp_array_2 = array();
			$record['other'] = $tmp_array;
			foreach($record as $key=>$value){
				if ($key == 'sex'){
					$value = $value == 1 ?'男':'女';
				}
				$tmp_array_2[$key] = $value;
			}
			$record['init_data'] = json_encode($tmp_array_2, JSON_UNESCAPED_UNICODE);
			$record['other'] = json_encode($tmp_array, JSON_UNESCAPED_UNICODE);
			$ans[] = $record;
		}
		return $ans;
	}
 	
	/**
	 * 处理面巡专家导入和领导导入
	 */
	public function handleIL() {
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$rowCount = $currentSheet->getHighestRow();
		$start = 3;
		$ans = array();
		for( $currentRow = $start; $currentRow <= $rowCount; $currentRow ++ ){
			$value = trim($currentSheet->getCell('C'.$currentRow)->getValue());
			if (empty($value)){
				break;
			}else{
				$ans[] = $value;
			}
		
		}
		return $ans;
	}
	

	/**
	 * 处理报告评语库上传
	 * 此处需按照模板来改动
	 */
	public function handleComprehensive() {
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$rowCount = $currentSheet->getHighestRow();
		$columnMax = $currentSheet->getHighestColumn();
		//只有两列 一列名称一列评语
		$ans = array();
		for( $currentRow = 1; $currentRow <= $rowCount; $currentRow ++ ) {
			$inner_array = array();
			$value = $currentSheet->getCell('A'.$currentRow)->getValue();
			$value = trim($value);
			$inner_array['index_chs_name'] = $value;
			$value = $currentSheet->getCell('B'.$currentRow)->getValue();
			$value = trim($value);
			$inner_array['comment'] = $value;
			$index_info = Index::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$inner_array['index_chs_name'])));
			if (!isset($index_info->id)){
				throw new Exception( 'Error not find in table index '.print_r($inner_array['index_chs_name'], true));
			}
			$inner_array['index_id']  = $index_info->id;
			$ans[] = $inner_array;
		}
		return $ans;
	}

	/**
	 * 胜任力指标评语导入
	 */
	public function handleCompetency(){
		$data_1 = $this->hanldleCompentencySheetByNumber(0);
		$data_2 = $this->hanldleCompentencySheetByNumber(1);
		$rtn_data =array();
		foreach($data_1 as $key=>$value){
			$inner_array = array();
			$index_info = Index::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['name'])));
			if (!isset($index_info->id)){
				throw new Exception( 'Error not find in table index '.print_r($value['name'], true));
			}
			$inner_array['index_id']  = $index_info->id;
			$inner_array['index_chs_name'] = $value['name'];
			$inner_array['advantage'] = $value['advantage'];
			$inner_array['disadvantage'] = $data_2[$key]['disadvantage'];
			if ($value['name'] != $data_2[$key]['name'] ){
				throw new Exception('Error not find '.print_r($value['name']));
			}
			$rtn_data[] = $inner_array;
		}
		return $rtn_data; 
	}
	
	public function hanldleCompentencySheetByNumber($number) {
		$currentSheet = self::$objPHPExcel->getSheet($number);
		$rowCount = $currentSheet->getHighestRow();
		$columnMax = $currentSheet->getHighestColumn();
		$columnMax++; //表示累加到多一列
		$ans = array();
		for( $currentRow = 1; $currentRow <= $rowCount; $currentRow ++ ) {
			//A列获取指标名称，其他咧获取相应的评语
			$record = array();
			$choices = array();
			for ($column = 'A'; $column != $columnMax; $column++) {
				$value = $currentSheet->getCell($column.$currentRow)->getValue();
				$value = trim($value);
				 if(empty($value)){
	             	//行结束
	             	break;
           		}
	            if( $column == 'A'){
	             	$record['name'] = $value;
	            }else{
           			$choices[] = $value;
           		}
	           
			}
			if ($number === 0 ){
				//优势评语
				$record['advantage'] = json_encode($choices, JSON_UNESCAPED_UNICODE);
				$ans[] = $record;
			}else {
				//劣势评语
				$record['disadvantage'] = json_encode($choices, JSON_UNESCAPED_UNICODE);
				$ans[] = $record;
			}
			
		}
		return $ans;
	}
	
	
	#处理综合表中28项指标下属的评价
	public function handleChildComment(){
		$data_1 = $this->hanldleChildSheetByNumber(0);
		$data_2 = $this->hanldleChildSheetByNumber(1);
		$rtn_data =array();
		foreach($data_1 as $key=>$value){
			$inner_array = array();
			$index_info = Index::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['index_name'])));
			if (!isset($index_info->id)){
				throw new Exception( 'Error not find in table index '.print_r($value['index_name'], true));
			}
			$inner_array['index_id']  = $index_info->id;
			$inner_array['index_chs_name'] = $value['index_name'];
			$inner_array['child_chs_name'] = $value['child_name'];
			$inner_array['advantage'] = $value['advantage'];
			$inner_array['disadvantage'] = $data_2[$key]['disadvantage'];
			if ($value['index_name'] != $data_2[$key]['index_name'] || $value['child_name'] != $data_2[$key]['child_name']){
				throw new Exception('Error not find '.print_r($value['index_name'] ));
			}
			$rtn_data[] = $inner_array;
		}
		return $rtn_data;
		#以下为测试代码
// 		$not_child = array();
// 		$child = array();
// 		foreach($data_1 as $key=>$value){
// 			$inner_array = array();
// 			$index_info = Index::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['index_name'])));
// 			if (!isset($index_info->id)){
// 				throw new Exception( 'Error not find in table index '.print_r($value['index_name'], true));
// 			}
// 			//加一个判定指标判定
// 			if ($index_info->name == 'zb_ldnl'){
// 				//zb_ldnl 0,0,0,0,0
// 				$child_info = Index::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['child_name'])));
// 				if (!isset($child_info->id)){
// 					$not_child[] = $value['index_name'].'-'.$value['child_name'];
// 				}else {
// 					$child[$value['index_name']][] = $child_info->name;
// 				}
// 			}else if ($index_info->name == 'zb_gzzf'){
// 				//zb_gzzf 1,0,1,1,1,1,1
// 				//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
// 				if ($value['child_name'] == '人际关系调节水平'){
// 					$child_info = Index::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['child_name'])));
// 					if (!isset($child_info->id)){
// 						$not_child[] = $value['index_name'].'-'.$value['child_name'];
// 					}else {
// 						$child[$value['index_name']][] = $child_info->name;
// 					}
// 				}else{
// 					$child_info = Factor::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['child_name'])));
// 					if (!isset($child_info->id)){
// 						$not_child[] = $value['index_name'].'-'.$value['child_name'];
// 					}else {
// 						$child[$value['index_name']][] = $child_info->name;
// 					}
// 				}
				
// 			}else {
// 				//下属全为因子的情况
// 					$child_info = Factor::findFirst(array('chs_name =:chs_name:','bind'=>array('chs_name'=>$value['child_name'])));
// 					if (!isset($child_info->id)){
// 						$not_child[] = $value['index_name'].'-'.$value['child_name'];
// 					}else {
// 						$child[$value['index_name']][] = $child_info->name;
// 					}
// 			}
// 		}
		
		
	}
	
	public function hanldleChildSheetByNumber($number){
		$currentSheet = self::$objPHPExcel->getSheet($number);
		$rowCount = $currentSheet->getHighestRow();
		$columnMax = $currentSheet->getHighestColumn();
		$columnMax++; //表示累加到多一列
		$ans = array();
		for( $currentRow = 1; $currentRow <= $rowCount; $currentRow ++ ) {
			//A列获取指标名称，其他咧获取相应的评语
			//先判断是不是空行
			$flag = $currentSheet->getCell('B'.$currentRow)->getValue();
			if (empty(trim($flag))){
				continue;
				//空行则直接跳过
			}
			$record = array();
			$choices = array();
			for ($column = 'B'; $column != $columnMax; $column++) {
				$value = $currentSheet->getCell($column.$currentRow)->getValue();
				$value = trim($value);
				if(empty($value)){
					//行结束
					break;
				}
				if ( $column == 'B'){
					$record['index_name'] = $value;
				}else if ( $column == 'C' ){
					$record['child_name'] = $value;
				}else {
					$choices[] = $value;
				}
		
			}
			if ($number === 0 ){
				//优势评语
				$record['advantage'] = json_encode($choices, JSON_UNESCAPED_UNICODE);
				$ans[] = $record;
			}else {
				//劣势评语
				$record['disadvantage'] = json_encode($choices, JSON_UNESCAPED_UNICODE);
				$ans[] = $record;
			}
		}
		return $ans;
	}
	
}	