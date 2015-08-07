<?php
/**
 * @Author: sxf
 * @Date:   2015-08-07 14:32:50
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-07 15:04:11
 */

/**
* 
*/
class LeaderController extends Base
{
	public function indexAction()
    {
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 评 结 果');
    }

    public function detailAction()
    {
    	
    }

    public function resultAction()
    {
    	
    }

}