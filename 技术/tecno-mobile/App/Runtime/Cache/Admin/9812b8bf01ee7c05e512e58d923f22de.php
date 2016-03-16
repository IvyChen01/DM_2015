<?php if (!defined('THINK_PATH')) exit();?>
<!-- <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=37f0869604ca86505487639427d52bf6"></script> -->
<!-- <script src="<?php echo C('STATIC_PATH');?>Plugins/kindeditor/kindeditor.js"></script>
<script src="<?php echo C('STATIC_PATH');?>Plugins/kindeditor/lang/en.js"></script> 
<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/formValidator/formValidator-4.1.3.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script> -->
<script>
   var ThinkPHP = window.Think = {
	        "ROOT"   : ""
	}
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#loginName").formValidator({onShow:"",onFocus:"会员账号应该为5-16字母、数字或下划线",onCorrect:"输入正确"}).inputValidator({min:5,max:16,onError:"会员账号应该为5-16字母、数字或下划线"}).regexValidator({regExp:"username",dataType:"enum",onError:"会员账号格式错误"
		}).ajaxValidator({
			dataType : "json",
			async : true,
			url : "<?php echo U('Admin/Users/checkLoginKey');?>",
			success : function(data){
				var json = WST.toJson(data);
	            if( json.status == "1" ) {
	                return true;
				} else {
	                return false;
				}
				return "该账号已被使用";
			},
			buttons: $("#dosubmit"),
			onError : "该账号已存在。",
			onWait : "请稍候..."
		}).defaultPassed();
	   $("#loginPwd").formValidator({
			onShow:"",onFocus:"登录密码长度应该为5-20位之间"
			}).inputValidator({
				min:5,max:50,onError:"登录密码长度应该为5-20位之间"
			});
		$("#userPhone_shop").inputValidator({min:0,max:11,onError:"你输入的手机号码非法,请确认"}).regexValidator({
		   regExp:"mobile",dataType:"enum",onError:"手机号码格式错误"
		}).ajaxValidator({
			dataType : "json",
			async : true,
			url : "<?php echo U('Admin/Users/checkLoginKey',array('id'=>$object.userId));?>",
			success : function(data){
				var json = WST.toJson(data);
	            if( json.status == "1" ) {
	                return true;
				} else {
	                return false;
				}
				return "该手机号码已被使用";
			},
			buttons: $("#dosubmit"),
			onError : "该手机号码已存在。",
			onWait : "请稍候..."
		}).defaultPassed().unFormValidator(true);
		//$("#shopSn_shop").formValidator({onShow:"",onFocus:"店铺编号不能超过20个字符",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"店铺编号不符合要求,请确认"});
		$("#shopName_shop").formValidator({onShow:"",onFocus:"店铺名称不能超过20个字符",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"店铺名称不符合要求,请确认"});
		//$("#userName_shop").formValidator({onShow:"",onFocus:"请输入店主姓名",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"店主姓名不能为空,请确认"});
		//$("#shopCompany").formValidator({onShow:"",onFocus:"请输入公司名称",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"公司名称不能为空,请确认"});
		$("#shopAddress").formValidator({onShow:"",onFocus:"请输入店铺地址",onCorrect:"输入正确"}).inputValidator({min:1,max:120,onError:"店铺地址不能为空,请确认"});
		//$("#areaId3").formValidator({onFocus:"请选择所属地区"}).inputValidator({min:1,onError: "请选择所属地区"});
		$("#goodsCatId1").formValidator({onFocus:"请选择所属行业"}).inputValidator({min:1,onError: "请选择所属行业"});
		$("#bankId").formValidator({onFocus:"请选择所属银行"}).inputValidator({min:1,onError: "请选择所属银行"});
		$("#bankNo").formValidator({onShow:"",onFocus:"请输入银行卡号",onCorrect:"输入正确"}).inputValidator({min:16,max:19,onError:"银行卡号格式错误,请确认"}) .functionValidator({fun:luhmCheck,onError:"请输入正确的银行卡号！"});;
	
		$("#serviceStartTime").formValidator({onShow:"",onFocus:"请选择营业时间"}).inputValidator({min:1,max:50,onError:"请选择营业时间"});
		$("#serviceEndTime").formValidator({onShow:"",onFocus:"请选择营业时间"}).inputValidator({min:1,max:50,onError:"请选择营业时间"});

		$("#userPhone_shop").blur(function(){
			  if($("#userPhone_shop").val()==''){
				  $("#userPhone_shop").unFormValidator(true);
			  }else{
				  $("#userPhone_shop").unFormValidator(false);
			  }
		});
		//ShopMapInit();
		initialize();
		<?php if($object['shopId'] !=0 ): ?>getAreaList("areaId2",<?php echo ($object["areaId1"]); ?>,0,<?php echo ($object["areaId2"]); ?>);<?php endif; ?>
   });
   /* function initialize() {
       var mapOptions = {
         center: new google.maps.LatLng(-34.397, 150.644),
         zoom: 8,
         mapTypeId: google.maps.MapTypeId.ROADMAP
       };
       var map = new google.maps.Map(document.getElementById("mapContainer"),
           mapOptions);
     } */
	var map;
	var markersArray = [];
	function initialize() {
	  <?php if($object['longitude'] !=0 ): ?>var haightAshbury = new google.maps.LatLng( <?php echo ($object['latitude']); ?>,<?php echo ($object['longitude']); ?>);
	  <?php else: ?>var haightAshbury = new google.maps.LatLng('29.845408626428', '29.646606445312');<?php endif; ?>
	  var mapOptions = {
	    center: haightAshbury,
	    zoom: 8, 
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("mapContainer"),mapOptions);
	  google.maps.event.addListener(map, 'click', function(event) {
	    addMarker(event.latLng);
	  });
	}

	function addMarker(location) {
	  deleteOverlays();//清除地图中的标记
	  marker = new google.maps.Marker({
	    position: location,
	    map: map
	  });
	  $('#longitude').val(location.lng());
		$('#latitude').val(location.lat());
		//$('#mapLevel').val(this.getZoom());
	  markersArray.push(marker);
	  var infowindow = new google.maps.InfoWindow({
		  content:"Shop here!"
		  });
		infowindow.open(map,marker);
	}
	// Removes the overlays from the map, but keeps them in the array
	function clearOverlays() {
	  if (markersArray) {
	    for (i in markersArray) {
	      markersArray[i].setMap(null);
	    }
	  }
	}
	// Shows any overlays currently in the array

	function showOverlays() {
	  if (markersArray) {
	    for (i in markersArray) {
	      markersArray[i].setMap(map);
	    }
	  }
	}
	// Deletes all markers in the array by removing references to them
	function deleteOverlays() {
	  if (markersArray) {
	    for (i in markersArray) {
	      markersArray[i].setMap(null);
	    }
	    markersArray.length = 0;
	  }
	}
    function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value=""><?php echo (L("select")); ?></option>');
	   }else{
		   if(t==1 && $('#areaId2').find("option:selected").text()!=''){
			   geocoder = new google.maps.Geocoder(); 
			   geocoder.geocode( { 'address': $('#areaId2').find("option:selected").text()}, function(results, status) { 
				      if (status == google.maps.GeocoderStatus.OK) { 
				        console.log(results[0].geometry.location) 
				        map.setCenter(results[0].geometry.location); 
				      }
			   });
			   //map.setZoom();
			   //map.setCity($('#areaId2').find("option:selected").text());
			   //$('#showLevel').val(shopMap.getZoom());
		   }
	   } 
	  var html = [];
	   $.post("<?php echo U('Admin/Shops/queryShowByList');?>",params,function(data,textStatus){
		    html.push('<option value=""><?php echo (L("select")); ?></option>');
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
</script>
<div class="bjui-pageContent">
	<form action="<?php echo U('edit');?>" id="addForm" class="pageForm"
		data-toggle="validate" data-reload-navtab="true" name="addForm"
		role="form">
		<input type='hidden' id='id' name='id' value='<?php echo ($object["shopId"]); ?>' />
		<table class="table table-condensed table-hover" width="100%">
			<tbody>
				<!-- <tr>
					<td colspan="2"><label class="control-label x100"><?php echo (L("shop_sn")); ?><font
							color='red'>*</font>：
					</label> <input type='text' id='shopSn_shop' class="form-control wst-ipt"
						name="shopSn" value='<?php echo ($object["shopSn"]); ?>' maxLength='25' /></td>
				</tr> -->
				<tr>
					<td colspan="2"><label class="control-label x100"><?php echo (L("shop_name")); ?><font
							color='red'>*</font>：
					</label> <input type='text' id='shopName_shop' class="form-control wst-ipt"
						name="shopName" value='<?php echo ($object["shopName"]); ?>' maxLength='25' /></td>
				</tr>
				<!-- <tr>
					<td colspan="2"><label class="control-label x100"><?php echo (L("manager")); ?><font
							color='red'>*</font>：
					</label> <input type='text' id='userName_shop' class="form-control wst-ipt" name="userName" value='<?php echo ($object["userName"]); ?>' maxLength='25' />
						<select id='staffsId' name="staffsId">
							<option value=''><?php echo (L("select")); ?></option>
							<?php if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['uid']); ?>' <?php if($object['userId'] == $vo['uid'] ): ?>selected<?php endif; ?>><?php echo ($vo['username']); ?>
							</option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select></td>
				</tr>-->
				
				<tr>
					<td colspan="2"><label class="control-label x100"><?php echo (L("telephone")); ?><font
							color='red'>*</font>：
					</label> <input type='text' id='shopTel_shop' class="form-control wst-ipt"
						name="shopTel" value='<?php echo ($object["shopTel"]); ?>' maxLength='25' /></td>
				</tr>
				<tr>
					<td colspan="2"><label class="control-label x100">Email<font
							color='red'>*</font>：
					</label> <input type='text' id='shopEmail'
						class="form-control wst-ipt" name="shopEmail"
						value='<?php echo ($object["shopEmail"]); ?>' maxLength='25' /></td>
				</tr>
				<tr>
                    <td colspan="2">
                        <label class="control-label x100"><?php echo (L("lang")); ?>：</label>
                        <select id='adLang' name="lang">
                          <option value='0' <?php if($object['lang'] == 0 ): ?>selected<?php endif; ?>>English</option>
                          <option value='1' <?php if($object['lang'] == 1 ): ?>selected<?php endif; ?>>French</option>
                          <option value='2' <?php if($object['lang'] == 2 ): ?>selected<?php endif; ?>>Arab</option>
                       </select>
                        
                    </td>
                </tr>
				<tr>
					<td colspan="2"><label class="control-label x100"><?php echo (L("shop_address")); ?><font
							color='red'>*</font>：
					</label> <select id='areaId1' name="areaId1"
						onchange='javascript:getAreaList("areaId2",this.value,0)'>
							<option value=''><?php echo (L("select")); ?></option>
							<?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?>
							</option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select> <select id='areaId2' name="areaId2">
							<option value=''><?php echo (L("select")); ?></option>
					</select> <!-- <select id='areaId3' name="areaId3">
							<option value=''>请选择</option>
					    </select> --></td>
				</tr>
				 
				<tr>
					<td colspan="2"><label class="control-label x100"><?php echo (L("address")); ?><font
							color='red'>*</font>：
					</label> <input type='text' id='shopAddress' class="form-control wst-ipt"
						name="shopAddress" value='<?php echo ($object["shopAddress"]); ?>' maxLength='120' />
					</td>
				</tr>
				<tr id='shopMap'>
					<td colspan="2">
						<div id="mapContainer" style='height: 400px; width: 90%;'><?php echo (L("map_init")); ?></div>
						<div style='display: none'>
							<input type='text' id='latitude' name='latitude'
								value="<?php echo ($object["latitude"]); ?>" /> <input type='text'
								id='longitude' name='longitude' value="<?php echo ($object["longitude"]); ?>" />
							<input type='text' id='mapLevel' name='mapLevel'
								value="<?php echo ($object["mapLevel"]); ?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close"><?php echo (L("close")); ?></button></li>
		<!-- <li><button type="submit" class="btn-default" data-icon="save">保存</button></li> -->
		<li><button type="submit" class="btn btn-success" data-icon="save"><?php echo (L("save")); ?></button></li>
	</ul>
</div>