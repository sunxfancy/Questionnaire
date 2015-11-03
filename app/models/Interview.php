<?php
class Interview extends \Phalcon\Mvc\Model 
{
     /**
     * @var string
     *
     */
    public $comments_incomplete;

    /**
     * @var string
     *
     */
    public $advantage;

     /**
     * @var string
     *
     */
    public $disadvantage;

     /**
     * @var string
     *
     */
    public $remark;

    /**
     * @var integer
     *
     */
    public $manager_id;

    /**
     * @var integer
     *
     */
    public $examinee_id; 
}
