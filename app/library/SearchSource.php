<?php

/**
 * 资源获取类
 * 负责托管
 * 所有方法，如果不传入参数，则**默认启用缓存**
 * 传入参数，则直接查询数据库，返回相应结果
 */
class SearchSource
{
	private $project;
	private $modules;
	private $indexs;
	private $factors;
	private $questions;

	private $project_id;
	private $modules_id;
	private $indexs_name;
	private $factors_name;
	private $questions_martix;
	
	function __construct($project_id)
	{
		$this->project_id = $project_id;
	}

	public function getProjectId() {
		return $this->project_id;
	}

	public function getProject($project_id = null){
		if ($project_id)
			return Project::findFirst($project_id);
		else
			if ($this->project == null) 
				$this->project = $this->getProject($this->project_id);
			return $this->project;
	}

	public function getModulesId($project_id = null)
	{	
		if ($project_id) {
			$pmrels = Pmrel::find(array(
				"project_id = ?0",
				"bind" => array($project_id)
			));
			$modules_id = array();
			foreach ($pmrels as $pmrel) {
				$modules_id[] = $pmrel->module_id;
			}
			return $modules_id;
		} else {
			if ($this->modules_id == null) 
				$this->modules_id = $this->getModulesId($this->project_id);
			return $this->modules_id;
		}
	}

	public function getModules($project_id = null){
		if ($project_id){
			$module_ids = $this->getModulesId($project_id);
			$modules = array();
			$mods = Module::findByIds($module_ids);
			foreach ($mods as $mod) {
				$modules[$mod->name] = $mod; 
			}
			return $modules;
		} else {
			if ($this->modules == null)
				$this->modules = $this->getModules($this->project_id);
			return $this->modules;
		}
	}

	public function getIndexsName($modules = null){
		if ($modules) {
			return $this->baseFindChildren($modules, $modules, 'Module');
		} else {
			if ($this->indexs_name == null) 
				$this->indexs_name = $this->getIndexsName($this->getModules());
			return $this->indexs_name;
		}
	}

	public function getIndexs($modules = null)
	{
		if ($modules) {
			return $this->getObjsByName('Index', $this->getIndexsName($modules));
		} else {
			if ($this->indexs == null) 
				$this->indexs = $this->getIndexs($this->getModules());
			return $this->indexs;
		}
	}

	public function getFactorsName($indexs = null){
		if ($indexs) {
			return $this->baseFindChildren($indexs, $indexs, 'Index');
		} else {
			if ($this->factors_name == null) 
				$this->factors_name = $this->getFactorsName($this->getIndexs());
			return $this->factors_name;
		}
	}

	public function getFactors($indexs = null)
	{
		if ($indexs) {
			return $this->getObjsByName('Factor', $this->getFactorsName($indexs));
		} else {
			if ($this->factors == null) 
				$this->factors = $this->getFactors($this->getIndexs());
			return $this->factors;
		}
	}

	public function getQuestionsMartix($factors = null)
	{
		if ($factors) {
			return $this->baseFindChildren($factors, $factors, 'Factor');
		} else {
			if ($this->questions_martix == null) 
				$this->questions_martix = $this->getQuestionsMartix($this->getFactors());
			return $this->questions_martix;
		}
	}

	public function getQuestions($factors = null)
	{
		if ($factors) {
			$ans = array();
			$mat = $this->getQuestionsMartix($factors);
			foreach ($mat as $key => $qlist) {
				$ans[$key] = array();
				$qs = Question::findByPapernameAndNums($key, array_values($qlist));
				foreach ($qs as $q) {
					$ans[$key][$q->number] = $q;
				}
			}
			return $ans;
		} else {
			if ($this->questions == null) 
				$this->questions = $this->getQuestions($this->getFactors());
			return $this->questions_martix;
		}
	}

	/**
	 * 批量寻找一组该资源的子元素
	 * @obj_array 要寻找的资源的集合
	 * @all_list 该资源的整体集合
	 * @class_name 该层的名称
	 * @return 资源子元素名的集合
	 */
	function baseFindChildren($obj_array, $all_list, $class_name)
	{
		$ans = array();	$next = array();
		foreach ($obj_array as $obj) {
			$child_list = explode(',', $obj->children);
			$child_type = null;
			if (isset($obj->children_type))
				$child_type = explode(',', $obj->children_type);
			foreach ($child_list as $key => $value) {
				if ($child_type) {
					$ctype = $child_type[$key];
					if ($ctype == 1) {
						if ($class_name == 'Factor')
							$ans[$obj->getPaperName()][$value] = $value;
						else $ans[$value] = $value;
					}
					if ($ctype == 0) $next[$value] = $value;
				} else $ans[$value] = $value;
			}
		}
		if ($class_name != 'Module' && count($next) != 0) {
			$objs = $this->getList($all_list, $next, $class_name);
			$this->combineAns($objs, $ans, $all_list, $class_name);
		} 
		return $ans;
	}

	function combineAns($objs, $ans, $all_list, $class_name)
	{
		$other_ans = $this->baseFindChildren($objs, $all_list, $class_name);
		if ($class_name == 'Factor') {
			foreach ($other_ans as $key => $value) {
				$ans[$key] = $value;
			}
		} else {
			foreach ($other_ans as $key => $qlist) {
				foreach ($qlist as $value) {
					$ans[$key][$value] = $value;
				}
			}
		}
	}

	/**
	 * 在一个列表中查找需要的资源，如果找不到，就从数据库中取
	 * 并且会自动缓存到列表array中，只支持Module、Index和Factor的查找
	 * @array 资源对象列表
	 * @find_list 要找的对象的名字或number集合
	 * @class_name 资源类名
	 * @return 返回全部找到的资源的集合
	 */
	function getList($array, $find_list, $class_name)
	{
		$ans = array();
		$temp = array(); // 不在array中的资源名集合
		foreach ($find_list as $value) {
			if ($array[$value]) {
				$ans[$value] = $array[$value];
			}else {
				$temp[$value] = $value; 
			}
		}
		// 这里需要验证
		$objs = $this->getObjsByName($class_name, $temp);
		foreach ($objs as $obj) {
			$array[$obj->name] = $obj; // 缓存到array中
			$ans[$obj->name] = $obj;
		}
		return $ans;
	}

	function getObjsByName($class_name, $namelist)
	{
		if ($namelist && count($namelist) != 0) {
			$objs = $class_name::find(array(
				'name IN ({names:array})',
				'bind' => array('names' => array_values($namelist))
			));
			$ans = array();
			foreach ($objs as $obj) {
				$ans[$obj->name] = $obj;
			}
			return $ans;
		} else {
			throw new Exception("Name list is null");
		}
	}
}
