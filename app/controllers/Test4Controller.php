<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function test5Action(){
		$examinee_id = 12;
		FactorScore::handleFactors($examinee_id);
		
	}
	public function indexAction(){
		$memory_state = BasicScore::start();	
		if($memory_state){
			echo "加载完成";
		}
	}
	public function t1Action(){
		$rt = Factor::queryCache(134);
		print_r($rt);
	}

}