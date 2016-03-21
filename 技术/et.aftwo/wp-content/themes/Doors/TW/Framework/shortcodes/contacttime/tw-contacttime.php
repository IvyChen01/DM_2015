<?php
function contacttime($atts)
{
    extract(shortcode_atts(array(
        'title'            => 'Business Hours',
        'workinghour'             => '',
        'workinghour2'             => '',
        'workinghour3'             => ''
    ), $atts));
    
    $result = '<div class="col-sm-4 wow zoomIn contacttime" data-wow-duration="700ms" data-wow-delay="400ms"><h2>'.$title.'</h2><div class="business-time"><p><i class="fa fa-clock-o"></i>'.$workinghour.' </p><p><i class="fa fa-clock-o"></i>'.$workinghour2.'</p><p><i class="fa fa-clock-o"></i> '.$workinghour3.'</p></div></div>';
    
    
    return $result;
}
add_shortcode( "tw-contacttime", "contacttime" );