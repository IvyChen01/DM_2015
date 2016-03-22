(function( $ ) {
    'use strict';

    $(function(){
        //kv
        if( jQuery('.kv').length > 0 ) {
            jQuery('.kv-bg-add').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Background Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    jQuery('.kv-bg-preview').attr('src',attachment.url);
                    jQuery('input.kv-bg').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //selling points
        if( jQuery('.sp-list').length > 0 ) {
            function sp_set_order() {
                jQuery('.sp-item').each( function(index) {
                    jQuery(this).find('.sp-input-text-center').attr('name', '_sp['+index+'][text-center]');
                    jQuery(this).find('.sp-input-text-light').attr('name', '_sp['+index+'][text-light]');
                    jQuery(this).find('.sp-input-color').attr('name', '_sp['+index+'][color]');
                    jQuery(this).find('.sp-input-bg').attr('name', '_sp['+index+'][bg]');
                    jQuery(this).find('textarea').attr('name', '_sp['+index+'][content]');
                    jQuery(this).find('.sp-item-head').html('#'+(index+1)+'<a class="sp-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a>');
                });
            }
            jQuery('.sp-list').sortable( {
                items: ".sp-item",
                handle: ".sp-item-head",
                helper: "clone",
                update: function( event, ui ) {
                    sp_set_order();
                }
            });
            jQuery('.sp-add').click(function(){
                var $button = jQuery(this),
                    $container = $button.siblings('.sp-list').find('tr'),
                    newItem = '<td class="sp-item"><div class="sp-item-content"><div class="sp-item-head">#<a class="sp-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div><div class="sp-item-body"><label><input class="sp-input-text-center" type="checkbox" name="_sp[][text-center]" value="1">Centering Text</label>&nbsp;&nbsp;&nbsp;<label><input class="sp-input-text-light" type="checkbox" name="_sp[][text-light]" value="1">White Text</label><hr><label>Background Color: </label><input class="sp-input-color" type="text" name="_sp[][color]" value="" placeholder="#FFFFFF"><hr><label>Background Image: </label><br><input class="sp-input-bg" type="text" name="_sp[][bg]" value=""><a href="#" class="sp-bg-add button-primary">Select</a><br><img src="" style="max-height:100px;"><hr><label>Content:</label><br><textarea name="_sp[][content]"></textarea></div></div></td>';
                $container.append(newItem);
                sp_set_order();
                return false;
            });
            jQuery('.sp-list').on( 'click', '.sp-item-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete this section?")) {
                        jQuery(this).parents('.sp-item').fadeOut( function() {
                        jQuery(this).remove();
                        sp_set_order();
                    });
                }
                return false;
            });
            jQuery('.sp-list').on( 'click', '.sp-bg-add', function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Background Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $button.siblings('img').attr('src',attachment.url);
                    $button.siblings('input.sp-input-bg').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //buy links
        if( jQuery('.buy-links').length > 0 ) {
            jQuery('.buy-add').click(function(){
                var $button = jQuery(this),
                    $container = $button.siblings('.buy-links'),
                    index = jQuery('.buy-item').length,
                    countryValue = jQuery('#country').val(),
                    countryName = jQuery('#country :selected').text(),
                    sellerValue = jQuery('#seller').val(),
                    sellerName = jQuery('#seller :selected').text(),
                    newItem = '<tr class="buy-item"><td>'+countryName+'<input type="hidden" name="_buy['+index+'][country]" value="'+countryValue+'"></td><td>'+sellerName+'<input type="hidden" name="_buy['+index+'][seller]" value="'+sellerValue+'"></td><td><input type="url" name="_buy['+index+'][url]" value=""></td><td><a class="button-primary buy-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></td></tr>';
                $container.append(newItem);
                return false;
            });
            jQuery('.buy-links').on( 'click', '.buy-item-delete', function(e) {
                if (window.confirm("Do you really want to delete this link?")) {
                    // alert('deleting');
                    jQuery(this).parents('.buy-item').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
                e.preventDefault();
            });
        }
        //spec photos
        if( jQuery('.photo-list').length > 0 ) {
            jQuery('.photo-add').click( function(e) {
                e.preventDefault();
                if( $('.photo-thumbnail').size() >= 6 ) {
                    alert('图片只能上传6张！');
                    return;
                }
                var $button = jQuery(this),
                $container = $button.siblings('.photo-list').find('tr');
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Photo',
                    button: { text: 'Add', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $button.parents('tr').find('.photo-input-url').val(attachment.url);
                    $button.parents('tr').find('img').attr('src',attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //features
        if( jQuery('.feature-list').length > 0 ) {
            jQuery('.feature-add').click(function(){
                var $button = jQuery(this),
                    $container = $button.siblings('.feature-list'),
                    index = jQuery('.feature-item').length,
                    newItem = '<tr class="feature-item"><td><input type="text" name="_features['+index+'][title]" value=""></td><td><input type="text" name="_features['+index+'][detail]"></td><td><a class="button-primary feature-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></td></tr>';
                $container.append(newItem);
                return false;
            });
            jQuery('.feature-list').on( 'click', '.feature-item-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete this feature?")) {
                    jQuery(this).parents('.feature-item').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
        }
        //video
        if( jQuery('.video').length > 0 ) {
            jQuery('.video-logo-add').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Logo',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    jQuery('.video-logo-preview').attr('src',attachment.url);
                    jQuery('input.video-logo').val(attachment.url);
                });
                uploader.open();
                return false;
            });
            jQuery('.video-bg-add').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Background Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    jQuery('.video-bg-preview').attr('src',attachment.url);
                    jQuery('input.video-bg').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //acc selling points
        if( jQuery('.acc-sp-list').length > 0 ) {
            function acc_sp_set_order() {
                jQuery('.sp-item').each( function(index) {
                    jQuery(this).find('.sp-input-text-center').attr('name', '_acc_sp['+index+'][text-center]');
                    jQuery(this).find('.sp-input-text-light').attr('name', '_acc_sp['+index+'][text-light]');
                    jQuery(this).find('.sp-input-color').attr('name', '_acc_sp['+index+'][color]');
                    jQuery(this).find('.sp-input-bg').attr('name', '_acc_sp['+index+'][bg]');
                    jQuery(this).find('textarea').attr('name', '_acc_sp['+index+'][content]');
                    jQuery(this).find('.sp-item-head').html('#'+(index+1)+'<a class="sp-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a>');
                });
            }
            jQuery('.acc-sp-list').sortable( {
                items: ".sp-item",
                handle: ".sp-item-head",
                helper: "clone",
                update: function( event, ui ) {
                    acc_sp_set_order();
                }
            });
            jQuery('.acc-sp-add').click(function(){
                var $button = jQuery(this),
                    $container = $button.siblings('.acc-sp-list').find('tr'),
                    newItem = '<td class="sp-item"><div class="sp-item-content"><div class="sp-item-head">#<a class="sp-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div><div class="sp-item-body"><label><input class="sp-input-text-center" type="checkbox" name="_acc_sp[][text-center]" value="1">Centering Text</label>&nbsp;&nbsp;&nbsp;<label><input class="sp-input-text-light" type="checkbox" name="_acc_sp[][text-light]" value="1">White Text</label><hr><label>Background Color: </label><input class="sp-input-color" type="text" name="_acc_sp[][color]" value="" placeholder="#FFFFFF"><hr><label>Background Image: </label><input class="sp-input-bg" type="text" name="_acc_sp[][bg]" value=""><a href="#" class="sp-bg-add button-primary">Select</a><br><img src="" style="max-height:100px;"><hr><label>Content:</label><br><textarea name="_acc_sp[][content]"></textarea></div></div></td>';
                $container.append(newItem);
                acc_sp_set_order();
                return false;
            });
            jQuery('.acc-sp-list').on( 'click', '.sp-item-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete this section?")) {
                        jQuery(this).parents('.sp-item').fadeOut( function() {
                        jQuery(this).remove();
                        sp_set_order();
                    });
                }
                return false;
            });
            jQuery('.acc-sp-list').on( 'click', '.sp-bg-add', function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Background Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $button.siblings('img').attr('src',attachment.url);
                    $button.siblings('input.sp-input-bg').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //qas
        if( jQuery('.qa-list').length > 0 ) {
            function qa_set_order() {
                jQuery('.qa-item').each( function(index) {
                    jQuery(this).find('input').attr('name', '_qa['+index+'][q]');
                    jQuery(this).find('textarea').attr('name', '_qa['+index+'][a]');
                    jQuery(this).find('.qa-item-head').html('#'+(index+1)+'<a class="qa-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a>');
                });
            }
            jQuery('.qa-list').sortable({
                items: ".qa-item",
                handle: ".qa-item-head",
                helper: "clone",
                update: function( event, ui ) {
                    qa_set_order();
                }
            });
            jQuery('.qa-add').click(function(){
                var $button = jQuery(this),
                    $container = $button.siblings('.qa-list'),
                    index = jQuery('.qa-item').length,
                    newItem = '<td class="qa-item"><div class="qa-item-content"><div class="qa-item-head">#<a class="qa-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i>Delete</a></div><div class="qa-item-body"><label>Q:<input type="text" name="_qa[][q]" value=""></label><br><label>A:<textarea name="_qa[][a]"></textarea></label></div></div></td>';
                $container.append(newItem);
                qa_set_order();
                return false;
            });
            jQuery('.qa-list').on( 'click', '.qa-item-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete this question?")) {
                    jQuery(this).parents('.qa-item').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
        }
        //warranty
        if( jQuery('.flag-select').length > 0 ) {
            jQuery('.flag-select').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $button.siblings('input').val(attachment.url);
                    $button.siblings('img').attr('src',attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //service network
        if( jQuery('.sn-city-list').length > 0 ) {
            jQuery('.sn-item-add').click(function(){
                var $button = jQuery(this),
                    $container = $button.siblings('.sn-city-list'),
                    index = jQuery('.sn-city').length,
                    newItem = '<div class="sn-city"><div class="sn-city-head">City: <input type="text" name="_sn['+index+'][city]" value=""> <a href="#" class="sn-add button-primary">Add Address</a> <a href="#" class="sn-city-delete button-primary"><i class="dashicons dashicons-no"></i></a></div><table class="sn-list"><thead><tr><th>Address</th><th>Tel</th><th>Email</th><th>Working Time</th><th></th></tr></thead></table></div>';
                $container.append(newItem);
                return false;
            });
            jQuery('.sn-city').on( 'click', '.sn-city-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete?")) {
                    jQuery(this).parents('.sn-city').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
            jQuery('.sn-city-list').on( 'click', '.sn-add', function(e){
                e.preventDefault();
                var $button = jQuery(this),
                    $container = $button.parents('.sn-city').children('.sn-list'),
                    i = $button.parents('.sn-city').index(),
                    j = $button.parents('.sn-city').find('.sn-item').length,
                    newItem = '<tr class="sn-item"><td><input type="text" name="_sn['+i+'][point]['+j+'][addr]" value=""></td><td><input type="text" name="_sn['+i+'][point]['+j+'][tel]" value=""></td><td><input type="text" name="_sn['+i+'][point]['+j+'][email]" value="service@carlcare.com"></td><td><input type="text" name="_sn['+i+'][point]['+j+'][time]" value=""></td><td><a class="button-primary sn-item-delete" href="#" title="Delete"><i class="dashicons dashicons-no"></i></a></td></tr>';
                $container.append(newItem);
                return false;
            });
            jQuery('.sn-city-list').on( 'click', '.sn-item-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete?")) {
                    jQuery(this).parents('tr').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
            jQuery('.sn-city-list').on( 'click', '.sn-city-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete?")) {
                    jQuery(this).parents('.sn-city').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
        }
        //phone photo
        if( jQuery('.phone-photo').length > 0 ) {
            jQuery('.phone-photo-add').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $button.siblings('img').attr('src',attachment.url);
                    $button.siblings('input').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //update
        if( jQuery('.update-list').length > 0 ) {
            jQuery('.laptop-add').click(function() {
                var $button = jQuery(this),
                    $container = $('.laptop-list tbody'),
                    i = $container.children('tr').length,
                    newItem = '<tr><td><input type="text" name="_laptop['+i+'][title]" value=""></td><td><input type="text" name="_laptop['+i+'][url]" value=""></td><td><a href="#" class="update-delete button-primary">Delete</a></td></tr>';
                $container.append(newItem);
                return false;
            });
            jQuery('.tfcard-add').click(function() {
                var $button = jQuery(this),
                    $container = $('.tfcard-list tbody'),
                    i = $container.children('tr').length,
                    newItem = '<tr><td><input type="text" name="_tfcard['+i+'][title]" value=""></td><td><input type="text" name="_tfcard['+i+'][url]" value=""></td><td><a href="#" class="update-delete button-primary">Delete</a></td></tr>';
                $container.append(newItem);
                return false;
            });
            jQuery('.update-list').on( 'click', '.update-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete?")) {
                    jQuery(this).parents('tr').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
        }
        //manual
        if( jQuery('.manual-list').length > 0 ) {
            jQuery('.manual-add').click(function() {
                var $button = jQuery(this),
                    $container = jQuery('.manual-list'),
                    i = jQuery('.manual-item').length,
                    newItem = '<tr class="manual-item"><td><input type="text" name="_manual['+i+'][lang]" value=""></td><td><input type="text" class="manual-url" name="_manual['+i+'][url]" value=""></td><td><a href="#" class="manual-select button-primary">Select</a> <a href="#" class="manual-delete button-primary">Delete</a></td></tr>';
                $container.append(newItem);
                return false;
            });
            jQuery('.manual-list').on('click', '.manual-select', function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Banner',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'application/pdf'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $button.parents('tr').find('.manual-url').val(attachment.url);
                });
                uploader.open();
                return false;
            });
            jQuery('.manual-list').on( 'click', '.manual-delete', function(e) {
                e.preventDefault();
                if (window.confirm("Do you really want to delete?")) {
                    jQuery(this).parents('tr').fadeOut( function() {jQuery(this).remove();});
                }
                return false;
            });
        }
        //key banner
        if( jQuery('.banner-info').length > 0 ) {
            jQuery('.banner-add').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Banner',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    jQuery('.banner-preview').attr('src',attachment.url);
                    jQuery('input.banner-img').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
        //news
        if( jQuery('.news-info').length > 0 ) {
            jQuery('.news-add').click( function(e) {
                e.preventDefault();
                var $button = jQuery(this);
                var uploader;
                if( uploader ) {
                    uploader.open();
                    return;
                }
                uploader = wp.media({
                    title: 'Upload or Select Image',
                    button: { text: 'Ok', size: 'small' },
                    multiple: false,
                    library : {type : 'image'}
                });
                uploader.on( 'select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    jQuery('.news-preview').attr('src',attachment.url);
                    jQuery('input.news-img').val(attachment.url);
                });
                uploader.open();
                return false;
            });
        }
    });

})( jQuery );
