<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://66beta.com
 * @since      1.0.0
 *
 * @package    Infinix
 * @subpackage Infinix/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
function display_smartphone_kv_metabox( $post ) {
    $kv = get_post_meta( $post->ID, '_kv', true );
    $kv = wp_parse_args( $kv, array( 'color'=>'', 'bg'=>'', 'detail'=>'' ) );
    ?>
    <div class="kv">
        <label>Background Color: <input type="text" class="kv-color" name="_kv[color]" value="<?php echo $kv['color']?>"></label>
        <hr>
        <label>Background Image: <input type="text" class="kv-bg" name="_kv[bg]" value="<?php echo $kv['bg']?>"></label>
        <a href="#" class="kv-bg-add button-primary">Select</a>
        <br>
        <img class="kv-bg-preview" src="<?php echo $kv['bg']?>" style="max-height: 100px;">
        <hr>
        <label>Detail:</label><br>
        <textarea name="_kv[detail]"><?php echo $kv['detail']?></textarea>
    </div>
    <?php
}


function display_smartphone_selling_point_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $sp = get_post_meta( $post->ID, '_sp', true );
    ?>
    <table class="sp-list">
        <tr class="clearfix">
        <?php if( ! empty($sp) ): ?>
        <?php for ($i=0,$j=count($sp); $i < $j; $i++): ?>
            <td class="sp-item">
                <div class="sp-item-content">
                    <div class="sp-item-head">#<?php echo $i+1; ?><a class="sp-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div>
                    <div class="sp-item-body">
                        <?php /*<label>Nav Title:</label><br>
                        <input class="sp-input-nav" type="text" name="_sp[<?php echo $i; ?>][nav]" size="20" value="<?php echo strtoupper($sp[$i]['nav']); ?>">
                        <hr>*/?>
                        <label><input class="sp-input-text-center" type="checkbox" name="_sp[<?php echo $i; ?>][text-center]" value="1" <?php echo isset($sp[$i]['text-center'])?'checked':''; ?>>Centering Text</label>&nbsp;&nbsp;&nbsp;<label><input class="sp-input-text-light" type="checkbox" name="_sp[<?php echo $i; ?>][text-light]" value="1"<?php echo isset($sp[$i]['text-light'])?'checked':''; ?>>White Text</label>
                        <hr>
                        <label>Background Color: <input class="sp-input-color" type="text" name="_sp[<?php echo $i; ?>][color]" value="<?php echo $sp[$i]['color']; ?>" placeholder="#ffffff"></label>
                        <hr>
                        <label>Background Image: <input class="sp-input-bg" type="text" name="_sp[<?php echo $i; ?>][bg]" value="<?php echo $sp[$i]['bg']; ?>"></label><a href="#" class="sp-bg-add button-primary">Select</a><br><img src="<?php echo $sp[$i]['bg']; ?>" style="max-height:100px;">
                        <hr>
                        <label>Content:</label><br>
                        <textarea name="_sp[<?php echo $i; ?>][content]"><?php echo $sp[$i]['content']; ?></textarea>
                    </div>
                </div>
            </td>
        <?php endfor; ?>
        <?php endif; ?>
        </tr>
    </table>
    <a href="#" class="sp-add button-primary">Add a Point</a>
    <?php
}

