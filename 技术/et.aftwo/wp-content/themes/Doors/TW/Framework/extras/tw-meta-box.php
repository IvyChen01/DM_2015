<?php
add_action('add_meta_boxes', 'doors_page_custome_meta_box');
function doors_page_custome_meta_box()
{
    add_meta_box('pageoptions', __('Page Options', 'tw'), 'page_options_meta_box', 'page', 'normal', 'low' );
}

function page_options_meta_box($post)
{
    $ispagesection = get_post_meta($post->ID, 'doors_is_page_section', TRUE);
    $showpagetitle = get_post_meta($post->ID, 'doors_show_page_title', TRUE);
    $subtitle = get_post_meta($post->ID, 'doors_page_subtitle', TRUE);
    $menustatus = get_post_meta($post->ID, 'doors_menu_disable_page', TRUE);
    $pagesection = get_post_meta($post->ID, 'doors_page_section', TRUE);
    $sectiontitle = get_post_meta($post->ID, 'doors_custom_page_title', TRUE);
?>
<div class="doors_metabox_field">
    <label for="doors_is_page_section">This page is a section:</label>
    <div class="field">
        <select name="doors_is_page_section" id="doors_is_page_section">
            <option value="yes">Yes</option>
            <option value="no" <?php if($ispagesection == 'no') { echo "Selected";} ?> >No</option>
        </select>
    </div>
</div>
<div class="doors_metabox_field">
    <label for="doors_show_page_title">Show page title:</label>
    <div class="field">
        <select name="doors_show_page_title" id="doors_show_page_title">
            <option value="yes">Yes</option>
            <option value="no" <?php if($showpagetitle == 'no') { echo "Selected";} ?> >No</option>
        </select>
    </div>
</div>
<div class="doors_metabox_field">
    <label for="doors_custom_page_title">Section Title:</label>
    <div class="field">
        <input type="text" value="<?php echo $sectiontitle; ?>" name="doors_custom_page_title" id="doors_custom_page_title">
    </div>
</div>
<div class="doors_metabox_field">
    <label for="doors_page_subtitle">Page Subtitle</label>
    <div class="field">
        <input type="text" name="doors_page_subtitle" id="doors_page_subtitle" value="<?php echo $subtitle; ?>"/>
    </div>
</div>
<div class="doors_metabox_field">
    <label for="doors_menu_disable_page">Disable page from menu:</label>
    <div class="field">
        <select name="doors_menu_disable_page" id="doors_menu_disable_page">
            <option value="no">No</option><option value="yes" <?php if($menustatus == 'yes') { echo "Selected";} ?> >Yes</option>
        </select>
    </div>
</div>
<div class="doors_metabox_field">
    <label for="doors_page_section">Assign current page as</label>
    <div class="field">
        <select name="doors_page_section" id="doors_page_section">
            <option value="default">Default Section</option>
            <option value="portfolio" <?php if($pagesection == 'portfolio') { echo 'Selected'; } ?> >Portfolio Section</option>
            <option value="parallax" <?php if($pagesection == 'parallax') { echo 'Selected'; } ?> >Parallax Section</option>
            <option value="contact" <?php if($pagesection == 'contact') { echo 'Selected'; } ?> >Contact Section</option>
            <option value="funfact" <?php if($pagesection == 'funfact') { echo 'Selected'; } ?> >Fun Fact Section</option>
        </select>
    </div>
</div>
<?php
}
add_action( 'save_post', 'save_page_option_info' );
function save_page_option_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            
            if(isset($_POST['doors_is_page_section']) && $_POST['doors_is_page_section'] != ''):
                update_post_meta($post_ID, 'doors_is_page_section', $_POST['doors_is_page_section']);
            endif;
            if(isset($_POST['doors_show_page_title']) && $_POST['doors_show_page_title'] != ''):
                update_post_meta($post_ID, 'doors_show_page_title', $_POST['doors_show_page_title']);
            endif;
            if(isset($_POST['doors_page_subtitle']) && $_POST['doors_page_subtitle'] != ''):
                update_post_meta($post_ID, 'doors_page_subtitle', $_POST['doors_page_subtitle']);
            endif;
            if(isset($_POST['doors_menu_disable_page']) && $_POST['doors_menu_disable_page'] != ''):
                update_post_meta($post_ID, 'doors_menu_disable_page', $_POST['doors_menu_disable_page']);
            endif;
            if(isset($_POST['doors_page_section']) && $_POST['doors_page_section'] != ''):
                update_post_meta($post_ID, 'doors_page_section', $_POST['doors_page_section']);
            endif;
            if(isset($_POST['doors_custom_page_title']) && $_POST['doors_custom_page_title'] != ''):
                update_post_meta($post_ID, 'doors_custom_page_title', $_POST['doors_custom_page_title']);
            endif;
    endif;
}

add_action('add_meta_boxes', 'doors_contact_custome_meta_box');
function doors_contact_custome_meta_box()
{
    add_meta_box('contactpageoption', __('Contact Section Settings', 'tw'), 'contact_options_meta_box', 'page', 'normal', 'low' );
}


