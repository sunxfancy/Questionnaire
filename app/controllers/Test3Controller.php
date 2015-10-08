<?php
	use PhpOffice\PhpWord\Reader\Word2007;
/**
	* 
	*/
class Test3Controller extends Base
{		
    public function indexAction(){
    	$project_id = 1520;
        $examinee_id = 31;
        $wordExport = new WordExport();
        // $wordExport->individualComReport($examinee_id);
        // $wordExport->individualCompetencyReport($examinee_id);
        // $wordExport->comprehensiveReport($project_id);
        // $wordExport->teamReport($project_id);
        $wordExport->teamReport($project_id);
    }
    public function index1Action(){
    	$project_id = 1520;
    	$examinee_id = 31;
    	$wordExport = new WordExport();
    	// $wordExport->individualComReport($examinee_id);
    	// $wordExport->individualCompetencyReport($examinee_id);
    	// $wordExport->comprehensiveReport($project_id);
    	// $wordExport->teamReport($project_id);
    	$wordExport->systemReport($project_id);
    }
   
    public function taAction(){
    	$com = new CompetencyData();
    	$d = $com->getTeamData(1520);
    	echo '班子中的五优三劣'.'<br />';
    	echo '<pre>';
    	print_r($d);
    	echo '</pre>';
    	echo '获取班子中的五优三劣在系统中的情况'."<br />";
    	$data = $com->getPositionIndexs(1520, $d);
    	echo '<pre>';
    	print_r($data);
    	echo '</pre>';
    	echo '获取班子中的五优三劣在系统中的情况'."<br />";
    	$data = $com->getProjectIndexsByData(1520, $d);
    	echo '<pre>';
    	print_r($data);
    	echo '</pre>';
    }
    

}