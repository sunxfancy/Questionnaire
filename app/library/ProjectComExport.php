<?php
require_once '../app/classes/PhpWord/Autoloader.php';

class ProjectComExport extends \Phalcon\Mvc\Controller{
	/**
	 * @usage 总体分析报告生成
	 * @param
	 */
	public  $wordHandle = null;
	public function report($project_id){

		$data = new ProjectComData();
		$data->project_check($project_id);
		$chart = new WordChart();
		$project = Project::findFirst($project_id);
		//-----------------------------------
		\PhpOffice\PhpWord\Autoloader::register();
		$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
		
		// layout
		$sectionStyle = array(
				'orientation'=>'portrait',
				'marginLeft'   => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.2),
				'marginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.2),
				'marginTop'    => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.2),
				'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.9),
				'pageSizeW'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
				'pageSizeH'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
				'headerHeight'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1),
				'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8),	
		);
		//add section
		$section = $this->wordHandle->addSection($sectionStyle);
		$section->getStyle()->setPageNumberingStart(1);
		$header = $section->addHeader();
		$header = $header->createTextrun();
		$header->addImage('reportimage/logo_2.jpg',
		array('marginTop'     => -1,
		'marginLeft'    =>\PhpOffice\PhpWord\Shared\Converter::cmToInch(1) ,
		'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.98),
		'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.54),
		'wrappingStyle'=>'square',
		));
		$header->addText($project->name."总体分析报告",array('color'=>'red','size'=>11),array('lineHeight'=>1,'alignment'=>'right'));
		
		$footer = $section->addFooter();
		$footer->addPreserveText('{PAGE}', array('size'=>10,'color'=>'000000',), array('alignment'=>'center', 'lineHeight'=>1));
		
		//cover part
		$paragraphStyle = array('alignment'=>'center','lineHeight'=>1.5);
		$defaultParagraphStyle=array('lineHeight'=>1.5);
		$captionFontStyle = array('name' => 'Microsoft YaHei','size'=>22, 'color'=>'red','bold'=>true);
		$section->addTextBreak(6);
		$section->addText($project->name."总体分析报告",$captionFontStyle,$paragraphStyle);
		$section->addPageBreak();
 		//set title style---TOC
		$this->wordHandle->addTitleStyle(1,array('size'=>16,'bold'=>true),array( 'lineHeight'=>1.5));
		$this->wordHandle->addTitleStyle(2,array('size'=>15,'bold'=>true),array( 'lineHeight'=>1.5));
		$this->wordHandle->addTitleStyle(3,array('size'=>12,'bold'=>true),array( 'lineHeight'=>1.5));
		
		//catalog part
		$section->addText("目录",array('color'=>'blue','size'=>12),$paragraphStyle);
		$section->addTOC(array('size'=>12),\PhpOffice\PhpWord\Style\TOC::TABLEADER_LINE, 1,3);
		$section->addPageBreak();
		
		$captionFontStyle2 = array('name' => 'Microsoft YaHei','size'=>18, 'color'=>'red','bold'=>true);
		$section->addText($project->name."总体分析报告",$captionFontStyle2,$paragraphStyle);
		//part1  项目背景
		$section->addTitle("一、项目背景",1);
		//-------------------------------------------------------------------------
		$examinee = Examinee::find(array('project_id=?1 AND type = 0 ','bind'=>array(1=>$project_id)));
		$examinee = $examinee->toArray();
		$examinee_num = count($examinee); //总人数
		$exam_date_start = explode(' ', $project->begintime)[0]; //开始时间
		$exam_date_end   = explode(' ', $project->endtime)[0]; //结束时间
		$min_time = 0;
		$total_time  = 0;
		$level_array = array(
			1=>0, 2=>0,3=>0,4=>0
		);
		foreach ($examinee as $examinee_record) {
			if ($min_time == 0 ||  $min_time > $examinee_record['exam_time']){
				$min_time = $examinee_record['exam_time'];
			}
			$total_time += $examinee_record['exam_time'];
			$level = ReportData::getLevel($examinee_record['id']);
			$level_array[$level] ++;
		}
		$min_time_str = null;
		foreach (array(3600=>'小时', 60=>'分',1=>'秒') as $key => $value) {
			if ($min_time >= $key) {
				$min_time_str .= floor($min_time / $key).$value;
				$min_time %= $key;
			}
		}//最短答题时间
		$average_time = $total_time/$examinee_num;
		$average_time_str = null;
		foreach (array(3600=>'小时', 60=>'分',1=>'秒') as $key => $value) {
			if ($average_time >= $key) {
				$average_time_str .= floor($average_time / $key).$value;
				$average_time %= $key;
			}
		}//平均答题时间
		
		$rate_1 = (sprintf('%.2f', $level_array[1]/$examinee_num )*100).'%';//优秀率
		$rate_2 = (sprintf('%.2f', $level_array[2]/$examinee_num )*100).'%';//良好率
		$rate_3 = (sprintf('%.2f', $level_array[3]/$examinee_num )*100).'%';//中等率
