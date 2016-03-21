<?php
function carousel($atts)
{
    extract(shortcode_atts(array(
        'category'              => '',
        'item'                  => '',
        'features'              => '1',
        'effect'                => 'slide'
    ), $atts));
    
    if($effect == 'fade')
    {
        $class = 'carfade';
    }
    else
    {
        $class = '';
    }
    
    $carousel_return = '';
    
    if($category != '' && $category != 0)
    {
        $carousel = array(
            'post_type'         => array('slider'),
            'post_status'       => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $item,
            'tax_query'         => array('relation' => 'AND', array('taxonomy' => 'carousel_cat', 'field' => 'id', 'terms' => array( $category )) ) 
        );
    }
    else
    {
        $carousel = array(
            'post_type'         => array('slider'),
            'post_status'       => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $item 
        );
    }
    
    query_posts($carousel);
    if(have_posts())
    {
        $carousel_return .= '<div id="carousel-wrapper">';
        $carousel_return .= '<div id="home-carousel" class="carousel slide '.$class.'" data-ride="carousel">';
        $carousel_return .= '<div class="container">
				<div class="carousel-arrows">
					<a class="home-carousel-left" href="#home-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
					<a class="home-carousel-right" href="#home-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>';
        $carousel_return .= '<div class="carousel-inner">';
        $car = 1;
        while(have_posts())
        {
            the_post();
            if(has_post_thumbnail())
            {
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'full');
                $thumb = $thumb[0];
            }
            else
            {
                $thumb = 'http://placehold.it/1600x1073';
            }
            
            if($car == 1){$class = 'active';} else{$class = '';}
            
            $carousel_return .= '<div class="item '.$class.'" style="background-image: url('.$thumb.')">
					<div class="carousel-caption container">
                                            '.  get_the_content().'
					</div>					
				</div>';
            $car++;
        }
        $carousel_return .= '</div>';
        
        if($features != 2)
        {
            $carousel_return .= '<div class="brand-promotion">';
            $carousel_return .= '<div class="container">';
            $carousel_return .= '<div class="media row">';
            
            $features = array(
                'post_type'         => array('features'),
                'post_status'       => array('publish'),
                'orderby'           => 'date',
                'order'             => 'DESC',
                'posts_per_page'    => 3
            );
            query_posts($features);
            if(have_posts())
            {
                while(have_posts())
                {
                    the_post();
                    if(has_post_thumbnail())
                    {
                        $thumb = get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'pull-left img-responsive'));
                    }
                    else
                    {
                        $thumb = '<img src="http://placehold.it/56x47" class="pull-left img-responsive" alt="'.get_the_title().'"/>';
                    }
                    //$feature_link =  get_post_meta(get_the_ID(), 'feature_link', true);
                    //<a href="'.$feature_link.'" style="color:white"></a>
                    $carousel_return .= '<div class="col-sm-4">
                                           <div class="brand-content wow fadeIn" data-wow-duration="700ms" data-wow-delay="300ms">
                                                    '.$thumb.'
                                                    <div class="media-body">							
                                                            <h2>'.  get_the_title().'</h2>
                                                            <p>'. get_the_content().'</p>
                                                    </div>
                                            </div>						
                                        </div>';
                }
            }
            
            $carousel_return .= '</div>';
            $carousel_return .= '</div>';
            $carousel_return .= '</div>';
            $carousel_return .= '</div>';
        }
        
        $carousel_return .= '</div>';
    }
    else
    {
        $carousel_return .= '<h1 class="text-center">Please Insert some Slider Item first.</h1>';
    }
    wp_reset_query();

    return $carousel_return;
    
    
}

add_shortcode( "doors-carousel", "carousel" );

