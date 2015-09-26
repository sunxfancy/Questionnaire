<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:18:46
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-14 17:37:25
 */

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class PmController extends Base
{
    public function initialize(){
        parent::initialize();
    }
	#主页面
    public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('北京政法系统人才测评项目管理平台');
    }
	#detail 进入界面
	public function detailAction(){
		//to detail.volt;
    }	
    #detail 信息获取
 	public function getdetailAction(){
    	$this->view->disable();
    	$manager = $this->session->get('Manager');
    	if(empty($manager)){
    		$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
    		return ;
    	}
    	$project_id = $manager->project_id;
    	$project = Project::findFirst($project_id);
    	if(!isset($project->id)){
    		$this->dataReturn(array('error'=>'项目不存在，请联系管理员'));
    		return ;
    	}
    	$ans_array = array();
    	$ans_array['project_name'] = $project->name;
    	$ans_array['begintime']    = $project->begintime;
    	$ans_array['endtime']      = $project->endtime; 
    	$ans_array['state'] = $project->state == 2 ? true :false;  
    	$ans_array['inquery'] = false;
    	$ans_array['exam'] = false;
    	if($project->state == 1 ){
    		$inquery = InqueryQuestion::findFirst(
    				array(
    				'project_id=?1',
    				'bind'=>array(1=>$project_id)));
    		if(isset($inquery->project_id)){
    			$ans_array['inquery'] = true;
    		}else{
    			$ans_array['exam'] = true;
    		}
    	} 
    	if($project->state == 2 ){
    		$ans_array['inquery'] = true;
    		$ans_array['exam'] = true;
    	}	
        $examinees = Examinee::find(array(
            'project_id=?1',
            'bind'=>array(1=>$project_id)));
        //获取该项目下答题的总人数
        $ans_array['exam_count'] = count($examinees);
        $examinee_com = 0;
        $examinee_coms = array();
        $examinee_not_coms = array();
        foreach ($examinees as $examinee) {
            if ($examinee->state > 0) {
                $examinee_com ++;
                $examinee_coms[ $examinee_com -1 ] = $examinee->id;
            }else{
            	$examinee_not_coms[] =$examinee->id;
            }
        }
        //答题完成人数
        $ans_array['exam_finish'] = $examinee_com;
        $interview_com = 0;
       	for($i = 0; $i<$examinee_com; $i++){
       		$interview = Interview::findFirst(
       				array( "examinee_id =:id:",
       						'bind'=>array('id'=>$examinee_coms[$i])
       		
       				));
       		//判定条件
       		if( !empty($interview->advantage) && !empty($interview->disadvantage) && !empty($interview->remark)){
       			$interview_com ++;
       		}
       	}
        $ans_array['interview_finish'] = $interview_com;
        
        $this->dataReturn(array('success'=>$ans_array));
        return ;
    }
	#进入模块页面
    public function moduleAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 试 模 块 选 择');
    }
    #模块界面获取信息
    public function getmoduleAction(){
    	$manager=$this->session->get('Manager');
    	if($manager){
    		$project_detail = ProjectDetail::findFirst(array(
    				"project_id=?1",
    				"bind"=>array(1=>$manager->project_id)));

    		if(!isset($project_detail->project_id)){
    			$this->dataReturn(array('success'=>''));
    			return ;
    		}
    		
    		$module_name = array();
    		$module_names = $project_detail->module_names;
    		$module_name = explode(',', $module_names);
    		if (empty($module_name)){
    			$this->dataReturn(array('success'=>''));
    			return ;
    		}
    		$ans= array();
    		foreach($module_name as $name){
    			$module = Module::findFirst(
    					array(
    							'name=?1',
    							'bind'=>array(1=>$name)
    					)
    			);
    			$ans[] = $module->chs_name;
    		}
    		$this->dataReturn(array("success"=> implode('|', $ans)));
    		return ;
    	}else{
    		$this->dataReturn(array('error'=>"您的身份验证出错,请重新登录"));
    		return ;
    	}
    }
    #写入选择模块结果
    public function writeprojectdetailAction(){
    	try{
    	$manager=$this->session->get('Manager');
    	$project_id =$manager->project_id;
    	#添加项目判断，是否有被试答题，若有答题则不能更新配置的模块
//     	$record = InqueryAns::findFirst(
//     			array(
//     					'project_id=?1',
//     					'bind'=>array(1=>$manager->project_id)
//     			)
//     	);
//     	if(isset($record->project_id)){
//     		$this->dataReturn(array('error'=>'已有被试答题，项目模块不可再修改！'));
//     		return ;
//     	}
    	if($manager){
    		$module_names = array();
    		$checkeds=$this->request->getpost('checkeds');
    		$values=$this->request->getpost('values');
    		$i = 0;
    		foreach($checkeds as $value){
    			if($value == 'true'){
    				$module_names[]=PmDB::getModuleName($values[$i]);
    			}
    			$i++;
    		}
			#全选情况
			$project_detail_info = array();
			$index_names = array();
    		if (count($module_names) == 10) {
    			$index = Index::find();
    			foreach ($index as $index_record) {
    				$index_names[] = $index_record->name;
    			}
    			$factor = Factor::find();
    			$factor_names = array();
    			foreach ($factor as $factor_record) {
    				$factor_names[] = $factor_record->name;
    			}
    			$question = Question::find();
    			$examination = array();
    			foreach ($question as $question_record) {
    				$paper_name = Paper::findFirst($question_record->paper_id)->name;
    				$examination[$paper_name][] = $question_record->number;
    			}
    			$project_detail_info['exam_json'] = json_encode($examination,JSON_UNESCAPED_UNICODE);
    		}else{
    			#所有相关指标名数组
    			$index_names = PmDB::getIndexName($module_names);
    			#所有相关因子名数组
    			$factor_names = PmDB::getFactorName($index_names);
    			#所有相关试卷下题目的数组
    			$examination =  PmDB::getQuestionName($factor_names);
    			
    			$project_detail_info['exam_json'] = json_encode($examination,JSON_UNESCAPED_UNICODE);
    		}
    		#因子分类 以及寻找子因子 
    		$factors = PmDB::getAllDividedFactors($factor_names);
    		$project_detail_info['factor_names'] = json_encode($factors,JSON_UNESCAPED_UNICODE);
    		$project_detail_info['module_names'] = implode(',', $module_names);
    		$project_detail_info['index_names'] = implode(',', $index_names);
    		$project_detail_info['project_id'] = $project_id;
    		#插入到project_detail 并更新状态
    		PmDB::insertProjectDetail($project_detail_info);
    		#模块配置的类型设为true
    		#需求量表的上传设为false
    		$this->dataReturn(array('success'=>true));
    		return;
    		}else{
    		$this->dataBack(array('error' => "您的身份验证出错!请重新登录!"));
    		return ;
    		}
    	}catch(Exception $e){
    		$this->dataReturn(array('error'=>$e->getMessage()));
    		return ;
    	}
    }
	#需求量表界面
	public function inqueryAction(){
		$this->view->setTemplateAfter('base2');
		$this->leftRender('需 求 量 表 配 置');
	}
	#获取需求量表
	public function getinqueryAction(){
		$manager=$this->session->get('Manager');
		if($manager){
			$inquery_detail = InqueryQuestion::find(
    			array(
				'project_id=?1',
    			'bind'=>array(1=>$manager->project_id)
			)
			);
			$ans = array();
			if (count($inquery_detail) == 0 ){
				$ans['state'] = false;
			}else{
				$ans['state'] = true;
			}
			if($ans['state']){
				$ans['result'] = $inquery_detail->toArray();
			}else{
				$ans['result'] = '';
			}
			$this->dataReturn(array('success'=>$ans));
			return ;
		}else{
			$this->dataReturn(array('error'=>"您的身份验证出错,请重新登录"));
			return ;
		}
	}
	#上传更新需求量表
	public function uploadInqueryAction(){
		#严格json格式{ '···' : '···'},json_encode 无法实现
		try{
            $file_path = null;
			if ($this->request->hasFiles()) {
				foreach ($this->request->getUploadedFiles() as $file) {
					if(empty($file->getName())){
						echo "{'error':'上传文件不能为空'}";
						return ;
					}else{
                        $file_name = null;
                        $file_name .= date("Y_m_d_H_i_s_");
                        $file_name .= rand(1,200)."_";
                        $file_name .= $file->getName();
                        $file_path = "./upload/";
                        $file_path .= $file_name;
                        $file->moveTo($file_path);
                    }
				}
			}else{
				echo "{'error':'wrong to here'}";
				return ;
			}
            if(empty($file_path)){
            	echo "{'error':'文件上传失败'}";
                return ;
            }
			$excelHander = new ExcelUpload($file_path);
            $data = $excelHander->handleInquery();
            if(file_exists($file_path)) unlink($file_path);
            $manager=$this->session->get('Manager');
            if(empty($manager)){
            	echo "{'error':'用户信息获取失败，请重新登陆'}";
            	return ;
            }
		    $project_id = $manager->project_id;
		    #上传需求量表前先删除之前的信息
		    #目前还没有加上项目进行时判断
		    #判断项目状态是否更新需求量表，是否有人答题
		    $record = InqueryAns::findFirst(
		    array(
		    'project_id=?1',
		    'bind'=>array(1=>$manager->project_id)
		    )
		    );
		    if(isset($record->project_id)){
		    	echo "{'error':'已有被试答题，需求量表不可删除！'}";
		    	return ;
		    }
		   PmDB::insertInquery($data, $project_id);
		   echo "{'success':'true'}";
           return ;
		}catch(Exception $e){
            if( file_exists($file_path)){
                unlink($file_path);
            }
            $msg = $e->getMessage();
            echo "{'error':'$msg'}";
			return ;
		}
	}
	#删除需求量表
	public function delInqueryAction(){
		try{
			$manager=$this->session->get('Manager');
			if(empty($manager)){
				$this->dataReturn(array('error'=>'用户信息获取失败'));
				return ;
			}
			#判断项目状态是否允许删除，是否有人答题
			$record = InqueryAns::findFirst(
					array(
						'project_id=?1',
						'bind'=>array(1=>$manager->project_id)
					)
			);
			if(isset($record->project_id)){
				$this->dataReturn(array('error'=>'已有被试答题，需求量表不可删除！'));
				return ;
			}
			PmDB::delInquery($manager->project_id);
			$this->dataReturn(array('success'=>'删除成功'));
			return ;
		}catch(Exception $e){
			$this->dataReturn(array('error'=>$e->getMessage()));
			return ;
		}
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
        $this->view->setVar('other',$examinee->other);
    }



   

    public function interviewinfoAction($manager_id){
        $this->view->setTemplateAfter('base2');
        $name = Manager::findFirst($manager_id)->name;
        $this->leftRender($name.' 面 询 完 成 情 况');
        $this->view->setVar('manager_id',$manager_id);
        $interview = InterviewInfo::getInterviewResult($manager_id);
        $data = json_encode($interview,true);
        $this->view->setVar('data',$data);
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
        if ($this->request->isPost() && $this->request->hasFiles()){
            $files = $this->request->getUploadedFiles();
            $filename = "Import-".date("YmdHis");
            $excel = ExcelLoader::getInstance();
            $project_id = $this->session->get('Manager')->project_id;
            $i = 1;
            foreach ($files as $file) {
                $newname = "./upload/".$filename."-".$i.".xls";
                $file->moveTo($newname);
                $ans = $excel->$method($newname, $project_id, $this->db);
                if ($ans != 0) { echo json_encode($ans); return; }
                $i++;
            }
        } else {
         	$this->dataReturn(array('error'=>'wrong to here!'));
         	return ;
        }
    }

	public function listexamineeAction(){
        $project_id = $this->session->get('Manager')->project_id;
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
            $sex = $this->request->getPost('sex', 'string');
            $examinee->sex = ($sex == '女') ? 0 : 1;
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
        // if ($oper == 'add') {
        //     $examinee->name       = $this->request->getPost('name', 'string');
        //     $sex = $this->request->getPost('sex', 'string');
        //     $examinee->sex        = ($sex == '女') ? 0 : 1;
        //     $examinee->password   = $this->request->getPost('password', 'string');
        //     $examinee = Examinee::find(array(
        //     'project_id = :project_id:',
        //     'bind' => array('project_id' => $project_id)));
        //     if(count($examinee) == 0){ 
        //             $last_number = $project_id.'0001';
        //     }else{
        //         $data_num = count($examinee);
        //         $last_number = $examinee[$data_num-1]->number+1;
        //     }
        //     if (!$examinee->save()) {
        //         foreach ($examinee->getMessages() as $message) {
        //             echo $message;
        //         }
        //     }
        // }
    }

    public function listinterviewerAction(){
        $project_id = $this->session->get('Manager')->project_id;
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
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
        $this->interviewData($builder);
    }

    public function updateinterviewerAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password   = $this->request->getPost('password', 'string');
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
        $project_id = $this->session->get('Manager')->project_id;
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
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

    //以excel形式，导出被试人员信息和测试结果
    public function checkAction($examinee_id){        
        $this->view->disable();
        $project_id = $this->session->get('Manager')->project_id;
        $examinee = Examinee::findFirst($examinee_id);
        if ($examinee->state == 0) {
            $this->dataBack(array('error'=>'被试还未答题'));
            return ;
        }else if ($examinee->state > 3) {
            CheckoutExcel::checkoutExcel11($examinee,$project_id);
        }else{
            try{
                $id = $examinee->id;
                BasicScore::handlePapers($id);
                BasicScore::finishedBasic($id);
                FactorScore::handleFactors($id);
                FactorScore::finishedFactor($id);
                IndexScore::handleIndexs($id);
                IndexScore::finishedIndex($id);
                CheckoutExcel::checkoutExcel11($examinee,$project_id);
            }catch(Exception $e){
                $this->dataBack(array('error'=>$e->getMessage()));
                return ;
            }
        }      
    }

    //以word形式，导出被试人员个人报告
    public function resultReportAction($examinee_id){        
        $this->view->disable();
        $project_id = $this->session->get('Manager')->project_id;
        $examinee = Examinee::findFirst($examinee_id);
        $wordExport = new WordExport();
        $wordExport->examineeReport($examinee,$project_id);
    }

   
	

    public function userdivideAction($manager_id){
       $this->view->setVar('manager_id',$manager_id);
       $this->view->setTemplateAfter('base2');
       $this->leftRender('测试人员分配');
    }
    
    public function examineeofmanagerAction($manager_id){
        $row = Interview::find(array(
           'manager_id = :manager_id:',
           'bind' => array('manager_id' => $manager_id)));
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

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $this->view->disable();
        echo json_encode($ans);
    }

    /*
     * 测试人员导出
     */
    public function examineeExportAction(){
        $project_id = $this->session->get('Manager')->project_id;
        $examinee = Examinee::find(array(
            'project_id = :project_id:',
            'bind' => array('project_id' => $project_id)));
        $result = array();
        foreach($examinee as $key => $item){
            $result[$key] = $item;
        }
        $excelExport = new ExcelExport();
        $excelExport->ExamineeExport($result);
    }

    /*
     * 面询人员导出
     */
    public function interviewerExportAction(){
        $result = $this->roleInfo('I');
        $excelExport = new ExcelExport();
        $excelExport->InterviewerExport($result);
    }

    /*
     * 领导导出
     */
    public function leaderExportAction(){
        $result = $this->roleInfo('L');
        $excelExport = new ExcelExport();
        $excelExport->LeaderExport($result);
    }

    public function roleInfo($role){
        $project_id = $this->session->get('Manager')->project_id;
        $interviewer = Manager::find(array(
            'role = :role: AND project_id = :project_id:',
            'bind' => array('role' => $role,'project_id' => $project_id)));
        $result = array();
        foreach($interviewer as $key => $item){
            $result[$key] = $item;
        }
        return $result;
    }

    public function getInterviewResult($manager_id){
        $rows = Interview::find(array(
                'manager_id = :manager_id:',
                'bind' => array('manager_id' => $manager_id)));
        $total = count($rows);
        $term = "remark<>'' AND advantage<>'' AND disadvantage<>'' AND manager_id=:manager_id:";
        $col = Interview::find(array(
                $term,
                'bind' => array('manager_id' => $manager_id)));
        $part_num = count($col);
        $msg = $part_num.'/'.$total;
        return $msg;
    }

    public function interviewData($builder){
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
            $item->degree_of_complete = $this->getInterviewResult($item->id);
            $ans['rows'][$key] = $item;
        }
        echo json_encode($ans);
        $this->view->disable();
    }
    
    function dataReturn($ans){
    	$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
    	$this->view->disable();
    	echo json_encode($ans);
    }
}