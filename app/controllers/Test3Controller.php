<?php
	/**
	* 
	*/
class Test3Controller extends Base
{		
	public function indexAction(){
       $word = new WordExport();
       $word->test();
	}
}