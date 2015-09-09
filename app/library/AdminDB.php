<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
class AdminDB {
	/**
	 * @usage 更新project信息
	 */
	public static function updateProject( $project_info ){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			$project_info->setTransaction($transaction);
			if($project_info->save() == false ){
				$transaction->rollback("数据更新失败-".print_r($project_info,true));
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * @usage 更新 project_manager 信息
	 */
	public static function updateManager($manager_info){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			$manager_info->setTransaction($transaction);
			if($manager_info->save() == false ){
				$transaction->rollback("数据更新失败-".print_r($manager_info,true));
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * @usage 删除项目, 删除project表
	 * 由于数据库中采取使用外键级联与project相关的所有信息
	 */
	public static function delproject($project_id){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			$project_info = Project::findFirst($id);
			$project_info->setTransaction($transaction);
			if($project_info->delete() == false ){
				 $transaction->rollback("数据删除失败-".print_r($project_info,true));
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
				throw new Exception($e->getMessage());
		}
	}
}