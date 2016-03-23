<?php
session_start();
require_once('forgotPwd/scode2.php');
$action = isset($_GET['a']) ? $_GET['a'] : '';
switch ($action)
{
    case 'verify':
        Image::buildImageVerify(48, 22, NULL, 'verify');
        exit(0);
    default:

}


if(isset($_POST['forUserName'])) {
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    $src_code = isset($_SESSION['verify']) ? $_SESSION['verify'] : '';
    if ($code == $src_code)
    {
        define('CURSCRIPT', 'test');
        require './source/class/class_core.php';//引入系统核心文件
        $discuz = & discuz_core::instance();//以下代码为创建及初始化对象
        $discuz->init();
        require './source/function/function_mail.php';
        $test_to = 'zuxiong.luo@transsion.com';
        $title = 'Find Password';
        $test_from = $_POST['forEmail'];
        $message = '<br>User Infos:<br>userName:'.$_POST['forUserName'].'<br>email:'.$_POST['forEmail']."<br>Message:".$_POST['resionGet'];
        $succeed = sendmail($test_to, $title.' @ '.$date, $_G['setting']['bbname']."\n\n\n$message", $test_from);
        if($succeed){
            echo "<script>alert('apply success');</script>";
        }
    }
    else
    {
        echo '<script>alert("Wrong verification code, please try again.")</script>';
    }


}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Cache-control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no" />
    <meta name="keywords" content="" />
    <meta name="description" content=",X'Club" />
    <meta http-equiv="Page-Exit" content="RevealTrans (Duration=3, Transition=23)">
    <title> X'Club</title>
    <link rel="stylesheet" href="static/image/mobile/style.css" type="text/css" media="all">
    <script src="static/js/mobile/jquery-1.8.3.min.js?Bcq" type="text/javascript"></script>

    <script type="text/javascript">var STYLEID = '2', STATICURL = 'static/', IMGDIR = 'static/image/common', VERHASH = 'Bcq', charset = 'gbk', discuz_uid = '0', cookiepre = '8ReE_2132_', cookiedomain = '', cookiepath = '/', showusercard = '1', attackevasive = '0', disallowfloat = 'newthread', creditnotice = '1|Reputation|,2|Points|,3|Contribution|', defaultstyle = '', REPORTURL = 'aHR0cDovL2xvY2FsaG9zdDo1MDMyL21lbWJlci5waHA/bW9kPXJlZ2lzdGVyJm1vYmlsZT0y', SITEURL = 'http://localhost:5032/', JSPATH = 'static/js/';</script>

    <link rel="stylesheet" href="template/webshow_mtb0115/touch/img/css/base.css?Bcq" type="text/css">

    <script>
    function includeLinkStyle(url) {
                var link = document.createElement("link");
                link.rel = "stylesheet";
                link.type = "text/css";
                link.href = url;
                document.getElementsByTagName("head")[0].appendChild(link);
        }
    $(document).ready(function(){
        var isOperaMini = Object.prototype.toString.call(window.operamini) === "[object OperaMini]";
        if( isOperaMini == true ){
            $('.opera_menu').css("display","block");
            $('.login_si .p_frec').css("width","90px");
            $('.sel_list').attr('class','opera_sel_list');
            $('.login-btn-inner').css('display','none');
            $('.login_select').css('min-height','30px');
            $('.answerli').css('display', 'block');
            $('.questionli').removeClass('bl_none');
	    $("div.m_txt:not(:has('*'))").css({"padding-top":"10px",});
        }
        else{
           $(document).on('change', '.sel_list', function() {
           var obj = $(this);
           $('.span_question').text(obj.find('option:selected').text());
           if(obj.val() == 0) {
                $('.answerli').css('display', 'none');
                $('.questionli').addClass('bl_none');
           } else {
                $('.answerli').css('display', 'block');
                $('.questionli').removeClass('bl_none');
           }
        });
//        formdialog.init();
        }

    });
    </script>
</head>

