<?

define('CURSCRIPT', 'test');
require './source/class/class_core.php';//引入系统核心文件
$discuz = & discuz_core::instance();//以下代码为创建及初始化对象
$discuz->init();

include DISCUZ_ROOT.'source/language/'.DISCUZ_LANG.'/lang_template.php';
$_G['lang'] = array_merge($_G['lang'], $lang);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Cache-control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no" />
    <meta name="keywords" content="zero" />
    <meta name="description" content="zero ,X'Club" />
    <meta http-equiv="Page-Exit" content="RevealTrans (Duration=3, Transition=23)">
    <title>X'Club</title>
    <link rel="stylesheet" href="static/image/mobile/style.css" type="text/css" media="all">
    <script src="static/js/mobile/jquery-1.8.3.min.js?eKb" type="text/javascript"></script>

    <script type="text/javascript">var STYLEID = '2', STATICURL = 'static/', IMGDIR = 'static/image/common', VERHASH = 'eKb', charset = 'gbk', discuz_uid = '4', cookiepre = '8ReE_2132_', cookiedomain = '', cookiepath = '/', showusercard = '1', attackevasive = '0', disallowfloat = 'newthread', creditnotice = '1|Reputation|,2|Points|,3|Contribution|', defaultstyle = '', REPORTURL = 'aHR0cDovL2xvY2FsaG9zdDo1MDMyL2ZvcnVtLnBocD9tb2Q9Zm9ydW1kaXNwbGF5JmZpZD0yJm1vYmlsZT0y', SITEURL = 'http://localhost:5032/', JSPATH = 'static/js/';</script>

    <!--    <script src="static/js/mobile/common.js?eKb" type="text/javascript" charset="gbk"></script>-->
    <link rel="stylesheet" href="template/webshow_mtb0115/touch/img/css/base.css?eKb" type="text/css">
	

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
        formdialog.init();
        }

    });
    </script>



</head>

