<?php


class Index extends \Phalcon\Mvc\Model 
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
     * @var integer
     *
     */
    public $father_index;

    /**
     * @var integer
     *
     */
    public $module_id;

    public function initialize()
    {
        $this->belongsTo('index_id', 'Index', 'id');
        $this->belongsTo('paper_id', 'Paper', 'id');
        $this->hasManyToMany(
            "id", "Fqrel", "factor_id", 
            "question_id", "Question", "id"
        );
        $this->hasMany("id", "FactorAns", "factor_id");
    }

}
