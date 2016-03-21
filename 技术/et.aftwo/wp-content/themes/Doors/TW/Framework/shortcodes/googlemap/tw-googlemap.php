<?php
function googlemap($atts)
{
    
    extract(shortcode_atts(array(
        'width'          => '100%',
        'height'         => '440px'
    ), $atts));
    
    $map_return = '';
    $map_return .= '<div class="clearfix"></div><div id="gmap" style="width: '.$width.'; height: '.$height.';">';
    $map_return .= '</div>';
   
    return $map_return;
}
add_shortcode( "doors-googlemap", "googlemap" );