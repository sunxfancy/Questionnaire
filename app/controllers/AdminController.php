<?php

class AdminController extends Base
{
    public function initialize(){
        $this->view->setTemplateAfter('base2');
    }

    public function indexAction(){
        $this->leftRender('项 目 管 理');
    }

    public function addnewAction(){
        $this->leftRender('新 建 项 目');
    }

    public function newprojectAction(){
        $date = date('y');
        $project = Project::find();
        if (count($project)  == 0) {
            $project_id = $date.'01';
        }else{
            $project_num1 = 0;$project_num2 = 0;
            foreach ($project as $projects) {
                if (intval($projects->id) - intval($date.'00') > 0) {
                    $project_num1++;
                }
            }
            if ($project_num1 > 0) {
                $project_last = $project->getLast();
                $project_id = $project_last->id+1;
            }else{
                $project_id = $date.'01';
            }
        }
        $manager = new Manager();
        $this->getData($manager, array(
            'name'     => 'pm_name',
            'username' => 'pm_username',
            'password' => 'pm_password'));
        $manager->role = 'P';

        $project = new Project();
        $this->getData($project, array(
            'name'        => 'project_name', 
            'description' => 'description',
            'begintime'   => 'begintime',
            'endtime'     => 'endtime'));
        $project->id = $project_id;
        try {
            if (!$manager->save()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
            $project->manager_id = $manager->id;
            if (!$project->save()) {
                foreach ($project->getMessages() as $message) {
                    echo $message;
                }
            }
            $manager->project_id = $project->id;
            $manager->save();
        } catch( Exception $e ) {
            echo $e->getMessage();
            return;
        }
        $this->response->redirect('admin');
    }

    public function detailAction($project_id){
        $this->view->setVar('project_id',$project_id);
        $this->leftRender('项 目 详 情');
        $project = Project::findFirst($project_id);
        $this->view->setVar('project_name',$project->name);
        $begintime = date('Y-m-d',strtotime($project->begintime));
        $endtime = date('Y-m-d',strtotime($project->endtime));
        $now = date("Y-m-d");
        $width = 100*round(strtotime($now)-strtotime($begintime))/round(strtotime($endtime)-strtotime($begintime)).'%'; 
        $detail = $this->getDetail($project_id);

        $this->view->setVar('begintime',$begintime);
        $this->view->setVar('endtime',$endtime);
        $this->view->setVar('now',$now);
        $this->view->setVar('width',$width);
        $this->view->setVar('detail',$detail);
    }

    public function getDetail($project_id){
        $examinees = Examinee::find(array(
            'project_id=?1',
            'bind'=>array(1=>$project_id)));
        $examinee_all = count($examinees);
        $examinee_com = 0;
        $examinee_coms = array();
        foreach ($examinees as $examinee) {
            if ($examinee->state > 0) {
                $examinee_com ++;
                $examinee_coms[] = $examinee->id;
            }
        }
        $interview_com = 0;
        for ($i=0; $i < $examinee_com; $i++) { 
            $interview = Interview::findFirst($examinee_coms[$i]);
            if (!empty($interview->advantage) && !empty($interview->disadvantage) &&!empty($interview->remark)){
                $interview_com++;
            } 
        }
        if ($examinee_all == 0) {
            $examinee_percent = 0;
        }else{
            $examinee_percent  = $examinee_com / $examinee_all;
        }
        if ($examinee_com == 0) {
            $interview_percent = 0;
        }else{
            $interview_percent = $interview_com / $examinee_com;
        }
        $detail = array(
            'examinee_percent'  => $examinee_percent,
            'interview_percent' => $interview_percent
        );
        return json_encode($detail,true);
    }

    public function listAction(){
        $builder = $this->modelsManager->createBuilder()
                                       ->columns(array(
                                        'Project.id as id', 'Project.begintime as begintime',
                                        'Project.endtime as endtime', 'Project.description as description',
                                        'Project.name as name', 'Manager.name as manager_name', 
                                        'Manager.username as manager_username', 'COUNT(Examinee.id) as user_count' ))
                                       ->from('Project')
                                       ->join('Manager', 'Project.manager_id = Manager.id')
                                       ->leftJoin('Examinee', 'Project.id = Examinee.project_id')
                                       ->groupBy('Examinee.id');
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else{
            $sort = 'id';
            $sord = 'desc';
        }
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
    }

    public function updateAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $project = Project::findFirst($id);
            $project->name      = $this->request->getPost('name', 'string');
            $project->begintime = $this->request->getPost('begintime', 'string');
            $project->endtime   = $this->request->getPost('endtime', 'string');
            $manager = Manager::findFirst(array(
                'project_id=?0',
                'bind'=>array($id)));
            $manager->name     = $this->request->getPost('manager_name', 'string');
            $manager->username = $this->request->getPost('manager_username', 'string');
            if (!$project->save()||!$manager->save()) {
                foreach ($project->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $manager = Project::findFirst($id);
            if (!$manager->delete()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

	public function datareturn($builder){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $limit = $this->request->getQuery('rows', 'int');
        $page = $this->request->getQuery('page', 'int');
        if (is_null($limit)) $limit = 10;
        if (is_null($page)) $page = 1;
        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array("builder" => $builder,
                                                                      "limit" => $limit,
                                                                      "page" => $page));
        $page = $paginator->getPaginate();
        $ans = array();
        $ans['total'] = $page->total_pages;
        $ans['page'] = $page->current;
        $ans['records'] = $page->total_items;
        foreach ($page->items as $key => $item){
            $ans['rows'][$key] = $item;
        }
        echo json_encode($ans);
        $this->view->disable();
    }

}

