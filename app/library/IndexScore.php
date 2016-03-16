<?php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
	/**
	 * @usage 写入指标成绩
	 * @state 3~4
	 * @author Wangyaohui
	 * @notice 1.Examinee表状态到3
	 * 		   2.FactorAns表中的信息
	 * 		   3.对比Project_detail表
	 * @date 2015-8-30
	 */
class IndexScore {
	private static $error_state = 3;
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
	 * @usage 获取project_id 成功则返回id， 失败返回false，表示已经完成这一层，抛出异常则下层没有完成
	 * @param int $examinee_id
	 * @throws Exception
	 */
	private static function getProjectId($examinee_id){
		$examinee_info = Examinee::findFirst(
				array("id = :id:",
						'bind'=>array('id'=>$examinee_id)
				)
		);
		#如果examinee_id为空，这种处理也合适
		if(isset($examinee_info->state)){
			if($examinee_info->state == 3){
				self::$project_id = $examinee_info->project_id;
				return true;
			}else if($examinee_info->state <= 2 ){
				throw new Exception(self::$error_state.'-下层计算还未完成-'.$examinee_info->state);
			}else{
				return false;
			}
		}else{
			throw new Exception(self::$error_state.'-不存在该账号的用户-'.$examinee_id);
		}
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
			throw new Exception(self::$error_state.'不存在指标'.print_r($project_detail));
		}
		$indexs_name_str = $project_detail->index_names;
		$indexs_name_array = explode(',', $indexs_name_str);
		$array_after = array();
		$next_index = array();
		foreach ($indexs_name_array as $value ){
			$index_detail = MemoryCache::getIndexDetail($value);
			if($value =='zb_ldnl'){
				$array_after[$index_detail->id] = $value;
				self::$indexs_list[3] = 'zb_pdyjcnl';
				self::$indexs_list[4] = 'zb_zzglnl';
				self::$indexs_list[7] = 'zb_cxnl';
				self::$indexs_list[8] = 'zb_ybnl';
				self::$indexs_list[6] = 'zb_dlgznl';
			}else if($value == 'zb_gzzf'){
				$array_after[$index_detail->id] = $value;
				self::$indexs_list[20] = 'zb_rjgxtjsp';
			}else{
				self::$indexs_list[$index_detail->id] = $value;
			}
		}
		foreach($array_after as $key => $value){
			self::$indexs_list[$key] = $value;
		}
		array_unique(self::$indexs_list);
		unset($array_after);
	}
	/**
	 * @usage 获取所有涉及到的因子得分数组
	 * @param int $examinee_id
	 */
	private static function getFactors($examinee_id){
		$factors_ans = FactorAns::find(
				array(
			"examinee_id = :examinee_id:",
			'bind' => array('examinee_id' =>$examinee_id)
		)
		);
		if(count($factors_ans) == 0){
			throw new Exception(self::$error_state.'-下层因子成绩未写入-'.count($factors_ans));
		}
		if(empty(self::$project_id)){
			self::getProjectId($examinee_id);
		}
		$project_detail = MemoryCache::getProjectDetail(self::$project_id);
		$factor_needed  = json_decode($project_detail->factor_names, true);
		foreach($factor_needed as $key=>$value){
			if(is_scalar($value)){
				$factor_detail = MemoryCache::getFactorDetail($value);
				$factor_id = $factor_detail->id;
				$factor_ans = FactorAns::findFirst(
				array(
						"examinee_id = :examinee_id: AND factor_id = :factor_id:",
						'bind'=>array('examinee_id'=>$examinee_id,'factor_id'=>$factor_id)
				)
				);
				if(!isset($factor_ans->examinee_id)){
					throw new Exception(self::$error_state.'-因子计分未写入-name-'.$value.'-id-'.$factor_id);
				}
				self::$factors_list[$value] = $factor_ans->ans_score;
			}else{
				foreach($value as $skey=>$svalue){
					$factor_detail = MemoryCache::getFactorDetail($svalue);
					$factor_id = $factor_detail->id;
					$factor_ans = FactorAns::findFirst(
					array(
						"examinee_id = :examinee_id: AND factor_id = :factor_id:",
						'bind'=>array('examinee_id'=>$examinee_id,'factor_id'=>$factor_id)
					)
					);
					if(!isset($factor_ans->examinee_id)){
						throw new Exception(self::$error_state.'-因子计分未写入-name-'.$svalue.'-id-'.$factor_id);
					}
					self::$factors_list[$svalue] = $factor_ans->ans_score;
				}
			}
		}
		if(isset($factor_needed)) { unset($factor_needed); }
	}
	/**
	 * 处理指标得分的核心
	 * @param int $examinee_id
	 */
	public static function handleIndexs($examinee_id) {
		#判定项目存在
		if(empty(self::$project_id)){
			$index_state = self::getProjectId($examinee_id);
			#false 表示这一层已经完成
			if(!$index_state){
				return false;
			}
		}
		#获取必须存到数据库的相关因子
		self::getFactors($examinee_id);
		#获取需要计算的指标
		if(empty(self::$indexs_list)){
			self::getIndexs($examinee_id);
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
		
		//edit by brucew 对6个特殊指标得分进行重写
		foreach ($index_ans as $key => $value ){
			$flag = false;
			switch($key) {
				//人际关系调节水平--恃强性 E &敏感性 I
				case "zb_rjgxtjsp": 
					$old_code = "(1.5*(po + aff + nur) + def + E + X3 + N + inte + I + aba + suc +fx)/13.5";
					$new_code ="(1.5*(po + aff + nur) + def + (10-E) + X3 + N + inte + (10-I) + aba + suc +fx)/13.5";
					$flag = true;
					break;
				//社交水平--恃强性 E&怀疑性 L
				case "zb_sjnl": 
					$old_code = "(1.5*(sy + aff + def + end) + agg + I + F + epqae + A + L + E +sp)/14";
					$new_code = "(1.5*(sy + aff + def + end) + agg + I + F + epqae + A + (10-L) + (10-E) +sp)/14";
					$flag = true;
					break;
				//容纳性--恃强性E
				case "zb_rnx": 
					$old_code = "(1.5*(po + nur + aff) + ac + aba + def + X1 + A + L + E)/11.5";
					$new_code = "(1.5*(po + nur + aff) + ac + aba + def + X1 + A + L + (10-E))/11.5";
					$flag = true;
					break;
				//诚信度 -- 好印象gi
				case "zb_cxd": 
					$old_code = "(1.5*(con + epqal) + gi + wb + Q3 + re + cm)/8";
					$new_code = "(1.5*(con + epqal) + (10-gi) + wb + Q3 + re + cm)/8";
					$flag = true;
					break;
				//情绪控制水平 -- 兴奋性F &敏感性 I
				case "zb_qxkzsp": 
					$old_code = "(1.5*(Y1 + sc + C) + G + Q3 + F + I + po + N + epqan)/11.5";
					$new_code = "(1.5*(Y1 + sc + C) + G + Q3 + (10-F) + (10-I) + po + N + epqan)/11.5";
					$flag = true;
					break;
				//个人价值取向 -- 好印象gi
				case "zb_grjzqx" : 
					$old_code = "(2*(ach + Y2 + cs) + exh + dom + nur + aff + aba + def + gi + wb + Q3 + sc +po)/17";
					$new_code = "(2*(ach + Y2 + cs) + exh + dom + nur + aff + aba + def + (10-gi) + wb + Q3 + sc +po)/17";
					$flag = true;
					break;
				default: #do nothing;
					break;
			}
			if ($flag) {
				$new_code = preg_replace('/[a-zA-Z][a-zA-Z0-9]*/', 'self::$factors_list[\'$0\']', $new_code);
				$matches = array();
				preg_match_all('/self\:\:\$factors\_list\[\'[a-zA-Z][a-zA-Z0-9]*\'\]/', $new_code, $matches);
				foreach($matches[0] as $skey=>$svalue){
					if(!isset($svalue)){
						eval("$svalue = 0;");
					}
				}
				$new_code =  "\$score = sprintf(\"%.2f\",$new_code);";
				eval($new_code);
				$index_ans[$key] = $score;
			}
		}
		//---end edit 
		try{
			$manager     = new TxManager();
			$transaction = $manager->get();	
			foreach (self::$indexs_list as  $key=>$value) {
				$index = new IndexAns();
				$index->setTransaction($transaction);
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
	/**
	 * @usage 完成指标得分计算后的被试状态转换
	 * @param int $examinee_id
	 * @throws Exception
	 * @return boolean
	 */
	public static function finishedIndex($examinee_id){
		$examinee_info = Examinee::findFirst(
				array("id = :id:",
						'bind'=>array('id'=>$examinee_id)
				)
		);
		#如果examinee_id为空，这种处理也合适
		if(isset($examinee_info->id)){
			try{
				$manager     = new TxManager();
				$transaction = $manager->get();
				$examinee_info->setTransaction($transaction);
				$examinee_info->state = 4;
				if($examinee_info->save() == false){
					$transaction->rollback(self::$error_state.'-数据库插入失败-'.print_r($examinee_info,true));
				}
				$transaction->commit();
				return true;
			}catch (TxFailed $e) {
				throw new Exception($e->getMessage());
			}
		}else{
			throw new Exception(self::$error_state.'-不存在该账号的用户-'.$examinee_id);
		}
	
	}
}