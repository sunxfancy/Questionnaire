<?php
    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/14/14
     * Time: 11:11 AM
     */
    $router = new Phalcon\Mvc\Router();
    $router->add("/stulogin/(\d+)", array("controller" => "stulogin",
                                          "action" => "index",
                                          "school_id" => 1));
    $router->add("/index/test/(\d+)", array("controller" => "index",
                                              "action" => "test",
                                              "type" => 1));