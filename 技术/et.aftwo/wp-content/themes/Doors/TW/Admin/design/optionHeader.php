<div class="option-header">
    <div class="clear"></div>
    <h1><a href="http://xpeedstudio.com">Doors Theme Options </a></h1>
    <p>Welcome To Doors Option page. </p>
    <div class="clear"></div>
</div>
<div class="main_option_area">
    <div class="option_left_nav">
        <?php
            $url = admin_url();
            if(isset($_GET['CPart'])):
                $cpart1 = $_GET['CPart'];
                if($cpart1 == ''):
                    $home_class = 'actve';
                elseif($cpart1 == 'h_option'):
                    $home_class1 = 'actve';
                elseif($cpart1 == 'home_option'):
                    $home_class2 = 'actve';
                elseif($cpart1 == 'f_option'):
                    $home_class3 = 'actve';
                elseif($cpart1 == 'b_option'):
                    $home_class4 = 'actve';
                elseif( $cpart1 == "home_option"):
                    $home_class8 = 'actve';
                elseif( $cpart1 == "import_option"):
                    $home_class10 = 'actve';
                elseif( $cpart1 == "css_option"):
                    $home_class11 = 'actve';
                endif;
            endif;
        ?>
        <ul>
            <li class="<?php echo $home_class; ?>"><a href="<?php echo $url .'themes.php?page=tw_theme_option';?>"><i class="fa fa-cogs"></i>General Settings</a></li>
            <!--<li class="<?php echo $home_class8; ?>"><a href="<?php echo $url .'themes.php?page=tw_theme_option&CPart=home_option';?>"><i class="fa fa-home"></i>Home Settings</a></li> -->
            <li class="<?php echo $home_class3; ?>"><a href="<?php echo $url .'themes.php?page=tw_theme_option&CPart=f_option';?>"><i class="fa fa-tasks"></i>Footer Settings</a></li>
            <li class="<?php echo $home_class4; ?>"><a href="<?php echo $url .'themes.php?page=tw_theme_option&CPart=b_option';?>"><i class="fa fa-columns"></i>Blog Settings</a></li>
            <li class="<?php echo $home_class10; ?>"><a href="<?php echo $url .'themes.php?page=tw_theme_option&CPart=import_option';?>"><i class="fa fa-exchange"></i>Import Data</a></li>
            <li class="<?php echo $home_class11; ?>"><a href="<?php echo $url .'themes.php?page=tw_theme_option&CPart=css_option';?>"><i class="fa fa-exchange"></i>Custom CSS</a></li>
            
        </ul>
    </div>
    <div class="right_option_details">
    
