<?php


class CheckoutExcel extends \Phalcon\Mvc\Controller{
    //以excel形式，导出被试人员信息和测试结果

    public static function checkoutExcel11($examinee,$project_id){
        //导出个人信息表
        require_once("../app/classes/PHPExcel.php");
        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        $cacheSettings = array('memoryCacheSize'=>'256MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $excel = new PHPExcel();
        $excel->getActiveSheet()->setTitle('1.个人信息表');
        
        self::checkoutPerson($examinee,$excel);//个人信息

        $msgWorkSheet = new PHPExcel_Worksheet($excel, '2.TQT人才测评系统'); //创建指标排序表
        $excel->addSheet($msgWorkSheet); 
        $excel->setActiveSheetIndex(1);
        self::checkoutIndex($examinee,$excel,$project_id); 

        $pf16 = new PHPExcel_Worksheet($excel, '3.16pf'); //创建16pf表
        $excel->addSheet($pf16); 
        $excel->setActiveSheetIndex(2);
        self::checkout16pf($examinee,$excel,$project_id);

        $epps = new PHPExcel_Worksheet($excel, '4.epps'); //创建epps表
        $excel->addSheet($epps); 
        $excel->setActiveSheetIndex(3);
        self::checkoutEpps($examinee,$excel,$project_id);

        $scl = new PHPExcel_Worksheet($excel, '5.scl90'); //创建SCL表
        $excel->addSheet($scl); 
        $excel->setActiveSheetIndex(4);
        self::checkoutScl($examinee,$excel,$project_id);

        $epqa = new PHPExcel_Worksheet($excel, '6.epqa'); //创建epqa表
        $excel->addSheet($epqa); 
        $excel->setActiveSheetIndex(5);
        self::checkoutEpqa($examinee,$excel,$project_id);

        $cpi = new PHPExcel_Worksheet($excel, '7.cpi'); //创建cpi表
        $excel->addSheet($cpi); 
        $excel->setActiveSheetIndex(6);
        self::checkoutCpi($examinee,$excel,$project_id);

        $spm = new PHPExcel_Worksheet($excel, '8.spm'); //创建spm表
        $excel->addSheet($spm); 
        $excel->setActiveSheetIndex(7);
        self::checkoutSpm($examinee,$excel,$project_id);

        $indexarray = new PHPExcel_Worksheet($excel, '9.8+5'); //创建8+5表
        $excel->addSheet($indexarray);
        $excel->setActiveSheetIndex(8);
        self::checkoutEightAddFive($examinee,$excel,$project_id);


        $structure = new PHPExcel_Worksheet($excel,'结构');//创建结构表
        $excel->addSheet($structure);
        $excel->setActiveSheetIndex(9);
        self::checkoutModuleResult($examinee,$excel,$project_id);

        $write = new PHPExcel_Writer_Excel5($excel);
        //临时文件命名规范    $examinee_id_$date_rand(100,900)
        $date = date('H_i_s');
        $stamp = rand(100,900);
        $fileName = './tmp/'.$examinee->id.'_'.$date.'_'.$stamp.'.xls';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename=\'$fileName\'');
        header("Content-Transfer-Encoding:binary");
        $write->save($fileName);
        return $fileName;
    }

