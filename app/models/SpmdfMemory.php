<?php
class SpmdfMemory extends  \Phalcon\Mvc\Model {

	/**
	 *
	 * BZ as 标准答案 取值 1 , 2, 3, ,4 ,5 ,6 ,7 ,8,
	 */

	public $BZ;

	/**
	 *
	 *XH as 1 2 3 4 5 6 ... 58 59 60
	 */

	public $XH;
	
	public static function getRecord($th, $xz){
		$record = self::findFirst(
				array(
						"XH = :th: AND BZ = :bz:",
						'bind' => array('th'=>$th, 'bz'=>$xz)
				)
		);
		$rtn_str = null;
		if(isset($record->BZ)){
			$rtn_str = 1;
		}else{
			$rtn_str = 0;
		}
		return $rtn_str;
	}
}