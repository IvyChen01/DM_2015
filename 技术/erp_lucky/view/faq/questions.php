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
                    <div class="qu-type-item">1. ERP——Enterprise Resource Planning 企业资源计划系统，是指在信息技术基础上，以系统化的管理思想，为企业决策层及员工提供决策运行手段的管理平台。ERP系统集中信息技术与先进的管理思想於一身，成为现代企业的运行模式，反映时代对企业合理调配资源，最大化地创造社会财富的要求，成为企业在信息时代生存、发展的基石。</div>
                    <div class="qu-type-item">2. SAP是ERP软件的一种.Systems ,Application,and Products in Data processing，即数据处理中的系统、应用和产品。 </div>
                    <div class="qu-type-item">3. 制造资源计划 Manufacturing Resource Planning （MRPII），它是对制造业企业的生产资源进行有效计划的一整套生产经营管理计划体系，是一种计划主导型的管理模式。MRPII是闭环MRP的直接延伸和扩充。</div>
                    <div class="qu-type-item">4. ERP项目实施要素由时间、成本、质量三方面构成，但最关键的因素是项目实施投入的人。</div>
                    <div class="qu-type-item">5. ERP集成性的最主要优点是数据的来源唯一，避免了重复输入和人为误差，并可以由授权人员共享。</div>
                    <div class="qu-type-item">6. 通过实施ERP系统，可实现成本控制与精确计算、准确分析产品盈利情况、加快市场反应速度的目的，但产品结构不会因此而发生改变。</div>
					<div class="qu-type-item">7. ERP系统实施战略中最常用的方法是面向模块的实施战略。</div>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. PLM(product lifecycle management产品生命周期管理)是一种应用于在单一地点的企业内部、分散在多个地点的企业内部，以及在产品研发领域具有协作关系的企业之间的，支持产品全生命周期的信息的创建、管理、分发和应用的一系列应用解决方案，它能够集成与产品相关的人力资源、产品生命周期管理、产品生命周期管理、流程、应用系统和信息。</div>
                    <div class="qu-type-item">2. SRM是供应商关系管理(Supplier Relationship Management)的英文缩写，供应商关系管理(SRM)系统的目标在于构建一个协同的共享信息平台，打通供应链脉络，使来自神经末梢的信号可以快速传递到神经中枢，从而使整个供应链系统可以随需而变。</div>
                    <div class="qu-type-item">3. CRM系统即客户关系管理系统(Customer Relationship Management)，以客户为中心的现代企业，以客户价值来判定市场需求，对于正在转变战略从"产品中心" 向 "客户中心" 过渡的企业无疑是一拍即合。</div>
                    <div class="qu-type-item">4. DRP(Distribution Resource Planning分销资源计划)是基于IT技术和预测技术对不确定的顾客需求进行预测分析以规划确定配送中心的存货、生产、派送等能力的计划系统。通过DRP系统可以实现成本、库存、产能、作业等的良好控制，从而达到顾客完全满意。</div>
                    <div class="qu-type-item">5. MRP(Material Requirement Planning物料需求计划)的主要用于保证物料的可用量，即它被用于为内部目的的以及销售和分销而采购或生产需求数量。这个过程包含监控库存，并自动建立相应的建议订单。</div>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. 传音ERP实施外部顾问公司是德硕管理咨询股份有限公司。</div>
                    <div class="qu-type-item">2. 传音ERP项目宗旨：<br />
高举项目航标，以愿景理念指导蓝图规划；<br />
关注战略重点，以关键战略实现整体联动；<br />
立足长远发展，以全局视角打造一体平台；<br />
夯实流程基石，以流程优化推进业务变革；<br />
勇于共同承诺，以切身力行展现自我价值；<br />
紧密沟通协作，以团队凝聚升华传音力量。</div>
                    <div class="qu-type-item">3.ERP漫画故事<br>
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