<?php
function textblock($atts, $content = null)
{
    extract(shortcode_atts(array(
        'heading' => '',
        'subtitle' => '',
        'btntext' => '',
        'btnlink' => '#'
    ), $atts));
    $mybutton_return = '';
    
    $mybutton_return .= '<div class="wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">
			<div class="container text-center textblock">
				<h1 class="text-center">'.$heading.'</h1>
				<p class="text-center">'.$subtitle.'</p>	
				<a href="'.$btnlink.'" class="btn btn-default">'.$btntext.'</a>
			</div>
		</div>';
    
    return $mybutton_return;
}
add_shortcode( "doors-textblock", "textblock" );