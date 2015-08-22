<?php


class FactorAns extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $score;

    /**
     * @var integer
     *
     */
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

    /**
     * @var integer
     *
     */
    public $ans_score;

    public function initialize(){
        $this->belongsTo('factor_id','Factor','id');
    }
}
