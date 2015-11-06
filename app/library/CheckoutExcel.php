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
// 		#2 -- finish 
        $objPHPExcel->createSheet(1);	//添加一个表
        $objPHPExcel->setActiveSheetIndex(1);   //设置第2个表为活动表，提供操作句柄
        $objActSheet = $objPHPExcel->getActiveSheet(); // 获取当前活动的表
        $objActSheet->setTitle('2.TQT人才测评系统');
        $this->checkoutIndex($examinee, $objActSheet); 
// 		#3 -- check
        $objPHPExcel->createSheet(2);
        $objPHPExcel->setActiveSheetIndex(2);   
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle('3.16pf');
        $this->checkout16pf($examinee, $objActSheet);
// 		#4 -- check 
        $objPHPExcel->createSheet(3);
        $objPHPExcel->setActiveSheetIndex(3);   
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '4.epps');
        $this->checkoutEpps($examinee,$objActSheet);
// 		#5 -- check 
        $objPHPExcel->createSheet(4);
        $objPHPExcel->setActiveSheetIndex(4);  
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '5.scl90' );
        $this->checkoutScl($examinee,$objActSheet);
// 		#6 -- check 
        $objPHPExcel->createSheet(5);
        $objPHPExcel->setActiveSheetIndex(5); 
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '6.epqa');
     	$this->checkoutEpqa($examinee,$objActSheet);
// 		#7 
        $objPHPExcel->createSheet(6);
        $objPHPExcel->setActiveSheetIndex(6);  
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objActSheet->setTitle('7.cpi');
        $this->checkoutCpi($examinee, $objActSheet);
// 		#8 -- check 
        $objPHPExcel->createSheet(7);
        $objPHPExcel->setActiveSheetIndex(7); 
        $objActSheet = $objPHPExcel->getActiveSheet(); 
        $objActSheet->setTitle( '8.spm');
        $this->checkoutSpm($examinee,$objActSheet);
// 		//#9 --finish
        $objPHPExcel->createSheet(8);
        $objPHPExcel->setActiveSheetIndex(8);  
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objActSheet->setTitle('9.8+5');
        $this->checkoutEightAddFive($examinee,$objActSheet);
