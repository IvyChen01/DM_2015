<?php
/**
 * 编译PHP文件
 */
require_once('_lib/Utils.php');
$frameFiles = array();//库文件，框架文件

//库文件
$files = Utils::getFiles('_lib');
foreach ($files as $value)
{
	if (is_file($value))
	{
		$frameFiles[] = $value;
	}
}

//控制器文件
$files = Utils::getFiles('_controller');
foreach ($files as $value)
{
	if (is_file($value))
	{
		$frameFiles[] = $value;
	}
}

//模型文件
$files = Utils::getFiles('_model');
foreach ($files as $value)
{
	if (is_file($value))
	{
		$frameFiles[] = $value;
	}
}

//引入全部项目文件
foreach ($frameFiles as $key => $value)
{
	require_once($value);
}

//生成主文件，线上模式。更新模板缓存
Utils::makePhp($frameFiles, 'index_.php', 'new MainController();');
System::cacheTemplates();

//进入主程序
Config::$isLocal = true;
new MainController();
?>
