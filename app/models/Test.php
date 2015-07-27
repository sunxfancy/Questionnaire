<?php

    /*
    * @Author: sxf
    * @Date:   2014-10-11 20:27:26
    * @Last Modified by:   sxf
    * @Last Modified time: 2014-10-22 19:21:34
    */

    class Test
        extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasManyToMany("t_id", "Tprel", "test_id", "part_id", "Part", "p_id");
            $this->hasMany("t_id", "Student", "test_id");
        }
    }
