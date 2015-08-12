<?php


class QuestionAns extends \Phalcon\Mvc\Model 
{

    /**
     * @var string
     *
     */
    public $option;

    /**
     * @var string
     *
     */
    public $score;

    /**
     * @var string
     *
     */
    public $question_number_list;


    /**
     * @var integer
     *
     */
    public $paper_id;

    /**
     * @var integer
     *
     */
    public $examinee_id;


    /**
     * 根据paper_id和用户id的集合来查找所有符合条件的答案
     */
    public function getQuestionAns($paper_id, $examinee_ids)
    {
        $anss = QuestionAns::find(array(
            'paper_id = :paper_id: AND examinee_id IN ({examinees:array})',
            'bind' => array('paper_id' => $paper_id, 'examinees' => $examinee_ids)
        ));
        return $anss;
    }
}
