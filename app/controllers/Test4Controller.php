<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	public function indexAction(){

		$examinee_id = 12;
		$basic_score = new BasicScoreOne();
		try{
		$answers_df = $basic_score->getPapersByExamineeId($examinee_id);
		}catch(Exception $e){
			echo $e->getMessage();
		}
		echo "<pre>";
		print_r($answers_df);
		echo "</pre>";
	}
}