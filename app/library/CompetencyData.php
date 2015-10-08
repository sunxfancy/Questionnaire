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
		//disadvantage 顺序排序
		$rt['disadvantage']['value'] = array_reverse($rt['disadvantage']['value']);
		$number = $rt['count'];
		$rt['value'] =sprintf('%.1f',($sum / $number) ); 
		return $rt;
	}
	/**
	 * 获取项目下所有人的各项指标的平均分****除去绿色通道****
	 */
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
		//disadvantage 顺序排序
		$rt['disadvantage']['value'] = array_reverse($rt['disadvantage']['value']);
		return $rt;
	}
	
	/**
	 *班子的职位分布
	 */
	public function getTeamPositions($project_id){
		//get all positions 
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				'DISTINCT(Examinee.professional) as professional'
		))
		->from('Examinee')
		->where('Examinee.type = 0 AND Examinee.team='."'班子' AND Examinee.project_id = $project_id")
		->getQuery()
		->execute();
		$result = $result->toArray();
		$tmp = null;
		$result = $this->foo($result,$tmp);
		return $result;
	}
	
	/**
	 * 获取各职称下的五优三劣分布
	 */
	public function getPositionIndexs($project_id, &$team_data){
		$positions = $this->getTeamPositions($project_id);
		$rt = array();
		foreach( $positions as $position ){
			$rt[$position] = $this->getProjectIndexsByDataAndPositon($project_id, $position, $team_data);
		}
		return $rt;
	}
	/**
	 * @usage 根据班子的整体无忧三列数据获取某一职位下的五优三劣
	 */
	public function getProjectIndexsByDataAndPositon($project_id, $position, &$team_data){
		$position_data = $this-> getProjectIndexsByPosition($project_id, $position);
		$sys_array = array();
		$pro_array = array();
		$data_pro_tmp = array();
		foreach($team_data['advantage']['value'] as $value){
			$data_pro_tmp = $position_data;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = sprintf('%.1f',$position_data[$key+1]);
		}
		
		foreach($team_data['disadvantage']['value'] as $value){
			$data_pro_tmp = $position_data;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = sprintf('%.1f',$position_data[$key+1]);
		}
		return $pro_array;
	}
	
	/**
	 * @usage 在班子中找出职位一致的人的所有指标平均值数据
	 * @ 此函数在获取班子的指标平均值后才会调用
	 */
	public function getProjectIndexsByPosition($project_id, $position){
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				//'Index.name as name',
				'Index.chs_name as chs_name',
				'avg(IndexAns.score)*12 as score'
		))
		->from('Examinee')
		->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id='.$project_id." AND Examinee.team ='班子' AND Examinee.professional = '$position'")
		->join('Index' , 'Index.id = IndexAns.index_id')
		->groupBy('Index.id')
		->orderBy('avg(IndexAns.score) desc')
		->getQuery()
		->execute();
		$result = $result->toArray();
		$tmp  = null;
		return $this->foo($result, $tmp);
	}
	
	/**
	 * @usage 根据已有的五优三劣获取系统的五优三劣的平均值----即可得到标准值
	 */
	public function getProjectIndexsByData($project_id, &$team_data){
		$data_pro= $this->getProjectAvgIndex($project_id);
		$sys_array = array();		
		$pro_array = array();
		$data_pro_tmp = array();
		foreach($team_data['advantage']['value'] as $value){
			$data_pro_tmp = $data_pro;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = sprintf('%.1f',$data_pro[$key+1]);
		}
		
		foreach($team_data['disadvantage']['value'] as $value){
			$data_pro_tmp = $data_pro;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = sprintf('%.1f',$data_pro[$key+1]);
		}
		return $pro_array;
	}
	
}