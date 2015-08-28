<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function test5Action(){
		$str = 124;
		if(1 == substr($str,0,1)){
			echo 'eee';
		}
		
		
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
			echo $e->getMessage();
		}
		$memory_end = memory_get_usage( true );
		$memory_consuming = ($memory_end - $memory_start)/1024/1024;
		$time_end = $this->microtime_float();
		$time_consuming = $time_end - $time_start;
		echo $time_consuming .'-'. $memory_consuming;
	}
	public function t1Action(){
		$time_start  =  $this->microtime_float ();
		$memory_start = memory_get_usage( true );
		try{
			FactorScore::beforeStart();
			
			if(FactorScore::handleFactors(12)){
				echo "finished";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
		$memory_end = memory_get_usage( true );
		$memory_consuming = ($memory_end - $memory_start)/1024/1024;
		$time_end = $this->microtime_float();
		$time_consuming = $time_end - $time_start;
		echo $time_consuming .'-'. $memory_consuming;
		
	}	
	public function t2Action(){
		$time_start  =  $this->microtime_float ();
		$memory_start = memory_get_usage( true );
		try{
			if(IndexScore::handleIndexs(12)){
				echo "finished";
			}
		}catch(Exception $e){
			echo $e->getMessage();
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