<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" type="text/css" href="/Public/css/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Js/webuploader/style.css" />
<link rel="stylesheet" type="text/css" href="/Public/Js/webuploader/webuploader.css" />
<!-- <link rel="stylesheet" type="text/css" href="/Public/css/shop.css"> 
<script src="<?php echo C('STATIC_PATH');?>Plugins/kindeditor/kindeditor.js"></script>
<script src="<?php echo C('STATIC_PATH');?>Plugins/kindeditor/lang/en.js"></script> 
<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/formValidator/formValidator-4.1.3.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script>-->

<script type="text/javascript" src="/Public/Js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/Public/Js/goodsbatchupload.js"></script>
<!--<script type="text/javascript" src="/Public/Js/layer/layer.min.js"></script>
<script type="text/javascript" src="/Public/Js/shopcom.js"></script>-->
<!-- <script type="text/javascript" src="/Public/Js/brandslist.js"></script> -->
<script type="text/javascript">
$(function () {
	   
	   $('#tab').TabPanel({tab:0});
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
			       editGoods();
			       return false;
			},onError:function(msg){
		}});
	   $("#goodsSn").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入商品编号"});
	   $("#goodsName").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入商品名称"});
	   $("#marketPrice").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入市场价格"});
	   $("#shopPrice").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入店铺价格"});
	   $("#goodsStock").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入库存"});
	   $("#goodsUnit").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入商品单位"});
	  /*  $("#goodsCatId3").formValidator({onFocus:"请选择商品分类"}).inputValidator({min:1,onError: "请选择完整商品分类"});
	   $("#shopCatId2").formValidator({onFocus:"请选择店铺分类"}).inputValidator({min:1,onError: "请选择完整店铺分类"}); */
	   <?php if($object['attrCatId'] ==0 ): ?>$("#goodsAttr").css("display","none");<?php endif; ?>
	   <?php if($object['goodsId'] !=0 ): ?>getCatListForEdit("goodsCatId2",<?php echo ($object["goodsCatId1"]); ?>,0,<?php echo ($object["goodsCatId2"]); ?>);
	   getCatListForEdit("goodsCatId3",<?php echo ($object["goodsCatId2"]); ?>,1,<?php echo ($object["goodsCatId3"]); ?>);
	   /* getShopCatListForEdit(<?php echo ($object["shopCatId1"]); ?>,<?php echo ($object["shopCatId2"]); ?>); */<?php endif; ?>
	
});

$("#submit").click(function(){
	var gallery = [];
	$('.gallery-img').each(function(){
		 gallery.push($(this).attr('v')+'@'+$(this).attr('iv'));
	});
	$('#gallery-img').val(gallery);
	$("#goodsPriceNo").val($('.hiddenPriceAttr').attr('dataId'));
    $('.attrList').each(function(){
		   //多选项处理
		   if($(this).attr('dataType')==1){
			   var chk = [];
			   $('input[name="attrTxtChk_'+$(this).attr('dataId')+'"]:checked').each(function(){
				   chk.push($(this).val())
			   })
		       $('#attr_name_'+$(this).attr('dataId')).val(chk.join(','));
		   }else{
			   //普通下拉，文本
			  // params['attr_name_'+$(this).attr('dataId')] = $.trim($(this).val());
			   $('#attr_name_'+$(this).attr('dataId')).val($.trim($(this).val()));
		   }
	   });
	$("#addForm").submit();
});
function imglimouseover(obj){
	if(!$(obj).find('.file-panel').html()){
		$(obj).find('.setdel').addClass('trconb');
		$(obj).find('.setdel').css({"display":""});
	}
}

function imglimouseout(obj){
	
	$(obj).find('.setdel').removeClass('trconb');
	$(obj).find('.setdel').css({"display":"none"});
}

function imglidel(obj){
	if (confirm('是否删除图片?')) {
		$(obj).parent().remove("li");
		return;
	}
}

function imgmouseover(obj){
	$(obj).find('.wst-gallery-goods-del').show();
}
function imgmouseout(obj){
	$(obj).find('.wst-gallery-goods-del').hide();
}
function delImg(obj){
	   $(obj).parent().remove();
}

var filetypes = ["gif","jpg","png","jpeg"];

