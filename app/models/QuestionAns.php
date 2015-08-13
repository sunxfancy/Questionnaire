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
     * 两个参数可以是单独的id,也可以是数组集合
     */
    public static function getAns($paper_id, $examinee_id)
    {
        $cond = '';
        if (is_array($paper_id))
             $cond .= 'paper_id IN ({paper_id:array})';
        else $cond .= 'paper_id = :paper_id:';

        $cond .= ' AND ';
        if (is_array($examinee_id)) 
             $cond .= 'examinee_id IN ({examinee_id:array})';
        else $cond .= 'examinee_id = :examinee_id:';

        $anss = QuestionAns::find(array( $cond,
            'bind' => array('paper_id' => $paper_id, 'examinee_id' => $examinee_id)
        ));
        return $anss;
    }

}
