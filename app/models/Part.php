<?php

    /*
    * @Author: sxf
    * @Date:   2014-10-11 20:29:46
    * @Last Modified by:   sxf
    * @Last Modified time: 2014-10-22 19:17:22
    */

    class Part
        extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasManyToMany("p_id", "Fprel", "part_id", "factor_id", "Factor", "f_id");
        }
    }
