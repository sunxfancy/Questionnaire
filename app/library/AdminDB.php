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
	 * @usage 删除项目, 删除project
	 * 由于数据库中采取使用外键级联与project相关的所有信息
	 */
	public static function delproject($project_id){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			$project_info = Project::findFirst($project_id);
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
	/**
	 *@usage 项目创建涉及 project 及manager 
	 */
	public static function addProject($project_info, $manager_info){
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();
			#先分别存储project 和 manager
			$project = new Project();
			$project->setTransaction($transaction);
			foreach($project_info as $key => $value){
				$project->$key = $value;
			}
			$manager = new Manager();
			$manager->setTransaction($transaction);
			foreach($manager_info as $key =>$value){
				$manager->$key = $value;
			}
			$manager->project_id = $project_info['id'];
			#先插入项目
			if( $project->create() == false ){
				$transaction->rollback("数据插入失败-".print_r($project,true));
			}
			#再插入项目经理
			if($manager->create() == false ){
				$transaction->rollback("数据删除失败-".print_r($manager,true));
			}
			#再更新项目
			$project->manager_id = $manager->id;
			if($project->save() == false ){
				$transaction->rollback("数据删除失败-".print_r($project,true));
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception($e->getMessage());
		}
	}

}