<?php
/**
 * @Author: sxf
 * @Date:   2015-08-07 19:21:18
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-10 10:11:24
 */

/**
* 
*/
class TestController extends Base
{
/*	
	public function indexAction($project_id)
	{
		$this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
		$factor_file = __DIR__ . "/../../app/config/factor.json";
		$index_file = __DIR__ . "/../../app/config/index.json";
		$factor_json = $this->loadJson($factor_file);
		$index_json = $this->loadJson($index_file);
		print_r($factor_json);
		print_r($index_json);

		// $this->calans($project_id);
		// foreach ($this->factors as $factor) {
		// 	$factor_config = $factor_json[$factor->name];
		// 	$this->calitem();
		// }
	}

	public function loadJson($filename, $toarray = true)
	{
		$json_string = file_get_contents($filename);
		$json_string = preg_replace('/[\r\n]/', '', $json_string);
		$json = json_decode($json_string, $toarray);
		if ($json == null) {
			echo json_last_error_msg();
			throw new Exception(json_last_error_msg());
		} 
		return $json;
	}

	public function calans($project_id)
	{
		$questions = getQuestions($project_id);
		foreach ($questions as $question) {‘
			$question_anss = $question->getQuestionAnss();
			foreach ($question_anss as $question_ans) {
				// 计算每人每题的基础得分
				// 这样可以得到原始成绩
			}
		}
	}

	public function calfactor($project_id, $factor_json)
	{
		foreach ($this->factors as $factor) {
			$factor_config = $factor_json[$factor->name];
			$this->calitem($factro, )
		}
	}

*/	
	public function indexAction(){
		$paper_id = $this->request->getPost("paper_id","string");
		$questions = $this->getQuestions(1,$paper_id);
		$this->response->setHeader("Content-Type", "text/plain; charset=utf-8");
	}

	// 返回question的列表,同时在类对象中缓存模块、因子、指标等对象组
	public function getQuestions($project_id,$paper_id)
	{
		$project = Pmrel::find(array(
			"project_id = ?1",
			"bind"=>array(1=>$project_id)
			));
		$modules_id_array = $this->getModules($project);
		
		$indexs = Index::find(array(
			'module_id IN ({module_id:array})',
			'bind' => array('module_id' => $modules_id_array)
		));
		$indexs_id_array = $this->getIds($indexs);

		$factor_id_array = $this->getFactor($indexs_id_array);

		$question_id_array = $this->getQlist($factor_id_array,$paper_id);

		return $question_id_array;
	}

	public function getFactor($indexs){
		//$this->view->disable();
		$factor_id = array();
		for ($i=0; $i <sizeof($indexs) ; $i++) { 
			$index = Index::findFirst($indexs[$i]);
			$children = $index->children;
			$childrentype = $index->children_type;
			$children = explode(",",$children );
			$childrentype = explode(",", $childrentype);
			for ($j=0; $j < sizeof($childrentype); $j++) { 
				//0代表index，1代表factor
				if ($childrentype[$j] == "0") {
					$index1 = Index::findFirst(intval($children[$j]));
					$children1 = $index1->children;
					$children1 = explode(",",$children1);
					for ($k=0; $k <sizeof($children1) ; $k++) { 
						$children1[$k] = intval($children1[$k]);
						$factor_id[] = $children1[$k];
					}
				}
				else{	
						$children[$j] = intval($children[$j]);
						$factor_id[] = $children[$j];
				}				
			}
		}
		return explode(",",implode(",",array_unique($factor_id)));
	}

	public function getQlist($factors,$paper_id){
		$this->view->disable();
		$questions_id = array();
		for ($i=0; $i <sizeof($factors) ; $i++) { 			
			$factor = Factor::findFirst($factors[$i]);
			if ($factor->paper_id == $paper_id) {
				$children = $factor->children;
				$childrentype = $factor->children_type;
				$children = explode(",",$children );
				$childrentype = explode(",", $childrentype);
				for ($j=0; $j < sizeof($childrentype); $j++) { 
					//0代表factor，1代表question
					if ($childrentype[$j] == "0") {
						$factor1 = Factor::findFirst($children[$j]);
						$children1 = $factor1->children;
						$children1 = explode(",",$children1);
						for ($k=0; $k <sizeof($children1) ; $k++) { 
							$children1[$k] = intval($children1[$k]);
							$questions_id[] = $children1[$k];						
						}
					}
					else{	
							$children[$j] = intval($children[$j]);
							$questions_id[] = $children[$j];
					}				
				}
			}
		}
		return explode(",",implode(",",array_unique($questions_id)));
	}

