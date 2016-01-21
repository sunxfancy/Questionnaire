<?php
/**
 * 项目总体数据整理
 */
require_once("../app/classes/PHPExcel.php");
class IndividualDataExport  extends \Phalcon\Mvc\Controller
{
	public function excelExport($examinee_id,$manager){
	 	PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
	 	$objPHPExcel = new PHPExcel();
	 	$objPHPExcel->createSheet(0);
	 	$objPHPExcel->setActiveSheetIndex(0); //设置第一个内置表
	 	$objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
	 	$objActSheet->setTitle('个人综合素质数据表');
	 	$examinee = Examinee::FindFirst(array(
	 		'id=?1',
	 		'bind'=>array(1=>$examinee_id)))->toArray();
	 	$result = new ProjectData();
	 	$start_column = 'C';
	 	$last = 'C';
	 	$last_data = null;
 		$data  = array();
 		$data  = $result->getindividualComprehensive($examinee_id);
 		$this->makeTable($data, $objActSheet);
 		$last = $start_column;
 		$last_data =  $data;
 		$this->joinTable( $data, $objActSheet, $start_column++, $examinee['number']);	
	 	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

	 	$year = floor($manager->project_id/ 100 );
	 	$path =  '/project/'.$year.'/'.$manager->project_id.'/individual/individual_data/';
	 	$handle = new FileHandle();
	 	$handle->mk_dir('.'.$path);
	 	$file_name =$path.$examinee['number'].'_individual_data.xls';
	 	$objWriter->save(".".$file_name);
	 	return $file_name;
	}
	
	public function position($objActSheet, $pos, $h_align='center', $v_align ='center'){
		$objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
		$objActSheet->getStyle($pos)->getAlignment()->setVertical($v_align);
	
	}
	
