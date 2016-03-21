<?php
function paragraph($atts, $content = null)
{
    extract(shortcode_atts(array(
        'class'              => '',
        'color'              => '',
        'fsize'              => '',
        'padding'            => '',
        'align'              => ''
    ), $atts));
    
    $result = '<p class="common_paragraph '.$class.'" style="padding: '.$padding.'; width: 100%; color: '.$color.'; font-size: '.$fsize.'; text-align:'.$align.'" >'.$content.'</p>';
    

    return $section_heading = force_balance_tags( $result );
    
    
}
add_shortcode( "doors-paragraph", "paragraph" );