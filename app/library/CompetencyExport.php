<?php
require_once '../app/classes/PhpWord/Autoloader.php';

class CompetencyExport
{	
	public  $wordHandle = null;
	
	/**
	 * @usage 个体胜任力报告生成
	 * @param
	 */
	public function individualCompetencyReport($examinee_id){
		//check examinee_id - - - get basic info 
		$data = new CompetencyData();
		$examinee_data = $data->getExamineeData($examinee_id);
		$examinee = Examinee::findFirst($examinee_id);
		$project_id = $examinee->project_id;
		$project_data  = $data->getProjectAvgIndex($project_id, $examinee_data);
		
		\PhpOffice\PhpWord\Autoloader::register();
		$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
		//set default style
		$this->wordHandle->setDefaultFontName("Microsoft YaHei");
		$titleFontStyle = array('color' => 'blue','size'=>12,'bold' => true);
		$fontStyle2 = array('color' => 'blue');
		//set table style
		$labelFontStyle = array('bold'=>true,'size'=>12) ;
		$labelParagraphStyle = array('alignment'=>'center');
		$valueFontStyle = array('size'=>12) ;
		$valuePragraphStyle = array('alignment'=>'center');
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$section = $this->wordHandle->createSection();
		$table = $section->addTable($styleTable);
		$table->addRow();
		$cell1_19 = $table->addCell(1000);
		$cell1_19->getStyle()->setGridSpan(9);
		$cell1_19->addText("胜任力模型+述职、民主生活会、民主集中制、四个全面",array('color' => 'red','bold' => true,'size' => 16),array('alignment'=>'center'));
		$table->addRow();
		$table->addCell(1000)->addText("姓名",$labelFontStyle,$labelParagraphStyle);
		$table->addCell(1000)->addText($examinee->name,$valueFontStyle,$valuePragraphStyle);
		$table->addCell(1000)->addText("性别",$labelFontStyle,$labelParagraphStyle);
		$table->addCell(1000)->addText(($examinee->sex == 1) ? '男' : '女',$valueFontStyle,$valuePragraphStyle);
		$table->addCell(1000)->addText("年龄",$labelFontStyle,$labelParagraphStyle);
		//个体年龄取整
		$age = floor(FactorScore::calAge($examinee->birthday,$examinee->last_login));
		$table->addCell(1000)->addText($age,$valueFontStyle,$valuePragraphStyle);
		$table->addCell(1000)->addText("职位",$labelFontStyle,$labelParagraphStyle);
		$cell2_89 = $table->addCell(1000);
		$cell2_89->getStyle()->setGridSpan(2);
		$cell2_89->addText($examinee->duty,$valueFontStyle,$valuePragraphStyle);
		$table->addRow();
		$cell3_19 = $table->addCell(1000);
		$cell3_19->getStyle()->setGridSpan(9);
		$cell3_19->addText('胜任素质评分',$titleFontStyle,$labelParagraphStyle);
		$table->addRow();
		foreach ($examinee_data['advantage']['value'] as $key => $value) {
			$table->addCell(1000)->addText($value['chs_name'],$labelFontStyle,$labelParagraphStyle);
		}
		foreach ($examinee_data['disadvantage']['value'] as $key => $value) {
			$table->addCell(1000)->addText($value['chs_name'],$labelFontStyle,$labelParagraphStyle);
		}
		$table->addCell(1000)->addText('总分',$labelFontStyle,$labelParagraphStyle);
		
		$table->addRow();
		foreach ($examinee_data['advantage']['value'] as $key => $value) {
			$table->addCell(1000)->addText($value['score'],$valueFontStyle,$valuePragraphStyle);
		}
		foreach ($examinee_data['disadvantage']['value'] as $key => $value) {
			$table->addCell(1000)->addText($value['score'],$valueFontStyle,$valuePragraphStyle);
		}
		$table->addCell(1000)->addText($examinee_data['value'],$valueFontStyle,$valuePragraphStyle);
		$table->addRow();
		$cell6_19 = $table->addCell(1000);
		$cell6_19->getStyle()->setGridSpan(9);
		$cell6_19->addText("胜任力模型+述职",$titleFontStyle,$labelParagraphStyle);
		$table->addRow();
		$cell7_19 = $table->addCell(1000);
		$cell7_19->getStyle()->setGridSpan(9);
		//add chart

		$chart = new WordChart();
		$fileName = $chart->radarGraph_3($examinee_data,$project_data, $project_id);
		if (file_exists($fileName)){
			$cell7_19->addImage($fileName,
					array(
							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(9.31),
							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(6.46),
							'wrappingStyle'=>'square',
					 ));
		}


		$cell7_19->addText("主要优势有五点：",$titleFontStyle);
		$array1 = array('一','二','三','四','五');
		$i = 0;
		foreach ($examinee_data['advantage']['value'] as $key => $value) {
			$cell7_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell7_19->addText("有待改进有三点：",$titleFontStyle);
		$array2 = array('一','二','三');
		$i = 0;
		foreach ($examinee_data['disadvantage']['value'] as $key => $value) {
			$cell7_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell7_19->addText("述职报告结果：",$titleFontStyle);
		$cell7_19->addTextBreak();
		$table->addRow();
		$cell8_19 = $table->addCell(1000);
		$cell8_19->getStyle()->setGridSpan(9);
		$cell8_19->addText("胜任力模型+民主生活会",$titleFontStyle,$labelParagraphStyle);
		$table->addRow();
		$cell9_19 = $table->addCell(1000);
		$cell9_19->getStyle()->setGridSpan(9);
		if (file_exists($fileName)){
			$cell9_19->addImage($fileName,
					array(
							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(9.31),
							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(6.46),
							'wrappingStyle'=>'square',
					 ));
		}
		$cell9_19->addText("主要优势有五点：",$titleFontStyle);
		$array1 = array('一','二','三','四','五');
		$i = 0;
		foreach ($examinee_data['advantage']['value'] as $key => $value) {
			$cell9_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell9_19->addText("有待改进有三点：",$titleFontStyle);
		$array2 = array('一','二','三');
		$i = 0;
		foreach ($examinee_data['disadvantage']['value'] as $key => $value) {
			$cell9_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell9_19->addText("民主生活会指标描述：",$titleFontStyle);
		$cell9_19->addTextBreak();
		$table->addRow();
		$cell10_19 = $table->addCell(1000);
		$cell10_19->getStyle()->setGridSpan(9);
		$cell10_19->addText("胜任力模型+民主集中制",$titleFontStyle,$labelParagraphStyle);
		$table->addRow();
		$cell11_19 = $table->addCell(1000);
		$cell11_19->getStyle()->setGridSpan(9);
		if (file_exists($fileName)){
			$cell11_19->addImage($fileName,
					array(
							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(9.31),
							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(6.46),
							'wrappingStyle'=>'square',
					 ));
		}
		$cell11_19->addText("主要优势有五点：",$titleFontStyle);
		$array1 = array('一','二','三','四','五');
		$i = 0;
		foreach ($examinee_data['advantage']['value'] as $key => $value) {
			$cell11_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell11_19->addText("有待改进有三点：",$titleFontStyle);
		$array2 = array('一','二','三');
		$i = 0;
		foreach ($examinee_data['disadvantage']['value'] as $key => $value) {
			$cell11_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell11_19->addText("民主集中制指标描述：",$titleFontStyle);
		$cell11_19->addTextBreak();
		
		$table->addRow();
		$cell12_19 = $table->addCell(1000);
		$cell12_19->getStyle()->setGridSpan(9);
		$cell12_19->addText("胜任力模型+四个全面",$titleFontStyle,$labelParagraphStyle);
		$table->addRow();
		$cell13_19 = $table->addCell(1000);
		$cell13_19->getStyle()->setGridSpan(9);
		if (file_exists($fileName)){
			$cell13_19->addImage($fileName,
					array(
							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(9.31),
							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(6.46),
							'wrappingStyle'=>'square',
					));
		}
		$cell13_19->addText("主要优势有五点：",$titleFontStyle);
		$array1 = array('一','二','三','四','五');
		$i = 0;
		foreach ($examinee_data['advantage']['value'] as $key => $value) {
			$cell13_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell13_19->addText("有待改进有三点：",$titleFontStyle);
		$array2 = array('一','二','三');
		$i = 0;
		foreach ($examinee_data['disadvantage']['value'] as $key => $value) {
			$cell13_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$cell13_19->addText("四个全面指标描述：",$titleFontStyle);
		$cell13_19->addTextBreak();

		//命名
		//临时文件命名规范    $project_id_$date_rand(100,900)
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
	 	$date = date('H_i_s');
	 	$stamp = rand(100,900);
		$fileName = './tmp/'.$examinee_id.'_'.$date.'_'.$stamp.'.docx';
		$objWriter->save($fileName);
		return $fileName;
	}

	/**
	 * @usage 班子胜任力报告生成
	 * @param
	 */
	public function teamReport($project_id){
		//get basic info
		$teamCompetency = new CompetencyData();
		$data = $teamCompetency->getTeamData($project_id);
		\PhpOffice\PhpWord\Autoloader::register();
		$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
		//cell style
		$CellNum =3;
		$CellLength = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(23)/ $CellNum;
		//set section style
		$sectionStyle = array(
			  'orientation'=>'portrait',
			  'marginLeft'   => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.17),
			  'marginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.17),
			  'marginTop'    => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.54),
			  'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.54),
			  'pageSizeW'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
			  'pageSizeH'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
			  'headerHeight'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
			  'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.75),	  
		);
		$section = $this->wordHandle->addSection($sectionStyle);
		//set default style
		$this->wordHandle->setDefaultFontName("Microsoft YaHei");
		$captionFontStyle = array('color' => 'red','size' => 18,'bold' => true);
		$titleFontStyle = array('color' => 'blue','size' => 14,'bold' => true);
		$fontStyle1 = array('bold' => true,'size' => 14);
		$fontStyle2 = array('color' => 'blue','size'=>14,'bold' => true);
		$paragraphStyle1 = array('lineHeight'=>1.5);
		$paragraphStyle2 = array('alignment'=>'center','lineHeight'=>1.5);
		$paragraphStyle3 = array('alignment'=>'center');
 		//set table style
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80 );
 		//report part
		$table = $section->addTable($styleTable);
		$table->addRow();
		$cell1_19 = $table->addCell($CellLength);
		$cell1_19->getStyle()->setGridSpan($CellNum);
		$cell1_19->addText("XX个人与班子对比",$captionFontStyle,$paragraphStyle3);
		$table->addRow();
		$cell2_13 = $table->addCell($CellLength);
		$cell2_13->addText("班子名称",$fontStyle1,$paragraphStyle3);
		$cell2_49 = $table->addCell($CellLength);
		$cell2_49->getStyle()->setGridSpan($CellNum-1);
		$cell2_49->addText("XX班子",$fontStyle1, $paragraphStyle3);
		$table->addRow();
		$cell3_19 = $table->addCell($CellLength);
		$cell3_19->getStyle()->setGridSpan($CellNum);
		$cell3_19->addText("胜任素质评分",$titleFontStyle,$paragraphStyle2);
		$table->addRow();
		$cell6_19 = $table->addCell($CellLength);
		$cell6_19->getStyle()->setGridSpan($CellNum);
		//add chart
		// $chart = new WordChart();
		// $fileName = $chart->radarGraph_2($data,$data_pro, $project_id);
		// if (file_exists($fileName)){
		// 	$cell6_19->addImage($fileName,
		// 			array(
		// 					'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(13.76),
		// 					'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(7.09),
		// 					'wrappingStyle'=>'square',
		// 			 ));
		// }
		$table->addRow();
		$cell7_19 = $table->addCell($CellLength);
		$cell7_19->getStyle()->setGridSpan($CellNum);
		$cell7_19->addText("胜任力评价 ",$titleFontStyle,$paragraphStyle3);
		$table->addRow();
		$cell8_19 = $table->addCell($CellLength);
		$cell8_19->getStyle()->setGridSpan($CellNum);
		$cell8_19->addText("主要优势有：",array('color' => 'blue','size'=>12,'bold' => true),$paragraphStyle1);
		$array1 = array('一','二','三','四','五');
		$i = 0;
		foreach ($data['advantage']['value'] as $key => $value) {
			$cell8_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$table->addRow();
		$cell9_19 = $table->addCell($CellLength);
		$cell9_19->getStyle()->setGridSpan($CellNum);
		$cell9_19->addText("有待改进有：",array('color' => 'blue','size'=>12,'bold' => true),$paragraphStyle1);
		$array2 = array('一','二','三');
		$i = 0;
		foreach ($data['disadvantage']['value'] as $key => $value) {
			$cell9_19->addText($array2[$i++]."是".$value['comment'], array('size'=>12));
		}
		//add table to save some data 
		$position_names =  $teamCompetency->getTeamPositions($project_id);
		$position_data  =  $teamCompetency->getPositionIndexs($project_id, $data);
		$biaozhunzhi    =  $teamCompetency->getProjectIndexsByData($project_id, $data);
		$index_names = array();
		$banzi = array();
		foreach ($data['advantage']['value'] as $key => $value) {
			$index_names[] = $value['chs_name'];
			$banzi[] = $value['score'];
		}
		foreach ($data['disadvantage']['value'] as $key => $value) {
			$index_names[] = $value['chs_name'];
			$banzi[] = $value['score'];
		}
		$table = $section->addTable($styleTable );
		$table->addRow();
		$table->addCell();
		foreach ($index_names as $key=>$value){
			$table->addCell()->addText($value);
		}
		$table->addRow();
		$table->addCell()->addText("班子");
		foreach ($banzi as $key=>$value){
			$table->addCell()->addText($value);
		}
		$table->addRow();
		$xitong = $teamCompetency->getProjectIndexsByData($project_id,$data);
		$table->addCell()->addText("系统");
		foreach ($xitong as $key=>$value){
			$table->addCell()->addText($value);
		}
		$i = 0; 
		foreach ($position_names as $key=>$value){
			$table->addRow();
			$table->addCell()->addText($value);
			foreach ($position_data[$value] as $skey=>$svalue){
				$table->addCell()->addText($svalue);
			}
		}
		//临时文件命名规范    $project_id_$date_rand(100,900)
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->wordHandle, 'Word2007');
	 	$date = date('H_i_s');
	 	$stamp = rand(100,900);
		$fileName = './tmp/'.$project_id.'_'.$date.'_'.$stamp.'.docx';
		$objWriter->save($fileName);
		return $fileName;
	}

	/**
	 * @usage 系统胜任力报告生成
	 * @param
	 */
	public function systemReport($project_id){
		//get basic info
		$systemCompetency = new CompetencyData();
		$data = $systemCompetency->getSystemData($project_id);
		$data_pro = $systemCompetency->getProjectAvgIndex($project_id);
		\PhpOffice\PhpWord\Autoloader::register();
		$this->wordHandle =  new \PhpOffice\PhpWord\PhpWord();
		//cell style
		$CellNum =$data['count']+1;
		$CellLength = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(18.76)/ $CellNum;
		//set section style
		$sectionStyle = array(
			  'orientation'=>'portrait',
			  'marginLeft'   => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.17),
			  'marginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.17),
			  'marginTop'    => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.54),
			  'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.54),
			  'pageSizeW'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
			  'pageSizeH'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
			  'headerHeight'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
			  'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.75),	  
		);
		$section = $this->wordHandle->addSection($sectionStyle);
		//set default style
		$this->wordHandle->setDefaultFontName("Microsoft YaHei");
		$captionFontStyle = array('color' => 'red','size' => 18,'bold' => true);
		$titleFontStyle = array('color' => 'blue','size' => 14,'bold' => true);
		$fontStyle1 = array('bold' => true,'size' => 14);
		$fontStyle2 = array('color' => 'blue','size'=>14,'bold' => true);
		$paragraphStyle1 = array('lineHeight'=>1.5);
		$paragraphStyle2 = array('alignment'=>'center','lineHeight'=>1.5);
		$paragraphStyle3 = array('alignment'=>'center');
		//set table style
		$styleTable = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80 );
		//report part
		$table = $section->addTable($styleTable);
		$table->addRow();
		$cell1_19 = $table->addCell($CellLength);
		$cell1_19->getStyle()->setGridSpan($CellNum);
		$cell1_19->addText("系统胜任力测评结果",$captionFontStyle,$paragraphStyle3);
		$table->addRow();
		$cell2_13 = $table->addCell($CellLength);
		$hebing = floor($CellNum/3);
		$cell2_13->getStyle()->setGridSpan($hebing);
		$cell2_13->addText("系统名称",$fontStyle1,$paragraphStyle3);
		$cell2_49 = $table->addCell($CellLength);
		$cell2_49->getStyle()->setGridSpan($CellNum-$hebing);
		$cell2_49->addText("XX系统",$fontStyle1, $paragraphStyle3);
		$table->addRow();
		$cell3_19 = $table->addCell($CellLength);
		$cell3_19->getStyle()->setGridSpan($CellNum);
		$cell3_19->addText("胜任素质评分",$titleFontStyle,$paragraphStyle2);
		$table->addRow();
		foreach ($data['advantage']['value'] as $key => $value) {
			$table->addCell($CellLength)->addText($value['chs_name'],$fontStyle1,$paragraphStyle3);
		}
		foreach ($data['disadvantage']['value'] as $key => $value) {
			$table->addCell($CellLength)->addText($value['chs_name'],$fontStyle1,$paragraphStyle3);
		}
		$table->addCell($CellLength)->addText('总分',$fontStyle1,$paragraphStyle3);
		
		$table->addRow();
		foreach ($data['advantage']['value'] as $key => $value) {
			$table->addCell($CellLength)->addText($value['score'],$fontStyle1,$paragraphStyle3);
		}
		foreach ($data['disadvantage']['value'] as $key => $value) {
			$table->addCell($CellLength)->addText($value['score'],$fontStyle1,$paragraphStyle3);
		}
		$table->addCell($CellLength)->addText($data['value'],$fontStyle1,$paragraphStyle3);
		$table->addRow();
		$cell6_19 = $table->addCell($CellLength);
		$cell6_19->getStyle()->setGridSpan($CellNum);
		//add chart
		$chart = new WordChart();
		$fileName = $chart->radarGraph_2($data,$data_pro, $project_id);
		if (file_exists($fileName)){
			$cell6_19->addImage($fileName,
					array(
							'width'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(13.76),
							'height'=>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(7.09),
							'wrappingStyle'=>'square',
					 ));
		}
		
		$table->addRow();
		$cell7_19 = $table->addCell($CellLength);
		$cell7_19->getStyle()->setGridSpan($CellNum);
		$cell7_19->addText("胜任力评价 ",$titleFontStyle,$paragraphStyle3);
		
		$table->addRow();
		$cell8_19 = $table->addCell($CellLength);
		$cell8_19->getStyle()->setGridSpan($CellNum);
		$cell8_19->addText("主要优势有：",array('color' => 'blue','size'=>12,'bold' => true),$paragraphStyle1);
		$array1 = array('一','二','三','四','五');
		$i = 0;
		foreach ($data['advantage']['value'] as $key => $value) {
			$cell8_19->addText($array1[$i++]."是".$value['comment'], array('size'=>12));
		}
		$table->addRow();
		$cell9_19 = $table->addCell($CellLength);
		$cell9_19->getStyle()->setGridSpan($CellNum);
		$cell9_19->addText("有待改进有：",array('color' => 'blue','size'=>12,'bold' => true),$paragraphStyle1);
		$array2 = array('一','二','三');
		$i = 0;
		foreach ($data['disadvantage']['value'] as $key => $value) {
			$cell9_19->addText($array2[$i++]."是".$value['comment'], array('size'=>12));
		}
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


