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
	private $questions_id;
	
	function __construct($project_id)
	{
		$this->project_id = $project_id;
	}

	public function getProject($project_id = null){
		if ($project_id)
			return Project::findFirst($project_id);
		else
			return $this->project;
	}

	public function getModules_id($project_id = null)
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
    		if ($this->modules_id) {
    			return $this->modules_id;
    		} else {
    			$this->modules_id = $this->getModules_id($this->project_id);
    			return $this->modules_id;
    		}
    	}
    }

	public function getModules($project_id = null){
		if ($project_id){
			$module_ids = $this->getModules_id($project_id);
			$modules = array();
			foreach($module_ids as $module_id){
				$modules[] = Module::findFirst($module_id);
			}
			return $modules;
		} else {
			if ($this->modules == null)
				$this->modules = $this->getModules($this->project_id);
			return $this->modules;
		}
	}

	public function getIndexs_name($modules = null){
		if ($modules) {
			return $this->baseFindChildren($modules, $modules, 'Module');
		} else {
			if ($this->indexs_name == null) 
				$this->indexs_name = $this->getIndexs_name($this->getModules());
			return $this->indexs_name;
		}
	}

	public function getIndexs($modules = null)
	{
		if ($modules) {
			return $this->getObjsByName($this->getIndexs_name($modules));
		} else {
			if ($this->indexs == null) 
				$this->indexs = $this->getIndexs($this->getModules());
			return $this->indexs;
		}
	}

	public function getFactors($indexs = null)
	{
		if ($indexs)
			return $this->baseFindChildren($indexs, $indexs, );
	}

	public function getFactors_name($indexs = null){
		if ($indexs) {
			return $this->baseFindChildren($indexs, $indexs, 'Index');
		} else {
			if ($this->factors_name == null) 
				$this->factors_name = $this->getFactors_name($this->getModules());
			return $this->factors_name;
		}
	}



    /**
     * 批量寻找一组该资源的子元素
     * @obj_array 要寻找的资源的集合
     * @all_list 该资源的整体集合
     * @class_name 该层的
     * @return [description]
     */
	function baseFindChildren($obj_array, $all_list, $class_name)
	{
		$ans = array();
		$next = array();
		foreach ($obj_array as $obj) {
			$child_list = explode($obj->children);
			$child_type = null;
			if ($obj->children_type)
				$child_type = explode($obj->children_type);
			foreach ($child_list as $key => $value) {
				$ctype = null;
				if ($child_type) $ctype = $child_type[$key];
				if ($ctype === 0) $ans[$value] = $value;
				if ($ctype === 1) $next[$value] = $value;
			}
		}
		if ($class_name != 'Module')
		$objs = $this->getList($all_list, $next, $class_name);
		foreach ($objs as $obj) {
			$other_ans = $this->baseFindChildren($objs, $all_list, $class_name);
			foreach ($other_ans as $oa) {
				$ans[$oa] = $oa;
			}
		}
		return $ans;
    }

    /**
     * 在一个列表中查找需要的资源，如果找不到，就从数据库中取
     * 并且会自动缓存到列表array中，只支持Module、Index和Factor的查找
     * @array 资源对象列表
     * @find_list 要找的对象的名字或number集合
     * @class_name 资源类名
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
		$objs = $class_name::find(array(
			'name IN ({names:array})',
			'bind' => array('names' => $namelist)
		));
		return $objs;
	}
}
?>