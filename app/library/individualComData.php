<?php
/**
 * @usage  个人综合报告数据生成，该类为individualComExport.php所用
 * @author Wangyaohui
 *
 */
class individualComData extends \Phalcon\Mvc\Controller{
	public function self_check($examinee_id){
		//check 
		$examinee =  Examinee::findFirst($examinee_id);
		if (!isset($examinee->id)){
			throw new Exception('被试id不存在');
		}
		if ($examinee->state < 5 ) {
			throw new Exception('被试基础算分未完成');
		}
		return $examinee->project_id;
	}
	public function getIndexdesc($examinee_id){
		 $this->self_check($examinee_id);
		 $result = $this->modelsManager->createBuilder()
                                       ->columns(array(
                                       	'Index.id as id',
                                        'Index.chs_name as chs_name', 
                                       	'Index.children as children',
                                       	'Index.name as name',
                                       	'IndexAns.score as score',
                                       	'IndexAns.examinee_id as examinee_id'
                                       		))
                                       ->from('Index')
                                       ->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
                                       ->orderBy('IndexAns.score desc')
                                       ->getQuery()
                                       ->execute();
		 return $result->toArray();
	}
	public function getAdvantages($examinee_id){
		$result = $this->getIndexdesc($examinee_id);
		$result_count = count($result);
		$advantages_count = $result_count >= 5 ? 5 : $result_count;
		$result = array_slice($result, 0, $advantages_count);
		$children_exists = array();
		for($start = 0; $start < $advantages_count; $start ++ ){
			$index_name = $result[$start]['name'];
			$children = $result[$start]['children'];
			$index_detail = $this->getChildrenOfIndexDesc($index_name, $children, $examinee_id);
			$top_detail = array();
			foreach($index_detail as $value){
				if (count($top_detail)  == 3 ){
					break;
				}
				if (!in_array($value['name'], $children_exists) ){
					$children_exists[] = $value['name'];
					$top_detail[] = $value;
				}
			}
			$result[$start]['detail'] = $top_detail;
		}
		return $result;
	}
	public function getDisadvantages($examinee_id){
		$result = $this->getIndexdesc($examinee_id);
		$result_count = count($result);
		$disadvantages_count = $result_count >= 3 ? 3:$result_count;
		$result = array_reverse(array_slice($result, '-'.$disadvantages_count));
		$children_exists = array();
		for($start = 0; $start < $disadvantages_count; $start ++ ){
			$index_name = $result[$start]['name'];
			$children = $result[$start]['children'];
			$index_detail = array_reverse($this->getChildrenOfIndexDesc($index_name, $children, $examinee_id));
			$bottom_detail = array();
			foreach($index_detail as $value){
				if (count($bottom_detail)  == 3 ){
					break;
				}
				if (!in_array($value['name'], $children_exists) ){
					$children_exists[] = $value['name'];
					$bottom_detail[] = $value;
				}
			}
			$result[$start]['detail'] = $bottom_detail;
		}
		return $result;
	}
	//10 分制
	public function getChildrenOfIndexDesc($index_name, $children, $examinee_id){	

		$modifyFactors = new ModifyFactors();
		return $modifyFactors->getChildrenOfIndexDescForIndividual($index_name, $children, $examinee_id);
// 		$children_array = explode(',',$children);	
// 		if ($index_name == 'zb_ldnl'){
// 				//zb_ldnl 0,0,0,0,0
// 				 $result = $this->modelsManager->createBuilder()
//                                        ->columns(array(
//                                         'Index.chs_name as chs_name', 
//                                        	'IndexAns.score as score',
//                                        	'Index.name as name'
//                                        		))
//                                        ->from('Index')
//                                        ->inwhere('Index.name', $children_array)
//                                        ->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
//                                        ->orderBy('IndexAns.score desc')
//                                        ->getQuery()
//                                        ->execute();
// 				return $result->toArray();
// 		}else if ($index_name == 'zb_gzzf'){
// 				//zb_gzzf 1,0,1,1,1,1,1 
// 				//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
// 					$children_1_array = array('X4','chg','Y3','Q3','spmabc','aff');
// 					$result_1 = $this->modelsManager->createBuilder()
// 					->columns(array(
// 							'Factor.chs_name as chs_name',
// 							'FactorAns.ans_score as score',
// 							'Factor.name as name'
// 					))
// 					->from('Factor')
// 					->inwhere('Factor.name', $children_1_array)
// 					->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
// 					->orderBy('FactorAns.ans_score desc')
// 					->getQuery()
// 					->execute();
					
// 					$children_2_array = array('zb_rjgxtjsp');
// 					$result_2 =    $this->modelsManager->createBuilder()
// 					->columns(array(
// 							'Index.chs_name as chs_name',
// 							'IndexAns.score as score',
// 							'Index.name as name'
// 					))
// 					->from('Index')
// 					->inwhere('Index.name', $children_2_array)
// 					->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
// 					->orderBy('IndexAns.score desc')
// 					->getQuery()
// 					->execute();
// 					$result = array_merge($result_1->toArray(), $result_2->toArray());
// 					$scores = array();
// 					foreach ($result as $record) {
// 			    		$scores[] = $record['score'];
// 					}
// 					array_multisort($scores, SORT_DESC, $result );
// 					return $result;
// 		}else {
// 				// 1,.,.,.,.,1
// 				$result = $this->modelsManager->createBuilder()
// 				->columns(array(
// 						'Factor.chs_name as chs_name',
// 						'FactorAns.ans_score as score',
// 						'Factor.name as name'
// 				))
// 				->from('Factor')
// 				->inwhere('Factor.name', $children_array)
// 				->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
// 				->orderBy('FactorAns.ans_score desc')
// 				->getQuery()
// 				->execute();
// 				return $result->toArray();
				
// 		}	
	}
	
