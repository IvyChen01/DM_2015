<?php
function timer($atts, $content = NULL)
{
    extract(shortcode_atts(array(
        'title'            => '',
        'icon'             => '',
        'amount'             => '1245',
    ), $atts));
    
    if($icon != '') {$ic = $icon;} else {$ic = 'fa fa-group';}
    
    $result = '<div class="col-xs-4 wow zoomIn funs" data-wow-duration="700ms" data-wow-delay="500ms">
                    <i class="fa '.$ic.'"></i>	
                    <h2>'.__($title, 'doors').'</h2>
                    <h3 class="timer">'.$amount.'</h3>						
                </div>';
    
    return $result;
}
add_shortcode( "doors-timer", "timer" );
