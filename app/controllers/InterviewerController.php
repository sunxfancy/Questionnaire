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
        $manager = $this->session->get('Manager');
        $this->view->setVar('manager_id',$manager->id);
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
    
    public function divideAction($manager_id)
    {
    	$json = $this->request->getPost('divide_examinee');
    	$returnMessage = array(
    			'status' => 'success'
    	);
    	$save_arr = explode('~', $json);
    	$min = $save_arr[0];
    	$max = $save_arr[1];
    	for ($i = $min; $i <= $max; $i++) {
    		//            $array = array(
    		//                'manager_id' => $manager_id,
    		//                'examinee_id' => $i
    		//            );
    		$res = Examinee::findFirst(array(
    				"number=:number:",
    				"bind" => array(
    						"number" => $i
    				)
    		));
    		if($res){
                $examinee_id = $res->id;
            $condition = "manager_id = :manager_id: AND examinee_id = :examinee_id:";
            /*
             * 判断interview表中是否存在记录
            * 若存在，则无需更新
            * 若不存在，则将数据插入到interview表中
            */
            $interview = Interview::findFirst(array(
                    $condition,
                    'bind' => array(
                            'manager_id' => $manager_id,
                            'examinee_id' => $examinee_id,

                    )
            ));
            $array = array(
                    'manager_id' => $manager_id,
                    'examinee_id' => $examinee_id,
                    'advantage' => '',
                    'disadvantage' => '',
                    'remark' => ''
            );
            if (!$interview) {
                if (Interview::commentSave($array) === false) {
                    $returnMessage['status'] = 'failed';
                    break;
                }
            }
            }
            else{
                continue;
            }
    	}
    	echo json_encode($returnMessage);
    }

}