<?php
/**
 * 系统安装控制器
 */
class InstallController
{
	private $install = null;//安装模型
	
	public function __construct()
	{
		if (file_exists(Config::$install_lock))
		{
			exit('Locked!');
		}
		else
		{
			$this->install = new Install();
			$action = Security::var_get('a');//操作标识
			switch ($action)
			{
				case 'create_database':
					$this->create_database();
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
	private function create_database()
	{
		$this->install->create_database();
		echo 'Succeed!';
	}
	
	/**
	 * 安装数据库
	 */
	private function install()
	{
		$this->install->install();
		$this->create_lock_file();
		echo 'Succeed!';
	}
	
	/**
	 * 生成锁定文件
	 */
	private function create_lock_file()
	{
		$file = fopen(Config::$install_lock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
}
?>
