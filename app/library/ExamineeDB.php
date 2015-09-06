<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
 
class ExamineeDB {
	public static function insertInquery($examinee_id, $inquery_ans, $project_id){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			$inquery = new InqueryAns();
			$inquery->setTransaction($transaction);
			$inquery->examinee_id = $examinee_id;
			$inquery->project_id  = $project_id;
			$inquery->option      = $inquery_ans;
			if ($inquery->save() == false){
				 $transaction->rollback("插入数据库失败-".$examinee_id.'-'.$project_id.'-'.$inquery_ans);
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
				throw new Exception($e->getMessage());
		}
	}
	public static function insertExamineeInfo(&$info, $array){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			$info->setTransaction($transaction);
			foreach($array as $key=>$value){
				$info->$key = $value;
			}
			if ($info->save() == false){
				$transaction->rollback("插入数据库失败-".print_r($array,true));
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	
}
