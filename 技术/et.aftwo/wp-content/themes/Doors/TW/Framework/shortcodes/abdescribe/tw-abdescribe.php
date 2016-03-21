<?php
function abdescribe($atts, $content = null)
{
    extract(shortcode_atts(array(
        'title'              => 'Our Vision',
        'description'              => 'His sumo verear torquatos et. Ad sint eripuit tractatos sit. Affert dissentiet nec ut. Eos no autem dolorem facilisi. Eu unum mucius scripserit qui. Ipsum omnes voluptaria est id.'
    ), $atts));
    
    $vission_return = '';
    
    $vission_return .= '<div class="col-sm-4 about-content wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">
					<h2>'.$title.'</h2>
					<p>'.$description.'</p>					
				</div>';
    
    return $vission_return;
    
    
}
add_shortcode( "tw-abdescribe", "abdescribe" );