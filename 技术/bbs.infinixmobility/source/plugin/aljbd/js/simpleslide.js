 ;(function($){
    $.fn.simpleSlideClass = function(settings) {
        settings = jQuery.extend({
            intervalTime: 5,
            AddClass:'active'
        },
        settings);
        var BoxObject = this;
        var ListObject = BoxObject.children();
    	var BoxObjectSelector = $(BoxObject).selector;
        var IntervalTime = settings.intervalTime;
        var AddClass = settings.addClass;
		var ListLength = 0;
    	var T;
        var curLiIndex = 0;
        var changeFlag = 0;
        if (isNaN(IntervalTime) || IntervalTime <= 1) {
            IntervalTime = 5;
        }
        if (!AddClass) {
            AddClass='active';
        }
        function initialize() {
        	start();
        	mousehover();
        }
        function start(){
        	ListLength = ListObject.length;
            T = setInterval(function() {
                automove();
            },
            IntervalTime * 1000);
        }
        function automove(){
        	curLiIndex = BoxObject.find('.'+AddClass).index();
        	changeFlag = curLiIndex+1;
        	if (changeFlag>=ListLength) {
        		changeFlag=0;
        	};
            ListObject.eq(changeFlag).addClass(AddClass).siblings().removeClass(AddClass);
            changeFlag++;
        }
        function mousehover() {
            BoxObject.mouseover(function() {
                clearInterval(T);
            })
            BoxObject.mouseout(function() {
                T = setInterval(function() {
                    automove();
                },
                IntervalTime * 1000);
            })
        };
        return initialize();
    };
})(jQuery);