<?php


class Examinee extends \Phalcon\Mvc\Model 
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


    public function initialize()
    {
        $this->belongsTo('project_id', 'Project', 'id');
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
}
