<?php
    /*
    * @Author: sxf
    * @Date:   2014-10-11 21:07:33
    * @Last Modified by:   sxf
    * @Last Modified time: 2014-11-06 10:40:57
    */

    // 本类负责控制学校账户的登录、注册、找回密码、显示注册成功与否等
    class ManagerloginController
        extends Base
    {
        public function initialize()
        {
            Phalcon\Tag::setTitle('欢迎登陆本系统');
            parent::initialize();

            if ($this->usecdn) {
                $this->assets->addCss("http://questionnaire-buaa.qiniudn.com/css/ace-bundle.min.css");
                $this->assets->collection('header')
                             ->addJs("http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js");
            } else {
                $this->assets->addCss("pagecss/ace-bundle.min.css");
                $this->assets->collection('header')
                             ->addJs("js/jquery.js");
            }
            $this->assets->collection('header-ie9-css')
                         ->addCss("css/ace-part2.min.css")
                         ->addCss("css/ace-ie.min.css");

            $this->assets->collection('header-ie9')
                         ->addJs("lib/html5shiv.js");

            $this->view->setTemplateAfter('backend-layout');
            $this->view->setVar('target', '/managerlogin/signin');
        }

        public function indexAction()
        {
            $this->view->setVar('error', false);
            $this->view->setVar('type', 'Manager');
        }

        public function signinAction()
        {
            if ($this->request->isPost() == true)
            {
                $username = $this->request->getPost("username", "string");
                $password = $this->request->getPost("password", "string");
                $manager = Manager::checkLogin($username, $password);

                if ($manager === 0)
                {
                    // 密码不正确
                    $this->view->setVar('error', 'password');
                    $this->view->setVar('type', 'Manager');
                    $this->view->pick('managerlogin/index');

                    return;
                }

                if ($manager === -1)
                {
                    // 用户不存在
                    $this->view->setVar('error', 'username');
                    $this->view->setVar('type', 'manager');
                    $this->view->pick('managerlogin/index');

                    return;
                }
                if ($manager->auth <= 1)
                {
                    $this->session->set('type', 'Manager');

                    $this->session->set('Manager', array('id' => $manager->id,
                                                         'username' => $manager->username,
                                                         'auth' => $manager->auth,
                                                         'school_id' => $manager->school_id,
                                                         'name' => $manager->name));

                    $this->response->redirect('index');
                }
                else
                {
                    $this->session->set('type', 'Admin');

                    $this->session->set('Admin', array('id' => $manager->id,
                                                       'username' => $manager->username,
                                                       'auth' => $manager->auth,
                                                       'name' => $manager->name));

                    $this->response->redirect('admin');
                }
            }
            else
            {
                $this->forward('managerlogin', 'index');
            }

        }

        public function signupAction()
        {
            if ($this->request->isPost() == true)
            {
                $username = $this->request->getPost("username", "string");
                $password = $this->request->getPost("password", "string");
                $phone = $this->request->getPost("phone", "string");
                $email = $this->request->getPost("email", "string");
                $realname = $this->request->getPost("name", "string");
                $ID_number = $this->request->getPost("id_num", "string");

                $manager = Manager::checkUsername($username);

                if ($manager != false)
                {
                    // 用户已存在
                    $this->view->setVar('succeed', false);
                }
                else
                {
                    $manager = new Manager();
                    if ($manager->signup($username, $password, $phone, $email, $realname, $ID_number))
                    {
                        $this->view->setVar('succeed', true);
                    }
                    else
                    {
                        $this->view->setVar('succeed', false);
                    }
                }
            }
            $this->view->setVar('succeed', true);
        }

        public function checkuserAction()
        {
            $this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
            if ($this->request->isPost() == true)
            {
                $username = $this->request->getPost("username", "string");
                $manager = Manager::checkUsername($username);

                if ($manager != false)
                {
                    // 用户已存在
                    $this->response->setContent("1");
                }
                else
                {
                    $this->response->setContent("0");
                }
            }
            $this->response->send();
            $this->view->disable();

            return $this->response;
        }

        public function findpassAction()
        {
            // 读取配置参数
            $this->view->disable();
            $filename = __DIR__."/../config/settings.json";
            if (file_exists($filename))
            {
                $fs = fopen($filename, "r");
                $file = fread($fs, filesize($filename));
                fclose($fs);
                if ($fs != null || $file != "")
                {
                    $settings = json_decode($file);
                }
                else
                {
                    $this->flash->error("邮件发送服务未配置");
                }
            }
            else
            {
                $this->flash->error("邮件发送服务未配置");
                $this->response->redirect('managerlogin');

                return;
            }

            $url = $_SERVER['SERVER_NAME'];
            $host = $settings->host;
            $from = $settings->from;
            $username = $settings->username;
            $password = $settings->password;
            if ($from == "" || is_null($from))
            {
                $from = $username;
            }

            // 向指定邮箱发一封邮件
            // 内含用户名
            // 密码重置链接
            if ($this->request->isPost() == true)
            {
                $email = $this->request->getPost('email', 'email');
                $manager = Manager::findFirst(array('email=:e:',
                                                    'bind' => array('e' => $email)));
                if ($manager == false)
                {
                    $this->flash->error('找不到该用户');
                    $this->response->redirect('managerlogin');

                    return;
                }
                $id = $manager->id;
                $name = $manager->name;
                $user = $manager->username;
                $pass = $manager->password;
                // 迷之加密方法
                $a = $this->encrypt($id, $this->something);
                $b = $this->encrypt($user, $pass);
                // 这里要对url进行拼接，不带有http开头的链接并不能被邮件客户端正确识别
                $url = "http://".$url;
                $url .= "/managerlogin/resetpassword?a=".$a."&b=".$b;
                $smtp = new Smtp($host, 25, true, $username, $password);
                $subject = "Question在线答题系统重置密码";
                $body = "<h3>找回密码</h3><p>尊敬的$name:<br>您的用户名为:$user<br>请点击以下链接进行密码重置操作:<a href=\"$url\">$url</a>";
                // $this->flash->error($host.$username.$password.$name.$user.$email.$from.$subject.$body);
                $issend = $smtp->sendmail($email, $from, $subject, $body, "HTML");
                if ($issend == true)
                {
                    $this->flash->success('成功发送邮件,请查收');
                }
                else
                {
                    $this->flash->error('邮件发送失败，请您联系管理员');
                }
                $this->response->redirect('managerlogin');
            }
        }

        public function resetpasswordAction()
        {
            $a = $this->request->getQuery("a");
            $b = $this->request->getQuery("b");
            if ($a == null || $b == null)
            {
                $this->flash->error('url无效');

                // $this->response->redirect('managerlogin');
                return;
            }
            $id = $this->decrypt($a, $this->something);

            if (!ctype_digit($id))
            {
                $this->flash->error('url无效');

                // $this->response->redirect('managerlogin');
                return;
            }
            $manager = Manager::findFirst($id);
            if ($manager == false)
            {
                $this->flash->error('url无效');

                // $this->response->redirect('managerlogin');
                return;
            }
            $name = $this->decrypt($b, $manager->password);
            if ($name != $manager->username)
            {
                $this->flash->error('url无效');

                // $this->response->redirect('managerlogin');
                return;
            }
            $this->session->set('reset', 'resetpass');
            $this->session->set('reset_id', $manager->id);
        }

        public function newpasswordAction()
        {
            $this->view->disable();
            if ($this->session->has('reset') && $this->request->isPost())
            {
                if ($this->session->get('reset') == 'resetpass')
                {
                    $password = $this->request->getPost('password', 'string');
                    $id = $this->session->get('reset_id');
                    $manager = Manager::findFirst($id);
                    if ($manager != false)
                    {
                        $manager->password = hash('sha256', $password);
                        if ($manager->save())
                        {
                            $this->session->remove("reset");
                            $this->session->remove("reset_id");
                            $this->flash->success('成功修改密码');
                        }
                        else
                        {
                            foreach ($manager->getMessages() as $message)
                            {
                                $this->flash->error($message);
                            }
                        }
                    }
                    else $this->flash->error("用户不存在");
                }
            }
            $this->response->redirect('managerlogin');
        }

        public function encrypt($text, $pass)
        {
            $key = pack('H*', $pass);
            $iv = pack('H*', $pass);
            $cilper = unpack('H*', mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_CBC, $iv));
            $str = "";
            foreach ($cilper as $c)
            {
                $str = $str.$c;
            }

            return $str;
        }

        public function decrypt($cilper, $pass)
        {
            $key = pack('H*', $pass);
            $iv = pack('H*', $pass);
            $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, pack('H*', $cilper), MCRYPT_MODE_CBC, $iv);
            $str = rtrim($str); // 一定要截取 后面会跟一些莫名奇妙的空字符
            return $str;
        }

        public function logoutAction()
        {
            $this->session->remove("type");
            $this->view->disable();
            $this->response->redirect('managerlogin');
        }

        public $something = "ef0856bcb043051c5ab7e47cd0a38b5eb29fdaeb1cbe003a05e1de2ffb2417a0";
    }
