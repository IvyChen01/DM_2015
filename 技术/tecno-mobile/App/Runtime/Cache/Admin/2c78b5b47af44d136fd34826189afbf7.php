<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name='id' value='<?php echo ($object["catId"]); ?>'/>
            <input type='hidden' id='parentId' name='parentId' value='<?php echo ($object["parentId"]); ?>'/>
            <input type='hidden' id='addChild' name='addChild' value='true'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
               <th width='250'><?php echo (L("cat_pic")); ?></th>
               <td valign='top'>
	               <div style="display: inline-block; vertical-align: middle;">
							<div id="j_custom_pic_up" data-toggle="upload"
								data-uploader="<?php echo U('upload');?>" data-file-size-limit="1024000000"
								data-file-type-exts="*.jpg;*.png;*.gif;*.mpg" data-multi="true"
								data-on-upload-success="pic_upload_success"
								data-icon="cloud-upload"></div>
							<input type="hidden" name="goodsCatImg" value="<?php echo ($object["goodsCatImg"]); ?>" id="j_custom_pic">
						    <span id="j_custom_span_pic"><img alt="" src="<?php echo ($object["goodsCatImg"]); ?>" width="100"></span>
						</div>
	             </td>
           </tr>
           <tr>
              <th width='250'><?php echo (L("parent_level")); ?><font color='red'>*</font>：</th>
              <td>
             <select name="parentId" data-toggle="selectpicker" >
			<option value="0"><?php echo (L("top-level")); ?></option>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["catId"]); ?>" <?php if($object['parentId'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo["catName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select> 
		</td>
           </tr>
           <tr>
             <th width='250'><?php echo (L("cats_name")); ?><font color='red'>*</font>：</th>
             <td><input type='text' id='catName' name='catName' class="form-control input-sm" value='<?php echo ($object["catName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
	             <th width='250'><?php echo (L("cat_desc")); ?><font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <textarea rows="2" cols="70" data-toggle="kindeditor" id='goodsCatDesc' name='goodsCatDesc'><?php echo ($object["goodsCatDesc"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
             <th width='250' ><?php echo (L("is_show")); ?><font color='red'>*</font>：</th>
             <td><input type='radio' id='isShow1' value='1' name='isShow' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?>/><?php echo (L("show")); ?>
                    <input type='radio' id='isShow0' value='0' name='isShow' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?>/><?php echo (L("hidden")); ?>
             </td>
           </tr>
           <tr>
             <th width='250'><?php echo (L("sort")); ?>：</th>
             <td>
             <input type='text' id='catSort' name='catSort' class="form-control input-sm" value='<?php echo ($object["catSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
            <tr>
             <th width='250'><?php echo (L("lang")); ?><font color='red'>*</font>：</th>
             <td>
             <select id='adLang' name="lang">
                <option value='0' <?php if($object['lang'] == 0 ): ?>selected<?php endif; ?>>English</option>
                <option value='1' <?php if($object['lang'] == 1 ): ?>selected<?php endif; ?>>French</option>
                <option value='2' <?php if($object['lang'] == 2 ): ?>selected<?php endif; ?>>Arab</option>
             </select>
             </td>
           </tr>
</table>
        </form>
    </div>
    
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close"><?php echo (L("close")); ?></button></li>
		<!-- <li><button type="submit" class="btn-default" data-icon="save">保存</button></li> -->
		<li><button id="submit" type="submit" class="btn btn-success" data-icon="save"><?php echo (L("save")); ?></button></li>
	</ul>
</div>
<script src="/Public/Js/functions.js"></script>
<script>
function pic_upload_success(file, data) {
    var json = $.parseJSON(data);
    
    $(this).bjuiajax('ajaxDone', json);
    if (json[BJUI.keys.statusCode] == BJUI.statusCode.ok) {
        $('#j_custom_pic').val(json.filename);
        $('#j_custom_span_pic').html('<img src="'+ json.filename +'" width="100" />');
    }
}
</script>