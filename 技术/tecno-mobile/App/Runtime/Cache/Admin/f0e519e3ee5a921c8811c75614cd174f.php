<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U(ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <label><?php echo (L("total_tables")); echo ($tables); echo (L("ables")); ?>，<?php echo (L("total")); echo ($total); ?></label>
            <div class="pull-right">
                <div class="btn-group">
                   <!--  <button type="submit" class="btn-default" data-icon="search">备份所选</button> -->
                    <a type="button" class="btn" href="<?php echo U('SysData/backup');?>" data-toggle="doajaxchecked" data-group="table" data-idname="table"><?php echo (L("batch_backup")); ?></a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="bjui-pageContent">
    <!-- 内容区 -->
    <form>
        <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
            <thead>
                <tr>
                    <th width="90">
                        <label>
                            <input name="" class="chooseAll" type="checkbox" onclick='javascript:checkAll(this.checked)' />
                        </label>
           
                    </th>
                    <th><?php echo (L("table_name")); ?></th>
                    <th><?php echo (L("table_desc")); ?></th>
                    <th><?php echo (L("line_number")); ?></th>
                    <th><?php echo (L("engine_type")); ?></th>
                    <th><?php echo (L("charset")); ?></th>
                    <th><?php echo (L("table_size")); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <input type="checkbox" class='chk' name="table" value="<?php echo ($tab["Name"]); ?>" />
                        </td>
                        <td align="left"><?php echo ($tab["Name"]); ?></td>
                        <td><?php echo ($tab["Comment"]); ?></td>
                        <td><?php echo ($tab["Rows"]); ?></td>
                        <td><?php echo ($tab["Engine"]); ?></td>
                        <td><?php echo ($tab["Collation"]); ?></td>
                        <td><?php echo ($tab["size"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <tr>
                        <th width="90">
                            <label>
                                <input name="" class="chooseAll" type="checkbox" onclick='javascript:checkAll(this.checked)'/><?php echo (L("all")); ?></label>
                            <!-- <label>
                                <input name="" class="unsetAll" type="checkbox" onclick='javascript:clickCheckbox()'/>反选</label> -->
                        </th>
                     <th><?php echo (L("table_name")); ?></th>
                    <th><?php echo (L("table_desc")); ?></th>
                    <th><?php echo (L("line_number")); ?></th>
                    <th><?php echo (L("engine_type")); ?></th>
                    <th><?php echo (L("charset")); ?></th>
                        <th><?php echo (L("total")); ?>：<?php echo ($total); ?></th>
                    </tr>
            </tbody>
        </table>
    </form>
</div>

<script type="text/javascript">
function checkAll(v){
	   $('.chk').each(function(){
		   $(this).prop('checked',v);
	   })
}
/*     $(function() {
        $(".submit").click(function() {
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要备份的数据库表吧");
                return false;
            }
            if ($(this).attr("disabledSubmit")) {
                popup.alert("已提交，系统在处理中...");
            } else {
                $(this).attr("disabledSubmit", true).html("提交处理中...");
                ajaxSubmit("/index.php/Admin/SysData/backup");
                //                        popup.alert("系统处理中，如果数据库中数据较多可能需要较长时间，请稍候....");
                setTimeout(function() {
                    popup.close("asyncbox_alert");
                }, 2000);
            }
        });
    }); */
</script>