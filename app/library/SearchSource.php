<?php

/**
 * 资源获取类
 * 负责托管
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
	private $indexs_id;
	private $factors_id;
	private $questions_id;
	
	function __construct($project_id)
	{
		$this->project_id=$project_id;
	}

	public function getProject($project_id=null){
		if($project_id){
			$project_l = Project::findFirst($project_id);
        	return $project_l;
		}else{
			if($this->project){
				return $this->project;
			}else{
				return $this->getProject($this->project_id);
			}
			}
	}

	public function getModules_id($project_id=null)
    {	
    	if($project_id){
    		$pmrels = Pmrel::find(array(
            "project_id = ?1",
            "bind"=>array(1=>$project_id)
            ));
	    	$modules_id=array();
	        foreach ($pmrels as $pmrel) {
	            $modules_id[] =$pmrel->module_id;
	        }
	        return $modules_id;
    	}else{
    		if($this->modules_id){
    			return $this->modules_id;
    		}else{
    			$this->modules_id = $this->getModules_id($this->project_id);
    			return $this->modules_id;
    		}
    	}
    }

	public function getModules($project_id=null){
		if($project_id){
			$module_ids = $this->getModules_id($project_id);
			$modules = array();
			foreach($module_ids as $module_id){
				$modules[]=Module::findFirst($module_id);
			}
			return $modules;
		}else{
			if($this->modules){
				return $this->modules;
			}else{
				$this->modules = $this->getModules($this->project_id);
				return $this->modules;
			}
		}
	}

    public function getIndexs($modules){

    }

	function baseFindChildren($obj_array, $all_list)
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
				if ($ctype === 0) {
					$ans[$value] = $value;
				}
				if ($ctype === 1) {
					$next[$value] = $value;
				}
			}
		}
		$this->getList
    }

    /**
     * 在一个列表中查找需要的资源，如果找不到，就从数据库中取
     * 并且会自动缓存到列表array中，只支持Index和Factor的查找
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
    	$objs = $class_name::find(array(
    		'name IN ({names:array})',
    		'bind' => array('names' => $temp)
    	));
    	foreach ($objs as $obj) {
    		$array[$obj->name] = $obj; // 缓存到array中
    		$ans[$obj->name] = $obj;
    	}
    }
}
?>