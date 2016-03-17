<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/ajaxfileupload.js"></script>
<script src="js/view-image.js"></script>
</head>

<body>
<div class="topbar">
	<span><a href="?m=adminFans" target="_self">Fans management</a> | <a href="?m=admin&a=logout" target="_self">Exit</a></span>
</div>
<div class="news-add">
	<h3>Edit</h3>
	<ul>
		<li>
			<span>Photo[342*342px]：</span>
			<a href="javascript:;" class="upload-img">Select</a>
			<input class="com-val img-url img-val"  type="text" name="photoTxt" id="photoTxt" value="<?php echo $_fans['photo']; ?>" />
		</li>
		<li>
			<span>Name：</span><input type="text" name="nameTxt" id="nameTxt" value="<?php echo $_fans['username']; ?>" />
		</li>
		<p>Introduction：</p>
		<li>
			<textarea name="content" id="content" style="width:100%;height:320px;"><?php echo $_fans['content']; ?></textarea>
		</li>
		<li>
			<span>Publish Time：</span><input type="text" name="pubTime" id="pubTime" value="<?php echo $_fans['pubtime']; ?>" />
		</li>
		<li>
			<input type="button" name="publish" id="publish" value="Save"/>
		</li>
	</ul>
</div>

<div class="upload-img-box dialog">
    <p class="close-btn"><a href="javascript:;">×</a></p>
    <div class="dialog-content">
        <div class="upload-input">
            <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
        </div>
        <div class="submit-upload">
            <button class="button" id="buttonUpload">Upload</button>
        </div>
    </div>
</div>
<div class="view-img-box dialog">
    <div class="dialog-content">
        <img src="" alt=""/>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function ()
{
	$("#publish").click(onClickAdd);
	$("#content").focus();
});

function onClickAdd(e)
{
	var photoTxt = $("#photoTxt").val();
	var nameTxt = $("#nameTxt").val();
	var content = $("#content").val();
	var pubTime = $("#pubTime").val();
	
	$.post("?m=adminFans&a=doModify", {photo: photoTxt, username: nameTxt, content: content, pubtime: pubTime}, onAdd);
}

function onAdd(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown Error!");
		return;
	}
	res = $.parseJSON(value);
	if (0 == res.code)
	{
		alert("Succeed!");
		document.location.href = "?m=adminFans";
	}
	else
	{
		alert(res.msg);
	}
}

$(function(){
    var img_val_index=0;
    $(".upload-img").click(function(){
        $("body").append("<div class='body-shadow'></div>");
        $(".upload-img-box").show();
        img_val_index=$(".upload-img").index($(this));
    })
    $(".dialog").each(function () {
        var dialog = $(this);
        dialog.find(".close-btn a").click(function () {
            dialog.hide();
            $(".body-shadow").detach();
        })
    })

    $("#buttonUpload").click(function(){
        ajaxFileUpload();
        $(".upload-img-box").hide();
        $(".body-shadow").detach();
    });
    function ajaxFileUpload()
    {
        $("#loading")
            .ajaxStart(function(){
                $(this).show();
            })
            .ajaxComplete(function(){
                $(this).hide();
            });

        $.ajaxFileUpload
        (
            {
                url:'?m=adminFans&a=uploadJqImage',
                secureuri:false,
                fileElementId:'fileToUpload',
                dataType: 'json',
                data:{name:'logan', id:'id'},
                success: function (data, status)
                {
                    if(typeof(data.error) != 'undefined')
                    {
                        if(data.error != '')
                        {
                            alert(data.error);
                        }else
                        {
//                            alert('file: ' + data.url);
                            $(".img-val").eq(img_val_index).val(data.url);
                        }
                    }
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )
        return false;
    }
});
</script>
</body>
</html>
