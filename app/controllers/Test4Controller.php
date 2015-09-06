<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		// $this->view->setTemplateAfter('base3');
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public static function microtime_float () {
		list( $usec ,  $sec ) =  explode ( " " ,  microtime ());
		return ((float) $usec  + (float) $sec );
	}
	
	public function indexAction(){
		$this->view->setVar('postId', 1111);
		$this->view->setVar('page_title','test');
		$this->view->setVar('name','test');
		$this->view->setVar('number', 110);
		$this->view->setVar('role', '测试');
		$this->view->paper = Paper::findFirst();
		$rtn_array = array(
			'hello', '你好'
		);
		$this->view->visit = $rtn_array;
		
		$this->view->json = json_encode($rtn_array);
// 		FactorScore::handleFactors(17);
// 		exit();
// 		var_dump(empty(0));
// 		var_dump(empty(''));
// 		var_dump(empty(false));
// 		var_dump(empty(true));
// 		exit();
// 		$time_start  =  $this->microtime_float ();
// 		$memory_start = memory_get_usage( true );
// 		try{
// 			$state = FactorScore::handleFactors(12);
// 			FactorScore::finishedFactor(12);
// 			var_dump($state);
			
// 		}catch(Exception $e){
// 			echo $e->getMessage().'<br />';
// 		}
// 		$memory_end = memory_get_usage( true );
// 		$memory_consuming = ($memory_end - $memory_start)/1024/1024;
// 		$time_end = $this->microtime_float();
// 		$time_consuming = $time_end - $time_start;
// 		echo $time_consuming .'-'. $memory_consuming;
	}
	public function gettestAction(){
		
		$time=$this->request->getPost("time","int");
		sleep(5);
		echo $time;
	}
	public static function clearAction(){
		// 		清空memcache缓存
		$memcache_obj = new Memcache;
		$memcache_obj->connect('localhost', 11211);
		$memcache_obj->flush();
		echo "finish";

	}
}