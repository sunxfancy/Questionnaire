<?php
use PhpOffice\PhpWord\Reader\Word2007;
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		  $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction(){		
			
		$examinee_id =2998;
		$examinee = Examinee::findFirst($examinee_id);
		$excel = new CheckoutExcel();
		$report = $excel->excelExport($examinee);

	}
	public function testAction(){
		$check_data = new CheckoutData();
		$examinee = Examinee::findFirst(2660);
		$rt = $check_data->getEightAddFive($examinee);
		echo '<pre>';
		print_r($rt);
// 		$check_data->getChildrenOfIndexDesc('zb_gzzf', 'X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff',2660);
	}
	

}