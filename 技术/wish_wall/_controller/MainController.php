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
		
		Config::$deviceType = 'pc';
		
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'adminHongBao':
				new AdminHongBaoController();
				break;
			case 'adminNews':
				new AdminNewsController();
				break;
			case 'adminWish':
				new AdminWishController();
				break;
			case 'adminZhuanPan':
				new AdminZhuanPanController();
				break;
			case 'chat':
				new ChatController();
				break;
			case 'hongBao':
				new HongBaoController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'news':
				new NewsController();
				break;
			case 'user':
				new UserController();
				break;
			case 'weiXin':
				new WeiXinController();
				break;
			case 'wish':
				new WishController();
				break;
			case 'zhuanPan':
				new ZhuanPanController();
				break;
			default:
				new WishController();
				
				/*
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '建设中';
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
