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
    <title>
    <?php
    if ($_language_user == 'cn')
    {
        echo "校园招聘";
    }
    else
    {
        echo "Campus Recruitment";
    }
    ?>
    </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="/style/js/jquery-1.9.1.min.js"></script>
    <script src="/style/js/newsModel.js"></script>
<!--    <script src="/style/js/job.offers.js"></script>-->
</head>
<?php
if ($_language_user == 'cn')
{
    echo "<body class='cn page-campus'><div id='wrapper'>";
    include("inc/cn_head.php");
}
else
{
    echo "<body class='en page-campus'><div id='wrapper'>";
    include("inc/head.php");
}
?>
    <div class="main">
        <div class="content">
            <div class="position"><a href="<?php echo $_menu_info['main_link']; ?>"><?php echo $_menu_info['main_name']; ?></a> > <span class="cur-pos"><?php echo $_menu_info['sub_name']; ?></span></div>
            <div class="page-title"><?php echo $_menu_info['sub_name']; ?></div>
        </div>
        <?php if (!empty($_info['banner_image'])) { ?>
            <div class="banner"><img src="<?php echo $_info['banner_image']; ?>" alt=""/></div>
        <?php } ?>
        <div class="content clearfix">
            <div class="offers-category">
                <div class="cate-tli school-jobs-info">
                    <?php
                    if ($_language_user == 'cn')
                    {
                        echo "校招信息";
                    }
                    else
                    {
                        echo "CATEGORY";
                    }
                    ?>
                </div>
                <div class="cate-tli">
					<?php
					if ($_language_user == 'cn')
					{
						echo "招聘岗位";
					}
					else
					{
						echo "CATEGORY";
					}
					?>
					</div>

                <div class="offers-cate-list">
                	<?php
                	$_is_first = true;
                	foreach ($_jobtype as $_key => $_value)
                	{
                		$_is_empty = true;
                		foreach ($_job as $_job_key => $_job_value)
                		{
                			if ($_value == $_job_value['typename'])
                			{
                				$_is_empty = false;
                				break;
                			}
                			
                		}
                		if (!$_is_empty)
                		{
                			if ($_is_first)
	                		{
	                			$_is_first = false;
	                			echo '<div class="offers-cate-item"><em class="status"></em><a href="javascript:;" class="font-cate">' . $_value . '</a>
								      <div class="son-cate-box" >
	                			          <ul> ';
								$_is_first2 = true;
								foreach ($_job as $_job_key => $_job_value)
								{
									if ($_value == $_job_value['typename'])
									{
										if ($_is_first2)
										{
											$_is_first2 = false;
											echo '<li class="son-cur"><a href="javascript:;">' . $_job_value['title'] . '</a></li>';
										}
										else
										{
											echo '<li><a href="javascript:;">' . $_job_value['title'] . '</a></li>';
										}
									}
								}
								echo '</ul>
	                			      </div>
									  </div>' . "\r\n";
	                		}
	                		else
	                		{
	                			echo '<div class="offers-cate-item"><em class="status"></em><a href="javascript:;" class="font-cate">' . $_value . '</a>
	                			<div class="son-cate-box">
	                			          <ul> ';
								foreach ($_job as $_job_key => $_job_value)
								{
									if ($_value == $_job_value['typename'])
									{
										echo '<li><a href="javascript:;">' . $_job_value['title'] . '</a></li>';
									}
								}
								echo '</ul>
	                			</div>
	                			</div>' . "\r\n";
	                		}
                		}
                	}
                	?>
                </div>
                <div class="contact-our">
                <?php
                if ($_language_user == 'cn')
                {
                    echo "<p><span>联系方式：</span><br>
                          电话：0755-33979200<br>
                          邮箱：hr.hq@transsion.com";
                }
                else
                {
                    echo "<p><span>Contact Information：</span><br>
                          Tel：0755-33979200<br>
                          Email：hr.hq@transsion.com";
                }
                ?>
                </div>
            </div>
			<div class="join-details-for">
                <?php echo $_campus_homepage; ?>
            </div>
            <div class="offers-details">
                <div class="cate-det-list">
                	<?php
                	$_is_first = true;
					$_is_first2 = true;
                	foreach ($_jobtype as $_key => $_value)
                	{
                		$_is_empty = true;
                		foreach ($_job as $_job_key => $_job_value)
                		{
                			if ($_value == $_job_value['typename'])
                			{
                				$_is_empty = false;
                				break;
                			}
                			
                		}
                		if (!$_is_empty)
                		{
							if ($_is_first)
							{
								$_is_first = false;
								echo '<div class="cate-det-item ">' . "\r\n";
							}
							else
							{
								echo '<div class="cate-det-item">' . "\r\n";
							}
							
	                		foreach ($_job as $_job_key => $_job_value)
	                		{
	                			if ($_value == $_job_value['typename'])
	                			{
									if ($_is_first2)
									{
										$_is_first2 = false;
										echo '<div class="cate-det-item-sub sub-cur">' . "\r\n";
									}
									else
									{
										echo '<div class="cate-det-item-sub">' . "\r\n";
									}
									
	                				echo '<div class="offers-name">' . $_job_value['title'] . '</div>' . "\r\n";
	                				echo '<div class="offers-description">' . $_job_value['content'] . '</div>' . "\r\n";
									
									echo '</div>' . "\r\n";
	                			}
	                		}
	    					echo '</div>' . "\r\n";
                		}
                	}
                 	?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($_language_user == 'cn')
    {
        include("inc/cn_footer.php");
    }
    else
    {
        include("inc/footer.php");
    }
    ?></div>

