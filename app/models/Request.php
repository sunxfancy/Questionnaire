<?php
/* 
* @Author: sxf
* @Date:   2014-10-14 19:19:02
* @Last Modified by:   sxf
* @Last Modified time: 2014-10-30 10:49:30
*/
class Request extends \Phalcon\Mvc\Model 
{
	public function initialize()
	{
	    $this->belongsTo("manager_id", "Manager", "id");
	    date_default_timezone_set("PRC");
	}

	public static function post($name,$district,$manager_id)
	{
			$request = new Request();
			$request->name       = $name;
			$request->district   = $district;
			$request->manager_id = $manager_id;
			$request->statue     = 2;
			$request->time = date('Y-m-d H:i:s');
			return $request;	
	}


}
