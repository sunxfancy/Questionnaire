<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:27:51
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-03 14:32:36
 */

/**
* 
*/
class ExamineeController extends Base
{
	public function initialize()
    {
        $this->view->setTemplateAfter('base3');
    }

	public function indexAction()
	{
		$this->response->redirect('/Examinee/inquery');
	}

	public function inqueryAction()
	{	
		$user_name='张晓强';
		$user_id='us001';

		$this->view->setVar('page_title','需求量表');
		$this->view->setVar('user_name',$user_name);
		$this->view->setVar('user_id',$user_id);
		$this->view->setVar('user_role','被试人员');
	}

	public function editinfoAction()
	{

	}

	public function doexamAction()
	{

	}
}