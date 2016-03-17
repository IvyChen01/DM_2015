<?php if (!defined('VIEW')) exit('Request Error!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>修改用户密码</title>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="style/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>
<body class="change-pwd-page">
<?php include("inc/head.php"); ?>
<div class="wrapper">
    <div class="main">
        <div id="admin_change_password">
            <span class="change-pwd-form-title">修改密码</span>
            <div class="change-form clearfix">
                <p class="cur-pwd">
                    <label for="curPwd">当前密码：</label>　　
                    <input type="password" name="src_password" id="src_password" onfocus="this.select()"/>
                </p>
                <p class="new-pwd">
                    <label for="newPwd">新密码：</label>　　
                    <input type="password" name="new_password" id="new_password" onfocus="this.select()"/>
                </p>
                <p class="submit-pwd">
                    <label for="submitPwd">确认新密码：</label>
                    <input type="password" name="confirm" id="confirm" onfocus="this.select()"/>
                </p>
            </div>
            <p class="change-pwd-bar">
                <a href="javascript:;" id="change">确认</a>
                <a href="/" class="quit-change">取消</a>
            </p>
        </div>
    </div>
</div>
<?php include("inc/footer.php"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#src_password").focus();
        $("#change").click(onClickChange);
        $(document).keydown(onDownWindow);
    });

    function onClickChange(e) {
        if ($("#confirm").val() == $("#new_password").val()) {
            $.post("?m=user&a=change_password", {src_password: $("#src_password").val(), new_password: $("#new_password").val()}, onChange);
        }
        else {
            alert("两次密码不一致！");
            $("#confirm").focus();
        }
    }

    function onChange(value) {
        var res = null;

        if (value.substr(0, 1) != "{") {
            alert("未知错误！");
            return;
        }

        res = $.parseJSON(value);
        switch (res.code) {
            case 0:
                alert(res.info);
                document.location.href = "?m=user";
                break;
            default:
                alert(res.info);
                $("#src_password").focus();
        }
    }

    function onDownWindow(e) {
        var currKey = 0, e = e || event;

        currKey = e.keyCode || e.which || e.charCode;
        switch (currKey) {
            case 13:
                //回车
                onClickChange(null);
                break;
            default:
        }
    }
</script>
</body>
</html>
