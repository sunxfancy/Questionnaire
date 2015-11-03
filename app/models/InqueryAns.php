<?php


class InqueryAns extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $project_id;

    /**
     * @var integer
     *
     */
    public $examinee_id;

    /**
     * @var string
     *
     */
    public $option;
    
    public function initialize(){
    	$this->belongsTo('exmainee_id', 'Examinee', 'id');
    	$this->belongsTo('project_id', 'Project', 'id');
    }


}
