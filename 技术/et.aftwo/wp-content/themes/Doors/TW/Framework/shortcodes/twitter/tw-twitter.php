<?php
function twitter($atts)
{
    extract(shortcode_atts(array(
        'message'            => 'PASSION LEADS TO DESIGN, DESIGN LEADS TO PERFORMANCE, PERFORMANCE LEADS TO SUCCESS!',
        'twitterlink'             => '#',
        'username'             => 'ThemeRegion',
        'date'             => 'August 13th, 2014'
    ), $atts));
    
    $result = '';
    $result .= '<div class="text-center wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">';
    $result .= '<i class="fa fa-twitter white" style="font-size: 80px; margin-bottom: 35px;"></i>';
    $result .= '<h1 class="white twitterheading">'.$message.'</h1>';
    $result .= '<p class="white">@<a class="twitterlink" href="'.$twitterlink.'">'.$username.'</a>- '.$date.'</p>';
    $result .= '</div>';
    
    
    return $result;
}
add_shortcode( "tw-twitter", "twitter" );