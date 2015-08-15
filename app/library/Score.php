<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 11:08:59
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-15 16:06:41
 */

/**
* 得分计算类库
*/
class Score
{
	private $ss; // search_source

	public function __construct($project_id)
	{
		$this->ss = new SearchSource($project_id);
	}

	public function Calculate()
	{
		$answers = $this->workAnswers();
		print_r($answers);
		$factor_ans = $this->workFactors($answers);
	}


	public function workFactors($answers)
	{
		foreach ($this->ss->getFactors() as $factor) {
			$this->calFactor($factor, $this->ss->getExaminees(), $answers);
		}
	}


	/**
	 * 计算因子得分
	 * @factor 要计算的因子对象
	 * @examinees 被试人员的对象列表
	 * @return 返回一个人员id为索引的factor_ans表
	 */
	function calFactor($factor, $examinees, $answers)
	{
		if ($this->factor_done[$factor->name]) 
			return $this->factor_done[$factor->name];
		$child_list = explode(',', $factor->children);
		$child_type = explode(',', $factor->children_type);

		$paper_name = $factor->getPaperName();
		$items = $this->factorRes($child_list, $child_type, $examinees, $answers);
		$ans = array();
		foreach ($examinees as $examinee) {
			$eid = $examinee->id;
			$factor_ans = Utils::findFirstAndNew(
				'FactorAns', array(
					'examinee_id = ?0 AND factor_id = ?1',
					'bind' => array($eid, $factor->id)
			));
			$factor_ans->score = $this->doAction($factor->action, $items[$eid]);
			$ans[$eid] = $factor_ans;
		}

		$this->factor_done[$factor->name] = $ans;

		return $ans;
	}

	function doAction($action, $array)
	{
		if (in_array($action, CalFunc::$func_reg)) {
			return CalFunc::$action($array);
		} else {
			if ($this->action_function[$action] == null) {
				$this->action_function[$action] = $this->complie_action($action);
			}
		}
	}

	function complie_action($child_list, $action)
	{
		// 这里需要正则加$符号
		return create_function($child_list, $action);
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
				$factor_ans = $this->calFactor($this->findFactor($child), $examinees, $answers);
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
		$factor_map = $this->ss->getFactors();
		$ans = $factor_map[$factor_name];
		if ($ans) return $ans;
		else {
			$msg = '';
			foreach ($factor_map as $key => $value) {
				$msg .= $key."\n";
			}
			throw new Exception("can not find factor [$factor_name] in resource\n$msg");
		}
	}

	// 传入一个answer对象数组, 计算所有人的得分
	function workAnswers()
	{
		$basic_score = new BasicScoreOne();
		$ans = array();
		foreach ($this->ss->getExaminees() as $examinee) {
			try{
				$answers_df = $basic_score->getPapersByExamineeId($examinee->id);
				$ans[$examinee->id] = $this->changeAns($answers_df);
			}catch(Exception $e){
				echo $e;
			}
		}
		return $ans;
	}

