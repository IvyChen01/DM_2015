<?php
function subtitle($atts)
{
    extract(shortcode_atts(array(
        'class'              => '',
        'text'               => '',
        'color'              => '',
        'fsize'              => '',
        'align'              => ''
    ), $atts));
    
    $result = '<div class="col-sm-6 col-sm-offset-3"><p style=" font-size: '.$fsize.'; color: '.$color.'; text-align: '.$align.';" class="wow fadeInUp '.$class.'" data-wow-duration="700ms" data-wow-delay="300ms">'.$text.'</p></div><div class="clearfix"></div>';
    

    return $section_heading = force_balance_tags( $result );
    
    
}
add_shortcode( "doors-subtitle", "subtitle" );