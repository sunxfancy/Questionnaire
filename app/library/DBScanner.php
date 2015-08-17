<?php
	/**
	 * use for developer to scanner dababase
	 * @author Wangyaohui
	 *
	 */
class DBScanner {
	
	#获取Paper表中的数据
	public static function getPaperInfo(){
		$paper_object_array = Paper::find();
		$rtn_array = array();
		foreach ($paper_object_array as $paper_object){
			$tmp_array = array();
			$tmp_array['id'] = $paper_object->id;
			$tmp_array['description'] = $paper_object->description;
			$tmp_array['name'] = $paper_object->name;
			$rtn_array[] = $tmp_array;
		}
		return $rtn_array;
		
	}
}