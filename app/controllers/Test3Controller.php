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
    
    public function testAction(){
    	$project_id = 1520;
    	$data = new ProjectComData();
    	$data->getComprehensiveData($project_id);
    }
 

}