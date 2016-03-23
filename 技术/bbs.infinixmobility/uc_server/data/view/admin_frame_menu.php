<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Modified by Valery Votintsev, codersclub.org -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo UC_CHARSET;?>" />
<meta name="author" content="International by Valery Votintsev, http://codersclub.org/discuzx/" />
<title>UCenter Administrator's Control Panel</title>
<!--vot--> <link rel="stylesheet" href="images/admincp<?php echo RTLSUFFIX;?>.css" type="text/css" media="all" />
<meta content="Comsenz Inc." name="Copyright" />
<!--vot--> <script src="language/<?php echo UC_LANG;?>/lang_js.js" type="text/javascript"></script>
</head>
<body>
<div class="menu">
	<ul id="leftmenu">
		<li><a href="admin.php?m=frame&a=main" target="main" class="tabon">HOME</a></li>
		<?php if($user['allowadminsetting'] || $user['isfounder']) { ?><li><a href="admin.php?m=setting&a=ls" target="main">Settings</a></li><?php } ?>
		<?php if($user['allowadminsetting'] || $user['isfounder']) { ?><li><a href="admin.php?m=setting&a=register" target="main">Registrations</a></li><?php } ?>
		<?php if($user['allowadminsetting'] || $user['isfounder']) { ?><li><a href="admin.php?m=setting&a=mail" target="main">E-Mails</a></li><?php } ?>
		<?php if($user['allowadminapp'] || $user['isfounder']) { ?><li><a href="admin.php?m=app&a=ls" target="main">Applications</a></li><?php } ?>
		<?php if($user['allowadminuser'] || $user['isfounder']) { ?><li><a href="admin.php?m=user&a=ls" target="main">Users</a></li><?php } ?>
		<?php if($user['isfounder']) { ?><li><a href="admin.php?m=admin&a=ls" target="main">Admins</a></li><?php } ?>
		<?php if($user['allowadminpm'] || $user['isfounder']) { ?><li><a href="admin.php?m=pm&a=ls" target="main">Messages</a></li><?php } ?>
		<?php if($user['allowadmincredits'] || $user['isfounder']) { ?><li><a href="admin.php?m=credit&a=ls" target="main">Money</a></li><?php } ?>
		<?php if($user['allowadminbadword'] || $user['isfounder']) { ?><li><a href="admin.php?m=badword&a=ls" target="main">Bad Words</a></li><?php } ?>
		<?php if($user['allowadmindomain'] || $user['isfounder']) { ?><li><a href="admin.php?m=domain&a=ls" target="main">Domains</a></li><?php } ?>
		<?php if($user['allowadmindb'] || $user['isfounder']) { ?><li><a href="admin.php?m=db&a=ls" target="main">Database</a></li><?php } ?>
		<?php if($user['isfounder']) { ?><li><a href="admin.php?m=feed&a=ls" target="main">Data List</a></li><?php } ?>
		<?php if($user['allowadmincache'] || $user['isfounder']) { ?><li><a href="admin.php?m=cache&a=update" target="main">Update Cache</a></li><?php } ?>
		<?php if($user['isfounder']) { ?><li><a href="admin.php?m=plugin&a=filecheck" target="main">Plugins</a></li><?php } ?>
	</ul>
</div>
<div class="footer">Powered by UCenter <?php echo UC_SERVER_VERSION;?><br />&copy; 2001 - 2011 <a href="http://www.comsenz.com/" target="_blank">Comsenz</a> Inc.</div>
<script type="text/javascript">
	function cleartabon() {
		if(lastmenu) {
			lastmenu.className = '';
		}
		for(var i = 0; i < menus.length; i++) {
			var menu = menus[i];
			if(menu.className == 'tabon') {
				lastmenu = menu;
			}
		}
	}
	var menus = document.getElementById('leftmenu').getElementsByTagName('a');
	var lastmenu = '';
	for(var i = 0; i < menus.length; i++) {
		var menu = menus[i];
		menu.onclick = function() {
			setTimeout('cleartabon()', 1);
			this.className = 'tabon';
			this.blur();
		}
	}

	cleartabon();
</script>

<?php include $this->gettpl('footer');?>