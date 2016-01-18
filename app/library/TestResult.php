<?php

class TestResult extends \Phalcon\Mvc\Model{
	public function test(){
		$result_1 = $this->modelsManager->createBuilder()
		->columns(array(
				'name as name'
		))
		->from('FourIndexsComment')
		->orderBy('name')
		->getQuery()
		->execute()
		->toArray();
		$tmp = array();
		$result_1 = $this->foo($result_1, $tmp);

		$result_2 = $this->modelsManager->createBuilder()
		->columns(array(
				'chs_name'
		))
		->from('Index')
		->orderBy('chs_name')
		->getQuery()
		->execute()
		->toArray();
		$tmp = array();
		$result_2 = $this->foo($result_2, $tmp);
		
		$tmp = array();
		$count = 0 ; 
		foreach ($result_1 as $key=>$value ){
			$inner_tmp = array();
			$inner_tmp[] = $value;
			$inner_tmp[] = $result_2[$key];
			if ($value != $result_2[$key]){
				$inner_tmp[] = '不同';
				$count++;
			}else {
				$inner_tmp[] = '';
			}
			$tmp[] = $inner_tmp;
		}
		echo $count;
		echo '<br />';
		
		return $tmp;
		
	}
	
	#辅助方法 --降维
	private function foo($arr, &$rt) {
		if (is_array($arr)) {
			foreach ($arr as $v) {
				if (is_array($v)) {
					$this->foo($v, $rt);
				} else {
					$rt[] = $v;
				}
			}
		}
		return $rt;
	}
	
}