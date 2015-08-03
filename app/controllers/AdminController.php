<?php

class AdminController extends Base
{
    public function initialize()
    {
        $this->view->setTemplateAfter('base2');
    }

    public function indexAction()
    {
        $this->leftRender();
    }

    public function addnewAction()
    {
        $this->leftRender();
    }

    public function listAction()
    {
        $builder = $this->modelsManager->createBuilder()
                                       ->columns(array(
                                        'Project.id as id', 'Project.begintime as begintime',
                                        'Project.endtime as endtime', 'Project.description as description',
                                        'Project.name as name', 'Manager.name as manager_name', 
                                        'Manager.username as manager_username', 'COUNT(Examinee.id) as user_count' ))
                                       ->from('Project')
                                       ->join('Manager', 'Project.manager_id = Manager.id')
                                       ->leftJoin('Examinee', 'Project.id = Examinee.project_id')
                                       ->groupBy('Examinee.id')
                                       ;
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


    public function updateAction()
    {
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $project = Project::findFirst($id);
            $project->username   = $this->request->getPost('begintime', 'string');
            $project->password   = $this->request->getPost('endtime', 'string');
            $project->role       = $this->request->getPost('name', 'string');
            $project->name       = $this->request->getPost('description', 'string');
            $project->manager_id = $this->request->getPost('manager_id', 'integer');
            if (!$project->save()) {
                foreach ($project->getMessages() as $message) {
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

    function leftRender()
    {
        /****************这一段可以抽象成一个通用的方法**********************/
        $manager = $this->session->get('Manager');
        $this->view->setVar('page_title','项 目 管 理');
        $this->view->setVar('user_name',$manager->name);
        $this->view->setVar('user_id',  $manager->username);
        $this->view->setVar('user_role',"管理员");
        /*******************************************************************/
    }

	public function datareturn($builder)
    {
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
        foreach ($page->items as $key => $item)
        {
            $ans['rows'][$key] = $item;
        }
        echo json_encode($ans);
        $this->view->disable();
    }
}

