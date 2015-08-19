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

    public function pointAction($examinee_id)
    {
        $this->view->setVar('examinee_id',$examinee_id);
        $this->view->setTemplateAfter('base2');
        $this->leftRender('填写面巡意见');
    }


    public function interviewAction($examinee_id){
        $returnMessage = array();
        $manager = $this->session->get('Manager');
        $array = array(
            'advantage' => $this->request->getPost('advantage'),
            'disadvantage' => $this->request->getPost('disadvantage'),
            'remark' => $this->request->getPost('remark'),
            'manager_id' => $manager->id,
            'examinee_id' => $examinee_id
        );
        if(Interview::commentSave($array) === true){
            $returnMessage['status'] = "success";
        }else{
            $returnMessage['status'] = "failed";
        }
        $returnMessage = json_encode($returnMessage);
        echo $returnMessage;
    }

}