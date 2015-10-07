<?php
require_once '../app/classes/PhpWord/Autoloader.php';

class WordExport extends \Phalcon\Mvc\Controller
{	
	public  $wordHandle = null;
	// public function __construct(){
	// 	\PhpOffice\PhpWord\Autoloader::register();
	// 	$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
	// }
	/**
	 * @usage 个体胜任力报告生成
	 * @param
	 */
	public function individualCompetencyReport($examinee_id){
		//check examinee_id;
		$report = new individualComReport();
		$project_id = $report->self_check($examinee_id);
		//get basic info
		$examinee = Examinee::findFirst($examinee_id);
		//set default style
		$titleFontStyle = array('color' => 'blue','bold' => true);
		$fontStyle2 = array('color' => 'blue');
		//set table style
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$this->wordHandle->addTableStyle('myOwnTableStyle', $styleTable);
		$section = $this->wordHandle->createSection();
		$table = $section->addTable('myOwnTableStyle');
		$table->addRow();
		$cell1_19 = $table->addCell(1000);
		$cell1_19->getStyle()->setGridSpan(9);
		$cell1_19->addText("胜任力模型+述职、民主生活会、民主集中制、四个全面",array('color' => 'red','bold' => true,'size' => 16),array('align'=>'center'));
		$table->addRow();
		$table->addCell(1000)->addText("姓名");
		$table->addCell(1000)->addText($examinee->name);
		$table->addCell(1000)->addText("性别");
		$table->addCell(1000)->addText(($examinee->sex == 1) ? '男' : '女');
		$table->addCell(1000)->addText("年龄");
		$age = FactorScore::calAge($examinee->birthday,$examinee->last_login);
		$table->addCell(1000)->addText($age);
		$table->addCell(1000)->addText("职位");
		$cell2_89 = $table->addCell(1000);
		$cell2_89->getStyle()->setGridSpan(2);
		$cell2_89->addText($examinee->duty);
		$table->addRow();
		$cell3_19 = $table->addCell(1000);
		$cell3_19->getStyle()->setGridSpan(9);
		$cell3_19->addText("胜任素质评分",$titleFontStyle);
		$table->addRow();
		$table->addCell(1000)->addText("领导力");
		$table->addCell(1000)->addText("独立工作能力");
		$table->addCell(1000)->addText("学习领悟能力");
		$table->addCell(1000)->addText("责任心");
		$table->addCell(1000)->addText("纪律性");
		$table->addCell(1000)->addText("工作作风");
		$table->addCell(1000)->addText("自控能力");
		$table->addCell(1000)->addText("自我定位");
		$table->addCell(1000)->addText("总分");
		$table->addRow();
		/*第5行数据来源待添加*/
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addCell(1000)->addText();
		$table->addRow();
		$cell6_19 = $table->addCell(1000);
		$cell6_19->getStyle()->setGridSpan(9);
		$cell6_19->addText("胜任力模型+述职",$titleFontStyle);
		$table->addRow();
		$cell7_19 = $table->addCell(1000);
		$cell7_19->getStyle()->setGridSpan(9);
		//两张图片
		$cell7_19->addText();
		$cell7_19->addText("主要优势有五点：",$fontStyle2);
		$array1 = array('一','二','三','四','五');
		for ($i=0; $i < 5; $i++) { 
			$cell7_19->addText($array1[$i]);
		}
		$cell7_19->addText("有待改进有三点：",$fontStyle2);
		$array2 = array('一','二','三');
		for ($i=0; $i < 3; $i++) { 
			$cell7_19->addText($array2[$i]);
		}
		$cell7_19->addText("述职报告结果：",$fontStyle2);

		$table->addRow();
		$cell8_19 = $table->addCell(1000);
		$cell8_19->getStyle()->setGridSpan(9);
		$cell8_19->addText("胜任力模型+民主生活会",$titleFontStyle);
		$table->addRow();
		$cell9_19 = $table->addCell(1000);
		$cell9_19->getStyle()->setGridSpan(9);
		//两张图片
		$cell9_19->addText();
		$cell9_19->addText("主要优势有五点：",$fontStyle2);
		$array1 = array('一','二','三','四','五');
		for ($i=0; $i < 5; $i++) { 
			$cell9_19->addText($array1[$i]);
		}
		$cell9_19->addText("有待改进有三点：",$fontStyle2);
		$array2 = array('一','二','三');
		for ($i=0; $i < 3; $i++) { 
			$cell9_19->addText($array2[$i]);
		}
		$cell9_19->addText("民主生活会指标描述：",$fontStyle2);

		$table->addRow();
		$cell10_19 = $table->addCell(1000);
		$cell10_19->getStyle()->setGridSpan(9);
		$cell10_19->addText("胜任力模型+民主集中制",$titleFontStyle);
		$table->addRow();
		$cell11_19 = $table->addCell(1000);
		$cell11_19->getStyle()->setGridSpan(9);
		//两张图片
		$cell11_19->addText();
		$cell11_19->addText("主要优势有五点：",$fontStyle2);
		$array1 = array('一','二','三','四','五');
		for ($i=0; $i < 5; $i++) { 
			$cell11_19->addText($array1[$i]);
		}
		$cell11_19->addText("有待改进有三点：",$fontStyle2);
		$array2 = array('一','二','三');
		for ($i=0; $i < 3; $i++) { 
			$cell11_19->addText($array2[$i]);
		}
		$cell11_19->addText("民主集中制指标描述：",$fontStyle2);

		$table->addRow();
		$cell12_19 = $table->addCell(1000);
		$cell12_19->getStyle()->setGridSpan(9);
		$cell12_19->addText("胜任力模型+四个全面",$titleFontStyle);
		$table->addRow();
		$cell13_19 = $table->addCell(1000);
		$cell13_19->getStyle()->setGridSpan(9);
		//两张图片
		$cell13_19->addText();
		$cell13_19->addText("主要优势有五点：",$fontStyle2);
		$array1 = array('一','二','三','四','五');
		for ($i=0; $i < 5; $i++) { 
			$cell13_19->addText($array1[$i]);
		}
		$cell13_19->addText("有待改进有三点：",$fontStyle2);
		$array2 = array('一','二','三');
		for ($i=0; $i < 3; $i++) { 
			$cell13_19->addText($array2[$i]);
		}
		$cell13_19->addText("四个全面指标描述：",$fontStyle2);

		//命名
		$fileName = $examinee->number."+individualCompetencyReport";
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
		$objWriter->save('wordexport/'.$fileName.'.docx');
	}

