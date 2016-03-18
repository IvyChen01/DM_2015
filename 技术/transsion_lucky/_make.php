<?php
/**
 * 编译PHP文件
 */
$src_time = microtime(true);
require_once('_model/Config.php');
require_once('_lib/Utils.php');
$frame_files = array();//库文件，框架文件

$frame_files[] = '_lib/db/Database.php';
$frame_files[] = '_lib/db/Dbbak.php';
$frame_files[] = '_lib/db/Mysql.php';
$frame_files[] = '_lib/phpmailer/class.phpmailer.php';
$frame_files[] = '_lib/phpmailer/class.smtp.php';
$frame_files[] = '_lib/phpmailer/Email.php';
$frame_files[] = '_lib/Check.php';
$frame_files[] = '_lib/Debug.php';
$frame_files[] = '_lib/FileCache.php';
$frame_files[] = '_lib/Http.php';
$frame_files[] = '_lib/Image.php';
$frame_files[] = '_lib/IpArea.php';
$frame_files[] = '_lib/Page.php';
$frame_files[] = '_lib/Pinyin.php';
$frame_files[] = '_lib/Security.php';
$frame_files[] = '_lib/Upload.php';
$frame_files[] = '_lib/Utils.php';
$frame_files[] = '_lib/Xml.php';

$frame_files[] = '_controller/AdminController.php';
$frame_files[] = '_controller/HongBaoController.php';
$frame_files[] = '_controller/InstallController.php';
$frame_files[] = '_controller/LuckyController.php';
$frame_files[] = '_controller/MainController.php';
$frame_files[] = '_controller/WeixinController.php';
$frame_files[] = '_model/Admin.php';
$frame_files[] = '_model/Config.php';
$frame_files[] = '_model/HongBao.php';
$frame_files[] = '_model/Install.php';
$frame_files[] = '_model/Lucky.php';
$frame_files[] = '_model/System.php';
$frame_files[] = '_model/Weixin.php';

if (Config::$debug_enabled)
{
	//生成主文件，调试模式
	$file_write = fopen('index.php', 'w');
	fwrite($file_write, "<?php\r\n");
	fwrite($file_write, '$frame_files = array();' . "\r\n");
	foreach ($frame_files as $value)
	{
		fwrite($file_write, '$frame_files[] = \'' . $value . '\';' . "\r\n");
	}
	fwrite($file_write, 'foreach ($frame_files as $key => $value) { require($value); }' . "\r\n");
	fwrite($file_write, 'new MainController();' . "\r\n");
	fwrite($file_write, "?>\r\n");
	fclose($file_write);
}
else
{
	//生成主文件，线上模式
	Utils::make_php($frame_files, 'index.php', 'new MainController();');
}

echo 'time: ' . (microtime(true) - $src_time) . '<br />';
?>
