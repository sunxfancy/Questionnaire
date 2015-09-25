<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-07 17:04:14
 */

include("../app/classes/PHPExcel.php");

/**
* 
*/
class ExcelLoader
{
    private $options = '';
    private function __construct() {
        $this->excel_col = array( 'C' => 'name',     'E' => 'native',   'F' => 'education',
                                  'G' => 'degree', 'H' => 'birthday', 'I' => 'politics',
                                  'J' => 'professional', 'K' => 'team',     'L' => 'employer',
                                  'M' => 'unit','N' => 'duty');
        $this->edu_name = array('school','profession','degree','date');
        $this->work_name = array('employer','unit','duty','date');
    }

    private static $instance;  
    public static function getInstance(){
        if (!(self::$instance instanceof self)){  
            self::$instance = new self();  
        }  
        return self::$instance;  
    }

    /**
     * 被试人员导入
     */
    public function LoadExaminee ($filename, $project_id, $db){
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        $examinee = Examinee::find(array(
            'project_id = :project_id:',
            'bind' => array('project_id' => $project_id)));
        $project = new Project();
        if(count($examinee) == 0){ 
                $last_number = $project_id.'0001';
        }else{
            $data_num = count($examinee);
            $last_number = $examinee[$data_num-1]->number+1;
        }
        $db->begin(); 
        if (is_readable($filename)){
            try {
                $objexcel = PHPExcel_IOFactory::load($filename);
                $sheet = $objexcel->getSheet(0);
                $higestrow = $sheet->getHighestRow();
                // $last_number = $project->last_examinee_id;
                $i = 3;
                while ($i <= $higestrow) {
                    $k = $sheet->getCell("C".$i)->getValue();
                    if (is_null($k) || $k == "") break;
                    $this->readline_examinee($sheet, $project_id, $last_number, $i);
                    $i++;
                    $last_number++;
                }
            } catch (Exception $ex) {
                $errors['Exception'] = $ex->getMessage();
                $db->rollback();
                $objexcel->disconnectWorksheets();
                unlink($filename);
                return $errors;
            }
            $project->last_examinee_id = $last_number;
            $project->save();
            $db->commit();
            $objexcel->disconnectWorksheets();
        }        
        unlink($filename);
        return 0;
    }

    public function readline_examinee($sheet, $project_id, $number, $i){
        $examinee = new Examinee();
        foreach ($this->excel_col as $key => $value) {
            $examinee->$value = self::filter($sheet->getCell($key.$i)->getValue());
        }
        $sex = self::filter($sheet->getCell('D'.$i)->getValue());
        if ($sex == '男' || $sex == 1) $examinee->sex = 1;
        else $examinee->sex = 0;
        $education = array();
        $work = array();
        $k = 0;
        $n = 0;
        $flag = 0;
        $this->readother_examinee($sheet,$education,$this->edu_name, $i);
        $this->readother_examinee($sheet,$work,$this->work_name,$i);
        $highest_column = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
        for($j = 14;$j < $highest_column;$j = $j + 4){
            //教育经历
            if( self::filter($sheet->getCellByColumnAndRow($j,$i)->getValue()) == 'end'){
                $flag = 1;
                $j++;
            }
            if($flag == 0){
                $judge = self::filter($sheet->getCellByColumnAndRow($j,$i)->getValue());
                if(!empty($judge)){
                    $education[$k]['school'] = self::filter($sheet->getCellByColumnAndRow($j,$i)->getValue());
                    $education[$k]['profession'] = self::filter($sheet->getCellByColumnAndRow($j+1,$i)->getValue());
                    $education[$k]['degree'] = self::filter($sheet->getCellByColumnAndRow($j+2,$i)->getValue());
                    $education[$k]['date'] = self::filter($sheet->getCellByColumnAndRow($j+3,$i)->getValue());
                    $k++;
                }
            }
            //工作经历
            else{
                $judge = self::filter($sheet->getCellByColumnAndRow($j,$i)->getValue());
                if(!empty($judge)){
                    $work[$n]['employer'] = self::filter($sheet->getCellByColumnAndRow($j,$i)->getValue());
                    $work[$n]['unit'] = self::filter($sheet->getCellByColumnAndRow($j+1,$i)->getValue());
                    $work[$n]['duty'] = self::filter($sheet->getCellByColumnAndRow($j+2,$i)->getValue());
                    $work[$n]['date'] = self::filter($sheet->getCellByColumnAndRow($j+3,$i)->getValue());
                    $n++;
                }else{
                    break;
                }
            }
        }
        $examinee->other = json_encode(array('education' => $education, 'work' => $work),JSON_UNESCAPED_UNICODE);
        $examinee->number = $number;
        $examinee->password = $this->random_string();
        $examinee->project_id = $project_id;
        $init_data = array();
        $init_data['name'] = $examinee->name;
        $init_data['native'] = $examinee->native;
        $init_data['education'] = $examinee->education;
        $init_data['politics'] = $examinee->politics;
        $init_data['degree'] = $examinee->degree;
        $init_data['professional'] = $examinee->professional;
        $init_data['employer'] = $examinee->employer;
        $init_data['unit'] = $examinee->unit;
        $init_data['team'] = $examinee->team;
        $init_data['duty'] = $examinee->duty;
        $init_data['birthday'] = $examinee->birthday;
        $init_data['sex'] = $examinee->sex;
        $init_data['other'] = $examinee->other;
        $examinee->init_data = json_encode($init_data,JSON_UNESCAPED_UNICODE);

        if (!$examinee->save()) {
            foreach ($examinee->getMessages() as $message) {
                throw new Exception($message);
            }
        }
    }

