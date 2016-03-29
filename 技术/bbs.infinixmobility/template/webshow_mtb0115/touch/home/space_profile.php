<?php exit;?>
<!--{if $_GET['mycenter'] && !$_G['uid']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
<!--{/if}-->
<!--{template common/header}-->

<!--{if !$_GET['mycenter']}-->
    <!--{subtemplate home/space_profile_body}-->
<!--{else}-->
<div class="cc_home">
    <div class="cc_home_h">
        <div class="s1"><img src="template/webshow_mtb0115/touch/img/space_bg.jpg"></div>
        <div class="s2"></div>
        <div class="s3"><img src="{avatar($_G[uid], small, true)}" /></div>
        <div class="s4">$_G[username]</div>
<!--        <div class="s5"><a href="home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1">Edit Profile</a></div> -->
    </div>

    <div class="cc_home_c">
    <form action="home.php?mod=spacecp&ac=profile&mycenter=1&mobile=2" method="post" autocomplete="off">
				<input type="hidden" value="6e5e582f" name="frompasswd" />
				<table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" width="100%">
					<!--{if !$_G['setting']['connect']['allow'] || !$conisregister}-->
						<tr>
							<th><span class="rq" title="{lang required}">*</span>Old password</th>
							<td><input type="password" name="oldpassword" id="oldpassword" class="px" /></td>
						</tr>
					<!--{/if}-->
					<tr>
						<th>New password</th>
						<td>
							<input type="password" name="newpassword" id="newpassword" class="px" />
							<p class="d" id="chk_newpassword">Please leave it empty if you are not intend to change your password.</p>
						</td>
					</tr>
					<tr>
						<th>Retype new password</th>
						<td>
							<input type="password" name="newpassword2" id="newpassword2"class="px" />
							<p class="d" id="chk_newpassword2">Please leave it empty if you are not intend to change your password.</p>
						</td>
					</tr>
					<tr id="contact"{if $_GET[from] == 'contact'} style="background-color: {$_G['style']['specialbg']};"{/if}>
						<th>{lang email}</th>
						<td>
							<input type="text" name="emailnew" id="emailnew" value="$space[email]" class="px" />
							<p class="d">
								<!--{if empty($space['newemail'])}-->
									<!--Current email address has been verified-->
								<!--{else}-->
									<!--$acitvemessage-->
								<!--{/if}-->
							</p>
							<!--{if $_G['setting']['regverify'] == 1 && (($_G['group']['grouptype'] == 'member' && $_G['adminid'] == 0) || $_G['groupid'] == 8) || $_G['member']['freeze']}--><p class="d">{lang memcp_profile_email_comment}</p><!--{/if}-->
						</td>
					</tr>
					
					<!--{if $_G['member']['freeze'] == 2}-->
					<tr>
						<th>{lang freeze_reason}</th>
						<td>
							<textarea rows="3" cols="80" name="freezereson" class="pt">$space[freezereson]</textarea>
							<p class="d" id="chk_newpassword2">{lang freeze_reason_comment}</p>
						</td>
					</tr>
					<!--{/if}-->

					<!--<tr>
						<th>{lang security_question}</th>
						<td>
							<select name="questionidnew" id="questionidnew">
								<option value="" selected>{lang memcp_profile_security_keep}</option>
								<option value="0">{lang security_question_0}</option>
								<option value="1">{lang security_question_1}</option>
								<option value="2">{lang security_question_2}</option>
								<option value="3">{lang security_question_3}</option>
								<option value="4">{lang security_question_4}</option>
								<option value="5">{lang security_question_5}</option>
								<option value="6">{lang security_question_6}</option>
								<option value="7">{lang security_question_7}</option>
							</select>
							<p class="d">{lang memcp_profile_security_comment}</p>
						</td>
					</tr>-->

					<!--<tr>
						<th>{lang security_answer}</th>
						<td>
							<input type="text" name="answernew" id="answernew" class="px" />
							<p class="d">{lang memcp_profile_security_answer_comment}</p>
						</td>
					</tr>-->					
					<!--{if $secqaacheck || $seccodecheck}-->
                    <tr>                        
						<style>
						.sec_code .vm{margin-left:0 !important}
						</style>
						<td colspan="2"><!--{subtemplate common/seccheck}--></td>
                    </tr>
					<!--{/if}-->					
					<tr>
						<td colspan="2" align="center"><button type="submit" name="pwdsubmit" value="true" class="mbutton" /><strong>Save</strong></button></td>
					</tr>
				</table>
				<input type="hidden" name="passwordsubmit" value="true" />
    </form>
    </div>
    
</div>
<!--{/if}-->
<!--{template common/footer}-->
