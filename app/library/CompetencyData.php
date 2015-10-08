<?php


class CompetencyData extends \Phalcon\Mvc\Controller
{
	/**
	 * @usage 系统 的胜任力报告 ****除去绿色通道****
	 * $Project_id int 
	 * $type 系统
	 */
	public function getSystemData($project_id){
		$team_members = Examinee::find(
		array("project_id = ?1 AND team = '系统' AND type = 0",
		'bind'=>array(1=>$project_id)
		));
		$members_count = count($team_members) ;
		if ($members_count == 0 ){
			throw new Exception('项目中的\'系统\'人数为0，无法进行胜任力报告生成');
		}
		$members_not_finished = array();
		foreach($team_members as $value){
			if ($value->state < 4 ){
				$tmp = array();
				$tmp['name'] = $value->name;
				$tmp['number'] = $value->number;
				$members_not_finished[] = $tmp;
			}
		}
		if (count($members_not_finished) > 0 ) {
			throw new Exception('系统中部分成员未完成测评过程-名单-'.print_r($members_not_finished,true));
		}
		$result = $this->modelsManager->createBuilder()
			    ->columns(array(
				//'Index.name as name',
				'Index.chs_name as chs_name',
				'avg(IndexAns.score) as score'
				))
			   ->from('Examinee')
			   ->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id='.$project_id." AND Examinee.team = '系统'")
			   ->join('Index' , 'Index.id = IndexAns.index_id')
			   ->groupBy('Index.id')
			   ->orderBy('avg(IndexAns.score) desc')
		       ->getQuery()
		       ->execute();
		$result = $result->toArray();
		$rt = array();
		$result_count = count($result);
		if ( $result_count > 8 ){
			$advantage = array_slice($result, 0, 5);
			$disadvantage = array_slice($result, -3);	
			$rt['count'] = 8;
			$rt['advantage']['count'] = 5;
			$rt['advantage']['value'] = $advantage;
			$rt['disadvantage']['count'] = 3;
			$rt['disadvantage']['value'] = $disadvantage;		
		}else{
			if ($result_count >= 5 ){
				$rt['count'] = $result_count;
				$advantage = array_slice($result, 0, 5);
				$rt['advantage']['count'] = 5;
				$rt['advantage']['value'] = $advantage;
				$rt['disadvantage']['count'] = $result_count-5;
				$disadvantage = array_slice($result, 5, $rt['disadvantage']['count']);
				$rt['disadvantage']['value'] = $disadvantage;
			}else{
				$rt['count'] = $result_count;
				$advantage = $result;
				$rt['advantage']['count'] = $result_count;
				$rt['advantage']['value'] = $advantage;
				$rt['disadvantage']['count'] =0;
				$rt['disadvantage']['value'] = null;
			}
			
		}
		$sum = 0;
		foreach($rt['advantage']['value'] as &$value){
			$value['score'] =  sprintf("%.1f", $value['score']* 12) ;
			$comment = CompetencyComment::findFirst(array(
					'name=?1',
					'bind'=>array(1=>$value['chs_name'])))->advantage;
			$comment = explode("|", $comment);
			$rand_key = array_rand($comment);
			$value['comment'] = $comment[$rand_key];
			$sum += $value['score'];
		}
		foreach($rt['disadvantage']['value'] as &$value){
			$value['score'] =  sprintf("%.1f", $value['score']* 12) ;
			$comment = CompetencyComment::findFirst(array(
					'name=?1',
					'bind'=>array(1=>$value['chs_name'])))->disadvantage;
			$comment = explode("|", $comment);
			$rand_key = array_rand($comment);
			$value['comment'] = $comment[$rand_key];
			$sum += $value['score'];
		}
		$number = $rt['count'];
		$rt['value'] =sprintf('%.1f',($sum / $number) ); 
		return $rt;
	}
	
