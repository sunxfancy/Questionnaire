<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		// $this->view->setTemplateAfter('base3');
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction(){		
		$data = $this->modelsCache->queryKeys();
		echo count($data);
		echo "<hr />";
		print_r($data);
		
		exit();
	}
}