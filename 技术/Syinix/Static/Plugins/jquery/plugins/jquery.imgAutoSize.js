// jQuery.imgAutoSize.js
// Tang Bin - http://planeArt.cn/ - MIT Licensed

// jQuery(function ($) {
//     // .imgWrap这个是图片外部容器，使用了本插件后超大的图片宽度将会限制在容器宽度
//     // 如果要控制图片与容器的边距，如20像素： $('.imgWrap').imgAutoSize(20);
//     $('.imgWrap').imgAutoSize();
// });

(function ($) {
 
    var loadImg = function (url, fn) {
        var img = new Image();
        img.src = url;
        if (img.complete) {
            fn.call(img);
        } else {
            img.onload = function () {
                fn.call(img);
                img.onload = null;
            };
        };
    };
 
    $.fn.imgAutoSize = function (padding) {
        var maxWidth = this.innerWidth() - (padding || 0);
        return this.find('img').each(function (i, img) {
            loadImg(this.src, function () {
                if (this.width > maxWidth) {
                    var height = maxWidth / this.width * this.height,
                        width = maxWidth;
 
                    img.width = width;
                    img.height = height;
                };
            });
        });
    };
 
})(jQuery);