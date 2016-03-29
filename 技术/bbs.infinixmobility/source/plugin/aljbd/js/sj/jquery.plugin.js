/**
 * 浏览器判断
 * $.m_borwser.safari
 */
(function($) {

    var userAgent = navigator.userAgent.toLowerCase();
    var borwser={};

    borwser.opera = userAgent.indexOf('opera') != -1 && opera.version();
    borwser.firefox = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
    borwser.msie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
    borwser.chrome = userAgent.indexOf('chrome') != -1 && userAgent.substr(userAgent.indexOf('chrome') + 7, 3);
    borwser.safari = userAgent.indexOf('safari') != -1 && userAgent.substr(userAgent.indexOf('safari') + 7, 3);
    borwser.qq = userAgent.indexOf('qqbrowser') != -1 && userAgent.substr(userAgent.indexOf('qqbrowser') + 9, 5);
    borwser.uc = userAgent.indexOf('ucbrowser') != -1 && userAgent.substr(userAgent.indexOf('safari') + 9, 9);

    $.m_borwser = borwser;

})(jQuery);

/**
 * 生成网站验证码
 * $(#seccode).m_seccode();
 */
(function($){

    $.fn.m_seccode = function(options) {

        var defaults = {
            width:'75px',
            height:'25px',
            title:'点击更新验证码'
        };

        return this.each(function(index, el) {

            var my = $(this)
            var data = $(this).data();
            if(!data) data = {};
            var opts = $.extend({}, defaults, options, data);
            var img = $('<img>').data('name','seccode_img');

            my.empty();

            img.css({
                width:opts.width, 
                height:opts.height, 
                cursor:"pointer"
            }).attr("title", opts.title);

            img.click(function() {
                this.src= Url('modoer/seccode/x/'+getRandom());
                my.show();
            });

            img.appendTo(my);
            img.click();

        });

    };

})(jQuery);

/* 文字插入文本光标处
 * $("#ID").insertAtCaret("text")
 */
(function($) {

    $.fn.extend({
        insertAtCaret: function(myValue) {
            var $t = $(this)[0];
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        }
    })

})(jQuery);

/**
 * tab切换
 * $('#id').m_nav({})
 * @author moufer<moufer@163.com>
 */
(function($) {

    $.fn.m_nav = function() {

        var navBox = $(this).find('.atab-box-nav');
        var areaBox = $(this).find('.atab-box-area');

        init = function() {
            var count = navBox.find('a').length;
            var width = Math.round(100/count);
            navBox.find('a').each(function()
            {
                var a = $(this);
                a.css({'width':width+'%'});
                if(areaBox[0]) {
                    a.click(function()
                    {
                        a_click(a);
                    }
                    ).attr('href','javascript:');
                }
            });
            if(!areaBox[0]) return;
            areaBox.find('.atab-box-area-dispay').hide();
            var current = navBox.find('a.atab-box-nav-current');
            if(current[0]) show_area(current.data('id'));
        }

        a_click = function(a) {
            navBox.find('a').each(function() {
                if(a.data('id') == $(this).data('id')) {
                    a.addClass('atab-box-nav-current');
                } else {
                    $(this).removeClass('atab-box-nav-current');
                }
            });
            areaBox.find('div.atab-box-area-dispay').hide();
            show_area(a.data('id'));
        }

        show_area = function(id) {
            areaBox.show();
            $('#'+id).show();
        }

        init();
    }

})(jQuery);

/**
 * 抽屉式弹出层
 * new $.m_drawer('#id',{})
 * @author moufer<moufer@163.com>
 */
