<?php
	/**
	* 
	*/
	class Test3Controller extends Base
	{
		
		public function indexAction(){
			$this->view->disable();
			$ss=new SearchSource(1);
			$modules=$ss->getModules(1);
			print_r($ss->getIdArray($modules));
		}
	}
?>