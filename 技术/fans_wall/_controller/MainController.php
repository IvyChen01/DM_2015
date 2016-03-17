<?php
/**
 * 主入口控制器
 * [ok]
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
			case 'adminFans':
				new AdminFansController();
				break;
			case 'fans':
				new FansController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'user':
				new UserController();
				break;
			default:
				new FansController();
				
				/*
				System::fixUrl();
				if (Utils::checkMobile())
				{
					//手机版
					echo $news->read_index_mobile();
				}
				else
				{
					//PC版
					echo $news->readIndex();
				}
				*/
		}
		
		//记录执行时间过长的接口
		$action = Security::varGet('a');//操作标识
		Debug::logMaxTime("[$module][$action]");
	}
}
?>
