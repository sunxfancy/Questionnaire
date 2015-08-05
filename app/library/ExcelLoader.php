<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-05 17:21:01
 */

include("../app/classes/PHPExcel.php");

/**
* 
*/
class ExcelLoader
{
	private function __construct() {
		$this->excel_col = array( 'C' => 'name',     'D' => 'sex',      'E' => 'native',       'F' => 'education',
						'G' => 'birthday', 'H' => 'politics', 'I' => 'professional', 'J' => 'employer', 
						'K' => 'unit',     'L' => 'duty');
		$this->edu_name = array('school','profession','degree','date');
		$this->work_name = array('employer','unit','duty','date');
	}

	private static $instance;  
	public static function getInstance()
	{
		if (!(self::$instance instanceof self))  
        {  
            self::$instance = new self();  
        }  
        return self::$instance;  
	}

	public function LoadExaminee ($filename, $project_id, $db)
    {
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        $db->begin(); 
        if (is_readable($filename))
        {
        	try {
	            $objexcel = PHPExcel_IOFactory::load($filename);
	            $sheet = $objexcel->getSheet(0);
	            $higestrow = $sheet->getHighestRow();

	            $last_number = Examinee::lastNum($project_id);
	            echo $last_number."\n";
				$i = 3;
				while ($i <= $higestrow) {
					$k = $sheet->getCell("C".$i)->getValue();
					if (is_null($k) || $k == "") break;
					$last_number++;
		            $this->readline_examinee($sheet, $project_id, $last_number, $i);
		            $i++;
				}
            } catch (Exception $ex) {
				$errors['Exception'] = $ex->getMessage();
				$db->rollback();
				$objexcel->disconnectWorksheets();
				unlink($filename);
				return $errors;
			}
        }
        $db->commit();
        $objexcel->disconnectWorksheets();
        unlink($filename);
        return 0;
    }

	

    public function readline_examinee($sheet, $project_id, $number, $i)
    {
		$examinee = new Examinee();
		foreach ($this->excel_col as $key => $value) {
			$examinee->$value = (string)$sheet->getCell($key.$i)->getValue();
		}
		$education = array();
		$work = array();
		$this->readother_examinee($sheet,$education,$this->edu_name, $i);
		$this->readother_examinee($sheet,$work,     $this->work_name,$i);
		$examinee->other = json_encode(array('education' => $education, 'work' => $work));
		$examinee->number = date('y').sprintf("%02d", $project_id).sprintf("%04d", $number);
		$examinee->password = $this->random_string();
		$examinee->project_id = $project_id;

		if (!$examinee->save()) {
			foreach ($examinee->getMessages() as $message) {
				throw new Exception($message);
			}
		}
	}

    function readother_examinee($sheet, $other_array, $name_array, $i)
    {
		$other_col = 'M';
		for ($j = 0; $j < 4; $j++) {
			for ($k = 0; $k < 4; $k++) { 
				$other_array[$j][$name_array[$k]] = (string)$sheet->getCell($other_col.$i)->getValue();
				$other_col++;
			}
		}
    }

    function random_string($max = 6){
        $chars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
        for($i = 0; $i < $max; $i++){
            $rnd = array_rand($chars);
            $rtn .= base64_encode(md5($chars[$rnd]));
        }
        return substr(str_shuffle(strtolower($rtn)), 0, $max);
    }
}