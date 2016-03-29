// 本js在jquery后加载
var charset = document.charset;
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_chrome = userAgent.indexOf('chrome') != -1 && userAgent.substr(userAgent.indexOf('chrome') + 7, 3);
var is_safari = userAgent.indexOf('safari') != -1 && userAgent.substr(userAgent.indexOf('safari') + 7, 3);
var ajaxPostGlobal = 0;

// 去空格
String.prototype.trim = function() {  
    return this.replace(/(^\s*)|(\s*$)/g, "");
}
// 数组搜索
Array.prototype.indexof = function(value) {
    for (var i in this) {
        if(i==value) return this[i];
    }
    return -1;
}
// 判断字符串是否为数字
String.prototype.is_numeric = function() {
    var patn = /^[0-9]+$/;
    return patn.test(str);
}
// 转JS可用URL
String.prototype.url = function() {  
    return this.replace('&amp;','&');
}

//判断一个ID是否是有效的数字型ID
function is_id(id,name) {
    if(!is_numeric(id)||id < 1) {
        alert('无效的' + name + '！');
        return false;
    }
    return true;
}
// 判断字符串是否为数字
function is_numeric(num) {
    var patn = /^[0-9]+$/;
    return patn.test(num);
}
//获取相对路径
function getUrl() {
    if(arguments.length == 0) {
        return typeof(mod)=='undefined' ? '' : '';
    }

    var flag = arguments[0];
    var fullurl = arguments[4];
    var crmod = modules[flag];
    var url = !fullurl ? (urlroot+'/') : siteurl;

    if(flag == 'modoer') {
        url += 'index.php?m=index';
    } else if(typeof(crmod)=='undefined') {
        url += '';
    } else {
        url += 'index.php?m='+flag;
    }

    if(typeof(arguments[1])=='string') {
        url += '&act='+arguments[1];
    } else {
        return url;
    }

    var param = arguments[2];
    var type = typeof(param);
    if(type=='object') {
        var split = '?';
        for (var i=0; i<param.length; i++) {
            url += split + param[i];
            split = '&';
        }
    } else if(type=='string') {
        url += '&' + param;
    }

    if(typeof(arguments[3])=='string') {
        url += '#' + arguments[3];
    }
    if(fullurl) url = siteurl + url;
    return url;
}
// url标签格式转换成链接
function Url(url_format, anchor, full_url) {
    if(url_format == '') return getUrl('');
    var urlarr = url_format.split('/');
    var flag = urlarr[0];
    if(!urlarr[1]) return getUrl(flag);
    var act = urlarr[1];
    if(urlarr.length <= 2) return getUrl(flag, act);
    var param = split = '';
    for (var i=2; i<urlarr.length; i++) {
        param += split + urlarr[i] + '=' + urlarr[++i];
        split = '&';
    }
    return getUrl(flag, act, param, anchor, full_url);
}
//判断是否返回信息
function is_message(str) {
    return str.match(/\{\s+caption:".*",message:".*".*\s*\}/);
}
//判断是否为json
function is_json(str) {
    return str.match(/^\{.*:.*\}$/);
}
//判断是否为有效域名
function is_domain(domain) {
    domain = domain.trim();
    if(domain=='') return false;
    if(domain.indexOf('.')<=0) return false;
    if(domain.match(/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/)) return false;
    return domain.match(/^[a-z0-9][a-z0-9\-]+[a-z0-9](\.[a-z]{2,4})+$/i) != null;
}
//解析Json
function parse_json(str) {
    data = trim(trim(str, String.fromCharCode(0)));
    var json = null;
    try {
        json = jQuery.parseJSON(data);
    } catch(exception) {
        alert('JSON转换错误：' + exception);
    } finally {
        return json;
    }
}
//取随机值
function getRandom() {
    return Math.floor(Math.random()*1000+1);
}
//提示对话框
function myAlert(data, return_msg) {
    var mymsg = eval('('+data+')'); //JSON转换
    mymsg.message = mymsg.message.replace('ERROR:','');
    if(mymsg.extra == 'login') {
        if(window.confirm(mymsg.caption + '本次操作，需要“登录”后才能继续。点击“确定”，登录网站。')) {
            window.location.href = Url('member/mobile/do/login');
        }
        return;
    } else if(mymsg.extra == 'dlg') {
        dlgOpen(mymsg.caption, mymsg.message.replace("{LF}","\r\n"), 400, 300, true);
    } else if(mymsg.extra == 'msg') {
        alert(mymsg.message.replace("{LF}","\r\n"));
    } else if (mymsg.extra == 'location') {
        document.location = mymsg.message;
    } else {
        if(return_msg) {
            return mymsg.message;
        } else {
            alert(mymsg.message);
        }
    }
}
//显示验证码
function show_seccode() {
    var id= (arguments[0]) ? arguments[0] : 'seccode';
    if($('#'+id).html()!='') return;
    var sec = $('#'+id).empty();
    var img = $('<img />')
            .css({weight:"80px", height:"25px", cursor:"pointer"})
            .attr("title",'点击更新验证码')
            .click(function() {
                this.src= Url('modoer/seccode/x/'+getRandom());
                $('#'+id).show();
            });
    sec.append(img);
    img.click();
}
function common_ajax_next_page(boxid,pageid) {
    if(!ajax_loading) return;
    ajax_loading = false;
    var nexturl = $('#multipage').find('[nextpage="Y"]').attr('href');
    $('#multipage').remove();
    if(!nexturl) {
        $('#'+pageid).remove();
        return;
    }
    $('#'+pageid).find('a').text('正在加载...请稍后');
    $.post(nexturl, { 'in_ajax':1, 'waterfall':'Y' },
    function(result) {
        if(result == null) {
            $('#'+pageid).find('a').text('信息读取失败，请稍后尝试。');
        } else if (is_message(result)) {
            myAlert(result);
        } else if(result != '') {
            $('#'+boxid).append(result);
            if($('#multipage').find('[nextpage="Y"]')[0]) {
                ajax_loading = true;
                $('#'+pageid).find('a').text('加载更多...'); 
            } else {
                $('#'+pageid).remove();
            }
            $('#'+boxid).append($('#nextpage'));
            $('#'+boxid).listview('refresh');
        }
    });
}

