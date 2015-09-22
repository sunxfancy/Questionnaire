<?php

class ChartLoader {
	const pchartdir = '../app/classes/pChart2.1.4/';
	public function __construct(){
		require_once(self::pchartdir.'class/pData.class.php');
		require_once(self::pchartdir.'class/pDraw.class.php');
		require_once(self::pchartdir.'class/pImage.class.php');
	}
	public function pie($number, $label, $title,$name){
		require_once(self::pchartdir."class/pPie.class.php");
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
		$PieChart->setSliceColor(0,array("R"=> 69 ,"G"=> 114,"B"=> 167));
		$PieChart->setSliceColor(1,array("R"=>176,"G"=> 70,"B"=>  67));
		$PieChart->setSliceColor(2,array("R"=> 137 ,"G"=>  165,"B"=> 88));
		$PieChart->setSliceColor(3,array("R"=>128 ,"G"=> 105,"B"=> 155));
		$PieChart->setSliceColor(4,array("R"=>61 ,"G"=> 150,"B"=> 174 ));
		$PieChart->setSliceColor(5,array("R"=>146 ,"G"=> 168,"B"=> 192 ));
		$PieChart->setSliceColor(6,array("R"=>219 ,"G"=> 132,"B"=> 61));
		$PieChart->setSliceColor(7,array("R"=>164 ,"G"=> 125,"B"=> 124));
		
		/* Draw a splitted pie chart */
		$myPicture->setFontProperties(array("FontName"=>self::pchartdir."zhfonts/zhongsong.ttf","FontSize"=>10));
		$PieChart->draw2DPie(120,125,array(
				"WriteValues"=>PIE_VALUE_PERCENTAGE,
				"ValuePosition"=>PIE_VALUE_NATURAL,
				"Border"=>FALSE,
				"ValueR"=>0,"ValueG"=>0,"ValueB"=>0
		));
		/*draw a pie legend*/
		$PieChart->drawPieLegend(200,80, array(
				"FontName"=>self::pchartdir.'zhfonts/zhongsong.ttf',
				"FontSize"=>10,
				"Style"=>LEGEND_NOBORDER,
				"Mode"=>LEGEND_VERTICAL,
					
		));
		/* Render the picture to a file */
		$myPicture->render("pcharts/example.draw2DPie_".$name.".png");
	}
	
