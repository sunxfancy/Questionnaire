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
        $this->view->setTemplateAfter('base1');
    }

	public function indexAction()
	{
        //获取登录用户的信息
		$user = array('name'=>"username",'number'=>"us00001",'role'=>"被试人员");
        
        $this->view->setVar("user",$user);
        // Paper::findFirst();
        $paper = $this->modelsManager->executeQuery("select * from Paper");
        $this->view->setVar("paper",$paper);

	}

    public function addAction()
    {
        // $paper = new Paper("select * from paper"); 
        $sql = "select * from Paper";
        $paper = $this->modelsManager->executeQuery($sql);
        $this->view->setVar("paper",$paper);

    }
}