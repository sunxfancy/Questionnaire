<?php
#此文件用于开发阶段数据的数据导入
class  ExcelUpload {
	/*设定操作对象*/
	private static $objPHPExcel = null;

	public function __construct($filePath) {
		require_once("../app/classes/PHPExcel.php");
		$fileType = PHPExcel_IOFactory::identify($filePath);
		$objReader = PHPExcel_IOFactory::createReader($fileType);
		self::$objPHPExcel = $objReader->load($filePath);
	}

	/*
	 * 处理SCL题库
	 * 
	 * SCL表：从第二行开始
	* TH(题号)    NR(内容)
	*
	* */
	public function handleSCL(){
		$currentSheet = self::$objPHPExcel->getSheet(0);
		$columnCount = $currentSheet->getHighestColumn();
		$rowCount = $currentSheet->getHighestRow();
		
		$SCL = array();
		for($currentRow = 2; $currentRow<=$rowCount; $currentRow++ ){
		$val = array();
		for( $currentColumn = 'A'; $currentColumn <=$columnCount; $currentColumn++){
		$val[] = $currentSheet->getCellByColumnAndRow(ord($currentColumn)-65, $currentRow)->getValue();
		}
		$SCL[] = $val;
		$val = null;
		}
		return $SCL;
		}
	/*
	 * 处理EPPS表
	 * TH(题号)  NRA (选项Ａ) NRB（内容Ｂ）
	 * EPPS：　处理方法同ＳＣＬ；
	 * */
		
	/*
	 * 处理EPQA表
	 * TH（题号） NR（内容）
	 * EPQA : 修改的表中处理方法同SCL
	 * */
	/*
	 * 处理CPI， 16PF 方式同上ＳＣＬ
	 * */

}