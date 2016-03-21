<?php
require(dirname(__FILE__)."/config.php");

if($cuserLogin->adminStyle!='dedecms')
{
	header("location:index_menu.php?openitem=100");
	exit();
}

require(DEDEADMIN.'/inc/inc_menu_module.php');
require(DEDEADMIN.'/inc/inc_menu_func.php');
?>
<html>
<head>
<title>DedeCms menu</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base target="main" />
</head>
<script language="javascript">
function showHide(objname)
{
	var obj = document.getElementById(objname);
	if(obj.style.display == 'block' || obj.style.display =='') obj.style.display = 'none';
	else obj.style.display = 'block';
}
</script>
<base target="main">
<body leftmargin="0" topmargin="0" target="rightFrame">
<table width='100%' height="100%" border='0' cellspacing='0' cellpadding='0'>
	<tr>
  <td style='padding-left:3px;padding-top:8px' valign="top">
<?php
GetMenus($cuserLogin->getUserRank(),'module');
?>
	</td>
	</tr>
</table>
<table width="120" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="6"></td></tr>
</table>
</body>
</html>