function common_picture_nav(fx) {
    var current = null;
    var show = false;
    $('.album_picture').find('li').each(function(i) {
        if($(this).attr('show')!='N') {
            current = $(this);
        }
    });
    if(current[0]) {
        if(fx == 'N') {
            show = current.next();
            if(!show[0]) {
                show = $(".album_picture>li:first");
            }
        } else {
            show = current.prev();
            if(!show[0]) {
                show = $(".album_picture>li:last");
            }
        }        
    } else {
        show = $(".album_picture>li:first");
    }
    current.attr('show','N').hide();
    show.attr('show','Y').show();
}

//js跳转，同时解决ie丢失referfer
function jslocation (url) {
    while (url.indexOf('&amp;') > 0) {
        url = url.replace('&amp;', '&');
    }
    document.location = url;
}

function pageBack() {
    var a = window.location.href;
    if (/#top/.test(a)) {
        window.history.go( - 2);
        window.location.load(window.location.href)
    } else {
        window.history.back();
        window.location.load(window.location.href)
    }
}

function createPicMove(a, b, c) {
    var g = function(j) {
        return "string" == typeof j ? document.getElementById(j) : j
    };
    var d = function(j, l) {
        for (var k in l) {
            j[k] = l[k]
        }
        return j
    };
    var f = function(j) {
        return j.currentStyle || document.defaultView.getComputedStyle(j, null)
    };
    var i = function(l, j) {
        var k = Array.prototype.slice.call(arguments).slice(2);
        return function() {
            return j.apply(l, k.concat(Array.prototype.slice.call(arguments)))
        }
    };
    var e = {
        Quart: {
            easeOut: function(k, j, m, l) {
                return - m * ((k = k / l - 1) * k * k * k - 1) + j
            }
        },
        Back: {
            easeOut: function(k, j, n, m, l) {
                if (l == undefined) {
                    l = 1.70158
                }
                return n * ((k = k / m - 1) * k * ((l + 1) * k + l) + 1) + j
            }
        },
        Bounce: {
            easeOut: function(k, j, m, l) {
                if ((k /= l) < (1 / 2.75)) {
                    return m * (7.5625 * k * k) + j
                } else {
                    if (k < (2 / 2.75)) {
                        return m * (7.5625 * (k -= (1.5 / 2.75)) * k + 0.75) + j
                    } else {
                        if (k < (2.5 / 2.75)) {
                            return m * (7.5625 * (k -= (2.25 / 2.75)) * k + 0.9375) + j
                        } else {
                            return m * (7.5625 * (k -= (2.625 / 2.75)) * k + 0.984375) + j
                        }
                    }
                }
            }
        }
    };
    var h = function(k, n, m, l) {
        this._slider = g(n);
        this._container = g(k);
        this._timer = null;
        this._count = Math.abs(m);
        this._target = 0;
        this._t = this._b = this._c = 0;
        this.Index = 0;
        this.SetOptions(l);
        this.Auto = !!this.options.Auto;
        this.Duration = Math.abs(this.options.Duration);
        this.Time = Math.abs(this.options.Time);
        this.Pause = Math.abs(this.options.Pause);
        this.Tween = this.options.Tween;
        this.onStart = this.options.onStart;
        this.onFinish = this.options.onFinish;
        var j = !!this.options.Vertical;
        this._css = j ? "top": "left";
        var o = f(this._container).position;
        o == "relative" || o == "absolute" || (this._container.style.position = "relative");
        this._container.style.overflow = "hidden";
        this._slider.style.position = "absolute";
        this.Change = this.options.Change ? this.options.Change: this._slider[j ? "offsetHeight": "offsetWidth"] / this._count
    };
    h.prototype = {
        SetOptions: function(j) {
            this.options = {
                Vertical: true,
                Auto: true,
                Change: 0,
                Duration: 50,
                Time: 10,
                Pause: 4000,
                onStart: function() {},
                onFinish: function() {},
                Tween: e.Quart.easeOut
            };
            d(this.options, j || {})
        },
        Run: function(j) {
            j == undefined && (j = this.Index);
            j < 0 && (j = this._count - 1) || j >= this._count && (j = 0);
            this._target = -Math.abs(this.Change) * (this.Index = j);
            this._t = 0;
            this._b = parseInt(f(this._slider)[this.options.Vertical ? "top": "left"]);
            this._c = this._target - this._b;
            this.onStart();
            this.Move()
        },
        Move: function() {
            clearTimeout(this._timer);
            if (this._c && this._t < this.Duration) {
                this.MoveTo(Math.round(this.Tween(this._t++, this._b, this._c, this.Duration)));
                this._timer = setTimeout(i(this, this.Move), this.Time)
            } else {
                this.MoveTo(this._target);
                this.Auto && (this._timer = setTimeout(i(this, this.Next), this.Pause))
            }
        },
        MoveTo: function(j) {
            this._slider.style[this._css] = j + "px"
        },
        Next: function() {
            this.Run(++this.Index)
        },
        Previous: function() {
            this.Run(--this.Index)
        },
        Stop: function() {
            clearTimeout(this._timer);
            this.MoveTo(this._target)
        }
    };
    return new h(a, b, c, {
        Vertical: false
    })
}

