<?php
/**
 * use for developer handle the DB[insert|update]: Paper, Question, **df[Cpi|Epps|Epqa|Ks|Scl|Som];
 * @author Wangyaohui
 */

class UploadController extends \Phalcon\Mvc\Controller {
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}
	
	public function indexAction() {	
		#进入上传页面	
	}
	#导入6套试题的指导语，名称
	public function uploadPaperAction(){
		echo "hel";
		exit();
		$paperData = array();
		$paperData[] = array(
				'description' =>"请根据自己的实际情况作“是”或“不是”的回答。这些问题要求你按自己的实际情况回答，不要去猜测怎样才是正确的回答。因为这里不存在正确或错误的回答，也没有捉弄人的问题，将问题的意思看懂了就快点回答，不要花很多时间去想。每个问题都要问答。问卷无时间限制，但不要拖延太长，也不要未看懂问题便回答。",
				'name'=>"EPQA"
		);
		$paperData[] = array(
				'description' =>"卡特尔十六种人格因素测验包括一些有关个人兴趣与态度的问题。每个人都有自己的看法，对问题的回答自然不同。无所谓正确或错误。请来试者尽量表达自己的意见。<br />每道题有三种选择。作答时，请注意下列四点：<br />１．请不要费时斟酌。应当顺其自然地依你个人的反应选答。一般地说来，问题都略嫌简短而不能包含所有有关的因素或条件。通常每分钟可作五六题，全部问题应在半小时内完成。<br />２．除非在万不得已的情形下，尽量避免如“介乎Ａ与Ｃ之间”或“不甚确定”这样的中性答案。<br />３．请不要遗漏，务必对每一个问题作答。 有些问题似乎不符合于你，有些问题又似乎涉及隐私，但本测验的目的，在于研究比较青年或成人的兴趣和态度，希望来试者真实作答。<br />４．作答时，请坦白表达自己的兴趣与态度，不必顾虑到主试者或其他人的意见与立场。",
				'name' =>"16PF"
		);
		$paperData[] = array(
				'description'=>"本测验含有一系列观点的陈述，请仔细阅读每一条，看看自己对它的感觉如何，如果你同意某个观点或该陈述真实地反映了你的情况，就作“是”的回答，否则作“否”的回答。",
				'name' => "CPI"
		);
		$paperData[] = array(
				'description' =>"本测验包括许多成对的语句，任何选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个。如果两句话都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。<br /> 总之，对于每道题的A、B两种选择你必须而且只能选择其一。",
				'name'=>"EPPS"
		);
		$paperData[] = array(
				'description' => "以下列出了有些人可能会有的问题，请仔细地阅读每一条，然后根据最近一星期以内下述情况影响您的实际感觉，在每个问题后标明该题的程度得分。",
				'name'=>"SCL"
		);
		$paperData[] = array(
				'description' =>"下面要做的是一个有趣的测试，完成它时要认真看、认真想， 前面的题认真了，会对做后面的题目有好处；<br />每道测试题都有一张主题图，在主题图中，图案是缺了一部分的，主题图下有6－8张小图片，其中有一张小图片可以使主题图整个图案合理与完整。请确定哪一张小图片补充在主题图缺少的空白处最合适。<br />本测验无时间限制，请认真去做。请记住，每个题目只有一个正确答案。",
				'name' => "SPM"
		);
		$flag = false;
		foreach($paperData as $data){
		/*
		 * 避免重复导入
		 * 
		 * */
			$name = $data['name'];
			$rt = Paper::findfirst("name='$name'");
			if(isset($rt->name)||!empty($rt->name)){
				echo "试卷-".$data['name']."-的指导语已经导入<br />";
				$flag = true;
			}else{
				$paper = new Paper();
				$paper->description = $data['description'];
				$paper->name = $data['name'];
				$paper->save();
			}
		}
		if ($flag){
			echo "查看以上提示";
		}else{
			echo "6张试卷的指导语添加完毕";
		}
	}
	#获取试题的编号，如果试题存在，返回id，否则，返回值为-1;
	public function checkPaperAction(){
		$paper_data = DBScanner::getPaperInfo();
		echo "<pre>";
		print_r($paper_data);
		echo "</pre>";
	}
	public function updatePaperAction(){
		
	}
	
	public function getPaperIdByName($name){
		$name = strtoupper($name);
		$rt = Paper::findfirst("name='$name'");
		if(isset($rt->id)){
			return $rt->id;
		}else{
			return -1;
		}
		
		
	}
	public function testAction(){
		$data = self::getPaperIdByName('SCL3');
		print_r($data);
		exit();
	}
	#上传SCL题库
	public function uploadSCLAction() {
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			#文件读取
			$SCLContent = null;
			$SCLexcelHander = new ExcelUpload($filePath);
			$SCLContent = $SCLexcelHander->handleSCL();
			unlink($filePath);
			if(!empty($SCLContent)){
				#数据入库操作
				$paper_id = null;
				$paper_id = self::getPaperIdByName("SCL");
				if ($paper_id == -1 || empty($paper_id)){
					die("No SCL paper found!");
				}
				$options = "没有|很轻|中等|偏重|严重";
				foreach($SCLContent as $rowContent ){
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "SCL题库导入成功";
			}

		}
	}
	#上传EPPS表
	public function uploadEPPSAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$EPPSContent = null;
			$EPPSexcelHander = new ExcelUpload($filePath);
			#EPPS处理与SCL同
			$EPPSContent = $EPPSexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($EPPSContent)){
				#数据入库操作
				$paper_id = null;
				$paper_id = self::getPaperIdByName("EPPS");
				if ($paper_id == -1 || empty($paper_id)){
					die("No EPPS paper found!");
				}
				$topic = null;
				$options = null;
				foreach($EPPSContent as $rowContent ){
					$options = $rowContent[1].'|'.$rowContent[2];
					$question = new Question();
					$question->topic = $topic;
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "EPPS题库导入成功";
			}
		
		}
	}
	#上传EPQA
	public function uploadEPQAAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$EPQAContent = null;
			$EPQAexcelHander = new ExcelUpload($filePath);
			#EPPS处理与SCL同
			$EPQAContent = $EPQAexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($EPQAContent)){
				#数据入库操作
				$paper_id = null;
				$paper_id = self::getPaperIdByName("EPQA");
				if ($paper_id == -1 || empty($paper_id)){
					die("No EPQA paper found!");
				}
				$topic = null;
				$options = "是|不是";
				foreach($EPQAContent as $rowContent ){
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "EPQA题库导入成功";
			}
		}
	}
	#上传CPI 
	public function uploadCPIAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$CPIContent = null;
			$CPIexcelHander = new ExcelUpload($filePath);
			#CPI处理与SCL同
			$CPIContent = $CPIexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($CPIContent)){
				#数据入库操作
				$paper_id = null;
				$paper_id = self::getPaperIdByName("CPI");
				if ($paper_id == -1 || empty($paper_id)){
					die("No CPI paper found!");
				}
				$topic = null;
				$options = "是|否";
				foreach($CPIContent as $rowContent ){
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "CPI题库导入成功";
			}
		}
	}
	#上传KS(16PF)
	public function uploadKSAction(){
		$fileName = null;
		$filePath = './upload/';
		if ($this->request->hasFiles()) {
			foreach ($this->request->getUploadedFiles() as $file) {
				$fileName = date("YmdHis");
				$fileName .= rand(0,9);
				$fileName .= $file->getName();
				$filePath .=$fileName;
				$file->moveTo($filePath);
			}
			$KSContent = null;
			$KSexcelHander = new ExcelUpload($filePath);
			#CPI处理与SCL同
			$KSContent = $KSexcelHander->handleSCL();
			unlink($filePath);
			if (!empty($KSContent)){
				#数据入库操作
				$paper_id = null;
				$paper_id = self::getPaperIdByName("16PF");
				if ($paper_id == -1 || empty($paper_id)){
					die("No 16PF paper found!");
				}
				$options = null;
				foreach($KSContent as $rowContent ){
					$rowContent[2] = substr($rowContent[2], 5, strlen($rowContent[2])-6);
					$rowContent[3] = substr($rowContent[3], 5, strlen($rowContent[3])-6);
					$rowContent[4] = substr($rowContent[4], 5, strlen($rowContent[4])-6);
					$options = $rowContent[2].'|'.$rowContent[3].'|'.$rowContent[4];
					$question = new Question();
					$question->topic = $rowContent[1];
					$question->number = $rowContent[0];
					$question->options = $options;
					$question->paper_id = $paper_id;
					$question->save();
				}
				echo "16PF题库导入成功";
			}
		}
	}
	
	/**
	 * 上传SPM题库
	 * SPM 60道图片题 图片上传至/public/spmimages/
	 */
	public function uploadSPMAction(){
		$spmarray = self::getSPMListArray();
		$paper_id = self::getPaperIdByName("SPM");
		foreach($spmarray as $value ){
// 			echo "<pre>";
// 			print_r($value);
// 			echo "</pre>";
			for($i = 0; $i<=33; $i+=3){
				$question = new Question();
				$question->topic = $value[$i+1];
				$question->number = $value[$i+2];
				$question->options = $value[$i];
				$question->paper_id = $paper_id;
				$question->save();
			}
		}
		echo "SPM导入成功";
		
	}
	public function getSPMListArray(){
		$rtn_array = array();
		for($xuanhuan1 = 1; $xuanhuan1 <= 5; $xuanhuan1 ++ ){
			//A B C D E
			$tmp = array();
			if ($xuanhuan1 <= 2 ){
				//A B
				
				for($tihao = 1; $tihao<=12; $tihao++){
					//1 ~ 12
					$str = null;
					for( $xuanxiang = 1; $xuanxiang <=6; $xuanxiang++ ){
						//1~6
						if($xuanxiang!=1){
							$str .= '|';
						}
						$str .= chr($xuanhuan1+64).$tihao.'A'.$xuanxiang;
					}
					$tmp[] = $str;
					$tmp[] = chr($xuanhuan1+64).$tihao.'M';
					$tmp[] = ($xuanhuan1-1)*12+$tihao;
		
				}
		
			}else{
				//C D E
				for($tihao =1; $tihao<=12; $tihao++){
					//1 ~ 12
					$str =null;
					for($xuanxiang = 1; $xuanxiang <=8 ; $xuanxiang++ ){
						if($xuanxiang!=1){
							$str.= '|';
						}
						$str .= chr($xuanhuan1+64).$tihao.'A'.$xuanxiang;
					}
					$tmp[] = $str;
					$tmp[] = chr($xuanhuan1+64).$tihao.'M';
					$tmp[] = ($xuanhuan1-1)*12+$tihao;
		
		
				}
			}
			$rtn_array[] = $tmp;
		}
		return $rtn_array;
	}
	
	
	
	
}