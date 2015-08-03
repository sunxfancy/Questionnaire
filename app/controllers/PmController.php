<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:18:46
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-03 10:09:41
 */

/**
* 
*/
class PmController extends Base
{
    public function initialize()
    {
          $this->view->setTemplateAfter('base2');
    }

    public function indexAction()
    {
        /****************这一段可以抽象成一个通用的方法**********************/
        $manager=$this->session->get('Manager');
        $this->view->setVar('page_title','北京政法系统人才测评项目管理平台');
        $this->view->setVar('user_name',$manager->name);
        $this->view->setVar('user_id',$manager->username);
        $this->view->setVar('user_role',"项目经理");
        /*******************************************************************/
    }

	public function detailAction()
	{
		
	}

	public function examineeAction()
	{
		# code...
	}

	public function interviewerAction()
	{
		# code...
	}

	public function leaderAction()
	{
		# code...
	}

	public function resultAction()
	{
		# code...
	}
}