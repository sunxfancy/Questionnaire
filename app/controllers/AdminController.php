<?php

class AdminController extends Base
{
    public function initialize(){
        $this->view->setTemplateAfter('base2');
       
    }

    public function indexAction(){
    	$manager = $this->session->get('Manager');
    	if(empty($manager)){
    		$this->response->redirect('/error/index/manager');
    		$this->view->disable();
    	}else{
    		$this->leftRender('项 目 管 理');
    	}
    }

    public function addnewAction(){
    	$manager = $this->session->get('Manager');
    	if(empty($manager)){
    		$this->response->redirect('/error/index/manager');
    		$this->view->disable();
    	}else{
    		$this->leftRender('新 建 项 目');
    	}
    }
    //project name check
    public function namecheckAction(){
    	$this->view->disable();
    	$name = $this->request->getPost('name', 'string');
    	$id =  $this->request->getPost('id', 'int');
    	$project_exits = Project::find(
    			array(
    					"name = :name:",
    					'bind' => array('name'=>$name)
    			)
    	);
    	if(count($project_exits) == 1){
    		#存在
    		foreach($project_exits as $project){
    			if($project->id == $id){
    				$this->dataReturn(array('flag'=>false));
    				return;
    			}
    		}
    		$this->dataReturn(array('flag'=>true));
    		return;
    	}else{
    		$this->dataReturn(array('flag'=>false));
    		return;
    	}
    }
    //manager username check
    public function managerusernamecheckAction(){
    	$this->view->disable();
    	$username = $this->request->getPost('username', 'string');
    	$id =  $this->request->getPost('id', 'int');
    	$manager_exits = Manager::find(
			array(
				"username = :username:",
				'bind' => array('username'=>$username)
			)
		);
    	if(count($manager_exits) == 1 ){
    		#存在
    		foreach($manager_exits as $manager){
    			if($manager->project_id == $id){
    				$this->dataReturn(array('flag'=>false));
    				return;
    			}
    		}
    		$this->dataReturn(array('flag'=>true));
    		return;
    	}else{
    		$this->dataReturn(array('flag'=>false));
    		return;
    	}
    }
    
    
	/**
	 * @usage 添加新项目
	 */
    public function newprojectAction(){
    	$this->view->disable();
		$manager_info = array();
		$manager_info['username'] = $this->request->getPost('pm_username', 'string');
		#在manager表中寻找是否存在该账号的用户
		$manager_exits = Manager::findFirst(
			array(
				"username = :username:",
				'bind' => array('username'=>$manager_info['username'])
			)
		);
		if(isset($manager_exits->username)){
			#经理账号已存在
			$this->dataReturn(array('error'=>'项目经理账号：\''.$manager_info['username'].'\'已存在'));
			return;
		}
		$manager_info['password'] =  $this->request->getPost('pm_password', 'string');
		$manager_info['name'] = $this->request->getPost('pm_name', 'string');
		#添加角色项
		$manager_info['role'] = 'P';
		
    	$project_info = array(); 
    	$project_info['name'] = $this->request->getPost('project_name', 'string');
    	#2015-9-10目前数据库中没有对project name 做索引
		$project_exits = Project::findFirst(
    		array(
    			"name = :name:",
    			'bind' => array('name'=>$project_info['name'])
    		)
		);
		if(isset($project_exits->name)){
			#项目名称已经存在
			$this->dataReturn(array('error'=>'项目名称：\''.$project_info['name'].'\'已存在'));
			return;
		}
		$project_info['begintime'] = $this->request->getPost('begintime', 'string');
		$project_info['endtime'] = $this->request->getPost('endtime', 'string');
		$project_info['description'] = $this->request->getPost('description', 'string');
		
		#准备写入到库
		#第一步：生成project_id;
        $date = date('y');
        $projects = Project::find();
        #项目表为空
        if (count($projects)  == 0) {
            $project_id = $date.'01';
        }else{
        	#项目表不为空
            $project_already_number = 0;
            foreach ($projects as $project_record) {
                #取出今年的添加的项目
                $project_record_id = intval($project_record->id);
                #舍去小数部分取整,取出年份
                $year = floor($project_record_id/100);
                #求余 获取编号
                $number = $project_record_id%100;
                if($year == $date ){
                	#获取当年份的最大编号
                	$project_already_number = $project_already_number>=$number ? $project_already_number : $number;
                }
            }
            if ($project_already_number > 0) {
                $project_id = $date.sprintf("%02d",$project_already_number+1);
                
            }else{
                $project_id = $date.'01';
            }
        }
        $project_info['id'] = $project_id;
        foreach($manager_info as $key=>$value){
        	if(empty($value)){
        		$this->dataReturn(array('error'=>'数据项不能为空'.print_r($manager_info, true)));
        		return;
        	}
        }
        foreach($project_info as $key=>$value){
        	if(empty($value) && $key !='description'){
        		$this->dataReturn(array('error'=>'数据项不能为空'.print_r($project_info, true)));
        		return;
        	}
        }
        #获取到代码生成的project_id;
        #确保manger表和project表都完成
        try{
        	AdminDB::addProject($project_info, $manager_info);
        }catch(Exception $e){
        	$this->dataReturn(array('error'=>'项目创建失败'));
        	return;
        }
        $this->dataReturn(array('flag'=>true));
        return ;
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
	/**
	 * @usage jqgrid 显示
	 */
    public function listAction(){
    	$this->view->disable();
    	$page = $this->request->get('page');
    	$rows = $this->request->get('rows');
    	$offset = $rows*($page-1);
    	$limit = $rows;
    	$sidx = $this->request->getQuery('sidx','string');
    	$sord = $this->request->getQuery('sord','string');
    	if ($sidx != null)
    		$sort = $sidx;
    	else{
    		$sort = 'id';
    		$sord = 'desc';
    	}
    	if ($sord != null){
    		$sort = $sort.' '.$sord;
    	}
    	//default get
    	$search_state = $this->request->get('_search');
    	if($search_state == 'false'){
        $result = $this->modelsManager->createBuilder()
                                       ->columns(array(
                                        'Project.id as id', 
                                       	'Project.begintime as begintime',
                                        'Project.endtime as endtime', 
                                       	'Project.description as description',
                                        'Project.name as name', 
                                       	'Manager.name as manager_name', 
                                        'Manager.username as manager_username', 
                                       	'Manager.password as manager_password',
                                        'COUNT(Examinee.id) as user_count' ))
                                       ->from('Project')
                                       ->join('Manager', 'Project.manager_id = Manager.id')
                                       ->leftJoin('Examinee', 'Project.id = Examinee.project_id ')    
                                       ->groupBy('Examinee.id')
                                       ->limit($limit,$offset)
                                       ->orderBy($sort)
                                       ->getQuery()
                                       ->execute();
        $rtn_array = array();
        $count = Project::count();
        $rtn_array['total'] = ceil($count/$rows);
        $rtn_array['records'] = $count;
        $rtn_array['rows'] = array();
        foreach($result as $value){
        	$rtn_array['rows'][] = $value;
        }    
        $rtn_array['page'] = $page;  
        $this->dataReturn($rtn_array);                
        return;
    	}else{
    	//处理search情况
    		$search_field =  $this->request->get('searchField');
    		$search_string =  $this->request->get('searchString');
    		$search_oper = $this->request->get('searchOper');
    		#分情况讨论
    		if( ($search_field == 'id' ||  $search_field == 'manager_username'  )&& $search_oper == 'eq'){
    			//equal
    			$oper = '=';
    			if ($search_field == 'id'){
    				$field = 'Project.'.$search_field;
    			}else if ( $search_field == 'manager_username' ){
    				$field = 'Manager.username';
    			}else{
    				
    			}
    			$result = $this->modelsManager->createBuilder()
    					 ->columns(array(
    					'Project.id as id',
    					'Project.begintime as begintime',
    					'Project.endtime as endtime',
    					'Project.description as description',
    					'Project.name as name',
    					'Manager.name as manager_name',
    					'Manager.username as manager_username',
    					'Manager.password as manager_password',    					
    					'COUNT(Examinee.id) as user_count' ))
    					 ->from('Project')
    			         ->join('Manager', "Project.manager_id = Manager.id AND $field $oper $search_string")
    			         ->leftJoin('Examinee', 'Project.id = Examinee.project_id ')    
    			         ->groupBy('Examinee.id')
    			         ->limit($limit,$offset)
    			         ->orderBy($sort)
    			         ->getQuery()
    			         ->execute();
    			
    		}else if ($search_oper == 'eq' && ($search_field == 'name' || $search_field=='manager_name' )){
    			$oper = 'LIKE';
    			$value = '%'.$search_string.'%';
    			if( $search_field == 'name' ){
    				$field = 'Project.'.$search_field;
    			}else if ( $search_field =='manager_name' ){
    				$field = 'Manager.name';
    			}else {
    				//
    			}
    			$result = $this->modelsManager->createBuilder()
    					->columns(array(
    					'Project.id as id',
    					'Project.begintime as begintime',
    					'Project.endtime as endtime',
    					'Project.description as description',
    					'Project.name as name',
    					'Manager.name as manager_name',
    					'Manager.username as manager_username',
    					'Manager.password as manager_password',
    					'COUNT(Examinee.id) as user_count' ))
    					 ->from('Project')
    			    	 ->join('Manager', "Project.manager_id = Manager.id AND $field $oper '$value'")
    			         ->leftJoin('Examinee', 'Project.id = Examinee.project_id ')    
    			         ->groupBy('Examinee.id')
    			         ->limit($limit,$offset)
    			    	 ->orderBy($sort)
    			    	 ->getQuery()
    			    	 ->execute();
    		}else if ( $search_field == 'user_count'){
    			$oper = '';
    			switch($search_oper){
    				case 'eq' : $oper = '='; break;
    				case 'lt' : $oper = '<'; break;
    				case 'le' : $oper = '<='; break;
    				case 'gt' : $oper = '>'; break;
    				case 'ge' : $oper = '>='; break;
    			}
    			$result = $this->modelsManager->createBuilder()
    			->columns(array(
    					'Project.id as id',
    					'Project.begintime as begintime',
    					'Project.endtime as endtime',
    					'Project.description as description',
    					'Project.name as name',
    					'Manager.name as manager_name',
    					'Manager.username as manager_username',
    					'Manager.password as manager_password',
    					'COUNT(Examinee.id) as user_count' ))
    					->from('Project')
    			    	->join('Manager', "Project.manager_id = Manager.id")
    			    	->leftJoin('Examinee', 'Project.id = Examinee.project_id ')    
    			    	->groupBy('Examinee.id')
    			    	->having("$search_field $oper $search_string")	
    			        ->limit($limit,$offset)
    			    	->orderBy($sort)
    			        ->getQuery()
    			    	->execute();
    			
    		}else if ( $search_field == 'begintime' || $search_field == 'endtime'){
    			$oper = '';
    			if($search_oper == 'bw'){
    				$oper = '>=';
    			}else if ($search_oper == 'ew'){
    				$oper = '<=';
    			}
    			$field = 'Project.'.$search_field;
    			$result = $this->modelsManager->createBuilder()
    					->columns(array(
    					'Project.id as id',
    					'Project.begintime as begintime',
    					'Project.endtime as endtime',
    					'Project.description as description',
    					'Project.name as name',
    					'Manager.name as manager_name',
    					'Manager.username as manager_username',
    					'Manager.password as manager_password',
    					'COUNT(Examinee.id) as user_count' ))
    					->from('Project')
    			    	->join('Manager', "Project.manager_id = Manager.id AND $field $oper '$search_string'")
    			    	->leftJoin('Examinee', 'Project.id = Examinee.project_id ')    
    			    	->groupBy('Examinee.id')
    			    	->limit($limit,$offset)
    			    	->orderBy($sort)
    			    	->getQuery()
    			    	->execute();
    		}else{
    			//waiting add...
    		}
    		$rtn_array = array();
    		$count = count($result);
    		$rtn_array['total'] = ceil($count/$rows);
    		$rtn_array['records'] = $count;
    		$rtn_array['rows'] = array();
    		foreach($result as $value){
    			$rtn_array['rows'][] = $value;
    		}
    		$rtn_array['page'] = $page;
    		$this->dataReturn($rtn_array);
    		return;
    	}
    }

    public function updateAction(){
    	$this->view->disable();
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
        	//edit
        	//修改之前应该判断数据库中是否已经存在记录
            $id = $this->request->getPost('id', 'int');
            $project = Project::findFirst($id);
            $project->name      = $this->request->getPost('name', 'string');
            #项目开始时间不可变更
//             $project->begintime = $this->request->getPost('begintime', 'string');
            $project->endtime   = $this->request->getPost('endtime', 'string');
            $manager = Manager::findFirst(array(
                'project_id=?0',
                'bind'=>array($id)));
            $manager->name     = $this->request->getPost('manager_name', 'string');
            $manager->username = $this->request->getPost('manager_username', 'string');
            AdminDB::updateManager($manager);
            AdminDB::updateProject($project);
        }else if($oper == 'del' ){
        	//del
        	//需要添加判断是否能被删除
            $id = $this->request->getPost('id', 'int');
            AdminDB::delproject($id);
        }else{
        	
        }
    }
    
    
    
    public function dataReturn($ans){
    	$this->view->disable();
    	$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
    	echo json_encode($ans);
    	
    }

}

