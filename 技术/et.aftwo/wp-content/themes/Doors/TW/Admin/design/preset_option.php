<?php
    if(isset($_POST['preset_settings']) && $_POST['preset_settings'] == 'Save Preset Settings')
    {
        
        update_option('presetcolor', $_POST['presetcolor']);
        
        
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=preset_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
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
                <option value="">Select Preset Color</option>
                <option value="black" <?php if($sbp == 'black') { echo 'Selected';} ?> >Black</option>
                <option value="blue" <?php if($sbp == 'blue') { echo 'Selected';} ?> >Blue</option>
                <option value="grap" <?php if($sbp == 'grap') { echo 'Selected';} ?> >Grap</option>
                <option value="green" <?php if($sbp == 'green') { echo 'Selected';} ?> >Green</option>
                
            </select>
        </td>
    </tr>
</table>


<div class="submit_area">
    <input type="submit" value="Save Preset Settings" name="preset_settings"/>
</div>
</form>