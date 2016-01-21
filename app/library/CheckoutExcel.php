<?php
	use PhpOffice\PhpWord\PhpWord;
/**
	 * @usage 十项报表数据统计
	 *
	 */
require_once("../app/classes/PHPExcel.php");

class CheckoutExcel extends \Phalcon\Mvc\Controller{

    public function excelExport($examinee){
        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
        $objPHPExcel = new PHPExcel();
        set_time_limit(0);
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
        $this->checkoutEpqa($examinee, $objActSheet);
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
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $file_name = './tmp/'.$examinee->id.'_checkout.xlsx';
        $objWriter->save($file_name);
        return $file_name;
    }
    public function position($objActSheet, $pos, $h_align='center'){
    	$objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
    	$objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$objActSheet->getStyle($pos.':'.$pos)->getAlignment()->setWrapText(true);
    }
    
    //导出个人信息
    public function checkoutPerson(&$examinee,&$objActSheet){
    	$objActSheet->getDefaultRowDimension()->setRowHeight(21);
    	$objActSheet->getDefaultColumnDimension()->setWidth(7);
    	$objActSheet->mergeCells('A1:L1');
    	$objActSheet->getColumnDimension('L')->setWidth(9);
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
    public function checkoutIndex(&$examinee,&$objActSheet){
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
    public function checkout16pf(&$examinee, &$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
    	$objActSheet->getColumnDimension('A')->setWidth(11);
        $objActSheet->getColumnDimension('B')->setWidth(7);
        $objActSheet->getColumnDimension('C')->setWidth(8);
        $objActSheet->getColumnDimension('D')->setWidth(19);
        $objActSheet->getColumnDimension('E')->setWidth(2);
        $objActSheet->getColumnDimension('F')->setWidth(2);
        $objActSheet->getColumnDimension('G')->setWidth(2);
        $objActSheet->getColumnDimension('H')->setWidth(2);
        $objActSheet->getColumnDimension('I')->setWidth(2);
        $objActSheet->getColumnDimension('J')->setWidth(2);
        $objActSheet->getColumnDimension('K')->setWidth(2);
        $objActSheet->getColumnDimension('L')->setWidth(2);
        $objActSheet->getColumnDimension('M')->setWidth(2);
        $objActSheet->getColumnDimension('N')->setWidth(2.8);
        $objActSheet->getColumnDimension('O')->setWidth(21);
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
        
//         $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
//         $startRow++;
//         $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
//         $startRow++;
//         $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
//         //edit bruce_w 2015-12-9 分页打印
//       	$startRow+=8;
        
        $firstRow = $startRow;
        $objActSheet->mergeCells('A'.$startRow.':O'.$startRow);
        $objActSheet->setCellValue('A'.$startRow,'次级因素计算结果及其简要解释');
        $this->position($objActSheet, 'A'.$startRow, 'left');
        $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
        $startRow++;
        $objActSheet->mergeCells('A'.$startRow.':B'.$startRow);
        $objActSheet->setCellValue('A'.$startRow,'因素名称');
        $this->position($objActSheet, 'A'.$startRow);
        $objActSheet->setCellValue('C'.$startRow,'代号');
        $this->position($objActSheet, 'C'.$startRow);
        $objActSheet->setCellValue('D'.$startRow,'原始分');
        $this->position($objActSheet, 'D'.$startRow);
        $objActSheet->mergeCells('E'.$startRow.':J'.$startRow);
        $objActSheet->setCellValue('E'.$startRow,'标准分');
        $this->position($objActSheet, 'E'.$startRow);
        $objActSheet->mergeCells('K'.$startRow.':O'.$startRow);
        $objActSheet->setCellValue('K'.$startRow,'简要解释');
        $this->position($objActSheet, 'K'.$startRow);
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
        		$objActSheet->mergeCells('E'.$startRow.':J'.$startRow);
        		if ($key == 'Y3'){
        			$objActSheet->setCellValue('E'.$startRow,$value['std_score']);
        			$this->position($objActSheet, 'E'.$startRow);
        		}else{
        			$objActSheet->setCellValue('E'.$startRow,'');
        		}
        		//edit brucew 2015-12-5 添加次级因子说明
        		$pingyu_array = array(
        			'X1' => array('焦虑,常感到不满意','一般','生活适应顺利'),
        			'X2' => array('外倾开朗,善于交际','中间','内倾胆小,克制性强'),
        			'X3' => array('富事业心,果断刚毅','中间','情感丰富,含蓄敏感'),
        			'X4' => array('独立果断,有气魄','中间','依赖别人,个性被动'),
        			'Y1' => array('情绪稳定,心理健康','一般','紧张,心理不甚健康'),
        			'Y2' => array('责任心强,精明果断','一般','缺乏恒心,随群附众'),	
        			'Y3' => array('聪明敢为,好强固执','一般','思维迟钝,保守世故'),
        			'Y4' => array('富有才识,自律谨严','一般','学识浅,克制力差')         				
        		);
        		$objActSheet->mergeCells('K'.$startRow.':O'.$startRow);
        		$this->position($objActSheet, 'K'.$startRow);   		
        		if($key == 'X1' || $key == 'X2' || $key == 'X3' || $key == 'X4') {
        			if($value['score'] > 7 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][0]);
        			}else if ( $value['score'] < 4 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][2]);
        			}else{
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][1]);
        			}
        		}else if ( $key == 'Y1' ){
        			if($value['score'] > 32 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][0]);
        			}else if ( $value['score'] < 12 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][2]);
        			}else{
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][1]);
        			}
        		}else if ( $key == 'Y2' ){
        			if($value['score'] > 67 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][0]);
        			}else if ( $value['score'] < 30 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][2]);
        			}else{
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][1]);
        			}
        			
        		}else if ( $key == 'Y3' ){
        			if($value['std_score'] > 7 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][0]);
        			}else if ( $value['std_score'] < 4 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][2]);
        			}else{
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][1]);
        			}
        			
        		}else {
        			if($value['score'] > 27 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][0]);
        			}else if ( $value['score'] < 17 ){
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][2]);
        			}else{
        				$objActSheet->setCellValue('K'.$startRow,$pingyu_array[$key][1]);
        			}
        		}
        		$lastRow = $startRow;
        		$startRow++;
        	}
        }
        $objActSheet->getStyle('A'.$firstRow.':O'.$lastRow)->applyFromArray($styleArray);       
        
    }
   # 4 EPPS
    public function checkoutEpps(&$examinee,&$objActSheet){
        $objActSheet->getDefaultColumnDimension()->setWidth(12);
        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
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
        $objActSheet->getStyle('A6')->getFont()->setBold(true);
        $objActSheet->setCellValue("B6","得分");   
        $this->position($objActSheet,'B6');
        $objActSheet->getStyle('B6')->getFont()->setBold(true);
        $objActSheet->setCellValue("C6","得分排序");
        $this->position($objActSheet,'C6');
        $objActSheet->getStyle('C6')->getFont()->setBold(true);
        $objActSheet->setCellValue("D6","测试项目");
        $this->position($objActSheet,'D6');
        $objActSheet->getStyle('D6')->getFont()->setBold(true);
        $objActSheet->setCellValue("E6","得分");
        $this->position($objActSheet,'E6');
        $objActSheet->getStyle('E6')->getFont()->setBold(true);
        $objActSheet->setCellValue("F6","得分排序");
        $this->position($objActSheet,'F6');
        $objActSheet->getStyle('F6')->getFont()->setBold(true);
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
//        	$startRow++;
       	$objActSheet->mergeCells('A'.$startRow.':F'.$startRow);
       	$objActSheet->setCellValue('A'.$startRow,'被测者的'.$count.'种需要倾向按其大小顺序依次排列为: ');
       	$this->position($objActSheet,'A'.$startRow, 'left');
       	$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	$firstRow = $startRow;
       	$startRow++;
       	$objActSheet->mergeCells('A'.$startRow.':F'.($startRow+1));
       	$this->position($objActSheet,'A'.$startRow,'left');
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
       	$startRow+=2;
//        	$startRow++;
//        	//edit bruce_w 2015-12-9 分页打印
//        	$startRow+=14;
       	$objActSheet->mergeCells('A'.$startRow.':F'.$startRow);
       	$objActSheet->setCellValue('A'.$startRow,'被测者的主要特点是: ');
       	$this->position($objActSheet,'A'.$startRow, 'left');
       	$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	$firstRow = $startRow;
       	$startRow++;
       	//取前五因子写下其特点
       	$flag = 0; 
       	$lastRow = $startRow;
       	$pingyu_array = array(
       		"成就需要"=>"办事成功感高，喜欢克服困难，努力完成任务，希望成为本行业的权威。乐于做有重大意义的事，在有竞争的情况下，总想取得优胜。",
       		"顺从需要"=>"较易受别人的暗示，乐于依从他人的指示和期望行事，对别人的观点较易附和、尊从，喜欢赞扬别人，乐于接受别人的领导，易于遵从世俗的要求。",
       		"秩序需要"=>"办事喜欢具有有组织性，在进行工作之前要详细计划，使得整个事情井然有序，喜欢依据一定的系统或模式做事，定时定量进餐和进行其他的活动，小心谨慎。",
       		"表现需要"=>"做事时常常想突出自己，以引起别人的注意和重视，说话、做事有时仅仅是为了引起别人对自己成就的重视，想成为注意的中心，希望别人迷恋、崇拜自己。",
       		"自主需要"=>"喜欢随心所欲，不受别人的影响，追求独立和自由，自己的事情自己决定办。避免遵从他人的观点，他们不愿意隶属于某些人或组织之下，避开责任和任务。",
       		"亲和需要"=>"乐于结交朋友，为朋友做事情，对朋友忠诚不二，尊重朋友和他人，遇事乐于与朋友合作，不乐于单独去做，与朋友有福同享，有难同当，喜欢与朋友保持密切的联系。",
       		"省察需要"=>"平时喜欢分析自己的言行， 反省自己的是非， 较善于观察别人，了解别人的感受，能设身处地为别人着想，经常依据别人的动机来判断别人、分析别人，观察力较高，可以预示别人的行动。",
       		"求助需要"=>"每当自己陷入困扰之中时，总是希望能得到别人的帮助、支持，希望别人能够时常地关怀自己，经常从别人那里寻求鼓励，当自己遇到不幸时希望能及时得到别人的同情、安慰。",
       		"支配需要"=>"想成为所在团体的领导者，被人视为领袖；在团体中乐于指导或领导他人，并且想监督他人的行动；力图控制别人，让别人受他的影响，按他的要求去做。",
       		"谦卑需要"=>"经常为做错某事而感到内疚；当受到指责时，认为自己应忍受痛苦，不应伤害他人，认为错了就应该受到惩罚；遇事不与人争执而常常屈从；在不适应的情境下沮丧；在优胜者面前自觉胆怯。",
       		"慈善需要"=>"富于同情心，在困难之中帮助不幸的人；以仁慈待人，宽恕旁人，对别人较为慷概；对于有伤病的人，在感情和行动上给以很大的帮助。",
       		"变异需要"=>"喜欢新的事物，乐于经常从事新而又难的工作；喜欢经历新奇与变化，经常尝试新的方法；追求新的时尚，好赶时髦。",
       		"持久需要"=>"办事喜欢从头到尾，从不半途而废，能够坚持到底；对于指定的任务能全力以赴，执着地去解决，直到完成全部任务以后才罢休；能长时间不分心地工作，不受周围地干扰。",
       		"异性恋需要"=>"乐于与异性一同参加各种活动；喜欢与异性接近，并可能想与之恋爱；参与有关性问题的讨论，阅读有关性方面的书籍。",
       		"攻击需要"=>"对与自己相反的意见好主动出击，公开地批评他人，告诉别人自己的看法；好开别人的玩笑；当自己与别人不和时，则离去；受辱以后处处要报复；容易因小事而发怒。"	
       	);
       	for($i = 0; $i < $count; $i ++ ){
       		$flag ++; 
      		//每个因子合并三行
       		$objActSheet->mergeCells('A'.$startRow.':F'.($startRow+2));
       		$objActSheet->setCellValue('A'.$startRow, $pingyu_array[$data[$i]['chs_name']]);
       		$this->position($objActSheet,'A'.$startRow,'left');
       		$objActSheet->getStyle('A'.$startRow)->getAlignment()->setWrapText(true);
       		$startRow+=2;
       		$lastRow = $startRow;
       		$startRow ++;
       		if( $flag == 5 ){
       			break;
       		}
       	}
       	$objActSheet->getStyle('A'.$firstRow.':F'.$lastRow)->applyFromArray($styleArray);
       	
       	
       	
       	
    }
   # 5 SCL
    public function checkoutScl(&$examinee , &$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
        $objActSheet->getDefaultColumnDimension()->setWidth(15);
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
        // 添加总分与隐形项目数统计
        //获取个人的SCL试卷答案统计
        $scl_paper_id = Paper::findFirst( array( "name = ?1", 'bind' => array(1=>"SCL")))->id;
        $scl_question_ans = QuestionAns::findFirst(array("paper_id = ?1 AND examinee_id = ?2", 'bind'=>array(1=>$scl_paper_id, 2=>$examinee->id)));
        $scl_score_str = $scl_question_ans->score;
        $scl_score_arr = explode('|', $scl_score_str);
        $yinxing_count = 0;
        $scl_total_score = 0;
        foreach($scl_score_arr as $value ){
        	if ($value != 1 ){
        		$yinxing_count++;
        	}
        	$scl_total_score+=$value;
        }
        $objActSheet->setCellValue('A9','总分');
        $this->position($objActSheet, 'A9');
        $objActSheet->setCellValue('B9',$scl_total_score);
        $this->position($objActSheet, 'B9');
        $objActSheet->setCellValue('A10','总均分');
        $this->position($objActSheet, 'A10');
        $objActSheet->setCellValue('A11','阴性项目数');
        $this->position($objActSheet, 'A11');
        $objActSheet->setCellValue('B11',$yinxing_count);
        $this->position($objActSheet, 'B11');
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
        	$objActSheet->setCellValue('E'.$startRow,sprintf("%.2f",$value['std_score']));
        	$this->position($objActSheet, 'E'.$startRow);
        	$lastRow = $startRow;
        	$startRow++;
        }
        $objActSheet->getStyle('D3:E'.$lastRow)->applyFromArray($styleArray);
        
        $startRow++;
