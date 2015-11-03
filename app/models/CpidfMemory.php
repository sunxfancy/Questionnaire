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
		if(!isset($record->TH)){
			throw new Exception('Not found the record-Cpidf-'.'-th-'.$th.'-xz-'.$xz);
		}
		$rtn_array = array();	
		if( $record->DO == 1 ){
			$rtn_array[] = 'do';
		}
		if( $record->CS == 1 ){
			$rtn_array[] = 'cs';
		}
		if( $record->SY == 1 ){
			$rtn_array[] = 'sy';
		}
		if( $record->SP == 1 ){
			$rtn_array[] = 'sp';
		}
		if( $record->SA == 1 ){
			$rtn_array[] = 'sa';
		}
		if( $record->WB == 1 ){
			$rtn_array[] = 'wb';
		}
		if( $record->RE == 1 ){
			$rtn_array[] = 're';
		}
		if( $record->SO == 1 ){
			$rtn_array[] = 'so';
		}
		if( $record->SC == 1 ){
			$rtn_array[] = 'sc';
		}
		if( $record->PO == 1 ){
			$rtn_array[] = 'po';
		}
		if( $record->GI == 1 ){
			$rtn_array[] = 'gi';
		}
		if( $record->CM == 1 ){
			$rtn_array[] = 'cm';
		}
		if( $record->AC == 1 ){
			$rtn_array[] = 'ac';
		}
		if( $record->AI == 1 ){
			$rtn_array[] = 'ai';
		}
		if( $record->IE == 1 ){
			$rtn_array[] = 'ie';
		}
		if( $record->PY == 1 ){
			$rtn_array[] = 'py';
		}
		if( $record->FX == 1 ){
			$rtn_array[] = 'fx';
		}
		if( $record->FE == 1 ){
			$rtn_array[] = 'fe';
		}
		
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}
}