<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name='id' value='<?php echo ($object["catId"]); ?>'/>
        <input type='hidden' id='parentId' name='parentId' value='<?php echo ($object["parentId"]); ?>'/>
        <input type='hidden' id='addChild' name='addChild' value='true'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'><?php echo (L("cat_name")); ?><font color='red'>*</font>：</th>
             <td><input type='text' id='catName' name="catName" class="form-control wst-ipt" value='<?php echo ($object["catName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='120' align='right'><?php echo (L("is_show")); ?><font color='red'>*</font>：</th>
             <td><input type='radio' id='isShow1' value='1' name='isShow' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?>/><?php echo (L("show")); ?>
                    <input type='radio' id='isShow0' value='0' name='isShow' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?>/><?php echo (L("hidden")); ?>
             </td>
           </tr>
           <tr>
             <th align='right'><?php echo (L("sort")); ?>:</th>
             <td>
             <input type='text' id='catSort' name='catSort' class="form-control input-sm" value='<?php echo ($object["catSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
           <tr>
             <th align='right'><?php echo (L("lang")); ?>:</th>
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