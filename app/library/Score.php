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
	
	/**
	 * 解析题号(|)字符串与选项(|)字符串，return array(题号=>选项)
	 * 题号 数值型
	 * 选项 字符型
	 */
	public static function strDivideToArray($str1, $str2){
		$str1_array = explode('|', $str1);
		$str2_array = explode('|', $str2);
		if( count($str1_array) != count($str2_array)){
			throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (count)");
		}else {
			$count = count($str1_array);
			if(is_numeric($str1_array[0])){
			   for($i = 0; $i <$count; $i++ ){
			   		if(is_numeric($str1_array[$i]) && preg_match ("/^[A-Z]$/", $str2_array[$i])){
			   			#ok
			   		}else{
			   			throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
			   		}
			   }
			   $rtn = self::arrayMergeKeyToValue($str1_array, $str2_array);
			   return $rtn;
					
			}else if (preg_match ("/^[A-Z]$/", $str1_array[0]) ){
				for($i = 0; $i <$count; $i++ ){
					if(is_numeric($str2_array[$i]) && preg_match ("/^[A-Z]$/", $str1_array[$i])){
						#ok
					}else{
						throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
					}
				}
				$rtn = self::arrayMergeKeyToValue($str2_array, $str1_array);
				return $rtn;
			}else {
				throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
			}
		}
	}
	/**
	 * 两个数组合并
	 * @param unknown $str1_array
	 * @param unknown $str2_array
	 * @return multitype:multitype:unknown
	 */
	public static function arrayMergeKeyToValue($str1_array, $str2_array){
		$array_count = count($str1_array);
		$array_return = array();
		for($i = 0; $i < $array_count; $i++ ){
			$array_set = array();
			$array_set['number'] = $str1_array[$i];
			$array_set['option'] = $str2_array[$i];
			$array_return[] = $array_set;
			$array_set = null;
		}
		return $array_return;
	}
	/**
	 * 比较一个一位数组是否在一个二维数组中 use for SPM
	 * parents   
	 * 
	 */
	public static function multidimensinal_search($parents, $needle) {
		foreach ( $parents as $key => $value ){
			$flag = 1;
			foreach( $needle as $skey => $svalue ){
				if($value[$skey] != $svalue){
					if($flag == 1) {
						break;
					}else{
						return false;
					}
				}else{
					if($flag == 1){
						$flag = 2;
					}else{
						return true;
					}
				}
			}
		}
	}
	/**
	 * 在二维数组中按照第二层的键值来查找对应的数组项后返回 use for 16PF
	 */
	public static function findInTwodemensianalArray($parents, $key, $value){
		foreach ($parents as  $skey => $svalue ){
			if ( $svalue[$key] == $value ){
				return $svalue;
			}
		}
	}
}