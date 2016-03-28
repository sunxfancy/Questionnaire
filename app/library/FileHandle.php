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
	#文件夹打包下载;
	// 把文件添加到打包的目录下
	public function addFileToZip($path, $zip) {
		$handler = opendir($path); //打开当前文件夹由$path指定。
		/*
		 循环的读取文件夹下的所有文件和文件夹
		 其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，
		 为了不陷于死循环，所以还要让$filename !== false。
		一定要用!==，因为如果某个文件名如果叫'0'，或者某些被系统认为是代表false，用!=就会停止循环
		*/
		while (($filename = readdir($handler)) !== false) {
			if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
				if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
					$this->addFileToZip($path . "/" . $filename, $zip);
				} else { //将文件加入zip对象
					$zip->addFile($path . "/" . $filename, $filename);
				}
			}
		}
		@closedir($path);
	}
	/**
	 * 生成zip文件返回
	 * @param dir $file_path
	 * @param int $project_id
	 * @param str $file_name
	 * @throws Exception
	 * @return string
	 */
	public function packageZip($file_path, $project_id, $file_name){
		$is_exist_path = './tmp/'.$project_id.'_'.$file_name.'.zip';
		//if (file_exists($is_exist_path)){
		if(0){
			return $is_exist_path;
		}else{
			//生成zip文件
			$zip = new ZipArchive();
			if ($zip->open($is_exist_path, ZipArchive::OVERWRITE) === TRUE) {
				$this->addFileToZip($file_path, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
				$zip->close(); //关闭处理的zip文件
				return $is_exist_path;
			}else{
				throw new Exception('Zip file failed !');
			}
		}
		
	}
	
}