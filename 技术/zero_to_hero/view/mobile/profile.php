<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="css/mobile.css?v=2015.5.23_18.18"/>
<script src="js/jquery-1.11.2.min.js"></script>
</head>
<body class="profile">
<div class="header">
    <div class="page-title">
        <a href="?m=mwzero&a=history" target="_self" class="back" id="backBtn"><img src="images/mobile/m_left_2.png" alt=""/></a>
        <span id="titleTxt">Me</span>
        <a href="javascript:;" class="edit-profile" id="editBtn"><img src="images/mobile/edit.png"></a>
        <a href="javascript:;" class="save-profile" id="finishBtn">Finish</a>
    </div>
</div>
<section id="basicInfo">
    <div class="user-stats">
        <img id="photoImg" src="<?php echo $_data['local_photo']; ?>"/>
        <div class="upload-stats" id="fileBtn">
            <input type="file" onchange="selectImage(this);" />
            <span>
               +
            </span>
        </div>
    </div>
    <div class="panel-title">
        Profile
    </div>
    <div class="user-info" id="editList">
        <div class="item">
            <span class="label">Name</span>
            <span class="value" id="nameTxt"><?php echo $_data['realname']; ?></span>
            <em class="edit-icon"></em>
        </div>
        <div class="item">
            <span class="label">Area</span>
            <span class="value" id="areaTxt"><?php echo $_data['locale']; ?></span>
            <em class="edit-icon"></em>
        </div>
        <div class="item sex-item">
            <span class="label">Gender</span>
            <span class="value" id="genderTxt"><?php echo $_data['gender']; ?></span>
            <em class="edit-icon"></em>
        </div>
        <div class="item">
            <span class="label">Age</span>
            <span class="value" id="ageTxt"><?php echo $_data['age']; ?></span>
            <em class="edit-icon"></em>
        </div>
        <div class="item">
            <span class="label">Email</span>
            <span class="value" id="emailTxt"><?php echo $_data['email']; ?></span>
            <em class="edit-icon"></em>
        </div>
		<div class="item">
            <span class="label">Phone</span>
            <span class="value" id="phoneTxt"><?php echo $_data['phone']; ?></span>
            <em class="edit-icon"></em>
        </div>
        <div class="exit" id="exitBtn">
            <a href="?m=mwuser&a=logout" target="_self">Logout</a>
        </div>
    </div>
</section>
<div class="dialog">
    <div class="title">Country</div>
    <div class="value">
        <input type="text" id="inputTxt" />
    </div>
    <div class="sex">
        <span>male
            <em>√</em>
        </span>
        <span>female
            <em>√</em>
        </span>
    </div>
    <div class="dialog-ctrl">
        <a href="javascript:;" class="cancel" id="cancelBtn">Cancel</a>
        <a href="javascript:;" class="ok" id="okBtn">Ok</a>
    </div>
</div>
<canvas id="cv" width="200px" height="200px" style="display:none;">
Your browser does not support the canvas element.
</canvas>
<script type="text/javascript">
var itemIndex = 0;
var genderIndex = -1;
var cv = null;
var cxt = null;
var photo = null;

$(document).ready(function()
{
	cv = document.getElementById("cv");
	cxt = cv.getContext("2d");
	photo = new Image();
	photo.onload = onLoadPhoto;
	$("#editBtn").click(onClickEdit);
	$(".user-info .item em").click(onClickInfoEm);
	$(".dialog .sex span").click(onClickGender);
	//$(".dialog-ctrl .cancel").click(onClickCancel);
	$("#okBtn").click(onClickOk);
	$("#cancelBtn").click(onClickCancel);
	$("#finishBtn").click(onClickFinish);
});

function onClickEdit(e)
{
	$("#editBtn").hide();
	$("#finishBtn").show();
	$("#titleTxt").text("Edit");
	$("#backBtn").hide();
	$("#photoImg").hide();
	$("#fileBtn").show();
	$("#editList em").show();
	$("#exitBtn").hide();
}

function onClickInfoEm(e)
{
	var item = $(this).closest(".item");
	
	itemIndex = item.index();
	if (item.hasClass("sex-item"))
	{
		$(".dialog .value").hide();
		$(".dialog .sex").show();
	}
	else
	{
		$(".dialog .value").show();
		$(".dialog .sex").hide();
	}
	$(".dialog .title").text(item.find(".label").text()).parent(".dialog").fadeIn();
	$("#inputTxt").val("");
}

