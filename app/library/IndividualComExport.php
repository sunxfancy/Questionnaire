<?php
	/**
	 * @usage 个体综合报告导出word
	 * @notice 该文件生成到系统临时目录中
	 * @文件生成名称  $examinee_id_$date_rand(100,900).docx
	 */
require_once '../app/classes/PhpWord/Autoloader.php';
class IndividualComExport extends \Phalcon\Mvc\Controller
{	
	public  $wordHandle = null;
	/**
	 * @usage 个体综合报告生成
	 * @param
	 */
	private function getBasic($examinee_id){
		//---------------------------------------------------
		// basic
		//check examinee_id;
		$report = new individualComData();
		$project_id = $report->self_check($examinee_id);
		//get basic info
		$examinee = Examinee::findFirst($examinee_id);
		//get all data
		$data = array();
		$data['name'] = $examinee->name;
		$data['sex']  = $examinee->sex == 1? '男' : '女';
		$data['birth'] = $examinee->birthday;
		$data['test_date'] = explode(' ',$examinee->last_login)[0];
		$json = json_decode($examinee->other,true);
		$data['school'] = '';
		$data['degree'] = '';
		if (isset($json['education'])){
			if (isset($json['education'][0])){ //必须是有相应的记录项
				$data['school']  = $json['education'][0]['school'];
				$data['degree']  = $json['education'][0]['degree'];
			}
		}
		$time_str = '';
		$time = $examinee->exam_time;
		foreach (array(3600=>'小时', 60=>'分',1=>'秒') as $key => $value) {
			if ($time >= $key) {
				$time_str .= floor($time / $key).$value;
				$time %= $key;
			}
		}
		$data['exam_time'] = $time_str;
		$data['works'] = '';
		if (isset($json['work'])){
			if (isset($json['work'][0])){ //必须是有相应的记录项
				$data['works'] = $json['work'];
			}
			
		}
		$data['exam_time_flag'] = array();
		if ($examinee->exam_time > 10800) {
			$data['exam_time_flag']['key'] = 1;
			$data['exam_time_flag']['value']  = '未在规定时间内完成';
		}else if($examinee->exam_time > 8400){
			$data['exam_time_flag']['key'] = 2;
			$data['exam_time_flag']['value']  = '在规定时间内完成';
		}else if($examinee->exam_time > 5400){
			$data['exam_time_flag']['key'] = 3;
			$data['exam_time_flag']['value']  = '比正常快近三分之一';
		}else{
			$data['exam_time_flag']['key'] = 4;
			$data['exam_time_flag']['value']  = '比正常快近二分之一';
		}
		$data['exam_auth_flag'] = array();
		$data['exam_auth_flag']['key'] = $report->IsHidden($examinee_id);
		$data['exam_auth_flag']['value'] = $data['exam_auth_flag']['key'] ? '真实（掩饰性系数低于平均水平）':'不真实（掩饰性系数高于平均水平）';
		
		if ($data['exam_time_flag']['key'] > 1 && $data['exam_auth_flag']['key'] ){
			$data['exam_evalute'] = '不仅快且准确';
		}else if ($data['exam_time_flag']['key'] > 1 && !$data['exam_auth_flag']['key']){
			$data['exam_evalute'] = '虽然快但不准确';
		}else if ($data['exam_time_flag']['key'] == 1 && $data['exam_auth_flag']['key'] ){
			$data['exam_evalute'] = '虽然慢但准确';
		}else{
			$data['exam_evalute'] = '不仅慢且不准确';
		}		
		$tmp_systemCom = $report->getSystemComprehensive($examinee_id);
		$data['excellent_rate'] = $tmp_systemCom['value'];

		$data['excellent_evaluate_key'] = $tmp_systemCom['level'];
		switch($data['excellent_evaluate_key']){
			case 1: $data['excellent_evaluate'] = '优'; break; 
			case 2: $data['excellent_evaluate'] = '良'; break;
			case 3: $data['excellent_evaluate'] = '中'; break;
			case 4: $data['excellent_evaluate'] = '差'; break;
		}
		$data['advantage'] = $report->getAdvantages($examinee_id);
		$data['disadvantage'] = $report->getDisadvantages($examinee_id);
		$data['com'] = $report->getindividualComprehensive($examinee_id);
		foreach($data['com'] as $key=>$value){
		 switch($key) {
		 	case "心理健康" : $data['com'][$key]['name'] = '职业心理'; $data['com'][$key]['des']='职业心理共有七项指标'; break;
		 	case "素质结构" : $data['com'][$key]['name'] = '职业素质'; $data['com'][$key]['des']='职业素质共有八项指标'; break;
		 	case "智体结构" : $data['com'][$key]['name'] = '三商与身体'; $data['com'][$key]['des']='三商与身体共有六项指标'; break;
		 	case "能力结构" : $data['com'][$key]['name'] = '职业能力'; $data['com'][$key]['des']='职业能力共有七项指标'; break;
		 }
		}
		$tmp_interview = $report->getComments($examinee_id);
		$data['remark'] = $tmp_interview['remark'];
		$data['advantages'] = $tmp_interview['advantage'];
		$data['disadvantages'] = $tmp_interview['disadvantage'];
		return $data;
	}
	
