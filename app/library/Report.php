<?php

class Report extends \Phalcon\Mvc\Controller{
	private function self_check($examinee_id){
		//check 
		$examinee =  Examinee::findFirst($examinee_id);
		if (empty($examinee)){
			throw new Exception('被试id不存在');
		}
		if ($examinee->state < 5 ) {
			throw new Exception('被试基础算分未完成');
		}
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
							'Factor.name as name'
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
						'Factor.name as name'
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
}