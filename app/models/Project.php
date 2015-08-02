<?php


class Project extends \Phalcon\Mvc\Model 
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
    public $begintime;

    /**
     * @var string
     *
     */
    public $endtime;

    /**
     * @var string
     *
     */
    public $name;

    /**
     * @var string
     *
     */
    public $description;

    /**
     * @var integer
     *
     */
    public $manager_id;


}
