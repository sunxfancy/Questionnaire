<?php
	/**
	 * @usage 需求量表结果统计表
	 *
	 */
require_once("../app/classes/PHPExcel.php");

class InqueryExcel extends \Phalcon\Mvc\Controller{

    public function excelExport($project_id) {
    	
        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
        $objPHPExcel = new PHPExcel();
		
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0); //设置第一个内置表
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('综合');
        $this->checkoutFirst($objActSheet,$project_id);//个人信息

        //data
        //数据
        $data = new ProjectComData();
        $data->project_check($project_id);
        $inquery_data = $data->getInqueryAnsComDetail($project_id);
         
        
        $objPHPExcel->createSheet(1);	//添加一个表
        $objPHPExcel->setActiveSheetIndex(1);   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('人数统计-单项统计');        
        $this->checkoutSecond($objActSheet,$project_id, $inquery_data); 
        
        $objPHPExcel->createSheet(2);	//添加一个表
        $objPHPExcel->setActiveSheetIndex(2);   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('人数统计-交叉项统计');
        $this->checkoutThird($objActSheet,$project_id, $inquery_data);
        
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $file_name = './tmp/'.$project_id.'_inqueryans_data.xls';
        $objWriter->save($file_name);
        return $file_name;
        
    }
    public function position($objActSheet, $pos, $h_align='center'){
    	$objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
    	$objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
    }
    
    //导出个人信息
    public function checkoutFirst($objActSheet,$project_id) {
    	//获取目前项目中已经完成的人的需求量表的结果列表
    	$examinee_results = $this->modelsManager->createBuilder()
    	->columns(array(
    			'Examinee.id as id',
    			'Examinee.number as number',
    			'Examinee.name as name',
    			'InqueryAns.option as option'
    	))
    	->from('Examinee')
    	->where('Examinee.project_id = '.$project_id .' AND Examinee.type = 0 ')
    	->leftjoin('InqueryAns', 'InqueryAns.examinee_id = Examinee.id AND InqueryAns.project_id = '.$project_id)
    	->getQuery()
    	->execute()
    	->toArray();
		//这里不再累赘判断结果集为空了
		$question_arr = explode('|',$examinee_results[0]['option']);
		$length = count($question_arr);
		
		$startColumn = 'B';
		$endColumn = 'B';
		for($i = 0; $i < $length; $i ++ ){
			$this->position($objActSheet, $startColumn."1");
			$endColumn = $startColumn;
			$objActSheet->setCellValue($startColumn++."1",$i+1);
		}
		$startRow = 2;
    	foreach($examinee_results as $examinee_record ){
    		$startColumn = 'A';
    		$this->position($objActSheet, $startColumn.$startRow);
    		$objActSheet->setCellValue($startColumn++.$startRow, $examinee_record['number']);
    		$question_arr = explode('|',$examinee_record['option']);
    		foreach($question_arr as $value ){
    			$this->position($objActSheet, $startColumn.$startRow);
    			$objActSheet->setCellValue($startColumn++.$startRow, $value);
    		}
    		$startRow++;
    	}
		
		$styleArray = array(
				'borders' => array(
						'allborders' => array(
								//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
								'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
								//'color' => array('argb' => 'FFFF0000'),
						),
				),
		);
		$objActSheet->getStyle('B2:'.$endColumn.($startRow-1))->applyFromArray($styleArray);
		
    }
   # 2 TQT 
    public function checkoutSecond($objActSheet,$project_id, &$inquery_data){
    	//settings
    	$objActSheet->getColumnDimension('A')->setWidth(20);
    	$objActSheet->getColumnDimension('B')->setWidth(10);
    	$i = 1;
    	$startColumn = 'A';
    	$startRow = 1;
    	foreach($inquery_data as $value) {
    		$objActSheet->mergeCells('A'.$startRow.':B'.$startRow);
    		$this->position($objActSheet, 'A'.$startRow, 'left');
    		$objActSheet->setCellValue('A'.$startRow, $i.'-单项统计');
    		$startRow++;
    		$j = 0;
    		foreach($value['options'] as $option_value) {
    			$this->position($objActSheet, 'A'.$startRow);
    			$objActSheet->setCellValue('A'.$startRow,$option_value);
    			$this->position($objActSheet, 'B'.$startRow);
    			$objActSheet->setCellValue('B'.$startRow,array_sum($inquery_data[$i-1]['value'][$j]));
    			$startRow++;
    			$j++;
    		}
    		$i++;
    		$startRow++;
    	}	
    }
    public function checkoutThird($objActSheet,$project_id, &$inquery_data){
    	$i = 1;
    	$startColumn = 'A';
    	$startRow = 1;
    	
    	foreach($inquery_data[0]['options'] as $level_name){
    		$objActSheet->getColumnDimension($startColumn++)->setWidth(20);
    	}
    	$objActSheet->getColumnDimension($startColumn)->setWidth(20);
    	$startColumn = 'A'; 
    	foreach($inquery_data as $value){
			$startColumn = 'B';
    		$endColumn = 'B';
    		foreach($inquery_data[0]['options'] as $level_name){
    			$this->position($objActSheet, $startColumn.($startRow+1));
    			$endColumn = $startColumn;
    			$objActSheet->setCellValue(($startColumn++).($startRow+1), $level_name);		
    		}
    		$objActSheet->mergeCells('A'.$startRow.':'.$endColumn.$startRow);
    		$this->position($objActSheet, 'A'.$startRow, 'left');
    		$objActSheet->setCellValue('A'.$startRow, $i.'-交叉项统计');
    		$startRow++;
    		$startRow++;
    		$j = 0;
    		foreach($value['options'] as $option_value) {
    			$this->position($objActSheet, 'A'.$startRow);
    			$objActSheet->setCellValue('A'.$startRow, $option_value);
    			$startColumn = 'B';
    			foreach($inquery_data[$i-1]['value'][$j] as $value_level_number){
    				$this->position($objActSheet, $startColumn.$startRow);
    				$objActSheet->setCellValue($startColumn.$startRow, $value_level_number);
    				$startColumn++;
    			}
    			$j++;
    			$startRow++;
    		}
    		$i++;
    		$startRow++;
    	}
    }
}