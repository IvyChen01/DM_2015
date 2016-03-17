<?php
$frameFiles = array();
$frameFiles[] = '_lib/db/Database.php';
$frameFiles[] = '_lib/db/Dbbak.php';
$frameFiles[] = '_lib/db/Mysql.php';
$frameFiles[] = '_lib/phpmailer/class.phpmailer.php';
$frameFiles[] = '_lib/phpmailer/class.smtp.php';
$frameFiles[] = '_lib/phpmailer/Email.php';
$frameFiles[] = '_lib/Debug.php';
$frameFiles[] = '_lib/FileCache.php';
$frameFiles[] = '_lib/Http.php';
$frameFiles[] = '_lib/Image.php';
$frameFiles[] = '_lib/Page.php';
$frameFiles[] = '_lib/Pinyin.php';
$frameFiles[] = '_lib/Security.php';
$frameFiles[] = '_lib/Upload.php';
$frameFiles[] = '_lib/Utils.php';
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
foreach ($frameFiles as $key => $value) { require($value); }
new MainController();
?>
