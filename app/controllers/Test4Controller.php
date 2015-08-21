<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function test5Action(){
		$examinee_id = 12;
		if(BasicScore::handlePapers($examinee_id)){
			echo $examinee_id.'处理完毕';
		}
		
	}
	public function indexAction(){
		$memory_state = BasicScore::start();	
		if($memory_state){
			echo "加载完成";
		}
	}

}