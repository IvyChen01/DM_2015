<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
<script src="js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
<script src="js/ajaxfileupload.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function checkExist()
{
	$.post("?m=survey&a=checkExist", {year: '2015', month: '2', week: '2'}, onCheck);
	return false;
}

function onCheck(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误！");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			//本周无数据，无需提示是否覆盖原数据，直接上传
			ajaxFileUpload();
			break;
		case 1:
			//本周数据已存在，提示是否覆盖原数据
			alert("本周数据已存在，是否覆盖原数据？");
			break;
		default:
			alert("未知错误！");
			$("#srcPassword").select();
	}
}

function ajaxFileUpload()
{
	$("#loading")
	.ajaxStart(function(){
		$(this).show();
	})
	.ajaxComplete(function(){
		$(this).hide();
	});

	$.ajaxFileUpload
	(
		{
			url:'?m=survey&a=import',
			secureuri:false,
			fileElementId:'fileToUpload',
			dataType: 'json',
			data:{name: 'logan', id: 'id', year: '2015', month: '2', week: '2'},
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != '')
					{
						alert(data.error);
					}else
					{
						alert(data.msg);
					}
				}
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
	return false;
}
</script>
</head>

<body>
$_level: <?php echo $_level; ?><br />
<div id="wrapper">
    <div id="content">
    	<h1>Ajax File Upload Demo</h1>
    	<p>Jquery File Upload Plugin  - upload your files with only one input field</p>
				<p>
				need any Web-based Information System?<br> Please <a href="http://www.phpletter.com/">Contact Us</a><br>
				We are specialized in <br>
				<ul>
					<li>Website Design</li>
					<li>Survey System Creation</li>
					<li>E-commerce Site Development</li>
				</ul>    	
		<img id="loading" src="images/loading.gif" style="display:none;">
		<table cellpadding="0" cellspacing="0" class="tableForm">

		<thead>
			<tr>
				<th>Please select a file and click Upload button</th>
			</tr>
		</thead>
		<tbody>	
			<tr>
				<td><input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"></td>			</tr>

		</tbody>
			<tfoot>
				<tr>
					<td><button class="button" id="buttonUpload" onclick="return checkExist();">Upload</button></td>
				</tr>
			</tfoot>
	
	</table>
    </div>
    
    <div>
		<input type="button" id="testBtn" value="fillForm" />
	</div>
	<div>
		<a href="?m=survey&a=export">export</a>
	</div>

<script type="text/javascript">
$(document).ready(function()
{
	$("#testBtn").click(onClickTest);
});

function onClickTest(e)
{
	$.post("?m=survey&a=fillForm", {id: "1", q1: "1", q2: "2", q3: "3", q4: "4", q5: "1", q6: "3"}, onTest);
}

function onTest(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误！");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			alert("ok");
			break;
		default:
			alert("未知错误！");
	}
}
</script>
</body>
</html>
