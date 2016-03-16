<?php if (!defined('THINK_PATH')) exit();?>   <div class="bjui-pageHeader">
	<form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U($Think.ACTION_NAME);?>" method="post">
	    <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <input placeholder="<?php echo (L("shop_name")); ?>" type="text" id='shopName' name="search[shopName]" value="<?php echo ($search["shopName"]); ?>" />
        <input placeholder="<?php echo (L("shop_sn")); ?>" type="text" id='shopSn' name="search[shopSn]" value="<?php echo ($search["shopSn"]); ?>" />
		<button type="submit" class="btn-default" data-icon="search"><?php echo (L("search")); ?></button>
		<span><a class="btn btn-default" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo"><?php echo (L("refresh")); ?></a></span>
		<div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy"><?php echo (L("operation")); ?><span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a type="button" class="btn" href="<?php echo U('toEdit');?>" id="addshops" data-toggle="dialog" data-width="800" data-height="600" data-id="dialog-mask" data-mask="true"><?php echo (L("new_add")); ?></a></li>
                    </ul>
                </div>
        </div>
	</form>	    
</div>
<div class="bjui-pageContent">
	<!-- 内容区 -->
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='30'><?php echo (L("sort")); ?></th>
               <th width='80'><?php echo (L("shop_name")); ?></th>
               <!-- <th width='80'><?php echo (L("shop_sn")); ?></th> -->
               <!-- <th width='80'><?php echo (L("manager")); ?></th> -->
               <th width='200'><?php echo (L("address")); ?></th>
               <th width='120'><?php echo (L("operation")); ?></th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['info'])): $i = 0; $__LIST__ = $Page['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr >
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['shopName']); ?></td>
               <!-- <td><?php echo ($vo['shopSn']); ?>&nbsp;</td> -->
               <!-- <td><?php echo ($vo['userName']); ?>&nbsp;</td> -->
               <td><?php echo ($vo['areaId1']); echo ($vo['areaId1']); echo ($vo['shopAddress']); ?></td>
               <td>
               
               <a class="btn btn-default glyphicon glyphicon-pencil" href="<?php echo U('toEdit',array('id' => $vo['shopId']));?>" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true"><?php echo (L("edit")); ?></a>
			   <a class="btn btn-red glyphicon glyphicon-trash" data-confirm-msg="确定要删除该行信息吗？" data-toggle="doajax" href="<?php echo U('del',array('id' => $vo['shopId']));?>"><?php echo (L("delete")); ?></a>
               
               </td>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             
           </tbody>
        </table>
</div>
<div class="bjui-pageFooter">
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
</script>
   <script>
   function del(id){
	   Plugins.confirm({title:'信息提示',content:'您确定要删除该商家吗?',okText:'确定',cancelText:'取消',okFun:function(){
		   Plugins.closeWindow();
		   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
		   $.post("<?php echo U('Admin/Shops/del');?>",{id:id},function(data,textStatus){
					var json = WST.toJson(data);
					if(json.status=='1'){
						Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
							location.reload();
						}});
					}else{
						Plugins.closeWindow();
						parent.showMsg({msg:'操作失败!',status:'danger'});
					}
				});
	      }});
   }
   function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("<?php echo U('Admin/Shops/queryShowByList');?>",params,function(data,textStatus){
		    html.push('<option value=""><?php echo (L("select")); ?></option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.id+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
   }
   $(document).ready(function(){
	    <?php if(!empty($areaId1)): ?>getAreaList("areaId2",'<?php echo ($areaId1); ?>',0,'<?php echo ($areaId2); ?>');<?php endif; ?>
   });
   
   </script>