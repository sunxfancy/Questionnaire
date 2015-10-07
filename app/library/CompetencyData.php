<?php


class CompetencyData
{
	public static function getData($project_id,$type){
		$examinee = Examinee::find(array(
			'project_id=?0 and team=?1 and state>4',
			'bind'=>array(0=>$project_id,1=>$type)));
		$examinee_all = Examinee::find(array(
			'project_id=?1 and state>4',
			'bind'=>array(1=>$project_id)));
		if (count($examinee) == 0) {
			throw new Exception("还未有".$type."的人参与测试！");
		}
		foreach ($examinee as $examinees) {
			$index_score = IndexAns::find(array(
				'examinee_id=?1',
				'bind'=>array(1=>$examinees->id)));
			foreach ($index_score as $iscore) {
				$score[$iscore->index_id][] = $iscore->score;
			}
		}
		foreach ($score as $key => $value) {
			$sum = array_sum($value);
			$count = count($value);
			$avg[$key] = $sum / $count;
		}
		arsort($avg);
		if (count($avg) > 5) {
			$advantage = array_slice($avg, 0, 5, true);
		}else{
			$advantage = $avg;
		} 
		$disadvantage = array_slice($avg, count($avg)-3, 3, true);
		foreach ($advantage as $key => $value) {
			$chs_name = Index::findFirst($key)->chs_name;
			$result['advantage'][$key]['chs_name'] = $chs_name;
			$result['advantage'][$key]['value'] = $value;
			$comment = CompetencyComment::findFirst(array(
				'name=?1',
				'bind'=>array(1=>$chs_name)))->advantage;
			$comment = explode("|", $comment);
	 		$rand_key = array_rand($comment);
	 		$result['advantage'][$key]['comment'] = $comment[$rand_key];
		}
		foreach ($disadvantage as $key => $value) {
			$chs_name = Index::findFirst($key)->chs_name;
			$result['disadvantage'][$key]['chs_name'] = $chs_name;
			$result['disadvantage'][$key]['value'] = $value;
			$comment = CompetencyComment::findFirst(array(
				'name=?1',
				'bind'=>array(1=>$chs_name)))->disadvantage;
			$comment = explode("|", $comment);
	 		$rand_key = array_rand($comment);
	 		$result['disadvantage'][$key]['comment'] = $comment[$rand_key];
		}
		return $result;
	}
}