(function($) {

    $.m_drawer = function(selector, options, callbacks) {

        //默认配置参数
        var _d_options = {
            place:'center',                 //显示方位 left, center, right 
            width:'100%',                   //宽度
            height:'auto',                  //高度
            type:'auto-top',                //显示形式
                                            //lock-top（显示在页面顶部，不随滚动条移动）
                                            //auto-top（显示在窗口顶部，不随滚动条移动）
                                            //auto-center（显示在窗口中央，不随滚动条移动）
                                            //auto-bottom（固定显示在页面顶部，不随滚动条移动）
                                            //float-top（显示在窗口顶部浮动，随窗口浮动）
                                            //float-center（显示在窗口中央浮动，随窗口浮动）
                                            //float-bottom（显示在窗口底部浮动，随窗口浮动）
            area_class: '',                 //工作区框架样式类（可选）
            direction:'top',                //进入方向 none，top，left，right
            speed:'fast'                    //进入速度 fast,normal,slow
        }

        //默认回调函数列表
        var _d_callbacks = {
            onInit:null,
            onOpen:null,
            onClose:null,
            onSubmit:null
        }

        //当前类
        var _drawer = this;
        //工作区内容
        var _my = $(selector);
        //插件配置参数
        var _opts = $.extend({}, _d_options, options);
        //回调函数
        var _callbacks = $.extend({}, _d_callbacks, callbacks);
        //插件框架div
        var $box = $('<div></div>').addClass('drawer-box');
        //模态层
        var $pattern = $('<div></div>').addClass('drawer-pattern');
        //工作区框架
        var $area = $('<div></div>').addClass('drawer-area');
        //设置工作区框架样式类
        if(_opts.area_class) $area.addClass(_opts.area_class);

        //是否第一次打开对话框
        this.is_first_open = true;
        /*
        _opts.place = 'center'; // left,center,right
        _opts.width = 90;
        _opts.height = 'auto';
        _opts.type = 'float-top'; //lock-top,auto-top,auto-center,auto-bottom,float-top,float-center,float-bottom
        _opts.direction = 'top'; //none,top,left,right
        _opts.speed = 'slow'; //fast,normal,slow
        */

        //初始化和绑定
        var _init = {

            //UI组装
            create:function() {
                //框架层
                $box.addClass('drawer-' + _opts.place).addClass('drawer-area-'+_opts.type);
                //最大宽度
                //var maxwidth = _opts.sizeunit == 'px' ? $(document.body).width() : 100;
                var height = _opts.height=='auto' ? 'auto' : (_opts.height);
                //工作区宽度和高度
                $area.css (
                {
                    'width' : _opts.width,
                    'height' : height
                }).hide();
                //模态层设置关闭类型并隐藏
                $pattern.attr('data-type','close').hide();
            },

            //显示时位置初始化
            show:function() {
                //模态层
                $pattern.height(Math.max($(window).height(),$(document.body).height())).width($(document.body).width());
                //如果是居中显示内容，则计算left进行定位
                if(_opts.place == 'center') {
                    var left = Math.round(($(document.body).width() - $area.width()) / 2);
                    $area.css('left', left + 'px');
                }
                //对话层显示定位
                if(_opts.type == 'auto-top') {
                    $area.css('top', $(window).scrollTop() + 'px');
                } else if (_opts.type == 'auto-center') {
                    var top = 0;
                    var body_height = $(document.body).height();
                    var scrollTop = $(window).scrollTop();
                    var height = $(window).height()-$area.height();
                    //页面比窗口高
                    if(height < 0) {
                        if(scrollTop > 1) {
                            //窗口顶部到页面底部大于对话层高
                            if(body_height - scrollTop >= height) {
                                top = scrollTop;
                            } else {
                                top = body_height-$area.height();
                            }
                        }
                        if(top < 0) top = 0;
                    } else {
                        top = scrollTop + Math.round(height / 2);
                    }
                    $area.css('top', top + 'px');
                } else if (_opts.type == 'auto-bottom') {
                    var top = $(window).scrollTop() + $(window).height() - $area.height();
                    $area.css('top', top + 'px');
                } else if (_opts.type == 'lock-bottom') {
                    var top = $(document.body).height() - $area.height();
                    $area.css('top', top + 'px');
                    $(window).scrollTop(top);
                } else if (_opts.type == 'float-top') {
                    $area.css({
                        position: 'fixed',
                        top: 0
                    });
                } else if (_opts.type == 'float-center') {
                    top = Math.round(($(window).height() - $area.height()) / 2);
                    if(top < 0) top = 0;
                    $area.css({
                        position: 'fixed',
                        top : top
                    });
                } else if (_opts.type == 'float-bottom') {
                    $area.css({
                        position: 'fixed',
                        bottom : 0
                    });
                };
            },

            //隐藏时的初始化操作
            hide:function() {
            },

            //载入
            load:function() {

                //页面元素初始化
                var d = _opts.place;
                _init.create();

                //插入网页
                $box.append($pattern).append($area.append(_my.css('display','block')));
                $(document.body).append($box);

                //初始化回调
                if(_callbacks.onInit) {
                    _callbacks.onInit(_drawer, $area);
                }
                //提交按钮回调
                if(_callbacks.onSubmit) {
                    var submit = $area.find('[data-type="submit"]');
                    if(submit[0]) {
                        submit.click(function() {
                            return _callbacks.onSubmit(_drawer, $area);
                        });
                    }
                }

                //绑定事件
                _event.bind();
            }
        };

        var _animate = {
            //显示动画
            show:function() {
                var attr = {};
                var speed = _opts.direction == 'none' ? 0 : _opts.speed;
                var overflowX = $(document.body).css('overflow-x');
                $box.show();
                //显示时必要的元素位置初始化
                _init.show();

                $area.show();
                if(_opts.place=='center') {
                    //lock-top,auto-top,auto-center,auto-bottom,float-top,float-center,float-bottom
                    if( _opts.type == 'lock-top' || _opts.type == 'float-top' || _opts.type == 'auto-top') {
                        attr.top = 0;
                        if(_opts.type == 'auto-top') {
                            attr.top = $area.offset().top;
                        }
                        $area.css({top:-$area.height()});
                    } else if(_opts.type == 'float-bottom' ) {
                        attr.bottom = 0;
                        $area.css({bottom:-$area.height()});
                    } else if(_opts.type == 'auto-bottom'||_opts.type == 'lock-bottom') {
                        attr.top = $area.offset().top;
                        attr.height = $area.height();
                        $area.css({top:attr.top + $area.height(), height:0});
                    } else {
                        attr.left = $area.offset().left;
                        if(parseInt(Math.random().toString().substr(2,1))%2==1) {
                            $area.css({left:$(window).width()});
                        } else {
                            $area.css({left:-$area.width()});
                        }
                        $(document.body).css('overflow-x','hidden');
                    }
                } else {
                    attr.left = $area.offset().left;
                    if(_opts.place == 'left') {
                        $area.css({left:-$area.width()});
                    } else {
                        $area.css({left:$(window).width()});
                    }
                    $(document.body).css('overflow-x','hidden');
                }

                //执行动画
                $pattern.fadeIn(speed);
                $area.animate(
                    attr, speed, function() {
                        $(document.body).css('overflow-x', overflowX);
                });
            },
            //隐藏动画
            hide:function() {
                var attr = {};
                var speed = _opts.direction == 'none' ? 0 : _opts.speed;
                //$(document.body).css('overflow-x','hidden');
                //$(document.body).css('overflow-x','auto');
                $pattern.fadeOut('fast');
                $area.fadeOut('fast');
                $box.fadeOut('fast');
                _init.hide();
            }
        };

        //行为事件处理
        var _event = {
            //打开抽屉层
            open:function () {
                //回调函数
                if(_callbacks.onOpen) {
                    var ret = _callbacks.onOpen(_drawer,_my);
                    if(ret==false) return;
                }
                _animate.show();
            },
            //关闭
            close:function () {
                //回调函数
                if(_callbacks.onClose) {
                    var ret = _callbacks.onClose(_drawer,_my);
                    if(ret == false) return;
                }
                _animate.hide();
            },
            //绑定事件
            bind:function() {
                $pattern.click(function() {
                    _event.close();
                });

                $box.find('[data-type="close"]').click(function() {
                    _event.close();
                });
            }
        };

        //打开
        this.open = function(callback) {
            if(callback) {
                _callbacks.onOpen = callback;
            }
            _event.open();
            this.is_first_open = false;
        }

        //关闭
        this.close = function(callback) {
            if(callback) {
                _callbacks.onClose = callback;
            }
            _event.close();
        }

        //删除
        this.remove = function(callback) {
            if(callback) {
                _callbacks.onRemove = callback;
            }
            //回调函数
            if(_callbacks.onRemove) {
                var ret = _callbacks.onRemove(_drawer,$area);
                if(ret == false) return;
            }
            $box.remove();
        }

        //返回工作区对象
        this.area = function() {
            return $area;
        }

        _init.load();

    }

})(jQuery);

