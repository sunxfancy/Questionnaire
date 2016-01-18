<?php

class Test1Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function testAction(){
		
		$examinee_info = Examinee::findFirst(1794);	

		$checkout_data = new CheckoutData();

		$checkout_data->getEightAddFive($examinee_info);
		
	}
	
}