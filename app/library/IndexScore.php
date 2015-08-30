<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	
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
	 */
	private static function getProjectId($examinee_id){
		self::$project_id = Examinee::findFirst(
		array(
			"id = :examinee_id:",
			'bind' => array('examinee_id'=>$examinee_id)
		)
		)->project_id;
	}
	/**
	 * @usage 获取所有要写入的指标数组
	 * @param int $examinee_id
	 */
	private static function getIndexs($examinee_id){
		if(empty(self::$project_id)){
			self::getProjectId($examinee_id);
		}
		$project_detail =  MemoryCache::getProjectDetail(self::$project_id);
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
		$factors = FactorAns::find(
				array(
			"examinee_id = :examinee_id:",
			'bind' => array('examinee_id' =>$examinee_id)
		)
		);
		$array_after = array();
		foreach($factors as $value ){
			self::$factors_list[$value->Factor->name] = $value->ans_score;
		}
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
		$index_ans = array();
		#此处为依次进行
		foreach(self::$indexs_list as $key => $value ){
			$score = 0;
			if($value !='zb_ldnl' && $value != 'zb_gzzf'){
				$index_detail = MemoryCache::getIndexDetail($value);
				$code = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', 'self::$factors_list[\'$0\']', $index_detail->action);
				$code =  "\$score = sprintf(\"%.2f\",$code);";
				eval($code);
				$index_ans[$value] = $score;
			}else if ($value == 'zb_ldnl'){
				$score = (2*($index_ans['zb_pdyjcnl'] + $index_ans['zb_zzglnl'])+ $index_ans['zb_cxnl'] + $index_ans['zb_ybnl']+$index_ans['zb_dlgznl'])/7;
				$index_ans[$value] = sprintf("%.2f",$score);
			}else {
				$score = (1.5*(self::$factors_list['X4'] + $index_ans['zb_rjgxtjsp']) + self::$factors_list['chg'] + self::$factors_list['Y3'] + self::$factors_list['Q3'] + self::$factors_list['spmabc'] +self::$factors_list['aff'])/8;
				$index_ans[$value] =  sprintf("%.2f",$score);
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