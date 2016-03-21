/**
 * Created with ljl.
 * User: palmchat
 * Date: 13-11-26
 * Time: 下午3:11
 * To change this template use File | Settings | File Templates.
 */
var cookie=function(){};
cookie.prototype = {
    getCookie: function (c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=")
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1
                c_end = document.cookie.indexOf(";", c_start)
                if (c_end == -1) c_end = document.cookie.length
                return unescape(document.cookie.substring(c_start, c_end))
            }
        }
        return ""
    },
    setCookie:function(c_name,value,expiredays){
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+
            ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
    },
    delCookie:function(c_name){
        this.setCookie(c_name,"",-1);
    }
}