	public function getExam($questions){
		$data = new array();
		for ($i=0; $i < sizeof($questions); $i++) { 

			$questions = Question::findFirst($questions[$i]);
			$data[$i]={
				'index':$i,
				'title':$questions->topics,
				'options':$questions->options
			}
		}

	}

	public function getIds($models)
	{
		$id_array = array();
		foreach ($models as $model) {
			$id_array[]  = $model->id;
		}
		return $id_array;
	}

	public function getModules($project)
	{
		$id_array = array();
		foreach ($project as $projects) {
			$id_array[]  = $projects->module_id;
		}
		return $id_array;
	}
/*
	public function calitem($item, $config, $main_config, $name = 'Factor')
	{
		if ($config['isdone']) return;
		if ($name == 'Factor') {
			$jz = $this->calQuestion($config['question']);
			$jz = $this->calQuestionAB($config['questionA'], $config['questionB']);
			$jz = $this->calFactor($config['factor'], $main_config);
		} else {
			$jz = $this->calFactor($config['factor']);
			$jz = $this->calIndex($config['factor'], $main_config);
		}
		$config['isdone'] = true;
	}

	public function calQuestion($questions)
	{
		if ($questions) {
			$jz = array();
			foreach ($questions as $question) {
				$question_anss = QuestionAns::find(array(
					'question_id = ?1 AND examinee_id IN ({examinees_id:array})',
					'bind' => array(1 => $question, 
									'examinees_id'=> $this->getIds($this->examinees))
				));
				foreach ($question_anss as $question_ans) {
					// 对每个人进行统计
					$jz[$question_ans->examinee_id][$question->id] = $question_ans;
					// 然后计算
				}
			}
			return $jz;
		}
	}

	// 这个函数目前不对
	public function calQuestionAB($questionA, $questionB)
	{
		if ($questionA || $questionB) {
			$jz = array();
			foreach ($questions as $question) {
				$question_anss = QuestionAns::find(array(
					'question_id = ?1 AND examinee_id IN ({examinees_id:array})',
					'bind' => array(1 => $question, 
									'examinees_id'=> $this->getIds($this->examinees))
				));
				foreach ($question_anss as $question_ans) {
					// 对每个人进行统计
					$jz[$question_ans->examinee_id][$question->id] = $question_ans;
					// 然后计算
				}
			}
			// 更新得分
			foreach ($jz as $examinee_id => $questions) {
				foreach ($questions as $question_id => $question_ans) {
					if ($question_ans->options == $a_or_b) {
						$question_ans->score = 1;
						$question_ans->save();
					}
				}
			}
			return $jz;
		}
	}

	public function calFactor($factors, $main_config = false)
	{
		if ($factors) {
			foreach ($factors as $factor) {
				// 尝试联表
				$factor_sql = 'SELECT FactorAns.* FROM FactorAns JOIN Factor ON Factor.id = FactorAns.factor_id 
							   WHERE Factor.name = :factor_name: AND examinee_id IN ({examinees_id:array})';

				$query = $this->modelsManager->createQuery($factor_sql);
				$factor_anss = $query->execute(array(
					'factor_name' => $factor->name,
					'examinees_id'=> $this->getIds($this->examinees)));

				foreach ($factor_anss as $factor_ans) {
					// 对每个人进行统计
					$jz[$factor_anss->examinee_id][$question->id] = $factor_anss;
					// 然后计算
				}
			}
		}
	}

	public function getExaminee($project_id)
	{
		$this->examinees = Examinee::find(array(
			'project_id = ?1 AND is_exam_com = 1',
			'bind' => array(1=>$project_id)));
		return $this->examinees;
	}
	*/
}