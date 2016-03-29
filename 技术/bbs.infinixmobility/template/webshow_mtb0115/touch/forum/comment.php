<?php exit;?>
<!--{template common/header}-->
<script type="text/javascript">
$().ready(function(){
$(".m_txt").html("Thread comment");
});
</script>

<form method="post" autocomplete="off" id="commentform" action="forum.php?mod=post&action=reply&comment=yes&tid=$post[tid]&pid=$_GET[pid]&extra=$extra{if !empty($_GET[page])}&page=$_GET[page]{/if}&commentsubmit=yes&infloat=yes" onsubmit="{if !empty($_GET['infloat'])}ajaxpost('commentform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;{/if}">
<div class="mv_post_dp">
    <h2>Comment: {$_G[forum_thread][subject]}</h2>
    <div class="mv_post_c">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="handlekey" value="$_GET['handlekey']" />
    <textarea name="message" id="commentmessage" onKeyUp="strLenCalc(this, 'checklen')" onKeyDown="seditor_ctlent(event, '$(\'commentsubmit\').click();')" tabindex="2" style="overflow: auto"></textarea>
    <div id="seccheck_comment">
    <!--{if $secqaacheck || $seccodecheck}-->
    <!--{subtemplate common/seccheck}-->
    <!--{/if}-->
    </div>
    <button type="submit" id="commentsubmit" class="mbutton" style="margin-top:5px;" value="true" name="commentsubmit" tabindex="3"{if !$seccodecheck} onmouseover="checkpostrule('seccheck_comment', 'ac=reply&infloat=yes&handlekey=$_GET[handlekey]');this.onmouseover=null"{/if}><span>{lang publish}</span></button>
    </div>
</div>
</form>
<!--{template common/footer}-->