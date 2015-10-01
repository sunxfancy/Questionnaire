<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		
	}
	
	public function indexAction(){		
// 		$re = new Report();
// 		echo '<pre>';
// 		print_r($re->getAdvantages(2656));
// 		echo '</pre>';
// 		echo '<hr />';
// 		echo '<pre>';
// 		print_r($re->getDisadvantages(2662));
// 		echo '</pre>';

// 		$chart = new ChartLoader();
// 		$chart->test();

		$re = new individualComReport();
		print_r($re->getSystemComprehensive(2662));
	}

}