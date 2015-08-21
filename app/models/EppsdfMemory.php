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
		$rtn_array = array();
		if(isset($record->$xz)){
			switch($record->$xz){
			case 1: $rtn_array[] = 'ach'; break;
			case 2: $rtn_array[] = 'def'; break;
			case 3: $rtn_array[] = 'ord'; break;
			case 4: $rtn_array[] = 'exh'; break;
			case 5: $rtn_array[] = 'aut'; break;
			case 6: $rtn_array[] = 'aff'; break;
			case 7: $rtn_array[] = 'int'; break;
			case 8: $rtn_array[] = 'suc'; break;
			case 9: $rtn_array[] = 'dom'; break;
			case 10: $rtn_array[] = 'aba'; break;
			case 11: $rtn_array[] = 'nur'; break;
			case 12: $rtn_array[] = 'chg'; break;
			case 13: $rtn_array[] = 'end'; break;
			case 14: $rtn_array[] = 'het'; break;
			case 15: $rtn_array[] = 'agg'; break;
			}
		}
		$rtn_str = implode('-',$rtn_array);
		return $rtn_str;
	}

}