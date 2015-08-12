<?php


class Question extends \Phalcon\Mvc\Model 
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
    public $topic;

    /**
     * @var string
     *
     */
    public $options;

    /**
     * @var string
     *
     */
    public $grade;

    /**
     * @var integer
     *
     */
    public $number;

    /**
     * @var integer
     *
     */
    public $paper_id;


    public function initialize()
    {
        $this->hasMany("id", "QuestionAns", "question_id");
        $this->hasManyToMany(
            "id", "Fqrel", "question_id", 
            "factor_id", "Factor", "id"
        );
    }
}
