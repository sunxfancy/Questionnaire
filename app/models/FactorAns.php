<?php

class FactorAns extends \Phalcon\Mvc\Model 
{
    public $score;
    public $std_score;
    /**
     * @var integer
     *
     */
    public $examinee_id;

    /**
     * @var integer
     *
     */
    public $factor_id;

    public $ans_score;
    
    public function initialize(){
    	$this->belongsTo('factor_id','Factor','id');
    	$this->belongsTo('examinee_id', 'Examinee','id');
    }
}
