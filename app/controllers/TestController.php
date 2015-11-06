<?php

class TestController extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	
	}
	
	public function indexAction() {
		$heelo = '';
		foreach($heelo as $value){
			print_R($value);
		}
	}
	
	public function testAction() {	
		$examinee_id = 8;
		$data = new ProjectData();
		$re = $data->getindividualComprehensive($examinee_id);
		echo '<pre>';
		print_r($re);
	}


}