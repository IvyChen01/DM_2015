<?php
/**
 * 预订管理控制器
 * @author Shines
 */
class AdminOrderController
{
	private $admin = null;
	private $install = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->admin = new Admin();
		$this->install = new Install();
		
		switch ($action)
		{
			case 'listData':
				if ($this->admin->checkLogin())
				{
					$this->listData();
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
		}
	}
	
	/**
	 * 登录
	 */
	private function listData()
	{
		$allTables = array(Config::$tbOrder);
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $this->install->getAllFields($tbName);
			$tableInfo['records'] = $this->install->getRecords($tbName, 0, 100000);
			$_tableList[] = $tableInfo;
		}
		$this->showDb($_tableList);
	}
	
	/**
	 * 显示数据库数据页
	 */
	private function showDb($_tableList)
	{
		include(Config::$viewDir . 'order/db.php');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
}
?>
