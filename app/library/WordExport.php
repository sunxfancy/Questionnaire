<?php

include("../app/classes/PHPWord.php");

class WordExport
{
	public function examineeReport($examinee,$project_id){
		$PHPWord = new PHPWord();
		$section = $PHPWord->createSection();

		$section->addText('综合素质I 测评报告',array('size'=>24, 'color'=>'red','bold'=>true));
		$section->addTextBreak(1);
		$section->addText("测评对象：".$examinee->name,array('size'=>20));
		$section->addTextBreak(1);
		$section->addText("性    别：".$examinee->sex,array('size'=>20));
		$section->addTextBreak(1);
		$section->addText("出生年月：".$examinee->birthday,array('size'=>20));
		$section->addTextBreak(1);
		$section->addText("测试单位：北京国合点金管理咨询有限公司",array('size'=>20));
		$section->addTextBreak(1);
		$section->addText("测试时间：".$examinee->last_login,array('size'=>20));
		$section->addTextBreak(1);

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