function contact_options_meta_box($post)
{
    $conimage = get_post_meta($post->ID, 'doors_contact_image', TRUE);
    $pagesection = get_post_meta($post->ID, 'doors_page_section', TRUE);
    $contactmap = get_post_meta($post->ID, 'doors_contact_map', TRUE);
    if($pagesection == 'contact') { $dis = 'display: block;'; } else {$dis = 'display: none;';}
    ?>
<style>
    #contactpageoption{<?php echo $dis; ?>}
</style>
<div class="doors_metabox_field">
        <label for="doors_contact_image">Contact Image</label>
        <div class="field">
            <div class="field">
                <input type="text" value="<?php echo $conimage; ?>" id="doors_contact_image" class="upload_field" name="doors_contact_image">
                <input type="button" value="Browse" class="upload_button">
            </div>
        </div>
    </div>
<div class="doors_metabox_field">
    <label for="doors_contact_map">Disable Contact Map</label>
    <div class="field">
        <select name="doors_contact_map" id="doors_contact_map">
            <option value="no" >No</option>
            <option value="yes" <?php if($contactmap == 'yes') { echo 'Selected'; } ?> >Yes</option>
            
        </select>
    </div>
</div>
    <?php
}

add_action( 'save_post', 'save_contact_option_info' );
function save_contact_option_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            
            if(isset($_POST['doors_contact_image']) && $_POST['doors_contact_image'] != ''):
                update_post_meta($post_ID, 'doors_contact_image', $_POST['doors_contact_image']);
            endif;
            if(isset($_POST['doors_contact_map']) && $_POST['doors_contact_map'] != ''):
                update_post_meta($post_ID, 'doors_contact_map', $_POST['doors_contact_map']);
            endif;
    endif;
}

add_action('add_meta_boxes', 'doors_normal_custome_meta_box');
function doors_normal_custome_meta_box()
{
    add_meta_box('normalpagesettings', __('Normal Page Settings', 'tw'), 'normalpage_options_meta_box', 'page', 'normal', 'low' );
}

function normalpage_options_meta_box($post)
{
    $npage = get_post_meta($post->ID, 'doors_normal_page', TRUE);
    $author = get_post_meta($post->ID, 'doors_author_meta', TRUE);
    $comment = get_post_meta($post->ID, 'newave_comment_section', TRUE);
    ?>
    <div class="doors_metabox_field">
        <label for="doors_normal_page">Sidebar Status</label>
        <div class="field">
            <select id="doors_normal_page" name="doors_normal_page">
                <option value="show">Show Sidebar</option>
                <option value="hide" <?php if($npage == 'hide') { echo 'Selected'; } ?> >Hide Sidebar</option>
            </select>
        </div>
    </div>
    <div class="doors_metabox_field">
        <label for="doors_author_meta">Author Meta Status</label>
        <div class="field">
            <select id="doors_author_meta" name="doors_author_meta">
                <option value="show">Show Author</option>
                <option value="hide" <?php if($author == 'hide') { echo 'Selected'; } ?> >Hide Author</option>
            </select>
        </div>
    </div>
    <div class="doors_metabox_field">
        <label for="newave_comment_section">Comment Status</label>
        <div class="field">
            <select id="newave_comment_section" name="newave_comment_section">
                <option value="show">Show Comment</option>
                <option value="hide" <?php if($comment == 'hide') { echo 'Selected'; } ?> >Hide Comment</option>
            </select>
        </div>
    </div>
    <?php
}
add_action( 'save_post', 'save_normalpage_option_info' );
function save_normalpage_option_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            
            if(isset($_POST['doors_normal_page']) && $_POST['doors_normal_page'] != ''):
                update_post_meta($post_ID, 'doors_normal_page', $_POST['doors_normal_page']);
            endif;
            if(isset($_POST['doors_author_meta']) && $_POST['doors_author_meta'] != ''):
                update_post_meta($post_ID, 'doors_author_meta', $_POST['doors_author_meta']);
            endif;
            if(isset($_POST['newave_comment_section']) && $_POST['newave_comment_section'] != ''):
                update_post_meta($post_ID, 'newave_comment_section', $_POST['newave_comment_section']);
            endif;
    endif;
}



add_action('add_meta_boxes', 'doors_team_custome_meta_box');
function doors_team_custome_meta_box()
{
    add_meta_box('team_exInfo', __('Extra Info', 'winter'), 'team_extra_info', 'team', 'advanced', 'high' );
}

function team_extra_info($post)
{
?>
    <?php $facebook = get_post_meta($post->ID, 'facebook', true); ?>
    <div class="meta_tr"><div class="meta_lable">Facebook</div><div class="meta_field"><input type="text" name="facebook" value="<?php if($facebook != '') { echo $facebook;} ?>" placeholder="http://"></div></div>
    <?php $drible = get_post_meta($post->ID, 'drible', true); ?>
    <div class="meta_tr"><div class="meta_lable">Dribble</div><div class="meta_field"><input type="text" name="drible" value="<?php echo $drible; ?>" placeholder="http://"></div></div>
    <?php $twitter = get_post_meta($post->ID, 'twitter', true); ?>
    <div class="meta_tr"><div class="meta_lable">Twitter</div><div class="meta_field"><input type="text" name="twitter" value="<?php echo $twitter; ?>" placeholder="http://"></div></div>
    <?php $google = get_post_meta($post->ID, 'google', true); ?>
    <div class="meta_tr"><div class="meta_lable">Google Plus</div><div class="meta_field"><input type="text" name="google" value="<?php echo $google; ?>" placeholder="http://"></div></div>
    <?php $linkedin= get_post_meta($post->ID, 'linkedin', true); ?>
    <div class="meta_tr"><div class="meta_lable">Linked In</div><div class="meta_field"><input type="text" name="linkedin" value="<?php echo $linkedin; ?>" placeholder="http://"></div></div>
    
    <div class="clr"></div>
<?php
}

