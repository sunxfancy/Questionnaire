<?php
	/**
	* 项目综合报告数据
	*/

class ProjectComData extends \Phalcon\Mvc\Controller {
	//综合报告生成前的检测
	public function project_check($project_id){
		$project_members = Examinee::find(
				array("project_id = ?1 AND type = 0",
						'bind'=>array(1=>$project_id)
				));
		$members_count = count($project_members) ;
		if ($members_count == 0 ){
			throw new Exception('项目的被试人数为0,无法进行项目综合报告生成');
		}
		$members_not_finished = array();
		foreach($project_members as $value){
			if ($value->state < 4 ){
				$tmp = array();
				$tmp['name'] = $value->name;
				$tmp['number'] = $value->number;
				$members_not_finished[] = $tmp;
			}
		}
		if (count($members_not_finished) > 0 ) {
			throw new Exception('项目成员未完成测评过程-名单-'.print_r($members_not_finished,true));
		}
	}
	#获取职业素质综合评价相关数据
	public function getComprehensiveData($project_id){
		$this->project_check($project_id);
		#判断项目详细信息中是否有职业素质相关的模块
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
			//获取某项模块下所有指标的平均分
			$result_1 = $this->modelsManager->createBuilder()
			->columns(array(
					'AVG(IndexAns.score) as score',
					'Index.chs_name as chs_name',
					'Index.id as id'
			))
			->from('Examinee')
			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id = '.$project_id)
			->join('Index', 'Index.id = IndexAns.index_id')
			->inwhere('Index.name', $children_array)
			->groupBy('Index.name')
			->orderBy('AVG(IndexAns.score) desc')
			->getQuery()
			->execute();
			$tmp = array();
			$tmp['children']= $result_1->toArray();
			$count = count($result_1);
			$sum = 0;
			foreach($tmp['children'] as &$value){
				$sum += sprintf('%.2f', $value['score'] );
			}
			if ($count == 0 ){
				throw new Exception('系统错误-模块下属指标的数量为0');
			}
			$tmp['value'] = sprintf('%.2f', $sum/$count);
			$module_array_score[] = $tmp;
		}
		return $module_array_score;
			
	}
	
	#项目总体的五优三劣
	
	#获取项目总体的指标顺序排序---
	public function getProjectIndexDesc($project_id){
		$this->project_check($project_id);
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				'Index.name as name',
				'Index.chs_name as chs_name',
				'AVG(IndexAns.score) as score',
				'Index.children as children'
				
		))
		->from('Examinee')
		->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id = '.$project_id)
		->join('Index', 'Index.id = IndexAns.index_id')
		->groupBy('Index.id')
		->orderBy('AVG(IndexAns.score) desc')
		->getQuery()
		->execute();
		 return $result->toArray();
	}
	
	#获取项目总体的优势指标--并得到其下属因子的得分排序完成的五优以及其下因子的排序结果
	public function getProjectAdvantages($project_id){
		$result = $this->getProjectIndexDesc($project_id);
		$result_count = count($result);
		$advantages_count = $result_count >= 5 ? 5 : $result_count;
		$result = array_slice($result, 0, $advantages_count);
// 		$children_exists = array();
		for($start = 0; $start < $advantages_count; $start ++ ){
			$index_name = $result[$start]['name'];
			$children = $result[$start]['children'];
			$index_detail = $this->getChildrenOfProjectIndexDesc($index_name, $children, $project_id);
// 			$top_detail = array();
// 			foreach($index_detail as $value){
// 				if (count($top_detail)  == 3 ){
// 					break;
// 				}
// 				if (!in_array($value['name'], $children_exists) ){
// 					$children_exists[] = $value['name'];
// 					$top_detail[] = $value;
// 				}
// 			}
// 			$result[$start]['detail'] = $top_detail;
			$result[$start]['detail'] = $index_detail;
		}
		return $result;
	}
	
	#获取项目总体的劣势指标--并得到其下属因子的得分 三劣 以及其下各自因子的排序结果
	public function getProjectDisadvantages($project_id){
		$result = $this->getProjectIndexDesc($project_id);
		$result_count = count($result);
		$disadvantages_count = $result_count >= 3 ? 3:$result_count;
		$result = array_reverse(array_slice($result, '-'.$disadvantages_count));
// 		$children_exists = array();
		for($start = 0; $start < $disadvantages_count; $start ++ ){
			$index_name = $result[$start]['name'];
			$children = $result[$start]['children'];
			$index_detail = array_reverse($this->getChildrenOfProjectIndexDesc($index_name, $children, $project_id));
// 			$bottom_detail = array();
// 			foreach($index_detail as $value){
// 				if (count($bottom_detail)  == 3 ){
// 					break;
// 				}
// 				if (!in_array($value['name'], $children_exists) ){
// 					$children_exists[] = $value['name'];
// 					$bottom_detail[] = $value;
// 				}
// 			}
// 			$result[$start]['detail'] = $bottom_detail;
			$result[$start]['detail'] = $index_detail;
			
		}
		return $result;
	}
	
	#获取项目的指标下属因子的得分排序返回
	public function getChildrenOfProjectIndexDesc($index_name, $children, $project_id){
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
			->orderBy('AVG(FactorAns.ans_score) desc')
			->getQuery()
			->execute();
			return $result->toArray();
		
		}
	}
	
	##通过因子找到项目中各层群人数的因子得分情况
	public function getFactorGrideByLevel($factor_id, $factor_chs_name, $level_examines,$project_id){
		#判断因子是index还是factor
		$factor_info = Factor::findFirst(
			array("id = ?1 AND chs_name = ?2", 'bind'=>array(1=>$factor_id, 2=>$factor_chs_name))
		);
		if (isset($factor_info->id)){
			//对各层次人群进行得分计算后返回
			$rtn_array = array();
			foreach( $level_examines as $level_array ){
				$result = $this->modelsManager->createBuilder()
							->columns(array(
								'AVG(FactorAns.ans_score) as score',
							  ))
							->from('Examinee')
							->inwhere('Examinee.id', $level_array)
							->join('FactorAns', 'FactorAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
							->join('Factor', 'FactorAns.factor_id = Factor.id AND Factor.chs_name = '."'$factor_chs_name'")
							->getQuery()
							->execute()
							->toArray();
				
				if (empty($result[0]['score'])){
					$score = 0;
				}else{
					$score = sprintf('%.2f', $result[0]['score']);
				}
				$rtn_array[] = $score; 
			}
			return $rtn_array;
		}
		$index_info = Index::findFirst(
			array("id = ?1 AND chs_name = ?2", 'bind'=>array(1=>$factor_id, 2=>$factor_chs_name))
		);
		if (isset($index_info->id)){
			$rtn_array = array();
			foreach( $level_examines as $level_array ){
				$result = $this->modelsManager->createBuilder()
							->columns(array(
								'AVG(IndexAns.score) as score',
							  ))
							->from('Examinee')
							->inwhere('Examinee.id', $level_array)
							->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
							->join('Index', 'IndexAns.index_id = Index.id AND Index.chs_name = '."'$factor_chs_name'")
							->getQuery()
							->execute()
							->toArray();
				
				if (empty($result[0]['score'])){
					$score = 0;
				}else{
					$score = sprintf('%.2f', $result[0]['score']);
				}
				$rtn_array[] = $score; 
			}
			return $rtn_array;
		}
		throw new Exception('no this factor exist!'.print_r($factor_id.'-'.$factor_chs_name));
	}
	##通过因子来找评语(对应评语中的前三)
	
	###################################################################################
	#																				  #
	#从需求量表答案结合被试信息表判断综合数据报表的基础点							  #
	#   需求量表中第一个题（单选）													  #
	###################################################################################
	
	#获取各层级下的人员清单 --- key(level) => value(examinee_ids_array)
	public function getBaseLevels($project_id){
		#获取基本项array
		$level_str =  $this->modelsManager->createBuilder()
			->columns(array( 'options' ))
			->from('InqueryQuestion')
			->where('id = 1 AND project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
		$level_array = explode('|', $level_str[0]['options']);
		#获取被试id_array
		$level_examines = array_keys($level_array);
		foreach($level_examines as &$value ){
			$value = array();
		}
		$examinee_ids = $this->modelsManager->createBuilder()
			->columns(array( 'Examinee.id as id' ))
			->from('Examinee')
			->where('Examinee.type =0 AND Examinee.project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
		foreach($examinee_ids as $svalue){
			$option = $this->modelsManager->createBuilder()
			->columns(array( 'InqueryAns.option as option' ))
			->from('InqueryAns')
			->where('InqueryAns.examinee_id = '. $svalue['id'].' AND InqueryAns.project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
			$level = ord(substr($option[0]['option'], 0 ,1)) -ord('a') ;
			$level_examines[$level][] = $svalue['id'];			
		}
		return array_combine($level_array,$level_examines);
	}


	#需求量表本身分析：是否多选 以及选项答案
	public function getInqueryDetail($project_id) {
		$inquery_questions =  $this->modelsManager->createBuilder()
			->columns(array( 'options','is_radio' ))
			->from('InqueryQuestion')
			->where('project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
		foreach($inquery_questions as & $question_record){
			 $question_record['options'] = explode( '|' , $question_record['options'] );
		}
		return $inquery_questions;
	}

	#全体人员需求量表的结果逐个分析
	public function getInqueryAnsDetail($project_id){
		  $option_array = $this->modelsManager->createBuilder()
			->columns(array( 'InqueryAns.option as option' ))
			->from('InqueryAns')
			->where('InqueryAns.project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
			$tmp = null;
		$inquery_total = array();
		foreach( $option_array as $value ){
			$option_value_array = explode('|', $value['option']);
		    foreach($option_value_array as $key=>$value){

		    }
		}
		print_r($option_array);
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