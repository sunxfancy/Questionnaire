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
		$rtn_array = array();
		if(isset($record->$xz)){
			$rtn_array[] = $record->$xz;
		}
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}
}