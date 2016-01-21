<?php
/**
 * @Author: sxf
 * @Date:   2015-08-07 14:32:50
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-07 15:04:11
 */

/**
* 
*/
class LeaderController extends Base
{
	public function indexAction(){
		parent::initialize();
        $this->view->setTemplateAfter('base2');
        $this->leftRender('测 评 结 果');
    }

    public function detailAction(){}

    public function resultAction(){
        $manager = $this->session->get('Manager');
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

    public function getotherAction($examinee_id){
        $examinee = Examinee::findFirst($examinee_id);
        $this->dataBack(array("other"=>$examinee->other));
    }

    #获取被试信息页面 (绿色通道人员除外)
    public function listexamineeAction($type = 0 ){
        $this->view->disable();
        $manager = $this->session->get('Manager');
        if (empty($manager)){
            $this->dataReturn(array('error'=>'获取用户信息失败，请重新登陆'));
            return ;
        }
        $project_id = $manager->project_id;
        $page = $this->request->get('page');
        $rows = $this->request->get('rows');
        $offset = $rows*($page-1);
        $limit = $rows;
        $sidx = $this->request->getQuery('sidx','string');
        $sord = $this->request->getQuery('sord','string');
        if ($sidx != null)
            $sort = $sidx;
        else{
            $sort = 'id';
            $sord = 'desc';
        }
        if ($sord != null){
            $sort = $sort.' '.$sord;
        }
        //default get
        $search_state = $this->request->get('_search');
        if($search_state == 'false'){
            $result = $this->modelsManager->createBuilder()
                ->columns(array(
                    'Examinee.id as id',
                    'Examinee.number as number',
                    'Examinee.name as name',
                    'Examinee.last_login as last_login',
                    'Examinee.state as state',
                    ))
                ->from('Examinee')
                //添加类型判断
                ->where('Examinee.project_id = '.$project_id.' AND Examinee.type = '.$type )
                ->limit($limit,$offset)
                ->orderBy($sort)
                ->getQuery()
                ->execute();
                $rtn_array = array();
                 $examinees = Examinee::find(array(
                'project_id=?1 AND type=?2',
                'bind'=>array(1=>$project_id, 2=>$type)));
                //获取该项目下答题的总人数
                $count =  count($examinees);
                $rtn_array['total'] = ceil($count/$rows);
                $rtn_array['records'] = $count;
                $rtn_array['rows'] = array();
                foreach($result as $value){
                    $rtn_array['rows'][] = $value;
                }    
                $rtn_array['page'] = $page;  
                $this->dataBack($rtn_array);                
                return;
        }else{
            //处理search情况
            $search_field =  $this->request->get('searchField');
            $search_string =  $this->request->get('searchString');
            $search_oper = $this->request->get('searchOper');
            #分情况讨论
            $filed = 'Examinee.'.$search_field;
            if ($search_oper == 'eq'){
                if ($search_field == 'name'){
                    $oper = 'LIKE';
                    $value = "'%$search_string%'";
                }else if ($search_field == 'number' || $search_field == 'sex' ){
                    $oper = '=';
                    $value = "'$search_string'";
                }else if ( $search_field == 'exam_state' || $search_field == 'interview_state'){
                    $filed = 'Examinee.state';
                    if ($search_string == 'true'){
                        $oper = '>=';
                    }else{
                        $oper = '<';
                    }
                    if ($search_field == 'exam_state'){
                        $value = 1;
                    }else {
                        $value = 4;
                    }
            }
            }else if ( $search_oper == 'bw' ||$search_oper == 'ew' ){
                if (  $search_field == 'last_login' ){
                    $value = "'$search_string'";
                }
                if($search_oper == 'bw'){
                    $oper = '>=';
                }else if ($search_oper == 'ew'){
                    $oper = '<=';
                }
            }else {
                //add ...
            }
            $result = $this->modelsManager->createBuilder()
            ->columns(array(
                    'Examinee.id as id',
                    'Examinee.number as number',
                    'Examinee.name as name',
                    'Examinee.last_login as last_login',
                    'Examinee.state as state',
            ))
            ->from('Examinee')
            ->where('Examinee.project_id = '.$project_id.' AND Examinee.type = '.$type." AND $filed $oper $value")
            //->limit($limit,$offset)
            ->orderBy($sort)
            ->getQuery()
            ->execute();
            $rtn_array = array();
            $count = count($result);
            $rtn_array['total'] = ceil($count/$rows);
            $rtn_array['records'] = $count;
            $rtn_array['rows'] = array();
            foreach($result as $value){
                $rtn_array['rows'][] = $value;
            }
            $rtn_array['page'] = $page;
            $this->dataBack($rtn_array);
            return;
        }    
    }

    function dataBack($ans){
        $this->response->setHeader("Content-Type", "application/json; charset=utf-8");
        echo json_encode($ans);
        $this->view->disable();
    }

}