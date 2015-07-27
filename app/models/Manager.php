<?php
/* 
* @Author: sxf
* @Date:   2014-10-11 20:30:24
* @Last Modified by:   sxf
* @Last Modified time: 2014-11-05 23:57:25
*/

class Manager extends \Phalcon\Mvc\Model 
{


	public static function checkLogin($username,$password)
	{
		$manager = Manager::findFirst(array(
		    "username = :str:",
		    "bind" => array("str" => $username)
		));
		if (!$manager) {
			return -1;
		}
		if (hash('sha256',$password) == $manager->password) {
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

	public function signup($username,$password,$phone,$email,$realname,$ID_number)
	{
		// todo：添加验证器
		$this->username = $username;
		$this->password = hash('sha256',$password);
		$this->phone    = $phone;
		$this->email    = $email;
		$this->name     = $realname;
		$this->id_num   = $ID_number;
		$this->auth     = 1; // 1为学校，2为领导们，3为管理员
		if ($this->save()) 
			return true;
		else
			return false;
	}
}
