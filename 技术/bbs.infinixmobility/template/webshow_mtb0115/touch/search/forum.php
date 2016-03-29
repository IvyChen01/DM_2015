<?php exit;?>
<!--{template common/header}-->
<link rel="stylesheet" type="text/css" href="template/webshow_mtb0115/touch/img/css/forumdisplay_list.css" media="all" />

<style>
.btool .li2.current2 { background-position: center 0!important;}
.btool .li2.current2 a { color:#8A98AA!important;}
.btool .li4.current4 { background-position: center -80px!important;}
.btool .li4.current4 a { color:#1A8FF2!important;}
</style>

<form id="searchform" class="searchform" method="post" autocomplete="off" action="search.php?mod=forum&mobile=2">
			<input type="hidden" name="formhash" value="{FORMHASH}" />

			<!--{subtemplate search/pubsearch}-->
			<!--{eval $policymsgs = $p = '';}-->
			<!--{loop $_G['setting']['creditspolicy']['search'] $id $policy}-->
			<!--{block policymsg}--><!--{if $_G['setting']['extcredits'][$id][img]}-->$_G['setting']['extcredits'][$id][img] <!--{/if}-->$_G['setting']['extcredits'][$id][title] $policy $_G['setting']['extcredits'][$id][unit]<!--{/block}-->
			<!--{eval $policymsgs .= $p.$policymsg;$p = ', ';}-->
			<!--{/loop}-->
			<!--{if $policymsgs}--><p>{lang search_credit_msg}</p><!--{/if}-->
</form>

<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{subtemplate search/thread_list}-->
<!--{/if}-->
<!--{template common/footer}-->
