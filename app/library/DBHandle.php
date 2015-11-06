<?php
	/**
	 * 模型方法的辅助类
	 * 1. 数据输入项的校验
	 * 2. 数据库表的插入
	 * @author Wangyaohui
	 * 添加了事务管理 model transaction
	 * finished 2015-8-18
	 */
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class DBHandle {
	
/**
     * 输入的数据的格式判断
     * @param unknown $data
     * @return number
     * 0 表示为空
     * 1 表示为字符串
     * 2 表示为整数
     * 3 表示字符串数组
     * 4 表示整数数组
     * 5 表示多维数组
     * -1 表示其他类型
     */
    public static function dataFormatCheck($data){
    	if( empty($data) ){
    		return 0;
    	}else if ( is_string($data) ){
    		return 1;
    	}else if ( is_integer($data) ){
    		return 2;
    	}else if ( is_array($data) ){
    		if(is_string($data[0])){
    			$flag = true;
    			foreach($data as $value){
    				if(!is_string($value)){
    					$flag = false;
    					break;
    				}
    			}
    			if($flag){
    				return 3;
    			}else{
    				return -1;
    			}
    			
    		}else if( is_integer($data[0])){
    			$flag = true;
    			foreach($data as $value){
    				if(!is_integer($value)){
    					$flag = false;
    					break;
    				}
    			}
    			if($flag){
    				return 4;
    			}else{
    				return -1;
    			}
    			
    		}else if( is_array($data[0])){
    			$flag = true;
    			foreach($data as $value){
    				if(!is_array($value)){
    					$flag = false;
    					break;
    				}
    			}
    			if($flag){
    				return 5;
    			}else{
    				return -1;
    			}
    		}else {
    			return -1;
    		}
		
    	}else {
    		return -1;
    	}
    }
    
    /**
     * Paper表数据插入
     * @throws Exception
     * @return boolean
     * [1] 插入成功
     * [0|Exception] 插入失败
     */
    public static function insertPaperData(){
    	if(Paper::count()!=0){
    		throw new Exception("The Paper table is already inserted, please delete it and then insert or update!");
    	}
    	$paper_data = Paper::getLastedDataFromModel();
    	$data_type = self::dataFormatCheck($paper_data);
    	if($data_type != 5){
    		throw new Exception("input type is not available!");
    	}
    	try {
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($paper_data as $record){
    			$paper = new Paper();
    			$paper->description = $record['description'];
    			$paper->name = $record['name'];
    			if( $paper->create() == false ){
    				$transaction->rollback("Cannot insert Paper data");
    			}
    		}
    		$transaction->commit();
    		return true; 	
    	} catch (TxFailed $e) {
    		throw new Exception("Failed, reason: ".$e->getMessage());
    	}
    }
    
    /**
     * 删除Paper 表数据
     * 关联到Question,Question_ans表, 因此不能随意删除
     * 尤其是Question表， 其中的数据必须是在获取到paper_id 之后才能导入
     * @return boolean
     * true 删除成功
     * false 删除失败
     */
    public static function deletePaperData(){

    	if(Question::count() != 0){
    		throw new Exception("The foreign key is used for table Question!");
    	}
    	$paper_data = Paper::find();
    	try {
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($paper_data  as $record){
    			if($record->delete() == false){
    					$transaction->rollback("Cannot delete Paper data");
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception("Failed, reason: ".$e->getMessage());
    	}
    }
    
    /**
     * 更新paper表数据
     * 主要是更新Paper表中的行记录,通过比照name,更新description
     * @param unknown $data
     * ture 更新成功
     * false|Exception 更新失败
     */
    public static function updatePaperData(){
    	$data = Paper::getLastedDataFromModel();
    	$data_type = self::dataFormatCheck($data);
    	if($data_type != 5){
    		throw new Exception("input type is not available!");
    	}
    	$raw_data_count = Paper::count();
    	if($raw_data_count != count($data)){
    		throw new Exception("Please ensure the data[from table and from array] consistency");
    	}

    	try {
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach ($data as $record ){
    		$paper_table_record = Paper::findFirst(
				array(
					"name = :name:",
					'bind'=> array('name'=>strtoupper(trim($record['name'])))
				));
    		if (isset($paper_table_record->id)){
    			if(strcmp($paper_table_record->description ,$record['description']) != 0){
    				$paper = new Paper();
    				$paper->id= $paper_table_record->id;
    				$paper->description = $record['description'];
    				$paper->name = strtoupper(trim($record['name']));
    				if($paper->update() == false){
    					$transaction->rollback("Cannot update Paper data");
    				}
    			}
    		}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception("Failed, reason: ".$e->getMessage());
    	}
    }
    
    
    /**
     * 查看Paper数据
     */
    public static function checkPaperData(){
    	$papers_data = Paper::getListByName();
    	if(count($papers_data) > 0){
    		foreach ($papers_data as $paper_data ){
    			echo "<h3><span style='color:red'>试卷编号</span>&nbsp;&nbsp;".$paper_data->id;echo "</h3>";
    			echo "<h3>试卷指导语</h3>";
    			echo "<p>".$paper_data->description;echo "</p>";
    			echo "<h3>试卷名称</h3>";
    			echo "<p>".$paper_data->name;echo "</p>";
    			echo "<hr />";
    		}
    	}else{
    		echo "数据信息不存在";
    	}
    }
    /**
     * SPM题库： 60道题
     * 插入SPM题到Question表中
     */
    public static function insertSPMtk(){
    	$spm_db_data = self::generateSPMDBData();
    	$paper_data = Paper::getListByName("SPM");
    	if(isset($paper_data->id)){
    		$spm_data = Question::getQuestionsByPaperId(intval($paper_data->id));
    		$spm_data_count = count($spm_data);
    		if($spm_data_count == 60 ){
    			throw new Exception("The SPM data has already inserted, don't do again!");
    		}else if ( $spm_data_count != 0 ){
    			throw new Exception("The DB data for SPM may be ERROR!");
    		}else{
    			try {
    				$manager     = new TxManager();
    				$transaction = $manager->get();
    				foreach($spm_db_data as $record){
    				$spm_question = new Question();
    				$spm_question->topic  =  $record['topic'];
    				$spm_question->options = $record['options'];
    				$spm_question->number =  intval($record['number']);
    				$spm_question->paper_id = intval($paper_data->id);
    				if ($spm_question->create() == false){
    						$transaction->rollback("Cannot insert SPM data");
    					}
    				}
    				$transaction->commit();
    				return true;
    			}catch (TxFailed $e) {
    				throw new Exception("Failed, reason: ".$e->getMessage());
    			}
    		}
    	}else{
    		throw new Exception("No Paper record for SPM data, please insert Paper table!");
    	}    	
    }
   
    /**
     * SPM题目名称对应的题库数据
     * @return multitype:multitype:string number Ambigous <NULL, string>
     */
    private static function generateSPMDBData(){
    	$rtn_array = array();
    	for($xunhuan1 = 1; $xunhuan1 <= 5; $xunhuan1 ++ ){
    		//A B C D E
    		if ($xunhuan1 <= 2 ){
    			//A B
    			for($tihao = 1; $tihao <= 12; $tihao++){
    				//1 ~ 12
    				$str = null;
    				for( $xuanxiang = 1; $xuanxiang <=6; $xuanxiang++ ){
    					//1~6
    					if($xuanxiang!=1){
    						$str .= '|';
    					}
    					$str .= chr($xunhuan1+ord('A')-1).$tihao.'A'.$xuanxiang;
    				}
    				$tmp_nei = array();
    				$tmp_nei['options'] = $str;
    				$tmp_nei['topic'] = chr($xunhuan1+ord('A')-1).$tihao.'M';
    				$tmp_nei['number'] = ($xunhuan1-1)*12+$tihao;
    				$rtn_array[] = $tmp_nei;
    	
    			}
    	
    		}else{
    			//C D E
    			for($tihao =1; $tihao<=12; $tihao++){
    				//1 ~ 12
    				$str =null;
    				for($xuanxiang = 1; $xuanxiang <=8 ; $xuanxiang++ ){
    					if($xuanxiang!=1){
    						$str.= '|';
    					}
    					$str .= chr($xunhuan1+ord('A')-1).$tihao.'A'.$xuanxiang;
    				}
    				$tmp_nei = array();
    				$tmp_nei['options'] = $str;
    				$tmp_nei['topic'] = chr($xunhuan1+ord('A')-1).$tihao.'M';
    				$tmp_nei['number'] = ($xunhuan1-1)*12+$tihao;
    				$rtn_array[] = $tmp_nei;
    	
    	
    			}
    		}
    	}
    	return $rtn_array;
    }
   
    /**
     * EPPS:225道题
     */
    public static function insertEPPStk($data){
    	if(self::dataFormatCheck($data)!= 5){
    		throw new Exception("input type is not available");
    	}
    	$paper_data = Paper::getListByName('EPPS');
    	if(isset($paper_data->id)){
    		$paper_id = intval($paper_data->id);
    		$question_data = Question::getQuestionsByPaperId($paper_id);
    		$question_data_count = count($question_data);
    		if($question_data_count == 225 ){
    			throw new Exception("The EPPS data has already inserted, don't do again!");
    		}else if ( $question_data_count != 0 ){
    			throw new Exception("The DB data for EPPS may be ERROR!");
    		}else{
    			try {
    				$manager     = new TxManager();
    				$transaction = $manager->get();
    				foreach($data as $record){
    					$options = $record[1].'|'.$record[2];
    					$epps_question = new Question();
    					$epps_question->topic = null;
    					$epps_question->number = $record[0];
    					$epps_question->options = $options;
    					$epps_question->paper_id = $paper_id;
    					if ($epps_question->create() == false){
    						$transaction->rollback("Cannot insert EPPS data");
    					}
    				}
    				$transaction->commit();
    				return true;
    			}catch (TxFailed $e) {
    				throw new Exception("Failed, reason: ".$e->getMessage());
    			}
    		}
    	}else{
    		return false;
    	}
    }
    
    public static function insertKStk($data){
    	if(self::dataFormatCheck($data)!= 5){
    		throw new Exception("input type is not available");
    	}
    	$paper_data = Paper::getListByName('16PF');
    	if(isset($paper_data->id)){
    		$paper_id = intval($paper_data->id);
    		$question_data = Question::getQuestionsByPaperId($paper_id);
    		$question_data_count = count($question_data);
    		if($question_data_count == 187 ){
    			throw new Exception("The 16PF data has already inserted, don't do again!");
    		}else if ( $question_data_count != 0 ){
    			throw new Exception("The DB data for 16PF may be ERROR!");
    		}else{
    			try {
    				$manager     = new TxManager();
    				$transaction = $manager->get();
    				foreach($data as $record){
    					$record[2] = substr($record[2], 3, strlen($record[2])-4);
    					$record[3] = substr($record[3], 3, strlen($record[3])-4);
    					$record[4] = substr($record[4], 3, strlen($record[4])-4);
    					$options = $record[2].'|'.$record[3].'|'.$record[4];
    					$ks_question = new Question();
    					$ks_question->topic = $record[1];
    					$ks_question->number = $record[0];
    					$ks_question->options = $options;
    					$ks_question->paper_id = $paper_id;
    					if ($ks_question->create() == false){
    						$transaction->rollback("Cannot insert 16PF data");
    					}
    				}
    				$transaction->commit();
    				return true;
    			}catch (TxFailed $e) {
    				throw new Exception("Failed, reason: ".$e->getMessage());
    			}
    		}
    	}else{
    		return false;
    	}
    }
    /**
     * 用于上传EPQA, CPI, SCL 三个数据库
     * @param unknown $name
     * @param unknown $data
     * @throws Exception
     * @return boolean
     */
    public static function insertTkByName($name,$data){
    	if(self::dataFormatCheck($data) != 5 || self::dataFormatCheck($name) != 1){
    		throw new Exception("input type is not available");
    	}
    	$name = strtoupper(trim($name));
    	$number = null;
    	switch ($name){
    		case 'EPQA' : $number = 88; $options = "是|不是"; break;
    		case 'CPI' : $number = 230; $options = "是|否";  break;
    		case 'SCL' : $number = 90;  $options = "没有|很轻|中等|偏重|严重"; break;
    		default : throw new Exception("no this Type data");
    	}
    	$paper_data = Paper::getListByName($name);
    	if(isset($paper_data->id)){
    		$paper_id = intval($paper_data->id);
    		$question_data = Question::getQuestionsByPaperId($paper_id);
    		$question_data_count = count($question_data);
    		if($question_data_count == $number ){
    			throw new Exception("The $name data has already inserted, don't do again!");
    		}else if ( $question_data_count != 0 ){
    			throw new Exception("The DB data for $name may be ERROR!");
    		}else{
    			try {
    				$manager     = new TxManager();
    				$transaction = $manager->get();
    				foreach($data as $record){
    					$scl_question = new Question();
    					$scl_question->topic = $record[1];
    					$scl_question->number = intval($record[0]);
    					$scl_question->options = $options;
    					$scl_question->paper_id = $paper_id;
    					if ($scl_question->create() == false){
    						$transaction->rollback("Cannot insert $name data");
    					}
    				}
    				$transaction->commit();
    				return true;
    			}catch (TxFailed $e) {
    				throw new Exception("Failed, reason: ".$e->getMessage());
    			}
    		}
    	}else{
    		return false;
    	}
    }
    
    /**
     * 删除Question表中的相应试卷的试题
     * @throws Exception
     * @return boolean
     */
    public static function deleteTKByName($name){
    	$name = strtoupper(trim($name));
    	$paper_data = Paper::getListByName($name);
    	if(isset($paper_data->id)){
    		$questions = Question::find(
    				array(
    						"paper_id = :paper_id:",
    						'bind' => array('paper_id'=>intval($paper_data->id))
    				)
    		);
    		try {
    			$manager     = new TxManager();
    			$transaction = $manager->get();
    			foreach($questions as $question){
    				if( $question->delete() == false ){
    					$transaction->rollback("Cannot delete $name data");
    				}
    			}
    			$transaction->commit();
    			return true;
    		}catch (TxFailed $e) {
    			throw new Exception("Failed, reason: ".$e->getMessage());
    		}
    	}else{
    		throw new Exception("No Paper record for $name data, please first insert Paper table!");
    	}
    }
    
    /**
     * 查看题目信息
     * @param unknown $name
     * @throws Exception
     * @return boolean
     */
    public static function checkTKByName($name){
    	if(self::dataFormatCheck($name) != 1){
    		throw new Exception("input type is not available!");
    	}
    	$name = strtoupper(trim($name));
    	try{
    		$number = 0;
    		switch($name){
    			case 'SPM' : $number = 60; break;
    			case 'CPI' : $number = 230; break;
    			case 'EPQA' : $number = 88; break;
    			case 'EPPS' : $number = 225; break;
    			case '16PF' : $number = 187; break;
    			case 'SCL' :$number = 90; break;
    			default : throw new Exception("no this Type data");
    		} 
    		$paper_record = Paper::getListByName($name);
    		if (isset($paper_record->id)){
    			$data = Question::find(
    					array(
    							"paper_id = :paper_id:",
    							'bind'=>array( 'paper_id' => intval($paper_record->id ) )
    					)
    			);
    			$data_count = count($data);
    			if ($data_count == 0 ){
    				echo "$name 数据为空";
    				return true;
    			}else if ($data_count == $number){
    				echo "<h1>".$name."题库</h1>";
    				foreach($data as $record) {
    					echo "题目编号&nbsp;&nbsp;&nbsp;<span style='color:red'>".$record->id;echo "</span><br />";
    					echo "题目内容&nbsp;&nbsp;&nbsp;".$record->topic;echo "<br />";
    					echo "题目选项&nbsp;&nbsp;&nbsp;".$record->options; echo "<br />";
    					echo "题目所在试卷的题号&nbsp;&nbsp;&nbsp;<strong>".$record->number; echo "</strong><br />";
    					echo "题目所在的试卷好&nbsp;&nbsp;&nbsp;".$record->paper_id; echo "<hr />";
    				}
    			}else{
    				throw new Exception("Database Error or link error");
    			}
    		}
    	}catch(Exception $e){
    		echo $e->getMessage();
    	}
    }

    //插入个体报告评语描述信息
    public static function insertChildIndexComment($data){
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            foreach($data as $value){
                $childindexcomment = new ChildIndexComment();
                $childindexcomment->setTransaction($transaction);
                foreach($value as $key=>$svalue){
                    $childindexcomment->$key = $svalue;
                }
                if( $childindexcomment->save() == false) {
                     $transaction->rollback('数据更新失败-3');
                }
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }
    #插入胜任力指标描述
    public static function insertCompetency($data) {
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();
            foreach($data as $value){
                $competencycomment = new CompetencyComment();
                $competencycomment->setTransaction($transaction);
                foreach($value as $skey=>$svalue){
                    $competencycomment->$skey = $svalue;
                }
                if($competencycomment->save() == false) {
                     $transaction->rollback('数据更新失败-3');
                }
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }
    #插入综合评价的28指标评语
    public static function insertComprehensive($data){
    	try{
    		$manager     = new TxManager();
    		$transaction = $manager->get();
    		foreach($data as $value){
    			$comprehensivecomment = new ComprehensiveComment();
    			$comprehensivecomment ->setTransaction($transaction);
    			foreach($value as $skey=>$svalue){
    				$comprehensivecomment ->$skey = $svalue;
    			}
    			if($comprehensivecomment->save() == false) {
    				$transaction->rollback('数据更新失败-3');
    			}
    		}
    		$transaction->commit();
    		return true;
    	}catch (TxFailed $e) {
    		throw new Exception($e->getMessage());
    	}
    }

     //插入指标与因子中间层
    public static function insertMiddle($data){
        try{
            $manager     = new TxManager();
            $transaction = $manager->get();

            foreach($data as $key=>$value){
                $middle = new MiddleLayer();
                $middle->setTransaction($transaction);
                foreach ($value as $skey=>$svalue ){
                	$middle->$skey = $svalue;
                }
                if($middle->save() == false) {
                     $transaction->rollback('数据更新失败-3');
                }
            }
            $transaction->commit();
            return true;
        }catch (TxFailed $e) {
            throw new Exception($e->getMessage());
        }
    }
}