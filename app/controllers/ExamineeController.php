<?php

class ExamineeController extends Base
{
	private static $paper_name_array = array('16PF','EPPS','SCL','EPQA','CPI','SPM');
    
	public function initialize(){
        $this->view->setTemplateAfter('base3');
    }
	#设置examinee转到/
	public function indexAction(){
        $this->response->redirect('/');
	}

	public function inqueryAction(){
		$exminee = $this->session->get('Examinee');
 		// $this->session->remove('Examinee');
		if(empty($exminee)){
			$this->response->redirect('/error/index/examinee');
			$this->view->disable();
		}else{
			$this->leftRender("需求量表");
		}
        //获得被试者的登陆信息      
	}

    //函数作者：Leo, 返回为布尔型，check_type为你要进行检验的项目，0-需求量表，1-答题，如果该项目已经答题完毕，则返回true
    public function check_ans($exam_id){
        $tmp=InqueryAns::findFirst(array(
                "examinee_id=?1",
                "bind"=>array(1=>$exam_id)
            ));
        if($tmp){
            return true;
        }
        return false;       
    }
    public function getInqueryAction(){
 		// $this->session->remove('Examinee');
    	$exminee = $this->session->get('Examinee');
    	if(empty($exminee)){
    		$this->dataReturn(array('error'=>'用户信息获取失败'));
    		return;
    	}
        $project_id = $exminee->project_id;
        try{
        	$inquery_data = MemoryCache::getInqueryQuestion($project_id);
        	#查询出缓存信息后，判断是否为空，为空则清空 -----只需要在需求量表处进行判断,其他的可以不进行判断，因为从数据库中读取不更改的数据，可默认为ok
        	
            $test = $this->modelsCache->get( 'inquery_question_by_project_id_'.$project_id );
        	if( count($test) == 0 ){
        		$this->modelsCache->delete( 'inquery_question_by_project_id_'.$project_id );
        	}
        }catch(Exception $e){
        	$this->dataReturn(array('error'=>$e->getMessage()));
        	return;
        }
        if(count($inquery_data) == 0 ){
        	$this->dataReturn(array('error'=>'需求量表获取失败,返回数据为空'));
        	return ;
        }else{

        	$question = array();
        	foreach($inquery_data as $record){
        		$question[] = array(
        			'index' => $record['id'],
        			'title' => $record['topic'],
        			'options' => $record['options'],
        			'is_multi' => $record['is_radio'] == 1 ? false : true,
        		);
        	}
        	$this->dataReturn(array('question'=>$question));
        	return ;
        }
    }

    public function getInqueryAnsAction(){
    	$exminee = $this->session->get('Examinee');
    	if(empty($exminee)){
    		$this->dataReturn(array('error'=>'用户信息获取失败'));
    		return;
    	}
    	$project_id = $exminee->project_id;
    	$examinee_id = $exminee->id;
        $option = $this->request->getPost("answer", "string");
        if(empty($option)){
        	$this->dataReturn(array('error'=>'提交失败:提交信息为空'));
        	return;
        }
        try{
        	ExamineeDB::insertInquery($examinee_id, $option, $project_id);
        }catch(Exception $e){
        	$this->dataReturn(array('error'=>$e->getMessage()));
        	return;
        }
        $this->dataReturn(array('flag'=>true));
    }

	public function doexamAction(){
		$exminee = $this->session->get('Examinee');
		// $this->session->remove('Examinee');
		if(empty($exminee)){
			$this->response->redirect('/error/index/examinee');
			$this->view->disable();
		}else{
			$this->leftRender("答题");
		}
	}

    public function getpaperAction(){
        $paper_name = $this->request->getPost("paper_name","string");
        $examinee = $this->session->get('Examinee');
        #添加如果用户已经答过题
        if (empty($examinee)){
        	$this->dataReturn(array('error'=>'获取用户信息失败，请重新登录！'));return;
        }
        if ($examinee->state > 0 ){
        	$this->dataReturn(array('error'=>'您已答过题目，请退出登录！'));return;
        }
        if(!$this->check_ans($examinee->id)){
            $this->dataReturn(array('error'=>'您还未完成需求量表的作答，请退出重新登录！'));return;
        }
        $project_id = $examinee->project_id;
        if(!in_array($paper_name, self::$paper_name_array)){
        	$this->dataReturn(array('error'=>'不存在试卷-'.$paper_name));
        	return ;
        }
        try{
        $paper_info = MemoryCache::getPaperDetail($paper_name);
        $paper_id = $paper_info->id;
        $project_detail_json = MemoryCache::getProjectDetail($project_id);
        }catch(Exception $e){
        	$this->dataReturn(array('error'=>$e->getMessage()));
        	return ;
        }
       
        $project_detail_array = json_decode($project_detail_json->exam_json, true);
        if(!isset($project_detail_array[$paper_name])){
        	$this->dataReturn(array("no_ques"=>'none'));
        	return;
        }
        $question_number_array = $project_detail_array[$paper_name];
       	$rtn_data = array();
       	try{
       	foreach($question_number_array as $value){
       		$question_data = MemoryCache::getQuestionDetail($value, $paper_id);
       		$rtn_data[] = array(
       				'index'=>$question_data->number,
       				'title'=>empty($question_data->topic)?'':$question_data->topic,
       				'options'=>$question_data->options
       		);
       	}
       	}catch(Exception $e){
       		$this->dataReturn(array('error'=>$e->getMessage()));
       		return ;
       	}
       	$this->dataReturn(array("question"=>$rtn_data,"description"=>$paper_info->description,"order"=> $question_number_array));
        return ;
    }

