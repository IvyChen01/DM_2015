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
			case 'faq':
				new FaqController();
				break;
			case 'fb':
				new FbController();
				break;
			case 'install':
				new InstallController();
				break;
			
			/////////
			/*
			case 'test_redis':
				$test = new Test();
				$test->test_redis();
				break;
			case 'test_memcache':
				$test = new Test();
				$test->test_memcache();
				break;
			case 'test_mysql':
				$test = new Test();
				$test->test_mysql();
				break;
			case 'test_for':
				$test = new Test();
				$test->test_for();
				break;
			*/
			default:
				new FbController();
				//include('view/end.html');
		}
	}
}
?>
