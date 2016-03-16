<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
	<form action="<?php echo U('edit');?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="addForm" role="form">
		<input type='hidden' id='id' name='id' value='<?php echo ($object["brandId"]); ?>' />
		<table class="table table-condensed table-hover" width="100%">
			<tbody>
				<tr>
					<td colspan="2">
					    <label class="control-label x100"><?php echo (L("brands_name")); ?><font color='red'>*</font>：</label>
					    <input type='text' id='brandName' name='brandName' class="form-control wst-ipt" value='<?php echo ($object["brandName"]); ?>' maxLength='25' />
					</td>
				</tr>
				<tr>
					<td colspan="2">
					    <label class="control-label x100"><?php echo (L("brand_cat")); ?><font color='red'>*</font>：</label> 
					    <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label> <input type='checkbox' id='cat<?php echo ($vo["catId"]); ?>' name='catIds[]' value='<?php echo ($vo["catId"]); ?>' <?php if($object['catBrands_'.$vo["catId"]]==1)echo "checked"; ?> >&nbsp;<?php echo ($vo["catName"]); ?>&nbsp;</label><?php endforeach; endif; else: echo "" ;endif; ?> 
					    <span id='catIdTips'></span>
					 </td>
				</tr>
				<tr style='height: 60px;'>
					<td colspan="2">
					    <label class="control-label x100"><?php echo (L("brand_pic")); ?>：</label>
						<div style="display: inline-block; vertical-align: middle;">
							<div id="j_custom_pic_up" data-toggle="upload"
								data-uploader="<?php echo U('upload');?>" data-file-size-limit="1024000000"
								data-file-type-exts="*.jpg;*.png;*.gif;*.mpg" data-multi="true"
								data-on-upload-success="pic_upload_success"
								data-icon="cloud-upload"></div>
							<input type="hidden" name="brandIco" value="<?php echo ($object["brandIco"]); ?>" id="j_custom_pic">
						    <span id="j_custom_span_pic"><img alt="" src="<?php echo ($object["brandIco"]); ?>" width="100"></span>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					    <label class="control-label x100"><?php echo (L("brand_desc")); ?><font color='red'>*</font>：</label>
						<div style="display: inline-block; vertical-align: middle;">
							<textarea name="brandDesc" style='width: 100%; height: 200px'
								data-toggle="kindeditor"><?php echo ($object["brandDesc"]); ?></textarea>
						</div>
				    </td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close"><?php echo (L("close")); ?></button></li>
		<!-- <li><button type="submit" class="btn-default" data-icon="save">保存</button></li> -->
		<li><button type="submit" class="btn btn-success" data-icon="save"><?php echo (L("save")); ?></button></li>
	</ul>
</div>


<!-- <script type="text/javascript" src="/Public/Js/jquery-1.9.1.js"></script> -->
<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/formValidator/formValidator-4.1.3.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script>

<script type="text/javascript">
    function pic_upload_success(file, data) {
        var json = $.parseJSON(data);
        
        $(this).bjuiajax('ajaxDone', json);
        if (json[BJUI.keys.statusCode] == BJUI.statusCode.ok) {
            $('#j_custom_pic').val(json.filename);
            $('#j_custom_span_pic').html('<img src="'+ json.filename +'" width="100" />');
        }
    }
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',
		   mode:'AutoTip',
		   formID:"addForm",
		   submitOnce:true,
		});
	   
	   $("#brandName").formValidator({onShow:"",onFocus:"品牌名称不能为空",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"你输入的长度不正确,请确认"});
	   $(":checkbox[name='catId']").formValidator({tipID:"catIdTips",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:1,max:20,onError:"请选择品牌所属的分类"});
   });
   </script>