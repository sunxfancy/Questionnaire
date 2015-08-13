<?php
/**
 * @Author: sxf
 * @Date:   2015-08-11 11:08:59
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-13 10:37:56
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
		$this->paper_ids = $this->getIds($this->papers);

		$examinees = Examinee::getAll($project_id);
		$examinee_ids = $this->getIds($examinees);
		$anss = QuestionAns::getAns($this->paper_ids, $examinee_ids);
		
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

	/**
	 * 对模型数组求id列表, 可以选第二参数为模型的字段名
	 */
	public function getIds($models, $name = 'id')
	{
		$id_array = array();
		foreach ($models as $model) {
			$id_array[]  = $model->$name;
		}
		return $id_array;
	}

	/**
	 * @brief 查询一个对象,若不存在则新建
	 * @return 所查找的对象
	 */
	function findFirstAndNew($classname, $array)
	{
		$obj = $classname::findFirst($array);
		if ($obj == false) {
			$obj = new $classname();
		}
		return $obj;
	}

}