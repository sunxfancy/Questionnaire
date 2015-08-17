<?php


class Paper extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var string
     *
     */
    public $description;

    /**
     * @var string
     *
     */
    public $name;
	
	/**
	 * Paper 关系 question
	 * 
	 */
    public function initialize(){
        $this->hasMany("id", "Factor", "paper_id");
        $this->hasMany("id", "Question", "paper_id");
    }
    /**
     *  添加 model method
     * @param unknown $data
     */
    public static function insertData($data){
    	
    }
    public static function updateData($data){
    	
    }
    public static function getListByName($name = null){
    	if( empty($name) ){
    		self::find();
    	}
    }
    public static function getListByNamesArray($names_array){
    	
    }
    public static function getListById($id){
    	
    }
    public static function getListByIdsArray($ids_array){
    	
    }
    public static function dataFormatCheck($data){
    	
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
}
