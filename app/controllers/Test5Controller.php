<?php

class Test5Controller extends Base
{
	public function calStd_score(){

	}

	public function calAge($examinee_id){
		$examinee = Examinee::findFirst(array(
            'id=?0',
            'bind'=>array($examinee_id)));
	}
}