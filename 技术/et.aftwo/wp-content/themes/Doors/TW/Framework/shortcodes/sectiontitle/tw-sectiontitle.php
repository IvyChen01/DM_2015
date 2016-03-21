<?php
function sectiontitle($atts)
{
    extract(shortcode_atts(array(
        'class'              => '',
        'text'               => '',
        'color'              => '',
        'fsize'              => '',
        'style'              => '',
        'align'              => ''
    ), $atts));
    
    if($style == 'withbg')
    {
        $result = '<h3 style="color:'.$color.'; font-size: '.$fsize.'; text-align: '.$align.';" class="sectiontitle wow fadeInDown '.$class.'" data-wow-duration="700ms" data-wow-delay="300ms">'.$text.'</h3>
                   <hr class="title-border">';
    }
    else
    {
        $result = '<h3 style="color:'.$color.'; font-size: '.$fsize.'; text-align: '.$align.';" class="sectiontitle wow fadeInDown '.$class.'" data-wow-duration="700ms" data-wow-delay="300ms">Services</h3>';
    }
    
    
    return $section_heading = force_balance_tags( $result );
    
    
}
add_shortcode( "doors-sectiontitle", "sectiontitle" );