<?php exit;?>
<!--{subtemplate common/header}-->
<style>#mwp, #mcontent { background:#FFF!important;}</style>
<script type="text/javascript">
$().ready(function(){
$(".m_txt").html("CC");
});
</script>
<div class="cc_main cc_doing"> 

    <h2 class="h2_title">CC</h2>
    <!--{if helper_access::check_module('doing')}-->
        <!--{subtemplate home/space_doing_form}-->
    <!--{/if}-->
    
    <div class="mv_post_nav cl">
        <a href="home.php?mod=space&do=$do&view=we"{if $actives[we]} class="current"{/if}>All</a>
        <a href="home.php?mod=space&do=$do&view=me"{if $actives[me]} class="current"{/if}>{lang doing_view_me}</a>
        <a href="home.php?mod=space&do=$do&view=all"{if $actives[all]} class="current"{/if}>{lang view_all}</a>
    </div>
    
    <!--{if $dolist}--> 
        <ul class="doing_list">
			<!--{loop $dolist $dv}-->
			<!--{eval $doid = $dv[doid];}-->
			<!--{eval $_GET[key] = $key = random(8);}-->
				<li>
                    <dl class="cl">
                    <dt><a href="home.php?mod=space&uid=$dv[uid]"><!--{avatar($dv[uid],small)}--></a></dt>
                    <dd class="dd1">
                        <!--{if empty($diymode)}--><a href="home.php?mod=space&uid=$dv[uid]">$dv[username]</a><!--{/if}-->
                        <span class="s2"><!--{date($dv['dateline'], 'u')}--></span>
					     <!--{eval $list = $clist[$doid];}-->											
                         <!--{if $dv[uid]==$_G[uid]}-->
                         <span class="s3"><a href="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$dv[id]&handlekey=doinghk_{$doid}_$dv[id]" class="DZKnSVA4Pv">({lang delete})</a></span>
                         <!--{/if}-->   
                    </dd>
                    <dd class="dd2">$dv[message]</dd>
                    </dl>              
				</li>
			<!--{/loop}-->
        </ul>
		<!--{if $multi}--><div class="cl">$multi</div><!--{/if}-->
    <!--{else}-->
			<div class="note_none">{lang doing_no_replay}<!--{if $space[self]}-->{lang doing_now}<!--{/if}--></div>
	<!--{/if}-->
</div>
<!--{subtemplate common/footer}-->