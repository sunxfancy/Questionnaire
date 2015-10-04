<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class InterviewDB 
{
    /**
     * 存储不完整意见--$comments_incomplete
     */
    public static function insertInComment($array){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
			$interview = Interview::findFirst(array(
                'manager_id=?0 and examinee_id=?1',
                'bind'=>array(0=>$array->manager_id,1=>$array->examinee_id)));
			$interview->setTransaction($transaction);
            $array = json_encode($array,true);
			$interview->comments_incomplete = $array;
			if( $interview->save() == false ){
				$transaction->rollback("数据插入失败");
			}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }

    /**
     * 存储完整意见--$comments
     */
    public static function insertComment($array){
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            $interview = Interview::findFirst(array(
                'manager_id=?0 and examinee_id=?1',
                'bind'=>array(0=>$array->manager_id,1=>$array->examinee_id)));
            $interview->setTransaction($transaction);
            $array = json_encode($array,true);
            $interview->comments = $array;
            if( $interview->save() == false ){
                $transaction->rollback("数据插入失败");
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }

}