<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- bootstrap - css -->
    <link href="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/themes/css/bootstrap.min.css" rel="stylesheet">
    <!-- core - css -->
    <link href="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/themes/css/style.css" rel="stylesheet">
    <link href="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/themes/purple/core.css" id="bjui-link-theme" rel="stylesheet">
    <!-- plug - css -->
    <link href="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
    <link href="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
    <!--[if lte IE 7]>
    <link href="/Static/Plugins/BJUI/themes/css/ie7.css" rel="stylesheet">
    <![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lte IE 9]>
        <script src="/Static/Plugins/BJUI/other/html5shiv.min.js"></script>
        <script src="/Static/Plugins/BJUI/other/respond.min.js"></script>
    <![endif]-->
    <!-- jquery -->
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/js/jquery-1.7.2.min.js"></script>
    <!-- 以下是B-JUI的分模块未压缩版，建议开发调试阶段使用下面的版本 -->
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/js/bjui-core.js"></script>
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/js/bjui-regional.zh-CN.js"></script>
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/js/bjui-frag.js"></script>
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/js/bjui-alertmsg.js"></script>
    <!-- nice validate -->
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/plugins/niceValidator/jquery.validator.js"></script>
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/plugins/niceValidator/jquery.validator.themes.js"></script>
    <!-- bootstrap plugins -->
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/plugins/bootstrap.min.js"></script>
    <script src="<?php echo C('WEB_ROOT');?>/Static/Plugins/jquery/plugins/jquery.form.js"></script>
    <script src="/Public/Js/functions.js"></script>
    <style type="text/css">
    /* 修复bootstrap样式被style.css覆盖问题开始 */
    .panel-default {
        border-color: #ddd;
    }
    .panel-default>.panel-heading {
        border-color: #ddd;
    }
    .form-group {
        margin-bottom: 15px;
    }
    /* 修复bootstrap样式被style.css覆盖问题结束 */
    .container {
        overflow: hidden;
        -webkit-animation: bounceIn 600ms linear;
        -moz-animation: bounceIn 600ms linear;
        -o-animation: bounceIn 600ms linear;
        animation: bounceIn 600ms linear;
    }
    /*登录框动画*/
    
    @-webkit-keyframes bounceIn {
        0% {
            opacity: 0;
            -webkit-transform: scale(.3);
        }
        50% {
            opacity: 1;
            -webkit-transform: scale(1.05);
        }
        70% {
            -webkit-transform: scale(.9);
        }
        100% {
            -webkit-transform: scale(1);
        }
    }
    @-moz-keyframes bounceIn {
        0% {
            opacity: 0;
            -moz-transform: scale(.3);
        }
        50% {
            opacity: 1;
            -moz-transform: scale(1.05);
        }
        70% {
            -moz-transform: scale(.9);
        }
        100% {
            -moz-transform: scale(1);
        }
    }
    @-o-keyframes bounceIn {
        0% {
            opacity: 0;
            -o-transform: scale(.3);
        }
        50% {
            opacity: 1;
            -o-transform: scale(1.05);
        }
        70% {
            -o-transform: scale(.9);
        }
        100% {
            -o-transform: scale(1);
        }
    }
    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
        70% {
            transform: scale(.9);
        }
        100% {
            transform: scale(1);
        }
    }
    </style>
    <title>登录 - <?php echo C('siteName');?></title>
</head>

<body style="padding-top: 200px;">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <?php echo C('siteName');?>
                        </h2>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i>
                                </span>
                                <input class="form-control input-nm" name="username" id="username" type="email" placeholder="帐号" autofocus>
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i>
                                </span>
                                <input class="form-control input-nm" name="pwd" id="pwd" type="password" placeholder="密码">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i>
                                </span>
                                <input class="form-control input-nm" name="verify_code" id="verify_code" type="text" placeholder="验证码">
                            </div>
                            <div class="form-group">
                                <img id="code_img" src="<?php echo U('Public/verify_code');?>" title="看不清？单击此处刷新" onclick="javascript:refresh()" style="cursor: pointer; vertical-align: middle;" /> <a class="arefresh" href="#">看不清？单击此处刷新</a>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">记住我
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="button" class="btn btn-lg btn-success btn-block submitForm">登 陆</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("form").keydown(function(e){
            var e = e || event,
            keycode = e.which || e.keyCode;
            if (keycode==13) {
                $(".submitForm").trigger("click");
            }
        });

        function refresh() {
            $('#code_img').attr('src', "<?php echo U('verify_code?&rand=');?>" + Math.random());
        }

        $(function() {
            $('#verify_code').focus(function() {
                $('#code_img').trigger("click");
            });
            $('.arefresh').click(function() {
                $('#code_img').trigger("click");
            })
        });

        $(function() {
            $(".submitForm").click(function() {
                if ($("#username").val() == '' || $("#pwd").val() == '' || $("#verify_code").val() == '') {
                    //popup.alert("填写完整后方可登陆");
                    $(this).alertmsg('error', "填写完整后方可登陆");
                    return false;
                }
                ajaxSubmit();
            });
            $(".findPwd").click(function() {
                $("#op_type").val("2");
                if ($("#email").val() == '') {
                    $(this).alertmsg('error', "填写了你的邮箱方可找回密码");
                    return false;
                }
                if ($("#verify_code").val() == '') {
                    $(this).alertmsg('error', "请写验证码方可找回密码");
                    return false;
                }
                ajaxSubmit();
            });
        });
    </script>
</body>

</html>