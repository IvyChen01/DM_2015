<?php
/**
 * 主入口，用于本地调试
 */
new MainDebug();

class MainDebug
{
	public function __construct()
	{
		//库文件，框架文件
		$frame_files = array();
		$frame_files[] = '_lib/dbdriver/Mysql.php';
		$frame_files[] = '_lib/phpmailer/class.phpmailer.php';
		$frame_files[] = '_lib/phpmailer/class.smtp.php';
		$frame_files[] = '_lib/Check.php';
		$frame_files[] = '_lib/Database.php';
		$frame_files[] = '_lib/Dbbak.php';
		$frame_files[] = '_lib/Debug.php';
		$frame_files[] = '_lib/Email.php';
		$frame_files[] = '_lib/Http.php';
		$frame_files[] = '_lib/Image.php';
		$frame_files[] = '_lib/Page.php';
		$frame_files[] = '_lib/Pinyin.php';
		$frame_files[] = '_lib/Security.php';
		$frame_files[] = '_lib/Upload.php';
		$frame_files[] = '_lib/Utils.php';
		$frame_files[] = '_lib/Xml.php';
		
		$frame_files[] = '_controller/AdminController.php';
		$frame_files[] = '_controller/FaqController.php';
		$frame_files[] = '_controller/FbController.php';
		$frame_files[] = '_controller/InstallController.php';
		$frame_files[] = '_controller/TestController.php';
		$frame_files[] = '_model/sdk/base_facebook.php';
		$frame_files[] = '_model/sdk/facebook.php';
		$frame_files[] = '_model/Admin.php';
		$frame_files[] = '_model/Config.php';
		$frame_files[] = '_model/Faq.php';
		$frame_files[] = '_model/Fb.php';
		$frame_files[] = '_model/Install.php';
		$frame_files[] = '_model/System.php';
		$frame_files[] = '_model/Test.php';
		$frame_files[] = '_model/User.php';
		
		$frame_files[] = '_controller/Main.php';
		
		foreach ($frame_files as $key => $value)
		{
			require_once($value);
		}
	}
}
?>
