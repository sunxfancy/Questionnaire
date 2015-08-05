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
        
	}

    public function loginAction()
    {
        $username = $this->request->getPost("username", "string");
        $password = $this->request->getPost("password", "string");
        $examinee = Examinee::checkLogin($username, $password);

        if ($examinee === 0) {
            $this->dataReturn(array('error' => '密码不正确'));
            return;
        }
        if ($examinee === -1) {
            $this->dataReturn(array('error' => '用户不存在'));
            return;
        }
        if ($examinee)
        {
            $this->session->set('Examinee', $examinee);
            $this->dataReturn(array('url' =>'/examinee/inquery'));
            return;
        }
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

    public function addAction()
    {
        // $paper = new Paper("select * from paper"); 
        $sql = "select * from Paper";
        $paper = $this->modelsManager->executeQuery($sql);
        $this->view->setVar("paper",$paper);

    }

    public function dataReturn($ans)
    {
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

}