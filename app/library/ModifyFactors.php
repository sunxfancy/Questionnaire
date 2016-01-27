<?php

class ModifyFactors extends \Phalcon\Mvc\Controller{
	
	/**
	 * @usage 8+5 
	 * @param 指标英文名称  $index_name
	 * @param 指标下属英文名称串  $children
	 * @param 被试id号 $examinee_id
	 * @return 指标及其下属排序数组 array[下属中文名， 下属英文名， 下属标准分， 下属最终分 ];
	 */
	public function getChildrenOfIndexDescFor85( $index_name,  $children,  $examinee_id ){
		$children_array = explode(',',$children);
		//根据指标进行相关因子转换，转换的因子先进行排序，返回值。
	
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
					'FactorAns.std_score as raw_score'
			
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
			//echo '<pre>';
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
					'FactorAns.std_score as raw_score'
			))
			->from('Factor')
			->inwhere('Factor.name', $children_array)
			->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
			//->orderBy('FactorAns.ans_score desc')
			->getQuery()
			->execute()
			->toArray();
			//edit by brucew 2016-01-23 添加指标-因子特例计算
			$scores = array();
			switch($index_name){
				//人际关系调节水平--恃强性 E &敏感性 I
				case "zb_rjgxtjsp":
					foreach ($result as &$value1){
						if ($value1['name'] == 'E' || $value1['name'] == 'I'){
							$value1['score'] = 10 - $value1['score'];
						}
						$scores[] = $value1['score'];
					}
					break;
					//社交水平--恃强性 E&怀疑性 L
				case "zb_sjnl":
					foreach ($result as &$value2){
						if ($value2['name'] == 'E' || $value2['name'] == 'L'){
							$value2['score'] = 10 - $value2['score'];
						}
						$scores[] = $value2['score'];
					}
					break;
					//容纳性--恃强性E
				case "zb_rnx":
					foreach ($result as &$value3){
						if ($value3['name'] == 'E'){
							$value3['score'] = 10 - $value3['score'];
						}
						$scores[] = $value3['score'];
					}
					break;
					//诚信度 -- 好印象gi
				case "zb_cxd":
					foreach ($result as &$value4){
						if ($value4['name'] == 'gi'){
							$value4['score'] = 10 - $value4['score'];
						}
						$scores[] = $value4['score'];
					}
					break;
					//情绪控制水平 -- 兴奋性F &敏感性 I
				case "zb_qxkzsp":
					foreach ($result as &$value5){
						if ($value5['name'] == 'F' || $value5['name'] == 'I'){
							$value5['score'] = 10 - $value5['score'];
						}
						$scores[] = $value5['score'];
					}
					break;
					//个人价值取向 -- 好印象gi
				case "zb_grjzqx" :
					foreach ($result as &$value6){
						if ($value6['name'] == 'gi'){
							$value6['score'] = 10 - $value6['score'];
						}
						$scores[] = $value6['score'];
					}
					break;
				default:
					foreach ($result as $value){
						$scores[] = $value['score'];
					}
					break;
				}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
		}
	}
	
	/**
	 * 
	 * @usage 个人五优三劣， 项目总体数据报告
	 * @param 指标英文名称  $index_name
	 * @param 指标下属英文名称串  $children
	 * @param 被试id号 $examinee_id
	 * @return 指标及其下属排序数组 array[下属中文名， 下属英文名， 下属最终分 ];
	 */
	public function getChildrenOfIndexDescForIndividual( $index_name,  $children,  $examinee_id ){
		$children_array = explode(',',$children);
		//根据指标进行相关因子转换，转换的因子先进行排序，返回值。
	
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
			//echo '<pre>';
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
			))
			->from('Factor')
			->inwhere('Factor.name', $children_array)
			->join('FactorAns', 'Factor.id = FactorAns.factor_id AND FactorAns.examinee_id = '.$examinee_id)
			//->orderBy('FactorAns.ans_score desc')
			->getQuery()
			->execute()
			->toArray();
			//edit by brucew 2016-01-23 添加指标-因子特例计算
			$scores = array();
			switch($index_name){
				//人际关系调节水平--恃强性 E &敏感性 I
				case "zb_rjgxtjsp":
					foreach ($result as &$value1){
						if ($value1['name'] == 'E' || $value1['name'] == 'I'){
							$value1['score'] = 10 - $value1['score'];
						}
						$scores[] = $value1['score'];
					}
					break;
					//社交水平--恃强性 E&怀疑性 L
				case "zb_sjnl":
					foreach ($result as &$value2){
						if ($value2['name'] == 'E' || $value2['name'] == 'L'){
							$value2['score'] = 10 - $value2['score'];
						}
						$scores[] = $value2['score'];
					}
					break;
					//容纳性--恃强性E
				case "zb_rnx":
					foreach ($result as &$value3){
						if ($value3['name'] == 'E'){
							$value3['score'] = 10 - $value3['score'];
						}
						$scores[] = $value3['score'];
					}
					break;
					//诚信度 -- 好印象gi
				case "zb_cxd":
					foreach ($result as &$value4){
						if ($value4['name'] == 'gi'){
							$value4['score'] = 10 - $value4['score'];
						}
						$scores[] = $value4['score'];
					}
					break;
					//情绪控制水平 -- 兴奋性F &敏感性 I
				case "zb_qxkzsp":
					foreach ($result as &$value5){
						if ($value5['name'] == 'F' || $value5['name'] == 'I'){
							$value5['score'] = 10 - $value5['score'];
						}
						$scores[] = $value5['score'];
					}
					break;
					//个人价值取向 -- 好印象gi
				case "zb_grjzqx" :
					foreach ($result as &$value6){
						if ($value6['name'] == 'gi'){
							$value6['score'] = 10 - $value6['score'];
						}
						$scores[] = $value6['score'];
					}
					break;
				default:
					foreach ($result as $value){
						$scores[] = $value['score'];
					}
					break;
			}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
		}
	}
	/**
	 *
	 * @usage 项目综合分析报告
	 * @param 指标英文名称  $index_name
	 * @param 指标下属英文名称串  $children
	 * @param 被试id号 $examinee_id
	 * @return 指标及其下属排序数组 array[下属中文名， 下属英文名， 下属最终分 ];
	 */
	public function getChildrenOfIndexDescForProject($index_name, $children, $project_id){
		$children_array = explode(',',$children);
		if ($index_name == 'zb_ldnl'){
			//zb_ldnl 0,0,0,0,0
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as chs_name',
					'AVG(IndexAns.score) as score',
					'Index.id as id'
			))
			->from('Examinee')
			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
			->join('Index', 'IndexAns.index_id = Index.id')
			->inwhere('Index.name', $children_array)
			->groupBy('Index.name')
			->orderBy('AVG(IndexAns.score) desc')
			->getQuery()
			->execute();
			return $result->toArray();
		}
		else if ($index_name == 'zb_gzzf'){
			//zb_gzzf 1,0,1,1,1,1,1
			//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
			$children_1_array = array('X4','chg','Y3','Q3','spmabc','aff');
			$result_1 = $this->modelsManager->createBuilder()
			->columns(array(
					'Factor.chs_name as chs_name',
					'AVG(FactorAns.ans_score) as score',
					'Factor.id as id'
			))
			->from('Examinee')
			->join('FactorAns', 'FactorAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
			->join('Factor', 'FactorAns.factor_id = Factor.id')
			->inwhere('Factor.name', $children_1_array)
			->groupBy('Factor.name')
			->orderBy('AVG(FactorAns.ans_score) desc')
			->getQuery()
			->execute();
			$children_2_array = array('zb_rjgxtjsp');
			$result_2 = $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as chs_name',
					'AVG(IndexAns.score) as score',
					'Index.id as id'
			))
			->from('Examinee')
			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
			->join('Index', 'IndexAns.index_id = Index.id')
			->inwhere('Index.name',$children_2_array )
			->groupBy('Index.name')
			->orderBy('AVG(IndexAns.score) desc')
			->getQuery()
			->execute();
				
			$result = array_merge($result_1->toArray(), $result_2->toArray());
			$scores = array();
			foreach ($result as $record) {
				$scores[] = $record['score'];
			}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
		}
		else {
			// 1,.,.,.,.,1
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Factor.chs_name as chs_name',
					'AVG(FactorAns.ans_score) as score',
					'Factor.id as id'
			
			))
			->from('Examinee')
			->join('FactorAns', 'FactorAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
			->join('Factor', 'FactorAns.factor_id = Factor.id')
			->inwhere('Factor.name', $children_array)
			->groupBy('Factor.name')
			//->orderBy('AVG(FactorAns.ans_score) desc')
			->getQuery()
			->execute()
			->toArray();
			//edit by brucew 2016-01-23 添加指标-因子特例计算
			$scores = array();
			switch($index_name){
				//人际关系调节水平--恃强性 E &敏感性 I
				case "zb_rjgxtjsp":
					foreach ($result as &$value1){
						if ($value1['chs_name'] == '恃强性' || $value1['chs_name'] == '敏感性'){
							$value1['score'] = 10 - $value1['score'];
						}
						$scores[] = $value1['score'];
					}
					break;
					//社交水平--恃强性 E&怀疑性 L
				case "zb_sjnl":
					foreach ($result as &$value2){
						if ($value2['chs_name'] == '恃强性' || $value2['chs_name'] == '怀疑性'){
							$value2['score'] = 10 - $value2['score'];
						}
						$scores[] = $value2['score'];
					}
					break;
					//容纳性--恃强性E
				case "zb_rnx":
					foreach ($result as &$value3){
						if ($value3['chs_name'] == '恃强性'){
							$value3['score'] = 10 - $value3['score'];
						}
						$scores[] = $value3['score'];
					}
					break;
					//诚信度 -- 好印象gi
				case "zb_cxd":
					foreach ($result as &$value4){
						if ($value4['chs_name'] == '好印象'){
							$value4['score'] = 10 - $value4['score'];
						}
						$scores[] = $value4['score'];
					}
					break;
					//情绪控制水平 -- 兴奋性F &敏感性 I
				case "zb_qxkzsp":
					foreach ($result as &$value5){
						if ($value5['chs_name'] == '兴奋性' || $value5['chs_name'] == '敏感性'){
							$value5['score'] = 10 - $value5['score'];
						}
						$scores[] = $value5['score'];
					}
					break;
					//个人价值取向 -- 好印象gi
				case "zb_grjzqx" :
					foreach ($result as &$value6){
						if ($value6['chs_name'] == '好印象'){
							$value6['score'] = 10 - $value6['score'];
						}
						$scores[] = $value6['score'];
					}
					break;
				default:
					foreach ($result as $value){
						$scores[] = $value['score'];
					}
					break;
			}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
	
		}
	}
	
	/**
	 *
	 * @usage 分人群的综合数据
	 * @param 指标英文名称  $index_name
	 * @param 指标下属英文名称串  $children
	 * @param 被试id号 $examinees 集合 array 
	 * @return 指标及其下属排序数组 array[下属中文名， 下属英文名， 下属最终分 ];
	 */
	public function getChildrenOfIndexDescForExaminees($index_name, $children, $examinees){
		$children_array = explode(',',$children);
		if ($index_name == 'zb_ldnl'){
			//zb_ldnl 0,0,0,0,0
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as chs_name',
					'AVG(IndexAns.score) as score',
					'Index.id as id'
			))
			->from('Examinee')
			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id')
			->inwhere("IndexAns.examinee_id" , $examinees)
			->join('Index', 'IndexAns.index_id = Index.id')
			->inwhere('Index.name', $children_array)
			->groupBy('Index.name')
			->orderBy('AVG(IndexAns.score) desc')
			->getQuery()
			->execute();
			return $result->toArray();
		}
		else if ($index_name == 'zb_gzzf'){
			//zb_gzzf 1,0,1,1,1,1,1
			//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
			$children_1_array = array('X4','chg','Y3','Q3','spmabc','aff');
			$result_1 = $this->modelsManager->createBuilder()
			->columns(array(
					'Factor.chs_name as chs_name',
					'AVG(FactorAns.ans_score) as score',
					'Factor.id as id'
			))
			->from('Examinee')
			->join('FactorAns', 'FactorAns.examinee_id = Examinee.id')
			->inwhere("FactorAns.examinee_id" , $examinees)
			->join('Factor', 'FactorAns.factor_id = Factor.id')
			->inwhere('Factor.name', $children_1_array)
			->groupBy('Factor.name')
			->orderBy('AVG(FactorAns.ans_score) desc')
			->getQuery()
			->execute();
			$children_2_array = array('zb_rjgxtjsp');
			$result_2 = $this->modelsManager->createBuilder()
			->columns(array(
					'Index.chs_name as chs_name',
					'AVG(IndexAns.score) as score',
					'Index.id as id'
			))
			->from('Examinee')
			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id')
			->inwhere("IndexAns.examinee_id" , $examinees)
			->join('Index', 'IndexAns.index_id = Index.id')
			->inwhere('Index.name',$children_2_array )
			->groupBy('Index.name')
			->orderBy('AVG(IndexAns.score) desc')
			->getQuery()
			->execute();
	
			$result = array_merge($result_1->toArray(), $result_2->toArray());
			$scores = array();
			foreach ($result as $record) {
				$scores[] = $record['score'];
			}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
		}
		else {
			// 1,.,.,.,.,1
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Factor.chs_name as chs_name',
					'AVG(FactorAns.ans_score) as score',
					'Factor.id as id'
		
			))
			->from('Examinee')
			->join('FactorAns', 'FactorAns.examinee_id = Examinee.id')
			->inwhere("FactorAns.examinee_id" , $examinees)
			->join('Factor', 'FactorAns.factor_id = Factor.id')
			->inwhere('Factor.name', $children_array)
			->groupBy('Factor.name')
			//->orderBy('AVG(FactorAns.ans_score) desc')
			->getQuery()
			->execute()
			->toArray();
			//edit by brucew 2016-01-23 添加指标-因子特例计算
			$scores = array();
					switch($index_name){
				//人际关系调节水平--恃强性 E &敏感性 I
				case "zb_rjgxtjsp":
					foreach ($result as &$value1){
						if ($value1['chs_name'] == '恃强性' || $value1['chs_name'] == '敏感性'){
							$value1['score'] = 10 - $value1['score'];
						}
						$scores[] = $value1['score'];
					}
					break;
					//社交水平--恃强性 E&怀疑性 L
				case "zb_sjnl":
					foreach ($result as &$value2){
						if ($value2['chs_name'] == '恃强性' || $value2['chs_name'] == '怀疑性'){
							$value2['score'] = 10 - $value2['score'];
						}
						$scores[] = $value2['score'];
					}
					break;
					//容纳性--恃强性E
				case "zb_rnx":
					foreach ($result as &$value3){
						if ($value3['chs_name'] == '恃强性'){
							$value3['score'] = 10 - $value3['score'];
						}
						$scores[] = $value3['score'];
					}
					break;
					//诚信度 -- 好印象gi
				case "zb_cxd":
					foreach ($result as &$value4){
						if ($value4['chs_name'] == '好印象'){
							$value4['score'] = 10 - $value4['score'];
						}
						$scores[] = $value4['score'];
					}
					break;
					//情绪控制水平 -- 兴奋性F &敏感性 I
				case "zb_qxkzsp":
					foreach ($result as &$value5){
						if ($value5['chs_name'] == '兴奋性' || $value5['chs_name'] == '敏感性'){
							$value5['score'] = 10 - $value5['score'];
						}
						$scores[] = $value5['score'];
					}
					break;
					//个人价值取向 -- 好印象gi
				case "zb_grjzqx" :
					foreach ($result as &$value6){
						if ($value6['chs_name'] == '好印象'){
							$value6['score'] = 10 - $value6['score'];
						}
						$scores[] = $value6['score'];
					}
					break;
				default:
					foreach ($result as $value){
						$scores[] = $value['score'];
					}
					break;
			}
			array_multisort($scores, SORT_DESC, $result );
			return $result;
	
		}
	}
	
}