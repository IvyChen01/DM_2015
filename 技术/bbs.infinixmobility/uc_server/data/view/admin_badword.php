<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script type="text/javascript">
	function switchbtn(btn) {
		$('srchuserdiv').style.display = btn == 'srch' ? '' : 'none';
		$('srchuserdiv').className = btn == 'srch' ? 'tabcontentcur' : '' ;
		$('srchuserbtn').className = btn == 'srch' ? 'tabcurrent' : '';
		$('adduserdiv').style.display = btn == 'srch' ? 'none' : '';
		$('adduserdiv').className = btn == 'srch' ? '' : 'tabcontentcur';
		$('adduserbtn').className = btn == 'srch' ? '' : 'tabcurrent';
		$('tmenu').style.height = btn == 'srch' ? '80'+'px' : '280'+'px';
	}
</script>
<div class="container">
	<?php if($status) { ?>
		<div class="correctmsg"><p><?php if($status == 2) { ?>Bad Word List Updated successfully.<?php } elseif($status == 1) { ?>Bad Word Added Successfully.<?php } ?></p></div>
	<?php } ?>
	<div id="tmenu" class="hastabmenu">
		<ul class="tabmenu">
			<li id="srchuserbtn" class="tabcurrent"><a href="#" onclick="switchbtn('srch');">Add Bad Words</a></li>
			<li id="adduserbtn"><a href="#" onclick="switchbtn('add');">Bulk Add</a></li>
		</ul>
		<div id="adduserdiv" class="tabcontent" style="display:none;">
			<form action="admin.php?m=badword&a=ls" method="post">
				<ul class="tiplist">
					<li>One item per each line, use "=" for separate the bad words and the replacement word.</li>
					<li>If you want to replace some words as **, Only need type that word here.</li>
					<li><strong>Example:</strong></li>
					<li>toobadword</li>
					<li>badword=goodword</li>
				</ul>
				<textarea name="badwords" class="bigarea"></textarea>
				<ul class="optlist">
					<li><input type="radio" name="type" value="2" id="badwordsopt2" class="radio" checked="checked" /><label for="badwordsopt2">Skip the current bad words when conflict</label></li>
					<li><input type="radio" name="type" value="1" id="badwordsopt1" class="radio" /><label for="badwordsopt1">Cover the current bad word list when conflict</label></li>
					<li><input type="radio" name="type" value="0" id="badwordsopt0" class="radio" /><label for="badwordsopt0">Drop the current bad word list, and then import new words (This operation can not be restored, recommend you to <a href="admin.php?m=badword&a=export" target="_blanks">Export Word List</a>, and make a backup file)</label></li>
				</ul>
				<input type="submit" name="multisubmit" value="Submit" class="btn" />
			</form>

		</div>
		<div id="srchuserdiv" class="tabcontentcur">
			<form action="admin.php?m=badword&a=ls" method="post">
			<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
			<table>
				<tr>
					<td>Bad Words:</td>
					<td><input type="text" name="findnew" class="txt" /></td>
					<td>Replace to:</td>
					<td><input type="text" name="replacementnew" class="txt" /></td>
					<td><input type="submit" value="Submit"  class="btn" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<br />
	<h3>Bad Word List</h3>
	<div class="mainbox">
		<?php if($badwordlist) { ?>
			<form action="admin.php?m=badword&a=ls" method="post">
				<table class="datalist fixwidth">
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">Delete</label></th>
						<th style="text-align:right;padding-right:11px;">Bad Words</th>
						<th></th>
						<th>Replace to</th>
						<th>Operator</th>
					</tr>
					<?php foreach((array)$badwordlist as $badword) {?>
						<tr>
							<td class="option"><input type="checkbox" name="delete[]" value="<?php echo $badword['id'];?>" class="checkbox" /></td>
							<td class="tdinput"><input type="text" name="find[<?php echo $badword['id'];?>]" value="<?php echo $badword['find'];?>" title="Click to Edit and Submit to Save" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" /></td>
							<td class="tdarrow">&gt;</td>
							<td class="tdinput"><input type="text" name="replacement[<?php echo $badword['id'];?>]" value="<?php echo $badword['replacement'];?>" title="Click to Edit and Submit to Save" class="txtnobd"  onblur="this.className='txtnobd'" onfocus="this.className='txt'" style="text-align:left;" /></td>
							<td><?php echo $badword['admin'];?></td>
						</tr>
					<?php } ?>
					<tr class="nobg">
						<td><input type="submit" value="Submit" class="btn" /></td>
						<td class="tdpage" colspan="4"><?php echo $multipage;?></td>
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