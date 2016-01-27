<?php
	use PhpOffice\PhpWord\PhpWord;
/**
	 * @usage 十项报表数据统计
	 *
	 */
require_once("../app/classes/PHPExcel.php");

class ProjectAnalysisExport extends \Phalcon\Mvc\Controller{

    public function excelExport($project_id){
        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
        $objPHPExcel = new PHPExcel();
        set_time_limit(0);
        //获取第一题选项及下属人员id
        $data = new ProjectComData();
        $result = $data->getBaseLevels($project_id);
        $project_examinee = Examinee::find(array(
            'project_id =?1 and type = 0',
            'bind'=>array(1=>$project_id)))->toArray();
        $project_examinees = array();
        foreach ($project_examinee as $key => $value) {
            $project_examinees[] = $value['id'];
        }
        $project_data = $data->IndexAvgOfExamineesDesc($project_examinees);
        $index_count = count($project_data);
        $rtn_array = array();
        if ($index_count < 5 ){
            $rtn_array['strong'] = array_slice($project_data, 0, $index_count);
            $rtn_array['weak']   = array();
        }else if( $index_count < 8 ){
            $rtn_array['strong'] = array_slice($project_data, 0, 5);
            $rtn_array['weak']   = array_reverse(array_slice($project_data, 5, $index_count-8));
        }else {
            $rtn_array['strong'] = array_slice($project_data, 0, 5);
            $rtn_array['weak']   = array_reverse(array_slice($project_data, $index_count-4, 3));
        }
       
        //统计
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0); //设置第一个内置表
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('统计');
        $this->statisticsExport($result,$objActSheet);
        //打印每个选项对应表
        $i = 1;
        foreach ($result as $key => $value) {
            $objPHPExcel->createSheet(intval($i));   //添加一个表
            $objPHPExcel->setActiveSheetIndex(intval($i));   //设置第2个表为活动表，提供操作句柄
            $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
            $objActSheet->setTitle($key);
            $this->optionExport($value,$objActSheet);
            $i++;
        }
        // 28项全
        $objPHPExcel->createSheet(intval($i));   //添加一个表
        $objPHPExcel->setActiveSheetIndex(intval($i));   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('28综合（全）');
        $this->comprehensiveExport($project_examinees,$result,$objActSheet);
        $i++;
        //28项简
        $objPHPExcel->createSheet(intval($i));   //添加一个表
        $objPHPExcel->setActiveSheetIndex(intval($i));   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('28综合（简）');
        $this->simpleComprehensiveExport($project_examinees,$result,$objActSheet);
        $i++;
        //五优
        $objPHPExcel->createSheet(intval($i));   //添加一个表
        $objPHPExcel->setActiveSheetIndex(intval($i));   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('优5分析');
        $this->fiveAdvantageExport($project_examinees,$rtn_array['strong'],$result,$objActSheet);
        $i++;
        //三劣
        $objPHPExcel->createSheet(intval($i));   //添加一个表
        $objPHPExcel->setActiveSheetIndex(intval($i));   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('劣3分析');
        $this->threeDisadvantageExport($project_examinees,$rtn_array['weak'],$result,$objActSheet);
        $i++;
        //综合素质分析
        $objPHPExcel->createSheet(intval($i));   //添加一个表
        $objPHPExcel->setActiveSheetIndex(intval($i));   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('制作综合素质分析');
        $this->analysisExport($project_id,$result,$objActSheet);
        $i++;
 		
