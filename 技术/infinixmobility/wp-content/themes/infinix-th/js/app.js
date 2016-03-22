(function( $ ) {
    'use strict';
    var kvHeight = 1;
    var w768 = Modernizr.mq('(min-width: 768px)');
    if (w768) {
        $('.rpd-image').each(function() {
            $(this).attr('src', $(this).data('src-d'));
        });
    } else {
        kvHeight = 0.9;
        $('.rpd-image').each(function() {
            $(this).attr('src', $(this).data('src'));
        });
    }
    var w992 = Modernizr.mq('(min-width: 992px)');
    if (w992) {
        $('.rpd-image-bg').each(function() {
            $(this).css( 'background-image', $(this).data('bg-d') );
        });
    } else {
        $('.rpd-image-bg').each(function() {
            $(this).css( 'background-image', $(this).data('bg') );
        });
    }
    //banner slide
    if ($('.key-banner').length) {
        $('.key-banner').slick({
            autoplay: true,
            dots: true,
            infinite: true,
            speed: 300,
            fade: false,
            cssEase: 'linear',
            arrows: true
        });
        $('.key-banner,.slick-slide').css('height', $(window).height()*kvHeight);
    }

    $('.video-pop').on('click', '.video-pop-close', function(event) {
        $('.video-pop-content,.video-pop-mask').hide();
    });
    $('body').on('click', '.key-video a', function(event) {
        event.preventDefault();
        $('.video-pop-mask').show();
        $('.video-pop-content').slideDown();
        return false;
    });

    // $('.key-feature').on('mouseover', '.feature-point a', function(event) {
    //     event.preventDefault();
    //     var $el = $(this);
    //         // $pics = $(".feature-pic img"),
    //         // index = $el.index();
    //     $(".feature-point .active").removeClass('active');
    //     // $pics.attr("src","");
    //     // $pics.eq(index).attr("src",$pics.eq(index).data("src"));
    //     $el.addClass('active');
    // });

    //fixed nav
    // if ($('.sp-anchor').length) {
    //     $('.sp-anchor').waypoint({
    //         handler: function(direction) {
    //             if ('down' === direction) {
    //                 $('.sp-anchor-inner').addClass('sp-anchor-fixed');
    //             }
    //             if ('up' === direction) {
    //                 $('.sp-anchor-fixed').removeClass('sp-anchor-fixed');
    //             }
    //         }
    //     });
    //     $('body').scrollspy({ target: '.sp-scroll', offset: 52 });
    // }

    //about tab switch
    $('#helpTab a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        jQuery(window).scrollTop(jQuery(document).height());
    });
    // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    //     alert("change");
    //     $(window).scrollTop($(document).height());
    // })

    //selling point pictrue switch
    $('.sp-slide-nav>div>img').on('click', function(){
        var src = $(this).attr('src');
        $('.sp-slide-box img').attr('src',src);
    });

    //buy switch
    $('.show-country a').on('click', function(e){
        e.preventDefault();
        var i = $(this).index('.show-country a');
        $('.country-list').hide();
        $('#area-'+i).show();
        $('#buyCountry').modal();
    });

    //support selection
    $('.support-selection').on('click', '#service a', function(){
        var serviceType = $(this).data('service'),
            buttonText = $(this).html(),
            $button = $(this).parents('.selection-list').siblings('.selection-head');

        $('.support-box-wrap').remove();
        $('#phone').collapse('hide').siblings('.selection-head').html('เลือกโทรศัพท์ของคุณ').prop("disabled", true);
        $('#location').collapse('hide').siblings('.selection-head').html('เลือกพื้นที่ของคุณ').prop("disabled", true);
        $button.html(buttonText).data('type', serviceType);
        $(this).parents('.selection-list').collapse('hide');
        switch (serviceType) {
            case 1:
                set_update_phone_list();
                break;
            case 2:
                set_manual_phone_list();
                break;
            case 3:
                set_service_network_location_list();
                break;
            case 4:
                show_faq();
                break;
            case 5:
                set_warranty_location_list();
                break;
            default:
                break;
        }
        return false;
    });

    $('.support-selection').on('click', '#phone a', function(){
        var buttonText = $(this).html(),
            id = $(this).data('id'),
            $button = $(this).parents('.selection-list').siblings('.selection-head'),
            serviceType = $('#service').siblings('.selection-head').data('type');

        $button.html(buttonText);
        $('.support-box-wrap').remove();
        $(this).parents('.selection-list').collapse('hide');

        switch(serviceType) {
            case 1:
                show_update_by_id(id);
                break;
            case 2:
                show_manual_by_id(id);
                break;
            default:
                break;
        }
        return false;
    });

    $('.support-selection').on('click', '#location a', function(){
        var buttonText = $(this).html(),
            $button = $(this).parents('.selection-list').siblings('.selection-head'),
            serviceType = $('#service').siblings('.selection-head').data('type');

        $('.support-box-wrap').remove();

        switch(serviceType) {
            case 2:
                $(this).parents('.selection-list').collapse('hide');
                $button.html(buttonText);
                show_manual( $(this).data('url') );
                break;
            case 3:
                $(this).parents('.selection-list').collapse('hide');
                show_service_network_city( $(this).parents('.city').data('id'), $(this).data('city') );
                break;
            case 5:
                $(this).parents('.selection-list').collapse('hide');
                show_warranty( $(this).data('id') );
                break;
            default:
                break;
        }

        return false;
    });

    function set_update_phone_list() {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_update_phone_list',
                _ajax_nonce: ajax_x.nonce,
            },
            function(res) {
            // console.log(res);
                if(true === res.result) {
                    var template = $('#phoneListTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('#phone').html(rendered);
                    $('#phone').siblings('.selection-head').prop("disabled", false);
                    $('#service').siblings('.selection-head').data('type', 1);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
        return false;
    }

    function set_manual_phone_list() {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_manual_phone_list',
                _ajax_nonce: ajax_x.nonce,
            },
            function(res) {
            // console.log(res);
                if(true === res.result) {
                    var template = $('#phoneListTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('#phone').html(rendered);
                    $('#phone').siblings('.selection-head').prop("disabled", false);
                    $('#service').siblings('.selection-head').data('type', 2);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
        return false;
    }

    function set_service_network_location_list() {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_service_network_location_list',
                _ajax_nonce: ajax_x.nonce
            },
            function(res) {
            // console.log(res);
                if(true === res.result) {
                    var template = $('#serivceNetworkListTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('#location').html(rendered);
                    $('#location').siblings('.selection-head').prop("disabled", false);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
        return false;
    }

    function set_warranty_location_list() {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_warranty_location_list',
                _ajax_nonce: ajax_x.nonce
            },
            function(res) {
            // console.log(res);
                if(true === res.result) {
                    var template = $('#warrantyLocationListTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('#location').html(rendered);
                    $('#location').siblings('.selection-head').prop("disabled", false);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
        return false;
    }

    function show_update_by_id( id ) {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_update_phone',
                _ajax_nonce: ajax_x.nonce,
                post_id: id
            },
            function(res) {
                // console.log(res);
                if(true === res.result) {
                    res.hasLaptop = (res.laptop.length > 0);
                    res.hasTfcard = (res.tfcard.length > 0);
                    var template = $('#phoneTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('.support-selection').after(rendered);
                    $('html, body').animate({scrollTop: $('.support-box-wrap').offset().top}, 500);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
    }

    function show_manual_by_id( id ) {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_manual_phone',
                _ajax_nonce: ajax_x.nonce,
                post_id: id
            },
            function(res) {
                // console.log(res);
                if(true === res.result) {
                    var template = $('#manualTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('.support-selection').after(rendered);
                    $('html, body').animate({scrollTop: $('.support-box-wrap').offset().top}, 500);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
    }

    function show_service_network_city( id, city ) {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_service_network_city',
                _ajax_nonce: ajax_x.nonce,
                post_id: id,
                city: city
            },
            function(res) {
                // console.log(res);
                if(true === res.result) {
                    var template = $('#serviceNetworkTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('.support-selection').after(rendered);
                    $('html, body').animate({scrollTop: $('.support-box-wrap').offset().top}, 500);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
    }

    function show_faq() {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_faq',
                _ajax_nonce: ajax_x.nonce
            },
            function(res) {
                // console.log(res);
                if(true === res.result) {
                    var template = $('#faqTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('.support-selection').after(rendered);
                    $('html, body').animate({scrollTop: $('.support-box-wrap').offset().top}, 500);
                    //qa collapse
                    $('.support-faq').on('click', '#qa-tabs a', function(e) {
                        e.preventDefault();
                        $(this).tab('show').addClass('active');
                        $('#qa-tabs-btn:visible').length && $('#qa-tabs').collapse('hide');
                        $('#qa-tabs-btn').html($(this).html()+' <span class="pull-right glyphicon glyphicon-plus" aria-hidden="true"></span>');
                    });
                    if($('#qa-tabs-btn:visible').length) {
                        $('#qa-tabs').addClass('collapse');
                    } else {
                        $('#qa-tabs').collapse('show');
                    }
                    $('#qa-tabs a:eq(0)').click();
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
    }

    function show_warranty( id ) {
        jQuery.post(
            ajax_x.ajax_url,
            {
                action: 'support_warranty',
                _ajax_nonce: ajax_x.nonce,
                post_id: id
            },
            function(res) {
                // console.log(res);
                if(true === res.result) {
                    var template = $('#warrantyTpml').html();
                    Mustache.parse(template);
                    var rendered = Mustache.render(template, res);
                    $('.support-selection').after(rendered);
                    $('html, body').animate({scrollTop: $('.support-box-wrap').offset().top}, 500);
                } else {
                    alert('coming soon');
                }
            },
            'json'
        );
    }

})( jQuery );
