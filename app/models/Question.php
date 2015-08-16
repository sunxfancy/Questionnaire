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

    public static function findByPapernameAndNums($paper_name, $numbers)
    {
        $paper_id = Paper::findId($paper_name);
        $qlist = Question::find(array(
            'paper_id = :pid: AND number IN ({numbers:array})',
            'bind' => array('pid' => $paper_id, 'numbers' => array_values($numbers))
        ));
        if (count($qlist) == 0) throw new Exception("Can not find any questions.");
        return $qlist;
    }
}
