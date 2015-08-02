<?php


class QuestionAns extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var integer
     *
     */
    public $option;

    /**
     * @var integer
     *
     */
    public $score;

    /**
     * @var integer
     *
     */
    public $question_id;

    /**
     * @var integer
     *
     */
    public $examinee_id;


}
