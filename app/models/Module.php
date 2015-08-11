<?php


class Module extends \Phalcon\Mvc\Model 
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
    public $belong_module;

    /**
     * @var string
     *
     */
    public $chs_name;

    public function initialize()
    {
        $this->hasMany("id", "Index", "module_id");
    }
}
