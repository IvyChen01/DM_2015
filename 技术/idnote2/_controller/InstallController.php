<?php
/**
 * 系统安装控制器
 * @author Shines
 */
class InstallController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'createDatabase':
				if (file_exists(Config::$installLock))
				{
					echo 'Locked!';
				}
				else
				{
					$this->createDatabase();
				}
				break;
			case 'install':
				if (file_exists(Config::$installLock))
				{
					echo 'Locked!';
				}
				else
				{
					$this->install();
				}
				break;
			default:
		}
	}
	
	/**
	 * 创建数据库
	 */
	private function createDatabase()
	{
		System::fixSubmit('createDatabase');
		$install = new Install();
		$install->createDatabase();
		echo 'Succeed!';
	}
	
	/**
	 * 安装数据库
	 */
	private function install()
	{
		System::fixSubmit('install');
		$install = new Install();
		$install->install();
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
