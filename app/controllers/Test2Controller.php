<?php


class Test2Controller extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}

	
	public function test2Action(){
		
		$this->listDir("./DATA");		
	}

function listDir($dir)
{
	echo $dir;
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

	if(is_dir($url)){
		$excelUpload=new ExcelUpload($url."/"."spm1.xls");
		$data=$excelUpload->handleTestExaminee();
		$data[0]['number']=$arr[2];
		print_r($data);
		//PmDB::insertExaminee($data,$project_id,0);
	}
		$paper_name=substr($arr[3],0,strlen($arr[3])-4);
		switch($paper_name){
			case "cpi1": $paper_name="CPI";break;
			case "epps1": $paper_name="EPPS";break;
			case "epqa1": $paper_name="EPQA";break;
			case "ks1": $paper_name="16PF";break;
			case "SCL1": $paper_name="SCL";break;
			case "spm1": $paper_name="SPM";break;
		}
	//检查人员是否存在
	


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
}

}