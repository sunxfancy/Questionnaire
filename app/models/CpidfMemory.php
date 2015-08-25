<?php

class CpidfMemory extends \Phalcon\Mvc\Model{
	
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
	
	public static function getRecord($th, $xz){
		$record =  self::findFirst(
			array(
			"TH = :th: AND XZ = :xz:",
			'bind' =>array('th'=>$th, 'xz'=>$xz)
		)
		);	
		$rtn_array = array();	
		if(isset($record->DO)&& $record->DO == 1 ){
			$rtn_array[] = 'do';
		}
		if(isset($record->CS)&& $record->CS == 1 ){
			$rtn_array[] = 'cs';
		}
		if(isset($record->SY)&& $record->SY == 1 ){
			$rtn_array[] = 'sy';
		}
		if(isset($record->SP)&& $record->SP == 1 ){
			$rtn_array[] = 'sp';
		}
		if(isset($record->SA)&& $record->SA == 1 ){
			$rtn_array[] = 'sa';
		}
		if(isset($record->WB)&& $record->WB == 1 ){
			$rtn_array[] = 'wb';
		}
		if(isset($record->RE)&& $record->RE == 1 ){
			$rtn_array[] = 're';
		}
		if(isset($record->SO)&& $record->SO == 1 ){
			$rtn_array[] = 'so';
		}
		if(isset($record->SC)&& $record->SC == 1 ){
			$rtn_array[] = 'sc';
		}
		if(isset($record->PO)&& $record->PO == 1 ){
			$rtn_array[] = 'po';
		}
		if(isset($record->GI)&& $record->GI == 1 ){
			$rtn_array[] = 'gi';
		}
		if(isset($record->CM)&& $record->CM == 1 ){
			$rtn_array[] = 'cm';
		}
		if(isset($record->AC)&& $record->AC == 1 ){
			$rtn_array[] = 'ac';
		}
		if(isset($record->AI)&& $record->AI == 1 ){
			$rtn_array[] = 'ai';
		}
		if(isset($record->IE)&& $record->IE == 1 ){
			$rtn_array[] = 'ie';
		}
		if(isset($record->PY)&& $record->PY == 1 ){
			$rtn_array[] = 'py';
		}
		if(isset($record->FX)&& $record->FX == 1 ){
			$rtn_array[] = 'fx';
		}
		if(isset($record->FE)&& $record->FE == 1 ){
			$rtn_array[] = 'fe';
		}
		
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}
}