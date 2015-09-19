<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		// $this->view->setTemplateAfter('base3');
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction(){		
		$data = $this->modelsCache->queryKeys();
		echo count($data);
		echo "<hr />";
		print_r($data);
		
		exit();
	}
	
	public function testAction(){
		$chart = new ChartLoader();
		$number = array(67,33);
		$label = array("男","女");
		$title = '性别比例';
		$name = 'sex';
		$chart->pie($number, $label, $title,$name);
		

		
	}
	public function test1Action(){
		$chart = new ChartLoader();
		$data_number = array(23,45, 15, 2 );
		$data_label = array("30岁及以下","31-35岁","36-40岁","41-45岁");
		$data_title = '年龄状态分布';
		$name = 'age';
		$chart->pie($data_number, $data_label, $data_title, $name);
	}
	public function test2Action(){
		$chart = new ChartLoader();
				$data_number = array(40,21,19,5);
				$data_label = array("基层管理","基层负责人","集团总部","基层助理");
				$data_title = '职位状态分布';
				$name = 'job';
				$chart->pie($data_number, $data_label, $data_title, $name);
	}
}