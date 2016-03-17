<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Management Center</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin&a=logout" target="_self">Exit</a></span>
</div>
<div class="main">
	<h3>Management Center</h3>
	<ul>
		<li>
			<a href="?m=adminFans" title="Fans management" target="_self">Fans management</a>
		</li>
		<li>
			<a href="?m=admin&a=changePassword" title="Change password" target="_self">Change password</a>
		</li>
	</ul>
</div>
</body>
</html>
