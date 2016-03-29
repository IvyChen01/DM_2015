//Modoer cache file
//Created on 2014-08-05 11:13:56

var siteurl = 'http://www.modoer.org';
var charset = 'gb2312';
var cookiepre = 'J6KLE_';
var cookiepath = '/';
var cookiedomain = 'modoer.org';
var urlroot = '';
var sitedomain = 'modoer.org';
var rewrite_mod = 'pathinfo';

var modules = new Array();
modules['weixin'] = new Array();
modules['weixin']['flag'] = 'weixin';
modules['weixin']['name'] = '微信公众号';
modules['weixin']['directory'] = '';

modules['item'] = new Array();
modules['item']['flag'] = 'item';
modules['item']['name'] = '主题点评';
modules['item']['directory'] = 'item';

modules['product'] = new Array();
modules['product']['flag'] = 'product';
modules['product']['name'] = '在线商城';
modules['product']['directory'] = 'product';

modules['review'] = new Array();
modules['review']['flag'] = 'review';
modules['review']['name'] = '点评';
modules['review']['directory'] = 'review';

modules['article'] = new Array();
modules['article']['flag'] = 'article';
modules['article']['name'] = '新闻资讯';
modules['article']['directory'] = 'article';

modules['coupon'] = new Array();
modules['coupon']['flag'] = 'coupon';
modules['coupon']['name'] = '优惠券';
modules['coupon']['directory'] = 'coupon';

modules['exchange'] = new Array();
modules['exchange']['flag'] = 'exchange';
modules['exchange']['name'] = '礼品兑换';
modules['exchange']['directory'] = 'exchange';

modules['card'] = new Array();
modules['card']['flag'] = 'card';
modules['card']['name'] = '会员卡';
modules['card']['directory'] = 'card';

modules['fenlei'] = new Array();
modules['fenlei']['flag'] = 'fenlei';
modules['fenlei']['name'] = '分类信息';
modules['fenlei']['directory'] = 'fenlei';

modules['ask'] = new Array();
modules['ask']['flag'] = 'ask';
modules['ask']['name'] = '问答';
modules['ask']['directory'] = 'ask';

modules['party'] = new Array();
modules['party']['flag'] = 'party';
modules['party']['name'] = '聚会活动';
modules['party']['directory'] = 'party';

modules['tuan'] = new Array();
modules['tuan']['flag'] = 'tuan';
modules['tuan']['name'] = '团购';
modules['tuan']['directory'] = 'tuan';

modules['group'] = new Array();
modules['group']['flag'] = 'group';
modules['group']['name'] = '小组';
modules['group']['directory'] = '';

modules['mylist'] = new Array();
modules['mylist']['flag'] = 'mylist';
modules['mylist']['name'] = '榜单';
modules['mylist']['directory'] = '';

modules['comment'] = new Array();
modules['comment']['flag'] = 'comment';
modules['comment']['name'] = '会员评论';
modules['comment']['directory'] = 'comment';

modules['member'] = new Array();
modules['member']['flag'] = 'member';
modules['member']['name'] = '会员';
modules['member']['directory'] = 'member';

modules['space'] = new Array();
modules['space']['flag'] = 'space';
modules['space']['name'] = '个人空间';
modules['space']['directory'] = 'space';

modules['link'] = new Array();
modules['link']['flag'] = 'link';
modules['link']['name'] = '友情链接';
modules['link']['directory'] = 'link';

modules['pay'] = new Array();
modules['pay']['flag'] = 'pay';
modules['pay']['name'] = '在线充值';
modules['pay']['directory'] = 'pay';

modules['adv'] = new Array();
modules['adv']['flag'] = 'adv';
modules['adv']['name'] = '广告';
modules['adv']['directory'] = 'adv';

modules['sms'] = new Array();
modules['sms']['flag'] = 'sms';
modules['sms']['name'] = '短信发送';
modules['sms']['directory'] = '';

modules['mobile'] = new Array();
modules['mobile']['flag'] = 'mobile';
modules['mobile']['name'] = '手机浏览';
modules['mobile']['directory'] = '';

website = {};
website.version = '20140803';
website.setting = {};
website.setting.charset = 'gb2312';
website.setting.tag_split = ' ';
website.module = {};

