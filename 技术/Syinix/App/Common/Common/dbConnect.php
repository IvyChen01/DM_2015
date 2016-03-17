<?php

$config2 = include($_SERVER["DOCUMENT_ROOT"] . "/Common/siteConfig.php");
$conn = MYSQL_CONNECT($config2["DB_HOST"], $config2["DB_USER"], $config2["DB_PWD"]) OR DIE("连接数据库失败");
mysql_select_db($config2["DB_NAME"], $conn) or die("不能选择数据库");
mysql_query("SET NAMES UTF8");
?>
