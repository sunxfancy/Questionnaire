<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-05 16:44:12
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

	public static function getInstance()
	{
		static $instance = new self();
		return $instance;
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

				$i = 3;
				while ($i <= $higestrow) {
					$k = $sheet->getCell("C".$i)->getValue();
					if (is_null($k) || $k == "") break;
		            $this->readline_examinee($sheet, $i);
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
        unlink($filename);
        return 0;
    }

	

    public function readline_examinee($sheet, $i)
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
}