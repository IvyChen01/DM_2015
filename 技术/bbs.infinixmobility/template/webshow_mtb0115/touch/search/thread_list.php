<?php exit;?>
<style>.cc_search .h2_title span { position:relative; left:1px!important; top:auto!important;}</style>
<div class="cc_main mfmlist mfmlist2 cc_search" style="background:none;">
	<h2 class="h2_title h2_title_t"><!--{if $keyword}-->{lang search_result_keyword} <!--{if $modfid}--><a href="forum.php?mod=modcp&action=thread&fid=$modfid&keywords=$modkeyword&submit=true&do=search&page=$page" target="_blank">{lang goto_memcp}</a><!--{/if}--><!--{else}-->{lang search_result}<!--{/if}--></h2>
    
    <ul id="alist">
	<!--{if empty($threadlist)}-->
	<!--<li class="note_none"><a href="javascript:;">{lang search_nomatch}</a></li>-->
	<!--{else}-->
        <!--{loop $threadlist $thread}-->
    
            <li class="li_main">
                <dl class="cl">
				<a class="search-thread-link" href="forum.php?mod=viewthread&tid=$thread[realtid]&highlight=$index[keywords]" $thread[highlight]>
                    <dt>
                        <span class="cl">                        
                        <!--{if $thread[folder] == 'lock'}-->
                             <!--<em>null_60</em>-->
                        <!--{elseif $thread['special'] == 1}-->
                             <!--<em>null_61</em>-->
                        <!--{elseif $thread['special'] == 2}-->
                            <!--<em>null_62</em>-->
                        <!--{elseif $thread['special'] == 3}-->
                             <!--<em>null_63</em>-->
                        <!--{elseif $thread['special'] == 4}-->
                             <!--<em>null_64</em>-->
                        <!--{elseif $thread['special'] == 5}-->
                             <!--<em>null_65</em>-->
                        <!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                            <em class="em1">Top</em>
					    <!--{elseif $thread['digest'] > 0}-->
					        <em class="em1">Recommend</em>
					    <!--{elseif $thread['attachment'] == 2 && $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
					       <!-- <em class="em1">Image</em>-->
                        <!--{/if}-->
                        <i class="sh-th-t">$thread[subject]</i>
                        </span>
                    </dt>
                    <dd class="cl">
                        <span class="s1"><!--{if $thread['authorid'] && $thread['author']}--> {$thread[author]}<!--{else}--><!--{if $_G['forum']['ismoderator']}-->{lang anonymous}<!--{else}-->{$_G[setting][anonymoustext]}<!--{/if}--><!--{/if}--><em class="sh-th-d">$thread[dateline]</em></span>
                        <span class="s2">$thread[replies]</span>
                    </dd>
					</a>
                </dl>
            </li>
        <!--{/loop}-->
	<!--{/if}-->
	$multipage
</div>
