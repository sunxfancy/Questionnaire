<?php
	require_once ("../app/classes/PHPExcel.php");
	class Test3Controller extends Base {
		public function indexAction(){
			$examinee=Examinee::findFirst(2048);
			$manager=Manager::findFirst(2);
			// $objPHPExcel = new PHPExcel();
			// $objPHPExcel->getProperties()->setTitle($examinee->id.'analysis_evaluation');
		 //    $objPHPExcel->getProperties()->setSubject($examinee->id.'analysis_evaluation');


		    //$this->fillSheet1($objPHPExcel,$examinee);
		    $indexs=$this->getindividualComprehensive($examinee->id);
		    $indexChildren=$this->getIndexsChildren('zb_xljksp',$examinee);
		    echo '<pre/>';
		    print_r($indexs);
		    print_r($indexChildren);
	  //      	$objActSheet2=$objPHPExcel -> createSheet();
	  //      	$this->fillSheet2($objActSheet2,$examinee);

	  //       $objActSheet3=$objPHPExcel -> createSheet();
	  //       $this->fillSheet3($objActSheet3,$examinee);

			// $objActSheet4=$objPHPExcel -> createSheet();
	  //       $this->fillSheet4($objActSheet4,$examinee);

	  //       $objActSheet5=$objPHPExcel -> createSheet();
	  //       $this->fillSheet5($objActSheet5,$examinee);

	  //       $objActSheet = $objPHPExcel->createSheet();
	  //       $this->fillSheet6($objActSheet,$examinee);


		 //    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	  //       $year = floor($manager->project_id/ 100 );
	  //       $path="/project/".$year."/".$manager->project_id."/individual/personal_analysis_evaluation/";
	  //       if(!is_dir(".".$path)){
	  //       	$handle=new FileHandle();
	  //       	$handle->mk_dir(".".$path);
	  //       }
	  //       $file_name_trans = $path.$examinee->number."_personal_analysis_evaluation.xls";
	  //       $file_name= iconv("utf-8", "gb2312", $file_name_trans);
	  //       $objWriter->save(".".$file_name);
			
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
			$objActSheet->setTitle('Sheet1');
	        $objActSheet->getColumnDimension('A')->setWidth(20);
	        $objActSheet->mergeCells('B1:E1');
	        $objActSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $cells=array('A1','A2');
	        $values=array('被测人员编号',$examinee->number);
	        $chars_offset=0;
	        $chars=array('一','二','三','四');
	        $offset=2;
	        $modules=$this->getindividualComprehensive($examinee->id);
	        foreach ($modules as $key => $module) {
	        	# code...
	        	$offset++;
	        	//处理单块第一行
	        	$objActSheet->mergeCells('B'.$offset.':E'.$offset);
	        	$cells[]='B'.$offset;
	        	$values[]=$chars[$chars_offset].$key.'评价指标';
	        	$objActSheet->getStyle('B'.$offset)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        	$chars_offset++;

	        	//处理单块第二行
	        	$offset++;
	        	$cells[]='B'.$offset;
	        	$values[]='组合因素';
	        	$cells[]='C'.$offset;
	        	$values[]='原始分';
	        	$cells[]='D'.$offset;
	        	$values[]='综合分';
	        	$cells[]='E'.$offset;
	        	$values[]='评价结果';
	        	$offset+=2;

	        	//循环各节
	        	foreach ($module as $key => $module_index) {
	        		# code...
	        		//处理单节第一行(附带因子数量)
	        		$index_name=$module_index['name'];
	        		$indexChildren=$this->getIndexsChildren($index_name,$examinee);
	        		$cells[]='A'.$offset;
	        		$values[]=$indexChildren['chs_name'];
	        		$cells[]='A'.($offset+1);
	        		$values[]=$indexChildren['count'];
	        		$children=$indexChildren['children'];
	        		//循环因子各行
	        		foreach ($children as $key => $child) {
	        			# code...
	        			$cells[]='B'.$offset;
	        			$values[]=$child['name'];
	        			$cells[]='C'.$offset;
	        			$values[]=$child['raw_score'];
	        			$cells[]='D'.$offset;
	        			$values[]=$child['ans_score'];
	        			$offset++;
	        		}
	        		$objActSheet->getStyle('A'.$offset.':E'.$offset)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	        		$objActSheet->getStyle('A'.$offset.':E'.$offset)->getFill()->getStartColor()->setARGB('FF808080');
	        		$offset++;

	        	}
	        	


	        }


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

		function fillSheet6($objActSheet,$examinee){
			$objActSheet->setTitle("排序新版");
			$strong = array(
	            '【强项指标1】【最优】','【强项指标2】【次优】','【强项指标3】【三优】','【强项指标4】【四优】','【强项指标5】【五优】','【强项指标6】【六优】','【强项指标7】【七优】','【强项指标8】【八优】'
	        );
	        $weak = array(
	            '【弱项指标1】【最弱】','【弱项指标2】【次弱】','【弱项指标3】【三弱】','【弱项指标4】【四弱】','【弱项指标5】【五弱】'
	        );
	        $checkout = new CheckoutData();
	        $eightAddFive = $checkout->getEightAddFive($examinee);
	        $objActSheet->getColumnDimension('A')->setWidth(20);
	        $objActSheet->getColumnDimension('B')->setWidth(16);
	        $objActSheet->getColumnDimension('C')->setWidth(12);
	        $objActSheet->getColumnDimension('D')->setWidth(12);
	        $objActSheet->getColumnDimension('E')->setWidth(12);
	        //settings
	        $objActSheet->getDefaultRowDimension()->setRowHeight(16);
	        $objActSheet->mergeCells('A1:E1');
	        $objActSheet->setCellValue('A1','TQT人才测评系统    28指标排序（8+5）');
	        $objActSheet->getStyle('A1')->getFont()->setBold(true);
	        $this->position($objActSheet,'A1');
	        $objActSheet->setCellValue('A2','编号');
	        $this->position($objActSheet,'A2');
	        $objActSheet->setCellValue('B2',$examinee->number);
	        $this->position($objActSheet,'B2');
	        $objActSheet->setCellValue('C2','姓名');
	        $this->position($objActSheet,'C2');
	        $objActSheet->mergeCells('D2:E2');
	        $objActSheet->setCellValue('D2',$examinee->name);
	        $this->position($objActSheet,'D2');
	        $objActSheet->mergeCells('A3:E3');
	        
	        $objActSheet->setCellValue('B4','组合因素');
	        $objActSheet->getStyle('B4')->getFont()->setBold(true);
	        $this->position($objActSheet,'B4');
	        $objActSheet->setCellValue('C4','原始分');
	        $objActSheet->getStyle('C4')->getFont()->setBold(true);
	        $this->position($objActSheet,'C4');
	        $objActSheet->setCellValue('D4','综合分');
	        $objActSheet->getStyle('D4')->getFont()->setBold(true);
	        $this->position($objActSheet,'D4');
	        $objActSheet->setCellValue('E4','评价结果');
	        $objActSheet->getStyle('E4')->getFont()->setBold(true);
	        $this->position($objActSheet,'E4');
	        $startRow = 5;
	        $styleArray = array(
	        		'borders' => array(
	        				'outline' => array(
	        						//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
	        						'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
	        						//'color' => array('argb' => 'FFFF0000'),
	        				),
	        		),
	        );
	        
	        if (isset($eightAddFive['strong'])){
	        	$i = 0;
	        	foreach($eightAddFive['strong'] as $eight ){
	        		 $firstRow = $startRow;
	        		 $lastRow = $startRow;
	        		 $objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
	        		 $objActSheet->setCellValue('A'.$startRow,$strong[$i]);
	        		 $this->position($objActSheet,'A'.$startRow,'left');
	        		 $startRow++;
	        		 $objActSheet->setCellValue('A'.$startRow,$eight['chs_name']);
	        		 $this->position($objActSheet,'A'.$startRow,'left');
	        		 $objActSheet->setCellValue('A'.($startRow+1),$eight['count']);
	        		 $this->position($objActSheet,'A'.($startRow+1),'left');
	        		 foreach ($eight['children'] as $svalue ){
	        		 	$objActSheet->setCellValue('B'.$startRow,$svalue['name']);
	        		 	$this->position($objActSheet,'B'.$startRow);
	        		 	$objActSheet->setCellValue('C'.$startRow,$svalue['raw_score']);
	        		 	$this->position($objActSheet,'C'.$startRow);
	        		 	$objActSheet->setCellValue('D'.$startRow,$svalue['ans_score']);
	        		 	$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
	        		 	$this->position($objActSheet,'D'.$startRow);
	        		 	$objActSheet->setCellValue('E'.$startRow,$svalue['number']);
	        		 	$this->position($objActSheet,'E'.$startRow);
	        		 	$startRow++;
	        		 }
	        		 $objActSheet->setCellValue('D'.$startRow,$eight['score']);
	        		 $objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
	        		 $this->position($objActSheet,'D'.$startRow);
	        		 $lastRow = $startRow;
	        		 $startRow++;
	        		 $objActSheet->getStyle('A'.$firstRow.':E'.$lastRow)->applyFromArray($styleArray);
	        	$i++;
	        	}
	        	$startRow++;
	        }
	        if (isset($eightAddFive['weak'])){
	        	$i = 0;
	        	foreach($eightAddFive['weak'] as $eight ){
	        		$firstRow = $startRow;
	        		$lastRow = $startRow;
	        		$objActSheet->mergeCells('A'.$startRow.':E'.$startRow);
	        		$objActSheet->setCellValue('A'.$startRow,$weak[$i]);
	        		$this->position($objActSheet,'A'.$startRow,'left');
	        		$startRow++;
	        	 	$objActSheet->setCellValue('A'.$startRow,$eight['chs_name']);
	        		$this->position($objActSheet,'A'.$startRow,'left');
	        		$objActSheet->setCellValue('A'.($startRow+1),$eight['count']);
	        		$this->position($objActSheet,'A'.($startRow+1),'left');
	        		foreach ($eight['children'] as $svalue ){
	        		 	$objActSheet->setCellValue('B'.$startRow,$svalue['name']);
	        		 	$this->position($objActSheet,'B'.$startRow);
	        		 	$objActSheet->setCellValue('C'.$startRow,$svalue['raw_score']);
	        		 	$this->position($objActSheet,'C'.$startRow);
	        		 	$objActSheet->setCellValue('D'.$startRow,$svalue['ans_score']);
	        		 	$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
	        		 	$this->position($objActSheet,'D'.$startRow);
	        		 	$objActSheet->setCellValue('E'.$startRow,$svalue['number']);
	        		 	$this->position($objActSheet,'E'.$startRow);
	        		 	$lastRow = $startRow;
	        		 	$startRow++;
	        		}
	        		$objActSheet->setCellValue('D'.$startRow,$eight['score']);
	        		$objActSheet->getStyle('D'.$startRow)->getFont()->setBold(true);
	        		$this->position($objActSheet,'D'.$startRow);
	        		$lastRow = $startRow;
	        		$startRow++;
	        		$objActSheet->getStyle('A'.$firstRow.':E'.$lastRow)->applyFromArray($styleArray);
	        		$i++;
	        	}
	        	$startRow++;
	        }
		}

		function position($objActSheet, $pos, $h_align='center'){
	    	$objActSheet->getStyle($pos)->getAlignment()->setHorizontal($h_align);
	    	$objActSheet->getStyle($pos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    	$objActSheet->getStyle($pos.':'.$pos)->getAlignment()->setWrapText(true);
    	}
    	
    	function getindividualComprehensive($examinee_id){
			$project_id = Examinee::findFirst($examinee_id)->project_id;
			$project_detail = 
			ProjectDetail::findFirst(
			array (
			"project_id = :project_id:",
			'bind' => array ('project_id' => $project_id),
			));
			
			if(empty($project_detail) || empty($project_detail->module_names)){
				throw new Exception('项目配置信息有误');
			}
			$exist_module_array = explode(',',$project_detail->module_names);
			$module_array = array("心理健康"=>'mk_xljk',"素质结构"=>'mk_szjg',"智体结构"=>'mk_ztjg',"能力结构"=>'mk_nljg');
			$module_array_score = array();
			foreach($module_array as $key => $value){
				if (!in_array($value, $exist_module_array)){
					continue;
				}
				$module_record =Module::findFirst(
				array(
				"name = ?1",
				'bind' => array(1=>$value)) );
				$children = $module_record->children;
				$children_array = explode(',', $children);
				$result_1 = $this->modelsManager->createBuilder()
				->columns(array(
						'Index.chs_name as chs_name',
						'Index.name as name',
						'IndexAns.score as score',
						'Index.children as children'
				))
				->from('Index')
				->inwhere('Index.name', $children_array)
				->join('IndexAns', 'IndexAns.index_id = Index.id AND IndexAns.examinee_id = '.$examinee_id)
				->orderBy('IndexAns.score desc')
				->getQuery()
				->execute()
				->toArray();
				//进行规范排序
				$module_array_score[$key] = array();
				foreach($result_1 as &$result_1_record){
					$skey = array_search($result_1_record['name'], $children_array);
					$module_array_score[$key][$skey] = $result_1_record;
				}
			}
			return $module_array_score;
		}

		function getIndexsChildren($index_name,$examinee){
			$strong_exist_array = array();
			$strong_value=array('name'=>$index_name);
			$index = Index::findFirst(array('name=?1','bind'=>array(1=>$strong_value['name'])));
			$strong_value['chs_name'] = $index->chs_name;
			$middle = array();
			$middle = MiddleLayer::find(array('father_chs_name=?1', 'bind'=>array(1=>$strong_value['chs_name'])))->toArray();
			$children = array();
			$children = $this->getChildrenOfIndexDesc($index->name, $index->children, $examinee->id);
			foreach($children as &$children_info){
				if(!isset($children_info['raw_score'])){
					$children_info['raw_score'] = null;
				}
			}
			$strong_value['count'] = count($children);
			$tmp = array();
			$children = $this->foo($children, $tmp);	
			//先进行去重选择
			$child_xuhao = array();
			$qiansan = 1; 
			for($i = 0, $len = count($children); $i < $len; $i += 4 ){
				if (in_array($children[$i], $strong_exist_array )){
					$child_xuhao[$children[$i]] = null;
				}else{
					if ($qiansan > 3 ){
						$child_xuhao[$children[$i]] = null;
					}else {
						$child_xuhao[$children[$i]] = $qiansan++;
						$strong_exist_array[] = $children[$i];
					}	
				}
			}

			$strong_value['children'] = array();
			$number_count = 0;
			foreach ($middle as $middle_info ){
				$outter_tmp = array();
				$middle_children = explode(',',$middle_info['children']);
				$outter_tmp_score = 0;
				foreach ($middle_children as $children_name){
					$inner_tmp = array();
					$key = array_search($children_name, $children);
					$inner_tmp['name'] = $children_name;
					$inner_tmp['raw_score'] = $children[$key+3];
					$inner_tmp['ans_score'] = $children[$key+1];
					$outter_tmp_score += $inner_tmp['ans_score'];
					$inner_tmp['number'] = $child_xuhao[$children_name];
					$strong_value['children'][] = $inner_tmp;
				}
				$outter_tmp['name'] = null;
				$outter_tmp['raw_score'] = null;
				$outter_tmp['ans_score'] = $outter_tmp_score;
				$outter_tmp['number'] = null;
				$strong_value['children'][] = $outter_tmp;
			}
			return $strong_value;
		}

		function getChildrenOfIndexDesc($index_name, $children, $examinee_id){	
			$modifyFactors = new ModifyFactors();
			return $modifyFactors->getChildrenOfIndexDescFor85( $index_name,  $children,  $examinee_id );
		}

		function foo($arr, &$rt) {
			if (is_array($arr)) {
				foreach ($arr as $v) {
					if (is_array($v)) {
						$this->foo($v, $rt);
					} else {
						$rt[] = $v;
					}
				}
			}
			return $rt;
		}
	}