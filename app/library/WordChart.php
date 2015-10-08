<?php
	/**
 	  * @usage 个体报告的数据图表生成
 	  * @名称 	//临时文件命名规范    $examinee_id_$date_rand(100,900)
	  */
require_once ('../app/classes/jpgraph/jpgraph.php');
class WordChart {
	public function barGraph_1($data, $examinee_id, $color='steelblue'){
		require_once ('../app/classes/jpgraph/jpgraph_bar.php');
		$datay=$data;
	    // Create the graph. These two calls are always required
		$graph = new Graph(300,315);
		$graph->SetScale('textlin');
		// Adjust the margin a bit to make more room for titles
		$graph->SetMargin(40,30,20,40);
		$graph->SetFrame(true,'black',1);
		 
		// Create a bar pot
		$bplot = new BarPlot($datay);
		// Adjust fill color
		$bplot->SetFillColor($color);
		$bplot->SetShadow("white");
		$graph->Add($bplot);
		// Setup labels
		$lbl = array("优秀","良好","一般","较差");
		$graph->xaxis->SetTickLabels($lbl);
		$graph->xaxis->SetFont(FF_CHINESE,FS_BOLD,12);
		$graph->yaxis->SetLabelFormat('%d%%');
;
		// Send back the HTML page which will call this script again
		// to retrieve the image.
		//临时文件命名规范    $examinee_id_$date_rand(100,900)
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/'.$examinee_id.'_'.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
	}
	public function barGraph_2($data, $examinee_id, $color = 'green'){
		require_once ('../app/classes/jpgraph/jpgraph_bar.php');
		// Create the graph. These two calls are always required
		$graph = new Graph(400,334);
		$graph->SetScale('textlin');
		$graph->SetShadow(true,5,'white');
		// Adjust the margin a bit to make more room for titles
		$graph->SetMargin(40,30,20,40);
		$graph->SetFrame(true,'black',1);
			
		// Create a bar pot
		$datay = array();
		$datalabel = array();
		foreach($data as $value){
			$datay[] = $value['score'];
			$datalabel[] = $value['chs_name'];
		}
		$bplot = new BarPlot($datay);
		// Adjust fill color
		$bplot->SetFillColor($color);
		$bplot->SetShadow("white");
		$graph->Add($bplot);
		// Setup labels
		$lbl = $datalabel;
		$graph->xaxis->SetTickLabels($lbl);
		$graph->xaxis->SetFont(FF_CHINESE,FS_BOLD,12);
			
		// Send back the HTML page which will call this script again
		// to retrieve the image.
		//临时文件命名规范    $examinee_id_$date_rand(100,900)
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/'.$examinee_id.'_'.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
	
	}
	
	public function radarGraph_1($data, $titles, $examinee_id){
		require_once ('../app/classes/jpgraph/jpgraph_radar.php');		
		require_once ('../app/classes/jpgraph/jpgraph_iconplot.php');
		 
		$graph = new RadarGraph (300,255);
		 
		$graph->SetTitles($titles);
		$graph->SetCenter(0.5,0.55);
		$graph->HideTickMarks();
		$graph->SetColor('white@0.7');
		$graph->axis->SetColor('darkgray');
		$graph->grid->SetColor('darkgray');
		$graph->grid->Show();
		 
		$graph->axis->title->SetFont(FF_CHINESE,FS_NORMAL,10);
		$graph->axis->title->SetMargin(5);
		$graph->SetGridDepth(DEPTH_BACK);
		$graph->SetSize(0.6);
		 
		$plot = new RadarPlot($data);
		$plot->SetColor('deepskyblue');
		$plot->SetLineWeight(1);
		$plot->SetFillColor('deepskyblue@0.5');
		 
		//$plot->mark->SetType(MARK_IMG_SBALL,'red');
		 
		$graph->Add($plot);
		//临时文件命名规范    $examinee_id_$date_rand(100,900)
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/'.$examinee_id.'_'.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
	}
	#系统胜任力报告
	public function radarGraph_2(&$data, $project_id){
		require_once ('../app/classes/jpgraph/jpgraph_radar.php');
		require_once ('../app/classes/jpgraph/jpgraph_iconplot.php');
		//数组处理
		$title_array = array();
		foreach($data['advantage'] as $value){
			$title_array = 
		}
		
		// Create the basic rtadar graph
		$graph = new RadarGraph(600,312);
		
		// Set background color and shadow
		$graph->SetColor("white");
// 		$graph->SetShadow();
		
		// Position the graph
		$graph->SetCenter(0.35,0.5);
		$graph->SetTitles(array('以','而','出发吧','苏俄和','德隆街','试试','带哦街'));
		// Setup the axis formatting
		$graph->axis->title->SetFont(FF_CHINESE,FS_NORMAL,10);
		$graph->axis->SetFont(FF_FONT1,FS_BOLD,10);
		$graph->axis->SetWeight(1);
		
		// Setup the grid lines
		$graph->grid->SetLineStyle("solid");
		$graph->grid->SetColor("gray");
		$graph->grid->Show();
		$graph->HideTickMarks();
		
		// Setup graph titles
		
		// Create the first radar plot
		$plot = new RadarPlot(array(30,80,60,40,71,81,47));
		$plot->SetLegend("Goal");
		$plot->SetColor("red","lightred");
		$plot->SetFill(false);
		$plot->SetLineWeight(1);
		
		// Create the second radar plot
		$plot2 = new RadarPlot(array(70,40,30,80,31,51,14));
		$plot2->SetLegend("Actual");
		$plot2->SetColor("blue","lightred");
		
		// Add the plots to the graph
		$graph->Add($plot2);
		$graph->Add($plot);
		
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/_'.$project_id.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
		
	}
}