/**
 * 浮动条（头部或底部）
 * $('#id').m_floatbar({})
 * @author moufer<moufer@163.com>
 */
(function($) {

    $.fn.m_floatbar = function(options) {

        var defaults = {
            barId : '',
            type: 'normal', //normal：浮动层是页面中间的一部分，当滚动条的值大于浮动层时，则浮动在顶部，当滚动条小于滚动条初始top时则隐藏
                            //top：浮动层始终在窗口的顶部显示
                            //bottom：浮动层始终在窗口底部显示
            showTop: 0,     //top模式使用, 浮动层默认被隐藏，当滚动条高度为设置值高度时显示浮动条
            hideTop: 0,     //top模式使用，表示当滚动条为设置值高度时隐藏滚动条

            onResize: null,
            onTouchmove: null
        }

        return this.each(function(index, el) {
            
            //写在DOM对象属性上的配置信息
            var dom_opts = $(this).data('options');
            var opts = $.extend({}, defaults, options, dom_opts);

            var bar = $(this);
            var bar_def_top = getCssNumAttr(bar,'top');
            var bar_def_height = 0;
            
            function init() {
                bar_def_height = bar.height();
                bar.css({position:'fixed'});
                if(opts.type=='top' && opts.showTop==0) {
                    $(document.body).css({
                        'margin-top': getMyHeight()+'px',
                    });
                    bar.css({top: 0});
                } else if(opts.type=='bottom') {
                    $(document.body).css({
                        'margin-bottom': getMyHeight()+'px',
                    });
                    bar.css({bottom: 0});
                } else {
                    resize();
                }
            }

            function resize(e) {
                if(opts.onResize) {
                    opts.onResize(getCssNumAttr(bar, 'top'));
                }
                var bar_height = getMyHeight();
                if(opts.type=='normal') {
                    bar.next().css('margin-top', bar_height+'px');
                }
            }

            function getMyHeight() {
                return bar.height() + getCssNumAttr(bar, 'padding-top') + getCssNumAttr(bar, 'padding-bottom');
            }

            function getCssNumAttr(conter, attrName) {
                var num = parseInt(conter.css(attrName).replace(/px/i,''));
                return isNaN(num) ? 0 : num;
            }

            function exec() {
                var top = 0;
                var scrollTop = $(window).scrollTop();
                //底部浮动
                if(opts.type=='bottom') {
                    if(opts.showTop < scrollTop && bar.css('display')=='none') bar.slideDown(); //show
                    if(opts.showTop > scrollTop && bar.css('display')!='none') bar.slideUp();
                    bar.css({bottom: 0});
                } else {
                    if(opts.type=='top' && opts.showTop > 0) {
                        //console.debug(bar.css('display'));
                        if(opts.hideTop==0) {
                            if(opts.showTop < scrollTop && bar.css('display')=='none') bar.slideDown(); //show
                            if(opts.showTop > scrollTop && bar.css('display')!='none') bar.slideUp();
                        } else {
                            if(scrollTop < opts.hideTop && scrollTop > opts.showTop && bar.css('display')=='none') bar.slideDown(); //show
                            if((scrollTop > opts.hideTop||scrollTop < opts.showTop) && bar.css('display')!='none') bar.slideUp();
                        }
                    } else {
                        if(opts.type=='normal') {
                            if(scrollTop < bar_def_top) {
                                top = bar_def_top - scrollTop;
                            } else {
                                top = 0;
                            }
                        }
                        bar.css('top', top + 'px'); 
                    }
                    //bar.css('top', top + 'px'); 
                }
                if(opts.onTouchmove) {
                    opts.onTouchmove(getCssNumAttr(bar, 'top'));
                }
            }

            $(window).resize(function(e) {
                resize();
            });

            $(window).bind('ontouchstart',function() {
                exec();
            });

            $(window).bind('touchmove',function() {
                exec();
            });

            init();

        });

    }

})(jQuery);

