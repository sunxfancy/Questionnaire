<?php

class ErrorController extends \Phalcon\Mvc\Controller {
	public function initialize(){
		$this->view->setTemplateAfter('base1');
	}
	public function indexAction(){
		$type = $this->dispatcher->getParams();
		#被试登录错误
		if($type[0] == 'examinee'){
			$this->view->setVar('url','/');
		}else if ($type[0] == 'manager'){
			$this->view->setVar('url','/managerlogin');
		}else{
			$this->view->setVar('url','/');
		}
	}
}
