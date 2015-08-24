<?php

class ProjectDetail extends \Phalcon\Mvc\Model {
	
	public $project_id;
	
	public $module_names;
	
	public $index_names;
	
	public $factor_names;
	
	public $exam_json;
	
	public function initialize(){
		$this->belongsTo('project_id', 'Project','id');
	}
}