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
		$fileName = './tmp/'.$project_id.$date.'_'.$stamp.'.jpeg';
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
		$fileName = './tmp/'.$project_id.$date.'_'.$stamp.'.jpeg';
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
		$fileName = './tmp/'.$project_id.$date.'_'.$stamp.'.jpeg';
		$graph->Stroke($fileName);
		return $fileName;
	}
	
	#生成十项报表中EPQA 第一个图表
	public static function scatter_horiz_Graph_epqa_1($data,$examinee) {		
		// Create the image
		$image = imagecreatefrompng('./images/EPQA_1.png');
		// Create some colors
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);
		// Replace path by your own font path
		$font = './fonts/simsun.ttf';
		// Add some shadow to the text
		$labels_array = array(
			"内外向"=>1,"神经质"=>2,"精神质"=>3,"掩饰性"=>4	
		);
		foreach ($data as $value) {
			if(isset($labels_array[$value['chs_name']])){
				$row = $labels_array[$value['chs_name']];
				$y = 60 + ($row-1)*36;
				$x = 87+(466*$value['std_score']/100);
				imagettftext($image, 7, 0, $x, $y, $black, $font, '●');
			}
		}
// 		$red = imagecolorallocate($image,255,0,0);//创建一个颜色，以供使用
// 		imageline($image,30,30,240,140,$red);
		
// 		//$red = imagecolorallocate($image,255,0,0);//创建一个颜色，以供使用
// 		self::MDashedLine($image,60,60,240,140,$white);
		
		$fileName = './tmp/'.$examinee->id.'_epqa_1.png';
		if(file_exists($fileName)){
			unlink($fileName);
		}
		imagepng ( $image , $fileName);
		//imagedestroy ( $image );
		return $fileName;
	}
	private static function MDashedLine($image, $x0, $y0, $x1, $y1, $fg, $bg)
	{
		$st = array($fg, $fg, $fg, $fg, $bg, $bg, $bg, $bg);
		ImageSetStyle($image, $st);
		ImageLine($image, $x0, $y0, $x1, $y1, IMG_COLOR_STYLED);
	}
	
	#生成十项报表中EPQA 第二个图表
	public static function scatter_horiz_Graph_epqa_2($data,$examinee) {		
		// Create the image
		$image = imagecreatefrompng('./images/EPQA_2.png');
		// Create some colors
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);
		// Replace path by your own font path
		$font = './fonts/simsun.ttf';
		// Add some shadow to the text
		$labels_array = array(
			"内外向","神经质",
		);
		if($data[0]['chs_name'] == $labels_array[0] && $data[1]['chs_name'] == $labels_array[1] ){
			$x = 66 + ($data[0]['std_score']/100)*472;
			if( $data[1]['std_score'] >= 25 ){
				$y = 494 - 469*(($data[1]['std_score']-25)/75);
				imagettftext($image, 7, 0, $x, $y, $black, $font, '●');
			}
		}
// 		$red = imagecolorallocate($image,255,0,0);//创建一个颜色，以供使用
// 		imageline($image,30,30,240,140,$red);
		
// 		//$red = imagecolorallocate($image,255,0,0);//创建一个颜色，以供使用
// 		self::MDashedLine($image,60,60,240,140,$white);
		
		$fileName = './tmp/'.$examinee->id.'_epqa_2.png';
		if(file_exists($fileName)){
			unlink($fileName);
		}
		imagepng ( $image , $fileName);
		//imagedestroy ( $image );
		return $fileName;
	}
	#十项报表CPI中图表
	public static function scatter_horiz_Graph_cpi($data, $examinee){
		// Create the image
		$image = imagecreatefrompng('./images/CPI_1.png');
		// Create some colors
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);
		// Replace path by your own font path
		$font = './fonts/simsun.ttf';
		// Add some shadow to the text
		$labels_array = array(
			"支配性"=>1,"进取性"=>2,"社交性"=>3,"自在性"=>4,"自承性"=>5,"幸福感"=>6,
			"责任感"=>7,"社会化"=>8,"自制力"=>9,"宽容性"=>10,"好印象"=>11,"同众性"=>12,
			"遵循成就"=>13,"独立成就"=>14,"精干性"=>15,
			"心理性"=>16,"灵活性"=>17,"女性化"=>18
		);
		foreach ($data as $value){
			if(isset($labels_array[$value['chs_name']])){
				$row = $labels_array[$value['chs_name']];
				$y = 80+($row-1)*37;
				$x = 94 + ( 456 * ($value['std_score']/100));
				imagettftext($image, 7, 0, $x, $y, $black, $font, '●');
			}
		}
// 		$red = imagecolorallocate($image,255,0,0);//创建一个颜色，以供使用
// 		imageline($image,30,30,240,140,$red);
		
// 		//$red = imagecolorallocate($image,255,0,0);//创建一个颜色，以供使用
// 		self::MDashedLine($image,60,60,240,140,$white);
		
		$fileName = './tmp/'.$examinee->id.'_cpi.png';
		if(file_exists($fileName)){
			unlink($fileName);
		}
		imagepng ( $image , $fileName);
		//imagedestroy ( $image );
		return $fileName;
	}
	
	
	
	
	
}