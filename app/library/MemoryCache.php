<?php
	/**
	 * @usage 用于缓存全局的查询数据表信息
	 * @author Wangyaohui
	 * @Date 2015-8-26
	 */
class MemoryCache {
	
	public static function checkConnect(){
		$test = @memcache_connect('127.0.0.1',11211);
		if( $test===false ){
  			throw new Exception('memcached is _probably_ not running');
		}
	}
	/**
	 * @type: 多次更改
	 * @method $rt->module_names, $rt->index_names, $rt->factor_names, $rt->exam_json; ok
	 * @usage 用于缓存通过project_id获取到的ProjectDetail表中的数据
	 * @return \Phalcon\Mvc\Model\Resultset\Simple
	 * @param int $project_id
	 */
	public static function getProjectDetail($project_id) {
		self::checkConnect();
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
	 * @type 不更改
	 * @method $rt->id, $rt->description;  ok
	 * @param string $paper_name
	 */
	public static function getPaperDetail($paper_name){
		self::checkConnect();
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
	 * @type 不更改
	 * @method $rt->id $rt->name $rt->children
	 * @usage 缓存根据因子名称查取到的因子详细记录
	 * @param string $factor_name
	 */
	public static function getFactorDetail($factor_name){
		self::checkConnect();
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
	 * @type 不更改
	 * @method $rt->id $rt->children $rt->name $rt->action
	 * @param unknown $index_name
	 */
	public static function getIndexDetail($index_name){
		self::checkConnect();
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
	 * @type 多次更改需判断
	 * @method foreach $rt['id'] $rt['options'] ok
	 * @param unknown $project_id
	 */
	public static function getInqueryQuestion($project_id){
		self::checkConnect();
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
	 * @type 不更改
	 * @param int $qustion_number
	 * @param int $paper_id
	 */
	public static function getQuestionDetail($qustion_number, $paper_id){
		self::checkConnect();
		return Question::findFirst(
			array(
			"paper_id = :paper_id: AND number=:question_number:",
			'bind' => array('paper_id'=>$paper_id, 'question_number'=>$qustion_number),
			'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
			'cache' => array ('key' => 'question_number_'.$qustion_number.'_paper_id_'.$paper_id)
		)
		);
	}
	
	/**
	 * 通过模块名称查询模块详情 $rt->children;
	 */
	public static function getModuleDetail($module_name){
		self::checkConnect();
		return Module::findFirst(
				array(
						"name = ?1",
						'bind' => array(1=>$module_name),
						'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
						'cache' => array ('key' =>'module_detail_name_'.$module_name)
				)
		);
	}
	
	
	
}
