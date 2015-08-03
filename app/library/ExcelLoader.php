<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-03 10:04:19
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
            $objexcel = PHPExcel_IOFactory::load("./upload/".$filename);
            $personsheet = $objexcel->getSheet(0);


        }
    }

    $excel_col = array( 'C' => 'name',     'D' => 'sex' ,     'E' => 'native' ,'F' => 'education'
    					'G' => 'birthday', 'H' => 'politics', 'I' => 'professional', 
    					'J' => 'employer', 'K' => 'unit',     'L' => 'duty')

    public function readline_examinee($db)
    {
    	try {
			$higestrow = $sheet->getHighestRow();
			$i = 3;
			while ($i <= $higestrow) {
				$k = $sheet->getCell("C".$i)->getValue();
				if (is_null($k) || $k == "") break;
				
				$name = (string)$sheet->getCell($this->excel_col[0].$i)->getValue();
				$password = (string)$sheet->getCell($this->excel_col[1].$i)->getValue();
				$district = (string)$sheet->getCell($this->excel_col[2].$i)->getValue();
				$schoolname = (string)$sheet->getCell($this->excel_col[3].$i)->getValue();
				$realname = (string)$sheet->getCell($this->excel_col[4].$i)->getValue();
				$phone = (string)$sheet->getCell($this->excel_col[5].$i)->getValue();
				$email = (string)$sheet->getCell($this->excel_col[6].$i)->getValue();
				$ID_number = (string)$sheet->getCell($this->excel_col[7].$i)->getValue();

				$manager = new Manager();
				if ($manager->signup($username, $password, $phone, $email, $realname, $ID_number))
				{
					$this->newschool($schoolname,$district,$manager);
				} else {
					throw new PDOException();
				}

				$i++;
			}
		}
		catch (PDOException $ex)
		{
			$errors['PDOException'] = $ex->getMessage();
			$this->db->rollback();
			$objexcel->disconnectWorksheets();
			unlink("./upload/".$file);
			// throw $ex;
			return $errors;
		}    
	}
           
}