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
    public $chs_name;

    /**
     * @var string
     *
     */
    public $ans_do;

    /**
     * @var string
     *
     */
    public $action;


    public function initialize()
    {
        $this->belongsTo('module_id', 'Module', 'id');
        $this->hasManyToMany(
            "id", "Firel", "index_id", 
            "factor_id", "Factor", "id"
        );
        $this->hasMany("id", "IndexAns", "index_id");
        $this->hasMany("id", "Index", "father_index");
    }

}
