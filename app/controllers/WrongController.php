<?php

class WrongController extends Base
{
	public function initialize(){
		$this->view->setTemplateAfter('base1');
	}
	public function indexAction($type){
		#被试登录错误
		if($type== 'examinee'){
			$this->view->setVar('url','/');
		}else if ($type == 'manager'){
			$this->view->setVar('url','/managerlogin');
		}else{
			$this->view->setVar('url','/');
		}
	}
	
	public function lowbrowserAction($type){
		$state = Utils::getBrowserDetail($this->request);
		if ($state ){
			if($type == 'manager'){
				$this->response->redirect('/managerlogin');
				$this->view->disable();
			}else{
				$this->response->redirect('/');
				$this->view->disable();
			}
			
		}
	}
}