//定位，获取经纬度
function getLocation(callback,error) {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(callback, error);
    }
}

//定位获取错误信息
function getLocationError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML="User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML="Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML="The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML="An unknown error occurred."
            break;
    }
}
//刷新当前页面
function document_reload() {
     document.location.reload();
}
//Ajax提交
function ajaxPost(formid,myid,func,use_data,dlgid,err_callback,set_domain) {
    if(typeof(set_domain)=='undefined'||set_domain==true) set_domain = true;
    //if(is_domain(sitedomain)) document.domain = sitedomain;
    if(ajaxPostGlobal != 0) {
        return false;
    }
    var iframeid = 'ajaxiframe';
    if($('#'+iframeid)[0] == null) {
        $(document.body).append('<iframe name="'+iframeid+'" id="'+iframeid+'"></iframe>');
    }
    var iframe = $('#'+iframeid);
    iframe.css("display","none");

    use_data = !use_data ? 0 : 1;
    ajaxPostGlobal = [formid, iframeid, myid, func, use_data];

    var form = $("#" + formid);
    form.attr("target", iframeid);
    form.append('<input type="hidden" name="in_ajax" value="1">');
    form.append('<input type="hidden" name="in_iframe" value="1">');
    iframe.unbind();
    iframe.load(function() {
        ajaxPostLoad(dlgid,err_callback,set_domain);
    });
    form[0].submit();
}
//ajax提交后返回
function ajaxPostLoad(dlgid, err_callback, set_domain) {
    if(set_domain && is_domain(sitedomain)) document.domain = sitedomain;
    if(ajaxPostGlobal==0) return;
    var ajaxparam = ajaxPostGlobal;
    ajaxPostGlobal = 0;
    var iframe = document.getElementById(ajaxparam[1]);
    var data = $(iframe.contentWindow.document.body).html();
    if(is_safari || is_moz) {
        //修正safari安装迅雷扩展后的问题
        var i = data.indexOf('<embed');
        if(i>=0) data = data.substring(0,i);
        i = data.indexOf('<div id="xunlei_');
        if(i>=0) data = data.substring(0,i);
    }
    //alert(data);
    if(data.indexOf('ERROR:') > 1) {
        if(err_callback) {
            err_callback(data);
        } else {
            myAlert(data.replace('ERROR:',''));
        }
        return;
    } else {
        //dlgClose(dlgid);
        if(data.match(/\{\s+caption:".*",message:".*".*\s*\}/)) {
            myAlert(data);
        }
    }
    //alert(strip_tags(data));
    if(ajaxparam[3]) {
        if(ajaxparam[4])
            setTimeout(ajaxparam[3]+'(\'' + ajaxparam[2] + '\',\'' + data.replace("'","\\'") + '\');', 10);
        else
            setTimeout(ajaxparam[3]+'(\'' + ajaxparam[2] + '\');', 10);
    }
}

