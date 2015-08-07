<?php
/**
 * @Author: sxf
 * @Date:   2015-08-07 19:21:18
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-07 22:29:36
 */

/**
* 
*/
class TestController extends Base
{
	
	public function indexAction()
	{
		$this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
		$factor_file = __DIR__ . "/../../app/config/factor.json";
		$index_file = __DIR__ . "/../../app/config/index.json";
		$json = $this->loadJson($filename);
		print_r($json);
	}


	public function loadJson($filename)
	{
		$json_string = file_get_contents($filename);
		$json_string = preg_replace('/[\r\n]/', '', $json_string);
		$json = json_decode($json_string);
		if ($json == null) {
			echo json_last_error_msg();
		} 
		return $json;
	}


}