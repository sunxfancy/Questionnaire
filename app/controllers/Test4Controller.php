<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public static function microtime_float () {
		list( $usec ,  $sec ) =  explode ( " " ,  microtime ());
		return ((float) $usec  + (float) $sec );
	}
	
	public function indexAction(){
		$time_start  =  $this->microtime_float ();
		$memory_start = memory_get_usage( true );
		try{
			$state = FactorScore::handleFactors(12);
			FactorScore::finishedFactor(12);
			var_dump($state);
			
		}catch(Exception $e){
			echo $e->getMessage().'<br />';
		}
		$memory_end = memory_get_usage( true );
		$memory_consuming = ($memory_end - $memory_start)/1024/1024;
		$time_end = $this->microtime_float();
		$time_consuming = $time_end - $time_start;
		echo $time_consuming .'-'. $memory_consuming;
	}
	
	public static function clearAction(){
		// 		清空memcache缓存
		$memcache_obj = new Memcache;
		$memcache_obj->connect('localhost', 11211);
		$memcache_obj->flush();
		echo "finish";

	}
}