<?php
require_once(dirname(__FILE__)."/../config.php");

 
//载入模块菜单
$moduleset = '';
$dsql->SetQuery("Select * From `#@__sys_module` order by id desc");
$dsql->Execute();
while($row = $dsql->GetObject()) {
	$moduleset .= $row->menustring."\r\n";
}
//载入插件菜单
$plusset = '';
$dsql->SetQuery("Select * From `#@__plus` where isshow=1 order by aid asc");
$dsql->Execute();
while($row = $dsql->GetObject()) {
	$plusset .= $row->menustring."\r\n";
}
//////////////////////////
$menusMoudle = "
-----------------------------------------------

<m:top item='15_' name='模块管理' c='6,' display='block'>
  <m:item name='模块管理' link='module_main.php' rank='sys_module' target='main' />
  <m:item name='上传新模块' link='module_upload.php' rank='sys_module' target='main' />
  <m:item name='模块生成向导' link='module_make.php' rank='sys_module' target='main' />
</m:top>

<m:top item='15_1' name='辅助插件' display='block'>
  <m:item name='插件管理器' link='plus_main.php' rank='10' target='main' />
  $plusset
</m:top>

$moduleset
-----------------------------------------------
";
?>