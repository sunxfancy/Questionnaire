<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-06 17:17:09
 */

include("../app/classes/PHPExcel.php");



/**
* 
*/
class ExcelLoader
{
	private function __construct() {
		$this->excel_col = array( 'C' => 'name',     'E' => 'native',   'F' => 'education',
								  'G' => 'birthday', 'H' => 'politics', 'I' => 'professional', 
								  'J' => 'employer', 'K' => 'unit',     'L' => 'duty');
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

	/**
	 * 被试人员导入
	 * TODO: 后面超过4条的部分
	 */
	public function LoadExaminee ($filename, $project_id, $db)
    {
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        $project = Project::findFirst($project_id);
        $last_number = 1;
        $db->begin(); 
        if (is_readable($filename))
        {
        	try {
	            $objexcel = PHPExcel_IOFactory::load($filename);
	            $sheet = $objexcel->getSheet(0);
	            $higestrow = $sheet->getHighestRow();

	            $last_number = $project->last_examinee_id;
				$i = 3;
				while ($i <= $higestrow) {
					$k = $sheet->getCell("C".$i)->getValue();
					if (is_null($k) || $k == "") break;
					$this->readline_examinee($sheet, $project_id, $last_number, $i);
					$i++; $last_number++;
				}
            } catch (Exception $ex) {
				$errors['Exception'] = $ex->getMessage();
				$db->rollback();
				$objexcel->disconnectWorksheets();
				unlink($filename);
				return $errors;
			}
        }
        $project->last_examinee_id = $last_number;
        $project->save();
        $db->commit();

        $objexcel->disconnectWorksheets();
        unlink($filename);
        return 0;
    }

    public function readline_examinee($sheet, $project_id, $number, $i)
    {
		$examinee = new Examinee();
		foreach ($this->excel_col as $key => $value) {
			$examinee->$value = self::filter($sheet->getCell($key.$i)->getValue());
		}
		$sex = self::filter($sheet->getCell($key.$i)->getValue());
		if ($sex == '男' || $sex == 1) $examinee->sex = 1;
		else $examinee->sex = 1;
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
				$other_array[$j][$name_array[$k]] = self::filter($sheet->getCell($other_col.$i)->getValue());
				$other_col++;
			}
		}
    }



    /**
	 * 需求量表导入
	 */
	public function LoadInquery ($filename, $project_id, $db)
    {
        $this->baseLoad('readline_inquery',$filename, $project_id, $db);
    }

    public function readline_inquery($sheet, $project_id, $i)
    {
    	# code...
    }

	/**
	 * 导入面询专家
	 */
	public function LoadInterviewer ($filename, $project_id, $db)
	{
		$this->baseLoad('readline_interviewer',$filename, $project_id, $db);
	}

    public function readline_interviewer($sheet, $project_id, $i)
    {
		$interviewer = new Manager();
		
		$interviewer->name = self::filter($sheet->getCell('C'.$i)->getValue());
		$interviewer->username = $this->random_string();
		$interviewer->password = $this->random_string();
		$interviewer->role = 'I';
		if (!$interviewer->save()) {
			foreach ($interviewer->getMessages() as $message) {
				throw new Exception($message);
			}
		}
    } 


    /**
     * 导入领导
     */
    public function LoadLeader ($filename, $project_id, $db)
    {
        $this->baseLoad('readline_leader',$filename, $project_id, $db);
    }

    public function readline_leader($sheet, $project_id, $i)
    {
    	$interviewer = new Manager();
		
		$interviewer->name = self::filter($sheet->getCell('C'.$i)->getValue());
		$interviewer->username = $this->random_string();
		$interviewer->password = $this->random_string();
		$interviewer->role = 'L';
		if (!$interviewer->save()) {
			foreach ($interviewer->getMessages() as $message) {
				throw new Exception($message);
			}
		}
    } 




    function baseLoad($funcname,$filename, $project_id, $db)
    {
    	PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        $db->begin(); 
        if (is_readable($filename))
        {
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
        }
        $db->commit();

        $objexcel->disconnectWorksheets();
        unlink($filename);
        return 0;
    }

    /**
	 * 过滤除中文、英文、数字、-和_以外的字符
	 */
	static function filter($data) {
		$str = (string)$data;
		$str = preg_replace('/[^A-Za-z0-9\x{4e00}-\x{9fa5}\-_]/iu','',$str);
		return $str;
	}

	function random_string($max = 6){
        $chars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
        $rtn = '';
        for($i = 0; $i < $max; $i++){
            $rnd = array_rand($chars);
            $rtn .= $chars[$rnd];
        }
        return $rtn;
    }
}


