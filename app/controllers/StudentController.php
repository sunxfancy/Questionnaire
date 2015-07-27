<?php

    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/14/14
     * Time: 11:55 AM
     */
    //学生答题管理
    use Phalcon\Cache\Frontend\Data as DataFrontend, Phalcon\Cache\Multiple, Phalcon\Cache\Backend\Memcache as MemcacheCache, Phalcon\Cache\Backend\File as FileCache;

    class StudentController
        extends Base
    {
        public function initialize()
        {
            Phalcon\Tag::setTitle('心理健康问卷调查');
            parent::initialize();
            $this->view->setTemplateAfter("index-layout");

            if ($this->usecdn)
            {
                $this->assets->addCss("http://questionnaire-buaa.qiniudn.com/css/survey2.min.css")
                             // ->addCss("http://questionnaire-buaa.qiniudn.com/css/buttons.css")
                              ->addCss("http://questionnaire-buaa.qiniudn.com/css/daterangepicker-bs3.css");
                $this->assets->collection("header")
                             ->addJs("http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js")
                             ->addCss("http://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js")
                             ->addJs("http://questionnaire-buaa.qiniudn.com/js/moment.js")
                             ->addJs("http://questionnaire-buaa.qiniudn.com/js/daterangepicker.js");
            }
            else
            {
                
                $this->assets
                             ->addCss("css/survey.css")
                             ->addCss("css/datepicker.css");
                $this->assets->collection("header")
                             ->addJs("lib/moment.js")
                             ->addJs("js/jquery.js")
                             ->addJs("lib/daterangepicker.js")
                             ->addJs("lib/jquery.cookie.js");
            }
             $this->assets->addCss("css/buttons.css");
        }

        public function indexAction()
        {
            date_default_timezone_set("PRC");
            $now = date("Y-m-d H:i:s");
            $iscompleted = true;
            $this->view->setVar("isintime", $this->session->get("start") <= $now && $this->session->get("end") >= $now);
            $this->view->setVar("isanswered", $this->session->get("answer_num") == $this->session->get("exam_num"));
            $this->view->setVar("description", $this->session->get("description"));
            $this->view->setVar("stu_id", $this->session->get("stu_id"));
            foreach ($this->session->get("student") as $index => $item)
            {
                $this->view->setVar($index, $item);
                if ($item === null || $item == "")
                {
                    $iscompleted = false;
                }
            }
            $this->view->setVar("iscompleted", $iscompleted);
        }

        public function saveinfoAction()
        {
            if ($this->request->isPost())
            {
                $stu = Student::findFirst(array("stu_id=:stu_id:",
                                                "bind" => array("stu_id" => $this->session->get("stu_id"))));
                $student = $this->session->get("student");
                $stu_no = trim($this->request->getPost("stu_no", "string"));
                $name = trim($this->request->getPost("name", "string"));
                $college = trim($this->request->getPost("college", "string"));
                $major = trim($this->request->getPost("major", "string"));
                $grade = trim($this->request->getPost("grade", "int"));
                //$age = $this->request->getPost("age", "int");
                $sex = trim($this->request->getPost("sex", "int"));
                $nativeplace = trim($this->request->getPost("nativeplace", "int"));
                $birthday = trim($this->request->getPost("birthday","string"));
                $nation = trim($this->request->getPost("nation","string"));
                $class = trim($this->request->getPost("class","string"));
                $singleton = trim($this->request->getPost("singleton","int"));

                $stu->stu_no = $stu_no;
                $student["stu_no"] = $stu_no;
                $stu->name = $name;
                $student["name"] = $name;
                $stu->college = $college;
                $student["college"] = $college;
                $stu->major = $major;
                $student["major"] = $major;
                $stu->grade = $grade;
                $student["grade"] = $grade;
                // $stu->age = $age;
                // $student["age"] = $age;
                $stu->sex = $sex;
                $student["sex"] = $sex;
                $stu->nativeplace = $nativeplace;
                $student["nativeplace"] = $nativeplace;
                $stu->birthday = $birthday;
                $student["birthday"] = $birthday;
                $stu->nation = $nation;
                $student["nation"] = $nation;
                $stu->class = $class;
                $student["class"] = $class;
                $stu->singleton = $singleton;
                $student["singleton"] = $singleton;
                $stu->save();
                $this->session->set("student", $student);
                $this->response->redirect("student/index");
            }
            else
            {
                $this->flash->error("请求数据无效!");
            }
        }

        //坑爹....
        public function surveyAction()
        {
            $this->assets->collection("header")
                         ->addJs("lib/stickUp.min.js");
            // $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
            if ($this->request->isGet())
            {
                $isfirst = $this->request->get("isfirst");
                if ($isfirst == 1)
                {
                    $this->session->set("p_start", strtotime(date("Y-m-d H:i:s")));
                    $test_id = $this->session->get("test_id");
                    $test = Test::findFirst(array("t_id=:t_id:",
                                                  "bind" => array("t_id" => $test_id)));
                    $parts = array();
                    foreach ($test->Part as $index => $part)
                    {
                        $parts[$index] = $part->p_id;
                    }
                    $part_num = $this->session->get("exam_num");
                    $this->session->set("parts", $parts);
                    $answer_num = $this->session->get("answer_num");
                    if ($answer_num != 0 && $answer_num < $part_num)
                    {
                        $result = $this->nextpart(-1, $this->session->get("answer_num"));
                    }
                    else if ($answer_num == 0)
                    {
                        $result = new SurveyResult();
                        $tnext = $part_num == 1 ? -1 : 1;
                        $cacheKey = $test->Part[0]->p_id.".txt";
                        $result->description = $test->Part[0]->description;
                        $result->nextpart = $this->getquestion($test->Part[0], $cacheKey);
                        $result->resultinfo = 1;
                        $result->cur = 0;
                        $this->session->set("cur", 0);
                        $this->session->set("next", $tnext);
                        $result->next = $tnext;
                    }
                    else
                    {
                        $this->response->redirect("student/index");
                    }
                }
                else if ($isfirst == 2)
                {
                    $result = $this->nextpart($this->session->get("cur"), $this->session->get("next"));
                }
                else
                {
                    $this->response->redirect("student/index");
                }
                $this->view->setVar("testinfo", $result);
            }
            else
            {
                $this->response->redirect("student/index");
            }
        }

        public function completeAction()
        {
            $school_id = $this->session->get("school_id");
            $this->view->setVar("url", "/stulogin/".$school_id);
        }

        private function nextpart($cur, $next)
        {
            $result = new SurveyResult();
            $parts = $this->session->get("parts");
            $stu_id = $this->session->get("stu_id");
            if ($cur != -1)
            {
                $end = strtotime(date("Y-m-d H:i:s"));
                $start = $this->session->get("p_start");
                $total = new Total();
                $curpart = Part::findFirst(array("p_id=:p_id:",
                                                 "bind" => array("p_id" => $parts[$cur])));
                $cacheKey = $curpart->p_id.".txt";
                $curquestions = $this->getquestion($curpart, $cacheKey);
                $tans = $this->cookies->get($stu_id."-".$cur)
                                      ->getValue();
                $answers = str_split($tans);
                if (!(strpos($tans, "0") === false) || strlen($tans) < count($curquestions))
                {
                    return $this->nextpart(-1, $cur);
                }
                $stu_answers = array();
                $total->student_id = $stu_id;
                $total->part_id = $curpart->p_id;
                $total->time = $end - $start;
                $total->answers = $tans;
                foreach ($curpart->Factor as $factor)
                {
                    $stu_answers[$factor->f_id] = new Answer();
                    $stu_answers[$factor->f_id]->factor_id = $factor->f_id;
                    $stu_answers[$factor->f_id]->student_id = $stu_id;
                    $stu_answers[$factor->f_id]->source = 0;
                }
                foreach ($answers as $index => $ans)
                {
                    $order = ord($ans) - ord("a");
                    $q = $curquestions[$index];
                    $scores = explode("|", $q["grade"]);
                    $score = $scores[$order];
                    // $fffid = $q["factor_id"];
                    // echo "order: $order score:$score factor:$fffid<br>";
                    $stu_answers[$q["factor_id"]]->source += $score;
                    $stu_answers[$q["factor_id"]]->ans .= $ans;
                }
                $this->db->begin();
                try
                {
                    $backup = new Backup();
                    $filename="../cache/backup/$stu_id.bak";
                    $backup->total = $total->toArray();
                    $i = 0;
                    foreach($stu_answers as $a)
                    {
                        $backup->answers[$i] = $a->toArray();
                        $i++;
                    }
                    $file=fopen($filename, "a");
                    fwrite($file, json_encode($backup)."|");
                    fclose($file);
                    if (!$total->save())
                    {
                        throw new PDOException();
                    }
                    foreach ($stu_answers as $stu_answer)
                    {
                        if (!$stu_answer->save())
                        {
                            throw new PDOException();
                        }
                    }
                    $this->db->commit();
                    $result->resultinfo = 1;
                }
                catch (PDOException $ex)
                {
                    echo $ex->getMessage();
                    $result->resultinfo = 0;
                    $this->db->rollback();
                    $this->view->disable();
                }
            }
            if ($next != -1)
            {
                $this->session->set("cur", $next);
                $tnext = $next == $this->session->get("exam_num") - 1 ? -1 : $next + 1;
                $this->session->set("next", $tnext);
                $this->session->set("p_start", strtotime(date("Y-m-d H:i:s")));
                $nextpart = Part::findFirst(array("p_id=:p_id:",
                                                  "bind" => array("p_id" => $parts[$next])));
                $cacheKey = $nextpart->p_id.".txt";
                $questions = $this->getquestion($nextpart, $cacheKey);
                $result->description = $nextpart->description;
                $result->nextpart = $questions;
                $result->cur = $next;
                $result->next = $tnext;

                return $result;
            }
            else
            {
                $stu_id = $this->session->get("stu_id");
                $stu = Student::findFirst($stu_id);
                $stu->status = 1;
                $stu->save();
                $this->response->redirect("student/complete");
            }
        }

        private function getquestion($part, $cacheKey)
        {
            $questions = array();
            $filefrontcache = new DataFrontend(array("lifetime" => 172800));
            $memforontcache = new DataFrontend(array("lifetime" => 14400));
            $cache = new Multiple(array(new MemcacheCache($memforontcache, array("perfix" => "cache",
                                                                                 "host" => "localhost",
                                                                                 "port" => "11211")),
                                        new FileCache($filefrontcache, array("perfix" => "cache",
                                                                             "cacheDir" => "../cache/cachefile/"))));

            if (!$cache->exists($cacheKey))
            {
                foreach ($part->Factor as $factor)
                {
                    $questions = array_merge($questions, $factor->Question->toArray());
                }
                sort($questions);
                $cache->save($cacheKey, $questions);
            }
            else
            {
                $questions = $cache->get($cacheKey);
            }

            return $questions;
        }
    }
