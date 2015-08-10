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

    public function initialize()
    {
        $this->hasMany("id", "Index", "module_id");
    }
}
