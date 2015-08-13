<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 11:08:59
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-13 10:49:26
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
	function calFactor($factor, $examinees)
	{
		$child_list = explode($factor->children);
		$child_type = explode($factor->children_type);

		foreach ($examinees as $examinee) {
			foreach ($child_list as $key => $child) {
				$ctype = $child_type[$key];
				
			}
		}
		
	}

	// 传入一个answer对象数组, 计算所有人的得分
	function calAns($answers, $examinees)
	{

	}

}