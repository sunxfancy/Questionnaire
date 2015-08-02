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

}