//设置cookie
function set_cookie(name, value, expireDays) {
    name = cookiepre + name;
    var datetime = 0;
    var expires = new Date();
    if(typeof(expireDays)!='number') expireDays = 1;
    //if(!expireDays) expireDays = 1;
    if(expireDays != 0) {
        expires.setTime(expires.getTime() + expireDays * 24 * 3600 * 1000);
        datetime = expires.toGMTString();
    }
    var cookiestr = '';
    cookiestr = name + '=' + escape(value) + '; path=' + cookiepath;
    if(cookiedomain != '') {
        cookiestr += '; domain=' + cookiedomain;
    }
    if(datetime) cookiestr += '; expires=' + datetime;
    document.cookie = cookiestr;
}
//读取cookie字串
function get_cookieval(start) {
    var end = document.cookie.indexOf(";", start);
    if(end == -1) {
        end = document.cookie.length;
    }
    return unescape(document.cookie.substring(start, end));
}
//读取cookie
function get_cookie(name) {
    name = cookiepre + name;
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while(i < clen) {
        var j = i + alen;
        if(document.cookie.substring(i, j) == arg) return get_cookieval(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if(i == 0) break;
    }
    return null;
}
//删除cookie
function del_cookie(name) {
    var expires = new Date();
    expires.setTime (expires.getTime()-1);
    var cval = '';//get_cookie(name);
    name = cookiepre + name;
    var cookiestr = '';
    cookiestr = name + '=' + cval + '; path=' + cookiepath;
    if(cookiedomain != '') {
        cookiestr += '; domain=' + cookiedomain;
    }
    cookiestr += '; expires=' + expires.toGMTString();
    //alert(cookiestr);
    document.cookie = cookiestr;
}
function trim (str, charlist) {
  var whitespace, l = 0, i = 0;
  str += '';
  if (!charlist) {
    // default list
    whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
  } else {
    // preg_quote custom list
    charlist += '';
    whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
  }
  l = str.length;
  for (i = 0; i < l; i++) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(i);
      break;
    }
  }
  l = str.length;
  for (i = l - 1; i >= 0; i--) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(0, i + 1);
      break;
    }
  }
  return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

//统计和检测文字输入
function record_charlen(obj,max,d_id) {
    var con = $(obj);
    var len = con.val().length;
    if(d_id) {
        $('#'+d_id).text(len);
    }
}

function basename (path, suffix) {
    var b = path.replace(/^.*[\/\\]/g, '');
    if (typeof(suffix) == 'string' && b.substr(b.length - suffix.length) == suffix) {
        b = b.substr(0, b.length - suffix.length);
    }
    return b;
}
