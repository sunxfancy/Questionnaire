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
			$inquery->exmainee_id = $examinee_id;
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
}