    function readother_examinee($sheet, $other_array, $name_array, $i){
        $other_col = 'M';
        for ($j = 0; $j < 4; $j++) {
            for ($k = 0; $k < 4; $k++) { 
                $other_array[$j][$name_array[$k]] = self::filter($sheet->getCell($other_col.$i)->getValue());
                $other_col++;
            }
        }
    }

    /**
     * 需求量表导入
     */
    public function LoadInquery ($filename, $project_id, $db){
        $this->baseLoad('readline_inquery',$filename, $project_id, $db);
    }

    public function readline_inquery($sheet, $project_id, $i){
        $options = '';
        $highest_column = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
        for($j = 3;$j<$highest_column;$j++){
            $cell_value = self::filter($sheet->getCellByColumnAndRow($j,$i)->getValue());
            $cell_value = trim($cell_value);
            if($cell_value != ''){
                $options .= $cell_value.'|';
            }else{
                break;
            }
        }
        $options = substr($options,0,strlen($options)-1);
        $radio = self::filter($sheet->getCell('C'.$i)->getValue());
        $is_radio = ($radio == '是') ? 1 : 0;
        $inquery_question = new InqueryQuestion();
        $inquery_question->id = $sheet->getCell('A'.$i)->getValue();
        $inquery_question->topic = $sheet->getCell('B'.$i)->getValue();
        $inquery_question->is_radio = $is_radio;
        $inquery_question->project_id = $project_id;
        $inquery_question->options = $options;
        if(!$inquery_question->save()){
            foreach($inquery_question->getMessage() as $message){
                throw new Exception($message);
            }
        }
    }

    /**
     * 导入面询专家
     */
    public function LoadInterviewer ($filename, $project_id, $db){
        $this->baseLoad('readline_interviewer',$filename, $project_id, $db);
    }

    public function readline_interviewer($sheet, $project_id, $i){
        $interviewer = Manager::find(array(
            'project_id =?0 and role=?1',
            'bind' => array(0=> $project_id,1=>'I')));
        $data_num = count($interviewer);
        if($data_num == 0){ 
            $last_number = $project_id.'1'.'01';
        }else{
            $last_number = $interviewer[$data_num-1]->username+1;
        }
        
        $interviewer = new Manager();
        $interviewer->name = self::filter($sheet->getCell('C'.$i)->getValue());
        $interviewer->username = $last_number;
        $interviewer->password = $this->random_string();
        $interviewer->role = 'I';
        $interviewer->project_id = $project_id;
        if (!$interviewer->save()) {
            foreach ($interviewer->getMessages() as $message) {
                throw new Exception($message);
            }
        }
    } 

    /**
     * 导入领导
     */
    public function LoadLeader ($filename, $project_id, $db){
        $this->baseLoad('readline_leader',$filename, $project_id, $db);
    }

    public function readline_leader($sheet, $project_id, $i){
        $leader = Manager::find(array(
            'project_id =?0 and role=?1',
            'bind' => array(0=> $project_id,1=>'L')));
        $data_num = count($leader);
        if($data_num == 0){ 
                $last_number = $project_id.'2'.'01';
        }else{
            $last_number = $leader[$data_num-1]->username+1;
        }

        $leader = new Manager();        
        $leader->name = self::filter($sheet->getCell('C'.$i)->getValue());
        $leader->username = $last_number;
        $leader->password = $this->random_string();
        $leader->role = 'L';
        $leader->project_id = $project_id;
        if (!$leader->save()) {
            foreach ($leader->getMessages() as $message) {
                throw new Exception($message);
            }
        }
    } 

    function baseLoad($funcname,$filename, $project_id, $db){
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        if (is_readable($filename)){
            $db->begin(); 
            try {
                $objexcel = PHPExcel_IOFactory::load($filename);
                $sheet = $objexcel->getSheet(0);
                $higestrow = $sheet->getHighestRow();

                $i = 3;
                while ($i <= $higestrow) {
                    $k = $sheet->getCell("C".$i)->getValue();
                    if (is_null($k) || $k == "") break;
                    $this->$funcname($sheet, $project_id, $i);
                    $i++;
                }
            } catch (Exception $ex) {
                $errors['Exception'] = $ex->getMessage();
                $db->rollback();
                $objexcel->disconnectWorksheets();
                unlink($filename);
                return $errors;
            }
            $db->commit();
            $objexcel->disconnectWorksheets();
        }
        unlink($filename);
        return 0;
    }

    /**
     * 过滤除中文、英文、数字、-和_以外的字符
     */
    static function filter($data) {
        $str = (string)$data;
        $str = preg_replace('/[^A-Za-z0-9\x{4e00}-\x{9fa5}\-_.]/iu','',$str);
        return $str;
    }

    function random_string($max = 6){
        $chars = explode(" ", "0 1 2 3 4 5 6 7 8 9");
        $rtn = '';
        for($i = 0; $i < $max; $i++){
            $rnd = array_rand($chars);
            $rtn .= $chars[$rnd];
        }
        return $rtn;
    }

}
