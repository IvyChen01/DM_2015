<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<div class="container">
	<?php if($status) { ?>
		<div class="<?php if($status > 0) { ?>correctmsg<?php } else { ?>errormsg<?php } ?>"><p><?php if($status == 2) { ?>Domain List Updated Successfully.<?php } elseif($status == 1) { ?>Domain Added Successfully.<?php } ?></p></div>
	<?php } ?>
	<div class="hastabmenu">
		<ul class="tabmenu">
			<li class="tabcurrent"><a href="#" class="tabcurrent">Add Domain</a></li>
		</ul>
		<div class="tabcontentcur">
			<form action="admin.php?m=domain&a=ls" method="post">
			<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
			<table>
				<tr>
					<td>Domain:</td>
					<td><input type="text" name="domainnew" class="txt" /></td>
					<td>IP:</td>
					<td><input type="text" name="ipnew" class="txt" /></td>
					<td><input type="submit" value="Submit"  class="btn" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<h3>Domain List</h3>
	<div class="mainbox">
		<?php if($domainlist) { ?>
			<form action="admin.php?m=domain&a=ls" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="datalist fixwidth">
					<tr>
						<th width="10%"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">Delete</label></th>
						<th width="60%">Domain</th>
						<th width="30%">IP</th>
					</tr>
					<?php foreach((array)$domainlist as $domain) {?>
					<tr>
						<td><input type="checkbox" name="delete[]" value="<?php echo $domain['id'];?>" class="checkbox" /></td>
						<td><input type="text" name="domain[<?php echo $domain['id'];?>]" value="<?php echo $domain['domain'];?>" title="Click to Edit and Submit to Save" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" style="text-align:left;" /></td>
						<td><input type="text" name="ip[<?php echo $domain['id'];?>]" value="<?php echo $domain['ip'];?>" title="Click to Edit and Submit to Save" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" style="text-align:left;" /></td>
					</tr>
					<?php } ?>
					<tr class="nobg">
						<td><input type="submit" value="Submit" class="btn" /></td>
						<td class="tdpage" colspan="2"><?php echo $multipage;?></td>
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

<?php include $this->gettpl('footer');?>