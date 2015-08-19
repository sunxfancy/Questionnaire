<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	public function test5Action(){
		$examinee_id = 12;
		BasicScore::handlePapers($examinee_id);
		
	}
	public function indexAction(){
		try{
		MemoryManagement::startMysqlMemoryTable('cpidf');
		}catch(Exception $e){
			echo $e->getMessage();
			return ;
		}
	
	}
	public function test1Action(){
		try{
			MemoryManagement::startMysqlMemoryTable('eppsdf');
		}catch(Exception $e){
			echo $e->getMessage();
			return ;
		}
	}
	public function test2Action(){
		try{
			MemoryManagement::startMysqlMemoryTable('epqadf');
		}catch(Exception $e){
			echo $e->getMessage();
			return ;
		}
	}
	public function test3Action(){
		try{
			MemoryManagement::startMysqlMemoryTable('spmdf');
		}catch(Exception $e){
			echo $e->getMessage();
			return ;
		}
	}
}