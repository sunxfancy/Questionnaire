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
                    'admin'       => new Phalcon\Acl\Role("M"),
                    'leader'      => new Phalcon\Acl\Role("L"),
                    'pm'          => new Phalcon\Acl\Role('P'),
                    'examinee'    => new Phalcon\Acl\Role("E"),
                    'interviewer' => new Phalcon\Acl\Role("I"),
                    'guests'      => new Phalcon\Acl\Role('G'));
                
                foreach ($roles as $role)
                {
                    $acl->addRole($role);
                }
 
                //manager area resources
                $privateResources = array(
                    'admin'       => array('index'),
                    'examinee'    => array('index'),
                    'interviewer' => array('index'),
                    'leader'      => array('index'),
                    'pm'          => array('index'),
                    'test'        => array('index')
                );
                
                //Public area resources
                $publicResources = array(
                     'managerlogin' => array('index',
                                      'login',
                                      'logout'),
                     'examinee' => array('login'),
                     'index'    => array('index'),
                     'test'     => array('index')
                );

                foreach ($privateResources as $resource => $actions)
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

                $acl->allow('M', 'admin', '*');
                $acl->allow('E', 'examinee', '*');
                $acl->allow('P', 'pm', '*');
                $acl->allow('L', 'leader', '*');
                $acl->allow('I', 'interviewer', '*');

                //The acl is stored in session, APC would be useful here too
                $this->persistent->acl = $acl;
            }

            return $this->persistent->acl;
        }

        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            $manager = $this->session->get("Manager");
            $type = 'G';
            if ($manager) {
                $type = $manager->role;
            } else {
                $examinee = $this->session->get("Examinee");
                $type = 'E';
            }
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();
            $acl = $this->getAcl();
            $allowed = $acl->isAllowed($type, $controller, $action);
            if ($allowed != Acl::ALLOW)
            {
                $this->flash->error("对不起，您没有访问权限");
                $dispatcher->forward(array('controller' => 'index',
                                           'action' => 'index'));
                return false;
            }
        }
    }