function display_smartphone_buy_link_metabox( $post ) {
    $buy = get_post_meta( $post->ID, '_buy', true );
    ?>
    <label>Country</label>
    <select id="country" name="country">
        <optgroup label="Africa">
            <option value="cotedivorie">Cote d'Ivorie</option>
            <option value="ghana">Ghana</option>
            <option value="kenya">Kenya</option>
            <option value="morocco">Morocco</option>
            <option value="nigeria">Nigeria</option>
        </optgroup>
        <optgroup label="Middle East">
            <option value="egypt">Egypt</option>
            <option value="ksa">Saudi Arabia</option>
            <option value="uae">UAE</option>
        </optgroup>
        <optgroup label="Asia">
            <option value="indonesia">Indonesia</option>
            <option value="pakistan">Pakistan</option>
            <option value="philippines">Philippines</option>
            <option value="thailand">Thailand</option>
            <option value="vietnam">Vietnam</option>
        </optgroup>
        <optgroup label="Europe">
            <option value="france">France</option>
        </optgroup>
    </select>
    <label>Seller</label>
    <select id="seller" name="seller">
        <option value="daraz">Daraz</option>
        <option value="jumia">Jumia</option>
        <option value="kilimall">Kilimall</option>
        <option value="konga">Konga</option>
        <option value="lazada">Lazada</option>
        <option value="slot">Slot</option>
        <option value="souq">Souq</option>
        <option value="yodala">Yodala</option>
        <option value="zoobashop">ZOOBASHOP</option>
        <option value="tisu">TISU</option>
        <option value="wadi">wadi</option>
    </select>
    <a href="#" class="buy-add button-primary">Add New</a>
    <hr>
    <table class="buy-links">
        <thead>
            <tr>
                <th width="120">Country</th>
                <th width="100">Seller</th>
                <th>URL</th>
                <th width="100"></th>
            </tr>
        </thead>
        <?php if( ! empty($buy) ): ?>
        <?php for ($i=0,$j=count($buy); $i < $j; $i++): 
            if( !isset( $buy[$i]) )
                continue;
        ?>
        <tr class="buy-item">
            <td><?php echo ucfirst( $buy[$i]['country'] ); ?><input type="hidden" name="_buy[<?php echo $i; ?>][country]" value="<?php echo $buy[$i]['country']; ?>"></td>
            <td><?php echo ucfirst( $buy[$i]['seller'] ); ?><input type="hidden" name="_buy[<?php echo $i; ?>][seller]" value="<?php echo $buy[$i]['seller']; ?>"></td>
            <td><input type="url" name="_buy[<?php echo $i; ?>][url]" value="<?php echo $buy[$i]['url']; ?>"></td>
            <td><a class="button-primary buy-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></td>
        </tr>
        <?php endfor; ?>
        <?php endif; ?>
    </table>
    <?php
}

function display_smartphone_photo_metabox( $post ) {
    $photos = get_post_meta( $post->ID, '_photos', true );
    ?>
    <table class="photo-list">
        <thead>
            <tr>
                <th width="50">#</th>
                <th width="150">Preview</th>
                <th>Image Url</th>
                <th width="80"></th>
            </tr>
        </thead>
        <tr>
            <td>1</td>
            <td><img src="<?php echo $photos[0]?>" style="max-height:100px;"></td>
            <td><input class="photo-input-url" type="text" name="_photos[0]" value="<?php echo $photos[0]?>"></td>
            <td><a class="button-primary photo-add" href="#">Select</a></td>
        </tr>
        <tr>
            <td>2</td>
            <td><img src="<?php echo $photos[1]?>" style="max-height:100px;"></td>
            <td><input class="photo-input-url" type="text" name="_photos[1]" value="<?php echo $photos[1]?>"></td>
            <td><a class="button-primary photo-add" href="#">Select</a></td>
        </tr>
        <tr>
            <td>3</td>
            <td><img src="<?php echo $photos[2]?>" style="max-height:100px;"></td>
            <td><input class="photo-input-url" type="text" name="_photos[2]" value="<?php echo $photos[2]?>"></td>
            <td><a class="button-primary photo-add" href="#">Select</a></td>
        </tr>
        <tr>
            <td>4</td>
            <td><img src="<?php echo $photos[3]?>" style="max-height:100px;"></td>
            <td><input class="photo-input-url" type="text" name="_photos[3]" value="<?php echo $photos[3]?>"></td>
            <td><a class="button-primary photo-add" href="#">Select</a></td>
        </tr>
        <tr>
            <td>5</td>
            <td><img src="<?php echo $photos[4]?>" style="max-height:100px;"></td>
            <td><input class="photo-input-url" type="text" name="_photos[4]" value="<?php echo $photos[4]?>"></td>
            <td><a class="button-primary photo-add" href="#">Select</a></td>
        </tr>
        <tr>
            <td>6</td>
            <td><img src="<?php echo $photos[5]?>" style="max-height:100px;"></td>
            <td><input class="photo-input-url" type="text" name="_photos[5]" value="<?php echo $photos[5]?>"></td>
            <td><a class="button-primary photo-add" href="#">Select</a></td>
        </tr>
    </table>
    <?php
}

function display_smartphone_feature_metabox( $post ) {
    $features = get_post_meta( $post->ID, '_features', true );
    ?>
    <a href="#" class="feature-add button-primary">Add New</a>
    <hr>
    <table class="feature-list">
        <thead>
            <tr>
                <th width="150">Title</th>
                <th>Detail</th>
                <th width="100"></th>
            </tr>
        </thead>
        <?php if( ! empty($features) ): ?>
        <?php $index=0;foreach ($features as $feature): ?>
        <tr class="feature-item">
            <td><input type="text" name="_features[<?php echo $index?>][title]" value="<?php echo $feature['title']; ?>"></td>
            <td><input type="text" name="_features[<?php echo $index++?>][detail]" value="<?php echo str_replace('"', '&#34;', str_replace("'", '&#39;', $feature['detail'])); ?>"></td>
            <td><a class="button-primary feature-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <?php
}

