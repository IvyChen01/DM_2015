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
                    <div class="qu-type-item">1. MRP(Material Requirement Planning物料需求计划)的主要用于保证物料的可用量，即它被用于为内部目的的以及销售和分销而采购或生产需求数量。这个过程包含监控库存，并自动建立相应的建议订单。</div>
                    <div class="qu-type-item">2. MRP运行之后会产生采购申请或计划订单。</div>
                    <div class="qu-type-item">3. 企业的物料需求计划、车间作业计划、采购计划等均来源于主生产计划，即先由主生产计划驱动物料需求计划，再由物料需求计划生成车间计划与采购计划，所以，主生产计划在ERP系统中启到承上启下的作用，实现从宏广到微观计划的过渡与连接 同时，主生产计划又是联系客房与企业销售部门的桥梁。</div>
                    <div class="qu-type-item">4. ERP系统包括以下主要功能：供应链管理、销售管理、分销、客户服务、财务管理、制造管理、库存管理、生产控制管理、人力资源、报表、制造执行系统(Manufacturing Executive System，MES)、工作流服务和企业信息系统等。此外，还包括金融投资管理、质量管理、运输管理、项目管理、法规与标准和过程控制等补充功能。</div>
                    <div class="qu-type-item">5. ERP是一个以管理会计为核心可以提供跨地区、跨部门、甚至跨公司整合实时信息的企业管理软件。针对物资资源管理（物流）、人力资源管理（人流）、财务资源管理（财流）、信息资源管理（信息流）集成一体化的企业管理软件。</div>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. 主生产计划（Master Production Schedule）。 由于主生产计划要驱动集优先级（物料）、能力与成本的计划与控制于一体的正式系统，它比生产计划要更加详细些。MPS有三种功能： 1、把企业计划同日常的作业计划联锁起来。2、为日常作业的管理提供一个“控制把手”。3、驱动正式的、一体化的计划与控制系统。</div>
                    <div class="qu-type-item">2. BOM(Bill of Material 物料清单)是计算机可以识别的产品结构数据文件，也是ERP的主导文件。BOM使系统识别产品结构，也是联系与沟通企业各项业务的纽带。ERP系统中的BOM的种类主要包括5类：缩排式BOM、汇总的BOM、反查用BOM、成本BOM、计划BOM。</div>
                    <div class="qu-type-item">3. 制造企业内部组织生产通常有两种方式：即按库存生产和按订单生产。</div>
                    <div class="qu-type-item">4. MRP在进行计算时，根据产品BOM主数据展开，计算并建议下阶物料的需求数量。</div>
                </div>
            </div>
            <div class="qu-type">
                <div class="qu-type-list">
                    <div class="qu-type-item">1. 1972年，从IBM公司跳槽出来的 4个年轻工程师创办了SAP公司。他们共同的目标就是生产销售统一商业标准软件。经过不懈的努力，这家德国公司已经成为用户/服务器商业应用领域世界领先的供应商。1988年，公司在法兰克福证券交易所上市。</div>
                    <div class="qu-type-item">2. 本次ERP实施范围，涉及的部门包括财务管理部、计划调度部、上游采购部、制造管理部、质量管理部。</div>
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