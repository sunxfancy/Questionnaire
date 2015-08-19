<?php


class Interview extends \Phalcon\Mvc\Model 
{

    /**
     * @var string
     *
     */
    public $advantage;

    /**
     * @var string
     *
     */
    public $disadvantage;

    /**
     * @var string
     *
     */
    public $remark;

    /**
     * @var integer
     *
     */
    public $manager_id;

    /**
     * @var integer
     *
     */
    public $examinee_id;
    
    
    public static function commentSave($arr){
    	$interview = new Interview();
    	$interview->advantage = $arr['advantage'];
    	$interview->disadvantage = $arr['disadvantage'];
    	$interview->remark = $arr['remark'];
    	$interview->examinee_id = $arr['examinee_id'];
    	$interview->manager_id = $arr['manager_id'];
    
    	if($interview->save()){
    		return true;
    	}
    	return false;
    
    }

}
