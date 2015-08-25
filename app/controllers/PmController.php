<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:18:46
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-14 17:37:25
 */

/**
* 
*/
class PmController extends Base
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->setTemplateAfter('base2');
        $this->leftRender('北京政法系统人才测评项目管理平台');
    }

	public function detailAction()
	{
		
	}

	public function examineeAction()
	{
		# code...
	}

	public function interviewerAction()
	{
		# code...
	}

	public function leaderAction()
	{
		# code...
	}

	public function resultAction()
	{
		# code...
	}

    public function testAction()
    {
        echo date('y');
        $this->view->disable();
    }

    public function selectmoduleAction()
    {
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 试 模 块 选 择');

    }

    public function disp_moduleAction(){
        $manager=$this->session->get('Manager');
        if($manager){
            $pmrels=Pmrel::find(array(
                "project_id=?1",
                "bind"=>array(1=>$manager->project_id)
                ));
            $ans='';
            for ($i=0; $i < sizeof($pmrels); $i++) { 
                $module=Module::findFirst($pmrels[$i]->module_id);
                $ans.=$module->chs_name.'|';
            }

            $this->dataBack(array("select"=>$ans));
        }else{
            $this->dataBack(array('error'=>"您的身份验证出错,请重新登录"));
        }
    }

    public function uploadexamineeAction()
    {
        $this->upload_base('LoadExaminee');
    }

    public function uploadinterviewerAction()
    {
        $this->upload_base('LoadInterviewer');
    }

    public function uploadleaderAction()
    {
        $this->upload_base('LoadLeader');
    }

    public function upload_base($method)
    {
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $this->view->disable();
        if ($this->request->isPost() && $this->request->hasFiles())
        {
            $files = $this->request->getUploadedFiles();
            $filename = "Import-".date("YmdHis");
            $excel = ExcelLoader::getInstance();
            $project_id = $this->session->get('Manager')->project_id;
            echo $project_id ."\n";
            $i = 1;
            foreach ($files as $file) {
                $newname = "./upload/".$filename."-".$i.".xls";
                echo $newname."\n";
                $file->moveTo($newname);
                $ans = $excel->$method($newname, $project_id, $this->db);
                echo $ans ."\n";
                if ($ans != 0) { echo json_encode($ans); return; }
                $i++;
            }
            echo 0;
        } else {
            echo json_encode(array('error' => '错误的接口访问'));
        }
    }

	public function listexamineeAction()
	{
        $project_id = $this->getProjectId();
        $builder = $this->modelsManager->createBuilder()                            
                                       ->from('Examinee')
                                       ->where("project_id = '$project_id'");
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else
            $sort = 'number';
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
	}

	public function updateexamineeAction()
    {
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $examinee = Examinee::findFirst($id);
            $examinee->name       = $this->request->getPost('name', 'string');
            $examinee->password   = $this->request->getPost('password', 'string');
            if (!$examinee->save()) {
                foreach ($examinee->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $examinee = Examinee::findFirst($id);
            if (!$examinee->delete()) {
                foreach ($examinee->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

    public function listinterviewerAction()
    {
        $project_id = $this->getProjectId();
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
                                       //->join('Project','Project.project_id=Manager.project_id')
                                       ->where("Manager.role = 'I' AND Manager.project_id = '$project_id'");
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else
            $sort = 'username';
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
    }

    function getProjectId() {
        $manager = $this->session->get('Manager');
        return $manager->project_id;
    }

    public function updateinterviewerAction()
    {
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password       = $this->request->getPost('password', 'string');
            if (!$manager->save()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            if (!$manager->delete()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

    public function listleaderAction()
    {
        $project_id = $this->getProjectId();
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
                                       //->join('Project','Project.project_id=Manager.project_id')
                                       ->where("Manager.role = 'L' AND Manager.project_id = '$project_id'");
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else
            $sort = 'id';
        if ($sord != null)
            $sort = $sort.' '.$sord;
        $builder = $builder->orderBy($sort);
        $this->datareturn($builder);
    }

    public function updateleaderAction()
    {
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password       = $this->request->getPost('password', 'string');
            if (!$manager->save()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
        if ($oper == 'del') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            if (!$manager->delete()) {
                foreach ($manager->getMessages() as $message) {
                    echo $message;
                }
            }
        }
    }

    public function writeselectedmoduleAction(){
        $this->view->disable();
        $manager=$this->session->get('Manager');
        if($manager){
            $checkeds=$this->request->getpost('checkeds');
            $values=$this->request->getpost('values');
            $this->db->begin();
            try{
                $pmrel_ori=Pmrel::find(array(
                        "project_id=?1",
                        "bind"=>array(1=>$manager->project_id)
                    ));
                for ($i=0; $i <sizeof($pmrel_ori) ; $i++) { 
                    $pmrel_ori[$i]->delete();
                }


                for($i=0;$i<sizeof($checkeds);$i++){
                    if($checkeds[$i]=='true'){
                        $module=Module::findFirst(array(
                        "chs_name= ?1",
                        "bind" => array( 1=> $values[$i])));
                        $pmrel=new Pmrel();
                        $pmrel->project_id=$manager->project_id;
                        $pmrel->module_id=$module->id;
                        $pmrel->save();
                    }
                 
                }
                $this->dataBack(array('url' =>'/pm/index'));
                $this->db->commit();
            }catch(Exception $e){
                $this->db->rollback();
                $this->dataBack(array('error' =>"保存错误,请重新操作!"));
            }
        }else{
            $this->dataBack(array('error' => "您的身份验证出错!请重新登录!"));
        }
    }

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

    public function infoAction($examinee_id){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('个人信息查看');
        $examinee = Examinee::findFirst($examinee_id);
        $this->view->setVar('name',$examinee->name);
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $this->view->setVar('sex',$sex);
        $this->view->setVar('education',$examinee->education);
        $this->view->setVar('degree',$examinee->degree);
        $this->view->setVar('birthday',$examinee->birthday);
        $this->view->setVar('native',$examinee->native);
        $this->view->setVar('politics',$examinee->politics);
        $this->view->setVar('professional',$examinee->professional);
        $this->view->setVar('employer',$examinee->employer);
        $this->view->setVar('unit',$examinee->unit);
        $this->view->setVar('duty',$examinee->duty);
        $this->view->setVar('team',$examinee->team);
    }

    //以excel形式，导出被试人员信息和测试结果
    public function checkAction($examinee_id){
        
        $this->view->disable();
        $examinee = Examinee::findFirst($examinee_id);
        $this->checkoutExcel($examinee);
        // $work = json_decode($examinee->other)->work;
        // echo "<pre>";
        // print_r($work);
        // $sumWork = count($work)+2;
        // if($sumWork<5)
        //     $sumWork = 5;
        // for($i = 0;$i<=$sumWork;$i++){
        //     $j = 1;
        //     $Work[$i] = (array)$Work[$i];
        //     foreach ((array)$work[$i] as $key => $value) {
        //         echo $key."=>".$value."------";
        //         $j++;
        //     }
        // }
        // $education = (array)$education;
        // echo "<pre>";
        // print_r($education);
        // print_r(gettype($education[0]));
        // $sum = count($education);
        // print_r($sum);
        // // print_r($examinee->birthday);
        
        // for($i = 7;$i<=$sum+7;$i++){
        //     $j = 1;
        //     $k = $i -7;
        //     $education[$k] = (array)$education[$k];
        //     print_r(gettype($education[$k]));
        //     foreach ($education[$k] as $key => $value) {
        //         echo $key." ".$value."   ";
        //         // $objActSheet->setCellValue("$letter[$j]$i","$value");
        //         $j++;
        //     }
        // }
        // echo "<pre>";
        // print_r($aaa->education[0]->school);
    }

    public function checkoutExcel($examinee){
        //导出个人信息表
        require_once("../app/classes/PHPExcel.php");
        PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        $cacheSettings = array('memoryCacheSize'=>'256MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $excel = new PHPExcel();
        $excel->getActiveSheet()->setTitle('个人信息表');
        //个人信息表
        $objActSheet = $excel->getActiveSheet();
        $objActSheet->getDefaultRowDimension()->setRowHeight(25);
        $objActSheet->getDefaultColumnDimension()->setWidth(20);

        // $objActSheet->getRowDimension('A')->setRowHeight(50);
        $objActSheet->getRowDimension(1)->setRowHeight(50);
        $objActSheet->mergeCells('A1:F1');
        $objActSheet->setCellValue('A1','测评人员个人基本情况');
        $objActSheet->getStyle('A1')->getFont()->setSize(20);
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->setCellValue('A2','姓名');
        $objActSheet->setCellValue('B2',$examinee->name);
        $objActSheet->setCellValue('C2','性别');
        $sex = ($examinee->sex == "1") ? "男" : "女";
        $objActSheet->setCellValue('D2',$sex);
        $objActSheet->setCellValue('E2','生日');
        $objActSheet->setCellValue('F2',$examinee->birthday);

        $objActSheet->setCellValue('A3','籍贯');
        $objActSheet->setCellValue('B3',$examinee->native);
        $objActSheet->setCellValue('C3','学历');
        $objActSheet->setCellValue('D3',$examinee->education);
        $objActSheet->setCellValue('E3','学位');
        $objActSheet->setCellValue('F3',$examinee->degree);
        
        $objActSheet->setCellValue('A4','政治面貌');
        $objActSheet->mergeCells('B4:C4');
        $objActSheet->setCellValue('B4',$examinee->politics);
        $objActSheet->setCellValue('D4','职称');
        $objActSheet->mergeCells('E4:F4');
        $objActSheet->setCellValue('F4',$examinee->professional);

        $objActSheet->setCellValue('A5','工作单位');
        $objActSheet->mergeCells('B5:C5');
        $objActSheet->setCellValue('B5',$examinee->employer);
        $objActSheet->setCellValue('D5','班子/系统成员');
        $objActSheet->mergeCells('E5:F5');
        $objActSheet->setCellValue('E5',$examinee->team);

        $objActSheet->setCellValue('A6','部门');
        $objActSheet->mergeCells('B6:C6');
        $objActSheet->setCellValue('B6',$examinee->unit);
        $objActSheet->setCellValue('D6','岗位/职务');
        $objActSheet->mergeCells('E6:F6');
        $objActSheet->setCellValue('E6',$examinee->duty);

        $objActSheet->mergeCells('A7:A11');
        $objActSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('A7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->getStyle('A1:F30')->getAlignment()->setWrapText(TRUE);
        $objActSheet->setCellValue('A7','教育经历（自高中毕业后起，含在职教育经历）');
        $education = json_decode($examinee->other)->education;
        $letter = array('A','B','C','D','E','F');
        $sumEducation = count($education)+2;
        if($sumEducation<5)
            $sumEducation = 5;
        $objActSheet->setCellValue('B7','毕业院校');
        $objActSheet->setCellValue('C7','专业');
        $objActSheet->setCellValue('D7','所获学位');
        $objActSheet->setCellValue('E7','起止时间');
        for($i = 8;$i<=$sumEducation+8;$i++){
            $j = 1;
            $education[$i-8] = (array)$education[$i-8];
            foreach ($education[$i-8] as $key => $value) {
                $objActSheet->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }

        $objActSheet->mergeCells('A12:A16');
        $objActSheet->getStyle('A12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('A12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objActSheet->setCellValue('A12','工作经历');        
        $work = json_decode($examinee->other)->work;
        $sumWork = count($work)+2;
        if($sumWork<5)
            $sumWork = 5;
        $objActSheet->setCellValue('B12','就职单位');
        $objActSheet->setCellValue('C12','部门');
        $objActSheet->setCellValue('D12','职位');
        $objActSheet->setCellValue('E12','工作时间');
        for($i = 13;$i<=$sumWork+13;$i++){
            $j = 1;
            $Work[$i-13] = (array)$Work[$i-13];
            foreach ((array)$work[$i-13] as $key => $value) {
                $objActSheet->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }

        $write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="result.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }

    public function testexcel(){
        require_once("../app/classes/PHPExcel.php");
        $excel = new PHPExcel();
        $excel->getActiveSheet()->setTitle('个人信息表');
        $letter = array('A','B','C','D','E','F','G');
        $tableheader = array('学号','姓名','性别','年龄','班级');
        for($i = 0;$i<count($tableheader);$i++){
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        $data = array(
                        array('1','小王','男','20','100'),
                        array('2','小王','女','20','100'),
                        array('3','小王','男','20','100'),
                        array('4','小王','女','20','100'),
                        array('5','小王','女','20','100'),
                        array('6','小王','男','20','100')
                        );
        for($i = 2;$i<=count($data)+1;$i++){
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        //创建第二张表格
        $msgWorkSheet = new PHPExcel_Worksheet($excel, 'card_message'); //创建一个工作表
        $excel->addSheet($msgWorkSheet); //插入工作表
        $excel->setActiveSheetIndex(1); //切换到新创建的工作表
        
        for($i = 0;$i<count($tableheader);$i++){
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        
        for($i = 2;$i<=count($data)+1;$i++){
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        $styleArray1 = array(
                    'font' => array(
                            'bold' => true,
                            'size'=>12,
                            'color'=>array(
                            'argb' => '00000000',
                                ),
                            ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            ),
                    'borders' => array (
                            'outline' => array (
                                        // 'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                                        'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
                                        // 'color' => array ('argb' => 'FF000000'),          //设置border颜色
                                    ),
                             ),
                    );
        // 将A1单元格设置为加粗，居中
        $excel->getActiveSheet()->getStyle('C1:D3')->applyFromArray($styleArray1);
        $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        // $styleArray = array(
        //                'borders' => array(
        //                     'allborders' =>array(
        //                             'style'=>PHPExcel_Style_Border::BORDER_THIN,
        //                             ),
        //                     ),
        //                );
        // $excel->getActiveSheet()->getStyle('C1:C3')->applyFormArray($styleArray);
        // $msgWorkSheet->getActiveSheet()->getStyle('C3')->applyFormArray(
        //             array(
        //                     'font' => array('bold' =>true),
        //                     'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        //                     )
        //             );
        // $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        // $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(false);


        //创建第三张表格
        $pf16 = new PHPExcel_Worksheet($excel,'16pf');
        $excel->addSheet($pf16);
        $excel->setActiveSheetIndex(2);

        for($i = 0;$i<count($tableheader);$i++){
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        for($i = 2;$i<=count($data)+1;$i++){
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        $excel->getActiveSheet()->mergeCells('A1:E5');

        

        $write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="result.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }


}