<?php
/**
 * 主入口
 */
new Main();

class Main
{
	public function __construct()
	{
		Config::init();
		$module = isset($_GET['m']) ? $_GET['m'] : '';//模块标识
		switch ($module)
		{
			case 'admin':
				new AdminController();
				break;
			case 'admin_faq':
				new AdminFaqController();
				break;
			case 'faq':
				new FaqController();
				break;
			case 'install':
				new InstallController();
				break;
			case 'user':
				new UserController();
				break;
			default:
				new FaqController();
		}
	}
}
?>