	public function bar(){
		 /* Create and populate the pData object */
 $MyData = new pData();  
 $MyData->addPoints(array(150,220,300,-250,-420,-200,300,200,100),"Server A");
 $MyData->addPoints(array(140,0,340,-300,-320,-300,200,100,50),"Server B");
 $MyData->setAxisName(0,"Hits");
 $MyData->addPoints(array("January","February","March","April","May","Juin","July","August","September"),"Months");
 $MyData->setSerieDescription("Months","Month");
 $MyData->setAbscissa("Months");

 /* Create the pChart object */
 $myPicture = new pImage(700,230,$MyData);

 /* Turn of Antialiasing */
 $myPicture->Antialias = FALSE;

 /* Add a border to the picture */
 $myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 $myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));

 /* Set the default font */
 $myPicture->setFontProperties(array("FontName"=>self::pchartdir.'zhfonts/zhongsong.ttf',"FontSize"=>12));

 /* Define the chart area */
 $myPicture->setGraphArea(60,40,650,200);

 /* Draw the scale */
 $scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);

 /* Write the chart legend */
 $myPicture->drawLegend(580,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw the chart */
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
 $settings = array("Surrounding"=>-30,"InnerSurrounding"=>30);
 $myPicture->drawBarChart($settings);

 /* Render the picture (choose the best way) */
		$myPicture->render("pcharts/bar.png");
	}
	public function vbar(){
		/* Create and populate the pData object */
		$MyData = new pData();
		$MyData->addPoints(array(13251,4118,3087,1460,1248,156,26,9,8),"Hits");
		$MyData->setAxisName(0,"Hits");
		$MyData->addPoints(array("Firefox","Chrome","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers");
		$MyData->setSerieDescription("Browsers","Browsers");
		$MyData->setAbscissa("Browsers");
		$MyData->setAbscissaName("Browsers");
		$MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
		
		/* Create the pChart object */
		$myPicture = new pImage(500,500,$MyData);
		$myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPicture->drawGradientArea(0,0,500,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
		$myPicture->setFontProperties(array("FontName"=>self::pchartdir.'zhfonts/zhongsong.ttf',"FontSize"=>12));
		
		/* Draw the chart scale */
		$myPicture->setGraphArea(100,30,480,480);
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM)); //
		
		/* Turn on shadow computing */
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Draw the chart */
		 $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30));
		
		 /* Write the legend */
		 $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		
		 /* Render the picture (choose the best way) */
		 $myPicture->render("pcharts/vbar.png");
	}
	
	public function line(){
		/* Create and populate the pData object */
		$MyData = new pData();
		$MyData->addPoints(array(-4,VOID,VOID,12,8,3),"Probe 1");
		$MyData->addPoints(array(3,12,15,8,5,-5),"Probe 2");
		$MyData->addPoints(array(2,7,5,18,19,22),"Probe 3");
		$MyData->setSerieTicks("Probe 2",4);
		$MyData->setSerieWeight("Probe 3",2);
		$MyData->setAxisName(0,"Temperatures");
		$MyData->addPoints(array("Jan","Feb","Mar","Apr","May","Jun"),"Labels");
		$MyData->setSerieDescription("Labels","Months");
		$MyData->setAbscissa("Labels");
		
		
		/* Create the pChart object */
		$myPicture = new pImage(700,230,$MyData);
		
		/* Turn of Antialiasing */
		$myPicture->Antialias = FALSE;
		
		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));
		
		/* Write the chart title */
		$myPicture->setFontProperties(array("FontName"=>self::pchartdir.'zhfonts/zhongsong.ttf',"FontSize"=>12));
		$myPicture->drawText(150,35,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		
		
		/* Define the chart area */
		$myPicture->setGraphArea(60,40,650,200);
		
		/* Draw the scale */
		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
		$myPicture->drawScale($scaleSettings);
		
		/* Turn on Antialiasing */
		$myPicture->Antialias = TRUE;
		
		/* Draw the line chart */
		$myPicture->drawLineChart();
		
		/* Write the chart legend */
		$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		
		/* Render the picture (choose the best way) */
		 $myPicture->render("pcharts/line.png");
	}
	public function radar(){
		require_once(self::pchartdir."class/pRadar.class.php");
		
		/* Create and populate the pData object */
		$MyData = new pData();
		$MyData->addPoints(array(40,20,15,10,8,4),"ScoreA");
		$MyData->addPoints(array(8,10,12,20,30,15),"ScoreB");
		$MyData->addPoints(array(4,8,16,32,16,8),"ScoreC");
		$MyData->setSerieDescription("ScoreA","Application A");
		$MyData->setSerieDescription("ScoreB","Application B");
		$MyData->setSerieDescription("ScoreC","Application C");
		
		/* Define the absissa serie */
		$MyData->addPoints(array("Size","Speed","Reliability","Functionalities","Ease of use","Weight"),"Labels");
		$MyData->setAbscissa("Labels");
		
		/* Create the pChart object */
		$myPicture = new pImage(700,230,$MyData);
		
		/* Draw a solid background */
		$Settings = array("R"=>179, "G"=>217, "B"=>91, "Dash"=>1, "DashR"=>199, "DashG"=>237, "DashB"=>111);
		$myPicture->drawFilledRectangle(0,0,700,230,$Settings);
		
		/* Overlay some gradient areas */
		$Settings = array("StartR"=>194, "StartG"=>231, "StartB"=>44, "EndR"=>43, "EndG"=>107, "EndB"=>58, "Alpha"=>50);
		$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);
		$myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));
		
		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));
		
		/* Write the picture title */
		$myPicture->setFontProperties(array("FontName"=>self::pchartdir.'zhfonts/zhongsong.ttf',"FontSize"=>12));
		$myPicture->drawText(10,13,"pRadar - Draw radar charts",array("R"=>255,"G"=>255,"B"=>255));
		
		
		/* Enable shadow computing */
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Create the pRadar object */
		$SplitChart = new pRadar();
		
		/* Draw a radar chart */
		$myPicture->setGraphArea(10,25,300,225);
		$Options = array("Layout"=>RADAR_LAYOUT_STAR,"BackgroundGradient"=>array("StartR"=>255,"StartG"=>255,"StartB"=>255,"StartAlpha"=>100,"EndR"=>207,"EndG"=>227,"EndB"=>125,"EndAlpha"=>50), "FontName"=>"../fonts/pf_arma_five.ttf","FontSize"=>6);
		$SplitChart->drawRadar($myPicture,$MyData,$Options);
		
		/* Draw a radar chart */
		$myPicture->setGraphArea(390,25,690,225);
		$Options = array("Layout"=>RADAR_LAYOUT_CIRCLE,"LabelPos"=>RADAR_LABELS_HORIZONTAL,"BackgroundGradient"=>array("StartR"=>255,"StartG"=>255,"StartB"=>255,"StartAlpha"=>50,"EndR"=>32,"EndG"=>109,"EndB"=>174,"EndAlpha"=>30), "FontName"=>"../fonts/pf_arma_five.ttf","FontSize"=>6);
		$SplitChart->drawRadar($myPicture,$MyData,$Options);
		
		/* Write the chart legend */
		$myPicture->drawLegend(235,205,array("Style"=>LEGEND_BOX,"Mode"=>LEGEND_HORIZONTAL));
		
		/* Render the picture (choose the best way) */
		 $myPicture->render("pcharts/radar.png");
	}
	

}
