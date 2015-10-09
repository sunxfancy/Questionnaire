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
		$path = './project/'.$year.'/'.$project_id.'/individual/comprehesive/';
		$path_url = '/project/'.$year.'/'.$project_id.'/individual/comprehesive/';
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
	public function getIndividualCompetencyReportAction(){
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
		$path = './project/'.$year.'/'.$project_id.'/individual/competency/';
		$path_url = '/project/'.$year.'/'.$project_id.'/individual/competency/';
		$name_1 = $examinee->number.'_individual_competency.docx'; //原始
		$name_2 = $examinee->number.'_individual_competency_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:red;text-decoration:none;'>个人胜任力报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:red;text-decoration:none;'>个人胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
		
			try{
				$report = new IndividualCompetencyExport();
				$report_tmp_name = $report->report($examinee_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:red;text-decoration:none;'>个人胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 个人十项报表数据导出
	public function getPersonalResultAction(){
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
		if ($examinee->state < 1 ){
			$this->dataReturn(array('error'=>'用户还未完成答题！'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $examinee->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/individual/personal_result/';
		$path_url = '/project/'.$year.'/'.$project_id.'/individual/personal_result/';
		$name_1 = $examinee->number.'_personal_result.xls'; //原始
		$name_2 = $examinee->number.'_personal_result_1.xls';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:red;text-decoration:none;'>个人测评十项报表</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:red;text-decoration:none;'>个人测评十项报表</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			if ($examinee->state > 3) {
				$report_tmp_name = CheckoutExcel::checkoutExcel11($examinee,$project_id);
			}else{
				try{
					$id = $examinee->id;
					BasicScore::handlePapers($id);
					BasicScore::finishedBasic($id);
					FactorScore::handleFactors($id);
					FactorScore::finishedFactor($id);
					IndexScore::handleIndexs($id);
					IndexScore::finishedIndex($id);
					$report_tmp_name = CheckoutExcel::checkoutExcel11($examinee,$project_id);
				}catch(Exception $e){
					$this->dataBack(array('error'=>$e->getMessage()));
					return ;
				}
			}
			try{
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:red;text-decoration:none;'>个人测评十项报表</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 个人信息数据导出
	public function getIndividualInfomationAction(){
		
	}
	# 项目总体报告导出
	public function getProjectComReportAction(){
		$this->view->disable();
		$project_id = $this->request->getPost('project_id', 'int');
		if (empty($project_id)){
			$this->dataReturn(array('error'=>'请求参数不完整!'));
			return ;
		}
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_1 = $project_id.'_team_report.docx'; //原始
		$name_2 = $project_id.'_team_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:red;text-decoration:none;'>人才综合测评总体分析报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:red;text-decoration:none;'>人才综合测评总体分析报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new ProjectComExport();
				$report_tmp_name = $report->report($project_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:red;text-decoration:none;'>人才综合测评总体分析报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目班子胜任力报告导出
	public function getTeamReportAction(){
		$this->view->disable();
		$project_id = $this->request->getPost('project_id', 'int');
		if (empty($project_id)){
			$this->dataReturn(array('error'=>'请求参数不完整!'));
			return ;
		}
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_1 = $project_id.'_team_report.docx'; //原始
		$name_2 = $project_id.'_team_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:red;text-decoration:none;'>班子胜任力报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:red;text-decoration:none;'>班子胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new WordExport();
				$report_tmp_name = $report->teamReport($project_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:red;text-decoration:none;'>班子胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目系统胜任力报告导出
	public function getSystemReportAction(){
		$this->view->disable();
		$project_id = $this->request->getPost('project_id', 'int');
		if (empty($project_id)){
			$this->dataReturn(array('error'=>'请求参数不完整!'));
			return ;
		}
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_1 = $project_id.'_system_report.docx'; //原始
		$name_2 = $project_id.'_system_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:red;text-decoration:none;'>系统胜任力报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:red;text-decoration:none;'>系统胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new WordExport();
				$report_tmp_name = $report->systemReport($project_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:red;text-decoration:none;'>系统胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	#批量导出个人综合素质报告
	public function getAllIndividualComprehesive(){
		$this->view->disable();
		$project_id = $this->request->getPost('project_id', 'int');
		if (empty($project_id)){
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
		$examinee = Examinee::find(array(
			'project_id=?1 and type=0',
			'bind'=>array(1=>$project_id)));
		foreach ($examinee as $examinees) {
			if ($examinees->state <5) {
				$this->dataReturn('error'=>'还有人未完成测评流程！');
				return;
			}
			$examinee_array[] = $examinees->id;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $examinee->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/individual/comprehesive/';
		$path_url = '/project/'.$year.'/'.$project_id.'/individual/comprehesive/';
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
	#批量导出个人胜任力报告
	public function getAllIndividualCompetency(){
		
	}
	public function dataReturn($ans){
		$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
		echo json_encode($ans);
		$this->view->disable();
	}
	
}