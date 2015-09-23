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
	public function drawAction(){
// 		$this->sexAction();
// 		$this->ageAction();
// 		$this->jobAction();
// 		$this->zhichengAction();
		$this->majorAction();
		$this->barAction();
		$this->vbarAction();
		$this->lineAction();
		$this->radarAction();
// 		$this->workstateAction();
		
		exit();
	}
	public function barAction(){
		$chart = new ChartLoader();
		$chart->bar();
	}
	public function vbarAction(){
		$chart = new ChartLoader();
		$chart->vbar();
	}
	public function lineAction(){
		$chart = new ChartLoader();
		$chart->line();
	}
	public function radarAction(){
		$chart = new ChartLoader();
		$chart->radar();
	}
	
	public function sexAction(){
		$chart = new ChartLoader();
		$number = array(67,33);
		$label = array("男","女");
		$title = '性别比例';
		$name = 'sex';
		$chart->pie($number, $label, $title,$name);
	}
	public function ageAction(){
		$chart = new ChartLoader();
		$data_number = array(23,45, 15, 2 );
		$data_label = array("30岁及以下","31-35岁","36-40岁","41-45岁");
		$data_title = '年龄状态分布';
		$name = 'age';
		$chart->pie($data_number, $data_label, $data_title, $name);
	}
	public function jobAction(){
		$chart = new ChartLoader();
				$data_number = array(40,21,19,5);
				$data_label = array("基层管理","基层负责人","集团总部","基层助理");
				$data_title = '职位状态分布';
				$name = 'job';
				$chart->pie($data_number, $data_label, $data_title, $name);
	}
	public function zhichengAction(){
		$chart = new ChartLoader();
		$data_number = array(13,21,46,5,0);
		$data_label = array("无职称","初级","中级","副高","正高");
		$data_title = '技术职称';
		$name = 'zhicheng';
		$chart->pie($data_number, $data_label, $data_title, $name);
	}
	public function majorAction(){
		$chart = new ChartLoader();
		$data_number = array(54,13,8,7,2,1);
		$data_label = array("理工类","管理类",'经济类','法律类','社科类','其它');
		$data_title = '教育专业背景';
		$name = 'major';
		$chart->pie($data_number, $data_label, $data_title, $name);
	}
	public function workstateAction(){
		$chart = new ChartLoader();
		$data_number = array(21,55,9,0,0);
		$data_label = array('非常胜任','胜任','基本胜任','有所不足','不能胜任');
		$data_title = '工作状态';
		$name = 'workstate';
		$chart->pie($data_number, $data_label, $data_title, $name);
	}
	public function challenageAction(){
		$chart = new ChartLoader();
		$data_number = array(2,1,7,75);
		$data_label = array('不希望','无所谓','希望但没信心','希望又有信心');
		$data_title = '接受挑战意愿';
		$name = 'challenge';
		$chart->pie($data_number, $data_label, $data_title, $name);
	}

}