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
        Phalcon\Tag::prependTitle('大学生心理健康测评系统 | ');
        $this->response->setHeader("Content-Type", "text/html; charset=utf-8");
        $this->assets->collection('footer');
        $this->assets->collection('header');
        if ($this->usecdn) {
            $this->assets->addCss("http://cdn.staticfile.org/twitter-bootstrap/3.3.0/css/bootstrap.min.css");
            // $this->assets->collection('header')
            // ->addJs("http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js")
            // ->addJs("http://cdn.staticfile.org/twitter-bootstrap/3.3.0/js/bootstrap.min.js");
        } else {
            $this->assets->addCss("bootstrap/css/bootstrap.min.css");
            // $this->assets->collection('header')->addJs("js/jquery.js")->addJs("bootstrap/js/bootstrap.min.js");
        }
    }


    public function forward($controller, $action)
    {
        $this->dispatcher->forward(array(
                "controller" => $controller,
                "action" => $action)
        );
    }

}

