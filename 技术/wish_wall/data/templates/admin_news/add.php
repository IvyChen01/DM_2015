<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发布新闻</title>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="topbar">
	<span><a href="?m=adminNews" target="_self">新闻管理</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="news-add">
	<h3>发布新闻</h3>
	<ul>
		<li>
			<textarea name="content" id="content" style="width:100%;height:320px;"></textarea>
		</li>
		<li>
			<input type="button" name="publish" id="publish" value="立即发布"/>
		</li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function ()
{
	$("#publish").click(onClickAdd);
	$("#content").focus();
});

function onClickAdd(e)
{
	var str = $("#content").val();
	
	if (str.length > 10000)
	{
		alert("内容不能超过10000字！");
		$("#content").select();
	}
	else
	{
		$.post("?m=adminNews&a=doAdd", {content: str}, onAdd);
	}
}

function onAdd(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误！");
		return;
	}
	res = $.parseJSON(value);
	if (0 == res.code)
	{
		alert("发布成功！");
		location.href = "?m=adminNews&a=detail&id=" + res.id;
	}
	else
	{
		alert(res.msg);
	}
}
</script>
</body>
</html>
