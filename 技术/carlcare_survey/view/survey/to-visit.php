<?php if(!defined('VIEW')) exit(0);?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>index--carlcare</title>
    <link rel="stylesheet" href="style/css/master.css"/>
</head>
<body class="page to-visit-page">
<div class="header">
    <div class="container">
        <a href="/">
            <img src="images/logo.png" alt="carlcare"/>
        </a>
        <div class="header-right">
            <? if($_level == 1 || $_level == 2){?>
            <div class="data-cx">
                <a href="javascript:;"><span></span>DATA IMPORT</a>
            </div>
            <?}?>
            <? if($_level == 1){?>
            <div class="data-vx ">
                <a href="javascript:;"><span></span>DATA EXPORT</a>
            </div>
            <?}?>
            <div class="user-dx">
                <a href="/?m=user&a=logout">Sign up</a>
            </div>
        </div>
    </div>
</div>
<div class="body">
    <div class="container">
        <div class="pl-tl">Customer List</div>
        <div class="sls-cot">
            <div class="country-box">
                <div class="imf-lt co-df-ul lt-ctc">
                    <a href="javascript:;" class="co-ul-selected"><span>Country</span><i></i></a>
                    <ul>
                        <li><a href="javascript:;">Country</a></li>
                    </ul>
                </div>
            </div>
            <div class="date-box">
                <div class="imf-lt co-df-ul lt-cts">
                    <a href="javascript:;" class="co-ul-selected"><span>——</span><i></i></a>
                    <ul>
                    </ul>
                </div>
                <span class="til til-year">Year</span>

                <div class="imf-lt co-df-ul lt-ctm">
                    <a href="javascript:;" class="co-ul-selected"><span>——</span><i></i></a>
                    <ul>
                        <li><a href="javascript:;">——</a></li>
                        <li><a href="javascript:;">1</a></li>
                        <li><a href="javascript:;">2</a></li>
                        <li><a href="javascript:;">3</a></li>
                        <li><a href="javascript:;">4</a></li>
                        <li><a href="javascript:;">5</a></li>
                        <li><a href="javascript:;">6</a></li>
                        <li><a href="javascript:;">7</a></li>
                        <li><a href="javascript:;">8</a></li>
                        <li><a href="javascript:;">08</a></li>
                        <li><a href="javascript:;">9</a></li>
                        <li><a href="javascript:;">10</a></li>
                        <li><a href="javascript:;">11</a></li>
                        <li><a href="javascript:;">12</a></li>
                    </ul>
                </div>
                <span class="til">Month</span>
                <div class=" imf-lt imf-week co-df-ul">
                    <a href="javascript:;" class="co-ul-selected"><span>——</span><i></i></a>
                    <ul>
                        <li><a href="javascript:;">——</a></li>
                        <li><a href="javascript:;">The first week</a></li>
                        <li><a href="javascript:;">The second week</a></li>
                        <li><a href="javascript:;">The third week</a></li>
                        <li><a href="javascript:;">The fourth week</a></li>
                        <li><a href="javascript:;">The fifth week</a></li>
                    </ul>
                </div>
            </div>
            Successful visit:<span class="suc-cots"></span>
            Waiting List: <span class="dnt-cots"></span>
            Not Accessible: <span class="dnc-cots"></span>
        </div>
        <div class="bk-dts">
            <div class="bk-sts">
                <a href="/" class="su-sts ">Successful  visit
                    <i class="b-l"></i>
                    <i class="b-2"></i>
                </a>
                <a href="javascript:;" class="nt-sts active">Waiting List
                    <i class="b-l"></i>
                    <i class="b-2"></i>
                </a>
                <a href="?m=survey&a=failvisit" class="dt-sts"> Not Accessible
                    <i class="b-l"></i>
                    <i class="b-2"></i>

                </a>
            </div>
            <div class="bk-brs">
                <div class="bk-mt">
                    <table>
                        <thead>
                        <tr>
                            <th style="width: 20%"><span>Serial Number</span></th>
                            <th style="width: 17%"><span>Customer</span></th>
                            <th style="width: 17%"><span>COUNTYR</span></th>
                            <th style="width: 23%"><span>REMAINING NUMBER</span></th>
                            <th style="width: 23%"><span>TO VISIT</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr>
                        <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine disabled" href="javascript:;">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine disabled" href="javascript:;">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine" href="visit.html">VISIT</a></td>
                        </tr> <tr>
                            <td><span class="cus-number">LF1252616</span></td>
                            <td><span class="cus-name">ABBAS EFE</span></td>
                            <td><span class="cus-country">NG</span></td>
                            <td><span class="cus-explain">2</span></td>
                            <td><a class="cus-examine disabled" href="javascript:;">VISIT</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pagination clearfix">
                    <a href="javascript:;" class="pre">
                        <
                    </a>
                    <div class="pg-bx">
                        <a href="javascript:" class="pg-nm">5</a>
                        <a href="javascript:" class="pg-nm">06</a>
                        <a href="javascript:" class="pg-nm">08</a>
                        <a href="javascript:" class="pg-nm">09</a>
                        <a href="javascript:" class="pg-nm cur">10</a>
                        <a href="javascript:" class="pg-nm">11</a>
                        <a href="javascript:" class="pg-nm">12</a>
                        <a href="javascript:" class="pg-nm">13</a>
                        <a href="javascript:" class="pg-nm">14</a>
                        <a href="javascript:" class="pg-nm">15</a>
                    </div>
                    <a href="javascript:;" class="next">
                        >
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dialog imf-dialog">
    <div class="content">
        <div class="close-dialog"><a href="javascript:;">X</a></div>
        <div class="imf-time clearfix">
            <div class="imf-year co-df-ul">
                <a href="javascript:;" class="co-ul-selected"><span>2015</span><i></i></a>
                <ul>
                    <li><a href="javascript:;">2015</a></li>
                    <li><a href="javascript:;">2016</a></li>
                    <li><a href="javascript:;">2017</a></li>
                    <li><a href="javascript:;">2018</a></li>
                </ul>
            </div>
            <div class="imf-month co-df-ul">
                <a href="javascript:;" class="co-ul-selected"><span>06</span><i></i></a>
                <ul>
                    <li><a href="javascript:;">1</a></li>
                    <li><a href="javascript:;">2</a></li>
                    <li><a href="javascript:;">3</a></li>
                    <li><a href="javascript:;">4</a></li>
                    <li><a href="javascript:;">5</a></li>
                    <li><a href="javascript:;">6</a></li>
                    <li><a href="javascript:;">7</a></li>
                    <li><a href="javascript:;">8</a></li>
                    <li><a href="javascript:;">9</a></li>
                    <li><a href="javascript:;">10</a></li>
                    <li><a href="javascript:;">11</a></li>
                    <li><a href="javascript:;">12</a></li>
                </ul>
            </div>
            <div class="co-df-ul data-import-week">
                <a href="javascript:;" class="co-ul-selected"><span>The first week</span><i></i></a>
                <ul>
                    <li><a href="javascript:;">The first week</a></li>
                    <li><a href="javascript:;">The second week</a></li>
                    <li><a href="javascript:;">The third week</a></li>
                    <li><a href="javascript:;">The fourth week</a></li>
                    <li><a href="javascript:;">The fifth week</a></li>
                </ul>
            </div>
        </div>
        <div class="bow-fs clearfix">
            <input type="text" class="fs-pas"/>
            <div class="bow-cot">
                <a href="javascript:;" class="bow-link">BROWSE</a>
                <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
            </div>
        </div>
        <div class="st-cot">
            <a href="javascript:;" class="st-fs data-file-upload">DETERMINE</a>
            <a href="javascript:;" class="st-qt">CANCEL</a>
        </div>
    </div>