/**
 * ajax 分页加载
 * $('#id').m_ajaxpage({})
 * @author moufer<moufer@163.com>
 */
(function($){

    $.fn.m_ajaxpage = function(options) {

        var defaults = {
            page:'div.[data-name="pagination"]',            //准备解析的分页代码
            container:'div.[data-name="data_container"]',   //数据加载的显示容器
            load_mod:'append',                              //数据加载模式,append:追加, override:覆盖
            append_mod:'',                              //append最佳模式下的加载方式，auto:表示自动追加
            onInit:null,                                    //初始化回调函数
            end:0
        };

        var lang = {
            loading:'加载中...',
            next_link:'加载更多...',

            end:0
        };

        var $this = $(this);
        var opts = $.extend({}, defaults, options);
        var container = $(opts.container);

        init();

        return {
            get:function(url, clear) {
                load_data(url, clear);
            }
        }
        
        function init() {

            $this.empty();
            var page_obj = $(opts.page);
            
            //分页代码加载到插件容器内
            $this.html(page_obj);
            $this.find('a').each(function() {
                var link = $(this);
                //追加模式，不需要上一页连接
                if(opts.load_mod == 'append') {
                    if(link.data('name') =='page_next') {
                        link.text(lang.next_link);
                    } else {
                        link.hide();
                    }
                }
                //点击事件
                link.click(function() {
                    load_data(link);
                    return false;
                });
            });
            //自动追加绑定
            if(opts.load_mod == 'append' && opts.append_mod == 'auto') {
                auto_append();
            }
            //回调事件
            if(opts.onInit) {
                opts.onInit($this, container);
            }
            if(opts.load_mod == 'append') {
                //没有分页代码则退出
                if(!$this.find('a.[data-name="page_next"]')[0]) {
                    $this.hide();
                    return;
                }
            }
            $this.show();
        }

        //数据加载
        function load_data(link, clear) {
            //覆盖模式需要清空容器内元素
            if(typeof(clear)=='undefined') {
                clear = opts.load_mod == 'append' ? false : true;
            }
            if(typeof(link)=='object') {
                var url = link.attr('href').url();
                link.text(lang.loading).attr('disabled','disabled');
            } else {
                var url = link;
            }
            //禁用所以点击事件
            $this.find('a').unbind( "click" ).click(function() {
                return false;
            });
            $.post(url, {in_ajax:1}, function(data)
            {
                if(clear) {
                    //清空容器
                    container.empty();
                }
                container.append(data);

                if(clear) {
                    //窗口移动到容器顶部
                    //var offset = container.offset();
                    $(body).animate({scrollTop:0},350);
                }
                //重新初始化新加载的分页（非最后一页时）
                init();
            });
        }

        //自动加载（追加模式下，窗口露出加载更多按钮是，自动读取下一页）
        function auto_append() {
            var lock = false;
            var events = 'scroll touchstart touchmove touchend';
            var append_click = function() {
                var next_link = $this.find('a.[data-name="page_next"]');
                if(next_link[0]) {
                    next_link.click();
                }
            }

            //触发自动加载的位置计算
            var show = function (event) {
                //常规浏览器下触发点是“下一页”按钮的top+height，即整个按钮显示在窗口时
                var event_top = $this.offset().top + $this.height();
                //窗口显示的最底部top值
                var wb = $(window).scrollTop()+$(window).height();
                //safari页面下滑会隐藏头部和底部工具栏，但是窗口高度值却没有变化，从而造成按钮已经显示，
                //但是程序判断不了已经显示（窗口实际可视高度变大，但浏览器程序没有相应将高度值增加，所以窗口底部top值比触发位置小）
                //解决办法就是JS固定增加高度，隐藏工具栏大约高70px
                if($.m_borwser.safari && !$.m_borwser.qq) {
                    wb += 70;
                }
                //计算触发点
                if(wb >= event_top) {
                    $(window).unbind(events, show);
                    if(!lock) {
                        window.setTimeout(function() {
                            append_click();
                        }, 400);                        
                    }
                    lock = true;
                }
            };
            //绑定滚动条和触屏滑动时间
            $(window).bind(events, show);
        }

    };

})(jQuery);

