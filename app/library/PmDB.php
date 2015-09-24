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

    //更新项目模块选择结果
    public static function updateProjectDetail($project_detail){
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            $project_detail->setTransaction($transaction);
            if($project_detail->save() == false ){
                $transaction->rollback("数据更新失败-".print_r($project_detail,true));
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }

    //更新项目状态
    public static function updateProjectState($project_id){
        $project = Project::findFirst($project_id);         
        $project->state = intval($project->state) + 1;
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();               
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

    //判断project->state是否已经更新
    public static function isStateSet($project_id,$type){
        $project = Project::findFirst($project_id);
        if ($project->state < 2) {
            switch($type){
                case '1':   $inquery = InqueryQuestion::findFirst(array(
                                'project_id=?1',
                                'bind'=>array(1=>$project_id)));
                            if (empty($inquery)) {return false;}
                            else {return false;}
                            break;
                case '2':   $project_detail = ProjectDetail::findFirst(array(
                                'project_id=?1',
                                'bind'=>array(1=>$project_id)));
                            if (empty($project_detail)) {return false;}
                            else {return false;}
                            break;
                default:    return true;
                            break;
            }
        }else{return true;}
    }
}