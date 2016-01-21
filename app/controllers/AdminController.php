<?php

class AdminController extends Base
{
    public function initialize(){
    	parent::initialize();
        $this->view->setTemplateAfter('base2');     
    }

    public function indexAction(){
    	$manager = $this->session->get('Manager');
    	if(empty($manager)){
    		$this->response->redirect('/wrong/index/manager');
    		$this->view->disable();
    	}else{
    		$this->leftRender('项 目 管 理');
    	}
    }

    public function addnewAction(){
    	$manager = $this->session->get('Manager');
    	if(empty($manager)){
    		$this->response->redirect('/wrong/index/manager');
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
		$project_info['begintime'] = $this->request->getPost('begintime', 'string');
		$project_info['endtime'] = $this->request->getPost('endtime', 'string');
		$project_info['description'] = $this->request->getPost('description', 'string');
		#时间检查
		if(strtotime($project_info['begintime']) >= strtotime($project_info['endtime']) ){
			$this->dataReturn(array('error'=>'项目结束时间不得早于开始时间'));
			return;
		}
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
            	#当年项目数不能超100，否则报错；；
            	if($project_already_number == 99 ){
            		$this->dataReturn(array('error'=>'本年度项目数量已达99个，请联系管理员！'));
            		return;
            	}
                $project_id = $date.sprintf("%02d",$project_already_number+1);
                
            }else{
                $project_id = $date.'01';
            }
        }
        $project_info['id'] = $project_id;
        //添加项目状态项
        $project_info['state'] = 0;
        foreach($manager_info as $key=>$value){
        	if(empty($value)){
        		$this->dataReturn(array('error'=>'数据项不能为空'.print_r($manager_info, true)));
        		return;
        	}
        }
        foreach($project_info as $key=>$value){
        	if($key == 'description' ||  $key == 'state'  ){
        		continue;
        	}
        	if(empty($value) ) {
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

    public function detailAction($project_id) { 
    	$manager = $this->session->get('Manager');
    	if(empty($manager)){
    		$this->response->redirect('/wrong/index/manager');
    		$this->view->disable();
    	}else{
    		$this->leftRender('项 目 详 情');
    	}  
    }

    public function getdetailAction(){
    	$this->view->disable();
    	$id = $this->request->getPost('id', 'int');	
    	$project = Project::findFirst($id);
    	if(!isset($project->id)){
    		$this->dataReturn(array('error'=>'该编号下的项目不存在，请返回刷新!'));
    		return ;
    	}
    	$ans_array = array();
    	$ans_array['project_name'] = $project->name;
    	$ans_array['begintime']    = $project->begintime;
    	$ans_array['endtime']      = $project->endtime;    
    	//添加绿色通道与正常被试判断	
        $examinees = Examinee::find(array(
            'project_id=?1 AND type= 0',
            'bind'=>array(1=>$id)));
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
                                       ->join('Manager', 'Project.manager_id = Manager.id  ')
                                       //添加被试与绿色通道判断
                                       ->leftJoin('Examinee', 'Project.id = Examinee.project_id AND Examinee.type = 0')    
                                       ->groupBy('Project.id')
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
    		#先取出最特殊情况
    		if ( $search_field == 'user_count'){
    			$oper = '';
    			switch($search_oper){
    				case 'eq' : $oper = '='; break;
    				case 'lt' : $oper = '<'; break;
    				case 'le' : $oper = '<='; break;
    				case 'gt' : $oper = '>'; break;
    				case 'ge' : $oper = '>='; break;
    			}
    			$filed = 'COUNT(Examinee.id)';
    			$value = $search_string;
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
    		    //添加被试与绿色通道判断
                ->leftJoin('Examinee', 'Project.id = Examinee.project_id AND Examinee.type = 0')   
    		    ->groupBy('Project.id')
    		    ->having("$filed $oper $value")	
    		    			        //->limit($limit,$offset)
    		    ->orderBy($sort)
    		    ->getQuery()
    		    ->execute();
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
    		if( ($search_field == 'id' ||  $search_field == 'manager_username'  )){
    			//equal
    			$oper = '=';
    			if ($search_field == 'id'){
    				$field = 'Project.'.$search_field;
    			}else if ( $search_field == 'manager_username' ){
    				$field = 'Manager.username';
    			}else{
    				//
    			}
    			$value = "'$search_string'";
    			
    		}else if ($search_field == 'name' || $search_field=='manager_name' ){
    			$oper = 'LIKE';
    			
    			if( $search_field == 'name' ){
    				$field = 'Project.'.$search_field;
    			}else if ( $search_field =='manager_name' ){
    				$field = 'Manager.name';
    			}else {
    				//
    			}
    			$value = "'%$search_string%'";
    		}else if ( $search_field == 'begintime' || $search_field == 'endtime'){
    			$oper = '';
    			if($search_oper == 'bw'){
    				$oper = '>=';
    			}else if ($search_oper == 'ew'){
    				$oper = '<=';
    			}
    			$field = 'Project.'.$search_field;
    			$value = "'$search_string'";	
    		}else{
    			//waiting add...
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
    		    	->join('Manager', "Project.manager_id = Manager.id AND $field $oper $value")
    		    	 //添加被试与绿色通道判断
                    ->leftJoin('Examinee', 'Project.id = Examinee.project_id AND Examinee.type = 0')   
    		    	->groupBy('Project.id')
    		    			    	//->limit($limit,$offset)
    		    	->orderBy($sort)
    		    	->getQuery()
    		    	->execute();
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
        	//修改之前应该判断数据库中是否已经存在记录 -- 目前在前端进行判定2015-9-12
            $id = $this->request->getPost('id', 'int');
            $project = Project::findFirst($id);
            $project->name      = $this->request->getPost('name', 'string');
            #项目开始时间不可变更
            $project->begintime = $this->request->getPost('begintime', 'string');
            $project->endtime   = $this->request->getPost('endtime', 'string');
            $project->description = $this->request->getPost('description', 'string');
            $manager = Manager::findFirst(array(
                'project_id=?0',
                'bind'=>array($id)));
            $manager->name     = $this->request->getPost('manager_name', 'string');
            $manager->username = $this->request->getPost('manager_username', 'string');
            $manager->password = $this->request->getPost('manager_password', 'string');
            #时间检查
            if(strtotime( $project->begintime) >= strtotime( $project->endtime ) ){
            	$this->dataReturn(array('error'=>'项目结束时间与开始时间冲突'));
            	return;
            }
            try{
            	AdminDB::updateManager($manager);
            	AdminDB::updateProject($project);
            }catch(Exception $e){
            	$this->dataReturn( array('error'=>'项目信息更新失败') );
            	return;
            }
            $this->dataReturn(array('flag'=>true));
            return;
        }else if($oper == 'del' ){
        	//del
        	//需要添加判断是否能被删除 --目前还未添加相应的判定
        
            $id = $this->request->getPost('id', 'int');
            $project_info = Project::findFirst($id);
          	if ( !isset( $project_info -> id ) ) {
          		$this->dataReturn(array('error'=>'项目编号不存在'));
          		return;
          	}else{
          		#判断项目状态，如果不是项目的初始状态则禁止删除
          		if($project_info->state != 0 ){
          			$this->dataReturn(array('error'=>'项目经理已配置了项目，不能被删除'));
          			return;
          		}else{
          			try{
          				AdminDB::delproject($id);
          			}catch(Exception $e){
          				$this->dataReturn(array('error'=>'项目删除失败'));
          				return;
          			}
          			$this->dataReturn(array('flag'=>true));
          			return;
          		}
          		
          	}
            
         
        }else{
        	//
        }
    }
    
    
    
    public function dataReturn($ans){
    	$this->view->disable();
    	$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
    	echo json_encode($ans);
    }

}