	public function report($examinee_id){
		\PhpOffice\PhpWord\Autoloader::register();
		$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
		$data = $this->getBasic($examinee_id);
		$chart = new WordChart();
		//----------------------------------------------------
		// layout 
		$sectionStyle = array(
			  'borderColor'=>'000000',
			  'borderSize'=>1,
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
		//add section
		$section = $this->wordHandle->addSection($sectionStyle);
		$section->getStyle()->setPageNumberingStart(1);
		$header = $section->addHeader();
		$footer = $section->addFooter();
		$footer->addPreserveText('{PAGE}/{NUMPAGES}', array('size'=>10,'color'=>'000000',), array('alignment'=>'center', 'lineHeight'=>1));
		//set first logo pic
		$section->addImage('reportimage/logo.png', 
		array('width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(6.88), 
			  'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(3.06),
        	  'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
        	  'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
        	  'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_OMARGIN,
        	  'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        	  'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_OMARGIN, 
		));
	    $section->addTextBreak(4,array('size'=>12),array('lineHeight'=>1.5));
	    // set caption block 
	    $caption = $section->createTextrun();
	    $caption->addImage('reportimage/fengmian.png',
	    array('marginTop'     => -1,
           	  'marginLeft'    =>\PhpOffice\PhpWord\Shared\Converter::cmToInch(1) ,
           	  'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(4.86), 
			  'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(4.06),
			  'wrappingStyle'=>'square',
        ));
	 	$caption->addText('综合素质测评报告',
		array('color'=>'red',
			  'size'=>36,			
		));
	 	$section->addTextBreak(1,array('size'=>'22'),array('lineHeight'=>1.5));
	 	//set examinee textrun
		$examineeinfotextrun = $section->addTextRun(
	 	array('borderTopSize'=>1,
			  'borderTopColor'=>'000000',
	 		  'lineHeight'=>1.5,	
	 		  'valign'=>'center',	
		));
	 	$basicInfoFontStyle = array('size'=>14,'bold'=>true);
	 	$examineeinfotextrun->addTextBreak();
	 	$examineeinfotextrun->addText('测评对象： '.$data['name'],$basicInfoFontStyle);
	 	$examineeinfotextrun->addTextBreak();
	 	$examineeinfotextrun->addText('性    别： '.$data['sex'],$basicInfoFontStyle);
	 	$examineeinfotextrun->addTextBreak();
	 	$examineeinfotextrun->addText('出生年月： '.$data['birth'], $basicInfoFontStyle);
	 	$examineeinfotextrun->addTextBreak();
	 	$examineeinfotextrun->addText('测试单位： 北京国合点金管理咨询有限公司',$basicInfoFontStyle);
	 	$examineeinfotextrun->addTextBreak();
	 	$examineeinfotextrun->addText('测试时间： '.$data['test_date'], $basicInfoFontStyle);
	 	
	 	$section->addPageBreak();
	 	// Define the TOC font style
	 	$section->addText("目录",	array('size'=>18,'color'=>'red'),array('alignment'=>'center', 'lineHeight'=>1.5));
	 	$section->addTOC(array('size'=>14),\PhpOffice\PhpWord\Style\TOC::TABLEADER_LINE, 1,3);
	 	$section->addPageBreak();
	 	
	 	// Add title styles
	 	$this->wordHandle->addTitleStyle(1, array('size' => 14, 'color' => 'red',  'bold' => true), array( 'lineHeight'=>1.5));
	 	$this->wordHandle->addTitleStyle(2, array('size' => 14, 'color' => 'blue', 'bold' => true), array( 'lineHeight'=>1.5));
	 	$this->wordHandle->addTitleStyle(3, array('size' => 14,  'color' =>'blue', 'bold' => true), array( 'lineHeight'=>1.5));
		
	 	$section->addTitle('一、个人情况综述', 1);
	 	$section->addTitle('个人信息',2);
	 	$section->addListItem("姓名： ".$data['name']."（".$data['sex']."）", 0, array('size'=>14), \PhpOffice\PhpWord\Style\ListItem::TYPE_SQUARE_FILLED,  array('lineHeight'=>1.5));
	 	$section->addListItem("毕业院校： ".$data['school'].$data['degree'], 0,  array('size'=>14),\PhpOffice\PhpWord\Style\ListItem::TYPE_ALPHANUM,  array('lineHeight'=>1.5));
	 	$section->addListItem("规定测试时间： 3小时", 0, array('size'=>14),\PhpOffice\PhpWord\Style\ListItem::TYPE_ALPHANUM,  array('lineHeight'=>1.5));		
	 	$section->addListItem("实际完成时间：".$data['exam_time'], 0,  array('size'=>14), \PhpOffice\PhpWord\Style\ListItem::TYPE_ALPHANUM, array('lineHeight'=>1.5));
	 	$section->addTitle('工作经历',2);
	 	$table = $section->addTable(
	 		array('borderSize'=>1, 
	 			  'borderColor'=>'000000',
	 			   'align'=>'center'
	 	)
	 	);
	 	//判断工作经历是否为空
	 	if(empty($data['works'])){
	 		$section->addText("空",array('size'=>14),array('lineHeight'=>1.5));
	 	}else{
	 		$row = $table->addRow(600);
	 		$row->addCell(2500, array('valign'=>'center'))->addText("工作单位",array('size'=>14),array('alignment'=>'center'));
	 		$row->addCell(2500, array('valign'=>'center'))->addText('部门',array('size'=>14),array('alignment'=>'center'));
	 		$row->addCell(2500, array('valign'=>'center'))->addText('职位',array('size'=>14),array('alignment'=>'center'));
	 		$row->addCell(2500, array('valign'=>'center'))->addText('工作时间',array('size'=>14),array('alignment'=>'center'));
	 		foreach($data['works'] as $value){
	 			$table->addRow(600);
	 			$table->addCell(2500,array('valign'=>'center'))->addText($value['employer'],array('size'=>14),array('alignment'=>'center'));
	 			$table->addCell(2500,array('valign'=>'center'))->addText($value['unit'],array('size'=>14),array('alignment'=>'center'));
	 			$table->addCell(2500,array('valign'=>'center'))->addText($value['duty'],array('size'=>14),array('alignment'=>'center'));
	 			$table->addCell(2500,array('valign'=>'center'))->addText($value['date'],array('size'=>14),array('alignment'=>'center'));
	 		}
	 	}
	 	$section->addTextBreak(1,array('size'=>14),array('lineHeight'=>1.5));
	 	$text = '    测试要求3小时，以'.$data['exam_time'].'完成，'.$data['name'].$data['exam_time_flag']['value'].'，且回答'.$data['exam_auth_flag']['value'].'，说明其阅读'.$data['exam_evalute'].'。 ';
	 	$section->addText($text,array('size'=>14),array('lineHeight'=>1.5));
	 	$section->addTextBreak(1,array('size'=>14),array('lineHeight'=>1.5));
	 	
	 	$table = $section->addTable();
	 	$row = $table->addRow();
	 	$text = '    根据测试结果和综合统计分析，分别从职业心理、职业素质、职业心智、职业能力等做出系统评价，按优、良、中、差四个等级评分。综合得分：优秀率为'.$data['excellent_rate'][0].'%，良好率为'.$data['excellent_rate'][1].'%，中为'.$data['excellent_rate'][2].'%，差为'.$data['excellent_rate'][3].'%，综合发展潜质为'.$data['excellent_evaluate'].'，如右图所示。 ';
	 	$row->addCell(7000)->addText($text,array('size'=>14),array('lineHeight'=>1.5));
	 	//add chart
	 	$fileName = $chart->barGraph_1($data['excellent_rate'], $examinee_id);
	 	if (file_exists($fileName)){
	 		$row->addCell(3000)->addImage($fileName,
	 				array(
	 						'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.77),
	 						'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.48),
	 						'wrappingStyle'=>'square',
	 				));
	 	}
	 	$section->addPageBreak();
	 	$section->addTitle('二、测评结果', 1);
	 	$section->addTitle('1、突出优势',2);
	 	foreach($data['advantage'] as $value){
	 		$section->addTitle($value['chs_name'],3);
 			$children = explode(",", $value['children']);
 			$count = count($children);
 			$j = 0;
 			$comments = array();
 			foreach($value['detail'] as $svalue){
 				$advantages = ChildIndexComment::findFirst(array(
 						'child_chs_name=?1 AND index_chs_name=?2',
 						'bind'=>array(1=>$svalue['chs_name'], 2=>$value['chs_name'])))->advantage;
 				$advantage = json_decode($advantages, true);
 				$rand_key = array_rand($advantage);
 				$convert_array = array('一','二','三');
 				$comments[]= $convert_array[$j++].$advantage[$rand_key];
 			}
 			$table = $section->addTable();
 			$row = $table->addRow();
 			$text_1 = "    本项内容共由".$count ."项指标构成，满分10分。根据得分的高低排序，分析".$data['name']."得分排在前三项具体特点为：";
 			$text_2 ="。具体分布如右图所示： ";
 			$textrun = $row->addCell(7000)->addTextRun(array('lineHeight'=>1.5));
 			$textrun->addText($text_1, array('size'=>14));
 			$textrun->addText(implode('；',$comments), array('size'=>14, 'bold'=>true));
 			$textrun->addText($text_2, array('size'=>14));
 			//add chart
 			$fileName = $chart->barGraph_2($value['detail'], $examinee_id, 'Cyan');
 			if (file_exists($fileName)){
 				$row->addCell(3000)->addImage($fileName,
 						array(
 								'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.77),
 								'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.48),
 								'wrappingStyle'=>'square',
 						));
 			}
 			$section->addTextBreak();	
	 	}
	 	$section->addTitle('2、需要改进方面',2);
	 	foreach($data['disadvantage'] as $value){
	 		$section->addTitle($value['chs_name'],3);
	 		$children = explode(",", $value['children']);
	 		$count = count($children);
	 		$j = 0;
	 		$comments = array();
	 		foreach($value['detail'] as $svalue){
	 			$advantages = ChildIndexComment::findFirst(array(
 						'child_chs_name=?1 AND index_chs_name=?2',
 						'bind'=>array(1=>$svalue['chs_name'], 2=>$value['chs_name'])))->disadvantage;
	 			$advantage = json_decode($advantages,true);
	 			$rand_key = array_rand($advantage);
	 			$convert_array = array('一','二','三');
	 			$comments [] = $convert_array[$j++].$advantage[$rand_key];
	 		}
	 		$table = $section->addTable();
	 		$row = $table->addRow();
	 		$text_1 = "    本项内容共由".$count ."项指标构成，满分10分。根据得分的由低到高排序，分析".$data['name']."得分偏低的原因为：";
	 		$text_2 = "。具体分布如右图所示： ";
	 		$textrun = $row->addCell(7000)->addTextRun(array('lineHeight'=>1.5));
	 		$textrun->addText($text_1, array('size'=>14));
	 		$textrun->addText(implode('；',$comments), array('size'=>14, 'bold'=>true));
	 		$textrun->addText($text_2, array('size'=>14));
	 		//add chart
	 		$fileName = $chart->barGraph_2($value['detail'], $examinee_id, 'darkgreen');
	 		if (file_exists($fileName)){
	 			$row->addCell(3000)->addImage($fileName,
	 					array(
	 							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.77),
	 							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.48),
	 							'wrappingStyle'=>'square',
	 					));
	 		}
	 		$section->addTextBreak();
	 	
	 	}
	 	$section->addPageBreak();
	 	$section->addTitle('三、综合评价', 1);
	 	if (empty($data['com'])){
	 		$section->addText('素质测评模块没有被选中', array('size'=>14,'bold'=>true,), array('lineHeight'=>1.5));
	 		$section->addTextBreak();
	 	}else{
	 		$table = $section->addTable();
	 		$row = $table->addRow();
	 		$key_array = array(); //图表名称数组
	 		$value_array = array(); // 图表值数组   一位小数
	 		$new_key_array = array(); // 文本名称数组
	 		$des_array = array(); //描述数组
	 		$index_array = array();
	 		foreach($data['com'] as $key =>$value ){
	 			$key_array[] = $key;
	 			$value_array[] = $value[0];
	 			$new_key_array[] = $value['name'];
	 			$des_array[] = $value['des'];
	 			$tmp = array();
	 			$tmp[] = $value[1][0]['name'];
	 			$tmp[] = $value[1][1]['name'];
	 			$tmp[] = $value[1][2]['name'];
	 			$index_array[] = $tmp;
	 		}
	 		$text_1 ="    综合评价分析包括对";
	 		$text_2 ="的分析。其中";
	 		$text_3 = "。由各指标的得分平均值得出";
	 		$text_4 = "的综合分。 ";
	 		$textrun = $row->addCell(7000)->addTextRun(array('lineHeight'=>1.5));
	 		$textrun->addText($text_1, array('size'=>14));
	 		$textrun->addText(implode('、',$new_key_array), array('size'=>14, 'bold'=>true));
	 		$textrun->addText($text_2, array('size'=>14));
	 		$textrun->addText(implode(',',$des_array), array('size'=>14));
	 		$textrun->addText($text_3, array('size'=>14));
	 		$textrun->addText(implode('、', $new_key_array), array('size'=>14));
			$textrun->addText($text_4, array('size'=>14));
	 		//add chart
	 		$fileName = $chart->radarGraph_1($value_array, $key_array, $examinee_id);
	 		if (file_exists($fileName)){
	 			$row->addCell(3000)->addImage($fileName,
	 					array(
	 							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.77),
	 							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(4.92),
	 							'wrappingStyle'=>'square',
	 					));
	 		}
	 		$i = 0;
	 		foreach($new_key_array as $value ){
	 			$section->addTitle($value,2);
	 			$textrun = $section->addTextRun(array('lineHeight'=>1.5));
	 			$textrun->addText($data['name'], array('size'=>14,'color'=>'blue'));
	 			//综合项指标评语  ComprehensiveComment 
	 			$comment = array();
	 			foreach ($index_array[$i++] as $value ){
	 				$comment[] = ComprehensiveComment::findFirst(array('index_chs_name = ?1', 'bind'=>array(1=>$value)))->comment;	
	 			}
	 			$textrun->addText(implode('；', $comment), array('size'=>14));
	 			$textrun->addText('。', array('size'=>14));
	 		}
	 		$section->addTextBreak();
	 	}
	 	$section->addPageBreak();
	 	$section->addTitle('四、结论与建议', 1);
	 	$table = $section->addTable(
	 		array('borderSize'=>1, 
	 			  'borderColor'=>'000000',
	 			  'align'=>'center'
	 	)
	 	);
	 	$row = $table->addRow(600);
	 	$firstCell = $row->addCell(2000, array('valign'=>'center'))->addText('优势',array('size'=>14,'color'=>'blue'),array('alignment'=>'center','lineHeight'=>1.5));
	 	$secondCell = $row->addCell(2000);
	 	$secondCell->getStyle()->setGridSpan(4);
	 	$i  = 1 ;
	 	foreach($data['advantages'] as $value){
	 		$secondCell->addText(($i++).'.'.$value,array('size'=>14),array('alignment'=>'left','lineHeight'=>1.5));
	 	}
	 	$row = $table->addRow(600);
	 	$firstCell = $row->addCell(2000, array('valign'=>'center'))->addText('改进',array('size'=>14,'color'=>'blue'),array('alignment'=>'center','lineHeight'=>1.5));
	 	$secondCell = $row->addCell(2000);
	 	$secondCell->getStyle()->setGridSpan(4);
	 	$i  = 1 ;
	 	foreach($data['disadvantages'] as $value){
	 		$secondCell->addText(($i++).'.'.$value,array('size'=>14),array('alignment'=>'left', 'lineHeight'=>1.5));
	 	}
	 	$row = $table->addRow(600);
	 	$row->addCell(2000, array('valign'=>'center','vMerge'=>'restart'))->addText('潜质',array('size'=>14,'color'=>'blue'),array('alignment'=>'center','lineHeight'=>1.5));
	 	$row->addCell(2000, array('valign'=>'center'))->addText("优",array('size'=>14),array('alignment'=>'center','lineHeight'=>1.5));
 		$row->addCell(2000, array('valign'=>'center'))->addText("良",array('size'=>14),array('alignment'=>'center','lineHeight'=>1.5));
 		$row->addCell(2000, array('valign'=>'center'))->addText("中",array('size'=>14),array('alignment'=>'center','lineHeight'=>1.5));
 		$row->addCell(2000, array('valign'=>'center'))->addText("差",array('size'=>14),array('alignment'=>'center','lineHeight'=>1.5));
 		$row = $table->addRow(600);
		$row->addCell(2000,array('vMerge' => 'continue'));
	 	for ($i=0; $i < 4; $i++) {
	 		if ( $data['excellent_evaluate_key'] == $i+1 ) {
	 			$table->addCell(2000)->addText('√',array('size'=>14,'color'=>'red'),array('alignment'=>'center','lineHeight'=>1.5));
	 		}else{
	 			$table->addCell(2000);
	 		}
	 	} 
	 	$row = $table->addRow(600);
	 	$firstCell = $row->addCell(2000, array('valign'=>'center'))->addText('评价',array('size'=>14,'color'=>'blue'),array('alignment'=>'center','lineHeight'=>1.5));
		$secondCell = $row->addCell(2000);
	 	$secondCell->getStyle()->setGridSpan(4);
	 	$secondCell->addText($data['remark'],array('size'=>14),array('lineHeight'=>1.5));
	 	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
		//临时文件命名规范    $examinee_id_$date_rand(100,900)
	 	$date = date('H_i_s');
	 	$stamp = rand(100,900);
		$fileName = './tmp/'.$examinee_id.'_'.$date.'_'.$stamp.'.docx';
		$objWriter->save($fileName);
		return $fileName;
	}
}


