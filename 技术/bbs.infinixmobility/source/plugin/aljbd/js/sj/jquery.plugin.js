/**
 * ������ж�
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
 * ������վ��֤��
 * $(#seccode).m_seccode();
 */
(function($){

    $.fn.m_seccode = function(options) {

        var defaults = {
            width:'75px',
            height:'25px',
            title:'���������֤��'
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

/* ���ֲ����ı���괦
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
 * tab�л�
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
 * ����ʽ������
 * new $.m_drawer('#id',{})
 * @author moufer<moufer@163.com>
 */
(function($) {

    $.m_drawer = function(selector, options, callbacks) {

        //Ĭ�����ò���
        var _d_options = {
            place:'center',                 //��ʾ��λ left, center, right 
            width:'100%',                   //���
            height:'auto',                  //�߶�
            type:'auto-top',                //��ʾ��ʽ
                                            //lock-top����ʾ��ҳ�涥��������������ƶ���
                                            //auto-top����ʾ�ڴ��ڶ���������������ƶ���
                                            //auto-center����ʾ�ڴ������룬����������ƶ���
                                            //auto-bottom���̶���ʾ��ҳ�涥��������������ƶ���
                                            //float-top����ʾ�ڴ��ڶ����������洰�ڸ�����
                                            //float-center����ʾ�ڴ������븡�����洰�ڸ�����
                                            //float-bottom����ʾ�ڴ��ڵײ��������洰�ڸ�����
            area_class: '',                 //�����������ʽ�ࣨ��ѡ��
            direction:'top',                //���뷽�� none��top��left��right
            speed:'fast'                    //�����ٶ� fast,normal,slow
        }

        //Ĭ�ϻص������б�
        var _d_callbacks = {
            onInit:null,
            onOpen:null,
            onClose:null,
            onSubmit:null
        }

        //��ǰ��
        var _drawer = this;
        //����������
        var _my = $(selector);
        //������ò���
        var _opts = $.extend({}, _d_options, options);
        //�ص�����
        var _callbacks = $.extend({}, _d_callbacks, callbacks);
        //������div
        var $box = $('<div></div>').addClass('drawer-box');
        //ģ̬��
        var $pattern = $('<div></div>').addClass('drawer-pattern');
        //���������
        var $area = $('<div></div>').addClass('drawer-area');
        //���ù����������ʽ��
        if(_opts.area_class) $area.addClass(_opts.area_class);

        //�Ƿ��һ�δ򿪶Ի���
        this.is_first_open = true;
        /*
        _opts.place = 'center'; // left,center,right
        _opts.width = 90;
        _opts.height = 'auto';
        _opts.type = 'float-top'; //lock-top,auto-top,auto-center,auto-bottom,float-top,float-center,float-bottom
        _opts.direction = 'top'; //none,top,left,right
        _opts.speed = 'slow'; //fast,normal,slow
        */

        //��ʼ���Ͱ�
        var _init = {

            //UI��װ
            create:function() {
                //��ܲ�
                $box.addClass('drawer-' + _opts.place).addClass('drawer-area-'+_opts.type);
                //�����
                //var maxwidth = _opts.sizeunit == 'px' ? $(document.body).width() : 100;
                var height = _opts.height=='auto' ? 'auto' : (_opts.height);
                //��������Ⱥ͸߶�
                $area.css (
                {
                    'width' : _opts.width,
                    'height' : height
                }).hide();
                //ģ̬�����ùر����Ͳ�����
                $pattern.attr('data-type','close').hide();
            },

            //��ʾʱλ�ó�ʼ��
            show:function() {
                //ģ̬��
                $pattern.height(Math.max($(window).height(),$(document.body).height())).width($(document.body).width());
                //����Ǿ�����ʾ���ݣ������left���ж�λ
                if(_opts.place == 'center') {
                    var left = Math.round(($(document.body).width() - $area.width()) / 2);
                    $area.css('left', left + 'px');
                }
                //�Ի�����ʾ��λ
                if(_opts.type == 'auto-top') {
                    $area.css('top', $(window).scrollTop() + 'px');
                } else if (_opts.type == 'auto-center') {
                    var top = 0;
                    var body_height = $(document.body).height();
                    var scrollTop = $(window).scrollTop();
                    var height = $(window).height()-$area.height();
                    //ҳ��ȴ��ڸ�
                    if(height < 0) {
                        if(scrollTop > 1) {
                            //���ڶ�����ҳ��ײ����ڶԻ����
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

            //����ʱ�ĳ�ʼ������
            hide:function() {
            },

            //����
            load:function() {

                //ҳ��Ԫ�س�ʼ��
                var d = _opts.place;
                _init.create();

                //������ҳ
                $box.append($pattern).append($area.append(_my.css('display','block')));
                $(document.body).append($box);

                //��ʼ���ص�
                if(_callbacks.onInit) {
                    _callbacks.onInit(_drawer, $area);
                }
                //�ύ��ť�ص�
                if(_callbacks.onSubmit) {
                    var submit = $area.find('[data-type="submit"]');
                    if(submit[0]) {
                        submit.click(function() {
                            return _callbacks.onSubmit(_drawer, $area);
                        });
                    }
                }

                //���¼�
                _event.bind();
            }
        };

        var _animate = {
            //��ʾ����
            show:function() {
                var attr = {};
                var speed = _opts.direction == 'none' ? 0 : _opts.speed;
                var overflowX = $(document.body).css('overflow-x');
                $box.show();
                //��ʾʱ��Ҫ��Ԫ��λ�ó�ʼ��
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

                //ִ�ж���
                $pattern.fadeIn(speed);
                $area.animate(
                    attr, speed, function() {
                        $(document.body).css('overflow-x', overflowX);
                });
            },
            //���ض���
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

        //��Ϊ�¼�����
        var _event = {
            //�򿪳����
            open:function () {
                //�ص�����
                if(_callbacks.onOpen) {
                    var ret = _callbacks.onOpen(_drawer,_my);
                    if(ret==false) return;
                }
                _animate.show();
            },
            //�ر�
            close:function () {
                //�ص�����
                if(_callbacks.onClose) {
                    var ret = _callbacks.onClose(_drawer,_my);
                    if(ret == false) return;
                }
                _animate.hide();
            },
            //���¼�
            bind:function() {
                $pattern.click(function() {
                    _event.close();
                });

                $box.find('[data-type="close"]').click(function() {
                    _event.close();
                });
            }
        };

        //��
        this.open = function(callback) {
            if(callback) {
                _callbacks.onOpen = callback;
            }
            _event.open();
            this.is_first_open = false;
        }

        //�ر�
        this.close = function(callback) {
            if(callback) {
                _callbacks.onClose = callback;
            }
            _event.close();
        }

        //ɾ��
        this.remove = function(callback) {
            if(callback) {
                _callbacks.onRemove = callback;
            }
            //�ص�����
            if(_callbacks.onRemove) {
                var ret = _callbacks.onRemove(_drawer,$area);
                if(ret == false) return;
            }
            $box.remove();
        }

        //���ع���������
        this.area = function() {
            return $area;
        }

        _init.load();

    }

})(jQuery);

/**
 * ��������ͷ����ײ���
 * $('#id').m_floatbar({})
 * @author moufer<moufer@163.com>
 */
(function($) {

    $.fn.m_floatbar = function(options) {

        var defaults = {
            barId : '',
            type: 'normal', //normal����������ҳ���м��һ���֣�����������ֵ���ڸ�����ʱ���򸡶��ڶ�������������С�ڹ�������ʼtopʱ������
                            //top��������ʼ���ڴ��ڵĶ�����ʾ
                            //bottom��������ʼ���ڴ��ڵײ���ʾ
            showTop: 0,     //topģʽʹ��, ������Ĭ�ϱ����أ����������߶�Ϊ����ֵ�߶�ʱ��ʾ������
            hideTop: 0,     //topģʽʹ�ã���ʾ��������Ϊ����ֵ�߶�ʱ���ع�����

            onResize: null,
            onTouchmove: null
        }

        return this.each(function(index, el) {
            
            //д��DOM���������ϵ�������Ϣ
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
                //�ײ�����
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
 * ajax ��ҳ����
 * $('#id').m_ajaxpage({})
 * @author moufer<moufer@163.com>
 */
(function($){

    $.fn.m_ajaxpage = function(options) {

        var defaults = {
            page:'div.[data-name="pagination"]',            //׼�������ķ�ҳ����
            container:'div.[data-name="data_container"]',   //���ݼ��ص���ʾ����
            load_mod:'append',                              //���ݼ���ģʽ,append:׷��, override:����
            append_mod:'',                              //append���ģʽ�µļ��ط�ʽ��auto:��ʾ�Զ�׷��
            onInit:null,                                    //��ʼ���ص�����
            end:0
        };

        var lang = {
            loading:'������...',
            next_link:'���ظ���...',

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
            
            //��ҳ������ص����������
            $this.html(page_obj);
            $this.find('a').each(function() {
                var link = $(this);
                //׷��ģʽ������Ҫ��һҳ����
                if(opts.load_mod == 'append') {
                    if(link.data('name') =='page_next') {
                        link.text(lang.next_link);
                    } else {
                        link.hide();
                    }
                }
                //����¼�
                link.click(function() {
                    load_data(link);
                    return false;
                });
            });
            //�Զ�׷�Ӱ�
            if(opts.load_mod == 'append' && opts.append_mod == 'auto') {
                auto_append();
            }
            //�ص��¼�
            if(opts.onInit) {
                opts.onInit($this, container);
            }
            if(opts.load_mod == 'append') {
                //û�з�ҳ�������˳�
                if(!$this.find('a.[data-name="page_next"]')[0]) {
                    $this.hide();
                    return;
                }
            }
            $this.show();
        }

        //���ݼ���
        function load_data(link, clear) {
            //����ģʽ��Ҫ���������Ԫ��
            if(typeof(clear)=='undefined') {
                clear = opts.load_mod == 'append' ? false : true;
            }
            if(typeof(link)=='object') {
                var url = link.attr('href').url();
                link.text(lang.loading).attr('disabled','disabled');
            } else {
                var url = link;
            }
            //�������Ե���¼�
            $this.find('a').unbind( "click" ).click(function() {
                return false;
            });
            $.post(url, {in_ajax:1}, function(data)
            {
                if(clear) {
                    //�������
                    container.empty();
                }
                container.append(data);

                if(clear) {
                    //�����ƶ�����������
                    //var offset = container.offset();
                    $(body).animate({scrollTop:0},350);
                }
                //���³�ʼ���¼��صķ�ҳ�������һҳʱ��
                init();
            });
        }

        //�Զ����أ�׷��ģʽ�£�����¶�����ظ��ఴť�ǣ��Զ���ȡ��һҳ��
        function auto_append() {
            var lock = false;
            var events = 'scroll touchstart touchmove touchend';
            var append_click = function() {
                var next_link = $this.find('a.[data-name="page_next"]');
                if(next_link[0]) {
                    next_link.click();
                }
            }

            //�����Զ����ص�λ�ü���
            var show = function (event) {
                //����������´������ǡ���һҳ����ť��top+height����������ť��ʾ�ڴ���ʱ
                var event_top = $this.offset().top + $this.height();
                //������ʾ����ײ�topֵ
                var wb = $(window).scrollTop()+$(window).height();
                //safariҳ���»�������ͷ���͵ײ������������Ǵ��ڸ߶�ֵȴû�б仯���Ӷ���ɰ�ť�Ѿ���ʾ��
                //���ǳ����жϲ����Ѿ���ʾ������ʵ�ʿ��Ӹ߶ȱ�󣬵����������û����Ӧ���߶�ֵ���ӣ����Դ��ڵײ�topֵ�ȴ���λ��С��
                //����취����JS�̶����Ӹ߶ȣ����ع�������Լ��70px
                if($.m_borwser.safari && !$.m_borwser.qq) {
                    wb += 70;
                }
                //���㴥����
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
            //�󶨹������ʹ�������ʱ��
            $(window).bind(events, show);
        }

    };

})(jQuery);

/**
 * ��������
 * $('#collapse').m_collapse();
 */
(function($) {

    $.fn.m_collapse = function(options) {

        var _d_options = {
            show_index:0,  //Ĭ����ʾ���������
            end:0
        };

        var _opts = $.extend({}, _d_options, options);
        
        return this.each(function(index, el) {

            //����ͼ���л�
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
                            //����ͼ��ͬ���仯
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
                //��������������������
                collapse.attr('data-index', index).removeClass().addClass('panel-collapse');
                if(_opts.show_index==index) {
                    collapse.show();
                    iconExtend.open(heading);
                } else {
                    collapse.hide();
                    iconExtend.off(heading);
                }
                //���ͷ���л�
                heading.click(function() {
                    toggle($(this), collapse);
                });
            });
            
        });

    }

})(jQuery);

/**
 * ��ȡ�������λ��Ϣ
 * $.m_location(callback_succeed,callback_error)
 * callback_succeed(float lat,float lng, object position)
 * callback_error(int code,string message, object error)
 */
(function($) {

    $.m_location = function (callbacks) {

        var lang = {
            'not_support':'��Ŀǰʹ�õ��������֧�ֶ�λ���ܡ�'
        };

        //2���ص��������ɹ���ȡ�ͻ�ȡʧ��
        var defaults = {
            succeed:null,
            error:null
        }

        var _opts = $.extend({}, defaults, callbacks);
        
        //��Ҫ�����֧��
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(location_succeed, location_error);
        } else {
            //�������֧�ֶ�λ
            var error = {
                code:-1,
                message:lang.not_support
            }
            location_error(error)
        }

        //��λ�ɹ�����ȡ����㲢ִ�лص�����
        function location_succeed(position) {
            if(_opts.succeed) {
                _opts.succeed (
                    position.coords.latitude,
                    position.coords.longitude,
                    position.coords
                );
            }
        }

        //��λʧ�ܣ����ش�����Ϣ
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