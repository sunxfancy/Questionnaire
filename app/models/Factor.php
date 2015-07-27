<?php

    /*
    * @Author: sxf
    * @Date:   2014-10-11 20:30:04
    * @Last Modified by:   sxf
    * @Last Modified time: 2014-10-11 20:30:15
    */

    class Factor
        extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasMany("f_id", "Question", "factor_id");
        }
    }
