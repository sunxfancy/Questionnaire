<?php
class CheckoutData extends \Phalcon\Mvc\Controller {
	
	#获取个人的8+5指标
	public function getEightAddFive($examinee_info){
		$result = $this->modelsManager->createBuilder()
			    ->columns(array(
				'IndexAns.index_id as id',
			   	'IndexAns.score as score'
				))
			   ->from('IndexAns')
			   ->where('IndexAns.examinee_id = '.$examinee_info->id)
			   ->orderBy('IndexAns.score desc')
		       ->getQuery()
		       ->execute()
			   ->toArray();
		$index_count = count($result);
		$rtn_array = array();
		if ($index_count < 8 ){
			$rtn_array['strong'] = array_slice($result, 0, $index_count);
			$rtn_array['weak']   = array();
		}else if( $index_count < 13 ){
			$rtn_array['strong'] = array_slice($result, 0, 8);
			$rtn_array['weak']   = array_reverse(array_slice($result, 8, $index_count-8));
		}else {
			$rtn_array['strong'] = array_slice($result, 0, 8);
			$rtn_array['weak']   = array_reverse(array_slice($result, $index_count-6, 5));
		}
		foreach($rtn_array['strong'] as &$strong_value){
			$index = Index::findFirst(array('id=?1','bind'=>array(1=>$strong_value['id'])));
			$strong_value['chs_name'] = $index->chs_name;
			$middle = array();
			$middle = MiddleLayer::find(array('father=?1', 'bind'=>array(1=>$strong_value['chs_name'])))->toArray();
			$children = array();
			$children = $this->getChildrenOfIndexDesc($index->name, $index->children, $examinee_info->id);
			foreach($children as &$children_info){
				if(!isset($children_info['raw_score'])){
					$children_info['raw_score'] = null;
				}
			}
			$strong_value['count'] = count($children);
			$tmp = array();
			$children = $this->foo($children, $tmp);
			$strong_value['children'] = array();
			$number_count = 0;
			foreach ($middle as $middle_info ){
				$outter_tmp = array();
				$middle_children = explode(',',$middle_info['children']);
				$outter_tmp_score = 0;

				foreach ($middle_children as $children_name){
					// if ($children_name == '组织能力' || $children_name == '判断与决策能力'){
					// 	echo "<pre>";
					// 	print_r($middle_children);
					// 	print_r($children);
					// 	exit();
					// }
					$inner_tmp = array();
					$key = array_search($children_name, $children);
					$number = (intval($key)+4)/4;
					if ( $number > 3 ){
						$number = null;
					}
					$inner_tmp['name'] = $children_name;
					$inner_tmp['raw_score'] = $children[$key+3];
					$inner_tmp['ans_score'] = $children[$key+1];
					$outter_tmp_score += $inner_tmp['ans_score'];
					$inner_tmp['number']    = $number;
					$strong_value['children'][] = $inner_tmp;
				}
				$outter_tmp['name'] = null;
				$outter_tmp['raw_score'] = null;
				$outter_tmp['ans_score'] = $outter_tmp_score;
				$outter_tmp['number'] = null;
				$strong_value['children'][] = $outter_tmp;
			}
		}
		//进行逆向重排列
		foreach($rtn_array['weak'] as &$strong_value){
			$index = Index::findFirst(array('id=?1','bind'=>array(1=>$strong_value['id'])));
			$strong_value['chs_name'] = $index->chs_name;
			$middle = array();
			$middle = MiddleLayer::find(array('father=?1', 'bind'=>array(1=>$strong_value['chs_name'])))->toArray();
			$children = array();
			$children = $this->getChildrenOfIndexDesc($index->name, $index->children, $examinee_info->id);
			$children = array_reverse($children);
			foreach($children as &$children_info){
				if(!isset($children_info['raw_score'])){
					$children_info['raw_score'] = null;
				}
			}
			$strong_value['count'] = count($children);
			$tmp = array();
			$children = $this->foo($children, $tmp);
			$strong_value['children'] = array();
			$number_count = 0;
			foreach ($middle as $middle_info ){
				$outter_tmp = array();
				$middle_children = explode(',',$middle_info['children']);
				$outter_tmp_score = 0;
				foreach ($middle_children as $children_name){
					$inner_tmp = array();
					$key = array_search($children_name, $children);
					$number = (intval($key)+4)/4;
					if ( $number > 3 ){
						$number = null;
					}
					$inner_tmp['name'] = $children_name;
					$inner_tmp['raw_score'] = $children[$key+3];
					$inner_tmp['ans_score'] = $children[$key+1];
					$outter_tmp_score += $inner_tmp['ans_score'];
					$inner_tmp['number']    = $number;
					$strong_value['children'][] = $inner_tmp;
				}
				$outter_tmp['name'] = null;
				$outter_tmp['raw_score'] = null;
				$outter_tmp['ans_score'] = $outter_tmp_score;
				$outter_tmp['number'] = null;
				$strong_value['children'][] = $outter_tmp;
			}
		}
	
		return $rtn_array;
		
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
	public function getChildrenOfIndexDesc($index_name, $children, $examinee_id){
		$children_array = explode(',',$children);
		if ($index_name == 'zb_ldnl'){
			//zb_ldnl 0,0,0,0,0
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as chs_name',
					'IndexAns.score as score',
					'Index.name as name'
			))
			->from('Index')
			->inwhere('Index.name', $children_array)
			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
			->orderBy('IndexAns.score desc')
			->getQuery()
			->execute();
			return $result->toArray();
		}else if ($index_name == 'zb_gzzf'){
			//zb_gzzf 1,0,1,1,1,1,1
			//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
			$children_1_array = array('X4','chg','Y3','Q3','spmabc','aff');
			$result_1 = $this->modelsManager->createBuilder()
			->columns(array(
					'Factor.chs_name as chs_name',
					'FactorAns.ans_score as score',
					'Factor.name as name',
					'FactorAns.score as raw_score'
					
			))
			->from('Factor')
			->inwhere('Factor.name', $children_1_array)
			->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
			->orderBy('FactorAns.ans_score desc')
			->getQuery()
			->execute();
				
			$children_2_array = array('zb_rjgxtjsp');
			$result_2 =    $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as chs_name',
					'IndexAns.score as score',
					'Index.name as name'
			))
			->from('Index')
			->inwhere('Index.name', $children_2_array)
			->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
			->orderBy('IndexAns.score desc')
			->getQuery()
			->execute();
			echo '<pre>';
			$result = array_merge($result_1->toArray(), $result_2->toArray());
			
			$scores = array();
			foreach ($result as $record) {
				$scores[] = $record['score'];
			}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
		}else {
			// 1,.,.,.,.,1
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Factor.chs_name as chs_name',
					'FactorAns.ans_score as score',
					'Factor.name as name',
					'FactorAns.score as raw_score'
			))
			->from('Factor')
			->inwhere('Factor.name', $children_array)
			->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
			->orderBy('FactorAns.ans_score desc')
			->getQuery()
			->execute();
			return $result->toArray();
	
		}
	}
	
	#10 结构数据
	
	public function getindividualComprehensive($examinee_id){
		$project_id = Examinee::findFirst($examinee_id)->project_id;
		$project_detail = MemoryCache::getProjectDetail($project_id);
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
			$module_record = MemoryCache::getModuleDetail($value);
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
		}
		return $module_array_score;
	}
	#28 项指标排序
	public function getIndexdesc($examinee_id){
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				'Index.chs_name as chs_name',
				'IndexAns.score as score',
		))
		->from('Index')
		->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
		->orderBy('IndexAns.score desc')
		->getQuery()
		->execute()
		->toArray();
		$count = count($result);
		$i = 0;
		foreach ($result as & $value ){
			$value['rank'] = '';
			if ($i < 8 ){
				$value['rank'] = '★';
			}
			if ( $count - $i <= 5 ){
				$value['rank'] = '●';
			}
			$i++;
		}
		return $result;
	}
}