    public function getExamAnswerAction(){
    	$id = $this->session->get('Examinee')->id;
    	$total_time=$this->request->getPost("total_time","int");
    	if($total_time){
    		try{
    			QuestionIC::finishedExam($id, intval($total_time));
    			BasicScore::handlePapers($id);
    			BasicScore::finishedBasic($id);
    			FactorScore::handleFactors($id);
    			FactorScore::finishedFactor($id);
    			IndexScore::handleIndexs($id);
    			IndexScore::finishedIndex($id); 
    		}catch(Exception $e){
    			$this->dataReturn(array('error'=>$e->getMessage()));
    			return ;
    		}
    		//正常计算完成后注销用户信息
    		$this->session->remove('Examinee');
    		$this->dataReturn(array("flag"=>$total_time));
    		return;
    	}
    	$option = $this->request->getPost("answer", "string");
    	$paper_name = $this->request->getPost("paper_name", "string");
    	$number = $this->request->getPost("order");
    	try{
    		QuestionIC::insertQuestionAns($id, $paper_name, $option, $number);
    	}catch(Exception $e){
    		$this->dataReturn(array("error"=>"提交失败:".$e->getMessage()));
    		return;
    	}
    	$this->dataReturn(array("flag"=>true));
    	return;
    }

    public function editinfoAction(){
    	$exminee = $this->session->get('Examinee');
        if(empty($exminee)){
        	$this->response->redirect('/error/index/examinee');
        	$this->view->disable();
        }else{
        	 $this->leftRender("个 人 信 息 填 写");
        } 
    }
    
    public function getexamineeinfoAction(){
    	$examinee = $this->session->get('Examinee');
    	if(empty($examinee)){
    		$this->dataReturn(array('error'=>'用户信息获取失败'));
    		return;
    	}else{
    		$examinee_info = Examinee::findFirst($examinee->id);
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
			$this->dataReturn(array('question'=>$question));
			return;
    	}
    }

    public function submitAction(){
    	$exminee = $this->session->get('Examinee');
    	if(empty($exminee)){
    		$this->dataReturn(array('error'=>'用户信息获取失败'));
    		return;
    	}
    	$examinee_id = $exminee->id;
    	$examinee_info = Examinee::findFirst($examinee_id);
    	$info_array = array();
    	$info_array['name'] 		= $this->request->getPost("name", "string");
    	$info_array['sex']  		= $this->request->getPost('sex', 'string') == '男' ? 1: 0;
    	$info_array['education'] 	= $this->request->getPost("education", "string");
    	$info_array['degree']       = $this->request->getPost("degree", "string");
    	$info_array['birthday']     = $this->request->getPost("birthday", "string");
    	$pattern = '/^\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])$/';
    	if( preg_match($pattern, $info_array['birthday']) == 0 ){
    		$this->dataReturn(array('error'=>'出生日期填写有误:'.$info_array['birthday'] ));
    		return ;
    	}
    	#添加生日区间判断 去区间[16 , 110 )
    	$age = FactorScore::calAge($info_array['birthday'],date('y-m-d H:i:s'));
    	if($age >= 110 || $age < 16 ){
    		$this->dataReturn(array('error'=>'出生日期不在系统的可测试范围[16,110)内:'.$info_array['birthday'] ));
    		return ;
    	}
    	$info_array['native']       = $this->request->getPost("native", "string");
    	$info_array['politics']     = $this->request->getPost("politics", "string");
     	$info_array['professional'] = $this->request->getPost("professional", "string");
     	$info_array['employer']     = $this->request->getPost("employer", "string");
     	$info_array['unit']         = $this->request->getPost("unit", "string");
     	$info_array['duty']         = $this->request->getPost("duty", "string");
     	$info_array['team']         = $this->request->getPost("team", "string");
    	try{
    		ExamineeDB::insertExamineeInfo($examinee_info, $info_array);
    		#如果用户更改name， 那么需要更新session数据
    		if($info_array['name'] != $exminee->name){
    			$examinee = Examinee::findfirst($exminee->id);
    			$this->session->remove('Examinee');
    			$this->session->set('Examinee', $examinee);
    		}
    	}catch(Exception $e){
    		$this->dataReturn(array('error'=>$e->getMessage()));
    		return;
    	}
    	$this->dataReturn(array('flag'=>true));    
    }

