<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name='id' value='<?php echo ($object["catId"]); ?>'/>
            <input type='hidden' id='parentId' name='parentId' value='<?php echo ($object["parentId"]); ?>'/>
			<input type='hidden' id='addChild' name='addChild' value='true'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
               <th width='120' align='right'>分类图片<font color='red'>*</font>：</th>
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
              <th width='120' align='right'>上级分类</th>
              <td>
             <select name="parentId" data-toggle="selectpicker">
			<option value="0">顶级分类</option>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["catId"]); ?>" <?php if($object['parentId'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo["catName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select> 
		</td>
           </tr>
           <tr>
             <th width='120' align='right'>分类名称<font color='red'>*</font>：</th>
             <td><input type='text' id='catName' name='catName' class="form-control input-sm" value='<?php echo ($object["catName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
	             <th width='120'>分类描述</th>
	             <td colspan='3'>
	             <textarea rows="2" cols="70" data-toggle="kindeditor" id='goodsCatDesc' name='goodsCatDesc'><?php echo ($object["goodsCatDesc"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
             <th width='120' align='right'>是否显示</th>
             <td><input type='radio' id='isShow1' value='1' name='isShow' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?>/>显示
                    <input type='radio' id='isShow0' value='0' name='isShow' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?>/>隐藏
             </td>
           </tr>
           <tr>
             <th align='right'>排序：</th>
             <td>
             <input type='text' id='catSort' name='catSort' class="form-control input-sm" value='<?php echo ($object["catSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
</table>
        </form>
    </div>
    
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<!-- <li><button type="submit" class="btn-default" data-icon="save">保存</button></li> -->
		<li><button id="submit" type="submit" class="btn btn-success" data-icon="save">保&nbsp;存</button></li>
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