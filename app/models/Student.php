<?php

    /*
    * @Author: sxf
    * @Date:   2014-10-11 20:31:26
    * @Last Modified by:   sxf
    * @Last Modified time: 2014-10-11 20:31:49
    */

    class Student
        extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->belongsTo("school_id", "School", "school_id");
            $this->belongsTo("test_id", "Test", "t_id");
            $this->hasMany("stu_id", "Answer", "student_id");
            $this->hasMany("stu_id", "Total", "student_id");
        }
    }
