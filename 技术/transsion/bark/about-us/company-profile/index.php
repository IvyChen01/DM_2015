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
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="/style/js/jquery-2.1.0.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include("../../inc/head.php")?>
    <div class="main">
        <div class="content">
            <div class="position"><a href="mol-pos">About us</a> > <span class="cur-pos">Company profile</span></div>
            <div class="page-title">Company profile</div>
        </div>
        <div class="banner"><img src="/images/company_profile_banner.jpg" alt=""/></div>
        <div class="content">
            <div class="column-intro-2 clearfix">
                <div class="left-section">
                    <p>
                        <strong>TECNO GROUP LIMITED</strong>, established in July 2006, is a high-tech company specializing
                        in the R&D, production, sale and service of mobile communication products. After
                        years of development, TECNO GROUP has become an important part of the mobile phone
                        industry and one of the major mobile phone manufacturers in the world. Currently,
                        it has full ownership of two famous mobile phone brands TECNO, itel and an after-sales
                        service brand Carlcare.
                    </p>
                    <p>
                        The company has set up offices in many countries and regions, such as Dubai, Nigeria, Kenya, Tanzania,
                        Cameroon and Bengal, and even has built a factory in Ethiopia, which has provided great support for all its brands.
                    </p>
                </div>
                <div class="right-section">
                    <p>
                        In recent years, TECNO GROUP has grown rapidly in research and development, design, production, sales
                        and aftersales service, etc. and achieved great economic strength. And with the great support of all
                        its partners, including Qualcomm, MediaTek, Facebook, Opera, MTN, Airtel, Etisalat, Safaricom and
                        Gameloft, etc., all its brands have enlarged their market share, increased sales volume and enhanced
                        market position continuously, because of which, TECNO GROUP has ascended to the top communication
                        companies in Africa. In 2013, it has gained an unprecedented achievement with the sales volume
                        of more than 37 million of all brands.
                    </p>
                    <p>
                        (Note: Because of the need of the business development, TECNO TELECOM LIMITED renamed to TECNO
                        GROUP LIMITED on August 21, 2013.)
                    </p>
                </div>
            </div>
            <div class="cur-sub-nav clearfix">
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="/images/contact_2.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">HISTORY</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="/images/contact_3.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">MISSON</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="/images/contact_4.jpg" alt=""/></a>
                    <a href="####" class="cnav-til">VISION</a>
                </div>
                <div class="cnav-item">
                    <a href="####" class="cnav-pic"><img src="/images/contact_5.jpg" alt=""/></a>
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
    <?php include("../../inc/footer.php")?>
</div>
</body>
</html>