<?php

class ChartLoader {
	const pchartdir = '../app/classes/pChart2.1.4/';
	public function __construct(){
		include(self::pchartdir.'class/pData.class.php');
		include(self::pchartdir.'class/pDraw.class.php');
		include(self::pchartdir.'class/pImage.class.php');
	}
	public function pie($number, $label, $title,$name){
		include(self::pchartdir."class/pPie.class.php");
		$data_number = $number;
		$data_label = $label;
		$data_title =$title;
		/* Create and populate the pData object */
		$MyData = new pData();
		$MyData->addPoints($data_number,"ScoreA");
		$MyData->setSerieDescription("ScoreA","Application A");
		/* Define the absissa serie */
		$MyData->addPoints($data_label,"Labels");
		$MyData->setAbscissa("Labels");
		/* Create the pChart object */
		$myPicture = new pImage(300,200,$MyData);
		/* Add a border to the picture */
		$myPicture->drawFilledRectangle(0,0,299,199,array("R"=>255,"G"=>255,"B"=>255));
		/* Write the picture title */
		$myPicture->setFontProperties(array("FontName"=>self::pchartdir."zhfonts/zhongsong.ttf","FontSize"=>16));
		$myPicture->drawText(70,40,$data_title,array("R"=>0,"G"=>0,"B"=>0));
		/* Create the pPie object */
		$PieChart = new pPie($myPicture,$MyData);
		/* Define the slice color */
		$count = count($label);
		for($i = 0; $i<$count; $i++){
			switch($i){
				case 0:$PieChart->setSliceColor(0,array("R"=> 69 ,"G"=> 114,"B"=> 167));break;
				case 1:$PieChart->setSliceColor(1,array("R"=>176,"G"=> 70,"B"=>  67));break;
				case 2:$PieChart->setSliceColor(2,array("R"=> 137 ,"G"=>  165,"B"=> 88));break;
				case 3:$PieChart->setSliceColor(3,array("R"=>128 ,"G"=> 105,"B"=> 155));break;
			}
		}
		
		
		/* Draw a splitted pie chart */
		$myPicture->setFontProperties(array("FontName"=>self::pchartdir."zhfonts/zhongsong.ttf","FontSize"=>10));
		$PieChart->draw2DPie(120,125,array(
				"WriteValues"=>PIE_VALUE_PERCENTAGE,
				"ValuePosition"=>PIE_VALUE_NATURAL,
				"Border"=>FALSE,
				"ValueR"=>0,"ValueG"=>0,"ValueB"=>0
		));
		/*draw a pie legend*/
		$PieChart->drawPieLegend(240,100, array(
				"FontName"=>self::pchartdir.'zhfonts/zhongsong.ttf',
				"FontSize"=>10,
				"Style"=>LEGEND_NOBORDER,
				"Mode"=>LEGEND_VERTICAL,
					
		));
		/* Render the picture to a file */
		$myPicture->render("pcharts/example.draw2DPie_".$name.".png");
	}
	

}
