<?php
/**
 * 系统安装控制器
 */
class InstallController
{
	private $install = null;//安装模型
	
	public function __construct()
	{
		if (file_exists(Config::$installLock))
		{
			exit('Locked!');
		}
		else
		{
			$this->install = new Install();
			$action = Security::varGet('a');//操作标识
			switch ($action)
			{
				case 'createDatabase':
					$this->createDatabase();
					break;
				case 'install':
					$this->install();
					break;
				default:
			}
		}
	}
	
	/**
	 * 创建数据库
	 */
	private function createDatabase()
	{
		System::fixSubmit('createDatabase');
		$this->install->createDatabase();
		echo 'Succeed!';
	}
	
	/**
	 * 安装数据库
	 */
	private function install()
	{
		System::fixSubmit('install');
		$this->install->install();
		$this->createLockFile();
		echo 'Succeed!';
	}
	
	/**
	 * 生成锁定文件
	 */
	private function createLockFile()
	{
		$file = fopen(Config::$installLock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
}
?>
