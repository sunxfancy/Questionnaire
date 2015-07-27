<?php 
	include("../app/classes/PHPExcel.php");

	class ImportController extends Base
	{
		public function initialize()
		{
			Phalcon\Tag::setTitle('系统管理');
			parent::initialize(); 
			$this->assets->addCss("pagecss/admin.min.css");
			$this->assets->collection('footer')
				->addJs("http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js")
				->addJs("lib/dropzone.min.js");
			$this->view->setTemplateAfter('index-layout');
		}

		public function indexAction()
		{

		}


		public function uploadAction()
		{
			if ($this->request->isPost())
			{
				if ($this->request->hasFiles())
				{
					$files = $this->request->getUploadedFiles();
					$filename = "Import-".date("YmdHis");
					$i = 1;
					foreach ($files as $file)
					{
						$file->moveTo("./upload/".$filename."-".$i.".xls");
						$i++;
					}
					$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
					echo json_encode($this->addschool($filename));
					$this->view->disable();
				}
				else
				{
					$this->flash->error("请求数据无效!");
					$this->response->redirect("import/index");
				}
			}
			else
			{
				$this->flash->error("请求数据无效!");
				$this->response->redirect("import/index");
			}
		}

		//依次是用户名，密码，学校所在地，学校名，管理员姓名，联系方式，邮箱，身份证号
		private $excel_col = array('F','H','B','C','D','E','F','G');

		public function addschool($filename)
		{
			PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
			$files = scandir("./upload");
			array_shift($files);
			array_shift($files);
			$errors = array();
			$j = 0;
			$this->db->begin();
			foreach ($files as $file)
			{
				if (strstr($file, $filename))
				{
					$objexcel = PHPExcel_IOFactory::load("./upload/".$file);
					$sheet = $objexcel->getSheet(0);
					try
					{
						$higestrow = $sheet->getHighestRow();
						$i = 2;
						while ($i <= $higestrow)
						{
							$k = $sheet->getCell("A".$i)->getValue();
							if (is_null($k) || $k == "") break;
							
							$username = (string)$sheet->getCell($this->excel_col[0].$i)->getValue();
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
			
			$objexcel->disconnectWorksheets();
			unlink("./upload/".$file);
			$this->db->commit();

			return $errors;
		}


		private function newschool($name,$district,$manager){
			
			// 新建学校
			$school = new School();
			$school->name = $name;
			$school->district = $district;
		
			if (!$school->save())
			{
				foreach ($school->getMessages() as $message)
				{
					$this->db->rollback();
					throw new PDOException($message);
				}
				
			}

			// 设定管理员和学校关联
			$manager->school_id = $school->school_id;
			if (!$manager->save())
			{
				foreach ($manager->getMessages() as $message)
				{
					$this->db->rollback();
					throw new PDOException($message);
				}
			}

		}

		public function studentAction()
		{
			
		}

		public function uploadstudentAction()
		{
			if ($this->request->isPost())
			{
				if ($this->request->hasFiles())
				{
					$files = $this->request->getUploadedFiles();
					foreach ($files as $file)
					{
						$filename = $file->getName();
						$file->moveTo("./upload/".$filename);
					}
					$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
					echo json_encode($this->addStudent($filename));
					$this->view->disable();
				}
				else
				{
					$this->flash->error("请求数据无效!");
					$this->response->redirect("import/index");
				}
			}
			else
			{
				$this->flash->error("请求数据无效!");
				$this->response->redirect("import/index");
			}
		}

		public function addStudent($filename)
		{
			$this->db->begin();
			$school =  School::findFirst(array(
				'name = :filename:',
				'bind' => array('filename' => substr($filename,0,strlen($filename)-4))
			));
			try {
				$test = $this->addTest($school);
				$this->addstudents($filename,$test->t_id,$school->school_id);
			} catch (PDOException $ex){
				$this->db->rollback();
				return $ex->getMessage();
			}
			$this->db->commit();	
		}

		public function addTest($school)
		{
			$test = Test::findFirst(array(
				'school_id = :id:',
				'bind' => array('id' => $school->school_id)
			));
			if ($test != false) {
				return $test;
			}

			$test = new Test();
			$test->people = 2;
            $test->school_id = $school->school_id;
            $test->begin_time = '2014-12-5 00:00:00';
            $test->end_time = '2014-12-15 23:59:59';
            $parts = Part::find();
            $test->exam_num = $parts->Count();
            $test->description = '2014心理健康测评';
            if (!$test->save())
            {
            	foreach ($school->getMessages() as $message)
				{
					throw new PDOException($message);
				}
            }

            foreach ($parts as $part)
            {
                $tprel = new Tprel();
                $tprel->test_id = $test->t_id;
                $tprel->part_id = $part->p_id;
                $tprel->save();
            } 

			return $test;
		}

	private function addstudents($filename, $t_no, $school_id)
	{
            PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip);
            $files = scandir("./upload");
            array_shift($files);
            array_shift($files);
            $errors = array();
            $j = 0;
            // $this->db->begin();
            foreach ($files as $file)
            {
                if (strstr($file, $filename))
                {
                    $objexcel = PHPExcel_IOFactory::load("./upload/".$file);
                    $sheet = $objexcel->getSheet(0);
                    $i = 2;
                    $highestrow = $sheet->getHighestRow();
                    while ($i <= $highestrow)
                    {
                        // 增加了检测，但是没有用
						if($sheet->getCell("C".$i)->isFormula())
                        {
                            $username = trim((string)$sheet->getCell("C".$i)
                                                      ->getOldCalculatedValue());
                        }
                        else
                        {
                            $username = trim((string)$sheet->getCell("C".$i)
                                                      ->getValue());
                        }
                        if ($username == "" || $username == null) break;

                        $student = Student::findFirst(array(
                        	'username = :username: and school_id = :school_id:',
                        	'bind' => array('username' => $username,'school_id' => $school_id)
                        ));
                        if ($student == false) {
                        	$student = new Student();
                        	$student->test_id = $t_no;
		                    $student->school_id = $school_id;
		                    $student->status = 0;
                        }
                        
                        if($sheet->getCell("A".$i)->isFormula())
                        {
                            $stu_no = trim((string)$sheet->getCell("A".$i)
                                                         ->getOldCalculatedValue());
                        }
                        else
                        {
                            $stu_no = trim((string)$sheet->getCell("A".$i)
                                                         ->getValue());
                        }
                        $student->stu_no = $stu_no;

                        $student->name = trim((string)$sheet->getCell("B".$i)
                                                            ->getValue());

                        $student->username = $username;

                        if($sheet->getCell("D".$i)->isFormula())
                        {
                            $pwd = trim((string)$sheet->getCell("D".$i)
                                         ->getOldCalculatedValue());
                        }
                        else
                        {
                            $pwd = trim((string)$sheet->getCell("D".$i)
                                         ->getValue());
                        }

                        $student->password = hash("sha256", $pwd);
                        $sex = trim((string)$sheet->getCell("E".$i)
                                     ->getValue());
                        if ($sex == "male")
                        {
                            $student->sex = 1;
                        }
                        else
                        {
                            if ($sex == "female")
                            {
                                $student->sex = 0;
                            }
                        }
                        $student->college = trim((string)$sheet->getCell("F".$i)
                                                  ->getValue());
                        $student->major = trim((string)$sheet->getCell("G".$i)
                                                ->getValue());
                        $student->grade = (int)$sheet->getCell("H".$i)
                                                ->getValue();
                        $student->class = trim((string)$sheet->getCell("I".$i)
                                              ->getValue());
                        $student->birthday = trim((string)$sheet->getCell("J".$i)
                                                      ->getValue());
                        $nativeplace = trim((string)$sheet->getCell("K".$i)->getValue()) == "城市" ? 1 : 0;
                        $student->nativeplace = $nativeplace;
                        $singleton = trim((string)$sheet->getCell("L".$i)->getValue()) == "是" ? 1 : 0;
                        $student->singleton = $singleton;
                        $student->nation = trim((string)$sheet->getCell("M".$i)
                                                             ->getValue());
                        if (!$student->save())
                        {
                            $errors[$j] = $student->getMessages();
                            $j++;
                        }

                        $i++;
                    }
                    $objexcel->disconnectWorksheets();
                    unlink("./upload/".$file);
                }
            }
            if (count($errors) > 0)
            {
                // $this->db->rollback();
                throw new PDOException($errors[0]);
            }
        }

	}