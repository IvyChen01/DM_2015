<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U($Think.ACTION_NAME);?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true">
        <input type="hidden" id="pk" name="info[id]" value="<?php echo ($info["id"]); ?>">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">标题：</label>
                        <input id="title" type="text" name="info[title]" value="<?php echo ($info["title"]); ?>" size="60" />
                        <a href="javascript:void(0)" id="checkNewsTitle">检测是否重复</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x100">所属分类：</label>
                        <select name="info[cid]" data-toggle="selectpicker" data-width="300">
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo $vo[catId];?>" <?php if($vo[catId] == $info[cid]): ?>selected="selected"<?php endif; ?>>
                                    <?php echo $vo[catName];?>
                                </option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                    <td>
                        <label class="control-label x100">发布状态：</label>
                        <input type="radio" name="info[status]" data-toggle="icheck" value="0" data-rule="checked" data-label="审核中&nbsp;&nbsp;" <?php if($info["status"] == 0): ?>checked<?php endif; ?>>
                        <input type="radio" name="info[status]" data-toggle="icheck" value="1" data-label="已发布" <?php if($info["status"] == 1): ?>checked<?php endif; ?>>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">关键词：</label>
                        <input type="text" name="info[keywords]" value="<?php echo ($info["keywords"]); ?>" placeholder="多关键词间用半角逗号分开" size="60" /> 多关键词间用半角逗号分开
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">文章描述：</label>
                        <textarea name="info[description]" style="width:784px;height:50px" data-toggle="autoheight"><?php echo ($info["description"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">文章摘要：</label>
                        <textarea name="info[summary]" style="width:784px;height:50px" data-toggle="autoheight"><?php echo ($info["summary"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">封面缩略图：</label>
                        <input type="text" id="thumbnail_text" name="info[thumbnail]" value="<?php echo ($info["thumbnail"]); ?>" size="60" />
                        <input type="button" id="thumbnail_btn" class="btn btn-info" value="选择图片" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">文章内容：</label>
                        <div style="display: inline-block; vertical-align: middle;">
                            <textarea name="info[content]" style="width:784px;height:50px" data-toggle="kindeditor"><?php echo (htmlspecialchars($info["content"])); ?></textarea>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>

<script type="text/javascript">
    // 单独调用KindEditor图片插件
    var editor = KindEditor.editor({
        allowFileManager : true
    });
    KindEditor('#thumbnail_btn').click(function() {
        editor.loadPlugin('image', function() {
            editor.plugin.imageDialog({
                imageUrl : KindEditor('#url1').val(),
                clickFn : function(url, title, width, height, border, align) {
                    KindEditor('#thumbnail_text').val(url);
                    editor.hideDialog();
                }
            });
        });
    });

    // 检查标题是否重复
    $("#checkNewsTitle").click(function() {
        $.getJSON("/index.php/Admin/Article/checkArticleTitle", {
                title: $("#title").val(),
                id: "<?php echo ($info["id"]); ?>"
            }, function(json) {
                $("#checkNewsTitle").css("color", json.status == 1 ? "#0f0" : "#f00").html(json.info);
        });
    });
</script>