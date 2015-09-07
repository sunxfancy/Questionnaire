<?php
/**
 * @Author: sxf
 * @Date:   2015-08-01 16:18:46
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-14 17:37:25
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
		$project_id = $this->session->get('Manager')->project_id;
        $project = Project::findFirst($project_id);
        $begintime = date('Y-m-d',strtotime($project->begintime));
        $endtime = date('Y-m-d',strtotime($project->endtime));
        $now = date("Y-m-d");
        $width = 100*round(strtotime($now)-strtotime($begintime))/round(strtotime($endtime)-strtotime($begintime)).'%';
        $detail = $this->getDetail($project_id);
        $this->view->setVar('begintime',$begintime);
        $this->view->setVar('endtime',$endtime);
        $this->view->setVar('now',$now);
        $this->view->setVar('width',$width);
        $this->view->setVar('detail',$detail);
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
        $this->view->setVar('other',$examinee->other);
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
                "bind"=>array(1=>$manager->project_id)));
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

    public function interviewinfoAction($manager_id){
        $this->view->setTemplateAfter('base2');
        $name = Manager::findFirst($manager_id)->name;
        $this->leftRender($name.' 面 询 完 成 情 况');
        $this->view->setVar('manager_id',$manager_id);
        $interview = InterviewInfo::getInterviewResult($manager_id);
        $data = json_encode($interview,true);
        $this->view->setVar('data',$data);
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
                'bind' => array('project_id' => $project_id)));
        $res = $delete_data->delete();
        $this->upload_base('LoadInquery');
    }

    public function upload_base($method){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $this->view->disable();
        if ($this->request->isPost() && $this->request->hasFiles()){
            $files = $this->request->getUploadedFiles();
            $filename = "Import-".date("YmdHis");
            $excel = ExcelLoader::getInstance();
            $project_id = $this->session->get('Manager')->project_id;
            $i = 1;
            foreach ($files as $file) {
                $newname = "./upload/".$filename."-".$i.".xls";
                $file->moveTo($newname);
                $ans = $excel->$method($newname, $project_id, $this->db);
                if ($ans != 0) { echo json_encode($ans); return; }
                $i++;
            }
        } else {
            // echo json_encode(array('error' => '错误的接口访问'));
            alert("请选择导入文件！");
        }
        $this->response->redirect('pm');
    }

	public function listexamineeAction(){
        $project_id = $this->session->get('Manager')->project_id;
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
            $sex = $this->request->getPost('sex', 'string');
            $examinee->sex = ($sex == '女') ? 0 : 1;
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
        // if ($oper == 'add') {
        //     $examinee->name       = $this->request->getPost('name', 'string');
        //     $sex = $this->request->getPost('sex', 'string');
        //     $examinee->sex        = ($sex == '女') ? 0 : 1;
        //     $examinee->password   = $this->request->getPost('password', 'string');
        //     $examinee = Examinee::find(array(
        //     'project_id = :project_id:',
        //     'bind' => array('project_id' => $project_id)));
        //     if(count($examinee) == 0){ 
        //             $last_number = $project_id.'0001';
        //     }else{
        //         $data_num = count($examinee);
        //         $last_number = $examinee[$data_num-1]->number+1;
        //     }
        //     if (!$examinee->save()) {
        //         foreach ($examinee->getMessages() as $message) {
        //             echo $message;
        //         }
        //     }
        // }
    }

    public function listinterviewerAction(){
        $project_id = $this->session->get('Manager')->project_id;
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
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
        $this->interviewData($builder);
    }

    public function updateinterviewerAction(){
        $oper = $this->request->getPost('oper', 'string');
        if ($oper == 'edit') {
            $id = $this->request->getPost('id', 'int');
            $manager = Manager::findFirst($id);
            $manager->name       = $this->request->getPost('name', 'string');
            $manager->password   = $this->request->getPost('password', 'string');
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
        $project_id = $this->session->get('Manager')->project_id;
        $builder = $this->modelsManager->createBuilder()
                                       ->from('Manager')
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

    //以excel形式，导出被试人员信息和测试结果
    public function checkAction($examinee_id){        
        $this->view->disable();
        $project_id = $this->session->get('Manager')->project_id;
        $examinee = Examinee::findFirst($examinee_id);
        if ($examinee->state == 0) {
            $this->dataReturn(array('error'=>'被试还未答题'));
            return ;
        }else if ($examinee->state > 3) {
            CheckoutExcel::checkoutExcel11($examinee,$project_id);
        }else{
            try{
                $id = $examinee->id;
                BasicScore::handlePapers($id);
                BasicScore::finishedBasic($id);
                FactorScore::handleFactors($id);
                FactorScore::finishedFactor($id);
                IndexScore::handleIndexs($id);
                IndexScore::finishedIndex($id);
                CheckoutExcel::checkoutExcel11($examinee,$project_id);
            }catch(Exception $e){
                $this->dataReturn(array('error'=>$e->getMessage()));
                return ;
            }
        }
        
    }

    //以word形式，导出被试人员个人报告
    public function resultReportAction($examinee_id){        
        $this->view->disable();
        $project_id = $this->session->get('Manager')->project_id;
        $examinee = Examinee::findFirst($examinee_id);
        $wordExport = new WordExport();
        $wordExport->examineeReport($examinee,$project_id);
    }

    public function writeprojectdetailAction(){
        $managers=$this->session->get('Manager');
        $project_id =$managers->project_id;
        if($managers){
            $module_names = array();
            $checkeds=$this->request->getpost('checkeds');
            $values=$this->request->getpost('values'); 
            for($i=0;$i<sizeof($checkeds);$i++){
                if($checkeds[$i]=='true'){
                    $module_names[]=$this->getModuleName($values[$i]);
                }  
            }
            if (count($module_names) == 10) {
                $index = Index::find();
                $index_names = array();
                foreach ($index as $indexs) {
                    $index_names[] = $indexs->name;
                }
                $factor = Factor::find();
                $factor_names = array();
                foreach ($factor as $fac) {
                    $factor_names[] = $fac->name; 
                }
                $question = Question::find();
                $examination = array();
                foreach ($question as $questions) {
                    $paper_name = Paper::findFirst($questions->paper_id)->name;
                    $examination[$paper_name][] = $questions->number;
                }
                $exam_json = json_encode($examination,JSON_UNESCAPED_UNICODE);
            }else{
                $index_names = $this->getIndex($module_names);
                $factor_names = $this->getFactor($index_names);
                $exam_json = $this->getNumber($factor_names);
            }
            $factors = array();
            foreach ($factor_names as $factor_name) {
                $factor = Factor::findFirst(array(
                    'name=?1',
                    'bind'=>array(1=>$factor_name)));
                $paper_id = $factor->paper_id;
                $paper_name = Paper::findFirst($paper_id)->name;
                $factor_id = $factor->id;
                $factors[$paper_name][$factor_id] = $factor_name;
                $childrentype = explode(',',$factor->children_type);
                if (in_array(0, $childrentype)) {
                    $factor = explode(',',$factor->children);
                    foreach ($factor as $factor1) {
                        $factorss = Factor::findFirst(array(
                            'name=?1',
                            'bind'=>array(1=>$factor1)));
                        $factors[$paper_name][$factorss->id] = $factor1;
                    }
                }
            }
            $factor_json = json_encode($factors,JSON_UNESCAPED_UNICODE);
            $module_names = implode(',', $module_names);
            $index_names = implode(',', $index_names);
            try{
                $manager     = new TxManager();
                $transaction = $manager->get();

                $project_detail = new ProjectDetail();
                $project_detail->setTransaction($transaction);
                $project_detail->project_id   = $project_id;
                $project_detail->module_names = $module_names;
                $project_detail->index_names  = $index_names;
                $project_detail->factor_names = $factor_json;
                $project_detail->exam_json    = $exam_json;
                if( !$project_detail->save()){
                    $transaction->rollback("Cannot insert ProjectDetail data");
                    $this->dataBack(array('error' => "存储失败！请重新提交！!"));
                    return false;
                }else{  
                    $this->dataBack(array('url' =>'/pm/index'));
                    $transaction->commit();
                    return true;
                }
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
     *传入参数：模块name
     *动作：查询Module表,找出选定的指标
     *返回参数：指标name
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
     *传入参数：指标name
     *动作：查询Index表,找出选定的因子
     *返回参数：因子name
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
     *传入参数：因子name
     *动作：查询Factor表,找出选定的问卷名和题目序号
     *返回参数：json格式的问卷name和题目number
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
        $row = Interview::find(array(
           'manager_id = :manager_id:',
           'bind' => array('manager_id' => $manager_id)));
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
        $rows = Interview::find(array(
                'manager_id = :manager_id:',
                'bind' => array('manager_id' => $manager_id)));
        $total = count($rows);
        $term = "remark<>'' AND advantage<>'' AND disadvantage<>'' AND manager_id=:manager_id:";
        $col = Interview::find(array(
                $term,
                'bind' => array('manager_id' => $manager_id)));
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
        }
        echo json_encode($ans);
        $this->view->disable();
    }

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        $this->view->disable();
        echo json_encode($ans);
    }

    /*
     * 测试人员导出
     */
    public function examineeExportAction(){
        $project_id = $this->session->get('Manager')->project_id;
        $examinee = Examinee::find(array(
            'project_id = :project_id:',
            'bind' => array('project_id' => $project_id)));
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
        $result = $this->roleInfo('I');
        $excelExport = new ExcelExport();
        $excelExport->InterviewerExport($result);
    }

    /*
     * 领导导出
     */
    public function leaderExportAction(){
        $result = $this->roleInfo('L');
        $excelExport = new ExcelExport();
        $excelExport->LeaderExport($result);
    }

    public function roleInfo($role){
        $project_id = $this->session->get('Manager')->project_id;
        $interviewer = Manager::find(array(
            'role = :role: AND project_id = :project_id:',
            'bind' => array('role' => $role,'project_id' => $project_id)));
        $result = array();
        foreach($interviewer as $key => $item){
            $result[$key] = $item;
        }
        return $result;
    }

    public function datareturn($builder){
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
            if (isset($item->sex)) {
                $item->sex = ($item->sex == 1)?'男':'女';
            }
            $ans['rows'][$key] = $item;
        }
        echo json_encode($ans);
        $this->view->disable();
    }

    public function getDetail($project_id){
        $examinees = Examinee::find(array(
            'project_id=?1',
            'bind'=>array(1=>$project_id)));
        $examinee_all = count($examinees);
        $examinee_com = 0;
        $examinee_coms = array();
        foreach ($examinees as $examinee) {
            if ($examinee->state  > 0) {
                $examinee_com ++;
                $examinee_coms[] = $examinee->id;
            }
        }
        $interview_com = 0;
        for ($i=0; $i < $examinee_com; $i++) { 
             $interview = Interview::findFirst($examinee_coms[$i]);
             if (!empty($interview->advantage) && !empty($interview->disadvantage) &&!empty($interview->remark)){
                 $interview_com++;
             } 
        }
        if ($examinee_all == 0) {
            $examinee_percent = 0;
        }else{
            $examinee_percent  = $examinee_com / $examinee_all;
        }
        if ($examinee_com == 0) {
            $interview_percent = 0;
        }else{
            $interview_percent = $interview_com / $examinee_com;
        }
        $detail = array(
            'examinee_percent'  => $examinee_percent,
            'interview_percent' => $interview_percent
        );
        return json_encode($detail,true);
    }
}