    public function listeduAction(){
    	$this->view->disable();
    	$rtn_array = array();
    	$examinee = $this->session->get('Examinee');
    	if(empty($examinee)){
    		 #返回错误信息
    		  $this->dataReturn(array('error'=>"用户信息获取失败"));
    		  return;
    	}
    	$examinee_info = Examinee::findFirst($examinee->id);
    	$json = json_decode($examinee_info->other,true);
    	$rtn_array['records'] = 0;
    	if(isset($json['education'])){
    		$count  =  count($json['education']);
    		$time_array = array();
    		foreach($json['education'] as $key=>$value){
    			$time_array[] = $value['date'];
    		}
    		array_multisort($time_array,SORT_DESC,$json['education']);
    		$rtn_array['page'] = 1;
    		$tmp_array = array();
    		for( $i = 0; $i < $count; $i++ ){
    				if(isset($json['education'][$i])){
    					 $json['education'][$i]['id'] = $i+1;
    					 $date_array = explode('-' ,$json['education'][$i]['date']);
    					 $json['education'][$i]['begintime'] =  $date_array[0];
    					 $json['education'][$i]['endtime'] = $date_array[1];
    					 unset( $json['education'][$i]['date']);
    					 $tmp_array[] = $json['education'][$i]; 
    				}
    		}
    		$rtn_array['total'] = 1;
    		$rtn_array['records'] = $count;
    		$rtn_array['rows'] = $tmp_array;
    		$this->dataReturn($rtn_array);
    		return;
    	}else{
    		$rtn_array['total'] = 0;
    		$rtn_array['page'] = 1;
    		$rtn_array['rows'] = null;
    		$this->dataReturn($rtn_array);
    		return;
    	}        
    }

    public function updateeduAction(){
        $this->view->disable();
        $oper = $this->request->getPost('oper', 'string');
        $examinee= $this->session->get('Examinee');
        $examinee_info = Examinee::findFirst($examinee->id);
        $json = json_decode($examinee_info->other,true);
        $rtn_array = array();
        if(!isset($json['education'])){
        	$json['education'] = array();
        }
        if(!isset($json['work'])){
        	$json['work'] = array();
        }
        $work_array = $json['work'];
		$education_array = $json['education'];
		//添加时间排序
		$time_array = array();
		foreach($education_array as $key=>$value){
			$time_array[] = $value['date'];
		}
		array_multisort($time_array,SORT_DESC,$education_array);
		if($oper == 'del' ){
			//del ok
			$id = $this->request->getPost('id', 'int');
			array_splice($education_array,$id-1,1);	
		}else{
			$new_array = array();
			$new_array['school']     =  $this->request->getPost('school', 'string');
			$new_array['profession'] = $this->request->getPost('profession', 'string');
			$new_array['degree']     = $this->request->getPost('degree', 'string');
			$begintime    = $this->request->getPost('begintime', 'string');
			$endtime      = $this->request->getPost('endtime', 'string');
			$id = $this->request->getPost('id', 'int');
			$new_array['date'] = $begintime.'-'.$endtime;
			if(empty($id)){
				//add
				$education_array[] = $new_array;					
			}else{
				//edit
				foreach($new_array as $key=>$value){
					$education_array[$id-1][$key] = $value;
				}
			} 			
		}
		//添加时间排序
		$time_array = array();
		foreach($education_array as $key=>$value){
			$time_array[] = $value['date'];
		}
		array_multisort($time_array,SORT_DESC,$education_array);
		$rtn_array['education'] = $education_array;
		$rtn_array['work'] = $work_array;
		$json = json_encode($rtn_array,JSON_UNESCAPED_UNICODE);
		try{
		ExamineeDB::unpdateOther($json, $examinee_info);
		}catch (Exception $e){
			$this->dataReturn(array('error'=>'教育经历更新失败'));
			return;
		}
		$this->dataReturn(array('flag'=>'true'));
		return;
    }
    
