<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * 因子层计算得分
	 * @author Wangyaohui
	 * @date 2015-8-30
	 */
class IndexScore {
	/**
	 * 缓存到本地项目id
	 * @var int
	 */
	private static $project_id = null;
	/**
	 * 缓存到本地的需要写入的指标数组
	 * @var array
	 */
	private static $indexs_list = array();
	/**
	 * @usage 缓存涉及到的所有因子的得分数组
	 * @var array
	 */
	private static $factors_list = array();
	/**
	 * @usage 通过examinee_id 获取该被试参与的项目涉及到的因子项目
	 * @param int $examinee_id
	 * @throws Exception
	 */
	private static function getProjectId($examinee_id){
		$results_from_examinee = Examinee::findFirst(
		array(
			"id = :examinee_id:",
			'bind' => array('examinee_id'=>$examinee_id)
		)
		);
		if(!isset($results_from_examinee->project_id)){
			throw new Exception("This examinee_id not exists!");
		}
		self::$project_id = $results_from_examinee->project_id;
	}
	/**
	 * @usage 获取所有要写入的指标数组,将可能要计算的复杂数组置于最后来计算
	 * @param int $examinee_id
	 */
	private static function getIndexs($examinee_id){
		if(empty(self::$project_id)){
			self::getProjectId($examinee_id);
		}
		$project_detail =  MemoryCache::getProjectDetail(self::$project_id);
		if(!isset($project_detail->index_names)){
			throw new Exception("no this project!");
		}
		$indexs_name_str = $project_detail->index_names;
		$indexs_name_array = explode(',', $indexs_name_str);
		$array_after = array();
		foreach ($indexs_name_array as $value ){
			$index_detail = MemoryCache::getIndexDetail($value);
			if($value =='zb_ldnl' || $value == 'zb_gzzf'){
				$array_after[$index_detail->id] = $value;
			}else{
				self::$indexs_list[$index_detail->id] = $value;
			}
		}
		foreach($array_after as $key => $value){
			self::$indexs_list[$key] = $value;
		}
		unset($array_after);
	}
	/**
	 * @usage 获取所有涉及到的因子得分数组
	 * @param int $examinee_id
	 */
	private static function getFactors($examinee_id){
		FactorScore::beforeStart();
		FactorScore::handleFactors($examinee_id);
		$factors_ans = FactorAns::find(
				array(
			"examinee_id = :examinee_id:",
			'bind' => array('examinee_id' =>$examinee_id)
		)
		);
		$rt_array = array();
		if(count($factors_ans) == 0){
			throw new Exception("no factors_calculate_results exist");
		}
		foreach($factors_ans as $value ){
			if(!isset($value->ans_score)){
				throw new Exception("The factor_calculate fails");
			}else {
				self::$factors_list[$value->Factor->name] = $value->ans_score;
			}
		}
		if(isset($factors_ans)) { unset($factors_ans);}
	}
	/**
	 * 处理指标得分的核心
	 * @param int $examinee_id
	 */
	public static function handleIndexs($examinee_id) {
		if(empty(self::$indexs_list)){
			self::getIndexs($examinee_id);
		}
		
		if(empty(self::$factors_list)){
			self::getFactors($examinee_id);
		}
		if(count(self::$factors_list) == 0){
			throw new Exception("no factor_results exist");
		}
		
		$index_ans = array();
		#此处为依次进行
		foreach(self::$indexs_list as $key => $value ){
			$score = 0;
			$index_detail = MemoryCache::getIndexDetail($value);
			if($value !='zb_ldnl' && $value != 'zb_gzzf'){
				#注意此处解析直接需要知道得到相应的因子得分，如果需要的因子得分而没有得到计算，那么可能报错
				$code = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', 'self::$factors_list[\'$0\']', $index_detail->action);
				$matches = array();
				preg_match_all('/self\:\:\$factors\_list\[\'[a-zA-Z][a-zA-Z0-9]*\'\]/', $code, $matches);
				foreach($matches[0] as $key=>$svalue){
					if(!isset($svalue)){
						 eval("$svalue = 0;");
					}
				}
				$code =  "\$score = sprintf(\"%.2f\",$code);";
				eval($code);
				$index_ans[$value] = $score;
			}else if ($value == 'zb_ldnl'){
				$code = preg_replace('/zb_[a-zA-Z0-9]*/', '\$index_ans[\'$0\']', $index_detail->action);
				$matches = array();
				preg_match_all('/\$index\_ans\[\'[a-zA-Z][a-zA-Z0-9]*\'\]/', $code, $matches);
				foreach($matches[0] as $key=>$svalue){
					if(!isset($svalue)){
						eval("$svalue = 0;");
					}
				}
				$code =  "\$score = sprintf(\"%.2f\",$code);";
				eval($code);
				$index_ans[$value] = $score;
			}else {
				if(!isset($index_ans['zb_rjgxtjsp'])){
					$index_ans['zb_rjgxtjsp'] = 0;
				}
				$code = $index_detail->action;
				$code = str_replace('zb_rjgxtjsp', 'rjgxtjsptmp', $code);
				self::$factors_list['rjgxtjsptmp'] = $index_ans['zb_rjgxtjsp'];
				$code = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', 'self::$factors_list[\'$0\']', $code);
				$matches = array();
				preg_match_all('/self\:\:\$factors\_list\[\'[a-zA-Z][a-zA-Z0-9]*\'\]/', $code, $matches);
				foreach($matches[0] as $key=>$svalue){
					if(!isset($svalue)){
						eval("$svalue = 0;");
					}
				}
				$code =  "\$score = sprintf(\"%.2f\",$code);";
				eval($code);
				$index_ans[$value] = $score;
				if(isset(self::$factors_list['rjgxtjsptmp'])){ unset(self::$factors_list['rjgxtjsptmp']);}
			}
		}	
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();	
			foreach (self::$indexs_list as  $key=>$value) {
				$index = new IndexAns();
				$index->examinee_id = $examinee_id;
				$index->index_id = $key;
				$index->score = $index_ans[$value];
				$isWrited = IndexAns::findFirst(
				array(
					"examinee_id = :examinee_id: AND index_id = :index_id:",
					'bind'=>array('examinee_id'=> $examinee_id, 'index_id'=>$key)
				)
				);
				if(isset($isWrited->score)){
					continue;
				}
				if( $index->save() == false ){
					$transaction->rollback("Cannot insert IndexAns data");
				}
			}
			$transaction->commit();
			return true;
		}catch (TxFailed $e) {
			throw new Exception("Failed, reason: ".$e->getMessage());
		}
		
	}
}