<?php exit;?>
<!--{template common/header}-->
<style>body, #mwp, #mcontent { background:#FFF!important;}</style>
<script type="text/javascript">
$().ready(function(){
//$(".m_txt").html("{if $_GET['type'] == 'forum'}block favorite{else}thread favorite{/if}");
$(".m_txt").text('Subscribed Threads')
});
</script>

<!--{if $_GET['type'] == 'forum'}-->
<div class="mv_post_nav cl">
    <!--<a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">{lang favthread}</a>
    <a href="javascript:void(0);" class="current">{lang favforum}</a>-->   
</div>
<div class="coll_list b_radius">
	<ul>
		<!--{if $list}-->
			<!--{loop $list $k $value}-->
			<li>
            <a href="$value[url]">$value[title]</a>
            <a href="home.php?mod=spacecp&ac=favorite&op=delete&favid={$value[favid]}" class="fav_d">Delete</a>
            </li>
			<!--{/loop}-->
		<!--{else}-->
		<li>{lang no_favorite_yet}</li>
		<!--{/if}-->
	</ul>
</div>
<!--{else}-->
<div class="mv_post_nav cl">
    <!--<a href="javascript:void(0);" class="current">{lang favthread}</a>
    <a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=forum">{lang favforum}</a>-->
</div>
<div class="fav_t_list">
	<ul>
		<!--{if $list}-->
			<!--{loop $list $k $value}-->
			<li>
            <a href="$value[url]">$value[title]</a>
            <a href="home.php?mod=spacecp&ac=favorite&op=delete&favid={$value[favid]}" class="fav_d">Delete</a>
            </li>
			<!--{/loop}-->
		<!--{else}-->
		<li>{lang no_favorite_yet}</li>
		<!--{/if}-->
	</ul>
</div>
<!--{/if}-->

<div class="cl">{$multi}</div>

<!--{template common/footer}-->