//	---------------------------------------------------------
		$section->addText("    为了充分开发中青年人才资源，了解中青年人才水平、培养有潜力人才及科技骨干、选拔一批经验丰富，德才兼备的中青年高技能人才，北京XXX集团（后简称“集团”），采用第三方北京技术交流培训中心(以下简称“中心”)自主研发26年，通过上下、左右、前后六维（简称“6＋1”）测评技术，对集团".$examinee_num."名中青年人才进行了一次有针对性的测评。从".$exam_date_start."到".$exam_date_end."，在集团培训中心进行上机测试。规定测评时间为3小时，最短完成时间为".$min_time_str."，一般为".$average_time_str."左右。 ",$defaultParagraphStyle);
		$section->addText("    测评后进行专家（四位局级以上领导干部）与中青年人才一对一人均半小时的沟通（简称“面询”）， 这是区别国内所有综合测评机构的独有特色。面询内容有三：一是根据测评结果按优劣势分析归纳与评价；二是双方互动理解与确认测评结果；三是现场解答每位人才提出的问题，并给予针对性、个性化的解决方案与建议。", $defaultParagraphStyle);
		$section->addText("    通过对".$examinee_num."位中青年人才综合统计分析，按优良中差排序结果为：全体优秀率达".$rate_1."，良好".$rate_2."。在测评和专家面询后，对全部人才进行了无记名的满意度调查，参加调查83人，回收有效问卷83份，有效率100%，满意度100%。（满意度调查报告详见附件1） ", $defaultParagraphStyle);
		
	    $section->addTitle("1、测评目的",2);
		$section->addTitle("第一、为中青年人才培训提供科学参考依据",3);
		$section->addText("    在传统的人事管理信息系统中，人与人之间的差别只体现在性别、年龄、职务、工种、学历、职称、工作经历上，而却忽略了内隐素质能力上的差异。综合测评可以帮助集团领导了解中青年人才更多重要的信息，为个性化培养与培训提供科学、准确的依据。在对人才进行精准识别后，还进行了人岗匹配，针对岗位胜任程度和潜质提出了使用与培养的建议。通过本次测评，清晰了集团中青年人才职业心理、职业素质、智体结构、职业能力和发展潜质，为集团下一步的培训工作提供了科学、客观、准确的依据。",$defaultParagraphStyle);
		$section->addTitle("第二、为中青年人才提供自我认知和自我提升的工具",3);
		$section->addText("    通过综合测评，帮助了这些人才全面、系统、客观、准确了解自我；通过结合岗位职责一对一面询，让这些人才更加明确自身优势与劣势；清晰哪些技能和素质需要进一步培训，在实际工作中扬长避短，促进自我职业生涯与集团战略的有机结合。",$defaultParagraphStyle);
		$section->addTitle("2、测评流程",2);
		$section->addText("    综合测评分为五个阶段：",$defaultParagraphStyle);
		$section->addText("    一是测评前准备。这一阶段确定测试人才的人数、测评时间、测评内容、测评群体的总体情况；收集测评人才简历；编制测评总体需求量表。",$defaultParagraphStyle);
		$section->addText("    二是人机对话测评。通过“6＋1”系统综合测评，人均获取近1000个定性与定量数据，经过数据处理与统计分析，为专家面询提供科学、准确、客观、真实的测评结果。",$defaultParagraphStyle);
		$section->addText("    三是专家面询。这一过程人均半小时，目的是让有较高领导岗位经历和复合学科背景的专家依据测评结果，与中青年人才一对一的互动沟通：首先，帮他们清晰自己的优劣势；其次，为他们排忧解惑；最后，为每位中青年人才梳理出与集团发展匹配的对策。",$defaultParagraphStyle);
		$section->addText("    四是撰写总体与个体报告。依据对“6＋1”大数据分析结果撰写总体综合素质分析报告；整合个人测评结果和专家面询评价，撰写每位人才的综合测评分析报告。",$defaultParagraphStyle);
		$section->addText("    五是汇报与反馈。向集团领导汇报总体与个体测评结果，反馈无记名满意度调查报告等，针对集团发展战略和现代人力资源管理提出针对性的建议与对策。",$defaultParagraphStyle);
		$section->addTitle("3、技术路径",2);
		$section->addText("    “中心”的综合测评系统始于1988年博士研究成果，经历了26年实践检验，其过程（1）测评地域：北京、上海、天津、广东、山西、湖南、湖北、陕西、内蒙、海南、浙江、山东、辽宁、河南等省市；（2）年龄：20～68岁；（3）学历：大专～博士后；（4）职称：初级～两院士；（5）职务：初、中级～政府副部长、部队中将（陆海空）；（6）类型：跨国公司高管、各类企业高管与技术人才；（7）测评人数：3万多人；（8）测评数据：每人925个；（9）获得荣誉：7次获国家自然科学基金资助，2次获航空科学基金资助，4次获省部级科学技术进步二等奖和管理成果一等奖；在国内外核心刊物发表论文30多篇，专著一本；测评软件50多套；培养出3名博士、9名硕士；经调查，客户反映测评准确率高、效果明显，平均满意度达97.8%，受到被测评人才和用人单位的普遍欢迎和认可。",$defaultParagraphStyle);
		
		//part2  基本情况分析
		$section->addTitle("二、综合测评基本情况分析",1);
		$inquery_data = $data->getInqueryAnsComDetail($project_id);
		//--------------------------------------------------------------------
		#获取inquery_data 第一个数据项 以及 总体人数
		
		$section->addText("    参加本次测评对象是集团的中青年人才（或简称“人才”），有".(count($inquery_data[0]['options'])+1)."个重要定义：", $defaultParagraphStyle);
		$textrun = $section->addTextRun(array('lineHeight'=>1.5));
		$textrun->addText('第一，');
		$textrun->addText('总体',array('color'=>'red'));
		$textrun->addText('：'.$examinee_num.'人');
		$time_array = array('第二','第三','第四','第五','第六','第七','第八','第九','第十','第十一','第十二','第十三','第十四','第十五');
		$i = 0;
		foreach($inquery_data[0]['options'] as $value){
			$textrun = $section->addTextRun(array('lineHeight'=>1.5));
			$textrun->addText($time_array[$i].'，');
			$textrun->addText($value,array('color'=>'red'));
			$textrun->addText('：'.array_sum($inquery_data[0]['value'][$i++]).'人');
		}
		$section->addTitle("（一）基本信息分析",2);
		//先分析简单项-----按照题目需求量表来 n项
		$i = 1;
		foreach($inquery_data as $value){
			$section->addTitle($i.'-逐项分析',3);
			$table = $section->addTable(
	 		array('borderSize'=>1, 
	 			  'borderColor'=>'000000'
	 		)
	 		);
	 		$row = $table->addRow(500);
	 		$row->addCell(1000, array('valign'=>'center'))->addText('分类',array('size'=>10.5),array('alignment'=>'center'));
	 		$row->addCell(1000, array('valign'=>'center'))->addText('人数',array('size'=>10.5),array('alignment'=>'center'));
	 		$row->addCell(1000, array('valign'=>'center'))->addText('比例',array('size'=>10.5),array('alignment'=>'center'));
			$j = 0; 
			foreach($value['options'] as $option_value) {
				$row = $table->addRow(500);
	 			$row->addCell(1000, array('valign'=>'center'))->addText($option_value,array('size'=>10.5),array('alignment'=>'center'));
	 			$row->addCell(1000, array('valign'=>'center'))->addText(array_sum($inquery_data[$i-1]['value'][$j]),array('size'=>10.5),array('alignment'=>'center'));
	 			$row->addCell(1000, array('valign'=>'center'))->addText(sprintf('%.2f', array_sum($inquery_data[$i-1]['value'][$j])/$examinee_num) *100 .'%',array('size'=>10.5),array('alignment'=>'center'));
				$j++;
			}
			$i++;
			//add chart -- 饼图 -- 加不了 无法湖区到图表名称
			
			//add text
			$section->addTextBreak();
			$section->addText('    相关分析：',array('color'=>'blue', 'bold'=>true), array('lineHeight'=>1.5));		
			$section->addTextBreak();
		}

		//交叉项分析----从第二道题开始 与第一项进行比较 综合分析 n-1项
		$i = 1;
		foreach($inquery_data as $value){
			$section->addTitle($i.'-交叉项分析',3);
			$table = $section->addTable(
	 		array('borderSize'=>1, 
	 			  'borderColor'=>'000000'
	 		)
	 		);
	 		$row = $table->addRow(500);
	 		$row->addCell(1000, array('valign'=>'center'))->addText('分类',array('size'=>10.5),array('alignment'=>'center'));
	 		foreach($inquery_data[0]['options'] as $level_name){
	 			$row->addCell(1000, array('valign'=>'center'))->addText($level_name,array('size'=>10.5),array('alignment'=>'center'));
	 		}
	 		$j = 0; 
			foreach($value['options'] as $option_value) {
				$row = $table->addRow(500);
	 			$row->addCell(1000, array('valign'=>'center'))->addText($option_value,array('size'=>10.5),array('alignment'=>'center'));
	 			foreach($inquery_data[$i-1]['value'][$j] as $value_level_number){
	 				$row->addCell(1000, array('valign'=>'center'))->addText($value_level_number,array('size'=>10.5),array('alignment'=>'center'));
	 			}
	 			$j++;
	 		}
			$i++;
			$section->addTextBreak();
			$section->addText('    相关分析：',array('color'=>'blue', 'bold'=>true), array('lineHeight'=>1.5));		
			$section->addTextBreak();
		}
		
		$level_examinees =$data->getBaseLevels($project_id);
		
