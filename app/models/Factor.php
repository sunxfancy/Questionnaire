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
    public $paper_id;

    /**
     * @var string
     *
     */
    public $children;

    /**
     * @var string
     *
     */
    public $children_type;

    /**
     * @var string
     *
     */
    public $action;

    /**
     * @var string
     *
     */
    public $ans_do;

    /**
     * @var string
     *
     */
    public $chabiao;

    /**
     * @var string
     *
     */
    public $chs_name;


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

    private $paper_name = null;
    public function getPaperName()
    {
        if ($this->paper_name == null) {
            $paper = $this->getPaper();
            $this->paper_name = $paper->name;
        }
        return $this->paper_name;
    }
    
    
    
}
