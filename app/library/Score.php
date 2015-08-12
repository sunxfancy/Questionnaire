<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 11:08:59
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-12 11:08:20
 */

/**
* 
*/
class Score
{
	
	public function __construct()
	{
	}

	public function Calculate($project_id)
	{
		$papers = array('16pf','epps');

	}


	/**
	 * 计算因子得分
	 * @factor 要计算的因子对象
	 * @examinees 被试人员的对象列表
	 */
	function calFactor($factor, $examinees)
	{
		
	}

	// 传入一个answer对象数组, 计算所有人的得分
	function calAns($answers, $examinees)
	{
		
	}

	/**
	 * @brief 查询一个对象,若不存在则新建
	 * @return 所查找的对象
	 */
	function findFirstAndNew($classname, $array)
	{
		$obj = $classname::findFirst($array);
		if ($obj == false) {
			$obj = new $classname();
		}
		return $obj;
	}

}