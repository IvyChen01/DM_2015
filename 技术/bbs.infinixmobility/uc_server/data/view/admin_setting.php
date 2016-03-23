<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>

<div class="container">
	<?php if($updated) { ?>
		<div class="correctmsg"><p>Updated Successfully.</p></div>
	<?php } elseif($a == 'register') { ?>
		<div class="note fixwidthdec"><p class="i">Allowed/Forbidden Email List. You just need to enter its domain. One Email per line. Example: @hotmail.com</p></div>
	<?php } ?>
	<?php if($a == 'ls') { ?>
		<div class="mainbox nomargin">
			<form action="admin.php?m=setting&a=ls" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th colspan="2">Date Format:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="dateformat" value="<?php echo $dateformat;?>" /></td>
						<td>Use yyyy(yy) as Year, mm as Month, dd as Day. Example: yyyy-mm-dd will result as 2009-07-28</td>
					</tr>
					<tr>
						<th colspan="2">Time Format:</th>
					</tr>
					<td>
						<input type="radio" id="hr24" class="radio" name="timeformat" value="1" <?php echo $timeformat[1];?> /><label for="hr24">24 Hours</label>
						<input type="radio" id="hr12" class="radio" name="timeformat" value="0" <?php echo $timeformat[0];?> /><label for="hr12">12 Hours</label>
					</td>
					</tr>
					<tr>
						<th colspan="2">Time offset:</th>
					</tr>
					<tr>
						<td>
							<select name="timeoffset">
								<option value="-12" <?php echo $checkarray['012'];?>>(GMT -12:00) Eniwetok, Kwajalein</option>
								<option value="-11" <?php echo $checkarray['011'];?>>(GMT -11:00) Midway Island, Samoa</option>
								<option value="-10" <?php echo $checkarray['010'];?>>(GMT -10:00) Hawaii</option>
								<option value="-9" <?php echo $checkarray['09'];?>>(GMT -09:00) Alaska</option>
								<option value="-8" <?php echo $checkarray['08'];?>>(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
								<option value="-7" <?php echo $checkarray['07'];?>>(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
								<option value="-6" <?php echo $checkarray['06'];?>>(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
								<option value="-5" <?php echo $checkarray['05'];?>>(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
								<option value="-4" <?php echo $checkarray['04'];?>>(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
								<option value="-3.5" <?php echo $checkarray['03.5'];?>>(GMT -03:30) Newfoundland</option>
								<option value="-3" <?php echo $checkarray['03'];?>>(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
								<option value="-2" <?php echo $checkarray['02'];?>>(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
								<option value="-1" <?php echo $checkarray['01'];?>>(GMT -01:00) Azores, Cape Verde Islands</option>
								<option value="0" <?php echo $checkarray['0'];?>>(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
								<option value="1" <?php echo $checkarray['1'];?>>(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
								<option value="2" <?php echo $checkarray['2'];?>>(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
								<option value="3" <?php echo $checkarray['3'];?>>(GMT +03:00) Baghdad, Riyadh, Nairobi</option>
								<option value="3.5" <?php echo $checkarray['3.5'];?>>(GMT +03:30) Tehran</option>
								<option value="4" <?php echo $checkarray['4'];?>>(GMT +04:00) Abu Dhabi, Baku, Moscow, Muscat, Tbilisi</option>
								<option value="4.5" <?php echo $checkarray['4.5'];?>>(GMT +04:30) Kabul</option>
								<option value="5" <?php echo $checkarray['5'];?>>(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
								<option value="5.5" <?php echo $checkarray['5.5'];?>>(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
								<option value="5.75" <?php echo $checkarray['5.75'];?>>(GMT +05:45) Katmandu</option>
								<option value="6" <?php echo $checkarray['6'];?>>(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
								<option value="6.5" <?php echo $checkarray['6.5'];?>>(GMT +06:30) Rangoon</option>
								<option value="7" <?php echo $checkarray['7'];?>>(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
<!--vot-->							<option value="8" <?php echo $checkarray['8'];?>>(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
								<option value="9" <?php echo $checkarray['9'];?>>(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
								<option value="9.5" <?php echo $checkarray['9.5'];?>>(GMT +09:30) Adelaide, Darwin</option>
								<option value="10" <?php echo $checkarray['10'];?>>(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
								<option value="11" <?php echo $checkarray['11'];?>>(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
								<option value="12" <?php echo $checkarray['12'];?>>(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
							</select>
						</td>
						<td>Default: GMT +08:00</td>
					</tr>

					<tr>
						<th colspan="2">Reg Days to send Message:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="pmsendregdays" value="<?php echo $pmsendregdays;?>" /></td>
						<td>If the reg days is less than the value, the users can't send messages. 0 means unlimited. This is to limit ad robort</td>
					</tr>
					<tr>
						<th colspan="2">Max Number of Messages allowed for a user in 24 hours:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="privatepmthreadlimit" value="<?php echo $privatepmthreadlimit;?>" /></td>
						<td>Recommend value: 30 - 100, 0 is unlimited, this is to prevent the Ads robots</td>
					</tr>
					<tr>
						<th colspan="2">Max Number of group chat Messages allowed for a user in 24 hours:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="chatpmthreadlimit" value="<?php echo $chatpmthreadlimit;?>" /></td>
						<td>Recommend value: 30 - 100, 0 is unlimited, this is to prevent the Ads robots</td>
					</tr>
					<tr>
						<th colspan="2">Maximum number of recipients that a user allowed to send group chat short messages within 24 hours:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="chatpmmemberlimit" value="<?php echo $chatpmmemberlimit;?>" /></td>
						<td>Limit the number of PM recipients that the user can send group chat short messages within 24 hours. We recommend to use a value in range of 30 - 100. Se to 0 for no restrictions. Used for limit the quantities of possible spam through the server</td>
					</tr>
					<tr>
						<th colspan="2">PM Flood Prevention:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="pmfloodctrl" value="<?php echo $pmfloodctrl;?>" /></td>
						<td>Interval between two PM, in seconds, 0 for unlimited, this is to prevent the Ads robots</td>
					</tr>

					<tr>
						<th colspan="2">Enable Message Center:</th>
					</tr>
					<tr>
					<td>
						<input type="radio" id="pmcenteryes" class="radio" name="pmcenter" value="1" <?php echo $pmcenter[1];?> onclick="$('hidden1').style.display=''"  /><label for="pmcenteryes">Yes</label>
						<input type="radio" id="pmcenterno" class="radio" name="pmcenter" value="0" <?php echo $pmcenter[0];?> onclick="$('hidden1').style.display='none'" /><label for="pmcenterno">No</label>
					</td>
					<td>Whether to enable or not the Message Center, it not affect the applications</td>
					</tr>
					<tbody id="hidden1" <?php echo $pmcenter['display'];?>>
					<tr>
						<th colspan="2">Enable Security Code for PM:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" id="sendpmseccodeyes" class="radio" name="sendpmseccode" value="1" <?php echo $sendpmseccode[1];?> /><label for="sendpmseccodeyes">Yes</label>
							<input type="radio" id="sendpmseccodeno" class="radio" name="sendpmseccode" value="0" <?php echo $sendpmseccode[0];?> /><label for="sendpmseccodeno">No</label>
						</td>
						<td>This is to prevent the Ads robots</td>
					</tr>
					</tbody>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" Submit " class="btn" tabindex="3" /></div>
			</form>
		</div>
	<?php } elseif($a == 'register') { ?>
		<div class="mainbox nomargin">
			<form action="admin.php?m=setting&a=register" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th colspan="2">Allow Multiple Registration with the same Email:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" id="yes" class="radio" name="doublee" value="1" <?php echo $doublee[1];?> /><label for="yes">Yes</label>
							<input type="radio" id="no" class="radio" name="doublee" value="0" <?php echo $doublee[0];?> /><label for="no">No</label>
						</td>
					</tr>
					<tr>
						<th colspan="2">Allowed Email Address:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="accessemail"><?php echo $accessemail;?></textarea></td>
						<td valign="top">Allow to register Email only from this domains.<br \>Example: hotmail.com</td>
					</tr>
					<tr>
						<th colspan="2">Forbidden Email Address:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="censoremail"><?php echo $censoremail;?></textarea></td>
						<td valign="top">Disable to register Email for this domains.<br \>Example: hotmail.com</td>
					</tr>
					<tr>
						<th colspan="2">Ban This Username:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="censorusername"><?php echo $censorusername;?></textarea></td>
						<td valign="top">You can use wildcards "*", a keyword per each line, such as "*Moderator*" (without quotation marks).</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" Submit " class="btn" tabindex="3" /></div>
			</form>
		</div>
	<?php } else { ?>
		<div class="mainbox nomargin">
			<form action="admin.php?m=setting&a=mail" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th colspan="2">Email From:</th>
					</tr>
					<tr>
						<td><input name="maildefault" value="<?php echo $maildefault;?>" type="text"></td>
						<td>Use this address as a default email sender</td>
					<tr>
						<th colspan="2">Send Method:</th>
					</tr>
					<tr>
						<td colspan="2">
							<label><input class="radio" name="mailsend" value="1"<?php if($mailsend == 1) { ?> checked="checked"<?php } ?> onclick="$('hidden1').style.display = 'none';$('hidden2').style.display = 'none';" type="radio"> Send through PHP mail Function (Recommend)</label><br />
							<label><input class="radio" name="mailsend" value="2"<?php if($mailsend == 2) { ?> checked="checked"<?php } ?> onclick="$('hidden1').style.display = '';$('hidden2').style.display = '';" type="radio"> Send through SMTP SOCKET (Support ESMTP Authentication)</label><br />
							<label><input class="radio" name="mailsend" value="3"<?php if($mailsend == 3) { ?> checked="checked"<?php } ?> onclick="$('hidden1').style.display = '';$('hidden2').style.display = 'none';" type="radio"> Send through PHP SMTP Function (For Windows servers only, does not support the ESMTP Authentication)</label>
						</td>
					</tr>
					<tbody id="hidden1"<?php if($mailsend == 1) { ?> style="display:none"<?php } ?>>
					<tr>
						<td colspan="2">SMTP Server Settings:</td>
					</tr>
					<tr>
						<td>
							<input name="mailserver" value="<?php echo $mailserver;?>" class="txt" type="text">
						</td>
						<td valign="top">Set SMTP Server address</td>
					</tr>
					<tr>
						<td colspan="2">SMTP Port:</td>
					</tr>
					<tr>
						<td>
							<input name="mailport" value="<?php echo $mailport;?>" type="text">
						</td>
						<td valign="top">Set the SMTP Server Port, Default is 25</td>
					</tr>
					</tbody>
					<tbody id="hidden2"<?php if($mailsend == 1 || $mailsend == 3) { ?> style="display:none"<?php } ?>>
					<tr>
						<td colspan="2">SMTP Server need authentication:</td>
					</tr>
					<tr>
						<td>
							<label><input type="radio" class="radio" name="mailauth"<?php if($mailauth == 1) { ?> checked="checked"<?php } ?> value="1" />Yes</label>
							<label><input type="radio" class="radio" name="mailauth"<?php if($mailauth == 0) { ?> checked="checked"<?php } ?> value="0" />No</label>
						</td>
						<td valign="top">Choose "Yes" if need</td>
					</tr>
					<tr>
						<td colspan="2">Sender Email Address:</td>
					</tr>
					<tr>
						<td>
							<input name="mailfrom" value="<?php echo $mailfrom;?>" class="txt" type="text">
						</td>
						<td valign="top">If you want to include the username, use the next Format: username &lt;user@domain.com&gt;</td>
					</tr>
					<tr>
						<td colspan="2">SMTP Username:</td>
					</tr>
					<tr>
						<td>
							<input name="mailauth_username" value="<?php echo $mailauth_username;?>" type="text">
						</td>
						<td valign="top"></td>
					</tr>
					<tr>
						<td colspan="2">SMTP Password:</td>
					</tr>
					<tr>
						<td>
							<input name="mailauth_password" value="<?php echo $mailauth_password;?>" type="text">
						</td>
						<td valign="top"></td>
					</tr>
					</tbody>
					<tr>
						<th colspan="2">Delimiter for header lines:</th>
					</tr>
					<tr>
						<td>
							<label><input class="radio" name="maildelimiter"<?php if($maildelimiter == 1) { ?> checked="checked"<?php } ?> value="1" type="radio"> Use "CRLF"</label><br />
							<label><input class="radio" name="maildelimiter"<?php if($maildelimiter == 0) { ?> checked="checked"<?php } ?> value="0" type="radio"> Use "LF"</label><br />
							<label><input class="radio" name="maildelimiter"<?php if($maildelimiter == 2) { ?> checked="checked"<?php } ?> value="2" type="radio"> Use "CR"</label>
						</td>
						<td>
							Adjust it according to your mail server
						</td>
					</tr>
					<tr>
						<th colspan="2">Username included in receiver address:</th>
					</tr>
					<tr>
						<td>
							<label><input type="radio" class="radio" name="mailusername"<?php if($mailusername == 1) { ?> checked="checked"<?php } ?> value="1" />Yes</label>
							<label><input type="radio" class="radio" name="mailusername"<?php if($mailusername == 0) { ?> checked="checked"<?php } ?> value="0" />No</label>
						</td>
						<td valign="top">Choose "Yes" if need</td>
					</tr>
					<tr>
						<th colspan="2">Ignore all error hints during mail sending:</th>
					</tr>
					<tr>
						<td>
							<label><input type="radio" class="radio" name="mailsilent"<?php if($mailsilent == 1) { ?> checked="checked"<?php } ?> value="1" />Yes</label>
							<label><input type="radio" class="radio" name="mailsilent"<?php if($mailsilent == 0) { ?> checked="checked"<?php } ?> value="0" />No</label>
						</td>
						<td valign="top">&nbsp;</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" Submit " class="btn" tabindex="3" /></div>
			</form>
		</div>
	<?php } ?>
</div>

<?php include $this->gettpl('footer');?>