<?php
	/**
	 * @usage 文件下载上传的控制器类
	 * @author Wangyaohui
	 *
	 */
class FileController extends \Phalcon\Mvc\Controller {
	# 个人综合评价报告导出(项目经理操作)
	public function mgetindividualcomreportAction(){
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
		$path1 = './project/'.$year.'/'.$project_id.'/individual/comprehensive/v1/';
		$path2 = './project/'.$year.'/'.$project_id.'/individual/comprehensive/v2/';
		$path_url1 = '/project/'.$year.'/'.$project_id.'/individual/comprehensive/v1/';
		$path_url2 = '/project/'.$year.'/'.$project_id.'/individual/comprehensive/v2/';
		$name = $examinee->number.'_individual_comprehensive.docx';
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>"点击下载<br /><br /><a href='".$path_url2.$name."' style='color:blue;text-decoration:underline;'>个体综合报告--修改版</a><br /><br /><a href='".$path_url1.$name."' style='color:blue;text-decoration:underline;'>个体综合报告--原版</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path1.$name)){
			$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url1.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
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
				$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url1.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}

	#个人原始答案导出
	public function mgetindividualanstableAction(){
		$this->view->disable();
		$manager=$this->session->get("Manager");
		$examinee_id = $this->request->getPost('examinee_id', 'int');
		if (empty($examinee_id)){
			$this->dataReturn(array('error'=>'请求参数不完整!'));
			return ;
		}

		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		$examinee = Examinee::findFirst($examinee_id);
		if (!isset($examinee->id) ){
			$this->dataReturn(array('error'=>'无效的用户编号'));
			return ;
		}
		if ($examinee->state < 1 ){
			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
			return ;
		}
		//对于原始答案，目录结构中不进行保留，因此，不必进行存在性和修改情况的判断
		$excelexport=new ExcelExport();
		$anstable=$excelexport->anstableExport($examinee,$manager);
		if($anstable==false){
			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
			return ;
		}
		$this->dataReturn(array("success"=>"点击下载 <a href='".$anstable."'>原始答案</a>"));
	}
	#个人因子分数导出
	public function mgetindividualdataAction(){
		$this->view->disable();
		$manager=$this->session->get("Manager");
		$examinee_id = $this->request->getPost('examinee_id', 'int');
		if (empty($examinee_id)){
			$this->dataReturn(array('error'=>'请求参数不完整!'));
			return ;
		}

		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		$examinee = Examinee::findFirst($examinee_id);
		if (!isset($examinee->id) ){
			$this->dataReturn(array('error'=>'无效的用户编号'));
			return ;
		}
		if ($examinee->state < 1 ){
			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
			return ;
		}
		//对于原始答案，目录结构中不进行保留，因此，不必进行存在性和修改情况的判断
		$dataexport=new IndividualDataExport();
		$anstable=$dataexport->excelExport($examinee_id,$manager);
		if($anstable==false){
			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
			return ;
		}
		$this->dataReturn(array("success"=>"点击下载 <a href='".$anstable."'>个人因子分数数据表</a>"));
	}
	# 个人综合评价报告导出(领导操作)
	public function lgetindividualcomreportAction(){
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
		$path2 = './project/'.$year.'/'.$project_id.'/individual/comprehensive/v2/';
		$path_url2 = '/project/'.$year.'/'.$project_id.'/individual/comprehensive/v2/';
		$name = $examinee->number.'_individual_comprehensive.docx';//修改
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url2.$name."' style='color:blue;text-decoration:underline;'>个体综合报告</a>"));
			return ;
		}else{
			$this->dataReturn(array('error'=>'个体综合报告还未生成！'));
			return ;
		}
	}
	# 个人胜任力报告导出(项目经理操作)  
	public function mgetindividualcompetencyreportAction(){
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
		$name = $examinee->number.'_individual_competency.docx'; // name 相同
		//先判断修改是否存在
		if (file_exists($path2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>"点击下载<br /><br /><a href='".$path_url2.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告--修改版</a><br /><br /><a href='".$path_url1.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告--原版</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path1.$name)){
			$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url1.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
			return ;
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
				$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url1.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 个人胜任力报告导出(领导操作)  
	public function lgetindividualcompetencyreportAction(){
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
			$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url2.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'个体胜任力报告还未生成！'));
			return ;
		}
	}
	# 个人十项报表数据导出 ---- pm &  interviewer 
	public function getpersonalresultAction(){
		$this->view->disable();
		$examinee_id = $this->request->getPost('examinee_id', 'int');
		$examinee_info = Examinee::findFirst(array('id=?1','bind'=>array(1=>$examinee_id)));
		if (!isset($examinee_info->id)){
			$this->dataReturn(array('error'=>'不存在的被试编号-'.$examinee_id));
			return ;
		}
		//个体报告的导出必须是manager pm & interviwer
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//判断个人状态
		if ($examinee_info->state == 0 ){
			//还未开始答题
			$this->dataReturn(array('error'=>'被试还未答题'));
			return ;
		}else if ($examinee_info -> state < 4 ){
			//算分流程未完成
			try{
			BasicScore::handlePapers($examinee_info->id);
			BasicScore::finishedBasic($examinee_info->id);
			FactorScore::handleFactors($examinee_info->id);
			FactorScore::finishedFactor($examinee_info->id);
			IndexScore::handleIndexs($examinee_info->id);
			IndexScore::finishedIndex($examinee_info->id);
			}catch(Exception $e){
				$this->dataReturn(array('error'=>'被试算分流程未完成，原因：'.$e->getMessage()));
				return ;
			}
		}else{
			//算分流程已完成
			//add nothing 
		}
		// 根据目录结构判断文件是否存在
		$year = floor($examinee_info->project_id/ 100 );
		$path = './project/'.$year.'/'.$examinee_info->project_id.'/individual/personal_result/';
		$path_url = '/project/'.$year.'/'.$examinee_info->project_id.'/individual/personal_result/';
		$name = $examinee_info->number.'_personal_result.xlsx';
		if(file_exists($path.$name)) {
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url.$name."' style='color:blue;text-decoration:underline;'>个人测评十项报表</a>"));
			return ;
		}else{
			try{
				$checkout_excel = new CheckoutExcel();
				$report_tmp_name = $checkout_excel->excelExport($examinee_info);
				$report_name = $path.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $examinee_info->id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url.$name."' style='color:blue;text-decoration:underline;'>个人测评十项报表</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>'个人测评十项报表生成失败，原因：'.$e->getMessage()));
				return ;
			}
		}
	}

	# 项目总体报告导出(项目经理操作)
	public function mgetprojectcomreportAction(){
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
		$path_1 = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_2 = './project/'.$year.'/'.$project_id.'/system/report/v2/';
		$path_url_1 = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url_2 = '/project/'.$year.'/'.$project_id.'/system/report/v2/';
		$name = $project_id.'_comprehensive.docx'; //name 相同
		//先判断修改是否存在
		if (file_exists($path_2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载<br /><br /><a href=\''.$path_url_2.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告--修改版</a><br /><br />".'<a href=\''.$path_url_1.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告--原版</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path_1.$name)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url_1.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new ProjectComExport();
				$report_tmp_name = $report->report($project_id);
				$report_name = $path_1.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载<a href=\''. $path_url_1.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体分析报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目总体报告导出(领导操作)
	public function lgetprojectcomreportAction(){
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
		$path = './project/'.$year.'/'.$project_id.'/system/report/v2/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/v2/';
		$name_2 = $project_id.'_comprehensive.docx';//name 
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
	public function mgetteamreportAction(){
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
		$path_1 = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_2 = './project/'.$year.'/'.$project_id.'/system/report/v2/';
		$path_url_1 = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url_2 = '/project/'.$year.'/'.$project_id.'/system/report/v2/';
		$name = $project_id.'_team.docx'; //name
		//先判断修改是否存在
		if (file_exists($path_2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<br /><br /><a href=\''.$path_url_2.$name."' style='color:blue;text-decoration:underline;'>班子胜任力报告--修改版</a>".'<br /><br /><a href=\''.$path_url_1.$name."' style='color:blue;text-decoration:underline;'>班子胜任力报告--原版</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path_1.$name)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url_1.$name."' style='color:blue;text-decoration:underline;'>班子胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new CompetencyExport();
				$report_tmp_name = $report->teamReport($project_id);
				$report_name = $path_1.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_1.$name."' style='color:blue;text-decoration:underline;'>班子胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目班子胜任力报告导出(领导操作)
	public function lgetteamreportAction(){
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
		$path = './project/'.$year.'/'.$project_id.'/system/report/v2/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/v2/';
		$name_2 = $project_id.'_team.docx';//name 
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
	public function mgetsystemreportAction(){
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
		$path_1 = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_2 = './project/'.$year.'/'.$project_id.'/system/report/v2/';
		$path_url_1 = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url_2 = '/project/'.$year.'/'.$project_id.'/system/report/v2/';
		$name = $project_id.'_system.docx'; //name
		//先判断修改是否存在
		if (file_exists($path_2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<br /><br /><a href=\''.$path_url_2.$name."' style='color:blue;text-decoration:underline;'>系统胜任力报告--修改版</a>".'<br /><br /><a href=\''.$path_url_1.$name."' style='color:blue;text-decoration:underline;'>系统胜任力报告--原版</a>"));
			return ;
			// 返回 路径
		}else if(file_exists($path_1.$name)){
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url_1.$name."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
			return ;
			//返回路径
		}else{
			//生成文件，之后返回下载路径
			try{
				$report = new CompetencyExport();
				$report_tmp_name = $report->systemReport($project_id);
				$report_name = $path_1.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''. $path_url_1.$name."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	# 项目系统胜任力报告导出(领导操作)
	public function lgetsystemreportAction(){
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
		$path_2 = './project/'.$year.'/'.$project_id.'/system/report/v2/';
		$path_url_2 = '/project/'.$year.'/'.$project_id.'/system/report/v2/';
		$name = $project_id.'_system.docx'; //name
		//先判断修改是否存在
		if (file_exists($path_2.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载&nbsp;<a href=\''.$path_url_2.$name."' style='color:blue;text-decoration:underline;'>系统胜任力报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'当前报告还未生成！'));
			return ;
		}
	}
	
	#一键生成所有人员的综合报告：  以及胜任力报告
	# 先判断所有人的报告是否可以全部生成 如果可以生成则生成， 否则不生成，反馈回不能生成的编号以及原因
	public function getallindividualcomprehesiveAction($type){
		$this->view->disable();
		//个体报告的导出必须是manager
		set_time_limit(0);
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		$year = floor($manager->project_id/ 100 );
		switch($type){
			case 1 : $path = './project/'.$year.'/'.$manager->project_id .'/individual/comprehensive/v1/';//个体综合原始报告位置
					 $suffix = '_individual_comprehensive.docx';
			break;
			case 2 : $path = './project/'.$year.'/'.$manager->project_id .'/individual/competency/v1/';//个体胜任力原始报告位置
					 $suffix = '_individual_competency.docx';		 
			break;
			default : $this->dataReturn(array('error'=>'请求参数错误-'.$type)); return ;
		}
		// 获取项目下的被试名单
		$examinees = $this->modelsManager->createBuilder()
		->columns(array(
				'number', 'name', 'id','state'
		))
		->from('Examinee')
		->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 ')
		->getQuery()
		->execute()
		->toArray();
		//分两个数组
		$not_finished_exam = array();  // 测评还未完成的    state < 5 面询专家意见填写完成后 
		$not_finished_report = array(); // 报告还未生成的       
		
		//$path = './project/'.$year.'/'.$manager->project_id .'/individual/comprehensive/v1/';//个体综合原始报告位置
		foreach ($examinees as $examinee_info) {
			if ( $examinee_info['state'] < 5 ) {
				$not_finished_exam[] = $examinee_info['number'].'-'.$examinee_info['name'].'-测评流程未完成';
			}else{
				//$name =  $examinee_info['number'].'_individual_comprehensive.docx';
				$name = $examinee_info['number'].$suffix;
				if (!file_exists($path.$name)){
					$not_finished_report[] = $examinee_info;
				}
			}
		}
		if (!empty($not_finished_exam)){
			$this->dataReturn(array('error'=>$not_finished_exam));
			return ;
		}
		if (!empty($not_finished_report)){
			//完成个体综合报告的生成
			//个体报告生成可能出现的exception
			$report_generate_error = array();
			foreach($not_finished_report as $examinee_info_1){
				try{
					$report = new IndividualComExport();
					$report_tmp_name = $report->report($examinee_info_1['id']);
					//$name = $examinee_info_1['number'].'_individual_comprehensive.docx';
					$name = $examinee_info_1['number'].$suffix;
					$report_name = $path.$name;
					$file = new FileHandle();
					$file->movefile($report_tmp_name, $report_name);
					//清空临时文件 主要在tmp中
					$file->clearfiles('./tmp/', $examinee_info_1['id']);
					//个体综合报告生成完成
				}catch(Exception $e){
					$report_generate_error[] = $examinee_info_1['number'].'-'.$examinee_info_1['name'].'-报告生成失败，原因：'.$e->getMessage();
				}
			}
			if (!empty($report_generate_error)){
				$this->dataReturn(array('error'=>$report_generate_error));
				return ;
			}
		}
		$this->dataReturn(array('success'=>'true'));
		return ;
	}
	
	public function dataReturn($ans){
		$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
		echo json_encode($ans);
		$this->view->disable();
	}
	
	#单一文件上传
	#（1）综合报告上传 __1 #（2）班子胜任力报告 __2 （3）	系统胜任力报告 __3 
	public function fileuploadv1Action($file_type){
		#严格json格式{ '···' : '···'},json_encode 无法实现
		try{
			$file_path = null;
			if ($this->request->hasFiles()) {
				foreach ($this->request->getUploadedFiles() as $file) {
					if(empty($file->getName())){
						echo "{'error':'上传文件不能为空'}";
						return ;
					}else{
						//判断有相应文件上传
						//报告上传必须是manager
						$manager = $this->session->get('Manager');
						if(empty($manager)) {
							echo "{'error':'用户信息失效，请重新登录!'}";
							return ;
						}
						//判断报告的类型确定报告的应该的名称
						$file_name  = '';
						$file_name  .= $manager->project_id;
						switch ($file_type){
							case 1: $file_name .= '_comprehensive.docx'; break;
							case 2: $file_name .= '_team.docx'; break;
							case 3: $file_name .= '_system.docx';break;
							default: echo "{'error':'不存在该类型上传！'}"; return ;
						}//文件应该的名称确定
						if ($file->getName() != $file_name){
							$tmp_name = $file->getName();
							echo "{'error':'不能识别的文件名！-$tmp_name'}"; 
							return ;
						}
						//判断是否原版报告已生成
						$year = floor( $manager->project_id / 100 );
						$old_file_name = './project/'.$year.'/'.$manager->project_id.'/system/report/v1/'.$file_name;
						if (!file_exists($old_file_name)){
							echo "{'error':'原版报告未生成，不能上传修改版'}";
							return ;
						}
						//移动文件到目标目录下
						$path = './project/'.$year.'/'.$manager->project_id.'/system/report/v2/';
						$file_path = $path.$file_name;
						$file_dir = new FileHandle();
						$file_dir->mk_dir($path);
						$file->moveTo($file_path);
						echo "{'success':'文件上传成功！'}"; 
						return ;
					}
				}
			}else{
				echo "{'error':'wrong to here'}";
				return ;
			}
		}catch(Exception $e){
			$msg = $e->getMessage();
			echo "{'error':'$msg'}";
			return ;
		}
	}
	#多文件上传===循环的单文件上传，采用plupload plugin 
	#（1）个体综合报告 __1 （2）个体胜任力报告 __2 
	public function fileuploadv2Action($file_type){
		try{
			//报告上传必须是manager
			$manager = $this->session->get('Manager');
			if(empty($manager)) {
				$this->dataReturn(array('error'=>'用户信息失效，请重新登录!')) ;
				return ;
			}
			$file_flag = null;
			switch($file_type){
				case 1: $file_flag = true; break;
				case 2: $file_flag = false; break;
				default:$this->dataReturn(array('error'=>'不存在该类型上传！')) ;
				return  ;
			}
			if ($this->request->hasFiles()) {
				foreach ($this->request->getUploadedFiles() as $file) {
					if(empty($file->getName())){
						$this->dataReturn(array('error'=>'上传文件不能为空')) ;
						return ;
					}else{
					//判断有相应文件上传
						if ( $file_flag ){
							//个体综合
							$tmp_file_name = $file->getName();
							//先对文件名进行正则匹配
							$pattern = '/^\d{8}_individual_comprehensive.docx$/';
							if (preg_match($pattern, $tmp_file_name) == 0 ){
								$this->dataReturn(array('error'=>'不能识别的文件')) ;
								return;
							}
							$tmp_file_name_array = explode('_', $tmp_file_name);
							$examinee_number =  $tmp_file_name_array[0];
							$examinee_info = Examinee::findFirst(
									array('number=?1','bind'=>array(1=>$examinee_number))
							);
							if (!isset($examinee_info->id)){
								$this->dataReturn(array('error'=>'不存在的编号')) ;
								return;
							}
							//判断原版文件是否存在，若不存在，则不能上传修改版文件
							$year = floor( $manager->project_id / 100 );
							$old_file_name = './project/'.$year.'/'.$manager->project_id.'/individual/comprehensive/v1/'.$tmp_file_name;
							if (!file_exists($old_file_name)){
								$this->dataReturn(array('error'=>'原版报告未生成，不能上传修改版'));
								return ;
							}	
							//移动文件到目标目录下
							
							$path = './project/'.$year.'/'.$manager->project_id.'/individual/comprehensive/v2/';
							$file_path = $path.$tmp_file_name;
							$file_dir = new FileHandle();
							$file_dir->mk_dir($path);
							$file->moveTo($file_path);
							$this->dataReturn(array('success'=>'true')) ;
								return;
						}else{
							//个体胜任力
							$tmp_file_name = $file->getName();
							//先对文件名进行正则匹配
							$pattern = '/^\d{8}_individual_competency.docx$/';
							if (preg_match($pattern, $tmp_file_name) == 0 ){
								$this->dataReturn(array('error'=>'不能识别的文件')) ;
								return;
							}
							$tmp_file_name_array = explode('_', $tmp_file_name);
							$examinee_number =  $tmp_file_name_array[0];
							$examinee_info = Examinee::findFirst(
									array('number=?1','bind'=>array(1=>$examinee_number))
							);
							if (!isset($examinee_info->id)){
									$this->dataReturn(array('error'=>'不存在的编号')) ;
								return;
							}
							$year = floor( $manager->project_id / 100 );
							$old_file_name = './project/'.$year.'/'.$manager->project_id.'/individual/competency/v1/'.$tmp_file_name;
							if (!file_exists($old_file_name)){
								$this->dataReturn(array('error'=>'原版报告未生成，不能上传修改版'));
								return ;
							}
							//移动文件到目标目录下
							
							$path = './project/'.$year.'/'.$manager->project_id.'/individual/competency/v2/';
							$file_path = $path.$tmp_file_name;
							$file_dir = new FileHandle();
							$file_dir->mk_dir($path);
							$file->moveTo($file_path);
							$this->dataReturn(array('success'=>'true')) ;
								return;
							
						}
					}
				}
		}else{
			$this->dataReturn(array('error'=>'wrong to here')) ;
			return;
		}
	}catch(Exception $e){
		$this->dataReturn(array('error'=>$e->getMessage())) ;
		return;
	}	
	}
	#报告上传情况查看 report_type 1 综合  2 胜任力
	function getindividualreportstateAction($report_type){
		$manager = $this->session->get('Manager');
		if(empty($manager)) {
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!')) ;
			return ;
		}
		$file_flag = true;
		switch($report_type){
			case 1: $file_flag = true; break;  //1 表示 综合报告
			case 2: $file_flag = false; break; //2 表示 胜任力报告
			default:$this->dataReturn(array('error'=>'不存在该类型查找-'.$report_type)) ;
				return  ;
		} 
		//全部都是除去了绿色通道人员
		$examinees = $this->modelsManager->createBuilder()
			->columns(array(
					'number'
			))
			->from('Examinee')
			->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 ')
			->getQuery()
			->execute()
			->toArray();
		$tmp =null;
		$examinees = $this->foo($examinees, $tmp);
		$rtn_array = array();
		$rtn_array['not'] = array();
		$rtn_array['ok']  = array();
		if ($file_flag){
			//comprehensive;
			foreach($examinees as $examinee_number){
				$year = floor( $manager->project_id / 100 );
				$new_file_name = './project/'.$year.'/'.$manager->project_id.'/individual/comprehensive/v2/'.$examinee_number.'_individual_comprehensive.docx';
				if (file_exists($new_file_name)){
					$rtn_array['ok'][] = $examinee_number;
				}else{
					$rtn_array['not'][] = $examinee_number;
				}
			}
		}else{
			//competency
			foreach($examinees as $examinee_number){
				$year = floor( $manager->project_id / 100 );
				$new_file_name = './project/'.$year.'/'.$manager->project_id.'/individual/competency/v2/'.$examinee_number.'_individual_competency.docx';
				if (file_exists($new_file_name)){
					$rtn_array['ok'][] = $examinee_number;
				}else{
					$rtn_array['not'][] = $examinee_number;
				}
			}
		}
		$this->dataReturn(array('success'=>$rtn_array));
		return ;
	}
	
	#辅助方法 --降维
	private function foo($arr, &$rt) {
		if (is_array($arr)) {
			foreach ($arr as $v) {
				if (is_array($v)) {
					$this->foo($v, $rt);
				} else {
					$rt[] = $v;
				}
			}
		}
		return $rt;
	}
	
	#报告打包下载-- file_type 1 2 | file_new 1 2 | 
	#原版综合 1  1 ， 原版胜任力 1  2 ， 修改版综合2  1 ，修改版胜任力 2 2 
	public function packagefilesAction($file_type, $file_new){
		set_time_limit(0);
		$manager = $this->session->get('Manager');
		if(empty($manager)) {
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!')) ;
			return ;
		}
		$examinees = $this->modelsManager->createBuilder()
		->columns(array(
				'number'
		))
		->from('Examinee')
		->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 ')
		->getQuery()
		->execute()
		->toArray();
		$tmp =null;
		$examinees = $this->foo($examinees, $tmp);
		$year = floor( $manager->project_id / 100 );
		// 查找所有的普通被试人员
		$not_finished = array();
		$path = '';
		$file_name = '';
		if ($file_type == 1 && $file_new == 1 ){
			//综合原版
			$path = './project/'.$year.'/'.$manager->project_id.'/individual/comprehensive/v1/';
			foreach($examinees as $examinee_number){
				$new_path = $path.$examinee_number.'_individual_comprehensive.docx';
				if (!file_exists($new_path)){
					$not_finished[] = $examinee_number;
				}
			}
			//遍历完所有的人员是否有相应的文件生成
			if(!empty($not_finished)){
				//全部人员的文件已经生成; 未生成
				$this->dataReturn(array('error'=>$not_finished));
				return ;
			}
			$file_name = 'individual_comprehensive_v1';
			
		}else if ($file_type == 1 && $file_new == 2 ){
			//胜任力原版
			$path = './project/'.$year.'/'.$manager->project_id.'/individual/competency/v1/';
			foreach($examinees as $examinee_number){
				$new_path = $path.$examinee_number.'_individual_competency.docx';
				if (!file_exists($new_path)){
					$not_finished[] = $examinee_number;
				}
			}
			//遍历完所有的人员是否有相应的文件生成
			if(!empty($not_finished)){
				//全部人员的文件已经生成; 未生成
				$this->dataReturn(array('error'=>$not_finished));
				return ;
			}
			$file_name = 'individual_competency_v1';
		}else if ($file_type == 2 && $file_new == 1 ){
			//综合修改
			$path = './project/'.$year.'/'.$manager->project_id.'/individual/comprehensive/v2/';
			foreach($examinees as $examinee_number){
				$new_path = $path.$examinee_number.'_individual_comprehensive.docx';
				if (!file_exists($new_path)){
					$not_finished[] = $examinee_number;
				}
			}
			//遍历完所有的人员是否有相应的文件生成
			if(!empty($not_finished)){
				//全部人员的文件已经生成; 未生成
				$this->dataReturn(array('error'=>$not_finished));
				return ;
			}
			$file_name = 'individual_comprehensive_v2';
		}else if ($file_type == 2 && $file_new == 2 ){
			//胜任力修改
			$path = './project/'.$year.'/'.$manager->project_id.'/individual/competency/v2/';
			foreach($examinees as $examinee_number){
				$new_path = $path.$examinee_number.'_individual_competency.docx';
				if (!file_exists($new_path)){
					$not_finished[] = $examinee_number;
				}
			}
			//遍历完所有的人员是否有相应的文件生成
			if(!empty($not_finished)){
				//全部人员的文件已经生成; 未生成
				$this->dataReturn(array('error'=>$not_finished));
				return ;
			}
			$file_name = 'individual_competency_v2';
		}else{
			$this->dataReturn(array('error'=>'参数错误-'.$file_type.'-'.$file_new));
			return ;
		}
		//$path 存在
		try{
			$zipfile = new FileHandle();
			$file_path = $zipfile->packageZip($path, $manager->project_id, $file_name);
			$this->dataReturn(array('success'=>$file_path));
			return ;
			
		}catch(Exception $e){
			$this->dataReturn(array('error'=>$e->Message()));
			return ;
		}
	}
	#文件导出 xls-- -- 被试人员列表 1   专家人员列表2   领导人员列表3
	public function exportroleAction($type){
		$manager = $this->session->get('Manager');
		if(empty($manager)) {
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!')) ;
			return ;
		}
		try{
		$excelExport = new ExcelExport();
		$file_name = '';
		switch($type){
			case 1 : 
				$result = Examinee::find(array('project_id = ?1 AND type = 0 ', 'bind'=>array(1=>$manager->project_id)));
				$file_name = $excelExport->ExamineeExport($result, $manager->project_id); 
				$this->dataReturn(array('success'=>$file_name));
				return ;
				break;
			case 2 : 
				$result = Manager::find(array('project_id = ?1 AND role = \'I\'', 'bind'=>array(1=>$manager->project_id)));
				$file_name = $excelExport->InterviewerExport($result, $manager->project_id); 
				$this->dataReturn(array('success'=>$file_name));
				return ;
				break;
			case 3 : 
				$result = Manager::find(array('project_id = ?1 AND role = \'L\'', 'bind'=>array(1=>$manager->project_id))); 
				$file_name = $excelExport->LeaderExport($result, $manager->project_id); 
				$this->dataReturn(array('success'=>$file_name));
				return ;
				break;
			case 4 : 
				$result = Examinee::find(array('project_id = ?1 AND type = 0 ', 'bind'=>array(1=>$manager->project_id)));
				$file_name = $excelExport->ExamineeExportSimple($result, $manager->project_id); 
				$this->dataReturn(array('success'=>$file_name));
				return ;
				break;
			default : $this->dataReturn(array('error'=>'参数错误-'.$type)) ;return ;
		}
		}catch(Exception $e){
			$this->dataReturn(array('error'=>"文件生成失败")) ;
			return ;
		}
		
	}
	#获取项目总体数据
	public function getprojectdataAction(){
		set_time_limit(0);
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
		$path = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$name = $project_id.'_project_data.xls'; //name 相同
		//先判断修改是否存在
		if (file_exists($path.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载<br /><br /><a href=\''.$path_url.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体数据</a><br /><br />"));
			return ;
		}else{
			//生成文件，之后返回下载路径
			try{
				$report =   new ProjectDataExport();
				$report_tmp_name = $report->excelExport($project_id);
				$report_name = $path.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载<a href=\''. $path_url.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体数据</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	#获取项目总体数据评估
	public function getprojectevaluationAction(){
		set_time_limit(0);
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
		$path = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$name = $project_id.'_project_evaluation.xls'; //name 相同
		//先判断修改是否存在
		if (file_exists($path.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载<br /><br /><a href=\''.$path_url.$name."' style='color:blue;text-decoration:underline;'>人才综合素质评估数据</a><br /><br />"));
			return ;
		}else{
			//生成文件，之后返回下载路径
			try{
				$report =   new ProjectEvaluationExport();
				$report_tmp_name = $report->excelExport($project_id);
				$report_name = $path.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载<a href=\''. $path_url.$name."' style='color:blue;text-decoration:underline;'>人才综合素质评估数据</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	#获取项目总体数据分析
	public function getprojectanalysisAction(){
		set_time_limit(0);
		$this->view->disable();
		//导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$name = $project_id.'_project_analysis.xls'; //name 相同
		//先判断修改是否存在
		if (file_exists($path.$name)){
			//修改文件存在;
			$this->dataReturn(array('success'=>'点击下载<br /><br /><a href=\''.$path_url.$name."' style='color:blue;text-decoration:underline;'>总体数据分析</a><br /><br />"));
			return ;
		}else{
			//生成文件，之后返回下载路径
			try{
				$report =   new ProjectAnalysisExport();
				$report_tmp_name = $report->excelExport($project_id);
				$report_name = $path.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载<a href=\''. $path_url.$name."' style='color:blue;text-decoration:underline;'>总体分析数据</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
		}
	}
	#生成被试人员的十项报表----可重复生成
	public function getpersonalresultsbyprojectAction() {
		set_time_limit(0);
		$this->view->disable();
		//十项报表的导出必须是manager pm & interviwer
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}

		$efb=new EFB();
		$file_path=$efb->fillExcel(1111);
		$this->dataReturn(array('success'=>array('success'=>$file_path)));
		//获取项目中完成测评的人员列表----全部都是除去了绿色通道人员 ---- 且被试已经完成了指标算分
		// $examinees = $this->modelsManager->createBuilder()
		// ->columns(array(
		// 		'number'
		// ))
		// ->from('Examinee')
		// ->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 AND Examinee.state >= 4 ')
		// ->getQuery()
		// ->execute()
		// ->toArray();
		// if(empty($examinees)){
		// 	$this->dataReturn(array('error'=>'目前没有被试完成测评，无法生成十项报表'));
		// 	return;
		// }
		// // 根据目录结构判断文件是否存在
		// $year = floor($manager->project_id/ 100 );
		// $path = './project/'.$year.'/'.$manager->project_id.'/individual/personal_result/';
		// $path_url = '/project/'.$year.'/'.$manager->project_id.'/individual/personal_result/';
		
		// //遍历完成的被试集判断其是否已经生成了十项报表
		// $finished_list = array();
		// $not_finished_list =array();
		// foreach($examinees as $examinee) {
		// 	$name = $examinee['number'].'_personal_result.xlsx';
		// 	if(file_exists($path.$name)) {
		// 		$finished_list[] = $examinee['number'];
		// 	}else{
		// 		try{
		// 			$examinee_info = Examinee::findFirst(array('number=?1','bind'=>array(1=>$examinee['number'])));
		// 			$checkout_excel = new CheckoutExcel();
		// 			$report_tmp_name = $checkout_excel->excelExport($examinee_info);
		// 			$report_name = $path.$name;
		// 			$file = new FileHandle();
		// 			$file->movefile($report_tmp_name, $report_name);
		// 			//清空临时文件 主要在tmp中
		// 			$file->clearfiles('./tmp/', $examinee_info->id);	
		// 			$finished_list[] = $examinee['number'];
		// 		}catch(Exception $e){
		// 			$not_finished_list[] = $examinee['number'] .'-生成失败-原因：'.$e->getMessage();
		// 		}
		// 	}
		// }
		// if(empty($finished_list)) {
		// 	$this->dataReturn(array('error'=>array('error'=>$not_finished_list)));
		// 	return;
		// }
		// //打包已完成的人员十项报表
		// //$path 存在
		// try{
		// 	$file_name = 'personal_results_package';
		// 	$zipfile = new FileHandle();
		// 	$zipfile->clearfiles('./tmp/', $manager->project_id);
		// 	$file_path = $zipfile->packageZip($path, $manager->project_id, $file_name);
		// 	$this->dataReturn(array('success'=>array('success'=>$file_path,'error'=>$not_finished_list)));
		// 	return ;	
		// }catch(Exception $e){
		// 	$this->dataReturn(array('error'=>$e->Message()));
		// 	return ;
		// }
	}
	
	#生成被试人员的原始答案-----可重复生成
	public function getanstablebyprojectAction() {
		set_time_limit(0);
		$this->view->disable();
		//原始答案的导出必须是manager pm & interviwer
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//获取项目中完成答题的人员列表----全部都是除去了绿色通道人员 ---- 且被试已经完成了指标算分
		$examinees = $this->modelsManager->createBuilder()
		->columns(array(
				'number','id','state'
		))
		->from('Examinee')
		->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 AND Examinee.state >= 1 ')
		->getQuery()
		->execute();
		if(empty($examinees)){
			$this->dataReturn(array('error'=>'目前没有被试完成答题，无法生成原始答案'));
			return;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($manager->project_id/ 100 );
		$path = './project/'.$year.'/'.$manager->project_id.'/individual/personal_anstable/';
		$path_url = '/project/'.$year.'/'.$manager->project_id.'/individual/personal_anstable/';
		//遍历完成的被试集判断其是否已经生成了十项报表
		$finished_list = array();
		$not_finished_list =array();
		foreach($examinees as $examinee) {
			$name = $examinee->number.'_personal_anstable.xls';
			if(file_exists($path.$name)) {
				$finished_list[] = $examinee->number;
			}else{
				try{
					$excelexport=new ExcelExport();
					$anstable=$excelexport->anstableExport($examinee,$manager);
					if($anstable==false){
						throw new Exception("error", 1);
					}else{
						$finished_list[]=$examinee->number;
					}
				}catch(Exception $e){
					$not_finished_list[] = $examinee['number'] .'-生成失败-原因：'.$e->getMessage();
				}
			}
		}
		if(empty($finished_list)) {
			$this->dataReturn(array('error'=>array('error'=>$not_finished_list)));
			return;
		}
		//打包已完成的人员十项报表
		//$path 存在
		try{
			$file_name = 'personal_anstable_package';
			$zipfile = new FileHandle();
			$zipfile->clearfiles('./tmp/', $manager->project_id);
			$file_path = $zipfile->packageZip($path, $manager->project_id, $file_name);
			$this->dataReturn(array('success'=>array('success'=>$file_path,'error'=>$not_finished_list)));
			return ;	
		}catch(Exception $e){
			$this->dataReturn(array('error'=>$e->Message()));
			return ;
		}
	}

	#生成个人的结果分析表analysis_eva....
 	public function mgetindividualanalysisAction(){
 		$this->view->disable();
 		$manager=$this->session->get("Manager");
 		$examinee_id = $this->request->getPost('examinee_id', 'int');
 		if (empty($examinee_id)){
 			$this->dataReturn(array('error'=>'请求参数不完整!'));
 			return ;
 		}
 
 		$manager = $this->session->get('Manager');
 		if(empty($manager)){
 			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
 			return ;
 		}
 		$examinee = Examinee::findFirst($examinee_id);
 		if (!isset($examinee->id) ){
 			$this->dataReturn(array('error'=>'无效的用户编号'));
 			return ;
 		}
 		if ($examinee->state < 4 ){
 			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
 			return ;
 		}
 		//对于原始答案，目录结构中不进行保留，因此，不必进行存在性和修改情况的判断
 		$excelexport=new ExcelExport();
 		$anstable=$excelexport->personalanalysisExport($examinee,$manager);
 		if($anstable==false){
 			$this->dataReturn(array('error'=>'用户测评流程还未完成！'));
 			return ;
 		}
 		$this->dataReturn(array("success"=>"点击下载 <a href='".$anstable."'>个人分析表</a>"));
 	}
	#生成打包的所有个人分析表
	public function getpersonalanalysisbyprojectAction(){
		set_time_limit(0);
		$this->view->disable();
		//原始答案的导出必须是manager pm & interviwer
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//获取项目中完成答题的人员列表----全部都是除去了绿色通道人员 ---- 且被试已经完成了指标算分
		$examinees = $this->modelsManager->createBuilder()
		->columns(array(
				'number','id','state','name'
		))
		->from('Examinee')
		->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 AND Examinee.state >= 4 ')
		->getQuery()
		->execute();
		if(empty($examinees)){
			$this->dataReturn(array('error'=>'目前没有被试完成答题，无法生成原始答案'));
			return;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($manager->project_id/ 100 );
		$path = './project/'.$year.'/'.$manager->project_id.'/individual/personal_analysis_evaluation/';
		$path_url = '/project/'.$year.'/'.$manager->project_id.'/individual/personal_analysis_evaluation/';
		//遍历完成的被试集判断其是否已经生成了个人分析表
		$finished_list = array();
		$not_finished_list =array();
		foreach($examinees as $examinee) {
			$name = $examinee->number.'_personal_analysis_evaluation.xls';
			if(file_exists($path.$name)) {
				$finished_list[] = $examinee->number;
			}else{
				try{
					$excelexport=new ExcelExport();
					$anstable=$excelexport->personalanalysisExport($examinee,$manager);
					if($anstable==false){
						throw new Exception("error", 1);
					}else{
						$finished_list[]=$examinee->number;
					}
				}catch(Exception $e){
					$not_finished_list[] = $examinee['number'] .'-生成失败-原因：'.$e->getMessage();
				}
			}
		}
		if(empty($finished_list)) {
			$this->dataReturn(array('error'=>array('error'=>$not_finished_list)));
			return;
		}
		//打包已完成的人员十项报表
		//$path 存在
		try{
			$file_name =' _personal_analysis_evaluation_package';
			$zipfile = new FileHandle();
			$zipfile->clearfiles('./tmp/', $manager->project_id);
			$file_path = $zipfile->packageZip($path, $manager->project_id, $file_name);
			$this->dataReturn(array('success'=>array('success'=>$file_path,'error'=>$not_finished_list)));
			return ;	
		}catch(Exception $e){
			$this->dataReturn(array('error'=>$e->Message()));
			return ;
		}
	}
	#生成被试人员的因子分数表-----可重复生成
	public function getindividualdatabyprojectAction() {
		set_time_limit(0);
		$this->view->disable();
		//原始答案的导出必须是manager pm & interviwer
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//获取项目中完成答题的人员列表----全部都是除去了绿色通道人员 ---- 且被试已经完成了指标算分
		$examinees = $this->modelsManager->createBuilder()
		->columns(array(
				'number','id','state'
		))
		->from('Examinee')
		->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 AND Examinee.state >= 4 ')
		->getQuery()
		->execute();
		if(empty($examinees)){
			$this->dataReturn(array('error'=>'目前没有被试完成答题，无法生成因子分数表'));
			return;
		}
		// 根据目录结构判断文件是否存在
		$year = floor($manager->project_id/ 100 );
		$path = './project/'.$year.'/'.$manager->project_id.'/individual/individual_data/';
		$path_url = '/project/'.$year.'/'.$manager->project_id.'/individual/individual_data/';
		//遍历完成的被试集判断其是否已经生成了十项报表
		$finished_list = array();
		$not_finished_list =array();
		foreach($examinees as $examinee) {
			$name = $examinee->number.'_individual_data.xls';
			if(file_exists($path.$name)) {
				$finished_list[] = $examinee->number;
			}else{
				try{
					$dataexport=new IndividualDataExport();
					$data=$dataexport->excelExport($examinee->id,$manager);
					if($data==false){
						throw new Exception("error", 1);
					}else{
						$finished_list[]=$examinee->number;
					}
				}catch(Exception $e){
					$not_finished_list[] = $examinee['number'] .'-生成失败-原因：'.$e->getMessage();
				}
			}
		}
		if(empty($finished_list)) {
			$this->dataReturn(array('error'=>array('error'=>$not_finished_list)));
			return;
		}
		//打包已完成的人员十项报表
		//$path 存在
		try{
			$file_name = 'individual_data_package';
			$zipfile = new FileHandle();
			$zipfile->clearfiles('./tmp/', $manager->project_id);
			$file_path = $zipfile->packageZip($path, $manager->project_id, $file_name);
			$this->dataReturn(array('success'=>array('success'=>$file_path,'error'=>$not_finished_list)));
			return ;	
		}catch(Exception $e){
			$this->dataReturn(array('error'=>$e->Message()));
			return ;
		}
	}
	
	
	#生成被试人员需求量表结果页面 ---- 可重复生成
	public function getinqueryansAction() {
		set_time_limit(0);
		$this->view->disable();
		//个体报告的导出必须是manager
		$manager = $this->session->get('Manager');
		if(empty($manager)){
			$this->dataReturn(array('error'=>'用户信息失效，请重新登录!'));
			return ;
		}
		//先判断项目中的人员答题情况
		$examinees = $this->modelsManager->createBuilder()
		->columns(array(
				'Examinee.id as id',
				'Examinee.number as number',
				'Examinee.name as name',
				'InqueryAns.option as option'
		))
		->from('Examinee')
		->where('Examinee.project_id = '.$manager->project_id .' AND Examinee.type = 0 ')
		->leftjoin('InqueryAns', 'InqueryAns.examinee_id = Examinee.id AND InqueryAns.project_id = '.$manager->project_id)
		->getQuery()
		->execute()
		->toArray();
		if(empty($examinees)){
			$this->dataReturn(array('error'=>'目前没有被试完成需求量表作答，无法生成统计结果'));
			return;
		}
		$not_finished = array();
		foreach($examinees as $examinee_info ){
			if (empty($examinee_info['option'])){
				$not_finished[] = $examinee_info['number'].'-'.$examinee_info['name'];
			}
		}
		//反馈回未完成列表
		if(!empty($not_finished)){
			$this->dataReturn(array('error'=>$not_finished));
			return;
		}
		// 根据目录结构判断文件是否存在
		$project_id = $manager->project_id;
		$year = floor($project_id / 100 );
		$path = './project/'.$year.'/'.$project_id.'/system/report/v1/';
		$path_url = '/project/'.$year.'/'.$project_id.'/system/report/v1/';
		$name = $project_id.'_inquery_data.xls'; 
		//先判断修改是否存在 取消文件是否存在的判断，直接进行生成
		
		if (file_exists($path.$name)){
			//修改文件存在;
			//$this->dataReturn(array('success'=>'点击下载<br /><br /><a href=\''.$path_url.$name."' style='color:blue;text-decoration:underline;'>人才综合测评总体数据</a><br /><br />"));
			//return ;
			unlink($path.$name);
		}
		//else{
			//生成文件，之后返回下载路径
			try{
				$report =   new InqueryExcel();
				$report_tmp_name = $report->excelExport($project_id);
				$report_name = $path.$name;
				$file = new FileHandle();
				$file->movefile($report_tmp_name, $report_name);
				//清空临时文件 主要在tmp中
				$file->clearfiles('./tmp/', $project_id);
				//返回路径
				$this->dataReturn(array('success'=>'点击下载<a href=\''. $path_url.$name."' style='color:blue;text-decoration:underline;'>需求量表统计结果</a>"));
				return ;
			}catch(Exception $e){
				$this->dataReturn(array('error'=>$e->getMessage()));
				return ;
			}
 		//}
	}
	
	public function testAction(){
		try{
			WordChart::scatter_horiz_Graph_epqa_1();
		}catch (Exception $e){
			echo $e->getMessage();
		}
	}
	public function test2Action(){
		try{
			WordChart::scatter_horiz_Graph_cpi();
		}catch (Exception $e){
			echo $e->getMessage();
		}
	}
	
}