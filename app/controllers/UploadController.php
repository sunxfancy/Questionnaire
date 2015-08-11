<?php
class UploadController extends \Phalcon\Mvc\Controller {
	
	public function initialize() {
        $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
    }
	#上传页
	public function indexAction() {
		
		
	}
	#上传SCL题库
	public function uploadSCLAction() {
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			#文件读取
			$SCLContent = null;
			$SCLexcelHander = new ExcelUpload($filePath);
			$SCLContent = $SCLexcelHander->handleSCL();
			unlink($filePath);
			if(!empty($SCLContent)){
				#数据入库操作
				$paper_id = null;
				$options = "没有|很轻|中等|偏重|严重";
				foreach($SCLContent as $rowContent ){
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "SCL题库导入成功";
			}

		}
	}
	#上传EPPS表
	public function uploadEPPSAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$EPPSContent = null;
			$EPPSexcelHander = new ExcelUpload($filePath);
			#EPPS处理与SCL同
			$EPPSContent = $EPPSexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($EPPSContent)){
				#数据入库操作
				$paper_id = null;
				$topic = null;
				$options = null;
				foreach($EPPSContent as $rowContent ){
					$options = $rowContent[1].'|'.$rowContent[2];
					$question = new Question();
					$question->topic = $topic;
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "EPPS题库导入成功";
			}
		
		}
	}
	#上传EPQA
	public function uploadEPQAAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$EPQAContent = null;
			$EPQAexcelHander = new ExcelUpload($filePath);
			#EPPS处理与SCL同
			$EPQAContent = $EPQAexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($EPQAContent)){
				#数据入库操作
				$paper_id = null;
				$topic = null;
				$options = "是|不是";
				foreach($EPQAContent as $rowContent ){
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "EPQA题库导入成功";
			}
		}
	}
	#上传CPI 
	public function uploadCPIAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$CPIContent = null;
			$CPIexcelHander = new ExcelUpload($filePath);
			#CPI处理与SCL同
			$CPIContent = $CPIexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($CPIContent)){
				#数据入库操作
				$paper_id = null;
				$topic = null;
				$options = "是|否";
				foreach($CPIContent as $rowContent ){
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "CPI题库导入成功";
			}
		}
	}
	#上传KS(16PF)
	public function uploadKSAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$KSContent = null;
			$KSexcelHander = new ExcelUpload($filePath);
			#CPI处理与SCL同
			$KSContent = $KSexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($KSContent)){
				#数据入库操作
				$paper_id = null;
				$options = null;
				foreach($KSContent as $rowContent ){
					$options = $rowContent[2].'|'.$rowContent[3].'|'.$rowContent[4];
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "16PF题库导入成功";
			}
		}
	}
	
}