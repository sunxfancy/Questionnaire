<?php
	/**
	 * @usage 十项报表数据统计
	 *
	 */
require_once("../app/classes/PHPExcel.php");

class CheckoutExcel extends \Phalcon\Mvc\Controller{

    public function excelExport($examinee){

        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
		
        $objPHPExcel = new PHPExcel();
        #1 -- finish
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0); //设置第一个内置表
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('1.个人信息表');
        $this->checkoutPerson($examinee,$objActSheet);//个人信息
		#2 -- finish 
        $objPHPExcel->createSheet(1);	//添加一个表
        $objPHPExcel->setActiveSheetIndex(1);   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('2.TQT人才测评系统');
        $this->checkoutIndex($examinee, $objActSheet); 
		#3 -- check
        $objPHPExcel->createSheet(2);
        $objPHPExcel->setActiveSheetIndex(2);   
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle('3.16pf');
        $this->checkout16pf($examinee, $objActSheet);
		#4 -- check 
        $objPHPExcel->createSheet(3);
        $objPHPExcel->setActiveSheetIndex(3);   
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '4.epps');
        $this->checkoutEpps($examinee,$objActSheet);
		#5 -- check 
        $objPHPExcel->createSheet(4);
        $objPHPExcel->setActiveSheetIndex(4);  
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '5.scl90' );
        $this->checkoutScl($examinee,$objActSheet);
		#6 -- check 
        $objPHPExcel->createSheet(5);
        $objPHPExcel->setActiveSheetIndex(5); 
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '6.epqa');
     	$this->checkoutEpqa($examinee,$objActSheet);
		#7 
        $objPHPExcel->createSheet(6);
        $objPHPExcel->setActiveSheetIndex(6);  
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objActSheet->setTitle('7.cpi');
        $this->checkoutCpi($examinee, $objActSheet);
		#8 -- check 
        $objPHPExcel->createSheet(7);
        $objPHPExcel->setActiveSheetIndex(7); 
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '8.spm');
        $this->checkoutSpm($examinee,$objActSheet);
		#9 --finish
        $objPHPExcel->createSheet(8);
        $objPHPExcel->setActiveSheetIndex(8);  
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objActSheet->setTitle('9.8+5');
        $this->checkoutEightAddFive($examinee,$objActSheet);
		#10 --finish 
        $objPHPExcel->createSheet(9);
        $objPHPExcel->setActiveSheetIndex(9);
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle('10.结构');
        $this->checkoutModuleResult($examinee,$objActSheet);

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $file_name = './tmp/'.$examinee->id.'_checkout.xls';
        $objWriter->save($file_name);
        return $file_name;
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
    //导出个人信息
    public function checkoutPerson($examinee,$objActSheet){
		//settings 
    	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getDefaultColumnDimension()->setWidth(8.38);
		//----------------------------------------------------------------
    	$current_row   = 1;
    	$start_column = 'A';
    	$column_merge_count = 11;$row_merge_count = 0;  //合并注意L: 合并的数量是减1的
    	$end_row = $this->_endRow($current_row, $row_merge_count);
    	$end_column = $this->_endColumn($start_column, $column_merge_count);
		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'测评人员个人基本情况',30, null, 22);
        //-----------------------------------------------------------------
		$this->_nextRow($current_row, $end_row, $row_merge_count);
		$start_column = 'A';
		$column_merge_count = 2;
		$end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'人员编号');
        $column_merge_count = 8;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->number,null,null,null,PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		//------------------------------------------------------------------
		$row_merge_count = 1;
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A'; 
        $column_merge_count = 0;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'姓名');
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->name);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'性别');
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->sex == 0 ? '女':'男');
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'籍贯');
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->native);
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'文化程度');
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->degree);
        //--------------------------------------------
        $row_merge_count = 1;
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A';
        $column_merge_count = 0;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,"出生日期");
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->birthday);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'年龄');
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        //年龄
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$age);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,"政治面貌");
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->politics);
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'技术职称');
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->professional);
        //--------------------------------------
        $row_merge_count = 1;
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A';
        $column_merge_count = 0;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'工作单位');
        $column_merge_count = 10;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->employer,null,null,null,PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        //------------------------------------------
        $row_merge_count = 0;
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A';
        $column_merge_count = 0;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'部门');
        $column_merge_count = 2;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->unit);
        $column_merge_count = 2; 
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'职务');
        $column_merge_count = 4;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->duty);
        //-----------------------------------------
        //教育经历数据处理
        $education = json_decode($examinee->other, true)['education'];
        $sumEducation = count($education);
        $row_merge_count = $sumEducation;
        if ($sumEducation < 5 ){
            $row_merge_count = 5;  //6 rows
        }
        $rows_merge_record = $row_merge_count; //记录所占用的行数
        /////////////////data end 
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A';
        $column_merge_count = 0;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'教育经历');
        $row_merge_count = 0; //修改endRow
        $end_row = $this->_endRow($current_row,$row_merge_count);
        $start_column = 'B';
        $column_merge_count = 2;
        $end_column = $this->_endRow($start_column,$column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'毕业院校');
        $column_merge_count = 2; 
        $this->_nextColumn($start_column, $end_column,$column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'专业');
        $column_merge_count = 1; 
        $this->_nextColumn($start_column, $end_column,$column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'所获学位');
        $column_merge_count = 2; 
        $this->_nextColumn($start_column, $end_column,$column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'时间');
		//根据最左边的合并格来写入
		for($i = 0 ; $i < $rows_merge_record; $i ++ ){
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$start_column = 'B';
			$column_merge_count = 2;
			if ($i < $sumEducation){
				$end_column = $this->_endRow($start_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$education[$i]['school']);
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$education[$i]['profession']);
				$column_merge_count = 1;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$education[$i]['degree']);
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$education[$i]['date']);
			}else{
				$end_column = $this->_endRow($start_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
				$column_merge_count = 1;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
			}
		}
		//-------------------------------
		//工作经历数据处理
		$work = json_decode($examinee->other, true)['work'];
		$sumWork= count($work);
		$row_merge_count = $sumWork;
		if ($sumWork < 5 ){
			$row_merge_count = 5;  //6 rows
		}
		$rows_merge_record = $row_merge_count; //记录所占用的行数
		/////////////////data end
		$this->_nextRow($current_row, $end_row, $row_merge_count);
		$start_column = 'A';
		$column_merge_count = 0;
		$end_column = $this->_endColumn($start_column, $column_merge_count);
		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'工作经历');
		$row_merge_count = 0; //修改endRow
		$end_row = $this->_endRow($current_row,$row_merge_count);
		$start_column = 'B';
		$column_merge_count = 2;
		$end_column = $this->_endRow($start_column,$column_merge_count);
		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'就职单位');
		$column_merge_count = 2;
		$this->_nextColumn($start_column, $end_column,$column_merge_count);
		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'部门');
		$column_merge_count = 1;
		$this->_nextColumn($start_column, $end_column,$column_merge_count);
		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'职位');
		$column_merge_count = 2;
		$this->_nextColumn($start_column, $end_column,$column_merge_count);
		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'工作时间');
		//根据最左边的合并格来写入
		for($i = 0 ; $i < $rows_merge_record; $i ++ ){
			$this->_nextRow($current_row, $end_row, $row_merge_count);
			$start_column = 'B';
			$column_merge_count = 2;
			if ($i < $sumEducation){
				$end_column = $this->_endRow($start_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$work[$i]['employer']);
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$work[$i]['unit']);
				$column_merge_count = 1;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$work[$i]['duty']);
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$work[$i]['date']);
			}else{
				$end_column = $this->_endRow($start_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
				$column_merge_count = 1;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
				$column_merge_count = 2;
				$this->_nextColumn($start_column, $end_column,$column_merge_count);
				$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'');
			}
		}
		$styleBorderArray = array(
		            'borders' => array(
				                'allborders' => array(
						                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
						                ),
				            ),
		);
		$objActSheet->getStyle("A3:L$end_row")->applyFromArray($styleBorderArray);
    }

   # 2 TQT 
    public function checkoutIndex($examinee,$objActSheet){
    	//settings
    	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getDefaultColumnDimension()->setWidth(12);
    	//----------------------------------------------------------------
    	$current_row   = 1;
    	$start_column = 'A';
    	$column_merge_count = 7;$row_merge_count = 1;  //合并注意L: 合并的数量是减1的
    	$end_row = $this->_endRow($current_row, $row_merge_count);
    	$end_column = $this->_endColumn($start_column, $column_merge_count);
    	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'TQT人才测评系统  28项指标排序',null, 12, 22);
    	//----------------------------------------------------------------
    	$row_merge_count = 0 ;
    	$this->_nextRow($current_row, $end_row, $row_merge_count);
    	$column_merge_count = 1;
    	$end_column = $this->_endColumn($start_column, $column_merge_count);
    	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'被试编号',null, 12, null,null,null, true);
    	$column_merge_count = 2;
    	$this->_nextColumn($start_column, $end_column, $column_merge_count);
    	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->number,null, 12, null,null,null, false);
    	$column_merge_count = 0;
    	$this->_nextColumn($start_column, $end_column, $column_merge_count);
    	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'姓名',null, 12, null,null,null, true);
    	$column_merge_count = 1;
    	$this->_nextColumn($start_column, $end_column, $column_merge_count);
    	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->name,null,12, null,null,null, false);
    	//-------------------------
    	$data = new CheckoutData();
    	$result = $data->getIndexdesc($examinee->id);
    	$this->_nextRow($current_row, $end_row, $row_merge_count);
    	$start_row = $current_row+1;
    	$i = 1; 
    	foreach ($result as $result_record){
    		$this->_nextRow($current_row, $end_row, $row_merge_count);
    		$start_column = 'A';
    		$column_merge_count = 0;
    		$end_column = $this->_endColumn($start_column, $column_merge_count);
    		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$i++,null, 12, null,null,null, false);
    		$column_merge_count = 2;
    		$this->_nextColumn($start_column, $end_column, $column_merge_count);
    		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$result_record['chs_name'],null, 12, null,null,null,false);
    		$column_merge_count = 0;
    		$this->_nextColumn($start_column, $end_column, $column_merge_count);
    		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$result_record['score'],null, 12, null,null,null,false);
    		$column_merge_count = 0;
    		$this->_nextColumn($start_column, $end_column, $column_merge_count);
    		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$result_record['rank'],null, 12, null,null,null,false);
    		$column_merge_count = 1;
    		$this->_nextColumn($start_column, $end_column, $column_merge_count);
    		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12, null,null,null, false);
    		 
    	} 
    	$styleBorderArray = array(
    			'borders' => array(
    					'allborders' => array(
    							'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
    					),
    			),
    	);
    	$objActSheet->getStyle("A$start_row:H$end_row")->applyFromArray($styleBorderArray);
    }
   # 3 16pf 
    public function checkout16pf($examinee, $objActSheet){
    	
        $objActSheet->getColumnDimension('B')->setWidth(5);
        $objActSheet->getColumnDimension('C')->setWidth(10);
        $objActSheet->getColumnDimension('D')->setWidth(20);
        $objActSheet->getColumnDimension('E')->setWidth(2.5);
        $objActSheet->getColumnDimension('F')->setWidth(2.5);
        $objActSheet->getColumnDimension('G')->setWidth(2.5);
        $objActSheet->getColumnDimension('H')->setWidth(2.5);
        $objActSheet->getColumnDimension('I')->setWidth(2.5);
        $objActSheet->getColumnDimension('J')->setWidth(2.5);
        $objActSheet->getColumnDimension('K')->setWidth(2.5);
        $objActSheet->getColumnDimension('L')->setWidth(2.5);
        $objActSheet->getColumnDimension('M')->setWidth(2.5);
        $objActSheet->getColumnDimension('N')->setWidth(2.8);
        $objActSheet->getColumnDimension('O')->setWidth(20);
        

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle('A2:O4')->applyFromArray($styleArray1);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:Q1');
        $objActSheet->setCellValue('A1','卡特尔十六种人格因素(16PF)测验结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objActSheet->mergeCells('B2:C2');
        $objActSheet->mergeCells('B3:C3');
        $objActSheet->mergeCells('B4:C4');
        $objActSheet->mergeCells('E2:J2');
        $objActSheet->mergeCells('E3:J3');
        $objActSheet->mergeCells('K2:N2');
        $objActSheet->mergeCells('K3:N3');
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('D2','编号');
        $objActSheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('E2',$examinee->number);
        $objActSheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('K2','姓名');
        $objActSheet->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('O2',$examinee->name);
        $objActSheet->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A3','性别');
        $objActSheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B3',$sex);
        $objActSheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('D3','年龄');
        $objActSheet->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('E3',$age);
        $objActSheet->setCellValue('K3','职业');
        $objActSheet->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('O3',$examinee->duty);
        $objActSheet->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         
        $objActSheet->setCellValue('A4','日期');
        $objActSheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $date  = explode(' ',$examinee->last_login)[0]; 
        $objActSheet->setCellValue('B4',$date);
        $objActSheet->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         

        $objActSheet->getRowDimension(5)->setRowHeight(8);

        $objActSheet->setCellValue('A6','因子名称');
        $objActSheet->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objActSheet->setCellValue('B6','代号');
        $objActSheet->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objActSheet->setCellValue('C6',' 标准分 ');
        $objActSheet->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objActSheet->setCellValue('D6','低分者特征');
        $objActSheet->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objActSheet->setCellValue('O6','高分者特征');
        $objActSheet->getStyle('O6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        

        $letter = array('E','F','G','H','I','J','K','L','M','N');
        for($i = 6;$i<16;$i++){
            $j = $i -5;
            $k = $j -1;
            $objActSheet->getStyle("$letter[$k]6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objActSheet->setCellValue("$letter[$k]6","$j");
        }

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$examinee->project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['16PF'];
        asort($factor_name);
        $factor_name_one = array();
        $factor_name_two = array();
        foreach ($factor_name as $key=>$value) {
            if ($value<='X') {
                $factor_name_one[$key] = $value;
            }
            else {
                $factor_name_two[$key] = $value;
            }
        }
        $i = 7;
        foreach ($factor_name_one as $key => $value) {
            $factor = Factor::find(
                                array(
                                    "name = :name:",'bind'=>array('name'=>$value))
                    );
            $factor_chs_name = $factor[0]->chs_name;
            $factorAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $factor[0]->id))
                    );
            $std_score = $factorAns[0]->std_score;
            $objActSheet->setCellValue("A$i","$factor_chs_name");
            $objActSheet->setCellValue("B$i","$value");
            $objActSheet->getStyle("B$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->setCellValue("C$i","$std_score");
            $objActSheet->getStyle("C$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $j = $std_score-1;
            $objActSheet->setCellValue("$letter[$j]$i","●");
            $i++;
        }
        $objActSheet->getStyle('A6:O'.($i-1))->applyFromArray($styleArray1);
        $objActSheet->getRowDimension($i)->setRowHeight(8);
        $i++;
        $objActSheet->getRowDimension($i)->setRowHeight(30);
        $objActSheet->mergeCells("A$i:O$i");
        $objActSheet->setCellValue("A$i",'次级因素计算结果及其简要解释');
        $objActSheet->getStyle("A$i")->getFont()->setSize(18);
        $i++;
        $objActSheet->mergeCells("A$i:C$i");
        $objActSheet->setCellValue("A$i",'因素名称');
        $objActSheet->setCellValue("D$i",'代号');
        $objActSheet->getStyle("D$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objActSheet->mergeCells("E$i:I$i");
        $objActSheet->setCellValue("E$i",'原始分');
        $objActSheet->getStyle("E$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->mergeCells("J$i:N$i");
        $objActSheet->setCellValue("J$i",'标准分');
        $objActSheet->setCellValue("O$i",'简要说明');
        $i++;
        $j = $i-1;
        foreach ($factor_name_two as $key => $value) {
            $factor = Factor::find(
                                array(
                                    "name = :name:",'bind'=>array('name'=>$value))
                    );
            $factor_chs_name = $factor[0]->chs_name;
            $factorAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $factor[0]->id))
                    );
            $std_score = round($factorAns[0]->std_score);
            $score = round($factorAns[0]->score);
            $objActSheet->mergeCells("A$i:C$i");
            $objActSheet->setCellValue("A$i","$factor_chs_name");            
            $objActSheet->setCellValue("D$i","$value");
            $objActSheet->mergeCells("E$i:I$i");
            $objActSheet->getStyle("D$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("E$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->setCellValue("E$i","$score");
            $objActSheet->mergeCells("J$i:N$i");
            if($value == "Y3"){
                $objActSheet->setCellValue("J$i","$std_score");
                $objActSheet->getStyle("J$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            }
                          
            $i++;
        }
        $objActSheet->getStyle("A$j:O".($i-1))->applyFromArray($styleArray);
        $objActSheet->getStyle("A$j:O".($i-1))->applyFromArray($styleArray1);
    }

    public function checkoutEpps($examinee,$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray1);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','爱德华个人偏好（EPPS）测试结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->setCellValue('C2','编号');
        $objActSheet->setCellValue('D2',$examinee->number);
        $objActSheet->setCellValue('E2','姓名');
        $objActSheet->setCellValue('F2',$examinee->name);
        $objActSheet->setCellValue('A3','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B3',$sex);
        $objActSheet->setCellValue('C3','年龄');
       	$age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B4',$date);

        $objActSheet->getRowDimension(5)->setRowHeight(8);

        $objActSheet->setCellValue("A6","测试项目");
        $objActSheet->setCellValue("B6","得分");        
        $objActSheet->setCellValue("C6","得分排序");
        $objActSheet->setCellValue("D6","测试项目");
        $objActSheet->setCellValue("E6","得分");
        $objActSheet->setCellValue("F6","得分排序");

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$examinee->project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['EPPS'];
        $factor_keys = array_keys($factor_name);
        $factor_epps = FactorAns::find(
                array(
                    "factor_id IN ({factor_key:array}) AND examinee_id = :id:",
                    'bind' => array( 'factor_key' => $factor_keys, 'id'=>$examinee->id),
                    'order' => 'score desc'
                    )
            );
        $number = ceil(count($factor_epps)/2);
        $i = 1;
        $str = "";
        foreach($factor_epps as $key=> $record){
            $factor = Factor::find(
                                array(
                                    "id = :id:",'bind'=>array('id'=>$record->factor_id))
                    );
            $factor_chs_name = $factor[0]->chs_name;
            if($factor_chs_name !="稳定系数"){
                if(empty($str))
                    $str = $factor_chs_name;
                else
                    $str = $str."，".$factor_chs_name;
                      
                if($i<=$number){
                    $j = $i+6;
                    $objActSheet->setCellValue("A$j","$factor_chs_name");
                    $objActSheet->setCellValue("B$j","$record->score");
                    $objActSheet->setCellValue("C$j","$i");
                    $i++;
                }
                else{
                    $j = $i-$number+6;
                    $objActSheet->setCellValue("D$j","$factor_chs_name");
                    $objActSheet->setCellValue("E$j","$record->score");
                    $objActSheet->setCellValue("F$j","$i");
                    $i++;
                }
            }else{
                $j = $i-$number+6;
                $objActSheet->setCellValue("D$j","$factor_chs_name");
                $objActSheet->setCellValue("E$j","$record->score");
            }  
        }
        $k = 6+$number;
        $objActSheet->getStyle("B6:C$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle("E6:F$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle("A6:F$k")->applyFromArray($styleArray);
        $objActSheet->getStyle("A6:F$k")->applyFromArray($styleArray1);
        $k++;
        $objActSheet->getRowDimension($k)->setRowHeight(8);
        $k++;
        $objActSheet->mergeCells("A$k:F$k");
        $objActSheet->setCellValue("A$k","被测者需要倾向按其大小顺序依次排列为: ");
        $objActSheet->getStyle("A$k")->getFont()->setBold(true);
        $k++;
        $objActSheet->getRowDimension($k)->setRowHeight(40);
        $objActSheet->mergeCells("A$k:F$k");
        $objActSheet->getStyle("A$k")->getAlignment()->setWrapText(TRUE);
        $objActSheet->setCellValue("A$k","$str");
        $objActSheet->getStyle("A".($k-1).":F$k")->applyFromArray($styleArray1);
        
    }

    public function checkoutScl($examinee , $objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:E1');
        $objActSheet->setCellValue('A1','SCL90 测试结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->setCellValue('A3','编号');
        $objActSheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('B3',$examinee->number);
        $objActSheet->setCellValue('A4','姓名');
        $objActSheet->setCellValue('B4',$examinee->name);
        $objActSheet->setCellValue('A5','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B5',$sex);
        $objActSheet->setCellValue('A6','年龄');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('B6',$age);
        $objActSheet->setCellValue('A7','日期');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B7',$date);
        $objActSheet->setCellValue('A8','总分');
        $objActSheet->setCellValue('A9','总均分');
        $objActSheet->setCellValue('A10','阴性项目数');
        $objActSheet->setCellValue('A11','阳性项目数');
        $objActSheet->setCellValue('A12','阳性症状均分');

        $objActSheet->setCellValue('D2','因子名称');
        $objActSheet->setCellValue('E2','因子分');
        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$examinee->project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['SCL'];
        $i = 3;
        foreach ($factor_name as $key => $value) {
            $factor = Factor::find(
                                array(
                                    "name = :name:",'bind'=>array('name'=>$value))
                    );
            $factor_chs_name = $factor[0]->chs_name;
            $factorAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $factor[0]->id))
                    );
            $std_score = $factorAns[0]->std_score;
            $objActSheet->setCellValue("D$i","$factor_chs_name");
            $objActSheet->getStyle("E$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("E$i")->getFont()->setBold(true);
            $objActSheet->setCellValue("E$i","$std_score");
            $i++;
        }
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle("A2:B12")->applyFromArray($styleArray);
        $objActSheet->getStyle("A2:B12")->applyFromArray($styleArray1);
        $objActSheet->getStyle("D2:E".($i-1))->applyFromArray($styleArray);
        $objActSheet->getStyle("D2:E".($i-1))->applyFromArray($styleArray1);
    }

    public static function checkoutEpqa($examinee,$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);

        $objActSheet->getColumnDimension('B')->setWidth(20);        

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray1);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','爱克森个性问卷成人 (EPQA) 结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->setCellValue('C2','编号');
        $objActSheet->setCellValue('D2',$examinee->number);
        $objActSheet->setCellValue('E2','姓名');
        $objActSheet->setCellValue('F2',$examinee->name);
        $objActSheet->setCellValue('A3','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B3',$sex);
        $objActSheet->setCellValue('C3','年龄');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B4',$date);

        $objActSheet->getRowDimension(5)->setRowHeight(8);

        $objActSheet->setCellValue('B6','因子名称');
        $objActSheet->setCellValue('C6','代号');
        $objActSheet->setCellValue('D6','原始得分');
        $objActSheet->setCellValue('E6','T分');
        $objActSheet->getStyle("C6:E6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$examinee->project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['EPQA'];
        $i = 7;
        foreach ($factor_name as $key => $value) {
            $factor = Factor::find(
                                array(
                                    "name = :name:",'bind'=>array('name'=>$value))
                    );
            $factor_chs_name = $factor[0]->chs_name;
            $factorAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $factor[0]->id))
                    );
            $score = $factorAns[0]->score;
            $std_score = $factorAns[0]->std_score;
            $objActSheet->setCellValue("B$i","$factor_chs_name");
            $str = strtoupper(substr($value,4));
            $objActSheet->getStyle("C$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->setCellValue("C$i","$str");
            $objActSheet->getStyle("D$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("D$i")->getFont()->setBold(true);
            $objActSheet->setCellValue("D$i","$score");
            $objActSheet->getStyle("E$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("E$i")->getFont()->setBold(true);
            $objActSheet->setCellValue("E$i","$std_score");
            $i++;
        }
        $objActSheet->getStyle('B6:E'.($i-1))->applyFromArray($styleArray);
        $objActSheet->getStyle('B6:E'.($i-1))->applyFromArray($styleArray1);
    }

    public function checkoutCpi($examinee,$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);

        $objActSheet->getColumnDimension('B')->setWidth(20);        

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray1);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','青年性格问卷（CPI）测试结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->setCellValue('C2','编号');
        $objActSheet->setCellValue('D2',$examinee->number);
        $objActSheet->setCellValue('E2','姓名');
        $objActSheet->setCellValue('F2',$examinee->name);
        $objActSheet->setCellValue('A3','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B3',$sex);
        $objActSheet->setCellValue('C3','年龄');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B4',$date);
        $objActSheet->getRowDimension(5)->setRowHeight(20);

        $objActSheet->setCellValue('A6','因子名称');
        $objActSheet->setCellValue('B6','代号');
        $objActSheet->setCellValue('C6','原始分');
        $objActSheet->setCellValue('D6','T分');
        $objActSheet->getStyle("A6:D6")->getFont()->setBold(true);
        $objActSheet->mergeCells("A7:F7");

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$examinee->project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['CPI'];
        ksort($factor_name);

        $array1 = array('do','cs','sy','sp','sa','wb');
        $array2 = array('re','so','sc','po','gi','cm');
        $array3 = array('ac','ai','ie');
        $array4 = array('py','fx','fe');
        $array_one = array();
        $array_two = array();
        $array_three = array();
        $array_four = array();
        foreach ($factor_name as $key => $value) {
            if(in_array($value, $array1)){
                $array_one[$key] = $value;
            }                
            if (in_array($value, $array2)) {
                $array_two[$key] = $value;
            }
            if(in_array($value, $array3)){
                $array_three[$key] = $value;
            }                
            if (in_array($value, $array4)) {
                $array_four[$key] = $value;
            }
        }
        $i = 7;
        $objActSheet->setCellValue("A$i",'第一类  人际关系适应能力的测验');
        self::dealCpi($objActSheet,$array_one,$i);
        $i+=count($array_one)+1;
        $objActSheet->setCellValue("A$i",'第二类  社会化、成熟度、责任心及价值观念的测验');
        self::dealCpi($objActSheet,$array_two,$i);
        $i+=count($array_two)+1;
        $objActSheet->setCellValue("A$i",' 第三类  成就能力与智能效率的测验');
        self::dealCpi($objActSheet,$array_three,$i);
        $i+=count($array_three)+1;
        $objActSheet->setCellValue("A$i",'第四类  个人的生活态度与倾向的测验');
        self::dealCpi($objActSheet,$array_four,$i);
    }

    public static function dealCpi($objActSheet,$array,$i){
        $objActSheet->mergeCells("A$i:F$i");
        $k = $i + count($array);
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle("A$i:F$k")->applyFromArray($styleArray1);
        $i++;
        foreach ($array as $key => $value) {
            $factor = Factor::find(
                                array(
                                    "name = :name:",'bind'=>array('name'=>$value))
                    );
            $factor_chs_name = $factor[0]->chs_name;
            $factorAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $key))
                    );
            $score = $factorAns[0]->score;
            $std_score = $factorAns[0]->std_score;
            $objActSheet->setCellValue("A$i","$factor_chs_name");
            $objActSheet->setCellValue("B$i","$value");
            $objActSheet->getStyle("B$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("C$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("C$i")->getFont()->setBold(true);
            $objActSheet->setCellValue("C$i","$score");
            $objActSheet->getStyle("D$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("D$i")->getFont()->setBold(true);
            $objActSheet->setCellValue("D$i","$std_score");
            $i++;
        }
    }

    public function checkoutSpm($examinee, $objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);

        $objActSheet->getColumnDimension('B')->setWidth(20);        

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                ),
            ),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray1);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','SPM瑞文标准推理测验结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->setCellValue('C2','编号');
        $objActSheet->setCellValue('D2',$examinee->number);
        $objActSheet->setCellValue('E2','姓名');
        $objActSheet->setCellValue('F2',$examinee->name);
        $objActSheet->setCellValue('A3','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B3',$sex);
        $objActSheet->setCellValue('C3','年龄');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B4',$date);

        $objActSheet->setCellValue('A6','总分');

        $objActSheet->setCellValue('C6','百分等级');

        $objActSheet->setCellValue('E6','智力等级');

        $objActSheet->setCellValue('A7','评定结果');
        $objActSheet->mergeCells('B7:F7');

        $objActSheet->setCellValue('A8','部分');
        $objActSheet->setCellValue('A9','得分');

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$examinee->project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['SPM'];
        $spmKey = array_keys($factor_name,"spm");
        $spmKey = $spmKey[0];
        $spmAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $spmKey))
                    );
        $spmScore = ceil($spmAns[0]->score);
        $spmStdScore = (string)ceil($spmAns[0]->std_score);
        $percent = substr($spmStdScore,1);
        $intellect = substr($spmStdScore,0,1);
        $objActSheet->setCellValue('B6',$spmScore);
        $objActSheet->setCellValue('D6',$percent);
        $objActSheet->setCellValue('F6',$intellect);
        $objActSheet->setCellValue('B7',"$intellect 级");
        $letterArr = array('A','B','C','D','E','F');
        $spmArray = array('spma','spmb','spmc','spmd','spme','spmf',);
        $i = 1;
        foreach ($factor_name as $key => $value) {
            if (in_array($value, $spmArray)) {
                $factorAns = FactorAns::find(
                                array(
                                    "factor_id = :id:",'bind'=>array('id'=> $key))
                    );
                $score = ceil($factorAns[0]->score);
                $letter = strtoupper(substr($value,3));
                $objActSheet->setCellValue("$letterArr[$i]8","$letter 类");
                $objActSheet->setCellValue("$letterArr[$i]9","$score");
                $i++;
            }
            
        }

        $objActSheet->getStyle("A2:F9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('A6:F9')->applyFromArray($styleArray);
    }
	//9. 8+5 表
     public function checkoutEightAddFive($examinee,$objActSheet){
        $strong = array(
            '【强项指标1】【最优】','【强项指标2】【次优】','【强项指标3】【三优】','【强项指标4】【四优】','【强项指标5】【五优】','【强项指标6】【六优】','【强项指标7】【七优】','【强项指标8】【八优】'
        );
        $weak = array(
            '【弱项指标1】【最弱】','【弱项指标2】【次弱】','【弱项指标3】【三弱】','【弱项指标4】【四弱】','【弱项指标5】【五弱】'
        );
        //settings
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
        $objActSheet->getDefaultColumnDimension()->setWidth(12);
        //----------------------------------------------------------------
        $current_row   = 1;
        $start_column = 'A';
        $column_merge_count = 6;$row_merge_count = 2;  //合并注意L: 合并的数量是减1的
        $end_row = $this->_endRow($current_row, $row_merge_count);
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'TQT人才测评系统    28指标排序（8+5）',30, 12, 18);
        //-----------------------------------------------------------------
        $row_merge_count = 0;
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A';
        $column_merge_count = 1;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'被试编号',null,12,null,null, null, true);
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->number,null,12);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'姓名' ,null,12,null,null, null, true);
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$examinee->name ,null,12);
        //-------------------------------------------------------------
        $row_merge_count = 0;
        $this->_nextRow($current_row, $end_row, $row_merge_count);
        $start_column = 'A';
        $column_merge_count = 1;
        $end_column = $this->_endColumn($start_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,null, null, true);
        $column_merge_count = 1;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'组合因素',null,12,null,null, null, true);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'原始分' ,null,12,null,null, null, true);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'综合分',null,12,null,null, null, true);
        $column_merge_count = 0;
        $this->_nextColumn($start_column, $end_column, $column_merge_count);
        $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'评价结果',null,12,null,null, null, true);
        //--------------------------------------------------------------
        $checkout = new CheckoutData();
        $eightAddFive = $checkout->getEightAddFive($examinee);
        $i = 0;
        foreach($eightAddFive['strong'] as $eight ){
        	$row_merge_count = 0;
        	$this->_nextRow($current_row, $end_row, $row_merge_count);
        	$start_row  = $current_row; 
        	$start_column = 'A';
        	$column_merge_count = 6;
        	$end_column = $this->_endColumn($start_column, $column_merge_count);
        	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$strong[$i++],null,12,null,'left', null, false);
        	$this->_nextRow($current_row, $end_row, $row_merge_count);
        	$start_row  = $current_row;
        	$start_column = 'A';
        	$column_merge_count = 1;
        	$end_column = $this->_endColumn($start_column, $column_merge_count);
        	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$eight['chs_name'], null,12,null,'left', null, false);
        	$inner_i  = 0;
        	foreach ($eight['children'] as $record ){
        		if ($inner_i == 1 ){
        			$start_column = 'A';
        			$row_merge_count = 0;
        			$this->_nextRow($current_row, $end_row, $row_merge_count);
        			$column_merge_count = 1;
        			$end_column = $this->_endColumn($start_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$eight['count'],null,12,null,'left', null, false);	
        		}else if ($inner_i == 0 ) {
        			$start_column = 'C';
        		}else{
        			$start_column = 'A';
        			$row_merge_count = 0;
        			$this->_nextRow($current_row, $end_row, $row_merge_count);
        			$column_merge_count = 1;
        			$end_column = $this->_endColumn($start_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,'left', null, true);	
        		}
        		$column_merge_count = 1;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['name'],null,12,null,null, null, false);
        		$column_merge_count = 0;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['raw_score'] ,null,12,null,'right', null, false);
        		$column_merge_count = 0;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['ans_score'],null,12,null,'right', null, true);
        		$column_merge_count = 0;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['number'],null,12,null,null, null, false);
        	$inner_i++;
        	$styleBorderArray = array(
        			'borders' => array(
        					'allborders' => array(
        							'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        					),
        			),
        	);
        
        	}
            //指标得分
            $start_column = 'A';
            $row_merge_count = 0;
            $this->_nextRow($current_row, $end_row, $row_merge_count);
            $column_merge_count = 1;
            $end_column = $this->_endColumn($start_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,'left', null, true);  
            $column_merge_count = 1;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,null, null, false);
            $column_merge_count = 0;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'' ,null,12,null,'right', null, false);
            $column_merge_count = 0;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$eight['score'],null,12,null,'right', null, true);
            $column_merge_count = 0;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,null, null, false);    
        	$objActSheet->getStyle("A$start_row:G$end_row")->applyFromArray($styleBorderArray);
        	
        }
     	$i = 0;
        foreach($eightAddFive['weak'] as $eight ){
        	$row_merge_count = 0;
        	$this->_nextRow($current_row, $end_row, $row_merge_count);
        	$start_row  = $current_row; 
        	$start_column = 'A';
        	$column_merge_count = 6;
        	$end_column = $this->_endColumn($start_column, $column_merge_count);
        	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$weak[$i++],null,12,null,'left', null, false);
        	$this->_nextRow($current_row, $end_row, $row_merge_count);
        	$start_row  = $current_row;
        	$start_column = 'A';
        	$column_merge_count = 1;
        	$end_column = $this->_endColumn($start_column, $column_merge_count);
        	$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$eight['chs_name'], null,12,null,'left', null, false);
        	$inner_i  = 0;
        	foreach ($eight['children'] as $record ){
        		if ($inner_i == 1 ){
        			$start_column = 'A';
        			$row_merge_count = 0;
        			$this->_nextRow($current_row, $end_row, $row_merge_count);
        			$column_merge_count = 1;
        			$end_column = $this->_endColumn($start_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$eight['count'],null,12,null,'left', null, false);	
        		}else if ($inner_i == 0 ) {
        			$start_column = 'C';
        		}else{
        			$start_column = 'A';
        			$row_merge_count = 0;
        			$this->_nextRow($current_row, $end_row, $row_merge_count);
        			$column_merge_count = 1;
        			$end_column = $this->_endColumn($start_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,'left', null, true);	
        		}
        		$column_merge_count = 1;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['name'],null,12,null,null, null, false);
        		$column_merge_count = 0;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['raw_score'] ,null,12,null,'right', null, false);
        		$column_merge_count = 0;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['ans_score'],null,12,null,'right', null, true);
        		$column_merge_count = 0;
        		$this->_nextColumn($start_column, $end_column, $column_merge_count);
        		$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$record['number'],null,12,null,null, null, false);
        	$inner_i++;
        	$styleBorderArray = array(
        			'borders' => array(
        					'allborders' => array(
        							'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        					),
        			),
        	);
        	}
            $start_column = 'A';
            $row_merge_count = 0;
            $this->_nextRow($current_row, $end_row, $row_merge_count);
            $column_merge_count = 1;
            $end_column = $this->_endColumn($start_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,'left', null, true);  
            $column_merge_count = 1;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,null, null, false);
            $column_merge_count = 0;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'' ,null,12,null,'right', null, false);
            $column_merge_count = 0;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,$eight['score'],null,12,null,'right', null, true);
            $column_merge_count = 0;
            $this->_nextColumn($start_column, $end_column, $column_merge_count);
            $this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row,'',null,12,null,null, null, false);    
        	$objActSheet->getStyle("A$start_row:G$end_row")->applyFromArray($styleBorderArray);
        }
    }
    #10 结构
    public function checkoutModuleResult($examinee,$objActSheet){
		//settings 
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
        $objActSheet->getDefaultColumnDimension()->setWidth(12);
        $data = new CheckoutData();
        $result = $data->getindividualComprehensive($examinee->id);
        $name_array = array('一','二','三','四');
        $current_row   = 1;
        $i = 0; 
        foreach ($result as $module_name =>$module_detail ){
        		$start_column = 'A';
        		$start_row = $current_row;
        		$row_merge_count = 1;
        		$end_row = $this->_endRow($current_row, $row_merge_count);
       			$column_merge_count = 6; 
       			$end_column = $this->_endColumn($start_column, $column_merge_count);
       			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $name_array[$i++].'、'.$module_name.'评价指标',null,12,20, null, null, true);
       			$row_merge_count = 0;
       			$this->_nextRow($current_row, $end_row, $row_merge_count);
       			$column_merge_count = 1;
       			$end_column = $this->_endColumn($start_column, $column_merge_count);
       			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '评价指标',null,12,null,null, null, true);
       			$column_merge_count = 1;
       			$this->_nextColumn($start_column, $end_column, $column_merge_count);
       			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '组合因素（项）',null,12,null,null, null, true);
       			$column_merge_count = 0;
       			$this->_nextColumn($start_column, $end_column, $column_merge_count);
       			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '综合分',null,12,null,null, null, true);
       			$column_merge_count = 1;
       			$this->_nextColumn($start_column, $end_column, $column_merge_count);
       			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '评价结果',null,12,null,null, null, true);
        		$inner_count = count($module_detail);
        		for($loop_i = 0; $loop_i < $inner_count; $loop_i ++ ){
        			$row_merge_count = 0;
        			$this->_nextRow($current_row, $end_row, $row_merge_count);
        			$start_column = 'A';
        			$column_merge_count = 1;
        			$end_column = $this->_endColumn($start_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $module_detail[$loop_i]['chs_name'],null,12,null,null, null, false);
        			$column_merge_count = 1;
        			$this->_nextColumn($start_column, $end_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, count(explode(',',$module_detail[$loop_i]['children'])),null,12,null,null, null, false);
        			$column_merge_count = 0;
        			$this->_nextColumn($start_column, $end_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, $module_detail[$loop_i]['score'],null,12,null,null, null, false);
        			$column_merge_count = 1;
        			$this->_nextColumn($start_column, $end_column, $column_merge_count);
        			$this->_setCellValue($objActSheet, $start_column, $current_row, $end_column, $end_row, '',null,12,null,null, null, false);
        			
        		}
        		$styleBorderArray = array(
        				'borders' => array(
        						'allborders' => array(
        								'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						),
        				),
        		);
           $objActSheet->getStyle("A$start_row:G$end_row")->applyFromArray($styleBorderArray);
           $this->_nextRow($current_row, $end_row, $row_merge_count);
        }
    }

    /*
     * 模块得分
     */
    public static function moduleDetailScore($module_name,$project_detail,$result,$examinee_id){
        $res = array();
        $project_module = explode(',',$project_detail->module_names);
        if(in_array($module_name,$project_module)){
            $module_part = $result[$module_name];
            foreach($module_part as $key => $value){
                $index = Index::findFirst(array(
                    'name = :name:',
                    'bind' => array(
                        'name' => $value['name']
                    )
                ));
                $index = json_encode($index);
                $index = json_decode($index,true);
//                $index_id = $index->id;
                $indexAns = IndexAns::findFirst(array(
                    'index_id = :index_id: AND examinee_id = :examinee_id:',
                    'bind' => array(
                        'index_id' => $index['id'],
                        'examinee_id' => $examinee_id
                    )
                ));
                $indexAns = json_encode($indexAns);
                $indexAns = json_decode($indexAns,true);
//                $score = $indexAns->score;
                $res[$value['name']]['score'] = $indexAns['score'];
//                score($res[$value['name']]['score']);exit;
            }
        }
        return $res;
    }

    /*
     * excel表公共函数
     */
    public static function structureExcelCommon($k,$module_name,$module_part,$result,$objActSheet,$item){
        $objActSheet->setCellValue('A'.$k,$result[$module_name][$module_part]['item']);
        $objActSheet->mergeCells('B'.$k.':C'.$k);
        $objActSheet->mergeCells('E'.$k.':F'.$k);
        $objActSheet->setCellValue('B'.$k,$result[$module_name][$module_part]['combineFactor']);
//                    $objActSheet->setCellValue('D'.($k+2),$resultItem['mk_xljk']['zb_xljksp']['combineFactor']);
        if(!$item[$module_part]['score']){
            $objActSheet->setCellValue('D'.$k,0);
        }else{
            $objActSheet->setCellValue('D'.$k,$item[$module_part]['score']);
        }
        $objActSheet->getStyle('A'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('D'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }

    /*
     * structure表公共表头
     */
    public static function structureExcelHead($k,$title,$objActSheet){
        $objActSheet->setCellValue('A'.$k,$title);
        $objActSheet->mergeCells('A'.$k.':F'.$k);
        $objActSheet->getStyle('A'.$k)->getFont()->setBold(true);
        $objActSheet->getStyle('A'.$k)->getFont()->setSize(20);
        $objActSheet->getRowDimension($k)->setRowHeight(50);
        $objActSheet->getStyle('A'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $objActSheet->getStyle("B$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //表头
        $k += 1;
        $objActSheet->setCellValue('A'.$k,'评价指标');
        $objActSheet->mergeCells('B'.$k.':C'.$k);
        $objActSheet->mergeCells('E'.$k.':F'.$k);
        $objActSheet->setCellValue('B'.$k,'组合因素(项)');
        $objActSheet->setCellValue('D'.$k,'综合分');
        $objActSheet->setCellValue('E'.$k,'评价结果');
        $objActSheet->getStyle('A'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('D'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('E'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }

     /*
     * 获取指标信息
     */
    public static function getIndexMsg($project_id){
        $project_detail = ProjectDetail::findFirst(array(
            'project_id = :project_id:',
            'bind' => array(
                'project_id' => $project_id
            )
        ));
        return json_decode(json_encode($project_detail),true);
    }

    /*
     * 获取测试人员的指标得分
     * 按分数由高到低排序
     */
    public static function getIndexScore($project_id,$examinee_id){
        $project_detail = self::getIndexMsg($project_id);
        $index_names = explode(',',$project_detail['index_names']);
//        $index_name = explode(',',$project_detail->index_names);
        $index_score = array();
        foreach($index_names as $key => $value){
            $index = Index::findFirst(array(
                'name = :name:',
                'bind' => array(
                    'name' => $value
                )
            ));
            $index = json_decode(json_encode($index),true);
            $index_ans = IndexAns::findFirst(array(
                'index_id = :index_id: AND examinee_id = :examinee_id:',
                'bind' => array(
                    'index_id' => $index['id'],
                    'examinee_id' => $examinee_id
                ),
            ));
            $index_ans = json_decode(json_encode($index_ans),true);
            $index_score["$value"] = $index_ans['score'];
        }
        arsort($index_score);
        return $index_score;
    }
    /*
     * 获取指标因子
     * project_id 项目id
     */
    public static function getIndexFactor($project_id){
        $project_detail = self::getIndexMsg($project_id);
        $index_names = explode(',',$project_detail['index_names']);
        $returnArray = array();
        foreach($index_names as $key => $value){
//            $index = Index::findFirst(array(
//                'name = :name:',
//                'bind' => array(
//                    'name' => $value
//                )
//            ));
//            $index = json_decode(json_encode($index),true);
            $index = self::getIndex($value);
            $children = $index['children'];
            $children_name = explode(',',$children);
            foreach($children_name as $k => $item){
                    $returnArray[$value][$item] = $item;
//                }
            }
//            $num = count($returnArray[$value]);
//            $returnArray[$value]['num'] = $num;
        }
        return $returnArray;
    }
    /*
     * 获取指标
     * index_name 指标英文名
     */
    public static function getIndex($index_name){
        $index = Index::findFirst(array(
            'name = :name:',
            'bind' => array(
                'name' => $index_name
            )
        ));
        $index = json_decode(json_encode($index),true);
        return $index;
    }

    /*
     * 获取指标因子答案
     * factor_name 因子英文名
     */
    public static function getFactorAnswer($examinee_id,$factor_name){
        $factor = self::getFactorMsg($factor_name);
        $factor_ans = FactorAns::findFirst(array(
            'factor_id = :factor_id: AND examinee_id = :examinee_id:',
            'bind' => array(
                'factor_id' => $factor['id'],
                'examinee_id' => $examinee_id
            )
        ));
        return json_decode(json_encode($factor_ans),true);
    }

    /*
     * 获取因子信息
     * factor_name 指标英文名
     */

    public static function getFactorMsg($factor_name){
        $factor = Factor::findFirst(array(
            'name = :name:',
            'bind' => array(
                'name' => $factor_name
            )
        ));
        return json_decode(json_encode($factor),true);
    }
    /*
     * 获取指标分数
     */
    public static function getIndexScore2($index_name,$examinee_id){
        $index = Index::findFirst(array(
            'name = :name:',
            'bind' => array(
                'name' => $index_name
            )
        ));
        $index = json_decode(json_encode($index),true);
        $index_ans = IndexAns::findFirst(array(
            'index_id = :index_id: AND examinee_id = :examinee_id:',
            'bind' => array(
                'index_id' => $index['id'],
                'examinee_id' => $examinee_id
            )
        ));
        $index_ans = json_decode(json_encode($index_ans),true);
        return $index_ans;
    }

}