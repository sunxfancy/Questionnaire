<?php


class Manager extends \Phalcon\Mvc\Model 
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
    public $username;

    /**
     * @var string
     *
     */
    public $password;

    /**
     * @var string
     *
     */
    public $role;

    /**
     * @var integer
     *
     */
    public $project_id;

    /**
     * @var string
     *
     */
    public $name;

    /**
     * @var string
     *
     */
    public $last_login;

	public function initialize(){
		$this->belongsTo('project_id', 'Project', 'id');
	}

    public static function checkLogin($username,$password)
    {
        $manager = Manager::findFirst(array(
            "username = :str:",
            "bind" => array("str" => $username)
        ));
        if (!$manager) {
            return -1;
        }
        if ($password == $manager->password) {
            $manager->last_login = date("Y-m-d H:i:s");
            $manager->save();
            return $manager;
        } else {
            return 0;
        }
    }

    public static function checkUsername($username)
    {
        $manager = Manager::findFirst(array(
            "username=:username:",
            "bind" => array("username" => $username)
        ));
        return $manager;
    }

}
