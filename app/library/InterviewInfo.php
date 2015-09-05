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
        	$interview_sum['number'][] = $number;
            $interview_sum['name'][] = $name;
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
        	$interview_not['number'][] = $number;
            $interview_not['name'][] = $name;
        }
        foreach ($interview_sum as $key1 => $value1) {
            foreach ($interview_com as $key2 => $value2) {
                echo $key1;
                echo $key2;
                exit();
                if ($key1 == $key2) {
                    
                }
            }
        }
        $interview = array(
        	'interview_com' => $interview_com,
        	'interview_not' => $interview_not);
        return $interview;
    }
}