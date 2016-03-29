<?php exit;?>
<!--{eval dheader('Location:touch_index.php');exit;}-->
<!--{if $_G['setting']['mobile']['mobilehotthread'] && $_GET['forumlist'] != 1}-->
	<!--{eval dheader('Location:forum.php?mod=guide&view=hot');exit;}-->
<!--{/if}-->
<!--{template common/header}-->
<link rel="stylesheet" href="template/webshow_mtb0115/touch/img/css/discuz.css?{VERHASH}" type="text/css">
<script type="text/javascript">
	function getvisitclienthref() {
		var visitclienthref = '';
		if(ios) {
			visitclienthref = 'https://itunes.apple.com/cn/app/zhang-shang-lun-tan/id489399408?mt=8';
		} else if(andriod) {
			visitclienthref = 'http://www.discuz.net/mobile.php?platform=android';
		}
		return visitclienthref;
	}
</script>

<!--{if $_GET['visitclient']}-->
<header class="header">
    <div class="nav">
		<span>{lang warmtip}</span>
    </div>
</header>
<div class="cl">
	<div class="clew_con">
		<h2 class="tit">{lang zsltmobileclient}</h2>
		<p>{lang visitbbsanytime}<input class="redirect button" id="visitclientid" type="button" value="{lang clicktodownload}" href="" /></p>
		<h2 class="tit">{lang iphoneandriodmobile}</h2>
		<p>{lang visitwapmobile}<input class="redirect button" type="button" value="{lang clicktovisitwapmobile}" href="$_GET[visitclient]" /></p>
	</div>
</div>
<script type="text/javascript">
	var visitclienthref = getvisitclienthref();
	if(visitclienthref) {
		$('#visitclientid').attr('href', visitclienthref);
	} else {
		window.location.href = '$_GET[visitclient]';
	}
</script>

<!--{else}-->

<!--{if $showvisitclient}-->
<div class="visitclienttip vm" style="display:block;">
	<a href="javascript:;" id="visitclientid" class="btn_download">{lang downloadnow}</a>	
	<p>
		{lang downloadzslttoshareview}
	</p>
</div>
<script type="text/javascript">
	var visitclienthref = getvisitclienthref();
	if(visitclienthref) {
		$('#visitclientid').attr('href', visitclienthref);
		$('.visitclienttip').css('display', 'block');
	}
</script>
<!--{/if}-->
<!--null_106-->
<!--{hook/index_top_mobile}-->

<!--{if $forum_favlist}-->
<div class="mdiscuz_fav">
    <h2>My favorite</h2>
    <ul class="cl">
    <!--{eval $favorderid = 0;}-->
    <!--{loop $forum_favlist $key $favorite}-->
    <!--{if $favforumlist[$favorite[id]]}-->
    <!--{eval $forum=$favforumlist[$favorite[id]];}-->
    <!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
    <li><a href="$forumurl"><span>$forum[name] {if $forum[todayposts]}<em>($forum[todayposts])</em>{/if}</span></a></li>
    <!--{/if}-->
    <!--{/loop}-->
    </ul>
</div>
<!--{/if}-->

<div id="m_forum">
	<!--{loop $catlist $key $cat}-->
	<div class="mforum_list">
		<div class="mforum_bh cl" href="#sub_forum_$cat[fid]">
			<span class="o"><img src="template/webshow_mtb0115/touch/img/collapsed_<!--{if !$_G[setting][mobile][mobileforumview]}-->yes<!--{else}-->no<!--{/if}-->.png"></span>
		    <a href="javascript:;">$cat[name]</a>
		</div>
		<div id="sub_forum_$cat[fid]" class="mforum_main">
			<ul>
				<!--{loop $cat[forums] $forumid}-->
				<!--{eval $forum=$forumlist[$forumid];}-->
				<li class="cl">
                    <dl{if $forum[todayposts] > 0} style="background-image:none;"{/if}>
                        <dt>
                            <!--{if $forum[icon]}-->
                                {$forum[icon]}
                            <!--{else}-->
                                <!--{eval $i >= 11 ? $i = 1 : $i++;}-->
                                <img src="template/webshow_mtb0115/touch/img/ficon/{$i}.png" />
                            <!--{/if}-->
                        </dt>
                        <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}" class="mforum_main_link">
                        <dd class="dd1">{$forum[name]}</dd>
                        <dd class="dd2">{$forum[description]}</dd>
                        <!--{if $forum[todayposts] > 0}--><span class="s3">$forum[todayposts]</span><!--{/if}-->
                        </a>
                    </dl>
                    
                </li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/loop}-->
</div>

<!--{hook/index_middle_mobile}-->
<script type="text/javascript">
	(function() {
		<!--{if !$_G[setting][mobile][mobileforumview]}-->
			$('.mforum_main').css('display', 'block');
		<!--{else}-->
			$('.mforum_main').css('display', 'none');
		<!--{/if}-->
		$('.mforum_bh').on('click', function() {
			var obj = $(this);
			var subobj = $(obj.attr('href'));
			if(subobj.css('display') == 'none') {
				subobj.css('display', 'block');
				obj.find('img').attr('src', 'template/webshow_mtb0115/touch/img/collapsed_yes.png');
			} else {
				subobj.css('display', 'none');
				obj.find('img').attr('src', 'template/webshow_mtb0115/touch/img/collapsed_no.png');
			}
		});
	 })();
</script>

<!--{/if}-->
<!--{template common/footer}-->