// 		//测评结果
		$section->addTitle("三、测评结果及特点分析",1);
		$section->addTitle("1、突出优势的特征",2);

		$advantage_data = $data->getProjectAdvantages($project_id);
		$number = 1;
		$existed_factors = array();
		//遍历优势结果集
		foreach($advantage_data as $advantage_record ){
			$section->addTitle(($number++).$advantage_record['chs_name'] , 3);
			$children_str = $advantage_record['children'];
			$children_array = explode(',', $children_str);
			//图表数据  storage
			$storage  = array();
			foreach($level_examinees as $level_record){
				$storage[] = array();
			}
			//遍历优势指标的下属
			$factor = 'A'; //保证每个指标的下属因子少于26
			foreach($children_array as $children_name ){
				$factor_value_by_level = $data->getFactorGrideByLevel(null, $children_name, $level_examinees, $project_id);
				for($i = 0, $len = count($storage); $i < $len; $i++ ){
					$storage[$i][$factor] = $factor_value_by_level[$i];
				}
				$factor ++;
			}//各层人员各种因子的数据获取完成         $storage ;
			$table = $section->addTable(
					array(	'borderSize'=>1,
							'borderColor'=>'000000'
					)
			);
			$row = $table->addRow(500);
			$row->addCell(1000, array('valign'=>'center'))->addText('分类',array('size'=>10.5),array('alignment'=>'center'));
			foreach($storage[0] as $stor_key => $stor_value){
				$row->addCell(1000, array('valign'=>'center'))->addText($stor_key,array('size'=>10.5),array('alignment'=>'center'));
			}
			$j = 0;
			foreach($storage as $storage_record) {
				$row = $table->addRow(500);
				$row->addCell(1000, array('valign'=>'center'))->addText($inquery_data[0]['options'][$j],array('size'=>10.5),array('alignment'=>'center'));
				foreach($storage_record as $storage_record_value){
					$row->addCell(1000, array('valign'=>'center'))->addText($storage_record_value,array('size'=>10.5),array('alignment'=>'center'));
				}
				$j++;
			}
			$section->addTextBreak();
			//优势3项下属
			$advantage_three = array();
			$advantage_count  = 0;
			foreach($advantage_record['detail'] as $factor_info){
				//优势指标中选取前三
				if ($advantage_count  >= 3 ){
					break;
				}
				if (in_array($factor_info['chs_name'], $existed_factors )) {
					continue;
				}else{
					$existed_factors[] = $factor_info['chs_name'];
				}//获取前三因子 factor_info['chs_name']
				$advantage_three[$factor_info['chs_name']] = array();
				$advantage_count ++ ;
				//优势因子获取优势评语
				//取 28项指标的下属
// 				$advantage_comment = ReportComment::findFirst(array(
// 						'name=?1',
// 						'bind'=>array(1=>$factor_info['chs_name'])))->advantage;
// 				$advantage_comment_array = explode("|", $advantage_comment);
				$advantage_comment = ChildIndexComment::findFirst(
					array('index_chs_name = ?1 AND child_chs_name =?2','bind'=>array(1=>$advantage_record['chs_name'], 2=>$factor_info['chs_name']))
				)->advantage;
				$advantage_comment_array = json_decode($advantage_comment, true);
				$rand_key = array_rand($advantage_comment_array);
				$comment = $advantage_comment_array[$rand_key]; //优势因子评语
				$advantage_three[$factor_info['chs_name']]['comment'] = $comment;
				$factor_by_level = $data->getFactorGrideByLevel($factor_info['chs_name'], null, $level_examinees, $project_id); 
				arsort($factor_by_level); //逆序排列
				$level_arsort_array = array();
				foreach($factor_by_level as $arsort_key => $arsort_value){
					$level_arsort_array[] = $inquery_data[0]['options'][$arsort_key];
				}
				$advantage_three[$factor_info['chs_name']]['level_arsort'] = $level_arsort_array;
			}//优势3项获取完毕   ----- $advantage_three
			$section->addText('特征描述', array('color'=>'blue', 'size'=>11,'bold'=>true));
			$number_array = array('一','二','三');
			$i = 0; 
			foreach($advantage_three as $value ){
				$section->addText($number_array[$i++].$value['comment'], $defaultParagraphStyle);
			}
			$section->addTextBreak();
			foreach($advantage_three as $key => $value ){
				$section->addText($key.'：'.implode('，',$value['level_arsort']), $defaultParagraphStyle);
			}
			$section->addTextBreak();
		}
		$section->addTitle('2、需要完善和提升的方面',2);
		//$level_examinees =$data->getBaseLevels($project_id);
		$disadvantage_data = $data->getProjectDisadvantages($project_id);
		$number = 1;
		$existed_factors = array();
		//遍历劣势结果集
		foreach($disadvantage_data as $disadvantage_record ){
			$section->addTitle(($number++).$disadvantage_record['chs_name'] , 3);
			$children_str = $disadvantage_record['children'];
			$children_array = explode(',', $children_str);
			//图表数据  storage
			$storage  = array();
			foreach($level_examinees as $level_record){
				$storage[] = array();
			}
			//遍历优势指标的下属
			$factor = 'A'; //保证每个指标的下属因子少于26
			foreach($children_array as $children_name ){
				$factor_value_by_level = $data->getFactorGrideByLevel(null, $children_name, $level_examinees, $project_id);
				for($i = 0, $len = count($storage); $i < $len; $i++ ){
					$storage[$i][$factor] = $factor_value_by_level[$i];
				}
				$factor ++;
			}//各层人员各种因子的数据获取完成         $storage ;
			$table = $section->addTable(
					array(	'borderSize'=>1,
							'borderColor'=>'000000'
					)
			);
			$row = $table->addRow(500);
			$row->addCell(1000, array('valign'=>'center'))->addText('分类',array('size'=>10.5),array('alignment'=>'center'));
			foreach($storage[0] as $stor_key => $stor_value){
				$row->addCell(1000, array('valign'=>'center'))->addText($stor_key,array('size'=>10.5),array('alignment'=>'center'));
			}
			$j = 0;
			foreach($storage as $storage_record) {
				$row = $table->addRow(500);
				$row->addCell(1000, array('valign'=>'center'))->addText($inquery_data[0]['options'][$j],array('size'=>10.5),array('alignment'=>'center'));
				foreach($storage_record as $storage_record_value){
					$row->addCell(1000, array('valign'=>'center'))->addText($storage_record_value,array('size'=>10.5),array('alignment'=>'center'));
				}
				$j++;
			}
			$section->addTextBreak();
			//劣势3项下属
			$disadvantage_three = array();
			$disadvantage_count  = 0;
			foreach($disadvantage_record['detail'] as $factor_info){
				//劣势指标中选取前三
				if ($disadvantage_count  >= 3 ){
					break;
				}
				if (in_array($factor_info['chs_name'], $existed_factors )) {
					continue;
				}else{
					$existed_factors[] = $factor_info['chs_name'];
				}//获取前三因子 factor_info['chs_name']
				$disadvantage_three[$factor_info['chs_name']] = array();
				$disadvantage_count ++ ;
				//劣势因子获取劣势因子
// 				$disadvantage_comment = ReportComment::findFirst(array(
// 						'name=?1',
// 						'bind'=>array(1=>$factor_info['chs_name'])))->disadvantage;
// 				$disadvantage_comment_array = explode("|", $disadvantage_comment);
				$disadvantage_comment = ChildIndexComment::findFirst(
						array('index_chs_name = ?1 AND child_chs_name =?2','bind'=>array(1=>$disadvantage_record['chs_name'], 2=>$factor_info['chs_name']))
				)->disadvantage;
				$disadvantage_comment_array = json_decode($disadvantage_comment, true);
				
				$rand_key = array_rand($disadvantage_comment_array);
				$comment = $disadvantage_comment_array[$rand_key]; //优势因子评语
				$disadvantage_three[$factor_info['chs_name']]['comment'] = $comment;
				$factor_by_level = $data->getFactorGrideByLevel($factor_info['chs_name'], null, $level_examinees, $project_id);
				arsort($factor_by_level); //逆序排列
				$level_arsort_array = array();
				foreach($factor_by_level as $arsort_key => $arsort_value){
					$level_arsort_array[] = $inquery_data[0]['options'][$arsort_key];
				}
				$disadvantage_three[$factor_info['chs_name']]['level_arsort'] = $level_arsort_array;
			}//劣势3项获取完毕   ----- $disadvantage_three
			$section->addText('特征描述', array('color'=>'blue', 'size'=>11, 'bold'=>true));
			$number_array = array('一','二','三');
			$i = 0;
			foreach($disadvantage_three as $value ){
				$section->addText($number_array[$i++].$value['comment'], $defaultParagraphStyle);
			}
			$section->addTextBreak();
			foreach($disadvantage_three as $key => $value ){
				$section->addText($key.'：'.implode('，',$value['level_arsort']), $defaultParagraphStyle);
			}
			$section->addTextBreak();
		}
		
		$section->addTitle("四、职业素质综合评价",1);
		$comprehensive_data = $data->getComprehensiveData($project_id);
		if (empty($comprehensive_data)){
			$section->addText('素质测评模块没有被选中', array('size'=>14,'bold'=>true,), array('lineHeight'=>1.5));
			$section->addTextBreak();
		}else{
			//chart data 
			$chart_labels = array();
			$chart_values = array();
			foreach($comprehensive_data as $comprehensive_record){
				$chart_labels[] = $comprehensive_record['name']; //图表中的标签名称
				$chart_values[] = $comprehensive_record['value'];//图表中对应项的得分数据	
			}
			//add data chart 
			$table = $section->addTable(
					array(	'borderSize'=>1,
							'borderColor'=>'000000'
					)
			);
			$row = $table->addRow(500);
			foreach($chart_labels as $chart_label_value){
				$row->addCell(1000, array('valign'=>'center'))->addText( $chart_label_value,array('size'=>10.5),array('alignment'=>'center'));
			}
			$row = $table->addRow(500);
			foreach($chart_values as $chart_label_value){
				$row->addCell(1000, array('valign'=>'center'))->addText( $chart_label_value,array('size'=>10.5),array('alignment'=>'center'));
			}
			$number_tk = 1; 
			foreach($comprehensive_data as $comprehensive_record ){
				
				$module_record = Module::findFirst(
				array(
						"name = ?1",
						'bind' => array(1=>$comprehensive_record['name_in_table']),
						
				)
		);//MemoryCache::getModuleDetail($comprehensive_record['name_in_table']); //根据数据库中存储的模块名称获取模块的下属children ，之后按照原有的children顺序来排列指标得分
				$children = explode(',', $module_record->children );
				$search_array = array();
				foreach($comprehensive_record['children'] as $com_value ){
					$search_array[$com_value['id']] = sprintf('%.2f', $com_value['score']);
				}
				foreach($children as &$value ){
					$index_info = Index::findFirst( array('name=?1', 'bind' => array(1=>$value)));
					$value = $search_array[$index_info->id];
				}//$children 按顺序排列的指标得分
				$section->addTitle( $number_tk++.$comprehensive_record['name'] , 2);
				$table = $section->addTable(
						array(	'borderSize'=>1,
								'borderColor'=>'000000'
						)
				);
				$row = $table->addRow(500);
				$number = count($children);
				$start = 'A';
				for($i = 0; $i < $number; $i++ ){
					$row->addCell(1000, array('valign'=>'center'))->addText($start++,array('size'=>10.5),array('alignment'=>'center'));
				}
				$row = $table->addRow(500);
				foreach($children as $chart_label_value){
					$row->addCell(1000, array('valign'=>'center'))->addText( $chart_label_value,array('size'=>10.5),array('alignment'=>'center'));
				}
				//前三指标评语
				$three_index = array_slice($comprehensive_record['children'], 0, 3 );
				$comment = array();
				foreach($three_index as $three_value) {
					$comment[] = ComprehensiveComment::findFirst(array('index_chs_name = ?1','bind'=>array(1=>$three_value['chs_name'])))->comment;
				}
				$section->addTextBreak();
				$section->addText(implode('；', $comment).'。', $defaultParagraphStyle);
				$section->addTextBreak();
				
			}
			
		}
