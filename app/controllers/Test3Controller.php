<?php
	/**
	* 
	*/
class Test3Controller extends Base
{		
    public function indexAction(){
        $examinee_id = 31;
        $wordExport = new WordExport();
        $wordExport->individualComReport($examinee_id);
        // $wordExport->allReport($project_id);
    }

}