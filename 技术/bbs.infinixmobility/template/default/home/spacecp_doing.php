<?php exit;?>
<!--{subtemplate common/header}-->
<script type="text/javascript">
$().ready(function(){
$(".m_txt").html("delete CC");
});
</script>
<div class="cc_doing_form">
	<form method="post" autocomplete="off" id="doingform_{$doid}_{$id}" name="doingform" action="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$id">
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="formhash" value="{FORMHASH}" class="minput" />
		<button name="deletesubmit" type="submit" class="mbutton" value="true">{lang determine}</button>
	</form>
</div>
<!--{subtemplate common/footer}-->