<body class="bg"><div id="mwp">
    <div id="mcontent">
        <div class="t_blank cl"></div><!-- registerbox start -->
        <div class="loginbox registerbox">
            <div class="logo-box">
                <a href="forum.php?mod=forumdisplay&amp;fid=2&amp;mobile=2"><img src="template/webshow_mtb0115/touch/img/logo_regester.png" alt=""/></a>
            </div>
            <div class="login_from">
                <form method="post" autocomplete="off" name="register" id="registerform" action="">
                    <ul>
                        <li><input type="text" tabindex="1" class="px p_fre for-userName" size="25" autocomplete="off" name="forUserName" value="Username" fwin="login" onfocus="if(this.value==defaultValue) {this.value='';}" onblur="if(!value) {value=defaultValue; ;}"></li>
                        <li class="bl_none"><input type="text" tabindex="4" class="px p_fre for-email" size="25" autocomplete="off"  name="forEmail" value="Email Address" fwin="login" onfocus="if(this.value==defaultValue) {this.value='';}" onblur="if(!value) {value=defaultValue; ;}"></li>
                        <!--Mark <li class="resion-get"><textarea name="resionGet" id="" rows="3"></textarea></li> -->
                    </ul>
                    <div class="sec_code vm" style="clear: both">
                        <img src="forgotpwd.mobile.php?a=verify" class="forgot-pwd-img"/>
                        <input type="text" name="code" class="forgot-pwd-code"/><br/>
                        <a href="javascript:;" class="refresh-iden-code" style="display: inline-block;margin-top: 10px;width:44px;margin-left: 0">Refresh</a>
                    </div>
                    <script type="text/javascript">
                        (function() {
                            $('.seccodeimg').on('click', function() {
                                $('#seccodeverify_SCSjq').attr('value', '');
                                var tmprandom = 'S' + Math.floor(Math.random() * 1000);
                                $('.sechash').attr('value', tmprandom);
                                $(this).attr('src', 'misc.php?mod=seccode&update=13447&idhash='+ tmprandom +'&mobile=2');
                            });
                            $(".refresh-iden-code").click(function(){
                                $('.seccodeimg').click();
                            })
                        })();
                    </script>
            </div>
            <div class="btn_register"><button tabindex="7" value="true" name="regsubmit" type="submit" class="formdialog pn pnc"><span>Submit</span></button></div>
            </form>
        </div>
        <!-- registerbox end -->
        <div id="mask" style="display:none;"></div>
    </div>
    <div class="b_blank"></div>
    <div id="ttoolbar">
        <div class="ttool cl">
            <div class="m_txt">
                Forgot Password
            </div>
            <div class="ttool_l">
                <a onclick="javascript:history.back(-1);" class="m_2"></a>
            </div>
            <div class="ttool_r">
                <div id="signin_menu" class="">
                    <ul>
                        <li><a href="member.php?mod=logging&amp;action=login&amp;mobile=2">null_101</a></li>
                        <li><a href="member.php?mod=register&amp;mobile=2">null_102</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div id="float-news" class="float-news">
        <div class="nv_c cl">
            <a class="float-close" href="javascript:void(0);">X</a>

            <div class="login_s">
                <form id="loginform" method="post" action="member.php?mod=logging&amp;action=login&amp;loginsubmit=yes&amp;loginhash=&amp;mobile=2" onsubmit="" >
                    <input type="hidden" name="formhash" id="formhash" value='f70e4eca' />
                    <input type="hidden" name="referer" id="referer" value="forum.php" />
                    <input type="hidden" name="fastloginfield" value="username">
                    <input type="hidden" name="cookietime" value="2592000">

                    <div class="login_si">
                        <div class="login-u-pic">
                            <div class="logins_ava"><img src="/uc_server/avatar.php?uid={$_G[uid]}&size=middle" /></div>
                        </div>
                        <div class="login-right-box clearfix">
                            <ul>
                                <li class="lic lic1">
                                    <input type="text" tabindex="1" class="p_frec p_frec1" size="30" autocomplete="off" value="username" name="username" fwin="login" onfocus="if(this.value==defaultValue) {this.value='';this.style.color = '#000'} " onblur="if(!value) {value=defaultValue; this.type='text';this.style.color ='#c6c2c1'}">
                                </li>
                                <li class="lic lic2">
                                    <input type="text" tabindex="2" class="p_frec p_frec2" size="30" value="password" name="password" fwin="login" onfocus="if(this.value==defaultValue) {this.value='';this.type='password';this.style.color = '#000'}" onblur="if(!value) {value=defaultValue; this.type='text';this.style.color ='#c6c2c1'}">
                                </li>
                                <li class="answerli" style="display:none;"><input type="text" name="answer" id="answer_" class="px p_fre" size="30" placeholder="答案"></li>
                            </ul>
                            <script type="text/javascript">
                                (function() {
                                    $('.seccodeimg').on('click', function() {
                                        $('#seccodeverify_SabBe').attr('value', '');
                                        var tmprandom = 'S' + Math.floor(Math.random() * 1000);
                                        $('.sechash').attr('value', tmprandom);
                                        $(this).attr('src', 'misc.php?mod=seccode&update=68566&idhash='+ tmprandom +'&mobile=2');
                                    });
                                    $(".refresh-iden-code").click(function(){
                                        $('.seccodeimg').click();
                                    });
                                    $(".forgot-pwd-img").click(function(){
                                        $(".forgot-pwd-img").attr("src","forgotpwd.mobile.php?a=verify&rm="+Math.random());
                                    })
                                    $('.refresh-iden-code').click(function(){
                                        $(".forgot-pwd-img").attr("src","forgotpwd.mobile.php?a=verify&rm="+Math.random());
                                    })
                                })();
                            </script>
                            <div class="btn_login"><button tabindex="3" value="true" name="submit" type="submit"><span>Login</span></button></div>

                        </div>
                    </div>
                </form>
                <p class="reg_link"><a href="member.php?mod=register&amp;mobile=2">Register</a></p>
                <p class="forget-pwd-mobile">
                    <a href="forgotpwd.mobile.php" >Forget password ?</a>
                </p>
            </div>
            <!-- userinfo end -->

            <script type="text/javascript">

            </script>
        </div>
    </div>


    <script src="template/webshow_mtb0115/touch/img/js/expand.js" type="text/javascript"></script>
    <script>
        $(function(){
            $(".btn_register button").click(function(){
                if($('.for-userName').val() == 'Username' || $('.for-email').val() == 'Email Address'){
                    alert('The user name and email cannot be empty!');
                    return false;
                }
                else if(!/^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/.test($('.for-email').val())){
                    alert('Please enter a valid email address!');
                    return false;
                }
            })

        })
    </script>

<!--Mark    <div class="footer-copyright"></div> -->
</body>
</html>
