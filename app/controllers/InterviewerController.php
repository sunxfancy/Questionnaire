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
        $advantage = $this->request->getPost('advantage');
        $disadvantage = $this->request->getPost('disadvantage');
        $remark = $this->request->getPost('remark');
        $advantages = explode("|", $advantage);
        $disadvantages = explode("|", $disadvantage);
        $flag = 0;
        foreach ($advantages as $key => $value) {
            if ($value == '') {
                $flag = 1;
            }
        }
        foreach ($disadvantages as $key => $value) {
            if ($value == '') {
                $flag = 1;
            }
        }
        if ($remark == '') {
            $flag = 1;
        }
        $array = array(
            'advantage' => $advantage,
            'disadvantage' => $disadvantage,
            'remark' => $remark,
            'manager_id' => $manager->id,
            'examinee_id' => $examinee_id
            );
        if ($flag == 1) {
            InterviewDB::insertInComments($array);
        }else{
            InterviewDB::insertComments($array);
        }
        $this->dataReturn(array('status'=>true));
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

    //进入添加意见页面时获取面询专家的意见
    public function getPointAction($examinee_id){
        $interviewer = $this->session->get('Manager');
        if(empty($interviewer)){
            $this->dataReturn(array('error'=>'用户信息获取失败,请重新登录'));
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

    #获取被试信息页面
    public function listexamineeAction(){
        $this->view->disable();
        $manager = $this->session->get('Manager');
        if (empty($manager)){
            $this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
            return ;
        }
        $manager_id = $manager->id;
        $page = $this->request->get('page');
        $rows = $this->request->get('rows');
        $offset = $rows*($page-1);
        $limit = $rows;
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else{
            $sort = 'id';
            $sord = 'desc';
        }
        if ($sord != null){
            $sort = $sort.' '.$sord;
        }
        //default get
        $search_state = $this->request->get('_search');
        if($search_state == 'false'){
            $result = $this->modelsManager->createBuilder()
                ->columns(array(
                    'Examinee.id as id',
                    'Examinee.number as number',
                    'Examinee.name as name',
                    'Examinee.sex as sex',
                    'Examinee.last_login as last_login',
                    'Examinee.state as state',
                    ))
                ->from('Examinee')
                //添加类型判断
                ->join('Interview','Interview.examinee_id = Examinee.id AND Interview.manager_id = '.$manager_id )
                ->limit($limit,$offset)
                ->orderBy($sort)
                ->getQuery()
                ->execute();
            $rtn_array = array();
            $examinees = Interview::find(array(
                'manager_id=?1',
                'bind'=>array(1=>$manager_id,)));
            //获取该项目下答题的总人数
            $count =  count($examinees);
            $rtn_array['total'] = ceil($count/$rows);
            $rtn_array['records'] = $count;
            $rtn_array['rows'] = array();
            foreach($result as $value){
                $rtn_array['rows'][] = $value;
            }    
            $rtn_array['page'] = $page;  
            $this->dataReturn($rtn_array);                
            return;
        }else{
            //处理search情况
            $search_field =  $this->request->get('searchField');
            $search_string =  $this->request->get('searchString');
            $search_oper = $this->request->get('searchOper');
            #分情况讨论
            $filed = 'Examinee.'.$search_field;
            if ($search_oper == 'eq'){
                if ($search_field == 'name'){
                    $oper = 'LIKE';
                    $value = "'%$search_string%'";
                }else if ($search_field == 'number' || $search_field == 'sex' ){
                    $oper = '=';
                    $value = "'$search_string'";
                }else if ( $search_field == 'exam_state' || $search_field == 'interview_state'){
                    $filed = 'Examinee.state';
                    if ($search_string == 'true'){
                        $oper = '>=';
                    }else{
                        $oper = '<';
                    }
                    if ($search_field == 'exam_state'){
                        $value = 1;
                    }else {
                        $value = 4;
                    }
            }
            }else if ( $search_oper == 'bw' ||$search_oper == 'ew' ){
                if (  $search_field == 'last_login' ){
                    $value = "'$search_string'";
                }
                if($search_oper == 'bw'){
                    $oper = '>=';
                }else if ($search_oper == 'ew'){
                    $oper = '<=';
                }
            }else {
                //add ...
            }
            $result = $this->modelsManager->createBuilder()
                ->columns(array(
                        'Examinee.id as id',
                        'Examinee.number as number',
                        'Examinee.name as name',
                        'Examinee.sex as sex',
                        'Examinee.last_login as last_login',
                        'Examinee.state as state',
                ))
                ->from('Examinee')
                ->join('Interview','Interview.examinee_id = Examinee.id AND Interview.manager_id = '.$manager_id." AND $filed $oper $value" )
                ->orderBy($sort)
                ->getQuery()
                ->execute();
            $rtn_array = array();
            $count = count($result);
            $rtn_array['total'] = ceil($count/$rows);
            $rtn_array['records'] = $count;
            $rtn_array['rows'] = array();
            foreach($result as $value){
                $rtn_array['rows'][] = $value;
            }
            $rtn_array['page'] = $page;
            $this->dataReturn($rtn_array);
            return;
        }     
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

}