	public function getindividualComprehensive($examinee_id){
		$project_id = $this->self_check($examinee_id);
		$project_detail = ProjectDetail::findFirst(
			  array (
			  		"project_id = :project_id:",
			  		'bind' => array ('project_id' => $project_id),

		));
		if(empty($project_detail) || empty($project_detail->module_names)){
			throw new Exception('项目配置信息有误');
		}
		$exist_module_array = explode(',',$project_detail->module_names);
		$module_array = array("心理健康"=>'mk_xljk',"素质结构"=>'mk_szjg',"智体结构"=>'mk_ztjg',"能力结构"=>'mk_nljg');
		$module_array_score = array();
		foreach($module_array as $key => $value){
			if (!in_array($value, $exist_module_array)){
				continue;
			}
			$module_record = Module::findFirst(
				array(
						"name = ?1",
						'bind' => array(1=>$value),
				)
			);
			$children = $module_record->children;
			$children_array = explode(',', $children);
			$result_1 = $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as name',
			))
			->from('Index')
			->inwhere('Index.name', $children_array)
			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
			->orderBy('IndexAns.score desc')
			->getQuery()
			->execute();
			$result_2 = $this->modelsManager->createBuilder()
			->columns(array(
					'AVG(IndexAns.score) as avg',
			))
			->from('Index')
			->inwhere('Index.name', $children_array)
			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
			->getQuery()
			->execute();
			$result_2 = $result_2->toArray();
			$module_array_score[$key][] = sprintf('%.2f',$result_2[0]['avg']);
			$result_1 = $result_1->toArray();
			$module_array_score[$key][] = array_splice($result_1, 0, 3);
		}
		return $module_array_score;
	}
	public function getSystemComprehensive($examinee_id){
		$project_id = $this->self_check($examinee_id);
		$result =IndexAns::find(
				array('examinee_id = ?1', 'bind'=>array(1=>$examinee_id))
		);
		$result = $result->toArray();
		//指标总数
		$count_all = count($result);
		if ($count_all <= 0 ){
			throw new Exception('指标数量为0，请确认');
		}
		//优秀（X>5.8）、良好(5.8≥X>5.3)、一般(5.3≥X>5.0)、较差（X≤5.0）
		$rate = array(
			0=>0,
			1=>0,
			2=>0,
			3=>0
		);
		$sum = 0;
		foreach($result as $value){
			$sum += $value['score'];
			if( $value['score'] > 5.8 ){
				$rate[0]++;
			}else if ($value['score'] > 5.3 ) {
				$rate[1]++;
			}else if ($value['score'] > 5.0 ) {
				$rate[2]++;
			}else {
				$rate[3]++;
			}
		}
		foreach($rate as &$value){
			$value = sprintf("%.2f",$value/$count_all)*100;
		}
		$rt['value'] = $rate;
		//计算个人的指标平均成绩，得到评价等级
		// 改用ReportData方法
		// $average = $sum/$count_all;
		// if( $average > 5.8 ){
		// 				$rt['level'] = 1;
		// 	}else if ( $average > 5.3 ) {
		// 				$rt['level'] = 2;
		// 	}else if ( $average > 5.0 ) {
		// 				$rt['level'] = 3;
		// 	}else {
		// 				$rt['level'] = 4;
		// 	}
		$rt['level'] = ReportData::getLevel($examinee_id);
		return $rt;
	}	
	public function IsHidden($examinee_id){
		$factor_name = 'epqal';
		$project_id = $this->self_check($examinee_id);
		//判断项目是否选中该因子
		$factor_id = '';
		$factor_info = ProjectDetail::findFirst(
			  array (
			  		"project_id = :project_id:",
			  		'bind' => array ('project_id' => $project_id),
		));
		$factor_names = json_decode($factor_info->factor_names,true);
		if (isset($factor_names['EPQA'])){
			if (!in_array($factor_name, $factor_names['EPQA'])){
				return true;
			}else{
				$new_array = array_flip( $factor_names['EPQA']);
				$factor_id = $new_array[$factor_name];
			}
		}else{
			return true;
		}
		//存在的情况下进行项目整体判断
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				'avg(FactorAns.score) as avg'
		))
		->from('Examinee')
		->join('FactorAns', 'Examinee.id = FactorAns.examinee_id and  Examinee.project_id = '.$project_id)
		->join('Factor', "Factor.id = FactorAns.factor_id AND Factor.name = '$factor_name'")
		->getQuery()
		->execute();
		$average = $result->toArray()[0]['avg'];
		$result = FactorAns::findFirst(
			array('factor_id = ?1 AND examinee_id = ?2', 'bind'=>array(1=>$factor_id, 2=>$examinee_id))
		);
		$person_score = $result->score;
		
		if ($person_score <= $average){
			return true;
		}else{
			return false;
		}
	}
	public function getComments($examinee_id){
		$interview = Interview::findFirst(array(
			'examinee_id=?1',
			'bind'=>array(1=>$examinee_id)));
		if (!isset($interview->examinee_id)){
			throw new Exception($examinee_id.'-专家面询未完成');
		}
		$advantage = json_decode($interview->advantage,true);
        $disadvantage = json_decode($interview->disadvantage,true);
        $comments = array(
            'advantage'    => $advantage,
            'disadvantage' => $disadvantage,
            'remark'       => $interview->remark,
            );
        return $comments;
	}

}