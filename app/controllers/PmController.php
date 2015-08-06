<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:18:46
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-06 16:33:09
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
        $builder = $this->modelsManager->createBuilder()                            
                                       ->from('Examinee');
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
            $examinee->project_id = $this->request->getPost('project_id', 'int');
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
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
                                       //->join('Project','Project.project_id=Manager.project_id')
                                       ->where('Manager.role = "I"');
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

    public function updateinterviewerAction()
    {
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password       = $this->request->getPost('password', 'string');
            $manager->project_id = $this->request->getPost('project_id', 'int');
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
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
                                       //->join('Project','Project.project_id=Manager.project_id')
                                       ->where('Manager.role = "L"');
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
            $manager->project_id = $this->request->getPost('project_id', 'int');
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

/*  function leftRender()
    {
        $manager = $this->session->get('Manager');
        $this->view->setVar('page_title','北京政法系统人才测评项目管理平台');
        $this->view->setVar('user_name',$manager->name);
        $this->view->setVar('user_id',  $manager->username);
        $this->view->setVar('user_role',"项目经理");
   }
*/
}