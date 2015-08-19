<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class MemoryManagement {
	private static $mysql_memory_list = array(
		'cpidf' , 'eppsdf', 'epqadf', 'ksdf','spmdf'
	);
	public static function startMysqlMemoryTable($table_name){
		$table_name = strtolower($table_name);
		if(!in_array($table_name, self::$mysql_memory_list, true)){
			throw new Exception ('There is no memory table for this table!');
		}
		switch ($table_name){
			case 'cpidf' : self::startMysqlCpidfMemory();  break;
			case 'eppsdf' : self::startMysqlEppsdfMemory();  break;
			case 'epqadf' : self::startMysqlEpqadfMemory(); break;
			case 'ksdf' : self::startMysqlKsdfMemory(); break;
			case 'spmdf' : self::startMysqlSpmdfMemory(); break;
		}
		
	}
	/**
	public $TH;
	public $XZ;
	public $DO;
	public $CS;
	public $SY;
	public $SP;
	public $SA;
	public $WB;
	public $RE;
	public $SO;
	public $SC;
	public $PO;
	public $GI;
	public $CM;
	public $AC;
	public $AI;
	public $IE;
	public $PY;
	public $FX;
	public $FE;
	 */
	private static function startMysqlCpidfMemory(){
		#先检测内存中是否存在cpidf_memory
		$cpidf_first = CpidfMemory::findFirst();
		if(isset($cpidf_first->TH)){
			echo 'already';
			return true;
		}else{
		     try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$cpidf_data = Cpidf::find();
				foreach($cpidf_data as $cpidf_record ){
					$cpidf_memory = new CpidfMemory();
					$cpidf_memory->TH = $cpidf_record->TH;
					$cpidf_memory->XZ = $cpidf_record->XZ;
					$cpidf_memory->AC = $cpidf_record->AC;
					$cpidf_memory->AI = $cpidf_record->AI;
					$cpidf_memory->CM = $cpidf_record->CM;
					$cpidf_memory->CS = $cpidf_record->CS;
					$cpidf_memory->DO = $cpidf_record->DO;
					$cpidf_memory->FE = $cpidf_record->FE;
					$cpidf_memory->GI = $cpidf_record->GI;
					$cpidf_memory->IE = $cpidf_record->IE;
					$cpidf_memory->PO = $cpidf_record->PO;
					$cpidf_memory->PY = $cpidf_record->PY;
					$cpidf_memory->RE = $cpidf_record->RE;
					$cpidf_memory->SA = $cpidf_record->SA;
					$cpidf_memory->SO = $cpidf_record->SO;
					$cpidf_memory->SP = $cpidf_record->SP;
					$cpidf_memory->SY = $cpidf_record->SY;
					$cpidf_memory->WB = $cpidf_record->WB;
					if( $cpidf_memory->create() == false) {
						unset($cpidf_data);
						$transaction->rollback("CPIDF DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				$transaction->commit();
				echo 'inserted';
				return true;
		   		}catch (TxFailed $e) {
    				throw new Exception("Failed, reason: ".$e->getMessage());
    			}	
		}
	}
	private static function startMysqlEppsdfMemory(){
		
	}
	private static function startMysqlEpqadfMemory(){
		
	}
	private static function startMysqlKsdfMemory(){
		
	}
	private static function startMysqlSpmdfMemory(){
		
	}
}