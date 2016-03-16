<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
     <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U($Think.ACTION_NAME);?>" method="post">
	    <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <input placeholder="<?php echo (L("goods_name")); ?>" id="goodsName" type="text" name="search[goodsName]" value="<?php echo ($search["goodsName"]); ?>" />
		<button type="submit" class="btn-default" data-icon="search"><?php echo (L("search")); ?></button>
		<!-- <span><a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span> -->
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn-default dropdown-toggle"
					data-toggle="dropdown" data-icon="copy">
					<?php echo (L("operation")); ?><span class="caret"></span>
				</button>
				<ul class="dropdown-menu right" role="menu">
					<li><a href="<?php echo U('toEdit');?>" data-toggle="dialog"
						data-width="1000" data-height="600" data-id="dialog-mask"
						data-mask="true"><?php echo (L("new_add")); ?></a></li>
				</ul>
			</div>
		</div>
	</form>
</div>
<div class="bjui-pageContent">
	<table class="table table-hover table-striped table-bordered wst-list">
		<thead>
			<tr>
				<th width='40'><?php echo (L("sort")); ?></th>
				<th colspan='2'><?php echo (L("goods_name")); ?></th>
				<th width='60'><?php echo (L("status")); ?></th>
				<th><?php echo (L("goods_score")); ?></th>
				<th><?php echo (L("time_score")); ?></th>
				<th><?php echo (L("service_score")); ?></th>
				<th width='150'><?php echo (L("operation")); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($Page['info'])): $i = 0; $__LIST__ = $Page['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td rowspan='2'><?php echo ($i); ?></td>
				<td rowspan='2' width='50' style='border-right: 0px;'><img src='/<?php echo ($vo[' goodsThums']); ?>' width='50' /></td>
				<td rowspan='2' width='140' style='border-left: 0px;'><span
					style='font-weight: bold;'><?php echo ($vo['goodsName']); ?></span><br /><?php echo (L("order")); ?>：<?php echo ($vo['orderNo']); ?></td>
				<td><?php if($vo['isShow'] == 1 ): ?><span class='label label-success'><?php echo (L("show")); ?></span> 
				    <?php else: ?> <span class='label label-warning'><?php echo (L("hidden")); ?></span><?php endif; ?>
				</td>
				<td>
					<div>
						<?php $__FOR_START_2072739794__=0;$__FOR_END_2072739794__=$vo['goodsScore'];for($i=$__FOR_START_2072739794__;$i < $__FOR_END_2072739794__;$i+=1){ ?><img
							src="/Public/Img/icon_score_yes.png" /><?php } ?>
						&nbsp;<?php echo ($vo['goodsScore']); ?> 
					</div>
				</td>
				<td>
					<div>
						<?php $__FOR_START_6215369__=0;$__FOR_END_6215369__=$vo['timeScore'];for($i=$__FOR_START_6215369__;$i < $__FOR_END_6215369__;$i+=1){ ?><img
							src="/Public/Img/icon_score_yes.png" /><?php } ?>
						&nbsp;<?php echo ($vo['timeScore']); ?> 
					</div>
				</td>
				<td>
					<div>
						<?php $__FOR_START_1194636614__=0;$__FOR_END_1194636614__=$vo['serviceScore'];for($i=$__FOR_START_1194636614__;$i < $__FOR_END_1194636614__;$i+=1){ ?><img
							src="/Public/Img/icon_score_yes.png" /><?php } ?>
						&nbsp;<?php echo ($vo['serviceScore']); ?> 
					</div>
				</td>
				<td rowspan='2'>
				    <a class="btn btn-default glyphicon glyphicon-pencil" href="<?php echo U('toEdit',array('id'=>$vo['id']));?>" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true"><?php echo (L("edit")); ?></a>&nbsp;
				    <a class="btn btn-default glyphicon glyphicon-trash" href="<?php echo U('del',array('id'=>$vo['id']));?>"><?php echo (L("delete")); ?></button>
				</td>
			</tr>
			<tr>
				<td colspan='4' style='word-break: break-all;'><?php echo (L("comment")); ?>[<?php echo ($vo['loginName']); ?>]：<?php echo ($vo['content']); ?></td>
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