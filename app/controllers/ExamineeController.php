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
        $this->view->setTemplateAfter('base2');
    }

	public function indexAction()
	{
		$this->leftRender("kasldf");
	}

    public function addAction()
    {
    }
}