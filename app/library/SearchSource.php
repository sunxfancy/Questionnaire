<?php

/**
 * 资源获取类
 * 负责托管资源在内存中
 * 所有get方法，如果不传入参数，则**默认启用缓存**
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
	
	private $examinees;
	private $examinees_id;
	private $papers;
	private $papers_name;
	private $answers; // 注意，这里是一个三维的表[被试id][试卷名][题号]

	public function __construct($project_id)
	{
		$this->project_id = $project_id;
	}

	public function getExaminees($project_id = null)
	{
		if ($project_id) {
			$exams = Examinee::getAll($project_id);
			$ans = array();
			foreach ($exams as $exam) {
				$ans[$exam->id] = $exam;
			}
			return $ans;
		} else {
			if ($this->examinees == null) 
				$this->examinees = $this->getExaminees($this->project_id);
			return $this->examinees;
		}
	}

	public function getExamineesId($project_id = null)
	{
		if ($project_id) {
			return Utils::getIds($this->getExaminees($project_id));
		} else {
			if ($this->examinees_id == null) 
				$this->examinees_id = $this->getExamineesId($this->project_id);
			return $this->examinees_id;
		}
	}

	public function getPapers()
	{
		if ($this->papers == null) {
			$temp = Paper::find();
			$this->papers = array();
			foreach ($temp as $paper) {
				$this->papers[$paper->id] = $paper;
			}
		}
		return $this->papers;
	}

	public function getPapersName()
	{
		if ($this->papers_name == null) 
			$this->papers_name = Utils::getIds($this->getPapers(), 'name');
		return $this->papers_name;
	}

	public function getAnswers($project_id = null)
	{
		if ($project_id) {
			$eids = $this->getExamineesId($project_id);
			$pids = Utils::getIds($this->getPapers());
			$qans = QuestionAns::getAns($pids, $eids);
			return $this->makeAns($qans);
		} else {
			if ($this->answers == null) 
				$this->answers = $this->getAnswers($this->project_id);
			return $this->answers;
		}
	}

	function makeAns(&$qans)
	{
		$answers = array();
		foreach ($qans as $ans) {
			$qlist = explode('|', $ans->question_number_list);
			$slist = explode('|', $ans->score);
			if (count($qlist) != count($slist)) {
				$msg = "Paper ID: $ans->paper_id\n".
					   "Number: $ans->number\n";
				throw new Exception("question_number_list and score length is not equal\n$msg");
			}
			$pname = $this->getPapers()[$ans->paper_id]->name;
			$examinee_id = $ans->examinee_id;
			foreach ($qlist as $key => $num) {
				$score = $slist[$key];
				$answers[$examinee_id][$pname][$num] = $score;
			}
		}
		return $answers;
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

	public function getIndexsName(&$modules = null){
		if ($modules) {
			return Utils::getIds($this->getIndexs($modules), 'name');
		} else {
			if ($this->indexs_name == null) 
				$this->indexs_name = $this->getIndexsName($this->getModules());
			return $this->indexs_name;
		}
	}

	public function getIndexs(&$modules = null)
	{
		if ($modules) {
			return $this->baseFindChildren($modules, 'Index');
		} else {
			if ($this->indexs == null) 
				$module = $this->getModules();
				$this->indexs = $this->getIndexs($module);
			return $this->indexs;
		}
	}

	public function getFactorsName(&$indexs = null){
		if ($indexs) {
			return Utils::getIds($this->getFactors($indexs), 'name');
		} else {
			if ($this->factors_name == null) 
				$this->factors_name = $this->getFactorsName($this->getIndexs());
			return $this->factors_name;
		}
	}

	public function getFactors(&$indexs = null)
	{
		if ($indexs) {
			return $this->baseFindChildren($indexs, 'Factor');
		} else {
			if ($this->factors == null) 
				$index = $this->getIndexs();
				$this->factors = $this->getFactors($index);
			return $this->factors;
		}
	}

	public function getQuestionsMartix(&$factors = null)
	{
		if ($factors) {
			$array = $this->baseFindChildren($factors, 'Question');
			return $array;
		} else {
			if ($this->questions_martix == null) 
				$this->questions_martix = $this->getQuestionsMartix($this->getFactors());
			return $this->questions_martix;
		}
	}

	public function getQuestions(&$factors = null)
	{
		if ($factors) {
			$ans = array();
			$mat = $this->getQuestionsMartix($factors);
			foreach ($mat as $key => $qlist) {
				$ans[$key] = array();
				$qs = Question::findByPapernameAndNums($key, $qlist);
				foreach ($qs as $q) {
					$ans[$key][$q->number] = $q;
				}
			}
			return $ans;
		} else {
			if ($this->questions == null) 
				$this->questions = $this->getQuestions($this->getFactors());
			return $this->questions;
		}
	}

	/**
	 * 递归寻找一组该资源的子元素
	 * @obj_array 要寻找的资源的集合
	 * @class_name 该层的名称
	 * @find_layer 传入1，表示寻找该层的子元素，传入0，表示寻找该层的平级元素
	 * @return 资源对象，但找题目时返回题目编号矩阵
	 */
	function baseFindChildren(&$obj_array, $class_name)
	{
		$names = $this->findChildren($obj_array, $class_name, 1);
		if ($class_name == 'Question') return $names;
		$ans = array();
		$objs = $this->getObjsByName($class_name, $names);
		$ans = $objs; // 拷贝数组
		 	# code...
		while (count($objs) != 0) 
			$objs = $this->combineAns($objs, $ans, $class_name);
		return $ans;
	}

	/**
	 * 批量寻找一组该资源的子元素
	 * 如果要寻找的是题目，那么将
	 * @obj_array 父层元素集合
	 * @class_name 要寻找的资源类名
	 * @find_layer 传入1，表示寻找该层的子元素，传入0，表示寻找该层的平级元素
	 * @return 资源子元素名的集合
	 */
	function findChildren(&$obj_array, $class_name, $find_layer)
	{
		$ans = array();
		foreach ($obj_array as $obj) {
			if ($obj->children == null) continue;
			$child_list = explode(',', $obj->children);
			$child_type = null;
			if (isset($obj->children_type)) {
				$child_type = explode(',', $obj->children_type);
				if (count($child_list) != count($child_type)) {
					throw new Exception("child_list and child_type length is not equal\n");
				}
			}
			foreach ($child_list as $key => $value) {
				if ($child_type)
					$ctype = $child_type[$key];
				else $ctype = 1;
				if ($ctype == $find_layer) {
					if ($class_name == 'Question' && $ctype == 1)
						$ans[$obj->getPaperName()][$value] = $value;
					else $ans[$value] = $value;
				}
			}
		}
		return $ans;
	}

	/**
	 * 合并找到的结果
	 * @ans 要寻找子元素的对象集合
	 * @all_list 当前的结果集合
	 * @class_name 当前要寻找的资源类名
	 * @return 返回新增的对象集合，同时当前的结果集合中添加元素
	 */
	function combineAns(&$ans, &$all_list, $class_name)
	{
		$other_ans = $this->findChildren($ans, $class_name, 0);
		$temp = array();
		foreach ($other_ans as $name) {
			if ($all_list[$name] == null) {
				echo $name;
				$temp[$name] = $name;
			}
		}
		if (count($temp) != 0) {
			$objs = $this->getObjsByName($class_name, $temp);
			foreach ($objs as $obj) {
				$all_list[$obj->name] = $obj;
			}
			return $objs;
		}
		return array();
	}

	/**
	 * 在一个列表中查找需要的资源，如果找不到，就从数据库中取
	 * 并且会自动缓存到列表array中，只支持Module、Index和Factor的查找
	 * @array 资源对象列表
	 * @find_list 要找的对象的名字或number集合
	 * @class_name 资源类名
	 * @return 返回全部找到的资源的集合
	 */
	function getList(&$array, &$find_list, $class_name)
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
		$objs = array();
		try {
			if (count($temp) != 0)
				$objs = $this->getObjsByName($class_name, $temp);
		} catch (Exception $e) {
			echo $e;
			$msg = "Find_list: ".print_r($find_list, true);
			throw new Exception("getList error\n$msg");
		}

		foreach ($objs as $obj) {
			if ($obj->name == 'spma') print_r($temp);
			$array[$obj->name] = $obj; // 缓存到array中
			$ans[$obj->name] = $obj;
		}
		return $ans;
	}

	function getObjsByName($class_name, &$namelist)
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
			if (count($namelist) != count($ans)) {
				$msg =  "Class: $class_name\n".
						"names: ".print_r($namelist, true);
				$msg .= "Array(\n";
				foreach ($ans as $key => $value) {
					$msg .= '  ';
					$msg .= $key."\n";
				}
				$msg .= ")\n";
				throw new Exception("getObjsByName can not find all resource.\n$msg");
			}
			return $ans;
		} else {
			throw new Exception("Name list is null");
		}
	}

	function printArray($array_name, $fried = 'name')
	{
		$array = $this->$array_name();
		echo $array_name."\n";
		$i = 1;
		foreach ($array as $key => $obj) {
			$out = $obj->$fried;
			echo "  $i.\t[$key] => $out\n";
			$i++;
		}
	}

	public function printQuestions()
	{
		$questions = $this->getQuestions();
		echo "getQuestions\n";
		foreach ($questions as $key => $value) {
			echo "$key\n";
			foreach ($value as $num => $obj) {
				echo "    $num\n";
			}
		}
	}

	public function printAll()
	{
		$this->printArray('getExaminees','number');
		$this->printArray('getModules','children');
		$this->printArray('getIndexs','children');
		$this->printArray('getFactors','children');
		$this->printQuestions();
	}
}


