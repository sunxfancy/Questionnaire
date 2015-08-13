<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 11:08:59
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-13 17:01:05
 */

/**
* 得分计算类库
*/
class Score
{
	
	public function __construct()
	{
	}

	public function Calculate($project_id)
	{
		$this->papers_name = array('ks','scl','spm');
		$this->papers = Paper::findByNames($papers_name);
		$this->paper_ids = Utils::getIds($this->papers);

		$this->examinees = Examinee::getAll($project_id);
		$this->examinee_ids = Utils::getIds($this->examinees);
		$anss = QuestionAns::getAns($this->paper_ids, $this->examinee_ids);
		
	}

	/**
	 * 计算因子得分
	 * @factor 要计算的因子对象
	 * @examinees 被试人员的对象列表
	 */
	function calFactor($factor, $examinees, $answers)
	{
		if ($this->factor_done[$factor->name]) 
			return $this->factor_done[$factor->name];
		$child_list = explode($factor->children);
		$child_type = explode($factor->children_type);

		$paper_name = $factor->getPaperName();
		$items = $this->factorRes($child_list, $child_type, $examinees, $answers);
		$ans = array();
		foreach ($examinees as $examinee) {
			$factor_ans = Utils::findFirstAndNew(
				'FactorAns', array(
					'examinee_id = ?0 AND factor_id = ?1',
					'bind' => array($examinee->id, $factor->id)
			));
			
			$ans[$examinee->id] = $factor_ans;
		}

		$this->factor_done[$factor->name] = $ans;

		return $ans;
	}

	function factorRes($child_list, $child_type, $examinees, $answers)
	{
		$items = $this->makeItemArray($examinees);
		foreach ($child_list as $key => $child) {
			$ctype = $child_type[$key];
			if ($ctype == 1) {
				foreach ($examinees as $examinee) {
					$items[$examinee->id][] = $answers[$examinee->id][$paper_name][$child];
				}
			} else {
				$factor_ans = $this->calFactor(findFactor($child));
				foreach ($examinees as $examinee) {
					$items[$examinee->id][] = $factor_ans[$examinee->id]->ans_score;
				}
			}
		}
		return $items;
	}

	function makeItemArray($examinees)
	{
		$items = array();
		foreach ($examinees as $examinee) {
			$items[$examinee->id] = array();
		}
		return $items;
	}

	function findFactor($factor_name)
	{
		return $this->factors[$factor_name];
	}

	// 传入一个answer对象数组, 计算所有人的得分
	function calAns($answers, $examinees)
	{

	}
	
	/**
	 * 解析题号(|)字符串与选项(|)字符串，return array(题号=>选项)
	 * 题号 数值型
	 * 选项 字符型
	 */
	public static function strDivideToArray($str1, $str2){
		$str1_array = explode('|', $str1);
		$str2_array = explode('|', $str2);
		if( count($str1_array) != count($str2_array)){
			throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (count)");
		}else {
			$count = count($str1_array);
			if(is_numeric($str1_array[0])){
			   for($i = 0; $i <$count; $i++ ){
			   		if(is_numeric($str1_array[$i]) && preg_match ("/^[A-Z]$/", $str2_array[$i])){
			   			#ok
			   		}else{
			   			throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
			   		}
			   }
			   $rtn = self::arrayMergeKeyToValue($str1_array, $str2_array);
			   return $rtn;
					
			}else if (preg_match ("/^[A-Z]$/", $str1_array[0]) ){
				for($i = 0; $i <$count; $i++ ){
					if(is_numeric($str2_array[$i]) && preg_match ("/^[A-Z]$/", $str1_array[$i])){
						#ok
					}else{
						throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
					}
				}
				$rtn = self::arrayMergeKeyToValue($str2_array, $str1_array);
				return $rtn;
			}else {
				throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
			}
		}
	}
	/**
	 * 两个数组合并
	 * @param unknown $str1_array
	 * @param unknown $str2_array
	 * @return multitype:multitype:unknown
	 */
	public static function arrayMergeKeyToValue($str1_array, $str2_array){
		$array_count = count($str1_array);
		$array_return = array();
		for($i = 0; $i < $array_count; $i++ ){
			$array_set = array();
			$array_set['number'] = $str1_array[$i];
			$array_set['option'] = $str2_array[$i];
			$array_return[] = $array_set;
			$array_set = null;
		}
		return $array_return;
	}
	/**
	 * 比较一个一位数组是否在一个二维数组中 use for SPM
	 * parents   
	 * 
	 */
	public static function multidimensinal_search($parents, $needle) {
		foreach ( $parents as $key => $value ){
			$flag = 1;
			foreach( $needle as $skey => $svalue ){
				if($value[$skey] != $svalue){
					if($flag == 1) {
						break;
					}else{
						return false;
					}
				}else{
					if($flag == 1){
						$flag = 2;
					}else{
						return true;
					}
				}
			}
		}
	}
	/**
	 * 在二维数组中按照第二层的键值来查找对应的数组项后返回 use for 16PF
	 */
	public static function findInTwodemensianalArray($parents, $key, $value){
		foreach ($parents as  $skey => $svalue ){
			if ( $svalue[$key] == $value ){
				return $svalue;
			}
		}
	}
}