<?php
    if(isset($_POST['shop_settings']) && $_POST['shop_settings'] == 'Save Shop Settings')
    {
        
        $shopsidebarPosition    = $_POST['shopsidebarPosition'];
        $shop_view          = $_POST['shop_view'];
        $shopsocialBlog         = $_POST['productSocial'];
        $singleProductPageTemplate = $_POST['singleProductPageTemplate'];
        
        
        update_option('shopsidebarPosition', $shopsidebarPosition);
        update_option('shop_view', $shop_view);
        update_option('productSocial', $shopsocialBlog);
        update_option('singleProductPageTemplate', $singleProductPageTemplate);
        
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=s_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Shop Settings
        </th>
    </tr>
     <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Product View</p>
            <?php $shop_view = get_option('shop_view', FALSE); ?>
            <input type="radio" value="nomal_view" name="shop_view" checked="checked"> &nbsp; <i class="fa fa-th-list"></i> &nbsp;&nbsp;Normal View
            <input <?php if($shop_view == 'box_view') { echo 'checked = "checked"';} ?>  class="right_radio" type="radio" value="box_view" name="shop_view"> &nbsp; <i class="fa fa fa-th"></i>&nbsp;&nbsp; Box View
            <input <?php if($shop_view == 'standard_view') { echo 'checked = "checked"';} ?>  class="right_radio" type="radio" value="standard_view" name="shop_view"> &nbsp; <i class="fa fa-coffee"></i>&nbsp;&nbsp; Standard View
            
        </td>
    </tr>
    <tr>
        <td>
            <?php $sbp = get_option('shopsidebarPosition', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Sidebar Position</p>
            <select id="selectLayout" name="shopsidebarPosition">
                <option value="">Select Position</option>
                <option value="leftSidebar" <?php if($sbp == 'leftSidebar') { echo 'Selected';} ?> >Left Side Bar</option>
                <option value="rightSidebar" <?php if($sbp == 'rightSidebar') { echo 'Selected';} ?> >Right Side Bar</option>
                
            </select>
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <?php $socialBlog = get_option('productSocial', FALSE); ?>
            <p class="rmsnotic"><i class="warninga fa fa-indent"></i>Enable or Disable Social Share for Single Product Page .</p>
            <input type="radio" value="yes" name="productSocial" checked="checked" /> Show Share Box
            <input class="right_radio" type="radio" value="no" name="productSocial" <?php if($socialBlog == 'no') { echo 'checked="checked"';} ?> /> Don't Show
        </td>
    </tr>
</table>
    
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <?php $sppt = get_option('singleProductPageTemplate', FALSE); ?>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Select Template For Single Product.</p>
            <select id="selectLayoutSingel" name="singleProductPageTemplate">
                <option value="">Select Template</option>
                <option value="leftSidebar" <?php if($sppt == 'leftSidebar') { echo 'Selected';} ?> >Left Side Bar</option>
                <option value="rightSidebar" <?php if($sppt == 'rightSidebar') { echo 'Selected';} ?> >Right Side Bar</option>
                <option value="noSidebar" <?php if($sppt == 'noSidebar') { echo 'Selected';} ?> >No Side Bar</option>
                
            </select>
        </td>
    </tr>
</table>
<div class="submit_area">
    <input type="submit" value="Save Shop Settings" name="shop_settings"/>
</div>
</form>