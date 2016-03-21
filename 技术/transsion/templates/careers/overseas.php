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
            echo "海外招聘";
        }
        else
        {
            echo "Overseas Recruitment";
        }
        ?>
    </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="/style/js/jquery-1.9.1.min.js"></script>
    <script src="/style/js/newsModel.js"></script>
    <script src="/style/js/job.offers.js"></script>
</head>
<?php
if ($_language_user == 'cn')
{
    echo "<body class='cn'><div id='wrapper'>";
    include("inc/cn_head.php");
}
else
{
    echo "<body class='en'><div id='wrapper'>";
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
                <div class="cate-tli">
					<?php
					if ($_language_user == 'cn')
					{
						echo "部门";
					}
					else
					{
						echo "DEPARTMENT";
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
	                			echo '<div class="offers-cate-item cur"><a href="javascript:;">' . $_value . '</a></div>' . "\r\n";
	                		}
	                		else
	                		{
	                			echo '<div class="offers-cate-item"><a href="javascript:;">' . $_value . '</a></div>' . "\r\n";
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
            <div class="offers-details">
                <div class="cate-det-list">
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
	            				echo '<div class="cate-det-item show">' . "\r\n";
	            			}
	            			else
	            			{
	            				echo '<div class="cate-det-item">' . "\r\n";
	            			}
	                		foreach ($_job as $_job_key => $_job_value)
	                		{
	                			if ($_value == $_job_value['typename'])
	                			{
	                				echo '<div class="offers-name">' . $_job_value['title'] . '</div>' . "\r\n";
	                				echo '<div class="offers-description">' . $_job_value['content'] . '</div>' . "\r\n";
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
</body>
</html>