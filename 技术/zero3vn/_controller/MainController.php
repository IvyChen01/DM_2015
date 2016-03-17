<?php
/**
 * 主入口
 * @author Shines
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::varGet('m');//模块标识
		$action = Security::varGet('a');//操作标识
		Config::$deviceType = Security::varGet('d');//设备类型
		if (empty(Config::$deviceType))
		{
			if (Utils::checkMobile())
			{
				//手机版
				Config::$deviceType = 'mobile';
			}
			else
			{
				//PC版
				Config::$deviceType = 'pc';
			}
		}
		
		//模块
		switch ($module)
		{
			case 'install':
				$this->goInstall($action);
				break;
			case 'admin':
				$this->goAdmin($action);
				break;
			default:
				$this->goGame($action);
		}
		
		//记录执行时间过长的接口
		if (!Config::$isLocal)
		{
			Debug::logMaxTime("[$module][$action]");
		}
	}
	
	/**
	 * 安装模块
	 */
	private function goInstall($action)
	{
		$controller = new InstallController();
		switch ($action)
		{
			case 'dbName':
				$controller->dbName();
				break;
			case 'createDatabase':
				$controller->createDatabase();
				break;
			case 'install':
				$controller->install();
				break;
			default:
		}
	}
	
	/**
	 * 管理员模块
	 */
	private function goAdmin($action)
	{
		$controller = new AdminController();
		switch ($action)
		{
			case 'verify':
				$controller->verify();
				break;
			case 'doLogin':
				$controller->doLogin();
				break;
			case 'changePassword':
				$controller->changePassword();
				break;
			case 'doChangePassword':
				$controller->doChangePassword();
				break;
			case 'logout':
				$controller->logout();
				break;
			case 'install':
				$controller->install();
				break;
			case 'db':
				$controller->db();
				break;
			case 'dbNews':
				$controller->dbNews();
				break;
			case 'upgrade':
				$controller->upgrade();
				break;
			case 'backup':
				$controller->backup();
				break;
			case 'recover':
				$controller->recover();
				break;
			case 'find':
				$controller->find();
				break;
			case 'log':
				$controller->log();
				break;
			case 'logTime':
				$controller->logTime();
				break;
			case 'phpinfo':
				$controller->info();
				break;
			case 'date':
				$controller->showDate();
				break;
			default:
				$controller->main();
		}
	}
	
	private function goGame($action)
	{
		$controller = new GameController();
		switch ($action)
		{
			case 'lucky':
				$controller->lucky();
				break;
			case 'doLucky':
				$controller->doLucky();
				break;
			case 'doShare':
				$controller->doShare();
				break;
			case 'winner':
				$controller->winner();
				break;
			case 'dataCount':
				$controller->dataCount();
				break;
			case 'exportUser':
				$controller->exportUser();
				break;
			case 'initPrize':
				$controller->initPrize();
				break;
			default:
				$controller->showEnter();
		}
	}
}
?>
