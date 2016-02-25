<?php

class ProjectEvaluation extends \Phalcon\Mvc\Controller {
	
	public function getIndividualEvaluation($examinee_id){
		$index_ans = IndexAns::find(array(
			'examinee_id =?1',
			'bind'=>array(1=>$examinee_id)));
		$score = 0;
		$count = 0;
		$level = '';
		foreach ($index_ans as $index) {
			$score += $index->score;
			$count++;
		}
		if ($count == 0) {
			$score_avg =0;
			$level = '未算分';
		}else{
			$score_avg = $score / $count;
		}

		if ($score_avg > 5.8) {
			$level = '优';
		}else if ($score_avg > 5.3) {
			$level = '良';
		}else if ($score_avg > 5.0) {
			$level = '中';
		}else{
			$level = '差';
		}
		$evaluation = array();
		$evaluation['score_avg'] = $score_avg;
		$evaluation['level']     = $level;
		return $evaluation;
	}
}