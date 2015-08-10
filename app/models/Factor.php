<?php


class Factor extends \Phalcon\Mvc\Model 
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
    public $name;

    /**
     * @var string
     *
     */
    public $factor;

    /**
     * @var integer
     *
     */
    public $father_factor;

    /**
     * @var integer
     *
     */
    public $index_id;

    /**
     * @var integer
     *
     */
    public $paper_id;


    public function initialize()
    {
        $this->belongsTo('paper_id', 'Paper', 'id');
        $this->hasManyToMany(
            "id", "Fqrel", "factor_id", 
            "question_id", "Question", "id"
        );
        $this->hasManyToMany(
            "id", "Firel", "factor_id", 
            "index_id", "Index", "id"
        );
        $this->hasMany("id", "FactorAns", "factor_id");
        $this->hasMany("id", "Index", "father_factor");
    }

}
