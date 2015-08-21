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
		$rtn_array = array();
		if(isset($record->E)&&!empty($record->E)&&$record->E!=0){
			$rtn_array[] = 'epqae';
		}
		if(isset($record->N)&&!empty($record->N)&&$record->N!=0){
			$rtn_array[] = 'epqan';
		}
		if(isset($record->P)&&!empty($record->P)&&$record->P!=0){
			$rtn_array[] = 'epqap';
		}
		if(isset($record->L)&&!empty($record->L)&&$record->L!=0){
			$rtn_array[] = 'epqal';
		}
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}
}