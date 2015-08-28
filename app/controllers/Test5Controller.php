<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class Test5Controller extends Base
{
	
	public function initialize(){
		$this->response->setHeader("Content-Type", "text/html; charset=utf-8");
	}

	public function indexAction(){
		$examinee_id = 12;
		$index_score = $this->calIndexScore($examinee_id);
		echo "<pre>";
		print_r($index_score);
		echo "</pre>";
		echo count($index_score);
		$this->insertIndexScore($index_score,$examinee_id);
	}

	// public function wordAction(){
	// 	WordExport::
	// }

	public function insertIndexScore($index_score,$examinee_id){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			
			foreach ($index_score as  $key=>$value){ 
				$index_ans = new IndexAns();
	            $index_ans->examinee_id = $examinee_id;
	            $index_ans->index_id = $key;
	            $index_ans->score = $value;
	            if( $index_ans->save() == false ){
	                $transaction->rollback("Cannot insert IndexAns data");
	            }  
			}  

			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception("Failed, reason: ".$e->getMessage());
		}
	}

	public function calIndexScore($examinee_id){
		$examinee = Examinee::findFirst($examinee_id);
		$project_id = $examinee->project_id;
		$index_names = $this->getIndexNames($project_id);
		$factor_score = $this->getFactorScore($examinee_id);
		$index_ids = array();
		foreach ($index_names as $index_name) {
			if ($index_name == 'zb_ldnl'|| $index_name == 'zb_gzzf') {
				continue;
			}else{
				$index_ids[] = $this->getIndexId($index_name);
			}
		}
		foreach ($index_ids as $index_id) {
			$indexs = Index::findFirst($index_id);
			$index['children'] = explode(',',$indexs->children);
			$index['childrentype'] = explode(',',$indexs->children_type);
			$index['action'] = $indexs->action;
			$index_score = 0;
			$do_action = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', '\$factor_score[\'$0\']', $index['action']);
			$do_action = "\$index_score = $do_action;";
			$ceshi['123'] = 1;
			$ceshi['12'] = 1;
			eval($do_action);
			$score[$indexs->name] = sprintf('%.2f',$index_score);
		}
		foreach ($index_names as $index_name) {
			if ($index_name == 'zb_ldnl') {
				$index_score = (2*($score['zb_pdyjcnl'] + $score['zb_zzglnl'])+ $score['zb_cxnl'] + $score['zb_ybnl']+ $score['zb_dlgznl'])/7;
				$score[$index_name] = sprintf('%.2f',$index_score);
			}
			else if ($index_name == 'zb_gzzf'){
				$index_score = (1.5*($factor_score['X4'] + $score['zb_rjgxtjsp']) + $factor_score['chg'] + $factor_score['Y3'] + $factor_score['Q3'] + $factor_score['spmabc'] + $factor_score['aff'])/8;
				$score[$index_name] = sprintf('%.2f',$index_score);
			}
			else{
				continue;
			}
		}
		$index_score = array();
		foreach ($score as $key => $value) {
			$index_id = $this->getIndexId($key);
			$index_score[$index_id] = $value;
		}
		return $index_score;
	}

	public function getFactorScore($examinee_id){
		$factor_ans = FactorAns::find(array(
			'examinee_id=?1',
			'bind'=>array(1=>$examinee_id)));
		$factor_score = array();
		foreach ($factor_ans as $factor) {
			$factor_name = Factor::findFirst($factor->factor_id)->name;
			$factor_score[$factor_name] = $factor->ans_score;
		}
		return $factor_score;
	}

	public function getIndexNames($project_id){
        $project_detail = ProjectDetail::findFirst(array(
                "project_id=?1",
                "bind"=>array(1=>$project_id)
                ));
        $index_names = array();
        $index_names = explode(',', $project_detail->index_names);
        return $index_names;
    }

    public function getIndexId($index_name){
    	$index = Index::findFirst(array(
    		'name=?1',
    		'bind'=>array(1=>$index_name)));
    	return $index->id;
    }

    public function getFactorId($factor_name){
    	$factor = Factor::findFirst(array(
    		'name=?1',
    		'bind'=>array(1=>$factor_name)));
    	return $factor->id;
    }

}