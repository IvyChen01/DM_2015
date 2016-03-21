<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-4-24
 * Time: 下午4:59
 */
?>
<div id="admin_header">
    <div class="content clearfix">
        <div class="admin-logo"><a href="?m=info&a=show_modify_index"><img src="/manager/images/admin_logo.png" alt=""/></a></div>
        <div class="admin-menu">
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_index"><span>首页</span></a>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=11"><span >关于我们</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=12" target="_self">企业简介</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=13" target="_self">发展历程</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=14" target="_self">公司使命</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=15" target="_self">发展愿景</a></li>
					<li><a href="?m=info&a=show_modify_info&id=42" target="_self">核心价值观</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=43" target="_self">经营理念</a></li>
                    <li><a href="?m=news&a=manage" target="_self">最新消息</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=21"><span >品牌管理</span></a>
                <div class="admin-subnav">
					<li><a href="?m=info&a=show_modify_info&id=22" target="_self">TECNO</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=23" target="_self">itel</a></li>
					<li><a href="?m=info&a=show_modify_info&id=27" target="_self">Infinix</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=24" target="_self">Carlcare</a></li>
					<li><a href="?m=info&a=show_modify_info&id=28" target="_self">iFLUX</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=25" target="_self">业务区域</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=26" target="_self">品牌保护</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=31"><span>运营体系</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=32" target="_self">研究开发</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=33" target="_self">供应链管理</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=34" target="_self">成为供应商</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=35" target="_self">生产制造</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=36" target="_self">质量体系</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=37" target="_self">市场营销</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=38" target="_self">客户服务</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=41"><span >加入传音</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=44" target="_self">海外生活</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=46" target="_self">职业发展</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=47" target="_self">员工风采</a></li>
					<li><a href="?m=info&a=show_modify_info&id=54" target="_self">人才培养</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=48" target="_self">薪资福利</a></li>
                    <li><a href="?m=job&a=manage&type=social" target="_self">社会招聘</a></li>
					<li><a href="?m=job&a=manage&type=campus" target="_self">校园招聘</a></li>
					<li><a href="?m=job&a=manage&type=overseas" target="_self">海外招聘</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=51"><span>社会责任</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=52" target="_self">本地支持</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=53" target="_self">慈善公益</a></li>
                </div>
            </div>
        </div>
        <div class="lang">
        <?php if ($_language_user == 'cn') { ?>
        	<a class="cur" href="?m=admin&a=change_language&language=en">EN</a>/<a href="?m=admin&a=change_language&language=en">中</a>
		<?php } else { ?>
			<a href="?m=admin&a=change_language&language=cn">EN</a>/<a class="cur" href="?m=admin&a=change_language&language=cn">中</a>
		<?php } ?>
        </div>
    </div>
</div>
<div class="bon-line"></div>
<script>
    $(function(){
        <?php echo "var tag_1=".$_tag1.";tag_2=".$_tag2.";";?>
        tag_2=tag_2==1?undefined:tag_2-2;
        $(".menu-item").eq(tag_1).children(".par-nav").addClass("cur");
        $(".menu-item").eq(tag_1).find(".admin-subnav li").eq(tag_2).addClass("cur-nav");
        $(".admin-subnav li").bind({
            mouseover:function(){
                $(".admin-subnav li").removeClass("cur-nav");
                $(this).addClass("cur-nav");
            },
            mouseleave:function(){
                $(".admin-subnav li").removeClass("cur-nav");
                $(".menu-item").eq(tag_1).find(".admin-subnav li").eq(tag_2).addClass("cur-nav");
            }
        })
        $(".menu-item").bind({
            mouseover:function(){
                $(".par-nav").removeClass("cur");
                $(this).children(".par-nav").addClass("cur");
                $(".admin-subnav").stop().hide();
                $(this).children(".admin-subnav").fadeIn();
            },
            mouseleave:function(){
                $(this).children(".admin-subnav").fadeOut();
                $(".menu-item").children(".par-nav").removeClass("cur");
                $(".menu-item").eq(tag_1).children(".par-nav").addClass("cur");
            }
        })
    })
</script>























