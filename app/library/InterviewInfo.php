<?php 

class InterviewInfo{
	//获取被试面巡完成人员及未完成人员名单
	public static function getInterviewResult($manager_id){
        $interview = Interview::find(array(
                'manager_id =?1',
                'bind' => array(1=>$manager_id)));
        $interview_sum = array();
        foreach ($interview as $interviews) {
        	$examinee = Examinee::findFirst($interviews->examinee_id);
        	$number = $examinee->number;
        	$name = $examinee->name;
        	$interview_sum[$number] = $name;
        }
        $term = "remark<>'' AND advantage<>'' AND disadvantage<>'' AND manager_id=:manager_id:";
        $interview = Interview::find(array(
                $term,
                'bind' => array('manager_id' => $manager_id)));
        $interview_com = array();
        foreach ($interview as $interviews) {
        	$examinee = Examinee::findFirst($interviews->examinee_id);
        	$number = $examinee->number;
        	$name = $examinee->name;
        	$interview_com[$number] = $name;
        }
        $interview_not = array();
        $interview_not = array_diff_key($interview_sum, $interview_com);
        foreach ($interview_com as $key => $value) {
            $interview_coms['number'][] = $key;
            $interview_coms['name'][] = $value;
        }
        foreach ($interview_not as $key => $value) {
            $interview_nots['number'][] = $key;
            $interview_nots['name'][] = $value;
        }
        $interview = array(
        	'interview_com' => $interview_coms,
        	'interview_not' => $interview_nots);
        return $interview;
    }
}