	/**
	 * @usage 总体分析报告生成
	 * @param
	 */
	public function comprehensiveReport($project_id){
		//get basic info
		$project = Project::findFirst($project_id);
		/*
		TODO...
		*/
		//set default style
		$this->wordHandle->setDefaultFontName('SimSun');
		$this->wordHandle->setDefaultFontSize(12);
		$paragraphStyle = array('align'=>'center');
		$captionFontStyle = array('name' => 'Microsoft YaHei','size'=>22, 'color'=>'red','bold'=>true);
		$captionFontStyle2 = array('name' => 'Microsoft YaHei','size'=>18, 'color'=>'red','bold'=>true);
		$fontStyle = array('color'=>'blue','bold'=>true);
		$contentStyle = array('size' => 12,'color' => 'blue','bold' => true);
		//set title style---TOC
		$this->wordHandle->addTitleStyle(1,array('size'=>16,'bold'=>true));
		$this->wordHandle->addTitleStyle(2,array('size'=>15,'bold'=>true));
		$this->wordHandle->addTitleStyle(3,array('size'=>12,'bold'=>true));
		//set table style
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$this->wordHandle->addTableStyle('myOwnTableStyle', $styleTable);
		$section = $this->wordHandle->createSection();
		//cover part
		$section->addText($project->name."总体分析报告",$captionFontStyle,$paragraphStyle);
		$section->addPageBreak();
		//catalog part
		$section->addText("目录",$contentStyle,$paragraphStyle);
		$section->addTOC(array('tabLeader'=>PhpOffice\PhpWord\Style\TOC::TABLEADER_DOT));
		$section->addPageBreak();
		//part1  项目背景
		$section->addText($project->name."总体分析报告",$captionFontStyle2,$paragraphStyle);
		$section->addTitle("一、项目背景",1);
	// 	$examinee = Examinee::find(array(
	// 		'project_id=?1',
	// 		// 'state > 1',
	// 		'bind'=>array(1=>$project_id)));
	// 	$examinee_num = 0;
	// 	$time = array();
	// 	$score_avg = array();
	// 	foreach ($examinee as $examinees) {
	// 		if ($examinees->state > 0) {
	// 			$examinee_num ++;
	// 			$time[] = $examinees->exam_time;
	// 			$index_ans = IndexAns::find(array(
	// 				'examinee_id=?1',
	// 				'bind'=>array(1=>$examinees->id)));
	// 			$score = 0;
	// 			$num = 0;
	// 			foreach ($index_ans as $index) {
	// 				$score += $index->score;
	// 				$num++;
	// 			}
	// 			if ($num == 0) {
	// 				$score_avg[] = 0;
	// 			}else{
	// 				$score_avg[] = $score / $num;
	// 			}	
	// 		}	
	// 	}
	// 	$level1_num = 0;$level2_num = 0;$level3_num = 0;$level4_num = 0;
	// 	foreach ($score_avg as $score) {
	// 		if ($score > 5.8) {
	// 			$level1_num ++;
	// 		}else if ($score > 5.3) {
	// 			$level2_num ++;
	// 		}else if ($score > 5) {
	// 			$level3_num ++;
	// 		}else{
	// 			$level4_num ++;
	// 		}
	// 	}
	// 	$avg_time = 0;$min_time = 0;$level1 = 0;$level2 = 0;$level3 = 0;$level4 = 0;
	// 	if ($examinee_num != 0) {
	// 		$level1 = sprintf("%d",$level1_num / $examinee_num).'%';
	// 		$level2 = sprintf("%d",$level2_num / $examinee_num).'%';
	// 		$level3 = sprintf("%d",$level3_num / $examinee_num).'%';
	// 		$level4 = sprintf("%d",$level4_num / $examinee_num).'%';
	// 		sort($time);
	// 		$min_time = $time[0].'秒';
	// 		$avg_time = intval(array_sum($time) / $examinee_num).'秒';
	// 	}

	// 	$section->addText("    为了充分开发中青年人才资源，了解中青年人才水平、培养有潜力人才及科技骨干、选拔一批经验丰富，德才兼备的中青年高技能人才，北京XXX集团（后简称“集团”），采用第三方北京技术交流培训中心(以下简称“中心”)自主研发26年，通过上下、左右、前后六维（简称“6＋1”）测评技术，对集团".$examinee_num."名中青年人才进行了一次有针对性的测评。分别于".$project->begintime."到".$project->endtime."，在集团培训中心进行上机测试。规定测评时间为3小时，最短完成时间为".$min_time."，一般为".$avg_time."左右。 ");
		$section->addText("    测评后进行专家（四位局级以上领导干部）与中青年人才一对一人均半小时的沟通（简称“面询”）， 这是区别国内所有综合测评机构的独有特色。面询内容有三：一是根据测评结果按优劣势分析归纳与评价；二是双方互动理解与确认测评结果；三是现场解答每位人才提出的问题，并给予针对性、个性化的解决方案与建议。");
	// 	$section->addText("    通过对".$examinee_num."位中青年人才综合统计分析，按优良中差排序结果为：全体优秀率达".$level1."，良好".$level2."。在测评和专家面询后，对全部人才进行了无记名的满意度调查，参加调查83人，回收有效问卷83份，有效率100%，满意度100%。（满意度调查报告详见附件1） ");
		$section->addTitle("1、测评目的",2);
		$section->addTitle("第一、为中青年人才培训提供科学参考依据",3);
		$section->addText("    在传统的人事管理信息系统中，人与人之间的差别只体现在性别、年龄、职务、工种、学历、职称、工作经历上，而却忽略了内隐素质能力上的差异。综合测评可以帮助集团领导了解中青年人才更多重要的信息，为个性化培养与培训提供科学、准确的依据。在对人才进行精准识别后，还进行了人岗匹配，针对岗位胜任程度和潜质提出了使用与培养的建议。通过本次测评，清晰了集团中青年人才职业心理、职业素质、智体结构、职业能力和发展潜质，为集团下一步的培训工作提供了科学、客观、准确的依据。");
		$section->addTitle("第二、为中青年人才提供自我认知和自我提升的工具",3);
		$section->addText("    通过综合测评，帮助了这些人才全面、系统、客观、准确了解自我；通过结合岗位职责一对一面询，让这些人才更加明确自身优势与劣势；清晰哪些技能和素质需要进一步培训，在实际工作中扬长避短，促进自我职业生涯与集团战略的有机结合。");
		$section->addTitle("2、测评流程",2);
		$section->addText("    综合测评分为五个阶段：");
		$section->addText("    一是测评前准备。这一阶段确定测试人才的人数、测评时间、测评内容、测评群体的总体情况；收集测评人才简历；编制测评总体需求量表。");
		$section->addText("    二是人机对话测评。通过“6＋1”系统综合测评，人均获取近1000个定性与定量数据，经过数据处理与统计分析，为专家面询提供科学、准确、客观、真实的测评结果。");
		$section->addText("    三是专家面询。这一过程人均半小时，目的是让有较高领导岗位经历和复合学科背景的专家依据测评结果，与中青年人才一对一的互动沟通：首先，帮他们清晰自己的优劣势；其次，为他们排忧解惑；最后，为每位中青年人才梳理出与集团发展匹配的对策。");
		$section->addText("    四是撰写总体与个体报告。依据对“6＋1”大数据分析结果撰写总体综合素质分析报告；整合个人测评结果和专家面询评价，撰写每位人才的综合测评分析报告。");
		$section->addText("    五是汇报与反馈。向集团领导汇报总体与个体测评结果，反馈无记名满意度调查报告等，针对集团发展战略和现代人力资源管理提出针对性的建议与对策。");
		$section->addTitle("3、技术路径",2);
		$section->addText("    “中心”的综合测评系统始于1988年博士研究成果，经历了26年实践检验，其过程（1）测评地域：北京、上海、天津、广东、山西、湖南、湖北、陕西、内蒙、海南、浙江、山东、辽宁、河南等省市；（2）年龄：20～68岁；（3）学历：大专～博士后；（4）职称：初级～两院士；（5）职务：初、中级～政府副部长、部队中将（陆海空）；（6）类型：跨国公司高管、各类企业高管与技术人才；（7）测评人数：3万多人；（8）测评数据：每人925个；（9）获得荣誉：7次获国家自然科学基金资助，2次获航空科学基金资助，4次获省部级科学技术进步二等奖和管理成果一等奖；在国内外核心刊物发表论文30多篇，专著一本；测评软件50多套；培养出3名博士、9名硕士；经调查，客户反映测评准确率高、效果明显，平均满意度达97.8%，受到被测评人才和用人单位的普遍欢迎和认可。");
		
		//part2  基本情况分析
		$section->addTitle("二、综合测评基本情况分析",1);
	// 	$inquery = InqueryQuestion::find(array(
	// 		'project_id=?1',
	// 		'bind'=>array(1=>$project_id)));
	// 	$option = array();
	// 	foreach ($inquery as $inquerys) {
	// 		$option[] = explode('|', $inquerys->options);
	// 	}
	// 	$inquery_ans = InqueryAns::find(array(
	// 		'project_id=?1',
	// 		'bind'=>array(1=>$project_id)));
	// 	$ans = array();
	// 	foreach ($inquery_ans as $inquery_anses) {
	// 		$ans[] = explode('|', $inquery_anses->option);
	// 	}
	// 	$section->addText("        参加本次测评对象是集团的中青年人才（或简称“人才”），有".(count($option[0])+1)."个重要定义：");
	// 	$section->addText("总体：参加测评的中青年人才，共".$examinee_num."人；");
	// 	for($i = 0;$i < count($option[0]);$i++) {
	// 		$section->addText($option[0][$i]."：".self::countNum($ans,0,$i)."人");
	// 	}
		$section->addTitle("（一）	基本信息分析",2);
		$section->addTitle("1.总体男女比例",3);
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(1000)->addText("职务");
		$table->addCell(1000)->addText("总人数");
		$table->addCell(1000)->addText("男性人数");
		$table->addCell(1000)->addText("女性人数");
		for($r = 1; $r <= 5; $r++) { 
			$table->addRow();
			$table->addCell(100)->addText();
			$table->addCell(100)->addText();
			$table->addCell(100)->addText();
			$table->addCell(100)->addText();
		}
		// $section->addText("如图1所示，".$examinee_num."位中青年人才中，男性有".."人，占总人数".."%；女性".."人，占总人数".."%");
		$section->addText("    相关分析：",$fontStyle);

		$section->addText("    相关分析：",$fontStyle);

		$section->addTitle("（二）职业素质分析",2);

		$section->addTitle("（三）工作满意度分析",2);

		$section->addTitle("（四）培训现状及需求分析",2);

		//测评结果
		$section->addTitle("三、测评结果及特点分析",1);
		$section->addTitle("1、五个突出优势的特征",2);


		//结论与建议
		$section->addTitle("五、结论与建议",1);
		$section->addTitle("（一）本次综合测评的基本评价",2);
		$section->addTitle("1、印证了集团对中青年人才培养前瞻性、系统性和实效性",3);
		// $section->addText("    通过本次综合测评与统计分析，得到了具有优秀发展潜质的中青年人才占".$level1."、有良好发展潜质占".$level2."、中等潜质为".$level3."的测评结果，进一步证明了集团在中青年人才培养体系的系统性、科学性、精准性、可行性及实操性。");
		$section->addTitle("2、量化了集团中青年人才的发展潜质和培养与培训路径",3);
		$section->addText("    以人均1000多个数据为基础，有复合的理论体系和系统的方法体系为支撑，对所有参加测评的中青年人才量化的内容有四：一是进行了发展潜质的量化排序；二是精确了能否胜任现有岗位的五级评分；三是明确了今后的培养方向；四是清晰了下一步培训的重点。");
		$section->addTitle("3、形成了具有XXX集团特色的中青年人才队伍",3);
		$section->addText("    集团有一支性别结构均衡、有行业特点，人才梯队结构年龄分布合理，专业门类较齐全、理工科配备合适，学历结构适当，对集团发展前景高度认可的中青年人才队伍。");
		$section->addTitle("4、突显了集团中青年人才特质",3);
		$section->addText("    形成了外向开朗、身心健康、阳光向上、精力充沛的人格；思路清晰，有追求和不断总结的归纳提炼能力；具有后天勤奋和先天聪明，勇于实践，训练有素的分析能力；还具有自律谨严，心胸开阔，持之以恒的纪律性；能很好胜任现有岗位的中青年人才特质。");
		$section->addTitle("5、彰显了集团对人才培养与培训合理性",3);
		$section->addText("    以XXX类专业技术人才为主体的中青年人才结构，能够与承担的集团工作任务特点相适应；通过培训需求和学历调查得知，中青年人才均受过高等教育，有较高的工作能力和职业素质，有丰富的工作经验，是一支总体素质较高的人才队伍。");
		$section->addTitle("6、突出了中青年人才较高的自知之明，普遍比较低调",3);
		$section->addText("    总体对自身发展有较明确定位，对个人能力的特长、胜任岗位的优势，以及能力素质的短板有比较客观的认识与评价，对职业生涯发展规划有迫切的需求。如：在在专家面询中，他们与专家互动最多的是如何改进自己的不足。而在“6＋1”调查中，统计自认为非常胜任现有工作岗位是25%，但实际测评结果却是50%。");
		$section->addTitle("7、达成了个人与集团发展较一致的职业目标",3);
		$section->addText("    对自身建设的努力方向、存在的问题和面临的任务，有比较一致的认识，并与集团促进人才发展目标较相吻合。因为100%的人对集团发展有信心，这些人才以在XXX工作为荣，把个人目标与集团目标匹配期望度非常高。");
		$section->addTitle("8、锻炼了一支经过基层磨练、综合素质高的集团总部中青年人才队伍",3);
		$section->addText("    集团总部中青年人才在心理健康、归纳能力、分析能力、聪慧性及对自我约束等均高于其他测评人才，而且他们大都经过基层历练，为集团机关发展与改革储备了优质与可靠的人才基础。");
		$section->addTitle("（二）本次测评出现的主要问题",2);
		$section->addTitle("1、集团在引进中青年人才来源还需要进一步优化",3);
		$section->addText("    中青年人才的专业结构较全面，学历水平比较高，职称层次较多。但来自名牌高校的优秀人才并不多，这也为什么在相应专业领域没有形成领军人才的直接原因。");
		$section->addTitle("2、集团总部人才优势与实际工作相矛盾的影响要引起重视",3);
		$section->addText("    测评结果显示，集团总部人才在工作的执著性、人际关系调节和独立工作能力均得分不高，但他们的实际潜质证明对应这三方面的短板是恰恰是他们的优势。为什么会出现这样矛盾呢？原因为：一是在集团总部有些部门存在管理传统和领导强势或无序；二是某些重要岗位出现人岗不匹配，理论上是出现了“彼德原理”现象，实际上是影响到下级或整个部门综合素质水平；三是集团总部“官本位”与现代管理相互交织产生的“蝴蝶效应”，不仅影响到这些人才，更重要的是已波及到总部管理层和下属企业。");
		$section->addTitle("3、危机感、局限性、依赖性较高比例不容忽视",3);
		$section->addText("    特别要强调的是：本次测评中68%的中青年人才工作求稳怕乱，除与本岗位有关的内容外，对其他的事情关心或关注很少，长此以往就会出现眼界不开阔、洞察力不强的局面；有79%的人才做事依靠上级布置，缺乏自主意识，不考虑工作为什么做，怎么样做；有75%的人才工作的执着性不强，自己有正确意见也不愿意或不敢发表，不太关心集团期望目标，只关注自己是否能完成局部的任务。长此下去，出了问题很难找到责任人，岗位责任与集团的绩效管理和绩效考核会形同虚设。");
		$section->addTitle("4、集团需要系统化的培训体系",3);
		$section->addText("    从综合测评看到：集团的培训年年都在不断创新，不断改进，不断提升。但随着外部环境不断变化，应对式的培训已经满足不了集团各层级人才的需求，这就需要从集团战略顶层面系统思考的培训规划与体系。如：中青年人才非常需要职业技能、管理方法、沟通技巧等系统的综合素质与能力方面的培训，也期望集团在这些方面加大对他们训练的力度，尽快提升他们的综合素质。");
		$section->addTitle("5、岗位稳定性过高，晋升困难，“天花板”和“温水煮青蛙”并存",3);
		$section->addText("    大部分中青年人才在当前职位上长久得不到调整或者提升，有些人才在基层助理职位上工作已有8年或更长。虽然岗位稳定能让人才在现有职务上游刃有余的完成工作，但思维模式和工作方法容易禁锢于固有的模式之中，“温水煮青蛙”的现象在这些人才中比较这普遍，长此下去，他们对职业前景的期待成为了“天花板”，随之带来就是理想逐渐倦怠，工作缺乏激情。");
		$section->addTitle("6、薪酬福利急待提升",3);
		$section->addText("    调查结果显示，大量中青年人才选择在集团工作的原因只有很少是因为薪资福利优厚；在希望集团能够改善的问题，更多人的期望能提高收入，增加福利。这说明集团在吸引优秀人才上，薪资福利的吸引力较弱，这也是吸引不到国内外优秀人才的重要原因所在。");
		$section->addTitle("（三）建议与对策",2);
		$section->addTitle("1、建立与集团战略匹配的现代化人力资源管理体系",3);
		$section->addText("    综合考虑本次测评结果，建议集团尽快建立与集团战略匹配的现代化人力资源管理体系。以中青年人才综合素质测评作为切入点，制定科学、规范、合理的人才发展规划；以培养高层次、复合型人才为重点，打造有目标、有重点、有计划、有针对性的现代化人力资源管理体系。");
		$section->addTitle("2、建立完善的薪酬福利体系，加大激励与吸引优秀人才的力度",3);
		$section->addText("    通过本次测评，中青年人才普遍希望集团的薪酬福利能够进一步得到提升，希望能引起集团领导的关注并提出匹配的解决对策。尽管XXX属于城市公共服务类，但其服务水平、所承担的职责和忠诚度远远高于一般的企业，而这一切取决于人才综合素质。");
		$section->addTitle("3、建立基于集团战略的现代人力资源管理的培训体系",3);
		$section->addText("    以集团人才规划为出发点，根据不同层次的人才，建立健全适合集团发展战略的培训体系已迫在眉睫。并在此基础上开展针对各层次人才的短板、个性化的培训，提升集团人才队伍的整体综合素质能力；注重中青年人才结合岗位需求有针对性培训，加大对这些人才培养与培训力度，重点就专业技能、管理方法、团队合作、人际沟通等进行全方位、多形式的培训。");
		$section->addTitle("4、建立合理的调岗及晋升制度，搭建中青年人才成长平台",3);
		$section->addText("    中青年人才在集团工作的稳定性普遍很高，但同时存在的问题就是没有多余的岗位吸引新的优秀人才加入。集团建立合理的调岗及晋升制度之后，不仅能促进现有人才的工作积极行，明确他们的职业发展道路，激发其工作热情，避免“天花板”现象；调岗和人才晋升之后，空余的岗位可以吸纳更多优秀的人才，给集团人才梯队注入新鲜血液，带来新思想、新技能。");
		$section->addTitle("5、对不同层次后备人才进行职业生涯规划",3);
		$section->addText("    结合集团战略与人才发展规划，以各层次后备人才综合测评作为切入点，以培养高层次、复合型人才为重点，打造有目标、有重点、有计划、有针对性的人才职业生涯规划和针对性、使用与培养相结合的体系。");
		$section->addTitle("6、建立不同层次人才综合素质体系，让优秀人才脱颖而出",3);
		$section->addText("    针对集团管理层和领导方法等有待提升的空间，以本次中青年人才综合测评结果为契机，在不同层次、不同群体人才综合素质与需求动机进行对比分析基础上，建立与集团发展战略需求相匹配胜任力标准，让德才兼备，想干事、能干事、干成事的人才在集团平台上施展自己的才华，使XXX集团成为行业的标杆！");
		//命名
		$fileName = $project->name."+comprehensiveReport";
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
		$objWriter->save('wordexport/'.$fileName.'.docx');
	}

