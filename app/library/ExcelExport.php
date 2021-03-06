<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 15/8/27
 * Time: 下午12:35
 */
require_once ("../app/classes/PHPExcel.php");

class ExcelExport 
{
    /**
     * 测试人员导出
     */
    public function ExamineeExport($arr, $project_id){
        $objPHPExcel = new PHPExcel();
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getProperties()->setTitle('测试人员excel');
        $objPHPExcel->getProperties()->setSubject('测试人员excel');
        /**
         * 设置单元格的值
         */
        $objActSheet->setCellValue('A1','用户名');
        $objActSheet->setCellValue('B1','密码');
        $objActSheet->setCellValue('C1','姓名');
        $objActSheet->setCellValue('D1','性别');
        $objActSheet->setCellValue('E1','籍贯');
        $objActSheet->setCellValue('F1','学历');
        $objActSheet->setCellValue('G1','学位');
        $objActSheet->setCellValue('H1','出生日期');
        $objActSheet->setCellValue('I1','政治面貌');
        $objActSheet->setCellValue('J1','职称');
        $objActSheet->setCellValue('K1','班子/系统');
        $objActSheet->setCellValue('L1','工作单位');
        $objActSheet->setCellValue('M1','部门');
        $objActSheet->setCellValue('N1','职务');
        $objActSheet->setCellValue('O1','教育经历');
        $objActSheet->setCellValue('P1','工作经历');
        //将测试人员信息导入到表中
        foreach($arr as $key => $item) {
            $key = $key + 2;
            $objActSheet->setCellValue('A' . $key, $item->number);
            $objActSheet->setCellValue('B' . $key, $item->password);
            $objActSheet->setCellValue('C' . $key, $item->name);
            if ($item->sex == 1) {
                $objActSheet->setCellValue('D' . $key, '男');
            } else {
                $objActSheet->setCellValue('D' . $key, '女');
            }
            $objActSheet->setCellValue('E' . $key, $item->native);
            $objActSheet->setCellValue('F' . $key, $item->education);
            $objActSheet->setCellValue('G' . $key, $item->degree);
            $objActSheet->setCellValue('H' . $key, $item->birthday);
            $objActSheet->setCellValue('I' . $key, $item->politics);
            $objActSheet->setCellValue('J' . $key, $item->professional);
            $objActSheet->setCellValue('K' . $key, $item->team);
            $objActSheet->setCellValue('L' . $key, $item->employer);
            $objActSheet->setCellValue('M' . $key, $item->unit);
            $objActSheet->setCellValue('N' . $key, $item->duty);
            $other = json_decode($item->other, true);
           // $education = json_encode($other['education'], JSON_UNESCAPED_UNICODE);
           // $work = json_encode($other['work'], JSON_UNESCAPED_UNICODE);
            $education = $other['education'];
            $education_string = '[';
            $work_string = '[';
            $work = $other['work'];
            foreach($education as $k => $v){
                $education_string .= '{';
                $education_string .= '学校：'.$v['school'].',';
                $education_string .= '专业：'.$v['profession'].',';
                $education_string .= '学位：'.$v['degree'].',';
                $education_string .= '时间：'.$v['date'];
                $education_string .= '},';
            }
            if($education_string != '['){
                $education_string = substr($education_string,0,strlen($education_string)-1);
            }
            $education_string .= ']';
            foreach($work as $k => $v){
                $work_string .= '{';
                $work_string .= '工作单位：'.$v['employer'].',';
                $work_string .= '部门：'.$v['unit'];
                $work_string .= '职务：'.$v['duty'];
                $work_string .= '时间：'.$v['date'];
                $work_string .= '},';
            }
            if($work_string != '['){
                $work_string = substr($work_string,0,strlen($work_string)-1);
            }
            $work_string .= ']';
            $objActSheet->setCellValue('O' . $key, $education_string);
            $objActSheet->setCellValue('P' . $key, $work_string);
        }
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $file_name = './tmp/'.$project_id.'_examinees.xls';
        $objWriter->save($file_name);
        return $file_name;
    }

    /*
     *面询专家导出
     */
    public function InterviewerExport($arr, $project_id){
        return $this->managerExport($arr,'I', $project_id);
    }

    /*
     * 领导导出
     */
    public function LeaderExport($arr, $project_id){
       return  $this->managerExport($arr,'L', $project_id);
    }

    public function managerExport($arr,$role, $project_id){
        $objPHPExcel = new PHPExcel();
        $objActSheet = $objPHPExcel->getActiveSheet();
        /*
         * excel属性
         */
        $file_name = '';
        if($role == 'L'){
            $objPHPExcel->getProperties()->setTitle('领导excel');
            $objPHPExcel->getProperties()->setSubject('领导excel');
            $file_name = './tmp/'.$project_id.'_leaders.xls';
        }else if ($role == 'I'){
            $objPHPExcel->getProperties()->setTitle('面询专家excel');
            $objPHPExcel->getProperties()->setSubject('面询专家excel');
            $file_name = './tmp/'.$project_id.'_interviewers.xls';
        }else {
        	throw new Exception('No this type-'.$role);
        }
        /*
         * 设置单元格的值
         */
        $objActSheet->setCellValue('A1','用户名(编号)');
        $objActSheet->setCellValue('B1','密码');
        $objActSheet->setCellValue('C1','姓名');
        $objActSheet->setCellValue('D1','项目编号');

        foreach($arr as $key => $item){
            $key = $key + 2;
            $objActSheet->setCellValue('A'.$key,$item->username);
            $objActSheet->setCellValue('B'.$key,$item->password);
            $objActSheet->setCellValue('C'.$key,$item->name);
            $objActSheet->setCellValue('D'.$key,$item->project_id);
        }
        $objActSheet->getColumnDimension('A')->setAutoSize(true);
        $objActSheet->getColumnDimension('B')->setAutoSize(true);
        $objActSheet->getColumnDimension('C')->setAutoSize(true);
        $objActSheet->getColumnDimension('D')->setAutoSize(true);
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save($file_name);
        return $file_name;
    }

}