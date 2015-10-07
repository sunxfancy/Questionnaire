<?php
	/**
	 * @usage 文件上传和下载的控制器类
	 * @author Wangyaohui
	 *
	 */
class FileController extends \Phalcon\Mvc\Controller {
	
	# 个人综合评价报告导出
	public function getIndividualComReport($examinee_id){
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
	}
	# 个人胜任力报告导出  project/
	public function getIndividualSheReport($examinee_id){
		
	}
	# 个人十项报表数据导出
	public function getIndividualTenSheet($examinee_id){
		
	}
	# 个人信息数据导出
	public function getIndividualInfo($examinee_id){
		
	}
	
	# 系统被试信息导出---pm
	public function getExamineesList(){
		
	}
	# 系统专家列表导出---pm
	public function getInterviewersList(){
		
	}
	# 系统领导列表导出 ---pm
	public function getLeadersList(){
		
	}
	# 项目总体报告导出
	public function getProjectComReport(){
		
	}
	# 项目班子报告导出
	public function getBanSheReport(){
		
	}
	# 项目系统报告导出
	public function getXiSheReport(){
		
	}
	public function dataReturn($ans){
		$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
		echo json_encode($ans);
		$this->view->disable();
	}
	
}