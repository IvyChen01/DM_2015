<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <!-- 内容区 -->
    <form action="<?php echo U($Think.ACTION_NAME);?>" method="POST" class="pageForm" data-toggle="validate" data-reload="true">
    <input type="hidden" name="data[cid]" value="<?php echo ($tree["cid"]); ?>" />
    <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
    <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
    <table class="table table-bordered table-hover table-striped table-top" data-layout-h="0" data-selected-multi="true">
        <thead>
            <tr>
                <th>id</th>
                <th><?php echo (L("cat_structure")); ?></th>
                <th><?php echo (L("new_cat")); ?></th>
                <th><?php echo (L("sort")); ?></th>
                <th><?php echo (L("menu")); ?></th>
                <th><?php echo (L("operation")); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($tree["id"]); ?></td>
                        <td>
                            <?php if($tree["fid"] == 0): ?><b><?php echo ($tree["fullname"]); ?></b>
                                <?php else: echo ($tree["fullname"]); endif; ?>
                            <?php if($tree["status"] == 0): ?>[
                                <font color="red">禁</font>]<?php endif; ?>
                        </td>
                        <td>
                            <select name="data[fid]" data-toggle="selectpicker" dataId='<?php echo ($tree["id"]); ?>' onchange='javascript:editPid(this)'>
                                <option value="0"><?php echo (L("top")); ?></option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i; if($vo1['id'] == $tree['id']): ?><option value="<?php echo ($vo1["id"]); ?>" selected="selected" readonly><?php echo ($vo1["fullname"]); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($vo1["id"]); ?>"><?php echo ($vo1["fullname"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="<?php echo ($tree["oid"]); ?>" onchange='javascript:editSort(this)' dataId='<?php echo ($tree["id"]); ?>' name="data[oid]" placeholder="<?php echo (L("sort")); ?>" size="5" />
                        </td>
               
                        <td>
                            <input type="text" value="<?php echo ($tree["name"]); ?>" onchange='javascript:editName(this)' dataId='<?php echo ($tree["id"]); ?>' name="data[name]" placeholder="<?php echo (L("menu")); ?>" size="20" />
                        </td>
                       
                        <td>
                            <a href="<?php echo U('delMenu?id=' . $tree[id]);?>" class="btn btn-default glyphicon glyphicon-trash" data-toggle="doajax" data-confirm-msg="<?php echo (L("delete_confirm")); ?>"><?php echo (L("delete")); ?></a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    </form>
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
function editName(obj){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/LeftMenu/editName');?>",{id:$(obj).attr('dataId'),menuName:obj.value},function(data,textStatus){
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
	   $.post("<?php echo U('Admin/LeftMenu/editSort');?>",{id:$(obj).attr('dataId'),menuSort:obj.value},function(data,textStatus){
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
function editPid(obj){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/LeftMenu/editPid');?>",{id:$(obj).attr('dataId'),menuPid:obj.value},function(data,textStatus){
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