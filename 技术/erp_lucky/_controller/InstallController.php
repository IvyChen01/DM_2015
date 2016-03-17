<?php
/**
 * 系统安装控制器
 */
class InstallController
{
	private $install = null;//安装模型
	private $lock_file = '';//锁定文件
	
	public function __construct()
	{
		$this->lock_file = Config::$dir_lock . 'install.php';
		if (file_exists($this->lock_file))
		{
			exit('Locked!');
		}
		else
		{
			$this->install = new Install();
			$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
			switch ($action)
			{
				case 'create_database':
					$this->create_database();
					break;
				case 'install':
					$this->install();
					break;
				case 'upgrade':
					$this->upgrade();
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
	 * 升级数据库
	 */
	private function upgrade()
	{
		$this->install->upgrade();
		$this->create_lock_file();
		echo 'Succeed!';
	}
	
	/**
	 * 生成锁定文件
	 */
	private function create_lock_file()
	{
		$file = fopen($this->lock_file, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
}
?>
