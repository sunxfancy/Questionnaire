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
						"XH = :th:",
						'bind' => array('th'=>$th)
				)
		);
		if(!isset($record->XH)){
			throw new Exception('Not found the record-Spmdf-'.'-th-'.$th);
		}else{
			if($record->BZ == $xz){
				return 1;
			}else{
				return 0;
			}
		}
	}
}