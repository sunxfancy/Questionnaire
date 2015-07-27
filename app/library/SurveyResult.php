<?php

    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/31/14
     * Time: 9:14 PM
     */
    /* description 描述
     * resultinfo 0代表保存失败　1代表保存成功并返回下一个part 2表示已经完成所有的part
     * nextpart array　仅当resultinfo=1时被赋值，包含下一个part的必要信息
     * cur 当前part序号
     */

    class SurveyResult
    {
        var $description;
        var $resultinfo;
        var $nextpart;
        var $cur;
        var $next;
    }