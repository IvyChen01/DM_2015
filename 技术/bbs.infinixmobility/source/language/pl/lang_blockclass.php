<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $ID: lang_blockclass.php by Valery Votintsev at 
 *      polish language pack by kaaleth ( kaaleth-discuzpl@windowslive.com )
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(
	'blockclass_html'			=> 'Wyświetlanie',//'展示类',

	'blockclass_html_html'			=> 'Statyczny HTML',//'静态模块',
	'blockclass_html_script_blank'		=> 'Własny HTML',//'自定义HTML',
	'blockclass_html_script_search'		=> 'Wyszukiwarka artykułów',//'搜索条',
	'blockclass_html_script_line'		=> 'Pozioma linia',//'分割线',
	'blockclass_html_script_banner'		=> 'Baner',//'图片横幅',
	'blockclass_html_script_vedio'		=> 'Film',//'网络视频',
	'blockclass_html_script_stat'		=> 'Statystyki',//'数据统计',
	'blockclass_html_script_forumtree'	=> 'Lista forów',//'版块列表',
	'blockclass_html_script_google'		=> 'Google',
	'blockclass_html_script_adv'		=> 'Reklama',//'站点广告',
	'blockclass_html_script_friendlink'	=> 'Linki znajomych',//'友情链接',
	'blockclass_html_script_sort'		=> 'Script types(order?)',//'分类信息',
	'blockclass_html_script_category'	=> 'Script Category',//'分类信息',

	'blockclass_html_announcement'			=> 'Ogłoszenie',//'公告模块',
	'blockclass_announcement_field_url'		=> 'URL',//'公告链接',
	'blockclass_announcement_field_title'		=> 'Tytuł',//'公告标题',
	'blockclass_announcement_field_summary'		=> 'Streszczenie',//'公告内容',
	'blockclass_announcement_field_starttime'	=> 'Data rozpoczęcia',//'开始时间',
	'blockclass_announcement_field_endtime'		=> 'Data zakończenia',//'结束时间',
	'blockclass_announcement_script_announcement'	=> 'Ogłoszenia',//'站点公告',

	'blockclass_html_myapp'			=> 'Aplikacje',//'漫游模块',
	'blockclass_myapp_field_url'		=> 'URL',//'应用链接',
	'blockclass_myapp_field_title'		=> 'Nazwa',//'应用名称',
	'blockclass_myapp_field_icon'		=> 'Ikona',//'应用图标',
	'blockclass_myapp_field_icon_small'	=> 'Mała ikona',//'应用图标(小)',
	'blockclass_myapp_field_icon_abouts'	=> 'Ikona aplikacji',//'应用图标(大图)',
	'blockclass_myapp_script_myapp'		=> 'Aplikacje',//'漫游应用',

	'blockclass_forum'			=> 'Forum',//'论坛类',

	'blockclass_forum_thread'			=> 'Temat',//'帖子模块',
	'blockclass_thread_field_url'			=> 'URL',//'帖子URL',
	'blockclass_thread_field_title'			=> 'Tytuł',//'帖子标题',
	'blockclass_thread_field_pic'			=> 'Obrazek',//'附件图片',
	'blockclass_thread_field_summary'		=> 'Streszczenie',//'帖子内容',
	'blockclass_thread_field_author'		=> 'Autor',//'楼主',
	'blockclass_thread_field_authorid'		=> 'ID autora',//'楼主UID',
	'blockclass_thread_field_avatar'		=> 'Awatar autora',//'楼主头像',
	'blockclass_thread_field_avatar_middle'		=> 'Średni awatar autora',//'楼主头像(中)',
	'blockclass_thread_field_avatar_big'		=> 'Duży awatar autora',//'楼主头像(大)',
//REMOVED	'blockclass_thread_field_icon'			=> 'Ikona',//'帖子图标',
	'blockclass_thread_field_forumurl'		=> 'URL forum',//'版块URL',
	'blockclass_thread_field_forumname'		=> 'Nazwa forum',//'版块名称',
	'blockclass_thread_field_typename'		=> 'Data Type Name',//'主题分类名称',
	'blockclass_thread_field_typeicon'		=> 'Data Type Icon',//'主题分类图标',
	'blockclass_thread_field_typeurl'		=> 'URL kategorii',//'主题分类URL',
	'blockclass_thread_field_sortname'		=> 'Nazwa kategorii',//'分类信息名称',
	'blockclass_thread_field_sorturl'		=> 'URL kategorii',//'分类信息URL',
	'blockclass_thread_field_posts'			=> 'Posty',//'总发帖数',
	'blockclass_thread_field_todayposts'		=> 'Dzisiejsze posty',//'今日发帖数',
	'blockclass_thread_field_lastpost'		=> 'Ostatnie posty',//'最后回复时间',
	'blockclass_thread_field_dateline'		=> 'Data ostatniego posta',//'发帖时间',
	'blockclass_thread_field_replies'		=> 'Odpowiedzi',//'回复数',
	'blockclass_thread_field_views'			=> 'Wyświetleń',//'总浏览数',
	'blockclass_thread_field_heats'			=> 'Gorące',//'热度值',
	'blockclass_thread_field_recommends'		=> 'Polecenia',//'推荐数',
	'blockclass_thread_field_hourviews'		=> 'Wyświetlenia na godzinę',//'小时浏览数',
	'blockclass_thread_field_todayviews'		=> 'Wyświetleń dziś',//'今日浏览数',
	'blockclass_thread_field_weekviews'		=> 'Wyświetleń na tydzień',//'本周浏览数',
	'blockclass_thread_field_monthviews'		=> 'Wyświetleń na miesiąc',//'本月浏览数',
	'blockclass_thread_script_threaddigest'		=> 'Wykopy',//'精华帖',
	'blockclass_thread_script_threadhot'		=> 'Gorące tematy',//'热门帖',
	'blockclass_thread_script_threadstick'		=> 'Przyklejone tematy',//'置顶帖',
	'blockclass_thread_script_threadspecial'	=> 'Specjalne tematy',//'特殊主题帖',
	'blockclass_thread_script_threadnew'		=> 'Ostatnie tematy',//'最新帖',
	'blockclass_thread_script_threadspecified'	=> 'Specyficzne tematy',//'指定帖子',
	'blockclass_thread_script_thread'		=> 'Dostosuj',//'高级自定义',

	'blockclass_forum_forum'			=> 'Forum',//'版块模块',
	'blockclass_forum_field_title'			=> 'Tytuł',//'版块名称',
	'blockclass_forum_field_url'			=> 'URL',//'版块链接',
	'blockclass_forum_field_summary'		=> 'Streszczenie',//'版块介绍',
	'blockclass_forum_field_icon'			=> 'Ikona',//'版块图标',
	'blockclass_forum_field_posts'			=> 'Posty',//'版块帖子数',
	'blockclass_forum_field_threads'		=> 'Tematy',//'版块话题数',
	'blockclass_forum_field_todayposts'		=> 'Dzisiejsze posty',//'版块今日新帖数',
	'blockclass_forum_script_forum'			=> 'Subfora(?)',//'论坛版块',

	'blockclass_sort_sort'			=> 'Kategoria',//'分类信息',
	'blockclass_sort_field_title'		=> 'Tytuł',//'帖子名称',
	'blockclass_sort_field_url'		=> 'URL',//'帖子链接',
	'blockclass_sort_field_summary'		=> 'Streszczenie',//'帖子介绍',
	'blockclass_sort_script_sort'		=> 'dostosuj',//'高级自定义',

	'blockclass_forum_trade'		=> 'Forum produktów',//'商品模块',
	'blockclass_trade_trade'		=> 'Produkty',//'商品模块',
	'blockclass_trade_field_title'		=> 'Nazwa produktu',//'商品名称',
	'blockclass_trade_field_url'		=> 'URL',//'商品链接',
	'blockclass_trade_field_summary'	=> 'Streszczenie',//'商品说明',
	'blockclass_trade_field_pic'		=> 'Obrazek',//'商品图片地址',
	'blockclass_trade_field_totalitems'	=> 'Liczba produktów',//'商品累计售出数',
	'blockclass_trade_field_author'		=> 'Sprzedawca',//'商品卖家',
	'blockclass_trade_field_authorid'	=> 'ID sprzedawcy',//'商品卖家UID',
	'blockclass_trade_field_price'		=> 'Cena',//'商品价格',
	'blockclass_trade_script_tradenew'	=> 'Nowe produkty',//'新商品',
	'blockclass_trade_script_tradehot'	=> 'Gorące produkty',//'热门商品',
	'blockclass_trade_script_tradespecified'	=> 'Specyficzne produkty',//'指定商品',
	'blockclass_trade_script_trade'			=> 'Dostosuj',//'高级自定义',

	'blockclass_forum_activity'		=> 'Forum wydarzeń',//'活动模块',
	'blockclass_activity_activity'		=> 'Wydarzenia',//'活动模块',
	'blockclass_activity_field_url'		=> 'URL',//'活动帖URL',
	'blockclass_activity_field_title'	=> 'Tytuł',//'活动标题',
	'blockclass_activity_field_pic'		=> 'Obrazek',//'主题图片',
	'blockclass_activity_field_summary'	=> 'Streszczenie',//'活动介绍',
	'blockclass_activity_field_time'	=> 'Czas',//'活动时间',
	'blockclass_activity_field_expiration'	=> 'Wygaśnie',//'报名截止时间',
	'blockclass_activity_field_author'	=> 'Autor',//'发起人',
	'blockclass_activity_field_authorid'	=> 'ID autora',//'发起人UID',
	'blockclass_activity_field_cost'		=> 'Koszt uczestnictwa',//'每人花销',
	'blockclass_activity_field_place'		=> 'Miejsca',//'活动地点',
	'blockclass_activity_field_class'		=> 'Typ',//'活动类型',
	'blockclass_activity_field_gender'		=> 'Płeć',//'性别要求',
	'blockclass_activity_field_number'		=> 'Wymagana liczba',//'需要人数',
	'blockclass_activity_field_applynumber'		=> 'Applied number',//'已报名人数',
	'blockclass_activity_script_activitynew'	=> 'Ostatnie wydarzenia',//'最新活动',
	'blockclass_activity_script_activitycity'	=> 'Same city events',//'同城活动',
	'blockclass_activity_script_activity'		=> 'Dostosuj',//'高级自定义',

	'blockclass_portal'			=> 'Portal',//'门户类',

	'blockclass_portal_article'		=> 'Artykuły',//'文章模块',
	'blockclass_article_field_url'		=> 'URL',//'文章链接',
	'blockclass_article_field_title'	=> 'Tytuł artykułu',//'文章标题',
	'blockclass_article_field_pic'		=> 'Obrazek',//'文章封面',
	'blockclass_article_field_summary'	=> 'Streszczenie',//'文章简介',
	'blockclass_article_field_dateline'	=> 'Wysłano',//'发布时间',
	'blockclass_article_field_uid'		=> 'ID autora',//'作者UID',
	'blockclass_article_field_username'	=> 'Nazwa autora',//'作者名',
	'blockclass_article_field_avatar'	=> 'Awatar autora',//'用户头像',
	'blockclass_article_field_avatar_middle'	=> 'Średni awatar autora',//'用户头像(中)',
	'blockclass_article_field_avatar_big'		=> 'Duży awatar autora',//'用户头像(大)',
	'blockclass_article_field_caturl'		=> 'URL kategorii',//'栏目链接',
	'blockclass_article_field_catname'		=> 'Nazwa kategorii',//'栏目名称',
	'blockclass_article_field_viewnum'		=> 'Wyświetleń',//'查看数',
	'blockclass_article_field_articles'		=> 'Artykuły',//'文章数',
	'blockclass_article_field_commentnum'		=> 'Komentarze',//'评论数',
	'blockclass_article_script_articlenew'		=> 'Nowe artykuły',//'最新文章',
	'blockclass_article_script_articlehot'		=> 'Gorące artykuły',//'热门文章',
	'blockclass_article_script_articlespecified'	=> 'Specyficzne artykuły',//'指定文章',
	'blockclass_article_script_article'		=> 'Dostosuj',//'高级自定义',

	'blockclass_portal_category'			=> 'Kategoria',//'门户栏目',
	'blockclass_category_field_url'			=> 'URL',//'栏目链接',
	'blockclass_category_field_title'		=> 'Nazwa',//'栏目名称',
	'blockclass_category_field_articles'		=> 'Artykułów',//'文章数',
	'blockclass_category_script_portalcategory'	=> 'Kategoria',//'文章栏目',

	'blockclass_portal_topic'		=> 'Tematy',//'专题模块',
	'blockclass_topic_field_url'		=> 'URL',//'专题链接',
	'blockclass_topic_field_title'		=> 'Tytuł',//'专题名称',
	'blockclass_topic_field_pic'		=> 'Okładka tematu',//'专题封面',
	'blockclass_topic_field_summary'	=> 'Opis',//'专题介绍',
	'blockclass_topic_field_uid'		=> 'ID autora',//'创建者UID',
	'blockclass_topic_field_username'	=> 'Autor',//'创建者',
	'blockclass_topic_field_dateline'	=> 'Wysłano',//'创建时间',
	'blockclass_topic_field_viewnum'	=> 'Wyświetleń',//'查看数',
	'blockclass_topic_script_topicnew'	=> 'Nowe tematy',//'最新专题',
	'blockclass_topic_script_topichot'	=> 'Gorące tematy',//'热门专题',
	'blockclass_topic_script_topicspecified'	=> 'Specyficzne tematy',//'指定专题',
	'blockclass_topic_script_topic'			=> 'Dostosuj',//'高级自定义',
	'blockclass_member'				=> 'Użytkownicy',//'会员类',

	'blockclass_member_member'		=> 'Użytkownicy',//'会员模块',
	'blockclass_member_field_url'		=> 'URL',//'空间链接',
	'blockclass_member_field_title'		=> 'Użytkownik',//'用户名',
	'blockclass_member_field_avatar'	=> 'Awatar',//'用户头像',
	'blockclass_member_field_avatar_middle'	=> 'Średni awatar',//'用户头像(中)',
	'blockclass_member_field_avatar_big'	=> 'Duży awatar',//'用户头像(大)',
	'blockclass_member_field_credits'	=> 'Liczba punktów',//'积分数',
	'blockclass_member_field_reason'	=> 'Powód polecenia',//'推荐原因',
	'blockclass_member_field_unitprice'	=> 'Cena dostępu do pojedynczej jednostki',//'竟价单次访问单价',
	'blockclass_member_field_showcredit'	=> 'Łączna liczba kredytów',//'竟价总积分',
	'blockclass_member_field_shownote'	=> 'Cena za powiadomienie',//'竟价上榜宣言',
	'blockclass_member_field_extcredits1'	=> 'Dodatkowe punkty 1',//'扩展积分1',
	'blockclass_member_field_extcredits2'	=> 'Dodatkowe punkty 2',//'扩展积分2',
	'blockclass_member_field_extcredits3'	=> 'Dodatkowe punkty 3',//'扩展积分3',
	'blockclass_member_field_extcredits4'	=> 'Dodatkowe punkty 4',//'扩展积分4',
	'blockclass_member_field_extcredits5'	=> 'Dodatkowe punkty 5',//'扩展积分5',
	'blockclass_member_field_extcredits6'	=> 'Dodatkowe punkty 6',//'扩展积分6',
	'blockclass_member_field_extcredits7'	=> 'Dodatkowe punkty 7',//'扩展积分7',
	'blockclass_member_field_extcredits8'	=> 'Dodatkowe punkty 8',//'扩展积分8',
	'blockclass_member_field_gender'	=> 'Płeć',//'性别',
	'blockclass_member_field_birthday'	=> 'Urodziny',//'出生日期',
	'blockclass_member_field_constellation'	=> 'Konstelacja',//'星座',
	'blockclass_member_field_zodiac'	=> 'Znak zodiaku',//'生肖',
	'blockclass_member_field_telephone'	=> 'Telefon',//'固定电话',
	'blockclass_member_field_mobile'	=> 'Telefon komórkowy',//'手机',
	'blockclass_member_field_idcardtype'	=> 'Typ karty',//'证件号类型',
	'blockclass_member_field_idcard'	=> 'ID karty',//'证件号',
	'blockclass_member_field_address'	=> 'Addres',//'邮寄地址',
	'blockclass_member_field_zipcode'	=> 'Kod pocztowy',//'邮编',
	'blockclass_member_field_nationality'	=> 'Narodowość',//'国籍',
	'blockclass_member_field_birthcity'	=> 'Miejsce urodzenia',//'出生城市',
	'blockclass_member_field_residecity'		=> 'Kraj zamieszkania',//'居住城市',
	'blockclass_member_field_residedist'		=> 'Region zamieszkania',//'居住县',
	'blockclass_member_field_residecommunity'	=> 'Miasto zamieszkania',//'居住小区',
	'blockclass_member_field_residesuite'		=> 'Miejsce zamieszkania',//'房间',
	'blockclass_member_field_graduateschool'	=> 'Ukończenie edukacji',//'毕业学校',
	'blockclass_member_field_education'		=> 'Edukacja',//'学历',
	'blockclass_member_field_occupation'		=> 'Zawód',//'职业',
	'blockclass_member_field_company'		=> 'Firma',//'公司',
	'blockclass_member_field_position'		=> 'Pozycja',//'职位',
	'blockclass_member_field_revenue'		=> 'Wynagrodzenie',//'年收入',
	'blockclass_member_field_affectivestatus'	=> 'Status uczuciowy',//'情感状态',
	'blockclass_member_field_lookingfor'		=> 'Szukam',//'交友目的',
	'blockclass_member_field_bloodtype'		=> 'Grupa krwi',//'血型',
	'blockclass_member_field_height'		=> 'Wysokość',//'身高',
	'blockclass_member_field_weight'		=> 'Waga',//'体重',
	'blockclass_member_field_alipay'		=> 'Konto Alipay',//'支付宝帐号',
	'blockclass_member_field_icq'			=> 'ICQ',//'ICQ号',
	'blockclass_member_field_qq'			=> 'QQ',//'QQ号',
	'blockclass_member_field_yahoo'			=> 'Yahoo',//'YAHOO帐号',
	'blockclass_member_field_msn'			=> 'MSN',//'MSN帐号',
	'blockclass_member_field_taobao'		=> 'Wangwang',//'阿里旺旺帐号',
	'blockclass_member_field_site'			=> 'Strona www',//'个人主页',
	'blockclass_member_field_bio'			=> 'O mnie',//'自我介绍',
	'blockclass_member_field_interest'		=> 'Zainteresowania',//'兴趣爱好',
	'blockclass_member_field_field1'		=> 'Własne pole 1',//'自定义字段1',
	'blockclass_member_field_field2'		=> 'Własne pole 2',//'自定义字段2',
	'blockclass_member_field_field3'		=> 'Własne pole 3',//'自定义字段3',
	'blockclass_member_field_field4'		=> 'Własne pole 4',//'自定义字段4',
	'blockclass_member_field_field5'		=> 'Własne pole 5',//'自定义字段5',
	'blockclass_member_field_field6'		=> 'Własne pole 6',//'自定义字段6',
	'blockclass_member_field_field7'		=> 'Własne pole 7',//'自定义字段7',
	'blockclass_member_field_field8'		=> 'Własne pole 8',//'自定义字段8',
	'blockclass_member_field_posts'			=> 'Postów',//'发帖数',
	'blockclass_member_field_threads'		=> 'Tematów',//'主题数',
	'blockclass_member_field_digestposts'		=> 'Wykopów',//'精华帖数',
	'blockclass_member_field_regdate'		=> 'Data rejestracji',//'注册时间',
	'blockclass_member_field_hourposts'		=> 'Postów w ostatniej godzinie',//'小时发帖数',
	'blockclass_member_field_todayposts'		=> 'Dzisiejsze posty',//'今日发帖数',
	'blockclass_member_field_weekposts'		=> 'Postów w ostatnim tygodniu',//'本周发帖数',
	'blockclass_member_field_monthposts'		=> 'Postów w ostatnim miesiącu',//'本月发帖数',
	'blockclass_member_script_membernew'		=> 'Nowych użytkowników',//'新会员',
	'blockclass_member_script_memberspecial'	=> 'Użytkowników specjalny',//'特殊会员',
	'blockclass_member_script_membercredit'		=> 'Top kredytów',//'积分排行',
	'blockclass_member_script_membershow'		=> 'Top użytkowników',//'竞价排行',
	'blockclass_member_script_memberposts'		=> 'Ranga',//'发帖排行',
	'blockclass_member_script_memberspecified'	=> 'Specyficzni użytkownicy',//'指定用户',
	'blockclass_member_script_member'		=> 'Dostosuj',//'高级自定义',
	'blockclass_space'				=> 'Przestrzeń',//'空间类',

	'blockclass_space_doing'		=> 'Aktywność',//'记录模块',
	'blockclass_doing_field_url'		=> 'URL',//'记录链接',
	'blockclass_doing_field_title'		=> 'Tytuł',//'记录内容',
	'blockclass_doing_field_uid'		=> 'ID użytkownika',//'用户UID',
	'blockclass_doing_field_username'	=> 'Użytkownik',//'用户名',
	'blockclass_doing_field_avatar'		=> 'Awatar',//'用户头像',
	'blockclass_doing_field_avatar_middle'	=> 'Średni awatar',//'用户头像(中)',
	'blockclass_doing_field_avatar_big'	=> 'Duż awatar',//'用户头像(大)',
	'blockclass_doing_field_dateline'	=> 'Data publikacji',//'发布时间',
	'blockclass_doing_field_replynum'	=> 'Odpowiedzi',//'回复数',
	'blockclass_doing_script_doingnew'	=> 'Nowych akcji',//'最新记录',
	'blockclass_doing_script_doinghot'	=> 'Gorących akcji',//'热门记录',
	'blockclass_doing_script_doing'		=> 'Dostosuj',//'高级自定义',

	'blockclass_space_blog'			=> 'Blogi',//'日志模块',
	'blockclass_blog_field_url'		=> 'URL',//'日志链接',
	'blockclass_blog_field_title'		=> 'Tytuł',//'日志标题',
	'blockclass_blog_field_pic'		=> 'Obrazek',//'日志图片',
	'blockclass_blog_field_summary'		=> 'Streszczenie',//'日志简介',
	'blockclass_blog_field_dateline'	=> 'Data publikacji',//'发布时间',
	'blockclass_blog_field_uid'		=> 'ID autora',//'作者UID',
	'blockclass_blog_field_username'	=> 'Autor',//'作者名',
	'blockclass_blog_field_avatar'		=> 'Awatar użytkownika',//'用户头像',
	'blockclass_blog_field_avatar_middle'	=> 'Średni awatar',//'用户头像(中)',
	'blockclass_blog_field_avatar_big'	=> 'Duży awatar',//'用户头像(大)',
	'blockclass_blog_field_replynum'	=> 'Liczba odpowiedzi',//'评论数',
	'blockclass_blog_field_viewnum'		=> 'Wyświetleń',//'浏览数',
	'blockclass_blog_field_click1'		=> 'Pozycja pola 1',//'表态项1',
	'blockclass_blog_field_click2'		=> 'Pozycja pola 2',//'表态项2',
	'blockclass_blog_field_click3'		=> 'Pozycja pola 3',//'表态项3',
	'blockclass_blog_field_click4'		=> 'Pozycja pola 4',//'表态项4',
	'blockclass_blog_field_click5'		=> 'Pozycja pola 5',//'表态项5',
	'blockclass_blog_field_click6'		=> 'Pozycja pola 6',//'表态项6',
	'blockclass_blog_field_click7'		=> 'Pozycja pola 7',//'表态项7',
	'blockclass_blog_field_click8'		=> 'Pozycja pola 8',//'表态项8',
	'blockclass_blog_script_blognew'	=> 'Nowe blogi',//'最新日志',
	'blockclass_blog_script_bloghot'	=> 'Gorące blogi',//'热门日志',
	'blockclass_blog_script_blogspecified'	=> 'Specyficzne blogi',//'指定日志',
	'blockclass_blog_script_blog'		=> 'Dostosuj',//'高级自定义',

	'blockclass_space_album'		=> 'Albumy',//'相册模块',
	'blockclass_album_field_url'		=> 'URL',//'相册链接',
	'blockclass_album_field_title'		=> 'Tytuł',//'相册名称',
	'blockclass_album_field_pic'		=> 'Okładka albumu',//'相册封面',
	'blockclass_album_field_dateline'	=> 'Data utworzenia',//'创建日期',
	'blockclass_album_field_updatetime'	=> 'Data aktualizacji',//'更新日期',
	'blockclass_album_field_username'	=> 'Użytkownik',//'用户名',
	'blockclass_album_field_uid'		=> 'ID użytkownika',//'用户UID',
	'blockclass_album_field_picnum'		=> 'Liczba obrazków',//'照片数',
	'blockclass_album_script_albumnew'	=> 'Nowe albumy',//'最新相册',
	'blockclass_album_script_albumspecified'	=> 'Specyficzne albumy',//'指定相册',
	'blockclass_album_script_album'			=> 'Dostosuj',//'高级自定义',

	'blockclass_space_pic'			=> 'Obrazki',//'图片模块',
	'blockclass_pic_field_url'		=> 'URL',//'图片链接',
	'blockclass_pic_field_title'		=> 'Tytuł',//'图片名称',
	'blockclass_pic_field_pic'		=> 'Obrazek',//'图片地址',
	'blockclass_pic_field_summary'		=> 'Opis',//'图片说明',
	'blockclass_pic_field_dateline'		=> 'Data publikacji',//'上传时间',
	'blockclass_pic_field_username'		=> 'Użytkownik',//'用户名',
	'blockclass_pic_field_uid'		=> 'ID użytkownika',//'用户UID',
	'blockclass_pic_field_viewnum'		=> 'Wyświetleń',//'查看数',
	'blockclass_pic_field_click1'		=> 'Pozycja pola 1',//'表态项1',
	'blockclass_pic_field_click2'		=> 'Pozycja pola 2',//'表态项2',
	'blockclass_pic_field_click3'		=> 'Pozycja pola 3',//'表态项3',
	'blockclass_pic_field_click4'		=> 'Pozycja pola 4',//'表态项4',
	'blockclass_pic_field_click5'		=> 'Pozycja pola 5',//'表态项5',
	'blockclass_pic_field_click6'		=> 'Pozycja pola 6',//'表态项6',
	'blockclass_pic_field_click7'		=> 'Pozycja pola 7',//'表态项7',
	'blockclass_pic_field_click8'		=> 'Pozycja pola 8',//'表态项8',
	'blockclass_pic_script_picnew'		=> 'Nowe obrazki',//'最新图片',
	'blockclass_pic_script_pichot'		=> 'Gorące obrazki',//'热门图片',
	'blockclass_pic_script_picspecified'	=> 'Specyficzne obrazki',//'指定图片',
	'blockclass_pic_script_pic'		=> 'Dostosuj',//'高级自定义',
	'blockclass_group'			=> 'Grupy',//'群组类',

	'blockclass_group_group'		=> 'Grupy',//'群组模块',
	'blockclass_group_field_url'		=> 'URL',//'群组链接',
	'blockclass_group_field_title'		=> 'Tytuł',//'群组名称',
	'blockclass_group_field_pic'		=> 'Obrazek',//'群组图片',
	'blockclass_group_field_summary'	=> 'Streszczenie',//'群组介绍',
	'blockclass_group_field_foundername'	=> 'Założyciel',//'创始人',
	'blockclass_group_field_founderuid'	=> 'ID założyciela',//'创始人UID',
	'blockclass_group_field_icon'		=> 'Ikona',//'群组图标',
	'blockclass_group_field_threads'	=> 'Liczba tematów',//'总话题数',
	'blockclass_group_field_posts'		=> 'Liczba postów',//'总发帖数',
	'blockclass_group_field_todayposts'	=> 'Dzisiejsze posty',//'今日发帖数',
	'blockclass_group_field_membernum'	=> 'Liczba użytkowników',//'成员数',
	'blockclass_group_field_dateline'	=> 'Data publikacji',//'创建时间',
	'blockclass_group_field_level'		=> 'Poziom grupy',//'群组等级',
	'blockclass_group_field_commoncredits'	=> 'Punkty grupy',//'群组公共积分',
	'blockclass_group_field_activity'	=> 'Wydarzenia grupy',//'群组活跃度',
	'blockclass_group_script_groupnew'	=> 'Nowe grupy',//'最新群组',
	'blockclass_group_script_grouphot'	=> 'Gorące grupy',//'热门群组',
	'blockclass_group_script_groupspecified'	=> 'Specyficzne grupy',//'指定群组',
	'blockclass_group_script_group'			=> 'Dostosuj',//'高级自定义',

	'blockclass_group_thread'		=> 'Tematy grup',//'群组帖子',
	'blockclass_groupthread_field_url'	=> 'URL tematu',//'帖子链接',
	'blockclass_groupthread_field_title'	=> 'Tytuł',//'帖子标题',
	'blockclass_groupthread_field_pic'	=> 'Obrazek',//'附件图片',
	'blockclass_groupthread_field_summary'	=> 'Streszczenie',//'帖子内容',
	'blockclass_groupthread_field_icon'	=> 'Ikona',//'帖子图标',
	'blockclass_groupthread_field_author'	=> 'Autor',//'楼主',
	'blockclass_groupthread_field_authorid'	=> 'ID autora',//'楼主UID',
	'blockclass_groupthread_field_avatar'	=> 'Awatar autora',//'楼主头像',
	'blockclass_groupthread_field_avatar_middle'	=> 'Średni awatar',//'楼主头像(中)',
	'blockclass_groupthread_field_avatar_big'	=> 'Duży awatar',//'楼主头像(大)',
	'blockclass_groupthread_field_posts'		=> 'Liczba postów w temacie',//'主题帖子总数',
	'blockclass_groupthread_field_todayposts'	=> 'Dzisiejsze posty',//'主题今日帖子数',
	'blockclass_groupthread_field_lastpost'		=> 'Ostatni post',//'主题最后发帖时间',
	'blockclass_groupthread_field_dateline'		=> 'Data publikacji',//'主题发布时间',
	'blockclass_groupthread_field_replies'		=> 'Liczba odpowiedzi',//'主题回复数',
	'blockclass_groupthread_field_views'		=> 'Wyświetlenia',//'主题查看数',
	'blockclass_groupthread_field_heats'		=> 'Gorące tematy',//'主题热度',
	'blockclass_groupthread_field_recommends'	=> 'Polecane tematy',//'主题推荐数',
	'blockclass_groupthread_field_groupname'	=> 'Nazwa grupy',//'群组名称',
	'blockclass_groupthread_field_groupurl'		=> 'URL grupy',//'群组链接',
	'blockclass_groupthread_script_groupthreadnew'		=> 'Narzędzia moderatora',//'新主题',
	'blockclass_groupthread_script_groupthreadhot'		=> 'Gorące tematy',//'热门主题',
	'blockclass_groupthread_script_groupthreadspecial'	=> 'Specjalne tematy',//'特殊主题',
	'blockclass_groupthread_script_groupthreadspecified'	=> 'Specyficzne tematy',//'指定主题',
	'blockclass_groupthread_script_groupthread'		=> 'Dostosuj',//'高级自定义',

	'blockclass_group_trade'		=> 'Produkty',//'群组商品',
	'blockclass_grouptrade_field_title'	=> 'Nazwa produktu',//'商品名称',
	'blockclass_grouptrade_field_url'	=> 'URL',//'商品链接',
	'blockclass_grouptrade_field_summary'	=> 'Streszczenie',//'商品说明',
	'blockclass_grouptrade_field_pic'		=> 'Obrazek',//'商品图片地址',
	'blockclass_grouptrade_field_totalitems'	=> 'W magazynie',//'商品累计售出数',
	'blockclass_grouptrade_field_author'		=> 'Sprzedawca',//'商品卖家',
	'blockclass_grouptrade_field_authorid'		=> 'ID sprzedawcy',//'商品卖家UID',
	'blockclass_grouptrade_field_price'		=> 'Cena',//'商品价格',
	'blockclass_grouptrade_script_grouptradenew'	=> 'Nowe produkty',//'新商品',
	'blockclass_grouptrade_script_grouptradehot'	=> 'Gorące produkty',//'热门商品',
	'blockclass_grouptrade_script_grouptradespecified'	=> 'Specyficzne produkty',//'指定商品',
	'blockclass_grouptrade_script_grouptrade'		=> 'Dostosuj',//'高级自定义',

	'blockclass_group_groupactivity'		=> 'Wydarzenia grupy',//'群组活动',
	'blockclass_group_activity'			=> 'Wydarzenie',//'群组活动',
	'blockclass_groupactivity_field_url'		=> 'URL',//'活动帖URL',
	'blockclass_groupactivity_field_title'		=> 'Tytuł',//'活动标题',
	'blockclass_groupactivity_field_pic'		=> 'Obrazek',//'主题图片',
	'blockclass_groupactivity_field_summary'	=> 'Streszczenie',//'活动介绍',
	'blockclass_groupactivity_field_time'		=> 'Czas',//'活动时间',
	'blockclass_groupactivity_field_expiration'	=> 'Wygasa',//'报名截止时间',
	'blockclass_groupactivity_field_author'		=> 'Autor',//'发起人',
	'blockclass_groupactivity_field_authorid'	=> 'ID autora',//'发起人UID',
	'blockclass_groupactivity_field_cost'		=> 'Koszt udziału',//'每人花销',
	'blockclass_groupactivity_field_place'		=> 'Miejsca',//'活动地点',
	'blockclass_groupactivity_field_class'		=> 'Typ',//'活动类型',
	'blockclass_groupactivity_field_gender'		=> 'Płeć',//'性别要求',
	'blockclass_groupactivity_field_number'		=> 'Wymagana liczba uczestników',//'需要人数',
	'blockclass_groupactivity_field_applynumber'		=> 'Liczba zgłoszeń',//'已报名人数',
	'blockclass_groupactivity_script_groupactivitynew'	=> 'Ostatnie wydarzenia',//'最新活动',
	'blockclass_groupactivity_script_groupactivitycity'	=> 'Wydarzenia miastowe',//'同城活动',
	'blockclass_groupactivity_script_groupactivity'		=> 'Dostosuj',//'高级自定义',

	'blockclass_xml'			=> 'Typ third party',//'第三方类',

	'blockclass_other'			=> 'Inne',//'其它类',
	'blockclass_other_script_friendlink'	=> 'Dostosuj',//'高级自定义',
	'blockclass_other_friendlink'		=> 'Link do znajomego',//'友情链接',
	'blockclass_other_friendlink_field_url'	=> 'Adres URL',//'站点URL',
	'blockclass_other_friendlink_field_title'	=> 'Nazwa strony',//'站点名称',
	'blockclass_other_friendlink_field_pic'		=> 'Logo strony',//'站点LOGO',
	'blockclass_other_friendlink_field_summary'	=> 'Opis strony',//'站点简介',

	'blockclass_other_script_stat'		=> 'Dostosuj',//'高级自定义',
	'blockclass_other_stat'			=> 'Statystyki',//'统计模块',
	'blockclass_other_stat_posts'		=> 'Łączna liczba postów',//'发帖总数',
	'blockclass_other_stat_groups'		=> 'Łączna liczba grup',//'群组总数',
	'blockclass_other_stat_members'		=> 'Łączna liczba użytkowników',//'会员总数',
	'blockclass_other_stat_groupnewposts'	=> 'Dzisiejsze posty w grupach',//'群组今日发帖',
	'blockclass_other_stat_bbsnewposts'	=> 'Dzisiejsze posty na forum',//'论坛今日发帖数',
	'blockclass_other_stat_bbslastposts'	=> 'Wczorajsze posty na forum',//'论坛昨日发帖数',
	'blockclass_other_stat_onlinemembers'	=> 'Użytkownicy online',//'当前在线会员数',
	'blockclass_other_stat_maxmembers'	=> 'Rekord użytkowników online',//'历史最高在线会员数',
	'blockclass_other_stat_doings'		=> 'Łącznie akcji',//'动态数',
	'blockclass_other_stat_blogs'		=> 'Łącznie blogów',//'日志数',
	'blockclass_other_stat_albums'		=> 'Łącznie albumów',//'相册数',
	'blockclass_other_stat_pics'		=> 'Łącznie obrazków',//'图片数',
	'blockclass_other_stat_shares'		=> 'Łącznie udostępnień',//'分享数',

	'blockclass_other_stat_posts_title'	=> 'Tytuł postów',//'帖子显示名',
	'blockclass_other_stat_groups_title'	=> 'Tytuł grup',//'群组显示名',
	'blockclass_other_stat_members_title'	=> 'Tytuł użytkowników',//'会员显示名',
	'blockclass_other_stat_groupnewposts_title'	=> 'Tytuł nowych postów w grupie',//'今日发帖显示名',
	'blockclass_other_stat_bbsnewposts_title'	=> 'Tytuł dzisiejszych postów na forum',//'今日发帖显示名',
	'blockclass_other_stat_bbslastposts_title'	=> 'Tytuł wczorajszych postów na forum',//'昨日发帖显示名',
	'blockclass_other_stat_onlinemembers_title'	=> 'Tytuł użytkowników online',//'当前在线会员显示名',
	'blockclass_other_stat_maxmembers_title'	=> 'Tytuł rekordu online',//'历史最高在线显示名',
	'blockclass_other_stat_doings_title'	=> 'Tytuł akcji',//'动态显示名',
	'blockclass_other_stat_blogs_title'	=> 'Tytuł blogów',//'日志显示名',
	'blockclass_other_stat_albums_title'	=> 'Tytuł albumów',//'相册显示名',
	'blockclass_other_stat_pics_title'	=> 'Tytuł obrazków',//'图片显示名',
	'blockclass_other_stat_shares_title'	=> 'Tytuł udostępnień',//'分享显示名',

	'blockclass_field_id'			=> 'ID pola',//'数据ID',
);


