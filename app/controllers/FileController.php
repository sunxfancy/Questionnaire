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
				$report = new CompetencyExport();
				$report_tmp_name = $report->individualCompetencyReport($examinee_id);
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
				$report = new CompetencyExport();
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
				$report = new CompetencyExport();
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
	public function dataReturn($ans){
		$this->response->setHeader("Content-Type", "text/json; charset=utf-8");
		echo json_encode($ans);
		$this->view->disable();
	}
	
	#单一文件上传
	#（1）综合报告上传 __1 #（2）系统胜任力报告 __2 （3）	班子胜任力报告 __3 
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
							case 2: $file_name .= '_system.docx'; break;
							case 3: $file_name .= '_team.docx';break;
							default: echo "{'error':'不存在该类型上传！'}"; return ;
						}//文件应该的名称确定
						if ($file->getName() != $file_name){
							$tmp_name = $file->getName();
							echo "{'error':'不能识别的文件名！-'$tmp_name}"; 
							return ;
						}
						//移动文件到目标目录下
						$year = floor( $manager->project_id / 100 );
						$path = './project/'.$year.'/'.$manager->project_id.'/report/v2/'.$file_name;
						$file->moveTo($path);
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
	#多文件上传
	#（1）个体综合报告 __1 （2）个体胜任力报告 __2 
	public function fileUploadv2Action($file_type){
		#严格json格式{ '···' : '···'},json_encode 无法实现
		try{
			$file_path = null;
			$file_ok = array();
			$file_not_ok = array();
			$file_flag = true;
			switch($file_type){
				case 1: $file_flag = true; break;
				case 2: $file_flag = false; break;
				default: echo "{'error':'不存在该类型上传！'}"; return ;
			}
			$manager = $this->session->get('Manager');
			if(empty($manager)) {
				echo "{'error':'用户信息失效，请重新登录!'}";
				return ;
			}
			if ($this->request->hasFiles()) {
				foreach ($this->request->getUploadedFiles() as $file) {
					if(empty($file->getName())){
						echo "{'error':'上传文件不能为空'}";
						return ;
					}else{
						//判断有相应文件上传
						//报告上传必须是manager
						//判断报告的类型确定报告的应该的名称
						$file_name  = '';
						$file_name  .= $manager->project_id;
						if ( $file_flag ){
							//个体综合
							$tmp_file_name = $file->getName();
							$tmp_file_name_array = explode('_', $tmp_file_name);
							$examinee_number =  $tmp_file_name_array[0];
							$file_type_name  =  $tmp_file_name_array[1].$tmp_file_name_array[2];
							if ($file_type_name != 'individualcomprehensive.docx'){
								$file_no_ok[] = $tmp_file_name.'-不能识别的文件名';
								continue;
							}
							$examinee_info = Examinee::findFirst(
							array('number=?1','bind'=>array(1=>$examinee_number))
							);
							if (!isset($examinee_info->id)){
								$file_no_ok[] = $tmp_file_name.'-不存在的被试编号';
								continue;
							}
							//移动文件到目标目录下
							$year = floor( $manager->project_id / 100 );
							$path = './project/'.$year.'/'.$manager->project_id.'/individual/comprehensive/v2/'.$tmp_file_name;
							$file->moveTo($path);
							$file_ok[] = $tmp_file_name;
							
						}else{
							//个体胜任力
							$tmp_file_name = $file->getName();
							$tmp_file_name_array = explode('_', $tmp_file_name);
							$examinee_number =  $tmp_file_name_array[0];
							$file_type_name  =  $tmp_file_name_array[1].$tmp_file_name_array[2];
							if ($file_type_name != 'individualcompetency.docx'){
								$file_no_ok[] = $tmp_file_name.'-不能识别的文件名';
								continue;
							}
							$examinee_info = Examinee::findFirst(
									array('number=?1','bind'=>array(1=>$examinee_number))
							);
							if (!isset($examinee_info->id)){
								$file_no_ok[] = $tmp_file_name.'-不存在的被试编号';
								continue;
							}
							//移动文件到目标目录下
							$year = floor( $manager->project_id / 100 );
							$path = './project/'.$year.'/'.$manager->project_id.'/individual/competency/v2/'.$tmp_file_name;
							$file->moveTo($path);
							$file_ok[] = $tmp_file_name;
						}
					}
				}
				//判断文件中是否存在未ok 的
				if(empty($file_not_ok)){
					$list = '';
					$i = 1; 
					foreach($file_not_ok as $value){
						$list.= $i++.'-'.$value.'<br />';
					}
					echo "{'error':'文件上传失败清单<br />'}";
					return ;
				}else{
					echo "{'success':'文件上传成功'}";
					return ;
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
}