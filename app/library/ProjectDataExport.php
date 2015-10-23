<?php
/**
 * 项目总体数据整理
 */
require_once("../app/classes/PHPExcel.php");
class ProjectDataExport  extends \Phalcon\Mvc\Controller
{
	
	
	public function excelExport($project_id){
	 	PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
	 	
	 	$objPHPExcel = new PHPExcel();
	 	set_time_limit(0);
	 	$objPHPExcel->createSheet(0);
	 	$objPHPExcel->setActiveSheetIndex(0); //设置第一个内置表
	 	$objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
	 	$objActSheet->setTitle('项目总体数据表');
	 	//获取项目下的所有成员id
	 	$examinee = $this->modelsManager->createBuilder()
			    ->columns(array(
			    'number',
				'id',
			    'state',
			    'name'
				))
			   ->from( 'Examinee' )
			   ->where( 'Examinee.type = 0 AND Examinee.project_id =  '.$project_id )
		       ->getQuery()
		       ->execute()
			   ->toArray();
		//异常处理 
		$members_not_finished = array();
		foreach($examinee as $value){
			if ($value['state'] < 4 ){
				$members_not_finished[$value['number']] = $value['name'];
			}
		}
		if (!empty($members_not_finished)) {
			$list = '项目中部分成员未完成测评过程，如下:<br/>';
			foreach ($members_not_finished as $key => $value) {
				$list .= $key.'：'.$value.'<br/>';
			}
			throw new Exception(print_r($list,true));
		}
	 	$i = 0; 
	 	$result = new ProjectData();
	 	$start_column = 'F';
	 	foreach ($examinee as $examinee_info) {
	 		$data  = array();
	 		$data  = $result->getindividualComprehensive($examinee_info['id']);
	 		if ($i === 0 ) {
	 			$this->makeTable($data, $objActSheet);
	 			
	 		}
	 		$this->joinTable( $data, $objActSheet, $start_column++, $examinee_info['number']);
	 		$i ++ ;
	 	}
	 	
	 	//根据项目第一人成绩统计打表
	 	
	 	//循环写入每个人的成绩
	 	
	 	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	 	$file_name = './tmp/'.$project_id.'_project_data.xls';
	 	$objWriter->save($file_name);
	 	return $file_name;
	}
	public function joinTable(&$data,$objActSheet, $column_flag, $examinee_id){
		$current_row = 2;
		$start_column = $column_flag;
		$row_merge_count = 0;
		$column_merge_count = 0;
		foreach ($data as $module_name =>$module_detail ){
			$end_row = $this->_endRow($current_row, $row_merge_count);
			$end_column = $this->_endColumn($start_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $examinee_id,null,20,null, null, null, true);	
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '综合分',null,20,null, null, null, true);
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
				$index_chosed_detail = $module_detail[$current_index_number];
				$end_row = $this->_endRow($current_row, $row_merge_count);
				foreach ($index_chosed_detail['detail'] as $index_name){
					$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$index_name['score'],null,20,null, null, null, false);
				    $this->_nextRow($current_row, $end_row, $row_merge_count);
				}
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$index_chosed_detail['score'],null,20,null, null, null, false);
				$this->_nextRow($current_row, $end_row, $row_merge_count);
				$this->_nextRow($current_row, $end_row, $row_merge_count);
				$this->_nextRow($current_row, $end_row, $row_merge_count);
			}
				
		}
		foreach ($data as $module_name =>$module_detail ){	
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'综合分',null,20,null, null, null, false);	
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
				$index_chosed_detail = $module_detail[$current_index_number];
				$this->_nextRow($current_row, $end_row, $row_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$index_chosed_detail['score'],null,20,null, null, null, false);
			}
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$this->_nextRow($current_row, $end_row, $row_merge_count);	
		
		}
	}
	public function makeTable(&$data,$objActSheet){
		//settings
		$objActSheet->getDefaultRowDimension()->setRowHeight(21);
		$objActSheet->getDefaultColumnDimension()->setWidth(12);
		$name_array = array('一','二','三','四');
		$current_row   = 1;
		$row_merge_count = 0;
		$i = 0;
		foreach ($data as $module_name =>$module_detail ){
			$start_column = 'B';
			$end_row = $this->_endRow($current_row, $row_merge_count);
			$column_merge_count = 6;
			$end_column = $this->_endColumn($start_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $name_array[$i++].'、'.$module_name.'评价指标',null,12,18, null, null, true);
			
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$start_column = 'A';
			$column_merge_count = 1;
			$end_column = $this->_endColumn($start_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '被试编号',null,12,null, null, null, true);
			$this->_nextColumn($start_column, $end_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '',null,12,null, null, null, true);
			
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$start_column = 'A';
			$column_merge_count = 1;
			$end_column = $this->_endColumn($start_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '',null,12,null, null, null, true);
			$this->_nextColumn($start_column, $end_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '组合因素',null,12,null, null, null, true);
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
				$index_chosed_detail = $module_detail[$current_index_number];
				$this->_nextRow($current_row, $end_row, $row_merge_count);
				$current_row_flag = $current_row;
				$start_column = 'A';
				$column_merge_count  = 1; 
				$end_column = $this->_endColumn($start_column, $column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $index_chosed_detail['chs_name'],null,12,null, null, null, false);
				$this->_nextRow($current_row, $end_row, $row_merge_count);
				$start_column = 'A';
				$column_merge_count  = 1;
				$end_column = $this->_endColumn($start_column, $column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,  count($index_chosed_detail['detail']),null,12,null, 'left', null, false);
				$inner_count = 0;
				$current_row = $current_row_flag;
				$row_merge_count = 0;
				$end_row = $this->_endRow($current_row, $row_merge_count);
				foreach ($index_chosed_detail['detail'] as $index_name){
					if ($inner_count == 0 || $inner_count == 1){
						$start_column = 'C';
						$column_merge_count  = 1;
						$end_column = $this->_endColumn($start_column, $column_merge_count);
						$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$index_name['name'],null,12,null, null, null, false);
					}else {
						$start_column = 'A';
						$column_merge_count  = 1;
						$end_column = $this->_endColumn($start_column, $column_merge_count);
						$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null, null, null, false);
						$column_merge_count  = 1;
						$this->_nextColumn($start_column, $end_column, $column_merge_count);
						$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$index_name['name'],null,12,null, null, null, false);
					}
					$inner_count++;
					$this->_nextRow($current_row, $end_row, $row_merge_count);	
				}
				$start_column = 'A';
				$column_merge_count  = 1;
				$end_column = $this->_endColumn($start_column, $column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null, null, null, false);
				$column_merge_count  = 1;
				$this->_nextColumn($start_column, $end_column, $column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null, null, null, false);
				$this->_nextRow($current_row, $end_row, $row_merge_count);
				$this->_nextRow($current_row, $end_row, $row_merge_count);
			}
			
		}
		$i = 0;
		foreach ($data as $module_name =>$module_detail ){
			$start_column = 'B';
			$end_row = $this->_endRow($current_row, $row_merge_count);
			$column_merge_count = 6;
			$end_column = $this->_endColumn($start_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $name_array[$i++].'、'.$module_name.'评价指标',null,12,18, null, null, true);
			
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$start_column = 'A';
			$column_merge_count = 1;
			$end_column = $this->_endColumn($start_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '评价指标',null,12,null, null, null, true);
			$this->_nextColumn($start_column, $end_column, $column_merge_count);
			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '组合因素（项）',null,12,null, null, null, true);
		
			$index_count = count($module_detail);
			for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
					$index_chosed_detail = $module_detail[$current_index_number];
					$this->_nextRow($current_row, $end_row, $row_merge_count);
					$start_column = 'A';
					$column_merge_count  = 1;
					$end_column = $this->_endColumn($start_column, $column_merge_count);
					$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$index_chosed_detail['chs_name'],null,12,null, null, null, false);
					$column_merge_count  = 1;
					$this->_nextColumn($start_column, $end_column, $column_merge_count);
					$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,count($index_chosed_detail['detail']),null,12,null, null, null, false);	
			}
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			
				
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
	/**
	 * @usage 表格填写
	 * @param $objActSheet 当前活动表
	 * @param $start_column 起始列
	 * @param $current_row 起始行
	 * @param $end_column 结束列
	 * @param $end_row 结束行
	 * @param $value 值
	 * @param $rowHeight 行高    默认 21
	 * @param $colWidth 列宽    默认8.38
	 * @param $fontSize 字号  默认 14
	 * @param $h_alignment 水平对齐方式
	 * @param $v_alignment 竖直对齐方式
	 * @param $bold 是否为粗体 默认为false
	 */
	private function _setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $value, $rowHeight = null, $colWidth = null, $fontSize = null, $h_alignment = null, $v_alignment = null, $bold = false){
		if (!empty($rowHeight)){
			$objActSheet->getRowDimension($current_row)->setRowHeight($rowHeight);
		}else{
			$objActSheet->getRowDimension($current_row)->setRowHeight(21);
		}
		if (!empty($colWidth)){
			$objActSheet->getColumnDimension($start_column)->setWidth($colWidth);
		}else{
			$objActSheet->getColumnDimension($start_column)->setWidth(8.38);
		}
		if (!empty($fontSize)){
			$objActSheet->getStyle("$start_column$current_row")->getFont()->setSize($fontSize);
		}else{
			$objActSheet->getStyle("$start_column$current_row")->getFont()->setSize(14);
		}
		if (!empty($v_alignment)){
			$objActSheet->getStyle("$start_column$current_row")->getAlignment()->setVertical($v_alignment);
		}else{
			//默认垂直居中
			$objActSheet->getStyle("$start_column$current_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		if (!empty($h_alignment)){
			$objActSheet->getStyle("$start_column$current_row")->getAlignment()->setHorizontal($h_alignment);
		}else{
			// 默认为水平居中
			$objActSheet->getStyle("$start_column$current_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		if ($bold){
			$objActSheet->getStyle("$start_column$current_row")->getFont()->setBold(true);
		}
		$objActSheet->getStyle("$start_column$current_row")->getAlignment()->setWrapText(true);//自动换行
		$objActSheet->mergeCells("$start_column$current_row:$end_column$end_row");
		$objActSheet->setCellValue("$start_column$current_row",$value);
	}
	/**
	 * @usage 下一行
	 * @param 当前开始行  $current_row
	 * @param 当前结束行  $end_row
	 * @param 下一行的合并行数  $row_merge_count
	 * @return 下一行的开始  $current_row 下一行的结束  $end_row
	 */
	private function _nextRow(&$current_row, &$end_row, $row_merge_count){
		$this->_nextColumn($current_row, $end_row, $row_merge_count);
	}
	/**
	 * @usage 获取表格结束行
	 * @param 开始行  $current_row
	 * @param 合并行数  $row_merge_count
	 * @return 结束行  $end_column
	 */
	private function _endRow($current_row, $row_merge_count){
		return $this->_endColumn($current_row, $row_merge_count);
	}
	/**
	 *
	 * @param 当前开始列 $start_column
	 * @param 当前结束列 $end_column
	 * @param 下一格的合并列数 $column_merge_count
	 * @return 下一格的开始列 $start_column, 下一格的结束列 $end_column
	 */
	private function _nextColumn(&$start_column, &$end_column, $column_merge_count){
		$start_column = ++ $end_column;
		$end_column = $this->_endColumn($start_column, $column_merge_count);
	}
	/**
	 * @usage 获取表格结束列
	 * @param 开始列  $start_column
	 * @param 合并格数  $column_merge_count
	 * @return 结束列  $end_column
	 */
	private function _endColumn($start_column, $column_merge_count){
		$end_column = $start_column;
		while($column_merge_count--){
			++$end_column;
		}
		return $end_column;
	}
}