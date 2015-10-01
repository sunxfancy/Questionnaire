<?php

class ChartLoader {
	public function test(){
		require_once("../app/classes/PHPExcel.php");
		$objPHPExcel = new PHPExcel();
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$objWorksheet->fromArray(
				array(
						array('' , 2010,   2011,   2012),
						array('Q1',   12,   15,     21),
						array('Q2',   56,   73,     86),
						array('Q3',   52,   61,     69),
						array('Q4',   30,   32,     0),
				)
		);
		// 设置每一个data series 数据系列的名称
		$dataseriesLabels = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),   //  2010
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),   //  2011
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', NULL, 1),   //  2012
		);
		$xAxisTickValues = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$5', NULL, 4),
			);
		//  设置作图区域数据
		$dataSeriesValues = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$5', NULL, 4),
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$5', NULL, 4),
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$5', NULL, 4),
		);
		$series = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
				PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping
				range(0, count($dataSeriesValues)-1),           // plotOrder
				$dataseriesLabels,                              // plotLabel
				$xAxisTickValues,                               // plotCategory
				$dataSeriesValues                               // plotValues
		);
		// 给数据系列分配一个做图区域
		$plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
		// Set the chart legend
		$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);
		
		// 设置图形标题
		$title = new PHPExcel_Chart_Title('Test Stacked Line Chart');
		// 设置Y轴标签
		$yAxisLabel = new PHPExcel_Chart_Title('Value ($k)');
		
		
		// 创建图形
		$chart = new PHPExcel_Chart(
				'chart1',       // name
				$title,         // title
				$legend,        // legend
				$plotarea,      // plotArea
				true,           // plotVisibleOnly
				0,              // displayBlanksAs
				NULL,           // xAxisLabel
				$yAxisLabel     // yAxisLabel
		);
		
		// 设置图形绘制区域
		$chart->setTopLeftPosition('A7');
		$chart->setBottomRightPosition('H20');
		
		// 将图形添加到当前工作表
		$objWorksheet->addChart($chart);
		
		
		// Save Excel 2007 file
		echo date('H:i:s')." Write to Excel2007 format";
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// 打开做图开关
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
		echo date('H:i:s')." File written to ".str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME));
	}
}
