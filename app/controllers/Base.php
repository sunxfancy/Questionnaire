<?php
/* 
* @Author: sxf
* @Date:   2014-10-07 19:55:37
* @Last Modified by:   sxf
* @Last Modified time: 2014-10-21 22:21:10
*/

/**
 * 所有控制器的基类，负责公用任务处理
 */
class Base extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        Phalcon\Tag::prependTitle('政法委胜任力测评软件 | ');
        $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
    }

    public function forward($controller, $action)
    {
        $this->dispatcher->forward(array(
                "controller" => $controller,
                "action" => $action)
        );
    }

    public function getData($model, $names, $method)
    {
        $b = false;
        if (strtoupper($method) == 'POST') $b = true;

        foreach ($names as $key => $value) {
            if (is_numeric($key)) $item = $value; 
            else $item = $key;
            if ($b)  
                $model[$item] = $this->request->getPost($value, 'string');
            else 
                $model[$item] = $this->request->getQuery($value, 'string');
        }
    }

    /**
     * 传入当前页面的title即可，渲染左边栏，仅用于base2
     */
    public function leftRender($title)
    {
        /****************这一段可以抽象成一个通用的方法**********************/
        $manager = $this->session->get('Manager');
        $this->view->setVar('page_title',$title);
        $this->view->setVar('user_name',$manager->name);
        $this->view->setVar('user_id',  $manager->username);
        if ($manager->role == 'M')
            $role = '管理员';
        if ($manager->role == 'P')
            $role = '项目经理';
        if ($manager->role == 'L')
            $role = '领导';
        if ($manager->role == 'I')
            $role = '专家';
        $this->view->setVar('user_role', $role);
        /*******************************************************************/
    }
}

