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
		if(isset($record->DO)&&!empty($record->DO)&&$record->DO!=0){
			$rtn_array[] = 'do';
		}
		if(isset($record->CS)&&!empty($record->CS)&&$record->CS!=0){
			$rtn_array[] = 'cs';
		}
		if(isset($record->SY)&&!empty($record->SY)&&$record->SY!=0){
			$rtn_array[] = 'sy';
		}
		if(isset($record->SP)&&!empty($record->SP)&&$record->SP!=0){
			$rtn_array[] = 'sp';
		}
		if(isset($record->SA)&&!empty($record->SA)&&$record->SA!=0){
			$rtn_array[] = 'sa';
		}
		if(isset($record->WB)&&!empty($record->WB)&&$record->WB!=0){
			$rtn_array[] = 'wb';
		}
		if(isset($record->RE)&&!empty($record->RE)&&$record->RE!=0){
			$rtn_array[] = 're';
		}
		if(isset($record->SO)&&!empty($record->SO)&&$record->SO!=0){
			$rtn_array[] = 'so';
		}
		if(isset($record->SC)&&!empty($record->SC)&&$record->SC!=0){
			$rtn_array[] = 'sc';
		}
		if(isset($record->PO)&&!empty($record->PO)&&$record->PO!=0){
			$rtn_array[] = 'po';
		}
		if(isset($record->GI)&&!empty($record->GI)&&$record->GI!=0){
			$rtn_array[] = 'gi';
		}
		if(isset($record->CM)&&!empty($record->CM)&&$record->CM!=0){
			$rtn_array[] = 'cm';
		}
		if(isset($record->AC)&&!empty($record->AC)&&$record->AC!=0){
			$rtn_array[] = 'ac';
		}
		if(isset($record->AI)&&!empty($record->AI)&&$record->AI!=0){
			$rtn_array[] = 'ai';
		}
		if(isset($record->IE)&&!empty($record->IE)&&$record->IE!=0){
			$rtn_array[] = 'ie';
		}
		if(isset($record->PY)&&!empty($record->PY)&&$record->PY!=0){
			$rtn_array[] = 'py';
		}
		if(isset($record->FX)&&!empty($record->FX)&&$record->FX!=0){
			$rtn_array[] = 'fx';
		}
		if(isset($record->FE)&&!empty($record->FE)&&$record->FE!=0){
			$rtn_array[] = 'fe';
		}
		
		$rtn_str = implode('|',$rtn_array);
		return $rtn_str;
	}
}