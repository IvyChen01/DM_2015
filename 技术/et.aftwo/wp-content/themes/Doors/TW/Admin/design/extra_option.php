<?php
    if(isset($_POST['extra_settings']) && $_POST['extra_settings'] == 'Save Extra Settings')
    {
        update_option('glatitude', $_POST['glatitude']);
        update_option('glongitude', $_POST['glongitude']);
        
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=extra_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Map Settings
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

<div class="submit_area">
    <input type="submit" value="Save Extra Settings" name="extra_settings"/>
</div>
</form>