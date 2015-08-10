<?php
/**
 * @Author: sxf
 * @Date:   2015-08-07 14:33:55
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-07 15:14:03
 */

/**
* 
*/
class InterviewerController extends Base
{
	
	public function indexAction()
    {
        $this->view->setTemplateAfter('base2');
        $this->leftRender('人 员 面 询');
    }

    public function pointAction()
    {
    	$this->view->setTemplateAfter('base2');
        $this->leftRender('人 才 测 评 系 统');
    }

}