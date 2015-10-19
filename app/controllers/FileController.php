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
			$this->dataReturn(array('success'=>"点击下载&nbsp;<a href='".$path_url2.$name."' style='color:blue;text-decoration:underline;'>个人胜任力报告</a>"));
			return ;
			// 返回 路径
		}else{
			$this->dataReturn(array('error'=>'个体胜任力报告还未生成！'));
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

	public function dataReturn($ans){
		$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
		echo json_encode($ans);
		$this->view->disable();
	}
	
	#单一文件上传
	#（1）综合报告上传 __1 #（2）班子胜任力报告 __2 （3）	系统胜任力报告 __3 
	public function fileUploadv1Action($file_type){
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
	public function fileUploadv2Action($file_type){
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
	
	/**
	 * 文件查找模块
	 */
	function getIndividualReportStateAction($report_type){
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
}