var $ = jQuery.noConflict();


    //Preloader

(function(){
    'use strict';

 $(window).load(function() {
    jQuery(".loaded").fadeOut();
    jQuery(".loader").delay(1000).fadeOut("slow");
});

(function($){
    'use strict';
    //smoothScroll
    $('#main-navbar').localScroll();
})(jQuery);

})(jQuery);

(function($){
    'use strict';
    //Pretty Photo
    $("a[data-rel^='prettyPhoto']").prettyPhoto({
        social_tools: false
    });
    
})(jQuery);
(function($){
    'use strict';
    // Search
    $('.fa-search').on('click', function() {
        $('.field-toggle').slideToggle(200);
    });
})(jQuery);
$(document).ready(function($){
    'use strict';
    /**** Progress Bar ****/    
    $('.skill').appear();
    $('.skill').on('appear', loadCharts);
    function loadCharts() {
        var bgc = $("#circle-one").attr('data-bgcolor');
        var trc = $("#circle-one").attr('data-trackcolor');
        $('#circle-one').easyPieChart({
            barColor: bgc,
            trackColor: trc,
            rotate: '0',
            lineCap: 'butt',
            scaleLength: '0',
            lineWidth: 32,
            size: 185
        });
        var bgc2 = $("#circle-two").attr('data-bgcolor');
        var trc2 = $("#circle-two").attr('data-trackcolor');
        $('#circle-two').easyPieChart({
            barColor: bgc2,
            trackColor: trc2,
            rotate: '0',
            lineCap: 'butt',
            scaleLength: '0',
            lineWidth: 32,
            size: 185
        });
        var bgc3 = $("#circle-three").attr('data-bgcolor');
        var trc3 = $("#circle-three").attr('data-trackcolor');
        $('#circle-three').easyPieChart({
            barColor: bgc3,
            trackColor: trc3,
            rotate: '0',
            lineCap: 'butt',
            scaleLength: '0',
            lineWidth: 32,
            size: 185
        });
        var bgc4 = $("#circle-four").attr('data-bgcolor');
        var trc4 = $("#circle-four").attr('data-trackcolor');
        $('#circle-four').easyPieChart({
            barColor: bgc4,
            trackColor: trc4,
            rotate: '0',
            lineCap: 'butt',
            scaleLength: '0',
            lineWidth: 32,
            size: 185
        });
    }
});
(function($) {
    "use strict";
    
    //Isotope
    var winDow = $(window);
    // Needed variables
    var $container = $('.portfolio-items');
    var $filter = $('.filter');

    try {
        $container.imagesLoaded(function() {
            $container.show();
            $container.isotope({
                filter: '*',
                layoutMode: 'masonry',
                animationOptions: {
                    duration: 750,
                    easing: 'linear'
                }
            });
        });
    } catch (err) {
    }

    winDow.bind('resize', function() {
        var selector = $filter.find('a.active').attr('data-filter');

        try {
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
        } catch (err) {
        }
        return false;
    });

    // Isotope Filter 
    $filter.find('a').click(function() {
        var selector = $(this).attr('data-filter');

        try {
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
        } catch (err) {

        }
        return false;
    });


    var filterItemA = $('.filter a');

    filterItemA.on('click', function() {
        var $this = $(this);
        if (!$this.hasClass('active')) {
            filterItemA.removeClass('active');
            $this.addClass('active');
        }
    });
})(jQuery);

(function($){
    'use strict';
    //Scroll Menu
    function menuToggle()
    {
        var windowWidth = $(window).width();

        if (windowWidth > 767) {
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 405) {
                    $('.navbar').addClass('navbar-fixed-top animated fadeIn');
                    $('.navbar').removeClass('main-nav');
                } else {
                    $('.navbar').removeClass('navbar-fixed-top');
                    $('.navbar').addClass('main-nav');
                }
            });
        } else {

            $('.navbar').addClass('main-nav');

        }
        ;
        if (windowWidth > 767) {
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 405) {
                    $('.top-bar').addClass('top-bar-hide');
                } else {
                    $('.top-bar').removeClass('top-bar-hide');
                }
            });
        } else {
            $('.top-bar').addClass(this);
        }
        ;

        if (windowWidth > 767) {
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 405) {
                    $('.navbar-brand').addClass('change-logo');
                } else {
                    $('.navbar-brand').removeClass('change-logo');
                }
            });
        } else {
            $('.navbar-brand').addClass(this);
        }

    }

    menuToggle();


    $(document).ready(function() {
        if ($(window).width() < 768)
        {
            $(".navbar-nav li a").click(function(event) {
                $(".navbar-collapse").collapse('hide');
            });
        }
    });
})(jQuery);