<body class="bg main">
<style type="text/css">
.main{height:512px!important;}
.touch-logo{margin-top:40px;padding-top:40px;text-align:center}
.touch-logo p{font-size:22px;margin-top:20px;color:#aaa;}
.index-ms-nav{text-align:center;margin-top:40px;}
.index-ms-nav a{display:block;width:200px;line-height:45px;border:2px solid #90C31F;border-radius:15px;margin:0 auto 20px;color:#90C31F;font-size:26px;text-align:center}
.touch-ms-footer{background:#F5F5F5;padding:20px 0;text-align:center;margin-top:60px;color:#aaa;}
.touch-ms-footer a{padding:0 20px;font-size:16px;color:#aaa;}
.touch-ms-footer span{margin-top:15px;display:inline-block;font-size:16px;color:#aaa;}
.touch-money-main{margin-top:60px;color: #444;
  margin-bottom: 100px;
padding:0 5px;
    font: 12px/1.5 Verdana,Tahoma,Helvetica,Arial,sans-serif;}
 .dt{border-top: 1px solid #cdcdcd;width: 100%;}
 .dt th{font-weight:700}
 .dt td, .dt th {
    border-bottom: 1px solid #cdcdcd;
    padding: 7px 4px;
	font-size:12px;
}
.alt, .alt th, .alt td {
    background-color: #f2f2f2;
}
.tbmu{margin:20px 0}
#mcontent, #ttoolbar,#float-news{transition:all 400ms}
</style>
<div id="mwp">
<div id="mcontent">
	<div class="touch-money-main">
	<div class="tbmu bw0">
<p>If the following actions occure, you will get reward points. However, in a cycle, the number of awards you get is limited.</p>
</div>
		<table cellspacing="0" cellpadding="0" class="dt valt">
<tbody><tr>
<th class="xw1">Action name</th>
<th class="xw1">Cycle range</th>
<th class="xw1">Xgold</th>

</tr><tr>
<td>Collection followed</td>
<td>Daily</td>
<td>+1</td>
</tr>
<tr class="alt">
<td>Comment Article</td>
<td>Daily</td>
<td>+1</td>
</tr>
<tr>
<td>Get comment</td>
<td>Daily</td>
<td>+2</td>
</tr>
<tr class="alt">
<td>Write Comment</td>
<td>Daily</td>
<td>+1</td>
</tr>
<tr>
<td>Create Share</td>
<td>Daily</td>
<td>+1</td>
</tr>
<tr class="alt">
<td>Poll Vote</td>
<td>Daily</td>
<td>+1</td>
</tr>
<tr>
<td>Greeting</td>
<td>Daily</td>
<td>+1</td>
</tr>
<tr class="alt">
<td>Visit other space</td>
<td>Daily</td>
<td>+2</td>
</tr>
<tr>
<td>Daily login</td>
<td>Daily</td>
<td>+2</td>
</tr>
<tr class="alt">
<td>Video verification</td>
<td>Once</td>
<td>+10</td>
</tr>
<tr>
<td>Upload avatar</td>
<td>Once</td>
<td>+5</td>
</tr>
<tr class="alt">
<td>E-mail verification</td>
<td>Once</td>
<td>+10</td>
</tr>
<tr>
<td>Register by Promotion</td>
<td>Unlimited cycle</td>
<td>+2</td>
</tr>
<tr class="alt">
<td>Visit Promotion</td>
<td>Unlimited cycle</td>
<td>+1</td>
</tr>
<tr>
<td>Add Digest</td>
<td>Unlimited cycle</td>
<td>+5</td>
</tr>
<tr class="alt">
<td>Reply post</td>
<td>Unlimited cycle</td>
<td>+1</td>
</tr>
<tr>
<td>Publish post</td>
<td>Unlimited cycle</td>
<td>+2</td>
</tr>
</tbody></table>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="template/webshow_mtb0115/touch/img/css/forumdisplay_list.css" id="JCSS" media="all" />
<script src="template/webshow_mtb0115/touch/img/js/jquery.cookie.js" type="text/javascript" type="text/javascript"></script>

<style>
    .btool .li2.current2 { background-position: center 0!important;}
    .btool .li2.current2 a { color:#8A98AA!important;}
    .btool .li4.current4 { background-position: center -80px!important;}
    .btool .li4.current4 a { color:#1A8FF2!important;}
    #searchform{display:none;position:absolute;top:53px;width:100%;background:#fff;left:0;box-shadow:0 3px 5px rgba(0, 0, 0, 0.2)}
    .search{padding:5px;margin-bottom:15px;}
    .mfmlist2{margin-top:70px;}
</style>

<form id="searchform" class="searchform" method="post" autocomplete="off" action="search.php?mod=forum&amp;mobile=2">
    <input type="hidden" name="formhash" value="76b7cadb" />

    <div class="search">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td>
                    <input value="" autocomplete="off" class="input" name="srchtxt" id="scform_srchtxt"  value="Searching" onblur="if(!value) {value=defaultValue; this.type='text';}" onfocus="if(this.value==defaultValue) {this.value='';}">
                </td>
                <td width='66' style="padding-right: 13px;">
                    <div ><input type="hidden" name="searchsubmit" value="yes"><input type="submit" value="Go" class="button2" id="scform_submit"></div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            document.onkeydown = function(e){
                if(!e) e = window.event;
                if((e.keyCode || e.which) == 13){
                    $("#scform_submit").click();
                }
            }
        })
    </script>
</form>




<script type="text/javascript">
    $('.favorite').on('click', function() {
        var obj = $(this);
        $.ajax({
            type:'POST',
            url:obj.attr('href') + '&handlekey=favorite&inajax=1',
            data:{'favoritesubmit':'true', 'formhash':'76b7cadb'},
            dataType:'xml',
        })
                .success(function(s) {
                    popup.open(s.lastChild.firstChild.nodeValue);
                    evalscript(s.lastChild.firstChild.nodeValue);
                })
                .error(function() {
                    window.location.href = obj.attr('href');
                    popup.close();
                });
        return false;
    });

    $(function(){
        var setSkin = function(){
            $('#JCSS').attr('href',$('.mskin a').eq($.cookie('CK_EQ')).attr('rel'));
            $('.mskin a').eq($.cookie('CK_EQ')).addClass('seleted').siblings('a').removeClass('seleted');
        };
        $('.mskin a').click(function(){
            $.cookie('CK_EQ', $(this).index(), {expires:7, path: '/' });
            setSkin();
        });
        setSkin();
    });
</script>
<div id="mask" style="display:none;"></div>
<div class="b_blank"></div>

<div id="ttoolbar">
    <div class="ttool cl">   
<div class="ttool_l">
                        <a class="m_2" href="javascript:history.back();"></a>
         
                    </div>	
        <div class="ttool_r">
            <!--<a href="javascript:void(0);" class="a_1 a_menu"></a>-->
            <div id="signin_menu" class="signin_menuv">
                <ul>
                    <li><a href="home.php?mod=space&amp;do=pm&amp;mobile=2">Message</a></li>
                    <li><a href="home.php?mod=space&amp;do=notice&amp;mobile=2">Notification</a></li>
                    <li><a href="misc.php?mod=tag&amp;mobile=2">Tags</a></li>
                    <li><a href="group.php?mod=my&amp;mobile=2">My Group</a></li>
                    <li><a href="forum.php?mod=group&amp;action=create&amp;mobile=2">Create New Group</a>

                    <li><a href="home.php?mod=space&amp;uid={$_G[uid]}&amp;do=profile&amp;mycenter=1&amp;mobile=2">Profile Edit</a></li>
                    <li><a href="member.php?mod=logging&amp;action=logout&amp;formhash=76b7cadb&amp;mobile=2">Sign Out</a></li>

                </ul>
            </div>
            <div id="float-open" class="float-open">
		<a class="open-btn" href="javascript:void(0);">
		    <?if ($_G[member][newpm] || $_G[member][newprompt]){?>
			<em class="new">
			<?if ($_G[member][newprompt]){?>
			<?=$_G[member][newprompt];}?>
			</em>
			<?}?>
		    <img src="template/webshow_mtb0115/touch/img/m_nav_2.png" class="opera_menu" style="display: none;width: 85%;margin-top: 20%;margin-left: 10%;">
		</a>
	    </div>
        </div>
    </div>
</div>
<div id="float-news" class="float-news" style="height:780px;">
    <div class="nv_c cl">
        <a class="float-close" href="javascript:void(0);">X</a>
        <? if($_G[uid]){?>
        <div class="umenu">
            <div class="login-u-pic">
                <div class="umenu_ava">
                    <a href="space_avatar.php?uid=<?= $_G[uid];?>"><?echo avatar($_G[uid],small)?></a>
                </div>
            </div>
            <p class="label-user-name"><?= $_G['username'];?></p>
            <ul>
                <li class="li0 cl"><span></span><a href="forum.php?mobile=2">Home</a></li>
                <li class="li1 cl"><span></span><a href="touch.money.php" >Xgold <em style="display:block"><? echo getuserprofile('extcredits'.$_G['setting']['creditstrans']);?></em></a></li>
                <li class="li2 cl"><span></span><a href="usergroup.mobile.php">Xpoint<em style="display:inline;margin-left:5px;"><? echo $_G[member][credits];?><br/> <?=$_G[group][grouptitle];?></em></a></li>
                <li class="li3 cl"><span></span><a href="home.php?mod=space&uid=<?=$_G[uid];?>&do=profile&mobile=2">Profile</a></li>
                <li class="li4 cl"><span></span><a href="home.php?mod=space&do=pm&mobile=2">Message<!--{if $_G[member][newpm]--}<em>(new)</em></a><!--{/if}--></a></li>
                <li class="li8 cl"><span></span><a href="home.php?mod=space&do=notice&mobile=2">Notification</a></li>
                <li class="li5 cl"><span></span><a href="home.php?mod=space&uid=<?=$_G[uid];?>&do=thread&type=thread&mobile=2">My Thread</a></li>
                <li class="li10 c1"><span></span><a href="home.php?mod=space&uid=<?=$_G[uid];?>&do=favorite&view=me&type=thread&amp;mobile=2">My Favorite</a></li>
                <li class="li6 cl"><span></span><a href="home.php?mod=space&uid=<?=$_G[uid];?>&do=profile&mycenter=1&mobile=2">Setting</a></li>
                <!--<li class="li7 cl"><span></span><a href="search.php?mod=forum&amp;mobile=2">search</a></li>-->
		<li class="li11 cl"><span></span><a href="home.php?mod=space&do=friend&mobile=2">Friend</a></li>
                <li class="li9 cl"><span></span><a href="member.php?mod=logging&action=logout&formhash=<?=FORMHASH?>">Sign Out</a></li>
            </ul>
        </div>
        <?}else{?>
        <form id="loginform" method="post" action="member.php?mod=logging&amp;action=login&amp;loginsubmit=yes&amp;loginhash=&amp;mobile=2" onsubmit="">
            <input name="formhash" id="formhash" value="d61e151c" type="hidden">
            <input name="referer" id="referer" value="forum.php" type="hidden">
            <input name="fastloginfield" value="username" type="hidden">
            <input name="cookietime" value="2592000" type="hidden">
            <div class="login_si">
                <div class="login-u-pic">
                    <div class="logins_ava"><img style="display: inline; visibility: visible;" zsrc="uc_server/avatar.php?uid=0&amp;size=middle" src="uc_server/avatar.php?uid=0&amp;size=middle"></div>
                </div>
              <div class="login-right-box clearfix">
			    <ul>
                    <li class="lic lic1">
                        <input tabindex="1" class="p_frec p_frec1" size="30" autocomplete="off" value="username" name="username" fwin="login" onfocus="if(this.value==defaultValue) {this.value='';this.style.color = '#000'} " onblur="if(!value) {value=defaultValue; this.type='text';this.style.color ='#c6c2c1'}" type="text">
                    </li>
                    <li class="lic lic2">
                        <input tabindex="2" class="p_frec p_frec2" size="30" value="password" name="password" fwin="login" onfocus="if(this.value==defaultValue) {this.value='';this.type='password';this.style.color = '#000'}" onblur="if(!value) {value=defaultValue; this.type='text';this.style.color ='#c6c2c1'}" type="text">
                    </li>

		    <!--{if empty($_GET['auth']) || $questionexist}-->
					<li class="lic questionli">
						<span class="opera_menu" style="display:none;font: 14px/1.5 Microsoft YaHei, Helvetica, sans-serif;float: left;width: 66px;color: #4DB74D;height: 40px;line-height: 40px;">security</span>
						<div class="login_select p_frec">
							<span class="login-btn-inner">
									<span class="login-btn-text">
											<span class="span_question"><?=$_G['lang']['security_question'];?></span>
									</span>
									<span class="icon-arrow">&nbsp;</span>
							</span>
							<select id="questionid_{$loginhash}" name="questionid" class="sel_list">
									<option value="0" selected="selected"><?=$_G['lang']['security_question'];?></option>
									<option value="1"><?=$_G['lang']['security_question_1'];?></option>
									<option value="2"><?=$_G['lang']['security_question_2'];?></option>
									<option value="3"><?=$_G['lang']['security_question_3'];?></option>
									<option value="4"><?=$_G['lang']['security_question_4'];?></option>
									<option value="5"><?=$_G['lang']['security_question_5'];?></option>
									<option value="6"><?=$_G['lang']['security_question_6'];?></option>
									<option value="7"><?=$_G['lang']['security_question_7'];?></option>
							</select>
						</div>
					</li>
					<li class="lic answerli" style="display:none;">
						<span class="opera_menu" style="display:none;font: 14px/1.5 Microsoft YaHei, Helvetica, sans-serif;float: left;width: 66px;color: #4DB74D;height: 40px;line-height: 40px;">answer</span>
						<input type="text" name="answer" id="answer_{$loginhash}" class="px p_frec p_frec2" size="25" placeholder="answer">
					</li>
			<!--{/if}-->

                    <!--Mark <li class="answerli" style="display:none;"><input name="answer" id="answer_" class="px p_fre" size="30" placeholder="Answer" type="text"></li> -->
                </ul>
				<div class="btn_login"><button tabindex="3" value="true" name="submit" type="submit"><span>Login</span></button></div>
			  </div>
                <script type="text/javascript">
                    (function() {
                        $('.seccodeimg').on('click', function() {
                            $('#seccodeverify_SIITt').attr('value', '');
                            var tmprandom = 'S' + Math.floor(Math.random() * 1000);
                            $('.sechash').attr('value', tmprandom);
                            $(this).attr('src', 'misc.php?mod=seccode&update=42298&idhash='+ tmprandom +'&mobile=2');
                        });
                        $(".refresh-iden-code").click(function(){
                            $('.seccodeimg').click();
                        })
                    })();
                </script>

            </div>
            
        </form>
        <p class="reg_link"><a href="member.php?mod=register&amp;mobile=2">Register</a></p>
		<p class="forget-pwd-mobile">
        <a href="member.php?mod=logging&action=login&viewlostpw=1&mobile=1">Forget password ?</a>
		</p>

        <?}?>

    </div>
</div>
     

<script src="template/webshow_mtb0115/touch/img/js/expand.js" type="text/javascript"></script>
<script type="text/javascript">
</script>
<!--<div class="footer-copyright"></div>-->
</div>

<script>
	var totalH = document.body.scrollHeight + document.body.scrollTop;
        var mwpH = Number($("#mwp").css("height").slice(0, -2));
        var visibelH = document.body.offsetHeight;
	var menuH = Math.max(totalH, mwpH, visibelH);

        $("#float-news").css("height", menuH);
</script>

</body>
</html>
