<?php
    if(isset($_POST['footer_settings']) && $_POST['footer_settings'] == 'Save Footer Settings')
    {
        
        $copyRight = $_POST['copyRight'];
        $google_tracking = $_POST['google_tracking'];
        $facebook = $_POST['facebook'];
        $googlePlus = $_POST['googlePlus'];
        $vk = $_POST['vk'];
        $dropbox = $_POST['dropbox'];
        $linkedin = $_POST['linkedin'];
        $twitter = $_POST['twitter']; 
        $pagelines = $_POST['pagelines'];
        $dribbble = $_POST['dribbble'];
        update_option('google_tracking', $google_tracking);
        
        
        
        
        
        update_option('copyRight', $copyRight);
        update_option('facebook', $facebook);
        update_option('googlePlus', $googlePlus);
        update_option('vk', $vk);
        update_option('dropbox', $dropbox);
        update_option('linkedin', $linkedin);
        update_option('twitter', $twitter);
        update_option('pagelines', $pagelines);
        update_option('dribbble', $dribbble);
        update_option('glatitude', $_POST['glatitude']);
        update_option('glongitude', $_POST['glongitude']);
        
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=f_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Google Map Settings
        </th>
    </tr>
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-map-marker"></i> Goole Latitude.</p>
            <input type="text" name="glatitude" value="<?php echo get_option('glatitude', FALSE); ?>" placeholder="Latitude"/>
        </td>
    </tr>
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-map-marker"></i> Goole Longitude.</p>
            <input type="text" name="glongitude" value="<?php echo get_option('glongitude', FALSE); ?>" placeholder="Latitude"/>
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Google Analytics Tracking Code
        </th>
    </tr>
    <tr>
        <td>
            <?php $google_tracking = get_option('google_tracking', FALSE); ?>
            <p class="rmsnotic"> Paste your Google Analytics Code (or other) here. </p>
            <textarea name="google_tracking" ><?php echo stripslashes($google_tracking); ?></textarea>
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Footer CopyRight
        </th>
    </tr>
    <tr>
        <td>
            <?php 
                $copyRight = get_option('copyRight', FALSE); 
            ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Copy Right &COPY;. </p>
            <textarea name="copyRight"><?php echo stripslashes($copyRight); ?></textarea>
            
            <div class="clear"></div>
           
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Social Settings
        </th>
    </tr>
    <tr>
        <td>
            <?php $facebook = get_option('facebook', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>Facebook</b></p>
            <input type="text" name="facebook"  value="<?php echo $facebook; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $twitter = get_option('twitter', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>Twitter</b></p>
            <input type="text" name="twitter" value="<?php echo $twitter; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $googlePlus = get_option('googlePlus', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>Google Plus</b></p>
            <input type="text" name="googlePlus" value="<?php echo $googlePlus; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $vk = get_option('vk', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>VK</b></p>
            <input type="text" name="vk" value="<?php echo $vk; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $dropbox = get_option('dropbox', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>DropBox</b></p>
            <input type="text" name="dropbox" value="<?php echo $dropbox; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $linkedin = get_option('linkedin', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>LinkdIn</b></p>
            <input type="text" name="linkedin" value="<?php echo $linkedin; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $dribbble = get_option('dribbble', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>Dribbble</b></p>
            <input type="text" name="dribbble" value="<?php echo $dribbble; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
    <tr>
        <td>
            <?php $pagelines = get_option('pagelines', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> <b>Page Lines</b></p>
            <input type="text" name="pagelines" value="<?php echo $pagelines; ?>" placeholder="http://" class="general_input" />
        </td>
    </tr>
</table>
<div class="submit_area">
    <input type="submit" value="Save Footer Settings" name="footer_settings"/>
</div>
</form>
    
