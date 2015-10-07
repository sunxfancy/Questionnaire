<?php
class FileHandle {

	//判断文件夹是否存在,不存在则创建目录
	public function forcemkdir($path) {
		//file_exist 判断文件或目录是否存在
		if(!file_exists($path)){
			$path = dirname($path);
			mkdir($path,0777,true);
			return true;
		}else{
			return true;
		}
	}
	//移动文件到相关目录下
	public function movefile($filename, $destination) {
		//判断源文件存在
		if (file_exists($filename)&& is_file($filename)){
			//目标文件存在，先删除后移动
			if (file_exists($destination)){
				unlink($destination);
			}
			$path = dirname($destination);
			$this->forcemkdir($path);
			rename($filename, $destination);
		}
	}
	
}