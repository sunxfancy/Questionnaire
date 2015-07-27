<?php

    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/27/14
     * Time: 10:57 PM
     */

    /*
     * result_type 数据类型　0代表仅获取部分列表　1代表修改test的值
     * parts 当前test所选的part的编号列表　array 仅当　result_type=1时有效
     * test 当前修改的test array 仅当　result_type=1时有效
     * type 0或1 代表选题类型 暂不可用 全为0
     *　part_list 当前type所有下的part列表
     */
    class TestResult
    {
        var $result_type;
        var $parts;
        var $test;
        var $type;
        var $part_list;
    }