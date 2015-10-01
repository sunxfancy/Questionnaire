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
	#主页面, 在主页面生成相关跳转
    public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('北京政法系统人才测评项目管理平台');
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
    			$module = Module::findFirst(
    					array(
    							'name=?1',
    							'bind'=>array(1=>$name)
    					)
    			);
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
				$this->dataReturn(array('error'=>'已有被试答题，需求量表不可再修改！'));
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
	#获取被试信息页面
	public function listexamineeAction(){
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
            	->where('Examinee.project_id = '.$project_id)
            	->limit($limit,$offset)
            	->orderBy($sort)
            	->getQuery()
            	->execute();
		        $rtn_array = array();
		         $examinees = Examinee::find(array(
            	'project_id=?1',
           		'bind'=>array(1=>$project_id)));
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
					$value = "%'$search_string'%";
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
			->where('Examinee.project_id = '.$project_id." AND $filed $oper $value")
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
	public function updateexamineeAction(){
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
			try{
				PmDB::insertExaminee($data, $project_id);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'被试人员信息插入成功！'));
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
            	$this->dataReturn( array('error'=>'被试人员信息更新失败') );
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
				$this->dataReturn( array('error'=>'被试人员纪录失败') );
				return;
			}
			$this->dataReturn(array('flag'=>true));
			return;
		}else {
			//add ...
		}
	}
	#上传被试信息列表
	public function uploadexamineeAction(){
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
		    PmDB::insertExaminee($data, $project_id);
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
	#被试信息导出页面
	public function examineeDownloadAction(){
		$this->view->setTemplateAfter('base2');
		$this->leftRender('被 试 人 员 数 据 下 载');
	}
	#导出被试信息列表
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
	#以excel形式，导出被试人员信息和测试结果--十张表格
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
	#以word形式，导出被试人员个人报告--个体报告
	public function resultReportAction($examinee_id){
		$this->view->disable();
		$project_id = $this->session->get('Manager')->project_id;
		$examinee = Examinee::findFirst($examinee_id);
		$wordExport = new WordExport();
		$wordExport->examineeReport($examinee,$project_id);
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
	#获取面巡专家列表
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
// 			foreach($result as $value){
// 				$rtn_array['rows'][] = $value;
// 			}
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
	public function uploadInterviewerAction(){
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
			$data[0]['name'] = $this->request->getPost('name', 'string');
			try{
				PmDB::insertInterviewer($data, $project_id);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'专家信息插入失败') );
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
				$this->dataReturn( array('error'=>'被试人员信息更新失败') );
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
				$this->dataReturn( array('error'=>'被试人员纪录失败') );
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
	#分配面巡人员
	public function userdivideAction($manager_id){
		$this->view->setVar('manager_id',$manager_id);
		$this->view->setTemplateAfter('base2');
		$this->leftRender('项 目 被 试 人 员 分 配');
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
		if ($oper == 'edit') {
			//edit
			$id = $this->request->getPost('id', 'int');
			$manager = Manager::findFirst($id);
			//$manager ->username       = $this->request->getPost('username', 'string');
			$manager->name = $this->request->getPost('name', 'string');
			$manager ->password   = $this->request->getPost('password', 'string');
			try{
				PmDB::updateManager($manager);
			}catch(Exception $e){
				$this->dataReturn( array('error'=>'信息更新失败') );
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
				$this->dataReturn( array('error'=>'删除失败') );
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
    public function leaderExportAction(){
    	$result = $this->roleInfo('L');
    	$excelExport = new ExcelExport();
    	$excelExport->LeaderExport($result);
    }
	#最终结果页面
	public function resultAction(){
		# code...
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

    function dataReturn($ans){
    	$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
    	$this->view->disable();
    	echo json_encode($ans);
    }
}