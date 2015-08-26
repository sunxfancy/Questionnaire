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

	public function initialize(){
		$this->belongsTo('paper_id', 'Paper', 'id');
		$this->belongsTo('examinee_id', 'Examinee' , 'id');
	}
	
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
    /**
     * @usage 根据examinee_id 选择出该被试的相关试卷的答案
     * @notice 一个人最多有6条记录
     * @param int $examinee_id
     * @throws Exception
     * @return array
     */
    public static function getListByExamineeId($examinee_id){
    	if (DBHandle::dataFormatCheck($examinee_id)!=2){
    		throw new Exception('input type is not available');
    	}
    	return  self::find(
        	array(
    		"examinee_id = :examinee_id:",
        	'bind' => array( 'examinee_id' => intval($examinee_id))
    	)
    	);
    }

}
