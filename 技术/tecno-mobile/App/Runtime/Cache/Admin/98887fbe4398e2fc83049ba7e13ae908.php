<?php if (!defined('THINK_PATH')) exit();?>   <script>
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#areaName").formValidator({onShow:"",onFocus:"地区名称至少要输入1个字符",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"你输入的长度不正确,请确认"});
	   
   });
   function edit(){
	   var params = {};
	   params.id = $('#id').val();
	   params.areaName = $('#areaName').val();
	   params.parentId = $('#parentId').val();
	   params.isShow = $("input[name='isShow']:checked").val();
	   params.areaSort = $('#areaSort').val();
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
	   $.post("<?php echo U('Admin/Areas/edit');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
				   location.href='<?php echo U("Admin/Areas/index",array("parentId"=>$object["parentId"]));?>';
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
   }
   </script>
   <div class="bjui-pageContent">
       <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name="id" value='<?php echo ($object["areaId"]); ?>'/>
        <input type='hidden' id='parentId' name="parentId" value='<?php echo ($object["parentId"]); ?>'/>
        <input type='hidden' id='addChild' name='addChild' value='true'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'><?php echo (L("area")); ?><font color='red'>*</font>：</th>
             <td><input type='text' id='areaName' name="areaName" class="form-control wst-ipt" value='<?php echo ($object["areaName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th align='right'><?php echo (L("is_show")); ?><font color='red'>*</font>：</th>
             <td>
             <label>
             <input type='radio' id='isShow1' name='isShow' value='1' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?> /><?php echo (L("show")); ?>
             </label>
             <label>
             <input type='radio' id='isShow0' name='isShow' value='0' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?> /><?php echo (L("hidden")); ?>
             </label>
             </td>
           </tr>
           <tr>
             <th align='right'><?php echo (L("sort2")); ?><font color='red'>*</font>：</th>
             <td>
             <input type='text' id='areaSort' name="areaSort" class="form-control wst-ipt" value='<?php echo ($object["areaSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
        </table>
       </form>
       </div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close"><?php echo (L("close")); ?></button></li>
		<li><button id="submit" type="submit" class="btn btn-success" data-icon="save"><?php echo (L("save")); ?></button></li>
	</ul>
</div>
<script src="/Public/Js/functions.js"></script>