function display_smartphone_video_metabox( $post ) {
    $video = get_post_meta( $post->ID, '_video', true );
    $video = wp_parse_args( $video, array( 'logo'=>'', 'url'=>'' ) );
    ?>
    <div class="video">
        <label>Background Image: <br><input type="text" class="video-bg" name="_video[bg]" value="<?php echo $video['bg']?>"></label>
        <a href="#" class="video-bg-add button-primary">Select</a>
        <br>
        <img class="video-bg-preview" src="<?php echo $video['bg']?>" style="max-height: 100px;">
        <hr>
        <label>Logo Image:<br><input type="text" class="video-logo" name="_video[logo]" value="<?php echo $video['logo']?>"></label>
        <a href="#" class="video-logo-add button-primary">Select</a>
        <br>
        <img class="video-logo-preview" src="<?php echo $video['logo']?>" style="max-height: 100px;">
        <hr>
        <label>Youtube Link:<br><input type="url" name="_video[url]" value="<?php echo $video['url']?>"></label>
    </div>
    <?php
}



function display_acc_kv_metabox( $post ) {
    $kv = get_post_meta( $post->ID, '_acc_kv', true );
    $kv = wp_parse_args( $kv, array( 'color'=>'', 'bg'=>'', 'detail'=>'' ) );
    ?>
    <div class="kv">
        <label>Background Color: <input type="text" class="kv-color" name="_acc_kv[color]" value="<?php echo $kv['color']?>"></label>
        <hr>
        <label>Background Image: <input type="text" class="kv-bg" name="_acc_kv[bg]" value="<?php echo $kv['bg']?>"></label>
        <a href="#" class="kv-bg-add button-primary">Select</a>
        <br>
        <img class="kv-bg-preview" src="<?php echo $kv['bg']?>" style="max-height: 100px;">
        <hr>
        <label>Detail:</label><br>
        <textarea name="_acc_kv[detail]"><?php echo $kv['detail']?></textarea>
    </div>
    <?php
}


function display_acc_selling_point_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $sp = get_post_meta( $post->ID, '_acc_sp', true );
    ?>
    <table class="acc-sp-list">
        <tr class="clearfix">
        <?php if( ! empty($sp) ): ?>
        <?php for ($i=0,$j=count($sp); $i < $j; $i++): ?>
            <td class="sp-item">
                <div class="sp-item-content">
                    <div class="sp-item-head">#<?php echo $i+1; ?><a class="sp-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div>
                    <div class="sp-item-body">
                        <label><input class="sp-input-text-center" type="checkbox" name="_acc_sp[<?php echo $i; ?>][text-center]" value="1" <?php echo isset($sp[$i]['text-center'])?'checked':''; ?>>Centering Text</label>&nbsp;&nbsp;&nbsp;<label><input class="sp-input-text-light" type="checkbox" name="_acc_sp[<?php echo $i; ?>][text-light]" value="1"<?php echo isset($sp[$i]['text-light'])
                        ?'checked':''; ?>>White Text</label>
                        <hr>
                        <label>Background Color: <input class="sp-input-color" type="text" name="_acc_sp[<?php echo $i; ?>][color]" value="<?php echo $sp[$i]['color']; ?>" placeholder="#ffffff"></label>
                        <hr>
                        <label>Background Image: <input class="sp-input-bg" type="text" name="_acc_sp[<?php echo $i; ?>][bg]" value="<?php echo $sp[$i]['bg']; ?>"></label><a href="#" class="sp-bg-add button-primary">Select</a><br><img src="<?php echo $sp[$i]['bg']; ?>" style="max-height:100px;">
                        <hr>
                        <label>Content:</label><br>
                        <textarea name="_acc_sp[<?php echo $i; ?>][content]"><?php echo $sp[$i]['content']; ?></textarea>
                    </div>
                </div>
            </td>
        <?php endfor; ?>
        <?php endif; ?>
        </tr>
    </table>
    <a href="#" class="acc-sp-add button-primary">Add a Point</a>
    <?php
}


