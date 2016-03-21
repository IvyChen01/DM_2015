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
                <a class="par-nav" href="?m=info&a=show_modify_index"><span>Main</span></a>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=11"><span >About</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=12" target="_self">Company Profile</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=13" target="_self">History</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=14" target="_self">Mission</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=15" target="_self">Vision</a></li>
					<li><a href="?m=info&a=show_modify_info&id=42" target="_self">Core Value</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=43" target="_self">Philosophy</a></li>
                    <li><a href="?m=news&a=manage" target="_self">Lastest News</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=21"><span >Brands</span></a>
                <div class="admin-subnav">
					<li><a href="?m=info&a=show_modify_info&id=22" target="_self">TECNO</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=23" target="_self">itel</a></li>
					<li><a href="?m=info&a=show_modify_info&id=27" target="_self">Infinix</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=24" target="_self">Carlcare</a></li>
					<li><a href="?m=info&a=show_modify_info&id=28" target="_self">iFLUX</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=25" target="_self">Business Segments</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=26" target="_self">Brand Protection</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=31"><span>Operating</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=32" target="_self">Research</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=33" target="_self">Supply Chain</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=34" target="_self">Apply Supplier</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=35" target="_self">Production</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=36" target="_self">Quality</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=37" target="_self">Marketing</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=38" target="_self">Customer</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=41"><span >Careers</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=44" target="_self">Life Abroad</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=46" target="_self">Career</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=47" target="_self">Our People</a></li>
					<li><a href="?m=info&a=show_modify_info&id=54" target="_self">Professional Training</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=48" target="_self">Pay and Benefits</a></li>
                    <li><a href="?m=job&a=manage&type=social" target="_self">Social Recruitment</a></li>
					<li><a href="?m=job&a=manage&type=campus" target="_self">Campus Recruitment</a></li>
					<li><a href="?m=job&a=manage&type=overseas" target="_self">Overseas recruitment</a></li>
                </div>
            </div>
            <div class="menu-item">
                <a class="par-nav" href="?m=info&a=show_modify_info&id=51"><span>Responsibility</span></a>
                <div class="admin-subnav">
                    <li><a href="?m=info&a=show_modify_info&id=52" target="_self">Local Support</a></li>
                    <li><a href="?m=info&a=show_modify_info&id=53" target="_self">Charity & Public Welfare</a></li>
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























