<?php
    /*
     * Template Name: Parallax Section Page
     */
     

     $custom = MoreThumb::get_post_thumbnail_url(get_post_type(), 'parallax-image', $post->ID); 
     $url = $custom;
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
<section class="parallax-section funfacts" id="<?php echo return_default_lan($post->ID); ?>" style=" background: url(<?php echo $url;?>) no-repeat fixed center center rgba(0, 0, 0, 0);">
    <div class="parallax-content">
        <div class="container">
                <?php if(get_post_meta($post->ID, "doors_show_page_title", true) == 'yes'): ?>
                <div class="text-center wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">
                    <h1 class="white"><?php echo $title; ?></h1>
                        <?php if(get_post_meta($post->ID, "doors_page_subtitle", true) != ''): ?>
                    <p class="white" style="margin-bottom: 50px;"><?php echo get_post_meta($post->ID, "doors_page_subtitle", true); ?></p>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php
                    $content_post = get_post($post->ID);
                    $content = $content_post->post_content;
                    $content = apply_filters('the_content', $content);
                    echo $content;
                ?>
            
        </div>
    </div>
</section>

