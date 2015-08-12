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

	public function indexAction(){
        
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
            $this->dataReturn(array('url' =>'/examinee/editinfo'));
            return;
        }
    }

	public function inqueryAction(){
		$this->leftRender("需求量表");
        //获得被试者的登陆信息
        
	}
    public function getquesAction(){
    	$index=$this->request->getPost('index','int');
        //需要按照index在数据库中搜索量化考评题目       
        $question = array('ques_length'=>(int)20,
                            'index'=>(int)$index,
                            'title'=>"test您认为公司发展",
                            'options'=>"资源整合能力|融资能力|人力资源管理能力|科研技术能力|科研技术能力|学习能力|工程建设与运营管理能力|内部管理能力|创新能力|风险控制能力",
                            'is_multi'=>true);
        $this->dataReturn($question);
    }

	public function doexamAction()
	{
		$this->leftRender("答题");
	}

    public function getpaperAction(){
        $examinee = $this->session->get('Examinee');
        $project_id = $examinee->project_id;
        $paper_id = $this->request->getPost("paper_id","int");
        $questions = $this->getQuestions($project_id,$paper_id);

        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        $this->dataReturn(array("question"=>$questions,"description"=>Paper::findFirst($paper_id)->description));
    }

    public function getQuestions($project_id,$paper_id){
        $project = Pmrel::find(array(
            "project_id = ?1",
            "bind"=>array(1=>$project_id)
            ));
        $modules_id_array = $this->getModules($project);
        
        $indexs_id_array = $this->getIndex($modules_id_array);

        $factor_id_array = $this->getFactor($indexs_id_array);

        $question_id_array = $this->getQlist($factor_id_array,$paper_id);

        $exams = $this->getExam($question_id_array);

        return $exams;
    }

    public function getIndex($modules){
        $index_id = array();
        for ($i=0; $i < sizeof($modules); $i++) { 
            $module = Module::findFirst($modules[$i]);
            $children = $module->children;
            $children = explode(",", $children);
            for ($j=0; $j < sizeof($children); $j++) { 
                $index_id[] = $children[$j];
            }
        }
        return explode(",",implode(",",array_unique($index_id)));
    }

    public function getFactor($indexs){
        //$this->view->disable();
        $factor_id = array();
        for ($i=0; $i <sizeof($indexs) ; $i++) { 
            $index = Index::findFirst($indexs[$i]);
            $children = $index->children;
            $childrentype = $index->children_type;
            $children = explode(",",$children );
            $childrentype = explode(",", $childrentype);
            for ($j=0; $j < sizeof($childrentype); $j++) { 
                //0代表index，1代表factor
                if ($childrentype[$j] == "0") {
                    $index1 = Index::findFirst(intval($children[$j]));
                    $children1 = $index1->children;
                    $children1 = explode(",",$children1);
                    for ($k=0; $k <sizeof($children1) ; $k++) { 
                        $children1[$k] = intval($children1[$k]);
                        $factor_id[] = $children1[$k];
                    }
                }
                else{   
                        $children[$j] = intval($children[$j]);
                        $factor_id[] = $children[$j];
                }               
            }
        }
        return explode(",",implode(",",array_unique($factor_id)));
    }

    public function getQlist($factors,$paper_id){
        $this->view->disable();
        $questions_id = array();
        for ($i=0; $i <sizeof($factors) ; $i++) {           
            $factor = Factor::findFirst($factors[$i]);
            if ($factor->paper_id == $paper_id) {
                $children = $factor->children;
                $childrentype = $factor->children_type;
                $children = explode(",",$children );
                $childrentype = explode(",", $childrentype);
                for ($j=0; $j < sizeof($childrentype); $j++) { 
                    //0代表factor，1代表question
                    if ($childrentype[$j] == "0") {
                        $factor1 = Factor::findFirst($children[$j]);
                        $children1 = $factor1->children;
                        $children1 = explode(",",$children1);
                        for ($k=0; $k <sizeof($children1) ; $k++) { 
                            $children1[$k] = intval($children1[$k]);
                            $questions_id[] = $children1[$k];                       
                        }
                    }
                    else{   
                            $children[$j] = intval($children[$j]);
                            $questions_id[] = $children[$j];
                    }               
                }
            }
        }
        
        return explode(",",implode(",",array_unique($questions_id)));
    }

    public function getExam($questions){
        $data = array();
        for ($i=0; $i < sizeof($questions); $i++) { 

            $question = Question::findFirst($questions[$i]);
            $data[$i]=json_encode(array(
                'index'=>$i,
                'title'=>$question->topic,
                'options'=>$question->options));
        }
        return $data;
    }

    public function getIds($models){
        $id_array = array();
        foreach ($models as $model) {
            $id_array[]  = $model->id;
        }
        return $id_array;
    }

    public function getModules($project){
        $id_array = array();
        foreach ($project as $projects) {
            $id_array[]  = $projects->module_id;
        }
        return $id_array;
    }

    public function getExamAnswerAction(){
        $answer = $this->request->getPost("answer", "string");
        $paper_id = $this->request->getPost("paper_id", "int");
        $this->dataReturn(array("answer"=>$answer));
    }

    public function addAction(){
        // $paper = new Paper("select * from paper"); 
        $sql = "select * from Paper";
        $paper = $this->modelsManager->executeQuery($sql);
        $this->view->setVar("paper",$paper);
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

    public function editinfoAction(){
        $this->leftRender("个 人 信 息 填 写");

        $examinee = $this->session->get('Examinee');
        $name = $examinee->name;
        $sex = $examinee->sex;
        $education = $examinee->education;
        $degree = $examinee->degree;
        $birthday = $examinee->birthday;
        $native = $examinee->native; 
        $politics = $examinee->politics;
        $professional = $examinee->professional;
        $employer = $examinee->employer;
        $unit = $examinee->unit;
        $duty = $examinee->duty;
        $team = $examinee->team;
        
        $this->view->setVar('name',$name);
        $this->view->setVar('sex',$sex);
        $this->view->setVar('education',$education);
        $this->view->setVar('degree',$degree);
        $this->view->setVar('birthday',$birthday);
        $this->view->setVar('native',$native);
        $this->view->setVar('politics',$politics);
        $this->view->setVar('professional',$professional);
        $this->view->setVar('employer',$employer);
        $this->view->setVar('unit',$unit);
        $this->view->setVar('duty',$duty);
        $this->view->setVar('team',$team);
    }

    public function listAction(){
        $this->view->disable();
        $examinee = $this->session->get('Examinee');
        $json = json_decode($examinee->other,true);
        $array = array();
        $array['records'] = count($json['education']);
        foreach ($array['records'] as $record)
        {
            $array['rows'][$record] = $json['education'][$record];
        }
        echo count($json['education']);
        echo json_encode($array);
        // $array = array();
        // $ans['records'] = count($json['education']);
        // $array['rows'] = $json['education'];
        // echo json_encode($array);
        /*
        for ($i=0; $i < 1; $i++) { 
            $school     = $json['education'][$i]['school'][0];
            $profession = $json['education'][$i]['profession'][0];
            $degree     = $json['education'][$i]['degree'][0];
            $date       = $json['education'][$i]['date'][0];
            $record     = $i;
        }*/

    }

    public function updateAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $record = $this->request->getPost('record', 'int');
            $json['education'][$record]['school'][0]     = $this->request->getPost('school', 'string');
            $json['education'][$record]['profession'][0] = $this->request->getPost('profession', 'string');
            $json['education'][$record]['degree'][0]     = $this->request->getPost('degree', 'string');
            $json['education'][$record]['date'][0]       = $this->request->getPost('date', 'string');
        }
        if (!$json['education'][$record]->save()) {
            foreach ($json['education'][$record]->getMessages() as $message) {
                echo $message;
            }
        }
        if ($oper == 'del') {
            $record = $this->request->getPost('record', 'int');
            if (!$json['education'][$record]->delete()) {
                foreach ($json['education'][$record]->getMessages() as $message) {
                    echo $message;
                }
            }
        }
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