add_action( 'save_post', 'save_team_extra_info' );
function save_team_extra_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            if(isset($_POST['facebook'])):
            update_post_meta($post_ID, 'facebook', $_POST['facebook']);
            endif;
            if(isset($_POST['drible'])):
            update_post_meta($post_ID, 'drible', $_POST['drible']);
            endif;
            if(isset($_POST['twitter'])):
            update_post_meta($post_ID, 'twitter', $_POST['twitter']);
            endif;
            if(isset($_POST['google'])):
            update_post_meta($post_ID, 'google', $_POST['google']);
            endif;
            if(isset($_POST['linkedin'])):
            update_post_meta($post_ID, 'linkedin', $_POST['linkedin']);
            endif;
    endif;
}




add_action('add_meta_boxes', 'doors_testimonial_custome_meta_box');
function doors_testimonial_custome_meta_box()
{
    add_meta_box('team_exInfo', __('Extra Info', 'winter'), 'testimonial_extra_info', 'testimonial', 'advanced', 'high' );
}

function testimonial_extra_info($post)
{
?>
    <?php $designation = get_post_meta($post->ID, 'designation', true); ?>
    <div class="meta_tr"><div class="meta_lable">Designation</div><div class="meta_field"><input type="text" name="designation" value="<?php echo $designation; ?>"></div></div>
    <div class="clear"></div>
<?php
}

add_action( 'save_post', 'save_testimonial_extra_info' );
function save_testimonial_extra_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            if(isset($_POST['designation']) && $_POST['designation'] != ''):
                update_post_meta($post_ID, 'designation', $_POST['designation']);
            endif;
    endif;
}

add_action('add_meta_boxes', 'doors_client_meta_box');
function doors_client_meta_box()
{
    add_meta_box('team_exInfo', __('Extra Info', 'wt'), 'client_extra_info', 'client', 'advanced', 'high' );
}

function client_extra_info($post)
{
?>
    <?php $clientlink = get_post_meta($post->ID, 'clientlink', TRUE);?>
    <div class="meta_tr"><div class="meta_lable">Client Link</div><div class="meta_field"><input type="text" name="clientlink" value="<?php echo $clientlink; ?>"></div></div>
    <div class="clear"></div>
<?php
}
add_action( 'save_post', 'save_client_link_info' );
function save_client_link_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            if(isset($_POST['clientlink']) && $_POST['clientlink'] != ''):
                update_post_meta($post_ID, 'clientlink', $_POST['clientlink']);
            endif;
    endif;
}





add_action('add_meta_boxes', 'xs_portfolio_meta_box');

function xs_portfolio_meta_box() {
    add_meta_box('team_exInfo', __('Portfolio Info', 'wt'), 'portfolio_extra_info', 'portfolio', 'advanced', 'high');
}

function portfolio_extra_info($post) {
    ?>
    
     <?php $aboutPortfolio = get_post_meta($post->ID, 'aboutPortfolio', TRUE); ?>
    <div style="width: 100%">
        <div style="width: 20%;float: left;">About Portfolio</div>
        <div style="width: 80%;float: left;">
            <textarea name="aboutPortfolio" id="" cols="60" rows="5"><?php echo $aboutPortfolio; ?></textarea>
            <br/><p><small><i>About Portfolio.</i></small></p>
        </div>
    </div>
    <?php $portfolioClients = get_post_meta($post->ID, 'portfolioClients', TRUE); ?>
    <div class="meta_tr">
        <div class="meta_lable">Client</div>
        <div class="meta_field">
            <input type="text" name="portfolioClients" value="<?php echo $portfolioClients; ?>"><br/>
            <p><i><small>Insert Client Name.</small></i></p>
        </div>
    </div>
    <?php $releaseDate = get_post_meta($post->ID, 'releaseDate', TRUE); ?>
    <div class="meta_tr">
        <div class="meta_lable">Release Date</div>
        <div class="meta_field">
            <input type="text" name="releaseDate" value="<?php echo $releaseDate; ?>">
            <br/><p><small><i>Insert Date with (October 28, 2014) this format.</i></small></p>
        </div>
    </div>
    <?php $liveLink = get_post_meta($post->ID, 'liveLink', TRUE); ?>
    <div class="meta_tr">
        <div class="meta_lable">Live Link</div>
        <div class="meta_field">
            <input type="text" name="liveLink" value="<?php echo $liveLink; ?>">
            <br/><p><small><i>Insert Project Live Link.</i></small></p>
        </div>
    </div>
   
    <div class="clear"></div>
    <?php
}

add_action('save_post', 'save_portfolio_info');

function save_portfolio_info($post_ID) {
    global $post;
    if (isset($_POST)):
        if (isset($_POST['portfolioClients'])):
            update_post_meta($post_ID, 'portfolioClients', $_POST['portfolioClients']);
        endif;
        if (isset($_POST['releaseDate'])):
            update_post_meta($post_ID, 'releaseDate', $_POST['releaseDate']);
        endif;
        if (isset($_POST['liveLink'])):
            update_post_meta($post_ID, 'liveLink', $_POST['liveLink']);
        endif;
        if (isset($_POST['aboutPortfolio'])):
            update_post_meta($post_ID, 'aboutPortfolio', $_POST['aboutPortfolio']);
        endif;
    endif;
}