function pic_upload_success(file, data) {
    var json = $.parseJSON(data);
    
    $(this).bjuiajax('ajaxDone', json);
    if (json[BJUI.keys.statusCode] == BJUI.statusCode.ok) {
        $('#j_custom_pic').val(json.filename);
        $('#j_custom_span_pic').html('<img src="'+ json.filename +'" width="100" />');
    }
}
</script>
<div class="bjui-pageContent">
	<form action="<?php echo U('edit');?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="addForm" role="form">
		<!-- <form action="#" name="myform" method="post" id="myform" autocomplete="off" class="pageForm" data-toggle="validate" data-reload-navtab="true" role="form"> -->
		<input type='hidden' id='id' name='id' value='<?php echo ($object["goodsId"]); ?>' /> 
		<input type='hidden' id='goodsThumbs' value='<?php echo ($object["goodsThums"]); ?>' />
		<table class="table-condensed table-hover" width="100%" id="goodsDetail">
			<tbody>
			    <tr>
	             <th width='120'>商品编号<font color='red'>*</font>：</th>
	             <td width='300'>
	             <input type='text' id='goodsSn' name='goodsSn' class="form-control wst-ipt" value='<?php echo ($object["goodsSn"]); ?>' maxLength='25'/>
	             </td>
	             <td rowspan='6' valign='top'>
	               <div style="display: inline-block; vertical-align: middle;">
							<div id="j_custom_pic_up" data-toggle="upload"
								data-uploader="<?php echo U('upload');?>" data-file-size-limit="1024000000"
								data-file-type-exts="*.jpg;*.png;*.gif;*.mpg" data-multi="true"
								data-on-upload-success="pic_upload_success"
								data-icon="cloud-upload">商品图标：</div>
							<input type="hidden" name="goodsImg" value="<?php echo ($object["goodsImg"]); ?>" id="j_custom_pic">
						    <span id="j_custom_span_pic"><img alt="" src="<?php echo ($object["goodsImg"]); ?>" width="100"></span>
						</div>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品名称<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsName' name='goodsName' class="form-control wst-ipt" value='<?php echo ($object["goodsName"]); ?>' maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>市场价格<font color='red'>*</font>：</th>
	             <td>
	             	<input type='text' id='marketPrice' name='marketPrice' class="form-control wst-ipt" value='<?php echo ($object["marketPrice"]); ?>' onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='10'/>
	             </td>
	           </tr>
	            <tr>
	             <th width='120'>店铺价格<font color='red'>*</font>：</th>
	             <td>
	             	<?php if($object["recommPrice"] > 0): ?><input type='text' id='shopPrice' name='shopPrice' disabled="disabled" class="form-control wst-ipt" value='<?php echo ($object["recommPrice"]); ?>' onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='10'/>
	             	<?php else: ?>
	             		<input type='text' id='shopPrice' name='shopPrice' class="form-control wst-ipt" value='<?php echo ($object["shopPrice"]); ?>' onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='10'/><?php endif; ?>
	             	
	             </td>
	           </tr>
	            <tr>
	             <th width='120'>商品库存<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsStock' name='goodsStock' class="form-control wst-ipt" value='<?php echo ($object["goodsStock"]); ?>' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='25' <?php if(count($object['priceAttrs']) > 0 ): ?>disabled<?php endif; ?> /></td>
	           </tr>
	           <tr>
	             <th width='120'>单位<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsUnit' name='goodsUnit' class="form-control wst-ipt" value='<?php echo ($object["goodsUnit"]); ?>'  maxLength='25'/></td>
	           </tr>
	           <!-- <tr>
	             <th width='120'>商品SEO关键字：</th>
	             <td colspan='3'>
	             <input type='text' style="width:788px" id='goodsKeywords' name='goodsKeywords' value='<?php echo ($object["goodsKeywords"]); ?>' maxlength="100">
	             </td>
	           </tr> -->
	           <tr>
	             <th width='120'>商品信息：</th>
	             <td colspan='3'>
	            <!--  <textarea rows="2" style="width:788px" id='goodsSpec' name='goodsSpec'><?php echo ($object["goodsSpec"]); ?></textarea> -->
	             <textarea rows="2" cols="70" data-toggle="kindeditor" id='goodsSpec' name='goodsSpec'><?php echo ($object["goodsSpec"]); ?></textarea>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品状态<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <label>
	             <input type='radio' id='isSale1' name='isSale' <?php if($object['isSale'] ==1 ): ?>checked<?php endif; ?> value='1'/>上架
	             </label>
	             <label>
	             <input type='radio' id='isSale0' name='isSale' <?php if($object['isSale'] ==0 ): ?>checked<?php endif; ?> value='0'/>下架
	             </label>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品属性：</th>
	             <td colspan='3'>
	             <label>
	             <input type='checkbox' id='isRecomm' name='isRecomm' <?php if($object['isRecomm'] ==1 ): ?>checked<?php endif; ?> value='1'/>推荐
	             </label>
	             <label>
	             <input type='checkbox' id='isBest' name='isBest' <?php if($object['isBest'] ==1 ): ?>checked<?php endif; ?> value='1'/>精品
	             </label>
	             <label>
	             <input type='checkbox' id='isNew' name='isNew' <?php if($object['isNew'] ==1 ): ?>checked<?php endif; ?> value='1'/>新品
	             </label>
	             <label>
	             <input type='checkbox' id='isHot' name='isHot' <?php if($object['isHot'] ==1 ): ?>checked<?php endif; ?> value='1'/>热销
	             </label>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>所属分类<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <select id='goodsCatId1' name='goodsCatId1' onchange='javascript:getCatListForEdit("goodsCatId2",this.value,0)'>
	                <option value=''>请选择</option>
	                <?php if(is_array($goodsCatsList)): $i = 0; $__LIST__ = $goodsCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['goodsCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	             </select>
	             <select id='goodsCatId2' name='goodsCatId2' onchange='javascript:getCatListForEdit("goodsCatId3",this.value,1);'>
	                <option value=''>请选择</option>
	             </select>
	             <select id='goodsCatId3' name='goodsCatId3'>
	                <option value=''>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <!-- <tr>
	             <th width='120'>店铺分类<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <select id='shopCatId1' name='shopCatId1' onchange='javascript:getShopCatListForEdit(this.value,"<?php echo ($object['shopCatId2']); ?>")'>
	                <option value='0'>请选择</option>
	                <?php if(is_array($shopCatsList)): $i = 0; $__LIST__ = $shopCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['shopCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	             </select>
	             <select id='shopCatId2' name='shopCatId2'>
	                <option value='0'>请选择</option>
	             </select>
	             </td>
	           </tr> -->
	           <tr>
	             <th width='120'>品牌：</th>
	             <td>
	             <select id='brandId' name='brandId' dataVal='<?php echo ($object["brandId"]); ?>'>
	                <option value='0'>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品描述<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <textarea rows="2" cols="70" data-toggle="kindeditor" id='goodsDesc' name='goodsDesc'><?php echo ($object["goodsDesc"]); ?></textarea>
	             </td>
	           </tr>
				</tr>
				<tr id="goodsAttr">
	             <th width='120'>商品其他属性<font color='red'>*</font>：</th>
	             <td colspan='3'>
	        <fieldset id='priceContainer' class='wst-goods-fieldset' <?php if(count($object['priceAttrs']) > 0): ?>style='display:block'<?php endif; ?>>
			    <legend>价格类型</legend>
			    <input type='hidden' class="hiddenPriceAttr" dataId='<?php echo ($object["priceAttrId"]); ?>' dataNo="<?php echo (count($object['priceAttrs'])); ?>" value='<?php echo ($object["priceAttrName"]); ?>'/>
			    <input type='hidden' id="goodsPriceNo"  name="goodsPriceNo" value=''/>
			    <table class="wst-form wst-goods-price-table">
	             <thead><tr><th>属性</th><th>规格</th><th>价格</th><!-- <th>推荐</th><th>库存</th> --><th>操作</th></tr></thead>
	             <tbody id="priceConent">
	             <?php if(is_array($object['priceAttrs'])): $i = 0; $__LIST__ = $object['priceAttrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		              <td style="text-align:right"><?php echo ($vo['attrName']); ?>：</td>
		              <td><input type="text" id="price_name_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" name="price_name_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" value="<?php echo ($vo['attrVal']); ?>"/></td>
		              <td><input type="text" id="price_price_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" name="price_price_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" value="<?php echo ($vo['attrPrice']); ?>" onblur="checkAttPrice(<?php echo ($vo['attrId']); ?>,<?php echo ($i); ?>);" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength="10"/></td>
		              <!-- <td><input type="radio" id="price_isRecomm_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" name="price_isRecomm" onclick="checkAttPrice(<?php echo ($vo['attrId']); ?>,<?php echo ($i); ?>);" <?php if($vo['isRecomm'] == 1): ?>checked<?php endif; ?>/></td>
		              <td><input type="text" id="price_stock_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" onblur="getTstock();" value="<?php echo ($vo['attrStock']); ?>" onblur="javascript:statGoodsStaock()" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength="10"/></td> -->
		              <td>
		              <?php if($i == 1): ?><a title="新增" class="btn" href="javascript:addPriceAttr()">新增</a>
		              <?php else: ?>
		              <a title="删除" class="btn" href="javascript:delPriceAttr(<?php echo ($i); ?>)">删除</a><?php endif; ?>
		              </td>
		           </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	             </tbody>
	            </table>
			</fieldset>
			<fieldset id='attrContainer' class='wst-goods-fieldset' <?php if(count($object['attrs']) > 0): ?>style='display:block'<?php endif; ?>>
			    <legend>属性类型</legend>
			    <table class="wst-form" style='width:100%'>
	              <tbody id='attrConent'>
	              <?php if(is_array($object['attrs'])): $i = 0; $__LIST__ = $object['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		              <td style="width:80px;text-align:right" nowrap><?php echo ($vo['attrName']); ?>：</td>
		              <td>
		              <?php if($vo['attrType']==0){ ?>
		              <input type="text" style='width:70%;' class="attrList" id="attr_name_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" name="attr_name_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" value="<?php echo ($vo['attrVal']); ?>" dataId="<?php echo ($vo['attrId']); ?>"/>
		              <?php }else if($vo['attrType']==2){ ?>
		              <select class="attrList" id="attr_name_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" name="attr_name_<?php echo ($vo['attrId']); ?>_<?php echo ($i); ?>" dataId="<?php echo ($vo['attrId']); ?>">
		              <?php if(is_array($vo['opts']['txt'])): $i = 0; $__LIST__ = $vo['opts']['txt'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$attrvo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($attrvo); ?>' <?php if($attrvo == $vo['attrVal']): ?>selected<?php endif; ?> ><?php echo ($attrvo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		              </select>
		              <?php }else if($vo['attrType']==1){ ?>
		              <input type='hidden' class="attrList" dataId='<?php echo ($vo['attrId']); ?>' name="attr_name_<?php echo ($vo['attrId']); ?>"  dataType="1"/>
		              
		              <?php if(is_array($vo['opts']['txt'])): $i = 0; $__LIST__ = $vo['opts']['txt'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$attrvo): $mod = ($i % 2 );++$i;?><label><input type='checkbox' name="attrTxtChk_<?php echo ($vo['attrId']); ?>" value="<?php echo ($attrvo); ?>" <?php if($vo['opts']['val'][$attrvo] == 1): ?>checked<?php endif; ?>/><?php echo ($attrvo); ?></label>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
		              <?php } ?>
		              </td>
		             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	              </tbody>
	            </table>
			</fieldset>
			<input type="hidden" id="attrCatId" name="attrCatId" value="" />
			</td>
			</tr>
	           <tr>
	             <th width='120'>商品相册<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <div id='galleryImgs' class='wst-gallery-imgs'>
                  <div id="tt"></div>
                  <?php if(count($object['gallery']) == 0): ?><div id="wrapper">
                           <!-- <div id="container"> -->
            <!--头部，相册选择和格式选择-->
                              <div id="uploader">
                               <div class="queueList">
                                   <div id="dndArea" class="placeholder">
                                      <div id="filePicker"></div>
                                      </div>
                                   <ul class="filelist"></ul>
                               </div>
                             <div class="statusBar" style="display:none">
                               <div class="progress">
                                    <span class="text">0%</span>
                                    <span class="percentage"></span>
                               </div>
                                    <div class="info"></div>
                               <div class="btns">
                                 <div id="filePicker2" class="webuploader-containe webuploader-container"></div><div class="uploadBtn state-finish">开始上传</div>
                               </div>
                            </div>
                         </div>
                      <!-- </div> -->
                   </div>
               <?php else: ?>
               	<div id="wrapper">
                       <!-- <div id="container"> -->
                          <div id="uploader">
                             <div class="queueList">
                                 <div id="dndArea" class="placeholder element-invisible">
                                    <div id="filePicker" class="webuploader-container"></div>
                                    </div>
                                 <ul class="filelist">
                                 	<?php if(is_array($object['gallery'])): $i = 0; $__LIST__ = $object['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="border: 1px solid rgb(59, 114, 165)" order="100" onmouseover="imglimouseover(this)" onmouseout="imglimouseout(this)">
	                                 		<input type="hidden" class="gallery-img" iv="<?php echo ($vo["goodsThumbs"]); ?>" v="<?php echo ($vo["goodsImg"]); ?>" />
	                                 		<img width="152" height="152" src="<?php echo ($vo["goodsThumbs"]); ?>"><span class="setdef" style="display:none">默认</span><span class="setdel" onclick="imglidel(this)" style="display:none">删除</span>
                                 		</li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                                 
                            </div>
                            <div class="statusBar" style="">
                               <div class="progress">
                                    <span class="text"></span>
                                    <span class="percentage"></span>
                               </div>
                               <div class="info"></div>
                               <div class="btns">
                                  <div id="filePicker2" class="webuploader-containe webuploader-container"></div>
                                  <div class="uploadBtn state-finish">开始上传</div>
                               </div>
                            </div>
                        </div>
                    <!-- </div> -->
                 </div><?php endif; ?>
		       <input type="hidden" id="gallery-img" name="gallery" value="" />
	       
	       
	           
	       </div>
	       </td>
	           </tr>
			</tbody>
		</table>
	</form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn btn-close"  data-icon="close">关闭</button></li>
		<li><a href="javascript:void(0);" id="submit" class="btn btn-success"><i class="fa fa-save"></i>保&nbsp;存</a></li>
	</ul>
</div>