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
        self::checkoutIndex($examinee,$excel); 

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
        self::checkoutSpm($examinee,$excel);

        $indexarray = new PHPExcel_Worksheet($excel, '9.8+5'); //创建8+5表
        $excel->addSheet($indexarray); 
        $excel->setActiveSheetIndex(8);
        self::checkoutIndexArray($examinee,$excel);

        $struct = new PHPExcel_Worksheet($excel, '10.结构'); //创建结构表
        $excel->addSheet($struct); 
        $excel->setActiveSheetIndex(9);
        self::checkoutStruct($examinee,$excel);

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

    //导出个人信息
    public static function checkoutPerson($examinee,$excel){
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(25);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        // $objActSheet->getRowDimension('A')->setRowHeight(50);
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

        $objActSheet->mergeCells('A7:A11');
        $objActSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('A7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->getStyle('A1:F30')->getAlignment()->setWrapText(TRUE);
        $objActSheet->setCellValue('A7','教育经历（自高中毕业后起，含在职教育经历）');
        $education = json_decode($examinee->other)->education;
        $letter = array('A','B','C','D','E','F');
        $sumEducation = count($education);
        // if($sumEducation<5)
        //     $sumEducation = 5;
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

        $objActSheet->mergeCells('A12:A16');
        $objActSheet->getStyle('A12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('A12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->setCellValue('A12','工作经历');        
        $work = json_decode($examinee->other)->work;
        $sumWork = count($work);
        $objActSheet->setCellValue('B12','就职单位');
        $objActSheet->setCellValue('C12','部门');
        $objActSheet->setCellValue('D12','职位');
        $objActSheet->setCellValue('E12','工作时间');
        for($i = 0;$i<$sumWork;$i++){
            $j = 1;
            $work[$i] = (array)$work[$i];
            $k = $i+13;
            foreach ((array)$work[$i] as $key => $value) {
                $objActSheet->setCellValue("$letter[$j]$k","$value");
                $j++;
            }
        }

    }

    //导出指标排序
    public static function checkoutIndex($examinee,$excel){
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(25);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:E1');
        $objActSheet->setCellValue('A1','TQT人才测评系统  28项指标排序');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','姓名');
        $objActSheet->setCellValue('B2',$examinee->name);
        $objActSheet->setCellValue('A3','编号');
        $objActSheet->setCellValue('B3','指标');
        $objActSheet->setCellValue('C3','得分');
        /*
        *通过$examinee->id在index_ans表中找到index_id 和 score
        *通过index_id 在index表中找到指标名称（chs_name）
        */
        $id = $examinee->id;
        $index_ans_info = IndexAns::find(
            array(
                 "examinee_id = :examinee_id:", 'bind' => array('examinee_id'=>$id),
                 'order' => 'score desc'
                 ));
        $i=1;
        foreach($index_ans_info as $value ){
            $k = $i + 3;
            $chs_name = (string)$value->Index->chs_name;
            $objActSheet->getStyle("A$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("C$k")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("A$k")->getFont()->setBold(true);
            $objActSheet->getStyle("C$k")->getFont()->setBold(true);
            $objActSheet->setCellValue("A$k","$i");
            $objActSheet->setCellValue("B$k","$chs_name");
            $objActSheet->setCellValue("C$k","$value->score");
            $i++;
        }      

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
            $objActSheet->setCellValue("C$i","$std_score");
            $j = $std_score-1;
            $objActSheet->setCellValue("$letter[$j]$i","*");
            $i++;
        }
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
        $objActSheet->mergeCells("E$i:I$i");
        $objActSheet->setCellValue("E$i",'原始分');
        $objActSheet->mergeCells("J$i:N$i");
        $objActSheet->setCellValue("J$i",'标准分');
        $objActSheet->setCellValue("O$i",'简要说明');
        $i++;
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
            $objActSheet->setCellValue("E$i","$score");
            $objActSheet->mergeCells("J$i:N$i");
            $objActSheet->setCellValue("J$i","$std_score");            
            $i++;
        }
        // // $objActSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // // $objActSheet->getStyle('A7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // $objActSheet->getStyle('A7:F30')->getAlignment()->setWrapText(TRUE);
        // $objActSheet->setCellValue('A7','教育经历（自高中毕业后起，含在职教育经历）');
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
        // $factor_name = json_decode($factors[0]->factor_names,true);
        // $factor_name = $factor_name['EPPS'];
        // $factor = Factor::find(
        //     array(
        //          "name IN ({name:array})", 'bind' => array('name'=>$factor_name)
        //          ));

        // echo "<pre>";
        // print_r($factor);
        // print_r($factor_name);exit;
        
    }

    public static function checkoutScl($examinee ,$excel,$project_id){
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(22);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:E1');
        $objActSheet->setCellValue('A1','SCL90 测试结果');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','分类号');
        $objActSheet->setCellValue('A3','编号');
        $objActSheet->setCellValue('A4','姓名');
        $objActSheet->setCellValue('B2',$examinee->name);
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
        // print_r($factor_name);exit;
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
        $factors = ProjectDetail::find(
            array(
                 "project_id = :project_id:", 'bind' => array('project_id'=>$project_id)
                 )
            );
        $factor_name = json_decode($factors[0]->factor_names,true);
        $factor_name = $factor_name['CPI'];
        // print_r($factor_name);exit;
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
            $std_score = $factorAns[0]->std_score;
            $objActSheet->setCellValue("B$i","$factor_chs_name");
            $objActSheet->setCellValue("C$i","$value");
            $objActSheet->getStyle("D$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle("D$i")->getFont()->setBold(true);
            $objActSheet->setCellValue("D$i","$std_score");
            $i++;
        }
    }

    public static function checkoutCpi($examinee,$excel){
        //todo
    }

    public static function checkoutSpm($examinee,$excel){
        //todo
    }

    public static function checkoutIndexArray($examinee,$excel){
        //todo
    }

    public static function checkoutStruct($examinee,$excel){
        //todo
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