<?php
    if(isset($_POST['typstyle_settings']) && $_POST['typstyle_settings'] == 'Save Tipography & Style Settings')
    {
        update_option('Basefont', $_POST['Basefont']);
        update_option('baseColor', $_POST['baseColor']);
        update_option('h1FontSize', $_POST['h1FontSize']);
        update_option('h1font', $_POST['h1font']);
        update_option('h1color', $_POST['h1color']);
        update_option('h2FontSize', $_POST['h2FontSize']);
        update_option('h2font', $_POST['h2font']);
        update_option('h2color', $_POST['h2color']);
        update_option('h3FontSize', $_POST['h3FontSize']);
        update_option('h3font', $_POST['h3font']);
        update_option('h3color', $_POST['h3color']);
        update_option('h4FontSize', $_POST['h4FontSize']);
        update_option('h4font', $_POST['h4font']);
        update_option('h4color', $_POST['h4color']);
        update_option('h5FontSize', $_POST['h5FontSize']);
        update_option('h5font', $_POST['h5font']);
        update_option('h5color', $_POST['h5color']);
        update_option('h6FontSize', $_POST['h6FontSize']);
        update_option('h6font', $_POST['h6font']);
        update_option('h6color', $_POST['h6color']);
        update_option('paraFontSize', $_POST['paraFontSize']);
        update_option('pFont', $_POST['pFont']);
        update_option('pColor', $_POST['pColor']);
        update_option('aFontSize', $_POST['aFontSize']);
        update_option('aFont', $_POST['aFont']);
        update_option('aColor', $_POST['aColor']);
        
        $css = '';
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['Basefont'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['h1font'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['h2font'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['h3font'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['h4font'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['h5font'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['h6font'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['pFont'].');'."\n";
        $css .= '@import url(http://fonts.googleapis.com/css?family='.$_POST['aFont'].');'."\n";
        
        $css .= 'body{ color: #'.$_POST['baseColor'].'; font-family: '.str_replace('+', ' ', $_POST['Basefont']).';}'."\n";
        $css .= 'h1{ color: #'.$_POST['h1color'].'; font-family: '.str_replace('+', ' ', $_POST['h1font']).'; font-size: '.$_POST['h1FontSize'].';}'."\n";
        $css .= 'h2{ color: #'.$_POST['h2color'].'; font-family: '.str_replace('+', ' ', $_POST['h2font']).'; font-size: '.$_POST['h2FontSize'].';}'."\n";
        $css .= 'h3{ color: #'.$_POST['h3color'].'; font-family: '.str_replace('+', ' ', $_POST['h3font']).'; font-size: '.$_POST['h3FontSize'].';}'."\n";
        $css .= 'h4{ color: #'.$_POST['h4color'].'; font-family: '.str_replace('+', ' ', $_POST['h4font']).'; font-size: '.$_POST['h4FontSize'].';}'."\n";
        $css .= 'h5{ color: #'.$_POST['h5color'].'; font-family: '.str_replace('+', ' ', $_POST['h5font']).'; font-size: '.$_POST['h5FontSize'].';}'."\n";
        $css .= 'h6{ color: #'.$_POST['h6color'].'; font-family: '.str_replace('+', ' ', $_POST['h6font']).'; font-size: '.$_POST['h6FontSize'].';}'."\n";
        $css .= 'p{ color: #'.$_POST['pColor'].'; font-family: '.str_replace('+', ' ', $_POST['pFont']).'; font-size: '.$_POST['paraFontSize'].';}'."\n";
        $css .= 'a{ color: #'.$_POST['aColor'].'; font-family: '.str_replace('+', ' ', $_POST['aFont']).'; font-size: '.$_POST['aFontSize'].';}'."\n";
        
        
        $css_file = 'typography.css';
        WP_Filesystem();
        global $wp_filesystem;
        if(!$wp_filesystem->put_contents(get_template_directory().'/TW/Assets/css/'.$css_file, $css, FS_CHMOD_FILE)) {
            echo 'Generating CSS error!';
        }
        
        
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=ts_option';
        echo "<script>window.location= '".$url."'</script>";
        
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Typography &AMP; Style Settings
        </th>
    </tr>
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i> Select Base Font For Your Site. (Those are google fonts).</p>
            <?php
                    $fontsSeraliazed = wp_remote_fopen('http://phat-reaction.com/googlefonts.php?format=php');
                    
                    $fontArray = unserialize($fontsSeraliazed);
                    
               $baseFont = get_option('Basefont', FALSE);     
                ?>
            <select id="SelectFont" name="Basefont">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $baseFont) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
                
        </td>
    </tr>
    <tr>
        <td>
            
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i>Select Base Color. (Click on the text field)</p>
            <input type="text" name="baseColor" id="baseColor" value="<?php if(get_option('baseColor', FALSE) != '') {echo get_option('baseColor', FALSE);} else{ echo '000000';} ?>" placeholder="000000" class="general_input" />
        </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>H1 Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('h1FontSize', FALSE) != '') { echo get_option('h1FontSize', FALSE);} else{ echo '30px';} ?>" name="h1FontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="selectf" name="h1font" style="float: left; margin-right: 10px">
                <option  value="Opent+Sans">Select Font</option>
                <?php
                    $h1font = get_option('h1font', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $h1font) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('h1color', FALSE) != '') { echo get_option('h1color', FALSE);} else{ echo '333333';} ?>" name="h1color" id="h1Color" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>H2 Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('h2FontSize', FALSE) != '') {echo get_option('h2FontSize', FALSE);} else{ echo '30px';} ?>" name="h2FontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="selectf2" name="h2font" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $h2font = get_option('h2font', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $h2font) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('h2color', FALSE) != '') { echo get_option('h2color', FALSE);} else { echo '333333';} ?>" name="h2color" id="h2Color" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>H3 Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('h3FontSize', FALSE) != '') { echo get_option('h3FontSize', FALSE);} else{ echo '30px';} ?>" name="h3FontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="selectf3" name="h3font" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $h3font = get_option('h3font', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $h3font) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'">'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('h3color', FALSE) != '') { echo get_option('h3color', FALSE);} else { echo '333333';} ?>" name="h3color" id="h3Color" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>H4 Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('h4FontSize', FALSE) != '') { echo get_option('h4FontSize', FALSE);} else { echo '30px';} ?>" name="h4FontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="selectf4" name="h4font" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $h4font = get_option('h4font', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $h4font) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('h4color', FALSE) != '') { echo get_option('h4color', FALSE);} else {echo '333333';} ?>" name="h4color" id="h4Color" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>H5 Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('h5FontSize', FALSE) != '') { echo get_option('h5FontSize', FALSE); } else { echo '30px';} ?>" name="h5FontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="selectf5" name="h5font" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $h5font = get_option('h5font', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $h5font) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('h5color', FALSE) != '') { echo get_option('h5color', FALSE);} else { echo '333333';} ?>" name="h5color" id="h5Color" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>H6 Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('h6FontSize', FALSE) != '') { echo get_option('h6FontSize', FALSE);} else{ echo '30px';} ?>" name="h6FontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="selectf6" name="h6font" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $h6font = get_option('h6font', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $h6font) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('h6color', FALSE) != '') { echo get_option('h6color', FALSE);} else { echo '333333';} ?>" name="h6color" id="h6Color" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>Paragraph Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('paraFontSize', FALSE) != '') { echo get_option('paraFontSize', FALSE);} else { echo '30px';} ?>" name="paraFontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="pFont" name="pFont" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $pFont = get_option('pFont', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $pFont) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'" '.$selected.'>'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('pColor', FALSE) != '') { echo get_option('pColor', FALSE);} else{ echo '333333';} ?>" name="pColor" id="pColor" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-indent"></i><strong>Link Style Settings.</strong></p>
            <input type="text" value="<?php if(get_option('aFontSize', FALSE) != '') { echo get_option('aFontSize', FALSE);} else { echo '30px';} ?>" name="aFontSize" placeholder="30px" class="general_input " style="width: 120px; float: left; margin-right: 10px"/>
        
            <select id="aFont" name="aFont" style="float: left; margin-right: 10px">
                <option value="Opent+Sans">Select Font</option>
                <?php
                    $aFont = get_option('aFont', FALSE);
                    foreach($fontArray as $font)
                    {
                        if($font['css-name'] == $aFont) {$selected = 'Selected';} else { $selected = '';}
                        echo '<option value="'.$font['css-name'].'">'.$font['font-name'].'</option>';
                    }
                ?>
            </select>
            <input type="text" value="<?php if(get_option('aColor', FALSE) != '') {echo get_option('aColor', FALSE);} else { echo '333333';} ?>" name="aColor" id="aColor" placeholder="333333" class="general_input " style="width: 120px; float: left;"/>
       </td>
    </tr>
</table>
<div class="submit_area">
    <input type="submit" value="Save Tipography & Style Settings" name="typstyle_settings"/>
</div>
</form>