<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class PmController extends Base
{
    public function initialize(){
        parent::initialize();
        set_time_limit(0);
    }
	#主页面, 在主页面生成相关跳转
    public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('项 目 管 理 平 台');
        $page = $this->request->getPost('page', 'int');
        if (empty($page)){
        	$page = 0;
        }
        #被试登录错误
        $this->view->setVar('page', $page);
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
    	//项目详情只显示被试
        $examinees = Examinee::find(array(
            'project_id=?1 AND type = 0',
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
    		$result = array();
    		$result['state'] = false;
    		$result['ans'] = null;
    		$project_detail = ProjectDetail::findFirst(array(
    				"project_id=?1",
    				"bind"=>array(1=>$manager->project_id)));
    		if(!isset($project_detail->project_id)){
    			$this->dataReturn(array('success'=>$result));
    			return ;
    		}  		
    		$module_name = array();
    		$module_names = $project_detail->module_names;
    		$module_name = explode(',', $module_names);
    		if (empty($module_name)){
    			$this->dataReturn(array('success'=>$result));
    			return ;
    		}
    		$ans= array();
    		foreach($module_name as $name){
    			$module = Module::findFirst(array(
    							'name=?1',
    							'bind'=>array(1=>$name)));
    			$ans[] = $module->chs_name;
    		}
    		$result['state'] = true;
    		$result['ans'] = implode('|', $ans);
    		$this->dataReturn(array("success"=>$result));
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
    	$result = $this->modelsManager->createBuilder()
                                       ->columns(array(
                                        'COUNT(Examinee.id) as count' ))
                                       ->from('Examinee')    
                                       ->join('QuestionAns', 'Examinee.id = QuestionAns.examinee_id AND Examinee.project_id = '.$project_id)
                                       ->getQuery()
                                       ->execute();
        $result = $result->toArray();
        if($result[0]['count'] > 0 ){
        	$this->dataReturn(array('error'=>'已有被试答题，项目模块不可再修改！')); 
        	return ;
        }
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
   	#删除题目配置
   	public function delmoduleAction(){
   		try{
   			$manager=$this->session->get('Manager');
   			if(empty($manager)){
   				$this->dataReturn(array('error'=>'用户信息获取失败'));
   				return ;
   			}
   			$project_id = $manager->project_id;
	   		#添加项目判断，是否有被试答题，若有答题则不能更新配置的模块
	    	$result = $this->modelsManager->createBuilder()
	                                       ->columns(array(
	                                        'COUNT(Examinee.id) as count' ))
	                                       ->from('Examinee')    
	                                       ->join('QuestionAns', 'Examinee.id = QuestionAns.examinee_id AND Examinee.project_id = '.$project_id)
	                                       ->getQuery()
	                                       ->execute();
	        $result = $result->toArray();
	        if($result[0]['count'] > 0 ){
	        	$this->dataReturn(array('error'=>'已有被试答题，项目模块不可再修改！')); 
	        	return ;
	        }
   			PmDB::delModule($manager->project_id);
   			$this->dataReturn(array('success'=>'删除成功'));
   			return ;
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
			$inquery_detail = InqueryQuestion::find(array(
				'project_id=?1',
    			'bind'=>array(1=>$manager->project_id)));
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
		    #判断项目状态是否更新需求量表，是否有人答题
			$result = $this->modelsManager->createBuilder()
			->columns(array(
			'COUNT(Examinee.id) as count' ))
			->from('Examinee')
			->join('InqueryAns', 'Examinee.id = InqueryAns.examinee_id AND Examinee.project_id = '.$project_id)
			->getQuery()
			->execute();
			$result = $result->toArray();
			if($result[0]['count'] > 0 ){
				echo "{'error':'已有被试答题，需求量表不可再修改！'}";
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
			#添加项目判断，是否有被试答题，若有答题则不能更新配置的模块
			$project_id = $manager->project_id;
			$result = $this->modelsManager->createBuilder()
			->columns(array(
			'COUNT(Examinee.id) as count' ))
			->from('Examinee')
			->join('InqueryAns', 'Examinee.id = InqueryAns.examinee_id AND Examinee.project_id = '.$project_id)
			->getQuery()
			->execute();
			$result = $result->toArray();
			if($result[0]['count'] > 0 ){
				$this->dataReturn(array('error'=>'已有被试答题，需求量表不可再修改！'));
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
	#被试信息页面
	public function examineeAction(){
		# code...
	}
	#获取被试信息页面 & 绿色通道页面信息获取
	public function listexamineeAction($type = 0 ){
		$this->view->disable();
		$manager = $this->session->get('Manager');
		if (empty($manager)){
			$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
			return ;
		}
		$project_id = $manager->project_id;
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
					'Examinee.id as id',
					'Examinee.number as number',
					'Examinee.name as name',
					'Examinee.sex as sex',
					'Examinee.password as password',
					'Examinee.last_login as last_login',
					'Examinee.state as state',
					))
				->from('Examinee')
				//添加类型判断
            	->where('Examinee.project_id = '.$project_id.' AND Examinee.type = '.$type )
            	->limit($limit,$offset)
            	->orderBy($sort)
            	->getQuery()
            	->execute();
		        $rtn_array = array();
		         $examinees = Examinee::find(array(
            	'project_id=?1 AND type=?2',
           		'bind'=>array(1=>$project_id, 2=>$type)));
        		//获取该项目下答题的总人数
        		$count =  count($examinees);
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
			$filed = 'Examinee.'.$search_field;
			if ($search_oper == 'eq'){
				if ($search_field == 'name'){
					$oper = 'LIKE';
					$value = "'%$search_string%'";
				}else if ($search_field == 'number' || $search_field == 'sex' ){
					$oper = '=';
					$value = "'$search_string'";
				}else if ( $search_field == 'exam_state' || $search_field == 'interview_state'){
			 		$filed = 'Examinee.state';
					if ($search_string == 'true'){
			 			$oper = '>=';
			 		}else{
			 			$oper = '<';
			 		}
			 		if ($search_field == 'exam_state'){
			 			$value = 1;
			 		}else {
			 			$value = 4;
			 		}
			}
			}else if ( $search_oper == 'bw' ||$search_oper == 'ew' ){
				if (  $search_field == 'last_login' ){
					$value = "'$search_string'";
				}
				if($search_oper == 'bw'){
					$oper = '>=';
				}else if ($search_oper == 'ew'){
					$oper = '<=';
				}
			}else {
				//add ...
			}
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Examinee.id as id',
					'Examinee.number as number',
					'Examinee.name as name',
					'Examinee.sex as sex',
					'Examinee.password as password',
					'Examinee.last_login as last_login',
					'Examinee.state as state',
			))
			->from('Examinee')
			->where('Examinee.project_id = '.$project_id.' AND Examinee.type = '.$type." AND $filed $oper $value")
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
	#更新被试信息页面
	public function updateexamineeAction($type = 0 ){
		$this->view->disable();
		$oper = $this->request->getPost('oper', 'string');
		if ( $oper == 'add'){
			$manager=$this->session->get('Manager');
			if(empty($manager)){
				echo "{'error':'用户信息获取失败，请重新登陆'}";
				return ;
			}
			$project_id = $manager->project_id;
			$data = array();
			$data[0]['name']       = $this->request->getPost('name', 'string');
			$data[0]['sex']		   = $this->request->getPost('sex', 'int');
			//-------------start  为页面添加的人员完善信息
			$data[0]['native'] = '';
			$data[0]['education'] = ''; 
			$data[0]['degree'] = '';
			$data[0]['birthday'] = '1970-01-01';
			$data[0]['politics']=  '';
			$data[0]['professional']=  '';
			$data[0]['team']= '';
			$data[0]['employer']=  '';
			$data[0]['unit']= '';
			$data[0]['duty']=  '';
			$tmp_array = array();
			$tmp_array['education'] = array();
			$tmp_array['work'] = array();
			$data[0]['other'] = $tmp_array;
			$tmp_array_2 = array();
			foreach($data[0] as $key=>$value){
				if ($key == 'sex'){
					$value = $value == 1 ?'男':'女';
				}
				$tmp_array_2[$key] = $value;
			}
			$data[0]['init_data'] = json_encode($tmp_array_2, JSON_UNESCAPED_UNICODE);
			$data[0]['other'] = json_encode($tmp_array, JSON_UNESCAPED_UNICODE);
			//-------------end
			try{
				PmDB::insertExaminee($data, $project_id, $type);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录插入成功！'));
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
			
		}else if ($oper == 'edit') {
			//edit
            $id = $this->request->getPost('id', 'int');
            $examinee = Examinee::findFirst($id);
          	$examinee->name       = $this->request->getPost('name', 'string');
			$examinee->sex        = $this->request->getPost('sex', 'int');
			$examinee->password   = $this->request->getPost('password', 'string');
            try{
            	PmDB::updateExaminee($examinee);
            }catch(Exception $e){
            	$this->dataReturn( array('error'=>'记录更新失败') );
            	return;
            }
            $this->dataReturn(array('flag'=>true));
            return;
		}
		else if ($oper == 'del') {
			#删除可选择多项
			$ids = $this->request->getPost('id', 'string');
			#删除未加限制
			$id_array =explode(',', $ids);
			$examinees = $this->modelsManager->createBuilder()
			->from('Examinee')
			->inWhere('id', $id_array)
			->getQuery()
			->execute();
			try{
				PmDB::deleteExaminee($examinees);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录删除失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}else {
			//add ...
		}
	}
	#上传被试信息列表 & 绿色通道上传
	public function uploadexamineeAction($type = 0){
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
            $data = $excelHander->handleExaminee();
            if(file_exists($file_path)) unlink($file_path);
            $manager=$this->session->get('Manager');
            if(empty($manager)){
            	echo "{'error':'用户信息获取失败，请重新登陆'}";
            	return ;
            }
           
            $project_id = $manager->project_id;
		    PmDB::insertExaminee($data, $project_id, $type);
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
	#个人信息查看页面
	public function infoAction($examinee_id,$type){
		$this->view->setTemplateAfter('base2');
		$this->leftRender('个 人 信 息 查 看');
		$this->view->setVar('examinee_id' , $examinee_id);
		$this->view->setVar('type', $type);
	}
	#个人信息显示页面详情
	public function listinfoAction(){
		$examinee_id = $this->request->getPost('examinee_id', 'int');
		if (empty($examinee_id)){
			$this->dataReturn(array('error'=>'查询的id号为空，请返回'));
			return ;
		}
		$examinee_info = Examinee::findFirst($examinee_id);
		if(!isset($examinee_info->id)){
			$this->dataReturn(array('error'=>'不存在的用户id号，请返回'));
			return ;
		}
			$question = array();
    		$question['name'] 		 = $examinee_info->name;
    		$question['sex']  		 = $examinee_info->sex == 1 ? '男' : '女';
    		$question['education']    = $examinee_info->education;
		 	$question['degree'] 	 = $examinee_info->degree;
		 	$question['birthday']    = $examinee_info->birthday;
			$question['politics']    = $examinee_info->politics;
			$question['native']      = $examinee_info->native;
			$question['professional']= $examinee_info->professional;
			$question['employer']    = $examinee_info->employer;
			$question['unit']        = $examinee_info->unit;
			$question['duty']        = $examinee_info->duty;
			$question['team']        = $examinee_info->team;
			$others                  = json_decode($examinee_info->other, true);
			$question['educations'] = $others['education'];
			$question['works'] = $others['work'];
    		//用户信息修改判断
    		$init_data = json_decode($examinee_info->init_data, true);
    		$diff_comm_array = array();
    		$diff_other_array = array();
    		$diff_other_array['education'] = array();
    		$diff_other_array['work'] = array();
    		if (!empty($init_data)){
    			foreach($init_data as $key=>$svalue){	
    				if ($key == 'other'){
    					if (!isset($svalue['education'])){
    						$svalue['education'] = array();
    					}
    					if (!isset($svalue['work'])){
    						$svalue['work'] = array();
    					}  
    					$tmp_edu_init = array() ; 
    					$tmp_wor_init = array() ;
    					$this->foo($svalue['education'],$tmp_edu_init);
    					$this->foo($svalue['work'], $tmp_wor_init);
    					$tmp_edu_new = array();
    					$tmp_wor_new = array();
    					$this->foo($question['educations'] , $tmp_edu_new);
    					$this->foo($question['works'] , $tmp_wor_new);
    					$diff_1 = array_diff($tmp_edu_init, $tmp_edu_new) || array_diff($tmp_edu_new,$tmp_edu_init) ;
    					$diff_2 = array_diff($tmp_wor_init, $tmp_wor_new) || array_diff($tmp_wor_new,$tmp_wor_init);
    					if (!empty($diff_1)){
    						$tmp = array();
    						$tmp['id'] = 'eduactions';
    						$tmp['value'] = $tmp_edu_init;
    						$tmp['svalue'] = $tmp_edu_new;
    						$diff_other_array['education'] = $tmp;	
    					}
    					if (!empty($diff_2)){
    						$tmp = array();
    						$tmp['id'] = 'works';
    						$tmp['value'] = $tmp_wor_init;
    						$tmp['svalue'] = $tmp_wor_new;
    						$diff_other_array['work']= $tmp;
    					}
    				}else {
    					if ($init_data[$key] != $question[$key]){
    						$tmp = array();
    						$tmp['id'] = $key;
    						$tmp['value'] = $init_data[$key];
    						$tmp['svalue'] = $question[$key];
    						$diff_comm_array[] = $tmp;
    					}
    				}	
    			}
    		}
    		$question['diff_comm'] = $diff_comm_array;
    		$question['diff_other'] = $diff_other_array;
    		#添加用户是否修改相应信息的判断以及修改的结果予以反馈
			$this->dataReturn(array('success'=>$question));
			return;
	}
	#辅助方法 --降维
	private function foo($arr, &$rt) {
		if (is_array($arr)) {
			foreach ($arr as $v) {
				if (is_array($v)) {
					$this->foo($v, $rt);
				} else {
					$rt[] = $v;
				}
			}
		}
		return $rt;
	}
	#被试信息导出页面
	public function examineedownloadAction(){
		$this->view->setTemplateAfter('base2');
		$this->leftRender('相 关 数 据 处 理');
	}
    #获取被试算分的状态
    public function getreportstateAction(){
        $this->view->disable();
        $manager = $this->session->get('Manager');
        if (empty($manager)){
            $this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
            return ;
        }
        // 获取项目下的未完成基础算分的人员名单 ---- 未完成
        $examinees = $this->modelsManager->createBuilder()
        ->columns(array(
        		'id'
        ))
        ->from('Examinee')
        ->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 AND Examinee.state < 4 ')
        ->getQuery()
        ->execute()
        ->toArray();
        $not_finish_calculate = array();
        foreach($examinees as $examinee_record){
        	$not_finish_calculate[] = $examinee_record['id'];
        }
        if (empty($not_finish_calculate)){
        	$this->dataReturn(array('success'=>'true'));
        	return ;
        }else {
        	$this->dataReturn(array('success'=>'false'));
        	return ;
        }
    }
    #所有被试人员进行算分处理 ----一键算分
    public function onekeycalculateAction(){
        $this->view->disable();
        $manager = $this->session->get('Manager');
        if (empty($manager)){
            $this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
            return ;
        }
        // 获取项目下的人员名单 ----所有
        $examinees = $this->modelsManager->createBuilder()
        ->columns(array(
        		'id', 'state', 'number', 'name'
        ))
        ->from('Examinee')
        ->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 ')
        ->getQuery()
        ->execute()
        ->toArray();
        $not_exam = array(); //未参加考试人员
//         $not_finish_calculate = array(); //未算分完成人员
        $calcual_error = array(); // 在算分过程中出现错误的人员
        foreach ( $examinees as $examinee_record ){
        	if ($examinee_record['state'] == 0 ){
        		$not_exam[] = $examinee_record['number'].'-'.$examinee_record['name'].'-还未参加测评';
        	}else if ($examinee_record['state'] < 4 ){
        		try{
        			BasicScore::handlePapers($examinee_record['id']);
        			BasicScore::finishedBasic($examinee_record['id']);
        			FactorScore::handleFactors($examinee_record['id']);
        			FactorScore::finishedFactor($examinee_record['id']);
        			IndexScore::handleIndexs($examinee_record['id']);
        			IndexScore::finishedIndex($examinee_record['id']);
        		}catch(Exception $e){
        			$calcual_error[] =  $examinee_record['number'].'-'.$examinee_record['name'].'-算分过程中失败，原因：'.$e->getMessage();
        		}
                
        	}else{
        		//...
        	}
        }
        //先反馈回未参与考试的人员
        if (!empty($not_exam)){
        	$this->dataReturn(array('error'=>$not_exam));
        	return ;
        }
        //后反馈回算分失败的人员
        if (!empty($calcual_error)){
        	$this->dataReturn(array('error'=>$calcual_error));
        	return ;
        }
        $this->dataReturn(array('success'=>'true'));
        return ;
    }    
	#导出被试信息列表
	public function examineeexportAction(){
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

    #绿色通道人员
    public function greenchannelAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('绿 色 通 道');
    }
	#面巡专家界面
	public function interviewerAction(){
		# code...
	}
	#获取面巡专家列表  ---- 面巡专家显示的面询人数为正常被试+绿色通道
	public function listinterviewerAction(){		
		$this->view->disable();
		$manager = $this->session->get('Manager');
		if (empty($manager)){
			$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
			return ;
		}
		$project_id = $manager->project_id;
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
					'Manager.id as id',
					'Manager.username as username',
					'Manager.name as name',
					'Manager.password as password',
					'Manager.last_login as last_login',
					'count(Interview.examinee_id) as count'
			))
			->from('Manager')
			->where('Manager.project_id = '.$project_id." AND Manager.role = 'I'" )
			->leftJoin('Interview', "Interview.manager_id = Manager.id" )
			->groupBy('Manager.id')
			->limit($limit,$offset)
			->orderBy($sort)
			->getQuery()
			->execute();
			$result = $result->toArray();
			foreach($result as &$value){
				 $term = "remark<>'' AND advantage<>'' AND disadvantage<>'' AND manager_id=:manager_id:";
        		 $interview_info = Interview::find(array(
                		$term,
                		'bind' => array('manager_id' => $value['id'])));
        		 $finish = count($interview_info);
        		 $value['count'] = $finish.'/'.$value['count'];
			}
			$rtn_array = array();
			$interviewers = Manager::find(array(
					'project_id=?1 AND role = ?2',
					'bind'=>array(1=>$project_id, 2=>'I')));
			//获取该项目下答题的总人数
			$count =  count($interviewers);
			$rtn_array['total'] = ceil($count/$rows);
			$rtn_array['records'] = $count;
			$rtn_array['rows'] = $result;
			$rtn_array['page'] = $page;
			$this->dataReturn($rtn_array);
			return;
		}else{
			//处理search情况
			$search_field =  $this->request->get('searchField');
			$search_string =  $this->request->get('searchString');
			$search_oper = $this->request->get('searchOper');
			if ($search_field == 'username'){
				$filed = 'Manager.'.$search_field;
				$oper = '=';
				$value = $search_string;
			}else if ($search_field == 'name'){
				$filed = 'Manager.'.$search_field;
				$oper = 'LIKE';
				$value = '%'.$search_string.'%';
			}else if ($search_field == 'last_login'){
				$filed = 'Manager.'.$search_field;
				if($search_oper == 'bw'){
    				$oper = '>=';
    			}else if ($search_oper == 'ew'){
    				$oper = '<=';
    			}
    			$value = $search_string;
			}else {
				//..
				return;
			}
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Manager.id as id',
					'Manager.username as username',
					'Manager.name as name',
					'Manager.password as password',
					'Manager.last_login as last_login',
					'count(Interview.examinee_id) as count'
			))
			->from('Manager')
			->where('Manager.project_id = '.$project_id." AND Manager.role = 'I' AND $filed $oper '$value'" )
			->leftJoin('Interview', "Interview.manager_id = Manager.id" )
			->groupBy('Manager.id')
			->limit($limit,$offset)
			->orderBy($sort)
			->getQuery()
			->execute();
			$result = $result->toArray();
			foreach($result as &$value){
				$term = "remark<>'' AND advantage<>'' AND disadvantage<>'' AND manager_id=:manager_id:";
				$interview_info = Interview::find(array(
						$term,
						'bind' => array('manager_id' => $value['id'])));
				$finish = count($interview_info);
				$value['count'] = $finish.'/'.$value['count'];
			}
			$rtn_array = array();
			$interviewers = Manager::find(array(
					'project_id=?1 AND role = ?2',
					'bind'=>array(1=>$project_id, 2=>'I')));
			//获取该项目下答题的总人数
			$count =  count($interviewers);
			$rtn_array['total'] = ceil($count/$rows);
			$rtn_array['records'] = $count;
			$rtn_array['rows'] = $result;
			// 			foreach($result as $value){
			// 				$rtn_array['rows'][] = $value;
			// 			}
			$rtn_array['page'] = $page;
			$this->dataReturn($rtn_array);
			return;
			
		}
	}
	#上传面巡专家列表
	public function uploadinterviewerAction(){
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
			$data = $excelHander->handleIL();
			if(file_exists($file_path)) unlink($file_path);
			$manager=$this->session->get('Manager');
			if(empty($manager)){
				echo "{'error':'用户信息获取失败，请重新登陆'}";
				return ;
			}
			$project_id = $manager->project_id;
			PmDB::insertInterviewer($data, $project_id);
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
	#更新专家页面信息
	public function updateinterviewerAction(){
		$this->view->disable();
		$manager = $this->session->get('Manager');
		if (empty($manager)){
			$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
			return ;
		}
		$project_id = $manager->project_id;
		$oper = $this->request->getPost('oper', 'string');
		if ($oper == 'add' ){
			$data = array();
			$data[] = $this->request->getPost('name', 'string');
			try{
				PmDB::insertInterviewer($data, $project_id);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录插入失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}else if ($oper == 'edit') {
			//edit
			$id = $this->request->getPost('id', 'int');
			$manager = Manager::findFirst($id);
			//$manager ->username       = $this->request->getPost('username', 'string');
			$manager->name = $this->request->getPost('name', 'string');
			$manager ->password   = $this->request->getPost('password', 'string');
			try{
				PmDB::updateManager($manager);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录更新失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}
		else if ($oper == 'del') {
			#删除可选择多项
			$ids = $this->request->getPost('id', 'string');
			#删除未加限制
			$id_array =explode(',', $ids);
			$managers = $this->modelsManager->createBuilder()
			->from('Manager')
			->where('project_id = '.$project_id ." AND role = 'I'")
			->inWhere('id', $id_array)
			->getQuery()
			->execute();
			try{
				PmDB::deleteManagers($managers);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录添加失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}else {
			//add ...
		}
	}
	# 面询人员导出
	public function interviewerExportAction(){
		$result = $this->roleInfo('I');
		$excelExport = new ExcelExport();
		$excelExport->InterviewerExport($result);
	}
	#配置面巡人员
	public function userdivideAction($manager_id){
		$this->view->setTemplateAfter('base2');
		$this->leftRender('项 目 被 试 人 员 分 配');
		$this->view->setVar('manager_id',$manager_id);
	}
	#获取面询专家信息
	public function getinterviewerAction(){
		$this->view->disable();
		$manager_id = $this->request->getPost('manager_id', 'int');
		$manager = Manager::findFirst($manager_id);
		if (empty($manager)){
			$this->dataReturn(array('error'=>'获取用户信息失败，请重新登录'));
			return ;
		}
		$this->dataReturn(array('success'=>$manager->name));
		return ;
	}
	#配置人员为被试+绿色通道
    #未配置人员获取
    public function  listexamineesnointAction(){
    	$this->view->disable();
    	$manager = $this->session->get('Manager');
    	if (empty($manager)){
    		$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
    		return ;
    	}
    	$project_id = $manager->project_id;
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
    		$result = $this->modelsManager->createQuery(
    				 "SELECT Examinee.id as id, Examinee.number as number , Examinee.name as name, Examinee.type as type 
    				  FROM Examinee     				 
    				  WHERE Examinee.project_id = $manager->project_id AND Examinee.id NOT IN
    				  (SELECT Interview.examinee_id  FROM Interview )
    				  ORDER BY  $sort 
    				  LIMIT $rows OFFSET $offset
    				"
    				 )
    			     ->execute();
    		$result = $result->toArray();
    		$count_result = $this->modelsManager->createQuery(
    				 "SELECT COUNT(Examinee.id) as count
    				  FROM Examinee     				 
    				  WHERE Examinee.project_id = $manager->project_id AND Examinee.id NOT IN
    				  (SELECT Interview.examinee_id  FROM Interview )
    				"
    				 ) ->execute();
    		$rtn_array = array();
    		$count =  $count_result[0]['count'];
    		$rtn_array['total'] = ceil($count/$rows);
    		$rtn_array['records'] = $count;
    		$rtn_array['rows'] =$result;
    		$rtn_array['page'] = $page;
    		$this->dataReturn($rtn_array);
    		return;
    	}else {
    		//处理search情况
    		$search_field =  $this->request->get('searchField');
    		$search_string =  $this->request->get('searchString');
    		$search_oper = $this->request->get('searchOper');
    		$filed = 'Examinee.'.$search_field;
    		if ($search_field == 'number'){
    			$oper = '=';
    			$value = $search_string;
    		}else if ($search_field == 'name' ){
    			$oper = 'LIKE';
    			$value = '\'%'.trim($search_string).'%\'';
    		}else if ($search_field == 'type'){
    			$oper = '=';
    			$value = intval($search_string);
    		}else {
    			//add ...
    		}
    		$result = $this->modelsManager->createQuery(
    				"SELECT Examinee.id as id, Examinee.number as number , Examinee.name as name, Examinee.type as type
    				FROM Examinee
    				WHERE Examinee.project_id = $manager->project_id AND $filed $oper $value AND Examinee.id NOT IN
    				(SELECT Interview.examinee_id  FROM Interview )
    				ORDER BY  $sort
    				"
    		)
    		->execute();
    		$result = $result->toArray();
    		$rtn_array = array();
    		$count =  count($result);
    		$rtn_array['total'] = ceil($count/$rows);
    		$rtn_array['records'] = $count;
    		$rtn_array['rows'] =$result;
    		$rtn_array['page'] = $page;
    		$this->dataReturn($rtn_array);
    		return;
    		return ;
    	}
    }
    #未配置人员的分配
    public function  updateexamineesnointAction($interviewer_id){
    	//只对del反应   del的意思为分配
    	//支持多删除
    	$this->view->disable();
    	$manager = $this->session->get('Manager');
    	if (empty($manager)){
    		$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
    		return ;
    	}
    	$interviewer = Manager::findFirst(
    			array('id = ?1 AND role = ?2', 
    			'bind'=>array(1=>$interviewer_id, 2=>'I'))
    	);
    	if (!isset($interviewer->id)){
    		$this->dataReturn(array('error'=>'不存在面询专家账号，请返回'));
    		return ;
    	}
    	$project_id = $manager->project_id;
    	$oper = $this->request->getPost('oper', 'string');
    	if ($oper == 'del') {
    		#删除可选择多项
    		$ids = $this->request->getPost('id', 'string');
    		#删除未加限制
    		$id_array =explode(',', $ids);
    		$examinees = $this->modelsManager->createBuilder()
    		->columns(array(
    				'Examinee.id as id'
    				))
    		->from('Examinee')
    		->inWhere('id', $id_array)
    		->getQuery()
    		->execute();
    		$data = $examinees->toArray();
    		try{
    			PmDB::allocExaminees($data, $interviewer_id);
    		}catch(Exception $e){
    			$this->dataReturn( array('error'=>'分配失败') );
    			return;
    		}
    		$this->dataReturn(array('flag'=>true));
    		return;
    	}else {
    		//add ...
    	}
    }
    #已配置人员获取
    public function listexamineehadintAction($interviewer_id){
    	$this->view->disable();
    	$manager = $this->session->get('Manager');
    	if (empty($manager)){
    		$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
    		return ;
    	}
    	$manager_id = $manager->id;
    	$interviewer = Manager::findFirst(
    			array('id = ?1 AND role = ?2',
    					'bind'=>array(1=>$interviewer_id, 2=>'I'))
    	);
    	if (!isset($interviewer->id)){
    		$this->dataReturn(array('error'=>'不存在面询专家账号，请返回'));
    		return ;
    	}
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
						'Examinee.id as id',
						'Examinee.number as number',
						'Examinee.name as name',
					  	'Examinee.type as type',
					  	'Interview.advantage as advantage',
					  	'Interview.disadvantage as disadvantage',
					  	'Interview.remark as remark'
					  ))
			->from('Examinee')
			->Join('Interview', 'Interview.manager_id ='.$interviewer_id.' AND Examinee.id = Interview.examinee_id')
			->limit($limit,$offset)
			->orderBy($sort)
			->getQuery()
			->execute();
    		$result = $result->toArray();
    		foreach($result as &$value ){
    			$value['state'] = 1;
    			if ( empty($value['advantage']) || empty($value['disadvantage']) || empty($value['remark']) ){
    				$value['state'] = 0;
    			}
    		}
    		$all_result = $this->modelsManager->createBuilder()
    		->from('Examinee')
    		->Join('Interview', 'Interview.manager_id ='.$interviewer_id.' AND Examinee.id = Interview.examinee_id')
    		->getQuery()
    		->execute();
    				$rtn_array = array();
    				$count =  count($all_result->toArray());
    				$rtn_array['total'] = ceil($count/$rows);
    				$rtn_array['records'] = $count;
    				$rtn_array['rows'] =$result;
    				$rtn_array['page'] = $page;
    				$this->dataReturn($rtn_array);
    						return;
    	}else{
    		//处理search情况
    		$search_field =  $this->request->get('searchField');
    		$search_string =  $this->request->get('searchString');
    		$search_oper = $this->request->get('searchOper');
    		$filed = 'Examinee.'.$search_field;
    		if ($search_field == 'number'){
    			$oper = '=';
    			$value = $search_string;
    		}else if ($search_field == 'name' ){
    			$oper = 'LIKE';
    			$value = '\'%'.trim($search_string).'%\'';
    		}else if ($search_field == 'type'){
    			$oper = '=';
    			$value = intval($search_string);
    		}else if ($search_field == 'state') {
    			$result = $this->modelsManager->createBuilder()
    			->columns(array(
    					'Examinee.id as id',
    					'Examinee.number as number',
    					'Examinee.name as name',
    					'Examinee.type as type',
    					'Interview.advantage as advantage',
    					'Interview.disadvantage as disadvantage',
    					'Interview.remark as remark'
    			))
    			->from('Examinee')
    			->Join('Interview', 'Interview.manager_id ='.$interviewer_id.' AND Examinee.id = Interview.examinee_id')
    			->orderBy($sort)
    			->getQuery()
    			->execute();
    			$result = $result->toArray();
    			$rt_result = array();
    			foreach($result as &$value ){
    				$value['state'] = 1;
    				if ( empty($value['advantage']) || empty($value['disadvantage']) || empty($value['remark']) ){
    					$value['state'] = 0;
    				}
    				if ($value['state'] == intval($search_string)){
    					$rt_result[] = $value;
    				}
    			}
    			$rtn_array = array();
    			$count =  count($rt_result);
    			$rtn_array['total'] = ceil($count/$rows);
    			$rtn_array['records'] = $count;
    			$rtn_array['rows'] =$rt_result;
    			$rtn_array['page'] = $page;
    			$this->dataReturn($rtn_array);
    			return;
    		}else{
    			//add...
    		}
    		$result = $this->modelsManager->createBuilder()
					  ->columns(array(
						'Examinee.id as id',
						'Examinee.number as number',
						'Examinee.name as name',
					  	'Examinee.type as type',
					  	'Interview.advantage as advantage',
					  	'Interview.disadvantage as disadvantage',
					  	'Interview.remark as remark'
					  ))
			->from('Examinee')
			->Join('Interview', 'Interview.manager_id ='.$interviewer_id.' AND Examinee.id = Interview.examinee_id '." AND $filed $oper $value")
			->orderBy($sort)
			->getQuery()
			->execute();
    		$result = $result->toArray();
    		$rtn_array = array();
    		$count =  count($result);
    		$rtn_array['total'] = ceil($count/$rows);
    		$rtn_array['records'] = $count;
    		$rtn_array['rows'] =$result;
    		$rtn_array['page'] = $page;
    		$this->dataReturn($rtn_array);
    		return;
    				return ;
    	}
    }
    #删除已配置人员的分配
    public function updateexamineehadintAction($interviewer_id){
    	//只对del反应   del的意思为分配
    	//支持多删除
    	$this->view->disable();
    	$manager = $this->session->get('Manager');
    	if (empty($manager)){
    		$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
    		return ;
    	}
    	$interviewer = Manager::findFirst(
    			array('id = ?1 AND role = ?2',
    					'bind'=>array(1=>$interviewer_id, 2=>'I'))
    	);
    	if (!isset($interviewer->id)){
    		$this->dataReturn(array('error'=>'不存在面询专家账号，请返回'));
    		return ;
    	}
    	$project_id = $manager->project_id;
    	$oper = $this->request->getPost('oper', 'string');
    	if ($oper == 'del') {
    		#删除可选择多项
    		$ids = $this->request->getPost('id', 'string');
    		#删除未加限制
    		$id_array =explode(',', $ids);
    		try{
    			PmDB::delallocExaminees($id_array, $interviewer_id);
    		}catch(Exception $e){
    			$this->dataReturn( array('error'=>'取消分配失败') );
    			return;
    		}
    		$this->dataReturn(array('flag'=>true));
    		return;
    	}else {
    		//add ...
    	}
    }
	#领导界面
	public function leaderAction(){
		# code...
	}
	#获取leader信息
	public function listleaderAction(){
	    $this->view->disable();
		$manager = $this->session->get('Manager');
		if (empty($manager)){
			$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
			return ;
		}
		$project_id = $manager->project_id;
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
					'Manager.id as id',
					'Manager.username as username',
					'Manager.name as name',
					'Manager.password as password',
					'Manager.last_login as last_login'
			))
			->from('Manager')
			->where('Manager.project_id = '.$project_id." AND Manager.role = 'L'" )
			->limit($limit,$offset)
			->orderBy($sort)
			->getQuery()
			->execute();
			$rtn_array = array();
			$interviewers = Manager::find(array(
					'project_id=?1 AND role = ?2',
					'bind'=>array(1=>$project_id, 2=>'L')));
			//获取该项目下答题的总人数
			$count =  count($interviewers);
			$rtn_array['total'] = ceil($count/$rows);
			$rtn_array['records'] = $count;
// 			$rtn_array['rows'] = $result;
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
			if ($search_field == 'username'){
				$filed = 'Manager.'.$search_field;
				$oper = '=';
				$value = $search_string;
			}else if ($search_field == 'name'){
				$filed = 'Manager.'.$search_field;
				$oper = 'LIKE';
				$value = '%'.$search_string.'%';
			}else if ($search_field == 'last_login'){
				$filed = 'Manager.'.$search_field;
				if($search_oper == 'bw'){
					$oper = '>=';
				}else if ($search_oper == 'ew'){
					$oper = '<=';
				}
				$value = $search_string;
			}else {
				//..
				return;
			}
			$result = $this->modelsManager->createBuilder()
			->columns(array(
					'Manager.id as id',
					'Manager.username as username',
					'Manager.name as name',
					'Manager.password as password',
					'Manager.last_login as last_login'
			))
			->from('Manager')
			->where('Manager.project_id = '.$project_id." AND Manager.role = 'L' AND $filed $oper '$value'" )
			->limit($limit,$offset)
			->orderBy($sort)
			->getQuery()
			->execute();
			$rtn_array = array();
			$interviewers = Manager::find(array(
					'project_id=?1 AND role = ?2',
					'bind'=>array(1=>$project_id, 2=>'L')));
			//获取该项目下答题的总人数
			$count =  count($interviewers);
			$rtn_array['total'] = ceil($count/$rows);
			$rtn_array['records'] = $count;
			// 			$rtn_array['rows'] = $result;
			foreach($result as $value){
				$rtn_array['rows'][] = $value;
			}
			$rtn_array['page'] = $page;
			$this->dataReturn($rtn_array);
			return;
		}
	}
	#更新leader 信息
	public function updateleaderAction(){
		$this->view->disable();
		$manager = $this->session->get('Manager');
		if (empty($manager)){
			$this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
			return ;
		}
		$project_id = $manager->project_id;
		$oper = $this->request->getPost('oper', 'string');
		if ($oper == 'add' ){
			$data = array();
			$data[]= $this->request->getPost('name', 'string');
			try{
				PmDB::insertLeader($data, $project_id);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录插入失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}else if ($oper == 'edit') {
			//edit
			$id = $this->request->getPost('id', 'int');
			$manager = Manager::findFirst($id);
			//$manager ->username       = $this->request->getPost('username', 'string');
			$manager->name = $this->request->getPost('name', 'string');
			$manager ->password   = $this->request->getPost('password', 'string');
			try{
				PmDB::updateManager($manager);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录更新失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}
		else if ($oper == 'del') {
			#删除可选择多项
			$ids = $this->request->getPost('id', 'string');
			#删除未加限制
			$id_array =explode(',', $ids);
			$managers = $this->modelsManager->createBuilder()
			->from('Manager')
			->where('project_id = '.$project_id ." AND role = 'L'")
			->inWhere('id', $id_array)
			->getQuery()
			->execute();
			try{
				PmDB::deleteManagers($managers);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'记录删除失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}else {
			//add ...
		}
	}
	#上传领导列表
  	public function uploadleaderAction(){
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
			$data = $excelHander->handleIL();
			if(file_exists($file_path)) unlink($file_path);
			$manager=$this->session->get('Manager');
			if(empty($manager)){
				echo "{'error':'用户信息获取失败，请重新登陆'}";
				return ;
			}
			$project_id = $manager->project_id;
			PmDB::insertLeader($data, $project_id);
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
    #领导导出界面
    public function leaderexportAction(){
    	$result = $this->roleInfo('L');
    	$excelExport = new ExcelExport();
    	$excelExport->LeaderExport($result);
    }
	#最终结果页面
	public function resultAction(){
		$manager = $this->session->get('Manager');
        $project_id = $manager->project_id;
        $this->view->setVar('project_id',$project_id);
	}
	
    function dataReturn($ans){
    	$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
    	$this->view->disable();
    	echo json_encode($ans);
    }
}