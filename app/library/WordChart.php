<?php
require_once '../app/classes/PhpWord/Autoloader.php';
class WordChart {
	const phpworddir = '../app/classes/';
	public function __construct(){
		\PhpOffice\PhpWord\Autoloader::register();
	}
	
}