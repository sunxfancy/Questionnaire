<?php
	/**
	 * @usage 文件下载的控制器类
	 * @author Wangyaohui
	 *
	 */
class FileController extends \Phalcon\Mvc\Controller {
	
	# 个人综合评价报告导出
	public function getIndividualComReportAction(){
		$this->view->disable();
		$examinee_id = $this->request->getPost('examinee_id', 'int');
		if (empty($examinee_id)){
			$this->dataReturn(array('error'=>'请求参数不完整!'));
			return ;
		}
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//判断个人状态
		$examinee = Examinee::findFirst($examinee_id);
		if (!isset($examinee->id) ){
			$this->dataReturn(array('error'=>'无效的用户编号'));
			return ;
		}
		if ($examinee->state < 5 ){
			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $examinee->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/geren/zonghe/';
		$path_url = '/project/'.$year.'/'.$project_id.'/geren/zonghe/';
		$name_1 = $examinee->number.'_individual_comprehesive.docx'; //原始
		$name_2 = $examinee->number.'_individual_comprehesive_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:red;text-decoration:none;'>个体综合报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:red;text-decoration:none;'>个体综合报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
		
			try{
				$report = new IndividualComExport();
				$report_tmp_name = $report->report($examinee_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:red;text-decoration:none;'>个体综合报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
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