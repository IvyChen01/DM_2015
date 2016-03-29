<?php exit;?>
<!--{template common/header}-->
<style>body { background:#FFF!important;}</style>
<link rel="stylesheet" type="text/css" href="template/webshow_mtb0115/touch/img/css/forumdisplay_list.css" media="all" />

<!--{if $tagname}-->
<div class="tag_main">
<h2 class="h2_title">
        <!--{if $tagname}-->Tag：$tagname<!--{/if}--> 
        <!--{if $showtype == 'thread'}-->{lang related_thread} <!--{/if}--> 
        <!--{if $showtype == 'blog'}--> lang related_blog} <!--{/if}--> 
        <span><a href="misc.php?mod=tag">Back</a></span>
</h2>
<!--{if empty($showtype) || $showtype == 'thread'}-->
<!--{if $threadlist}-->
<!--{eval require DISCUZ_ROOT.'template/webshow_mtb0115/touch/img/plus/plus.php';}-->
<div class="mfmlist mfmlist2">
    <ul id="alist">
    <!--{loop $threadlist $thread}-->
            <li class="li_main">
                <dl class="cl">
                    <dt class="cl">
                        <span class="cl">
                        <a href="forum.php?mod=viewthread&tid=$thread[tid]">
                        <!--{if $thread[folder] == 'lock'}-->
                            <em>Lock</em>
                        <!--{elseif $thread['special'] == 1}-->
                            <em>Poll</em>
                        <!--{elseif $thread['special'] == 2}-->
                            <em>Product</em>
                        <!--{elseif $thread['special'] == 3}-->
                            <em>Award</em>
                        <!--{elseif $thread['special'] == 4}-->
                            <em>Event</em>
                        <!--{elseif $thread['special'] == 5}-->
                            <em>Debate</em>
                        <!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                            <em>Top</em>
					    <!--{elseif $thread['digest'] > 0}-->
					        <em>Digest</em>
					    <!--{elseif $thread['attachment'] == 2 && $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
					        <em>Image </em>               
                        <!--{/if}-->
                        <i>{$thread[subject]}</i></a></span>
                        <!--{eval $piclist=threadpics($thread[tid],3);}-->
                        <!--{if $piclist}-->                                                                 
                        <ul class="cl">
                            <!--{loop $piclist $o}-->
                                <li><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"><img src="apic.php?aid=$o[aid]&size=101x101" /></a></li>
                            <!--{/loop}-->
                        </ul>
                        <!--{/if}-->
                    </dt>
                    <dd class="cl">
                        <span class="s1"><!--{if $thread['authorid'] && $thread['author']}--> {$thread[author]}<!--{else}--><!--{if $_G['forum']['ismoderator']}-->{lang anonymous}<!--{else}-->{$_G[setting][anonymoustext]}<!--{/if}--><!--{/if}--><em>$thread[dateline]</em></span>
                        <span class="s2">$thread[replies]</span>
                    </dd>
                </dl>
            </li>
    <!--{/loop}-->
    </ul>
</div>

    <!--{if empty($showtype)}-->
        <div class="tag_main_b"><a href="misc.php?mod=tag&id=$id&type=thread">{lang more}...</a></div>
    <!--{else}--> 
        <!--{if $multipage}-->
            <div>$multipage</div>
        <!--{/if}--> 
    <!--{/if}--> 
    
<!--{else}-->
    <div class="tag_main_b">{lang no_content}</div>
<!--{/if}--> 
<!--{/if}--> 
</div>

<!--{else}-->
<div class="common_tb">
    <h2 class="h2_title">
        Tag
        <span><a href="misc.php?mod=tag">Back</a></span>
    </h2>
    <div class="common_c">
        <form method="post" action="misc.php?mod=tag">
        <input type="text" name="name" placeholder="{lang tag}" />
        <button type="submit" class="mbutton">{lang search}</button>
        </form>
    </div>
    <div>{lang empty_tags}</div>
</div>
<!--{/if}--> 


<!--{template common/footer}-->