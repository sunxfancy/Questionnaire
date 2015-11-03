<?php

use Phalcon\Mvc\Model\Resultset;

class EpqadfMemory extends \Phalcon\Mvc\Model{

	public $TH;

	public $XZ;

	public $E;

	public $N;

	public $P;

	public $L;
	
	public static function getRecord($th, $xz){
		$record =  self::findFirst(
			array(
			"TH = :th: AND XZ = :xz:",
			'bind' =>array('th'=>$th, 'xz'=>$xz)
		)
		);
		if(!isset($record->TH)){
			throw new Exception('Not found the record-EPQAdf-'.'-th-'.$th.'-xz-'.$xz);
		}
		$rtn_array = array();
		if( $record->E == 1 ){
			$rtn_array[] = 'epqae';
		}
		if( $record->N == 1 ){
			$rtn_array[] = 'epqan';
		}
		if( $record->P == 1 ){
			$rtn_array[] = 'epqap';
		}
		if( $record->L == 1 ){
			$rtn_array[] = 'epqal';
		}
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}
}