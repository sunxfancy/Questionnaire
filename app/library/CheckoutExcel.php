<?php


class CheckoutExcel extends \Phalcon\Mvc\Controller{
    //以excel形式，导出被试人员信息和测试结果
    

    public static function checkoutExcel11($examinee){
        //导出个人信息表
        require_once("../app/classes/PHPExcel.php");
        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        $cacheSettings = array('memoryCacheSize'=>'256MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $excel = new PHPExcel();
        $excel->getActiveSheet()->setTitle('个人信息表');
        //个人信息表
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