</div>
<div class="dialog imr-dialog">
    <div class="content">
        <div class="close-dialog"><a href="javascript:;">X</a></div>

        <div class="imf-time clearfix">
            <div class="imf-year co-df-ul">
                <a href="javascript:;" class="co-ul-selected"><span>——</span><i></i></a>
                <ul>
                    <li><a href="javascript:;">2015</a></li>
                    <li><a href="javascript:;">2016</a></li>
                    <li><a href="javascript:;">2017</a></li>
                    <li><a href="javascript:;">2018</a></li>
                </ul>
            </div>
            <div class="imf-month co-df-ul">
                <a href="javascript:;" class="co-ul-selected"><span>——</span><i></i></a>
                <ul>
                    <li><a href="javascript:;">1</a></li>
                    <li><a href="javascript:;">2</a></li>
                    <li><a href="javascript:;">3</a></li>
                    <li><a href="javascript:;">4</a></li>
                    <li><a href="javascript:;">5</a></li>
                    <li><a href="javascript:;">6</a></li>
                    <li><a href="javascript:;">7</a></li>
                    <li><a href="javascript:;">8</a></li>
                    <li><a href="javascript:;">9</a></li>
                    <li><a href="javascript:;">10</a></li>
                    <li><a href="javascript:;">11</a></li>
                    <li><a href="javascript:;">12</a></li>
                </ul>
            </div>
            <div class="co-df-ul data-import-week">
                <a href="javascript:;" class="co-ul-selected"><span>——</span><i></i></a>
                <ul>
                    <li><a href="javascript:;">The first week</a></li>
                    <li><a href="javascript:;">The second week</a></li>
                    <li><a href="javascript:;">The third week</a></li>
                    <li><a href="javascript:;">The fourth week</a></li>
                    <li><a href="javascript:;">The fifth week</a></li>
                </ul>
            </div>
            <div class="rp-dc">
                <a href="javascript:;">OK</a>
            </div>
        </div>

    </div>

</div>
<div id="ajaxUploadFileLoading" class="ajax-upload-shadow"><img src="/style/images/loading.gif" alt=""/></div>
<div class="footer">
    <div class="container">
        <p>
            Copyright © 2010 - 2015 Themes Kingdom. All Rights Reserved.<br>
            2CheckOut.com Inc. (Ohio, USA) is an authorized retailer for goods and services provided by Themes Kingdom.
        </p>
    </div>
</div>
<script src="style/js/jquery-1.8.2.min.js"></script>
<script src="style/js/ajaxfileupload.js"></script>
<script src="style/js/jquery.cookie.js"></script>
<script src="style/js/index.js"></script>
<script src="style/js/common.list.js"></script>
</body>
</html>