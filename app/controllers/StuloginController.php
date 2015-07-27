<?php

    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/11/14
     * Time: 9:10 PM
     */
    //学生登录管理，包括登录验证
    class StuloginController
        extends Base
    {
        public function initialize()
        {
            Phalcon\Tag::setTitle('欢迎登录本系统');
            parent::initialize();

            if ($this->usecdn)
            {
                $this->assets->addCss("http://questionnaire-buaa.qiniudn.com/css/ace-bundle.min.css");
                $this->assets->collection('header')
                             ->addJs("http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js")
                             ->addJs("http://cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js");
            }
            else
            {
                $this->assets->addCss("pagecss/ace-bundle.min.css");
                $this->assets->collection('header')
                    ->addJs("js/jquery.js")
                    ->addJs("lib/jquery.qrcode.min.js");
            }
            $this->assets->collection('header-ie9-css')
                         ->addCss("css/ace-part2.min.css")
                         ->addCss("css/ace-ie.min.css");
            $this->assets->collection('header-ie9')
                         ->addJs("lib/html5shiv.js");

            $this->view->setTemplateAfter('backend-layout');
        }

        public function indexAction($school_id = 0, $error = null)
        {
            if (!isset($error))
            {
                $this->session->set("school_id", $school_id);
                $this->view->setVar("error", false);
            }
            else
            {
                $this->view->setVar("error", $error);
            }
            $school = School::findFirst(array("school_id=:school_id:",
                                              "bind" => array("school_id" => $this->session->get("school_id"))));
            if ($school != null)
            {
                $this->view->setVar("school_name", $school->name);
            }
            else
            {
                $this->view->setVar("school_name", "");
                $this->flash->error("对不起，您访问的学校不存在");
            }
            $this->view->setVar("type", "student");
            $this->view->setVar("target", "/stulogin/check");
        }

        public function checkAction()
        {
            if ($this->request->isPost())
            {
                $username = $this->request->getPost("username", "string");
                $password = $this->request->getPost("password", "string");
                $school_id = $this->session->get("school_id");
                $pwd = hash("sha256", $password);
                $stu = Student::findFirst(array("username=:username: AND school_id=:school_id:",
                                                "bind" => array("username" => $username,
                                                                "school_id" => $school_id)));
                if ($stu != null)
                {
                    if ($stu->password == $pwd)
                    {
                        $school = $stu->School;
                        $test = $stu->Test;
                        $this->session->set("type", "Student");
                        $this->session->set("stu_id", $stu->stu_id);
                        $this->session->set("exam_num", $test->exam_num);
                        $this->session->set("answer_num", $stu->Total->count());
                        $this->session->set("begin", $test->begin_time);
                        $this->session->set("end", $test->end_time);
                        $this->session->set("test_id", $stu->test_id);
                        $this->session->set("description", $test->description);
                        $this->session->set("student", array("stu_no" => $stu->stu_no,
                                                             "name" => $stu->name,
                                                             "college" => $stu->college,
                                                             "major" => $stu->major,
                                                             "grade" => $stu->grade,
                                                             "sex" => $stu->sex,
                                                             "nativeplace" => $stu->nativeplace,
                                                             "school" => $school->name,
                                                             "birthday" => $stu->birthday,
                                                             "nation" => $stu->nation,
                                                             "class" => $stu->class,
                                                             "singleton" => $stu->singleton
                                                             ));
                        $this->response->redirect("student/index");
                    }
                    else
                    {
                        $this->response->redirect("stulogin/index/$school_id/password");
                        // 为什么是0？
                    }
                }
                else
                {
                    $this->response->redirect("stulogin/index/0/stuusername");
                }
            }
            else
            {
                $this->flash->error("请求数据无效!");
            }
        }
    }