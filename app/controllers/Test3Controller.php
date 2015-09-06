<?php
	/**
	* 
	*/
class Test3Controller extends Base
{		
	public function indexAction(){
        $project_id = 1502;
        $examinee = Examinee::findFirst(19);
        $wordExport = new WordExport();
        $wordExport->examineeReport($examinee,$project_id);
	}
}