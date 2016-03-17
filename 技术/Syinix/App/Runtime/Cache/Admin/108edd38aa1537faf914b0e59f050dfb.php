<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
	<form action="<?php echo U(edit);?>"  method="POST" class="pageForm" data-toggle="validate" data-reload="true">
		<input type="hidden" name="act" value="add" />
		<select name="parentId" data-toggle="selectpicker" data-rule="required">
			<option value="">请选择分类</option>
			<option value="0">顶级分类</option>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["catId"]); ?>"><?php echo ($vo["catName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select> 
		<input placeholder="你要添加的栏目名称" id="newName" type="text" name="catName" value="" data-rule="required" />
		<input placeholder="排序" id="catId" type="text" name="catSort" value="" data-rule="required" />
		<button type="submit" class="btn-default">确定添加</button>
		<span><a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span>
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
	<!-- 内容区 -->
	<form action="<?php echo U(edit);?>"  method="POST" class="pageForm" data-toggle="validate" data-reload="true">
	<table class="table table-bordered table-hover table-striped table-top" data-layout-h="0" data-selected-multi="true">
		<thead>
			<tr>
				<!-- <th>序号</th> -->
				<th>ID</th>
				<th>分类名称</th>
				<th>排序</th>
				<th>是否显示</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?><tr id='tr_0_<?php echo ($i); ?>' class="tr_0">
				<!-- <td><?php echo ($i); ?></td> -->
				<td><?php echo ($tree["catId"]); ?></td>
				<td><input type="text" onchange='javascript:editName(this)' dataId='<?php echo ($tree["catId"]); ?>' value="<?php echo ($tree["catName"]); ?>" name="catName" maxLength='50'></td>
				
				<td><input type="text" onchange='javascript:editSort(this)' dataId='<?php echo ($tree["catId"]); ?>' value="<?php echo ($tree["catSort"]); ?>" name="catSort" maxLength='50'></td>
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
				<a href="<?php echo U('toEdit?id=' . $tree[catId]);?>" class="btn btn-default glyphicon glyphicon-pencil" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true">编辑</a>
				<a class="btn btn-default glyphicon glyphicon-plus" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true" href="<?php echo U('toEdit',array('parentId'=>$tree[catId]));?>" >新增子分类</a>&nbsp;
				<!-- <button data-toggle="doedit" class="btn btn-green" type="button">编辑</button> -->
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	</form>
</div>
<script type="text/javascript">
function editName(obj){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/ArticleCats/editName');?>",{id:$(obj).attr('dataId'),catName:obj.value},function(data,textStatus){
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
	   $.post("<?php echo U('Admin/ArticleCats/editSort');?>",{id:$(obj).attr('dataId'),catSort:obj.value},function(data,textStatus){
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
	   $.post("<?php echo U('Admin/ArticleCats/editiIsShow');?>",{id:v,isShow:t},function(data,textStatus){
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