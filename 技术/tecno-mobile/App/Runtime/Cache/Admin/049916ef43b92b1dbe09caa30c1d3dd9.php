<?php if (!defined('THINK_PATH')) exit();?>
<link rel="stylesheet" href="/Public/css/daterangepicker-bs3.css">
<script type="text/javascript" src="/Public/Js/daterangepicker.js"></script>
   <script>
   function query(id){
	   var date = $('#logDate').val().split(' -> ');
	   $('#startDate').val(date[0]);
	   $('#endDate').val(date[1]);
       $('#form1').submit();   
   }
   $(function(){
	   $('#logDate').daterangepicker({format:'YYYY-MM-DD',separator:' -> '});
   })
   </script>
   <div class="bjui-pageHeader">
	<form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U($Think.ACTION_NAME);?>" method="post">
	    <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
       <input type='hidden' id='startDate' name='search[startDate]' value='<?php echo ($search["startDate"]); ?>'/>
       <input type='hidden' id='endDate' name='search[endDate]' value='<?php echo ($search["endDate"]); ?>'/>
                     <?php echo (L("login_time")); ?>：<input type='text' id='logDate' class="form-control" readonly='true' style='width:250px' value='<?php echo ($startDate); ?> -> <?php echo ($endDate); ?>'/>
       <input placeholder="<?php echo (L("account")); ?>" id="loginName" type="text" name="search[loginName]" value="<?php echo ($search["loginName"]); ?>"  autocomplete="off"/>
       <button type="submit" class="btn btn-primary glyphicon glyphicon-search" onclick='javascript:query()'><?php echo (L("search")); ?></button> 
		<!-- <span><a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">刷新</a></span> -->
		<!-- <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="<?php echo U('toEdit');?>" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true">新增数据</a></li></ul>
                </div>
            </div> -->
	</form>
</div>
<div class="bjui-pageContent">   
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='40'><?php echo (L("id")); ?></th>
               <th width='80'><?php echo (L("account")); ?></th>
               <th width='80'><?php echo (L("name")); ?></th>
               <th width='150'><?php echo (L("login_time")); ?></th>
               <th width='150'><?php echo (L("login_ip")); ?></th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['info'])): $i = 0; $__LIST__ = $Page['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><?php echo ($vo['loginId']); ?></td>
               <td><?php echo ($vo['loginName']); ?></td>
               <td><?php echo ($vo['staffName']); ?></td>
               <td><?php echo ($vo['loginTime']); ?></td>
               <td><?php echo ($vo['loginIp']); ?></td>   
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