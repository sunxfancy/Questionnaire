<?php
class FileHandle {

	//判断文件夹是否存在,不存在则创建目录
	function mk_dir($dir, $mode = 0755)
	{
	
		if (is_dir($dir) || @mkdir($dir,$mode)) return true;
	
		if (!$this->mk_dir(dirname($dir),$mode)) return false;
	
		return @mkdir($dir,$mode);
	
	}
	//移动文件到相关目录下
	public function movefile($filename, $destination) {
		//判断源文件存在
		if (file_exists($filename) && is_file($filename)){
			//目标文件存在，先删除后移动
			if (file_exists($destination)){
				unlink($destination);
			}
			$this->mk_dir(dirname($destination));
			rename($filename, $destination);
		}else{
			return false;
		}
	}
	//清空文件--主要针对临时文件
	public function clearfiles($dirname , $keywords ){
		foreach ( glob ( $dirname.$keywords.'*' ) as  $filename ) {
			unlink($filename);
		}
		return true;
	}
	
}