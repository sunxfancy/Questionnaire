<?php
class KsdfMemory extends \Phalcon\Mvc\Model {
	/**
	 * TH as
	 */
	public $TH;

	/**
	 * A B C
	 */
	public $A;

	public $B;

	public $C;
	
	public static function getRecord($th, $xz){
		$record = self::findFirst(
		array(
			"TH = :th:",
			'bind' => array('th'=>$th)
		)
		);
		if(!isset($record->TH)){
			throw new Exception('Not found the record-Ksdf-'.'-th-'.$th.'-xz-'.$xz);
		}
		return $record->$xz;
	}
}