// 		#10 --finish 
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
    public function position($objActSheet, $pos, $h_align='center'){
    	$objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
    	$objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
    }
    
    //导出个人信息
    public function checkoutPerson($examinee,$objActSheet){
    	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getDefaultColumnDimension()->setWidth(10);
    	$objActSheet->mergeCells('A1:L1');
    	$objActSheet->setCellValue("A1",'测评人员个人基本情况');
    	$objActSheet->getStyle("A1")->getFont()->setBold(true);
    	$this->position($objActSheet, 'A1');
		$objActSheet->mergeCells('A2:C2');
		$objActSheet->setCellValue("A2",'人员编号');
		$this->position($objActSheet, 'A2');
		$objActSheet->mergeCells('D2:L2');
		$objActSheet->setCellValue("D2",$examinee->number);
		$this->position($objActSheet, 'D2','left');
		$objActSheet->mergeCells('A3:A4');
		$objActSheet->setCellValue("A3",'姓名');
		$this->position($objActSheet, 'A3');
		$objActSheet->mergeCells('B3:C4');
		$objActSheet->setCellValue("B3",$examinee->name);
		$this->position($objActSheet, 'B3');
		$objActSheet->mergeCells('D3:D4');
		$objActSheet->setCellValue("D3",'性别');
		$this->position($objActSheet, 'D3');
		$objActSheet->mergeCells('E3:F4');
		$objActSheet->setCellValue("E3",$examinee->sex == 0 ? '女':'男');
		$this->position($objActSheet, 'E3');
		$objActSheet->mergeCells('G3:G4');
		$objActSheet->setCellValue("G3",'籍贯');
		$this->position($objActSheet, 'G3');
		$objActSheet->mergeCells('H3:I4');
		$objActSheet->setCellValue("H3",$examinee->native);
		$this->position($objActSheet, 'H3');
		$objActSheet->mergeCells('J3:K4');
		$objActSheet->setCellValue("J3",'文化程度');
		$this->position($objActSheet, 'J3');
		$objActSheet->mergeCells('L3:L4');
		$objActSheet->setCellValue("L3",$examinee->degree);
		$this->position($objActSheet, 'L3');
		$objActSheet->mergeCells('A5:A6');
		$objActSheet->setCellValue("A5",'出生日期');
		$this->position($objActSheet, 'A5');
		$objActSheet->mergeCells('B5:C6');
		$objActSheet->setCellValue("B5",$examinee->birthday);
		$this->position($objActSheet, 'B5');
		$objActSheet->mergeCells('D5:D6');
		$objActSheet->setCellValue("D5",'年龄');
		$this->position($objActSheet, 'D5');
		$objActSheet->mergeCells('E5:F6');
		$age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
		$objActSheet->setCellValue("E5",$age);
		$this->position($objActSheet, 'E5');
		$objActSheet->mergeCells('G5:G6');
		$objActSheet->setCellValue("G5",'政治面貌');
		$this->position($objActSheet, 'G5');
		$objActSheet->mergeCells('H5:I6');
		$objActSheet->setCellValue("H5",$examinee->politics);
		$this->position($objActSheet, 'H5');
		$objActSheet->mergeCells('J5:K6');
		$objActSheet->setCellValue("J5",'技术职称');
		$this->position($objActSheet, 'J5');
		$objActSheet->mergeCells('L5:L6');
		$objActSheet->setCellValue("L5",$examinee->professional);
		$this->position($objActSheet, 'L5');
		$objActSheet->mergeCells('A7:A8');
		$objActSheet->setCellValue("A7",'工作单位');
		$this->position($objActSheet, 'A7');
		$objActSheet->mergeCells('B7:L8');
		$objActSheet->setCellValue("B7",$examinee->employer);
		$this->position($objActSheet, 'B7','left');
		$objActSheet->setCellValue("A9",'部门');
		$this->position($objActSheet, 'A9');
		$objActSheet->mergeCells('B9:F9');
		$objActSheet->setCellValue("B9",$examinee->unit);
		$this->position($objActSheet, 'B9','left');
		$objActSheet->setCellValue("G9",'职务');
		$this->position($objActSheet, 'G9');
		$objActSheet->mergeCells('H9:L9');
		$objActSheet->setCellValue("H9",$examinee->duty);
		$this->position($objActSheet, 'H9','left');
		$education = json_decode($examinee->other, true)['education'];
        $sumEducation = count($education);
        if ($sumEducation < 5 ){
            $sumEducation = 5;  //6 rows
        }
        $objActSheet->mergeCells('A10:A'.(10+$sumEducation));
      	$objActSheet->setCellValue("A10", '教育经历');
      	$this->position($objActSheet, 'A10');
      	$objActSheet->mergeCells('B10:E10');
      	$objActSheet->setCellValue("B10", '毕业院校');
      	$this->position($objActSheet, 'B10');
      	$objActSheet->mergeCells('F10:H10');
      	$objActSheet->setCellValue("F10", '专业');
      	$this->position($objActSheet, 'F10');
      	$objActSheet->mergeCells('I10:J10');
      	$objActSheet->setCellValue("I10", '所获学位');
      	$this->position($objActSheet, 'I10');
      	$objActSheet->mergeCells('K10:L10');
      	$objActSheet->setCellValue("K10", '时间');
      	$this->position($objActSheet, 'K10');
		for( $row = 11; $row < 11+ $sumEducation; $row++ ){
			if (isset($education[$row-11])){
				$objActSheet->mergeCells('B'.$row.':E'.$row);
				$objActSheet->setCellValue("B".$row, $education[$row-11]['school']);
				$this->position($objActSheet, "B".$row);
				$objActSheet->mergeCells('F'.$row.':H'.$row);
				$objActSheet->setCellValue("F".$row, $education[$row-11]['profession']);
				$this->position($objActSheet, "F".$row);
				$objActSheet->mergeCells('I'.$row.':J'.$row);
				$objActSheet->setCellValue("I".$row, $education[$row-11]['degree']);
				$this->position($objActSheet, "I".$row);
				$objActSheet->mergeCells('K'.$row.':L'.$row);
				$objActSheet->setCellValue("K".$row, $education[$row-11]['date']);
				$this->position($objActSheet, "K".$row);
			}else{
				$objActSheet->mergeCells('B'.$row.':E'.$row);
				$objActSheet->setCellValue("B".$row, '');
				$this->position($objActSheet, "B".$row);
				$objActSheet->mergeCells('F'.$row.':H'.$row);
				$objActSheet->setCellValue("F".$row, '');
				$this->position($objActSheet, "F".$row);
				$objActSheet->mergeCells('I'.$row.':J'.$row);
				$objActSheet->setCellValue("I".$row, '');
				$this->position($objActSheet, "I".$row);
				$objActSheet->mergeCells('K'.$row.':L'.$row);
				$objActSheet->setCellValue("K".$row, '');
			}
		}
		$work = json_decode($examinee->other, true)['work'];
		$sumWork= count($work);
		if ($sumWork < 5 ){
			$sumWork = 5;
		}
		$startRow = 10+$sumEducation+1;
		$objActSheet->mergeCells('A'.$startRow.':A'.($startRow+$sumWork));
		$objActSheet->setCellValue('A'.$startRow, '工作经历');
		$this->position($objActSheet, 'A'.$startRow);
		$objActSheet->mergeCells('B'.$startRow.':E'.$startRow);
		$objActSheet->setCellValue("B".$startRow, '就职单位');
		$this->position($objActSheet, 'B'.$startRow);
		$objActSheet->mergeCells('F'.$startRow.':H'.$startRow);
		$objActSheet->setCellValue("F".$startRow, '部门');
		$this->position($objActSheet, 'F'.$startRow);
		$objActSheet->mergeCells('I'.$startRow.':J'.$startRow);
		$objActSheet->setCellValue("I".$startRow, '职位');
		$this->position($objActSheet, 'I'.$startRow);
		$objActSheet->mergeCells('K'.$startRow.':L'.$startRow);
		$objActSheet->setCellValue("K".$startRow, '工作时间');
		$this->position($objActSheet, 'K'.$startRow);
		for( $row = $startRow+1; $row < $startRow +1 + $sumWork; $row++ ){
			if (isset($work[$row-$startRow-1])){
				$objActSheet->mergeCells('B'.$row.':E'.$row);
				$objActSheet->setCellValue("B".$row, $work[$row-$startRow-1]['employer']);
				$this->position($objActSheet, "B".$row);
				$objActSheet->mergeCells('F'.$row.':H'.$row);
				$objActSheet->setCellValue("F".$row, $work[$row-$startRow-1]['unit']);
				$this->position($objActSheet, "F".$row);
				$objActSheet->mergeCells('I'.$row.':J'.$row);
				$objActSheet->setCellValue("I".$row, $work[$row-$startRow-1]['duty']);
				$this->position($objActSheet, "I".$row);
				$objActSheet->mergeCells('K'.$row.':L'.$row);
				$objActSheet->setCellValue("K".$row,  $work[$row-$startRow-1]['date']);
				$this->position($objActSheet, "K".$row);
			}else{
				$objActSheet->mergeCells('B'.$row.':E'.$row);
				$objActSheet->setCellValue("B".$row, '');
				$this->position($objActSheet, "B".$row);
				$objActSheet->mergeCells('F'.$row.':H'.$row);
				$objActSheet->setCellValue("F".$row, '');
				$this->position($objActSheet, "F".$row);
				$objActSheet->mergeCells('I'.$row.':J'.$row);
				$objActSheet->setCellValue("I".$row, '');
				$this->position($objActSheet, "I".$row);
				$objActSheet->mergeCells('K'.$row.':L'.$row);
				$objActSheet->setCellValue("K".$row, '');
			}
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
		$objActSheet->getStyle('A3:L'.($startRow + $sumWork))->applyFromArray($styleArray);
		
    }
   # 2 TQT 
    public function checkoutIndex($examinee,$objActSheet){
    	//settings
    	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getDefaultColumnDimension()->setWidth(10);
    	$objActSheet->mergeCells('A1:H2');
    	$objActSheet->setCellValue("A1",'TQT人才测评系统  28项指标排序');
    	$objActSheet->getStyle("A1")->getFont()->setBold(true);
    	$this->position($objActSheet, "A1");
    	$objActSheet->mergeCells('A3:B3');
    	$objActSheet->setCellValue("A3",'被试编号');
    	$this->position($objActSheet, "A3");
    	$objActSheet->mergeCells('C3:E3');
    	$objActSheet->setCellValue("C3",$examinee->number);
    	$this->position($objActSheet, "C3");
    	$objActSheet->setCellValue("F3",'姓名');
    	$this->position($objActSheet, "F3");
    	$objActSheet->mergeCells('G3:H3');
    	$objActSheet->setCellValue("G3",$examinee->name);
    	$this->position($objActSheet, "G3");
    	$objActSheet->mergeCells('A4:H4');
    	$data = new CheckoutData();
    	$result = $data->getIndexdesc($examinee->id);
    	$startRow = 5; 
    	$i = 0;
    	$lastRow = 5;
    	foreach ($result as $value ) {
    		$objActSheet->setCellValue("A".$startRow,$i+1);
    		$this->position($objActSheet, "A".$startRow);
    		$objActSheet->mergeCells('B'.$startRow.':D'.$startRow);
    		$objActSheet->setCellValue("B".$startRow,$value['chs_name']);
    		$this->position($objActSheet, "B".$startRow);
    		$objActSheet->mergeCells('E'.$startRow.':F'.$startRow);
    		$objActSheet->setCellValue("E".$startRow,$value['score']);
    		$this->position($objActSheet, "E".$startRow);
    		$objActSheet->setCellValue("G".$startRow,$value['rank']);
    		$this->position($objActSheet, "G".$startRow);
    		$objActSheet->setCellValue("H".$startRow,'');
    		$lastRow = $startRow;
    		$startRow++;
    		$i++;
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
    	$objActSheet->getStyle('A5:H'.$lastRow)->applyFromArray($styleArray);
    }
   # 3 16pf 
    public function checkout16pf($examinee, $objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(10);
        $objActSheet->getColumnDimension('C')->setWidth(10);
        $objActSheet->getColumnDimension('D')->setWidth(30);
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
        $objActSheet->getColumnDimension('O')->setWidth(30);
        $objActSheet->mergeCells('A1:O2');
        $objActSheet->setCellValue('A1','卡特尔十六种人格因素(16PF)测验结果');
        $objActSheet->getStyle("A1")->getFont()->setBold(true);
        $this->position($objActSheet, "A1");
        $objActSheet->setCellValue('A3','分类号');
        $this->position($objActSheet, "A3");
        $objActSheet->setCellValue('B3','');
        $objActSheet->setCellValue('C3','编号');
        $this->position($objActSheet, "C3");
        $objActSheet->setCellValue('D3',$examinee->number);
        $this->position($objActSheet, "D3");
        $objActSheet->mergeCells('E3:I3');
        $objActSheet->setCellValue('E3','姓名');
        $this->position($objActSheet, "E3");
        $objActSheet->mergeCells('J3:O3');
        $objActSheet->setCellValue('J3',$examinee->name);
        $this->position($objActSheet, "J3");
        $objActSheet->setCellValue('A4','性别');
        $this->position($objActSheet, "A4");
        $objActSheet->setCellValue('B4',$examinee->sex == 0 ? '女':'男');
        $this->position($objActSheet, "B4");
        $objActSheet->setCellValue('C4','年龄');
        $this->position($objActSheet, "C4");
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->setCellValue('D4',$age);
        $this->position($objActSheet, "D4");
        $objActSheet->mergeCells('E4:I4');
        $objActSheet->setCellValue('E4','职业');
        $this->position($objActSheet, "E4");
        $objActSheet->mergeCells('J4:O4');
        $objActSheet->setCellValue('J4',$examinee->duty);
        $this->position($objActSheet, "J4");
        $objActSheet->setCellValue('A5','日期');
        $this->position($objActSheet, "A5");
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->mergeCells('B5:O5');
        $objActSheet->setCellValue('B5',$date);
        $this->position($objActSheet, "B5",'left');
        $styleArray = array(
        		'borders' => array(
        				'allborders' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A3:O5')->applyFromArray($styleArray);
        
        $objActSheet->mergeCells('A6:O6');
        $objActSheet->setCellValue('A7','因子名称');
        $this->position($objActSheet, 'A7');
        $objActSheet->setCellValue('B7','代号');
        $this->position($objActSheet, 'B7');
        $objActSheet->setCellValue('C7',' 标准分 ');
        $this->position($objActSheet, 'C7');
        $objActSheet->setCellValue('D7','低分者特征');
        $this->position($objActSheet, 'D7');
        $objActSheet->setCellValue('O7','高分者特征');
        $this->position($objActSheet, 'O7');
        $startColumn = 'E';
        for($i = 1; $i <= 10; $i++){
        	$objActSheet->setCellValue(($startColumn).'7',$i);
        	$this->position($objActSheet, ($startColumn++).'7');
        }
        $data = CheckoutData::get16PFdata($examinee);
        if (empty($data)){
        	return ;
        }
     	$array_normal = array('A','B','C','E','F','G','H','I','L','M','N','O','Q1','Q2','Q3','Q4');
     	$array_normal_left = array(
     			'缄默,孤独','迟钝,学识浅薄','情绪激动','谦逊,顺从','严肃,审慎','权宜敷衍','畏怯,退缩','理智,着重现实','信赖随和','现实,合乎成规','坦白,直率,天真','安详沉着,有自信','保守,服膺传统','依赖,随群附众','矛盾冲突,不明大体',	'心平气和,闲散宁静'	
     	);
     	$array_normal_right = array(
     			'外向,乐群','聪慧,富有才识','情绪稳定','好强固执','轻松兴奋','有恒负责','冒险敢为','敏感,感情用事','怀疑,刚愎','幻想,狂放不羁','精明能干,世故','忧虑抑郁,烦恼多端','自由,批评激进','自立自强,当机立断','知已知彼,自律谨严','紧张困拢,激动挣扎'	
     	);
        $array_ciji = array('X1','X2','X3','X4','Y1','Y2','Y3','Y4');
        $startRow = 8;
        $lastRow = 8;
        foreach ($data as $key=>$value ){
        	//先写简单因子
        	if (in_array($key, $array_normal)){
        		  $number = array_search($key, $array_normal);
        		  $objActSheet->setCellValue('A'.$startRow,$value['chs_name']);
        		  $this->position($objActSheet, 'A'.$startRow);
        		  $objActSheet->setCellValue('B'.$startRow,$key);
        		  $this->position($objActSheet, 'B'.$startRow);
        		  $int_std_score = intval($value['std_score']);
        		  $objActSheet->setCellValue('C'.$startRow,$int_std_score);
        		  $this->position($objActSheet, 'C'.$startRow);
        		  $objActSheet->setCellValue('D'.$startRow,$array_normal_left[$number]);
        		  $this->position($objActSheet, 'D'.$startRow);
        		  $objActSheet->setCellValue('O'.$startRow,$array_normal_right[$number]);
        		  $this->position($objActSheet, 'O'.$startRow);
        		  $startColumn = 'E';
        		  for($i = 1; $i <= 10; $i++){
        		  	if ($i == $int_std_score ){
        		  		$objActSheet->setCellValue(($startColumn).$startRow,'●');
        		  		$this->position($objActSheet, ($startColumn++).$startRow);
        		  	}else{
        		  		$objActSheet->setCellValue(($startColumn++).$startRow,'');
        		  	}
        		  }
        		  $lastRow = $startRow;
        		  $startRow++;
        	}
        }
        $objActSheet->getStyle('A7:O'.$lastRow)->applyFromArray($styleArray);
        
        $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
        $startRow++;
        $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
        $startRow++;
        $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
        $firstRow = $startRow;
        $objActSheet->setCellValue('A'.$startRow,'次级因素计算结果及其简要解释');
        $this->position($objActSheet, 'A'.$startRow, 'left');
        $startRow++;
        $objActSheet->mergeCells('A'.$startRow.':B'.$startRow);
        $objActSheet->setCellValue('A'.$startRow,'因素名称');
        $this->position($objActSheet, 'A'.$startRow);
        $objActSheet->setCellValue('C'.$startRow,'代号');
        $this->position($objActSheet, 'C'.$startRow);
        $objActSheet->setCellValue('D'.$startRow,'原始分');
        $this->position($objActSheet, 'D'.$startRow);
        $objActSheet->mergeCells('E'.$startRow.':N'.$startRow);
        $objActSheet->setCellValue('E'.$startRow,'标准分');
        $this->position($objActSheet, 'E'.$startRow);
        $objActSheet->setCellValue('O'.$startRow,'简要解释');
        $this->position($objActSheet, 'O'.$startRow);
        $startRow++;
        foreach ($data as $key=>$value ){
        	//次级因子
        	if (in_array($key,$array_ciji)){
        		$number = array_search($key, $array_normal);
        		$objActSheet->mergeCells('A'.$startRow.':B'.$startRow);
        		$objActSheet->setCellValue('A'.$startRow,$value['chs_name']);
        		$this->position($objActSheet, 'A'.$startRow);
        		$objActSheet->setCellValue('C'.$startRow,$key);
        		$this->position($objActSheet, 'C'.$startRow);
        		$objActSheet->setCellValue('D'.$startRow, $value['score']);
        		$this->position($objActSheet, 'D'.$startRow);
        		$objActSheet->mergeCells('E'.$startRow.':N'.$startRow);
        		if ($key == 'Y3'){
        			$objActSheet->setCellValue('E'.$startRow,$value['std_score']);
        			$this->position($objActSheet, 'E'.$startRow);
        		}else{
        			$objActSheet->setCellValue('E'.$startRow,'');
        		}
        		$objActSheet->setCellValue('O'.$startRow,'');
        		$lastRow = $startRow;
        		$startRow++;
        	}
        }
        $objActSheet->getStyle('A'.$firstRow.':O'.$lastRow)->applyFromArray($styleArray);       
        
    }
   # 4 EPPS
    public function checkoutEpps($examinee,$objActSheet){
        $objActSheet->getDefaultColumnDimension()->setWidth(14);
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','爱德华个人偏好（EPPS）测试结果');
        $objActSheet->getStyle("A1")->getFont()->setBold(true);
        $this->position($objActSheet,'A1');
        $objActSheet->setCellValue('A2','分类号');
        $this->position($objActSheet,'A2');
        $objActSheet->setCellValue('B2','');
        $objActSheet->setCellValue('C2','编号');
        $this->position($objActSheet,'C2');
        $objActSheet->setCellValue('D2',$examinee->number);
        $this->position($objActSheet,'D2');
        $objActSheet->setCellValue('E2','姓名');
        $this->position($objActSheet,'E2');
        $objActSheet->setCellValue('F2',$examinee->name);
        $this->position($objActSheet,'F2');
        $objActSheet->setCellValue('A3','性别');
        $this->position($objActSheet,'A3');
        $objActSheet->setCellValue('B3',$examinee->sex == 0 ? '女':'男');
        $this->position($objActSheet,'B3');
        $objActSheet->setCellValue('C3','年龄');
        $this->position($objActSheet,'C3');
       	$age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->setCellValue('D3',$age);
        $this->position($objActSheet,'D3');
        $objActSheet->setCellValue('E3','职业');
        $this->position($objActSheet,'E3');
        $objActSheet->setCellValue('F3',$examinee->duty);
        $this->position($objActSheet,'F3');
        $objActSheet->setCellValue('A4','日期');
        $this->position($objActSheet,'A4');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->mergeCells('B4:F4');
        $objActSheet->setCellValue('B4',$date);
        $this->position($objActSheet,'B4','left');
        $styleArray = array(
        		'borders' => array(
        				'allborders' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray);
        
        $objActSheet->mergeCells('A5:F5');
        
        $objActSheet->setCellValue("A6","测试项目");
        $this->position($objActSheet,'A6');
        $objActSheet->setCellValue("B6","得分");   
        $this->position($objActSheet,'B6');
        $objActSheet->setCellValue("C6","得分排序");
        $this->position($objActSheet,'C6');
        $objActSheet->setCellValue("D6","测试项目");
        $this->position($objActSheet,'D6');
        $objActSheet->setCellValue("E6","得分");
        $this->position($objActSheet,'E6');
        $objActSheet->setCellValue("F6","得分排序");
        $this->position($objActSheet,'F6');
        $data = CheckoutData::getEPPSdata($examinee);
        if (empty($data)){
        	return ;
        }
        $count = count($data);
        $line = ceil($count/2);
        $startRow = 7;
        $lastRow = $startRow;
       	for($i = 0; $i <$line; $i ++ ){
       		$objActSheet->setCellValue("A".$startRow,$data[$i]['chs_name']);
       		$this->position($objActSheet,"A".$startRow);
       		$objActSheet->setCellValue("B".$startRow,$data[$i]['std_score']);
       		$this->position($objActSheet,"B".$startRow);
       		$objActSheet->setCellValue("C".$startRow,$data[$i]['rank']);
       		$this->position($objActSheet,"C".$startRow);
       		$lastRow = $startRow;
       		$startRow ++;
       	}
       	$startRow = 7;
       	for($i = 0; $i <$line; $i ++ ) {
       		if(isset($data[$i+$line])){
       			$objActSheet->setCellValue("D".$startRow,$data[$i+$line]['chs_name']);
       			$this->position($objActSheet,"D".$startRow);
       			$objActSheet->setCellValue("E".$startRow,$data[$i+$line]['std_score']);
       			$this->position($objActSheet,"E".$startRow);
       			$objActSheet->setCellValue("F".$startRow,$data[$i+$line]['rank']);
       			$this->position($objActSheet,"F".$startRow);
       			$lastRow = $startRow;
       			$startRow ++;
       		}else{
       			$objActSheet->setCellValue("D".$startRow,'');
       			$this->position($objActSheet,"D".$startRow);
       			$objActSheet->setCellValue("E".$startRow,'');
       			$this->position($objActSheet,"E".$startRow);
       			$objActSheet->setCellValue("F".$startRow,'');
       			$this->position($objActSheet,"F".$startRow);
       			$lastRow = $startRow;
       			$startRow ++;
       		}
       	}  
       	$objActSheet->getStyle('A6:F'.$lastRow)->applyFromArray($styleArray);
       	$count = count($data);
       	if ($data[$count-1]['chs_name'] == '稳定系数'){
       		--$count;
       	}
       	$startRow++;
       	$objActSheet->mergeCells('A'.$startRow.':F'.$startRow);
       	$objActSheet->setCellValue('A'.$startRow,'被测者的'.$count.'种需要倾向按其大小顺序依次排列为: ');
       	$this->position($objActSheet,'A'.$startRow, 'left');
       	$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	$firstRow = $startRow;
       	$startRow++;
       	$objActSheet->mergeCells('A'.$startRow.':F'.($startRow+1));
       	//$this->position($objActSheet,'A'.$startRow, 'left');
       	$objActSheet->getStyle('A'.$startRow)->getAlignment()->setWrapText(true);  
       	$name_array = array();
       	for($i = 0 ; $i <$count ; $i++ ){
       		$name_array[] = $data[$i]['chs_name'];
       	}
       	$name_str = implode(',', $name_array);
       	$name_str .= '。';
       	$objActSheet->setCellValue('A'.$startRow,$name_str);
       	$styleArray = array(
       			'borders' => array(
       					'outline' => array(
       							//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
       							'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
       							//'color' => array('argb' => 'FFFF0000'),
       					),
       			),
       	);
       	$objActSheet->getStyle('A'.$firstRow.':F'.($startRow+1))->applyFromArray($styleArray);
       	
       	
    }
   # 5 SCL
    public function checkoutScl($examinee , $objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);
        $objActSheet->mergeCells('A1:E1');
        $objActSheet->setCellValue('A1','SCL90 测试结果');
        $objActSheet->getStyle('A1')->getFont()->setBold(true);
        $this->position($objActSheet, 'A1');
        $objActSheet->mergeCells('A2:E2');
        $objActSheet->setCellValue('A3','分类号');
        $this->position($objActSheet, 'A3');
        $objActSheet->setCellValue('A4','编号');
        $this->position($objActSheet, 'A4');
        $objActSheet->setCellValue('B4',$examinee->number);
        $this->position($objActSheet, 'B4');
        $objActSheet->setCellValue('A5','姓名');
        $this->position($objActSheet, 'A5');
        $objActSheet->setCellValue('B5',$examinee->name);
        $this->position($objActSheet, 'B5');
        $objActSheet->setCellValue('A6','性别');
        $this->position($objActSheet, 'A6');
        $objActSheet->setCellValue('B6',$examinee->sex == 0 ? '女':'男');
        $this->position($objActSheet, 'B6');
        $objActSheet->setCellValue('A7','年龄');
        $this->position($objActSheet, 'A7');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->setCellValue('B7',$age);
        $this->position($objActSheet, 'B7');
        $objActSheet->setCellValue('A8','日期');
        $this->position($objActSheet, 'A8');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B8',$date);
        $this->position($objActSheet, 'B8');
        $objActSheet->setCellValue('A9','总分');
        $this->position($objActSheet, 'A9');
        $objActSheet->setCellValue('A10','总均分');
        $this->position($objActSheet, 'A10');
        $objActSheet->setCellValue('A11','阴性项目数');
        $this->position($objActSheet, 'A11');
        $objActSheet->setCellValue('A12','阳性项目数');
        $this->position($objActSheet, 'A12');
        $objActSheet->setCellValue('A13','阳性症状均分');
        $this->position($objActSheet, 'A13');
        $styleArray = array(
        		'borders' => array(
        				'allborders' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A3:B13')->applyFromArray($styleArray);
        
        $objActSheet->setCellValue('D3','因子名称');
        $this->position($objActSheet, 'D3');
        $objActSheet->setCellValue('E3','因子分');
        $this->position($objActSheet, 'E3');
        $startRow = 4;
        $data = CheckoutData::getSCLdata($examinee);
        if (empty($data)){
        	return ;
        }
        $lastRow = $startRow;
        foreach ($data as $value ){
        	$objActSheet->setCellValue('D'.$startRow,$value['chs_name']);      
        	$this->position($objActSheet, 'D'.$startRow);
        	$objActSheet->setCellValue('E'.$startRow,$value['std_score']);
        	$this->position($objActSheet, 'E'.$startRow);
        	$lastRow = $startRow;
        	$startRow++;
        }
        $objActSheet->getStyle('D3:E'.$lastRow)->applyFromArray($styleArray);
    }
   # 6 EPQA
    public function checkoutEpqa($examinee,$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $objActSheet->mergeCells('A1:I1');
        $objActSheet->setCellValue('A1','爱克森个性问卷成人 (EPQA) 结果');
        $objActSheet->getStyle('A1')->getFont()->setBold(true);
        $this->position($objActSheet, 'A1');
   	    $objActSheet->setCellValue('A2','分类号');
   	    $this->position($objActSheet, 'A3');
   	    $objActSheet->mergeCells('B2:C2');
        $objActSheet->setCellValue('D2','编号');
        $this->position($objActSheet, 'D2');
        $objActSheet->mergeCells('E2:F2');
        $objActSheet->setCellValue('E2',$examinee->number);
        $this->position($objActSheet, 'E2');
        $objActSheet->setCellValue('G2','姓名');
        $this->position($objActSheet, 'G2');
        $objActSheet->mergeCells('H2:I2');
        $objActSheet->setCellValue('H2',$examinee->name);
        $this->position($objActSheet, 'H2');
        $objActSheet->setCellValue('A3','性别');
        $this->position($objActSheet, 'A3');
        $objActSheet->mergeCells('B3:C3');
        $objActSheet->setCellValue('B3',$examinee->sex == "1" ? "男" : "女");
        $this->position($objActSheet, 'B3');
        $objActSheet->setCellValue('D3','年龄');
        $this->position($objActSheet, 'D3');
        $objActSheet->mergeCells('E3:F3');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $this->position($objActSheet, 'E3');
        $objActSheet->setCellValue('E3',$age);
        $objActSheet->setCellValue('G3','');
        $objActSheet->mergeCells('H3:I3');
        $objActSheet->setCellValue('H3','');
        $objActSheet->setCellValue('A4','日期');
        $this->position($objActSheet, 'A4');
        $objActSheet->mergeCells('B4:I4');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B4',$date);
        $this->position($objActSheet, 'B4', 'left');
        $objActSheet->mergeCells('D4:I4');
        $styleArray = array(
        		'borders' => array(
        				'allborders' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A2:I4')->applyFromArray($styleArray);
        
        $objActSheet->mergeCells('A5:I5');
        $objActSheet->setCellValue('C6','因子名称');
        $this->position($objActSheet, 'C6');
        $objActSheet->setCellValue('D6','代号');
        $this->position($objActSheet, 'D6');
        $objActSheet->setCellValue('E6','原始得分');
        $this->position($objActSheet, 'E6');
        $objActSheet->setCellValue('F6','T分');
        $this->position($objActSheet, 'F6');
        
        $startRow = 7;
      	$data = CheckoutData::getEPQAdata($examinee);
      	if (empty($data)){
      		return ;
      	}
      	$lastRow = $startRow;
      	$tihuan = array(
      			'epqae'=>'E',
      			'epqan'=>'N',
      			'epqap'=>'P',
      			'epqal'=>'L'
      			 
      	);
      	foreach( $data as $value){
      		$objActSheet->setCellValue('C'.$startRow,$value['chs_name']);
      		$this->position($objActSheet, 'C'.$startRow);
      		$objActSheet->setCellValue('D'.$startRow,$tihuan[$value['name']]);
      		$this->position($objActSheet, 'D'.$startRow);
      		$objActSheet->setCellValue('E'.$startRow,$value['score']);
      		$this->position($objActSheet, 'E'.$startRow);
      		$objActSheet->setCellValue('F'.$startRow,$value['std_score']);
      		$this->position($objActSheet, 'F'.$startRow);
      		$lastRow = $startRow;
      		$startRow++;
      	} 
      	$objActSheet->getStyle('C6:F'.$lastRow)->applyFromArray($styleArray);
    }
   # 7 CPI
    public function checkoutCpi($examinee,$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','青年性格问卷（CPI）测试结果');
        $objActSheet->getStyle('A1')->getFont()->setBold(true);
        $this->position($objActSheet, 'A1');
   	    $objActSheet->setCellValue('A2','分类号');
   	    $this->position($objActSheet, 'A2');
   	    $objActSheet->mergeCells('B2:F2');
        $objActSheet->setCellValue('A3','编号');
        $this->position($objActSheet, 'A3');
        $objActSheet->setCellValue('B3',$examinee->number);
        $this->position($objActSheet, 'B3');
        $objActSheet->setCellValue('C3','姓名');
        $this->position($objActSheet, 'C3');
        $objActSheet->setCellValue('D3',$examinee->name);
        $this->position($objActSheet, 'D3');
        $objActSheet->setCellValue('E3','性别');
        $this->position($objActSheet, 'E3');
        $objActSheet->setCellValue('F3',$examinee->sex == "1" ? "男" : "女");
        $this->position($objActSheet, 'F3');
        $objActSheet->setCellValue('A4','年龄');
        $this->position($objActSheet, 'A4');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->setCellValue('B4',$age);
        $this->position($objActSheet, 'B4');
        $objActSheet->setCellValue('C4','职业');
        $this->position($objActSheet, 'C4');
        $objActSheet->setCellValue('D4',$examinee->duty);
        $this->position($objActSheet, 'D4');
        $objActSheet->setCellValue('E4','测试日期');
        $this->position($objActSheet, 'E4');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('F4',$date);
        $this->position($objActSheet, 'F4');
        $styleArray = array(
        		'borders' => array(
        				'allborders' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray);
        
        $objActSheet->mergeCells('A5:F5');
        $objActSheet->setCellValue('A6','因子名称');
        $this->position($objActSheet, 'A6');
        $objActSheet->setCellValue('B6','代号');
        $this->position($objActSheet, 'B6');
        $objActSheet->setCellValue('C6','原始分');
        $this->position($objActSheet, 'C6');
        $objActSheet->setCellValue('D6','T分');
        $this->position($objActSheet, 'D6');
        $styleArray = array(
        		'borders' => array(
        				'outline' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A6:D6')->applyFromArray($styleArray);
        
       	 $data = CheckoutData::getCPIdata($examinee);
       	 if (empty($data)){
       	 	return ;
       	 }
       	 $array1 = array('do','cs','sy','sp','sa','wb');
       	 $array2 = array('re','so','sc','po','gi','cm');
       	 $array3 = array('ac','ai','ie');
       	 $array4 = array('py','fx','fe');
       	 
       	 $objActSheet->mergeCells("A7:D7");
       	 $objActSheet->setCellValue('A7', '第一类  人际关系适应能力的测验');
       	 $objActSheet->getStyle('A7')->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A7','left');
       	 $startRow = 7;
       	 $lastRow = $startRow;
       	 foreach ($array1 as $value ){
       	 	if (isset($data[$value])){
       	 		
       	 		$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('A'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'A'.$startRow);
       	 		$objActSheet->setCellValue('B'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 	}
       	 }
       	 
       	 $objActSheet->getStyle('A7:D'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $firstRow = $startRow;
       	 $lastRow = $startRow;
       	 $objActSheet->mergeCells('A'.$startRow.':D'.$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '第二类  社会化、成熟度、责任心及价值观念的测验');
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A'.$startRow, 'left');
       	 foreach ($array2 as $value ){
       	 	if (isset($data[$value])){
       	 	
       	 		$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('A'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'A'.$startRow);
       	 		$objActSheet->setCellValue('B'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 	}
       	 }
       	 $objActSheet->getStyle('A'.$firstRow.':D'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $firstRow = $startRow;
       	 $lastRow = $startRow;
       	 $objActSheet->mergeCells("A".$startRow.":D".$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '第三类  成就能力与智能效率的测验');
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A'.$startRow, 'left');
       	 
       	 foreach ($array3 as $value ){
       	 	if (isset($data[$value])){
       	 		
       	 		$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('A'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'A'.$startRow);
       	 		$objActSheet->setCellValue('B'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 	}
       	 }
       	 $objActSheet->getStyle('A'.$firstRow.':D'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $firstRow = $startRow;
       	 $lastRow = $startRow;
       	 $objActSheet->mergeCells("A".$startRow.":D".$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '第四类  个人的生活态度与倾向的测验');
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A'.$startRow, 'left');
       	 foreach ($array4 as $value ){
       	 	if (isset($data[$value])){
       	 		
       	 		$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('A'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'A'.$startRow);
       	 		$objActSheet->setCellValue('B'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 	}
       	 }
       	 $objActSheet->getStyle('A'.$firstRow.':D'.$lastRow)->applyFromArray($styleArray);
       	 
    }
   # 8 SPM 
    public function checkoutSpm($examinee, $objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','SPM瑞文标准推理测验结果');
        $objActSheet->getStyle('A1')->getFont()->setBold(true);
        $this->position($objActSheet,'A1');
   	    $objActSheet->setCellValue('A2','分类号');
   	    $this->position($objActSheet,'A2');
   	    $objActSheet->mergeCells('B2:F2');
        $objActSheet->setCellValue('A3','编号');
        $this->position($objActSheet,'A3');
        $objActSheet->setCellValue('B3',$examinee->number);
        $this->position($objActSheet,'B3');
        $objActSheet->setCellValue('C3','姓名');
        $this->position($objActSheet,'C3');
        $objActSheet->setCellValue('D3',$examinee->name);
        $this->position($objActSheet,'D3');
        $objActSheet->setCellValue('E3','性别');
        $this->position($objActSheet,'E3');
        $objActSheet->setCellValue('F3',$examinee->sex == "1" ? "男" : "女");
        $this->position($objActSheet,'F3');
        $objActSheet->setCellValue('A4','年龄');
        $this->position($objActSheet,'A4');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $objActSheet->setCellValue('B4',$age);
        $this->position($objActSheet,'B4');
        $objActSheet->setCellValue('C4','测试日期');
        $this->position($objActSheet,'C4');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('D4',$date);
        $this->position($objActSheet,'D4');
        $styleArray = array(
        		'borders' => array(
        				'outline' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A2:F4')->applyFromArray($styleArray);
        $objActSheet->getStyle('A6:F9')->applyFromArray($styleArray);
        $objActSheet->mergeCells('A5:F5');
        
        $objActSheet->setCellValue('A6','总分');
        $this->position($objActSheet,'A6');
        $objActSheet->setCellValue('C6','百分等级');
        $this->position($objActSheet,'C6');
        $objActSheet->setCellValue('E6','智力等级');
        $this->position($objActSheet,'E6');
        $objActSheet->setCellValue('A7','评定结果');
        $this->position($objActSheet,'A7');
        $objActSheet->mergeCells('B7:F7');
        $objActSheet->setCellValue('A8','部分');
        $this->position($objActSheet,'A8');
        $objActSheet->setCellValue('B8','A类');
        $this->position($objActSheet,'B8');
        $objActSheet->setCellValue('C8','B类');
        $this->position($objActSheet,'C8');
        $objActSheet->setCellValue('D8','C类');
        $this->position($objActSheet,'D8');
        $objActSheet->setCellValue('E8','D类');
        $this->position($objActSheet,'E8');
        $objActSheet->setCellValue('F8','E类');
        $this->position($objActSheet,'F8');
        $objActSheet->setCellValue('A9','得分');
        $this->position($objActSheet,'A9');
        $spmArray = array('spma','spmb','spmc','spmd','spme');
        $spmPos = array('B','C','D','E','F');
        $data = CheckoutData::getSPMdata($examinee);
        if (empty($data)){
        	return ;
        }
        $dengji = array(1=>'一级',2=>'二级',3=>'三级',4=>'四级',5=>'五级');
		if (isset($data['spm'])){
			$str = $data['spm']['std_score'];
			$zhili = substr($str, 0,1);
			$objActSheet->setCellValue('F6',$zhili);
			$this->position($objActSheet,'F6');
			$baifen = substr($str, 1);
			$objActSheet->setCellValue('D6',$baifen);
			$this->position($objActSheet,'D6');
			if(isset($dengji[$zhili])){
				$objActSheet->setCellValue('B7',$dengji[$zhili]);
				$this->position($objActSheet,'B7','left');
			}
		}
		$sum = 0;
        foreach($spmArray as $key => $value ){
        	if (isset($data[$value])) {
        		$objActSheet->setCellValue($spmPos[$key].'9',$data[$value]['std_score']);
        		$this->position($objActSheet,$spmPos[$key].'9');
        		$sum += $data[$value]['std_score'];
        	}
        }
        $objActSheet->setCellValue('B6',$sum);
        $this->position($objActSheet,'B6');
    }
   # 9. 8+5 表
    public function checkoutEightAddFive($examinee,$objActSheet){
        $strong = array(
            '【强项指标1】【最优】','【强项指标2】【次优】','【强项指标3】【三优】','【强项指标4】【四优】','【强项指标5】【五优】','【强项指标6】【六优】','【强项指标7】【七优】','【强项指标8】【八优】'
        );
        $weak = array(
            '【弱项指标1】【最弱】','【弱项指标2】【次弱】','【弱项指标3】【三弱】','【弱项指标4】【四弱】','【弱项指标5】【五弱】'
        );
        $checkout = new CheckoutData();
        $eightAddFive = $checkout->getEightAddFive($examinee);
        $objActSheet->getColumnDimension('A')->setWidth(25);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(15);
        $objActSheet->getColumnDimension('D')->setWidth(15);
        $objActSheet->getColumnDimension('E')->setWidth(15);
        //settings
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
        $objActSheet->mergeCells('A1:E1');
        $objActSheet->setCellValue('A1','TQT人才测评系统    28指标排序（8+5）');
        $objActSheet->getStyle('A1')->getFont()->setBold(true);
        $this->position($objActSheet,'A1');
        $objActSheet->setCellValue('A2','编号');
        $this->position($objActSheet,'A2');
        $objActSheet->setCellValue('B2',$examinee->number);
        $this->position($objActSheet,'B2');
        $objActSheet->setCellValue('C2','姓名');
        $this->position($objActSheet,'C2');
        $objActSheet->mergeCells('D2:E2');
        $objActSheet->setCellValue('D2',$examinee->name);
        $this->position($objActSheet,'D2');
        $objActSheet->mergeCells('A3:E3');
        
        $objActSheet->setCellValue('B4','组合因素');
        $objActSheet->getStyle('B4')->getFont()->setBold(true);
        $this->position($objActSheet,'B4');
        $objActSheet->setCellValue('C4','原始分');
        $objActSheet->getStyle('C4')->getFont()->setBold(true);
        $this->position($objActSheet,'C4');
        $objActSheet->setCellValue('D4','综合分');
        $objActSheet->getStyle('D4')->getFont()->setBold(true);
        $this->position($objActSheet,'D4');
        $objActSheet->setCellValue('E4','评价结果');
        $objActSheet->getStyle('E4')->getFont()->setBold(true);
        $this->position($objActSheet,'E4');
        $startRow = 5;
        $styleArray = array(
        		'borders' => array(
        				'outline' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        
        if (isset($eightAddFive['strong'])){
        	$i = 0;
        	foreach($eightAddFive['strong'] as $eight ){
        		 $firstRow = $startRow;
        		 $lastRow = $startRow;
        		 $objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
        		 $objActSheet->setCellValue('A'.$startRow,$strong[$i]);
        		 $this->position($objActSheet,'A'.$startRow,'left');
        		 $startRow++;
        		 $objActSheet->setCellValue('A'.$startRow,$eight['chs_name']);
        		 $this->position($objActSheet,'A'.$startRow,'left');
        		 $objActSheet->setCellValue('A'.($startRow+1),$eight['count']);
        		 $this->position($objActSheet,'A'.($startRow+1),'left');
        		 foreach ($eight['children'] as $svalue ){
        		 	$objActSheet->setCellValue('B'.$startRow,$svalue['name']);
        		 	$this->position($objActSheet,'B'.$startRow);
        		 	$objActSheet->setCellValue('C'.$startRow,$svalue['raw_score']);
        		 	$this->position($objActSheet,'C'.$startRow);
        		 	$objActSheet->setCellValue('D'.$startRow,$svalue['ans_score']);
        		 	$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
        		 	$this->position($objActSheet,'D'.$startRow);
        		 	$objActSheet->setCellValue('E'.$startRow,$svalue['number']);
        		 	$this->position($objActSheet,'E'.$startRow);
        		 	$lastRow = $startRow;
        		 	$startRow++;
        		 }
        		 $objActSheet->getStyle('A'.$firstRow.':E'.$lastRow)->applyFromArray($styleArray);
        	$i++;
        	}
        	$startRow++;
        }
        if (isset($eightAddFive['weak'])){
        	$i = 0;
        	foreach($eightAddFive['weak'] as $eight ){
        		$firstRow = $startRow;
        		$lastRow = $startRow;
        		$objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
        		$objActSheet->setCellValue('A'.$startRow,$weak[$i]);
        		$this->position($objActSheet,'A'.$startRow,'left');
        		$startRow++;
        	 	$objActSheet->setCellValue('A'.$startRow,$eight['chs_name']);
        		$this->position($objActSheet,'A'.$startRow,'left');
        		$objActSheet->setCellValue('A'.($startRow+1),$eight['count']);
        		$this->position($objActSheet,'A'.($startRow+1),'left');
        		foreach ($eight['children'] as $svalue ){
        		 	$objActSheet->setCellValue('B'.$startRow,$svalue['name']);
        		 	$this->position($objActSheet,'B'.$startRow);
        		 	$objActSheet->setCellValue('C'.$startRow,$svalue['raw_score']);
        		 	$this->position($objActSheet,'C'.$startRow);
        		 	$objActSheet->setCellValue('D'.$startRow,$svalue['ans_score']);
        		 	$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
        		 	$this->position($objActSheet,'D'.$startRow);
        		 	$objActSheet->setCellValue('E'.$startRow,$svalue['number']);
        		 	$this->position($objActSheet,'E'.$startRow);
        		 	$lastRow = $startRow;
        		 	$startRow++;
        		}
        		$objActSheet->getStyle('A'.$firstRow.':E'.$lastRow)->applyFromArray($styleArray);
        		$i++;
        	}
        	$startRow++;
        }
    }
    #10 结构
    public function checkoutModuleResult($examinee,$objActSheet){
    	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
		$objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(20);
        $objActSheet->getColumnDimension('D')->setWidth(20);
        $data = new CheckoutData();
        $result = $data->getindividualComprehensive($examinee->id);
        $name_array = array('一','二','三','四');
        if (empty($result)){
        	return ;
        }
        $startRow = 1;
        $i = 0;
        foreach ($result as $module_name =>$module_detail ){
        		$objActSheet->mergeCells('A'.$startRow.":D".$startRow);
        		$objActSheet->setCellValue('A'.$startRow, $name_array[$i++].'、'.$module_name.'评价指标');
        		$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
        		$this->position($objActSheet,'A'.$startRow);
        		$startRow++;
				$objActSheet->setCellValue('A'.$startRow,'评价指标');
				$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
				$this->position($objActSheet,'A'.$startRow);
				$objActSheet->setCellValue('B'.$startRow,'组合因素（项）');
				$objActSheet->getStyle('B'.$startRow)->getFont()->setBold(true);
				$this->position($objActSheet,'B'.$startRow);
				$objActSheet->setCellValue('C'.$startRow,'综合分');
				$objActSheet->getStyle('C'.$startRow)->getFont()->setBold(true);
				$this->position($objActSheet,'C'.$startRow);
				$objActSheet->setCellValue('D'.$startRow,'评价结果');
				$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
				$this->position($objActSheet,'D'.$startRow);
       			$inner_count = count($module_detail);
       			$startRow++;
       			$objActSheet->mergeCells('A'.$startRow.":D".$startRow);
       			$objActSheet->getStyle('A'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
       			$objActSheet->getStyle('A'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');	
       			$startRow++;
        		for($loop_i = 0; $loop_i < $inner_count; $loop_i ++ ){
        			$objActSheet->setCellValue('A'.$startRow,$module_detail[$loop_i]['chs_name']);
        			$this->position($objActSheet,'A'.$startRow);
        			$objActSheet->setCellValue('B'.$startRow, count(explode(',',$module_detail[$loop_i]['children'])));
        			$this->position($objActSheet,'B'.$startRow);
        			$objActSheet->setCellValue('C'.$startRow,$module_detail[$loop_i]['score']);
        			$this->position($objActSheet,'C'.$startRow);
        			$objActSheet->setCellValue('D'.$startRow,'');
        			$startRow++;
        		}
        		$objActSheet->mergeCells('A'.$startRow.":D".$startRow);
        		$objActSheet->getStyle('A'.$startRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        		$objActSheet->getStyle('A'.$startRow)->getFill()->getStartColor()->setARGB('FFA9A9A9');	
        		$startRow++;
        }
    }


}