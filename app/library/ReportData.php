<?php

class ReportData
{
	//由指标得分的平均分，判定优良中差
	public static function getLevel($examinee_id){
		$index_ans = IndexAns::find(array(
			'examinee_id'=>1,
			'bind'=>array(1=>$examinee_id)));
		$score = 0;
		$count = 0;
		foreach ($index_ans as $index) {
			$score += $index->score;
			$count++;
		}
		$score_avg = $score / $count;
		if ($score_avg > 5.8) {
			$level = 1;
		}else if ($score_avg > 5.3) {
			$level = 2;
		}else if ($score_avg > 5.0) {
			$level = 3;
		}else{
			$level = 4;
		}
		return $level;
	}
	
}