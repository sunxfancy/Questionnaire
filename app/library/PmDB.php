<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class PmDB 
{
    //存储项目模块选择结果
	public static function insertProjectDetail($project_detail_info){
		try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            $project_detail = new ProjectDetail();
            foreach($project_detail_info as $key => $value){
                $project_detail->$key = $value;
            }
            if( !$project_detail->create()){
                $transaction->rollback("数据插入失败-".print_r($project_detail,true));
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
	}

    //更新项目状态
    public static function updateProjectState($project_id,$state){
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            $project = Project::findFirst($project_id);
            $project->state = $state; 
            $project->setTransaction($transaction);
            if($project->save() == false ){
                $transaction->rollback("数据更新失败-".print_r($project,true));
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }
}