/**
 * 伸缩组插件
 * $('#collapse').m_collapse();
 */
(function($) {

    $.fn.m_collapse = function(options) {

        var _d_options = {
            show_index:0,  //默认显示伸缩组序号
            end:0
        };

        var _opts = $.extend({}, _d_options, options);
        
        return this.each(function(index, el) {

            //伸缩图标切换
            var iconExtend = {
                add:function(heading) {
                    var icon = $('<span>').addClass('icon18')
                        .addClass('icon18-stand').addClass('icon18-extend')
                    heading.prepend($('<div>').addClass('panel-icon-r').append(icon));
                },
                open:function(heading) {
                    if(!heading.find('>.panel-icon-r>span')[0]) {
                        iconExtend.add(heading);
                    }
                    heading.find('>.panel-icon-r>span').removeClass('off');
                },
                off:function(heading) {
                    if(!heading.find('>.panel-icon-r>span')[0]) {
                        iconExtend.add(heading);
                    }
                    heading.find('>.panel-icon-r>span').addClass('off');
                }
            }

            function toggle(heading, collapse) {
                $this.find('> .panel-comm').each(function(index) {
                    var c_heading = $(this).find('> .panel-heading');
                    var c_collapse = $(this).find('> .panel-collapse');
                    if(c_collapse.data('index') == collapse.data('index')) {
                        c_collapse.slideToggle('fast',function() {
                            //伸缩图标同步变化
                            if(c_collapse.is(':hidden')) {
                                iconExtend.off(c_heading);
                            } else {
                                iconExtend.open(c_heading);
                            }
                        });
                    } else {
                        c_collapse.slideUp('fast',function() {
                            iconExtend.off(c_heading);
                        });
                    }
                });
            }

            var $this = $(this);
            $this.find('> .panel-comm').each(function(index) {
                var panel = $(this);
                var heading = panel.find('> div.panel-heading');
                var collapse = panel.find('> div.panel-collapse');
                //处理内容区，隐藏其他
                collapse.attr('data-index', index).removeClass().addClass('panel-collapse');
                if(_opts.show_index==index) {
                    collapse.show();
                    iconExtend.open(heading);
                } else {
                    collapse.hide();
                    iconExtend.off(heading);
                }
                //点击头部切换
                heading.click(function() {
                    toggle($(this), collapse);
                });
            });
            
        });

    }

})(jQuery);

/**
 * 获取浏览器定位信息
 * $.m_location(callback_succeed,callback_error)
 * callback_succeed(float lat,float lng, object position)
 * callback_error(int code,string message, object error)
 */
(function($) {

    $.m_location = function (callbacks) {

        var lang = {
            'not_support':'您目前使用的浏览器不支持定位功能。'
        };

        //2个回调函数，成功获取和获取失败
        var defaults = {
            succeed:null,
            error:null
        }

        var _opts = $.extend({}, defaults, callbacks);
        
        //需要浏览器支持
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(location_succeed, location_error);
        } else {
            //浏览器不支持定位
            var error = {
                code:-1,
                message:lang.not_support
            }
            location_error(error)
        }

        //定位成功，获取坐标点并执行回调方法
        function location_succeed(position) {
            if(_opts.succeed) {
                _opts.succeed (
                    position.coords.latitude,
                    position.coords.longitude,
                    position.coords
                );
            }
        }

        //定位失败，返回错误信息
        function location_error(error) {
            if(_opts.error) {
                _opts.error(
                    error.code,
                    error.message,
                    error
                );
            }
        }
    }

})(jQuery);