	/**
	 * @usage 班子胜任力报告生成
	 * @param
	 */
	public function teamReport($project_id){
		//get basic info
		/*
		TODO...
		*/
		$sectionStyle = array(
			  'orientation'=>'portrait',
			  'marginLeft'   => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.59),
			  'marginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25),
			  'marginTop'    => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),
			  'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),
			  'pageSizeW'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
			  'pageSizeH'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
			  'headerHeight'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
			  'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.75),	  
		);
		$section = $this->wordHandle->addSection($sectionStyle);
		//set default style
		$this->wordHandle->setDefaultFontName('Microsoft YaHei');
		$this->wordHandle->setDefaultFontSize(12);
		$captionFontStyle = array('color' => 'red','size' => 18);
		$titleFontStyle = array('color' => 'blue','size' => 14,'bold' => true);
		$fontStyle1 = array('bold' => true,'size' => 14);
		$fontStyle2 = array('bold' => true,'color' => 'blue');
		$paragraphStyle1 = array('lineHeight'=>1.5);
		$paragraphStyle2 = array('alignment'=>'center');
		//set table style
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$this->wordHandle->addTableStyle('myOwnTableStyle', $styleTable);
		//report part
		$table = $section->addTable('myOwnTableStyle');
		$table->addRow();
		$table->addCell(11000)->addText("个人与班子对比",$captionFontStyle,$paragraphStyle2);
		$table->addRow();
		$table->addCell(11000)->addText("班子名称",$fontStyle1,$paragraphStyle2);
		$table->addRow();
		$table->addCell(11000)->addText("胜任素质评分",$titleFontStyle,$paragraphStyle2);
		$table->addRow();
		$table->addCell(1000);
		/*
		图表  TODO...
		addImage();
		*/
		$table->addRow();
		$table->addCell(11000)->addText("胜任力评价 ",$titleFontStyle,$paragraphStyle2);
		/*
		TODO...
		优劣势评语获取
		*/
		$table->addRow();
		$advantageCell = $table->addCell(11000);
		$advantageCell->addText("主要优势有五点：",$fontStyle2,$paragraphStyle1);
		$array1 = array('一','二','三','四','五');
		for ($i=0; $i < 5; $i++) { 
			$advantageCell->addText($array1[$i]);
		}
		$table->addRow();
		$disadvantageCell = $table->addCell(11000);
		$disadvantageCell->addText("有待改进有三点：",$fontStyle2,$paragraphStyle1);
		$array2 = array('一','二','三');
		for ($i=0; $i < 3; $i++) { 
			$disadvantageCell->addText($array2[$i]);
		}
		//命名
		$fileName = $project_id."+teamReport";
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
		$objWriter->save('wordexport/'.$fileName.'.docx');
	}

	/**
	 * @usage 系统胜任力报告生成
	 * @param
	 */
	public function systemReport($project_id){
		\PhpOffice\PhpWord\Autoloader::register();
		$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
		//get basic info
		$examinee = Examinee::find(array(
			'project_id=?0 and team=?1 and state>4',
			'bind'=>array(0=>$project_id,1=>'系统')));
		if (count($examinee) == 0) {
			throw new Exception('还未有人参与测试！');
		}
		foreach ($examinee as $examinees) {
			$index_score = IndexAns::find(array(
				'examinee_id=?1',
				'bind'=>array(1=>$examinees->id)));
			foreach ($index_score as $iscore) {
				$score[$iscore->index_id][] = $iscore->score;
			}
		}
		foreach ($score as $key => $value) {
			$sum = array_sum($value);
			$count = count($value);
			$avg[$key] = $sum / $count;
		}
		arsort($avg);
		if (count($avg) > 5) {
			$advantage = array_slice($avg, 0, 5, true);
		}else{
			$advantage = $avg;
		} 
		$disadvantage = array_slice($avg, count($avg)-3, 3, true);
		foreach ($advantage as $key => $value) {
			$chs_name = Index::findFirst($key)->chs_name;
			$advantages[$chs_name] = $value;
			$comment = CompetencyComment::findFirst(array(
				'name=?1',
				'bind'=>array(1=>$chs_name)))->advantage;
			$comment = explode("|", $comment);
	 		$acomment[] = array_rand($comment);
		}
		foreach ($disadvantage as $key => $value) {
			$chs_name = Index::findFirst($key)->chs_name;
			$disadvantages[$chs_name] = $value;
			$comment = CompetencyComment::findFirst(array(
				'name=?1',
				'bind'=>array(1=>$chs_name)))->disadvantage;
			$comment = explode("|", $comment);
	 		$dcomment[] = array_rand($comment);
		}
		//cell style
		$CellNum = count($advantages) + count($disadvantages) + 1;
		$CellLength = 11000 / $CellNum;
		//set section style
		$sectionStyle = array(
			  'orientation'=>'portrait',
			  'marginLeft'   => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.59),
			  'marginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25),
			  'marginTop'    => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),
			  'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),
			  'pageSizeW'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
			  'pageSizeH'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
			  'headerHeight'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
			  'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.75),	  
		);
		$section = $this->wordHandle->addSection($sectionStyle);
		//set default style
		$this->wordHandle->setDefaultFontName("Microsoft YaHei");
		$this->wordHandle->setDefaultFontSize(12);
		$captionFontStyle = array('color' => 'red','size' => 18,'bold' => true);
		$titleFontStyle = array('color' => 'blue','size' => 14,'bold' => true);
		$fontStyle1 = array('bold' => true,'size' => 14);
		$fontStyle2 = array('color' => 'blue','bold' => true);
		$paragraphStyle1 = array('lineHeight'=>1.5);
		$paragraphStyle2 = array('alignment'=>'center');
		//set table style
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$this->wordHandle->addTableStyle('myOwnTableStyle', $styleTable);
		//report part
		$table = $section->addTable('myOwnTableStyle');
		$table->addRow();
		$cell1_19 = $table->addCell($CellLength);
		$cell1_19->getStyle()->setGridSpan($CellNum);
		$cell1_19->addText("系统胜任力测评结果",$captionFontStyle,$paragraphStyle2);
		$table->addRow();
		$cell2_13 = $table->addCell($CellLength);
		$cell2_13->getStyle()->setGridSpan($CellNum);
		$cell2_13->addText("系统名称",$fontStyle1,$paragraphStyle2);
		$table->addRow();
		$cell3_19 = $table->addCell($CellLength);
		$cell3_19->getStyle()->setGridSpan($CellNum);
		$cell3_19->addText("胜任素质评分",$titleFontStyle,$paragraphStyle2);
		$table->addRow();
		foreach ($advantages as $key => $value) {
			$table->addCell($CellLength)->addText($key,$fontStyle1);
		}
		foreach ($disadvantages as $key => $value) {
			$table->addCell($CellLength)->addText($key,$fontStyle1);
		}
		$table->addCell($CellLength)->addText("总分", $fontStyle1);
		$table->addRow();
		foreach ($advantages as $key => $value) {
			$table->addCell($CellLength)->addText($value,$fontStyle1);
		}
		foreach ($disadvantages as $key => $value) {
			$table->addCell($CellLength)->addText($value,$fontStyle1);
		}
		$table->addCell($CellLength)->addText();
		$table->addRow();
		$cell6_19 = $table->addCell($CellLength);
		$cell6_19->getStyle()->setGridSpan($CellNum);
		/*
		图表  TODO...
		addImage();
		*/
		$table->addRow();
		$cell7_19 = $table->addCell($CellLength);
		$cell7_19->getStyle()->setGridSpan($CellNum);
		$cell7_19->addText("胜任力评价 ",$titleFontStyle,$paragraphStyle2);
		
		$table->addRow();
		$cell8_19 = $table->addCell($CellLength);
		$cell8_19->getStyle()->setGridSpan($CellNum);
		$cell8_19->addText("主要优势有：",$fontStyle2,$paragraphStyle1);
		$array1 = array('一','二','三','四','五');
		for ($i=0; $i < 5; $i++) { 
			$cell8_19->addText($array1[$i]."是".$acomment[$i]);
		}
		$table->addRow();
		$cell9_19 = $table->addCell($CellLength);
		$cell9_19->getStyle()->setGridSpan($CellNum);
		$cell9_19->addText("有待改进有：",$fontStyle2,$paragraphStyle1);
		$array2 = array('一','二','三');
		for ($i=0; $i < 3; $i++) { 
			$cell9_19->addText($array2[$i]."是".$dcomment[$i]);
		}
		//命名
		$fileName = $project_id."+systemReport";
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
		$objWriter->save('wordexport/'.$fileName.'.docx');
	}	

}


