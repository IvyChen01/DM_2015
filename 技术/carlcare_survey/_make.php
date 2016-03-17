<?php
/**
 * 编译PHP文件
 */
$srcTime = microtime(true);
require_once('_model/Config.php');
require_once('_lib/Utils.php');
$frameFiles = array();//库文件，框架文件

$frameFiles[] = '_lib/db/Database.php';
$frameFiles[] = '_lib/db/Dbbak.php';
$frameFiles[] = '_lib/db/Mysql.php';
//$frameFiles[] = '_lib/fb/base_facebook.php';
//$frameFiles[] = '_lib/fb/facebook.php';
$frameFiles[] = '_lib/phpmailer/class.phpmailer.php';
$frameFiles[] = '_lib/phpmailer/class.smtp.php';
$frameFiles[] = '_lib/phpmailer/Email.php';
//$frameFiles[] = '_lib/Check.php';
$frameFiles[] = '_lib/Debug.php';
$frameFiles[] = '_lib/FileCache.php';
$frameFiles[] = '_lib/Http.php';
$frameFiles[] = '_lib/Image.php';
//$frameFiles[] = '_lib/IpArea.php';
$frameFiles[] = '_lib/Page.php';
$frameFiles[] = '_lib/Pinyin.php';
$frameFiles[] = '_lib/Security.php';
$frameFiles[] = '_lib/Upload.php';
$frameFiles[] = '_lib/Utils.php';
//$frameFiles[] = '_lib/Xml.php';

$frameFiles[] = '_controller/AdminController.php';
$frameFiles[] = '_controller/InstallController.php';
$frameFiles[] = '_controller/MainController.php';
$frameFiles[] = '_controller/SurveyController.php';
$frameFiles[] = '_controller/UserController.php';
$frameFiles[] = '_model/Admin.php';
$frameFiles[] = '_model/Config.php';
$frameFiles[] = '_model/Install.php';
$frameFiles[] = '_model/Survey.php';
$frameFiles[] = '_model/System.php';
$frameFiles[] = '_model/User.php';

if (Config::$debugEnabled)
{
	//生成主文件，调试模式
	$fileWrite = fopen('index.php', 'w');
	fwrite($fileWrite, "<?php\r\n");
	fwrite($fileWrite, '$frameFiles = array();' . "\r\n");
	foreach ($frameFiles as $value)
	{
		fwrite($fileWrite, '$frameFiles[] = \'' . $value . '\';' . "\r\n");
	}
	fwrite($fileWrite, 'foreach ($frameFiles as $key => $value) { require($value); }' . "\r\n");
	fwrite($fileWrite, 'new MainController();' . "\r\n");
	fwrite($fileWrite, "?>\r\n");
	fclose($fileWrite);
}
else
{
	//生成主文件，线上模式
	Utils::makePhp($frameFiles, 'index.php', 'new MainController();');
}

echo 'time: ' . (microtime(true) - $srcTime) . '<br />';
?>
