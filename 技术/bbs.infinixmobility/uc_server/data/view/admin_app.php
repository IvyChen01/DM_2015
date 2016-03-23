<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<!-- Modified by Valery Votintsev -->
<?php include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script type="text/javascript">
var apps = new Array();
var run = 0;
function testlink() {
	if(apps[run]) {
		$('status_' + apps[run]).innerHTML = 'Connecting...';
		$('link_' + apps[run]).src = $('link_' + apps[run]).getAttribute('testlink') + '&sid=<?php echo $sid;?>';
	}
	run++;
}
window.onload = testlink;
</script>
<div class="container">
	<?php if($a == 'ls') { ?>
		<h3 class="marginbot">Application List<a href="admin.php?m=app&a=add" class="sgbtn">Add New Application</a></h3>
		<?php if(!$status) { ?>
			<div class="note fixwidthdec">
				<p class="i">If the connection failed, please click "Edit" to set the application IP.</p>
			</div>
		<?php } elseif($status == '2') { ?>
			<div class="correctmsg"><p>Application List Updated Successfully.</p></div>
		<?php } ?>
		<div class="mainbox">
			<?php if($applist) { ?>
				<form action="admin.php?m=app&a=ls" method="post">
					<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
					<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
						<tr>
							<th nowrap="nowrap"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">Delete</label></th>
							<th nowrap="nowrap">ID</th>
							<th nowrap="nowrap">Application Name</th>
							<th nowrap="nowrap">Application URL</th>
							<th nowrap="nowrap">Connection status</th>
							<th nowrap="nowrap">Details</th>
						</tr>
						<?php $i = 0;?>
						<?php foreach((array)$applist as $app) {?>
							<tr>
<!--vot-->							<td width="70"><input type="checkbox" name="delete[]" value="<?php echo $app['appid'];?>" class="checkbox" /></td>
								<td width="35"><?php echo $app['appid'];?></td>
								<td><a href="admin.php?m=app&a=detail&appid=<?php echo $app['appid'];?>"><strong><?php echo $app['name'];?></strong></a></td>
								<td><a href="<?php echo $app['url'];?>" target="_blank"><?php echo $app['url'];?></a></td>
<!--vot-->							<td width="140"><div id="status_<?php echo $app['appid'];?>"></div><script id="link_<?php echo $app['appid'];?>" testlink="admin.php?m=app&a=ping&inajax=1&url=<?php echo urlencode($app['url']);?>&ip=<?php echo urlencode($app['ip']);?>&appid=<?php echo $app['appid'];?>&random=<?php echo rand()?>"></script><script>apps[<?php echo $i;?>] = '<?php echo $app['appid'];?>';</script></td>
<!--vot-->							<td width="50"><a href="admin.php?m=app&a=detail&appid=<?php echo $app['appid'];?>">Edit</a></td>
							</tr>
							<?php $i++?>
						<?php } ?>
						<tr class="nobg">
							<td colspan="9"><input type="submit" value="Submit" class="btn" /></td>
						</tr>
					</table>
					<div class="margintop"></div>
				</form>
			<?php } else { ?>
				<div class="note">
					<p class="i">No Records!</p>
				</div>
			<?php } ?>
		</div>
	<?php } elseif($a == 'add') { ?>
		<h3 class="marginbot">Add New Application<a href="admin.php?m=app&a=ls" class="sgbtn">Return to Application List</a></h3>
		<div class="mainbox">
			<table class="opt">
				<tr>
					<th>Choose Install Type:</th>
				</tr>
				<tr>
					<td>
						<input type="radio" name="installtype" class="radio" checked="checked" onclick="$('url').style.display='none';$('custom').style.display='';" />Custom Install
						<input type="radio" name="installtype" class="radio" onclick="$('url').style.display='';$('custom').style.display='none';" />Install by URL (Recommended)
					</td>
				</tr>
			</table>
			<div id="url" style="display:none;">
				<form method="post" action="" target="_blank" onsubmit="document.appform.action=document.appform.appurl.value;" name="appform">
					<table class="opt">
						<tr>
							<th>Install Application by URL:</th>
						</tr>
						<tr>
							<td><input type="text" name="appurl" size="50" value="http://domainname/install/index.php" style="width:300px;" /></td>
						</tr>
					</table>
					<div class="opt">
						<input type="hidden" name="ucapi" value="<?php echo UC_API;?>" />
						<input type="hidden" name="ucfounderpw" value="<?php echo $md5ucfounderpw;?>" />
						<input type="submit" name="installsubmit"  value="Install" class="btn" />
					</div>
				</form>
			</div>
			<div id="custom">
				<form action="admin.php?m=app&a=add" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
					<table class="opt">
						<tr>
							<th colspan="2">Application Type:</th>
						</tr>
						<tr>
							<td>
							<select name="type">
								<?php foreach((array)$typelist as $typeid => $typename) {?>
									<option value="<?php echo $typeid;?>"> <?php echo $typename;?> </option>
								<?php }?>
							</select>
							</td>
							<td></td>
						</tr>
						<tr>
							<th colspan="2">Application Name:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="name" value="" /></td>
							<td>Limited to 20 Characters.</td>
						</tr>
						<tr>
							<th colspan="2">Application URL:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="url" value="" /></td>
							<td>Enter the Application API URL, that connect to UCenter. Without "/" at the end</td>
						</tr>
						<tr>
							<th colspan="2">Application IP:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="ip" value="" /></td>
							<td>Leave blank in common case. If your application is unable to connect the UCenter, you can try to set the application IP.</td>
						</tr>
						<tr>
							<th colspan="2">Connect Key:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="authkey" value="" /></td>
							<td>Only allows to use english letters and numbers, 64 characters limited. You must set the key in application same as this value, otherwise the application will not be able to connect to UCenter.</td>
						</tr>


						<tr>
							<th colspan="2">Application Real Path:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="apppath" value="" />
							</td>
							<td>Default is blank, if you enter the relative path (from UC), the program will convert it to the absolute path automatically, such as ../</td>
						</tr>
						<tr>
							<th colspan="2">Personal Profile Page URL:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="viewprourl" value="" />
							</td>
							<td>Example: /space.php?uid=%s . Where %s represents the UID</td>
						</tr>
						<tr>
							<th colspan="2">Application API Filename:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="apifilename" value="uc.php" />
							</td>
							<td>Application API Filename, not contain the Path, default is uc.php</td>
						</tr>
						<tr>
							<th colspan="2">Tag Template:</th>
						</tr>
						<tr>
							<td><textarea class="area" name="tagtemplates"></textarea></td>
							<td valign="top">The tag template of current application showed in other applications.</td>
						</tr>

						<tr>
							<th colspan="2">Tag Template Description:</th>
						</tr>
						<tr>
							<td><textarea class="area" name="tagfields"><?php echo $tagtemplates['fields'];?></textarea></td>
							<td valign="top">Only one description per line, separated the name and title by ",". Example:<br />subject,Thread Title<br />url,Thread Address</td>
						</tr>
						<tr>
							<th colspan="2">Login all Application at the same time?:</th>
						</tr>
						<tr>
							<td>
								<input type="radio" class="radio" id="yes" name="synlogin" value="1" /><label for="yes">Yes</label>
								<input type="radio" class="radio" id="no" name="synlogin" value="0" checked="checked" /><label for="no">No</label>
							</td>
							<td>Open this function, when you login other applications, you will login this application at same time.</td>
						</tr>
						<tr>
							<th colspan="2">Receive Notice?:</th>
						</tr>
						<tr>
							<td>
								<input type="radio" class="radio" id="yes" name="recvnote" value="1"/><label for="yes">Yes</label>
								<input type="radio" class="radio" id="no" name="recvnote" value="0" checked="checked" /><label for="no">No</label>
							</td>
							<td></td>
						</tr>
					</table>
					<div class="opt"><input type="submit" name="submit" value=" Submit " class="btn" tabindex="3" /></div>
				</form>
			</div>
		</div>
	<?php } else { ?>
		<h3 class="marginbot">Edit Application<a href="admin.php?m=app&a=ls" class="sgbtn">Return to Application List</a></h3>
		<?php if($updated) { ?>
			<div class="correctmsg"><p>Updated Successfully.</p></div>
		<?php } elseif($addapp) { ?>
			<div class="correctmsg"><p>Application Added Successfully.</p></div>
		<?php } ?>
		<div class="mainbox">
			<form action="admin.php?m=app&a=detail&appid=<?php echo $appid;?>" method="post">
			<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th colspan="2">ID: <?php echo $appid;?></th>
					</tr>
					<tr>
						<th colspan="2">Application Type:</th>
					</tr>
					<tr>
						<td>
						<select name="type">
							<?php foreach((array)$typelist as $typeid => $typename) {?>
							<option value="<?php echo $typeid;?>" <?php if($typeid == $type) { ?>selected="selected"<?php } ?>> <?php echo $typename;?> </option>
							<?php }?>
						</select>
						</td>
						<td></td>
					</tr>

					<tr>
						<th colspan="2">Application Name:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="name" value="<?php echo $name;?>" /></td>
						<td>Limited to 20 Characters.</td>
					</tr>
					<tr>
						<th colspan="2">Application URL:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="url" value="<?php echo $url;?>" /></td>
						<td>Enter the Application API URL, that connect to UCenter. Without "/" at the end</td>
					</tr>
					<tr>
						<th colspan="2">Application extra URL:</th>
					</tr>
					<tr>
						<td><textarea name="extraurl" class="area"><?php echo $extraurl;?></textarea></td>
						<td>Other URLs that this application can access. Please do not add "/" at the end, one URL per line. Only synchronized URL can be requested</td>
					</tr>
					<tr>
						<th colspan="2">Application IP:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="ip" value="<?php echo $ip;?>" /></td>
						<td>Leave blank in common case. If your application is unable to connect the UCenter, you can try to set the application IP.</td>
					</tr>
					<tr>
						<th colspan="2">Connect Key:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="authkey" value="<?php echo $authkey;?>" /></td>
						<td>Only allows to use english letters and numbers, 64 characters limited. You must set the key in application same as this value, otherwise the application will not be able to connect to UCenter.</td>
					</tr>

					<tr>
						<th colspan="2">Application Real Path:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="apppath" value="<?php echo $apppath;?>" />
						</td>
						<td>Default is blank, if you enter the relative path (from UC), the program will convert it to the absolute path automatically, such as ../</td>
					</tr>
					<tr>
						<th colspan="2">Personal Profile Page URL:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="viewprourl" value="<?php echo $viewprourl;?>" />
						</td>
						<td>Example: /space.php?uid=%s . Where %s represents the UID</td>
					</tr>
					<tr>
						<th colspan="2">Application API Filename:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="apifilename" value="<?php echo $apifilename;?>" />
						</td>
						<td>Application API Filename, not contain the Path, default is uc.php</td>
					</tr>

					<tr>
						<th colspan="2">Tag Template:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="tagtemplates"><?php echo $tagtemplates['template'];?></textarea></td>
						<td valign="top">The tag template of current application showed in other applications.</td>
					</tr>
					<tr>
						<th colspan="2">Tag Template Description:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="tagfields"><?php echo $tagtemplates['fields'];?></textarea></td>
						<td valign="top">Only one description per line, separated the name and title by ",". Example:<br />subject,Thread Title<br />url,Thread Address</td>
					</tr>
					<tr>
						<th colspan="2">Login all Application at the same time?:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="yes" name="synlogin" value="1" <?php echo $synlogin[1];?> /><label for="yes">Yes</label>
							<input type="radio" class="radio" id="no" name="synlogin" value="0" <?php echo $synlogin[0];?> /><label for="no">No</label>
						</td>
						<td>Open this function, when you login other applications, you will login this application at same time.</td>
					</tr>
					<tr>
						<th colspan="2">Receive Notice?:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="yes" name="recvnote" value="1" <?php echo $recvnotechecked[1];?> /><label for="yes">Yes</label>
							<input type="radio" class="radio" id="no" name="recvnote" value="0" <?php echo $recvnotechecked[0];?> /><label for="no">No</label>
						</td>
						<td></td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" Submit " class="btn" tabindex="3" /></div>
<?php if($isfounder) { ?>
				<table class="opt">
					<tr>
						<th colspan="2">Application UCenter Configuration Information:</th>
					</tr>
					<tr>
						<th>
<textarea class="area" onFocus="this.select()">
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '<?php echo UC_DBHOST;?>');
define('UC_DBUSER', '<?php echo UC_DBUSER;?>');
define('UC_DBPW', '<?php echo UC_DBPW;?>');
define('UC_DBNAME', '<?php echo UC_DBNAME;?>');
define('UC_DBCHARSET', '<?php echo UC_DBCHARSET;?>');
define('UC_DBTABLEPRE', '`<?php echo UC_DBNAME;?>`.<?php echo UC_DBTABLEPRE;?>');
define('UC_DBCONNECT', '0');
define('UC_KEY', '<?php echo $authkey;?>');
define('UC_API', '<?php echo UC_API;?>');
define('UC_CHARSET', '<?php echo UC_CHARSET;?>');
define('UC_IP', '');
define('UC_APPID', '<?php echo $appid;?>');
define('UC_PPP', '20');
</textarea>
						</th>
						<td>If you lost your application UCenter Configuration Information, you can copy the code below to application Configuration file</td>
					</tr>
				</table>
<?php } ?>
			</form>
		</div>
	<?php } ?>
</div>

<?php include $this->gettpl('footer');?>