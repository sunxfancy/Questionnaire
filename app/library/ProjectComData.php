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
		foreach($project_members as $value){
			if ($value->state < 4 ){
				$members_not_finished[$value->number] = $value->name;
			}
		}
		if (isset($members_not_finished)) {
			$list = '系统中部分成员未完成测评过程，如下:<br/>';
			foreach ($members_not_finished as $key => $value) {
				$list .= $key.'：'.$value.'<br/>';
			}
			throw new Exception(print_r($list,true));
		}

	}
	#获取职业素质综合评价相关数据
	public function getComprehensiveData($project_id){
		$this->project_check($project_id);
		#判断项目详细信息中是否有职业素质相关的模块
		$project_detail = ProjectDetail::findFirst(
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
		$module_name_array = array("心理健康"=>'职业心理',"素质结构"=>'职业素质',"智体结构"=>'智体结构',"能力结构"=>'职业能力');

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
			foreach($tmp['children'] as &$svalue){
				$sum += sprintf('%.2f', $svalue['score'] );
			}
			if ($count == 0 ){
				throw new Exception('系统错误-模块下属指标的数量为0');
			}
			$tmp['value'] = sprintf('%.2f', $sum/$count);
			$tmp['name'] =$module_name_array[$key];
			$tmp['name_in_table'] = $value;
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
	#获取部分人员的指标平均分---
	public function IndexAvgOfExaminees($examinee_ids){
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				// 'Index.name as name',
				'Index.chs_name as chs_name',
				'AVG(IndexAns.score) as score'
		))
		->from('Examinee')
		->join('IndexAns', 'IndexAns.examinee_id = Examinee.id')
		->inwhere('Examinee.id', $examinee_ids)
		->join('Index', 'Index.id = IndexAns.index_id')
		->groupBy('Index.id')
		->getQuery()
		->execute();
		 return $result->toArray();
	}
	#获取部分人员的指标平均分---DESC
	public function IndexAvgOfExamineesDesc($examinee_ids){
		$result = $this->modelsManager->createBuilder()
		->columns(array(
				'Index.name as name',
				'Index.chs_name as chs_name',
				'Index.children as children',
				'AVG(IndexAns.score) as score'
		))
		->from('Examinee')
		->join('IndexAns', 'IndexAns.examinee_id = Examinee.id')
		->inwhere('Examinee.id', $examinee_ids)
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
		$modifyFactors = new ModifyFactors();
		return $modifyFactors->getChildrenOfIndexDescForProject($index_name, $children, $project_id);
// 		$children_array = explode(',',$children);
// 		if ($index_name == 'zb_ldnl'){
// 			//zb_ldnl 0,0,0,0,0
// 			$result = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Index.chs_name as chs_name',
// 					'AVG(IndexAns.score) as score',
// 					'Index.id as id'
// 			))
// 			->from('Examinee')
// 			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
// 			->join('Index', 'IndexAns.index_id = Index.id')
// 			->inwhere('Index.name', $children_array)
// 			->groupBy('Index.name')
// 			->orderBy('AVG(IndexAns.score) desc')
// 			->getQuery()
// 			->execute();
// 			return $result->toArray();
// 		}
// 		else if ($index_name == 'zb_gzzf'){
// 			//zb_gzzf 1,0,1,1,1,1,1
// 			//X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff
// 			$children_1_array = array('X4','chg','Y3','Q3','spmabc','aff');
// 			$result_1 = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Factor.chs_name as chs_name',
// 					'AVG(FactorAns.ans_score) as score',
// 					'Factor.id as id'
// 			))
// 			->from('Examinee')
// 			->join('FactorAns', 'FactorAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
// 			->join('Factor', 'FactorAns.factor_id = Factor.id')
// 			->inwhere('Factor.name', $children_1_array)
// 			->groupBy('Factor.name')
// 			->orderBy('AVG(FactorAns.ans_score) desc')
// 			->getQuery()
// 			->execute();
// 			$children_2_array = array('zb_rjgxtjsp');
// 			$result_2 = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Index.chs_name as chs_name',
// 					'AVG(IndexAns.score) as score',
// 					'Index.id as id'
// 			))
// 			->from('Examinee')
// 			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
// 			->join('Index', 'IndexAns.index_id = Index.id')
// 			->inwhere('Index.name',$children_2_array )
// 			->groupBy('Index.name')
// 			->orderBy('AVG(IndexAns.score) desc')
// 			->getQuery()
// 			->execute();
			
// 			$result = array_merge($result_1->toArray(), $result_2->toArray());
// 			$scores = array();
// 			foreach ($result as $record) {
// 				$scores[] = $record['score'];
// 			}
// 			array_multisort($scores, SORT_DESC, $result );
// 			return $result;
// 		}
// 		else {
// 			// 1,.,.,.,.,1
// 			$result = $this->modelsManager->createBuilder()
// 			->columns(array(
// 					'Factor.chs_name as chs_name',
// 					'AVG(FactorAns.ans_score) as score',
// 					'Factor.id as id'
					
// 			))
// 			->from('Examinee')
// 			->join('FactorAns', 'FactorAns.examinee_id = Examinee.id AND Examinee.type =0 AND Examinee.project_id = '.$project_id)
// 			->join('Factor', 'FactorAns.factor_id = Factor.id')
// 			->inwhere('Factor.name', $children_array)
// 			->groupBy('Factor.name')
// 			->orderBy('AVG(FactorAns.ans_score) desc')
// 			->getQuery()
// 			->execute();
// 			return $result->toArray();
		
// 		}
	}
	
	##通过因子找到项目中各层群人数的因子得分情况
	public function getFactorGrideByLevel($factor_chs_name = null, $factor_name = null, $level_examines,$project_id){
		#判断因子是index还是factor
		//按照中文名搜索
		if (empty($factor_chs_name)){
			$factor_info = Factor::findFirst(
					array("name = ?2", 'bind'=>array(2=>$factor_name))
			);
			$search = 'Factor.name = '."'$factor_name'";
		//按照英文名搜索
		}else{
			$factor_info = Factor::findFirst(
					array("chs_name = ?2", 'bind'=>array(2=>$factor_chs_name))
			);
			$search = 'Factor.chs_name = '."'$factor_chs_name'";
		}

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
				->join('Factor', 'FactorAns.factor_id = Factor.id AND '.$search )
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
		//按照中文名搜索
		if (empty($factor_chs_name)){
			$index_info = Index::findFirst(
			array(" name = ?2", 'bind'=>array( 2=>$factor_name))
		);
			$search = 'Index.name = '."'$factor_name'";
			//按照英文名搜索
		}else{
			$index_info = Index::findFirst(
			array("chs_name = ?2", 'bind'=>array( 2=>$factor_chs_name))
			);
			$search = 'Index.chs_name = '."'$factor_chs_name'";
		}
		
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
							->join('Index', 'IndexAns.index_id = Index.id AND '.$search )
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
		throw new Exception('no this factor exist!'.print_r($factor_name));
	}
	##通过因子来找评语(对应评语中的前三)
	
	###################################################################################
	#																				  #
	#从需求量表答案结合被试信息表判断综合数据报表的基础点							  #
	#   需求量表中第一个题（单选）													  #
	#												  								  #
	###################################################################################
	
	#获取各层级下的人员清单 --- key(level) => value(examinee_ids_array)
	#结合上边的查询各层因子，结合下边的n-1项查询， n项查询由n-1项查询统计得出，因此直接进行n-1
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
			->columns(array( 'Examinee.id as id, Examinee.name as name,Examinee.number as number' ))
			->from('Examinee')
			->where('Examinee.type =0 AND Examinee.project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
		//若参与测试的用户没有答需求量表，这在系统上是不完备的，需要对每一个用户的需求量表的解答结果进行统计
		$not_finished = array();
		foreach($examinee_ids as $svalue){
			$option = $this->modelsManager->createBuilder()
			->columns(array( 'InqueryAns.option as option' ))
			->from('InqueryAns')
			->where('InqueryAns.examinee_id = '. $svalue['id'].' AND InqueryAns.project_id = '.$project_id)
			->getQuery()
			->execute()
			->toArray();
			if(empty($option)){
				$not_finished[] = $svalue['number'].'-'.$svalue['name'];
				continue;
			}
			$level = ord(substr($option[0]['option'], 0 ,1)) -ord('a') ;
			$level_examines[$level][] = $svalue['id'];			
		}
		//edit brucew 2015-12-22
		if(empty($not_finished)){
			return array_combine($level_array,$level_examines);
		}else{
			throw new Exception('以下用户未参与需求量表答题：【'.count($not_finished).'人】<br />'.implode('<br />', $not_finished));
		}
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

	#需求量表的n+n-1同时分析 遍历BaeLevel返回的结果集中的所有各层人员的各项题目的各项选项的统计结果
	public function getInqueryAnsComDetail($project_id){
		$level_examines = $this->getBaseLevels($project_id);
		$level_count = count($level_examines);
		$inquery_questions = $this->getInqueryDetail($project_id);
		foreach($inquery_questions as &$inquery_question_value ){
			$inquery_question_value['value'] = array();
			$quetion_option_count = count($inquery_question_value['options']);
			for($i = 0; $i < $quetion_option_count ;$i ++ ){
				$tmp = array();
				for($j = 0; $j < $level_count; $j++ ){
					$tmp[] = 0;
				}
				$inquery_question_value['value'][] = $tmp;
			}
		}
		//storage array ok 
		//遍历全体人员的inqueryAns并写入到storage array
		$level = 0;  //首选项标识符
		foreach($level_examines as $examinees_array ){
			//获取各层下的人员
			foreach($examinees_array as $examinee_id_in_level ){
				//通过id去查询个人的inqueryAns
				$option_array = $this->modelsManager->createBuilder()
				->columns(array( 'InqueryAns.option as option' ))
				->from('InqueryAns')
				->where('InqueryAns.project_id = '.$project_id .' AND InqueryAns.examinee_id = '.$examinee_id_in_level )
				->getQuery()
				->execute()
				->toArray();
				//获取到个人的inqueryAns str
				$option_str = $option_array[0]['option'];
				$individual_ans_array = explode('|', $option_str);
				$individual_ans_count = count($individual_ans_array);
				for($number = 0; $number <$individual_ans_count ; $number++ ){
					//每一道题先判定题号对应的需求量量内容is_radio
					if ($inquery_questions[$number]['is_radio'] == 1 ){
						$ans_level = ord($individual_ans_array[$number]) - ord('a');
						$inquery_questions[$number]['value'][$ans_level][$level]++;
					}else{
						//is_radio == 0 
						$ans_value_array = str_split($individual_ans_array[$number]);
						foreach($ans_value_array as $ans_value) {
							$ans_level = ord($ans_value)-ord('a');
							$inquery_questions[$number]['value'][$ans_level][$level]++;
						}
						
					}
				}
			}
			$level ++;
		}
		return $inquery_questions;
	}

	#全体人员需求量表的结果逐个分析----------丢弃（有上方法替代与完善）
	public function getInqueryAnsDetail($project_id){
		$inquery_questions = $this->getInqueryDetail($project_id);
		foreach($inquery_questions as &$value ){
			$value['value'] = array();
			$count = count($value['options']);
			for($i = 0; $i < $count ;$i ++ ){
				$value['value'][] = 0;
			}
		}
		$option_array = $this->modelsManager->createBuilder()
		->columns(array( 'InqueryAns.option as option' ))
		->from('InqueryAns')
		->where('InqueryAns.project_id = '.$project_id)
		->getQuery()
		->execute()
		->toArray();
		foreach( $option_array as $svalue ){
			$option_value_array = explode('|', $svalue['option']);
			$question_count = count($option_value_array);
			for($i = 0; $i <$question_count; $i ++ ){
				if ($inquery_questions[$i]['is_radio'] == 1){
				    $level = ord($option_value_array[$i])-ord('a');
					$inquery_questions[$i]['value'][$level]++;
				}else{//is_radio == 0
					$ans_array = str_split($option_value_array[$i]);
					foreach($ans_array as $lsvalue){
						$level = ord($option_value_array[$i])-ord('a');
						$inquery_questions[$i]['value'][$level]++;
					}
				}
			}
		}
		return $inquery_questions;
		
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