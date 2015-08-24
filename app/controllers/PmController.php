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
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->setTemplateAfter('base2');
        $this->leftRender('北京政法系统人才测评项目管理平台');
        $manager = $this->session->get('Manager');
        $this->view->setVar('manager_id',$manager->id);
    }

	public function detailAction()
	{
		
	}

	public function examineeAction()
	{
		# code...
	}

	public function interviewerAction()
	{
		# code...
	}

	public function leaderAction()
	{
		# code...
	}

	public function resultAction()
	{
		# code...
	}

    public function testAction()
    {
        echo date('y');
        $this->view->disable();
    }

    public function selectmoduleAction()
    {
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

    public function uploadexamineeAction()
    {
        $this->upload_base('LoadExaminee');
    }

    public function uploadinterviewerAction()
    {
        $this->upload_base('LoadInterviewer');
    }

    public function uploadleaderAction()
    {
        $this->upload_base('LoadLeader');
    }

    public function upload_base($method)
    {
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

	public function listexamineeAction()
	{
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

	public function updateexamineeAction()
    {
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

    public function listinterviewerAction()
    {
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

    public function updateinterviewerAction()
    {
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

    public function listleaderAction()
    {
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

    public function updateleaderAction()
    {
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
    
    public function userdivideAction($manager_id){
    	$this->view->setVar('manager_id',$manager_id);
    	$this->view->setTemplateAfter('base2');
    	$this->leftRender('测试人员分配');
    }
    /*
     * 专家面询测试员列表
    */
    //    public function examineelistbymanagerAction($manager_id){
    //        $condition = "manager_id = :manager_id:";
    //        $manager = Interview::find(
    //            array(
    //                $condition,
    //                "bind" => array(
    //                    "manager_id" => $manager_id
    //                )
    //            )
    //        );
    //        $returnData = array();
    //        for($i = 0;$i < count($manager);$i++)
    	//
    	//        );
    	//
    	//    }
    
    public function examineeofmanagerAction($manager_id){
    	$condition = 'manager_id = :manager_id:';
    	$row = Interview::find(
    			array(
    					$condition,
    					'bind' => array(
    							'manager_id' => $manager_id
    					)
    			)
    	);
    	$term = '';
    	foreach($row as $key => $item){
    		$term .= ' id='.$item->examinee_id.' OR ';
    	}
    	if(empty($term)){
    		$term = 0;
    	}else{
    		$term = substr($term,0,strlen($term)-3);
    	}
    	$builder = $this->modelsManager->createBuilder()
    	->from('Examinee')
    	->where($term);
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
}