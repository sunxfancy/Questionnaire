<?php
/**
 * @Author: sxf
 * @Date:   2015-08-06 17:11:43
 * @Last Modified by:   sxf
 * @Last Modified time: 2015-08-06 17:16:39
 */

	function random_string($max = 6){
        $chars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
        $rtn = '';
        for($i = 0; $i < $max; $i++){
            $rnd = array_rand($chars);
            $rtn .= $chars[$rnd];
        }
        return $rtn;
    }

    echo random_string()."\n";