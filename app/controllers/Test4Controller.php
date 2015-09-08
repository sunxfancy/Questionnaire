<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		// $this->view->setTemplateAfter('base3');
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction(){		
		$data = $this->modelsCache->queryKeys();
		print_r($data);
		
		$d1 = $this->modelsCache->get('inquery_question_by_project_id_1513');
		echo count($d1);
		exit();
	}
}