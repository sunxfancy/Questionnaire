<?php

class ReportComment extends \Phalcon\Mvc\Model 
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
    public $advantage;

    /**
     * @var text
     * 
     */
    public $disadvantage;
}