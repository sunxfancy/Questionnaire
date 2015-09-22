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
	public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('人 员 面 询');
        $manager = $this->session->get('Manager');
        $this->view->setVar('manager_id',$manager->id);
    }

    public function pointAction($examinee_id){
        $examinee = Examinee::findFirst($examinee_id);
        $level = ReportData::getLevel($examinee_id);
        $level1 = '';$level2 = '';$level3 = '';$level4 = '';
        if ($level == '优') {
            $level1 = '&radic;';
        }else if ($level == '良') {
            $level2 = '&radic;';
        }else if ($level == '中') {
            $level3 = '&radic;';
        }else if ($level == '差') {
            $level4 = '号&radic;';
        }
        $this->view->setVar('level1',$level1);
        $this->view->setVar('level2',$level2);
        $this->view->setVar('level3',$level3);
        $this->view->setVar('level4',$level4);
        $this->view->setVar('name',$examinee->name);
        $this->view->setVar('examinee_id',$examinee_id);
        $this->view->setTemplateAfter('base2');
        $this->leftRender('填 写 面 询 意 见');
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
    
    public function divideAction($manager_id){
    	$json = $this->request->getPost('divide_examinee');
    	$returnMessage = array('status' => 'success');
    	$save_arr = explode('~', $json);
    	$min = $save_arr[0];
    	$max = $save_arr[1];
    	for ($i = $min; $i <= $max; $i++) {
    		$res = Examinee::findFirst(array(
    				"number=:number:",
    				"bind" => array("number" => $i)));
    		if($res){
                $examinee_id = $res->id;
                /*
                 * 判断interview表中是否存在记录
                * 若存在，则无需更新
                * 若不存在，则将数据插入到interview表中
                */
                $interview = Interview::findFirst(array(
                        'manager_id =?0 AND examinee_id =?1',
                        'bind' => array(0=> $manager_id,1=> $examinee_id,)));
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

    public function getPointAction($examinee_id){
        $interviewer = $this->session->get('Manager');
        if(empty($interviewer)){
            $this->dataReturn(array('error'=>'用户信息获取失败'));
            return;
        }else{
            $level = ReportData::getLevel($examinee_id);
            $interview = Interview::findFirst(array(
                'examinee_id =?0 and manager_id =?1',
                'bind'=>array(0=>$examinee_id,1=>$interviewer->id)));
            if (empty($interview->advantage)) {
                $advantage = array('1. ','2. ','3. ','4. ','5. ',);
            }else{
                $advantage = explode('|',$interview->advantage);
            }
            if (empty($interview->disadvantage)) {
                $disadvantage = array('1. ','2. ','3. ');
            }else{
                $disadvantage = explode('|',$interview->disadvantage);
            }
            $point = array();
            $point['advantage1'] = $advantage[0];
            $point['advantage2'] = $advantage[1];
            $point['advantage3'] = $advantage[2];
            $point['advantage4'] = $advantage[3];
            $point['advantage5'] = $advantage[4];
            $point['disadvantage1'] = $disadvantage[0];
            $point['disadvantage2'] = $disadvantage[1];
            $point['disadvantage3'] = $disadvantage[2];
            $point['level'] = $level;
            $point['remark'] = $interview->remark;
            $this->dataReturn(array('point'=>$point));
            return;
        }
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

}