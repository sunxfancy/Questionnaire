<?php
	/**
	* 
	*/
	class Test3Controller extends Base
	{
		
		public function indexAction(){
			$this->view->disable();
			 $ss=new SearchSource(1);
			 $project=$ss->getProject();
			 print_r($project->id);
		}
	}
?>