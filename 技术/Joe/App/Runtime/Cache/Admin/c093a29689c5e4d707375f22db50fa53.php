<?php if (!defined('THINK_PATH')) exit();?>   <div class="bjui-pageHeader">
	<form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U($Think.ACTION_NAME);?>" method="post">
		<input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
     <!--    店铺分类：<select id='shopCatId1' autocomplete="off" onchange='javascript:getShopCatListForGoods(this.value,"<?php echo ($object['shopCatId2']); ?>")'>
	         <option value='0'>请选择</option>
	         <?php if(is_array($shopCatsList)): $i = 0; $__LIST__ = $shopCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($shopCatId1 == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	     </select>
	     <select id='shopCatId2' autocomplete="off">
	         <option value='0'>请选择</option>
	     </select>-->
        <input placeholder="商品名称" type="text" name="goodsName" value="<?php echo ($goodsName); ?>" />
		<button type="submit" class="btn-default" data-icon="search">查询</button>
		<span><a class="btn btn-default" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span>
		<div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a type="button" class="btn" href="<?php echo U('toEdit');?>" id="addgoods" data-toggle="dialog" data-width="1000" data-height="1000" data-id="dialog-mask" data-mask="true">新增数据</a></li>
                        <li><a type="button" class="btn" href="<?php echo U('Goods/changeRecomStatusN');?>" data-toggle="doajaxchecked" data-group="chk" data-idname="ids" data-confirm-msg="确定要推荐选中项吗？">批量取消推荐</a></li>
                        <li><a type="button" class="btn" href="<?php echo U('Goods/changeRecomStatus');?>" data-toggle="doajaxchecked" data-group="chk" data-idname="ids" data-confirm-msg="确定要推荐选中项吗？">批量推荐</a></li>
                        <li><a type="button" class="btn" href="<?php echo U('Goods/batchDel');?>" data-toggle="doajaxchecked" data-group="chk" data-idname="ids" data-confirm-msg="确定要删除选中项吗？">批量删除</a></li>
                        <li><a type="button" class="btn" href="<?php echo U('Goods/changeBestStatus');?>" data-toggle="doajaxchecked" data-group="chk" data-idname="ids" data-confirm-msg="确定要精品选中项吗？">批量精品</a></li>
                        <li><a type="button" class="btn" href="<?php echo U('Goods/changeBestStatusN');?>" data-toggle="doajaxchecked" data-group="chk" data-idname="ids" data-confirm-msg="确定要取消精品选中项吗？">批量取消精品</a></li>
                        <li><a type="button" class="btn" href="<?php echo U('Goods/unSale');?>" data-toggle="doajaxchecked" data-group="chk" data-idname="ids" data-confirm-msg="确定要下架选中项吗？">批量下架</a></li>
                    </ul>
                </div>
        </div>
	</form>	    
</div>
<div class="bjui-pageContent">
	<!-- 内容区 -->
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='2'><input type='checkbox' name='chkall' onclick='javascript:checkAll(this.checked)'/></th>
               <th width='180'>商品Id</th>
               <th width='180'>商品名称</th>
               <th width='60'>商品编号</th>
               <th width='40'>价格</th>
               <th width='100'>商品分类</th>
               <!-- <th width='80'>店铺</th> -->
               <th width='25'>推荐</th>
               <th width='25'>精品</th>
               <th width='25'>上架</th>
               <th width='25'>销量</th>
               <th width='100'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['info'])): $i = 0; $__LIST__ = $Page['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr >
               <td><input type='checkbox' class='chk' name='chk' value='<?php echo ($vo['goodsId']); ?>'/></td>
               <td><?php echo ($vo['goodsId']); ?>&nbsp;</td>
               <td>
               <img src='<?php echo ($vo['goodsImg']); ?>' width='50'/>
               <?php echo ($vo['goodsName']); ?>
               </td>
               <td><?php echo ($vo['goodsSn']); ?>&nbsp;</td>
               <td><?php echo ($vo['shopPrice']); ?>&nbsp;</td>
               <td><?php echo ($vo['catName']); ?>&nbsp;</td>
               <!-- <td><?php echo ($vo['shopId']); ?>&nbsp;</td> -->
               <td>
               <?php if($vo['isRecomm']==1 ): ?>推荐<?php endif; ?>
               </td>
               <td>
               <?php if($vo['isBest']==1 ): ?>精品<?php endif; ?>
               </td>
               <td>
               <?php if($vo['isSale']==1 ): ?>上架<?php endif; ?>
               </td>
               <td><?php echo ($vo['saleCount']); ?></td>
               <td>
               <a class="btn btn-default glyphicon glyphicon-pencil" href='<?php echo U("toEdit",array("id"=>$vo["goodsId"]));?>' data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true">编辑</a> 
               <a href="<?php echo U('Goods/del?id=' . $vo[goodsId]);?>" class="btn btn-red glyphicon glyphicon-trash" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删除</a>
               
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
<!--<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/formValidator/formValidator-4.1.3.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script> 
<script type="text/javascript" src="/Public/Js/layer/layer.min.js"></script>
<script type="text/javascript" src="/Public/Js/shopcom.js"></script>-->
<script type="text/javascript">

   function changeStatus(id,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Goods/changeGoodsStatus');?>",{id:id,status:v},function(data,textStatus){
				var json = WST.toJson(data);
				if(json.status=='1'){
					Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
					    location.reload();
					}});
				}else{
					
					Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
				
				}
	   });
   }
   function batchBest(v){
	   var ids = [];
	   $('.chk').each(function(){
		   if($(this).prop('checked'))ids.push($(this).val());
	   })
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Goods/changeBestStatus');?>",{id:ids.join(','),status:v},function(data,textStatus){
				var json = WST.toJson(data);
				if(json.status=='1'){
					Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
						$(this).navtab('reloadForm', true);
					}});
				}else{
					Plugins.closeWindow();
					Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
				
				}
	   });
   }
   function batchRecom(v){
	   var ids = [];
	   $('.chk').each(function(){
		   if($(this).prop('checked'))ids.push($(this).val());
	   })
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Goods/changeRecomStatus');?>",{id:ids.join(','),status:v},function(data,textStatus){
				var json = WST.toJson(data);
				if(json.status=='1'){
					Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
						$(this).navtab('reloadForm', true);
					}});
				}else{
					Plugins.closeWindow();
					Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
				
				}
	   });
   }
   function checkAll(v){
	   $('.chk').each(function(){
		   $(this).prop('checked',v);
	   })
   }
    $.fn.imagePreview = function(options){
		var defaults = {}; 
		var opts = $.extend(defaults, options);
		var t = this;
		xOffset = -21;
		yOffset = -8;
		/* if(!$('#preview')[0])$(".bjui-pageContent").append("<div id='preview'><img width='200'  src=''/></div>");
		$(this).hover(function(e){
			   $('#preview img').attr('src',$(this).attr('img')); 
			   $("#preview").css("margin-top",($('#preview img').clientY - xOffset) + "px").css("margin-left",($('#preview img').clientX + yOffset) + "px").show();      
		  },
		  function(){
			$("#preview").hide();
		}); 
		$(this).mousemove(function(e){
			   $("#preview").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px");
		}); */
	}
   function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("<?php echo U('Admin/Areas/queryByList');?>",params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
   }
   $(document).ready(function(){
	    $('.imgPreview').imagePreview();
	    <?php if(!empty($areaId1)): ?>getAreaList("areaId2",'<?php echo ($areaId1); ?>',0,'<?php echo ($areaId2); ?>');<?php endif; ?>
   });
   </script>