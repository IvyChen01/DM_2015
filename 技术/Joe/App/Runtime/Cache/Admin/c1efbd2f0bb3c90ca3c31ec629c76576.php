<?php if (!defined('THINK_PATH')) exit();?>   <div class="bjui-pageHeader">
	 <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U($Think.ACTION_NAME);?>" method="post">
	<input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
		 <select name="search[adPositionId]" data-toggle="selectpicker">
			<option value="">请选择广告位置</option>
			<option value='-1' >首页主广告</option>
			<option value='0' >产品页广告</option>
			<option value='1' >aboutus页广告</option>
                        <option value='2' >support页广告</option>
                        <option value='3' >service页广告</option>
			<?php if(is_array($goodsCatList)): $i = 0; $__LIST__ = $goodsCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' >(商品分类)<?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		<input placeholder=" 广告标题" id="adName" type="text" name="search[adName]" value="<?php echo ($search["adName"]); ?>" />
		<button type="submit" class="btn-default" data-icon="search">查询</button>
		<!-- <span><a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span> -->
		<div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="<?php echo U('toEdit');?>" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true">新增数据</a></li></ul>
                </div>
            </div>
	</form>
</div>
<div class="bjui-pageContent">
	<!-- 内容区 -->

	<table class="table table-bordered table-hover table-striped table-top" data-layout-h="0" data-selected-multi="true">
		<thead>
			<tr>
				<th width='40'>&nbsp;</th>
               <th width='120'>广告标题</th>
               <th>广告位置</th>
               <th>广告网址</th>
               <th>广告日期</th>
               <!-- <th>所属地区</th> -->
               <th width='80'>图标</th>
               <!-- <th width='80'>点击数</th> -->
               <th width='150'>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['adName']); ?></td>
               <td>
               <?php if($vo['adPositionId'] == -1 ): ?>首页主广告
               <?php elseif($vo['adPositionId'] ==0 ): ?>product页广告
               <?php elseif($vo['adPositionId'] ==1 ): ?>aboutus页广告
               <?php elseif($vo['adPositionId'] ==2 ): ?>support页广告
               <?php elseif($vo['adPositionId'] ==3 ): ?>service页广告
               <?php else: ?>
               <?php if(is_array($goodsCatList)): $i = 0; $__LIST__ = $goodsCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gvo): $mod = ($i % 2 );++$i; if($vo['adPositionId'] == $gvo['catId'] ): echo ($gvo['catName']); endif; endforeach; endif; else: echo "" ;endif; endif; ?>
               </td>
               <td><?php echo ($vo['adURL']); ?></td>
               <td><?php echo ($vo['adStartDate']); ?>至<?php echo ($vo['adEndDate']); ?></td>
               <!-- <td><?php echo ($vo['areaName1']); echo ($vo['areaName2']); ?></td> -->
               <td><img src='/<?php echo ($vo['adFile']); ?>' width='60' height='30'></td>
               <!-- <td><?php echo ($vo['adClickNum']); ?></td> -->
               <td>
                <a href="<?php echo U('del?id=' . $vo[adId]);?>" class="btn btn-red glyphicon glyphicon-trash" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删除</a>
				<a href="<?php echo U('toEdit?id=' . $vo[adId]);?>" class="btn btn-default glyphicon glyphicon-pencil" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true">编辑</a>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	</form>
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