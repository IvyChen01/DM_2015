<?php
$uid = $_GET['uid'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="Page-Exit" content="RevealTrans (Duration=3, Transition=23)">
	<link rel="stylesheet" href="static/image/mobile/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="template/webshow_mtb0115/touch/img/css/base.css?eKb" type="text/css">
</head>
<body class="bg main">
	<div style="width: 100%; background: #90c31f; height: 40px; line-height:40px; box-shadow:  1px 0px 2px rgba(0,0,0,0.0); font-size: 0.9em; text-align: center;">
		<div style="position:absolute;">
			<a href="javascript:history.back();" style="display: block;width: 22px;height: 30px;margin: 0 0 0 10px;background: url(template/webshow_mtb0115/touch/img/m_left_2.png) 0 10px no-repeat;overflow: hidden;background-size: 58%;"></a>
		</div>
		<span style="font-size: 1.5em;">Avatar</span>
	</div>	

	<form action="FileUploadProcess.php" enctype="multipart/form-data" method="post" style="width: 200px; margin: 40px auto;">
		<input name="uid" type="hidden" value="<?php echo $uid; ?>" />
		<input name="size" type="hidden" value="small" />
		Please select a face image :<br><input type="file" name="myfile" style="height:40px;" />
		<input type="submit" value="Upload Picture" style="width: 200px; height: 45px; line-height: 45px; border: 2px solid #90C31F; border-radius: 15px; font-size: 26px; text-align: center;" />
	</form>
</body>
</html>
