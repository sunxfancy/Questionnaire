<?php

class ProjectData extends \Phalcon\Mvc\Controller {
	
	public function getindividualComprehensive($examinee_id){
		$project_id = Examinee::findFirst($examinee_id)->project_id;
		$project_detail = 	ProjectDetail::findFirst(
		array (
		"project_id = :project_id:",
		'bind' => array ('project_id' => $project_id),
		)
		);
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
					'Index.chs_name as chs_name',
					'Index.name as name',
					'IndexAns.score as score',
					'Index.children as children'
			))
			->from('Index')
			->inwhere('Index.name', $children_array)
			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
			->orderBy('IndexAns.score desc')
			->getQuery()
			->execute()
			->toArray();
			//进行规范排序
			$module_array_score[$key] = array();
			foreach($result_1 as &$result_1_record){
				$skey = array_search($result_1_record['name'], $children_array);
				$module_array_score[$key][$skey] = $result_1_record;
			}
			//对指标层进行遍历查找中间层,以及children
			foreach($module_array_score[$key] as &$index_info ) {
				$middle = array();
				$middle = MiddleLayer::find(array('father_chs_name=?1', 'bind'=>array(1=>$index_info['chs_name'])))->toArray();
				$children = array();
				$index_info['count'] = count(explode(',',$index_info['children']));
				$children = $this->getChildrenOfIndexDesc($index_info['name'], $index_info['children'], $examinee_id);
				$tmp = array();
				$children = $this->foo($children, $tmp);
				$tmp_detail = array();
				foreach ($middle as $middle_info ){
					$outter_tmp = array();
					$middle_children = explode(',',$middle_info['children']);
					$outter_tmp_score = 0;
					foreach ($middle_children as $children_name){
						$skey = array_search($children_name, $children);
						$inner_tmp = array();
						$inner_tmp['name'] = $children_name;
						$inner_tmp['score'] = $children[$skey+1];
						$outter_tmp_score += $inner_tmp['score'];
						$tmp_detail[] = $inner_tmp;
					}
					$outter_tmp['name'] = null;
					$outter_tmp['score'] = $outter_tmp_score;
					$tmp_detail[] = $outter_tmp;
				}
				$index_info['detail'] = $tmp_detail;
				
			}
		}
		return $module_array_score;
	}
	
	/**
	 * @usage 28项全     不同层被试人员的平均成绩
	 */
	public function getlevelsComprehensive($examinee_ids){
		$project_id = Examinee::findFirst($examinee_ids[0])->project_id;
		$project_detail = 	ProjectDetail::findFirst(
		array (
		"project_id = :project_id:",
		'bind' => array ('project_id' => $project_id),
		)
		);
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
					'Index.chs_name as chs_name',
					'Index.name as name',
					'AVG(IndexAns.score) as score',
					'Index.children as children'
			))
			->from('Index')
			->inwhere('Index.name', $children_array)
			->join('IndexAns', 'IndexAns.index_id = Index.id')
			->inwhere("IndexAns.examinee_id", $examinee_ids)
			->orderBy('AVG(IndexAns.score) desc')
			->groupBy('Index.name')
			->getQuery()
			->execute()
			->toArray();
			//进行规范排序
			$module_array_score[$key] = array();
			foreach($result_1 as &$result_1_record){
				$skey = array_search($result_1_record['name'], $children_array);
				$module_array_score[$key][$skey] = $result_1_record;
			}
			//对指标层进行遍历查找中间层,以及children
			
			$modifyData = new ModifyFactors();
			foreach($module_array_score[$key] as &$index_info ) {
				$middle = array();
				$middle = MiddleLayer::find(array('father_chs_name=?1', 'bind'=>array(1=>$index_info['chs_name'])))->toArray();
				$children = array();
				$index_info['count'] = count(explode(',',$index_info['children']));
				$children = $modifyData->getChildrenOfIndexDescForExaminees($index_info['name'], $index_info['children'], $examinee_ids);
				//$children = $this->getChildrenOfIndexDesc($index_info['name'], $index_info['children'], $examinee_id);
				$tmp = array();
				$children = $this->foo($children, $tmp);
				$tmp_detail = array();
				foreach ($middle as $middle_info ){
					$outter_tmp = array();
					$middle_children = explode(',',$middle_info['children']);
					$outter_tmp_score = 0;
					foreach ($middle_children as $children_name){
						$skey = array_search($children_name, $children);
						$inner_tmp = array();
						$inner_tmp['name'] = $children_name;
						$inner_tmp['score'] = $children[$skey+1];
						$outter_tmp_score += $inner_tmp['score'];
						$tmp_detail[] = $inner_tmp;
					}
					$outter_tmp['name'] = null;
					$outter_tmp['score'] = $outter_tmp_score;
					$tmp_detail[] = $outter_tmp;
				}
				$index_info['detail'] = $tmp_detail;
				
			}
		}
		return $module_array_score;
	}
	
	public function getChildrenOfIndexDesc($index_name, $children, $examinee_id){
		
		$modifyFactors = new ModifyFactors();
		return $modifyFactors->getChildrenOfIndexDescForIndividual($index_name, $children, $examinee_id);
		
		
// 		$children_array = explode(',',$children);
// 		if ($index_name == 'zb_ldnl'){
// 			//zb_ldnl 0,0,0,0,0
// 			$result = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Index.chs_name as chs_name',
// 					'IndexAns.score as score',
// 					'Index.name as name'
// 			))
// 			->from('Index')
// 			->inwhere('Index.name', $children_array)
// 			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
// 			->orderBy('IndexAns.score desc')
// 			->getQuery()
// 			->execute();
// 			return $result->toArray();
// 		}else if ($index_name == 'zb_gzzf'){
// 			//zb_gzzf 1,0,1,1,1,1,1
// 			//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
// 			$children_1_array = array('X4','chg','Y3','Q3','spmabc','aff');
// 			$result_1 = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Factor.chs_name as chs_name',
// 					'FactorAns.ans_score as score',
// 					'Factor.name as name',
			
// 			))
// 			->from('Factor')
// 			->inwhere('Factor.name', $children_1_array)
// 			->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
// 			->orderBy('FactorAns.ans_score desc')
// 			->getQuery()
// 			->execute();
	
// 			$children_2_array = array('zb_rjgxtjsp');
// 			$result_2 =    $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Index.chs_name as chs_name',
// 					'IndexAns.score as score',
// 					'Index.name as name'
// 			))
// 			->from('Index')
// 			->inwhere('Index.name', $children_2_array)
// 			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
// 			->orderBy('IndexAns.score desc')
// 			->getQuery()
// 			->execute();

// 			$result = array_merge($result_1->toArray(), $result_2->toArray());	
// 			$scores = array();
// 			foreach ($result as $record) {
// 				$scores[] = $record['score'];
// 			}
// 			array_multisort($scores, SORT_DESC, $result );
// 			return $result;
// 		}else {
// 			// 1,.,.,.,.,1
// 			$result = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Factor.chs_name as chs_name',
// 					'FactorAns.ans_score as score',
// 					'Factor.name as name',
// 			))
// 			->from('Factor')
// 			->inwhere('Factor.name', $children_array)
// 			->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
// 			->orderBy('FactorAns.ans_score desc')
// 			->getQuery()
// 			->execute();
// 			return $result->toArray();
	
// 		}
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
	
}