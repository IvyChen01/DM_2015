<?php
/**
 * 主入口控制器
 * @author Shines
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::varGet('m');//模块标识
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
		
		switch ($module)
		{
			case 'install':
				new InstallController();
				break;
			case 'admin':
				new AdminController();
				break;
			case 'game':
				new GameController();
				break;
			case 'adminGame':
				new AdminGameController();
				break;
			default:
				new GameController();
		}
		
		//记录执行时间过长的接口
		$action = Security::varGet('a');//操作标识
		if (!Config::$isLocal)
		{
			Debug::logMaxTime("[$module][$action]");
		}
	}
}
?>
