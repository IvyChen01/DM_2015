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
        }

    });
    </script>

</head>

<body class="bg">
<div id="mwp">
<div id="mcontent">
<div class="user-infos">
    <span class="use-lv cur-lv"><strong>Your Group Level:</strong><em><?echo $_G[group][grouptitle];?></em></span>
    <span class="use-lv xicon" Xicon = "<?echo $_G[member][credits];?>"><strong>Your Level EXP:</strong><em><?echo $_G[member][credits];?></em></span>
</div>

<div class="all-group">
    <select  id="selectGroup">
        <option value="0">Jade Star</option>
        <option value="1">Sapphire Star</option>
        <option value="2">Golden Star</option>
        <option value="3">Jade Diamond</option>
        <option value="4">Sapphire Diamond</option>
        <option value="5">Golden Diamond</option>
        <option value="6">Crown</option>
    </select>
</div>
<div class="group-dets">
<div class="table-iron level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/1.png"></td>
            <td>LV1</td>
            <td>50</td>
            <td>6</td>
            <td>30</td>

        </tr>
        <tr>
            <td><img src="static/image/level/1/2.png"></td>
            <td>LV2</td>
            <td>200</td>
            <td>12</td>
            <td>60</td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/3.png"></td>
            <td>LV3</td>
            <td>500</td>
            <td>20</td>
            <td>120</td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/4.png"></td>
            <td>LV4</td>
            <td>800</td>
            <td>60</td>
            <td>180</td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/5.png"></td>
            <td>LV5</td>
            <td>1300</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/6.png"></td>
            <td>LV6</td>
            <td>2000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td
        </tr>
        <tr>
            <td><img src="static/image/level/1/7.png"></td>
            <td>LV7</td>
            <td>2500</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/8.png"></td>
            <td>LV8</td>
            <td>3000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/9.png"></td>
            <td>LV9</td>
            <td>3500</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/1/10.png"></td>
            <td>LV10</td>
            <td>4000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>
<div class="table-bronze level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/1.png"></td>
            <td>LV1</td>
            <td>4500</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/2.png"></td>
            <td>LV2</td>
            <td>5000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/3.png"></td>
            <td>LV3</td>
            <td>5500</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/4.png"></td>
            <td>LV4</td>
            <td>6000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/5.png"></td>
            <td>LV5</td>
            <td>6500</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/6.png"></td>
            <td>LV6</td>
            <td>7000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/7.png"></td>
            <td>LV7</td>
            <td>7500</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/8.png"></td>
            <td>LV8</td>
            <td>8000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/9.png"></td>
            <td>LV9</td>
            <td>9000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/2/10.png"></td>
            <td>LV10</td>
            <td>10000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>
<div class="table-silver level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/1.png"></td>
            <td>LV1</td>
            <td>11000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/2.png"></td>
            <td>LV2</td>
            <td>12000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/3.png"></td>
            <td>LV3</td>
            <td>13000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/4.png"></td>
            <td>LV4</td>
            <td>14000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/5.png"></td>
            <td>LV5</td>
            <td>15000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/6.png"></td>
            <td>LV6</td>
            <td>16000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/7.png"></td>
            <td>LV7</td>
            <td>17000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/8.png"></td>
            <td>LV8</td>
            <td>18000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/9.png"></td>
            <td>LV9</td>
            <td>19000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/3/10.png"></td>
            <td>LV10</td>
            <td>20000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>
<div class="table-gold level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/1.png"></td>
            <td>LV1</td>
            <td>21000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/2.png"></td>
            <td>LV2</td>
            <td>23000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/3.png"></td>
            <td>LV3</td>
            <td>25000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/4.png"></td>
            <td>LV4</td>
            <td>27000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/5.png"></td>
            <td>LV5</td>
            <td>29000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/6.png"></td>
            <td>LV6</td>
            <td>31000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/7.png"></td>
            <td>LV7</td>
            <td>35000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/8.png"></td>
            <td>LV8</td>
            <td>40000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/9.png"></td>
            <td>LV9</td>
            <td>45000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/4/10.png"></td>
            <td>LV10</td>
            <td>50000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>
<div class="table-platinum level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/1.png"></td>
            <td>LV1</td>
            <td>55000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/2.png"></td>
            <td>LV2</td>
            <td>60000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/3.png"></td>
            <td>LV3</td>
            <td>65000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/4.png"></td>
            <td>LV4</td>
            <td>70000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/5.png"></td>
            <td>LV5</td>
            <td>75000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/6.png"></td>
            <td>LV6</td>
            <td>80000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/7.png"></td>
            <td>LV7</td>
            <td>35000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/8.png"></td>
            <td>LV8</td>
            <td>85000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/9.png"></td>
            <td>LV9</td>
            <td>90000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/5/10.png"></td>
            <td>LV10</td>
            <td>100000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>
