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
	#获取职业素质相关数据
	public function getComprehensiveData($project_id){
		$this->project_check($project_id);
		$project_detail = MemoryCache::getProjectDetail($project_id);
		if(empty($project_detail) || empty($project_detail->module_names)){
			throw new Exception('项目配置信息有误');
		}
		$exist_module_array = explode(',',$project_detail->module_names);
		print_r($exist_module_array);
		exit();
		$module_array = array("心理健康"=>'mk_xljk',"素质结构"=>'mk_szjg',"智体结构"=>'mk_ztjg',"能力结构"=>'mk_nljg');
		$module_array_score = array();
		foreach($module_array as $key => $value){
			echo $value;
			echo '<pre>';
			print_r($exist_module_array);
			echo '</pre>';
			if (!in_array($value, $exist_module_array)){
				continue;
			}
			echo 'hrere';
			$module_record = MemoryCache::getModuleDetail($value);
			$children = $module_record->children;
			$children_array = explode(',', $children);
			//获取某项模块下所有指标的平均分
			$result_1 = $this->modelsManager->createBuilder()
			->columns(array(
					'AVG(IndexAns.score) as score',
			))
			->from('Examinee')
			->join('IndexAns', 'IndexAns.examinee_id = Examinee.id AND Examinee.type = 0 AND Examinee.project_id = '.$project_id)
			->join('Index', 'Index.id = IndexAns.index_id')
			->inwhere('Index.name', $children_array)
			->getQuery()
			->execute();
			echo 'iii';
			print_r($result_1->toArray());
		}
			
	}
	
}