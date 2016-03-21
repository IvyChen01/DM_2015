<?php
function testimonial($atts)
{
    extract(shortcode_atts(array(
        'type'          => 'normal',
        'number'       => '8'
    ), $atts));
    
    $testimonial_return = '';
    if($type == 'slider')
    {
        $normal = array(
            'post_type'         => array('testimonial'),
            'status'            => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $number
        );
        query_posts($normal);
        if(have_posts())
        {
            $total = 0; 
            while(have_posts()){the_post(); $total++;}
            
            $testimonial_return .= '<div class=" text-center wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">';
            $testimonial_return .= '<div id="testimonial-carousel" class="carousel slide carfade" data-ride="carousel">';
            $testimonial_return .= '<div class="carousel-inner">';
            $t = 1;
            while(have_posts())
            {
                the_post();
                if($t == 1)
                {
                    $class = 'active';
                }
                else
                {
                    $class = '';
                }
                $designation = get_post_meta(get_the_ID(), 'designation', true);
                
                $testimonial_return .= '<div class="item '.$class.'">';
                    $testimonial_return .= '<h1 class="white">'.get_the_content().'</h1>
                                            <h2 class="white testimonialdesignation">'.  get_the_title().' <br/><span>'.$designation.'</span></h2>';
                $testimonial_return .= '</div>';
                $t++;
            }
            $testimonial_return .= '</div>';
            $testimonial_return .= '</div>';
            $testimonial_return .= '</div>';
        }
        else
        {
            $testimonial_return .= '<h1 class="query_worning">Create Some Testimonial.</h1>';
            
        }
        
        wp_reset_query();
    }
    
    
    return $testimonial_return;
}
add_shortcode( "tw-testimonial", "testimonial" );