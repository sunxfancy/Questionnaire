<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function test5Action(){
		$examinee_id = 12;
// 		$papers = QuestionAns::getPapers($examinee_id);
// 		foreach($papers as $value){
// 			print_r($value);
// 		}
// 		print_r($papers);
// 		try{
// 		$factor_state = FactorScore::handleFactors($examinee_id);
// 		if($factor_state){
// 			echo "id = $examinee_id  factor finished";
// 		}
// 		}catch(Exception $e){
// 			echo $e->getMessage();
// 			return false;
// 		}
// 		try{
// 			if(BasicScore::beforeStart()){
// 				BasicScore::handlePapers($examinee_id);
// 			}
// 		}catch(Exception $e){
// 			echo $e->getMessage();
// 		}
// 		exit();
		
	}
	public function microtime_float () {
		list( $usec ,  $sec ) =  explode ( " " ,  microtime ());
		return ((float) $usec  + (float) $sec );
	}
	
	public function indexAction(){
		
		$time_start  =  $this->microtime_float ();
		$memory_start = memory_get_usage( true );
		try{
			BasicScore::beforeStart();
			if(BasicScore::handlePapers(12)){
				echo "finished";
			}
		}catch(Exception $e){
			$e->getMessage();
		}
		$memory_end = memory_get_usage( true );
		$memory_consuming = ($memory_end - $memory_start)/1024/1024;
		$time_end = $this->microtime_float();
		$time_consuming = $time_end - $time_start;
		echo $time_consuming .'-'. $memory_consuming;
	}
	public function t1Action(){
		FactorScore::beforeStart();
		FactorScore::handleFactors(12);
	}
}