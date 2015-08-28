<?php

class Paper extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *primary key
     */
    public $id;

    /**
     * @var string
     *
     */
    public $description;

    /**
     * @var string
     * i.e.  SCL EPPS EPQA KS, CPI, SPM
     */
    public $name;
	
	/**
	 * Paper 关系 question
	 * 
	 */
    private static $paper_data = array(
    		array(
    				'description' =>"请你仔细阅读每一道试题，按自己的情况选择“是”与“否”。请就第一感觉回答，不要在每道题目上花费很长的时间。这里没有对你不利的题目，答案也无所谓正确与错误。每题都要回答。",
                    'name'=>"EPQA"
    		),
    		array(
    				'description' =>"如下每道题都包含一个情境，请仔细阅读每一个道题目所描述的情境，凭自己第一感觉从三个选项中选出最符合自己想法或行为的一项，不要去考虑情境的考察目的是什么，选项没有对错之分，每题都要回答。",
    				'name' =>"16PF"
    		),
    		array(
    				'description'=>"下面是一些有关个人观点、看法的陈述。请你仔细阅读每一个陈述，根据你的真实想法，选择最符合自己的一项。答案没有对、错之分。不要花太多的时间去考虑每个条目，只要如实回答就可以了。",
    				'name' => "CPI"
    		),
    		array(
    				'description' =>"本测验包括许多成对的语句，任何选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个。如果两句话都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。总之，对于每道题的A、B两种选择你必须而且只能选择其一。",
    				'name'=>"EPPS"
    		),
    		array(
    				'description' =>"仔细阅读每一条，根据自己最近一星期内的感觉，选择与自己相近的选项。必须逐条填写不可遗漏，每一项只能选择一个，不能选择两个或更多。",
    				'name'=>"SCL"
    		),
    		array(
    				'description' =>"以下每个题目都有一定的主题，但是每张大的主题图中都缺少一部分，主题图以下有6—8张小图片，若填补在主题图的缺失部分，可以使整个图案合理与完整，请从每题下面所给出的小图片中找出适合大图案的一张。",
    				'name' => "SPM"
    		)
    );
    
    public function initialize(){
        $this->hasMany("id", "Factor", "paper_id");
        $this->hasMany("id", "Question", "paper_id");
    }
    /**
     * 此处用于更新外部的paper_data 后，进行更新数据库的操作
     * @return multitype:multitype:string
     */
    public static function getLastedDataFromModel(){
    	return self::$paper_data;
    }
    
    /**
     *  添加 model method
     *
     */

    /**
     * 按照name遍历Paper表寻找对应项
     * $name = null 表示查询全表记录
     * $name = '**' 表示查询该名称的表记录
     * 返回值 [phalcon_mvc_model_object_array]
     * @param string $name
     */
    public static function getListByName($name = null){
    	$data_type = DBHandle::dataFormatCheck($name);
    	if($data_type!=0 && $data_type!=1){
    		throw new Exception("input type is not available!");
    	}
    	$rtn_array = null;
    	if( empty($name) ){
    		$rtn_array = self::find();
    	}else{
    		$rtn_array = self::findFirst(
			array(
    			"name = :name:",
				"bind" => array('name'=>strtoupper(trim($name)))
    		)
    		);
    	}
    	return $rtn_array;
    }
    /**
     * 按照names_array 返回响应的results_array
     * $names_array 不能为空, 否则抛出  Empty Exception
     * 返回值 [phalcon_mvc_model_object_array] 返回数组的项可能为空,需判断处理
     * @param array $names_array
     */
    public static function getListByNamesArray($names_array){
    	$data_type = DBHandle::dataFormatCheck($names_array);
    	if($data_type != 3){
    		throw new Exception("input type is not available");
    	}
    	$rtn_array = null;
    	#If you bind arrays in bound parameters, keep in mind, that keys must be numbered from zero:
    	$names_array = array_values($names_array);
    	# names_array strtoupper
    	$names_array_tmp = array();
    	foreach($names_array as $value){
    		$names_array_tmp[]= strtoupper($value);
    	}
    	$names_array = $names_array_tmp;
    	$names_array_tmp = null;
    	$rtn_array = self::find(
    		array(
    		"name IN ({name:array})",
    		'bind' => array('name'=>$names_array)
    	)
    	);
    	return $rtn_array;
    }
    /**
     * 按照id遍历Paper表寻找对应项
     * $id = null 表示全表查询
     * $id = integer 表示查询对应id 的表记录
     * 返回值 [phalcon_mvc_model_object_array]
     * @param string $id
     */
    public static function getListById($id = null){
    	$data_type = DBHandle::dataFormatCheck($id);
    	if($data_type!=0 && $data_type!=2){
    		throw new Exception("input type is not available!");
    	}
    	$rtn_array = null;
    	if( empty($id) ){
    		$rtn_array = self::find();
    	}else{
    		$rtn_array = self::findFirst(
    			array(
    			"id = :id:",
    			"bind" => array('id'=>$id)
    		)
    		);
    	}
    	return $rtn_array;
    }
    /**
     * 按照ids_array 返回响应的results_array
     * $ids_array 不能为空, 否则抛出  Empty Exception
     * 返回值 [phalcon_mvc_model_object_array] 返回数组的项可能为空,需判断处理
     * @param array $ids_array
     */
    public static function getListByIdsArray($ids_array){
    	$data_type = DBHandle::dataFormatCheck($ids_array);
    	if($data_type!=4){
    		throw new Exception("input type is not available!");
    	}
    	$rtn_array = null;
    	#If you bind arrays in bound parameters, keep in mind, that keys must be numbered from zero:
    	$ids_array = array_values($ids_array);
    	$rtn_array = self::find(
    			array(
    					"id IN ({name:array})",
    					'bind' => array('name'=>$ids_array)
    			)
    	);
    	return $rtn_array;
    }
    
    /**
     * 该方法已经抛弃，使用phalcon的外键关系来实现
     * 当获取到papers的信息数组后，如何获取其中的相关信息，从而减少查表的重复性
     * @param $papers_array $id -> $name
     * @return unknown
     */
    public static function getNameFromPapersArrayById($papers_array , $id){
    	foreach($papers_array as $paper_array){
    		if($paper_array->id == $id){
    			return $paper_array->name;
    		}
    	}
    	return false;
    }
    
    
    

    public static function findByNames($names)
    {
        $papers = self::find(array(
            'name IN ({names:array})',
            'bind' => array('names' => $names)
        ));
        return $papers;
    }

    public static function findId($name)
    {
        $paper = self::findFirst(array(
            'name = ?0',
            'bind' => array($name)
        ));
        if ($paper) {
            return $paper->id;
        }
        else return null;
    }

    public static function findName($id)
    {
        $paper = self::findFirst($id);
        if ($paper)
            return $paper->name;
        else return null;
    }
    
    /**
     * 
     * @param integer $id
     */
    public static function queryPaperInfo($id){
    	return self::findFirst(
        	array(
    		"id = :paper_id:",
        	'bind' => array( 'paper_id'=>$id),
        	'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
//        	'cache' => array('key'=> "paper_name_from_id_".$id)
    	)
    	);
    }
}
