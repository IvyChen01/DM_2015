<?php
function section($atts, $content = null)
{
    extract(shortcode_atts(array(
        'class'              => ''
    ), $atts));
    
    $section_return = '';
    
    $result = '<div class="padding-top padding-bottom '.$class.'" style="width: 100%;">';
    $result .= '<div class="container">';
    $result .= '<div class="row">';
    $result .= do_shortcode(  $content );
    $result .= '<div class="clear"></div></div>';
    $result .= '</div><div class="clear"></div>';
    $result .= '</div>';

    return $section_return .= force_balance_tags( $result );
    
    
}
add_shortcode( "tw-section", "section" );