<?php
function contactdetails($atts)
{
    extract(shortcode_atts(array(
        'title'          => 'Visit Our Office',
        'address'          => '',
        'phone'         => '',
        'email'         => '',
       
    ), $atts));
    
    $contact_address_return = '<div class="col-sm-4 wow zoomIn contactdetails" data-wow-duration="700ms" data-wow-delay="300ms">';
    $contact_address_return .= '<h2>'.$title.'</h2>';
    $contact_address_return .= '<address>';
    $contact_address_return .= '<p><i class="fa fa-map-marker"></i> Address: '.$address.'</p>';
    $contact_address_return .= '<p><i class="fa fa-phone"></i> Phone: '.$phone.'</p>';
    $contact_address_return .= '<p><i class="fa fa-envelope"></i> Email: '.$email.'</p>';
    $contact_address_return .= '</address>';
    $contact_address_return .= '</div>';
   
    return $contact_address_return;
}
add_shortcode( "tw-contactdetails", "contactdetails" );