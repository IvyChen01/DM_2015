<?php if (!defined('THINK_PATH')) exit();?> <div class="bjui-pageContent">
	    <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name="id" value='<?php echo ($object["attrId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th align='right'><?php echo (L("goods_cat")); ?><font color='red'>*</font>：</th>
             <td>
             <select id='catId' name="catId">
                <?php if(is_array($goodsCatList)): $i = 0; $__LIST__ = $goodsCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object["catId"] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             </td>
           </tr>
           <tr>
             <th width='150' align='right'><?php echo (L("goods_attribute")); ?><font color='red'>*</font>：</th>
             <td><input type='text' id='attrName' name="attrName" class="form-control wst-ipt" value='<?php echo ($object["attrName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='150' align='right'><?php echo (L("price_attr")); ?><font color='red'>*</font>：</th>
             <td><select id='attrType_<?php echo ($i); ?>' name="attrType" onchange='javascript:hideSelVal(this.value);'>
	               <option value='0' <?php if($object["attrType"] ==0): ?>selected<?php endif; ?>><?php echo (L("input")); ?></option/>
	               <option value='1' <?php if($object["attrType"] ==1): ?>selected<?php endif; ?>><?php echo (L("option")); ?></option/>
	               <option value='2' <?php if($object["attrType"] ==2): ?>selected<?php endif; ?>><?php echo (L("drop_down")); ?></option/>
               </select></td>
           </tr>
           <tr>
             <th width='150' align='right'><?php echo (L("price_attr")); ?><font color='red'>*</font>：</th>
              <td><input type='radio' id='isPriceAttr0' value='1' name='isPriceAttr' <?php if($object['isPriceAttr'] ==1 ): ?>checked<?php endif; ?>/><?php echo (L("yes")); ?>
                    <input type='radio' id='isPriceAttr1' value='0' name='isPriceAttr' <?php if($object['isPriceAttr'] ==0 ): ?>checked<?php endif; ?>/><?php echo (L("no")); ?>
             </td>
           </tr>
           <tr id="SelVal">
             <th width='200' ><?php echo (L("attr_option_value")); ?>：</th>
              <td><input type='text' id='attrContent' name="attrContent" class="form-control wst-ipt" value='<?php echo ($object["attrContent"]); ?>'/>
             </td>
           </tr>
           
           <tr>
             <th align='right'><?php echo (L("sort")); ?>：</th>
             <td>
             <input type='text' id='attrSort' name="attrSort" class="form-control"  value='<?php echo ($object["attrSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
        </table>
       </form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close"><?php echo (L("close")); ?></button></li>
		<!-- <li><button type="submit" class="btn-default" data-icon="save">保存</button></li> -->
		<li><button id="submit" type="submit" class="btn btn-success" data-icon="save"><?php echo (L("save")); ?></button></li>
	</ul>
</div>
<script>
   function hideSelVal(val){
	   if(val==0){
		   $("#SelVal").css("display","none");
	   }else{
		   $("#SelVal").show();
	   }
   }
   $(function(){
	   <?php if($object["attrType"] ==0 ): ?>$("#SelVal").css("display","none");<?php endif; ?>
   })
</script>