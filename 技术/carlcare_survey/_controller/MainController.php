<?php
/**
 * 主入口控制器
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::varGet('m');//模块标识
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'survey':
				new SurveyController();
				break;
			case 'user':
				new UserController();
				break;
			default:
				new SurveyController();
		}
		
		$action = Security::varGet('a');//操作标识
		if (!('admin' == $module && 'log' == $action) && !('admin' == $module && 'logTime' == $action))
		{
			Debug::logTime("[$module][$action]");
		}
	}
}
?>
