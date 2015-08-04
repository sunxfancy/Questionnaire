<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-03 11:26:32
 */

/**
* 
*/
class ExcelLoader
{
	public function LoadExaminee ($filename, $db)
    {
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        $db->begin(); 
        if (is_readable($filename))
        {
        	try {
	            $objexcel = PHPExcel_IOFactory::load("./upload/".$filename);
	            $personsheet = $objexcel->getSheet(0);
            }
			catch (Exception $ex)
			{
				$errors['Exception'] = $ex->getMessage();
				$db->rollback();
				$objexcel->disconnectWorksheets();
				unlink("./upload/".$file);
				return $errors;
			}    
        }
        $db->commit();
    }

    $excel_col = array( 'C' => 'name',     'D' => 'sex',      'E' => 'native',       'F' => 'education',
    					'G' => 'birthday', 'H' => 'politics', 'I' => 'professional', 'J' => 'employer', 
    					'K' => 'unit',     'L' => 'duty');
	$edu_name = array('school','profession','degree','date');
	$work_name = array('employer','unit','duty','date');

    public function readline_examinee()
    {
		$higestrow = $sheet->getHighestRow();
		$i = 3;
		while ($i <= $higestrow) {
			$k = $sheet->getCell("C".$i)->getValue();
			if (is_null($k) || $k == "") break;

			$examinee = new Examinee();
			foreach ($excel_col as $key => $value) {
				$examinee[$value] = (string)$sheet->getCell($key.$i)->getValue();
			}
			$education = array();
			$work = array();
			$this->readother_examinee($education,$edu_name,$i);
			$this->readother_examinee($work,$work_name,$i);

			if (!$examinee->save()) {
				foreach ($student->getMessages() as $message) {
					throw new Exception($message);
				}
			}
			$i++;
		}
	}
    

    function readother_examinee($other_array, $name_array, $i)
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