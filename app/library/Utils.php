<?php
/**
 * @Author: sxf
 * @Date:   2015-08-13 10:42:05
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-13 10:46:11
 */

/**
* 小工具类, 全部静态方法
*/
class Utils
{
	/**
	 * 对模型数组求id列表, 可以选第二参数为模型的字段名
	 */
	public static function getIds($models, $name = 'id')
	{
		$id_array = array();
		foreach ($models as $model) {
			$id_array[]  = $model->$name;
		}
		return $id_array;
	}

	/**
	 * 查询一个对象,若不存在则新建
	 * @return 所查找的对象
	 */
	public static function findFirstAndNew($classname, $array)
	{
		$obj = $classname::findFirst($array);
		if ($obj == false) {
			$obj = new $classname();
		}
		return $obj;
	}

	/**
	 * 加载一个json文件，可选参数是否转换为数组
	 */ 
	public static function loadJson($filename, $toarray = true)
	{
		$json_string = file_get_contents($filename);
		$json_string = preg_replace('/[\r\n\t]/', '', $json_string);
		$json = json_decode($json_string, $toarray);
		if ($json == null) {
			echo json_last_error_msg();
			throw new Exception(json_last_error_msg());
		} 
		return $json;
	}
}