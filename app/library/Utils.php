<?php
/**
* 小工具类, 全部静态方法
* @method 浏览器低版本检测方法
*/
class Utils
{
	/**
	 * 客户端浏览器检测
	 */
	public static function getBrowserDetail($request){
		$headers = $request->getHeaders();
		return self::getBrowser($headers['User-Agent']);
	}
	/**
	 * 获取浏览器类型与版本
	 */
	public static function getBrowser($agent) {
		if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
		{
			if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs)){
				if( $regs[1] < 10 ) {
					return false;
				}else{
					return true;
				}
			}else{
				return true;
			}
		}
		else if(strpos($agent,'Firefox')!==false){
// 			if (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs)) {
// 				return $regs[1];
// 			}else{
// 				return true;
// 			}
			return true;
		}
		else if(strpos($agent,'Chrome')!==false) {
// 			if (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs)) {
// 				return $regs[1];
// 			}else{
// 				return 1;
// 			}
			return true;
		}
		else if(strpos($agent,'Opera')!==false) {
// 			if (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs)){
// 				return $regs[1];
// 			}else{
// 				return 1;
// 			}
			return true;
		}
		else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false){
// 			if(preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs)){
// 				return $regs[1];
// 			}else{
// 				return 1;
// 			}
			return true;
		}
		else
			return true;
	}
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