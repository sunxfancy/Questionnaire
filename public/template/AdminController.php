<?php
    /*
    * @Author: sxf
    * @Date:   2014-10-15 19:33:55
    * @Last Modified by:   笑凡
    * @Last Modified time: 2015-01-03 10:54:44
    */

    include("../app/classes/PHPExcel.php");

    /**
     * 超级管理员控制页面
     */
    class AdminController
        extends Base
    {
        public function initialize()
        {
            Phalcon\Tag::setTitle('系统管理');
            parent::initialize();
        }



        public function uploadAction()
        {
            if ($this->request->isPost())
            {
                if ($this->request->hasFiles())
                {
                    $files = $this->request->getUploadedFiles();
                    $filename = "A-".date("YmdHis");
                    $i = 1;
                    foreach ($files as $file)
                    {
                        $file->moveTo("./upload/".$filename."-".$i.".xls");
                        $i++;
                    }
                    $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
                    echo json_encode($this->addquestions($filename));
                    $this->view->disable();
                }
                else
                {
                    $this->flash->error("请求数据无效!");
                    $this->response->redirect("admin/index");
                }
            }
            else
            {
                $this->flash->error("请求数据无效!");
                $this->response->redirect("admin/index");
            }
        }

        public function addquestions($filename)
        {
            PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
            $files = scandir("./upload");
            array_shift($files);
            array_shift($files);
            $errors = array();
            $factors = array();
            $j = 0;
            $this->db->begin();
            foreach ($files as $file)
            {
                if (strstr($file, $filename))
                {
                    $objexcel = PHPExcel_IOFactory::load("./upload/".$file);
                    $factorsheet = $objexcel->getSheet(0);
                    $questionsheet = $objexcel->getSheet(1);
                    $part = new Part();
                    $part->type = 0;
                    $part->name = (string)$factorsheet->getCell("B2")
                                                      ->getValue();
                    $part->description = (string)$factorsheet->getCell("B3")
                                                             ->getValue();
                    try
                    {
                        if (!$part->save())
                        {
                            $errors[$j]['error'] = "part";
                            foreach ($part->getMessages() as $key => $message)
                            {
                                $errors[$j][$key] = $message;
                            }
                            $j++;
                            $this->db->rollback();
                            $objexcel->disconnectWorksheets();
                            unlink("./upload/".$file);

                            return $errors;
                        }
                        else
                        {
                            $higestrow = $factorsheet->getHighestRow();
                            $i = 5;
                            while ($i <= $higestrow)
                            {
                                $factor = new Factor();
                                $factor->ratio = $factorsheet->getCell("B".$i)
                                                             ->getValue();
                                $k = $factorsheet->getCell("A".$i)
                                                 ->getValue();
                                if (is_null($k) || $k == "") break;
                                if ($factor->save())
                                {
                                    $factors["$k"] = $factor->f_id;
                                    $fprel = new Fprel();
                                    $fprel->factor_id = $factor->f_id;
                                    $fprel->part_id = $part->p_id;
                                    if (!$fprel->save())
                                    {
                                        $errors[$j]['error'] = "fprel";
                                        foreach ($fprel->getMessages() as $key => $message)
                                        {
                                            $errors[$j][$key] = $message;
                                        }
                                        $j++;
                                        $this->db->rollback();
                                        $objexcel->disconnectWorksheets();
                                        unlink("./upload/".$file);

                                        return $errors;
                                    }
                                }
                                else
                                {
                                    $errors[$j]['error'] = "factor";
                                    foreach ($factor->getMessages() as $key => $message)
                                    {
                                        $errors[$j][$key] = $message;
                                    }
                                    $j++;
                                    $this->db->rollback();
                                    $objexcel->disconnectWorksheets();
                                    unlink("./upload/".$file);

                                    return $errors;
                                }
                                $i++;
                            }
                            $higestrow = $questionsheet->getHighestRow(); //不可靠
                            $i = 3;
                            while ($i <= $higestrow)
                            {
                                $question = new Question();
                                $topic = (string)$questionsheet->getCell("A".$i)
                                                               ->getValue();
                                if (is_null($topic) || $topic == "") break;
                                $question->topic = $topic;
                                $question->factor_id = $factors[$questionsheet->getCell("C".$i)
                                                                              ->getValue()];
                                $question->options = "";
                                $question->grade = "";
                                $col = "D";
                                $colnum = $questionsheet->getCell("B".$i)
                                                        ->getValue();
                                for ($k = 1; $k <= $colnum; $k++, $col++)
                                {
                                    $str = $questionsheet->getCell($col.$i)
                                                         ->getValue();
                                    $mem = explode("|", $str);
                                    $question->options .= "|".$mem[0];
                                    $question->grade .= "|".$mem[1];
                                }
                                $question->options = substr($question->options, 1);
                                $question->grade = substr($question->grade, 1);
                                if (!$question->save())
                                {
                                    $errors[$j]['error'] = "question";
                                    $errors[$j]['maxrow'] = $higestrow;
                                    foreach ($question->getMessages() as $key => $message)
                                    {
                                        $errors[$j][$key] = $message;
                                    }
                                    $j++;
                                    $this->db->rollback();
                                    $objexcel->disconnectWorksheets();
                                    unlink("./upload/".$file);

                                    return $errors;
                                }
                                $i++;
                            }
                        }
                    }
                    catch (PDOException $ex)
                    {
                        foreach ($ex->getMessages() as $key => $message)
                        {
                            $errors[$j][$key] = $message;
                        }
                        $j++;
                        $this->db->rollback();
                        $objexcel->disconnectWorksheets();
                        unlink("./upload/".$file);
                        throw $ex;
                        //return $errors;
                    }
                    $objexcel->disconnectWorksheets();
                    unlink("./upload/".$file);
                }
            }
            $this->db->commit();

            return $errors;
        }

     

        

        public function datareturn($builder)
        {
            $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
            $limit = $this->request->getQuery('rows', 'int');
            $page = $this->request->getQuery('page', 'int');
            if (is_null($limit)) $limit = 10;
            if (is_null($page)) $page = 1;
            $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array("builder" => $builder,
                                                                          "limit" => $limit,
                                                                          "page" => $page));
            $page = $paginator->getPaginate();
            //print_r($page->items);
            $ans = array();
            $ans['total'] = $page->total_pages;
            $ans['page'] = $page->current;
            $ans['records'] = $page->total_items;
            foreach ($page->items as $key => $item)
            {
                $ans['rows'][$key] = $item;
            }
            echo json_encode($ans);
            $this->view->disable();
        }

        public function datareturnforuser($builder)
        {
            $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
            $limit = $this->request->getQuery('rows', 'int');
            $page = $this->request->getQuery('page', 'int');
            if (is_null($limit)) $limit = 10;
            if (is_null($page)) $page = 1;
            $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array("builder" => $builder,
                                                                          "limit" => $limit,
                                                                          "page" => $page));
            $page = $paginator->getPaginate();
            //print_r($page->items);
            $ans = array();
            $ans['total'] = $page->total_pages;
            $ans['page'] = $page->current;
            $ans['records'] = $page->total_items;
            foreach ($page->items as $key => $item)
            {
                $item->password = '***';
                $ans['rows'][$key] = $item;
            }
            echo json_encode($ans);
            $this->view->disable();
        }

        public function setsettingsAction()
        {
            $settings = array();
            // $settings['url'] = $this->request->getPost('url');
            $settings['host'] = $this->request->getPost('host');
            $settings['from'] = $this->request->getPost('from');
            $settings['username'] = $this->request->getPost('username');
            $settings['password'] = $this->request->getPost('password');
            // print_r($settings);
            $str = json_encode($settings);
            $file = __DIR__."/../config/settings.json";
            $fs = fopen($file, 'w');
            fwrite($fs, $str);
            fclose($fs);
            // $this->writeFile("../config/settings.json",json_encode($settings));
            $this->response->redirect('admin');
        }

        public function exportAction($school_id) {
            $this->view->disable();
            ini_set('display_errors', 0);
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '100');
            if ($this->request->isGet())
            {
                $this->response->setHeader("Content-Type", "application/force-download");
                $this->response->setHeader("Content-Transfer-Encoding", "binary");
                $this->response->setHeader("Pragma", "no-cache");
                $this->response->setHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
                $base_row = 5;
                $excel = new PHPExcel();
                $sheet = $excel->getSheet(0);
                $sheet->setTitle("sheet0");
                $filename = $this->create_uuid().".xls";
                // $manager = $this->session->get("Manager");
                // $test_id = $this->request->get("test_id");
                // $school_id = $manager["school_id"];
                $test = Test::findFirst("school_id = $school_id");
                $school = School::findFirst($school_id);
                $sheet->setCellValue("A1", "学校");
                $sheet->setCellValue("B1", $school->name);
                $sheet->setCellValue("A2", "地区");
                $sheet->setCellValue("B2", $school->district);
                $sheet->setCellValue("A3", "测试名称");
                $sheet->setCellValue("B3", $test->description);
                $sheet->setCellValue("A4", "姓名");
                $sheet->setCellValue("B4", "学号");
                $sheet->setCellValue("C4", "性别");
                $sheet->setCellValue("D4", "出生日期");
                $sheet->setCellValue("E4", "民族");
                $sheet->setCellValue("F4", "是否独生子女");
                $sheet->setCellValue("G4", "生源地");
                $sheet->setCellValue("H4", "院系");
                $sheet->setCellValue("I4", "专业");
                $sheet->setCellValue("J4", "年级");
                $sheet->setCellValue("K4", "班级");

                // $base_col = "L";
                // foreach ($test->Part as $part)
                // {
                //     $sheet->setCellValue($base_col."4", $part->name);
                //     $base_col++;
                // }

                foreach ($test->Student as $student)
                {
                    try {
                        $sheet->setCellValue("A".$base_row, $student->name);
                        $sheet->setCellValue("B".$base_row, $student->stu_no);
                        $sex = $student->sex==0 ? "女" : "男";
                        $sheet->setCellValue("C".$base_row, $sex);
                        $sheet->setCellValue("D".$base_row, $student->birthday);
                        $sheet->setCellValue("E".$base_row, $student->nation);
                        $singleton = $student->singleton==0 ? "否" : "是";
                        $sheet->setCellValue("F".$base_row, $singleton);
                        $nativeplace = $student->nativeplace==0 ? "农村" : "城镇";
                        $sheet->setCellValue("G".$base_row, $nativeplace);
                        $sheet->setCellValue("H".$base_row, $student->college);
                        $sheet->setCellValue("I".$base_row, $student->major);
                        $sheet->setCellValue("J".$base_row, $student->grade);
                        $sheet->setCellValue("K".$base_row, $student->class);
                    } catch(Exception $e) {}

                    $base_col = "L";
                    $a=array('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5,'f'=>6,'g'=>7,'h'=>8,'i'=>9,'j'=>10,'k'=>11,'l'=>12,'m'=>13,'n'=>14,'o'=>15,'p'=>16,'q'=>17,'r'=>18,'s'=>19,'t'=>20,'u'=>21,'v'=>22,'w'=>23,'x'=>24,'y'=>25,'z'=>26);
                    try {
                        foreach($student->Total as $total)
                        {
                            $answers = strtolower($total->answers);
                            $len = strlen($answers);
                            if (isset($answers) && ($len!=0))
                                for ($i = 0;$i<$len;++$i) {
                                    $sheet->setCellValue("$base_col"."$base_row",$a[$answers[$i]]);
                                    $sheet->setCellValue("$base_col"."4",$i+1);
                                    $base_col++;
                                }
                        }
                    } catch (Exception $e) {}
                    $base_row++;
                }

                $writer = PHPExcel_IOFactory::createWriter($excel, "Excel5");
                $writer->save("../cache/temp/$filename");
                $excel->disconnectWorksheets();
                $this->response->setFileToSend("../cache/temp/$filename", $school->name."学生资料.xls");
                $this->response->send();
               //return $response;
            }

        }

        private function create_uuid($prefix = "")
        {    //可以指定前缀
            $str = md5(uniqid(mt_rand(), true));
            $uuid  = substr($str,0,8) . '-';
            $uuid .= substr($str,8,4) . '-';
            $uuid .= substr($str,12,4) . '-';
            $uuid .= substr($str,16,4) . '-';
            $uuid .= substr($str,20,12);
            return $prefix . $uuid;
        }
    }
