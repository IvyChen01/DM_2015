<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U(ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <!-- <input type="text" name="search[name]" value="<?php echo ($search["name"]); ?>" class="form-control" size="10" />
            <input type="text" name="search[date]" value="<?php echo ($search["date"]); ?>" class="form-control" size="8" />
            <button type="button" class="btn showMoreSearch" data-toggle="moresearch" data-name="moresearch" title="更多查询条件"><i class="fa fa-angle-double-down"></i></button>
            <button type="submit" class="btn-default" data-icon="search">查询</button> -->
            <!-- <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo">清空查询</a> -->
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy"><?php echo (L("operation")); ?><span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                    <li><a href="<?php echo U('addNode');?>" data-toggle="dialog" data-width="800" data-height="600" data-id="dialog-mask" data-mask="true"><i class="fa fa-plus"></i><?php echo (L("new_add")); ?></a></li>
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
                <th><?php echo (L("sort_num")); ?></th>
                <th><?php echo (L("node_structure")); ?> 
                </th>
                <th><?php echo (L("node_id")); ?></th>
                <th><?php echo (L("node_name")); ?></th>
                <th><?php echo (L("show_name")); ?></th>
                <th><?php echo (L("sort")); ?></th>
                <th><?php echo (L("type")); ?></th>
                <th><?php echo (L("status")); ?></th>
                <th width="150"><?php echo (L("operation")); ?></th>
            </tr>
        </thead>
        <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr id="<?php echo ($vo["id"]); ?>" pid="<?php echo ($vo["pid"]); ?>">
                <td><?php echo ($k); ?></td>
                <td align="left" class="tree" style="cursor: pointer;"><?php echo ($vo["fullname"]); ?></td>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["name"]); ?></td>
                <td><?php echo ($vo["title"]); ?></td>
                <td edit="0" fd="sort"><?php echo ($vo["sort"]); ?></td>
                <td><?php echo ($vo["level"]); ?></td>
                <td><?php echo ($vo["statusText"]); ?></td>
                <td>
                  <a href="<?php echo U('editNode?id='.$vo[id]);?>" class="btn btn-red glyphicon glyphicon-trash" data-toggle="dialog" data-id="nodeEdit" data-width="800" data-height="480"><?php echo (L("edit")); ?></a>
                  <!-- <a href="javascript:void(0);" class="btn btn-default opStatus" val="<?php echo ($vo["status"]); ?>"><?php echo ($vo["chStatusText"]); ?></a> -->
                  <a href="<?php echo U('del?id=' . $vo[id]);?>" class="btn btn-red glyphicon glyphicon-trash" data-toggle="doajax" data-confirm-msg="<?php echo (L("delete_confirm")); ?>"><?php echo (L("delete")); ?></a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
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

<script type="text/javascript">
    $(function() {
        //快捷启用禁用操作
        $(".opStatus").click(function() {
            alert('123');
        });

        //快捷改变操作排序dblclick
        $("tbody>tr>td[fd]").click(function() {
            var inval = $(this).html();
            var infd = $(this).attr("fd");
            var inid = $(this).parents("tr").attr("id");
            if ($(this).attr('edit') == 0) {
                $(this).attr('edit', '1').html("<input class='input' size='5' id='edit_" + infd + "_" + inid + "' value='" + inval + "' />").find("input").select();
            }
            $("#edit_" + infd + "_" + inid).focus().bind("blur", function() {
                var editval = $(this).val();
                $(this).parents("td").html(editval).attr('edit', '0');
                if (inval != editval) {
                    $.post("/index.php/Admin/Access/opSort", {
                        id: inid,
                        fd: infd,
                        sort: editval
                    });
                }
            })
        });

        var chn = function(cid, op) {
            if (op == "show") {
                $("tr[pid='" + cid + "']").each(function() {
                    $(this).removeAttr("status").show();
                    chn($(this).attr("id"), "show");
                });
            } else {
                $("tr[pid='" + cid + "']").each(function() {
                    $(this).attr("status", 1).hide();
                    chn($(this).attr("id"), "hide");
                });
            }
        }
        $(".tree").click(function() {
            if ($(this).attr("status") != 1) {
                chn($(this).parent().attr("id"), "hide");
                $(this).attr("status", 1);
            } else {
                chn($(this).parent().attr("id"), "show");
                $(this).removeAttr("status");
            }
        });
    });
</script>