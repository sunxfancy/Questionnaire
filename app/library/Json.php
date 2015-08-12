<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 09:18:33
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-12 15:49:38
 */

/**
* Json同步类库
*/
class Json
{
	public function __construct($db) {
		$this->db = $db;
	}

	public function Load()
	{
		$work_names = array('module', 'index', 'factor');
		$this->db->begin();
		try {
			foreach ($work_names as $work_name) {
				$filename = __DIR__ . "/../../app/config/$work_name.json";
				$json = $this->loadJson($filename);
				$this->updateSQL($json, $work_name);
			}
		} catch (Exception $ex) {
			echo $ex->getMessage() ."\n";
			$this->db->rollback();
		}
		$this->db->commit();
	}

	// 加载一个json文件，可选传入是否转换为数组
	private function loadJson($filename, $toarray = true)
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

	// 更新数据库
	function updateSQL($json_array, $class_name)
	{
		foreach ($json_array as $key => $value) {
			$obj = $this->getObj($key, ucfirst($class_name));
			$this->jsonToObject($obj, $class_name, $key, $value);
			if (!$obj->save())
				foreach ($obj->getMessages() as $msg) {
					print_r($obj);
					echo $msg."\n";
					throw new Exception($msg);
				}
		}
	}

	function getObj($name, $classname)
	{
		$obj = $classname::findFirst(array(
			'name = :name:',
			'bind' => array('name' => $name)));
		if (!$obj) {
			$obj = new $classname();
		}
		return $obj;
	}

	function jsonToObject($obj, $class_name, $name, $array)
	{
		$obj->name = $name;
		foreach ($array as $key => $value) {
			if ($key == 'question' || $key == 'factor' || $key == 'index') {
				$obj->children = $value;
				$b = $key == $class_name ? 0 : 1;
				$obj->children_type = $this->makeArray($value, $b);
			}
			$default_array = array(
				'action','ans','children','belong_module','chs_name');
			if (in_array($key, $default_array)) {
				$obj->$key = $value;
			}
		}
	}

	// 根据array字段，生成新的children_type
	function makeArray($array, $data)
	{
		$children_len = count(explode(',',$array));
		$children_type = array();
		array_pad($children_type, $children_len, $data);
		return implode(',', $children_type);
	}
}