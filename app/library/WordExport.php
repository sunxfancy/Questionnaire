<?php

include("../app/classes/PHPWord.php");

class WordExport
{
	public function examineeReport($examinee,$project_id){
		$PHPWord = new PHPWord();
		// $PHPWord->setDefaultFontSize(14);
		$section = $PHPWord->createSection();

		$section->addTextBreak(6);
		$section->addText('综合素质I 测评报告',array('size'=>36, 'color'=>'red','bold'=>true),array('align'=>'center'));
		$section->addTextBreak(1);
		$section->addText("测评对象：".$examinee->name,array('size'=>14));
		$section->addTextBreak(1);
		$section->addText("性    别：".$examinee->sex,array('size'=>14));
		$section->addTextBreak(1);
		$section->addText("出生年月：".$examinee->birthday,array('size'=>14));
		$section->addTextBreak(1);
		$section->addText("测试单位：北京国合点金管理咨询有限公司",array('size'=>14));
		$section->addTextBreak(1);
		$section->addText("测试时间：".$examinee->last_login,array('size'=>14));
		$section->addTextBreak(1);

		$section->addPageBreak();
		$section->addText("目录",array('color'=>'red','size'=>14));
		// $styleTOC = array('tabLeader'=>PHPWord_Style_TOC::TABLEADER_DOT); 
		// $styleFont = array('spaceAfter'=>60, 'name'=>'Tahoma', 'size'=>12); 
		// $section->addTOC($styleFont, $styleTOC);

		$section->addPageBreak();
		// $PHPWord->addTitleStyle(1，array('color'=>'red','size'=>14));
		$section->addTitle("一、个人情况综述",1);
		// $PHPWord->addTitleStyle(2，array('color'=>'red','size'=>14));
		$section->addTitle("个人信息",2);
		// $listStyle = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER);
		$section->addListItem("姓名：".$examinee->name."(".$examinee->sex.")");
		$section->addListItem("毕业院校：".$examinee->education);
		$section->addListItem("规定测试时间：3小时");
		$section->addListItem("实际完成时间：".$examinee->exam_time);
		$section->addTitle("工作经历",2);
		$table = $section->addTable();
		$table->addRow(400);
		$table->addCell(20)->addText("就职单位");
		$table->addCell(20)->addText("部门");
		$table->addCell(20)->addText("职位");
		$table->addCell(20)->addText("工作时间");

		if ($examinee->exam_time > 10800) {
			$comOrnot = '未在规定时间内完成';
		}else if($examinee->exam_time > 8400){
			$comOrnot = '在规定时间内完成';
		}else if($examinee->exam_time > 5400){
			$comOrnot = '比正常快近三分之一';
		}else{
			$comOrnot = '比正常快近二分之一';
		}
		foreach (array(3600=>'小时', 60=>'分') as $key => $value) {
			if ($examinee->exam_time >= $key) {
				$time .= floor($examinee->exam_time / $key).$value;
				$examinee->exam_time %= $key;
			}
		}
		// $section->addText("测试要求3小时，以".$time."完成，".$examinee->name.$comOrnot."，且回答"."真实（掩饰性系数低于平均水平）"."，说明其阅读"."不仅快而且准确。");

		$section->addPageBreak();
		$section->addTitle("二、测评结果",1);
		$section->addTitle("1、突出优势",2);
		
		// $section->addTitle($index1,3);



		//命名
		$fileName = $examinee->number."+".$examinee->name."+"."综合素质测评报告";
		header("Content-Disposition:attachment;filename=".$fileName.".doc"); 
		$this->commonMsg($PHPWord);
	}

	//导出为word文档
	public function commonMsg($PHPWord){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-word");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header("Content-Transfer-Encoding:binary");
        $Writer= PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $Writer->save('php://output');
    }

}


