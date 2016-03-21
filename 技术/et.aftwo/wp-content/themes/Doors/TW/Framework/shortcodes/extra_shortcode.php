<?php
function popupitem($atts)
{
    extract(shortcode_atts(array(
        'item'      => '',
        'number'    => ''
    ), $atts));
    $recentitem_return = '';
    if($item == 'featured')
    {
         $products = array(
                'post_type'         => array('product'),
                'post_status'       => array('publish'),
                'orderby'           => 'date',
                'order'             => 'DESC',
                'posts_per_page'    => $number,
                'meta_key'          => '_featured',
                'meta_value'        => 'yes'
            );
            query_posts($products);
            if(have_posts())
            {
                $total = 0; 
                while(have_posts()){the_post(); $total++;}
                
                $recentitem_return .= '<div id="carousel-example-generic-f-product" class="carousel slide" data-ride="carousel" data-interval="false">';
                $recentitem_return .= '<div class="carousel-inner">';
                $t = 1;
                while(have_posts())
                {
                    the_post();
                    if(has_post_thumbnail())
                    {
                        $srcfull1 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'large');
                        $srcfull = $srcfull1[0];
                        $img = get_the_post_thumbnail(get_the_ID(), 'product_thumb');
                        $img1 = get_the_post_thumbnail(get_the_ID(), 'blog-thumb2');
                    }
                    else
                    {
                        $srcfull = 'http://placehold.it/500x500';
                        $img = '<img src="http://placehold.it/240x300" alt="Theme doors"/>';
                        $img1 = '<img src="http://placehold.it/180x180" alt="Theme doors"/>';
                    }
                    if(get_post_meta( get_the_ID(), '_regular_price', true) != '')
                    {
                                        $price = number_format(get_post_meta( get_the_ID(), '_regular_price', true), 2, '.', '');
                    } 
                    elseif(get_post_meta( get_the_ID(), '_sale_price', true) != '')
                    {
                        $price = number_format(get_post_meta( get_the_ID(), '_sale_price', true), 2, '.', '');
                    }   
                    else
                    {
                        $price = number_format(0, 2, '.', '');
                    } 
                    
                    if($t == 1) { $recentitem_return .= '<div class="item active">';}
                    
                    $shop_view = get_option('shop_view', FALSE); 
                    
                     if($shop_view == 'box_view'):
                          $recentitem_return .= '<div class="col-lg-4">
                            <div class="product_block design_rating">
                                <div class="pb_thumb">
                                    <div class="pro_img">
                                        '.$img1.'
                                        <div class="pb_thumb_hover"><a href="'.$srcfull.'" data-rel="prettyPhoto"><i class="fa fa-paperclip"></i></a></div>
                                    </div>
                                </div>
                                <div class="pb_details">
                                    <h1>'.get_the_title().'</h1>
                                    <p class="pb_price">'.get_woocommerce_currency_symbol().''.$price.'</p>
                                    <p class="pb_rate">';
                                    global $woocommerce, $product;
                                    if ( $rating_html = $product->get_rating_html() ) :
                                          $recentitem_return .= $rating_html; 
                                    endif;
                                    $recentitem_return .= '</p>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                                <div class="pb_footer">
                                    <a href="'.  get_permalink().'" class="pb_deti_button">Details</a>
                                    '.do_shortcode('[add_to_cart id="'.get_the_ID().'"]').'
                                </div>
                            </div>
                        </div>';
                     else:
                         $cat = get_the_terms( get_the_ID(), 'product_cat');
                            if ( $cat && ! is_wp_error( $cat ) ) : 
                            foreach ( $cat as $c ) 
                            {
                               $ci = $c->name;
                               $cl = get_term_link( $c->slug, 'product_cat' );
                            }
                            else:
                                $ci = 'Uncategories';
                                $cl = '#';
                            endif;
                         $recentitem_return .= '<div class="col-lg-4">
                                    <div class="product_three">
                                        <div class="pttop">
                                            <a href="'.get_permalink().'"><i class="fa fa-chain-broken"></i></a>
                                            <a data-rel="prettyPhoto" href="'.$srcfull.'"><i class="fa fa-refresh"></i></a>
                                            '.do_shortcode('[add_to_cart id="'.get_the_ID().'"]').'
                                        </div>
                                        <div class="ptthumb">
                                            '.$img1.'
                                            <div class="ptthumb_hover"></div>
                                            <div class="pttcategory"><a href="'.$cl.'">'.$ci.'</a></div>
                                            <div class="pttprice"><span>'.get_woocommerce_currency_symbol().''.$price.'</span></div>
                                            <div class="pttrate">';

                                                    global $woocommerce, $product;
                                                    if ( $rating_html = $product->get_rating_html() ) :
                                                          $recentitem_return .= $rating_html; 
                                                    endif;

                                            $recentitem_return .='</div>
                                        </div>
                                        <div class="ptbottom">
                                            <a href="'.get_permalink().'">'.substr(get_the_title(), 0, 15).'</a>
                                        </div>
                                    </div>
                                </div>';
                     endif;
                   
                        
                    
                    if($t %  3 == 0 && $t < $total){ $recentitem_return .='</div><div class="item">';}
                    elseif($t % 3 == 0 && $t == $total){$recentitem_return .='</div>';}
                    elseif($t == $total){$recentitem_return .='</div>';}
                    $t++;
                }
                $recentitem_return .= '</div>';
                $recentitem_return .= '<a class="left carousel-control" href="#carousel-example-generic-f-product" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic-f-product" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                      </a>';
                $recentitem_return .= '</div>';
            }
            else
            {
                $recentitem_return .= '<h1 class="query_worning">Insert Some Product First</h1>';
            }
            wp_reset_query();
    }
    elseif($item == 'recent')
    {
        $products = array(
                'post_type'         => array('product'),
                'post_status'       => array('publish'),
                'orderby'           => 'date',
                'order'             => 'DESC',
                'posts_per_page'    => $number
            );
            query_posts($products);
            if(have_posts())
            {
                $total = 0; 
                while(have_posts()){the_post(); $total++;}
                
                $recentitem_return .= '<div id="carousel-example-generic-r-product" class="carousel slide" data-ride="carousel" data-interval="false">';
                $recentitem_return .= '<div class="carousel-inner">';
                $t = 1;
                while(have_posts())
                {
                    the_post();
                    if(has_post_thumbnail())
                    {
                        $srcfull1 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'large');
                        $srcfull = $srcfull1[0];
                        $img = get_the_post_thumbnail(get_the_ID(), 'product_thumb');
                        $img1 = get_the_post_thumbnail(get_the_ID(), 'blog-thumb2');
                    }
                    else
                    {
                        $srcfull = 'http://placehold.it/500x500';
                        $img = '<img src="http://placehold.it/240x300" alt="Theme doors"/>';
                        $img1 = '<img src="http://placehold.it/180x180" alt="Theme doors"/>';
                    }
                    if(get_post_meta( get_the_ID(), '_regular_price', true) != '')
                    {
                                        $price = number_format(get_post_meta( get_the_ID(), '_regular_price', true), 2, '.', '');
                    } 
                    elseif(get_post_meta( get_the_ID(), '_sale_price', true) != '')
                    {
                        $price = number_format(get_post_meta( get_the_ID(), '_sale_price', true), 2, '.', '');
                    }   
                    else
                    {
                        $price = number_format(0, 2, '.', '');
                    } 
                    
                    if($t == 1) { $recentitem_return .= '<div class="item active">';}
                    
                    
                   $shop_view = get_option('shop_view', FALSE); 
                    
                     if($shop_view == 'box_view'):
                          $recentitem_return .= '<div class="col-lg-4">
                            <div class="product_block design_rating">
                                <div class="pb_thumb">
                                    <div class="pro_img">
                                        '.$img1.'
                                        <div class="pb_thumb_hover"><a href="'.$srcfull.'" data-rel="prettyPhoto"><i class="fa fa-paperclip"></i></a></div>
                                    </div>
                                </div>
                                <div class="pb_details">
                                    <h1>'.get_the_title().'</h1>
                                    <p class="pb_price">'.get_woocommerce_currency_symbol().''.$price.'</p>
                                    <p class="pb_rate">';
                                    global $woocommerce, $product;
                                    if ( $rating_html = $product->get_rating_html() ) :
                                          $recentitem_return .= $rating_html; 
                                    endif;
                                    $recentitem_return .= '</p>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                                <div class="pb_footer">
                                    <a href="'.  get_permalink().'" class="pb_deti_button">Details</a>
                                    '.do_shortcode('[add_to_cart id="'.get_the_ID().'"]').'
                                </div>
                            </div>
                        </div>';
                     else:
                         $cat = get_the_terms( get_the_ID(), 'product_cat');
                            if ( $cat && ! is_wp_error( $cat ) ) : 
                            foreach ( $cat as $c ) 
                            {
                               $ci = $c->name;
                               $cl = get_term_link( $c->slug, 'product_cat' );
                            }
                            else:
                                $ci = 'Uncategories';
                                $cl = '#';
                            endif;
                         $recentitem_return .= '<div class="col-lg-4">
                                    <div class="product_three">
                                        <div class="pttop">
                                            <a href="'.get_permalink().'"><i class="fa fa-chain-broken"></i></a>
                                            <a data-rel="prettyPhoto" href="'.$srcfull.'"><i class="fa fa-refresh"></i></a>
                                            '.do_shortcode('[add_to_cart id="'.get_the_ID().'"]').'
                                        </div>
                                        <div class="ptthumb">
                                            '.$img1.'
                                            <div class="ptthumb_hover"></div>
                                            <div class="pttcategory"><a href="'.$cl.'">'.$ci.'</a></div>
                                            <div class="pttprice"><span>'.get_woocommerce_currency_symbol().''.$price.'</span></div>
                                            <div class="pttrate">';

                                                    global $woocommerce, $product;
                                                    if ( $rating_html = $product->get_rating_html() ) :
                                                          $recentitem_return .= $rating_html; 
                                                    endif;

                                            $recentitem_return .='</div>
                                        </div>
                                        <div class="ptbottom">
                                            <a href="'.get_permalink().'">'.substr(get_the_title(), 0, 15).'</a>
                                        </div>
                                    </div>
                                </div>';
                     endif;
                        
                    
                    if($t %  3 == 0 && $t < $total){ $recentitem_return .='</div><div class="item">';}
                    elseif($t % 3 == 0 && $t == $total){$recentitem_return .='</div>';}
                    elseif($t == $total){$recentitem_return .='</div>';}
                    $t++;
                }
                $recentitem_return .= '</div>';
                $recentitem_return .= '<a class="left carousel-control" href="#carousel-example-generic-r-product" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic-r-product" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                      </a>';
                $recentitem_return .= '</div>';
            }
            else
            {
                $recentitem_return .= '<h1 class="query_worning">Insert Some Product First</h1>';
            }
            wp_reset_query();
    }
    
    return $recentitem_return;
}

add_shortcode('tw-popupitem', 'popupitem');