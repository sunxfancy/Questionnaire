<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class Test5Controller extends Base
{
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}

	public function indexAction(){
		$str="
a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a
";
$a1 = explode('|',$str);
echo count($a1);
	

		// $examinee_id = 15;
		// $std_score = $this->calStd($examinee_id);
		// $ans_score = $this->calAns($examinee_id);
		// $this->insertScore($std_score,$ans_score,$examinee_id);
		//$index_score = $this->calIndex($examinee_id);
		//print_r($index_score);
	}

	public function insertScore($std_score,$ans_score,$examinee_id){
		$factor_ans = FactorAns::find(array(
			'examinee_id=?0',
			'bind'=>array(0=>$examinee_id)));
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			foreach ($factor_ans as  $value){ 
				if(isset($std_score[$examinee_id][$value->factor_id])){
					$value->std_score = $std_score[$examinee_id][$value->factor_id];
				}else{
					$value->std_score = 0;
				}
				if(isset($ans_score[$examinee_id][$value->factor_id])){
					$value->ans_score = $ans_score[$examinee_id][$value->factor_id];
				}else{
					$value->ans_score = 0;
				}
				if($value->save() == false){
					$transaction->rollback("Cannot update table FactorAns' score");
				}
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception("Failed, reason: ".$e->getMessage());
		}
	}

	public function calStd($examinee_id){
		$std_score = array();
		$examinee = CalAge::getExaminee($examinee_id);
		$age = CalAge::calAge1($examinee->birthday,$examinee->last_login);
		$factor_ans = FactorAns::find(array(
			'examinee_id=?0',
			'bind'=>array(0=>$examinee_id)));
		$std_score = array();
		foreach ($factor_ans as $value) {
			$paper_name = CalAge::getPaperName($value->Factor->paper_id);
			switch (strtoupper($paper_name)) {
				case 'CPI':
					$dm = ($examinee->sex ==0) ? 2 : 1;
					$std_score[$examinee_id][$value->factor_id] = $this->cal_cpi_Std_score($dm,$value->factor_id,$value->score);
					break;
				case 'EPQA':
					$dm = ($examinee->sex ==0) ? 2 : 1;
					$dage = floor($age);
					$std_score[$examinee_id][$value->factor_id] = $this->cal_epqa_Std_score($dm,$dage,$value->factor_id,$value->score);
					break;
				case '16PF':
					$dage = floor($age);
					$dm = ($examinee->sex ==0) ? 9 : 8;
					$std_score[$examinee_id][$value->factor_id] = $this->cal_ks_Std_score($dm,$dage,$value->factor_id,$value->score);
					break;
				case 'SPM': 
					$std_score[$examinee_id][$value->factor_id] = $this->cal_spm_Std_score($age,$value->factor_id,$value->score);
					break;
				default:
					$std_score[$examinee_id][$value->factor_id] = $value->score;
					break;
			}
		}
		return $std_score;
	}

	public function cal_cpi_Std_score($dm,$factor_id,$score){
		$factor_name = CalAge::getFactorName($factor_id);
		$cpimd = Cpimd::findFirst(array(
            'DM=?0 and YZ=?1',
            'bind'=>array(0=>$dm,1=>$factor_name)));
		$m = 0;
		$sd = 0;
		if(isset($cpimd->M)){
			$m =  $cpimd->M;
		}
		if(isset($cpimd->SD)){
			$sd = $cpimd->SD;
		}
		if($m != 0 && $sd != 0){ 
			$std_score = 50 + (10 * ($score - $m)) / $sd;
			return $std_score;
		}
	}

	public function cal_epqa_Std_score($dm,$dage,$factor_id,$score){
		$factor_name = CalAge::getFactorName($factor_id);
		$epqamd = Epqamd::findFirst(array(
			'DAGEL <= :age: AND DAGEH >= :age: AND DSEX = :sex:',
			'bind'=>array('age'=>$dage,'sex'=>$dm)));
		switch ($factor_name) {
			case 'epqae':
				$m = $epqamd->EM;
				$sd = $epqamd->ESD;
				break;
			case 'epqan':
				$m = $epqamd->NM;
				$sd = $epqamd->NSD;
				break;
			case 'epqap':
				$m = $epqamd->PM;
				$sd = $epqamd->PSD;
				break;
			case 'epqal':
				$m = $epqamd->LM;
				$sd = $epqamd->LSD;
				break;		
			default:
				throw new Exception("No record find!");
				break;
		}
		$std_score = 50 + (10 * ($score - $m)) / $sd;
		return $std_score;
	}

	public function cal_ks_Std_score($dm,$dage,$factor_id,$score){
		$std_score = null;
		$factor_ignore = array(
			'X1','X2','X3','X4','Y1','Y2','Y4'
			);
		$factor_name = CalAge::getFactorName($factor_id);
		if (in_array($factor_name, $factor_ignore)){
			$std_score = $score;
		}
		else if($factor_name == 'Y3'){
			$ksmd = Ksmd::find(array(
				'YZ=?1',
				'bind'=>array(1=>$factor_name))); 
			foreach ($ksmd as $ksmds ) {
				if ($score <= $ksmds->ZZF && $score >= $ksmds->QSF) {
						$std_score = $ksmds->BZF;
				}
			}
		}else{
			$ksmd = Ksmd::find(array(
				'DM=?0 AND YZ=?1',
				'bind'=>array(0=>$dm,1=>$factor_name))); 
			foreach ($ksmd as $ksmds ) {
				if ($score <= $ksmds->ZZF && $score >= $ksmds->QSF) {
						$std_score = $ksmds->BZF;
				}
			}
		}
		return $std_score;
	}

	public function cal_spm_Std_score($age,$factor_id,$score){ 
		$factor_name = CalAge::getFactorName($factor_id);
		if ($factor_name == 'spm'){
			$spmmd = Spmmd::findFirst(array(
				'NLH >= :age: AND NLL <= :age:',
				'bind'=>array('age'=>$age)));
			foreach ($spmmd as $spmmds) {
				if ($score >= $spmmd->B95) {
					$std_score = 1;
				}
				else if ($score >= $spmmd->B75) {
					$std_score =2;
				}
				else if ($score >= $spmmd->B25) {
					$std_score = 3;
				}
				else if ($score >= $spmmd->B5) {
					$std_score = 4;
				}
				else{
					$std_score = 5;
				}			
			}
		}
		else{
				$std_score = $score;
			}
		return $std_score;
	}

	public function calAns($examinee_id){
		$ans_score = array();
		$factor_ans = FactorAns::find(array(
			'examinee_id=?0',
			'bind'=>array(0=>$examinee_id)));
		foreach ($factor_ans as $factor_anses) {
			$factor_id = $factor_anses->factor_id;
			$ans = $factor_anses->std_score;
			$factor = Factor::findFirst(array(
				'id=?0',
				'bind'=>array(0=>$factor_id)));
			eval($factor->ans_do.';');
			$ans_score[$examinee_id][$factor_id] = sprintf("%.2f",$ans);
		}
		return $ans_score;
	}

	public function calIndex($examinee_id){
		$factor_ans = FactorAns::find(array(
			'examinee_id=?0',
			'bind'=>array(0=>$examinee_id)));
		echo "<pre>";
		print_r($factor_ans);
		echo "</pre>";
		exit();
		$index_ans = IndexAns::find(array(
			'examinee_id=?0',
			'bind'=>array(0=>$examinee_id)));
		// echo "<pre>";
		// print_r($index_ans);
		// echo "</pre>";
		// exit();
		foreach ($index_ans as $index_anses) {
			$factor_score = array();
			$index = Index::findFirst($index_anses->index_id);
            $children = explode(",",$index->children );          
            $childrentype = explode(",", $index->children_type);
            $action = $index->action;
            for ($j=0; $j < sizeof($childrentype); $j++) { 
                //0代表index，1代表factor
                if ($childrentype[$j] == "0") {
                    $index1 = Index::findFirst(array(
                        'name=?1',
                        'bind'=>array(1=>$children[$j])));
                    $children1 = $index1->children;
                    $children1 = explode(",",$children1);
                    $action = $index1->action;
                    for ($k=0; $k <sizeof($children1) ; $k++) {
                    	$factor_id = CalAge::getFactorId($children1[$k]);
                    	if ($factor_ans->factor_id == $factor_id) {
                    		$factor_score[$children1[$k]] = $factor_ans->ans_score;
                    	}
                    }
                    $do_action = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', '\$factor_score[\'$0\']', $action);
					$do_action =  "\$index_score = $do_action;";
					eval($do_action);
                    $score[$examinee_id][$index1->id] = sprintf('%.2f',$factor_score);
                }
                else{   
                	$factor_id = CalAge::getFactorId($children[$j]);
                	if ($factor_ans->factor_id == $factor_id) {
                		$factor_score[$children1[$k]] = $factor_ans->ans_score;
                	}
                }   
                $do_action = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', '\$factor_score[\'$0\']', $action);
				$do_action =  "\$index_score = $do_action;";
				eval($do_action);
                $score[$examinee_id][$index->id] = sprintf('%.2f',$factor_score);            
            }
		}
		return $score;
	}
	
}