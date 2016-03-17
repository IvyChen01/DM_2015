<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name='id' value='<?php echo ($object["catId"]); ?>'/>
        <input type='hidden' id='parentId' name='parentId' value='<?php echo ($object["parentId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'>分类名称<font color='red'>*</font>：</th>
             <td><input type='text' id='catName' name="catName" class="form-control wst-ipt" value='<?php echo ($object["catName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='120' align='right'>是否显示<font color='red'>*</font>：</th>
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
   <!--  <div class="modal-body">
        <form id="addForm" class="form-horizontal required-validate" role="form" action="<?php echo U('edit');?>" data-toggle="validate" data-reload-navtab="true">
            <input type='hidden' id='id' name='id' value='<?php echo ($object["catId"]); ?>'/>
            <input type='hidden' id='parentId' name='parentId' value='<?php echo ($object["parentId"]); ?>'/>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label" >分类名称<font color='red'>*</font>：</label>
                <div class="col-sm-4">
                    <input type='text' id='catName' name='catName' class="form-control input-sm" value='<?php echo ($object["catName"]); ?>' maxLength='25'/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label" >是否显示<font color='red'>*</font>：</label>
                <div class="col-sm-4">
                    <input type='radio' id='isShow1' value='1' name='isShow' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?>/>显示
                    <input type='radio' id='isShow0' value='0' name='isShow' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?>/>隐藏
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">排序号：</label>
                <div class="col-sm-4">
                    <input type='text' id='catSort' name='catSort' class="form-control input-sm" value='<?php echo ($object["catSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
                </div>
            </div>
                <label for="inputField" class="col-sm-2 control-label">所属用户组</label>
                <div class="col-sm-4">
                    <select name="info[role_id]" class="form-control input-sm"><?php echo ($info["roleOption"]); ?></select>
                </div>
    </div> -->
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