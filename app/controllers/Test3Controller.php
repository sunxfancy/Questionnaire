<?php
	/**
	* 
	*/
class Test3Controller extends Base
{		
	public function indexAction(){
		$this->view->disable();    
    	$project_num = Project::count()+1;
        $date = date('y');
        $project_id = $date.substr(strval($project_num+100),1,2);
        echo $project_id;  
	}
}