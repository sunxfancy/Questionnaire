<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		  $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction(){		
// 		$re = new Report();
// 		echo '<pre>';
// 		print_r($re->getAdvantages(2656));
// 		echo '</pre>';
// 		echo '<hr />';
// 		echo '<pre>';
// 		print_r($re->getDisadvantages(2662));
// 		echo '</pre>';

		// $chart = new ChartLoader();
		// $chart->test();

		$re = new individualComReport();
		
		// // print_r($re->getSystemComprehensive(2662));
		echo "<pre>";
		$d = $re->IsHidden(2660);
		var_dump($d);
// 		print_r($re->getindividualComprehensive(2660));
		echo "</pre>";
	//	$this->excelloader();

	}

	public function excelloader(){
		require_once("../app/classes/PHPExcel.php");
		#将单元格序列化后再进行Gzip压缩，然后保存在内存中
		PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);  
		$file_path='template/leader.xls';
		$file_type = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($file_type);
		$objReader->setReadDataOnly(true);

		$objPHPExcel = $objReader->load($file_path);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		//---------------------------------------------------------------------------------
		// iterators

		// echo '<table style=\'border:1px solid; border-collapse:collapse;\'>' . "\n";
		// foreach ($objWorksheet->getRowIterator() as $row) {
		//   echo '<tr style=\'border:1px solid\'>' . "\n";
				
		//   $cellIterator = $row->getCellIterator();
		//   $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
		//                                                      // even if it is not set.
		//                                                      // By default, only cells
		//                                                      // that are set will be
		//                                                      // iterated.
		//   foreach ($cellIterator as $cell) {
		//     echo '<td style=\'border:1px solid\'>' . $cell->getValue() . '</td>' . "\n";
		//   }
		  
		//   echo '</tr>' . "\n";
		// }
		// echo '</table>' . "\n";
		//-------------------------------------------------------------------------------------
		// highest rows and columns
		
		// $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		// $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

		// $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

		// echo '<table>' . "\n";
		// for ($row = 1; $row <= $highestRow; ++$row) {
		//   echo '<tr>' . "\n";

		//   for ($col = 0; $col <= $highestColumnIndex; ++$col) {
		//     echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . '</td>' . "\n";
		//   }

		//   echo '</tr>' . "\n";
		// }
		// echo '</table>' . "\n";


	}

}