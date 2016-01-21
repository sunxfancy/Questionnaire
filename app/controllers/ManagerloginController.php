<?php

/**
 * 后台登录页面
 */
class ManagerloginController extends Base
{
    public function initialize(){
    	parent::initialize();
        $this->view->setTemplateAfter('base1');
    }

    public function indexAction(){
    	$state = Utils::getBrowserDetail($this->request);
    	if (!$state ){
    		$this->response->redirect('/wrong/lowbrowser/manager');
    		$this->view->disable();
    	}
    }

    public function loginAction(){
        $username = $this->request->getPost("username", "string");
        $password = $this->request->getPost("password", "string");
        if (!LoginConfig::IsOnlyNumberAndLetter($username)) {
            $this->dataReturn(array('error' => '账号输入需为字母或数字'));
            return;
        }
        if (!LoginConfig::IsOnlyNumberAndLetter($password)) {
            $this->dataReturn(array('error' => '密码输入需为字母或数字'));
            return;
        }
        $manager = Manager::checkLogin($username, $password);
        if ($manager === 0) {
            $this->dataReturn(array('error' => '密码不正确'));
            return;
        }
        if ($manager === -1) {
            $this->dataReturn(array('error' => '用户不存在'));
            return;
        }
        if ($manager){
            $this->session->set('Manager', $manager);
	        switch ($manager->role) {
	        	case 'M': // 管理员
                    $this->dataReturn(array('url' => '/admin/index'));
	        		break;
	        	case 'P': // 项目经理
                    $this->dataReturn(array('url' => '/pm/index'));
	        		break;
	        	case 'L':  // 领导
                    $this->dataReturn(array('error' => '请在领导登录页面登录<a href=\'/\'>点击跳转</a>'));
	        		break;

	        	case 'I': // 面询专家
                    $this->dataReturn(array('url' => '/interviewer/index'));
	        		break;

	        	default:
	        		$this->dataReturn(array('error' => '用户权限异常'));
	        		break;
        	}
        }
    }

    public function logoutAction(){
        $manager = $this->session->get('Manager');
        $this->session->remove('Manager');
    	$this->response->redirect('managerlogin');
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

}

