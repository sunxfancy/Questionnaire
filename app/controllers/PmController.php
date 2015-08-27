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

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;


class PmController extends Base
{
    public function initialize(){
        parent::initialize();
    }

    public function indexAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('北京政法系统人才测评项目管理平台');
    }

	public function detailAction(){
		
	}

	public function examineeAction(){
		# code...
	}

	public function interviewerAction(){
		# code...
	}

	public function leaderAction(){
		# code...
	}

	public function resultAction(){
		# code...
	}

    public function selectmoduleAction(){
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 试 模 块 选 择');
    }

    public function disp_moduleAction(){
        $manager=$this->session->get('Manager');
        if($manager){
            $project_detail = ProjectDetail::findFirst(array(
                "project_id=?1",
                "bind"=>array(1=>$manager->project_id)
                ));
            $module_name = array();
            $module_names = $project_detail->module_names;
            $module_name = explode(',', $module_names);
            $ans='';
            for ($i=0; $i < sizeof($module_name); $i++) { 
                $module=Module::findFirst(array(
                    'name=?1',
                    'bind'=>array(1=>$module_name[$i])));
                $ans.=$module->chs_name.'|';
            }
            $this->dataBack(array("select"=>$ans));
        }else{
            $this->dataBack(array('error'=>"您的身份验证出错,请重新登录"));
        }
    }

    public function uploadexamineeAction(){
        $this->upload_base('LoadExaminee');
    }

    public function uploadinterviewerAction(){
        $this->upload_base('LoadInterviewer');
    }

    public function uploadleaderAction(){
        $this->upload_base('LoadLeader');
    }

    public function uploadInqueryAction(){
        $project_id = $this->session->get('Manager')->project_id;
        $delete_data = InqueryQuestion::find(array(
                'project_id = :project_id:',
                'bind' => array(
                        'project_id' => $project_id
                    )
            ));
        $res = $delete_data->delete();
        $this->upload_base('LoadInquery');
    }

    public function upload_base($method){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $this->view->disable();
        if ($this->request->isPost() && $this->request->hasFiles())
        {
            $files = $this->request->getUploadedFiles();
            $filename = "Import-".date("YmdHis");
            $excel = ExcelLoader::getInstance();
            $project_id = $this->session->get('Manager')->project_id;
            // echo $project_id ."\n";
            $i = 1;
            foreach ($files as $file) {
                $newname = "./upload/".$filename."-".$i.".xls";
                // echo $newname."\n";
                $file->moveTo($newname);
                $ans = $excel->$method($newname, $project_id, $this->db);
                // echo $ans ."\n";
                if ($ans != 0) { echo json_encode($ans); return; }
                $i++;
            }
            // echo 0;
        } else {
            echo json_encode(array('error' => '错误的接口访问'));
        }
    }

	public function listexamineeAction(){
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

	public function updateexamineeAction(){
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

    public function listinterviewerAction(){
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
        // $this->datareturn($builder);
        $this->interviewData($builder);
    }

    public function updateinterviewerAction(){
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

    public function listleaderAction(){
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

    public function updateleaderAction(){
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
        CheckoutExcel::checkoutExcel11($examinee);
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

    public function writeprojectdetailAction(){
        $manager=$this->session->get('Manager');
        if($manager){
            $project_id = $manager->project_id;
            $module_names = array();
            $checkeds=$this->request->getpost('checkeds');
            $values=$this->request->getpost('values'); 
            for($i=0;$i<sizeof($checkeds);$i++){
                if($checkeds[$i]=='true'){
                    $module_names[]=$this->getModuleName($values[$i]);
                }  
            }
            $index_names = $this->getIndex($module_names);
            $factor_names = $this->getFactor($index_names);
            $exam_json = $this->getNumber($factor_names);
            $module_names = implode(',', $module_names);
            $index_names = implode(',', $index_names);
            $factors = array();
            foreach ($factor_names as $factor_name) {
                $factor = Factor::findFirst(array(
                    'name=?1',
                    'bind'=>array(1=>$factor_name)));
                $paper_id = $factor->paper_id;
                $paper_name = Paper::findFirst($paper_id)->name;
                $factor_id = $factor->id;
                $factors[$paper_name][$factor_id] = $factor_name;
            }
            $factor_json = json_encode($factors,JSON_UNESCAPED_UNICODE);
            try{
                $manager     = new TxManager();
                $transaction = $manager->get();

                $project_detail = new ProjectDetail();
                $project_detail->project_id = $project_id;
                $project_detail->module_names = $module_names;
                $project_detail->index_names = $index_names;
                $project_detail->factor_names = $factor_json;
                $project_detail->exam_json = $exam_json;
                if( $project_detail->save() == false ){
                    $transaction->rollback("Cannot insert ProjectDetail data");
                }   
                $this->dataBack(array('url' =>'/pm/index'));
                $transaction->commit();
                return true;
            }catch (TxFailed $e) {
                throw new Exception("Failed, reason: ".$e->getMessage());
            }
        }else{
        $this->dataBack(array('error' => "您的身份验证出错!请重新登录!"));
        }
    }

    public function getModuleName($module_chs_name){
        $module = Module::findFirst(array(
            'chs_name=?1',
            'bind'=>array(1=>$module_chs_name)));
        $module_name = $module->name;
        return $module_name;
    }

    /*
    传入参数：模块name
    动作：查询Module表,找出选定的指标
    返回参数：指标name
    */
    public function getIndex($module_name){
        $index_name = array();
        for ($i=0; $i < sizeof($module_name); $i++) { 
            $module = Module::findFirst(array(
                'name=?1',
                'bind'=>array(1=>$module_name[$i])));
            $children = $module->children;
            $children = explode(",", $children);
            for ($j=0; $j < sizeof($children); $j++) { 
                $index_name[] = $children[$j];
            }
        }
        return explode(",",implode(",",array_unique($index_name)));
    }

    /*
    传入参数：指标name
    动作：查询Index表,找出选定的因子
    返回参数：因子name
    */
    public function getFactor($index_name){
        $factor_names = array();
        for ($i=0; $i <sizeof($index_name) ; $i++) {
            $index = Index::findFirst(array(
                'name=?1',
                'bind'=>array(1=>$index_name[$i])));
            $children = $index->children;
            $childrentype = $index->children_type;
            $children = explode(",",$children );           
            $childrentype = explode(",", $childrentype);
            for ($j=0; $j < sizeof($childrentype); $j++) { 
                //0代表index，1代表factor
                if ($childrentype[$j] == "0") {
                    $index1 = Index::findFirst(array(
                        'name=?1',
                        'bind'=>array(1=>$children[$j])));
                    $children1 = $index1->children;
                    $children1 = explode(",",$children1);
                    for ($k=0; $k <sizeof($children1) ; $k++) {
                        $factor_names[] = $children1[$k];
                    }
                }
                else{   
                        $factor_names[] = $children[$j];
                }               
            }
        }     
        $factor_names = explode(",",implode(",",array_unique($factor_names)));
        return $factor_names;
    }

    /*
    传入参数：因子name
    动作：查询Factor表,找出选定的问卷名和题目序号
    返回参数：json格式的问卷name和题目number
    */
    public function getNumber($factor_name){
        $questions_number = array();
        for ($i=0; $i <sizeof($factor_name) ; $i++) {         
            $factor = Factor::findFirst(array(
                'name=?1',
                'bind'=>array(1=>$factor_name[$i])));         
            $children = $factor->children;
            $childrentype = $factor->children_type;
            $children = explode(",",$children );
            $childrentype = explode(",", $childrentype);
            for ($j=0; $j < sizeof($childrentype); $j++) { 
                //0代表factor，1代表question
                if ($childrentype[$j] == "0") {
                    $factor1 = Factor::findFirst(array(
                        'name=?1',
                        'bind'=>array(1=>$children[$j])));
                    $children1 = $factor1->children;
                    $children1 = explode(",",$children1);
                    for ($k=0; $k <sizeof($children1) ; $k++) { 
                        $paper_name = Paper::findFirst($factor1->paper_id)->name;  
                        $questions_number[$paper_name][] =trim( $children1[$k],' ');
                    }
                }
                else{ 
                    $paper_name = Paper::findFirst($factor->paper_id)->name; 
                    $questions_number[$paper_name][] =trim( $children[$j],' ');
                }               
            }
        }
        foreach ($questions_number as $key => $value) {
            $questions_number[$key] = $this->sort_and_unique($questions_number[$key]);
        }
        $json = json_encode($questions_number,JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function getPaperId($paper_name){
        $paper = Paper::findFirst(array(
            'name=?1',
            'bind'=>array(1=>$paper_name)));
        return $paper->id;
    }

    public function sort_and_unique($array){
        $array = explode(",",implode(",",array_unique($array)));
        $length = sizeof($array);
        for($i=0;$i<$length;$i++)
        {
            $array[$i] = intval($array[$i]);
        } 
        sort($array);
        return $array;       
    }

    public function userdivideAction($manager_id){
       $this->view->setVar('manager_id',$manager_id);
       $this->view->setTemplateAfter('base2');
       $this->leftRender('测试人员分配');
    }
    
    public function examineeofmanagerAction($manager_id){
       $condition = 'manager_id = :manager_id:';
       $row = Interview::find(
               array(
                       $condition,
                       'bind' => array(
                               'manager_id' => $manager_id
                       )
               )
       );
       $term = '';
       foreach($row as $key => $item){
           $term .= ' id='.$item->examinee_id.' OR ';
       }
       if(empty($term)){
           $term = 0;
       }else{
           $term = substr($term,0,strlen($term)-3);
       }
       $builder = $this->modelsManager->createBuilder()
       ->from('Examinee')
       ->where($term);
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

    public function getInterviewResult($manager_id){
        $condition = 'manager_id = :manager_id:';
        $rows = Interview::find(
            array(
                $condition,
                'bind' => array(
                    'manager_id' => $manager_id
                )
            )
        );
        $total = count($rows);
        $term = 'remark is not null AND advantage is not null AND disadvantage is not null AND manager_id=:manager_id:';
        $col = Interview::find(
            array(
                $term,
                'bind' => array(
                    'manager_id' => $manager_id
                )
            )
        );
        $part_num = count($col);
        $msg = $part_num.'/'.$total;
        return $msg;
    }

    public function interviewData($builder){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $limit = $this->request->getQuery('rows', 'int');
        $page = $this->request->getQuery('page', 'int');
        if (is_null($limit)) $limit = 10;
        if (is_null($page)) $page = 1;
        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array("builder" => $builder,
            "limit" => $limit,
            "page" => $page));
        $page = $paginator->getPaginate();
        $ans = array();
        $ans['total'] = $page->total_pages;
        $ans['page'] = $page->current;
        $ans['records'] = $page->total_items;
        foreach ($page->items as $key => $item){
            $item->degree_of_complete = $this->getInterviewResult($item->id);
            $ans['rows'][$key] = $item;
            // $res = $this->getInterviewResult($item->id);
            // $ans['rows'][$key]['degree_of_complete'] = $res;
        }
        echo json_encode($ans);
        $this->view->disable();
    }

    function getProjectId() {
        $manager = $this->session->get('Manager');
        return $manager->project_id;
    }

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

    /*
     * 测试人员导出
     */
    public function examineeExportAction(){
        $project_id = $this->session->get('Manager')->project_id;
        $condition = 'project_id = :project_id:';
        $examinee = Examinee::find(array(
            $condition,
            'bind' => array(
                'project_id' => $project_id
            )
        ));
        $result = array();
        foreach($examinee as $key => $item){
            $result[$key] = $item;
        }
        $excelExport = new ExcelExport();
        $excelExport->ExamineeExport($result);
    }

    /*
     * 面询人员导出
     */
    public function interviewerExportAction(){
        $result = $this->interviewInfo('I');
        $excelExport = new ExcelExport();
        $excelExport->InterviewerExport($result);
    }

    /*
     * 领导导出
     */
    public function leaderExportAction(){
        $result = $this->interviewInfo('L');
        $excelExport = new ExcelExport();
        $excelExport->LeaderExport($result);
    }

    public function interviewInfo($role){
        $project_id = $this->session->get('Manager')->project_id;
        $condition = 'role = :role: AND project_id = :project_id:';
        $interviewer = Manager::find(array(
            $condition,
            'bind' => array(
                'role' => $role,
                'project_id' => $project_id
            )
        ));
        $result = array();
        foreach($interviewer as $key => $item){
            $result[$key] = $item;
        }
//        return json_decode($result,true);
        return $result;
    }

}