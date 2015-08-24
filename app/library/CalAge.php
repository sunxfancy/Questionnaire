<?php


class CalAge
{
	public static function calAge1($birthdays,$todays){
		$today_temp = array();
		$birthday = $birthdays;
		$today_temp = explode(' ',$todays);
		$today = $today_temp[0];
		$startdate=strtotime("$birthday");
		$enddate=strtotime("$today");
		$days=round(($enddate-$startdate)/3600/24) ;
		$age = sprintf("%.2f",$days/365);
		return $age;
	}
	public static function getExaminee($examinee_id){
		return Examinee::findFirst($examinee_id);
	}
	public static function getFactorName($factor_id){
		return Factor::findFirst($factor_id)->name; 
	}

	public static function getPaperName($paper_id){
		return Paper::findFirst($paper_id)->name;
	}

	public static function getFactorId($factor_name){
		$factor = Factor::findFirst(array(
			'name=?0',
			'bind'=>array(0=>$factor_name)));
		return $factor->id;
	}

 	public static function getIndexId($index_name){
		$index = Index::findFirst(array(
			'name=?0',
			'bind'=>array(0=>$index_name)));
		return $index->id;
	}
}