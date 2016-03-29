<?php exit;?>
<!--{template common/header}-->
<style>body { background:#FFF!important;}</style>
<!--{if $type != 'countitem'}-->
<div class="common_tb">
    <h2>Tag</h2>
    <div class="common_c">
    <form method="post" action="misc.php?mod=tag">
		<input type="text" name="name" placeholder="{lang tag}" />
        <button type="submit" class="mbutton">{lang search}</button>
    </form>
    <!--{if $tagarray}-->
        <div class="tag_list cl">
        <!--{loop $tagarray $tag}--> 
        <a href="misc.php?mod=tag&id=$tag[tagid]">$tag[tagname]</a> 
        <!--{/loop}--> 
        </div>
    <!--{else}-->
        <div class="tag_none">{lang no_tag}</div>
    <!--{/if}-->
    </div>
</div>

<!--{else}--> 
    {$num} 
<!--{/if}--> 
<!--{template common/footer}-->