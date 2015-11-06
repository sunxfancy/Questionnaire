<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * @usage 题目基础得分计算需要对照的5张得分对照表加载为内存表
	 * @author Wangyaohui
	 * @date 2015-8-25
	 */
class MemoryTable {
	private static $mysql_memory_list = array(
		'cpidf' , 'eppsdf', 'epqadf', 'ksdf','spmdf','cpimd','epqamd','ksmd','spmmd'
	);
	/**
	 * @usage 所有内存表的加载器
	 * @throws Exception
	 * @return boolean
	 */
	public static function loader() {
		foreach(self::$mysql_memory_list as $value){
			self::startMysqlMemoryTable($value);
		}
	}
	
	private static function startMysqlMemoryTable($table_name){
		$table_name = strtolower($table_name);
		if(!in_array($table_name, self::$mysql_memory_list, true)){
			throw new Exception ("There is no memory table for table named $table_name!");
		}
		$state = false;
		switch ($table_name){
			case 'cpidf' : $state = self::startMysqlCpidfMemory();  break;
			case 'eppsdf' : $state = self::startMysqlEppsdfMemory();  break;
			case 'epqadf' :$state = self::startMysqlEpqadfMemory(); break;
			case 'ksdf' : $state = self::startMysqlKsdfMemory(); break;
			case 'spmdf' : $state = self::startMysqlSpmdfMemory(); break;
			case 'cpimd' : $state = self::startMysqlCpimdMemory(); break;
			case 'epqamd' :  $state = self::startMysqlEpqamdMemory(); break;
			case 'ksmd':  $state = self::startMysqlKsmdMemory(); break;
			case 'spmmd' :  $state = self::startMysqlSpmmdMemory(); break;
			
		}
		return $state;	
	}
	/**
	 * public $TH;
	 * public $XZ;
	 * public $DO;
	 * public $CS;
	 * public $SY;
	 * public $SP;
	 * public $SA;
	 * public $WB;
	 * public $RE;
	 * public $SO;
	 * public $SC;
	 * public $PO;
	 * public $GI;
	 * public $CM;
	 * public $AC;
	 * public $AI;
	 * public $IE;
	 * public $PY;
	 * public $FX;
	 * public $FE;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlCpidfMemory(){
		$cpidf_first = CpidfMemory::findFirst();
		if(isset($cpidf_first->TH)){
			return true;
		}else{
		     try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$cpidf_data = Cpidf::find();
				foreach($cpidf_data as $cpidf_record ){
					$cpidf_memory = new CpidfMemory();
					$cpidf_memory->setTransaction($transaction);
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
					#2015-8-22 发现未添加项
					$cpidf_memory->SC = $cpidf_record->SC;
					$cpidf_memory->FX = $cpidf_record->FX;
					if( $cpidf_memory->create() == false) {
						unset($cpidf_data);
						$transaction->rollback("CPIDF DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				$transaction->commit();
				return true;
		   		}catch (TxFailed $e) {
    				throw new Exception("Failed, reason: ".$e->getMessage());
    			}	
		}
	}
	/**
	 * EPPSDF:
	 * public $TH;
	 * public $A;
	 * public $B;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlEppsdfMemory(){
		$eppsdf_first = EppsdfMemory::findFirst();
		if(isset($eppsdf_first->TH)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$eppsdf_data = Eppsdf::find();
				foreach($eppsdf_data as $eppsdf_record ){
					$eppsdf_memory = new EppsdfMemory();
					$eppsdf_memory->setTransaction($transaction);
					$eppsdf_memory->TH = $eppsdf_record->TH;
					$eppsdf_memory->A  = $eppsdf_record->A;
					$eppsdf_memory->B  = $eppsdf_record->B;
					if( $eppsdf_memory->create() == false) {
						unset($eppsdf_data);
						$transaction->rollback("EPPSDF DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}	
	}
	/**
	 * public $TH;
	 * public $XZ;
	 * public $E;
	 * public $N;
	 * public $P;
	 * public $L;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlEpqadfMemory(){
		$epqadf_first = EpqadfMemory::findFirst();
		if(isset($epqadf_first->TH)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$epqadf_data = Epqadf::find();
				foreach($epqadf_data as $epqadf_record ){
					$epqadf_memory = new EpqadfMemory();
					$epqadf_memory->setTransaction($transaction);
					$epqadf_memory->TH = $epqadf_record->TH;
					$epqadf_memory->XZ = $epqadf_record->XZ;
					$epqadf_memory->E = $epqadf_record->E;
					$epqadf_memory->N = $epqadf_record->N;
					$epqadf_memory->P = $epqadf_record->P;
					$epqadf_memory->L = $epqadf_record->L;
					if( $epqadf_memory->create() == false) {
						unset($epqadf_data);
						$transaction->rollback("EPQADF DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}	
	}
	/**
	 * public $TH;
	 * public $A;
	 * public $B;
	 * public $C;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlKsdfMemory(){
		$ksdf_first = KsdfMemory::findFirst();
		if(isset($ksdf_first->TH)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$ksdf_data = Ksdf::find();
				foreach($ksdf_data as $ksdf_record ){
					$ksdf_memory = new KsdfMemory();
					$ksdf_memory->setTransaction($transaction);
					$ksdf_memory->TH = $ksdf_record->TH;
					$ksdf_memory->A  = $ksdf_record->A;
					$ksdf_memory->B  = $ksdf_record->B;
					$ksdf_memory->C  = $ksdf_record->C;
					if( $ksdf_memory->create() == false) {
						unset($ksdf_data);
						$transaction->rollback("KSDF DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				if(isset($ksdf_data)){
					unset($ksdf_data);
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}
	}
	/**
	 * 	public $BZ;
	 *	public $XH;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlSpmdfMemory(){
		$spmdf_first = SpmdfMemory::findFirst();
		if(isset($spmdf_first->XH)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$spmdf_data = Spmdf::find();
				foreach($spmdf_data as $spmdf_record ){
					$spmdf_memory = new SpmdfMemory();
					$spmdf_memory->setTransaction($transaction);
					$spmdf_memory->XH = $spmdf_record->XH;
					$spmdf_memory->BZ = $spmdf_record->BZ;
					if( $spmdf_memory->create() == false) {
						unset($spmdf_data);
						$transaction->rollback("SPMDF DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				if(isset($ksdf_data)){
					unset($ksdf_data);
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}
	}
	/**
	 * public $DM;
	 * public $YZ;
	 * public $M;
	 * public $SD;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlCpimdMemory(){
		$cpimd_first = CpimdMemory::findFirst();
		if(isset($cpimd_first->DM)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$cpimd_data = Cpimd::find();
				foreach($cpimd_data as $cpimd_record ){
					$cpimd_memory = new CpimdMemory();
					$cpimd_memory->setTransaction($transaction);
					$cpimd_memory->DM = $cpimd_record->DM;
					$cpimd_memory->YZ = $cpimd_record->YZ;
					$cpimd_memory->M  = $cpimd_record->M;
					$cpimd_memory->SD = $cpimd_record->SD;
					if( $cpimd_memory->create() == false) {
						unset($cpimd_data);
						$transaction->rollback("CPIMD DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				if(isset($cpimd_data)){
					unset($cpimd_data);
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}
	}
	/**
	 * public $DSEX;
	 * public $EAGEL;
	 * public $DAGEH;
	 * public $EM;
	 * public $ESD;
	 * public $NM;
	 * public $NSD;
	 * public $PM;
	 * public $PSD;
	 * public $LM;
	 * public $LSD;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlEpqamdMemory(){
		$epqamd_first = EpqamdMemory::findFirst();
		if(isset($epqamd_first->DSEX)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$epqamd_data = Epqamd::find();
				foreach($epqamd_data as $epqamd_record ){
					$epqamd_memory = new EpqamdMemory();
					$epqamd_memory -> setTransaction($transaction);
					$epqamd_memory->DSEX = $epqamd_record->DSEX;
					$epqamd_memory->DAGEL = $epqamd_record->DAGEL;
					$epqamd_memory->DAGEH  = $epqamd_record->DAGEH;
					$epqamd_memory->EM = $epqamd_record->EM;
					$epqamd_memory->ESD = $epqamd_record->ESD;
					$epqamd_memory->NM = $epqamd_record->NM;
					$epqamd_memory->NSD = $epqamd_record->NSD;
					$epqamd_memory->PM = $epqamd_record->PM;
					$epqamd_memory->PSD = $epqamd_record->PSD;
					$epqamd_memory->LM = $epqamd_record->LM;
					$epqamd_memory->LSD = $epqamd_record->LSD;			
					if( $epqamd_memory->create() == false) {
						unset($epqamd_data);
						$transaction->rollback("EPQAMD DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				if(isset($epqamd_data)){
					unset($epqamd_data);
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}
	}
	/**
	 * public $DM;
	 * public $YZ;
	 * public $QSF;
	 * public $ZZF;
	 * public $BZF;
	 * @throws Exception
	 * @return boolean
	 */
	private static function startMysqlKsmdMemory(){
		$ksmd_first = KsmdMemory::findFirst();
		if(isset($ksmd_first->YZ)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$ksmd_data = Ksmd::find();
				foreach($ksmd_data as $ksmd_record ){
					$ksmd_memory = new KsmdMemory();
					$ksmd_memory->setTransaction($transaction);
					$ksmd_memory->DM = $ksmd_record->DM;
					$ksmd_memory->YZ = $ksmd_record->YZ;
					$ksmd_memory->QSF  = $ksmd_record->QSF;
					$ksmd_memory->ZZF = $ksmd_record->ZZF;
					$ksmd_memory->BZF = $ksmd_record->BZF;
					if( $ksmd_memory->create() == false) {
						unset($ksmd_data);
						$transaction->rollback("KSMD DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				if(isset($ksmd_data)){
					unset($ksmd_data);
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}
		
	}
	/**
	 * public $NLL;
	 * public $NLH;
	 * public $B95;
	 * public $B90;
	 * public $B75;
	 * public $B50;
	 * public $B25;
	 * public $B10;
	 * public $B5;
	 */
	private static function startMysqlSpmmdMemory(){
		$spmmd_first = SpmmdMemory::findFirst();
		if(isset($spmmd_first->NLL)){
			return true;
		}else{
			try {
				$manager     = new TxManager();
				$transaction = $manager->get();
				$spmmd_data = Spmmd::find();
				foreach($spmmd_data as $spmmd_record ){
					$spmmd_memory = new SpmmdMemory();
					$spmmd_memory->setTransaction($transaction);
					$spmmd_memory->NLL = $spmmd_record->NLL;
					$spmmd_memory->NLH = $spmmd_record->NLH;
					$spmmd_memory->B95 = $spmmd_record->B95;
					$spmmd_memory->B90 = $spmmd_record->B90;
					$spmmd_memory->B75 = $spmmd_record->B75;
					$spmmd_memory->B50 = $spmmd_record->B50;
					$spmmd_memory->B25 = $spmmd_record->B25;
					$spmmd_memory->B10 = $spmmd_record->B10;
					$spmmd_memory->B5  = $spmmd_record->B5;
					if( $spmmd_memory->create() == false) {
						unset($ksmd_data);
						$transaction->rollback("SPMMD DATA INSERT INTO MEMORY TABLE ERROR!");
					}
				}
				if(isset($spmmd_data)){
					unset($spmmd_data);
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception("Failed, reason: ".$e->getMessage());
			}
		}	
	}
}