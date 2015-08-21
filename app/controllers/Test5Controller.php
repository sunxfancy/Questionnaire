<?php

class Test5Controller extends Base
{
	public function indexAction($examinee_id){
		$examinee = CalAge::getExaminee($examinee_id);
		$age = CalAge::calAge1($examinee->birthday,$examinee->last_login);
		$factor_ans = FactorAns::findAll(array(
			'examinee_id=?0',
			'bind'=>array(0=>$examinee_id)));
		foreach ($factor_ans as $factor_anses) {
			$paper_name = getPaperName($factor_anses->paper_id);
			switch ($paper_name) {
				case 'CPI':
					$dm = ($examinee->sex ==0) : 2 ? 1;
					$std_score = cal_cpi_Std_score($dm,$factor_anses->factor_id,$factor_anses->score);
					break;
				case 'EPQA':
					$dm = ($examinee->sex ==0) : 2 ? 1;
					$dage = floor($age);
					$std_score = cal_epqa_Std_score($dm,$dage,$factor_anses->factor_id,$factor_anses->score);
					break;
				case '16PF':
					$dm = ($examinee->sex ==0) : 9 ? 8;
					$std_score = cal_ks_Std_score($dm,$factor_anses->factor_id,$factor_anses->score);
					break;
				case 'SPM': 
					$std_score = cal_cpi_Std_score($age,$factor_anses->factor_id,$factor_anses->score);
					break;
				default:
					$std_ans = $factor_anses->sore;
					break;
			}
		}
	}

	public function cal_cpi_Std_score($dm,$factor_id,$score){
		$cpimode = Cpimode::findFirst(array(
            'DM=?0 and YZ=?1',
            'bind'=>array(0=>$dm,1=>$factor_name)));
		$m = $cpimode->M;
		$sd = $cpimode->SD;
		$std_score = 50 + (10 * ($score - $m)) / $sd;
		return $std_score;
	}

	public function cal_epqa_Std_score($dm,$dage,$factor_id,$score){
		$factor_name = CalAge::getFactorName($factor_id);
		$epqamode = Epqamode::findFirst(
			/*
			DSEX = $dm;
			DAGEL<=$age<=DAGEH;
			*/);
		switch ($factor_name) {
			case 'epqae':
				$m = $epqamode->EM;
				$sd = $epqamode->ESD;
				break;
			case 'epqan':
				$m = $epqamode->NM;
				$sd = $epqamode->NSD;
				break;
			case 'epqap':
				$m = $epqamode->PM;
				$sd = $epqamode->PSD;
				break;
			case 'epqal':
				$m = $epqamode->LM;
				$sd = $epqamode->LSD;
				break;
			
			default:
				throw new Exception("No record find!");
				break;
		}
		$std_score = 50 + (10 * ($score - $m)) / $sd;
		return $std_score;
	}

	public function cal_ks_Std_score($dm,$factor_id,$score){
		$factor_name = CalAge::getFactorName($factor_id);
		$ksmode = Ksmode::findAll(array(
			'DM=?0 and YZ=?1',
			'bind'=>array(0=>$dm,1=>$factor_name))
			);
		//这个条件该怎么写？？
		// if ($ksmode->QSF<=$age && $ksmode->ZZF>=$age) {
		// 	$std_score = $ksmode->BZF;
		// 	return $std_score;
		// }
		else throw new Exception("No record find!");
		
	}

	public function cal_spm_Std_score($age,$factor_id,$score){
		if ($this->getFactorName($factor_anses->factor_id) == "spm"){
			$spmmode = Spmmode::findFirst(
				/*
				NLL<=$age<=NLH;*/
				);
			if ($score >= $spmmode->B95) {
				$std_score = 1;
			}
			else if ($score >= $spmmode->B75) {
				$std_score =2;
			}
			else if ($score >= $spmmode->B25) {
				$std_score = 3;
			}
			else if ($score >= $spmmode->B5) {
				$std_score = 4;
			}
			else{
				$std_score = 5;
			}
		}
		else{
			$std_score = $score;
		}
		return $std_score;
	}
}