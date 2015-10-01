<?php

class ReportData
{
	//由指标得分的平均分，判定优良中差
	public static function getLevel($examinee_id){
		$index_ans = IndexAns::find(array(
			'examinee_id'=>1,
			'bind'=>array(1=>$examinee_id)));
		$score = 0;
		$count = 0;
		foreach ($index_ans as $index) {
			$score += $index->score;
			$count++;
		}
		$score_avg = $score / $count;
		if ($score_avg > 5.8) {
			$level = "优";
		}else if ($score_avg > 5.3) {
			$level = "良";
		}else if ($score_avg > 5.0) {
			$level = "中";
		}else{
			$level = "差";
		}
		return $level;
	}
	
	//获取综合统计分析
	public static function getComprehensive($examinee_id){
		$project_id = Examinee::findFirst($examinee_id)->project_id;
		$module = ProjectDetail::findFirst($project_id)->module_names;
		$module_selected = array();
		$module_selected = explode(",",$module);
		$module_array = array("职业心理"=>'mk_xljk',"职业素质"=>'mk_szjg',"三商与身体"=>'mk_ztjg',"职业能力"=>'mk_nljg');
		$module_exist = array_intersect($module_array,$module_selected);
		$n = 0;
		foreach ($module_exist as $key => $value) {
			$index_score[$n]['name'] = $key;
			$index = Module::findFirst(array(
				'name=?1',
				'bind'=>array(1=>$value)))->children;
			$index_array = explode(",", $index);
			foreach ($index_array as $skey => $svalue) {
				$index_id = MemoryCache::getIndexDetail($svalue)->id;
				$score[$key][$svalue] = IndexAns::findFirst(array(
					'examinee_id=?0 and index_id=?1',
					'bind'=>array(0=>$examinee_id,1=>$index_id)))->score;
			}
			print_r($score);
			$index_score[$n]['sum'] = array_sum($score[$key]);
			arsort($score[$key]);
			$score= array_slice($score[$key], 0,3);
			foreach ($score as $key => $value) {
				$index_score[$n]['score']['sname'] = $key;
				$index_score[$n]['score']['sscore'] = $value;
				$index_score[$n]['score']['schs_name'] = MemoryCache::getIndexDetail($key)->chs_name;
			}
			$index_score[$n]['sum'] = array_sum($index_score[$n]['score']);
			$n++;
		}
		echo "<pre>";
		print_r($index_score);
		echo "</pre>";
	}

}