// 		//结论与建议
		$section->addTitle("五、结论与建议",1);
		$section->addTitle("（一）本次综合测评的基本评价",2);
		$section->addTitle("1、印证了集团对中青年人才培养前瞻性、系统性和实效性",3);
		$section->addText("    通过本次综合测评与统计分析，得到了具有优秀发展潜质的中青年人才占".$rate_1."、有良好发展潜质占".$rate_2."、中等潜质为".$rate_3."的测评结果，进一步证明了集团在中青年人才培养体系的系统性、科学性、精准性、可行性及实操性。",$defaultParagraphStyle);
		$section->addTitle("2、量化了集团中青年人才的发展潜质和培养与培训路径",3);
		$section->addText("    以人均1000多个数据为基础，有复合的理论体系和系统的方法体系为支撑，对所有参加测评的中青年人才量化的内容有四：一是进行了发展潜质的量化排序；二是精确了能否胜任现有岗位的五级评分；三是明确了今后的培养方向；四是清晰了下一步培训的重点。",$defaultParagraphStyle);
		$section->addTitle("3、形成了具有XXX集团特色的中青年人才队伍",3);
		$section->addText("    集团有一支性别结构均衡、有行业特点，人才梯队结构年龄分布合理，专业门类较齐全、理工科配备合适，学历结构适当，对集团发展前景高度认可的中青年人才队伍。",$defaultParagraphStyle);
		$section->addTitle("4、突显了集团中青年人才特质",3);
		$section->addText("    形成了外向开朗、身心健康、阳光向上、精力充沛的人格；思路清晰，有追求和不断总结的归纳提炼能力；具有后天勤奋和先天聪明，勇于实践，训练有素的分析能力；还具有自律谨严，心胸开阔，持之以恒的纪律性；能很好胜任现有岗位的中青年人才特质。",$defaultParagraphStyle);
		$section->addTitle("5、彰显了集团对人才培养与培训合理性",3);
		$section->addText("    以XXX类专业技术人才为主体的中青年人才结构，能够与承担的集团工作任务特点相适应；通过培训需求和学历调查得知，中青年人才均受过高等教育，有较高的工作能力和职业素质，有丰富的工作经验，是一支总体素质较高的人才队伍。",$defaultParagraphStyle);
		$section->addTitle("6、突出了中青年人才较高的自知之明，普遍比较低调",3);
		$section->addText("    总体对自身发展有较明确定位，对个人能力的特长、胜任岗位的优势，以及能力素质的短板有比较客观的认识与评价，对职业生涯发展规划有迫切的需求。如：在在专家面询中，他们与专家互动最多的是如何改进自己的不足。而在“6＋1”调查中，统计自认为非常胜任现有工作岗位是25%，但实际测评结果却是50%。",$defaultParagraphStyle);
		$section->addTitle("7、达成了个人与集团发展较一致的职业目标",3);
		$section->addText("    对自身建设的努力方向、存在的问题和面临的任务，有比较一致的认识，并与集团促进人才发展目标较相吻合。因为100%的人对集团发展有信心，这些人才以在XXX工作为荣，把个人目标与集团目标匹配期望度非常高。",$defaultParagraphStyle);
		$section->addTitle("8、锻炼了一支经过基层磨练、综合素质高的集团总部中青年人才队伍",3);
		$section->addText("    集团总部中青年人才在心理健康、归纳能力、分析能力、聪慧性及对自我约束等均高于其他测评人才，而且他们大都经过基层历练，为集团机关发展与改革储备了优质与可靠的人才基础。",$defaultParagraphStyle);
		$section->addTitle("（二）本次测评出现的主要问题",2);
		$section->addTitle("1、集团在引进中青年人才来源还需要进一步优化",3);
		$section->addText("    中青年人才的专业结构较全面，学历水平比较高，职称层次较多。但来自名牌高校的优秀人才并不多，这也为什么在相应专业领域没有形成领军人才的直接原因。",$defaultParagraphStyle);
		$section->addTitle("2、集团总部人才优势与实际工作相矛盾的影响要引起重视",3);
		$section->addText("    测评结果显示，集团总部人才在工作的执著性、人际关系调节和独立工作能力均得分不高，但他们的实际潜质证明对应这三方面的短板是恰恰是他们的优势。为什么会出现这样矛盾呢？原因为：一是在集团总部有些部门存在管理传统和领导强势或无序；二是某些重要岗位出现人岗不匹配，理论上是出现了“彼德原理”现象，实际上是影响到下级或整个部门综合素质水平；三是集团总部“官本位”与现代管理相互交织产生的“蝴蝶效应”，不仅影响到这些人才，更重要的是已波及到总部管理层和下属企业。",$defaultParagraphStyle);
		$section->addTitle("3、危机感、局限性、依赖性较高比例不容忽视",3);
		$section->addText("    特别要强调的是：本次测评中68%的中青年人才工作求稳怕乱，除与本岗位有关的内容外，对其他的事情关心或关注很少，长此以往就会出现眼界不开阔、洞察力不强的局面；有79%的人才做事依靠上级布置，缺乏自主意识，不考虑工作为什么做，怎么样做；有75%的人才工作的执着性不强，自己有正确意见也不愿意或不敢发表，不太关心集团期望目标，只关注自己是否能完成局部的任务。长此下去，出了问题很难找到责任人，岗位责任与集团的绩效管理和绩效考核会形同虚设。",$defaultParagraphStyle);
		$section->addTitle("4、集团需要系统化的培训体系",3);
		$section->addText("    从综合测评看到：集团的培训年年都在不断创新，不断改进，不断提升。但随着外部环境不断变化，应对式的培训已经满足不了集团各层级人才的需求，这就需要从集团战略顶层面系统思考的培训规划与体系。如：中青年人才非常需要职业技能、管理方法、沟通技巧等系统的综合素质与能力方面的培训，也期望集团在这些方面加大对他们训练的力度，尽快提升他们的综合素质。",$defaultParagraphStyle);
		$section->addTitle("5、岗位稳定性过高，晋升困难，“天花板”和“温水煮青蛙”并存",3);
		$section->addText("    大部分中青年人才在当前职位上长久得不到调整或者提升，有些人才在基层助理职位上工作已有8年或更长。虽然岗位稳定能让人才在现有职务上游刃有余的完成工作，但思维模式和工作方法容易禁锢于固有的模式之中，“温水煮青蛙”的现象在这些人才中比较这普遍，长此下去，他们对职业前景的期待成为了“天花板”，随之带来就是理想逐渐倦怠，工作缺乏激情。",$defaultParagraphStyle);
		$section->addTitle("6、薪酬福利急待提升",3);
		$section->addText("    调查结果显示，大量中青年人才选择在集团工作的原因只有很少是因为薪资福利优厚；在希望集团能够改善的问题，更多人的期望能提高收入，增加福利。这说明集团在吸引优秀人才上，薪资福利的吸引力较弱，这也是吸引不到国内外优秀人才的重要原因所在。",$defaultParagraphStyle);
		$section->addTitle("（三）建议与对策",2);
		$section->addTitle("1、建立与集团战略匹配的现代化人力资源管理体系",3);
		$section->addText("    综合考虑本次测评结果，建议集团尽快建立与集团战略匹配的现代化人力资源管理体系。以中青年人才综合素质测评作为切入点，制定科学、规范、合理的人才发展规划；以培养高层次、复合型人才为重点，打造有目标、有重点、有计划、有针对性的现代化人力资源管理体系。",$defaultParagraphStyle);
		$section->addTitle("2、建立完善的薪酬福利体系，加大激励与吸引优秀人才的力度",3);
		$section->addText("    通过本次测评，中青年人才普遍希望集团的薪酬福利能够进一步得到提升，希望能引起集团领导的关注并提出匹配的解决对策。尽管XXX属于城市公共服务类，但其服务水平、所承担的职责和忠诚度远远高于一般的企业，而这一切取决于人才综合素质。",$defaultParagraphStyle);
		$section->addTitle("3、建立基于集团战略的现代人力资源管理的培训体系",3);
		$section->addText("    以集团人才规划为出发点，根据不同层次的人才，建立健全适合集团发展战略的培训体系已迫在眉睫。并在此基础上开展针对各层次人才的短板、个性化的培训，提升集团人才队伍的整体综合素质能力；注重中青年人才结合岗位需求有针对性培训，加大对这些人才培养与培训力度，重点就专业技能、管理方法、团队合作、人际沟通等进行全方位、多形式的培训。",$defaultParagraphStyle);
		$section->addTitle("4、建立合理的调岗及晋升制度，搭建中青年人才成长平台",3);
		$section->addText("    中青年人才在集团工作的稳定性普遍很高，但同时存在的问题就是没有多余的岗位吸引新的优秀人才加入。集团建立合理的调岗及晋升制度之后，不仅能促进现有人才的工作积极行，明确他们的职业发展道路，激发其工作热情，避免“天花板”现象；调岗和人才晋升之后，空余的岗位可以吸纳更多优秀的人才，给集团人才梯队注入新鲜血液，带来新思想、新技能。",$defaultParagraphStyle);
		$section->addTitle("5、对不同层次后备人才进行职业生涯规划",3);
		$section->addText("    结合集团战略与人才发展规划，以各层次后备人才综合测评作为切入点，以培养高层次、复合型人才为重点，打造有目标、有重点、有计划、有针对性的人才职业生涯规划和针对性、使用与培养相结合的体系。",$defaultParagraphStyle);
		$section->addTitle("6、建立不同层次人才综合素质体系，让优秀人才脱颖而出",3);
		$section->addText("    针对集团管理层和领导方法等有待提升的空间，以本次中青年人才综合测评结果为契机，在不同层次、不同群体人才综合素质与需求动机进行对比分析基础上，建立与集团发展战略需求相匹配胜任力标准，让德才兼备，想干事、能干事、干成事的人才在集团平台上施展自己的才华，使XXX集团成为行业的标杆！",$defaultParagraphStyle);
		//命名
		//临时文件命名规范    $project_id_$date_rand(100,900)
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
	 	$date = date('H_i_s');
	 	$stamp = rand(100,900);
		$fileName = './tmp/'.$project_id.'_'.$date.'_'.$stamp.'.docx';
		$objWriter->save($fileName);
		return $fileName;
	}
}