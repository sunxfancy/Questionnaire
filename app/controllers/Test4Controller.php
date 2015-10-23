<?php
use PhpOffice\PhpWord\Reader\Word2007;
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		  $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction(){		
			
		$project_id = 1521;
		$da  = new ProjectDataExport();
		$re = $da->excelExport($project_id);
		

	}
	public function testAction(){
// 		$check_data = new CheckoutData();
// 		$examinee = Examinee::findFirst(2660);
// 		$rt = $check_data->getEightAddFive($examinee);
		$da = new ProjectData();
		$rt = $da->getindividualComprehensive(2998);
		echo '<pre>';
		print_r($rt);
// 		$check_data->getChildrenOfIndexDesc('zb_gzzf', 'X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff',2660);
	}
	public function test2Action(){
		$da = new ProjectData();
		$rt = $da->getindividualComprehensive(2996);
		echo '<pre>';
		print_r($rt);
	}
	public function test3Action(){
		$da = new ProjectData();
		$info = Examinee::findFirst(2997);
		$rt = $da->getEightAddFive($info);
		echo '<pre>';
		print_r($rt);
	}

}