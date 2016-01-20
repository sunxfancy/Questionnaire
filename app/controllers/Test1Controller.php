<?php

class Test1Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function testAction(){
		
		  $scl_paper_id = Paper::findFirst( array( "name = ?1", 'bind' => array(1=>"SCL")))->id;
		  $examinee =(object)array();
		  $examinee->id = 1794;
		  $scl_question_ans = QuestionAns::findFirst(array("paper_id = ?1 AND examinee_id = ?2", 'bind'=>array(1=>$scl_paper_id, 2=>$examinee->id)));
		  echo '<pre>';
		  print_r($scl_question_ans->score);
		
	}
	
}