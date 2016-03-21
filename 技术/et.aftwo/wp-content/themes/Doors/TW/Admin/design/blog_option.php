<?php
    if(isset($_POST['blog_settings']) && $_POST['blog_settings'] == 'Save Blog Settings')
    {
        $blog_title         = $_POST['blog_title'];
        $blogDes            = $_POST['blogDes'];
        $sidebarPosition    = $_POST['sidebarPosition'];
        $aboutauthorstatus    = $_POST['aboutauthorstatus'];
        
        $commentswithc = $_POST['commentswithc'];
        update_option('commentswithc', $commentswithc);
        update_option('blog_title', $blog_title);
        update_option('blogDes', $blogDes);
        update_option('sidebarPosition', $sidebarPosition);
        update_option('aboutauthorstatus', $aboutauthorstatus);
        
        
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=b_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Blog Settings
        </th>
    </tr>
    <tr>
        <td>
            <?php
                $blog_title = get_option('blog_title', FALSE);
                $blogDes = get_option('blogDes', FALSE);
            ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Enter Blog Page Title</p>
            <input type="text" name="blog_title" value="<?php echo $blog_title; ?>" placeholder="Blog" class="general_input">
            <div class="clear"></div>
            <p style="margin-top: 20px;" class="rmsnotic"><i class="up_icon fa fa-indent"></i> Blog Page <b>Excerpt</b> or <b>Sub Title Text</b>.</p>
            <textarea name="blogDes"><?php echo $blogDes; ?></textarea>
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    
    <tr>
        <td>
            <?php $sbp = get_option('sidebarPosition', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Sidebar Position</p>
            <select id="selectLayout" name="sidebarPosition">
                <option value="">Select Position</option>
                <option value="leftSidebar" <?php if($sbp == 'leftSidebar') { echo 'Selected';} ?> >Left Side Bar</option>
                <option value="rightSidebar" <?php if($sbp == 'rightSidebar') { echo 'Selected';} ?> >Right Side Bar</option>
                
            </select>
        </td>
    </tr>
</table>
    
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Comment Settings
        </th>
    </tr>
    <tr>
        <td>
            <?php $commentswithc = get_option('commentswithc', FALSE); ?>
            <p class="rmsnotic"><i class="warninga fa fa-exclamation-triangle"></i> Be careful, it will be overwrites the default roles. </p>
            <input type="radio" value="commentOn" name="commentswithc" checked="checked"/> Show Comment Box
            <input class="right_radio" type="radio" value="commentOff" name="commentswithc" <?php if($commentswithc == 'commentOff') { echo 'checked="checked"';} ?> /> Don't Show
        </td>
    </tr>
</table>
    
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Author Meta Display Status
        </th>
    </tr>
    <tr>
        <td>
            <?php $aboutauthorstatus = get_option('aboutauthorstatus', FALSE); ?>
            <p class="rmsnotic"><i class="warninga fa fa-exclamation-triangle"></i> About Author Visibility. </p>
            <input type="radio" value="show" name="aboutauthorstatus" checked="checked"/> Show About Author
            <input class="right_radio" type="radio" value="hide" name="aboutauthorstatus" <?php if($aboutauthorstatus == 'hide') { echo 'checked="checked"';} ?> /> Hide About Author
        </td>
    </tr>
</table>

<div class="submit_area">
    <input type="submit" value="Save Blog Settings" name="blog_settings"/>
</div>
</form>