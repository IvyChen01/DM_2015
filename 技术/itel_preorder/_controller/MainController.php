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
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'order':
				new OrderController();
				break;
			case 'adminOrder':
				new AdminOrderController();
				break;
			default:
				new OrderController();
				
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
		if (!Config::$isLocal)
		{
			Debug::logMaxTime("[$module][$action]");
		}
	}
}
?>