<div class="table-diamond level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/1.png"></td>
            <td>LV1</td>
            <td>120000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/2.png"></td>
            <td>LV2</td>
            <td>130000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/3.png"></td>
            <td>LV3</td>
            <td>140000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/4.png"></td>
            <td>LV4</td>
            <td>150000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/5.png"></td>
            <td>LV5</td>
            <td>250000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/6.png"></td>
            <td>LV6</td>
            <td>350000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/7.png"></td>
            <td>LV7</td>
            <td>450000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/8.png"></td>
            <td>LV8</td>
            <td>550000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/9.png"></td>
            <td>LV9</td>
            <td>650000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/6/10.png"></td>
            <td>LV10</td>
            <td>850000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>
<div class="table-diamond level-table">
    <table>
        <tr>
            <td>Level Icon</td>
            <td>User group level</td>
            <td>Level EXP<br>(Xcoin)</td>
            <td>Thread publish<br>
                (Posts/Hour)
            </td>
            <td>Comment/reply<br>
                (Comments/Hour)
            </td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/1.png"></td>
            <td>LV1</td>
            <td>900000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/2.png"></td>
            <td>LV2</td>
            <td>910000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/3.png"></td>
            <td>LV3</td>
            <td>920000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/4.png"></td>
            <td>LV4</td>
            <td>930000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/5.png"></td>
            <td>LV5</td>
            <td>940000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/6.png"></td>
            <td>LV6</td>
            <td>950000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/7.png"></td>
            <td>LV7</td>
            <td>960000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/8.png"></td>
            <td>LV8</td>
            <td>970000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/9.png"></td>
            <td>LV9</td>
            <td>980000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
        <tr>
            <td><img src="static/image/level/7/10.png"></td>
            <td>LV10</td>
            <td>1000000</td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
            <td><img alt="data_valid" src="static/image/common/data_valid.gif"></td>
        </tr>
    </table>
</div>

</div>
<script>
    $(function(){

        (function(){
            var group = ['Jade Star','Sapphire Star','Golden Star','Jade Diamond','Sapphire Diamond','Golden Diamond','Crown'];

            var curLv = $(".cur-lv em").text();

            for(var i=0;i<group.length;i++){
                if(curLv.toLowerCase().indexOf(group[i].toLowerCase()) > -1){
                    $("#selectGroup").val(i)
                    $(".level-table:not(:eq("+i+"))").css("display","none");
                    $(".level-table").eq(i).css("display","block").find("img").css({"display":"inline","visibility":"inherit"});
                    return
                }
            }
        })()


        $("#selectGroup").change(function(){
            var showIndex = $(this).val();
            $(".level-table:not(:eq("+showIndex+"))").css("display","none");
            $(".level-table").eq(showIndex).css("display","block");
        })
    })
</script>
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
                if(!e) e = window.event;//
                if((e.keyCode || e.which) == 13){
                    $("#scform_submit").click();
                }
            }
        })
    </script>
</form>
</div>



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
            <a href="forum.php?forumlist=1&amp;mobile=2" class="m_2"></a>
        </div>
        <div class="ttool_r">
            <!--<a href="javascript:void(0);" class="a_1 a_menu"></a>-->
            <div id="signin_menu" class="signin_menuv">
                <ul>
                    <li><a href="home.php?mod=space&amp;do=pm&amp;mobile=2">Message</a></li>
                    <li><a href="home.php?mod=space&amp;do=notice&amp;mobile=2">Notification</a></li>
                    <!--<li><a href="home.php?mod=medal&amp;mobile=2">null_201</a></li>-->
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


<div id="float-news" class="float-news" style="min-height: 614px;">
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
                <li class="li10 c1"><span></span><a href="home.php?mod=space&uid=<?=$_G[uid];?>&do=favorite&view=me&type=thread&mobile=2">My Favorite</a></li>
                <li class="li6 cl"><span></span><a href="home.php?mod=space&uid=<?=$_G[uid];?>&do=profile&mycenter=1&mobile=2">Setting</a></li>
                <!--<li class="li7 cl"><span></span><a href="search.php?mod=forum&mobile=2">search</a></li>-->
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

                <!--Mark    <li class="answerli" style="display:none;"><input name="answer" id="answer_" class="px p_fre" size="30" placeholder="Answer" type="text"></li>  -->
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

        <?}?>

    </div>
</div>

<script src="template/webshow_mtb0115/touch/img/js/expand.js" type="text/javascript"></script>
<script type="text/javascript">
</script>
<!--<div class="footer-copyright"></div>-->
</div>

<script>
	var totalH = document.body.scrollHeight;
        var mwpH = Number($("#mwp").css("height").slice(0, -2));
        var visibelH = document.body.offsetHeight;
        var menuH = Math.max(totalH, mwpH, visibelH);

        $("#float-news").css("height", menuH);
</script>

</body>
</html>
