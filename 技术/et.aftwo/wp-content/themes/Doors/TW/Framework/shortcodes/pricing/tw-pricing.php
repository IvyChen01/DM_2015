<?php
function pricing($atts)
{
    extract(shortcode_atts(array(
        'feature'            => '',
        'title'             => 'Basic',
        'currency'         => '$',
        'price'             => '49',
        'billing'             => 'monthly',
        'details1'             => '5 Domain Names',
        'details2'             => '1GB Dedicated Ram',
        'details3'             => '5 Sub Domain',
        'details4'             => '10 Addon Domain',
        'details5'             => '24/7 Support',
        'signuplink'             => '5 Domain Names',
        'signup'             => 'Sign-up'
    ), $atts));
    
    $result = '<div class="pricing-table"><div class="col-sm-3">';
    $result .= '<div class="servicegenerator single-table '.$feature.' wow zoomIn" data-wow-duration="700ms" data-wow-delay="500ms">';
    $result .= ' <h2>'.$title.'</h2>';
    $result .= '<p class="price"><span class="dollar-icon">'.$currency.'</span><span>'.$price.'</span> '.$billing.'</p>';
    $result .= ' <ul>';
    $result .= '<li>'.$details1.'</li>';
    $result .= '<li>'.$details2.'</li>';
    $result .= '<li>'.$details3.'</li>';
    $result .= '<li>'.$details4.'</li>';
    $result .= '<li>'.$details5.'</li>';
    $result .= '</ul>';
    $result .= ' <a href="'.$signuplink.'" class="btn-signup">'.$signup.'</a>';
    $result .= '</div>';
    $result .= ' </div></div>';
    
    
    return $result;
}
add_shortcode( "tw-pricing", "pricing" );