	public function joinTable(&$data,$objActSheet, $column_flag, $examinee_id){
		$objActSheet->getColumnDimension($column_flag)->setWidth(20);
		$startRow = 1;
		$i = 0;
		foreach ($data as $module_name =>$module_detail ){
			$i++;
			if ($i == 1 ){
				$startRow++;
				$objActSheet->setCellValue($column_flag.$startRow,$examinee_id);
				$this->position($objActSheet, $column_flag.$startRow);
				$objActSheet->getStyle($column_flag.$startRow)->getFont()->setBold(true);
				$objActSheet->getStyle($column_flag.$startRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			}
			$startRow++;
			$objActSheet->setCellValue($column_flag.$startRow,'综合分');
			$this->position($objActSheet, $column_flag.$startRow);
			$objActSheet->getStyle($column_flag.$startRow)->getFont()->setBold(true);
			$startRow++;
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
				$objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
				$startRow++;
				$index_chosed_detail = $module_detail[$current_index_number];
				foreach ($index_chosed_detail['detail'] as $index_name){
					$objActSheet->setCellValue($column_flag.$startRow,$index_name['score']);
					$this->position($objActSheet, $column_flag.$startRow);
					$startRow++;
				}
				//add index score
				$objActSheet->setCellValue($column_flag.$startRow,$index_chosed_detail['score']);
				$this->position($objActSheet, $column_flag.$startRow);
				$startRow++;
				$startRow++;
				$objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			}
			
			
			$startRow++;
		}
		$i = 0;
		foreach ($data as $module_name =>$module_detail ){
			$startRow++;
			$objActSheet->setCellValue($column_flag.$startRow,'综合分');
			$this->position($objActSheet, $column_flag.$startRow);
			$objActSheet->getStyle($column_flag.$startRow)->getFont()->setBold(true);
			$startRow++;
			$objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
				$startRow++;
				$index_chosed_detail = $module_detail[$current_index_number];
				$objActSheet->setCellValue($column_flag.$startRow,$index_chosed_detail['score']);
				$this->position($objActSheet, $column_flag.$startRow);
			}
			$startRow++;
			$objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$startRow++;
		}
		
	}
	public function makeTable(&$data,$objActSheet){
		//settings
		$objActSheet->getDefaultRowDimension()->setRowHeight(15);
		$objActSheet->getColumnDimension('A')->setWidth(30);
		$objActSheet->getColumnDimension('B')->setWidth(20);
		$objActSheet->getColumnDimension('C')->setWidth(15);
		$name_array = array('一','二','三','四');
		$startRow = 1;
		$i = 0;
		foreach ($data as $module_name =>$module_detail ){
			$objActSheet->mergeCells('A'.$startRow.':C'.$startRow);
			$objActSheet->setCellValue('A'.$startRow,$name_array[$i++].'、'.$module_name.'评价指标');
			$this->position($objActSheet, 'A'.$startRow);
			$objActSheet->getRowDimension($startRow)->setRowHeight(30);
			$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
			if ($i == 1 ){
				$startRow++;
				$objActSheet->setCellValue('A'.$startRow,'被试编号');
				$this->position($objActSheet, 'A'.$startRow);
				$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
				$objActSheet->getStyle('A'.$startRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			}
			$startRow++;
			$objActSheet->setCellValue('A'.$startRow,'评价指标');
			$this->position($objActSheet, 'A'.$startRow);
			$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
			$objActSheet->setCellValue('B'.$startRow,'组合因素');
			$this->position($objActSheet, 'B'.$startRow);
			$objActSheet->getStyle('B'.$startRow)->getFont()->setBold(true);
			$startRow++;
			
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
				$objActSheet->getStyle('A'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle('A'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
				$objActSheet->getStyle('B'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle('B'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
				$objActSheet->getStyle('C'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle('C'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
				$startRow++;
				$index_chosed_detail = $module_detail[$current_index_number];
				$objActSheet->setCellValue('A'.$startRow,$index_chosed_detail['chs_name']);
				$this->position($objActSheet, 'A'.$startRow,'left');
				$objActSheet->setCellValue('A'.($startRow+1), $index_chosed_detail['count']);
				$this->position($objActSheet, 'A'.($startRow+1),'left');
				foreach ($index_chosed_detail['detail'] as $index_name){
					$objActSheet->setCellValue('B'.$startRow,$index_name['name']);
					$this->position($objActSheet, 'B'.$startRow);
					$startRow++;
				}
// 				$objActSheet->setCellValue($column_flag.$startRow,$index_chosed_detail['score']);
// 				$this->position($objActSheet, $column_flag.$startRow);
				$startRow++;
				$startRow++;
				$objActSheet->getStyle('A'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle('A'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
				$objActSheet->getStyle('B'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle('B'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
				$objActSheet->getStyle('C'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objActSheet->getStyle('C'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			}
			$startRow++;
		}
		$i = 0;
		foreach ($data as $module_name =>$module_detail ){
			$objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
			$objActSheet->setCellValue('A'.$startRow,$name_array[$i++].'、'.$module_name.'评价指标');
			$this->position($objActSheet, 'A'.$startRow);
			$objActSheet->getRowDimension($startRow)->setRowHeight(30);
			$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
			$startRow++;
			$objActSheet->setCellValue('A'.$startRow,'评价指标');
			$this->position($objActSheet, 'A'.$startRow);
			$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
			$objActSheet->setCellValue('B'.$startRow,'组合因素');
			$this->position($objActSheet, 'B'.$startRow);
			$objActSheet->getStyle('B'.$startRow)->getFont()->setBold(true);
			$startRow++;
			$objActSheet->getStyle('A'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle('A'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$objActSheet->getStyle('B'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle('B'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$objActSheet->getStyle('C'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle('C'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
					$startRow++;
					$index_chosed_detail = $module_detail[$current_index_number];
					$objActSheet->setCellValue('A'.$startRow,$index_chosed_detail['chs_name']);
					$this->position($objActSheet, 'A'.$startRow);
					$objActSheet->setCellValue('B'.$startRow,$index_chosed_detail['count']);
					$this->position($objActSheet, 'B'.$startRow);
			}
			$startRow++;
			$objActSheet->getStyle('A'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle('A'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$objActSheet->getStyle('B'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle('B'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$objActSheet->getStyle('C'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objActSheet->getStyle('C'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
			$startRow++;
		}
	}
	
	
	#辅助方法 --降维
	private function foo($arr, &$rt) {
		if (is_array($arr)) {
			foreach ($arr as $v) {
				if (is_array($v)) {
					$this->foo($v, $rt);
				} else {
					$rt[] = $v;
				}
			}
		}
		return $rt;
	}
}