	function changeAns($ans_df)
	{
		$ret = array();
		foreach ($ans_df as $ans) {
			$qlist = explode(',', $ans['question_number_list']);
			$slist = explode(',', $ans['score']);
			foreach ($qlist as $key => $qnum) {
				$score = $slist[$key];
				$ret[$ans->paper_name][$qnum] = $score;
			}
		}
		return $ret;
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
			   		if(is_numeric($str1_array[$i]) && preg_match ("/^[a-z]$/", $str2_array[$i])){
			   			#ok
			   		}else{
			   			throw new Exception("The two strings \"$str1\" and \"$str2\" are not appropriate (type)");
			   		}
			   }
			   $rtn = self::arrayMergeKeyToValue($str1_array, $str2_array);
			   return $rtn;
					
			}else if (preg_match ("/^[a-z]$/", $str1_array[0]) ){
				for($i = 0; $i <$count; $i++ ){
					if(is_numeric($str2_array[$i]) && preg_match ("/^[a-z]$/", $str1_array[$i])){
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
	 * 在二维数组中按照第二层的键值来查找对应的数组项后返回 use for 16PF, SCL, EPPS
	 */
	public static function findInTwodemensianalArray($parents, $key, $value){
		foreach ($parents as  $skey => $svalue ){
			if ( $svalue[$key] == $value ){
				return $svalue;
			}
		}
	}
	
	/**
	 * EPQA使用联合主键 TH-XZ
	 * 通过这两个来查找相应的数组项返回 use for EPQA, CPI
	 */
	public static function multidimensinal_search_v2($parents, $needle) {
		foreach ( $parents as $key => $value ){
			$flag = 1;
			foreach( $needle as $skey => $svalue ){
				if($value[$skey] != $svalue){
					if($flag == 1) {
						break;
					}
				}else{
					if($flag == 1){
						$flag = 2;
					}else{
						return $value;
					}
				}
			}
		}
	}
	
	
	
	
	/**
	 * use for EPQA, CPI 返回值数组的读取,并转为字符串
	 * 字符串格式为 name-score
	 */
	public static function readScoreFromArray($array){
		 $rtn_array = array();
		 foreach ($array as $key => $value){
		 	if($key =='TH' || $key == 'XZ'){
		 		continue;
		 	}
		 	if( !empty($value)&&$value !=0 ){
		 		$rtn_array[] = $key;
		 	}
		 }
		 $rtn_str = implode('-',$rtn_array);
		 return $rtn_str;	 
	}
	/**
	 * use for epps 
	 * 根据 A B 选项为不同的因子算分
	 * 
	 */
	public static function readScoreFromArray_v2($array,$choice){
		if($choice == 1){
			return $array['X'];
		}else if ($choice == 2 )
		{
			return $array['Y'];
		}
	}
	
	/**
	 * 标准命名替换 针对name2.xls表
	 */
	public static function reEPQAList($epqa_result_array){
		$rt_array = array(); 
		foreach($epqa_result_array as $value){
		 	switch($value){
		 		case 'E': $rt_array[] = 'epqae';break;
		 		case 'P': $rt_array[] = 'epqap';break;
		 		case 'N': $rt_array[] = 'epqan';break;
		 		case 'L': $rt_array[] = 'epqal';break;
		 		default : $rt_array[]=null;
		 	}
		 }
		 return $rt_array;
		 
	}
	public static function reEPPSList($epps_result_array){
		$rt_array = array();
		foreach($epps_result_array as $value){
			switch($value){
			case 1: $rt_array[] = 'ach'; break;
			case 2: $rt_array[] = 'def'; break;
			case 3: $rt_array[] = 'ord'; break;
			case 4: $rt_array[] = 'exh'; break;
			case 5: $rt_array[] = 'aut'; break;
			case 6: $rt_array[] = 'aff'; break;
			case 7: $rt_array[] = 'int'; break;
			case 8: $rt_array[] = 'suc'; break;
			case 9: $rt_array[] = 'dom'; break;
			case 10: $rt_array[] = 'aba'; break;
			case 11: $rt_array[] = 'nur'; break;
			case 12: $rt_array[] = 'chg'; break;
			case 13: $rt_array[] = 'end'; break;
			case 14: $rt_array[] = 'het'; break;
			case 15: $rt_array[] = 'agg'; break;
			}
		}
		return $rt_array;
	} 
/*
Array
(
    [0] => Array
        (
            [0] => 13
            [1] => end
        )

    [1] => Array
        (
            [0] => 7
            [1] => int
        )

    [2] => Array
        (
            [0] => 3
            [1] => ord
        )

    [3] => Array
        (
            [0] => 1
            [1] => ach
        )

    [4] => Array
        (
            [0] => 12
            [1] => chg
        )

    [5] => Array
        (
            [0] => 10
            [1] => aba
        )

    [6] => Array
        (
            [0] => 9
            [1] => dom
        )

    [7] => Array
        (
            [0] => 6
            [1] => aff
        )

    [8] => Array
        (
            [0] => 2
            [1] => def
        )

    [9] => Array
        (
            [0] => 15
            [1] => agg
        )

    [10] => Array
        (
            [0] => 8
            [1] => suc
        )

    [11] => Array
        (
            [0] => 4
            [1] => exh
        )

    [12] => Array
        (
            [0] => 5
            [1] => aut
        )

    [13] => Array
        (
            [0] => 14
            [1] => het
        )

    [14] => Array
        (
            [0] => 11
            [1] => nur
        )

)


		 */
	
	public static function useforEPPSNumToName(){
		/**
		 * 来自指标-因子-试题-简称.xls
		 */
		$str = "持久需要	13
		省察需要	7
		秩序需要	3
		成就需要	1
		变异需要	12
		谦卑需要	10
		支配需要	9
		亲和需要	6
		顺从需要	2
		攻击需要	15
		求助需要	8
		表现需要	4
		自主需要	5
		异性恋需要	14
		慈善需要	11";
		/**
		 *  来自name2.xls
		 */
		$str2 = "持久需要	end
省察需要	int
秩序需要	ord
成就需要	ach
变异需要	chg
谦卑需要	aba
支配需要	dom
亲和需要	aff
顺从需要	def
攻击需要	agg
求助需要	suc
表现需要	exh
自主需要	aut
异性恋需要	het
慈善需要	nur";
		$str_array = explode("\n", $str);
		$str2_array = explode("\n", $str2);
		$count = count($str_array);
		$result_array =array();
		for($i = 0; $i < $count ; $i ++ ){
			$tmp = array();
			$tmp_num = array();
			$tmp_val = array();
			preg_match('/[0-9]+/',$str_array[$i], $tmp_num);
			preg_match('/[a-z]+/', $str2_array[$i], $tmp_val);
			$tmp[] = $tmp_num[0];
			$tmp[] = $tmp_val[0];
			$result_array[]= $tmp;
		}
		return $result_array;
	}	
}