function display_support_faq_qa_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $qa = get_post_meta( $post->ID, '_qa', true );
    ?>
    <table class="qa-list">
        <tr class="clearfix">
        <?php if( ! empty($qa) ): ?>
        <?php for ($i=0,$j=count($qa); $i < $j; $i++): ?>
            <td class="qa-item">
                <div class="qa-item-content">
                    <div class="qa-item-head">#<?php echo $i+1; ?><a class="qa-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div>
                    <div class="qa-item-body">
                        <label>Q:<input type="text" name="_qa[<?php echo $i; ?>][q]" value="<?php echo $qa[$i]['q']; ?>"></label>
                        <br>
                        <label>A:<textarea name="_qa[<?php echo $i; ?>][a]"><?php echo $qa[$i]['a']; ?></textarea></label>
                    </div>
                </div>
            </td>
        <?php endfor; ?>
        <?php endif; ?>
        </tr>
    </table>
    <a href="#" class="qa-add button-primary">Add a Question</a>
    <?php
}

function display_support_warranty_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $qa = get_post_meta( $post->ID, '_qa', true );
    ?>
    <table class="qa-list">
        <tr class="clearfix">
        <?php if( ! empty($qa) ): ?>
        <?php for ($i=0,$j=count($qa); $i < $j; $i++): ?>
            <td class="qa-item">
                <div class="qa-item-content">
                    <div class="qa-item-head">#<?php echo $i+1; ?><a class="qa-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div>
                    <div class="qa-item-body">
                        <label>Q:<input type="text" name="_qa[<?php echo $i; ?>][q]" value="<?php echo $qa[$i]['q']; ?>"></label>
                        <br>
                        <label>A:<textarea name="_qa[<?php echo $i; ?>][a]"><?php echo $qa[$i]['a']; ?></textarea></label>
                    </div>
                </div>
            </td>
        <?php endfor; ?>
        <?php endif; ?>
        </tr>
    </table>
    <a href="#" class="qa-add button-primary">Add a Question</a>
    <?php
}

function display_support_service_network_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $sn = get_post_meta( $post->ID, '_sn', true );
    ?>
    <div class="sn-city-list">
        <?php if( ! empty($sn) ): ?>
        <?php $i=0;foreach ($sn as $item): ?>
        <div class="sn-city">
            <div class="sn-city-head">City: <input type="text" name="_sn[<?php echo $i?>][city]" value="<?php echo $item['city']?>"> <a href="#" class="sn-add button-primary">Add Address</a> <a href="#" class="sn-city-delete button-primary"><i class="dashicons dashicons-no"></i></a></div>
            <table class="sn-list">
                <thead>
                    <tr>
                        <th>Address</th>
                        <th>Tel</th>
                        <th>Email</th>
                        <th>Working Time</th>
                        <th></th>
                    </tr>
                </thead>
                <?php if( ! empty($item['point']) ): ?>
                <?php $j=0;foreach ($item['point'] as $point): ?>
                <tr class="sn-item">
                    <td><input type="text" name="_sn[<?php echo $i?>][point][<?php echo $j?>][addr]" value="<?php echo $point['addr']?>"></td>
                    <td><input type="tel" name="_sn[<?php echo $i?>][point][<?php echo $j?>][tel]" value="<?php echo $point['tel']?>"></td>
                    <td><input type="email" name="_sn[<?php echo $i?>][point][<?php echo $j?>][email]" value="<?php echo $point['email']?>"></td>
                    <td><input type="text" name="_sn[<?php echo $i?>][point][<?php echo $j?>][time]" value="<?php echo $point['time']?>"></td>
                    <td><a class="button-primary sn-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i></a></td>
                </tr>
                <?php ++$j;endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
        <?php ++$i;endforeach; ?>
        <?php endif; ?>
    </div>
    <hr>
    <a href="#" class="sn-item-add button-primary">Add City</a>
    <?php
}

