<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>
<!--Modified by Valery Votintsev, codersclub.org-->
<script src="js/common.js" type="text/javascript"></script>
<script src="js/calendar.js" type="text/javascript"></script>

<?php if($a == 'ls') { ?>

	<script type="text/javascript">
		function switchbtn(btn) {
			$('srchuserdiv').style.display = btn == 'srch' ? '' : 'none';
			$('srchuserdiv').className = btn == 'srch' ? 'tabcontentcur' : '' ;
			$('srchuserbtn').className = btn == 'srch' ? 'tabcurrent' : '';
			$('adduserdiv').style.display = btn == 'srch' ? 'none' : '';
			$('adduserdiv').className = btn == 'srch' ? '' : 'tabcontentcur';
			$('adduserbtn').className = btn == 'srch' ? '' : 'tabcurrent';
		}
	</script>

	<div class="container">
		<?php if($status) { ?>
			<div class="<?php if($status > 0) { ?>correctmsg<?php } else { ?>errormsg<?php } ?>"><p><?php if($status < 0) { ?><em>User Add Failed:</em> <?php } ?><?php if($status == 2) { ?>User(s) Deleted Successfully<?php } elseif($status == 1) { ?>User Added Successfully.<?php } elseif($status == -1) { ?>Illegal Username<?php } elseif($status == -2) { ?>Username contain bad words<?php } elseif($status == -3) { ?>This username is already exists<?php } elseif($status == -4) { ?>Illegal Email<?php } elseif($status == -5) { ?>This Email is not allowed<?php } elseif($status == -6) { ?>This Email is already exists<?php } ?></p></div>
		<?php } ?>
		<div class="hastabmenu">
			<ul class="tabmenu">
				<li id="srchuserbtn" class="tabcurrent"><a href="#" onclick="switchbtn('srch')">Search User</a></li>
				<li id="adduserbtn"><a href="#" onclick="switchbtn('add')">Add User</a></li>
			</ul>
			<div id="adduserdiv" class="tabcontent" style="display:none;">
				<form action="admin.php?m=user&a=ls&adduser=yes" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table width="100%">
					<tr>
						<td>Username:</td>
						<td><input type="text" name="addname" class="txt" /></td>
						<td>Password:</td>
						<td><input type="text" name="addpassword" class="txt" /></td>
						<td>Email:</td>
						<td><input type="text" name="addemail" class="txt" /></td>
						<td><input type="submit" value="Submit"  class="btn" /></td>
					</tr>
				</table>
				</form>
			</div>
			<div id="srchuserdiv" class="tabcontentcur">
				<form action="admin.php?m=user&a=ls" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table width="100%">
					<tr>
						<td>Username:</td>
						<td><input type="text" name="srchname" value="<?php echo $srchname;?>" class="txt" /></td>
						<td>UID:</td>
						<td><input type="text" name="srchuid" value="<?php echo $srchuid;?>" class="txt" /></td>
						<td>Email:</td>
						<td><input type="text" name="srchemail" value="<?php echo $srchemail;?>" class="txt" /></td>
						<td rowspan="2"><input type="submit" value="Submit" class="btn" /></td>
					</tr>
					<tr>
						<td>Reg. Date:</td>
<!--vot-->					<td><input type="text" name="srchregdatestart" onclick="showcalendar();" value="<?php echo $srchregdatestart;?>" class="txt" /></td>
<!--vot-->					<td> to </td>
<!--vot-->					<td><input type="text" name="srchregdateend" onclick="showcalendar();" value="<?php echo $srchregdateend;?>" class="txt" /></td>
						<td>Reg. IP:</td>
						<td><input type="text" name="srchregip" value="<?php echo $srchregip;?>" class="txt" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>

		<?php if($adduser) { ?><script type="text/javascript">switchbtn('add');</script><?php } ?>
<br />
		<h3>User List</h3>
		<div class="mainbox">
			<?php if($userlist) { ?>
				<form action="admin.php?m=user&a=ls&srchname=<?php echo $srchname;?>&srchregdate=<?php echo $srchregdate;?>" onsubmit="return confirm('This operation can not be restored, confirm to delete these users?');" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">Delete</label></th>
						<th>Username</th>
						<th>Email</th>
						<th>Reg. Date</th>
						<th>Reg. IP</th>
						<th>Edit</th>
					</tr>
					<?php foreach((array)$userlist as $user) {?>
						<tr>
							<td class="option"><input type="checkbox" name="delete[]" value="<?php echo $user['uid'];?>" class="checkbox" /></td>
							<td><?php echo $user['smallavatar'];?> <strong><?php echo $user['username'];?></strong></td>
							<td><?php echo $user['email'];?></td>
							<td><?php echo $user['regdate'];?></td>
							<td><?php echo $user['regip'];?></td>
							<td><a href="admin.php?m=user&a=edit&uid=<?php echo $user['uid'];?>">Edit</a></td>
						</tr>
					<?php } ?>
					<tr class="nobg">
						<td><input type="submit" value="Submit" class="btn" /></td>
						<td class="tdpage" colspan="6"><?php echo $multipage;?></td>
					</tr>
				</table>
				</form>
			<?php } else { ?>
				<div class="note">
					<p class="i">No Records!</p>
				</div>
			<?php } ?>
		</div>
	</div>

<?php } else { ?>

	<div class="container">
		<h3 class="marginbot">Edit User Profile
			<?php if(getgpc('fromadmin')) { ?>
				<a href="admin.php?m=admin&a=ls" class="sgbtn">Return to Admin List</a>
			<?php } else { ?>
				<a href="admin.php?m=user&a=ls" class="sgbtn">Return to User List</a>
			<?php } ?>
		</h3>
		<?php if($status == 1) { ?>
			<div class="correctmsg"><p>User Profile Edited successfully</p></div>
		<?php } elseif($status == -1) { ?>
			<div class="correctmsg"><p>User Profile Edit failed</p></div>
		<?php } else { ?>
			<div class="note"><p class="i">Leave blank to use old password.</p></div>
		<?php } ?>
		<div class="mainbox">
			<form action="admin.php?m=user&a=edit&uid=<?php echo $uid;?>" method="post">
			<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th>Avatar: <input name="delavatar" class="checkbox" type="checkbox" value="1" /> Delete Avatar</th>
					</tr>
					<tr>
						<th>Virtual Avatar:</th>
					</tr>
					<tr>
						<td><?php echo $user['bigavatar'];?></td>
					</tr>
					<tr>
						<th>Real Avatar:</th>
					</tr>
					<tr>
						<td><?php echo $user['bigavatarreal'];?></td>
					</tr>
					<tr>
						<th>Username:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="newusername" value="<?php echo $user['username'];?>" class="txt" />
							<input type="hidden" name="username" value="<?php echo $user['username'];?>" class="txt" />
						</td>
					</tr>
					<tr>
						<th>Password:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="password" value="" class="txt" />
						</td>
					</tr>
					<tr>
						<th>Security Question: <input type="checkbox" class="checkbox" name="rmrecques" value="1" /> Clean Security Questions</th>
					</tr>
					<tr>
						<th>Email:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="email" value="<?php echo $user['email'];?>" class="txt" />
						</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" Submit " class="btn" tabindex="3" /></div>
			</form>
		</div>
	</div>
<?php } ?>
<?php include $this->gettpl('footer');?>