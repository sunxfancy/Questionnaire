<?php

class FourIndexsComment extends \Phalcon\Mvc\Model 
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
    public $comment;
}