    public function listworkAction(){
    	$this->view->disable();
    	$rtn_array = array();
    	$examinee = $this->session->get('Examinee');
    	if(empty($examinee)){
    		   #返回错误信息
    		  $this->dataReturn(array('error'=>"用户信息获取失败"));
    		  return;
    	}
    	$examinee_info = Examinee::findFirst($examinee->id);
    	$json = json_decode($examinee_info->other,true);
    	$rtn_array['records'] = 0;
    	if(isset($json['work'])){
    		$count = count($json['work']);
    		//读出原有的数据，先排序
    		$time_array = array();
    		foreach($json['work'] as $key=>$value){
    			$time_array[] = $value['date'];
    		}
    		array_multisort($time_array,SORT_DESC,$json['work']);
    		$rtn_array['total']   = 1;
    		$rtn_array['page'] = 1;#当前页
    		$tmp_array = array();
    		for( $i = 0; $i < $count; $i++ ){
    				if(isset($json['work'][$i])){
    					 $json['work'][$i]['id'] = $i+1;
    					 $date_array = explode('-' ,$json['work'][$i]['date']);
    					 $json['work'][$i]['begintime'] =  $date_array[0];
    					 $json['work'][$i]['endtime'] = $date_array[1];
    					 unset( $json['work'][$i]['date']);
    					 $tmp_array[] = $json['work'][$i];
    				}
    		}
    		$rtn_array['records'] = $count;;#返回的记录数,改为记录的总数
    		$rtn_array['rows'] = $tmp_array;#实际结果数组
    		echo json_encode($rtn_array,JSON_UNESCAPED_UNICODE);
    		return;
    	}else{
    		$rtn_array['total'] = 0;
    		$rtn_array['page'] = 1;
    		$rtn_array['rows'] = null;
    		echo json_encode($rtn_array,JSON_UNESCAPED_UNICODE);
    		return;
    	}        
    }

    public function updateworkAction(){
        $this->view->disable();
        $oper = $this->request->getPost('oper', 'string');
        $examinee= $this->session->get('Examinee');
        $examinee_info = Examinee::findFirst($examinee->id);
        $json = json_decode($examinee_info->other,true);
        $rtn_array = array();
        if(!isset($json['work'])){
        	$json['work'] = array();
        }
        if(!isset($json['education'])){
        	$json['education'] = array();
        }
        $work_array = $json['work'];
		$education_array = $json['education'];
		#操作之前先排序
		$time_array = array();
		foreach($work_array as $key=>$value){
			$time_array[] = $value['date'];
		}
		array_multisort($time_array,SORT_DESC,$work_array);
		if ($oper == 'del'){
			$id = $this->request->getPost('id', 'int');
			array_splice($work_array,$id-1,1);
		}else{
			$new_array = array();
			$new_array['employer']    = $this->request->getPost('employer', 'string');
			$new_array['unit'] = $this->request->getPost('unit', 'string');
			$new_array['duty']     = $this->request->getPost('duty', 'string');
			$new_array['date']       = $this->request->getPost('date', 'string');
			$begintime    = $this->request->getPost('begintime', 'string');
			$endtime      = $this->request->getPost('endtime', 'string');
			$id = $this->request->getPost('id', 'int');
			$new_array['date'] = $begintime.'-'.$endtime;
			if(empty($id)){
				//add
				$work_array[] = $new_array;
			}else{
				//edit
				foreach($new_array as $key=>$value){
					$work_array[$id-1][$key] = $value;
				}
			}
		}
		//添加时间排序
		$time_array = array();
		foreach($work_array as $key=>$value){
			$time_array[] = $value['date'];
		}
		array_multisort($time_array,SORT_DESC,$work_array);
		$rtn_array['education'] = $education_array;
		$rtn_array['work'] = $work_array;
		$json = json_encode($rtn_array,JSON_UNESCAPED_UNICODE);
		try{
		ExamineeDB::unpdateOther($json, $examinee_info);
		}catch (Exception $e){
			$this->dataReturn(array('error'=>'教育经历更新失败'));
		}
		$this->dataReturn(array('flag'=>true));
		return;      
    }

    public function dividepeoAction($manager_id){
        $this->view->disable();
        $project_id = $this->session->get('Manager')->project_id;
        $interview = Interview::find();
        $examinee_divd = array();
        foreach ($interview as $interviews) {
            $examinee_divd[] = Examinee::findFirst($interviews->examinee_id)->number;

        }
        $examinee = Examinee::find(array(
            'project_id =?1',
            'bind'=>array(1=>$project_id)));
        $examinee_all = array();
        foreach ($examinee as $examinees) {
            $examinee_all[] = $examinees->number;
        }
        $examinee_not = array();
        $examinee_not = array_diff($examinee_all,$examinee_divd);
        echo json_encode($examinee_not,true);
    }

    public function dataReturn($ans){
        $this->response->setHeader("Content-Type", "text/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

    public function leftRender($title){
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