function onClickGender(e)
{
	if ($(this).siblings("span").hasClass("selected")) $(this).siblings("span").removeClass("selected");
	$(this).addClass("selected");
	genderIndex = $(this).index();
}

function onClickOk(e)
{
	var gender = "";
	
	switch (itemIndex)
	{
		case 0:
			if ($("#inputTxt").val() == "")
			{
				alert("Name cannot be empty!");
				return;
			}
			$("#nameTxt").text($("#inputTxt").val());
			$.post("?m=mwuser&a=doChangeName", {realname: $("#inputTxt").val()}, onChangeInfo);
			break;
		case 1:
			if ($("#inputTxt").val() == "")
			{
				alert("Area cannot be empty!");
				return;
			}
			$("#areaTxt").text($("#inputTxt").val());
			$.post("?m=mwuser&a=doChangeLocale", {locale: $("#inputTxt").val()}, onChangeInfo);
			break;
		case 2:
			switch (genderIndex)
			{
				case 0:
					gender = "male";
					break;
				case 1:
					gender = "female";
					break;
				default:
					gender = "";
			}
			if (gender == "")
			{
				alert("Gender cannot be empty!");
				return;
			}
			$("#genderTxt").text(gender);
			$.post("?m=mwuser&a=doChangeGender", {gender: gender}, onChangeInfo);
			break;
		case 3:
			if ($("#inputTxt").val() == "")
			{
				alert("Age cannot be empty!");
				return;
			}
			$("#ageTxt").text($("#inputTxt").val());
			$.post("?m=mwuser&a=doChangeAge", {age: $("#inputTxt").val()}, onChangeInfo);
			break;
		case 4:
			if (!checkEmail($("#inputTxt").val()))
			{
				alert("Please enter the correct email!");
				return;
			}
			$("#emailTxt").text($("#inputTxt").val());
			$.post("?m=mwuser&a=doChangeEmail", {email: $("#inputTxt").val()}, onChangeInfo);
			break;
		case 5:
			if ($("#inputTxt").val() == "")
			{
				alert("Phone number cannot be empty!1");
				return;
			}
			$("#phoneTxt").text($("#inputTxt").val());
			$.post("?m=mwuser&a=doChangePhone", {phone: $("#inputTxt").val()}, onChangeInfo);
			break;
		default:
	}
	$(".dialog").fadeOut();
}

function onChangeInfo(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown Error!");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			break;
		default:
			alert(res.info);
	}
}

function onClickCancel(e)
{
	$(".dialog").fadeOut();
}

function onClickFinish(e)
{
	$("#editBtn").show();
	$("#finishBtn").hide();
	$("#titleTxt").text("Me");
	$("#backBtn").show();
	$("#photoImg").show();
	$("#fileBtn").hide();
	$("#editList em").hide();
	$("#exitBtn").show();
}

function checkEmail(str)
{
	var re = /^([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+@([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+.[a-za-z]{2,3}$/;
	
	return re.test(str);
}

function selectImage(file)
{
	var reader = null;
	
	if (!file.files || !file.files[0])
	{
		return;
	}
	reader = new FileReader();
	reader.onload = function(e)
	{
		$("#photoImg").attr("src", e.target.result);
		photo.src = e.target.result;
	}
	reader.readAsDataURL(file.files[0]);
}

function onLoadPhoto()
{
	var dx = 0;
	
	cxt.clearRect(0, 0, cv.width, cv.height);
	if (photo.width < photo.height)
	{
		dx = (photo.height - photo.width) / 2;
		cxt.drawImage(photo, 0, dx, photo.width, photo.width, 0, 0, cv.width, cv.height);
	}
	else
	{
		dx = (photo.width - photo.height) / 2;
		cxt.drawImage(photo, dx, 0, photo.height, photo.height, 0, 0, cv.width, cv.height);
	}
	uploadPhoto();
}

function uploadPhoto()
{
	$.post("?m=mwuser&a=doChangePhoto", {img: cv.toDataURL("image/jpeg", 0.9).replace("data:image/jpeg;base64,", "")}, onUploadPhoto);
}

function onUploadPhoto(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown Error!");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			alert("Upload completed!");
			break;
		default:
			alert(res.info);
	}
}
</script>
</body>
</html>
