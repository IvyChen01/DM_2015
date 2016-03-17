<?php if (!defined('THINK_PATH')) exit();?>    <!-- <script src="/Public/Js/daterangepicker.js"></script> -->
   <script>
   var ThinkPHP = window.Think = {
	        "ROOT"   : ""
	}
   var filetypes = ["gif","jpg","png","jpeg"];
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:false,submitOnce:true,onError:function(msg){
		}});
	   
	   $("#adPositionId").formValidator({onFocus:"请选择广告位置"}).inputValidator({min:1,onError: "请选择广告位置"});
	   $("#adName").formValidator({empty:false,onFocus:"请输入广告标题"}).inputValidator({min:1,onError: "请输入广告标题"});
	   //$('#adDateRange').daterangepicker({format:'YYYY-MM-DD',separator:' 至 '});
	   /* <?php if($object['adId'] !=0 ): ?>getAreaList("areaId2",<?php echo ($object["areaId1"]); ?>,0,<?php echo ($object["areaId2"]); ?>);<?php endif; ?> */
   });
   function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("<?php echo U('Admin/District/queryByList');?>",params,function(data,textStatus){
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
   $("#submit").click(function(){
	    $("#adPic").val($.trim($("#adFile").val()));
		$("#myform").submit();
	});
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
	<iframe name="upload" style="display:none"></iframe>
			<form id="uploadform_Filedata" autocomplete="off" style="position:absolute;top:80px;left:115px;z-index:10;" enctype="multipart/form-data" method="POST" target="upload" action="<?php echo U('uploadPic');?>" >
				<div style="position:relative;">
				<input id="adFile" name="adFile" class="form-control wst-ipt" type="text" value="<?php echo ($object["adFile"]); ?>" readonly style="margin-right:4px;float:left;margin-left:8px;width:250px;"/>
				<div class="div1" style="position:absolute;left:280px;">
					<!-- <div class="div2">浏览</div> -->
					<input type="file" class="inputstyle" id="Filedata" name="Filedata" onchange="updfile('Filedata');" >
				</div>
				<div style="clear:both;"></div>
				<!-- <div >&nbsp;图片大小:1400 x 300 (px)(格式为 gif, jpg, jpeg, png)</div> -->
				<input type="hidden" name="dir" value="ads">
				<input type="hidden" name="width" value="1400">
				<input type="hidden" name="folder" value="Filedata">
				<input type="hidden" name="sfilename" value="Filedata">
				<input type="hidden" name="fname" value="adFile">
				<input type="hidden" id="s_Filedata" name="s_Filedata" value="">
				
				</div>
		</form>
       <form action="<?php echo U('edit');?>" id="myform" class="pageForm" data-toggle="validate" data-reload-navtab="true" name="myform" role="form">
        <input type='hidden' id='id' name="id" value='<?php echo ($object["adId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <!-- <tr>
             <th align='right'>广告地区：</th>
             <td>
             <select id='areaId1' onchange='javascript:getAreaList("areaId2",this.value,0)'>
                <option value=''>请选择</option>
                <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             <select id='areaId2'>
               <option value=''>请选择</option>
             </select>
             (不选则默认整个商城)
             </td>
           </tr> -->
           <tr>
             <th align='right'>广告位置<font color='red'>*</font>：</th>
             <td>
             <select id='adPositionId' name="adPositionId">
                <option value=''>请选择</option>
                <option value='-1' <?php if($object['adPositionId'] == -1 ): ?>selected<?php endif; ?>>首页主广告</option>
                <option value='0' <?php if($object['adPositionId'] == 0 ): ?>selected<?php endif; ?>>product页广告</option>
                <option value='1' <?php if($object['adPositionId'] == 1 ): ?>selected<?php endif; ?>>aboutus页广告</option>
                <option value='2' <?php if($object['adPositionId'] == 2 ): ?>selected<?php endif; ?>>support页广告</option>
                <option value='3' <?php if($object['adPositionId'] == 3 ): ?>selected<?php endif; ?>>service页广告</option>
                <?php if(is_array($goodsCatList)): $i = 0; $__LIST__ = $goodsCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['adPositionId'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             </td>
           </tr>
           <tr>
             <th width='120' align='right'>广告标题<font color='red'>*</font>：</th>
             <td><input type='text' id='adName' name="adName" class="form-control wst-ipt" value='<?php echo ($object["adName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr style="height:60px;">
             <th align='right'>广告图片<font color='red'>*</font>：</th>
             <td><input type="hidden" id="adPic" name="adPic" class="form-control wst-ipt" value=""/>
             </td>
           </tr>
           <tr>
             <th align='right'>预览图：</th>
             <td height='40'>
             	<div id="preview_Filedata">
               <img id='preview' src='/<?php echo ($object["adFile"]); ?>' height='152' <?php if($object['adFile'] =='' ): ?>style='display:none'<?php endif; ?>/>
               </div>
             </td>
             
           </tr>
          
           <tr>
	             <th width='120'>广告文字信息：</th>
	             <td colspan='3'>
	            <!--  <textarea rows="2" style="width:788px" id='goodsSpec' name='goodsSpec'><?php echo ($object["goodsSpec"]); ?></textarea> -->
	             <textarea rows="2" cols="70" data-toggle="kindeditor" id='adDesc' name='adDesc'><?php echo ($object["adDesc"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
             <th align='right'>广告链接：</th>
             <td>
             <input type='text' id='adURL' name="adURL" class="form-control wst-ipt" value='<?php echo ($object["adURL"]); ?>'/>
             </td>
             <td rowspan='4' valign='top'>
	               <div style="display: inline-block; vertical-align: middle;">
							<div id="j_custom_pic_up" data-toggle="upload"
								data-uploader="<?php echo U('upload');?>" data-file-size-limit="1024000000"
								data-file-type-exts="*.jpg;*.png;*.gif;*.mpg" data-multi="true"
								data-on-upload-success="pic_upload_success"
								data-icon="cloud-upload">手机版图片：</div>
							<input type="hidden" name="adPhoneImg" value="<?php echo ($object["adPhoneImg"]); ?>" id="j_custom_pic">
						    <span id="j_custom_span_pic"><img alt="" src="<?php echo ($object["adPhoneImg"]); ?>" width="100"></span>
						</div>
	             </td>
           </tr>
           <tr>
             <th align='right'>视频链接：</th>
             <td>
             <input type='text' id='adVideo' name="adVideo" class="form-control wst-ipt" value='<?php echo ($object["adVideo"]); ?>'/>
             </td>
           </tr>
           <tr>
             <th align='right'>广告日期<font color='red'>*</font>：</th>
             <td>
             <input type='text' name="adStartDate" data-toggle="datepicker" class="form-control"  value='<?php echo ($object["adStartDate"]); ?>'/>至
             <input type='text' name="adEndDate" data-toggle="datepicker" class="form-control"  value='<?php echo ($object["adEndDate"]); ?>'/>
             </td>
           </tr>
           <tr>
             <th align='right'>广告排序号：</th>
             <td>
             <input type='text' id='adSort' name="adSort" class="form-control"  value='<?php echo ($object["adSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
           <!-- <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="<?php echo U('Admin/Ads/index');?>"'>返&nbsp;回</button>
             </td>
           </tr> -->
        </table>
       </form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<!-- <li><button type="submit" class="btn-default" data-icon="save">保存</button></li> -->
		<li><button id="submit" type="submit" class="btn btn-success" data-icon="save">保&nbsp;存</button></li>
	</ul>
</div>