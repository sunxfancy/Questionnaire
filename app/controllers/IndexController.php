<?php
    /*
    * @Author: sxf
    * @Date:   2014-10-12 20:30:11
    * @Last Modified by:   笑凡
    * @Last Modified time: 2014-12-10 00:40:22
    */

    /**
     * 本控制器为学校用户提供管理入口
     */
    include("../app/classes/PHPExcel.php");

    class IndexController
        extends Base
    {

        public function initialize()
        {
            Phalcon\Tag::setTitle('问卷调查管理');
            parent::initialize();

            if ($this->usecdn)
            {
                $this->assets->addCss("http://cdn.staticfile.org/dropzone/3.10.2/css/dropzone.css")
                             ->addCss("http://cdn.staticfile.org/jqgrid/4.6.0/css/ui.jqgrid.css")
                             ->addCss("http://questionnaire-buaa.qiniudn.com/css/ace-bundle.min.css")
                             ->addCss("http://questionnaire-buaa.qiniudn.com/css/backend.css")
                             ->addCss("http://questionnaire-buaa.qiniudn.com/css/daterangepicker-bs3.css");
                $this->assets->collection("header")
                             // ->addJs("http://cdn.staticfile.org/jquery/2.1.1-rc2/jquery.min.js")
                             ->addJs("http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js")
                             ->addJs("http://cdn.staticfile.org/twitter-bootstrap/3.3.0/js/bootstrap.min.js");
                $this->assets->collection('footer')
                             ->addJs("http://questionnaire-buaa.qiniudn.com/js/moment.js")
                             ->addJs("http://cdn.staticfile.org/dropzone/3.10.2/dropzone.min.js")
                             ->addJs("http://questionnaire-buaa.qiniudn.com/js/daterangepicker.js")
                             ->addJs("http://questionnaire-buaa.qiniudn.com/js/backend2.js")
                             ->addJs("http://cdn.staticfile.org/jqgrid/4.6.0/js/jquery.jqGrid.src.js")
                             ->addJs("http://cdn.staticfile.org/jqgrid/4.6.0/js/i18n/grid.locale-cn.js");
            }
            else
            {
                // 本地压缩版
                $this->assets->addCss("pagecss/index.min.css");
                $this->assets->collection("header")
                             ->addJs("js/jquery.js")
                             ->addJs("bootstrap/js/bootstrap.min.js");
                $this->assets->collection('footer')
                             ->addJs("lib/moment.js")
                             ->addJs("lib/dropzone.min.js")
                             ->addJs("lib/daterangepicker.js")
                             ->addJs("js/backend.js");

            }
            $this->assets->collection('footer')
                        ->addJs("js/ZeroClipboard.js");

            $this->assets->collection('header-ie9-css')
                         ->addCss("css/ace-part2.min.css")
                         ->addCss("css/ace-ie.min.css");
            $this->assets->collection('header-ie9')
                         ->addJs("lib/html5shiv.js")
                         ->addJs("lib/ace-extra.min.js");

            $this->view->setTemplateAfter('index-layout');
            date_default_timezone_set("PRC");
        }
        // 
        //  ->addCss("css/font-awesome.min.css")
        //  ->addCss("css/dropzone.css")
        //  ->addCss("jqGrid/css/jquery-ui.min.css")
        //  ->addCss("jqGrid/css/ui.jqgrid.css")
        //  ->addCss("css/ace-fonts.css")
        //  ->addCss("css/ace.min.css")
        //  //sb ace 会用css样式覆盖上面的jqGrid的css
        //  ->addCss("css/ace-rtl.min.css")
        //  ->addCss("css/datepicker.css")

        public function indexAction()
        {
            if (!$this->session->has('type'))
            {
                $this->response->redirect('managerlogin/index');
            }
            else
            {
                if ($this->session->get('type') != 'Manager')
                {
                    $this->flash->error('对不起，您没有访问权限');
                    $this->response->redirect('managerlogin/index');
                }
            }


            if (!$this->checkSchool())
            {
                $this->view->setTemplateAfter('request-layout');
                if ($this->session->get('type') == 'Manager')
                {
                    $this->view->pick('index/request');
                    $manager = $this->session->get('Manager');
                    $id = $manager['id'];
                    $request = Request::findFirst(array('manager_id = :id:',
                                                        'bind' => array('id' => $id),
                                                        'sort' => 'id desc'));
                    if ($request)
                    {
                        $this->view->setVar('statue', $request->statue);
                    }
                    else
                    {
                        $this->view->setVar('statue', -1);
                    }
                }
            }
            $manager = $this->session->get('Manager');
            $name = $manager['name'];
            $this->view->setVar('admin', $name);
        }

        public function checkSchool()
        {
            if ($this->session->has('Manager'))
            {
                $manager = $this->session->get('Manager');
                if (!is_null($manager['school_id']))
                {
                    return true;
                }
            }

            return false;
        }

        public function checkAction()
        {
            if ($this->request->isPost())
            {
                $name = $this->request->getPost("name", "string");
                $district = $this->request->getPost("district", "string");
                $id = 0;
                if ($this->session->has('Manager'))
                {
                    $manager = $this->session->get('Manager');
                    $id = $manager['id'];
                    $request = Request::post($name, $district, $id);
                    if (!$request->save())
        
                    {
                        $this->flash->error('数据库保存不成功');
                        foreach ($request->getMessages() as $message)
                        {
                            $this->flash->error($message);
                        }
                    }
                    else
                    {
                        $this->flash->success('发送成功');
                        $this->response->redirect('index/index');
                    }
                }
                else
                {
                    $this->flash->error('用户未登陆');
                }
            }
        }

        public function modifytestAction($test_id)
        {
            $result = new TestResult();
            $test = Test::findFirst(array("t_id=:t_id:",
                                          "bind" => array("t_id" => $test_id)));
            $type = $test->Part->getFirst() ? $test->Part->getFirst()->type : -1;
            $result->result_type = 1;
            $result->test = array("test_id" => $test->t_id,
                                  "people" => $test->people,
                                  "description" => $test->description,
                                  "begin" => substr($test->begin_time, 0, strlen($test->begin_time) - 3),
                                  "end" => substr($test->end_time, 0, strlen($test->end_time) - 3));
            $result->parts = array();
            foreach ($test->Part as $index => $tp)
            {
                $result->parts[$index] = $tp->p_id;
            }
            $result->type = $type;
            $result->part_list = $this->getpart($type);
            $this->view->setVar("info", $result);
            // 设置url
            $url = $this->makeurl();
            $this->view->setVar("url", $url);
            
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }

        public function addtestAction()
        {
            $this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
            if ($this->request->isPost())
            {
                $test = new Test();
                $sn = $this->request->getPost("date", "string");
                $date = explode(" - ", $sn);
                // $people = $this->request->getPost("people", "int");
                $people = 0;
                $description = $this->request->getPost("description", "string");
                $parts = $this->request->getPost("part");
                $pcount = count($parts);
                $test->people = $people;
                $manager = $this->session->get("Manager");
                $test->school_id = $manager["school_id"];
                $test->begin_time = date("Y-m-d H:i", strtotime($date[0]));
                $test->end_time = date("Y-m-d H:i", strtotime($date[1]));
                $test->exam_num = $pcount;
                $test->description = $description;
                $this->db->begin();
                try
                {
                    if ($test->save())
                    {
                        foreach ($parts as $part)
                        {
                            $tprel = new Tprel();
                            $tprel->test_id = $test->t_id;
                            $tprel->part_id = $part;
                            $tprel->save();
                        }
                        $this->db->commit();
                        echo "true";
                    }
                    else
                    {
                        throw new PDOException();
                    }
                }
                catch (PDOException $ex)
                {
                    $this->db->rollback();
                    echo $ex->getMessage();
                    echo "保存失败";
                }
            }
            else
            {
                echo "请求数据无效!";
            }
            $this->view->disable();
        }

        public function updatetestAction()
        {
            $this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
            if ($this->request->isPost())
            {
                $test_id = $this->request->getPost("test_id", "int");
                $sn = $this->request->getPost("date", "string");
                $date = explode(" - ", $sn);
                // $people = $this->request->getPost("people", "int");
                $people = 0;
                $description = $this->request->getPost("description", "string");
                $parts = $this->request->getPost("part");
                $test = Test::findFirst(array("t_id=:t_id:",
                                              "bind" => array("t_id" => $test_id)));
                $test->people = $people;
                $pcount = count($parts);
                $manager = $this->session->get("Manager");
                $test->school_id = $manager["school_id"];
                $test->begin_time = date("Y-m-d H:i", strtotime($date[0]));
                $test->end_time = date("Y-m-d H:i", strtotime($date[1]));
                $test->exam_num = $pcount;
                $test->description = $description;
                $this->db->begin();
                try
                {
                    if ($test->save())
                    {
                        $tprls = Tprel::find(array("test_id=:test_id:",
                                                   "bind" => array("test_id" => $test->t_id)));
                        foreach ($tprls as $tp)
                        {
                            $tp->delete();
                        }
                        foreach ($parts as $part)
                        {
                            $tprel = new Tprel();
                            $tprel->test_id = $test->t_id;
                            $tprel->part_id = $part;
                            $tprel->save();
                        }
                        $this->db->commit();
                        echo "true";
                    }
                    else
                    {
                        throw new PDOException();
                    }
                }
                catch (PDOException $ex)
                {
                    $this->db->rollback();
                    echo $ex->getMessage();
                    echo "保存失败";
                }
            }
            else
            {
                echo "请求数据无效";
            }

            $this->view->disable();
        }

        public function importAction($test_id)
        {
            $this->view->setVar("test_id", $test_id);
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }

        public function uploadAction($t_no)
        {
            if ($this->request->isPost())
            {
                if ($this->request->hasFiles())
                {
                    $manager = $this->session->get("Manager");
                    $school_id = $manager["school_id"];
                    $filename = $school_id.'-'.$t_no.'-'.date("YmdHis");
                    $files = $this->request->getUploadedFiles();
                    $i = 1;
                    foreach ($files as $file)
                    {
                        $file->moveTo("./upload/".$filename.'-'.$i.".xls");
                    }
                    $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
                    echo json_encode($this->addstudents($filename, $t_no));
                    $this->view->disable();
                }
                else
                {
                    echo "请求数据无效!";
                }
            }
            else
            {
                echo "请求数据无效!";
            }
        }

        private function addstudents($filename, $t_no)
        {
            PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
            $files = scandir("./upload");
            array_shift($files);
            array_shift($files);
            $manager = $this->session->get("Manager");
            $school_id = $manager["school_id"];
            $errors = array();
            $j = 0;
            $this->db->begin();
            foreach ($files as $file)
            {
                if (strstr($file, $filename))
                {
                    $objexcel = PHPExcel_IOFactory::load("./upload/".$file);
                    $sheet = $objexcel->getSheet(0);
                    $i = 2;
                    $highestrow = $sheet->getHighestRow();
                    while ($i <= $highestrow)
                    {
                        // 增加了检测，但是没有用
                        if($sheet->getCell("C".$i)->isFormula())
                        {
                            $username = trim((string)$sheet->getCell("C".$i)
                                                      ->getOldCalculatedValue());
                        }
                        else
                        {
                            $username = trim((string)$sheet->getCell("C".$i)
                                                      ->getValue());
                        }
                        if ($username == "" || $username == null) break;

                        $student = new Student();
                        if($sheet->getCell("A".$i)->isFormula())
                        {
                            $stu_no = trim((string)$sheet->getCell("A".$i)
                                                         ->getOldCalculatedValue());
                        }
                        else
                        {
                            $stu_no = trim((string)$sheet->getCell("A".$i)
                                                         ->getValue());
                        }
                        $student->stu_no = $stu_no;

                        $student->name = trim((string)$sheet->getCell("B".$i)
                                                            ->getValue());

                        $student->username = $username;

                        if($sheet->getCell("D".$i)->isFormula())
                        {
                            $pwd = trim((string)$sheet->getCell("D".$i)
                                         ->getOldCalculatedValue());
                        }
                        else
                        {
                            $pwd = trim((string)$sheet->getCell("D".$i)
                                         ->getValue());
                        }

                        $student->password = hash("sha256", $pwd);
                        $sex = trim((string)$sheet->getCell("E".$i)
                                     ->getValue());
                        if ($sex == "male")
                        {
                            $student->sex = 1;
                        }
                        else
                        {
                            if ($sex == "female")
                            {
                                $student->sex = 0;
                            }
                        }
                        $student->college = trim((string)$sheet->getCell("F".$i)
                                                  ->getValue());
                        $student->major = trim((string)$sheet->getCell("G".$i)
                                                ->getValue());
                        $student->grade = (int)$sheet->getCell("H".$i)
                                                ->getValue();
                        $student->class = trim((string)$sheet->getCell("I".$i)
                                              ->getValue());
                        $student->birthday = trim((string)$sheet->getCell("J".$i)
                                                      ->getValue());
                        $nativeplace = trim((string)$sheet->getCell("K".$i)->getValue()) == "城市" ? 1 : 0;
                        $student->nativeplace = $nativeplace;
                        $singleton = trim((string)$sheet->getCell("L".$i)->getValue()) == "是" ? 1 : 0;
                        $student->singleton = $singleton;
                        $student->nation = trim((string)$sheet->getCell("M".$i)
                                                             ->getValue());
                        $student->test_id = $t_no;
                        $student->school_id = $school_id;
                        $student->status = 0;
                        try
                        {
                            if (!$student->save())
                            {
                                $errors[$j] = $student->getMessages();
                                $j++;
                            }
                        }
                        catch (PDOException $ex)
                        {
                            $errors[$j] = $ex->getMessage();
                            $j++;
                        }
                        $i++;
                    }
                    $objexcel->disconnectWorksheets();
                    unlink("./upload/".$file);
                }
            }
            if (count($errors) > 0)
            {
                $this->db->rollback();
            }
            else
            {
                $this->db->commit();
            }

            return $errors;
        }

        public function testAction($type)
        {
            $url = $this->makeurl();
            $this->view->setVar("url", $url);

            $result = new TestResult();
            $result->result_type = 0;
            $result->type = $type;
            $result->part_list = $this->getpart($type);
            $this->view->setVar("info", $result);
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }

        public function surveylistAction()
        {
            $manager = $this->session->get("Manager");
            $tests = Test::find(array("school_id = :school_id:",
                                      "bind" => array("school_id" => $manager["school_id"]),
                                      "sort" => "id desc"));
            $now = date("Y-m-d H:i:s");
            $list = array();
            foreach ($tests as $index => $test)
            {
                /*
                 * status
                 * 0: 测试未开始
                 * 1: 测试正在进行中
                 * 2: 测试已经过期
                 */
                $import = Student::count(array("test_id= :test_id:",
                                               "bind" => array("test_id" => $test->t_id)));
                $status = 0;
                if ($now >= $test->begin_time && $now <= $test->end_time)
                {
                    $status = 1;
                }
                else
                {
                    if ($now > $test->end_time)
                    {
                        $status = 2;
                    }
                }
                $item = array("test_id" => $test->t_id,
                              "people" => $test->people,
                              "begin" => substr($test->begin_time, 0, strlen($test->begin_time) - 3),
                              "end" => substr($test->end_time, 0, strlen($test->end_time) - 3),
                              "description" => $test->description,
                              "status" => $status,
                              "import" => $import);
                $list[$index] = $item;
            }
            $this->view->setVar("tests", $list);

            // 设置url
            $url = $this->makeurl();
            $this->view->setVar("url", $url);

            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }

        public function exportAction()
        {
            $this->view->disable();
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
                $manager = $this->session->get("Manager");
                $test_id = $this->request->get("test_id");
                $school_id = $manager["school_id"];
                $test = Test::findFirst($test_id);
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

                $base_col = "L";
                foreach ($test->Part as $part)
                {
                    $sheet->setCellValue($base_col."4", $part->name);
                    $base_col++;
                }

                foreach ($test->Student as $student)
                {
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
                    $base_col = "L";

                    foreach($student->Total as $total)
                    {
                        $sheet->setCellValue("$base_col"."$base_row", $total->answers);
                        $base_col++;
                    }
                    $base_row++;
                }

                $writer = PHPExcel_IOFactory::createWriter($excel, "Excel5");
                $writer->save("../cache/temp/$filename");
                $excel->disconnectWorksheets();
                $this->response->setFileToSend("../cache/temp/$filename", $test->description."学生资料.xls");
                $this->response->send();
               //return $response;
            }
        }

        private function getpart($type)
        {
            $items = Part::find(array("type=:type:",
                                      "bind" => array("type" => $type)));
            $parts = array();
            foreach ($items as $index => $item)
            {
                $parts[$index] = $item;
            }

            return $parts;
        }

        public function getstudentlistAction()
        {
            $test_id = $this->request->getQuery('test_id', 'int');
            $sidx = $this->request->getQuery('sidx','string');
            $sord = $this->request->getQuery('sord','string');
            if (ctype_digit($test_id))
            {
                $builder = $this->modelsManager->createBuilder()
                                               ->from('Student')
                                               ->where("test_id=$test_id");
                if ($sidx != null)
                    $sort = $sidx;
                else
                    $sort = 'stu_no';
                if ($sord != null)
                    $sort = $sort.' '.$sord;
                $builder = $builder->orderBy($sort);
                $this->datareturn($builder);
            }
        }

        public function editstudentlistAction()
        {
            $this->view->disable();
            $oper = $this->request->getPost('oper', 'string');
            if ($oper == 'edit')
            {
                $stu_id      = $this->request->getPost('stu_id', 'int');
                $username    = $this->request->getPost('username', 'string');
                $name        = $this->request->getPost('name', 'string');
                $stu_no      = $this->request->getPost('stu_no', 'int');
                // $age         = $this->request->getPost('age', 'int');
                $college     = $this->request->getPost('college', 'string');
                $major       = $this->request->getPost('major', 'string');
                $sex         = $this->request->getPost('sex', 'int');
                $grade       = $this->request->getPost('grade', 'int');
                $nativeplace = $this->request->getPost('nativeplace', 'string');
                $birthday    = $this->request->getPost("birthday","string");
                $nation      = $this->request->getPost("nation","string");
                $class       = $this->request->getPost("class","string");
                $singleton   = $this->request->getPost("singleton","int");

                $student = Student::findFirst($stu_id);
                if (!$student || is_null($stu_id))
                {
                    echo "false";

                    return;
                }
                $student->username    = $username;
                $student->name        = $name;
                $student->stu_no      = $stu_no;
                // $student->age         = $age;
                $student->college     = $college;
                $student->major       = $major;
                $student->sex         = $sex;
                $student->grade       = $grade;
                $student->nativeplace = $nativeplace;
                $student->birthday    = $birthday;
                $student->nation      = $nation;
                $student->class       = $class;
                $student->singleton   = $singleton;

                if (!$student->save())
                {
                    foreach ($student->getMessages() as $message)
                    {
                        echo $message;
                    }
                }
            }
            else
            {
                if ($oper == 'del')
                {
                    $stu_id = $this->request->getPost('id', 'int');
                    $student = Student::findFirst($stu_id);
                    if (!$student->delete())
                    {
                        foreach ($student->getMessages() as $message)
                        {
                            echo $message;
                        }
                    }
                }
            }

        }

        public function viewAction($index)
        {
            $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
            $test = Test::findFirst(array("t_id=:t_id:",
                                          "bind" => array("t_id" => $index)));
            $students = $test->getStudent();
            $done = 0;
            foreach ($students as $student) {
                $done += $student->status;
            }
            $sum = count($students);
            $this->view->setVar("notdone", $sum - $done);
            $this->view->setVar("sum", $sum);
            $this->view->setVar("test_id", $index);
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
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

        public function requestschooltestAction()
        {

        }

        private function makeurl()
        {
            $manager = $this->session->get('Manager');
            $school_id = $manager['school_id'];
            $url = $_SERVER['SERVER_NAME'];
            $url = "http://".$url."/stulogin/index/".$school_id;
            return $url;
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
