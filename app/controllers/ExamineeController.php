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

	public function initialize(){
        $this->view->setTemplateAfter('base3');
    }
	#设置examinee转到/
	public function indexAction(){
        $this->response->redirect('/');
	}
	
    public function loginAction(){
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

	public function inqueryAction(){
		$exminee = $this->session->get('Examinee');
 		// $this->session->remove('Examinee');
		if(empty($exminee)){
			$this->response->redirect('/error/index/examinee');
			$this->view->disable();
		}else{
			$this->leftRender("需求量表");
		}
        //获得被试者的登陆信息      
	}

    public function getInqueryAction(){
// 		$this->session->remove('Examinee');
    	$exminee = $this->session->get('Examinee');
    	if(empty($exminee)){
    		$this->dataReturn(array('error'=>'用户信息获取失败'));
    		return;
    	}
        $project_id = $exminee->project_id;
        $inquery_data = MemoryCache::getInqueryQuestion($project_id);
        if(count($inquery_data) == 0 ){
        	$this->dataReturn(array('error'=>'需求量表获取失败,返回数据为空'));
        	return ;
        }else{
        	$question = array();
        	foreach($inquery_data as $record){
        		$question[] = array(
        			'index' => $record['id'],
        			'title' => $record['topic'],
        			'options' => $record['options'],
        			'is_multi' => $record['is_radio'] == 1 ? false : true,
        		);
        	}
        	$this->dataReturn(array('question'=>$question));
        	return ;
        }
    }

    public function getInqueryAnsAction(){
    	$exminee = $this->session->get('Examinee');
    	if(empty($exminee)){
    		$this->dataReturn(array('error'=>'用户信息获取失败'));
    		return;
    	}
    	$project_id = $exminee->project_id;
    	$examinee_id = $exminee->id;
        $option = $this->request->getPost("answer", "string");
        if(empty($option)){
        	$this->dataReturn(array('error'=>'提交失败:提交信息为空'));
        	return;
        }
        try{
        	ExamineeDB::insertInquery($examinee_id, $option, $project_id);
        }catch(Exception $e){
        	$this->dataReturn(array('error'=>$e->getMessage()));
        	return;
        }
        $this->dataReturn(array('flag'=>true));
    }

	public function doexamAction(){
		$this->leftRender("答题");
	}

    public function getpaperAction(){
        $paper_name = $this->request->getPost("paper_name","string");
        $examinee = $this->session->get('Examinee');
        $project_id = $examinee->project_id;
        $paper_id = $this->getPaperId($paper_name);
        $questions = $this->getQuestions($project_id,$paper_name);
        $data = $this->getExamination($questions,$paper_id);

        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        if (empty($data)) {
            $no_ques = "none";
            $this->dataReturn(array("no_ques"=>$no_ques));
        }
        else{
            $this->dataReturn(array("question"=>$data,"description"=>Paper::findFirst($paper_id)->description,"order"=>$questions));
        }
    }

    public function getQuestions($project_id,$paper_name){
        $project_detail = ProjectDetail::findFirst(array(
                "project_id=?1",
                "bind"=>array(1=>$project_id)
                ));
        $question = json_decode($project_detail->exam_json,true);
        $questions = array();
        foreach ($question as $key => $value) {
            if ($key == $paper_name) {
                $questions = $value;
            }
            else
                continue;
        }
        return $questions;
    }

    public function getExamination($questions,$paper_id){
        $data = array();
        for ($i=0;$i<sizeof($questions);$i++) {
            $questionb = Question::findFirst(array(
                'paper_id=?0 and number=?1',
                'bind'=>array(0=>$paper_id,1=>$questions[$i])));
            $title = '';
            if (isset($questionb->topic) && !empty($questionb->topic)) {
                $title = $questionb->topic;
            }
            $data[$i]=array(
                'index'=>$i,
                'title'=>$title,
                'options'=>$questionb->options);
        }
        return $data;
    }
    public function getExamAnswerAction(){
    	$id = $this->session->get('Examinee')->id;
    	$total_time=$this->request->getPost("total_time","int");
    	if($total_time){
    		$time_start  =  Test4Controller::microtime_float ();
    		$memory_start = memory_get_usage( true );
    		try{
    			QuestionIC::finishedExam($id, intval($total_time));
    			BasicScore::handlePapers($id);
    			BasicScore::finishedBasic($id);
    			FactorScore::handleFactors($id);
    			FactorScore::finishedFactor($id);
    			IndexScore::handleIndexs($id);
    			IndexScore::finishedIndex($id);
    		}catch(Exception $e){
    			$this->dataReturn(array("total_time"=>$e->getMessage()));
    			return ;
    		}
    		$memory_end = memory_get_usage( true );
    		$memory_consuming = ($memory_end - $memory_start)/1024/1024;
    		$time_end = Test4Controller::microtime_float();
    		$time_consuming = $time_end - $time_start;
    		$this->dataReturn(array("total_time"=>$time_consuming .'-'. $memory_consuming));
    		return;
    	}
    	$option = $this->request->getPost("answer", "string");
    	$paper_name = $this->request->getPost("paper_name", "string");
    	$number = $this->request->getPost("order");
    	$time_start  =  Test4Controller::microtime_float ();
    	$memory_start = memory_get_usage( true );
    	try{
    		QuestionIC::insertQuestionAns($id, $paper_name, $option, $number);
    	}catch(Exception $e){
    		$this->dataReturn(array("flag"=>false));
    		return;
    	}
    	$memory_end = memory_get_usage( true );
    	$memory_consuming = ($memory_end - $memory_start)/1024/1024;
    	$time_end = Test4Controller::microtime_float();
    	$time_consuming = $time_end - $time_start;
    	$this->dataReturn(array("flag"=>true));
    	return;
    }

    public function editinfoAction(){
        $this->leftRender("个 人 信 息 填 写");
        $id = $this->session->get('Examinee')->id;
        $examinee = Examinee::findFirst($id);
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
    }

    public function submitAction(){
        $this->view->disable();
        $id = $this->session->get('Examinee')->id;
        $examinee = Examinee::findFirst($id);
        $examinee->name         = $this->request->getPost("name", "string");
        $sex = $this->request->getPost("sex", "string");
        $examinee->sex          = ($sex =="男") ? 1 : 0;
        $examinee->education    = $this->request->getPost("education", "string");
        $examinee->degree       = $this->request->getPost("degree", "string");
        $examinee->birthday     = $this->request->getPost("birthday", "string");
        $examinee->native       = $this->request->getPost("native", "string");
        $examinee->politics     = $this->request->getPost("politics", "string");
        $examinee->professional = $this->request->getPost("professional", "string");
        $examinee->employer     = $this->request->getPost("employer", "string");
        $examinee->unit         = $this->request->getPost("unit", "string");
        $examinee->duty         = $this->request->getPost("duty", "string");
        $examinee->team         = $this->request->getPost("team", "string");
        if (!$examinee->save()) {
            foreach ($examinee->getMessages() as $msg) {
                echo $msg."\n";
            }
        }
    }

    public function listeduAction(){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        $this->view->disable();
        $id = $this->session->get('Examinee')->id;
        $examinee = Examinee::findFirst($id);
        $json = json_decode($examinee->other,true);
        $array = array();
        $array['records'] = count($json['education']);
        for($i = 0;$i<$array['records'] + 1;$i++){
            $json['education'][$i]['id'] = $i;
        }
        $array['rows'] = $json['education'];
        echo json_encode($array,JSON_UNESCAPED_UNICODE);
    }

    public function updateeduAction(){
        $this->view->disable();
        $oper = $this->request->getPost('oper', 'string');
        $id = $this->session->get('Examinee')->id;
        $examinee = Examinee::findFirst($id);
        // print_r($examinee);
        $json = json_decode($examinee->other,true);
        $array = array();
        $array['rows'] = $json['education'];
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $json['education'][$id]['school']     = $this->request->getPost('school', 'string');
            $json['education'][$id]['profession'] = $this->request->getPost('profession', 'string');
            $json['education'][$id]['degree']     = $this->request->getPost('degree', 'string');
            $json['education'][$id]['date']       = $this->request->getPost('date', 'string');
            $array ['rows'][$id] = $json['education'][$id];
            $json['education'] = $array['rows'];
        } 
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            array_splice($array['rows'],$id,1);
            $json['education'] = $array['rows'];
        }
        if ($oper == 'add') {
            $id = count($json['education']) + 1;
            $json['education'][$id]['school']     = $this->request->getPost('school', 'string');
            $json['education'][$id]['profession'] = $this->request->getPost('profession', 'string');
            $json['education'][$id]['degree']     = $this->request->getPost('degree', 'string');
            $json['education'][$id]['date']       = $this->request->getPost('date', 'string');
            $array ['rows'][$id] = $json['education'][$id];
            $json['education'] = $array['rows'];
        }
        $json = json_encode($json,JSON_UNESCAPED_UNICODE);
        $examinee->other = $json;
        if (!$examinee->save()) {
            foreach ($examinee->getMessages() as $msg) {
                echo $msg."\n";
            }
        }
    }
    
    public function listworkAction(){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        $this->view->disable();
        $id = $this->session->get('Examinee')->id;
        $examinee = Examinee::findFirst($id);
        $json = json_decode($examinee->other,true);
        $array = array();
        $array['records'] = count($json['work']);
        for($i = 0;$i<$array['records'] + 1;$i++){
            $json['work'][$i]['id'] = $i;
        }
        $array['rows'] = $json['work'];
        echo json_encode($array,JSON_UNESCAPED_UNICODE);
    }

    public function updateworkAction(){
        $this->view->disable();
        $oper = $this->request->getPost('oper', 'string');
        $id = $this->session->get('Examinee')->id;
        $examinee = Examinee::findFirst($id);
        // print_r($examinee);
        $json = json_decode($examinee->other,true);
        $array = array();
        $array['rows'] = $json['work'];
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $json['work'][$id]['employer']     = $this->request->getPost('employer', 'string');
            $json['work'][$id]['unit'] = $this->request->getPost('unit', 'string');
            $json['work'][$id]['duty']     = $this->request->getPost('duty', 'string');
            $json['work'][$id]['date']       = $this->request->getPost('date', 'string');
            $array ['rows'][$id] = $json['work'][$id];
            $json['work'] = $array['rows'];
        } 
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            array_splice($array['rows'],$id,1);
            $json['work'] = $array['rows'];
        }
        //print_r($json);
        $json = json_encode($json,JSON_UNESCAPED_UNICODE);
        $examinee->other = $json;
        if (!$examinee->save()) {
            foreach ($examinee->getMessages() as $msg) {
                echo $msg."\n";
            }
        }
    }

    public function dividepeoAction($manager_id){
        $project_id = $this->session->get('Manager')->project_id;
        $this->view->disable();
        $interview = Interview::find();
        $term = '(';
        foreach($interview as $key => $item){
            $term .= ' id<>'.$item->examinee_id.' AND ';
        }
        if($term == '('){
            $phql = 'SELECT * FROM Examinee WHERE project_id='.$project_id;
            $row = $this->modelsManager->executeQuery($phql);
            $data = array();
            foreach($row as $key => $value){
                $data[$key] = $value;
            }
            $data = json_encode($data);
            echo $data;
        }else{
            $term = substr($term,0,strlen($term)-4);
            $term .= ')';
            $phql = 'SELECT * FROM Examinee WHERE '.$term.' AND project_id='.$project_id;
            $row = $this->modelsManager->executeQuery($phql);
            $data = array();
            foreach($row as $key => $value){
                $data[$key] = $value;
            }
            $data = json_encode($data);
            echo $data;
        }
    }

    public function getPaperId($paper_name){
        $paper = Paper::findFirst(array(
            'name=?1',
            'bind'=>array(1=>$paper_name)));
        return $paper->id;
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

    public function leftRender($title){
        /****************这一段可以抽象成一个通用的方法**********************/
        $examinee = $this->session->get('Examinee');
        $name = $examinee->name;
        $number = $examinee->number;
        $this->view->setVar('page_title',$title);
        $this->view->setVar('name',$name);
        $this->view->setVar('number',$number);
        $this->view->setVar('role','被试人员');
        /*******************************************************************/
    }
}