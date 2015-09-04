<?php


class InqueryQuestion extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var string
     *
     */
    public $topic;

    /**
     * @var string
     *
     */
    public $options;

    /**
     * @var integer
     *
     */
    public $is_radio;
    /**
    *@var integer
    */
    public $project_id;
    
    public function initialize(){
    	
    	$this->belongsTo('project_id', 'Project', 'id');
    	
    }


}
