<?php
/**
 * 主入口控制器
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		
		/////// debug
		if (Config::$configType == 2)
		{
			Debug::log('$_GET: ' . substr(@json_encode($_GET), 0, 500));
			Debug::log('$_POST: ' . substr(@json_encode($_POST), 0, 500));
		}
		
		$module = Security::varGet('m');//模块标识
		switch ($module)
		{
			case 'install':
				new InstallController();
				break;
			case 'admin':
				new AdminController();
				break;
			case 'adminZero':
				new AdminZeroController();
				break;
			case 'fb':
				new FbController();
				break;
			case 'fbzero':
				new FbZeroController();
				break;
			case 'user':
				new UserController();
				break;
			case 'zero':
				new ZeroController();
				break;
			case 'mwzero':
				new MwZeroController();
				break;
			case 'mwuser':
				new MwUserController();
				break;
			default:
				//new MwZeroController();
				//return;
				
				if (Utils::checkMobile())
				{
					//手机版
					new MwZeroController();
				}
				else
				{
					//PC版
					new FbZeroController();
				}
		}
		
		$action = Security::varGet('a');//操作标识
		if (!('admin' == $module && 'log' == $action) && !('admin' == $module && 'logTime' == $action))
		{
			Debug::logTime("[$module][$action]");
		}
	}
}
?>
