<?php
    /*
     * Template Name: Portfolio Section Page
     */
     $pagetitle = get_post_meta($post->ID, 'doors_custom_page_title', TRUE);
     if($pagetitle == '')
     {
         $title = $post->post_title;
     }
     else
     {
         $title = $pagetitle;
     }
?>
<section id="<?php echo return_default_lan($post->ID); ?>" class="padding-top">
    <div class="container">
        <div class="row text-center section-title portfoliosection">
            <?php if(get_post_meta($post->ID, "doors_show_page_title", true) == 'yes'): ?>
                <div class="col-sm-6 col-sm-offset-3">
                        <h3 class="wow fadeInDown" data-wow-duration="700ms" data-wow-delay="300ms"><?php echo $title; ?></h3>
                        <hr class="title-border">
                        <?php if(get_post_meta($post->ID, "doors_page_subtitle", true) != ''): ?>
                        <p class="wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                            <?php echo get_post_meta($post->ID, "doors_page_subtitle", true); ?>
                        </p>
                        <?php endif; ?>
                </div>	
            <?php endif;?>
        </div>
    </div>
    <?php
        $content_post = get_post($post->ID);
        $content = $content_post->post_content;
        $content = apply_filters('the_content', $content);
        echo $content;
    ?>
</section>