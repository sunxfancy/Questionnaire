<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 09:11:41
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-15 10:21:11
 */

	
/**
* 
*/
class Test2Controller extends Base
{

	public function indexAction()
	{
		$this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
		$json = new Json($this->db);
		$json->Load();
	}

	public function makeresAction($project_id)
	{
		$this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
		try {
			$res = new SearchSource($project_id);
			print_r($res->getQuestionsMartix());
		} catch (Exception $e) {
			echo $e;
		}
	}

}