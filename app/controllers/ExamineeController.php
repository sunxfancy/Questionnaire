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

	public function initialize()
    {
        $this->view->setTemplateAfter('base3');

    }

	public function indexAction()
	{
        
	}

    public function loginAction()
    {
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

	public function inqueryAction()
	{
		$this->leftRender("需求量表");
        //获得被试者的登陆信息
        
	}
    public function getquesAction()
    {
    	$index=$this->request->getPost('index','int');
        //需要按照index在数据库中搜索量化考评题目       
        $question = array('ques_length'=>(int)20,
                            'index'=>(int)$index,
                            'title'=>"test您认为公司发展",
                            'options'=>"资源整合能力|融资能力|人力资源管理能力|科研技术能力|科研技术能力|学习能力|工程建设与运营管理能力|内部管理能力|创新能力|风险控制能力",
                            'is_multi'=>true);
        $this->dataReturn($question);
    }

	public function editinfoAction()
	{
        $this->leftRender("个 人 信 息 填 写");

        /*$examinee = $this->session->get('Examinee');
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
        $json = json_decode($examinee->other);
        $json['education'][0]['school']

        
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
        $this->view->setVar('duty',$duty);*/
	}

	public function doexamAction()
	{
		$this->leftRender("答题");
	}

    public function addAction()
    {
        // $paper = new Paper("select * from paper"); 
        $sql = "select * from Paper";
        $paper = $this->modelsManager->executeQuery($sql);
        $this->view->setVar("paper",$paper);

    }

    public function dataReturn($ans)
    {
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

    public function leftRender($title)
    {
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