<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-4-17
 * Time: 上午11:21
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../style/master.css"/>
    <script src="../style/js/jquery-2.1.0.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include("../inc/head.php")?>
    <div class="main">
        <div class="content">
            <div class="position"><span class="cur-pos">About Us</span></div>
            <div class="page-title">About Us</div>
        </div>
        <div class="banner"><img src="../images/aboutUs_banner.jpg" alt=""/></div>
        <div class="content">
            <div class="column-intro">
                <p>A high-tech company specializing in the R&D, production, sale and service of mobile communication products</p>
                <p>A leading mobile supplier to Africa</p>
                <p>An important part of the mobile phone industry</p>
                <p>One of the major mobile phone manufacturers in the world</p>
                <p>(Note: Because of the need of the business development, the company renamed to TECNO GROUP LIMITED on August 21, 2013.).</p>
            </div>
            <div class="contact-method">
                <div class="contact-til">MEDIA CONTACTS</div>
                <div class="contact-list">
                    <ul>
                        <li><span class="con-li-icon"></span>86-755-33979200</li>
                        <li><span class="con-li-icon"></span>86-755-33979211</li>
                        <li><span class="con-li-icon"></span>cosimo.lu@tecnotelecom.com</li>
                    </ul>
                </div>
                <div class="hk-office office-addr">
                    <span class="addr-til">Hong Kong Office: </span>
                    <p class="addr-til-det">
                        Unit 710, 7/F, Century Center, 44-46 Hung To
                        Road, Kwun Tong, Kowloon, Hong Kong
                    </p>
                </div>
                <div class="sz-office office-addr">
                    <span class="addr-til"> Shen Zhen Office:</span>
                    <p class="addr-til-det">
                        17th Floor, Desay building, No. 9789 Shennan
                        Road, Hi-Tech Park, Nanshan District,
                        Shenzhen, China
                    </p>
                </div>
            </div>
            <div class="cur-sub-nav clearfix">
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="../images/contact_1.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">COMPANY PROFILE</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="../images/contact_2.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">HISTORY</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="../images/contact_3.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">MISSON</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="../images/contact_4.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">VISION</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="../images/contact_5.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">LATEST NEWS</a>
                </div>
            </div>
            <script>
                $(function(){
                    $(".cnav-item").mouseover(function(){$(this).addClass("hover")}).mouseleave(function(){$(this).removeClass("hover")})
                })
            </script>
        </div>
    </div>
    <?php include("../inc/footer.php")?>
</div>
</body>
</html>