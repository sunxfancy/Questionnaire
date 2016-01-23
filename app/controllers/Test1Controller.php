<?php

class Test1Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function testAction(){
			
		  $index_name = "zb_rjgxtjsp";
		  $children = "po,aff,nur,def,E,X3,N,inte,I,aba,suc,fx";
		  $examinee_id = 1794;
		  $test = new ModifyFactors;
		  $test->getChildrenOfIndexDesc($index_name, $children, $examinee_id);
		
	}
	
}