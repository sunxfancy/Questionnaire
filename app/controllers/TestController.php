<?php

class TestController extends \Phalcon\Mvc\Controller {
	
	public function testAction(){
		$age = FactorScore::calAge('1980-07-2', '2015-11-06');
		echo $age;
		echo $age;
		exit();
		
	}
	
	public function test2Action(){
		$numberstr = "451262425624221213541236823371528244344886467588338347484757";
		$numberarr = str_split($numberstr);
		foreach($numberarr as &$value ){
			$value = chr(96+$value);
		}
		$choicestr = implode('|', $numberarr);
		echo $choicestr;
		exit();
	}
	
	public function test3Action(){
		$str = "AABBCACBCBCCACACCCACCACBBCCBAAAAABBCCBAACABBCCAACCCACBAABCBBACBAABBACBABACAAAACCACBCBAACBCACBBBBBBBACCAABBBCBBAABBCBACBCCBABAACABACACBCCACAAACCBCBABBAAACCCCBACAACCBBACCCCBCBCCCAAABAACAAAA";$str = strtolower($str);
		$strarr = str_split($str);
		$strstr = implode('|', $strarr);
		
		echo $strstr;
		exit(); 
	
	}

	public function test4Action(){
		if(file_exists('./project/11/1111/personal_result/')){
			echo "ok";
		}else{
			mkdir('./project/11/1111/');
		}

	}
}