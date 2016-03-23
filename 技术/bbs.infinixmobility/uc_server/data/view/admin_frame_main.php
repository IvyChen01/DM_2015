<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<!-- Modified by Valery Votintsev -->
<?php include $this->gettpl('header');?>
<?php if($iframe) { ?>
<script type="text/javascript">
	var uc_menu_data = new Array();
	o = document.getElementById('header_menu_menu');
	elems = o.getElementsByTagName('A');
	for(i = 0; i<elems.length; i++) {
		uc_menu_data.push(elems[i].innerHTML);
		uc_menu_data.push(elems[i].href);
	}
	try {
		parent.uc_left_menu(uc_menu_data);
		parent.uc_modify_sid('<?php echo $sid;?>');
	} catch(e) {}
</script>
<?php } ?>
<div class="container">
	<h3>UCenter Statistics</h3>
	<ul class="memlist fixwidth">
		<li><em><?php if($user['allowadminapp'] || $user['isfounder']) { ?><a href="admin.php?m=app&a=ls">Applications</a><?php } else { ?>Applications<?php } ?>:</em><?php echo $apps;?></li>
		<li><em><?php if($user['allowadminuser'] || $user['isfounder']) { ?><a href="admin.php?m=user&a=ls">Members</a><?php } else { ?>Members<?php } ?>:</em><?php echo $members;?></li>
		<li><em><?php if($user['allowadminpm'] || $user['isfounder']) { ?><a href="admin.php?m=pm&a=ls">Messages</a><?php } else { ?>Messages<?php } ?>:</em><?php echo $pms;?></li>
		<li><em>Friends:</em><?php echo $friends;?></li>
	</ul>
	
	<h3>Notice Status</h3>
	<ul class="memlist fixwidth">
		<li><em><?php if($user['allowadminnote'] || $user['isfounder']) { ?><a href="admin.php?m=note&a=ls">Unsent Messages</a><?php } else { ?>Unsent Messages<?php } ?>:</em><?php echo $notes;?></li>
		<?php if($errornotes) { ?>
			<li><em><?php if($user['allowadminnote'] || $user['isfounder']) { ?><a href="admin.php?m=note&a=ls">Application Notice Failed</a><?php } else { ?>Application Notice Failed<?php } ?>:</em>		
			<?php foreach((array)$errornotes as $appid => $error) {?>
				<?php echo $applist[$appid]['name'];?>&nbsp;
			<?php }?>
		<?php } ?>
	</ul>
	
	<h3>System Environment</h3>
	<ul class="memlist fixwidth">
		<li><em>UCenter Version:</em>UCenter <?php echo UC_SERVER_VERSION;?> Release <?php echo UC_SERVER_RELEASE;?> <a href="http://www.discuz.net/forumdisplay.php?fid=151" target="_blank">View Latest Chinese Version</a> 
		<li><em>System & PHP:</em><?php echo $serverinfo;?></li>
		<li><em>Software:</em><?php echo $_SERVER['SERVER_SOFTWARE'];?></li>
		<li><em>MySQL Version:</em><?php echo $dbversion;?></li>
		<li><em>Upload Permissions:</em><?php echo $fileupload;?></li>
		<li><em>Current Database Size:</em><?php echo $dbsize;?></li>		
		<li><em>Host Name:</em><?php echo $_SERVER['SERVER_NAME'];?> (<?php echo $_SERVER['SERVER_ADDR'];?>:<?php echo $_SERVER['SERVER_PORT'];?>)</li>
		<li><em>magic_quote_gpc:</em><?php echo $magic_quote_gpc;?></li>
		<li><em>allow_url_fopen:</em><?php echo $allow_url_fopen;?></li>		
	</ul>
	<h3>UCenter Development Team</h3>
	<ul class="memlist fixwidth">
		<li>
			<em>Copyright:</em>
<!--vot-->		<em class="memcont"><a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a></em>
		</li>
		<li>
			<em>Manager:</em>
<!--vot-->		<em class="memcont"><a href="http://www.discuz.net/space.php?uid=1" target="_blank">Kevin 'Crossday'</a></em>
		</li>
		<li>
			<em>Development Team:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/space.php?uid=859" target="_blank">Hypo 'cnteacher' Wang</a>,
				<a href="http://www.discuz.net/space.php?uid=80629" target="_blank">Ning 'Monkey' Hou</a>,				
				<a href="http://www.discuz.net/space.php?uid=875919" target="_blank">Jie 'tom115701' Zhang</a>
			</em>
		</li>
		<li>
			<em>Safe Team:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/space.php?uid=859" target="_blank">Hypo 'cnteacher' Wang</a>,
				<a href="http://www.discuz.net/space.php?uid=492114" target="_blank">Liang 'Metthew' Xu</a>,
				<a href="http://www.discuz.net/space.php?uid=285706" target="_blank">Wei (Sniffer) Yu</a>
			</em>
		</li>
		<li>
			<em>Style Team:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/space.php?uid=294092" target="_blank">Fangming 'Lushnis' Li</a>,
				<a href="http://www.discuz.net/space.php?uid=717854" target="_blank">Ruitao 'Pony.M' Ma</a>
			</em>
		</li>
		<li>
			<em>Thanks to:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/space.php?uid=122246" target="_blank">Heyond</a>
			</em>
		</li>
		<li>
			<em>Company Site:</em>
			<em class="memcont"><a href="http://www.comsenz.com" target="_blank">http://www.Comsenz.com</a></em>
		</li>
		<li>
			<em>Official Site:</em>
			<em class="memcont"><a href="http://www.discuz.com" target="_blank">http://www.Discuz.com</a></em>
		</li>
		<li>
			<em>Official Forum:</em>
			<em class="memcont"><a href="http://www.discuz.net" target="_blank">http://www.Discuz.net</a></em>
		</li>
<!--vot-->	<li>
<!--vot-->		<em>Multilingual Version:</em>
<!--vot-->		<em class="memcont"><a href="http://codersclub.org/discuzx/" target="_blank">Valery Votintsev</a></em>
<!--vot-->	</li>
	</ul>
</div>

<?php echo $ucinfo;?>

<?php include $this->gettpl('footer');?>