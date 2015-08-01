<?php

class AdminController extends Base
{

    public function indexAction()
    {

    }

    public function listAction()
	{
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager');
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
            $manager = Manager::findFirst($id);
			$manager->username   = $this->request->getPost('username', 'string');
			$manager->password   = $this->request->getPost('password', 'string');
			$manager->role       = $this->request->getPost('role', 'string');
			$manager->name       = $this->request->getPost('name', 'string');
			$manager->project_id = $this->request->getPost('project_id', 'integer');
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

