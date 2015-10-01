<?php
	/**
	* 
	*/
class Test3Controller extends Base
{		
	public function indexAction(){
        // $project_id = 1501;
        // $examinee = Examinee::findFirst(53);
        // $wordExport = new WordExport();
        // $wordExport->examineeReport($examinee,$project_id);
        // $wordExport->allReport($project_id);
        $report = new ReportData();
        $report->getComprehensive(19);
	}
}