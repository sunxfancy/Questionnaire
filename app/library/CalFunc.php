<?php
/**
 * @Author: sxf
 * @Date:   2015-08-12 15:08:17
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-12 15:44:00
 */

/**
* 
*/
class CalFunc
{
	public static $func_reg = array('sum', 'avg');

	public static function sum($array)
	{
		$sum = 0;
		foreach ($array as $value) {
			$sum += $value;
		}
		return $sum;
	}

	public static function avg($array)
	{
		$sum = 0; $size = 0;
		foreach ($array as $value) {
			$sum += $value; $size++;
		}
		return $sum / $size;
	}

	public static function xavg($array, $q)
	{
		$sum = 0; $size = 0;
		foreach ($array as $key => $value) {
			$sum += ($value * $q[$key]);
			$size += $q[$key];
		}
		return $sum / $size;
	}
}