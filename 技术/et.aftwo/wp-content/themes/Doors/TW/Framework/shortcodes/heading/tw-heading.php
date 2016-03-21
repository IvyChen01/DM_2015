<?php
function heading($atts)
{
    extract(shortcode_atts(array(
        'type'               => '1',
        'class'              => '',
        'text'               => '',
        'color'              => '',
        'fsize'              => '',
        'align'              => '',
        'margin'             => ''
    ), $atts));
    $section_heading = '';
    if($type == 1)
    {
        $section_heading .= '<h1 class="'.$class.'" style="color: '.$color.'; font-size: '.$fsize.'; text-align: '.$align.'; margin: '.$margin.';">'.$text.'</h1>';
    }
    elseif($type == 2)
    {
        $section_heading .= '<h2 class="'.$class.'" style="color: '.$color.'; font-size: '.$fsize.'; text-align: '.$align.'; margin: '.$margin.';">'.$text.'</h2>';
    }
    elseif($type == 3)
    {
        $section_heading .= '<h3 class="'.$class.'" style="color: '.$color.'; font-size: '.$fsize.'; text-align: '.$align.'; margin: '.$margin.';">'.$text.'</h3>';
    }
    elseif($type == 4)
    {
        $section_heading .= '<h4 class="'.$class.'" style="color: '.$color.'; font-size: '.$fsize.'; text-align: '.$align.'; margin: '.$margin.';">'.$text.'</h4>';
    }
    elseif($type == 5)
    {
        $section_heading .= '<h5 class="'.$class.'" style="color: '.$color.'; font-size: '.$fsize.'; text-align: '.$align.'; margin: '.$margin.';">'.$text.'</h5>';
    }
    else
    {
        $section_heading .= '<h6 class="'.$class.'" style="color: '.$color.'; font-size: '.$fsize.'; text-align: '.$align.'; margin: '.$margin.';">'.$text.'</h6>';
    }
    
    return $section_heading;
    
    
}
add_shortcode( "doors-heading", "heading" );