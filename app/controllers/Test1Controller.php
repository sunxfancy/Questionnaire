<?php

class Test1Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function testAction(){
		
		$project_data = new ProjectData();
		
		$rtn = $project_data->getindividualComprehensive(1794);
		
		echo '<pre>';
		
		print_r($rtn);
		
	}
	
}