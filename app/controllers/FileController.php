<?php
	/**
	 * @usage 文件下载的控制器类
	 * @author Wangyaohui
	 *
	 */
class FileController extends \Phalcon\Mvc\Controller {
	# 个人综合评价报告导出(项目经理操作)
	public function MgetIndividualComReportAction(){
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
		$path1 = './project/'.$year.'/'.$project_id.'/individual/comprehesive/v1/';
		$path2 = './project/'.$year.'/'.$project_id.'/individual/comprehesive/v2/';
		$path_url1 = '/project/'.$year.'/'.$project_id.'/individual/comprehesive/v1/';
		$path_url2 = '/project/'.$year.'/'.$project_id.'/individual/comprehesive/v2/';
		$name = $examinee->number.'_individual_comprehesive.docx';
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url2.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path1.$name)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url1.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new IndividualComExport();
				$report_tmp_name = $report->report($examinee_id);
				$report_name = $path1.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url1.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 个人综合评价报告导出(领导操作)
	public function LgetIndividualComReportAction(){
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
		// 根据目录结构判断文件是否存在
		$project_id = $examinee->project_id;
		$year = floor($project_id / 100 );
		$path2 = './project/'.$year.'/'.$project_id.'/individual/comprehesive/v2/';
		$path_url2 = '/project/'.$year.'/'.$project_id.'/individual/comprehesive/v2/';
		$name = $examinee->number.'_individual_comprehesive.docx';//修改
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url2.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'当前报告还未生成！'));
			return ;
		}
	}
	# 个人胜任力报告导出(项目经理操作)  project/
	public function MgetIndividualCompetencyReportAction(){
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
		$path1 = './project/'.$year.'/'.$project_id.'/individual/competency/v1/';
		$path2 = './project/'.$year.'/'.$project_id.'/individual/competency/v2/';
		$path_url1 = '/project/'.$year.'/'.$project_id.'/individual/competency/v1/';
		$path_url2 = '/project/'.$year.'/'.$project_id.'/individual/competency/v2/';
		$name = $examinee->number.'_individual_competency.docx'; //原始
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url2.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path1.$name)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url1.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径	
			try{
				$report = new CompetencyExport();
				$report_tmp_name = $report->individualCompetencyReport($examinee_id);
				$report_name = $path1.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url1.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 个人胜任力报告导出(领导操作)  project/
	public function LgetIndividualCompetencyReportAction(){
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
		// 根据目录结构判断文件是否存在
		$project_id = $examinee->project_id;
		$year = floor($project_id / 100 );
		$path2 = './project/'.$year.'/'.$project_id.'/individual/competency/v2/';
		$path_url2 = '/project/'.$year.'/'.$project_id.'/individual/competency/v2/';
		$name = $examinee->number.'_individual_competency.docx';
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url2.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'当前报告还未生成！'));
			return ;
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
		$name = $examinee->number.'_personal_result.xls';
		if(file_exists($path.$name)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name."' style='color:blue;text-decoration:underline;'>个人测评十项报表</a>"));
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
				$report_name = $path.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name."' style='color:blue;text-decoration:underline;'>个人测评十项报表</a>"));
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
	# 项目总体报告导出(项目经理操作)
	public function MgetProjectComReportAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_1 = $project_id.'_comprehesive.docx'; //原始
		$name_2 = $project_id.'_comprehesive_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告</a>"));
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
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目总体报告导出(领导操作)
	public function LgetProjectComReportAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_2 = $project_id.'_comprehesive_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告</a>"));
			return ;
			// 返回 路径
		}else {
			$this->dataReturn(array('error'=>'当前报告还未生成！'));
			return ;
		}
	}
	# 项目班子胜任力报告导出(项目经理操作)
	public function MgetTeamReportAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_1 = $project_id.'_team_report.docx'; //原始
		$name_2 = $project_id.'_team_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:blue;text-decoration:underline;'>班子胜任力报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:blue;text-decoration:underline;'>班子胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new CompetencyExport();
				$report_tmp_name = $report->teamReport($project_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:blue;text-decoration:underline;'>班子胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目班子胜任力报告导出(领导操作)
	public function LgetTeamReportAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_2 = $project_id.'_team_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:blue;text-decoration:underline;'>班子胜任力报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'当前报告还未生成！'));
			return ;
		}
	}
	# 项目系统胜任力报告导出(项目经理操作)
	public function MgetSystemReportAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_1 = $project_id.'_system_report.docx'; //原始
		$name_2 = $project_id.'_system_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path.$name_1)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_1."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new CompetencyExport();
				$report_tmp_name = $report->systemReport($project_id);
				$report_name = $path.$name_1;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name_1."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目系统胜任力报告导出(领导操作)
	public function LgetSystemReportAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/';
		$name_2 = $project_id.'_system_report_1.docx';//修改
		//先判断修改是否存在
		if (file_exists($path.$name_2)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name_2."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'当前报告还未生成！'));
			return ;
		}
	}
	#批量导出个人综合素质报告
	public function getAllIndividualComprehesiveAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//判断个人状态
		$project_id = $manager->project_id;
		$examinee = Examinee::find(array(
			'project_id=?1 and type=0',
			'bind'=>array(1=>$project_id)));
		foreach ($examinee as $examinees) {
			if ($examinees->state <5) {
				$not_fished[$examinees->number] = $examinees->name;
			}else{
				$examinee_array[$examinees->number] = $examinees->id;
			}
		}
		if (isset($not_fished)) {
			$error = '部分人员未完成测评流程！名单如下：<br/>';
			foreach ($not_fished as $key => $value) {
				$error .= $key.'：'.$value.'<br/>';
			}
			$this->dataReturn(array('error'=>$error));
			return;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/individual/comprehesive/';
		$path_url = '/project/'.$year.'/'.$project_id.'/individual/comprehesive/';
		foreach ($examinee_array as $key=> $value) {
			$name = $key.'_individual_comprehesive.docx'; //原始
			if(file_exists($path.$name)){
				continue;
			}else{
				//生成文件，之后返回下载路径
				try{
					$report = new IndividualComExport();
					$report_tmp_name = $report->report($value);
					$report_name = $path.$name;
					$file = new FileHandle();
					$file->movefile($report_tmp_name, $report_name);
					//清空临时文件 主要在tmp中
					$file->clearfiles('./tmp/', $value);
				}catch(Exception $e){
					$this->dataReturn(array('error'=>$e->getMessage()));
					return ;
				}
			}
		}
		$this->dataReturn(array('success'=>'已生成全部被试个人综合素质报告'));
	}
	#批量导出个人胜任力报告
	public function getAllIndividualCompetencyAction(){
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//判断个人状态
		$project_id = $manager->project_id;
		$examinee = Examinee::find(array(
			'project_id=?1 and type=0',
			'bind'=>array(1=>$project_id)));
		foreach ($examinee as $examinees) {
			if ($examinees->state <5) {
				$not_fished[$examinees->number] = $examinees->name;
			}else{
				$examinee_array[$examinees->number] = $examinees->id;
			}
		}
		if (isset($not_fished)) {
			$error = '部分人员未完成测评流程！名单如下：<br/>';
			foreach ($not_fished as $key => $value) {
				$error .= $key.'：'.$value.'<br/>';
			}
			$this->dataReturn(array('error'=>$error));
			return;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/individual/competency/';
		$path_url = '/project/'.$year.'/'.$project_id.'/individual/competency/';
		foreach ($examinee_array as $key=> $value) {
			$name = $key.'_individual_competency.docx'; //原始
			if(file_exists($path.$name)){
				continue;
			}else{
				//生成文件，之后返回下载路径
				try{
					$report = new IndividualComExport();
					$report_tmp_name = $report->report($value);
					$report_name = $path.$name;
					$file = new FileHandle();
					$file->movefile($report_tmp_name, $report_name);
					//清空临时文件 主要在tmp中
					$file->clearfiles('./tmp/', $value);
				}catch(Exception $e){
					$this->dataReturn(array('error'=>$e->getMessage()));
					return ;
				}
			}
		}
		$this->dataReturn(array('success'=>'已生成全部被试个人胜任力报告'));
	}
	#报告上传基本方法
	public function baseUploadAction(){
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
	public function dataReturn($ans){
		$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
		echo json_encode($ans);
		$this->view->disable();
	}
}