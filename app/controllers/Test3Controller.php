<?php
	use PhpOffice\PhpWord\Reader\Word2007;
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
    
    public function testAction(){
    	$re = new WordExport();
    	$d = $re->systemReport(1518);
    	echo '<pre>';
    	print_r($d);
    	echo '</pre>';	
    }
    
    public function test1Action(){
    	$com = new CompetencyData();
    	$d = $com->getSystemData(1518);
    	echo '<pre>';
    	print_r($d);
    	echo '</pre>';
    }
}