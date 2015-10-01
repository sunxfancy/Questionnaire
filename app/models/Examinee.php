<?php


class Examinee extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var int
     *
     */
    public $number;

    /**
     * @var string
     *
     */
    public $password;

    /**
     * @var string
     *
     */
    public $name;

    /**
     * @var string
     *
     */
    public $other;

    /**
     * @var integer
     *
     */
    public $sex;

    /**
     * @var string
     *
     */
    public $native;

    /**
     * @var string
     *
     */
    public $education;

    /**
     * @var string
     *
     */
    public $politics;

    /**
     * @var string
     *
     */
    public $professional;

    /**
     * @var string
     *
     */
    public $degree;

    /**
     * @var string
     *
     */
    public $employer;

    /**
     * @var string
     *
     */
    public $unit;

    /**
     * @var string
     *
     */
    public $team;

    /**
     * @var string
     *
     */
    public $duty;

    /**
     * @var integer
     *
     */
    public $project_id;

    /**
     * @var string
     *
     */
    public $birthday;

    /**
     * @var string
     *
     */
    public $last_login;

    /**
     * @var integer
     *
     */
    public $is_exam_com;

    /**
     * @var integer
     *
     */
    public $state;

    /**
     * @var integer
     *
     */
    public $exam_time;
    /**
     * @var text
     */
	public $init_data;
	
	/**
	 * @var tinyint
	 */
	public $type;
	

    public function initialize()
    {
        $this->belongsTo('project_id', 'Project', 'id');
    }
    /**
     * 判断被试人员是否已经答完题
     * @param unknown $examinee_id
     * @throws Exception
     * @return boolean
     */
    public static function checkIsExamedByExamineeId($examinee_id){
    	$examinee_info = self::findFirst(
		array(
			"id = :examinee_id:",
			'bind' => array( 'examinee_id' => intval($examinee_id))
		)
    	);
    	if (isset($examinee_info->is_exam_com)){
    		if( intval($examinee_info->is_exam_com) == 1 ){
    			return true;
    		}else{
    			return false;
    		}	
    	}else{
    		throw new Exception('no this examinee_id!');
    	}
    }
    
    // 被试人员登陆验证
    public static function checkLogin($username,$password)
    {
        $examinee = Examinee::findFirst(array(
            "number = :str:",
            "bind" => array("str" => $username)
        ));
        if (!$examinee) {
            return -1;
        }
        if ($password == $examinee->password) {
            $examinee->last_login = date("Y-m-d H:i:s");
            $examinee->save();
            return $examinee;
        } else {
            return 0;
        }
    }

    public static function getAll($project_id) {
        $ans = self::find(array(
            'project_id = ?0',
            'bind' => array($project_id)));
        return $ans;
    }
}