add_action('add_meta_boxes', 'tw_service_meta_box');
function tw_service_meta_box()
{
    add_meta_box('team_exInfo', __('Icon Info', 'wt'), 'service_icon_info', 'service', 'side', 'high' );
}

function service_icon_info($post)
{
?>
    <?php $serviceIcon = get_post_meta($post->ID, 'serviceIcon', TRUE);?>
    <div class="meta_tr" style="width: 100%;">
        <div class="meta_lable">Service Icon</div>
        <div class="meta_field">
            <?php
                $icon = array(
'' => 'None', 
'fa-adjust' => 'adjust',
'fa-anchor' => 'anchor',
'fa-archive' => 'archive',
'fa-arrows' => 'arrows',
'fa-arrows-h' => 'arrows-h',
'fa-arrows-v' => 'arrows-v',
'fa-asterisk' => 'asterisk',
'fa-automobile' => 'automobile',
'fa-ban' => 'ban',
'fa-bank' => 'bank',
'fa-bar-chart-o' => 'bar-chart-o',
'fa-barcode' => 'barcode',
'fa-bars' => 'bars',
'fa-beer' => 'beer',
'fa-bell' => 'bell',
'fa-bell-o' => 'bell-o',
'fa-bolt' => 'bolt',
'fa-bomb' => 'bomb',
'fa-book' => 'book',
'fa-bookmark' => 'bookmark',
'fa-bookmark-o' => 'bookmark-o',
'fa-briefcase' => 'briefcase',
'fa-bug' => 'bug',
'fa-building' => 'building',
'fa-building-o' => 'building-o',
'fa-bullhorn' => 'bullhorn',
'fa-bullseye' => 'bullseye',
'fa-cab' => 'cab',
'fa-calendar' => 'calendar',
'fa-calendar-o' => 'calendar-o',
'fa-camera' => 'camera',
'fa-camera-retro' => 'camera-retro',
'fa-car' => 'car',
'fa-caret-square-o-down' => 'caret-square-o-down',
'fa-caret-square-o-left' => 'caret-square-o-left',
'fa-caret-square-o-right' => 'caret-square-o-right',
'fa-caret-square-o-up' => 'caret-square-o-up',
'fa-certificate' => 'certificate',
'fa-check' => 'check',
'fa-check-circle' => 'check-circle',
'fa-check-circle-o' => 'check-circle-o',
'fa-check-square' => 'check-square',
'fa-check-square-o' => 'check-square-o',
'fa-child' => 'child',
'fa-circle' => 'circle',
'fa-circle-o' => 'circle-o',
'fa-circle-o-notch' => 'circle-o-notch',
'fa-circle-thin' => 'circle-thin',
'fa-clock-o' => 'clock-o',
'fa-cloud' => 'cloud',
'fa-cloud-download' => 'cloud-download',
'fa-cloud-upload' => 'cloud-upload',
'fa-code' => 'code',
'fa-code-fork' => 'code-fork',
'fa-coffee' => 'coffee',
'fa-cog' => 'cog',
'fa-cogs' => 'cogs',
'fa-comment' => 'comment',
'fa-comment-o' => 'comment-o',
'fa-comments' => 'comments',
'fa-comments-o' => 'comments-o',
'fa-compass' => 'compass',
'fa-credit-card' => 'credit-card',
'fa-crop' => 'crop',
'fa-crosshairs' => 'crosshairs',
'fa-cube' => 'cube',
'fa-cubes' => 'cubes',
'fa-cutlery' => 'cutlery',
'fa-dashboard' => 'dashboard',
'fa-database' => 'database',
'fa-desktop' => 'desktop',
'fa-dot-circle-o' => 'dot-circle-o',
'fa-download' => 'download',
'fa-edit' => 'edit',
'fa-ellipsis-h' => 'ellipsis-h',
'fa-ellipsis-v' => 'ellipsis-v',
'fa-envelope' => 'envelope',
'fa-envelope-o' => 'envelope-o',
'fa-envelope-square' => 'envelope-square',
'fa-eraser' => 'eraser',
'fa-exchange' => 'exchange',
'fa-exclamation' => 'exclamation',
'fa-exclamation-circle' => 'exclamation-circle',
'fa-exclamation-triangle' => 'exclamation-triangle',
'fa-external-link' => 'external-link',
'fa-external-link-square' => 'external-link-square',
'fa-eye' => 'eye',
'fa-eye-slash' => 'eye-slash',
'fa-fax' => 'fax',
'fa-female' => 'female',
'fa-fighter-jet' => 'fighter-jet',
'fa-file-archive-o' => 'file-archive-o',
'fa-file-audio-o' => 'file-audio-o',
'fa-file-code-o' => 'file-code-o',
'fa-file-excel-o' => 'file-excel-o',
'fa-file-image-o' => 'file-image-o',
'fa-file-movie-o' => 'file-movie-o',
'fa-file-pdf-o' => 'file-pdf-o',
'fa-file-photo-o' => 'file-photo-o',
'fa-file-picture-o' => 'file-picture-o',
'fa-file-powerpoint-o' => 'file-powerpoint-o',
'fa-file-sound-o' => 'file-sound-o',
'fa-file-video-o' => 'file-video-o',
'fa-file-word-o' => 'file-word-o',
'fa-file-zip-o' => 'file-zip-o',
'fa-film' => 'film',
'fa-filter' => 'filter',
'fa-fire' => 'fire',
'fa-fire-extinguisher' => 'fire-extinguisher',
'fa-flag' => 'flag',
'fa-flag-checkered' => 'flag-checkered',
'fa-flag-o' => 'flag-o',
'fa-flash' => 'flash',
'fa-flask' => 'flask',
'fa-folder' => 'folder',
'fa-folder-o' => 'folder-o',
'fa-folder-open' => 'folder-open',
'fa-folder-open-o' => 'folder-open-o',
'fa-frown-o' => 'frown-o',
'fa-gamepad' => 'gamepad',
'fa-gavel' => 'gavel',
'fa-gear' => 'gear',
'fa-gears' => 'gears',
'fa-gift' => 'gift',
'fa-glass' => 'glass',
'fa-globe' => 'globe',
'fa-graduation-cap' => 'graduation-cap',
'fa-group' => 'group',
'fa-hdd-o' => 'hdd-o',
'fa-headphones' => 'headphones',
'fa-heart' => 'heart',
'fa-heart-o' => 'heart-o',
'fa-history' => 'history',
'fa-home' => 'home',
'fa-image' => 'image',
'fa-inbox' => 'inbox',
'fa-info' => 'info',
'fa-info-circle' => 'info-circle',
'fa-institution' => 'institution',
'fa-key' => 'key',
'fa-keyboard-o' => 'keyboard-o',
'fa-language' => 'language',
'fa-laptop' => 'laptop',
'fa-leaf' => 'leaf',
'fa-legal' => 'legal',
'fa-lemon-o' => 'lemon-o',
'fa-level-down' => 'level-down',
'fa-level-up' => 'level-up',
'fa-life-bouy' => 'life-bouy',
'fa-life-ring' => 'life-ring',
'fa-life-saver' => 'life-saver',
'fa-lightbulb-o' => 'lightbulb-o',
'fa-location-arrow' => 'location-arrow',
'fa-lock' => 'lock',
'fa-magic' => 'magic',
'fa-magnet' => 'magnet',
'fa-mail-forward' => 'mail-forward',
'fa-mail-reply' => 'mail-reply',
'fa-mail-reply-all' => 'mail-reply-all',
'fa-male' => 'male',
'fa-map-marker' => 'map-marker',
'fa-meh-o' => 'meh-o',
'fa-microphone' => 'microphone',
'fa-microphone-slash' => 'microphone-slash',
'fa-minus' => 'minus',
'fa-minus-circle' => 'minus-circle',
'fa-minus-square' => 'minus-square',
'fa-minus-square-o' => 'minus-square-o',
'fa-mobile' => 'mobile',
'fa-mobile-phone' => 'mobile-phone',
'fa-money' => 'money',
'fa-moon-o' => 'moon-o',
'fa-mortar-board' => 'mortar-board',
'fa-music' => 'music',
'fa-navicon' => 'navicon',
'fa-paper-plane' => 'paper-plane',
'fa-paper-plane-o' => 'paper-plane-o',
'fa-paw' => 'paw',
'fa-pencil' => 'pencil',
'fa-pencil-square' => 'pencil-square',
'fa-pencil-square-o' => 'pencil-square-o',
'fa-phone' => 'phone',
'fa-phone-square' => 'phone-square',
'fa-photo' => 'photo',
'fa-picture-o' => 'picture-o',
'fa-plane' => 'plane',
'fa-plus' => 'plus',
'fa-plus-circle' => 'plus-circle',
'fa-plus-square' => 'plus-square',
'fa-plus-square-o' => 'plus-square-o',
'fa-power-off' => 'power-off',
'fa-print' => 'print',
'fa-puzzle-piece' => 'puzzle-piece',
'fa-qrcode' => 'qrcode',
'fa-question' => 'question',
'fa-question-circle' => 'question-circle',
'fa-quote-left' => 'quote-left',
'fa-quote-right' => 'quote-right',
'fa-random' => 'random',
'fa-recycle' => 'recycle',
'fa-refresh' => 'refresh',
'fa-reorder' => 'reorder',
'fa-reply' => 'reply',
'fa-reply-all' => 'reply-all',
'fa-retweet' => 'retweet',
'fa-road' => 'road',
'fa-rocket' => 'rocket',
'fa-rss' => 'rss',
'fa-rss-square' => 'rss-square',
'fa-search' => 'search',
'fa-search-minus' => 'search-minus',
'fa-search-plus' => 'search-plus',
'fa-send' => 'send',
'fa-send-o' => 'send-o',
'fa-share' => 'share',
'fa-share-alt' => 'share-alt',
'fa-share-alt-square' => 'share-alt-square',
'fa-share-square' => 'share-square',
'fa-share-square-o' => 'share-square-o',
'fa-shield' => 'shield',
'fa-shopping-cart' => 'shopping-cart',
'fa-sign-in' => 'sign-in',
'fa-sign-out' => 'sign-out',
'fa-signal' => 'signal',
'fa-sitemap' => 'sitemap',
'fa-sliders' => 'sliders',
'fa-smile-o' => 'smile-o',
'fa-sort' => 'sort',
'fa-sort-alpha-asc' => 'sort-alpha-asc',
'fa-sort-alpha-desc' => 'sort-alpha-desc',
'fa-sort-amount-asc' => 'sort-amount-asc',
'fa-sort-amount-desc' => 'sort-amount-desc',
'fa-sort-asc' => 'sort-asc',
'fa-sort-desc' => 'sort-desc',
'fa-sort-down' => 'sort-down',
'fa-sort-numeric-asc' => 'sort-numeric-asc',
'fa-sort-numeric-desc' => 'sort-numeric-desc',
'fa-sort-up' => 'sort-up',
'fa-space-shuttle' => 'space-shuttle',
'fa-spinner' => 'spinner',
'fa-spoon' => 'spoon',
'fa-square' => 'square',
'fa-square-o' => 'square-o',
'fa-star' => 'star',
'fa-star-half' => 'star-half',
'fa-star-half-empty' => 'star-half-empty',
'fa-star-half-full' => 'star-half-full',
'fa-star-half-o' => 'star-half-o',
'fa-star-o' => 'star-o',
'fa-suitcase' => 'suitcase',
'fa-sun-o' => 'sun-o',
'fa-support' => 'support',
'fa-tablet' => 'tablet',
'fa-tachometer' => 'tachometer',
'fa-tag' => 'tag',
'fa-tags' => 'tags',
'fa-tasks' => 'tasks',
'fa-taxi' => 'taxi',
'fa-terminal' => 'terminal',
'fa-thumb-tack' => 'thumb-tack',
'fa-thumbs-down' => 'thumbs-down',
'fa-thumbs-o-down' => 'thumbs-o-down',
'fa-thumbs-o-up' => 'thumbs-o-up',
'fa-thumbs-up' => 'thumbs-up',
'fa-ticket' => 'ticket',
'fa-times' => 'times',
'fa-times-circle' => 'times-circle',
'fa-times-circle-o' => 'times-circle-o',
'fa-tint' => 'tint',
'fa-toggle-down' => 'toggle-down',
'fa-toggle-left' => 'toggle-left',
'fa-toggle-right' => 'toggle-right',
'fa-toggle-up' => 'toggle-up',
'fa-trash-o' => 'trash-o',
'fa-tree' => 'tree',
'fa-trophy' => 'trophy',
'fa-truck' => 'truck',
'fa-umbrella' => 'umbrella',
'fa-university' => 'university',
'fa-unlock' => 'unlock',
'fa-unlock-alt' => 'unlock-alt',
'fa-unsorted' => 'unsorted',
'fa-upload' => 'upload',
'fa-user' => 'user',
'fa-users' => 'users',
'fa-video-camera' => 'video-camera',
'fa-volume-down' => 'volume-down',
'fa-volume-off' => 'volume-off',
'fa-volume-up' => 'volume-up',
'fa-warning' => 'warning',
'fa-wheelchair' => 'wheelchair',
'fa-wrench' => 'wrench',
'fa-file' => 'file',
'fa-file-archive-o' => 'file-archive-o',
'fa-file-audio-o' => 'file-audio-o',
'fa-file-code-o' => 'file-code-o',
'fa-file-excel-o' => 'file-excel-o',
'fa-file-image-o' => 'file-image-o',
'fa-file-movie-o' => 'file-movie-o',
'fa-file-o' => 'file-o',
'fa-file-pdf-o' => 'file-pdf-o',
'fa-file-photo-o' => 'file-photo-o',
'fa-file-picture-o' => 'file-picture-o',
'fa-file-powerpoint-o' => 'file-powerpoint-o',
'fa-file-sound-o' => 'file-sound-o',
'fa-file-text' => 'file-text',
'fa-file-text-o' => 'file-text-o',
'fa-file-video-o' => 'file-video-o',
'fa-file-word-o' => 'file-word-o',
'fa-file-zip-o' => 'file-zip-o',
'fa-circle-o-notch' => 'circle-o-notch',
'fa-cog' => 'cog',
'fa-gear' => 'gear',
'fa-refresh' => 'refresh',
'fa-spinner' => 'spinner',
'fa-check-square' => 'check-square',
'fa-check-square-o' => 'check-square-o',
'fa-circle' => 'circle',
'fa-circle-o' => 'circle-o',
'fa-dot-circle-o' => 'dot-circle-o',
'fa-minus-square' => 'minus-square',
'fa-minus-square-o' => 'minus-square-o',
'fa-plus-square' => 'plus-square',
'fa-plus-square-o' => 'plus-square-o',
'fa-square' => 'square',
'fa-square-o' => 'square-o',
'fa-bitcoin' => 'bitcoin',
'fa-btc' => 'btc',
'fa-cny' => 'cny',
'fa-dollar' => 'dollar',
'fa-eur' => 'eur',
'fa-euro' => 'euro',
'fa-gbp' => 'gbp',
'fa-inr' => 'inr',
'fa-jpy' => 'jpy',
'fa-krw' => 'krw',
'fa-money' => 'money',
'fa-rmb' => 'rmb',
'fa-rouble' => 'rouble',
'fa-rub' => 'rub',
'fa-ruble' => 'ruble',
'fa-rupee' => 'rupee',
'fa-try' => 'try',
'fa-turkish-lira' => 'turkish-lira',
'fa-usd' => 'usd',
'fa-won' => 'won',
'fa-yen' => 'yen',
'fa-align-center' => 'align-center',
'fa-align-justify' => 'align-justify',
'fa-align-left' => 'align-left',
'fa-align-right' => 'align-right',
'fa-bold' => 'bold',
'fa-chain' => 'chain',
'fa-chain-broken' => 'chain-broken',
'fa-clipboard' => 'clipboard',
'fa-columns' => 'columns',
'fa-copy' => 'copy',
'fa-cut' => 'cut',
'fa-dedent' => 'dedent',
'fa-eraser' => 'eraser',
'fa-file' => 'file',
'fa-file-o' => 'file-o',
'fa-file-text' => 'file-text',
'fa-file-text-o' => 'file-text-o',
'fa-files-o' => 'files-o',
'fa-floppy-o' => 'floppy-o',
'fa-font' => 'font',
'fa-header' => 'header',
'fa-indent' => 'indent',
'fa-italic' => 'italic',
'fa-link' => 'link',
'fa-list' => 'list',
'fa-list-alt' => 'list-alt',
'fa-list-ol' => 'list-ol',
'fa-list-ul' => 'list-ul',
'fa-outdent' => 'outdent',
'fa-paperclip' => 'paperclip',
'fa-paragraph' => 'paragraph',
'fa-paste' => 'paste',
'fa-repeat' => 'repeat',
'fa-rotate-left' => 'rotate-left',
'fa-rotate-right' => 'rotate-right',
'fa-save' => 'save',
'fa-scissors' => 'scissors',
'fa-strikethrough' => 'strikethrough',
'fa-subscript' => 'subscript',
'fa-superscript' => 'superscript',
'fa-table' => 'table',
'fa-text-height' => 'text-height',
'fa-text-width' => 'text-width',
'fa-th' => 'th',
'fa-th-large' => 'th-large',
'fa-th-list' => 'th-list',
'fa-underline' => 'underline',
'fa-undo' => 'undo',
'fa-unlink' => 'unlink',
'fa-angle-double-down' => 'angle-double-down',
'fa-angle-double-left' => 'angle-double-left',
'fa-angle-double-right' => 'angle-double-right',
'fa-angle-double-up' => 'angle-double-up',
'fa-angle-down' => 'angle-down',
'fa-angle-left' => 'angle-left',
'fa-angle-right' => 'angle-right',
'fa-angle-up' => 'angle-up',
'fa-arrow-circle-down' => 'arrow-circle-down',
'fa-arrow-circle-left' => 'arrow-circle-left',
'fa-arrow-circle-o-down' => 'arrow-circle-o-down',
'fa-arrow-circle-o-left' => 'arrow-circle-o-left',
'fa-arrow-circle-o-right' => 'arrow-circle-o-right',
'fa-arrow-circle-o-up' => 'arrow-circle-o-up',
'fa-arrow-circle-right' => 'arrow-circle-right',
'fa-arrow-circle-up' => 'arrow-circle-up',
'fa-arrow-down' => 'arrow-down',
'fa-arrow-left' => 'arrow-left',
'fa-arrow-right' => 'arrow-right',
'fa-arrow-up' => 'arrow-up',
'fa-arrows' => 'arrows',
'fa-arrows-alt' => 'arrows-alt',
'fa-arrows-h' => 'arrows-h',
'fa-arrows-v' => 'arrows-v',
'fa-caret-down' => 'caret-down',
'fa-caret-left' => 'caret-left',
'fa-caret-right' => 'caret-right',
'fa-caret-square-o-down' => 'caret-square-o-down',
'fa-caret-square-o-left' => 'caret-square-o-left',
'fa-caret-square-o-right' => 'caret-square-o-right',
'fa-caret-square-o-up' => 'caret-square-o-up',
'fa-caret-up' => 'caret-up',
'fa-chevron-circle-down' => 'chevron-circle-down',
'fa-chevron-circle-left' => 'chevron-circle-left',
'fa-chevron-circle-right' => 'chevron-circle-right',
'fa-chevron-circle-up' => 'chevron-circle-up',
'fa-chevron-down' => 'chevron-down',
'fa-chevron-left' => 'chevron-left',
'fa-chevron-right' => 'chevron-right',
'fa-chevron-up' => 'chevron-up',
'fa-hand-o-down' => 'hand-o-down',
'fa-hand-o-left' => 'hand-o-left',
'fa-hand-o-right' => 'hand-o-right',
'fa-hand-o-up' => 'hand-o-up',
'fa-long-arrow-down' => 'long-arrow-down',
'fa-long-arrow-left' => 'long-arrow-left',
'fa-long-arrow-right' => 'long-arrow-right',
'fa-long-arrow-up' => 'long-arrow-up',
'fa-toggle-down' => 'toggle-down',
'fa-toggle-left' => 'toggle-left',
'fa-toggle-right' => 'toggle-right',
'fa-toggle-up' => 'toggle-up',
'fa-arrows-alt' => 'arrows-alt',
'fa-backward' => 'backward',
'fa-compress' => 'compress',
'fa-eject' => 'eject',
'fa-expand' => 'expand',
'fa-fast-backward' => 'fast-backward',
'fa-fast-forward' => 'fast-forward',
'fa-forward' => 'forward',
'fa-pause' => 'pause',
'fa-play' => 'play',
'fa-play-circle' => 'play-circle',
'fa-play-circle-o' => 'play-circle-o',
'fa-step-backward' => 'step-backward',
'fa-step-forward' => 'step-forward',
'fa-stop' => 'stop',
'fa-youtube-play' => 'youtube-play',
'fa-adn' => 'adn',
'fa-android' => 'android',
'fa-apple' => 'apple',
'fa-behance' => 'behance',
'fa-behance-square' => 'behance-square',
'fa-bitbucket' => 'bitbucket',
'fa-bitbucket-square' => 'bitbucket-square',
'fa-bitcoin' => 'bitcoin',
'fa-btc' => 'btc',
'fa-codepen' => 'codepen',
'fa-css3' => 'css3',
'fa-delicious' => 'delicious',
'fa-deviantart' => 'deviantart',
'fa-digg' => 'digg',
'fa-dribbble' => 'dribbble',
'fa-dropbox' => 'dropbox',
'fa-drupal' => 'drupal',
'fa-empire' => 'empire',
'fa-facebook' => 'facebook',
'fa-facebook-square' => 'facebook-square',
'fa-flickr' => 'flickr',
'fa-foursquare' => 'foursquare',
'fa-ge' => 'ge',
'fa-git' => 'git',
'fa-git-square' => 'git-square',
'fa-github' => 'github',
'fa-github-alt' => 'github-alt',
'fa-github-square' => 'github-square',
'fa-gittip' => 'gittip',
'fa-google' => 'google',
'fa-google-plus' => 'google-plus',
'fa-google-plus-square' => 'google-plus-square',
'fa-hacker-news' => 'hacker-news',
'fa-html5' => 'html5',
'fa-instagram' => 'instagram',
'fa-joomla' => 'joomla',
'fa-jsfiddle' => 'jsfiddle',
'fa-linkedin' => 'linkedin',
'fa-linkedin-square' => 'linkedin-square',
'fa-linux' => 'linux',
'fa-maxcdn' => 'maxcdn',
'fa-openid' => 'openid',
'fa-pagelines' => 'pagelines',
'fa-pied-piper' => 'pied-piper',
'fa-pied-piper-alt' => 'pied-piper-alt',
'fa-pied-piper-square' => 'pied-piper-square',
'fa-pinterest' => 'pinterest',
'fa-pinterest-square' => 'pinterest-square',
'fa-qq' => 'qq',
'fa-ra' => 'ra',
'fa-rebel' => 'rebel',
'fa-reddit' => 'reddit',
'fa-reddit-square' => 'reddit-square',
'fa-renren' => 'renren',
'fa-share-alt' => 'share-alt',
'fa-share-alt-square' => 'share-alt-square',
'fa-skype' => 'skype',
'fa-slack' => 'slack',
'fa-soundcloud' => 'soundcloud',
'fa-spotify' => 'spotify',
'fa-stack-exchange' => 'stack-exchange',
'fa-stack-overflow' => 'stack-overflow',
'fa-steam' => 'steam',
'fa-steam-square' => 'steam-square',
'fa-stumbleupon' => 'stumbleupon',
'fa-stumbleupon-circle' => 'stumbleupon-circle',
'fa-tencent-weibo' => 'tencent-weibo',
'fa-trello' => 'trello',
'fa-tumblr' => 'tumblr',
'fa-tumblr-square' => 'tumblr-square',
'fa-twitter' => 'twitter',
'fa-twitter-square' => 'twitter-square',
'fa-vimeo-square' => 'vimeo-square',
'fa-vine' => 'vine',
'fa-vk' => 'vk',
'fa-wechat' => 'wechat',
'fa-weibo' => 'weibo',
'fa-weixin' => 'weixin',
'fa-windows' => 'windows',
'fa-wordpress' => 'wordpress',
'fa-xing' => 'xing',
'fa-xing-square' => 'xing-square',
'fa-yahoo' => 'yahoo',
'fa-youtube' => 'youtube',
'fa-youtube-play' => 'youtube-play',
'fa-youtube-square' => 'youtube-square',
'fa-ambulance' => 'ambulance',
'fa-h-square' => 'h-square',
'fa-hospital-o' => 'hospital-o',
'fa-medkit' => 'medkit',
'fa-plus-square' => 'plus-square',
'fa-stethoscope' => 'stethoscope',
'fa-user-md' => 'user-md',
'fa-wheelchair' => 'wheelchair',
);
            ?>
            
            <select name="serviceIcon" id="serviceIcon">
                <?php
                    foreach($icon as $key => $val)
                    {
                        if($key == $serviceIcon )
                        {
                            echo '<option value="'.$key.'" Selected>'.$val.'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$key.'">'.$val.'</option>';
                        }
                    }
                ?>
            </select><br/>
            <p><i><small>Font Awesome Icon Class For Service.</small></i></p>
        </div>
    </div>
    <div class="clear"></div>
<?php
}

add_action( 'save_post', 'save_service_info' );
function save_service_info($post_ID)
{
    global $post;
    if(isset($_POST)):
            if(isset($_POST['serviceIcon']) && $_POST['serviceIcon'] != ''):
                update_post_meta($post_ID, 'serviceIcon', $_POST['serviceIcon']);
            endif;
    endif;
}

