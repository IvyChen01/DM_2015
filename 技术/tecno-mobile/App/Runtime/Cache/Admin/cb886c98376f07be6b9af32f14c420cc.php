<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U(ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <input type="text" placeholder="<?php echo (L("role_name")); ?>" name="search[name]" value="<?php echo ($search["name"]); ?>" class="form-control" size="10" />
            <button type="submit" class="btn-default" data-icon="search"><?php echo (L("search")); ?></button>
            <!-- <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo"><?php echo (L("role_name")); ?>清空查询</a> -->
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy"><?php echo (L("operation")); ?><span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                    <li><a href="<?php echo U('toEdit');?>" data-toggle="dialog" data-width="600" data-height="400" data-id="dialog-mask" data-mask="true"><i class="fa fa-plus"></i> <?php echo (L("operation")); ?>新增数据</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="bjui-pageContent">
    <!-- 内容区 -->
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
                <th><?php echo (L("role_id")); ?></th>
                <th><?php echo (L("role_name")); ?></th>
                <th><?php echo (L("desc")); ?></th>
                <th><?php echo (L("status")); ?></th>
                <th><?php echo (L("operation")); ?></th>
            </tr>
        </thead>
        <?php if(is_array($Page['info'])): $k = 0; $__LIST__ = $Page['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr id="<?php echo ($vo["id"]); ?>">
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["name"]); ?></td>
                <td align="left"><?php echo ($vo["remark"]); ?></td>
                <td><?php if($vo['status'] ==1 ): echo (L("enable")); endif; ?>
               <?php if($vo['status'] ==0 ): echo (L("forbid")); endif; ?>&nbsp;</td>
                <td>
                    <a href="<?php echo U('toEdit',array('id' => $vo[id]));?>" class="btn btn-default glyphicon glyphicon-pencil" data-toggle="dialog" data-id="nodeEdit" data-width="800" data-height="480"><?php echo (L("edit")); ?></a>
                    <a href="<?php echo U('Access/changeRole',array('id' => $vo[id]));?>" class="btn btn-default glyphicon " data-toggle="dialog" data-width="600" data-height="400" data-id="dialog-mask" data-mask="true"><?php echo (L("permissions")); ?></a>
                    <a class="btn btn-default glyphicon glyphicon-trash" data-confirm-msg="<?php echo (L("delete_confirm")); ?>" data-toggle="doajax" href="<?php echo U('del',array('id' => $vo['id']));?>"><?php echo (L("delete")); ?></a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
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

    <script type="text/javascript">
        //show完毕前执行
        $('#myModal').on('shown.bs.modal', function () {
            // 提交表单
            $(".submitForm").click(function() {
                var url;
                if ($("#pk").val())
                    url = '/index.php/Admin/Role/edit';
                else
                    url = '/index.php/Admin/Role/add';
                ajaxSubmit(url, '#addForm');
            });
        });       
    </script>

    <script type="text/javascript">
    $(function() {
        //快捷启用禁用操作
        $(".opStatus").click(function() {
            var obj = $(this);
            var id = $(this).parents("tr").attr("id");
            var status = $(this).attr("val");
            $.getJSON("/index.php/Admin/Role/opRoleStatus", {
                id: id,
                status: status
            }, function(json) {
                if (json.status == 1) {
                    popup.success(json.info);
                    $(obj).attr("val", json.data.status).html(status == 1 ? "启用" : "禁用").parents("td").prev().html(status == 1 ? "禁用" : "启用");
                } else {
                    popup.alert(json.info);
                }
            });
        });
    });
    </script>