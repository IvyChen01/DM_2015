<?php
function portfolio($atts)
{
    extract(shortcode_atts(array(
        'formate'          => 'filter',
        'number'       => '8'
    ), $atts));
    
    $return_portfolio = '';
    
    if($formate == 'filter')
    {
        $filter_cat = array(
            'orderby'       => 'name',
            'order'         => 'ASC', 
            'hide_empty'    => 0,
            'hierarchical'  => 1,
            'taxonomy'      => 'portfolio'
        );
        $categories = get_categories( $filter_cat );
        $return_portfolio .= '<div class="portfolio-wrapper wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">';
        $return_portfolio .= '<ul class="filter text-center">';
        $return_portfolio .= '<li><a class="active" href="#" data-filter="*">All</a></li>';
        if(is_array($categories))
        {
            foreach($categories as $cat)
            {
                $return_portfolio .= '<li><a href="#" data-filter=".cat_'.$cat->term_id.'">'.$cat->cat_name.'</a></li>';
            }
        }
        $return_portfolio .= '</ul>';
        
        $filter = array(
            'post_type'     => array('portfolio'),
            'post_status'   => array('publish'),
            'orderby'       => 'ID',
            'order'         => 'DESC',
            'posts_per_page'=> $number
        );
        query_posts($filter);
        if(have_posts())
        {
            $return_portfolio .= '<ul class="portfolio-items">';
            $i = 1;
            while(have_posts()): the_post();
                if(has_post_thumbnail())
                {
                    $srcfull1 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'full');
                    $srcfull = $srcfull1[0];
                    $thumgSmall = get_the_post_thumbnail(get_the_ID(), 'square-big', array('class'=> 'img-responsive'));
                }
                else
                {
                    $srcfull = 'http://placehold.it/635x635';
                    $thumgSmall = '<img class="img-responsive" src="http://placehold.it/350x335" alt="'.  get_the_title().'"/>';
                }
                $terms = get_the_terms(get_the_ID(), 'portfolio');
                $tid = '';
                if(is_array($terms))
                {
                    foreach ( $terms as $term ) 
                    {
                            $tid .= 'cat_'.$term->term_id.' ';
                    }
                }
                
                $return_portfolio .= '<li class="'.$tid.'">
					<div class="portfolio-content">
						'.$thumgSmall.'
						<div class="overlay">								
							<a class="folio-detail" href="'.$srcfull.'" data-rel="prettyPhoto[gallery]"><i class="fa fa-camera"></i></a>
							<h2>'.  get_the_title().'</h2>
							<p>'.  substr(get_the_content(), 0, 137).'</p>
							<a class="folio-link" href="'.  get_the_permalink().'"><i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>	
				</li>';
                
           endwhile;
            $return_portfolio .= '</ul>';
        }
        else
        {
            $return_portfolio .= '<div class="row">';
            $return_portfolio .= '<h1 class="text-center">Insert Some Portfolio First</h1>';
            $return_portfolio .= '</div>';
        }
        $return_portfolio .= '</div>';
        wp_reset_query();
    }
    
    elseif($formate == 'slide')
    {
        $slide = array(
            'post_type'         => array('portfolio'),
            'status'            => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $number
        );
        query_posts($slide);
        if(have_posts())
        {
            $total = 0; 
            while(have_posts()){the_post(); $total++;}
            
            
            $return_portfolio .= '<div style="margin-bottom: 100px;" id="portfolio-carousel" class="carousel slide" data-ride="carousel">';
            $return_portfolio .= '<a class="team-carousel-left" href="#portfolio-carousel" data-slide="prev"><i class="fa fa- fa-chevron-left"></i></a>
					<a class="team-carousel-right" href="#portfolio-carousel" data-slide="next"><i class="fa fa- fa-chevron-right"></i></a>';
            $return_portfolio .= '<div class="carousel-inner">';
            
            $t = 1;
            while(have_posts())
            {
                the_post();
                if($t == 1) { $return_portfolio .= '<div class="item active"><ul class="portfolio-items2">';}
                
                if(has_post_thumbnail())
                {
                    $srcfull1 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'full' );
                    $srcfull = $srcfull1[0];
                    $thumgSmall = get_the_post_thumbnail(get_the_ID(), 'square-big', array('class'=> 'img-responsive'));
                }
                else
                {
                    $srcfull = 'http://placehold.it/635x635';
                    $thumgSmall = '<img src="http://placehold.it/350x335" alt="'.  get_the_title().'"/>';
                }
                
                    $return_portfolio .= '<li>
					<div class="portfolio-content">
						'.$thumgSmall.'
						<div class="overlay">								
							<a class="folio-detail" href="'.$srcfull.'" data-rel="prettyPhoto[gallery]"><i class="fa fa-camera"></i></a>
							<h2>'.  get_the_title().'</h2>
							<p>'.  substr(get_the_content(), 0, 137).'</p>
							<a class="folio-link" href="'.  get_the_permalink().'"><i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>	
				</li>';
                
                if($t %  4 == 0 && $t < $total){ $return_portfolio .='</ul></div><div class="item"><ul class="portfolio-items2">';}
                elseif($t % 4 == 0 && $t == $total){$return_portfolio .='</ul></div>';}
                elseif($t == $total){$return_portfolio .='</ul></div>';}
                $t++;
                
            }
            $return_portfolio .= '</div>';
            $return_portfolio .= '</div>';
            $return_portfolio .= '<div class="falsePadding"></div>';
        }
        else
        {
            $return_portfolio .= '<h1 class="query_worning">Insert Some Portfolio First</h1>';
        }
        wp_reset_query();
    }
    else
    {
        $normala = array(
            'post_type'         => array('portfolio'),
            'status'            => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $number,
            'paged'             => (get_query_var('paged')) ? get_query_var('paged') : 1
        );
        query_posts($normala);
        if(have_posts())
        {
            $return_portfolio .= '<div style="margin-bottom: 100px;" class="normalPortfolio">';
            $return_portfolio .= '<ul class="portfolio-items2">';
            while (have_posts()):
                the_post();
                
                
                if(has_post_thumbnail())
                {
                    $srcfull1 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'full' );
                    $srcfull = $srcfull1[0];
                    $thumgSmall = get_the_post_thumbnail(get_the_ID(), 'square-big', array('class'=> 'img-responsive'));
                }
                else
                {
                    $srcfull = 'http://placehold.it/635x635';
                    $thumgSmall = '<img src="http://placehold.it/350x335" alt="'.  get_the_title().'"/>';
                }
                
                    $return_portfolio .= '<li>
					<div class="portfolio-content">
						'.$thumgSmall.'
						<div class="overlay">								
							<a class="folio-detail" href="'.$srcfull.'" data-rel="prettyPhoto[gallery]"><i class="fa fa-camera"></i></a>
							<h2>'.  get_the_title().'</h2>
							<p>'.  substr(get_the_content(), 0, 137).'</p>
							<a class="folio-link" href="'.  get_the_permalink().'"><i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>	
				</li>';
                
            endwhile;
            $return_portfolio .= '</ul>';
            $return_portfolio .= '<div class="clear"></div><div class="my_pag_nav">'.tw_paging_nav().'</div>';
            $return_portfolio .= '<div class="clearfix"></div>';
            $return_portfolio .= '</div>';
            $return_portfolio .= '<div class="clearfix"></div>';
        }
        else
        {
            $return_portfolio .= '<h1 class="query_worning">Insert Some Portfolio First</h1>';
        }
        wp_reset_query();
        
    }
    
    
    
    return $return_portfolio;
}
add_shortcode( "doors-portfolio", "portfolio" );