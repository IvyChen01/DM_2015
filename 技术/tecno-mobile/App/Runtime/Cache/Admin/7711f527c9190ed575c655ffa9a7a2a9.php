<?php if (!defined('THINK_PATH')) exit();?> <div class="bjui-pageHeader">
	<form action="<?php echo U(edit);?>"  method="POST" class="pageForm" data-toggle="validate" data-reload="true">
		<select name="parentId" data-toggle="selectpicker" data-rule="required">
			<option value="0"><?php echo (L("country")); ?></option>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["areaId"]); ?>"><?php echo ($vo["areaName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select> 
		<input placeholder="<?php echo (L("new_area")); ?>" id="areaName" type="text" name="areaName" value="" data-rule="required" />
		<input placeholder="<?php echo (L("sort2")); ?>" id="areaSort" type="text" name="areaSort" value="" />
		<select id='adLang' name="lang">
                          <option value='0' >English</option>
                          <option value='1' >French</option>
                          <option value='2' >Arab</option>
                       </select>
		<button type="submit" class="btn-default"><?php echo (L("submit")); ?></button>
		<span><a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo"><?php echo (L("refresh")); ?></a></span>
		<!-- <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="<?php echo U('toEdit');?>" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true">新增数据</a></li></ul>
                </div>
            </div> -->
	</form>
</div>
<div class="bjui-pageContent">
   
      <!--  <input type='hidden' id='parentId' value='<?php echo ($pArea[areaId]); ?>'/> -->
      <!--  <div class='wst-tbar' style='height:25px;'>
       <?php if($pArea['areaId'] !=0 ): ?>上级地区：<?php echo ($pArea['areaName']); endif; ?>
       <?php if($pArea['areaId'] !=0 ): ?><a class="btn glyphicon btn-success" href="<?php echo U('Admin/Areas/index',array('parentId'=>$pArea['parentId']));?>" style='float:right;margin-left:5px;'>返回</a><?php endif; ?>
       
       <a class="btn btn-success glyphicon glyphicon-plus" href="<?php echo U('Admin/Areas/toEdit',array('parentId'=>$pArea['areaId']));?>" style='float:right'>新增</a>
       
       </div> -->
       
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='100'><?php echo (L("sort")); ?></th>
               <th><?php echo (L("area")); ?></th>
               <th width='80'><?php echo (L("is_show")); ?></th>
               <th width='80'><?php echo (L("sort2")); ?></th>
               <th width='300'><?php echo (L("operation")); ?></th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['areaName']); ?></td>
               <td>
               <div class="dropdown">
               <?php if($vo['isShow']==0 ): ?><button class="btn btn-danger dropdown-toggle wst-btn-dropdown"  type="button" data-toggle="dropdown">
					    <?php echo (L("hidden")); ?>
					  <span class="caret"></span>
				   </button>
               <?php else: ?>
                   <button class="btn btn-success dropdown-toggle wst-btn-dropdown" type="button" data-toggle="dropdown">
					      <?php echo (L("show")); ?>
					  <span class="caret"></span>
				   </button><?php endif; ?>
                   <ul class="dropdown-menu" role="menu">
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:toggleIsShow(1,<?php echo ($vo['areaId']); ?>)"><?php echo (L("show")); ?></a></li>
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:toggleIsShow(0,<?php echo ($vo['areaId']); ?>)"><?php echo (L("hidden")); ?></a></li>
				   </ul>
               </div>
               </td>
               <td><input type="text" onchange='javascript:editSort(this)' dataId='<?php echo ($vo["areaId"]); ?>' value="<?php echo ($vo['areaSort']); ?>" name="catSort" maxLength='50'></td>
               <td>
               <a href="<?php echo U('del?id=' . $vo[areaId]);?>" class="btn btn-red glyphicon glyphicon-trash" data-toggle="doajax" data-confirm-msg="<?php echo (L("delete_confirm")); ?>"><?php echo (L("delete")); ?></a>
				<a href="<?php echo U('toEdit?id=' . $vo[areaId]);?>" class="btn btn-default glyphicon glyphicon-pencil" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true"><?php echo (L("edit")); ?></a>
				<a class="btn btn-default glyphicon glyphicon-plus" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true" href="<?php echo U('toEdit',array('parentId'=>$vo[areaId]));?>" ><?php echo (L("add_child")); ?></a>&nbsp;
               
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
           </tbody>
        </table>
       </div>
       <!-- <div class="bjui-pageFooter">
    <div class="pages">
        <span>每页</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="20" <?php if($_SESSION['pageSize']== 20): ?>selected="selected"<?php endif; ?>>20</option>
                <option value="40" <?php if($_SESSION['pageSize']== 40): ?>selected="selected"<?php endif; ?>>40</option>
                <option value="60" <?php if($_SESSION['pageSize']== 60): ?>selected="selected"<?php endif; ?>>60</option>
                <option value="120" <?php if($_SESSION['pageSize']== 120): ?>selected="selected"<?php endif; ?>>120</option>
                <option value="150" <?php if($_SESSION['pageSize']== 150): ?>selected="selected"<?php endif; ?>>150</option>
            </select>
        </div>
        <span>条，共 <?php echo ($total); ?> 条</span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($total); ?>" data-page-size="<?php echo (session('pageSize')); ?>" data-page-current="<?php echo (session('pageCurrent')); ?>">
    </div>
</div>

<script>
    /* zxc优化开始 */

    // 解决多个列表间的字段排序冲突问题
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='orderField']").val("");
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='orderDirection']").val("");

    // 解决多个列表间的分页大小冲突问题
    var selectedPagesize = $(".page.unitBox.fade.in > .bjui-pageFooter > .pages > .selectPagesize > select").val();
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='pageSize']").val(selectedPagesize);
    $(".page.unitBox.fade.in > .bjui-pageFooter > .pagination-box").attr('data-page-size',selectedPagesize);

    //console.log("pageSize" + $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='pageSize']").val());
    //console.log("selectedPagesize:" + selectedPagesize);
    //console.log("data-page-size:" + $(".page.unitBox.fade.in > .bjui-pageFooter > .pagination-box").attr('data-page-size'));

    /* zxc优化结束 */
</script> -->
  <script>
   function toggleIsShow(t,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Areas/editiIsShow');?>",{id:v,isShow:t},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
					$(this).navtab('refresh');  
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
	   });
   }
   function editName(obj){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   alert(obj.value);
	   $.post("<?php echo U('Admin/Areas/editName');?>",{id:$(obj).attr('dataId'),areaName:obj.value},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000});
				$(this).navtab('refresh');  
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
}
   function editSort(obj){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Areas/editSort');?>",{id:$(obj).attr('dataId'),areaSort:obj.value},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000});
				$(this).navtab('refresh');  
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
}
   </script>