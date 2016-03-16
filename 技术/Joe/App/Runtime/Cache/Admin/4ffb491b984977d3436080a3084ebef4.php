<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
	<form action="<?php echo U(edit);?>"  method="POST" class="pageForm" data-toggle="validate" data-reload="true">
		<select name="parentId" data-toggle="selectpicker" data-rule="required">
			<option value="0">顶级分类</option>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["catId"]); ?>"><?php echo ($vo["catName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select> 
		<input placeholder="你要添加的商品分类名称" id="newName" type="text" name="catName" value="" data-rule="required" />
		<input placeholder="排序" id="catId" type="text" name="catSort" value="" data-rule="required" />
		<button type="submit" class="btn-default">确定添加</button>
		<span><a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span>
		<div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="<?php echo U('toEdit');?>" data-toggle="dialog" data-width="800" data-height="600" data-id="dialog-mask" data-mask="true">新增数据</a></li></ul>
                </div>
            </div>
	</form>
</div>

<div class="bjui-pageContent">
	<!-- 内容区 -->
	<form action="<?php echo U(edit);?>"  method="POST" class="pageForm" data-toggle="validate" data-reload="true">
	<table class="table table-bordered table-hover table-striped table-top" data-layout-h="0" data-selected-multi="true">
		<thead>
			<tr>
				<!-- <th>序号</th> -->
				<th>ID</th>
				<th>分类名称</th>
				<th>分类图标</th>
				<th>排序</th>
				<th>是否显示</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?><tr id='tr_0_<?php echo ($i); ?>' class="tr_0">
				<!-- <td><?php echo ($i); ?></td> -->
				<td><?php echo ($tree["catId"]); ?></td>
				<td><!-- <span class='glyphicon glyphicon-plus' onclick='javascript:loadChildTree(this,<?php echo ($tree["catId"]); ?>,"tr_0_<?php echo ($i); ?>")' style='margin-right: 3px; cursor: pointer'></span> --><input type="text" onchange='javascript:editName(this)' dataId='<?php echo ($tree["catId"]); ?>' value="<?php echo ($tree["catName"]); ?>" name="catName" size="20"></td>
				<td><img src='<?php echo ($tree['goodsCatImg']); ?>' height='50'/></td>
				<td><input type="text" onchange='javascript:editSort(this)' dataId='<?php echo ($tree["catId"]); ?>' value="<?php echo ($tree["catSort"]); ?>" name="catSort" size="10">
				</td>
				
				<td>
					<div class="dropdown">
						<?php if($tree['isShow']==0 ): ?><button class="btn btn-danger dropdown-toggle wst-btn-dropdown"
							id='btn_<?php echo ($tree[' catId']); ?>' type="button" data-toggle="dropdown">
							隐藏 <span class="caret"></span>
						</button>
						<?php else: ?>
						<button class="btn btn-success dropdown-toggle wst-btn-dropdown"
							id='btn_<?php echo ($tree[' catId']); ?>' type="button" data-toggle="dropdown">
							显示 <span class="caret"></span>
						</button><?php endif; ?>

						<ul class="dropdown-menu" role="menu"
							aria-labelledby="btn_<?php echo ($tree['catId']); ?>">
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="javascript:toggleIsShow(1,<?php echo ($tree['catId']); ?>)">显示</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="javascript:toggleIsShow(0,<?php echo ($tree['catId']); ?>)">隐藏</a></li>
						</ul>

					</div>
				</td>
				<td>
				<a href="<?php echo U('del?id=' . $tree[catId]);?>" class="btn btn-red glyphicon glyphicon-trash" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删除</a>
				<a href="<?php echo U('toEdit?id=' . $tree[catId]);?>" class="btn btn-default glyphicon glyphicon-pencil" data-toggle="dialog" data-width="800" data-height="600" data-id="dialog-mask" data-mask="true">编辑</a>
				<a class="btn btn-default glyphicon glyphicon-plus" data-toggle="dialog" data-width="800" data-height="600" data-id="dialog-mask" data-mask="true" href="<?php echo U('toEdit',array('parentId'=>$tree[catId]));?>" >新增子分类</a>&nbsp;
				<!-- <button data-toggle="doedit" class="btn btn-green" type="button">编辑</button> -->
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	</form>
</div>
<script type="text/javascript">
function toEdit(id,pid){
	   var url = "<?php echo U('Admin/GoodsCats/toEdit',array('id'=>'__0','parentId'=>'__1'));?>";
	   url = WST.replaceURL(url,[id,pid]);
       location.href=url;     
}
function editName(obj){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/GoodsCats/editName');?>",{id:$(obj).attr('dataId'),catName:obj.value},function(data,textStatus){
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
	   $.post("<?php echo U('Admin/GoodsCats/editSort');?>",{id:$(obj).attr('dataId'),catSort:obj.value},function(data,textStatus){
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
function toggleIsShow(t,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/GoodsCats/editIsShow');?>",{id:v,isShow:t},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
				   //location.reload();
					 $(this).navtab('refresh');  
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
	   });
}
</script>
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