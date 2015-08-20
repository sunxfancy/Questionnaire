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
    	$this->belongsTo('paper_id', 'Paper', 'id');
        $this->hasManyToMany(
            "id", "Fqrel", "question_id", 
            "factor_id", "Factor", "id"
        );
    }
    /**
     * 根据Paper_id 获取相应试卷的具体题目情况
     * 返回值 [phalcon_mvc_model_object_array] 返回数组的项可能为空,需判断处理
     * @param $paper_id;
     */
    public static function getQuestionsByPaperId($paper_id){
    	$data_type = DBHandle::dataFormatCheck($paper_id);
    	if ($data_type != 2 ){
    		throw new Exception("input type is not available");
    	}
    	$question_object_array = self::find(
		array(
    		"paper_id = :paper_id:",
			'bind' => array( 'paper_id' => $paper_id)
    	)
    	);
    	return $question_object_array;
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
