<?php
/**
 * @Author: sxf
 * @Date:   2015-08-02 15:33:40
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-02 16:21:46
 */

/**
* 
*/
class ExcelLoader
{
	public function LoadExaminee ($filename, $db)
    {
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
        $files = scandir("./upload");
        array_shift($files);
        array_shift($files);
        $errors = array();
        $factors = array();
        $j = 0;
        $db->begin();
        foreach ($files as $file)
        {
            if (strstr($file, $filename))
            {
                $objexcel = PHPExcel_IOFactory::load("./upload/".$file);
                $personsheet = $objexcel->getSheet(0);
                $part->name = (string)$factorsheet->getCell("B2")
                                                  ->getValue();
                $part->description = (string)$factorsheet->getCell("B3")
                                                         ->getValue();
                try
                {
                    if (!$part->save())
                    {
                        $errors[$j]['error'] = "part";
                        foreach ($part->getMessages() as $key => $message)
                        {
                            $errors[$j][$key] = $message;
                        }
                        $j++;
                        $this->db->rollback();
                        $objexcel->disconnectWorksheets();
                        unlink("./upload/".$file);

                        return $errors;
                    }
                    else
                    {
                        $higestrow = $factorsheet->getHighestRow();
                        $i = 5;
                        while ($i <= $higestrow)
                        {
                            $factor = new Factor();
                            $factor->ratio = $factorsheet->getCell("B".$i)
                                                         ->getValue();
                            $k = $factorsheet->getCell("A".$i)
                                             ->getValue();
                            if (is_null($k) || $k == "") break;
                            if ($factor->save())
                            {
                                $factors["$k"] = $factor->f_id;
                                $fprel = new Fprel();
                                $fprel->factor_id = $factor->f_id;
                                $fprel->part_id = $part->p_id;
                                if (!$fprel->save())
                                {
                                    $errors[$j]['error'] = "fprel";
                                    foreach ($fprel->getMessages() as $key => $message)
                                    {
                                        $errors[$j][$key] = $message;
                                    }
                                    $j++;
                                    $this->db->rollback();
                                    $objexcel->disconnectWorksheets();
                                    unlink("./upload/".$file);

                                    return $errors;
                                }
                            }
                            else
                            {
                                $errors[$j]['error'] = "factor";
                                foreach ($factor->getMessages() as $key => $message)
                                {
                                    $errors[$j][$key] = $message;
                                }
                                $j++;
                                $this->db->rollback();
                                $objexcel->disconnectWorksheets();
                                unlink("./upload/".$file);

                                return $errors;
                            }
                            $i++;
                        }
                        $higestrow = $questionsheet->getHighestRow(); //不可靠
                        $i = 3;
                        while ($i <= $higestrow)
                        {
                            $question = new Question();
                            $topic = (string)$questionsheet->getCell("A".$i)
                                                           ->getValue();
                            if (is_null($topic) || $topic == "") break;
                            $question->topic = $topic;
                            $question->factor_id = $factors[$questionsheet->getCell("C".$i)
                                                                          ->getValue()];
                            $question->options = "";
                            $question->grade = "";
                            $col = "D";
                            $colnum = $questionsheet->getCell("B".$i)
                                                    ->getValue();
                            for ($k = 1; $k <= $colnum; $k++, $col++)
                            {
                                $str = $questionsheet->getCell($col.$i)
                                                     ->getValue();
                                $mem = explode("|", $str);
                                $question->options .= "|".$mem[0];
                                $question->grade .= "|".$mem[1];
                            }
                            $question->options = substr($question->options, 1);
                            $question->grade = substr($question->grade, 1);
                            if (!$question->save())
                            {
                                $errors[$j]['error'] = "question";
                                $errors[$j]['maxrow'] = $higestrow;
                                foreach ($question->getMessages() as $key => $message)
                                {
                                    $errors[$j][$key] = $message;
                                }
                                $j++;
                                $db->rollback();
                                $objexcel->disconnectWorksheets();
                                unlink("./upload/".$file);

                                return $errors;
                            }
                            $i++;
                        }
                    }
                }
                catch (PDOException $ex)
                {
                    foreach ($ex->getMessages() as $key => $message)
                    {
                        $errors[$j][$key] = $message;
                    }
                    $j++;
                    $db->rollback();
                    $objexcel->disconnectWorksheets();
                    unlink("./upload/".$file);
                    throw $ex;
                    //return $errors;
                }
                $objexcel->disconnectWorksheets();
                unlink("./upload/".$file);
            }
        }
        $db->commit();

        return $errors;
    }
}