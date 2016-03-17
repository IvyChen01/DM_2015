<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-6-12
 * Time: 上午11:27
 */ ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href="style/master.css" rel="stylesheet">
    <script src="style/js/jquery-1.9.1.min.js"></script>
</head>
<body class="questions">
<?php include("inc/head.php");?>
<div class="wrapper">
    <div class="main">
        <div class="question-model-title">答案，在这里</div>
        <div class="qu-type-title clearfix">
            <ul>
                <li class="show"><a href="javascript:;">技术类</a></li>
                <li><a href="javascript:;">策略类</a></li>
                <li><a href="javascript:;">策略类</a></li>
                <li><a href="javascript:;">策略类</a></li>
            </ul>
            <script>$(".qu-type-title li").width(1100/$(".qu-type-title li").length);</script>
        </div>
        <div class="qu-type-content">
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. ERP的主要思想是？</div>
                    <div class="qu-type-item">2. 下面哪两种是制造企业最基本的生产特征？？</div>
                    <div class="qu-type-item">3. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">4. 物料主数据一般归属于哪个模块？</div>
                    <div class="qu-type-item">5. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">6. 物料主数据一般归属于哪个模块？</div>
                </div>
                <div class="qu-page-turn">
                    <a href="javascript:;">1</a>
                    <a href="javascript:;">2</a>
                    <a href="javascript:;" class="cur">3</a>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. ERP的主要思想是？</div>
                    <div class="qu-type-item">2. 下面哪两种是制造企业最基本的生产特征？？</div>
                    <div class="qu-type-item">3. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">4. 物料主数据一般归属于哪个模块？</div>
                    <div class="qu-type-item">5. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">6. 物料主数据一般归属于哪个模块？</div>
                </div>
                <div class="qu-page-turn">
                    <a href="javascript:;" class="cur">1</a>
                    <a href="javascript:;">2</a>
                    <a href="javascript:;">3</a>
                    <a href="javascript:;">4</a>
                    ……
                    <a href="javascript:;">8</a>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. ERP的主要思想是？</div>
                    <div class="qu-type-item">2. 下面哪两种是制造企业最基本的生产特征？？</div>
                    <div class="qu-type-item">3. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">4. 物料主数据一般归属于哪个模块？</div>
                    <div class="qu-type-item">5. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">6. 物料主数据一般归属于哪个模块？</div>
                </div>
                <div class="qu-page-turn">
                    <a href="javascript:;">1</a>
                    <a href="javascript:;" class="cur">2</a>
                    <a href="javascript:;">3</a>
                    <a href="javascript:;">4</a>
                    ……
                    <a href="javascript:;">7</a>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. ERP的主要思想是？</div>
                    <div class="qu-type-item">2. 下面哪两种是制造企业最基本的生产特征？？</div>
                    <div class="qu-type-item">3. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">4. 物料主数据一般归属于哪个模块？</div>
                    <div class="qu-type-item">5. ERP集成性的主要优点是什么？</div>
                    <div class="qu-type-item">6. 物料主数据一般归属于哪个模块？</div>
                </div>
                <div class="qu-page-turn">
                    <a href="javascript:;">1</a>
                    <a href="javascript:;">2</a>
                    <a href="javascript:;" class="cur">3</a>
                    <a href="javascript:;">4</a>
                    ……
                    <a href="javascript:;">10</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("inc/footer.php");?>
<script src="style/js/questions.js"></script>
</body>
</html>