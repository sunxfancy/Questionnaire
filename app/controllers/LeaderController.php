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
	public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 评 结 果');
    }

    public function detailAction(){}

    public function resultAction(){}

    public function infoAction($examinee_id){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('个人信息查看');
        $examinee = Examinee::findFirst($examinee_id);
        $this->view->setVar('name',$examinee->name);
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $this->view->setVar('sex',$sex);
        $this->view->setVar('education',$examinee->education);
        $this->view->setVar('degree',$examinee->degree);
        $this->view->setVar('birthday',$examinee->birthday);
        $this->view->setVar('native',$examinee->native);
        $this->view->setVar('politics',$examinee->politics);
        $this->view->setVar('professional',$examinee->professional);
        $this->view->setVar('employer',$examinee->employer);
        $this->view->setVar('unit',$examinee->unit);
        $this->view->setVar('duty',$examinee->duty);
        $this->view->setVar('team',$examinee->team);
        $this->view->setVar('other',$examinee->other);
    }

    public function getOtherAction($examinee_id){
        $examinee = Examinee::findFirst($examinee_id);
        $this->dataBack(array("other"=>$examinee->other));
    }

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

}