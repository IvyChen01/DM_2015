<?php

function recentPost($atts) {
    extract(shortcode_atts(array(
        'number' => '4'
                    ), $atts));

    $recent_return = '';


    $rp = array(
        'post_type' => array('post'),
        'post_status' => array('publish'),
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $number
    );
    query_posts($rp);
    if (have_posts()) {
        $recent_return .= '<div class="container"><div class="row servicegenerator">';

        while (have_posts()) {
            the_post();
            if (has_post_thumbnail()) {
                $bthumb = get_the_post_thumbnail(get_the_ID(), 'blog-thumb', array('class' => 'img-responsive'));
            } else {
                $bthumb = '<img src="http://placehold.it/240x355" alt="' . get_the_title() . '" class="img-responsive"/>';
            }
            $num_comments = get_comments_number(get_the_ID());

            if ($num_comments == 0) {
                $comments = __('0', 'tw');
            } elseif ($num_comments > 1) {
                $comments = $num_comments . __('', 'tw');
            } else {
                $comments = __('1', 'tw');
            }
            $write_comments = $comments;

            $recent_return .= '<div class="col-sm-12 col-md-6">
					<div class="single-blog wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
						<div class="blog-image">
							<a href="' . get_the_permalink() . '">' . $bthumb . '</a>
							<div class="post-date">
								<p>' . get_the_time('j') . '<span>' . get_the_time('F') . '</span></p>
							</div>
						</div>
						<div class="entry-content">							
							<a href="' . get_the_permalink() . '"><h2>' . substr(get_the_title(), 0, 30) . '</h2></a>
							<div class="entry-meta">
								<span><a href="#"><i class="fa fa-user"></i> Posted By: ' . get_the_author() . '</a></span>
								<span><a href="#"><i class="fa fa-comments"></i> ' . $write_comments . '</a></span>
							</div>
							<p>' . substr(force_balance_tags(get_the_content()), 0, 111) . '</p>
							<a href="' . get_the_permalink() . '" class="btn btn-primary">Read More</a>
						</div>
					</div>
				</div>';
        }

        $recent_return .= '</div></div>';
    }
    wp_reset_query();


    return $recent_return;
}

add_shortcode("doors-recentPost", "recentPost");
