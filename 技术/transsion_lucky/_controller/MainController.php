<?php
/**
 * 主入口控制器
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::var_get('m');//模块标识
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'hong_bao':
				new HongBaoController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'lucky':
				new LuckyController();
				break;
			case 'weixin':
				new WeixinController();
				break;
			default:
				new WeixinController();
				
				//echo Security::md5_multi('admin', Config::$key);
		}
		
		$action = Security::var_get('a');//操作标识
		if (!('admin' == $module && 'log' == $action))
		{
			Debug::log("[$module][$action] time: " . Debug::runtime());
		}
	}
}
?>
