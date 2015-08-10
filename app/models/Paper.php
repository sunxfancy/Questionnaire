<?php


class Paper extends \Phalcon\Mvc\Model 
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
    public $description;

    /**
     * @var string
     *
     */
    public $name;

    public function initialize()
    {
        $this->hasMany("id", "Factor", "paper_id");
    }
}
