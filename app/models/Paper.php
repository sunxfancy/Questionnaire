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
    				'description' =>"请根据自己的实际情况作“是”或“不是”的回答。这些问题要求你按自己的实际情况回答，不要去猜测怎样才是正确的回答。因为这里不存在正确或错误的回答，也没有捉弄人的问题，将问题的意思看懂了就快点回答，不要花很多时间去想。每个问题都要问答。问卷无时间限制，但不要拖延太长，也不要未看懂问题便回答。",
    				'name'=>"EPQA"
    		),
    		array(
    				'description' =>"卡特尔十六种人格因素测验包括一些有关个人兴趣与态度的问题。每个人都有自己的看法，对问题的回答自然不同。无所谓正确或错误。请来试者尽量表达自己的意见。<br />每道题有三种选择。作答时，请注意下列四点：<br />１．请不要费时斟酌。应当顺其自然地依你个人的反应选答。一般地说来，问题都略嫌简短而不能包含所有有关的因素或条件。通常每分钟可作五六题，全部问题应在半小时内完成。<br />２．除非在万不得已的情形下，尽量避免如“介乎Ａ与Ｃ之间”或“不甚确定”这样的中性答案。<br />３．请不要遗漏，务必对每一个问题作答。 有些问题似乎不符合于你，有些问题又似乎涉及隐私，但本测验的目的，在于研究比较青年或成人的兴趣和态度，希望来试者真实作答。<br />４．作答时，请坦白表达自己的兴趣与态度，不必顾虑到主试者或其他人的意见与立场。",
    				'name' =>"16PF"
    		),
    		array(
    				'description'=>"本测验含有一系列观点的陈述，请仔细阅读每一条，看看自己对它的感觉如何，如果你同意某个观点或该陈述真实地反映了你的情况，就作“是”的回答，否则作“否”的回答。",
    				'name' => "CPI"
    		),
    		array(
    				'description' =>"本测验包括许多成对的语句，任何选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个。如果两句话都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。<br /> 总之，对于每道题的A、B两种选择你必须而且只能选择其一。",
    				'name'=>"EPPS"
    		),
    		array(
    				'description' => "以下列出了有些人可能会有的问题，请仔细地阅读每一条，然后根据最近一星期以内下述情况影响您的实际感觉，在每个问题后标明该题的程度得分。",
    				'name'=>"SCL"
    		),
    		array(
    				'description' =>"下面要做的是一个有趣的测试，完成它时要认真看、认真想， 前面的题认真了，会对做后面的题目有好处；<br />每道测试题都有一张主题图，在主题图中，图案是缺了一部分的，主题图下有6－8张小图片，其中有一张小图片可以使主题图整个图案合理与完整。请确定哪一张小图片补充在主题图缺少的空白处最合适。<br />本测验无时间限制，请认真去做。请记住，每个题目只有一个正确答案。",
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
    
    public static function queryPaperInfo($id){
    	return self::findFirst(
        	array(
    		"id = :paper_id:",
        	'bind' => array( 'paper_id'=>$id),
        	'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
        	'cache' => array('key'=> "paper_name_from_id_".$id)
    	)
    	);
    }
}
