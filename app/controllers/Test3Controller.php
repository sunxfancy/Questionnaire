<?php
	/**
	* 
	*/
	class Test3Controller extends Base
	{
		
		public function indexAction(){
			$this->view->disable();
			 // $ss=new SearchSource(1);
			 // $project=$ss->getModules_id();
			 // print_r($project);

			echo json_encode(array("aaa"=>"$$$"));

		}
	}
?>