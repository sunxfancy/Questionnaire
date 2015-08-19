<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	public function indexAction(){
		try{
		MemoryManagement::startMysqlMemoryTable('cpidf');
		}catch(Exception $e){
			echo $e->getMessage();
			return ;
		}
	
	}
}