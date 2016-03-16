<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U(ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <label><?php echo (L("total")); echo ($files); echo (L("sql_file")); ?>，<?php echo (L("total")); echo ($total); ?></label>
            <div class="pull-right">
                <div class="btn-group">
                   <!--  <button type="button" class="btn-default delSqlFiles">删除所选</button> -->
                    <a type="button" class="btn" href="<?php echo U('SysData/delSqlFiles');?>" data-toggle="doajaxchecked" data-group="sqlFiles" data-idname="sqlFiles" data-confirm-msg="<?php echo (L("delete_confirm")); ?>"><?php echo (L("delete_selected")); ?></a>
                    <!-- <button type="button" class="btn-green sendSql">发送SQL到邮箱</button>
                    <button type="button" class="btn-red zip">压缩SQL为ZIP</button> -->
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
                    <th width="90">
                        <label>
                            <input name="" class="chooseAll" type="checkbox" onclick='javascript:checkAll(this.checked)'/><?php echo (L("all")); ?></label>
                    </th>
                    <th><?php echo (L("sql_name")); ?></th>
                    <th><?php echo (L("backup_time")); ?></th>
                    <th><?php echo (L("type")); ?></th>
                    <th><?php echo (L("file_size")); ?></th>
                    <th><?php echo (L("file_comment")); ?></th>
                    <th><?php echo (L("import")); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sql): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <input pre="<?php echo ($sql["pre"]); ?>" type="checkbox" class='chk' name="sqlFiles" value="<?php echo ($sql["name"]); ?>" />
                        </td>
                        <td align="left"><a href="<?php echo U('SysData/downFile',array('file'=>$sql['name'],'type'=>'sql'));?>" target="_blank"><?php echo ($sql["name"]); ?></a>
                        </td>
                        <td><?php echo ($sql["time"]); ?></td>
                        <td><?php echo ($sql["type"]); ?></td>
                        <td><?php echo ($sql["size"]); ?></td>
                        <td class="description" title="<?php echo ($sql["description"]); ?>"><?php echo (L("view_info")); ?></td>
                        <td>
                            <!-- <button class="btn restore"  sqlPre="<?php echo ($sql["pre"]); ?>">导入</button> -->
                            <a href="<?php echo U('SysData/restoreData',array('sqlPre'=>$sql['pre']));?>" class="btn btn-red glyphicon" data-toggle="doajax" data-confirm-msg="<?php echo (L("import_confirm")); ?>"><?php echo (L("import")); ?></a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <!-- <tr>
                        <th width="90">
                            <label>
                                <input name="" class="chooseAll" type="checkbox" />全选</label>
                            <label>
                                <input name="" class="unsetAll" type="checkbox" />反选</label>
                        </th>
                        <th>SQL文件名</th>
                        <th>备份时间</th>
                        <th>类型</th>
                        <th>总计：<?php echo ($total); ?></th>
                        <th>文件备注</th>
                        <th>导入</th>
                    </tr> -->
            </tbody>
        </table>
        <input type="hidden" name="to" id="to" value="" />
    
