<?php
    if(isset($_POST['general_settings']) && $_POST['general_settings'] == 'Save General Settings')
    {
        
        
        
        
        if(isset($_FILES['file_upload']) && $_FILES['file_upload']['name'] != '')
        {
            
            require_once ABSPATH.'wp-admin/includes/file.php';

            $allowed_image_types = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'png'          => 'image/png',
                'gif'          => 'image/gif',
                
            );

                $upload_overrides = array( 'test_form' => false );
                $status = wp_handle_upload($_FILES['file_upload'], $upload_overrides);

               if(empty($status['error']) && isset($status['file']))
               {
                    
                    
                    $uploads = wp_upload_dir();
                    //$org_url = $uploads['url'].'/'.basename($resized);
                    $org_url = $uploads['url'].'/'.$_FILES['file_upload']['name'];

              }
              else
              {
                wp_die(sprintf(__('Upload Error: %s', 'rms'), $status['error']));
              }

        }
        
        
        if(isset($_FILES['logo_upload']) && $_FILES['logo_upload']['name'] != '')
        {
            
            require_once ABSPATH.'wp-admin/includes/file.php';

            $allowed_image_types = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'png'          => 'image/png',
                'gif'          => 'image/gif',
                
            );

                $upload_overrides = array( 'test_form' => false );
                $status = wp_handle_upload($_FILES['logo_upload'], $upload_overrides);

               if(empty($status['error']) && isset($status['file']))
               {
                    $uploads = wp_upload_dir();
                    $resized_url = $uploads['url'].'/'.$_FILES['logo_upload']['name'];

              }
              else
              {
                wp_die(sprintf(__('Upload Error: %s', 'rms'), $status['error']));
              }

        }
        
        if(isset($org_url) && $org_url != '')
        {
            update_option('favicon_url', $org_url);
        }
        
        
                    
        
        
        update_option('presetcolor', $_POST['presetcolor']);
        update_option('sliderShortcode', $_POST['sliderShortcode']);
        update_option('quickPhone', $_POST['quickPhone']);
        update_option('quickEmail', $_POST['quickEmail']);
        update_option('logo_text', $_POST['logo_text']);
        if(isset($resized_url) && $resized_url != '')
        {
            update_option('logo_url', $resized_url);
        }
        
        $url = admin_url().'themes.php?page=tw_theme_option';
        echo "<script>window.location= '".$url."'</script>";
    }
    
    if(isset($_GET['action']) && $_GET['action'] == 'removefavicon')
    {
        delete_option('favicon_url');
        $url = admin_url().'themes.php?page=tw_theme_option';
        echo "<script>window.location= '".$url."'</script>";
    }
    if(isset($_GET['action']) && $_GET['action'] == 'removelogo')
    {
        delete_option('logo_url');
        $url = admin_url().'themes.php?page=tw_theme_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">


<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Favicon Icon
        </th>
    </tr>
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-upload"></i> Upload your Favicon (16x16px ico/png - use <a href="http://www.favicon.cc/">favicon.cc</a> to make sure it's fully compatible).</p>
            <?php $favicon_url = get_option('favicon_url', FALSE); ?>
            <?php 
                if($favicon_url != ''):
                    echo '<div class="favicon_image"><img src="'.$favicon_url.'" alt="Winter"/></div>';
                endif;
            ?>
            <div class="custom_file_upload">
                <input type="text" class="file" id="upfile" name="file_info">
                    <div class="file_upload">
                            <input type="file" id="file_upload" name="file_upload">
                    </div>
            </div>
            <div class="removebutton"><a href="themes.php?page=tw_theme_option&action=removefavicon">Remove</a></div>
        </td>
    </tr>
</table>

    
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Logo
        </th>
    </tr>
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-upload"></i> Upload Logo Image With (58x85) Resolation. Other wise its heard crop automatically. </p>
            
            <?php
                $logo_url = get_option('logo_url', FALSE);
                if($logo_url != '' && isset($logo_url))
                {
                    echo '<div class="admin_logo_option"><img style="background: #D9232D;" src="'.$logo_url.'" alt="ThemeOnLab"/></div>';
                }
            ?>
            
            <div class="custom_file_upload">
                <input type="text" class="file" id="upfile1" name="file_info">
                    <div class="file_upload">
                            <input type="file" id="file_upload1" name="logo_upload">
                    </div>
            </div>
            <div class="removebutton"><a href="themes.php?page=tw_theme_option&action=removelogo">Remove</a></div>
            <div class="clear"></div>
            <?php $logo_text = get_option('logo_text', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-th-list"></i> Insert Logo text. </p>
            <input type="text" name="logo_text" value="<?php echo stripslashes($logo_text); ?>" placeholder="DOORS">
        </td>
    </tr>
</table>


    
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Slide Settings
        </th>
    </tr>
    <tr>
        <td>
            <?php $sliderShortcode = get_option('sliderShortcode', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-th-list"></i> Insert Slider shortcode and save it. Default Shortcode ( [doors-carousel category="" item="3" features="1" effect="slide"] ). Available effect ( slide, fade ).</p>
            <textarea name="sliderShortcode" id="slider_shortcode"><?php echo stripslashes($sliderShortcode); ?></textarea>
        </td>
    </tr>
</table>
    
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Contact Info Settings
        </th>
    </tr>
    <tr>
        <td>
            <?php $quickPhone = get_option('quickPhone', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-th-list"></i> Insert Your Contact Number. </p>
            <input type="text" name="quickPhone" value="<?php echo stripslashes($quickPhone); ?>" placeholder="+111 123 123">
        </td>
    </tr>
    <tr>
        <td>
            <?php $quickEmail = get_option('quickEmail', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-th-list"></i> Insert Your Email Address. </p>
            <input type="text" name="quickEmail" value="<?php echo stripslashes($quickEmail); ?>" placeholder="example@example.com">
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Color Preset Settings
        </th>
    </tr>
    <tr>
        <td>
            <?php $sbp = get_option('presetcolor', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Select Preset Color</p>
            <select id="selectpreset" name="presetcolor">
                <option value="red">Red</option>
                <option value="black" <?php if($sbp == 'black') { echo 'Selected';} ?> >Black</option>
                <option value="blue" <?php if($sbp == 'blue') { echo 'Selected';} ?> >Blue</option>
                <option value="grap" <?php if($sbp == 'grap') { echo 'Selected';} ?> >Grap</option>
                <option value="green" <?php if($sbp == 'green') { echo 'Selected';} ?> >Green</option>
                
            </select>
        </td>
    </tr>
</table>
    
    
<div class="submit_area">
    <input type="submit" value="Save General Settings" name="general_settings"/>
</div>
<div class="clear"></div>
</form>
<script type="text/javascript">
    document.getElementById("file_upload").onchange = function () {
    document.getElementById("upfile").value = this.value;
};
    document.getElementById("file_upload1").onchange = function () {
    document.getElementById("upfile1").value = this.value;
};
</script>