<?php

function service($atts, $content = null) {
    extract(shortcode_atts(array(
        'type' => '',
        'sitem' => ''
                    ), $atts));

    $service_return = '';

    $service_return .= '<div class="container"><div class="row">';
    if ($type == 'slide') {
        $service = array(
            'post_type' => array('service'),
            'post_status' => array('publish'),
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $sitem
        );
        query_posts($service);
        if (have_posts()) {
            $service_return .= '<div id="features-carousel servicegenerator" class="carousel slide" data-ride="carousel">';
            $service_return .= '<a class="team-carousel-left" href="#features-carousel" data-slide="prev"><i class="fa fa- fa-chevron-left"></i></a>
                                <a class="team-carousel-right" href="#features-carousel" data-slide="next"><i class="fa fa- fa-chevron-right"></i></a>';
            $service_return .= '<div class="carousel-inner">';

            $total = 0;
            while (have_posts()) {
                the_post();
                $total++;
            }
            $t = 1;
            while (have_posts()) {
                the_post();
                if ($t == 1) {
                    $service_return .= '<div class="item active">';
                }

                $icon = get_post_meta(get_the_ID(), 'serviceIcon', true);
                if ($icon != '' && $icon != 1) {
                    $ico = 'fa ' . $icon;
                } else {
                    $ico = 'fa fa-bomb';
                }

                $service_return .= '<div class="col-md-3 col-sm-6 wow zoomIn text-center" data-wow-duration="700ms" data-wow-delay="300ms">					
					<div class="service-icon">
						<i class="' . $ico . '"></i>							
					</div>
					<div class="service-text">
						<h4>' . get_the_title() . '</h4>
						<p>' . substr(get_the_content(), 0, 150) . '</p>
					</div>					
				</div>';


                if ($t % 4 == 0 && $t < $total) {
                    $service_return .='</div><div class="item">';
                } elseif ($t % 4 == 0 && $t == $total) {
                    $service_return .='</div>';
                } elseif ($t == $total) {
                    $service_return .='</div>';
                }
                $t++;
            }
            $service_return .= '</div>';
            $service_return .= '</div></div>';
        } else {
            $service_return .= '<div class="row">';
            $service_return .= '<h1 class="text-center">Insert Some Services First</h1>';
            $service_return .= '</div>';
        }
        wp_reset_query();
    } else {
        $service = array(
            'post_type' => array('service'),
            'post_status' => array('publish'),
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $sitem
        );
        query_posts($service);
        if (have_posts()) {
            $service_return .= '<div class="servicegenerator">';
            while (have_posts()) {
                the_post();
                $icon = get_post_meta(get_the_ID(), 'serviceIcon', true);
                if ($icon != '' && $icon != 1) {
                    $ico = 'fa ' . $icon;
                } else {
                    $ico = 'fa fa-bomb';
                }
                $service_return .= '<div class="col-md-3 col-sm-6 wow zoomIn text-center" data-wow-duration="700ms" data-wow-delay="300ms">					
                                    <div class="service-icon">
                                            <i class="' . $ico . '"></i>							
                                    </div>
                                    <div class="service-text">
                                            <h4>' . get_the_title() . '</h4>
                                            <p>' . substr(get_the_content(), 0, 150) . '</p>
                                    </div>					
                            </div>';
            }
            $service_return .= '</div>';
        } else {
            $service_return .= '<div class="row">';
            $service_return .= '<h1 class="text-center">Insert Some Services First</h1>';
            $service_return .= '</div>';
        }
        wp_reset_query();
    }
    $service_return .= '</div>';
    return $service_return;
}

add_shortcode("doors-service", "service");
