<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-6-12
 * Time: 上午11:27
 */
$pageId=2;
?>
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
                <li class="show"><a href="javascript:;">系统知识</a></li>
                <li><a href="javascript:;">模块知识</a></li>
                <li><a href="javascript:;">项目宣传</a></li>
            </ul>
            <script>$(".qu-type-title li").width(1100/$(".qu-type-title li").length);</script>
        </div>
        <div class="qu-type-content">
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. 根据ASAP实施方法论，ERP系统实施主要采用全面实施的方式，有时会根据企业规模及具体资源情况采取分步实施或分片全面实施的方式。</div>
                    <div class="qu-type-item">2. 当很多小的重复交易建立了长期合同，就需要一个特殊的合同机制涵盖这种关系和单个交易的需求，这被称为框架协议（Outline Agreement）。</div>
                    <div class="qu-type-item">3. 主生产计划用于确定公司打算要做什么，作为组织备料、生产、排程的数据源头和主要依据。</div>
                    <div class="qu-type-item">4. 未完成的客户订单是指已经收到但尚未向客户发货的客户订单。</div>
                    <div class="qu-type-item">5. 企业实施ERP的实质，是充分运用现代信息技术，在企业管理的深度和广度上实现物流、信息流、资金流的三流合一。</div>
                    <div class="qu-type-item">6. 供应商主数据的主要包含供应商基本信息及采购、财务相关信息。</div>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. SD销售与分销模块(Sales and Distribution)，其中包括销售计划、询价报价、订单管理、运输发货、发票等的管理，同时可对分销网络进行有效的管理。</div>
                    <div class="qu-type-item">2. MM物料管理模块(Material Management)，主要有采购、库房与库存管理、MRP、供应商评价等管理功能。</div>
                    <div class="qu-type-item">3. PP生产计划模块(Production Planning)，可实现对工厂数据、生产计划、MRP、能力计划、成本核算等的管理，使得企业能够有效的降低库存，提高效率。同时各个原本分散的生产流程的自动连接，也使得生产流程能够前后连贯的进行，而不会出现生产脱节，耽误生产交货时间。</div>
                    <div class="qu-type-item">4. FI财务会计模块(Financial Accounting)，它可提供应收、应付、总账、合并、投资、基金、现金管理等功能，这些功能可以根据各分支机构的需要来进行调整，并且往往是多语种的。同时，科目的设置会遵循任何一个特定国家中的有关规定。</div>
                    <div class="qu-type-item">5. CO管理会计模块(Controlling)，它包括利润及成本中心、产品成本、项目会计、获利分析等功能，它不仅可以控制成本，还可以控制公司的目标，另外还提供信息以帮助高级管理人员作出决策或制定规划。</div>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. 传音ERP项目宣传的主标题是开启你的ERP模式，积攒你的RP ；有了ERP,妈妈再也不用担心我加班了，副标题是实施ERP系统，打造传音一体化信息平台。</div>
					<div></div>
                    <div class="qu-type-item">2.ERP漫画故事<br>
                        <img src="/style/images/cartoon.jpg" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("inc/footer.php");?>
<script src="style/js/questions.js"></script>
</body>
</html>