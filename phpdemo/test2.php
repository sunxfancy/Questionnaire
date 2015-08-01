<?php
/**
 * @Author: sxf
 * @Date:   2015-07-29 23:00:36
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-07-29 23:36:16
 */

	function run() {
		$ans = 10;
		eval ('$ans = $ans/2;');
		return $ans;
	}

	echo run() ."\n";

	function a($b, $c)
	{
		echo $b ."\n";
		echo $c ."\n";
	}

	call_user_func_array('a', array("111", "222")); 