<?php
	/**
	 * @usage 用于缓存全局的查询数据表信息
	 * @author Wangyaohui
	 * @Date 2015-8-26
	 */
class MemoryCache {
	
	/**
	 * @method $rt->module_names, $rt->index_names, $rt->factor_names, $rt->exam_json;
	 * @usage 用于缓存通过project_id获取到的ProjectDetail表中的数据
	 * @return \Phalcon\Mvc\Model\Resultset\Simple
	 * @param int $project_id
	 */
	public static function getProjectDetail($project_id) {
		return ProjectDetail::findFirst(
			  array (
			  		"project_id = :project_id:",
			  		'bind' => array ('project_id' => $project_id),
			  		'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
			  		'cache' => array ('key' => 'project_detail_id_'.$project_id)
		)
		);
	}
	/**
	 * @method $rt->id, $rt->description;
	 * @param string $paper_name
	 */
	public static function getPaperDetail($paper_name){
		return Paper::findFirst(
			  	array(
					"name = :name:",
			  		'bind' => array('name'=>$paper_name),
			  		'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
			  		'cache' => array ('key' => 'paper_detail_name_'.$paper_name)
		)
		);
	}
	
	/**
	 * @method $rt->id $rt->name $rt->children
	 * @usage 缓存根据因子名称查取到的因子详细记录
	 * @param string $factor_name
	 */
	public static function getFactorDetail($factor_name){
		return Factor::findFirst(
			 array(
			"name = :factor_name:",
			'bind'=>array('factor_name'=>$factor_name),
			'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
			'cache' => array ('key' => 'factor_detail_name_'.$factor_name)
		) 	
		);
	}
	
	/**
	 * @method $rt->id $rt->children $rt->name $rt->action
	 * @param unknown $index_name
	 */
	public static function getIndexDetail($index_name){
		return Index::findFirst(
			array(
			"name = :index_name:",
			'bind' => array( 'index_name' => $index_name),
			'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
			'cache' => array ('key' => 'index_detail_name_'.$index_name)
		)
		);
	}
	/**
	 * @method foreach $rt['id'] $rt['options']
	 * @param unknown $project_id
	 */
	public static function getInqueryQuestion($project_id){
		return InqueryQuestion::find(
			array(
				"project_id = :project_id:",
				'bind' => array('project_id'=>$project_id),
				'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
				'cache' => array ('key' => 'inquery_question_by_project_id_'.$project_id)
		)
		);
	}
	
	
	/**
	 * 将question表逐条缓存
	 * @param int $qustion_number
	 * @param int $paper_id
	 */
	public static function getQuestionDetail($qustion_number, $paper_id){
		return Question::findFirst(
			array(
			"paper_id = :paper_id: AND number=:question_number:",
			'bind' => array('paper_id'=>$paper_id, 'question_number'=>$qustion_number),
			'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
			'cache' => array ('key' => 'question_number_'.$qustion_number.'_paper_id_'.$paper_id)
		)
		);
	}
	
	
	
}