<script>
    $(function(){
        $(".cate-det-item").each(function(){
//            var maxHeight=$(".cate-det-item").height();
//            maxHeight=maxHeight>$(this).height()?maxHeight:$(this).height();
//            $(".cate-det-item").height(maxHeight);
        })
        $(".school-jobs-info").click(function(){
            $(".cate-det-item").hide();
            $(".join-details-for").fadeIn()
        })
        $(".offers-cate-item .font-cate,.offers-cate-item em").click(function(){
            $(".join-details-for").hide();
            var showIndex=$(".offers-cate-item").index($(this).closest('.offers-cate-item'));
            var userAgent = window.navigator.userAgent;
            if(userAgent.indexOf('MSIE 7.0') > 0 || userAgent.indexOf('MSIE 6.0') > 0){
                $(".offers-cate-item").removeClass("cur").eq(showIndex).addClass("cur").find(".son-cate-box").show();
            }
            else{
                $(".offers-cate-item").removeClass("cur").eq(showIndex).addClass("cur").find(".son-cate-box").slideDown(400);
            }
            $(".cate-det-item-sub").hide();
            $(".cate-det-item").removeClass("show").hide().eq(showIndex).find(".cate-det-item-sub").eq(0).show();
            $(".son-cate-box li").removeClass("son-cur");
            $(this).find("li:first").addClass("son-cur");
            $(".cate-det-item").eq(showIndex).fadeIn();
            $(".offers-cate-item").not('.cur').find(".son-cate-box").slideUp(400);
        })
        $(".son-cate-box li").click(function(){
            $(".join-details-for").hide();
            var cateIndex = $(this).closest('.offers-cate-item').index();
            var subIndex = $(this).index();
            $(".cate-det-item").eq(cateIndex).find(".cate-det-item-sub").not(":eq("+subIndex+")").hide();
            $(".cate-det-item").eq(cateIndex).show().find(".cate-det-item-sub").eq(subIndex).fadeIn();
            $(".son-cate-box").find("li").removeClass("son-cur");
            $(this).closest(".son-cate-box").find("li").eq(subIndex).addClass("son-cur");
        })
    })
</script>
</body>
</html>
