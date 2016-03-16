<?php if (!defined('THINK_PATH')) exit();?>
<div class="bjui-pageHeader">
	<form action="<?php echo U(index);?>" method="POST" class="pageForm"
		data-toggle="validate" data-reload="true">
		<!--    店铺分类：<select id='shopCatId1' autocomplete="off" onchange='javascript:getShopCatListForGoods(this.value,"<?php echo ($object['shopCatId2']); ?>")'>
	         <option value='0'>请选择</option>
	         <?php if(is_array($shopCatsList)): $i = 0; $__LIST__ = $shopCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($shopCatId1 == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	     </select>
	     <select id='shopCatId2' autocomplete="off">
	         <option value='0'>请选择</option>
	     </select>
        <input placeholder="商品名称" type="text" name="goodsName" value="<?php echo ($goodsName); ?>" data-rule="required" />
		<button type="submit"  class="btn btn-default" data-icon="search" onclick='javascript:queryOnSale()'>查询</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		<span><a class="btn btn-default" href="javascript:;"
			onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn-default dropdown-toggle"
					data-toggle="dropdown" data-icon="copy">
					功能操作<span class="caret"></span>
				</button>
				<ul class="dropdown-menu right" role="menu">
					<li><a type="button" class="btn" href="<?php echo U('toEdit');?>"
						id="addgoods" data-toggle="dialog" data-width="600"
						data-height="400" data-id="dialog-mask" data-mask="true">新增数据</a></li>
				</ul>
			</div>
		</div>
	</form>
</div>
<div class="bjui-pageContent">
	<table class="table table-hover table-striped table-bordered wst-list">
		<?php if(is_array($Page['info'])): $key = 0; $__LIST__ = $Page['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><thead>
			<tr>
				<th colspan='6'><?php echo ($key); ?>.订单：<?php echo ($vo['orderNo']); ?><span
					style='margin-left: 100px;'><?php echo ($vo['shopName']); ?></span></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div style='width: 150px;'>
						<?php if(is_array($vo['goodslist'])): $i = 0; $__LIST__ = $vo['goodslist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><img
							style='margin: 2px;' src="/<?php echo ($goods['goodsThums']); ?>"
							height="50" width="50" title='<?php echo ($goods[' goodsName']); ?>'/><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</td>
				<td><?php echo ($vo['userName']); ?></td>
				<td><?php echo ($vo['totalMoney']+$vo['deliverMoney']); ?><br /> <?php if($vo['payType'] ==1 ): ?>在线支付<?php else: ?>货到付款<?php endif; ?>
				</td>
				<td><?php echo ($vo['createTime']); ?></td>
				<td><?php if($vo["orderStatus"] == -3): ?>会员拒收 <?php elseif($vo["orderStatus"] == -5): ?>店铺确认取消 <?php elseif($vo["orderStatus"] == -4): ?>店铺确认拒收 <?php elseif($vo["orderStatus"] == -2): ?>未付款 <?php elseif($vo["orderStatus"] == -1): ?>用户取消 <?php elseif($vo["orderStatus"] == 0): ?>未受理 <?php elseif($vo["orderStatus"] == 1): ?>已受理 <?php elseif($vo["orderStatus"] == 2): ?>打包中 <?php elseif($vo["orderStatus"] == 3): ?>配送中 <?php elseif($vo["orderStatus"] == 4): ?>已到货 <?php elseif($vo["orderStatus"] == 5): ?>店铺确认到货<?php endif; ?></td>
				<td><a class="btn btn-primary glyphicon"
					href="<?php echo U('Admin/Orders/toView',array('id'=>$vo['orderId']));?>"">查看</a>&nbsp;
				</td>
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