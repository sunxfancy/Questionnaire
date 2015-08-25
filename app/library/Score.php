<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 11:08:59
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-16 16:55:33
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
		$this->factor_done = array();
	}

	/**
	 * 核心计算调用接口
	 */
	public function Calculate()
	{
		$answers = $this->workAnswers();  // 第一层， 由答案转换得分
		$factor_ans = $this->workFactors($answers); // 第二层， 计算因子得分
		// TODO: 第三层， 计算指标得分
	}


	/**
	 * 依次计算列表中的每一个因子
	 */
	public function workFactors($answers)
	{
		$ans = array();
		foreach ($this->ss->getFactors() as $factor) {
			$temp = $this->calFactor($factor, $this->ss->getExaminees(), $answers);
			foreach ($temp as $obj) {
				echo "$obj->factor_id => $obj->score\n";
			}
		}
		return $ans;
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
		if (count($child_list) == 0) return null;
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
			$factor_ans->examinee_id = $eid;
			$factor_ans->factor_id = $factor->id;
			$factor_ans->score = $this->doAction($factor->children, $factor->action, $items[$eid]);
			if (!$factor_ans->save()) {
				foreach ($factor_ans->getMessages() as $msg) {
					throw new Exception($msg);
				}
			}
			$ans[$eid] = $factor_ans;
		}

		$this->factor_done[$factor->name] = $ans;

		return $ans;
	}

	function doAction($children, $action, $array)
	{
		if (in_array($action, CalFunc::$func_reg)) {
			$ans = call_user_func(array('CalFunc',$action), $array);
			return $ans;
		} else {
			if ($this->action_function[$action] == null) {
				$this->action_function[$action] = $this->complie_action($children, $action);
			}
			return call_user_func_array($this->action_function[$action], $array);
		}
	}

	function complie_action($child_list, $action)
	{
		// 这里需要正则加$符号
		$child_list = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', '\$$0', $child_list);
		$action     = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', '\$$0', $action);
		$action = "return $action;";
		return create_function($child_list, $action);
	}

	function factorRes($child_list, $child_type, $examinees, $answers)
	{
		$items = $this->makeItemArray($examinees);
		foreach ($child_list as $key => $child) {
			if ($child == null) {
				throw new Exception("child is null");
			}
			$ctype = $child_type[$key];
			if ($ctype == 1) {
				foreach ($examinees as $examinee) {
					$items[$examinee->id][] = $answers[$examinee->id][$paper_name][$child];
					echo $paper_name;
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
			echo '$factor_map'."\n";
			foreach ($factor_map as $name => $obj) {
				echo "$name\t";
			}
			throw new Exception("can not find factor [$factor_name] in resource\n");
		}
	}

	// 传入一个answer对象数组, 计算所有人的得分
	function workAnswers()
	{
		$basic_score = new BasicScore();
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
			$qlist = explode('|', $ans['question_number_list']);
			$slist = explode('|', $ans['score']);
			foreach ($qlist as $key => $qnum) {
				$score = $slist[$key];
				$ret[$ans['paper_name']][$qnum] = $score;
			}
		}
		return $ret;
	}
	

}