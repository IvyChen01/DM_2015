<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array('{lang pm}');}-->
<!--{template common/header}-->
<style>
/*current page*/
.btool .li5.current5 { background-position: center 0!important;}
.btool .li5.current5 a { color:#8A98AA!important;}
.btool .li3.current3 { background-position: center -80px!important;}
.btool .li3.current3 a { color:#1A8FF2!important;}
.pmbox { margin:10px; background:#FFF; border:1px solid #DDD; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);}
    .pmbox .avatar_img img { width:36px; height:36px; border:0; padding:0px; margin:0px; border-radius:18px;}
	.pmbox li { height:auto;}
	.pmbox li span em { color:#FF5500;}
</style>

<!--{if in_array($filter, array('privatepm')) || in_array($_GET[subop], array('view'))}-->
	<!--{if in_array($filter, array('privatepm'))}-->
    <script type="text/javascript">
	    $().ready(function(){
		$(".m_txt").html("Message");
		});
    </script>
	<div class="pmbox">
		<ul>
        <!--{if $list}-->
			<!--{loop $list $key $value}-->
			<li>
			<div class="avatar_img"><img style="height:32px;width:32px;" src="<!--{if $value[pmtype] == 2}-->{STATICURL}image/common/grouppm.png<!--{else}--><!--{avatar($value[touid] ? $value[touid] : ($value[lastauthorid] ? $value[lastauthorid] : $value[authorid]), small, true)}--><!--{/if}-->" /></div>
				<a href="{if $value[touid]}home.php?mod=space&do=pm&subop=view&touid=$value[touid]{else}home.php?mod=space&do=pm&subop=view&plid={$value['plid']}&type=1{/if}">
					<div class="cl">
						<!--{if $value[new]}--><span class="num">$value[pmnum]</span><!--{/if}-->
						<!--{if $value[touid]}-->
							<!--{if $value[msgfromid] == $_G[uid]}-->
								<span class="name">{lang me} {lang you_to} {$value[tousername]} :</span>
							<!--{else}-->
								<span class="name"><em>{$value[tousername]}</em> {lang you_to} {lang me} :</span>
							<!--{/if}-->
						<!--{elseif $value['pmtype'] == 2}-->
							<span class="name">{lang chatpm_author}:$value['firstauthor']</span>
						<!--{/if}-->
					</div>
					<div class="cl grey">
						<span class="time"><!--{date($value[dateline], 'u')}--></span>
						<span><!--{if $value['pmtype'] == 2}-->[{lang chatpm}]<!--{if $value[subject]}-->$value[subject]<br><!--{/if}--><!--{/if}--><!--{if $value['pmtype'] == 2 && $value['lastauthor']}--><div style="padding:0 0 0 20px;">......<br>$value['lastauthor'] : $value[message]</div><!--{else}-->$value[message]<!--{/if}--></span>
					</div>
				</a>
			</li>
			<!--{/loop}-->
        <!--{else}-->
            <div class="note_none">Empty</div>
        <!--{/if}-->
		</ul>
	</div>
	<!-- main pmlist end -->

	<!--{elseif in_array($_GET[subop], array('view'))}-->
    <script type="text/javascript">
	    $().ready(function(){
		$(".m_txt").html("Check message");
		});
    </script>

	<!-- main viewmsg_box start -->
	<div class="wp">
		<div class="msgbox b_m">
			<!--{if !$list}-->
				{lang no_corresponding_pm}
			<!--{else}-->
				<!--{loop $list $key $value}-->
					<!--{subtemplate home/space_pm_node}-->
				<!--{/loop}-->
				$multi
			<!--{/if}-->
		</div>
		<!--{if $list}-->
            <form id="pmform" class="pmform" name="pmform" method="post" action="home.php?mod=spacecp&ac=pm&op=send&pmid=$pmid&daterange=$daterange&pmsubmit=yes&mobile=2" >
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<!--{if !$touid}-->
			<input type="hidden" name="plid" value="$plid" />
			<!--{else}-->
			<input type="hidden" name="touid" value="$touid" />
			<!--{/if}-->
			<div class="reply b_m"><input type="text" value="" class="px" autocomplete="off" id="replymessage" name="message"></div>
			<div class="reply b_m"><input type="button" name="pmsubmit" id="pmsubmit" class="formdialog button2" value="{lang reply}" /></div>
            </form>

		<!--{/if}-->
	</div>
	<!-- main viewmsg_box end -->

	<!--{/if}-->

<!--{else}-->
	<div class="bm_c">
		{lang user_mobile_pm_error}
	</div>
<!--{/if}-->

<!--{template common/footer}-->
