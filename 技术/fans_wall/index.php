<?php
/**
 * 编译PHP文件
 * [ok]
 */
$frameFiles = array();//库文件，框架文件
$frameFiles[] = '_lib/db/Database.php';
$frameFiles[] = '_lib/db/Dbbak.php';
$frameFiles[] = '_lib/db/Mysql.php';
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
$frameFiles[] = '_controller/AdminFansController.php';
$frameFiles[] = '_controller/FansController.php';
$frameFiles[] = '_controller/InstallController.php';
$frameFiles[] = '_controller/MainController.php';
$frameFiles[] = '_controller/UserController.php';

$frameFiles[] = '_model/Admin.php';
$frameFiles[] = '_model/Config.php';
$frameFiles[] = '_model/Fans.php';
$frameFiles[] = '_model/Install.php';
$frameFiles[] = '_model/System.php';
$frameFiles[] = '_model/User.php';

foreach ($frameFiles as $key => $value)
{
	require_once($value);
}

$module = Security::varGet('m');//模块标识
if ('_make' == $module)
{
	//生成主文件，线上模式
	Utils::makePhp($frameFiles, 'index_.php', 'new MainController();');
	echo 'ok';
}
else
{
	Config::$isLocal = true;
	new MainController();
}
?>
