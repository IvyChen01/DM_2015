<?php
function images($atts, $content = null)
{
    extract(shortcode_atts(array(
        'url' => '',
        'width' => '',
        'margin' => ''
    ), $atts));
    if($width != '')
    {
        $w = $width;
    }
    else
    {
        $w = '';
    }
    $image_return = '<div class="wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                            <img class="img-responsive" src="'.$url.'" alt="" style="width: '.$w.'; margin: '.$margin.';">
                    </div>';
    
    return $image_return;
}
add_shortcode( "doors-images", "images" );