</div>
<script type="text/javascript">
function checkAll(v){
	   $('.chk').each(function(){
		   $(this).prop('checked',v);
	   })
}
//提交数据恢复操作
$(".restore").click(function() {
	alert(1);
    if ($(this).attr("disabledSubmit")) {
        popup.alert("已提交，系统在处理中...");
        return false;
    }
    var sqlPre = $(this).attr("sqlPre");
    $(".restore[sqlPre='" + sqlPre + "']").attr("disabledSubmit", true).html("导入中...");
    $(".btn").attr("disabledSubmit", true);
    alert(2);
    $.getJSON("<?php echo U('SysData/restoreData');?>", {
        sqlPre: sqlPre
    }, function(json) {
    	alert(json);
        if (json.status == 1) {
            if (json.url) {
                $("#opStatus").show().html(json.info);
                repeat(json.url, "restore");
            } else {
                popup.success(json.info);
            }
            popup.close("asyncbox_alert");
        } else {
            popup.error(json.info);
        }
    });
    popup.alert("系统处理中，如果导入文件较大可能需要较长时间，请稍候....");
    return false;
});
    $(function() {
        //刷新操作
        var repeat = function(url, type) {
            $.post(url, function(json) {
                //                        var json = eval("(" + json + ")");
                if (json.status == 1) {
                    if (json.url) {
                        $("#opStatus").html(json.info);
                        repeat(json.url, type);
                    } else {
                        popup.success(json.info, 'oh yeah', function(action) {
                            if (action == 'ok') {
                                $("#opStatus").hide('solw');
                                $("." + type).html(type == "sendSql" ? "发送SQL到邮箱" : "导入");
                            }
                        });
                        $(".btn").removeAttr("disabledSubmit");
                    }
                } else {
                    popup.error(json.info);
                }
            });
        }
        $(".sendSql").click(function() {
            if ($(this).attr("disabledSubmit")) {
                popup.alert("已提交，系统在处理中...");
                return false;
            }
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要发送到邮件中的数据库表吧");
                return false;
            }
            popup.open({
                id: "ifrSendSql",
                url: "/index.php/Admin/SysData/sendSql",
                width: 400,
                height: 100,
                buttons: [{
                    value: '确定发送邮件',
                    result: 'submit'
                }, {
                    value: '取消',
                    result: 'cancel'
                }],
                callback: function(btnRes, cntWin, reVal) {
                    if (btnRes == "submit") {
                        var email = cntWin.getEmail();
                        var Reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                        if (Reg.test(email)) {
                            $("#to").val(email);
                            $(".btn").attr("disabledSubmit", true);
                            $("form").ajaxSubmit({
                                url: "/index.php/Admin/SysData/sendSql",
                                type: "POST",
                                success: function(json, st) {
                                    //                                            var json = eval("(" + json + ")");
                                    if (json.status == 1) {
                                        if (json.url) {
                                            $("#opStatus").show().html(json.info);
                                            repeat(json.url, "sendSql");
                                        } else {
                                            popup.success(json.info);
                                        }
                                        popup.close("asyncbox_alert");
                                    } else {
                                        popup.error(json.info);
                                    }
                                }
                            });
                            popup.close("ifrSendSql");
                        } else {
                            popup.error("你输入的电子邮件地址格式错误");
                        }
                        return false;
                    }
                }
            });
            return false;
        });
        //显示SQL文件说明信息
       /*  $('.description').poshytip({
            className: 'tip-yellowsimple',
            showTimeout: 0.5,
            alignX: 'center',
            offsetY: 0,
            allowTipHover: true
        }); */
        clickCheckbox(); //全新反选
        //同一备份版本任意一个卷选中则选中该卷所有文件
        $("tbody input[type='checkbox']").click(function() {
            $("tbody input[type='checkbox'][pre='" + $(this).attr("pre") + "']").prop("checked", $(this).prop('checked'));
        });
  
        //删除备份文件
        $(".delSqlFiles").click(function() {
            if ($(this).attr("disabledSubmit")) {
                popup.alert("已提交，系统在处理中...");
                return false;
            }
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要删除的数据库表吧");
                return false;
            }
            popup.confirm('你确定要删除备份文件吗？', '温馨提示', function(action) {
                if (action == 'ok') {
                    $(".btn").attr("disabledSubmit", true);
                    $(this).html("提交处理中...");
                    ajaxSubmit("/index.php/Admin/SysData/delSqlFiles");
                }
            });
            return false;
        });

        //删除备份文件
        $(".zip").click(function() {
            if ($(this).attr("disabledSubmit")) {
                popup.alert("已提交，系统在处理中...");
                return false;
            }
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要压缩的数据库表吧");
                return false;
            }
            ajaxSubmit("/index.php/Admin/SysData/zipSql");
            $(".btn").attr("disabledSubmit", true);
            $(this).html("压缩中...");
            return false;
        });
    });
</script>