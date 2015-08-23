<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:18:46
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-14 17:37:25
 */

/**
* 
*/
class PmController extends Base
{
    public function initialize(){
        parent::initialize();
    }

    public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('北京政法系统人才测评项目管理平台');
    }

	public function detailAction(){
		
	}

	public function examineeAction(){
		# code...
	}

	public function interviewerAction(){
		# code...
	}

	public function leaderAction(){
		# code...
	}

	public function resultAction(){
		# code...
	}

    public function testAction(){
        echo date('y');
        $this->view->disable();
    }

    public function selectmoduleAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 试 模 块 选 择');
    }

    public function disp_moduleAction(){
        $manager=$this->session->get('Manager');
        if($manager){
            $pmrels=Pmrel::find(array(
                "project_id=?1",
                "bind"=>array(1=>$manager->project_id)
                ));
            $ans='';
            for ($i=0; $i < sizeof($pmrels); $i++) { 
                $module=Module::findFirst($pmrels[$i]->module_id);
                $ans.=$module->chs_name.'|';
            }

            $this->dataBack(array("select"=>$ans));
        }else{
            $this->dataBack(array('error'=>"您的身份验证出错,请重新登录"));
        }
    }

    public function uploadexamineeAction(){
        $this->upload_base('LoadExaminee');
    }

    public function uploadinterviewerAction(){
        $this->upload_base('LoadInterviewer');
    }

    public function uploadleaderAction(){
        $this->upload_base('LoadLeader');
    }

    public function upload_base($method){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $this->view->disable();
        if ($this->request->isPost() && $this->request->hasFiles())
        {
            $files = $this->request->getUploadedFiles();
            $filename = "Import-".date("YmdHis");
            $excel = ExcelLoader::getInstance();
            $project_id = $this->session->get('Manager')->project_id;
            echo $project_id ."\n";
            $i = 1;
            foreach ($files as $file) {
                $newname = "./upload/".$filename."-".$i.".xls";
                echo $newname."\n";
                $file->moveTo($newname);
                $ans = $excel->$method($newname, $project_id, $this->db);
                echo $ans ."\n";
                if ($ans != 0) { echo json_encode($ans); return; }
                $i++;
            }
            echo 0;
        } else {
            echo json_encode(array('error' => '错误的接口访问'));
        }
    }

	public function listexamineeAction(){
        $project_id = $this->getProjectId();
        $builder = $this->modelsManager->createBuilder()                            
                                       ->from('Examinee')
                                       ->where("project_id = '$project_id'");
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else
            $sort = 'number';
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
	}

	public function updateexamineeAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $examinee = Examinee::findFirst($id);
            $examinee->name       = $this->request->getPost('name', 'string');
            $examinee->password   = $this->request->getPost('password', 'string');
            if (!$examinee->save()) {
                foreach ($examinee->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $examinee = Examinee::findFirst($id);
            if (!$examinee->delete()) {
                foreach ($examinee->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

    public function listinterviewerAction(){
        $project_id = $this->getProjectId();
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
                                       //->join('Project','Project.project_id=Manager.project_id')
                                       ->where("Manager.role = 'I' AND Manager.project_id = '$project_id'");
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else
            $sort = 'username';
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
    }

    function getProjectId() {
        $manager = $this->session->get('Manager');
        return $manager->project_id;
    }

    public function updateinterviewerAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password       = $this->request->getPost('password', 'string');
            if (!$manager->save()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            if (!$manager->delete()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

    public function listleaderAction(){
        $project_id = $this->getProjectId();
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
                                       //->join('Project','Project.project_id=Manager.project_id')
                                       ->where("Manager.role = 'L' AND Manager.project_id = '$project_id'");
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else
            $sort = 'id';
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
    }

    public function updateleaderAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password       = $this->request->getPost('password', 'string');
            if (!$manager->save()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            if (!$manager->delete()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

    public function writeselectedmoduleAction(){
        $this->view->disable();
        $manager=$this->session->get('Manager');
        if($manager){
            $checkeds=$this->request->getpost('checkeds');
            $values=$this->request->getpost('values');
            $this->db->begin();
            try{
                $pmrel_ori=Pmrel::find(array(
                        "project_id=?1",
                        "bind"=>array(1=>$manager->project_id)
                    ));
                for ($i=0; $i <sizeof($pmrel_ori) ; $i++) { 
                    $pmrel_ori[$i]->delete();
                }


                for($i=0;$i<sizeof($checkeds);$i++){
                    if($checkeds[$i]=='true'){
                        $module=Module::findFirst(array(
                        "chs_name= ?1",
                        "bind" => array( 1=> $values[$i])));
                        $pmrel=new Pmrel();
                        $pmrel->project_id=$manager->project_id;
                        $pmrel->module_id=$module->id;
                        $pmrel->save();
                    }
                 
                }
                $this->dataBack(array('url' =>'/pm/index'));
                $this->db->commit();
            }catch(Exception $e){
                $this->db->rollback();
                $this->dataBack(array('error' =>"保存错误,请重新操作!"));
            }
        }else{
            $this->dataBack(array('error' => "您的身份验证出错!请重新登录!"));
        }
    }

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

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
    }

    public function writeprojectdetailAction(){

    }

    /*
    传入参数：
    */
    public function getModule(){
        $module_name = array();
        $manager=$this->session->get('Manager');
        if($manager){
            $checkeds=$this->request->getpost('checkeds');
            $values=$this->request->getpost('values'); 
            for($i=0;$i<sizeof($checkeds);$i++){
                if($checkeds[$i]=='true'){
                    $module_name=$values[$i];
                }         
        }else{
            $this->dataBack(array('error' => "您的身份验证出错!请重新登录!"));
        }
        return $module_name;
    }

    /*
    传入参数：模块name
    动作：查询Module表,找出选定的指标
    返回参数：指标name
    */
    public function getIndex($module_name){
        $index_name = array();
        for ($i=0; $i < sizeof($module_name); $i++) { 
            $module = Module::findFirst(array(
                'name=?1',
                'bind'=>array(1=>$module_name[$i])));
            $children = $module->children;
            $children = explode(",", $children);
            for ($j=0; $j < sizeof($children); $j++) { 
                $index_name[] = $children[$j];
            }
        }
        return explode(",",implode(",",array_unique($index_name)));
    }

    /*
    传入参数：指标name
    动作：查询Index表,找出选定的因子
    返回参数：因子name
    */
    public function getFactor($index_name){
        $factor_name = array();
        for ($i=0; $i <sizeof($index_name) ; $i++) {
            $index = Index::findFirst(array(
                'name=?1',
                'bind'=>array(1=>$index_name[$i])));
            $children = $index->children;
            $childrentype = $index->children_type;
            $children = explode(",",$children );           
            $childrentype = explode(",", $childrentype);
            for ($j=0; $j < sizeof($childrentype); $j++) { 
                //0代表index，1代表factor
                if ($childrentype[$j] == "0") {
                    $index1 = Index::findFirst(array(
                        'name=?1',
                        'bind'=>array(1=>$children[$j])));
                    $children1 = $index1->children;
                    $children1 = explode(",",$children1);
                    for ($k=0; $k <sizeof($children1) ; $k++) {
                        $factor_name[] = $children1[$k];
                    }
                }
                else{   
                        $factor_name[] = $children[$j];
                }               
            }
        }     
        return explode(",",implode(",",array_unique($factor_name)));
    }

    /*
    传入参数：因子name
    动作：查询Factor表,找出选定的问卷名和题目序号
    返回参数：json格式的问卷name和题目number
    */
    public function getNumber($factor_name){
        $questions_number = array();
        $paper_id = array();      
        for ($i=0; $i <sizeof($factor_name) ; $i++) {         
            $factor = Factor::findFirst(array(
                'name=?1',
                'bind'=>array(1=>$factor_name[$i])));
            $paper_id[] = $factor->paper_id;          
            $children = $factor->children;
            $childrentype = $factor->children_type;
            $children = explode(",",$children );
            $childrentype = explode(",", $childrentype);
            for ($j=0; $j < sizeof($childrentype); $j++) { 
                //0代表factor，1代表question
                if ($childrentype[$j] == "0") {
                    $factor1 = Factor::findFirst(array(
                        'name=?1',
                        'bind'=>array(1=>$children[$j])));
                    $paper_id[] = $factor1->paper_id;
                    $children1 = $factor1->children;
                    $children1 = explode(",",$children1);
                    for ($k=0; $k <sizeof($children1) ; $k++) { 
                        $questions_number[] = trim($children1[$k],' ');
                    }
                }
                else{   
                    $questions_number[] =trim( $children[$j],' ');
                }               
            }
        }
        if(empty($questions_number)){
            return $questions_number;
        }
        $number = explode(",",implode(",",array_unique($questions_number)));
        $length = sizeof($number);
        for($i=0;$i<$length;$i++)
        {
            $number[$i] = intval($number[$i]);
        }
        sort($number);
        $paper_id = explode(",",implode(",",array_unique($paper_id)));

        return $json;
    }

}