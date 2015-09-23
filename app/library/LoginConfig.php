<?php

class LoginConfig
{
	/**
    * 检测是否只由数字组成
    */
    static function IsOnlyNumber($data) {
		if(!preg_match('/^[0-9]*$/', $data)){
        	return false;
        }else{
        	return true;
        }
    }

    /**
    * 检测是否只由数字和数字组成
    */
    static function IsOnlyNumberAndLetter($data) {
        if(!preg_match('/^[a-zA-Z0-9]*$/', $data)){
        	return false;
        }else{
        	return true;
        }
    }
}