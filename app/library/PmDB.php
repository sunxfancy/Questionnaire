<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class PmDB 
{
    //存储项目模块选择结果 并 修改项目状态
	public static function insertProjectDetail($project_detail_info){
		try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            $project_detail = new ProjectDetail();
            $project_detail->setTransaction($transaction);
            foreach($project_detail_info as $key => $value){
                $project_detail->$key = $value;
            }
            $project = Project::findFirst($project_detail_info['project_id']);
            $project->setTransaction($transaction);
            $type= true;
            $state = self::getProjectStateNext($project, $type);
            $project->state = $state ;
            if( $project_detail->save() == false || $project->save() == false ){
                $transaction->rollback("数据插入失败");
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
	}
	#删除项目配置模块
	public static function delModule($project_id){
		try{
			$delete_data = ProjectDetail::findFirst(array(
			'project_id = :project_id:',
			'bind' => array('project_id' => $project_id)));
			if (isset($delete_data->project_id)){
				$manager     = new TxManager();
				$transaction = $manager->get();
				$delete_data->setTransaction($transaction);
				if($delete_data->delete()== false){
					$transaction->rollback('数据更新失败-1');
				}
				#说明该项目下需求量表已导入过，则继续更新项目状态
				$project = Project::findFirst(
							array(
									"id=?1",'bind'=>array(1=>$project_id))
					);
				$project->setTransaction($transaction);
				$project->state = ($project->state - 1 >=0 )? $project->state-1 : 0 ;
				if(  $project->save() == false ){
						$transaction->rollback("数据插入失败-2");
				}
				$transaction->commit();
				return true;
			}else{
				return true;
			}
			
			
		}catch (TxFailed $e) {
		throw new Exception($e->getMessage());
		}
	}
	#删除项目需求量表
	public static function delInquery($project_id){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			#先删除已有的信息
			$delete_data = InqueryQuestion::find(array(
			'project_id = :project_id:',
			'bind' => array('project_id' => $project_id)));
			foreach($delete_data as $data_record){
				$data_record->setTransaction($transaction);
				if($data_record->delete()== false){
					$transaction->rollback('数据更新失败-1');
				}
			}
			#说明该项目下需求量表已导入过，则继续更新项目状态
			if(count($delete_data) > 0 ){
				$project = Project::findFirst(
						array(
								"id=?1",'bind'=>array(1=>$project_id))
				);
				$project->setTransaction($transaction);
				$project->state = ($project->state - 1 >=0 )? $project->state-1 : 0 ;
				if(  $project->save() == false ){
					$transaction->rollback("数据插入失败-2");
				}
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
	}
    //插入需求量表信息 并 修改项目状态
    public static function insertInquery($data, $project_id){
        try{
        self::delInquery($project_id);
        #插入新数据
        $manager     = new TxManager();
        $transaction = $manager->get();
        foreach($data as $value){
            $inquery = new InqueryQuestion();
            $inquery->setTransaction($transaction);
            foreach($value as $key=>$svalue){
                $inquery->$key = $svalue;
            }
            $inquery->project_id = $project_id;
            if($inquery->save() == false) {
                 $transaction->rollback('数据更新失败-3');
            }
        }
        $type= false;
        #更新项目状态
        $project = Project::findFirst(
            array(
                "id=?1",'bind'=>array(1=>$project_id))
            );
        $project->setTransaction($transaction);
        $state = self::getProjectStateNext($project, $type);
        $project->state = $state ;
        if(  $project->save() == false ){
                $transaction->rollback("数据插入失败-4");
        }
        $transaction->commit();
        return true;
    }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }

    //更新项目状态
	#模块配置的类型设为true
	#需求量表的上传设为false
    public static function getProjectStateNext($project, $type){
		#项目状态更新前的判断
    	if ($project->state == 2){
    		$state = 2;
    	}else if ($project->state == 0 ){
    		$state = 1;
    	}else {
    		// 1 -- 表示二者必居其一
    		$inquery = InqueryQuestion::findFirst(
    				array(
    						'project_id=?1',
    						'bind'=>array(1=>$project->id)));
    		if(isset($inquery->project_id)){
    			if ($type){
    				$state = 2;
    			}else{
    				$state = 1;
    			}
    		}else{
    			if ($type){
    				$state = 1;
    			}else{
    				$state = 2;
    			}
    		}
    	}
    	return $state;
      
    }
    
    
    /**
     *@usage input 模块的中文名称string
     *@return 模块的英文名称 string
     */
    public static function getModuleName($module_chs_name){
    	$module = Module::findFirst(array(
    			'chs_name=?1',
    			'bind'=>array(1=>$module_chs_name)));
    	if(!isset($module->name)){
    		throw new Exception($module_chs_name.'-模块名称不存在');
    	}
    	$module_name = $module->name;
    	return $module_name;
    }
    
    /**
     *@usage input 模块的英文名数组
     *@return 模块下属指标的集合 array
     */
    public static function getIndexName($module_names){
    	$index_names = array();
    	foreach($module_names as $value){
    		$module = Module::findFirst(
    				array(
    						'name=?1',
    						'bind'=>array(1=>$value))
    		);
    		$children_str = $module->children;
    		$children_array = explode(",", $children_str);
    		foreach($children_array as $value){
    			$index_names[] = $value;
    		}
    	}
    	return array_unique($index_names);
    }
    
    /**
     * @usage input 指标名数组 array
     * @return 因子名数组 array
     */
    public static function getFactorName($index_names){
    	$factor_names = array();
    	foreach($index_names as $value){
    		$index = Index::findFirst(
    				array(
    						'name=?1',
    						'bind'=>array(1=>$value))
    		);
    		$children_str = $index->children;
    		$children_type_str = $index->children_type;
    		$children_array = explode(",",$children_str );
    		$children_type_array = explode(',', $children_type_str);
    		$i = 0;
    		#指标下有子指标
    		foreach($children_type_array as $value){
    			#子指标下属的肯定是因子
    			if($value == '0'){
    				$zi = Index::findFirst(array(
    						'name=?1',
    						'bind'=>array(1=>$children_array[$i])));
    				$zi_child_str = $zi->children;
    				$zi_child_array = explode(",",$zi_child_str );
    				foreach($zi_child_array as $value){
    					$factor_names[] = $value;
    				}
    			}else{
    				$factor_names[] = $children_array[$i];
    			}
    			$i++;
    		}
    		 
    	}
    	return array_unique($factor_names);
    }
    
    /**
     * @usage input 因子数组名
     * @return 试卷下的题号 array
     */
    public static function getQuestionName($factor_names){
    	$questions_numbers = array();
    	foreach ($factor_names as $value){
    		$factor = Factor::findFirst(array(
    				'name=?1',
    				'bind'=>array(1=>$value)));
    		$children_str = $factor->children;
    		$children_type_str = $factor->children_type;
    		$children_array = explode(",",$children_str );
    		$children_type_array = explode(',', $children_type_str);
    		#指标下有子指标
    		$i = 0;
    		foreach($children_type_array as $value){
    			#子因子肯定是题目
    			if($value == '0'){
    				$zi = Factor::findFirst(array(
    						'name=?1',
    						'bind'=>array(1=>$children_array[$i])));
    				$zi_child_str = $zi->children;
    				$zi_child_array = explode(",",$zi_child_str );
    				foreach($zi_child_array as $svalue){
    					$paper_name = Paper::findFirst($zi->paper_id)->name;
    					$questions_numbers[$paper_name][] =trim($svalue,' ');
    				}
    			}else{
    				$paper_name = Paper::findFirst($factor->paper_id)->name;
    				$questions_numbers[$paper_name][] =trim($children_array[$i],' ');
    			}
    			$i++;
    		}
    	}
        $question_array = array();
    	foreach($questions_numbers as $key=>$value){
    		$value = array_unique($value, SORT_NUMERIC);
            foreach ($value as $skey => $svalue) {
                $question_array[$key][] = $svalue;
            }   
    	}
        return $question_array;
    }
    /**
     * @usage input 因子名数组
     * @return 所有分类下的因子数组
     */
    public static function getAllDividedFactors($factor_names){
    	$factors = array();
    	foreach ($factor_names as $factor_name) {
    		$factor = Factor::findFirst(array(
    				'name=?1',
    				'bind'=>array(1=>$factor_name)));
    		$paper_name = Paper::findFirst($factor->paper_id)->name;
    		$factors[$paper_name][$factor->id] = $factor_name;
    		$children_type_array = explode(',',$factor->children_type);
    		#因子至多两层
    		if (in_array(0, $children_type_array)) {
    			$factor = explode(',',$factor->children);
    			foreach ($factor as $value) {
    				$zi_factor = Factor::findFirst(array(
    						'name=?1',
    						'bind'=>array(1=>$value)));
    				$factors[$paper_name][$zi_factor->id] = $value;
    			}
    		}
    	}
    	return $factors;
    }
    /**
     * pm更新被试信息
     * @param object $examinee_info
     */
    public static function updateExaminee($examinee_info){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
			$examinee_info->setTransaction($transaction);
    		if( $examinee_info->save() == false ){
    			$transaction->rollback("数据插入失败");
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }
    /**
     * 删除被试纪录
     * @param array $id_array
     */
    public static function deleteExaminee($examinees){
    		try{
    			$manager     = new TxManager();
    			$transaction = $manager->get();
				foreach($examinees as $value){
					$value->setTransaction($transaction);
					if( $value->delete() == false ){
							$transaction->rollback("数据删除失败");
					}
				}
    			$transaction->commit();
    			return true;
    		}catch (TxFailed $e) {
    			throw new Exception($e->getMessage());
    		}
    		
    }
    /**
     * 导入被试信息列表
     */
    public static function 	insertExaminee($data, $project_id, $type = 0 ){
    	//对原有数据进行整理
    	$examinee = Examinee::find(array(
    			'project_id = :project_id:',
    			"order" => "number desc",
    			'bind' => array('project_id' => $project_id)));
    	$new_count =  count($data);
    	//1501 0001 
    	$already_number = 0;
    	if (count($examinee) == 0 ){
    		$already_number = 0;
    	}else {
    		$already_number = $examinee[0]->number-$project_id*10000;
    	}
    	#异常
    	if ($new_count + $already_number > 9999 ){
    		throw new Exception('项目人数超限-9999');
    	}
    	$start = $project_id*10000 + $already_number+1;
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		
    		foreach($data as $value){
    			$examinee = new Examinee();
    			$examinee->setTransaction($transaction);
    			$examinee->project_id = $project_id;
    			$examinee->state = 0;
    			$examinee->number = $start++;
    			foreach($value as $skey =>$svalue ){
    				$examinee->$skey = $svalue;
    			}
    			$examinee->password = self::getRandString();
    			$examinee->type = $type;
    			if( $examinee->save() == false ){
    				$transaction->rollback("数据插入失败");
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    	
    }
    /**
     * 删除纪录--专家
     * @param array $id_array
     */
    public static function deleteManagers($managers){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($managers as $value){
    			$value->setTransaction($transaction);
    			if( $value->delete() == false ){
    				$transaction->rollback("数据删除失败");
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    
    }
    /**
     * 更新manager信息
     */
    public static function updateManager($data){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		$data->setTransaction($transaction);
    		if( $data->save() == false ){
    			$transaction->rollback("数据更新失败");
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }
    public static function insertLeader($data, $project_id){
    	//对原有数据整理
    	$leader = Manager::find(array(
    			'project_id =?0 and role=?1',
    			"order" => "username desc",
    			'bind' => array(0=> $project_id,1=>'L')));
    	$new_count =  count($data);
    	//1501 101
    	$already_number = 0;
    	if (count($leader) == 0 ){
    		$already_number = 0;
    	}else {
    		$already_number = $leader[0]->username-$project_id*1000 -200;
    	}
    	#异常
    	if ($new_count + $already_number > 99 ){
    	throw new Exception('项目人数超限-99');
    	}
    	$start = $project_id*1000 +200+ $already_number+1;
    	try{
    	$manager     = new TxManager();
    	$transaction = $manager->get();
    	foreach($data as $value){
    	$manager = new Manager();
    	$manager->setTransaction($transaction);
    	$manager->project_id = $project_id;
    	$manager->role= "L";
    	$manager->username = $start++;
    	$manager->password = self::getRandString();
    	$manager->name = $value;
    	if( $manager->save() == false ){
    			$transaction->rollback("数据插入失败");
    	}
    	}
    	$transaction->commit();
    	return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }
    public static function insertInterviewer($data, $project_id){
    	//对原有数据整理
    	$interviewer = Manager::find(array(
    			'project_id =?0 and role=?1',
    			"order" => "username desc",
    			'bind' => array(0=> $project_id,1=>'I')));
    	$new_count =  count($data);
    	//1501 101
    	$already_number = 0;
    	if (count($interviewer) == 0 ){
    		$already_number = 0;
    	}else {
    		$already_number = $interviewer[0]->username-$project_id*1000 -100;
    	}
    	#异常
    	if ($new_count + $already_number > 99 ){
    		throw new Exception('项目人数超限-99');
    	}
    	$start = $project_id*1000 + 100+ $already_number+1;
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($data as $value){
    			$manager = new Manager();
    			$manager->setTransaction($transaction);
    			$manager->project_id = $project_id;
    			$manager->role= "I";
    			$manager->username = $start++;
    			$manager->password = self::getRandString();
    			$manager->name = $value;
    			if( $manager->save() == false ){
    				$transaction->rollback("数据插入失败");
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}	
    }
    public static function getRandString($length = 6) {
    	$characters = '0123456789';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }
    
    /**
     * 分配被试到面询专家
     */
    public static function allocExaminees($data, $interviewer_id){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($data as $value){
    			$interview = new Interview();
    			$interview->setTransaction($transaction);
    			$interview->manager_id = $interviewer_id;
    			$interview->examinee_id = $value['id'];
    			if( $interview->save() == false ){
    				$transaction->rollback("数据插入失败");
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }
    /**
     * 取消面询分配
     */
    public static function delallocExaminees($data, $interviewer_id){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($data as $value){
    			$interview = Interview::findFirst(
    			array('examinee_id = ?1 AND manager_id = ?2',
    			'bind'=>array(
    			1=>$value, 2=>$interviewer_id
    			))
    			);
    			if (!isset($interview->examinee_id)){
    				continue;
    			}
    			$interview->setTransaction($transaction);
    			if( $interview->delete() == false ){
    				$transaction->rollback("数据删除失败");
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }
    
}