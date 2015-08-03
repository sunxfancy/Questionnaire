<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-03 10:24:35
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
			catch (PDOException $ex)
			{
				$errors['PDOException'] = $ex->getMessage();
				$db->rollback();
				$objexcel->disconnectWorksheets();
				unlink("./upload/".$file);
				return $errors;
			}    
        }
    }

    $excel_col = array( 'C' => 'name',     'D' => 'sex',      'E' => 'native',       'F' => 'education',
    					'G' => 'birthday', 'H' => 'politics', 'I' => 'professional', 'J' => 'employer', 
    					'K' => 'unit',     'L' => 'duty');

    public function readline_examinee ($db)
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
			
			if (!$examinee->save()) {
				throw new Exception("Error Processing Request", 1);
			}
			$i++;
		}
	}
           
}