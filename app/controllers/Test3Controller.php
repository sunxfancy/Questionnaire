<?php
/**
	* 
	*/
class Test3Controller extends Base
{		
    public function indexAction(){
    	$project_id = 1520;
        $wordExport = new ProjectComExport();
        $wordExport->report($project_id);
    }
 

}