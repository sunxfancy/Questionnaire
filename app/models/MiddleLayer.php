<?php

class MiddleLayer extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *primary key
     */
    public $id;

    /**
     * @var text
     *
     */
    public $name;

    /**
     * @var text
     * 
     */
    public $father;

    /**
     * @var text
     * 
     */
    public $children;
}