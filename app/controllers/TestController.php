<?php

class TestController extends \Phalcon\Mvc\Controller {
	
	public function testAction(){
		$age = FactorScore::calAge('1980-07-2', '2015-11-06');
		echo $age;
		exit();
		
	}
	
	public function test2Action(){
		$numberstr = "1212212221111112221212221222121121111112212222221222121122221122222222112111221221212111";
		$numberarr = str_split($numberstr);
		foreach($numberarr as &$value ){
			$value = chr(96+$value);
		}
		$choicestr = implode('|', $numberarr);
		echo $choicestr;
		exit();
	}
	
	public function test3Action(){
		$str = "AACACBCCCACBACBACBAACABCCBABABBAABCCACACACBBAABBBCCCBBBBBCCBCCABCCCBCAABAACBCBACABBBACCBABABBACCBACBBBACACBBCACACCAACCBACACBACBBABCAACCCCABACCAACCABBBABAACAABCABCAABBCBCCACACCBBAABABCCABA";
		$str = strtolower($str);
		$strarr = str_split($str);
		$strstr = implode('|', $strarr);
		
		echo $strstr;
		exit(); 
	
	}
}