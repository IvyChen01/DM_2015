<?php
/* **********************************************************
 * jQuery UI Accordion (toggles)
 * **********************************************************/
function tw_toggles( $params, $content = null) {
    extract( shortcode_atts( array(
    	'id' => rand(100,1000)
    ), $params ) );
		
	$scontent = do_shortcode($content);
	if(trim($scontent) != ""){
		$output = '<div id="tw-accordion-'.$id.'" class="tw-sc-accordion">'.$scontent;
		$output .= '</div>';
		$output .= '<script type="text/javascript">
		jQuery(function() {
			jQuery( "#tw-accordion-'.$id.' > br" ).remove();
			jQuery( "#tw-accordion-'.$id.' > p" ).remove();
			
			jQuery( "#tw-accordion-'.$id.'" ).accordion();
		});
		</script>';
		
		return $output;
	} else {
		return "";
	}
}
add_shortcode( 'tw-accordions', 'tw_toggles' );

function tw_toggle( $params, $content = null) {
    extract( shortcode_atts( array(
        'title' => 'title'
    ), $params ) );
    return str_replace('<p></p>','','<div class="tw-title"><span class="background_accordion"></span><a href="#">'.$title.'</a></div><div>'.do_shortcode($content).'</div>');
	
}
add_shortcode( 'tw-accordion', 'tw_toggle' );