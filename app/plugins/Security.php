<?php
    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/14/14
     * Time: 11:40 AM
     */
    use Phalcon\Events\Event, Phalcon\Mvc\User\Plugin, Phalcon\Mvc\Dispatcher, Phalcon\Acl;

    class Security
        extends Plugin
    {
        public function __construct($dependencyInjector)
        {
            $this->_dependencyInjector = $dependencyInjector;
        }

        public function getAcl()
        {
            if (!isset($this->persistent->acl))
            {
                $acl = new Phalcon\Acl\Adapter\Memory();
                $acl->setDefaultAction(Phalcon\Acl::DENY);
                //Register roles
                $roles = array(
                    'admin'       => new Phalcon\Acl\Role("Admin"),
                    'leader'      => new Phalcon\Acl\Role("Leader"),
                    'pm'          => new Phalcon\Acl\Role('PM'),
                    'examinee'    => new Phalcon\Acl\Role("Examinee"),
                    'interviewer' => new Phalcon\Acl\Role("Interviewer"),
                    'guests'      => new Phalcon\Acl\Role('Guests'));
                
                foreach ($roles as $role)
                {
                    $acl->addRole($role);
                }

                //admin area resources
                $adminResources = array(
                    'admin' => array('index'),
                    'import' => array('index')
                );
                
                //manager area resources
                $managerResources = array('index' => array('index'));
                
                //student area resources
                $studentResources = array('student' => array('index'));
                
                //Public area resources
                $publicResources = array(
                     'managerlogin' => array('index',
                                      'checkuser',
                                      'check',
                                      'signin',
                                      'signup',
                                      'findpass',
                                      'resetpassword',
                                      'newpassword',
                                      'logout'),
                     'stulogin' => array('index',
                                         'check'),
                     'index' => array('index')
                );
                foreach ($adminResources as $resource => $actions)
                {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
                }
                foreach ($managerResources as $resource => $actions)
                {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
                }
                foreach ($studentResources as $resource => $actions)
                {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
                }
                foreach ($publicResources as $resource => $actions)
                {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
                }
                //Grant access to public areas to both users and guests
                foreach ($roles as $role)
                {
                    foreach ($publicResources as $resource => $actions)
                    {
                        $acl->allow($role->getName(), $resource, $actions);
                    }
                }

                $acl->allow('Student', 'student', '*');
                $acl->allow('Admin', 'admin', '*');
                $acl->allow('Admin', 'import', '*');
                $acl->allow('Manager', 'index', '*');

                //The acl is stored in session, APC would be useful here too
                $this->persistent->acl = $acl;
            }

            return $this->persistent->acl;
        }

        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            $type = $this->session->get("type");
            if ($type == null )
            {
                $type = "Guests";
            }
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();
            $acl = $this->getAcl();
            $allowed = $acl->isAllowed($type, $controller, $action);
            if ($allowed != Acl::ALLOW)
            {
                $this->flash->error("对不起，您没有访问权限");
                $dispatcher->forward(array('controller' => 'managerlogin',
                                           'action' => 'index'));
                return false;
            }
        }
    }