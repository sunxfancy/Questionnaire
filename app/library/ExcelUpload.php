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

	
	
}