<?php
	/**
 	  * @usage 报告的数据图表生成
 	  * @名称 	//临时文件命名规范    $id_$date_rand(100,900)
	  */
require_once ('../app/classes/jpgraph/jpgraph.php');
class WordChart {
	#个体综合图表1
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
	#个体五优三劣图表
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
	#个体综合素质图表
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
	public function radarGraph_2(&$data, &$data_pro, $project_id){
		require_once ('../app/classes/jpgraph/jpgraph_radar.php');
		require_once ('../app/classes/jpgraph/jpgraph_iconplot.php');
		//数组处理
		$title_array = array();
		$sys_array = array();
		$pro_array = array();
		
		foreach($data['advantage']['value'] as $value){
			$data_pro_tmp = $data_pro;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = $data_pro[$key+1];
		}
		
		foreach($data['disadvantage']['value'] as $value){
			$data_pro_tmp = $data_pro;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = $data_pro[$key+1];
		}

		// Create the basic rtadar graph
		$graph = new RadarGraph(600,312);
		
		// Set background color and shadow
		$graph->SetColor("white");
// 		$graph->SetShadow();
		
		// Position the graph
		$graph->SetCenter(0.35,0.5);
		$graph->SetTitles($title_array);
		// Setup the axis formatting
		$graph->axis->title->SetFont(FF_CHINESE,FS_NORMAL,10);
		$graph->axis->SetFont(FF_FONT1,FS_BOLD,10);
		$graph->axis->SetWeight(1);
		
		// Setup the grid lines
		$graph->grid->SetLineStyle("solid");
		$graph->grid->SetColor("gray");
		$graph->grid->Show();
		$graph->SetGridDepth(DEPTH_BACK);
		$graph->SetSize(0.6);
		$graph->HideTickMarks();
		
		// Setup graph titles
		
		// Create the first radar plot
		$plot = new RadarPlot($pro_array);
		$plot->SetLegend("胜任标准");
		$plot->SetColor("blue","lightblue");
		$plot->SetFill(false);
		$plot->SetLineWeight(3);
		
		// Create the second radar plot
		$plot2 = new RadarPlot($sys_array);
		$plot2->SetLegend("系统测评值");
		$plot2->SetColor("red","lightred");
		$plot2->mark->SetType(MARK_IMG_SBALL,'red');
		$plot2->SetFill(false);
		$plot2->SetLineWeight(3);
		
		// Add the plots to the graph
		$graph->Add($plot);
		$graph->Add($plot2);
		
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/_'.$project_id.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
		
	}
	
	#个人胜任力报告
	public function radarGraph_3(&$data, &$data_pro, $project_id){
		require_once ('../app/classes/jpgraph/jpgraph_radar.php');
		require_once ('../app/classes/jpgraph/jpgraph_iconplot.php');
		//数组处理
		$title_array = array();
		$sys_array = array();
		$pro_array = array();
	
		foreach($data['advantage']['value'] as $value){
			$data_pro_tmp = $data_pro;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = $data_pro[$key+1];
		}
	
		foreach($data['disadvantage']['value'] as $value){
			$data_pro_tmp = $data_pro;
			$title_array[] = $value['chs_name'];
			$sys_array[] = $value['score'];
			$data_pro_tmp = array_flip($data_pro_tmp);
			$key = $data_pro_tmp[trim($value['chs_name'])];
			$pro_array[] = $data_pro[$key+1];
		}
	
		// Create the basic rtadar graph
		$graph = new RadarGraph(600,450);
	
		// Set background color and shadow
		$graph->SetColor("white");
		// 		$graph->SetShadow();
	
		// Position the graph
		$graph->SetCenter(0.45,0.5);
		$graph->SetTitles($title_array);
		// Setup the axis formatting
		$graph->axis->title->SetFont(FF_CHINESE,FS_NORMAL,11);
		$graph->axis->SetFont(FF_FONT1,FS_BOLD,11);
		$graph->axis->SetWeight(1);
	
		// Setup the grid lines
		$graph->grid->SetLineStyle("solid");
		$graph->grid->SetColor("gray");
		$graph->grid->Show();
		$graph->SetGridDepth(DEPTH_BACK);
		$graph->SetSize(0.6);
		$graph->HideTickMarks();
	
		// Setup graph titles
	
		// Create the first radar plot
		$plot = new RadarPlot($pro_array);
		$plot->SetLegend("胜任标准");
		$plot->SetColor("blue","lightblue");
		$plot->SetFill(false);
		$plot->SetLineWeight(3);
	
		// Create the second radar plot
		$plot2 = new RadarPlot($sys_array);
		$plot2->SetLegend("个人测评值");
		$plot2->SetColor("red","lightred");
		$plot2->mark->SetType(MARK_IMG_SBALL,'red');
		$plot2->SetFill(false);
		$plot2->SetLineWeight(3);
	
		// Add the plots to the graph
		$graph->Add($plot);
		$graph->Add($plot2);
	
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/_'.$project_id.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
	
	}
	//综合报告 -- 饼状图 --- n项
	
	//综合报告 五优三劣
	public static function lineGraph_1($level_data,  $level_name, $title, $project_id){
		require_once ('../app/classes/jpgraph/jpgraph.php');
		require_once ('../app/classes/jpgraph/jpgraph_line.php');
		
		// Setup the graph
		$graph = new Graph(1500, 500);
		$graph->SetMarginColor('white');
		$graph->SetScale("textlin");
		$graph->SetFrame(false);
		$graph->SetMargin(30,50,30,30);
		
		$graph->title->Set($title);
		$graph->title->SetFont(FF_CHINESE,FS_NORMAL,11);

		$graph->yaxis->HideZeroLabel();
		$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
		$graph->xgrid->Show();
		
		$graph->xaxis->SetTickLabels(array_keys($level_data[0]));
		
		$i = 0; 
		foreach($level_data as $data ){
			$p1 = new LinePlot(array_values($data));
			$p1->SetLegend($level_name[$i++]);
			$graph->Add($p1);
		}
		
		$graph->legend->SetShadow('gray@0.4',5);
		$graph->legend->SetPos(0.1,0.1,'right','top');
		// Output line
		
		$date = date('H_i_s');
		$stamp = rand(100,900);
		$fileName = './tmp/_'.$project_id.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
	}
	
	
	
	
}