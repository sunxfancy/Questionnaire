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

    /**
     * @var integer
     *
     */
    public $last_examinee_id;

    /**
     * @var integer
     *
     */
    public $state;



    public function initialize()
    {
        $this->belongsTo('manager_id', 'Manager', 'id');
    }
}
