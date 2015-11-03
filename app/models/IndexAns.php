<?php


class IndexAns extends \Phalcon\Mvc\Model 
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
    public $index_id;

    /**
     * @var integer
     *
     */
    public $examinee_id;

    public function initialize()
    {
        $this->belongsTo('index_id',  'Index','id');
        $this->belongsTo('examinee_id', 'Examinee', 'id');
    }
}