//         $startRow++;
//         //edit bruce_w 2015-12-9 分页打印
//         $startRow+=19;
        $objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
        $objActSheet->setCellValue('A'.$startRow,'SCL-90测试结果解释 ');
        $this->position($objActSheet,'A'.$startRow);
        $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
        $firstRow = $startRow;
        $startRow++;
        //取所有因子写下其特点
        $flag = 0;
        $lastRow = $startRow;
        $pingyu_array = array(
        		"躯体化"=>"该因子主要反映主观的身体不适感，包括心血管、肠胃道、呼吸道系统主诉不适和头痛、脊痛、肌肉酸痛、以及焦虑的其他躯体表现。",
        		"强迫症状"=>"该因子主要指那种明知没有必要，但又无法摆脱的无意义的思想、冲动、行为等表现，还有一些比较一般的感知障碍(如脑子变空了，“记忆力不行”等)也在这一因子中反映。",
        		"人际关系敏感"=>"该因子主要是反映某些个人不自在感与自卑感，尤其是在与其他人相比较时更为突出。自卑感、懊丧、以及在人事关系明显相处不好的人，往往这一因子得高分。",
        		"忧郁"=>"反映的是临床上忧郁症状群相联系的广泛的概念。忧郁苦闷的感情和心境是代表性症状，它还以对生活的兴趣减退，缺乏活动的愿望、丧失活动力等为特征，并包括失望、悲叹、与忧郁相联系的其它感知及躯体方面的问题。",
        		"焦虑"=>"包括一些通常临床上明显与焦虑症状相联系的症状与体验。一般指那些无法静息、神经过敏、紧张、以及由此产生躯体征象 (如震颤) 。那种游离不定的焦虑及惊恐发作是本因子的主要内容，它还包括有一个反映“解体”的项目。",
        		"敌对"=>"主要以三方面来反映病人的敌对表现、思想、感情及行为。包括从厌烦、争论、摔物、直至争斗和不可抑制的冲动暴发等各个方面。",
        		"恐怖"=>"与传统的恐怖状态所反映的内容基本一致，恐惧的对象包括出门旅行，空旷场地、人群、或公共场合及交通工具。此外还有反映社交恐怖的项目。",
        		"偏执"=>"偏执是一个十分复杂的概念，本因子只是包括了它的一些基本内容，主要是指思维方面，  如投射性思维，敌对、猜疑、关系妄想、忘想、被动体验和夸大等。",
        		"精神病性"=>"其中有幻想、思维播散、被控制感、思维被插入等反映精神分裂症择定状项目。",
        		"其它"=>"该因子是反映睡眠及饮食情况的。"
         );
        foreach ($data as $value ){
        	
        	//每个因子合并三行
        	$objActSheet->mergeCells('A'.$startRow.':E'.($startRow+2));
        	$objActSheet->setCellValue('A'.$startRow, $pingyu_array[$value['chs_name']]);
        	$this->position($objActSheet,'A'.$startRow,'left');
        	$objActSheet->getStyle('A'.$startRow)->getAlignment()->setWrapText(true);
        	$startRow+=2;
        	$lastRow = $startRow;
        	$startRow ++;
        }        
        $objActSheet->getStyle('A'.$firstRow.':E'.$lastRow)->applyFromArray($styleArray);
    }
   # 6 EPQA
    public function checkoutEpqa(&$examinee,&$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
        $objActSheet->getDefaultColumnDimension()->setWidth(10);
        $objActSheet->mergeCells('A1:H1');
        $objActSheet->setCellValue('A1','爱克森个性问卷成人 (EPQA) 结果');
        $objActSheet->getStyle('A1')->getFont()->setBold(true);
        $this->position($objActSheet, 'A1');
   	    $objActSheet->setCellValue('A2','分类号');
   	    $this->position($objActSheet, 'A2');
   	   // $objActSheet->mergeCells('B2:C2');
        $objActSheet->setCellValue('C2','编号');
        $this->position($objActSheet, 'C2');
        $objActSheet->mergeCells('D2:E2');
        $objActSheet->setCellValue('D2',$examinee->number);
        $this->position($objActSheet, 'D2');
        $objActSheet->setCellValue('F2','姓名');
        $this->position($objActSheet, 'F2');
        $objActSheet->mergeCells('G2:H2');
        $objActSheet->setCellValue('G2',$examinee->name);
        $this->position($objActSheet, 'G2');
        $objActSheet->setCellValue('A3','性别');
        $this->position($objActSheet, 'A3');
       //$objActSheet->mergeCells('B3:C3');
        $objActSheet->setCellValue('B3',$examinee->sex == "1" ? "男" : "女");
        $this->position($objActSheet, 'B3');
        $objActSheet->setCellValue('C3','年龄');
        $this->position($objActSheet, 'C3');
        $objActSheet->mergeCells('D3:E3');
        $age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
        $this->position($objActSheet, 'D3');
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('F3','');
        $objActSheet->mergeCells('G3:H3');
        $objActSheet->setCellValue('G3','');
        $objActSheet->setCellValue('A4','日期');
        $this->position($objActSheet, 'A4');
        $objActSheet->mergeCells('B4:H4');
        $date  = explode(' ',$examinee->last_login)[0];
        $objActSheet->setCellValue('B4',$date);
        $this->position($objActSheet, 'B4', 'left');
        $objActSheet->mergeCells('D4:H4');
        $styleArray = array(
        		'borders' => array(
        				'allborders' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A2:H4')->applyFromArray($styleArray);
        
        $objActSheet->mergeCells('A5:H5');
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
      	$startRow++;
      	$objActSheet->mergeCells('A'.$startRow.':H'.$startRow);
      	$objActSheet->setCellValue('A'.$startRow,' 爱森克个性问卷(成人)(EPQA)各因子的含义 ');
      	$this->position($objActSheet,'A'.$startRow, 'left');
      	$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
      	$firstRow = $startRow;
      	$startRow++;
      	$flag = 0;
      	$lastRow = $startRow;
      	$pingyu_array = array(
      			    "内外向"=>"内外向 (E)：分数特高的特点是个性外向，爱交际，喜参加联欢会，朋友多，需要有人同他谈话，不爱一人阅读和作研究，渴望兴奋的事，喜冒险，向外发展，行动受一时冲动影响。喜实际的工作，回答问题迅速，漫不经心，随和，乐观，喜欢谈笑，宁愿动而不愿静，倾向进攻。总的说来是情绪失控制的人，不是一个很踏实的人。分数特低的特点是安静，离群，内省，喜爱读书而不喜欢接触人。保守，与人保持一定距离（除非挚友），倾向于事前有计划，做事关前顾后，不凭一时冲动。不喜欢兴奋的事，日常生活有规律，严谨。很少进攻行为，多少有些悲观。踏实可靠。价值观念是以伦理做标准。",
      			    "神经质"=>"神经质 (N)：分数特高的特点是情绪不稳，焦虑，紧张，易怒，往往又有抑郁。睡眠不好，患有各种心身障碍。情绪过分，对各种刺激的反应都过于强烈，情绪激发后又很难平复下来。由于强烈的情绪反应而影响了他的正常适应。不可理喻，甚至有时走上危险道路。在与外向结合时，这种人是容易冒火的和不休息的，以至激动，进攻。概括地说，是一个紧张的人，好抱偏见，以至错误。分数特低的特点是倾向于情绪反应缓慢，弱，即使激起了情绪也很快平复下来。通常是平静的，即使生点气也是有节制的，并且不紧张。",							
    				"精神质"=>"精神质 (P)：分数高的成人的特点是独身，不关心人，常有些麻烦，在哪里都不合适。可能是残忍的，不人道的，缺乏同情心，感觉迟钝。对人抱敌意，即令是对亲友也如此。进攻，即使是喜爱的人。喜欢一些古怪的不平常的事情，不惧安危，喜恶作剧，总要捣乱。",						
    			    "掩饰性"=>"掩饰性 (L)：测定被试的“掩饰”倾向，即不真实的回答。同时也有测量被试的纯朴性的作用。它没有划分有无掩饰的确切标准，要看所测样本的一般水平以及被试的年龄。一般来说，成人的L分因年龄而升高，儿童则因年龄而减低。"							
      			);      	

      	foreach( $data as $value){
      		//每个因子合并三行 
      		$next_plus = 0;
      		if($value['chs_name'] == "内外向" ){
      			$next_plus = 7;
      		}else if ( $value['chs_name'] == "神经质" ){
      			$next_plus = 6;
      		}else if  ( $value['chs_name'] == "精神质" ) {
      			$next_plus = 3;
      		}else {
      			$next_plus = 3;
      		}
      		$objActSheet->mergeCells('A'.$startRow.':H'.($startRow+$next_plus));   		
      		$objActSheet->setCellValue('A'.$startRow, $pingyu_array[$value['chs_name']]);
      		$this->position($objActSheet,'A'.$startRow,'left');
      		$objActSheet->getStyle('A'.$startRow)->getAlignment()->setWrapText(true);
      		$startRow+=$next_plus;
      		$lastRow = $startRow;
      		$startRow ++;
      	}
      	
      	$string = "以上所列特点是极端例子，实际上很少有如此典型的人，大多是两极端之间，不过是倾向某一端而已。在解释时应注意，正常人也具有神经质和精神质，高级神经的活动如果在不利因素影响下向病理方面发展，神经质可以发展成神经症，精神质可以发展成精神病。因此，神经质和精神质并不是病理的，不过有些精神病和罪犯是在前者的基础上发展来的。";							
      	$firstRow = $startRow;
      	$objActSheet->mergeCells('A'.$startRow.':H'.($startRow+4));
      	$objActSheet->setCellValue('A'.$startRow, $string);
      	$this->position($objActSheet,'A'.$startRow,'left');
      	$objActSheet->getStyle('A'.$startRow)->getAlignment()->setWrapText(true);
      	$startRow+=4;
      	$lastRow = $startRow;
      	$startRow ++;
      	$objActSheet->getStyle('A'.$firstRow.':H'.$lastRow)->applyFromArray($styleArray);
      	$startRow+=8;
      	$objActSheet->mergeCells("A".$startRow.":H".$startRow);
      	$objActSheet->setCellValue('A'.$startRow, '爱克森个性问卷成人 (EPQA) 结果剖析	');
      	$this->position($objActSheet, 'A'.$startRow);
      	$objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
      	$startRow++;
//       	$filePath = WordChart::scatter_horiz_Graph_epqa_1($data, $examinee);
//       	$objDrawing = new PHPExcel_Worksheet_Drawing();
//       	$objDrawing->setPath($filePath);
//       	$width = 14.48*39;
//       	$height = 5.48*39;
//       	$objDrawing->setWidthAndHeight($width, $height);
//       	$objDrawing->setCoordinates("A".$startRow);
//       	$objDrawing->setWorksheet($objActSheet);
      	$filePath = WordChart::scatter_horiz_Graph_epqa_1($data, $examinee);
      	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
      	$gdImage = imagecreatefrompng($filePath);
      	$objDrawing->setImageResource($gdImage);
      	$objDrawing->setName('epqa-1');
      	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
      	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
      	$width = 14.48*39;
      	$height = 5.48*39;
      	$objDrawing->setResizeProportional(false);
      	$objDrawing->setWidthAndHeight($width, $height);
      	$objDrawing->setCoordinates("A".$startRow);
      	$objDrawing->setWorksheet($objActSheet);
      	$startRow+=12;
//       	//edit bruce_w 2015-12-9 分页打印
//       	$filePath = WordChart::scatter_horiz_Graph_epqa_2($data, $examinee);
//       	$objDrawing1 = new PHPExcel_Worksheet_Drawing();
//       	$objDrawing1->setPath($filePath);
//       	$width = 14.92*38;
//       	$height = 12.49*38;
//       	$objDrawing1->setWidthAndHeight($width, $height);
//       	$objDrawing1->setCoordinates("A".$startRow);
//       	$objDrawing1->setWorksheet($objActSheet);
      	 $filePath = WordChart::scatter_horiz_Graph_epqa_2($data, $examinee);
       	 $objDrawing2 = new PHPExcel_Worksheet_MemoryDrawing();
       	 $gdImage = imagecreatefrompng($filePath);
       	 $objDrawing2->setImageResource($gdImage);
       	 $objDrawing2->setName('epqa-2');
       	 $objDrawing2->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
       	 $objDrawing2->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
       	 $width = 14.92*38;
      	 $height = 12.49*38;
      	 $objDrawing2->setResizeProportional(false);
       	 $objDrawing2->setWidthAndHeight($width, $height);
       	 $objDrawing2->setCoordinates("A".$startRow);
       	 $objDrawing2->setWorksheet($objActSheet);
       	 
    }
   # 7 CPI
    public function checkoutCpi(&$examinee,&$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
        $objActSheet->getDefaultColumnDimension()->setWidth(12);
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
        $objActSheet->setCellValue('B6','因子名称');
        $this->position($objActSheet, 'B6');
        $objActSheet->setCellValue('C6','代号');
        $this->position($objActSheet, 'C6');
        $objActSheet->setCellValue('D6','原始分');
        $this->position($objActSheet, 'D6');
        $objActSheet->setCellValue('E6','T分');
        $this->position($objActSheet, 'E6');
        $styleArray = array(
        		'borders' => array(
        				'outline' => array(
        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
        						//'color' => array('argb' => 'FFFF0000'),
        				),
        		),
        );
        $objActSheet->getStyle('A6:F6')->applyFromArray($styleArray);
        
       	 $data = CheckoutData::getCPIdata($examinee);
       	 if (empty($data)){
       	 	return ;
       	 }
       	 $array1 = array('do','cs','sy','sp','sa','wb');
       	 $array2 = array('re','so','sc','po','gi','cm');
       	 $array3 = array('ac','ai','ie');
       	 $array4 = array('py','fx','fe');
       	 
       	 $objActSheet->mergeCells("A7:F7");
       	 $objActSheet->setCellValue('A7', '第一类  人际关系适应能力的测验');
       	 $objActSheet->getStyle('A7')->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A7','left');
       	 $startRow = 7;
       	 $lastRow = $startRow;
       	 foreach ($array1 as $value ){
       	 	if (isset($data[$value])){
       	 		
       	 		$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('B'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 		$objActSheet->setCellValue('E'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'E'.$startRow);
       	 	}
       	 }
       	 
       	 $objActSheet->getStyle('A7:F'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $firstRow = $startRow;
       	 $lastRow = $startRow;
       	 $objActSheet->mergeCells('A'.$startRow.':F'.$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '第二类  社会化、成熟度、责任心及价值观念的测验');
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A'.$startRow, 'left');
       	 foreach ($array2 as $value ){
       	 	if (isset($data[$value])){
       	 	
       	 		$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('B'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 		$objActSheet->setCellValue('E'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'E'.$startRow);
       	 	}
       	 }
       	 $objActSheet->getStyle('A'.$firstRow.':F'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $firstRow = $startRow;
       	 $lastRow = $startRow;
       	 $objActSheet->mergeCells("A".$startRow.":F".$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '第三类  成就能力与智能效率的测验');
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A'.$startRow, 'left');
       	 
       	 foreach ($array3 as $value ){
       	 	if (isset($data[$value])){
       	 		
       	 			$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('B'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 		$objActSheet->setCellValue('E'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'E'.$startRow);
       	 	}
       	 }
       	 $objActSheet->getStyle('A'.$firstRow.':F'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $firstRow = $startRow;
       	 $lastRow = $startRow;
       	 $objActSheet->mergeCells("A".$startRow.":F".$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '第四类  个人的生活态度与倾向的测验');
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $this->position($objActSheet, 'A'.$startRow, 'left');
       	 foreach ($array4 as $value ){
       	 	if (isset($data[$value])){
       	 		
       	 			$startRow++;
       	 		$lastRow = $startRow;
       	 		$objActSheet->setCellValue('B'.$startRow,$data[$value]['chs_name']);
       	 		$this->position($objActSheet, 'B'.$startRow);
       	 		$objActSheet->setCellValue('C'.$startRow,ucwords($value));
       	 		$this->position($objActSheet, 'C'.$startRow);
       	 		$objActSheet->setCellValue('D'.$startRow,$data[$value]['score']);
       	 		$this->position($objActSheet, 'D'.$startRow);
       	 		$objActSheet->setCellValue('E'.$startRow,$data[$value]['std_score']);
       	 		$this->position($objActSheet, 'E'.$startRow);
       	 	}
       	 }
       	 $objActSheet->getStyle('A'.$firstRow.':F'.$lastRow)->applyFromArray($styleArray);
       	 $startRow++;
       	 $startRow++;
//        	 //edit bruce_w 2015-12-9 分页打印
       	 $startRow+=20;
       	 $objActSheet->mergeCells("A".$startRow.":F".$startRow);
       	 $objActSheet->setCellValue('A'.$startRow, '青年性格问卷测试(CPI)剖析图');
       	 $this->position($objActSheet, 'A'.$startRow);
       	 $objActSheet->getStyle('A'.$startRow)->getFont()->setBold(true);
       	 $startRow++;
       	 $startRow++;
       	 $filePath = WordChart::scatter_horiz_Graph_cpi($data, $examinee);
       	 $objDrawing3 = new PHPExcel_Worksheet_MemoryDrawing();
       	 $gdImage = imagecreatefrompng($filePath);
       	 $objDrawing3->setImageResource($gdImage);
       	 $objDrawing3->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
       	 $objDrawing3->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
       	 $width = 15*39;
       	 $height = 20*39;
       	 $objDrawing3->setResizeProportional(false);
       	 $objDrawing3->setName('cpi-1');
       	 $objDrawing3->setWidthAndHeight($width, $height);
       	 $objDrawing3->setCoordinates("A".$startRow);
       	 $objDrawing3->setWorksheet($objActSheet);
    }
   # 8 SPM 
    public function checkoutSpm(&$examinee, &$objActSheet){
        $objActSheet->getDefaultRowDimension()->setRowHeight(21);
        $objActSheet->getDefaultColumnDimension()->setWidth(12);
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
        $dengji = array(1=>'一级、高水平智力。',2=>'二级、智力水平良好。',3=>'三级、中等水平智力。',4=>'四级、智力水平中下。',5=>'五级、智力缺陷。');
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
    public function checkoutEightAddFive(&$examinee,&$objActSheet){
        $strong = array(
            '【强项指标1】【最优】','【强项指标2】【次优】','【强项指标3】【三优】','【强项指标4】【四优】','【强项指标5】【五优】','【强项指标6】【六优】','【强项指标7】【七优】','【强项指标8】【八优】'
        );
        $weak = array(
            '【弱项指标1】【最弱】','【弱项指标2】【次弱】','【弱项指标3】【三弱】','【弱项指标4】【四弱】','【弱项指标5】【五弱】'
        );
        $checkout = new CheckoutData();
        $eightAddFive = $checkout->getEightAddFive($examinee);
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(16);
        $objActSheet->getColumnDimension('C')->setWidth(12);
        $objActSheet->getColumnDimension('D')->setWidth(12);
        $objActSheet->getColumnDimension('E')->setWidth(12);
        //settings
        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
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
        		 	$startRow++;
        		 }
        		 $objActSheet->setCellValue('D'.$startRow,$eight['score']);
        		 $objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
        		 $this->position($objActSheet,'D'.$startRow);
        		 $lastRow = $startRow;
        		 $startRow++;
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
        		$objActSheet->setCellValue('D'.$startRow,$eight['score']);
        		$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
        		$this->position($objActSheet,'D'.$startRow);
        		$lastRow = $startRow;
        		$startRow++;
        		$objActSheet->getStyle('A'.$firstRow.':E'.$lastRow)->applyFromArray($styleArray);
        		$i++;
        	}
        	$startRow++;
        }
    }
    #10 结构
    public function checkoutModuleResult(&$examinee,&$objActSheet){
    	$objActSheet->getDefaultRowDimension()->setRowHeight(16);
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