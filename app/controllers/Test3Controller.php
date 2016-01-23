<?php
	require_once ("../app/classes/PHPExcel.php");
	class Test3Controller extends \Phalcon\Mvc\Controller {
		public function IndexAction(){
			$examinee=Examinee::findFirst(2047);
			$manager=Manager::findFirst(2);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setTitle($examinee->id.'analysis_evaluation');
		    $objPHPExcel->getProperties()->setSubject($examinee->id.'analysis_evaluation');


		    $this->fillSheet1($objPHPExcel,$examinee);

	       	$objActSheet2=$objPHPExcel -> createSheet();
	       	$this->fillSheet2($objActSheet2,$examinee);

	        $objActSheet3=$objPHPExcel -> createSheet();
	        $this->fillSheet3($objActSheet3,$examinee);

			$objActSheet4=$objPHPExcel -> createSheet();
	        $this->fillSheet4($objActSheet4,$examinee);

	        $objActSheet5=$objPHPExcel -> createSheet();
	        $this->fillSheet5($objActSheet5,$examinee);


	    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $year = floor($manager->project_id/ 100 );
        $path="/project/".$year."/".$manager->project_id."/individual/personal_analysis_evaluation/";
        if(!is_dir(".".$path)){
        	$handle=new FileHandle();
        	$handle->mk_dir(".".$path);
        }
        $file_name_trans = $path.$examinee->number."_personal_analysis_evaluation.xls";
        $file_name= iconv("utf-8", "gb2312", $file_name_trans);
        $objWriter->save(".".$file_name);
		}

		function fillCell($cellarr,$valuearr,$objActSheet){
			foreach ($cellarr as $key => $cellar) {
				# code...
	        $objActSheet->setCellValue($cellar,$valuearr[$key]?$valuearr[$key]:"");
			}
		}

		function fillSheet1($objPHPExcel,$examinee){
			 	$objActSheet = $objPHPExcel->getActiveSheet(0);
		        $objActSheet -> setTitle("28指标位置");
		        

		        $indexs=Index::find();
		        $objActSheet->getColumnDimension('B')->setWidth(20);
		        $objActSheet->setCellValue('C1',"location");
		        $objActSheet->setCellValue('D1',"starting");
		        $objActSheet->setCellValue('E1',"ending");
		        $objActSheet->setCellValue('F1',"keyscore");

		        foreach ($indexs as $key => $index) {
		        	# code...
		        	$objActSheet->setCellValue('A'.($key+2),$key+1);
		        	$objActSheet->setCellValue('B'.($key+2),$index->chs_name);

		        }
		}

		function fillSheet2($objActSheet,$examinee){
	        $objActSheet->getColumnDimension('A')->setWidth(20);
	        $objActSheet->mergeCells('B1:E1');
	        $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $cells=array('B1','A2','A3','B4','C4','D4','E4');
	        $values=array('一、心理健康评价指标','被测人员编号',$examinee->number,'组合因素','原始分','综合分','评价结果');
	        $this->fillCell($cells,$values,$objActSheet);
		}
		function fillSheet3($objActSheet,$examinee){
			$objActSheet -> setTitle("All items");
	        $objActSheet->getColumnDimension('A')->setWidth(20);
	        $objActSheet->getColumnDimension('A')->setWidth(15);
	        $objActSheet->mergeCells('B1:E1');
	        $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	       	$factor_ans_objs=FactorAns::find(array(
	       			"examinee_id=?1",
	       			"bind"=>array(1=>$examinee->id)
	       		));
	       	$cells=array('B1','A2','A3','B4','C4','D4','E4');
	        $values=array('一、心理健康评价指标','被测人员编号',$examinee->number,'组合因素','原始分','综合分','评价结果');
	       	$offset=5;
	       	foreach ($factor_ans_objs as $key => $factor_ans_obj) {
	       		# code..
	       		$factor=Factor::findFirst($factor_ans_obj->factor_id);
	       		$factor_chs_name=$factor->chs_name;
	       		if($factor_chs_name=='SPM(A)'||$factor_chs_name=='SPM(B)'||$factor_chs_name=='SPM(C)'||$factor_chs_name=='SPM(D)'||$factor_chs_name=='SPM(E)'||$factor_chs_name=='SPM(A、B、C)'){
	       			$offset--;
	       			continue;
	       		}
	       		$cells[]="A".($key+$offset);
	       		$values[]=$key+$offset-4;
	       		$cells[]='B'.($key+$offset);
	       		$values[]=$factor_chs_name;
	       		$cells[]='C'.($key+$offset);
	       		$values[]=$factor_ans_obj->score;
	       		$cells[]='D'.($key+$offset);
	       		$values[]=$factor_ans_obj->ans_score;

	       	}
			$this->fillCell($cells,$values,$objActSheet);
		}
		function fillSheet4($objActSheet,$examinee){
			$objActSheet -> setTitle("项目排序");
	        $objActSheet->getColumnDimension('A')->setWidth(20);
	        $objActSheet->getColumnDimension('A')->setWidth(15);
	        $objActSheet->mergeCells('B1:E1');
	        $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		 $factor_ans_objs = $this->modelsManager->createBuilder()
                                       ->columns(array( 
                                       	'FactorAns.factor_id as factor_id',
                                       	'FactorAns.score as score',
                                       	'FactorAns.ans_score as ans_score'
                                       		))
                                       ->from('FactorAns')
                                       ->inwhere("examinee_id",array($examinee->id))
                                       ->orderBy('FactorAns.ans_score desc')
                                       ->getQuery()
                                       ->execute();
	       	$cells=array('B1','A2','A3','B4','C4','D4','E4');
	        $values=array('73项组合因素综合分排序','被测人员编号',$examinee->number,'组合因素','原始分','综合分','评价结果');
	       	$offset=5;
	       	foreach ($factor_ans_objs as $key => $factor_ans_obj) {
	       		# code..
	       		$factor=Factor::findFirst($factor_ans_obj->factor_id);
	       		$factor_chs_name=$factor->chs_name;
	       		if($factor_chs_name=='SPM(A)'||$factor_chs_name=='SPM(B)'||$factor_chs_name=='SPM(C)'||$factor_chs_name=='SPM(D)'||$factor_chs_name=='SPM(E)'||$factor_chs_name=='SPM(A、B、C)'){
	       			$offset--;
	       			continue;
	       		}
	       		$cells[]="A".($key+$offset);
	       		$values[]=$key+$offset-4;
	       		$cells[]='B'.($key+$offset);
	       		$values[]=$factor_chs_name;
	       		$cells[]='C'.($key+$offset);
	       		$values[]=$factor_ans_obj->score;
	       		$cells[]='D'.($key+$offset);
	       		$values[]=$factor_ans_obj->ans_score;

	       	}
			$this->fillCell($cells,$values,$objActSheet);
		}

		function fillSheet5($objActSheet,$examinee){
			$objActSheet -> setTitle("排序");
	        $objActSheet->getColumnDimension('B')->setWidth(20);
	        $objActSheet->mergeCells('A1:B1');
	        $cells=array('A1','C1','D1','E1');
	        $values=array('被测编号',$examinee->number,'姓名',$examinee->name);

	        $index_ans_objs=$this->modelsManager->createBuilder()
                                       ->columns(array( 
                                       	'IndexAns.index_id as index_id',
                                       	'IndexAns.score as score'
                                       		))
                                       ->from('IndexAns')
                                        ->inwhere("examinee_id",array($examinee->id))
                                       ->orderBy('IndexAns.score desc')
                                       ->getQuery()
                                       ->execute();
            $offset=2;
            foreach ($index_ans_objs as $key => $index_ans_obj) {
            	# code...
            	$index=Index::findFirst($index_ans_obj->index_id);
            	$index_chs_name=$index->chs_name;
            	$cells[]="A".($key+$offset);
	       		$values[]=$key+$offset-1;
	       		$cells[]='B'.($key+$offset);
	       		$values[]=$index_chs_name;
	       		$cells[]='C'.($key+$offset);
	       		$values[]=$index_ans_obj->score;

	       		if($key<8){
	       			$cells[]='D'.($key+$offset);
	       			$values[]='★';
	       		}else if($key>sizeof($index_ans_objs)-6){
	       			$cells[]='D'.($key+$offset);
	       			$values[]='●';
	       		}
	       		
            }
	        $this->fillCell($cells,$values,$objActSheet);
		}
	}