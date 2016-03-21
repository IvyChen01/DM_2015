<?php
/**
 * 系统安装模块
 * @author Shines
 */
class InstallController
{
	private $install = null;//安装
	
	public function __construct()
	{
		$this->install = new Install();
	}
	
	/**
	 * 显示数据库名字
	 */
	public function dbName()
	{
		System::fixSubmit('dbName');
		if (file_exists(Config::$installLock))
		{
			echo 'Locked!';
		}
		else
		{
			echo Config::$dbConfig['dbName'];
		}
	}
	
	/**
	 * 创建数据库
	 */
	public function createDatabase()
	{
		System::fixSubmit('createDatabase');
		if (file_exists(Config::$installLock))
		{
			echo 'Locked!';
		}
		else
		{
			$this->install->createDatabase();
			echo 'Succeed!';
		}
	}
	
	/**
	 * 安装数据库
	 */
	public function install()
	{
		System::fixSubmit('install');
		if (file_exists(Config::$installLock))
		{
			echo 'Locked!';
		}
		else
		{
			$this->install->install();
			$this->createLockFile();
			echo 'Succeed!';
		}
	}
	
	/**
	 * 生成锁定文件
	 */
	private function createLockFile()
	{
		$file = fopen(Config::$installLock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库时才可删除。?>');
		fclose($file);
	}
}
?>
