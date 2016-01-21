<?php
/**
 * @Author: sxf
 * @Date:   2015-08-04 10:47:09
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-04 10:48:37
 */

/**
* 被试人员登录页面
*/
class IndexController extends Base
{
	public function initialize()
    {
    	parent::initialize();
        $this->view->setTemplateAfter('base1');
    }
	
	public function indexAction()
	{
		$state = Utils::getBrowserDetail($this->request);
		if (!$state ){
			$this->response->redirect('/wrong/lowbrowser/examinee');
			$this->view->disable();
		}
	}

	public function loginAction(){
        $username = $this->request->getPost("username", "string");
        $password = $this->request->getPost("password", "string");
        if (!LoginConfig::IsOnlyNumber($username)) {
        	$this->dataReturn(array('error' => '账号输入错误'));
	        return;
        }
        if (!LoginConfig::IsOnlyNumberAndLetter($password)) {
        	$this->dataReturn(array('error' => '密码输入错误'));
	        return;
        }
        if (strlen($username) == 8) {
	        $examinee = Examinee::checkLogin($username, $password);	        
	        if ($examinee === 0) {
	            $this->dataReturn(array('error' => '密码不正确'));
	            return;
	        }
	        if ($examinee === -1) {
	            $this->dataReturn(array('error' => '用户不存在'));
	            return;
	        }
	        if ($examinee){
		        $project = Project::findFirst($examinee->project_id);
		        $now = date('y-m-d h:i:s');
		        if (strtotime($now) < strtotime($project->begintime)) {
		            $this->dataReturn(array('error'=>'测评还未开启，请在测评开启后登录'));
		            return;
		        }if (strtotime($now) > strtotime($project->endtime)) {
		            $this->dataReturn(array('error'=>'测评已经结束，请在测评开启时间内登录'));
		            return;
		        }
		        if ($examinee->state > 0) {
		            $this->dataReturn(array('error'=>'您已参加过测评，不能再次登录'));
		            return;
		        }
		        if ($project->state < 2) {
		            $this->dataReturn(array('error'=>'本次测评配置还未完成，请待配置完成后登录'));
		            return;
		        }
		        $this->session->set('Examinee', $examinee);
		        #添加绿色通道人员直接到个人信息编辑页
		        if ($examinee->type == 1){
		        	$this->dataReturn(array('url' =>'/examinee/editinfo'));
		        	return ;
		        }
		        if (LoginConfig::IsInqueryFinish($examinee->id)) {
		        	$this->dataReturn(array('url' =>'/examinee/editinfo'));
		        }else {
		        	$this->dataReturn(array('url' =>'/examinee/inquery'));
		        }
	        }
	    }else if (strlen($username) == 7) {
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
	            if ($manager->role == 'L') {
	            	$this->session->set('Manager', $manager);
	            	$this->dataReturn(array('url' => '/leader/index'));
	            }else{
	            	$this->dataReturn(array('error' => '请在后台登录入口登录<a href=\'/managerlogin\'>点击跳转</a>'));
	            }
	        }
	    }else{
	    	$this->dataReturn(array('error' => '用户不存在'));
	        return;
	    }
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }
}