	public function getProjectAvgIndex($project_id){
		$team_members = Examinee::find(
				array("project_id = ?1 AND type = 0",
						'bind'=>array(1=>$project_id)
				));
		$members_count = count($team_members) ;
		if ($members_count == 0 ){
			throw new Exception('项目中的人数为0，无法进行胜任力报告生成');
		}
		$members_not_finished = array();
		foreach($team_members as $value){
			if ($value->state < 4 ){
				$tmp = array();
				$tmp['name'] = $value->name;
				$tmp['number'] = $value->number;
				$members_not_finished[] = $tmp;
			}
		}
		if (count($members_not_finished) > 0 ) {
			throw new Exception('项目中部分成员未完成测评过程-名单-'.print_r($members_not_finished,true));
		}
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				//'Index.name as name',
				'Index.chs_name as chs_name',
				'avg(IndexAns.score)*12 as score'
		))
		->from('Examinee')
		->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id='.$project_id)
		->join('Index' , 'Index.id = IndexAns.index_id')
		->groupBy('Index.id')
		->orderBy('avg(IndexAns.score) desc')
		->getQuery()
		->execute();
		$result = $result->toArray();
		$tmp  = null;
		return $this->foo($result, $tmp);
	}
	
	#辅助方法 --降维
	private function foo($arr, &$rt) {
		if (is_array($arr)) {
			foreach ($arr as $v) {
				if (is_array($v)) {
					$this->foo($v, $rt);
				} else {
					$rt[] = $v;
				}
			}
		}
		return $rt;
	}
	
	/**
	 * @usage 班子 的胜任力报告 ****除去绿色通道****
	 * $Project_id int 
	 * $type 班子
	 */
	public function getTeamData($project_id){
		$team_members = Examinee::find(
				array("project_id = ?1 AND team = '班子' AND type = 0",
						'bind'=>array(1=>$project_id)
				));
		$members_count = count($team_members) ;
		if ($members_count == 0 ) {
			throw new Exception('项目中的\'班子\'人数为0，无法进行胜任力报告生成');
		}
		$members_not_finished = array();
		foreach($team_members as $value){
			if ($value->state < 4 ){
				$tmp = array();
				$tmp['name'] = $value->name;
				$tmp['number'] = $value->number;
				$members_not_finished[] = $tmp;
			}
		}
		if (count($members_not_finished) > 0 ) {
			throw new Exception('班子中部分成员未完成测评过程-名单-'.print_r($members_not_finished,true));
		}
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				//'Index.name as name',
				'Index.chs_name as chs_name',
				'avg(IndexAns.score) as score'
		))
		->from('Examinee')
		->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id='.$project_id." AND Examinee.team = '班子'")
		->join('Index' , 'Index.id = IndexAns.index_id')
		->groupBy('Index.id')
		->orderBy('avg(IndexAns.score) desc')
		->getQuery()
		->execute();
		$result = $result->toArray();
		$rt = array();
		$result_count = count($result);
		if ( $result_count > 8 ){
			$advantage = array_slice($result, 0, 5);
			$disadvantage = array_slice($result, -3);
			$rt['count'] = 8;
			$rt['advantage']['count'] = 5;
			$rt['advantage']['value'] = $advantage;
			$rt['disadvantage']['count'] = 3;
			$rt['disadvantage']['value'] = $disadvantage;
		}else{
			if ($result_count >= 5 ){
				$rt['count'] = $result_count;
				$advantage = array_slice($result, 0, 5);
				$rt['advantage']['count'] = 5;
				$rt['advantage']['value'] = $advantage;
				$rt['disadvantage']['count'] = $result_count-5;
				$disadvantage = array_slice($result, 5, $rt['disadvantage']['count']);
				$rt['disadvantage']['value'] = $disadvantage;
			}else{
				$rt['count'] = $result_count;
				$advantage = $result;
				$rt['advantage']['count'] = $result_count;
				$rt['advantage']['value'] = $advantage;
				$rt['disadvantage']['count'] =0;
				$rt['disadvantage']['value'] = null;
			}		
		}
		foreach($rt['advantage']['value'] as &$value){
			$value['score'] =  sprintf("%.1f", $value['score']* 12) ;
			$comment = CompetencyComment::findFirst(array(
					'name=?1',
					'bind'=>array(1=>$value['chs_name'])))->advantage;
			$comment = explode("|", $comment);
			$rand_key = array_rand($comment);
			$value['comment'] = $comment[$rand_key];
		}
		foreach($rt['disadvantage']['value'] as &$value){
			$value['score'] =  sprintf("%.1f", $value['score']* 12) ;
			$comment = CompetencyComment::findFirst(array(
					'name=?1',
					'bind'=>array(1=>$value['chs_name'])))->disadvantage;
			$comment = explode("|", $comment);
			$rand_key = array_rand($comment);
			$value['comment'] = $comment[$rand_key];
		}
		return $rt;
	}
	
}