        //导出
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $file_name = './tmp/'.$project_id.'_analysis.xls';
        $objWriter->save($file_name);
        return $file_name;
    }

    public function position($objActSheet, $pos, $h_align='center'){
        $objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
        $objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->getStyle($pos.':'.$pos)->getAlignment()->setWrapText(true);
    }
    //统计表
    public function statisticsExport($result,$objActSheet){
        //settings
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        
        $startRow = 1; 
        $lastRow = 1;
        foreach ($result as $key =>$value) {
            $objActSheet->setCellValue("A".$startRow,$key);
            $this->position($objActSheet, "A".$startRow);
            $startColumn = 'B';
            $lastColumn = 'B';
            foreach ($value as $skey => $svalue) {
                $number = Examinee::findFirst($svalue)->number;
                $objActSheet->setCellValue($startColumn.$startRow,$number);
                $this->position($objActSheet, $startColumn.$startRow);
                $lastColumn = $startColumn;
                $startColumn++;
            }

            $lastRow = $startRow;
            $startRow++;
        }
    }
    //单个选项表
    public function optionExport($value,$objActSheet){
        $i = 0; 
        $result = new ProjectData();
        $start_column = 'D';
        $last = 'D';
        $last_data = null;
        foreach ($value as $skey => $svalue) {
            $data  = array();
            $data  = $result->getindividualComprehensive($svalue);
            if ($i === 0 ) {
                $this->makeTable($data, $objActSheet); 
            }
            $last = $start_column;
            $last_data =  $data;
            $number = Examinee::findFirst($svalue)->number;
            $this->joinTable( $data, $objActSheet, $start_column++, $number);  
            $i ++ ;
        }
        // 计算平均值
        $this->joinAvg($objActSheet, $last_data, 'D', $last );
    }
    //28项全
    public function comprehensiveExport($project_examinees,$result,$objActSheet){
        $project_data = new ProjectData();
        $com_data = $project_data->getlevelsComprehensive($project_examinees);
        $this->joinTable( $com_data, $objActSheet, 'C', '总体');

        $i = 0; 
        $start_column = 'D';
        $last = 'D';
        $last_data = null;
        foreach ($result as $key => $value) {
            $data  = array();
            $data  = $project_data->getlevelsComprehensive($value);
            if ($i === 0 ) {
                $this->makeTable($data, $objActSheet); 
            }
            $last = $start_column;
            $last_data =  $data;
            $number = Examinee::findFirst($value)->number;
            $this->joinTable( $data, $objActSheet, $start_column++, $key);  
            $i ++ ;
        }
    }
    //28项简
    public function simpleComprehensiveExport($project_examinees,$result,$objActSheet){
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $score = new ProjectComData();
        $project_data = $score->IndexAvgOfExaminees($project_examinees);
        
        $objActSheet->setCellValue('C1',"总体");
        $startRow = 2; 
        $i = 0;
        $lastRow = 2;
        foreach ($project_data as $key=>$value ) {
            $objActSheet->getColumnDimension("A")->setWidth(10);
            $objActSheet->setCellValue("A".$startRow,$i+1);
            $this->position($objActSheet, "A".$startRow);
            $objActSheet->getColumnDimension("B")->setWidth(20);
            $objActSheet->setCellValue("B".$startRow,$value['chs_name']);
            $this->position($objActSheet, "B".$startRow);
            $objActSheet->setCellValue("C".$startRow,$value['score']);
            $this->position($objActSheet, "C".$startRow);
            $lastRow = $startRow;
            $startRow++;
            $i++;
        }
        $column = 'D';
        foreach ($result as $key => $value) {
            $data = $score->IndexAvgOfExaminees($value);
            $this->joinScore($data,$objActSheet,$column++,$key);
        }
    }
    //五优
    public function fiveAdvantageExport($project_examinees,$advantage,$result,$objActSheet){
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $children_score = new ModifyFactors();

        $startRow = 2;
        foreach ($advantage as $key => $value) {
            $tempRow1 = $startRow;
            $data = $children_score->getChildrenOfIndexDescForExaminees($value['name'], $value['children'], $project_examinees);
            $objActSheet->setCellValue('A'.$tempRow1,$value['chs_name']);
            $objActSheet->setCellValue('B'.$tempRow1,'总体');
            $tempRow1 ++;
            foreach ($data as $sskey => $ssvalue) {
                $objActSheet->setCellValue('A'.$tempRow1,$ssvalue['chs_name']);
                $objActSheet->setCellValue('B'.$tempRow1,$ssvalue['score']);
                $tempRow1 ++;
            }

            $startColumn = 'C';
            foreach ($result as $skey => $svalue) {
                $tempRow = $startRow;
                $data = $children_score->getChildrenOfIndexDescForExaminees($value['name'], $value['children'], $svalue);
                $objActSheet->setCellValue($startColumn.($tempRow++),$skey);
                foreach ($data as $sskey => $ssvalue) {
                    $objActSheet->setCellValue($startColumn.$tempRow,$ssvalue['score']);
                    $tempRow ++;
                }
                $startColumn ++;
            }
            $startRow = $tempRow + 1; 
        }
    }
    //三劣
    public function threeDisadvantageExport($project_examinees,$disadvantage,$result,$objActSheet){
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $children_score = new ModifyFactors();

        $startRow = 2;
        foreach ($disadvantage as $key => $value) {
            $tempRow1 = $startRow;
            $data = $children_score->getChildrenOfIndexDescForExaminees($value['name'], $value['children'], $project_examinees);
            $objActSheet->setCellValue('A'.$tempRow1,$value['chs_name']);
            $objActSheet->setCellValue('B'.$tempRow1,'总体');
            $tempRow1 ++;
            foreach ($data as $sskey => $ssvalue) {
                $objActSheet->setCellValue('A'.$tempRow1,$ssvalue['chs_name']);
                $objActSheet->setCellValue('B'.$tempRow1,$ssvalue['score']);
                $tempRow1 ++;
            }
            
            $startColumn = 'C';
            foreach ($result as $skey => $svalue) {
                $tempRow = $startRow;
                $data = $children_score->getChildrenOfIndexDescForExaminees($value['name'], $value['children'], $svalue);
                $objActSheet->setCellValue($startColumn.($tempRow++),$skey);
                foreach ($data as $sskey => $ssvalue) {
                    $objActSheet->setCellValue($startColumn.$tempRow,$ssvalue['score']);
                    $tempRow ++;
                }
                $startColumn ++;
            }
            $startRow = $tempRow + 1; 
        }
    }
    //制作综合素质分析
    public function analysisExport($project_id,$result,$objActSheet){
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $examinee = Examinee::find(array(
            'project_id =?1',
            'bind'=>array(1=>$project_id)))->toArray();
        $examinees = array();
        foreach ($examinee as $key=>$value) {
            $examinees[] = $value['id'];
        }
        $data = new CheckoutData();
        $result_1 = $data->getIndexScoreOfModule($project_id,$examinees);
        $tempRow1 = 2;
        foreach ($result_1['score'] as $key => $value) {
            $objActSheet->setCellValue('A'.$tempRow1,$key);
            $objActSheet->setCellValue('B'.$tempRow1,'总体');
            $tempRow1 ++;
            $inner_count = count($value);
            for($loop_i = 0; $loop_i < $inner_count; $loop_i ++ ){
                $objActSheet->setCellValue('A'.$tempRow1,$value[$loop_i]['chs_name']);
                $this->position($objActSheet,'A'.$tempRow1);
                $objActSheet->setCellValue('B'.$tempRow1,$value[$loop_i]['score']);
                $this->position($objActSheet,'B'.$tempRow1);
                $tempRow1 ++;
            }
            $tempRow1 ++;
        }
        $objActSheet->setCellValue('A'.$tempRow1,'综合素质');
        $objActSheet->setCellValue('B'.$tempRow1,'总体');
        $tempRow1 ++;
        foreach ($result_1['sum'] as $key => $value) {
            $objActSheet->setCellValue('A'.$tempRow1,$key);
            $this->position($objActSheet,'A'.$tempRow1);
            $objActSheet->setCellValue('B'.$tempRow1,$value);
            $this->position($objActSheet,'B'.$tempRow1);
            $tempRow1 ++;
        }

        $startRow = 2;
        $startColumn = 'C';
        foreach ($result as $key => $value) {
            $tempRow = $startRow;
            $data1 = $data->getIndexScoreOfModule($project_id,$value);
            foreach ($data1['score'] as $skey => $svalue) {
                $objActSheet->setCellValue($startColumn.($tempRow++),$key);
                $inner_count = count($svalue);
                for($loop_i = 0; $loop_i < $inner_count; $loop_i ++ ){
                    $objActSheet->setCellValue($startColumn.$tempRow,$svalue[$loop_i]['score']);
                    $this->position($objActSheet,$startColumn.$tempRow);
                    $tempRow ++;
                }
                $tempRow ++;
            }
            $objActSheet->setCellValue($startColumn.$tempRow,$key);
            $tempRow ++;
            foreach ($data1['sum'] as $keys => $values) {
                $objActSheet->setCellValue($startColumn.$tempRow,$values);
                $this->position($objActSheet,$startColumn.$tempRow);
                $tempRow ++;
            }
            $startColumn ++;
        }
    }
    public function joinScore($data,$objActSheet,$startColumn,$key){
        $objActSheet->setCellValue($startColumn."1",$key);
        $startRow = 2;
        foreach ($data as $key => $value) {
            $objActSheet->setCellValue($startColumn.$startRow,$value['score']);
            $this->position($objActSheet, $startColumn.$startRow);
            $startRow ++;
        }
    }

    public function joinAvg($objActSheet,$data, $startColumn, $endColumn){
        $column_flag = $endColumn;
        $column_flag++;
        $jiange_1 = $column_flag;
        $column_flag++;
        $jiange_2 = $column_flag;
        $column_flag++;
        $objActSheet->getColumnDimension($column_flag)->setWidth(20);
        $startRow = 1;
        $i = 0;
        foreach ($data as $module_name =>$module_detail ){
            $i++;
            if ($i == 1 ){
                $startRow++;
            }
            $startRow++;
            $objActSheet->setCellValue($column_flag.$startRow,'平均分');
            $this->position($objActSheet, $column_flag.$startRow);
            $objActSheet->getStyle($column_flag.$startRow)->getFont()->setBold(true);
            $startRow++;
            $index_count = count($module_detail);
            for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
                $objActSheet->getStyle($jiange_1.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($jiange_1.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
                $objActSheet->getStyle($jiange_2.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($jiange_2.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
                $objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
                $startRow++;
                $index_chosed_detail = $module_detail[$current_index_number];
                foreach ($index_chosed_detail['detail'] as $index_name){
                    $objActSheet->setCellValue($column_flag.$startRow,"=AVERAGE(".$startColumn.$startRow.":".$endColumn.$startRow.')');
                    $objActSheet->getStyle($column_flag.$startRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                    $this->position($objActSheet, $column_flag.$startRow);
                    $objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
                    $startRow++;
                }
                $objActSheet->setCellValue($column_flag.$startRow,"=AVERAGE(".$startColumn.$startRow.":".$endColumn.$startRow.')');
                $objActSheet->getStyle($column_flag.$startRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                $this->position($objActSheet, $column_flag.$startRow);
                $objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
                $startRow++;
                $startRow++;
                $objActSheet->getStyle($jiange_1.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($jiange_1.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
                $objActSheet->getStyle($jiange_2.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($jiange_2.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
                $objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            }
            $startRow++;
        }
        $i = 0;
        foreach ($data as $module_name =>$module_detail ){
            $startRow++;
            $objActSheet->setCellValue($column_flag.$startRow,'评价结果');
            $this->position($objActSheet, $column_flag.$startRow);
            $objActSheet->getStyle($column_flag.$startRow)->getFont()->setBold(true);
            $startRow++;
            $objActSheet->getStyle($jiange_1.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objActSheet->getStyle($jiange_1.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $objActSheet->getStyle($jiange_2.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objActSheet->getStyle($jiange_2.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $index_count = count($module_detail);
            for ($current_index_number = 0; $current_index_number < $index_count; $current_index_number ++ ){
                $startRow++;
                $index_chosed_detail = $module_detail[$current_index_number];
                $objActSheet->setCellValue($column_flag.$startRow,'');
                $this->position($objActSheet, $column_flag.$startRow);
            }
            $startRow++;
            $objActSheet->getStyle($jiange_1.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objActSheet->getStyle($jiange_1.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $objActSheet->getStyle($jiange_2.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objActSheet->getStyle($jiange_2.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $objActSheet->getStyle($column_flag.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objActSheet->getStyle($column_flag.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $startRow++;
        }  
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
            $objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
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