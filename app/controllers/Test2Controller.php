<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class Test2Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
		set_time_limit(0);
	}

	
	public function test2Action(){
		
		$this->listDir("./DATA");		
	}

function listDir($dir)
{
	if(is_dir($dir))
   	{
     	if ($dh = opendir($dir)) 
		{
        	while (($file = readdir($dh)) !== false)
			{
				if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
                {
         			$this->readExcel($dir."/".$file);
         		}
        	}
        	closedir($dh);
     	}
   	}
}

#这里的储存逻辑：1：项目id->1111; 4：项目名称：准确度测试项目; 3: 管理员id->pm_test; 4：管理员密码:1234

public $flag=true;
function readExcel($url){
	$project_id=1111;
	$manager_id="pmtest";
	$manager_pwd="1234";
	$arr=explode("/", $url);
	//检查项目是否建立(添加过就不再添加)
	if($this->flag){
		$this->initProject($project_id,$manager_id,$manager_pwd);
		$this->flag=false;
	}
	//选择题目模块
	$this->initModule($project_id);
	//检查人员是否添加过(name为标识)
	if(is_dir($url)){
		$this->initExaminee($project_id,$url,$arr);
	}

	//写入答案

		
    $this->initExamineeAns($arr[2],$url);

  
	


}

function initModule($project_id){
	$project_detail=ProjectDetail::findFirst(array(
			"project_id=?1",
			"bind"=>array(1=>$project_id)
		));

	if($project_detail){
		return;
	}
	try{
    		$module_names = array();
    		$module=Module::find();
    		foreach ($module as $module_record) {
    				if($module_record->name=="胜任力"||$module_record->name=="素质测评模块"){
    					continue;
    				}
    				$module_names[] = $module_record->name;
    			}
			$project_detail_info = array();
			$index_names = array();
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
    		//echo "success";
    		return;
    	}catch(Exception $e){
    		echo "fail";
    		return ;
    	}
}

function initExaminee($project_id,$url,$arr){
		$examinee=Examinee::findFirst(array(
			"name=?1",
			"bind"=>array(1=>$arr[2])
		));
		if($examinee){
			return;
		}
		$excelUpload=new ExcelUpload($url."/"."spm1.xls");
		$data=$excelUpload->handleTestExaminee();
		$data[0]['name']=$arr[2];

			try{
				PmDB::insertExaminee($data, $project_id);
			}catch(Exception $e){
				//$this->dataReturn( array('error'=>'记录插入成功！'));
				echo '记录插入失败！';
				return;
			}
		//echo '记录插入成功！';
}

function initProject($project_id,$manager_id,$manager_pwd){
		$project=Project::findFirst($project_id);
		if(!$project){
			$manager_info = array();
			$project_info = array(); 
			$manager_info['username'] =$manager_id;
    		$project_info['name'] = "准确度测试项目";
			$manager_info['password'] =  $manager_pwd;
			$manager_info['name'] = "Phalcon";
			$manager_info['role'] = 'P';
			$project_info['begintime'] = "2000-01-01 00:00:00";
			$project_info['endtime'] = "2050-12-31 00:00:00";
			$project_info['description'] = "这是一个通过public/DATA中导入的原始答题数据进行数据导出的测试的项目";
			$project_info['id'] = $project_id;
			$project_info['state'] = 0;
			try{
        		AdminDB::addProject($project_info, $manager_info);
	        }catch(Exception $e){
	        	echo "fail";
	        }
		}
		return;
}

function initExamineeAns($id,$url){
		$examinee=Examinee::findFirst(array(
				"name=?1",
				"bind"=>array(1=>$id)
			));
		if(!$examinee){
			return;
		}
		$id=$examinee->id;
		$questionAns=QuestionAns::findFirst(array(
				"examinee_id=?1",
				"bind"=>array(1=>$id)
			));
		if($questionAns){
			return;
		}

		$ansArr=array('CPI'=>'AR2','EPPS'=>'AM2','EPQA'=>'O2','16PF'=>'BD2','SCL'=>'S2','SPM'=>'Q2');
    	if(is_dir($url)){
    		if ($dh = opendir($url)) 
			{
				
	        	while (($file = readdir($dh)) !== false)
				{
					if($file!="." && $file!="..")
	                {
	                	$examinee->state=1;
	                	$examinee->save();
	                	$excelUpload=new ExcelUpload($url."/".$file);
	                	$file=strtolower($file);
	                	$paper_name="";
	         			switch ($file) {
	         				case 'cpi1.xls': $paper_name="CPI";break;
	         				case 'epps1.xls': $paper_name="EPPS";break;
	         				case 'epqa1.xls': $paper_name="EPQA";break;
	         				case 'ks1.xls' : $paper_name="16PF";break;
	         				case 'scl1.xls' : $paper_name="SCL";break;
	         				case 'spm1.xls' : $paper_name="SPM";break;
	         			}
	         			$paper=Paper::findFirst(array(
	         					"name=?1",
	         					"bind"=>array(1=>$paper_name)
	         				));
						$options_ret = $excelUpload->handleOption($ansArr[$paper_name]);
	         			$manager     = new TxManager();
	         			$transaction = $manager->get();
	         			$questionAns=new QuestionAns();
	         			$questionAns->setTransaction($transaction);
	         			$questionAns->paper_id=$paper->id;

	         			$questionAns->examinee_id=$id;
	         			$questionAns->option=$options_ret[0];
	         			$questionAns->question_number_list=$options_ret[1];
	         			$questionAns->time="120";
	         			if( $questionAns->save() == false ){
							$transaction->rollback('数据库插入失败-'.print_r($questionAns,true));
						}
						$transaction->commit();
				    }	
			
	        	}
	        	closedir($dh);
	     	}
    	}
    	
    	return;
}

}