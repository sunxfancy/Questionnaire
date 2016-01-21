<?php
/**
 *项目人才素质评估数据导出
 */
require_once("../app/classes/PHPExcel.php");
class ProjectEvaluationExport  extends \Phalcon\Mvc\Controller
{
	public function excelExport($project_id){
	 	PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
	 	$objPHPExcel = new PHPExcel();
	 	$objPHPExcel->createSheet(0);
	 	$objPHPExcel->setActiveSheetIndex(0); //设置第一个内置表
	 	$objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
	 	$objActSheet->setTitle('素质评估数据表');
	 	//获取项目下的所有成员id
	 	$examinee = $this->modelsManager->createBuilder()
			    ->columns(array(
			    'number',
				'id',
			    'state',
			    'name',
			    'unit'
				))
			   ->from( 'Examinee' )
			   ->where( 'Examinee.type = 0 AND Examinee.project_id =  '.$project_id )
		       ->getQuery()
		       ->execute()
			   ->toArray();
		//异常处理 
		if(empty($examinee)){
			throw new Exception('项目的被试人数为0,无法进行项目数据表生成');
		}
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
	 	$result = new ProjectEvaluation();
	 	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getDefaultColumnDimension()->setWidth(15);
    	$objActSheet->mergeCells('A1:E2');
    	$objActSheet->setCellValue("A1",'综合素质测评及评价评估统计');
    	$objActSheet->getStyle("A1")->getFont()->setBold(true);
    	$this->position($objActSheet, "A1");
    	$objActSheet->setCellValue("A3",'编号');
    	$this->position($objActSheet, "A3");
    	$objActSheet->setCellValue("B3",'所属');
    	$this->position($objActSheet, "B3");
    	$objActSheet->setCellValue("C3",'姓名');
    	$this->position($objActSheet, "C3");
    	$objActSheet->setCellValue("D3",'分数');
    	$this->position($objActSheet, "D3");
    	$objActSheet->setCellValue("E3",'评估');
    	$this->position($objActSheet, "E3");
    	$startRow = 4; 
    	$lastRow = 4;
	 	foreach ($examinee as $examinee_info) {
	 		$evaluation = array();
	 		$evaluation = $result->getIndividualEvaluation($examinee_info['id']);
	 		$objActSheet->setCellValue("A".$startRow,$examinee_info['number']);
    		$this->position($objActSheet, "A".$startRow);
    		$objActSheet->setCellValue("B".$startRow,$examinee_info['unit']);
    		$this->position($objActSheet, "B".$startRow);
    		$objActSheet->setCellValue("C".$startRow,$examinee_info['name']);
    		$this->position($objActSheet, "C".$startRow);
    		$objActSheet->setCellValue("D".$startRow,$evaluation['score_avg']);
    		$this->position($objActSheet, "D".$startRow);
    		$objActSheet->setCellValue("E".$startRow,$evaluation['level']);
    		$this->position($objActSheet, "E".$startRow);
    		$lastRow = $startRow;
    		$startRow++;
	 	}
	 	$styleArray = array(
    		'borders' => array(
    			'allborders' => array(
    				'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
    			),
    		),
    	);
    	$objActSheet->getStyle('A3:E'.$lastRow)->applyFromArray($styleArray);

	 	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	 	$file_name = './tmp/'.$project_id.'_project_evaluation.xls';
	 	$objWriter->save($file_name);
	 	return $file_name;
	}
	public function position($objActSheet, $pos, $h_align='center'){
    	$objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
    	$objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$objActSheet->getStyle($pos.':'.$pos)->getAlignment()->setWrapText(true);
    }
}