function display_support_update_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $laptop = get_post_meta( $post->ID, '_laptop', true );
    $tfcard = get_post_meta( $post->ID, '_tfcard', true );
    ?>
    <div class="update-box">
        <h4>For laptop</h4>
        <table class="update-list laptop-list">
            <thead>
                <th width="220">Title</th>
                <th>Url</th>
                <th width="80"></th>
            </thead>
            <tbody>
                <?php if($laptop): ?>
                <?php $i=0;foreach ($laptop as $item): ?>
                <tr>
                    <td><input type="text" name="_laptop[<?php echo $i?>][title]" value="<?php echo $item['title']?>"></td>
                    <td><input type="text" name="_laptop[<?php echo $i++?>][url]" value="<?php echo $item['url']?>"></td>
                    <td><a href="#" class="update-delete button-primary">Delete</a></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="#" class="laptop-add button-primary">Add a link</a>
    </div>
    <br>
    <div class="update-box">
        <h4>For TF card</h4>
        <table class="update-list tfcard-list">
            <thead>
                <th width="220">Title</th>
                <th>Url</th>
                <th width="80"></th>
            </thead>
            <tbody>
                <?php if($tfcard): ?>
                <?php $j=0;foreach ($tfcard as $item): ?>
                <tr>
                    <td><input type="text" name="_tfcard[<?php echo $j?>][title]" value="<?php echo $item['title']?>"></td>
                    <td><input type="text" name="_tfcard[<?php echo $j++?>][url]" value="<?php echo $item['url']?>"></td>
                    <td><a href="#" class="update-delete button-primary">Delete</a></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="#" class="tfcard-add button-primary">Add a link</a>
    </div>
    <?php
}

function display_support_manual_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $manual = get_post_meta( $post->ID, '_manual', true );
    ?>
    <table class="manual-list">
        <thead>
            <th width="200">Title</th>
            <th>Download Url</th>
            <th width="150"></th>
        </thead>
        <tbody>
            <?php if( ! empty($manual) ): ?>
            <?php $i=0;foreach ($manual as $item): ?>
            <tr class="manual-item">
                <td><input type="text" name="_manual[<?php echo $i?>][lang]" value="<?php echo $item['lang']?>"></td>
                <td><input type="text" class="manual-url" name="_manual[<?php echo $i++?>][url]" value="<?php echo $item['url']?>"></td>
                <td><a href="#" class="manual-select button-primary">Select</a> <a href="#" class="manual-delete button-primary">Delete</a></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <hr>
    <a href="#" class="manual-add button-primary">Add language version</a>
    <?php
}

function display_support_phone_photo_metabox( $post ) {
    $image = get_post_meta( $post->ID, '_phone_photo', true );
    ?>
    <div class="phone-photo">
        <input style="width:100%;" type="text" name="_phone_photo" value="<?php echo $image?>"> <a href="#" class="phone-photo-add button-primary">Change Image</a>
        <hr>
        <img src="<?php echo $image?>" style="max-height:200px;width:auto;">
    </div>
    <?php
}

function display_key_banner_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $banner = get_post_meta( $post->ID, '_banner', true );
    $banner = wp_parse_args( $banner, array( 'url'=>'', 'img'=>'' ) );
    ?>
    <div class="banner-info">
        <label>Url: <input type="text" name="_banner[url]" value="<?php echo $banner['url']?>"></label>
        <hr>
        <label>Image: <input type="text" class="banner-img" name="_banner[img]" value="<?php echo $banner['img']?>"></label>
        <img class="banner-preview" src="<?php echo $banner['img']?>" style="max-height:200px;width:auto;">
        <br>
        <a href="#" class="banner-add button-primary">Change Image</a>
    </div>
    <?php
}
/*
function display_news_metabox( $post ) {
    echo '<input type="hidden" name="infinix_nonce" id="infinix_nonce" value="'.wp_create_nonce('class-infinix-admin.php').'">';
    $news = get_post_meta( $post->ID, '_news', true );
    $news = wp_parse_args( $news, array( 'url'=>'', 'detail'=>'', 'img'=>'' ) );
    ?>
    <div class="news-info">
        <label>Url: <input type="text" name="_news[url]" value="<?php echo $news['url']?>"></label>
        <hr>
        <label>Detail: <textarea name="_news[detail]"><?php echo $news['detail']?></textarea></label>
        <hr>
        <label>Thumbnail: <input type="text" class="news-img" name="_news[img]" value="<?php echo $news['img']?>"></label>
        <img class="news-preview" src="<?php echo $news['img']?>" style="max-height:150px;width:auto;">
        <br>
        <a href="#" class="news-add button-primary">Change Image</a>
    </div>
    <?php
}
*/
function display_support_flag_metabox( $post ) {
    $flag = get_post_meta( $post->ID, '_flag', true );
    ?>
    <input type="text" name="_flag" value="<?php echo $flag?>" style="width:80%;"> <a href="#" class="flag-select button-primary">Select Image</a>
    <br>
    <img src="<?php echo $flag?>">
    <?php
}
