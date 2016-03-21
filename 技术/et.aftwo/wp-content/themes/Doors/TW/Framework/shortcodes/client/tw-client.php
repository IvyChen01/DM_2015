<?php
function client($atts)
{
    extract(shortcode_atts(array(
        'type'          => 'normal',
        'number'       => '8',
        'category' => '',
    ), $atts));
    
    $client_return = '';
    
    if($type == 'slide')
    {
        $client = array(
            'post_type'         => array('client'),
            'post_status'       => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $number,
            'our_client' => $category
        );
        query_posts($client);
        if(have_posts())
        {
            $total = 0; 
            $client_return .= '<div id="clients-carousel" class="carousel slide" data-ride="carousel">';
            $client_return .= '<div class="carousel-inner wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">';
            while(have_posts()){the_post(); $total++;}
            
            $t = 1;
            while(have_posts())
            {
                the_post();
                if(has_post_thumbnail())
                {
                    
                    $thumgSmall = get_the_post_thumbnail(get_the_ID());
                }
                else
                {
                    $thumgSmall = '<img src="http://placehold.it/130x50" alt="'.  get_the_title().'"/>';
                }
                $client_url = get_post_meta(get_the_ID(), 'clientlink', TRUE);
                if($client_url != '' && $client_url != 1)
                {
                    $curl = $client_url;
                }
                else
                {
                    $curl = '#';
                }
                if($t == 1) { $client_return .= '<div class="item active"><ul>';}
                
                    $client_return .= '<li><a class="img-responsive" href="'.$curl.'">'.$thumgSmall.'</a></li>';
                    
                if($t %  4 == 0 && $t < $total){ $client_return .='</ul></div><div class="item"><ul>';}
                elseif($t % 4 == 0 && $t == $total){$client_return .='</ul></div>';}
                elseif($t == $total){$client_return .='</ul></div>';}
                $t++;
            }
            $client_return .= '</div>';
            $client_return .= '<a class="client-left" href="#clients-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                <a class="client-right" href="#clients-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>';
            $client_return .= '</div>';
        }
        else
        {
            $client_return .= '<h1 class="query_worning">Create Some Client.</h1>';
        }
        wp_reset_query();
    }
    else
    {
        $client = array(
            'post_type'         => array('client'),
            'post_status'       => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $number,
            'our_client' => $category
        );
        query_posts($client);
        if(have_posts())
        {
            $client_return .= '<ul class="normalclient">';
            while(have_posts())
            {
                the_post();
                if(has_post_thumbnail())
                {
                    
                    $thumgSmall = get_the_post_thumbnail(get_the_ID());
                }
                else
                {
                    $thumgSmall = '<img src="http://placehold.it/130x50" alt="'.get_the_title().'"/>';
                }
                $client_url = get_post_meta(get_the_ID(), 'clientlink', TRUE);
                if($client_url != '' && $client_url != 1)
                {
                    $curl = $client_url;
                }
                else
                {
                    $curl = '#';
                }
                $client_return .= '
                            <li><a class="img-responsive" href="'.$client_url.'">'.$thumgSmall.'</a></li>
                            ';
            }
            $client_return .= '</ul>';
            
        }
        else
        {
            $client_return .= '<h1 class="query_worning">Create Some Client.</h1>';
        }
        wp_reset_query();
    }
    
    
    return $client_return;
}
add_shortcode( "doors-client", "client" );