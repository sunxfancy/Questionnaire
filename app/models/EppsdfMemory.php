<?php
class EppsdfMemory extends \Phalcon\Mvc\Model{

	public $TH;
	public $A;
	public $B;
	
	
	public static function getRecord($th, $xz){
		$record = self::findFirst(
				array(
						"TH = :th:",
						'bind' => array('th'=>$th)
				)
		);
		if(!isset($record->TH)){
			throw new Exception('Not found the record-Eppsdf-'.'-th-'.$th.'-xz-'.$xz);
		}
		$rtn_str = null;
		switch($record->$xz){
		case 1: $rtn_str = 'ach'; break;
		case 2: $rtn_str = 'def'; break;
		case 3: $rtn_str = 'ord'; break;
		case 4: $rtn_str = 'exh'; break;
		case 5: $rtn_str = 'aut'; break;
		case 6: $rtn_str = 'aff'; break;
		case 7: $rtn_str = 'int'; break;
		case 8: $rtn_str = 'suc'; break;
		case 9: $rtn_str = 'dom'; break;
		case 10: $rtn_str = 'aba'; break;
		case 11: $rtn_str = 'nur'; break;
		case 12: $rtn_str = 'chg'; break;
		case 13: $rtn_str = 'end'; break;
		case 14: $rtn_str = 'het'; break;
		case 15: $rtn_str = 'agg'; break;
		default: throw new Exception("Not found the factor_name according to ".$record->$xz);
		}
		return $rtn_str;
	}

}