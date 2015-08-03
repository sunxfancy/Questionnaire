<?php

class ManagerloginController extends Base
{
    public function initialize()
    {
          $this->view->setTemplateAfter('base1');
    }

    public function indexAction()
    {

    }

    public function loginAction()
    {
        $username = $this->request->getPost("username", "string");
        $password = $this->request->getPost("password", "string");
        $manager = Manager::checkLogin($username, $password);

        if ($manager === 0) {
            dataReturn(array('error' => '密码不正确'));
            return;
        }
        if ($manager === -1) {
            dataReturn(array('error' => '用户不存在'));
            return;
        }
        if ($manager != 0)
        {
            $this->session->set('Manager', $manager);
	        switch ($manager->role) {
	        	case 'M': // 管理员
                    dataReturn(array('url' => 'admin/index'));
	        		break;
	        	case 'P': // 项目经理

	        		break;
	        	case 'L':  // 领导

	        		break;

	        	case 'I': // 面询专家
	        		break;

	        	default:
	        		dataReturn(array('error' => '用户权限异常'));
	        		break;
        	}
        }
    }

    public function logoutAction()
    {
    	
    }

    public function dataReturn($ans)
    {
        echo json_encode($ans);
        $this->view->disable();
    }

}