(function($){
   'use strict';
   //Initiat WOW JS
    var wow = new WOW({
    mobile: false       // trigger animations on mobile devices (default is true)
  });
wow.init();
})(jQuery);

(function($){
    'use strict';
    // Timer
    if ($(".funfacts").length > 0)
    {
        $('.funfacts').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
            if (visible) {
                $(this).find('.timer').each(function() {
                    var $this = $(this);
                    $({Counter: 0}).animate({Counter: $this.text()}, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.ceil(this.Counter));
                        }
                    });
                });
                $(this).unbind('inview');
            }
        });

    }
})(jQuery);
(function($) {
    'use strict';
    // Google Map Customization
    if ($("#gmap").length > 0)
    {
        (function() {

            var map;

            map = new GMaps({
                el: '#gmap',
                lat: glatitude,
                lng: glongitude,
                scrollwheel: false,
                zoom: 16,
                zoomControl: true,
                panControl: false,
                streetViewControl: false,
                mapTypeControl: false,
                overviewMapControl: false,
                clickable: false
            });

            var image = '';
            map.addMarker({
                lat: glatitude,
                lng: glongitude,
                icon: image,
                animation: google.maps.Animation.DROP,
                verticalAlign: 'bottom',
                horizontalAlign: 'center',
                backgroundColor: '#d3cfcf',
            });


            var styles =[
                {
                    "featureType": "road",
                    "stylers": [
                        {"color": "#ffffff"}
                    ]
                }, {
                    "featureType": "water",
                    "stylers": [
                        {"color": "#99b3cc"}
                    ]
                }, {
                    "featureType": "landscape",
                    "stylers": [
                        {"color": "#f2efe9"}
                    ]
                }, {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {"color": "#d3cfcf"}
                    ]
                }, {
                    "featureType": "poi",
                    "stylers": [
                        {"color": "#ded2ac"}
                    ]
                }, {
                    "elementType": "labels.text",
                    "stylers": [
                        {"saturation": 1},
                        {"weight": 0.1},
                        {"color": "#000000"}
                    ]
                }

            ];

            map.addStyle({
                styledMapName: "Styled Map",
                styles: styles,
                mapTypeId: "map_style"
            });

            map.setStyle("map_style");
        }());
    }
})(jQuery);
(function($) {
    if ($("#contact-form").length > 0)
    {
        $("body, html").on("submit", "#contact-form", function(e) {
            e.preventDefault();
            var requrl = prloadorimg + '/inc/mail.php';
            $("#consubmit").html('Please Wait..');
            var name = $("#conname").val();
            var email = $("#conemail").val();
            var message = $("#conmessage").val();
            if (name === '')
            {
                $("#consubmit").html('Submit');
                $("#conname").css('border-color', '#db1820');
                $("#conname").addClass("emptyfield");
            }
            else
            {
                $("#consubmit").html('Please Wait..');
                $("#conname").css('border-color', '#d7d7d7');
                $("#conname").removeClass("emptyfield");
                if (email === '')
                {
                    $("#consubmit").html('Submit');
                    $("#conemail").css('border-color', '#db1820');
                    $("#conemail").addClass("emptyfield");
                }
                else
                {
                    $("#consubmit").html('Please Wait..');
                    $("#conemail").css('border-color', '#d7d7d7');
                    $("#conemail").removeClass("emptyfield");
                    if (message === '')
                    {
                        $("#consubmit").html('Submit');
                        $("#conmessage").css('border-color', '#db1820');
                        $("#conmessage").addClass("emptyfield");
                    }
                    else
                    {
                        $("#consubmit").html('Please Wait..');
                        $("#conmessage").css('border-color', '#d7d7d7');
                        $("#conmessage").removeClass("emptyfield");
                        $.ajax({
                            type: "POST",
                            url: requrl,
                            data: {name: name, email: email, message: message},
                            success: function(data)
                            {
                                $("#consubmit").html('Successfully Sent');
                                $("#conname").val('');
                                $("#conemail").val('');
                                $("#conmessage").val('');
                            }
                        });
                    }
                }
            }
            $("#contact-form").unbind('submit');
            return false;
        });
    }
})(jQuery);



