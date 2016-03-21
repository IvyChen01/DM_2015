<?php
add_action('add_meta_boxes', 'xs_feature_meta_box');

function xs_feature_meta_box() {
    add_meta_box('features_exInfo', __('Feature Info', 'wt'), 'feature_extra_info', 'features', 'advanced', 'high');
}

function feature_extra_info($post) {
    ?>
    <?php $feature_link = get_post_meta($post->ID, 'feature_link', TRUE); ?>
    <div class="meta_tr">
        <div class="meta_lable" style="width:32%">Call To Action</div>
        <div class="meta_field" style="width:55%">
            <input type="text" name="feature_link" value="<?php echo $feature_link; ?>">
            <br/><p><small><i>If you like to use call to action add link. if you dont just use (.)</i></small></p>
        </div>
    </div>

    <div class="clear"></div>
    <?php
}

add_action('save_post', 'save_feature_info');

function save_feature_info($post_ID) {
    global $post;
    if (isset($_POST)):
        if (isset($_POST['feature_link'])):
            update_post_meta($post_ID, 'feature_link', $_POST['feature_link']);
        endif;

    endif;
}


//from tw carousel

//<div class="col-sm-4">
//    <a href="'.$feature_link.'" style="color:white">
//        <div class="brand-content wow fadeIn" data-wow-duration="700ms" data-wow-delay="300ms">
//                '.$thumb.'
//                <div class="media-body">							
//                        <h2>'.  get_the_title().'</h2>
//                        <p>'. substr(get_the_content(), 0, 90).'</p>
//                </div>
//        </div>
//    </a>						
//</div>