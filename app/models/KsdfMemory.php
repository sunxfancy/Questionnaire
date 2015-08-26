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
		return $record->$xz;
	}
}