    //导出个人信息
    public static function checkoutPerson($examinee,$excel){
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(25);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','测评人员个人基本情况');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','姓名');
        $objActSheet->setCellValue('B2',$examinee->name);
        $objActSheet->setCellValue('C2','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('D2',$sex);
        $objActSheet->setCellValue('E2','生日');
        $objActSheet->setCellValue('F2',$examinee->birthday);

        $objActSheet->setCellValue('A3','籍贯');
        $objActSheet->setCellValue('B3',$examinee->native);
        $objActSheet->setCellValue('C3','学历');
        $objActSheet->setCellValue('D3',$examinee->education);
        $objActSheet->setCellValue('E3','学位');
        $objActSheet->setCellValue('F3',$examinee->degree);
        
        $objActSheet->setCellValue('A4','政治面貌');
        $objActSheet->mergeCells('B4:C4');
        $objActSheet->setCellValue('B4',$examinee->politics);
        $objActSheet->setCellValue('D4','职称');
        $objActSheet->mergeCells('E4:F4');
        $objActSheet->setCellValue('F4',$examinee->professional);

        $objActSheet->setCellValue('A5','工作单位');
        $objActSheet->mergeCells('B5:C5');
        $objActSheet->setCellValue('B5',$examinee->employer);
        $objActSheet->setCellValue('D5','班子/系统成员');
        $objActSheet->mergeCells('E5:F5');
        $objActSheet->setCellValue('E5',$examinee->team);

        $objActSheet->setCellValue('A6','部门');
        $objActSheet->mergeCells('B6:C6');
        $objActSheet->setCellValue('B6',$examinee->unit);
        $objActSheet->setCellValue('D6','岗位/职务');
        $objActSheet->mergeCells('E6:F6');
        $objActSheet->setCellValue('E6',$examinee->duty);

        $education = json_decode($examinee->other)->education;
        $letter = array('A','B','C','D','E','F');
        $sumEducation = count($education);
        if($sumEducation<4)
            $row1 = 4;
        else
            $row1 = $sumEducation+1;
        $row1 +=7;


        $objActSheet->mergeCells("A7:A$row1");
        $objActSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('A7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->getStyle('A1:F30')->getAlignment()->setWrapText(TRUE);
        $objActSheet->setCellValue('A7','教育经历（自高中毕业后起，含在职教育经历）');
        
        $objActSheet->setCellValue('B7','毕业院校');
        $objActSheet->setCellValue('C7','专业');
        $objActSheet->setCellValue('D7','所获学位');
        $objActSheet->setCellValue('E7','起止时间');
        // print_r($education);exit;
        for($i = 0;$i<$sumEducation;$i++){
            $j = 1;
            $k = $i +8;
            $education[$i] = (array)$education[$i];
            foreach ((array)$education[$i] as $key => $value) {
                $objActSheet->setCellValue("$letter[$j]$k","$value");
                $j++;
            }
        }

        $work = json_decode($examinee->other)->work;
        $sumWork = count($work);
        $row1++;
        if($sumWork<4)
            $row2 = 4;
        else
            $row2 = $sumWork+1;
        $row2 +=$row1;

        $objActSheet->mergeCells("A$row1:A$row2");
        $objActSheet->getStyle("A$row1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle("A$row1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->setCellValue("A$row1",'工作经历');        
        
        $objActSheet->setCellValue("B$row1",'就职单位');
        $objActSheet->setCellValue("C$row1",'部门');
        $objActSheet->setCellValue("D$row1",'职位');
        $objActSheet->setCellValue("E$row1",'工作时间');
        $num = 1;
        for($i = 0;$i<$sumWork;$i++){
            $j = 1;
            $work[$i] = (array)$work[$i];
            $k = $row1+$num;
            foreach ((array)$work[$i] as $key => $value) {
                $objActSheet->setCellValue("$letter[$j]$k","$value");
                $j++;
            }
            $num++;
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
        $objActSheet->getStyle("A2:F$row2")->applyFromArray($styleArray);
        $objActSheet->getStyle("A2:F$row2")->applyFromArray($styleArray1);

    }

    //导出指标排序
    public static function checkoutIndex($examinee,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(25);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:E1');
        $objActSheet->setCellValue('A1','TQT人才测评系统  28项指标排序');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','编号');
        $objActSheet->setCellValue('B2',$examinee->number);
        $objActSheet->setCellValue('C2','姓名');
        $objActSheet->setCellValue('D2',$examinee->name);
        /*
        *通过$examinee->id在index_ans表中找到index_id 和 score
        *通过index_id 在index表中找到指标名称（chs_name）
        */
        $examinee_id = $examinee->id;
        $index = self::getIndexScore($project_id,$examinee_id);
        $i = 1;
        $k = 0;
        $sum = count($index);
        foreach($index as $key => $value ){
            $k = $i + 2;
            $index_ans_info = Index::find(
                    array('name = :name:','bind'=>array(
                        'name' => $key))
                );
            $chs_name = $index_ans_info[0]->chs_name;

            $objActSheet->getStyle("A$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("C$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("A$k")->getFont()->setBold(true);
            $objActSheet->getStyle("C$k")->getFont()->setBold(true);
            $objActSheet->setCellValue("A$k","$i");
            $objActSheet->setCellValue("B$k","$chs_name");
            $objActSheet->setCellValue("C$k","$value");            
            if($i<=8){
                $objActSheet->setCellValue("D$k","#");
                $objActSheet->getStyle("D$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            if($sum - $i<5){
                $objActSheet->setCellValue("D$k","*");
                $objActSheet->getStyle("D$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            $i++;
        }
        $objActSheet->setCellValue('A1',"TQT人才测评系统  ".$sum."项指标排序"); 
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
        $objActSheet->getStyle("A3:E$k")->applyFromArray($styleArray);
        $objActSheet->getStyle("A3:E$k")->applyFromArray($styleArray1);     

    }

    public static function checkout16pf($examinee,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);

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
        $objActSheet->setCellValue('D2','编号');
        $objActSheet->setCellValue('E2',$examinee->number);
        $objActSheet->setCellValue('K2','姓名');
        $objActSheet->setCellValue('O2',$examinee->name);
        $objActSheet->setCellValue('A3','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('B3',$sex);
        $objActSheet->setCellValue('D3','年龄');
        $birthday = $examinee->birthday;
        $bir = explode('-',$birthday);
        $age = date("Y") - $bir[0];
        if((date("m")-$bir[1])>0 || ( (date("m")==$bir[1])&&(date("d")>$bir[2]) ))
            $age++;
        $objActSheet->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('E3',$age);
        $objActSheet->setCellValue('K3','职业');
        $objActSheet->setCellValue('O3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $objActSheet->setCellValue('B4',date("Y-m-d"));

        $objActSheet->getRowDimension(5)->setRowHeight(8);

        $objActSheet->setCellValue('A6','因子名称');
        $objActSheet->setCellValue('B6','代号');
        $objActSheet->setCellValue('C6',' 标准分 ');
        $objActSheet->setCellValue('D6','低分者特征');
        $objActSheet->setCellValue('O6','高分者特征');

        $letter = array('E','F','G','H','I','J','K','L','M','N');
        for($i = 6;$i<16;$i++){
            $j = $i -5;
            $k = $j -1;
            $objActSheet->getStyle("$letter[$k]6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objActSheet->setCellValue("$letter[$k]6","$j");
        }

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
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
            $objActSheet->setCellValue("$letter[$j]$i","*");
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

    public static function checkoutEpps($examinee,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
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
        $birthday = $examinee->birthday;
        $bir = explode('-',$birthday);
        $age = date("Y") - $bir[0];
        if((date("m")-$bir[1])>0 || ( (date("m")==$bir[1])&&(date("d")>$bir[2]) ))
            $age++;
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $objActSheet->setCellValue('B4',date("Y-m-d"));

        $objActSheet->getRowDimension(5)->setRowHeight(8);

        $objActSheet->setCellValue("A6","测试项目");
        $objActSheet->setCellValue("B6","得分");        
        $objActSheet->setCellValue("C6","得分排序");
        $objActSheet->setCellValue("D6","测试项目");
        $objActSheet->setCellValue("E6","得分");
        $objActSheet->setCellValue("F6","得分排序");

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
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

    public static function checkoutScl($examinee ,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
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
        $birthday = $examinee->birthday;
        $bir = explode('-',$birthday);
        $age = date("Y") - $bir[0];
        if((date("m")-$bir[1])>0 || ( (date("m")==$bir[1])&&(date("d")>$bir[2]) ))
            $age++;
        $objActSheet->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('B6',$age);
        $objActSheet->setCellValue('A7','日期');
        $objActSheet->setCellValue('B7',date("Y-m-d"));
        $objActSheet->setCellValue('A8','总分');
        $objActSheet->setCellValue('A9','总均分');
        $objActSheet->setCellValue('A10','阴性项目数');
        $objActSheet->setCellValue('A11','阳性项目数');
        $objActSheet->setCellValue('A12','阳性症状均分');

        $objActSheet->setCellValue('D2','因子名称');
        $objActSheet->setCellValue('E2','因子分');
        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
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

    public static function checkoutEpqa($examinee,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
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
        $birthday = $examinee->birthday;
        $bir = explode('-',$birthday);
        $age = date("Y") - $bir[0];
        if((date("m")-$bir[1])>0 || ( (date("m")==$bir[1])&&(date("d")>$bir[2]) ))
            $age++;
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $objActSheet->setCellValue('B4',date("Y-m-d"));

        $objActSheet->getRowDimension(5)->setRowHeight(8);

        $objActSheet->setCellValue('B6','因子名称');
        $objActSheet->setCellValue('C6','代号');
        $objActSheet->setCellValue('D6','原始得分');
        $objActSheet->setCellValue('E6','T分');
        $objActSheet->getStyle("C6:E6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
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

    public static function checkoutCpi($examinee,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
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
        $birthday = $examinee->birthday;
        $bir = explode('-',$birthday);
        $age = date("Y") - $bir[0];
        if((date("m")-$bir[1])>0 || ( (date("m")==$bir[1])&&(date("d")>$bir[2]) ))
            $age++;
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $objActSheet->setCellValue('B4',date("Y-m-d"));
        $objActSheet->getRowDimension(5)->setRowHeight(20);

        $objActSheet->setCellValue('A6','因子名称');
        $objActSheet->setCellValue('B6','代号');
        $objActSheet->setCellValue('C6','原始分');
        $objActSheet->setCellValue('D6','T分');
        $objActSheet->getStyle("A6:D6")->getFont()->setBold(true);
        $objActSheet->mergeCells("A7:F7");

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
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

    public static function checkoutSpm($examinee,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
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
        $birthday = $examinee->birthday;
        $bir = explode('-',$birthday);
        $age = date("Y") - $bir[0];
        if((date("m")-$bir[1])>0 || ( (date("m")==$bir[1])&&(date("d")>$bir[2]) ))
            $age++;
        $objActSheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D3',$age);
        $objActSheet->setCellValue('E3','职业');
        $objActSheet->setCellValue('F3',$examinee->duty);

        $objActSheet->setCellValue('A4','日期');
        $objActSheet->setCellValue('B4',date("Y-m-d"));

        $objActSheet->setCellValue('A6','总分');

        $objActSheet->setCellValue('C6','百分等级');

        $objActSheet->setCellValue('E6','智力等级');

        $objActSheet->setCellValue('A7','评定结果');
        $objActSheet->mergeCells('B7:F7');

        $objActSheet->setCellValue('A8','部分');
        $objActSheet->setCellValue('A9','得分');

        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
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

     public static function checkoutEightAddFive($examinee,$excel,$project_id){
//        $excel2 = new PHPExcel();
        $strong = array(
            '【强项指标1】【最优】','【强项指标2】【次优】','【强项指标3】【三优】',
            '【强项指标4】【四优】','【强项指标5】【五优】','【强项指标6】【六优】',
            '【强项指标7】【七优】','【强项指标8】【八优】'
        );
        $weak = array(
            '【弱项指标1】【最弱】','【弱项指标2】【次弱】','【弱项指标3】【三弱】',
            '【弱项指标4】【四弱】','【弱项指标5】【五弱】'
        );
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultColumnDimension()->setWidth(20);
        $objActSheet->getDefaultRowDimension()->setRowHeight(20);
        $examinee_id = $examinee->id;
        $examinee_number = $examinee->number;
        $examinee_name = $examinee->name;
        $index_msg = self::getIndexMsg($project_id);
        $index_score = self::getIndexScore($project_id,$examinee_id);//指标得分，由高到低排序
        $index_num = count($index_score);
        /*
         * 8+5表表头
         */
        $objActSheet->setCellValue('A1','TQT人才测评系统    '.$index_num.'指标排序(8+5)');
        $objActSheet->mergeCells('A1:E3');
        $objActSheet->getStyle('A1')->getFont()->setSize(18);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->mergeCells('A4:B4');
        $objActSheet->setCellValue('A4','被测编号:');
        $objActSheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objActSheet->getStyle('A4:E4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objActSheet->getStyle('A4:E4')->getFill()->getStartColor()->setRGB('#BEBEBE');
        $objActSheet->setCellValue('C4',$examinee_number );
        $objActSheet->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objActSheet->setCellValue('D4','姓名：');
        $objActSheet->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objActSheet->setCellValue('E4',$examinee_name);
        $objActSheet->setCellValue('B5','组合因素');
        $objActSheet->setCellValue('C5','原始分');
        $objActSheet->setCellValue('D5','综合分');
        $objActSheet->setCellValue('E5','评价结果');
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        $objActSheet->getStyle('A1:E5')->applyFromArray($styleArray);
//        $objActSheet->mergeCells('A1:E5');
        //数据导入
        $index_factors = self::getIndexFactor($project_id);
        $factor_ans = array();
        $high = 0;
        $low = 0;
        $row = 6;
        //强项导出
        foreach($index_score as $key => $value){
            if($high <= 7){
                $index_factor = $index_factors[$key];
                foreach($index_factor as $k => $v){
                    $factor_chs_name = self::getFactorMsg($v)['chs_name'];
                    $factor_ans[$value][$v]['answer'] = self::getFactorAnswer($examinee_id,$v);//指标测试答案
                    $factor_ans[$value][$v]['chs_name'] = $factor_chs_name;
                }
                $index = self::getIndex($key);//测试指标
                $objActSheet->setCellValue('A'.$row,$strong[$high]);
                $headOne = $row+1;
                $headTwo = $row+2;
                $objActSheet->setCellValue('A'.$headOne,$index['chs_name']);
                $objActSheet->setCellValue('A'.$headTwo,count($index_factors[$key]));
                $objActSheet->getStyle('A'.$headTwo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $start_row = $row;
                $row = $row + 1;
                foreach($index_factors[$key] as $i => $item){
                    if(substr($item,0,3) != 'zb_'){
                        $objActSheet->setCellValue('B'.$row,self::getFactorMsg($item)['chs_name']);
                        $factor_answer = self::getFactorAnswer($examinee_id,$item);
                        $objActSheet->setCellValue('C'.$row,$factor_answer['score']);
                        $objActSheet->setCellValue('D'.$row,$factor_answer['std_score']);
                        $row++;
                    }else{
                        $objActSheet->setCellValue('B'.$row,self::getIndex($item)['chs_name']);
                        $index_answer = self::getIndexScore2($item,$examinee_id);
                        $objActSheet->setCellValue('C'.$row,$index_answer['score']);
                        $objActSheet->setCellValue('D'.$row,$index_answer['score']);
                        $row++;
                    }
                }
//                $row++;
                if($value){
                    $objActSheet->setCellValue('D'.$row,$value);
                }else{
                    $objActSheet->setCellValue('D'.$row,0);
                }
                $row++;
                $objActSheet->getStyle('A'.$row.':E'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle('A'.$row.':E'.$row)->getFill()->getStartColor()->setRGB('#BEBEBE');
//                $objActSheet->mergeCells('A'.$start_row.':E'.$row);
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                            'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                            //'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                $objActSheet->getStyle('A'.$start_row.':E'.$row)->applyFromArray($styleArray);
                $row++;
                $high++;
            }else{
                break;
            }
        }
        // asort($index_score);
        $index_score = array_reverse($index_score,true);
        //弱项导出
        foreach($index_score as $key => $value){
            if($low <= 4){
                $index_factor = $index_factors[$key];
                foreach($index_factor as $k => $v){
                    $factor_chs_name = self::getFactorMsg($v)['chs_name'];
                    $factor_ans[$value][$v]['answer'] = self::getFactorAnswer($examinee_id,$v);//指标测试答案
                    $factor_ans[$value][$v]['chs_name'] = $factor_chs_name;
                }
                $index = self::getIndex($key);//测试指标
                $objActSheet->setCellValue('A'.$row,$weak[$low]);
                $objActSheet->setCellValue('A'.($row+1),$index['chs_name']);
                $objActSheet->setCellValue('A'.($row+2),count($index_factors[$key]));
                $objActSheet->getStyle('A'.($row+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $start_row = $row;
                $row = $row + 1;
                foreach($index_factors[$key] as $i => $item){
                    if(substr($item,0,3) != 'zb_'){
                        $objActSheet->setCellValue('B'.$row,self::getFactorMsg($item)['chs_name']);
                        $factor_answer = self::getFactorAnswer($examinee_id,$item);
                        $objActSheet->setCellValue('C'.$row,$factor_answer['score']);
                        $objActSheet->setCellValue('D'.$row,$factor_answer['std_score']);
                        $row++;
                    }else{
                        $objActSheet->setCellValue('B'.$row,self::getIndex($item)['chs_name']);
                        $index_answer = self::getIndexScore2($item,$examinee_id);
                        $objActSheet->setCellValue('C'.$row,$index_answer['score']);
                        $objActSheet->setCellValue('D'.$row,$index_answer['score']);
                        $row++;
                    }
                }
//                $row++;
                if($value){
                    $objActSheet->setCellValue('D'.$row,$value);
                }else{
                    $objActSheet->setCellValue('D'.$row,0);
                }
                $row++;
                $objActSheet->getStyle('A'.$row.':E'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle('A'.$row.':E'.$row)->getFill()->getStartColor()->setRGB('#BEBEBE');
//                $objActSheet->setCellValue('D'.$row,$value);
//                $objActSheet->mergeCells('A'.$start_row.':E'.$row);
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            // 'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                            'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                            //'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                $objActSheet->getStyle('A'.$start_row.':E'.$row)->applyFromArray($styleArray);
                $row++;
                $low++;
            }else{
                break;
            }
        }

    }

    public static function checkoutStruct($examinee,$excel){
        //todo
    }

    public static function checkoutModuleResult($examinee,$excel,$project_id){
//        $excel2 = new PHPExcel();
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(20);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);
        $resultItem = self::testResultItem();
        $examinee_id = $examinee->id;
        $module = self::getScore($examinee_id,$project_id,$resultItem);
//        var_dump($module);
//        exit;
        $k = 1;
        $objActSheet->getRowDimension($k)->setRowHeight(40);
        $objActSheet->mergeCells('B'.$k.':F'.$k);
        foreach($module as $key => $item){
            if(!empty($item)){
                if($key == 'mk_xljk'){
//                    $objActSheet->getRowDimension($k+2)->set
                    self::structureExcelHead($k,'心理健康评价指标',$objActSheet);
                    //心理健康水平行
                    self::structureExcelCommon($k+2,'mk_xljk','zb_xljksp',$resultItem,$objActSheet,$item);
                    //情绪控制水平行
                    self::structureExcelCommon($k+3,'mk_xljk','zb_qxkzsp',$resultItem,$objActSheet,$item);
                    //适应环境水平
                    self::structureExcelCommon($k+4,'mk_xljk','zb_syhjsp',$resultItem,$objActSheet,$item);
                    //人际关系调节水平
                    self::structureExcelCommon($k+5,'mk_xljk','zb_rjgxtjsp',$resultItem,$objActSheet,$item);
                    //性格
                    self::structureExcelCommon($k+6,'mk_xljk','zb_xg',$resultItem,$objActSheet,$item);
                    //执着
                    self::structureExcelCommon($k+7,'mk_xljk','zb_zz',$resultItem,$objActSheet,$item);
                    //风险性
                    self::structureExcelCommon($k+8,'mk_xljk','zb_fxx',$resultItem,$objActSheet,$item);
                    $objActSheet->mergeCells('B'.($k+9).':C'.($k+9));
                    $objActSheet->mergeCells('E'.($k+9).':F'.($k+9));
                    $k += 9;

                }
                elseif($key == 'mk_szjg'){
//                    $objActSheet->setCellValue('B'.$k,'素质结构评价指标');
                    self::structureExcelHead($k,'素质结构评价指标',$objActSheet);
                    //责任心
                    self::structureExcelCommon($k+2,'mk_szjg','zb_zrx',$resultItem,$objActSheet,$item);
                    //诚信度
                    self::structureExcelCommon($k+3,'mk_szjg','zb_cxd',$resultItem,$objActSheet,$item);
                    //个人价值取向
                    self::structureExcelCommon($k+4,'mk_szjg','zb_grjzqx',$resultItem,$objActSheet,$item);
                    //团队精神
                    self::structureExcelCommon($k+5,'mk_szjg','zb_tdjs',$resultItem,$objActSheet,$item);
                    //工作态度
                    self::structureExcelCommon($k+6,'mk_szjg','zb_gztd',$resultItem,$objActSheet,$item);
                    //工作作风
                    self::structureExcelCommon($k+7,'mk_szjg','zb_gzzf',$resultItem,$objActSheet,$item);
                    //表现性
                    self::structureExcelCommon($k+8,'mk_szjg','zb_bxx',$resultItem,$objActSheet,$item);
                    //容纳性
                    self::structureExcelCommon($k+9,'mk_szjg','zb_rnx',$resultItem,$objActSheet,$item);
                    $objActSheet->mergeCells('B'.($k+10).':C'.($k+10));
                    $objActSheet->mergeCells('E'.($k+10).':F'.($k+10));
                    $k += 10;
                }
                elseif($key == 'mk_ztjg'){
//                    $objActSheet->setCellValue('B'.$k,'智体结构评价指标');
                    self::structureExcelHead($k,'智体结构评价指标',$objActSheet);
                    //聪慧性
                    self::structureExcelCommon($k+2,'mk_ztjg','zb_chd',$resultItem,$objActSheet,$item);
                    //精明能干
                    self::structureExcelCommon($k+3,'mk_ztjg','zb_jmng',$resultItem,$objActSheet,$item);
                    //纪律性
                    self::structureExcelCommon($k+4,'mk_ztjg','zb_jlx',$resultItem,$objActSheet,$item);
                    //体质精力
                    self::structureExcelCommon($k+5,'mk_ztjg','zb_tzjl',$resultItem,$objActSheet,$item);
                    //分析能力
                    self::structureExcelCommon($k+6,'mk_ztjg','zb_fxnl',$resultItem,$objActSheet,$item);
                    //归纳能力
                    self::structureExcelCommon($k+7,'mk_ztjg','zb_gnnl',$resultItem,$objActSheet,$item);

                    $objActSheet->mergeCells('B'.($k+8).':C'.($k+8));
                    $objActSheet->mergeCells('E'.($k+8).':F'.($k+8));
                    $k += 8;
                }
                else{
//                    $objActSheet->setCellValue('B'.$k,'能力结构评价指标');
                    self::structureExcelHead($k,'能力结构评价指标',$objActSheet);
                    //独立工作能力
                    self::structureExcelCommon($k+2,'mk_nljg','zb_dlgznl',$resultItem,$objActSheet,$item);
                    //创新能力
                    self::structureExcelCommon($k+3,'mk_nljg','zb_cxnl',$resultItem,$objActSheet,$item);
                    //应变能力
                    self::structureExcelCommon($k+4,'mk_nljg','zb_ybnl',$resultItem,$objActSheet,$item);
                    //判断与决策能力
                    self::structureExcelCommon($k+5,'mk_nljg','zb_pdyjcnl',$resultItem,$objActSheet,$item);
                    //组织管理能力
                    self::structureExcelCommon($k+6,'mk_nljg','zb_zzglnl',$resultItem,$objActSheet,$item);
                    //社交能力
                    self::structureExcelCommon($k+7,'mk_nljg','zb_sjnl',$resultItem,$objActSheet,$item);
                    //领导能力
                    self::structureExcelCommon($k+8,'mk_nljg','zb_ldnl',$resultItem,$objActSheet,$item);
                    $k += 7;
                }

            }
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
        $objActSheet->getStyle('A1:F'.($k+1))->applyFromArray($styleArray);


    }
    /*
     * 获取结构表信息
     */
    public static function testResultItem(){
        $result = array();
        //心理健康模块
        $result['mk_xljk'] = array(
            'zb_xljksp' => array(
                'item' => '心理健康水平',
                'combineFactor' => 19,
                'name' => 'zb_xljksp'
            ),
            'zb_qxkzsp' => array(
                'item' => '情绪控制水平',
                'combineFactor' => 10,
                'name' => 'zb_qxkzsp'
            ),
            'zb_syhjsp' => array(
                'item' => '适应环境水平',
                'combineFactor' => 8,
                'name' => 'zb_syhjsp'
            ),
            'zb_rjgxtjsp' => array(
                'item' => '人际关系调节水平',
                'combineFactor' => 11,
                'name' => 'zb_rjgxtjsp'
            ),
            'zb_xg' => array(
                'item' => '性格',
                'combineFactor' => 10,
                'name' => 'zb_xg'
            ),
            'zb_zz' => array(
                'item' => '执着',
                'combineFactor' => 11,
                'name' => 'zb_zz'
            ),
            'zb_fxx' => array(
                'item' => '风险性',
                'combineFactor' => 8,
                'name' => 'zb_fxx'
            )
        );
        //素质结构模块
        $result['mk_szjg'] = array(
            'zb_zrx' => array(
                'item' => '责任心',
                'combineFactor' => 12,
                'name' => 'zb_zrx'
            ),
            'zb_cxd' => array(
                'item' => '诚信度',
                'combineFactor' => 7,
                'name' => 'zb_cxd'
            ),
            'zb_grjzqx' => array(
                'item' => '个人价值取向',
                'combineFactor' => 11,
                'name' => 'zb_grjzqx',
            ),
            'zb_tdjs' => array(
                'item' => '团队精神',
                'combineFactor' => 9,
                'name' => 'zb_tdjs'
            ),
            'zb_gztd' => array(
                'item' => '工作态度',
                'combineFactor' => 7,
                'name' => 'zb_gztd'
            ),
            'zb_gzzf' => array(
                'item' => '工作作风',
                'combineFactor' => 8,
                'name' => 'zb_gzzf'
            ),
            'zb_bxx' => array(
                'item' => '表现性',
                'combineFactor' => 9,
                'name' => 'zb_bxx'
            ),
            'zb_rnx' => array(
                'item' => '容纳性',
                'combineFactor' => 4,
                'name' => 'zb_rnx'
            )
        );
        //智体结构模块
        $result['mk_ztjg'] = array(
            'zb_chd' => array(
                'item' => '聪慧性',
                'combineFactor' => 10,
                'name' => 'zb_chd'
            ),
            'zb_jmng' => array(
                'item' => '精干性',
                'combineFactor' => 7,
                'name' => 'zb_jmng'
            ),
            'zb_jlx' => array(
                'item' => '纪律性',
                'combineFactor' => 8,
                'name' => 'zb_jlx'
            ),
            'zb_tzjl' => array(
                'item' => '体质精力',
                'combineFactor' => 8,
                'name' => 'zb_tzjl'
            ),
            'zb_fxnl' => array(
                'item' => '分析能力',
                'combineFactor' => 11,
                'name' => 'zb_fxnl'
            ),
            'zb_gnnl' => array(
                'item' => '归纳能力',
                'combineFactor' => 12,
                'name' => 'zb_gnnl'
            )
        );
        //能力结构模块
        $result['mk_nljg'] = array(
            'zb_dlgznl' => array(
                'item' => '独立工作能力',
                'combineFactor' => 9,
                'name' => 'zb_dlgznl'
            ),
            'zb_cxnl' => array(
                'item' => '创新能力',
                'combineFactor' => 12,
                'name' => 'zb_cxnl'
            ),
            'zb_ybnl' => array(
                'item' => '应变能力',
                'combineFactor' => 9,
                'name' => 'zb_ybnl'
            ),
            'zb_pdyjcnl' => array(
                'item' => '判断与决策能力',
                'combineFactor' => 9,
                'name' => 'zb_pdyjcnl'
            ),
            'zb_zzglnl' => array(
                'item' => '组织管理能力',
                'combineFactor' => 8,
                'name' => 'zb_zzglnl'
            ),
            'zb_sjnl' => array(
                'item' => '社交能力',
                'combineFactor' => 12,
                'name' => 'zb_sjnl'
            ),
            'zb_ldnl' => array(
                'item' => '领导能力',
                'combineFactor' => 6,
                'name' => 'zb_ldnl'
            )
        );

        return $result;
    }

    public static function getScore($examinee_id,$project_id,$result){
//        $result = $this->testResultItem();
        $project_detail = ProjectDetail::findFirst(array(
            'project_id = :project_id:',
            'bind' => array(
                'project_id' => $project_id
            )
        ));
        $module = array();
        //心理健康模块
        $module['mk_xljk'] = self::moduleDetailScore('mk_xljk',$project_detail,$result,$examinee_id);
        //素质结构模块
        $module['mk_szjg'] = self::moduleDetailScore('mk_szjg',$project_detail,$result,$examinee_id);
        //智体结构模块
        $module['mk_ztjg'] = self::moduleDetailScore('mk_ztjg',$project_detail,$result,$examinee_id);
        //能力结构模块
        $module['mk_nljg'] = self::moduleDetailScore('mk_nljg',$project_detail,$result,$examinee_id);
//        var_dump($module);
//        exit;
        return $module;
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


    public function testexcel(){
        require_once("../app/classes/PHPExcel.php");
        $excel = new PHPExcel();
        $excel->getActiveSheet()->setTitle('个人信息表');
        $letter = array('A','B','C','D','E','F','G');
        $tableheader = array('学号','姓名','性别','年龄','班级');
        for($i = 0;$i<count($tableheader);$i++){
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        $data = array(
                        array('1','小王','男','20','100'),
                        array('2','小王','女','20','100'),
                        array('3','小王','男','20','100'),
                        array('4','小王','女','20','100'),
                        array('5','小王','女','20','100'),
                        array('6','小王','男','20','100')
                        );
        for($i = 2;$i<=count($data)+1;$i++){
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        //创建第二张表格
        $msgWorkSheet = new PHPExcel_Worksheet($excel, 'card_message'); //创建一个工作表
        $excel->addSheet($msgWorkSheet); //插入工作表
        $excel->setActiveSheetIndex(1); //切换到新创建的工作表
        
        for($i = 0;$i<count($tableheader);$i++){
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        
        for($i = 2;$i<=count($data)+1;$i++){
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        $styleArray1 = array(
                    'font' => array(
                            'bold' => true,
                            'size'=>12,
                            'color'=>array(
                            'argb' => '00000000',
                                ),
                            ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            ),
                    'borders' => array (
                            'outline' => array (
                                        // 'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                                        'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
                                        // 'color' => array ('argb' => 'FF000000'),          //设置border颜色
                                    ),
                             ),
                    );
        // 将A1单元格设置为加粗，居中
        $excel->getActiveSheet()->getStyle('C1:D3')->applyFromArray($styleArray1);
        $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        // $styleArray = array(
        //                'borders' => array(
        //                     'allborders' =>array(
        //                             'style'=>PHPExcel_Style_Border::BORDER_THIN,
        //                             ),
        //                     ),
        //                );
        // $excel->getActiveSheet()->getStyle('C1:C3')->applyFormArray($styleArray);
        // $msgWorkSheet->getActiveSheet()->getStyle('C3')->applyFormArray(
        //             array(
        //                     'font' => array('bold' =>true),
        //                     'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        //                     )
        //             );
        // $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        // $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(false);


        //创建第三张表格
        $pf16 = new PHPExcel_Worksheet($excel,'16pf');
        $excel->addSheet($pf16);
        $excel->setActiveSheetIndex(2);

        for($i = 0;$i<count($tableheader);$i++){
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        for($i = 2;$i<=count($data)+1;$i++){
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        $excel->getActiveSheet()->mergeCells('A1:E5');

        

        $write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="result.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }
}