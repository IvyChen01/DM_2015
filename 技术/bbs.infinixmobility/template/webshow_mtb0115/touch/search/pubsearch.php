<?php exit;?>
<!--{if !empty($srchtype)}--><input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
<div class="search">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td style="padding-left: 5px">
						<input value="$keyword" autocomplete="off" class="input" name="srchtxt" id="scform_srchtxt" value="" placeholder="Thread Searching">
					</td>
					<td width="66" align="center" class="scbar_btn_td" style="padding-right: 5px">
						<div><input type="hidden" name="searchsubmit" value="yes"><input type="submit" value="Go" class="button2" id="scform_submit"></div>
					</td>
				</tr>
			</tbody>
		</table>
</div>
