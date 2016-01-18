<?php
	/**
	 * @usage 用以导入最后的评语表
	 * @author Wangyaohui
	 *
	 */

class CommentController extends \Phalcon\Mvc\Controller {

	public function initialize(){

		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	
	}
	
	public function uploadcompetencyAction(){
		die('finished -|-_-|-');
		try{
			$file_path = './comment/competency_comment.xls';
			$shengHandler = new ExcelUpload($file_path);
			$data = $shengHandler->handleCompetency();
			$dbHandle = new DBHandle();
			$dbHandle->insertCompetency($data);
			echo 'finished';
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	
	public function uploadcomprehensiveAction(){
		die('finished -|-_-|-');
		try{
			$file_path = './comment/comprehensive_comment.xlsx';
			$zongHandler = new ExcelUpload($file_path);
			$data = $zongHandler->handleComprehensive();
			$dbHandle = new DBHandle();
			$dbHandle->insertComprehensive($data);
			echo 'finished';
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
		
	}
	
	
	public function uploadchildrenofindexAction(){
		die('finished -|-_-|-');
		try{
			$file_path = './comment/childrenOfIndexComment.xlsx';
			set_time_limit(0);
			$childHandler = new ExcelUpload($file_path);
			$data = $childHandler->handleChildComment();
			$dbHandle = new DBHandle();
			$dbHandle->insertChildIndexComment($data);
			echo 'finished';
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	
	
	
}
