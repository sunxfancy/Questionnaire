<?php
/**
 * use for developer handle the DB[insert|update]: Paper, Question, **df[Cpi|Epps|Epqa|Ks|Scl|Som];
 * 
 * @author Wangyaohui
 * @finished 2015-8-18
 */
class UploadController extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction() {	
		#进入上传页面	
	}
	/**
	 * 导入试卷信息 6套
	 * @return boolean
	 */
	public function uploadpaperAction(){
		try{
		$insert_state = DBHandle::insertPaperData();
		if ($insert_state){
			echo "数据导入成功";
			return true;
		}
		}catch(Exception $e){
			echo $e->getMessage();
			echo "<br />failed<br />";
			return false;
		}		
	}
	/**
	 * 查看试卷信息 
	 */
	public function checkpaperAction(){
		DBHandle:: checkPaperData();
	}
	/**
	 * 更新试卷信息
	 * 更新试卷必须在原有数据的基础上进行操作，否则会报错
	 */
	public function updatepaperAction(){
		try{
		$update_state = DBHandle::updatePaperData();
		if($update_state){
			echo "数据更新成功";
		}
		} catch(Exception $e){
			echo $e->getMessage();
			echo "<br />failed<br />";
			return ;
		}	
	}
	/**
	 * 删除试卷
	 * 删除试卷将在系统中不被允许
	 */
	public function deletepaperAction(){
		// die("not allowed");
		try{
		$delete_state = DBHandle::deletePaperData();
		if($delete_state){
			echo "数据删除成功";
		}
		}catch(Exception $e){
			echo $e->getMessage();
			echo "<br />failed<br />";
			return ;
		}
	}
	/**
	 * 上传SPM题库
	 * SPM 60道图片题 图片上传至/public/spmimages/
	 */
	public function uploadspmAction(){
		try{
			$insert_state = DBHandle::insertSPMtk();
			if($insert_state){
				echo "spm insert completely";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}		
	}
	public function checkspmAction(){
		try{
		DBHandle::checkTKByName('SPM');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	public function deletespmAction(){
		// die("not allowed!");
		try{
			$delete_state = DBHandle::deleteTKByName('SPM');
			if($delete_state){
				echo "spm delete completely";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	/**
	 * 题库文件上传总调度,分控到各个上传单位
	 */
	public function uploadtkAction(){
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				 if(empty($file->getName())){
				 	echo "请先上传相应文件";
				 	return false;
				 }else{
				 	$params = $this->dispatcher->getParams();
				 	if(count($params)!=1){
				 		echo "Parameters number ERROR";
				 	}else{
				 		$file_name = null;
				 		$file_name .= date("Y_m_d_H_i_s_");
				 		$file_name .= rand(1,200)."_";
				 		$file_name .= $file->getName();
				 		$file_path = "./upload/";
				 		$file_path .= $file_name;
				 		$file->moveTo($file_path);
				 		switch(strtoupper(trim($params[0]))){
				 			case "SCL" : $this->dispatcher->forward(
							array(
								'action' => 'uploadSCL',
								'params' => array('file_path'=>$file_path, 'type'=>'SCL')
							)
				 			); break;
				 			
				 			case "CPI" : $this->dispatcher->forward(
							array(
								'action' => 'uploadCPI',
								'params' => array('file_path'=>$file_path, 'type'=>'CPI')
							)
				 			); break; 
				 			case "KS" : $this->dispatcher->forward(
							array(
								'action' => 'uploadKS',
								'params' => array('file_path'=>$file_path, 'type'=>'KS')
							)
				 			); break;
				 			case "EPQA" : $this->dispatcher->forward(
							array(
								'action' => 'uploadEPQA',
								'params' => array('file_path'=>$file_path, 'type'=>'EPQA')
							)
				 			);break;
				 			case "EPPS" : $this->dispatcher->forward(
							array(
								'action' => 'uploadEPPS',
								'params' => array('file_path'=>$file_path, 'type'=> 'EPPS')
							)
				 			); break;
				 			default : if(file_exists($file_path)) { unlink($file_path); }; die("Parameters content ERROR"); 
				 		}
				 		
				 	}
				 }
			} 
		}else{
			echo "no allowed to get here, please return and upload some files!";
		}
	}
	/**
	 * 分发控制action到各个action的参数校验
	 * @param unknown $params = array ('file_path'=>'**', 'type'=>'**')
	 * @param unknown $name = such as 'SCL' 'EPPS' so on
	 * @return boolean
	 */
	public static function uploadParamsCheck ($params, $name){
		//print_r($params);
		if ( count($params) != 2){
			return false;
		}else{
			if(strtoupper(trim($params['type'] )) != strtoupper(trim($name))) {
				return false;
			}else {
				if (file_exists($params['file_path'])){
					return true;
				}else{
					return false;
				}
			}
		}
	}
	/**
	 * 上传SCL题库
	 */
	public function uploadsclAction() {
		$params = $this->dispatcher->getParams();
		$state = self::uploadParamsCheck($params, 'SCL');
		if (!$state){
			die("please check the Parameters transmission!");
		}
		$file_path = $params['file_path'];
		#调用读取excel
		try{
		$SCLexcelHander = new ExcelUpload($file_path);
		$scl_data = $SCLexcelHander->handleSheetOne('SCL');
		unlink($file_path);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		#将数据传入写入数据库 
		try{
		$insert_state = DBHandle::insertTkByName('SCL', $scl_data);
		if ($insert_state){
			echo "SCL数据导入成功";
		}
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	public function deletesclAction(){
		// die("not allowed");
		try{
			$delete_state = DBHandle::deleteTKByName('SCL');
			if($delete_state){
				echo "SCL删除成功";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	public function checksclAction(){
		try{
		DBHandle::checkTKByName('SCL');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	/**
	 * 上传EPPS题库
	 */
	public function uploadeppsAction(){
		$params = $this->dispatcher->getParams();
		$state = self::uploadParamsCheck($params, 'EPPS');
		if (!$state){
			die("please check the Parameters transmission!");
		}
		$file_path = $params['file_path'];
		#调用读取excel
		try{
			$EPPSexcelHander = new ExcelUpload($file_path);
			$epps_data = $EPPSexcelHander->handleSheetTwo('EPPS');
			unlink($file_path);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		#将数据传入写入数据库
		try{
		$insert_state = DBHandle::insertEPPStk($epps_data);
		if ($insert_state){
			echo "EPPS数据导入成功";
		}
		}catch(Exception $e){
				echo $e->getMessage();
				return false;
		}	
	}
	public function deleteeppsAction(){
		// die("not allowed");
		try{
			$delete_state = DBHandle::deleteTKByName('EPPS');
			if($delete_state){
				echo "EPPS删除成功";
			}
		}catch(Exception $e){
				echo $e->getMessage();
				return false;
		}
	}
	public function checkeppsAction(){
		try{
				$delete_state = DBHandle::checkTKByName('EPPS');
			}catch(Exception $e){
				echo $e->getMessage();
				return false;
			}
		}
	/**
	 * 上传EPQA
	 */
	public function uploadEPQAAction(){
		$params = $this->dispatcher->getParams();
		$state = self::uploadParamsCheck($params, 'EPQA');
		if (!$state){
			die("please check the Parameters transmission!");
		}
		$file_path = $params['file_path'];
		#调用读取excel
		try{
		$EPQAexcelHander = new ExcelUpload($file_path);
		$epqa_data = $EPQAexcelHander->handleSheetOne('EPQA');
		unlink($file_path);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		#将数据传入写入数据库 
		try{
		$insert_state = DBHandle::insertTkByName('EPQA', $epqa_data);
		if ($insert_state){
			echo "EPQA数据导入成功";
		}
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	public function checkepqaAction(){
		try{
			DBHandle::checkTKByName('EPQA');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	public function deleteepqaAction(){	
		// die("not allowed");
		try{
			$delete_state = DBHandle::deleteTKByName('EPQA');
			if($delete_state){
				echo "EPQA删除成功";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	/**
	* 上传CPI题库
	*/
	public function uploadcpiAction(){
		$params = $this->dispatcher->getParams();
		$state = self::uploadParamsCheck($params, 'CPI');
		if (!$state){
			die("please check the Parameters transmission!");
		}
		$file_path = $params['file_path'];
		#调用读取excel
		try{
		$CPIexcelHander = new ExcelUpload($file_path);
		$cpi_data = $CPIexcelHander->handleSheetOne('CPI');
		unlink($file_path);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		#将数据传入写入数据库 
		try{
		$insert_state = DBHandle::insertTkByName('CPI', $cpi_data);
		if ($insert_state){
			echo "CPI数据导入成功";
		}
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	public function checkcpiAction(){
		try{
			DBHandle::checkTKByName('CPI');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	public function deletecpiAction(){
		// die("not allowed");
		try{
			$delete_state = DBHandle::deleteTKByName('CPI');
			if($delete_state){
				echo "CPI删除成功";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	/**
	 * 上传16PF
	 */
	public function uploadksAction(){
		$params = $this->dispatcher->getParams();
		$state = self::uploadParamsCheck($params, 'KS');
		if (!$state){
			die("please check the Parameters transmission!");
		}
		$file_path = $params['file_path'];
		#调用读取excel
		try{
			$KSexcelHander = new ExcelUpload($file_path);
			$ks_data = $KSexcelHander->handleSheetThree('KS');
			unlink($file_path);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		#将数据传入写入数据库
		try{
		$insert_state = DBHandle::insertKStk($ks_data);
		if ($insert_state){
			echo "16PF(KS)数据导入成功";
		}
		}catch(Exception $e){
				echo $e->getMessage();
				return false;
		}	
	}	
	public function checkksAction(){	
		try{
			DBHandle::checkTKByName('16PF');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	public function deleteksAction(){
		//die("not allowed");		
		try{
			$delete_state = DBHandle::deleteTKByName('16PF');
			if($delete_state){
				echo "16PF删除成功";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	/**
	 * 上传报告评语
	 */
	public function uploadreportcommentAction(){
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
            $data = $excelHander->handleReportComment();
            if(file_exists($file_path)) unlink($file_path);
		    DBHandle::insertReportComment($data);
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
	/**
	 * 上传胜任力指标
	 */
	public function uploadcompetencyAction(){
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
            $data = $excelHander->handleCompetency();
            if(file_exists($file_path)) unlink($file_path);
		    DBHandle::insertCompetency($data);
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
	public function insertmiddleAction(){
		$middle_file = __DIR__ . "/../../app/config/middlelayer.json";
		$middle_json = $this->loadJson($middle_file);
		DBHandle::insertMiddle($middle_json);
	}
	public function loadJson($filename, $toarray = true)
	{
		$json_string = file_get_contents($filename);
		$json_string = preg_replace('/[\r\n]/', '', $json_string);
		$json = json_decode($json_string, $toarray);
		if ($json == null) {
			// echo json_last_error_msg();
			// throw new Exception(json_last_error_msg());
		} 
		return $json;
	}
}