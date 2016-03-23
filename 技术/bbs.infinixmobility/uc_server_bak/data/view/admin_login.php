<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>
<script type="text/javascript">
function $(id) {
	return document.getElementById(id);
}
</script>

<div class="container">
<!--vot-->	<form action="<?php echo UC_API;?>/admin.php?m=user&a=login" method="post" id="loginform" <?php if($iframe) { ?>target="_self"<?php } else { ?>target="_top"<?php } ?>>
		<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
		<input type="hidden" name="seccodehidden" value="<?php echo $seccodeinit;?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe;?>" />
		<table class="mainbox">
			<tr>
				<td class="loginbox">
					<h1>UCenter</h1>
					<p>UCenter is a bridge to let more than one application to share one user database.</p>
				</td>
				<td class="login">
					<?php if($errorcode == UC_LOGIN_ERROR_FOUNDER_PW) { ?><div class="errormsg loginmsg"><p>Incorrect founder password</p></div>
					<?php } elseif($errorcode == UC_LOGIN_ERROR_ADMIN_PW) { ?><div class="errormsg loginmsg"><p><em>Login Failed!</em><br />Invaild username or passowrd.</p></div>
					<?php } elseif($errorcode == UC_LOGIN_ERROR_ADMIN_NOT_EXISTS) { ?><div class="errormsg loginmsg"><p>This Admin does not exists</p></div>
					<?php } elseif($errorcode == UC_LOGIN_ERROR_SECCODE) { ?><div class="errormsg loginmsg"><p>Incorrect Security Code</p></div>
					<?php } elseif($errorcode == UC_LOGIN_ERROR_FAILEDLOGIN) { ?><div class="errormsg loginmsg"><p>You have tried to login too many times, please try again after 15 minutes</p></div>
					<?php } ?>
					<p>
						<input type="radio" name="isfounder" value="1" class="radio" <?php if((isset($_POST['isfounder']) && $isfounder) || !isset($_POST['isfounder'])) { ?>checked="checked"<?php } ?> onclick="$('username').value='UCenter Administrator'; $('username').readOnly = true; $('username').disabled = true; $('password').focus();" id="founder" /><label for="founder">Founder</label>
						<input type="radio" name="isfounder" value="0" class="radio" <?php if((isset($_POST['isfounder']) && !$isfounder)) { ?>checked="checked"<?php } ?> onclick="$('username').value=''; $('username').readOnly = false; $('username').disabled = false; $('username').focus();" id="admin" /><label for="admin">Administrator</label>
					</p>
					<p id="usernamediv">Username:<input type="text" name="username" class="txt" tabindex="1" id="username" value="<?php echo $username;?>" /></p>
					<p>Password:<input type="password" name="password" class="txt" tabindex="2" id="password" value="<?php echo $password;?>" /></p>
<!--vot-->				<p>Security Code:<input type="text" name="seccode" class="txt" tabindex="2" id="seccode" value="" style="margin-right:5px;width:85px;" /><img width="140" height="42" src="<?php echo UC_API;?>/admin.php?m=seccode&seccodeauth=<?php echo $seccodeinit;?>&<?php echo rand();?>" /></p>
					<p class="loginbtn"><input type="submit" name="submit" value="Login" class="btn" tabindex="3" /></p>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
<?php if((isset($_POST['isfounder']) && $isfounder) || !isset($_POST['isfounder'])) { ?>
	$('username').value='UCenter Administrator';
	$('username').disabled = true;
	$('username').readOnly = true;
	$('password').focus();
<?php } else { ?>
	$('username').readOnly = false;
	$('username').readOnly = false;
	$('username').focus();
<?php } ?>
</script>
<div class="footer">Powered by UCenter <?php echo UC_SERVER_VERSION;?> &copy; 2001 - 2011 <a href="http://www.comsenz.com/" target="_blank">Comsenz</a> Inc.</div>
<?php include $this->gettpl('footer');?>