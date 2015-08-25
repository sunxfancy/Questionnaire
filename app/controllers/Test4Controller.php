<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function test5Action(){
		$examinee_id = 12;
		try{
		$factor_state = FactorScore::handleFactors($examinee_id);
		if($factor_state){
			echo "id = $examinee_id  factor finished";
		}
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		
	}
	public function indexAction(){
// 		$memory_state = BasicScore::start();	
// 		if($memory_state){
// 			echo "加载完成";
// 		}

// 		$paper= Paper::find(
//   		  array(
//        	 "cache" => array(
//             "key"      => "my-cache",
//             "lifetime" => 300
//         )
//     	)
// 		);		
// 		print_r($paper);
// 		echo "<hr />";
		
// 		$examinees = Examinee::find();
// 		print_r($examinees);
// 		echo "<br />";


// $memcache = new Memcache;
// $memcache->connect("localhost",11211); # You might need to set "localhost" to "127.0.0.1"
// echo "Server's version: " . $memcache->getVersion() . "\n";
// $tmp_object = new stdClass;
// $tmp_object->str_attr = "test";
// $tmp_object->int_attr = 123;
// $memcache->set("key",$tmp_object,false,20);
// echo "Store data in the cache (data will expire in 10 seconds)\n";
// echo "Data from the cache:\n";
// var_dump($memcache->get("key"));
		
	}
	public function t1Action(){
		$rt = Factor::queryCache(134);
		print_r($rt);
	}
}