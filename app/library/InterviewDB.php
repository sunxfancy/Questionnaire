<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class InterviewDB 
{
    /**
     * 存储不完整意见--$comments_incomplete
     */
    public static function insertInComment($array,$examinee_id,$manager_id){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
			$interview = Interview::findFirst(array(
                'manager_id=?0 and examinee_id=?1',
                'bind'=>array(0=>$manager_id,1=>$examinee_id)));
			$interview->setTransaction($transaction);
            $array = json_encode($array,JSON_UNESCAPED_UNICODE);
			$interview->comments_incomplete = $array;
            $interview->advantage = '';
            $interview->disadvantage = '';
            $interview->remark = '';
            $examinee = Examinee::findFirst($examinee_id);
            $examinee->setTransaction($transaction);
            $examinee->state = 4;
			if( $interview->save() == false || $examinee->save() == false){
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
    public static function insertComment($array,$examinee_id,$manager_id){
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            $interview = Interview::findFirst(array(
                'manager_id=?0 and examinee_id=?1',
                'bind'=>array(0=>$manager_id,1=>$examinee_id)));
            $interview->setTransaction($transaction);
            $advantage = array(
                'advantage1' => $array['advantage1'],
                'advantage2' => $array['advantage2'],
                'advantage3' => $array['advantage3'],
                'advantage4' => $array['advantage4'],
                'advantage5' => $array['advantage5']);
            $interview->advantage = json_encode($advantage,JSON_UNESCAPED_UNICODE);
            $disadvantage = array(
                'disadvantage1' => $array['disadvantage1'],
                'disadvantage2' => $array['disadvantage2'],
                'disadvantage3' => $array['disadvantage3']);
            $interview->disadvantage = json_encode($disadvantage,JSON_UNESCAPED_UNICODE);
            $interview->remark = $array['remark'];
            $examinee = Examinee::findFirst($examinee_id);
            $examinee->setTransaction($transaction);
            $examinee->state = 5;
            if( $interview->save() == false || $examinee->save() == false){
                $transaction->rollback("数据插入失败");
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }

}