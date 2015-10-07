<?php
	/**
	* 
	*/
class Test3Controller extends Base
{		
    public function indexAction(){
    	$project_id = 1501;
        $examinee_id = 31;
        $wordExport = new WordExport();
        // $wordExport->individualComReport($examinee_id);
        // $wordExport->individualCompetencyReport($examinee_id);
        // $wordExport->comprehensiveReport($project_id);
        // $wordExport->teamReport($project_id);
        $wordExport->systemReport($project_id);
    }

}