<?php
/**
 * 导入题库
 */
class InstallFaq
{
	private $db = null;//数据库
	private $tb_faq = '';//题目表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_faq = Config::$tb_faq;
	}
	
	public function install()
	{
		//54
		$this->db->connect();
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('ERP的中英文全称是什么？', 'A:Enterprise Resource Planning   企业资源计划', 'B:Execute Resource Planning  执行资源计划', 'C:Execute Requirement Planning 执行需求计划', 'D:Executive Requirement Planning 执行需求计划', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('SAP的中英文全称是什么？', 'A:Systems Applications Products in Data Processing 数据处理中的系统、应用和产品', 'B:Support Applications Products in Date Processing数据处理中的支持、应用和产品', 'C:Support Applications Program in Date Processing数据处理中的支持、应用和程序', 'D:Systems Applications Program in Date Processing数据处理中的系统、应用和程序', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('MRPII的中英文全称是什么？', 'A:Material Requirement Planning  物料需求计划', 'B:Manufacturing Resource Planning  制造资源计划', 'C:Material Requirement Planning II 物料需求计划II', 'D:Manufacturing Resource PlanningII  制造资源计划II', '2', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('实施ERP的最关键因素是什么？', 'A:系统', 'B:公司业务模式', 'C:人', 'D:公司产品结构', '3', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('ERP集成性的最主要优点是什么？', 'A:数据的来源唯一，避免了重复输入和人为误差，并可以由授权人员共享', 'B:减少工作量', 'C:加强了财务部门与业务部门之间的沟通', 'D：减少了数据量', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('以下哪项不是实施ERP可能获得的效益？', 'A:成本控制与精确计算', 'B:改变产品结构', 'C:准确分析产品盈利情况', 'D:加快市场反应速度', '2', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('ERP系统实施战略中最常用的方法是？', 'A:面向对象的实施战略', 'B:面向模块的实施战略', 'C:Big Bang实施战列', 'D:面向流程的实施战略', '2', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('PLM的中英文全称是什么？', 'A:Product Lifecycle Management   产品生命周期管理', 'B:Project Lifecycle Management   项目生命周期管理', 'C:Project Lifecycle Manager      项目生命周期经理', 'D:Product Lifecycle Manager      产品生命周期经理', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('SRM的中英文全称是什么？', 'A:Supplier Relationship Management  供应商关系管理', 'B:Supply Relationship Management  供应关系管理', 'C:Supplier Requirement Management  供应商需求管理', 'D:Supply Requirement  Management   供应需求管理', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('CRM的中英文全称是什么？', 'A:Customer Requirement Management 客户需求管理', 'B:Customer Relationship Management  客户关系管理', 'C:Customer Requirement Manager 客户需求经理', 'D:Customer Relationship Manager  客户关系经理', '2', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('DRP的中英文全称是什么？', 'A:Distribution Resource Planning   分销管理系统', 'B:Distribution Requirement Planning 分销需求计划', 'C:Distribution Resource Production  分销资源产品', 'D:Distribution Requirement Production 分销需求产品', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('MRP的中英文全称是什么？', 'A:Material Requirement Planning   物料需求计划', 'B:Material Resource Planning  物料资源计划', 'C:Material Resource Production 物料资源产品', 'D:Material Requirement Production 物料需求产品', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('传音ERP实施外部顾问公司是哪家？', 'A:IBM管理咨询股份有限公司', 'B:德勤管理咨询股份有限公司', 'C:惠普管理咨询股份有限公司', 'D:德硕管理咨询股份有限公司', '4', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('传音ERP项目的六大宗旨包含？', 'A:好RP带来好运气，好ERP带来好效率', 'B:开启你的ERP模式，积攒你的RP', 'C:立足长远发展，以全局视角打造一体平台', 'D:实施ERP系统，打造传音一体化信息平台', '3', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，丈夫打电话给妻子，提出带同事回家吃饭的请求属于？', 'A:订货意向', 'B:商务沟通', 'C:订单确认', 'D:发出订单', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子询问丈夫有多少人、想吃什么菜属于？', 'A:订货意向', 'B:商务沟通', 'C:订单确认', 'D:发出订单', '2', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子爽快答应丈夫“没问题，我会准备好的”属于？', 'A:订货意向', 'B:商务沟通', 'C:订单确认', 'D:发出订单', '3', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，丈夫告知妻子人数、时间和菜品属于？', 'A:订货意向', 'B:商务沟通', 'C:订单确认', 'D:发出订单', '4', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子列出各种菜的所需材料以便安排晚饭属于？', 'A:BOM清单', 'B:库存不足', 'C:确定最佳批次与批量', 'D:瓶颈工艺', '1', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子发现冰箱里“只有2个鸡蛋”属于？', 'A:BOM清单', 'B:库存不足', 'C:确定最佳批次与批量', 'D:瓶颈工艺', '2', '1', '1')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('在实施ERP系统时，不应选择的策略是？', 'A:分步实施', 'B:分片全面实施', 'C:全面实施', 'D:各部门独立实施', '4', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('框架协议的英文全称是什么？', 'A:Outline Agreement', 'B:Contract', 'C:Schedule Agreement', 'D:Blanket PO', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('主生产计划用于？', 'A:确定公司打算要做什么', 'B:计划和控制在制品', 'C:计划原材料的采购数量和时间', 'D:计划相关需求的物料', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('什么是未完成的客户订单？', 'A:误期的客户订单', 'B:已经收到但尚未向客户发出回执的客户订单', 'C:已经收到但尚未向客户发货的客户订单', 'D:已经收到客户订单，但是对其承诺日期晚于客户需求日期', '3', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('企业实施ERP的实质，是充分运用现代信息技术，在企业管理的深度和广度上实现( )的三流合一？', 'A:物流、资金流、数据流', 'B:物流、信息流、资金流', 'C:数据流、信息流、资金流', 'D:成本流、物流、资金流', '2', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('供应商主数据的信息主要来自哪些部门？', 'A:采购、财务、质量', 'B:采购、财务', 'C:采购、财务、销售', 'D:采购、财务、生产、销售', '2', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('SD的中英文全称是什么？', 'A:Sell Distribution  销售分销', 'B:Sales and Distribution 销售分销', 'C:System Sales 系统销售', 'D:System Distribution 系统分销', '2', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('MM的中英文全称是什么？', 'A:Material Management   物料管理', 'B:Material Manager  物料经理', 'C:Main Material 主要物料', 'D:Master Material 主要物料', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('PP的中英文全称是什么？', 'A:Production Planning   生产计划模块', 'B:PrOduction Scheduling 生产制造计划', 'C:Products Planning  产品计划', 'D:Products Scheduling 产品制造计划', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('FI的中英文全称是什么？', 'A:Financial Accounting   财务会计', 'B:Finance Accounting  财务会计', 'C:Financial Accounting 金融会计', 'D:Finance Accounting 金融会计', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('CO的中英文全称是什么？', 'A:Controlling   控制或管理会计', 'B:Cost  成本会计', 'C:Cost of Products 产品成本', 'D:Controlling of Products 产品控制', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('传音ERP项目宣传的主标题是哪些？', 'A:好RP带来好运气，好ERP带来好效率', 'B:开启你的ERP模式，积攒你的RP ；有了ERP,妈妈再也不用担心我加班了', 'C:ERP来了，你准备好了吗？', 'D:不错的人品+互联网思维+大数据系统=ERP', '2', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('传音ERP项目宣传的副标题是什么？', 'A:高举项目航标，以愿景理念指导蓝图规划', 'B:实施ERP系统，打造传音一体化信息平台', 'C:关注战略重点，以关键战略实现整体联动', 'D:立足长远发展，以全局视角打造一体平台', '2', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子买鸡蛋时，发现有一个破了要求更换属于？', 'A:BOM清单', 'B:库存不足', 'C:确定最佳批次与批量', 'D:瓶颈工艺', '3', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子制作烤鸭遇到拔鸭毛困难的问题属于？', 'A:BOM清单', 'B:库存不足', 'C:确定最佳批次与批量', 'D:瓶颈工艺', '4', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子发现自己做烤鸭来不及，于是请别人做好按时送到家属于？', 'A:委外加工', 'B:加单', 'C:尝试拼单', 'D:紧急采购', '1', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，儿子也打电话回来请妈妈做饭跟同学聚会属于？', 'A:委外加工', 'B:加单', 'C:尝试拼单', 'D:紧急采购', '2', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妈妈问儿子愿不愿意跟爸爸的同事们一起吃属于？', 'A:委外加工', 'B:加单', 'C:尝试拼单', 'D:紧急采购', '3', '1', '2')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('物料需求计划(MRP)的主要功能是？', 'A、分配资源', 'B、销售产品', 'C、详细排产', 'D、监控库存，并自动建立相应的建议订单', '4', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('MRP运行之后会产生哪些获取建议（procurement proposal）？', 'A:采购申请', 'B:计划订单、生产订单', 'C:采购申请、采购订单', 'D:采购申请、计划订单', '4', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('ERP中制定采购计划有多种来源，其主要来源是？', 'A:报价单', 'B:请购单', 'C:主生产计划', 'D:询价单', '3', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('ERP的功能覆盖范围包括？', 'A:供应链管理', 'B:销售管理', 'C:财务管理', 'D:生产控制管理', '1,2,3,4', '2', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('ERP是一个以（  ）为核心可以提供跨地区、跨部门、甚至跨公司整合实时信息的企业管理软件？', 'A:管理会计', 'B:人事管理', 'C:物流管理', 'D:商务贸易', '1', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('MPS的中英文全称是什么？', 'A:Master Production Schedule   主生产计划', 'B:Main Production Schedule    主生产计划', 'C:Material Planning System    物料计划系统', 'D:Main Planning System        主计划系统', '1', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('BOM的中英文全称是什么？', 'A:Bill of Main Material 主物料清单', 'B:Benefit of Material 物料收益', 'C:Bill of Material   物料清单', 'D:Benefit of Main Material 主物料收益', '3', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('下面哪两种是制造企业最基本的生产特征？', 'A:按库存生产和按订单生产', 'B:按库存生产和按订单装配', 'C:按订单装配和按订单设计', 'D:按订单生产和按订单设计', '1', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('MRP在进行计算时，是根据以下哪项数据展开的？', 'A:产品工艺路线', 'B:工作中心数据', 'C:相关需求数据', 'D:BOM数据', '4', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('SAP系统是来自哪个国家的产品？', 'A:中国', 'B:中国台湾', 'C:德国', 'D:美国', '3', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('本次传音ERP实施，不包括哪个部门的业务？', 'A:计调部', 'B:财务管理部', 'C:人事部', 'D:制造管理部', '3', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妈妈在儿子的电话后发现鸡蛋又不够了，开始联系小贩送货到家属于？', 'A:委外加工', 'B:加单', 'C:尝试拼单', 'D:紧急采购', '4', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子打电话催问烤鸭什么时候能送到家属于？', 'A:委外催单', 'B:推单', 'C:设备更新', 'D:领导嘉奖', '1', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妈妈推掉儿子第二桌饭的请求属于？', 'A:委外催单', 'B:推单', 'C:设备更新', 'D:领导嘉奖', '2', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，妻子建议换个大一点的烤箱属于？', 'A:委外催单', 'B:推单', 'C:设备更新', 'D:领导嘉奖', '3', '1', '3')");
		$this->db->query("INSERT INTO $this->tb_faq (question, option1, option2, option3, option4, answer, question_type, month_type) VALUES ('漫画故事中，丈夫让妻子全权处理购买烤箱的事情属于？', 'A:委外催单', 'B:推单', 'C:设备更新', 'D:领导嘉奖', '4', '1', '3')");
	}
	
	public function fix_faq()
	{
		$this->db->connect();
		$this->db->query("update $this->tb_faq set option1='A:Distribution Resource Planning   分销资源计划' where id=11");
	}
}
?>
