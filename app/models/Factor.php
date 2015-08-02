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
    public $module_id;

    /**
     * @var integer
     *
     */
    public $paper_id;


}
