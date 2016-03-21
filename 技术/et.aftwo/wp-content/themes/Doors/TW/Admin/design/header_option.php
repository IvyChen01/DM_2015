<?php
    if(isset($_POST['header_settings']) && $_POST['header_settings'] == "Save Header Settings")
    {
       
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
                    
        
        
        
        update_option('sliderShortcode', $_POST['sliderShortcode']);
        update_option('quickPhone', $_POST['quickPhone']);
        update_option('quickEmail', $_POST['quickEmail']);
        update_option('logo_text', $_POST['logo_text']);
        if(isset($resized_url) && $resized_url != '')
        {
            update_option('logo_url', $resized_url);
        }
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=h_option';
        echo "<script>window.location= '".$url."'</script>";
    }
    
    if(isset($_GET['action']) && $_GET['action'] == 'removelogo')
    {
        delete_option('logo_url');
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=h_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
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
                <input type="text" class="file" id="upfile" name="file_info">
                    <div class="file_upload">
                            <input type="file" id="file_upload" name="logo_upload">
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
            <p class="rmsnotic"><i class="up_icon fa fa-th-list"></i> Insert Slider shortcode and save it. Default Shortcode ([doors-carousel category="" item="3" features="1"]). </p>
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
<div class="submit_area">
    <input type="submit" value="Save Header Settings" name="header_settings"/>
</div>
</form>
<script type="text/javascript">
    document.getElementById("file_upload").onchange = function () {
    document.getElementById("upfile").value = this.value;
};
</script>