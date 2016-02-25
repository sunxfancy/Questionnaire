<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 15/8/27
 * Time: 下午12:35
 */
require_once ("../app/classes/PHPExcel.php");

class ExcelExport extends \Phalcon\Mvc\Controller
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

    public function ExamineeExportSimple($arr, $project_id){
        $objPHPExcel = new PHPExcel();
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getProperties()->setTitle('测试人员excel简版');
        $objPHPExcel->getProperties()->setSubject('测试人员excel简版');
        /**
         * 设置单元格的值
         */
        $objActSheet->setCellValue('A1','用户名');
        $objActSheet->setCellValue('B1','密码');
        $objActSheet->setCellValue('C1','姓名');
        // $objActSheet->setCellValue('D1','性别');
        // $objActSheet->setCellValue('E1','籍贯');
        // $objActSheet->setCellValue('F1','学历');
        // $objActSheet->setCellValue('G1','学位');
        // $objActSheet->setCellValue('H1','出生日期');
        // $objActSheet->setCellValue('I1','政治面貌');
        // $objActSheet->setCellValue('J1','职称');
        // $objActSheet->setCellValue('K1','班子/系统');
        // $objActSheet->setCellValue('L1','工作单位');
        // $objActSheet->setCellValue('M1','部门');
        // $objActSheet->setCellValue('N1','职务');
        // $objActSheet->setCellValue('O1','教育经历');
        // $objActSheet->setCellValue('P1','工作经历');
        //将测试人员信息导入到表中
        foreach($arr as $key => $item) {
            $key = $key + 2;
            $objActSheet->setCellValue('A' . $key, $item->number);
            $objActSheet->setCellValue('B' . $key, $item->password);
            $objActSheet->setCellValue('C' . $key, $item->name);
           //  if ($item->sex == 1) {
           //      $objActSheet->setCellValue('D' . $key, '男');
           //  } else {
           //      $objActSheet->setCellValue('D' . $key, '女');
           //  }
           //  $objActSheet->setCellValue('E' . $key, $item->native);
           //  $objActSheet->setCellValue('F' . $key, $item->education);
           //  $objActSheet->setCellValue('G' . $key, $item->degree);
           //  $objActSheet->setCellValue('H' . $key, $item->birthday);
           //  $objActSheet->setCellValue('I' . $key, $item->politics);
           //  $objActSheet->setCellValue('J' . $key, $item->professional);
           //  $objActSheet->setCellValue('K' . $key, $item->team);
           //  $objActSheet->setCellValue('L' . $key, $item->employer);
           //  $objActSheet->setCellValue('M' . $key, $item->unit);
           //  $objActSheet->setCellValue('N' . $key, $item->duty);
           //  $other = json_decode($item->other, true);
           // // $education = json_encode($other['education'], JSON_UNESCAPED_UNICODE);
           // // $work = json_encode($other['work'], JSON_UNESCAPED_UNICODE);
           //  $education = $other['education'];
           //  $education_string = '[';
           //  $work_string = '[';
           //  $work = $other['work'];
           //  foreach($education as $k => $v){
           //      $education_string .= '{';
           //      $education_string .= '学校：'.$v['school'].',';
           //      $education_string .= '专业：'.$v['profession'].',';
           //      $education_string .= '学位：'.$v['degree'].',';
           //      $education_string .= '时间：'.$v['date'];
           //      $education_string .= '},';
           //  }
           //  if($education_string != '['){
           //      $education_string = substr($education_string,0,strlen($education_string)-1);
           //  }
           //  $education_string .= ']';
           //  foreach($work as $k => $v){
           //      $work_string .= '{';
           //      $work_string .= '工作单位：'.$v['employer'].',';
           //      $work_string .= '部门：'.$v['unit'];
           //      $work_string .= '职务：'.$v['duty'];
           //      $work_string .= '时间：'.$v['date'];
           //      $work_string .= '},';
           //  }
           //  if($work_string != '['){
           //      $work_string = substr($work_string,0,strlen($work_string)-1);
           //  }
           //  $work_string .= ']';
           //  $objActSheet->setCellValue('O' . $key, $education_string);
           //  $objActSheet->setCellValue('P' . $key, $work_string);
        }
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $file_name = './tmp/'.$project_id.'_examinees_simple.xls';
        $objWriter->save($file_name);
        return $file_name;
    }

    #用户原始答案导出
    public function anstableExport($examinee,$manager){
      //参数$examinee已经被验证过了，为了安全，再一次进行验证
        if (!isset($examinee->id) ){
          return false;
        }
        if ($examinee->state < 1 ){
          return false;
        }

        $objPHPExcel = new PHPExcel();
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getProperties()->setTitle($examinee->id.'原始答案');
        $objPHPExcel->getProperties()->setSubject($examinee->id.'原始答案');
        /**
         * 设置单元格的值
         */

        /**
         * 设置单元格的值
         */
        $max=0;
        #第二列
        $objActSheet->setCellValue('B1','需求量表');
        $inquery_ans=InqueryAns::findFirst(array(
          "examinee_id=?1",
          "bind"=>array(1=>$examinee->id)
          ));
          if($inquery_ans){
              $anstable_arr=explode("|", $inquery_ans->option);
              foreach ($anstable_arr as $key => $anstable_ar) {
                  # code...
                  $objActSheet->setCellValue('B'.($key+2),$anstable_ar);
              }
              $max=sizeof($anstable_arr);
          }
        
        $charsets=array("C","D","E","F","G","H");
        $answers=QuestionAns::find(array(
            "examinee_id=?1",
            "bind"=>array(1=>$examinee->id)
          ));

        #第三~八列
        if($answers){
          foreach ($answers as $key => $answer) {
            # code...
            $paper_id=$answer->paper_id;

            $paper=Paper::findFirst($paper_id);
            $objActSheet->setCellValue($charsets[$key]."1",$paper->name);
            $answer_option=$answer->option;
            $lists=$answer->question_number_list;
            $anstables=explode("|", $answer_option);
            $list=explode("|", $lists);
            foreach ($anstables as $i => $anstable) {
                # code...
                $objActSheet->setCellValue($charsets[$key].(intval($list[$i])+1),$anstable);
            }
            $max<sizeof($list)&&$max=sizeof($list);
          }

        }

        $objActSheet->setCellValue('A1',"题号");
        for ($i=0; $i < $max ; $i++) { 
          # code...
          $objActSheet->setCellValue('A'.($i+2),$i+1);
        }
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $year = floor($manager->project_id/ 100 );
        $path="/project/".$year."/".$manager->project_id."/individual/personal_anstable/";
        $handle=new FileHandle();
        $handle->mk_dir(".".$path);
        $file_name_trans = $path.$examinee->number."_personal_anstable.xls";
        $file_name= iconv("utf-8", "gb2312", $file_name_trans);
        $objWriter->save(".".$file_name);
        return $file_name_trans;
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

    /*导出用户分析表*/
    public function personalanalysisExport($examinee,$manager){
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setTitle($examinee->id.'analysis_evaluation');
        $objPHPExcel->getProperties()->setSubject($examinee->id.'analysis_evaluation');


        
        // $indexs=$this->getindividualComprehensive($examinee->id);
        // $indexChildren=$this->getIndexsChildren('zb_xljksp',$examinee);
        // echo '<pre/>';
        // print_r($indexs);
        // print_r($indexChildren);
          $objActSheet2=$objPHPExcel -> createSheet(1);
          $cachePos=$this->fillSheet2($objActSheet2,$examinee);
         //print_r($cachePos);
          $this->fillSheet1($objPHPExcel,$examinee,$cachePos);

          $objActSheet3=$objPHPExcel -> createSheet();
          $this->fillSheet3($objActSheet3,$examinee);

      $objActSheet4=$objPHPExcel -> createSheet();
          $this->fillSheet4($objActSheet4,$examinee);

          $objActSheet5=$objPHPExcel -> createSheet();
          $this->fillSheet5($objActSheet5,$examinee);

          $objActSheet = $objPHPExcel->createSheet();
          $this->fillSheet6($objActSheet,$examinee);


        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
          $year = floor($manager->project_id/ 100 );
          $path="/project/".$year."/".$manager->project_id."/individual/personal_analysis_evaluation/";
          if(!is_dir(".".$path)){
            $handle=new FileHandle();
            $handle->mk_dir(".".$path);
          }
          $file_name_trans = $path.$examinee->number."_personal_analysis_evaluation.xls";
          $file_name= iconv("utf-8", "gb2312", $file_name_trans);
          $objWriter->save(".".$file_name);
          return $file_name;
      
    }

    function fillCell($cellarr,$valuearr,$objActSheet){
      foreach ($cellarr as $key => $cellar) {
        # code...
          $objActSheet->setCellValue($cellar,$valuearr[$key]?$valuearr[$key]:"");
      }
    }

    function fillSheet1($objPHPExcel,$examinee,$cachePos){
            $cells=array();
            $values=array();
            $objPHPExcel->setActiveSheetIndex(0);
            $objActSheet = $objPHPExcel->getActiveSheet();
            $objActSheet -> setTitle("28指标位置");
            

            $indexs=Index::find();
            $objActSheet->getColumnDimension('B')->setWidth(20);
            $objActSheet->setCellValue('C1',"location");
            $objActSheet->setCellValue('D1',"starting");
            $objActSheet->setCellValue('E1',"ending");
            $objActSheet->setCellValue('F1',"keyscore");

            foreach ($indexs as $key => $index) {
              # code...
              $chname=$index->chs_name;
              $cells[]='A'.($key+2);
              $values[]=$key+1;
              $cells[]='B'.($key+2);
              $values[]=$chname;
              $cells[]='D'.($key+2);
              $values[]=$cachePos[$chname][0];
              $cells[]='E'.($key+2);
              $values[]=$cachePos[$chname][2];
              $cells[]='F'.($key+2);
              $values[]=$cachePos[$chname][1];              
            }
            $this->fillCell($cells,$values,$objActSheet);
    }

    function fillSheet2($objActSheet,$examinee){
          $cachePos=array();
          $objActSheet->setTitle('Sheet1');
          $objActSheet->getColumnDimension('A')->setWidth(20);
          $objActSheet->mergeCells('B1:E1');
          $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $cells=array('A1','A2');
          $values=array('被测人员编号',$examinee->number);
          $chars_offset=0;
          $chars=array('一','二','三','四');
          $offset=2;
          $modules=$this->getindividualComprehensive($examinee->id);
          foreach ($modules as $key => $module) {
            # code...
            $offset++;
            //处理单块第一行
            $objActSheet->mergeCells('B'.$offset.':E'.$offset);
            $cells[]='B'.$offset;
            $values[]=$chars[$chars_offset].$key.'评价指标';
            $objActSheet->getStyle('B'.$offset)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $chars_offset++;

            //处理单块第二行
            $offset++;
            $cells[]='B'.$offset;
            $values[]='组合因素';
            $cells[]='C'.$offset;
            $values[]='原始分';
            $cells[]='D'.$offset;
            $values[]='综合分';
            $cells[]='E'.$offset;
            $values[]='评价结果';
            $offset+=2;

            //循环各节
            foreach ($module as $key => $module_index) {
              # code...
              //处理单节第一行(附带因子数量)
              $index_name=$module_index['name'];
              $indexChildren=$this->getIndexsChildren($index_name,$examinee);
              $cells[]='A'.$offset;
              $values[]=$indexChildren['chs_name'];
              //记录各分数所在位置
              $cachePos[$indexChildren['chs_name']]=array();
              $cachePos[$indexChildren['chs_name']][]=$offset-1;
              $cells[]='A'.($offset+1);
              $values[]=$indexChildren['count'];
              $children=$indexChildren['children'];
              //循环因子各行
              foreach ($children as $key => $child) {
                # code...
                $cells[]='B'.$offset;
                $values[]=$child['name'];
                $cells[]='C'.$offset;
                $values[]=$child['raw_score'];
                $cells[]='D'.$offset;
                $values[]=$child['ans_score'];
                $offset++;
              }
              $cells[]='D'.$offset;
              $values[]=$module_index['score'];
              $cachePos[$indexChildren['chs_name']][]=$offset+1-$cachePos[$indexChildren['chs_name']][0];
              $offset++;
              $cachePos[$indexChildren['chs_name']][]=$offset-1;

              $objActSheet->getStyle('A'.$offset.':E'.$offset)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
              $objActSheet->getStyle('A'.$offset.':E'.$offset)->getFill()->getStartColor()->setARGB('FF808080');
              $offset++;

            }
            


          }


          $this->fillCell($cells,$values,$objActSheet);
          return $cachePos;
    }
    function fillSheet3($objActSheet,$examinee){
      $objActSheet -> setTitle("All items");
          $objActSheet->getColumnDimension('A')->setWidth(20);
          $objActSheet->getColumnDimension('A')->setWidth(15);
          $objActSheet->mergeCells('B1:E1');
          $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $factor_ans_objs=FactorAns::find(array(
              "examinee_id=?1",
              "bind"=>array(1=>$examinee->id)
            ));
          $cells=array('B1','A2','A3','B4','C4','D4','E4');
          $values=array('一、心理健康评价指标','被测人员编号',$examinee->number,'组合因素','原始分','综合分','评价结果');
          $offset=5;
          foreach ($factor_ans_objs as $key => $factor_ans_obj) {
            # code..
            $factor=Factor::findFirst($factor_ans_obj->factor_id);
            $factor_chs_name=$factor->chs_name;
            if($factor_chs_name=='SPM(A)'||$factor_chs_name=='SPM(B)'||$factor_chs_name=='SPM(C)'||$factor_chs_name=='SPM(D)'||$factor_chs_name=='SPM(E)'||$factor_chs_name=='SPM(A、B、C)'){
              $offset--;
              continue;
            }
            $cells[]="A".($key+$offset);
            $values[]=$key+$offset-4;
            $cells[]='B'.($key+$offset);
            $values[]=$factor_chs_name;
            $cells[]='C'.($key+$offset);
            $values[]=$factor_ans_obj->score;
            $cells[]='D'.($key+$offset);
            $values[]=$factor_ans_obj->ans_score;

          }
      $this->fillCell($cells,$values,$objActSheet);
    }
    function fillSheet4($objActSheet,$examinee){
      $objActSheet -> setTitle("项目排序");
          $objActSheet->getColumnDimension('A')->setWidth(20);
          $objActSheet->getColumnDimension('A')->setWidth(15);
          $objActSheet->mergeCells('B1:E1');
          $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

     $factor_ans_objs = $this->modelsManager->createBuilder()
                                       ->columns(array( 
                                        'FactorAns.factor_id as factor_id',
                                        'FactorAns.score as score',
                                        'FactorAns.ans_score as ans_score'
                                          ))
                                       ->from('FactorAns')
                                       ->inwhere("examinee_id",array($examinee->id))
                                       ->orderBy('FactorAns.ans_score desc')
                                       ->getQuery()
                                       ->execute();
          $cells=array('B1','A2','A3','B4','C4','D4','E4');
          $values=array('73项组合因素综合分排序','被测人员编号',$examinee->number,'组合因素','原始分','综合分','评价结果');
          $offset=5;
          foreach ($factor_ans_objs as $key => $factor_ans_obj) {
            # code..
            $factor=Factor::findFirst($factor_ans_obj->factor_id);
            $factor_chs_name=$factor->chs_name;
            if($factor_chs_name=='SPM(A)'||$factor_chs_name=='SPM(B)'||$factor_chs_name=='SPM(C)'||$factor_chs_name=='SPM(D)'||$factor_chs_name=='SPM(E)'||$factor_chs_name=='SPM(A、B、C)'){
              $offset--;
              continue;
            }
            $cells[]="A".($key+$offset);
            $values[]=$key+$offset-4;
            $cells[]='B'.($key+$offset);
            $values[]=$factor_chs_name;
            $cells[]='C'.($key+$offset);
            $values[]=$factor_ans_obj->score;
            $cells[]='D'.($key+$offset);
            $values[]=$factor_ans_obj->ans_score;

          }
      $this->fillCell($cells,$values,$objActSheet);
    }

    function fillSheet5($objActSheet,$examinee){
      $objActSheet -> setTitle("排序");
          $objActSheet->getColumnDimension('B')->setWidth(20);
          $objActSheet->mergeCells('A1:B1');
          $cells=array('A1','C1','D1','E1');
          $values=array('被测编号',$examinee->number,'姓名',$examinee->name);

          $index_ans_objs=$this->modelsManager->createBuilder()
                                       ->columns(array( 
                                        'IndexAns.index_id as index_id',
                                        'IndexAns.score as score'
                                          ))
                                       ->from('IndexAns')
                                        ->inwhere("examinee_id",array($examinee->id))
                                       ->orderBy('IndexAns.score desc')
                                       ->getQuery()
                                       ->execute();
            $offset=2;
            foreach ($index_ans_objs as $key => $index_ans_obj) {
              # code...
              $index=Index::findFirst($index_ans_obj->index_id);
              $index_chs_name=$index->chs_name;
              $cells[]="A".($key+$offset);
            $values[]=$key+$offset-1;
            $cells[]='B'.($key+$offset);
            $values[]=$index_chs_name;
            $cells[]='C'.($key+$offset);
            $values[]=$index_ans_obj->score;

            if($key<8){
              $cells[]='D'.($key+$offset);
              $values[]='★';
            }else if($key>sizeof($index_ans_objs)-6){
              $cells[]='D'.($key+$offset);
              $values[]='●';
            }
            
            }
          $this->fillCell($cells,$values,$objActSheet);
    }

    function fillSheet6($objActSheet,$examinee){
      $objActSheet->setTitle("排序新版");
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

    function position($objActSheet, $pos, $h_align='center'){
        $objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
        $objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->getStyle($pos.':'.$pos)->getAlignment()->setWrapText(true);
      }
      
    function getindividualComprehensive($examinee_id){
      $project_id = Examinee::findFirst($examinee_id)->project_id;
      $project_detail = 
      ProjectDetail::findFirst(
      array (
      "project_id = :project_id:",
      'bind' => array ('project_id' => $project_id),
      ));
      
      if(empty($project_detail) || empty($project_detail->module_names)){
        throw new Exception('项目配置信息有误');
      }
      $exist_module_array = explode(',',$project_detail->module_names);
      $module_array = array("心理健康"=>'mk_xljk',"素质结构"=>'mk_szjg',"智体结构"=>'mk_ztjg',"能力结构"=>'mk_nljg');
      $module_array_score = array();
      foreach($module_array as $key => $value){
        if (!in_array($value, $exist_module_array)){
          continue;
        }
        $module_record =Module::findFirst(
        array(
        "name = ?1",
        'bind' => array(1=>$value)) );
        $children = $module_record->children;
        $children_array = explode(',', $children);
        $result_1 = $this->modelsManager->createBuilder()
        ->columns(array(
            'Index.chs_name as chs_name',
            'Index.name as name',
            'IndexAns.score as score',
            'Index.children as children'
        ))
        ->from('Index')
        ->inwhere('Index.name', $children_array)
        ->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
        ->orderBy('IndexAns.score desc')
        ->getQuery()
        ->execute()
        ->toArray();
        //进行规范排序
        $module_array_score[$key] = array();
        foreach($result_1 as &$result_1_record){
          $skey = array_search($result_1_record['name'], $children_array);
          $module_array_score[$key][$skey] = $result_1_record;
        }
      }
      return $module_array_score;
    }

    function getIndexsChildren($index_name,$examinee){
      $strong_exist_array = array();
      $strong_value=array('name'=>$index_name);
      $index = Index::findFirst(array('name=?1','bind'=>array(1=>$strong_value['name'])));
      $strong_value['chs_name'] = $index->chs_name;
      $middle = array();
      $middle = MiddleLayer::find(array('father_chs_name=?1', 'bind'=>array(1=>$strong_value['chs_name'])))->toArray();
      $children = array();
      $children = $this->getChildrenOfIndexDesc($index->name, $index->children, $examinee->id);
      foreach($children as &$children_info){
        if(!isset($children_info['raw_score'])){
          $children_info['raw_score'] = null;
        }
      }
      $strong_value['count'] = count($children);
      $tmp = array();
      $children = $this->foo($children, $tmp);  
      //先进行去重选择
      $child_xuhao = array();
      $qiansan = 1; 
      for($i = 0, $len = count($children); $i < $len; $i += 4 ){
        if (in_array($children[$i], $strong_exist_array )){
          $child_xuhao[$children[$i]] = null;
        }else{
          if ($qiansan > 3 ){
            $child_xuhao[$children[$i]] = null;
          }else {
            $child_xuhao[$children[$i]] = $qiansan++;
            $strong_exist_array[] = $children[$i];
          } 
        }
      }

      $strong_value['children'] = array();
      $number_count = 0;
      foreach ($middle as $middle_info ){
        $outter_tmp = array();
        $middle_children = explode(',',$middle_info['children']);
        $outter_tmp_score = 0;
        foreach ($middle_children as $children_name){
          $inner_tmp = array();
          $key = array_search($children_name, $children);
          $inner_tmp['name'] = $children_name;
          $inner_tmp['raw_score'] = $children[$key+3];
          $inner_tmp['ans_score'] = $children[$key+1];
          $outter_tmp_score += $inner_tmp['ans_score'];
          $inner_tmp['number'] = $child_xuhao[$children_name];
          $strong_value['children'][] = $inner_tmp;
        }
        $outter_tmp['name'] = null;
        $outter_tmp['raw_score'] = null;
        $outter_tmp['ans_score'] = $outter_tmp_score;
        $outter_tmp['number'] = null;
        $strong_value['children'][] = $outter_tmp;
      }
      return $strong_value;
    }

    function getChildrenOfIndexDesc($index_name, $children, $examinee_id){  
      $modifyFactors = new ModifyFactors();
      return $modifyFactors->getChildrenOfIndexDescFor85( $index_name,  $children,  $examinee_id );
    }

    function foo($arr, &$rt) {
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