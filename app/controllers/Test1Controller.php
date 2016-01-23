<?php

class Test1Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function testAction(){
			
// 		  $index_name = "zb_rjgxtjsp";
// 		  $children = "po,aff,nur,def,E,X3,N,inte,I,aba,suc,fx";
// 		  $examinee_id = 1794;
// 		  $test = new ModifyFactors;
// 		  $test->getChildrenOfIndexDesc($index_name, $children, $examinee_id);
		$examinee_ids = array( 1793,1794);
		$proData = new ProjectData();
		$rt = $proData->getlevelsComprehensive($examinee_ids);
		echo '<Pre>';
		print_r($rt);
		
	}
	
	public function test1Action(){
		$proData = new ProjectData();
		$proData->getindividualComprehensive(1793);
	}
	public function test2Action(){
		$proData = new ProjectData();
		$proData->getindividualComprehensive(1794);
	}
	
}