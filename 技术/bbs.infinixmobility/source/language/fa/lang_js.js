/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	Javascript Language variables

	$Id: lang_js.js by Valery Votintsev, codersclub.org

	Translated to Persian by Discuz.ir
*/

//--------------------------------
//static/js/register.js

// Suggested email domains for registering:
var emaildomains = [
		'aol.com',
		'gmail.com',
		'hotmail.com',
		'msn.com',
		'qq.com',
		'yahoo.com'
		];

//--------------------------------
//static/js/common.js

var colortexts = {
	'Black'			: 'سیاه',//'黑色',
	'Sienna'		: 'قهوه ای',//'赭色',
	'DarkOliveGreen'	: 'سبز تیره زیتونی',//'暗橄榄绿色',
	'DarkGreen'		: 'سبز تیره',//'暗绿色',
	'DarkSlateBlue'		: 'آبی خاکستری تیره',//'暗灰蓝色',
	'Navy'			: 'آبی کم رنگ',//'海军色',
	'Indigo'		: 'نیلی',//'靛青色',
	'DarkSlateGray'		: 'سبز تیره',//'墨绿色',
	'DarkRed'		: 'قرمز تیره',//'暗红色',
	'DarkOrange'		: 'نارنجی تیره',//'暗桔黄色',
	'Olive'			: 'زیتونی',//'橄榄色',
	'Green'			: 'سبز',//'绿色',
	'Teal'			: 'فیروزه ای',//'水鸭色',
	'Blue'			: 'آبی',//'蓝色',
	'SlateGray'		: 'آهکی',//'灰石色',
	'DimGray'		: 'خاکستری تیره',//'暗灰色',
	'Red'			: 'قرمز',//'红色',
	'SandyBrown'		: 'قهوه ای شنی',//'沙褐色',
	'YellowGreen'		: 'زرد سبز',//'黄绿色',
	'SeaGreen'		: 'سبز دریایی',//'海绿色',
	'MediumTurquoise'	: 'سبز زمردی',//'间绿宝石',
	'RoyalBlue'		: 'آبی ارغوانی',//'皇家蓝',
	'Purple'		: 'ارغوانی',//'紫色',
	'Gray'			: 'خاکستری',//'灰色',
	'Magenta'		: 'قرمز ارغوانی',//'红紫色',
	'Orange'		: 'نارنجی',//'橙色',
	'Yellow'		: 'زرد',//'黄色',
	'Lime'			: 'نارنجی اسیدی',//'酸橙色',
	'Cyan'			: 'فیروزه ای',//'青色',
	'DeepSkyBlue'		: 'آبی آسمانی',//'深天蓝色',
	'DarkOrchid'		: 'اغوانی تیره',//'暗紫色',
	'Silver'		: 'نقره ای',//'银色',
	'Pink'			: 'صورتی',//'粉色',
	'Wheat'			: 'زرد روشن',//'浅黄色',
	'LemonChiffon'		: 'لیمو ابریشمی',//'柠檬绸色',
	'PaleGreen'		: 'سبز کم رنگ',//'苍绿色',
	'PaleTurquoise'		: 'سبز پررنگ',//'苍宝石绿',
	'LightBlue'		: 'آبی روشن',//'亮蓝色',
	'Plum'			: 'آلویی',//'洋李色',
	'White'			: 'سفید' //'白色'
};

/*
',',	//'，',
'.',	//'。',
':',	//'点',
'!',	//'！'
'&laquo;',//'《',
'&raquo;',//'》',
*/


//--------------------------------

var lng = {

//---------------------------
//static/image/editor/editor_base.js
// USED in /source/module/home/home_editor.php
// MOVE TO:
//static/js/editor_base.js
	'restore_last_saved'	: 'آیا شما مطمئن هستید که میخواهید آخرین عمل ذخیره شده را بازگردانی کنید؟',//'您确定要恢复上次保存?',
	'cut_manually'		: 'تنظیمات امنیتی مرورگر شما از ویرایشگر به طور خودکار عملیات برش را انجام نمی دهداز کلید مینابر (کنترل  x) برای تکمیل این عملیات استفاده کنید',//'您的浏览器安全设置不允许编辑器自动执行剪切操作,请使用键盘快捷键(Ctrl+X)来完成',
	'copy_manually'		: 'تنظیمات امنیتی مرورگر شما از ویرایشگر به طور خودکار عملیات کپی را انجام نمی دهد. برای تکمیل این عملیات از کلید های میانبر (کنترل c )استفاده کنید',//'您的浏览器安全设置不允许编辑器自动执行拷贝操作,请使用键盘快捷键(Ctrl+C)来完成',
	'paste_manually'	: 'تنظیمات امنیتی مرورگر شما از ویرایشگر به طور خودکار عمل چسباندن را  انجام نمیدهد نمی دهد. با استفاده از میانبر های صفحه کلید (کنترل V)این کار را انجام دهید.',//'您的浏览器安全设置不允许编辑器自动执行粘贴操作,请使用键盘快捷键(Ctrl+V)来完成',
	'graffiti_no_init'	: 'نمیتواند مقدار داده اولیه گرافیتی را پیدا کند',//'找不到涂鸦板初始化数据',
	'ie5_only'		: 'فقط در IE 5.01 یا بالاتر پشتیبانی میکند',//'只支持IE 5.01以上版本',
	'edit_raw'		: 'ویرایش خام متن',//'编辑源码',
	'plain_text_warn'	: 'زمانی که تبدیل به متن ساده شود قالب اولیه خود را از دست میدهد.! \ n آیا مطمئن هستید که می خواهید ادامه دهید؟',//'转换为纯文本时将会遗失某些格式。\n您确定要继续吗？',
	'browser_update'	: 'مرورگر شما از این ویژگی پشتیبانی نمی کند، لطفا نسخه مرورگر خود را بروزرسانی کنید',//'你的浏览器不支持此功能，请升级浏览器版本',
	'tips'			: 'راهنمایی',//'小提示',

//---------------------------
//static/image/editor/editor_function.js
// USED in: /source/admincp/admincp_feed.php
// USED in: /template/default/home/cpacecp_blog.htm
// USED in: /template/default/portal/portalcp_article.htm
// MOVED TO:
//static/js/editor_function.js
	'wysiwyg_only'		: 'این عملیات تنها برای حالت WYSIWYG موثر است',//'本操作只在多媒体编辑模式下才有效',

//---------------------------
//static/image/admincp/cloud/cloud.js
	'int_cloud_test'	: 'تست های دیگر رابط کاربری پلت فرم ابر',//'云平台其他接口测试',
	'int_roaming_test'	: 'تست های دیگر رابط رومینگe',//'漫游其他接口测试',
	'int_qq_test'		: 'تست رابط QQ  اینترنت',//'QQ互联接口测试',
	'server_busy'		: 'این سرویس مشغول است.لطفا بعد تلاش کنید',//'服务器繁忙，请稍后再试',
	'tested_ok'		: 'تست با موفقیت ، زمان استفاده: ',//'测试成功，耗时 ',
	'seconds'		: ' ثانیه.',//' 秒',

//---------------------------
//static/image/admincp/cloud/qqgroup.js
	'select_topic_to_push'	: 'برای انتقال مقالات باید حداقل یک موضوع را انتخاب کنید',//'请至少推送一条头条主题和一条列表主题',
	'select_item_to_push'	: 'برای انتقال مقالات باید حداقال یک مورد را انتخاب کنید',//'请至少推送一条信息到列表区域',
	'loading'		: 'بارگذاری ...',//'加载中...',
	'push5reached'		: 'Push Post number has reached five, in the right to cancel a number and try again.',//'推送帖子已达到5条，请在右侧取消一些再重试。',
	'click_left'		: 'در سمت چپ کلیک کنید',//'点击左侧',
	'push_to_list'		: 'Will push the information to the list',//'将信息推送到列表',
	'wait_image_upload'	: 'آپلود تصویر، لطفا صبر کنید ...',//'图片上传中，请稍后...',





//---------------------------
//upload/static/js/autoloadpage.js
	'loading_content_wait'	: 'در حال بارگذاری محتوا، لطفا صبر کنید ...',//'正在加载, 请稍后...',

//---------------------------
//upload/static/js/at.js
//	'enter_username'	: 'Please enter the user name',//'请输用户名',

//--------------------------------
//static/js/calendar.js
//static/js/forum_calendar.js
//static/js/home_calendar.js

	'prev_month'	: 'ماه قبل',//'上一月',
	'next_month'	: 'ماه بعد',//'下一月',
	'select_year'	: 'انتخاب سال',//'点击选择年份',
	'select_month'	: 'انتخاب ماه',//'点击选择月份',
	'wday0'		: 'یک شنبه',//'日',
	'wday1'		: 'دوشنبه',//'一',
	'wday2'		: 'سه شنبه',//'二',
	'wday3'		: 'چهار شنبه',//'三',
	'wday4'		: 'پنج شنبه',//'四',
	'wday5'		: 'جمعه',//'五',
	'wday6'		: 'شنبه',//'六',
	'month'		: 'ماه',//'月',
	'today'		: 'امروز',//'今天',
	'hours'		: 'ساعت',//'点',
	'minutes'	: 'دقیه',//'分',
	'halfhour'	: 'نیم ساعت',//'半小时',
	'ok'		: 'ثبت',//'OK',

//--------------------------------
//static/js/common.js

	'open_new_win'		: 'باز کردن در پنجره جدید',//'在新窗口打开',
	'actual_size'		: 'اندازه واقعی',//'实际大小',
	'close'			: 'بستن',//'关闭',
	'wheel_zoom'		: 'استفاده از اسکرول ماوس برای زوم / تصویر',//'鼠标滚轮缩放图片',
	'reminder'		: 'تذکر',//'提示信息',
	'submit'		: 'ثبت',//'确定',
	'cancel'		: 'لغو',//'取消',
	'wait_please'		: 'در حال بارگذاری ...',//'请稍候...',
	'int_error'		: 'خطا داخلی، نمی توانید این محتوا را نمایش دهد',//'内部错误，无法显示此内容',
	'flash_required'	: 'این مطالب نیاز به ادوبی فلش پلیر 9.0.124 دارد یا بالاتر',//'此内容需要 Adobe Flash Player 9.0.124 或更高版本',
	'flash_download'	: 'دانلود فلش پلیر',//'下载 Flash Player',
	'day1'			: '1 روز',//'一天',
	'week1'			: '1 هفته',//'一周',
	'days7'			: '7 روز',//'7 天',
	'days14'		: '14 روز',//'14 天',
	'month1'		: '1 ماه',//'一个月',
	'month3'		: '3 ماه',//'三个月',
	'month6'		: '6 ماه',//'半年',
	'year1'			: '1 سال',//'一年',
	'custom'		: 'انتخابی',//'自定义',
	'permanent'		: 'ثابت',//'永久',
	'show_all_expr'		: 'نمایش تمام شکلک ها',//'显示所有表情',
	'page_prev'		: 'صفحه قبلی',//'上页',
	'page_next'		: 'صفحه بعدی',//'下页',
	'copy2clipboard'	: 'کپی در کلیپ بورد',//'点此复制到剪贴板',
// ATTENTION!
// The next line must have the same value as in /template.php - 'enter_content' !!!
	'enter_search_string'	: 'عبارت جستجو را وارد کنید',//'请输入搜索内容',
	'refresh_q&a'		: 'بارگزاری مجدد Q & A',//'刷新验证问答',
	'refresh_code'		: 'بارگزاری  کد',//'刷新验证码',
	'code_invalid'		: 'کد امنیتی اشتباه است، لطفا دوباره سعی کنید',//'验证码错误，请重新填写',
	'q&a_invalid'		: 'پاسخ اشتباه است، لطفا دوباره سعی کنید',//'验证问答错误，请重新填写',
	'code_clipboard'	: 'کد در کلیپ بورد کپی شد',//'代码已复制到剪贴板',
	'enter_link_url'	: 'URL پیوند را وارد کنید',//'请输入链接地址',
	'enter_link_text'	: 'متن لینک را وارد کنید',//'请输入链接文字',
	'enter_image_url'	: 'URL تصویر را وارد کنید',//'请输入图片地址',
	'width_optional'	: 'عرض (اختیاری)',//'宽(可选)',
	'height_optional'	: 'ارتفاع (اختیاری)',//'高(可选)',
	'narrow_screen'		: 'صفحه نمایش باریک',//'切换到窄版',
	'wide_screen'		: 'صفحه نمایش گسترده',//'切换到宽版',
	'logging_wait'		: 'ورود به سیستم، لطفا صبر کنید ...',//'登录中，请稍后...',
	'notices_no'		: '[　　　]',//'【　　　】',
	'notices_yes'		: '[جدید]',//'【新提醒】',
	'sec_after_win_closed'	: ' چند ثانیه قبل از بسته شدن پنجره',//' 秒后窗口关闭',
	'sec_after_page_jump'	: ' ثانیه قبل از تغییر مسیر صفحه',//' 秒后页面跳转',
	'jump_now'		: 'پرش',//'立即跳转',
	'error_message'		: 'پیام خطا',//'错误信息',
	'ctrl_d_favorites'	: 'کلیدهای Ctrl + D  برای اضافه کردن به علاقه مندی ها',//'请按 Ctrl+D 键添加到收藏夹',
	'non_ie_manually'	: 'برای مرورگر های غیر IE باید به صورت دستی تنظمیم کنید',//'非 IE 浏览器请手动将本站设为首页',
	'blind_enable'		: 'فعال کردن experience',//'开启盲人体验',//tc:'開啟后窗盲人體驗',
	'blind_disable'		: 'غیر فعال کردن experience',//'关闭盲人体验',//tc:'關閉盲人體驗',

//--------------------------------
//static/js/common_diy.js

	'edit'			: 'ویرایش',//'编辑',
	'warn_not_saved'	: 'شما اطلاعات را اصلاح کردید.اگر خارج شوید. تمام اطلاعات از دست خواهد رفت',//'您的数据已经修改,退出将无法保存您的修改。',
	'confirm_exit'		: 'تمام تغییرات از دست داده خواهد شد.آیا مطمئن هستید که میخواهید خارج شوید؟',//'退出将不会保存您刚才的设置。是否确认退出？',
	'select_image_upload'	: 'انتخاب یک تصویر برای آپلود',//'请选择您要上传的图片',

//--------------------------------
//static/js/common_extra.js

	'copy_failed'		: 'کپی ناموفق بود، لطفا انتخاب کنید "اجازه دسترسی"',//'复制失败，请选择“允许访问”',
	'prev'			: 'قبلی.',//'上一张',
	'next'			: 'بعدی',//'下一张',
        'shortcut_add'		: 'Adding a desktop shortcut',//'添加桌面快捷',
        'shortcut_1'		: '1. Click "',//'1、点击"',
        'shortcut_1_1'		: 'Download desktop shortcut',//'下载桌面快捷',
        'shortcut_1_2'		: '", and after the download is completed, you can move the file to your desktop',//'"，下载完成后，可移动文件到系统桌面',
        'shortcut_2'		: '2. Click "',//'2、点击"',
        'shortcut_2_1'		: 'Download icon file',//'下载ICO图标',
        'shortcut_2_2'		: '", and after the download is completed, right-click on the desktop shortcut file -&gt; Properties -&gt; Change Icon, and select the downloaded ICO icon',//'"，下载完成后，右击桌面快捷文件->属性->更改图标，选择已下载的ICO图标即可',

//--------------------------------
//static/js/editor.js

	'restore_size_edit'	: 'حالت اولیه ادیتور',//'恢复编辑器大小',
	'full_screen_edit'	: 'تمام صفحه ویرایشگر',//'全屏方式编辑',
	'current_length'	: 'طول کنونی',//'当前长度',
	'bytes'			: 'بایت',//'字节',
	'system_limit'		: 'حد سیستم',//'系统限制',
	'up_to'			: '~',//'到',
	'check_length'		: 'تعداد طول',//'字数检查',
	'data_restored'		: 'داده ها ترمیم شد',//'数据已恢复',
	'data_saved'		: 'داده ها ذخیره شد',//'数据已保存',
	'clear_all_sure'	: 'آیا مطمئن هستید که میخواهید تمام محتوا را حذف کنید؟',//'您确认要清除所有内容吗？',
	'hide_content'		: 'مخفی کردن محتوا',//'请输入要隐藏的信息内容',
	'free_content'		: 'اگر شما برای پست قیمتی تعیین نکنید.پست به طور رایگان نمایش داده خواهد شد ',//'如果您设置了帖子售价，请输入购买前免费可见的信息内容',
	'when_thread_replied'	: 'نمایش فقط زمانی که کاربر به این موضوع پاسخ دهد',//'只有当浏览者回复本帖时才显示',
	'when_points_more'	: 'نمایش فقط زمانی که امتیاز کاربر بیشتر باشد',//'只有当浏览者积分高于',
	'when_show'		: 'زمانی که نمایش داده شود',//'时才显示',
	'table_rows'		: 'ردیف جدول',//'表格行数',
	'table_columns'		: 'ستون های جدول',//'表格列数',
	'table_width'		: 'عرض جدول: ',//'表格宽度: ',
	'bg_color'		: 'رنگ پس زمینه',//'背景颜色',
	'table_intro0'		: 'راهنمایی نوشتن سریع جدول ',//'快速书写表格提示',
	'table_intro1'		: '&quot;[tr=color]&quot; Define the row background color<br />&quot;[td=Width]&quot; Define the column width<br />&quot;[td=Column_Span,Row_Span,Width]&quot; Define the Row/Column Span and Width<br /><br />Fast writing table example: ',//'“[tr=颜色]” 定义行背景<br />“[td=宽度]” 定义列宽<br />“[td=列跨度,行跨度,宽度]” 定义行列跨度<br /><br />快速书写表格范例：',
	'table_intro2'		: '[table]<br />نام:|دیسکاز!<br />ورژن:|X1.5<br />[/table]',//'[table]<br />Name:|Discuz!<br />Version:|X1<br />[/table]',
	'table_intro3'		: 'Use &quot;|&quot; to separate rows, if there is the &quot;|&quot; character in the data, replace it with &quot;\\|&quot;, separate rows with &quot;\\n&quot;.',//'用“|”分隔每一列，表格中如有“|”用“\\|”代替，换行用“\\n”代替。',
	'audio_url'		: 'ورودی URL فایل های موزیک',//'请输入音乐文件地址',
	'video_url'		: 'ورودی URL فایل های ویدیو',//'请输入视频地址',
	'auto_play'		: 'پخش خودکار؟',//'是否自动播放',
	'flash_url'		: 'لطفا ورودی URL  فایل فلش را وارد کنید ',//'请输入 Flash 文件地址',
	'enter_please'		: 'لطفا وارد کنید',//'请输入第',
	'nth_parameter'		: '-پارامتر',//' 个参数',
	'font'			: 'فونت',//'字体',
	'full_screen'		: 'تمام صفحه',//'全屏',
	'restore_size'		: 'بازگرداندن اندازه',//'恢复',
	'general'		: 'حالت عمومی',//'常用',
	'simple'		: 'حالت پیشرفته',//'高级',
	'bad_browser'		: 'مرورگر شما از این ویژگی پشتیبانی نمی کند',//'你的浏览器不支持此功能',
	'click_autosave_enable'	: 'برای فعال کردن ذخیره خودکار اینجا کلیک کنید',//'点击开启自动保存',
	'autosave_enable'	: 'فعال کردن ذخیره خودکار',//'开启自动保存',
	'autosave_disable'	: 'غیر فعال کردن ذخیره خودکار',//'点击关闭自动保存',
	'autosave_enabled'	: 'اطلاعات ذخیره خودکار فعال است',//'数据自动保存已开启',
	'autosave_disabled'	: 'اطلاعات ذخیره خودکار غیر فعال است',//'数据自动保存已关闭',
	'data_saved_at'		: 'اطلاعات ذخیره شده در',//'数据已于',
	'saved_time'		: '',//NOT REQUIRED IN ENGLISH!//'保存',
	'sec_before_saving'	: 's قبل از ذخیره خودکار',//'秒后保存',
	'insert_quote'		: 'قرار دادن نقل قول',//'请输入要插入的引用',
	'insert_code'		: 'وارد کردن کد',//'请输入要插入的代码',
	'enter_item_list'	: 'Enter the item list.\r\nLeave blank, or click Cancel.',//'输入一个列表项目.\r\n留空或者点击取消完成此列表.',
	'width'			: 'عرض',//'宽',
	'height'		: 'ارتفاع',//'高',
	'audio_support'		: 'پشتیبانی از wma, mp3, ra, rm, و فرمت های دیگر<br />مثال: http://server/audio.wma',//'支持 wma mp3 ra rm 等音乐格式<br />示例: http://server/audio.wma',
	'video_support'		: 'Supported for Youku, Potatoes, 56, 6, Cool video and other video services<br />Supported video formats: wmv avi rmvb mov swf flv.<br /> Example: http://server/movie.wmv',//'支持优酷、土豆、56、酷6等视频站的视频网址<br />支持 wmv avi rmvb mov swf flv 等视频格式<br />示例: http://server/movie.wmv',
	'flash_support'		: 'پشتیبانی فایل های فلش: swf flv <br /> مثال: http://server/flash.swf',//'支持 swf flv 等 Flash 网址<br />示例: http://server/flash.swf',
	'paste_from_word'	: 'بچسبانید یک محتوا از Word',//'从 Word 粘贴内容',
	'paste_word_tip'	: 'طفا برای چسباندن مطالب از word از میانبر (Ctrl + V) استفاده کنید',//'请通过快捷键(Ctrl+V)把 Word 文件中的内容粘贴到上',
	'show_tips'		: 'نمایش نکات',//'友情提示',
	'expire_days'		: 'معتبر برای (روز)',//'有效天数',
	'expire_days_invalid'	: 'Distance from the posting date is greater than the number of days when the label automatically expire',//'距离发帖日期大于这个天数时标签自动失效',
	'download_remote'	: 'دانلود فایل پیوست از راه دور، لطفا صبر کنید ...',//'正在下载远程附件，请稍等……',
	'create_post_directory'	: 'ایجاد پست در دایرکتوری',//'创建效天帖子目录',
	'page_number'		: 'تعداد صفحه',//'页码',
	'jump_to_page'		: 'پرش به صفحه ویژه',//'跳转到指定的页',
	'jump_to_page_comment'	: 'استفاده [صفحه] برچسب برای اضافه کردن به یک صفحه',//'用 [page] 对当前帖子分页后的页码',
	'jump_to_post'		: 'پرش به پست ویژه',//'跳转到指定的帖子',
	'jump_tip_pid'		: 'ارسال TID و PID',//'帖子的 TID 和 PID',
	'add_indent'		: 'اضافه کردن خط اول تورفتگی',//'添加行首缩进',
	'enter_post_password'	: 'لطفا رمز پست را وارد کنید',//'请输入帖子密码',
	'begin_flash_img'	: 'ابتدا URL فلش و یا تصویر انیمیشن  را وارد کنید',//'请输入开头动画 Flash 或 图片 地址',
	'begin_click_url'	: 'در URL لینک کلیک کنید',//'点击链接地址',
	'begin_stay_seconds'	: 'نمایش ثانیه',//'停留秒数',
	'begin_disappearance'	: ' پس از بارگذاری افکت ها ناپدید می شوند',//'载入、消失的效果',
	'none'			: 'هیچ ',//'无',
	'begin_fade'		: 'محو شدن',//'淡入淡出',
	'begin_explosive'	: 'انفجار',//'展开闭合',
	'begin_info'		: 'پشتیبانی فرمت های: swf flv jpg gif png<br/>محدوده عرض: 400~1024, محدوده ارتفاع: 300~640<br/>مثال: http://server/flash.swf',//'支持 swf flv jpg gif png 网址<br />宽高范围: 宽400~1024 高300~640<br />示例: http://server/flash.swf',

//--------------------------------
//static/js/forum.js

	'del_thread_sure'	: 'آیا شما مطمئن هستید به حذف این موضوع از موضوعات تازه ؟',//'您确认要把此主题从热点主题中移除么？',
	'there_are'		: 'وجود دارد',//'有',
	'new_reply_exists'	: 'پاسخ به موضوع های جدیدی وجود دارد . برای مشاهده کلیک کنید',//'有新回复的主题，点击查看',
//--------------------------------
//static/js/forum_google.js

	'search_net'	: 'جستجو در اینترنت',//'网页搜索',
	'search_site'	: 'جستجو در سایت',//'站内搜索',
	'search'	: 'جستجو',//'搜索',

//--------------------------------
//static/js/forum_moderate.js

	'choose_tread'	: 'انتخاب موضوع تا متوسط',//'请选择需要操作的帖子',

//--------------------------------
//static/js/forum_post.js

	'internal_error'	: 'خطا در سرور داخلی',//'内部服务器错误',
	'upload_ok'		: 'آپلود با موفقیت',//'上传成功',
	'ext_not_supported'	: 'این پسوند فایل پشتیبانی نمی شود',//'不支持此类扩展名',
	'sorry_ext_not_supported'	: 'با عرض پوزش، از جمله پسوند هایی که پشتیبانی نمی شود.',//'对不起，不支持上传此类扩展名的附件。',
	'illegal_image_type'	: 'نوع تصویر غیر قانونی',//'图片附件不合法',
	'can_not_save_attach'	: 'نمیتواند پیوست را ذخیره کند',//'附件文件无法保存',
	'invalid_file'		: ' فایل با خطا آپلود شد',//'没有合法的文件被上传',
	'illegal_operation'	: 'عملیات همراه با خطا',//'非法操作',
	'enter_content'		: 'عنوان یا محتوا وارد کنید',//'请完成标题或内容栏',
	'select_category'	: 'انتخاب بخش مربوطه برای موضوع',//'请选择主题对应的分类',
	'select_category_info'	: 'انتخاب بخش مربوطه برای اطلاعات موضوع',//'请选择主题对应的分类信息',
	'title_long'		: 'طول عنوان بیش از حد از 255 حرف است.',//'您的标题超过 80 个字符的限制',
	'content_long'		: 'The content length does not meet the requirements.\n\n',//'您的帖子长度不符合要求。\n\n',
	'ignore_pending_attach'	: 'تعدادی پیوست ناموفق وجود دارد.آیا شما آن ها را نادیده میگیرید؟',//'您有等待上传的附件，确认不上传这些附件吗？',
	'still_uploading'	: 'تعدادی از پیوست ها هنوز در حال آپلودند.لطفا ثبت کنید.موضوع پس از آپلود شدن پیوست ها به طور خودکار انتشار داده خواهد شد.',//'您有正在上传的附件，请稍候，上传完成后帖子将会自动发表...',
	'no_data_recover'	: 'بدون اطلاعات میتواند بازیافت شود!',//'没有可以恢复的数据！',
	'content_overwrite'	: 'Warning:\nCurrent content will be overwritten with the saved data!\nAre you sure to restore the data?',//'此操作将覆盖当前帖子内容，确定要恢复数据吗？',
	'upload_finished'	: 'آپلود تمام شد!',//'附件上传完成！',
	'successfull'		: 'موفقیت آمیز:',//'成功',
	'failed'		: 'ناموفق:',//'失败',
	'ones'			: ' آیتم ها',//'个',
	'uploading'		: 'در حال آپلود',//'上传中...',
	'select_image_files'	: 'انتخاب فایل های تصویری',//'请选择图片文件',
	'delete'		: 'حذف کردن',//'删除',
	'contains'		: 'ادامه دادن ',//'包含',
	'img_attached_num'	: 'تصاویر پیوست شده',//'个图片附件',
	'files attached_num'	: 'فایل های پیوست شده',//'个附件',
	'images'		: 'تصاویر',//'图片',
	'attachments'		: 'پیوست ها',//'附件',
//	'upload_failed'		: 'آپلود ناموفق',//'上传失败',

	'attach_big'		: 'اندازه فایل پیوست بیش از حد مجاز',//'服务器限制择图无法上传择图那么大的附件',
	'attach_group_big'	: 'مجموع سایز پیوست گروه کاربری شما بیش از حد مجاز است',//'用户组限制无法上传那么大传更的附件',
	'attach_type_big'	: 'This file type total attachment size exceeds allowed limit',//'文件类型限制无法上传那么大的附件',
	'attach_daily_big'	: 'مجموع پیوست روزانه بیش از حد مجاز',//'本日已无法上传更多的附件',
	'validating_q&a'	: 'اعتبار سنجی Q & A، لطفا صبر کنید',//'验证问答校验中，请稍后',
	'validating_code'	: 'قبول کردن کد، لطفا صبر کنید',//'验证码校验中，请稍后',
	'attach_type_disabled'	: 'این نوع فایل غیر فعال است',//'附件类型被禁止',
	'attach_max'		: 'نه بزرگتر از',//'不能超过',
	'vote_max_reached'	: 'رسیدن به حداکثر تعداد رای: ',//'已达到最大投票数',
	'no_remote_attach'	: 'Sبا عرض پوزش، بدون پیوست از راه دور',//'抱歉，暂无远程附件',
	'delete_post_sure'	: 'مطمئن هستید که میخواهید این پست را حذف کنید؟',//'确定要删除该帖子吗？',
	'feed_add_confirm'	: 'Because of you have set read permission or sell the post, do you confirm also the broadcast to your listeners to see?',//'由于您设置了阅读权限或出售帖，您确认还转播给您的听众看吗？',
//--------------------------------
//static/js/forum_viewthread.js

	'best_answer_sure'	: 'Are you sure you want to define this post as the "Best Answer"?',//'您确认要把该回复选为“最佳答案”吗？',
	'premoderated'		: 'Replies to this category must be audited. Your post wll be displayed after the verification',//'本版回帖需要审核，您的帖子将在通过审核后显示',
	'credit_confirm1'	: 'دانلود هزینه ',//'下载需要消耗',
	'credit_confirm2'	: ' points, are you sure to download?',//'，您是否要下载？',
	'thread_to_clipboard'	: 'آدرس موضوع در کلیپ بورد کپی شده است',//'帖子地址已经复制到剪贴板',
	'click_to_enlarge'	: 'برای بزرگنمایی کلیک کنید',//'点击放大',
	'notify_on_reply'	: 'دریافت پاسخ اطلاع رسانی',//'接收回复通知',
	'notify_on_reply_cancel'	: 'انصراف از پاسخ اطلاع رسانی',//'取消回复通知',
	'share_connection_failed'	: 'اتصال برای به اشتراک گذاشتن ناموفق، لطفا دوباره سعی کنید',//'分享服务连接失败，请稍后再试',
	'qq_bind'		: 'Please bind your QQ account',//'请先绑定QQ账号',
	'quote_by'		: 'نقل قول توسط .*? در  .*? کد',//'本帖最后由 .*? 于 .*? 编辑',
	'copy_code'		: 'کپی کردن کد',//'复制代码',
	'download_pocket_forum'	: 'دانلود پاکت انجمن',//'下载掌上论坛',
	'pocket_forum_android'	: 'اگر نسخه آندروید بود، اسکن QR کد را می توان به طور مستقیم به گوشی دانلود کند',//'Andriod版本，扫描二维码可以直接下载到手机',
	'pocket_forum_android_alt'	: 'مناسب برای گوشی های هوشمند مبتنی بر آندروید مانند سامسونگ / HTC / و غیره',//'适用于装有安卓系统的三星/HTC/小米等手机',
	'pocket_forum_ios'	: 'اگر آی فون استفاده می شود، اسکن thw QR کد را می توان به طور مستقیم به گوشی دانلود کند',//'iPhone版本，扫描二维码可以直接下载到手机',
	'pocket_forum_ios_alt'	: 'مناسب برای تلفن همراه اپل',//'适用于苹果手机',
	'quick_reply_here'	: '#پاسخ سریع در اینجا#', //'#在这里快速回复#',
	
//--------------------------------
//static/js/handlers.js
	'file_selected_exceed'	: 'شما فایل های زیادی را انتخاب کردید.',//'您选择的文件个数超过限制。',
	'upload_number_exceed'	: 'شما نمی توانید هر فایل  بیشتری را اضافه کنید.',//'您已达到上传文件的上限了。',
	'can_choose_more'	: 'شما هنوز می توانید انتخاب کنید ',//'您还可以选择 ',
	'files'			: ' فایل ها',//' 个文件',
	'file_is_large'		: 'فایل بسیار بزرگ است.',//'文件太大.',
	'file_is_empty'		: 'شما نمی توانید یک فایل صفر بایتی آپلود کنید.',//'不能上传零字节文件.',
	'file_type_disabled'	: 'آپلود این نوع فایل غیر فعال شده است',//'禁止上传该类型的文件.',
	'unhandled_error'	: 'Unhandled Error',//'',
	'upload_progress'	: 'آپلود شده ',//'正在上传',
	'upload_cancelled'	: 'لغو شده',//'取消上传',
	'file_description'	: 'توضیحات فایل',//'图片描述',
	'image_upload_failed'	: 'آپلود تصویر ناموفق',//'图片上传失败',
	'upload_failed'		: 'آپلود ناموفق',//'上传失败',
	'upload_completed'	: 'آپلود کامل شد.',//'上传完成.',
	'upload_error'		: 'خطای آپلود: ',//'',
	'config_error'		: 'خطا در پیکربندی',//'',
	'server_error'		: ' خطا سرور  (IO)',//'',
	'security_error'	: 'خطای امنیتی',//'',
	'upload_limit_exceed'	: 'Upload limit exceeded.',//'',
	'file_not_found'	: 'فایل یافت نشد.',//'',
	'validation_failed'	: 'اعتبار سنجی ناموفق. فایل حذف می شوند.',//'',
	'upload_stopped'	: 'متوقف شد',//'',

//--------------------------------
//static/js/home.js
	'day'			: 'روز',//'日',
	'category_empty'	: 'نام گروه نمی تواند خالی باشد!',//'分类名不能为空！',

//--------------------------------
//static/js/home_ajax.js

//	'close'			: 'Close',//'关闭',
//	'wait_please'		: 'Loading ...',//'请稍候...',

//--------------------------------
//static/js/home_blog.js

	'title_length_invalid'	: 'طول عنوان (باید 1 ~ 80 کاراکتر باشد) به غیر این کار نمیکند',//'标题长度(1~80字符)不符合要求',

//--------------------------------
//static/js/home_common.js

	'show_orig_image'	: 'نمایش تصویر اصلی در یک پنجره جدید',//'点击图片，在新窗口显示原始尺寸',
	'continue_sure'		: 'آیا مطمئن به ادامه هستید؟',//'您确定要执行本操作吗？',
	'select_item'		: 'لطفا آیتم را برای کار  انتخاب کنید',//'请选择要操作的对象',
	'image_url_invalid'	: 'URL تصویر نادرست',//'图片地址不正确',
	'audio_url_invalid'	: 'URL های صوتی نادرست، نمی تواند خالی باشد',//'音乐地址错误，不能为空',

//!!!!! MayBe wrap this names!!
	'collapse'		: 'Collapse',//'收起',
	'expand'		: 'Expand',//'展开',

//--------------------------------
//static/js/home_friendselector.js

	'select_max'		: 'شما می توانید انتخاب کنید تا',//'最多只允许选择',
	'users'			: 'کاربران',//'个用户',
	'allready_exists'	: 'وارد شده است',//'已经存在',

//--------------------------------
//static/js/home_manage.js

	'you_friends_now'	: 'شما در حال حاضر دوست هستید، شما می توانید ',//'你们现在是只允许好友了，接下来，您还可以：',
	'leave_message'		: 'گذاشتن یک پیام',//'给TA留言',
	'or'			: 'یا',//'或者',
	'send_greeting'		: 'ارسال پیام تبریک',//'打个招呼',
	'reply'			: 'پاسخ',//'回复',
	'comment'		: 'نظر',//'评论',
	'close_list'		: 'بستن لیست',//'收起列表',
	'more_feeds'		: 'خوراک های بیشتر',//'更多动态',

//--------------------------------
//static/js/home_uploadpic.js

	'image_type_invalid'	: ' عرض پوزش، تصویر با این فرمت پشتیبانی نمی شود',//'对不起，不支持上传此类扩展名的图片',
	'insert_to_content'	: 'برای وارد کردن به محتوا در مکان فعلی  اینجا کلیک کنید',//'点击这里插入内容中当前光标的位置',
	'insert'		: 'وارد کردن',//'插入',
	'image_description'	: 'توضیحات تصویر',//'图片描述',
	'uploading_wait'	: 'در حال آپلود.لطفا صبر کنید',//'上传中，请等待',
	'retry'			: 'تلاش مجدد',//'重试',

//---------------------------
//static/js/makehtml.js
	'generate'		: 'تولید ',//'生成',
	'generate_ok'		: ' با موفقیت تولید شد',//'生成成功',
	'generate_error'	: ' تولید ناموفق',//'生成失败',
	'generate_start'	: 'شروع تولید کردن ',//'开始生成 ',
	'generate_click_continue'	: 'اگر مرورگر شما پاسخ نمی دهد، بر روی ادامه کلیک کنید...',//'如果您的浏览器没有反应，请点击继续...',
	'generate_completed'	: ' تولید کامل شد',//' 生成完成',
	'generate_total'	: 'نیاز های نهایی برای تولید',//'本次共需要生成 ',
	'generate_files'	: ' فایل ها!با موفقیت تولید شدند',//' 文件，成功生成 ',
	'generate_first'	: 'اولین تولید شده',//'正在生成第 ',
	'generate_percent'	: 'تکمیل شده است ',//'已经完成 ',

//---------------------------
//static/js/mobile/common.js
	'first'		: 'اولین ',//'第 ',
	'page'		: 'صفحه',//'页',
	'pages'		: ' صفحات',//'页',
	'prev_page'	: 'قبلی',//'上一页',
	'next_page'	: 'بعدی',//'下一页',
	
	'click_to_reload'	: 'برای بارگیری مجدد کلیک کنید',//'点击重新加载',
	'loading_now'		: 'در حال بارگذاری...',//'正在加载...',

	'geo_timeout'		: 'دریافت محل توقف، لطفا دوباره سعی کنید',//'获取位置超时，请重试',
	'geo_error'		: 'قادر به شناسایی مکان فعلی شما نیست',//'无法检测到您的当前位置',
	'geo_permission'	: 'Please allow normal access to your current location',//'请允许能够正常访问您的当前位置',
	'unknown_error'		: 'خطای ناشناخته رخ داده است',//'发生未知错误',
	'touch_down_refresh'	: 'برای بروز رسانی لمس کنید',//'下拉可以刷新',
	'touch_up_refresh'	: 'Touch UP to refresh',//'松开可以刷新',

//--------------------------------
//static/js/portal.js

	'delete_sure'		: 'آیا مطمئن به حذف این  اطلاعات هستید؟',//'您确定要删除该数据吗？',
	'ignore_sure'		: 'آیا مطمئن  به چشم پوشی از این داده  ها هستید؟',//'您确定要屏蔽该数据吗？',
	'to'			: 'به',//'到',

	'choose_block'		: 'انتخاب بلوک',//'选择模块',
	'blocks_found1'		: 'یافت',//'找到',
	'blocks_found2'		: 'بلوک های مربوطه',//'个相应的模块',
	'blocks_not_found'	: 'بلوک های نا مربوط',//'没有相应的模块',
	'select_block'		: 'لطفا یک بلوک را انتخاب کنید!',//'请选择一个模块！',
	'show_settings'		: 'نمایش تنظیمات',//'展开设置项',
	'hide_settings'		: 'مخفی کردن تنظیمات',//'收起设置项',
	'block_name_empty'	: 'نام بلوک نمی تواند خالی باشد',//'模块标识不能为空',
	'block_convert_sure'	: 'آیا مطمئن به تبدیل بلوک ها براساس نوع هستید؟',//'你确定要转换模块的类型从',
	'back'			: 'بازگشت',//'返回',
	'settings_expand'	: 'نمایش تنظیم',//'展开设置项',
	'settings_hide'		: 'مخفی کردن تنظیم',//'收起设置项',
	'custom_content_error'	: 'خطا در محتوا سفارشی! کد HTML:',//'自定义内容错误，',
	'html_error'		: 'کد HTML: ',//'HTML代码：',
	'tags_not_match'	: ' -برچسب ها مطابقت ندارند',//' 标签不匹配',
	'entered'		: 'وارد شده ',//'已输入 ',
	'exceed'		: 'تجاوز ',//'超出 ',
	'title_length_bad'	: 'این عنوان نادرست است',//'标题长度不正确',
	'summary_length_bad'	: 'طول خلاصه نادرست است',//'简介长度不正确',

//--------------------------------
//static/js/portal_diy.js

	'choose_style'		: 'انتخاب استایل',//'选择样式',
	'style'			: 'استایل',//'样式',
	'style1'		: 'استایل1',//'样式1',
	'style2'		: 'استایل2',//'样式2',
	'style3'		: 'استایل3',//'样式3',
	'style4'		: 'استایل4',//'样式4',
	'style5'		: 'استایل5',//'样式5',
	'style6'		: 'استایل6',//'样式6',
	'style7'		: 'استایل7',//'样式7',
	'no_border'		: 'No border قاب',//'无边框框架',
	'no_border_no_margin'	: 'No border, no margin',//'无边式框且无边距',

	'title'			: 'عنوان',//'标题',
	'attribute'		: 'صفت',//'属性',
	'data'			: 'اطلاعات',//'数据',
	'update'		: 'بروزرسانی',//'更新',
	'export'		: 'صادرکردن',//'导出',
	'repeat'		: 'تکرار',//'平铺',
	'no_repeat'		: 'بدون تکرار',//'不平铺',
	'repeat_x'		: 'تکرار افقی',//'横向平铺',
	'repeat_y'		: 'تکرار عمودی',//'纵向平铺',
	'no_style'		: 'بدون استایل',//'无样式',
	'solid_line'		: 'Solid خط',//'实线',
	'dotted_line'		: 'Dotted خط',//'点线',
	'dashed_line'		: 'Dased خط',//'虚线',
	'link'			: 'لینک',//'链接',
	'border'		: 'Border',//'边框',
	'size'			: 'سایز',//'大小',
	'color'			: 'رنگ',//'颜色',
	'separate_config'	: ' پیکربندی جدا',//'分别设置',
	'right'			: 'راست',//'右',
	'bottom'		: 'پایین',//'下',
	'top'			: 'بالا',//'上',
	'left'			: 'چپ',//'左',
	'margin'		: 'Margin',//'外边距',
	'padding'		: 'Padding',//'内边距',
	'bg_image'		: 'تصویر پس زمینه',//'背景图片',
	'class'			: 'تعیین شده Class',//'指定class',
	'block'			: 'بلوک',//'模块',
	'frame'			: 'فریم',//'框架',
	'onclick'		: 'onClick',//'点击',
	'onmouseover'		: 'onMouseover',//'滑过',
	'switch_type'		: 'Switch Type',//'切换类型',
	'image'			: 'تصویر',//'图片',
	'position'		: 'موقعیت',//'位置',
	'align_left'		: 'Left Align',//'居左',
	'align_right'		: 'Right Align',//'居右',
	'offset'		: 'Offset',//'偏移量',
//!!! mainly the same as 'color' !!!!!!
//	'colour'		: 'Colour',//'色',
	'add_new_title'		: 'اضافه کردن عنوان جدید',//'添加新标题',
	'delete_this_sure'	: 'آیا شما مطمئن به حذف هستید؟ این نمیتوانید بازگردانده شود اگر شما حذفش کنید!',//'您确实要删除吗,删除以后将不可恢复',
	'loading_content'	: 'بارگذاری محتوا...',//'正在加载内容...',
	'modified_import'	: 'You have made some modifications, please import it after you save it, otherwise the imported data won\'t include modification of this time.',//'您已经做过修改，请保存后再做导出，否则导出的数据将不包括您这次所做的修改。',
	'total'			: 'نهایی ',//'共',
	'blocks'		: 'بلوک ها',//'个模块',
	'updating_the'		: 'بروز رسانی #',//'正在更新第',
	'done'			: 'انجام شد',//'已完成',
	'start_updating'	: 'شروع بروز رسانی...',//'开始更新...',
	'update_block_data'	: 'بروز رسانی اطلاعات بلوک',//'更新模块数据',
	'clear_diy_sure'	: 'Are you sure to clear the current page DIY data? It can not be restored if you clear it.',//'您确实要清空页面上所在DIY数据吗,清空以后将不可恢复',
	'frame_not_found'	: 'هشدار: قاب یافت نشد، لطفا قاب اضافه کنید.',//'提示：未找到框架，请先添加框架。',
	'apply_all_pages'	: 'پذیرفتن برای تمام این صفحه',//'应用于此类全部页面',
	'apply_current_page'	: 'درخواست برای صفحه فعلی',//'只应用于本页面',
	'save_temp_sure'	: 'ذخیره اطلاعات موقت؟ <br />برای ذخیره موقت اطلاعات بر روی دکمه ثبت کلیک کنید،و برای لغو ذخیره موقت بر روی دکمه لغو کلیک کنید',//'是否保留暂存数据？<br />按确定按钮将保留暂存数据，按取消按钮将删除暂存数据。',
	'save_temp'		: 'ذخیره اطلاعات موقت',//'保留暂存数据',
	'revert_last_saved'	: 'آیا مطمئن هستید که می خواهید به بازگشت به نسخه های قبلی از نتایج ذخیره؟',//'您确定要恢复到上一版本保存的结果吗？',
	'continue_temp_sure'	: 'Continue to DIY with temporary data?',//'是否继用于续暂存数据的DIY？',
	'update_completed'	: 'بروز رسانی کامل شد.',//'已更新完成。',
	'tab_label'		: 'برگه برچسب',//'tab标签',
	'temp_action'		: 'بر روی دکمه "ادامه" کلیک کنید تا اطلاعات موقت  بر روی استایل فعلی بار گذاری شود ، <br />و برای حذف اطلاعات موقت بر روی دکمه "حذف"کلیک کنید.',//'按继续按钮将打开暂存数据并DIY，<br />按删除按钮将删除暂存数据。',
	'continue'		: 'ادامه',//'继续',
	'block_no_rights'	: 'با عرض پوزش، شما اجازه دسترسی به اضافه کردن و یا ویرایش بلوک را ندارید',//'抱歉，您没有权限添加或编辑模块',

//--------------------------------
//static/js/portal_diy_data.js
	'data_manage'		: 'مدیریت مستقیم از داده های بلوک',//'可直接管理模块数据',
	'quit'			: 'ترک',//'退出',
//--------------------------------
//static/js/qshare.js
	'from_tencent'		: 'من از Tencent  میکرو بلاگ آمده ام یک پلتفورم باز',//"\u6211\u6765\u81EA\u4E8E\u817E\u8BAF\u5FAE\u535A\u5F00\u653E\u5E73\u53F0",

//--------------------------------
//static/js/register.js

	'username_invalid'	: 'نام کاربری حاوی نویسه های نامعتبر است',//'用户名包含敏感字符',
	'username_short'	: 'نام کاربری کوتاه تر از 2 حرف است',//'用户名小于 3 个字符',
	'username_long'		: 'نام کاربری بیشتر از 15 حرف است',//'用户名超过 15 个字符',
	'passwords_not_equal'	: 'دو کلمه عبور با یکدیگر مطابقت ندارد',//'两次输入的密码不一致',
	'email_invalid'		: 'ایمیل حاوی نویسه های نامعتبر است',//'Email 包含敏感字符',
	'invite_code_invalid'	: 'کد دعوت نامه حاوی نویسه های نامعتبر است',//'邀请码包含敏感字符',
	'password_fill'		: 'لطفا رمز عبور را پر کنید',//'请填写密码',
	'password_again'	: 'لطفا دوباره رمز عبور را وارد کنید',//'请再次输入密码',
	'email_fill'		: 'لطفا آدرس ایمیل را وارد کنید',//'请输入邮箱地址',
	'length_min'		: ', کمترین طول',//', 最小长度为 '
	'chars'			: ' کاراکتر',//' 个字符',
	'password_strength'	: 'قدرت رمز عبور: ',//'密码强度:',
	'pw_weak'		: 'ضعیف',//'弱',
	'pw_middle'		: 'متوسط',//'中',
	'pw_strong'		: 'قوی',//'强',
	'pass_short'		: 'رمز عبور بیش از حد کوتاه است',//'密码太短，不得少于 ',
	'digital'		: 'دیجیتال',//'数字',
	'lowercase'		: 'حروف کوچک',//'小写字母',
	'capitals'		: 'حروف بزرگ',//'大写字母',
	'specials'		: 'نماد های خاص',//'特殊符号',
	'pw_weak_info'		: 'رمز عبور ضعیف، رمز عبور باید شامل',//'密码太弱，密码中必须包含 ',
	'leave_blank_old_pass'	: 'این قسمت را خالی بگذارید اگر شما نیازی به تغییر رمز عبور ندارید',//'如不需要更改密码，此处请留空',

//--------------------------------
//static/js/seditor.js
	'enter_username'	: 'لطفا نام کاربری را وارد کنید',//'请输用户名',
	'at_friend'		: '@ کاربر، شما می توانید برای مشاهده پست به او یاددآوری کنید',//'@朋友账号，就能提醒他来看帖子',

//--------------------------------
//static/js/smilies.js

//--------------------------------
//static/js/space_diy.js

	'save_js'		: 'جاوا اسکریپت ذخیره شده',//'javascript脚本保存后显示',
	'settings'		: 'تنظیمات',//'设置',

//---------------------------
//static/js/swfupload.js

	'attach_file'		: 'پیوست',

//---------------------------
//static/js/threadsort.js

	'select_please'		: 'لطفا انتخاب کنید',//'请选择',
	'required_fill'		: 'فیلد های مورد نیاز پر نشده',//'必填项目没有填写',
	'select_next_level'	: 'لطفا  سطح بعدی را انتخاب کنید',//'请选择下一级',
	'numeric_invalid'	: 'مقدار عددی نامعتبر است',//'数字填写不正确',
	'email_invalid'		: 'آدرس ایمیل نامعتبر است',//'邮件地址不正确',
	'text_too_long'		: 'مقدار فیلد بیش از حد طولانی است',//'填写项目长度过长',
	'value_is_greater'	: 'مقدار بیشتر از حداکثر است',//'大于设置最大值',
	'value_is_less'		: 'مقدار کمتر از حداقل است',//'小于设置最小值',
	'enter_valid_url'	: 'لطفا آدرس URL درست را وارد کنید شروع با http://',//'请正确填写以http://开头的URL地址',

//--------------------------------
//static/js/upload.js

	'file_not_supported'	: 'با عرض پوزش، این نوع فایل پشتیبانی نشده است',//'对不起，不支持上传此类文件',
	'wait_upload'		: 'صبر برای آپلود ...',//'等待上传...',

//-------------------------------------
//source/function/function_admincp.php
	'version_uptodate'	: 'شما در حال استفاده از نسخه  به روز Discuz! هستید. لطفا به نکات زیر برای ارتقاء به موقع دقت کنید .',

//-------------------------------------
//api/manyou/cloud_iframe.js
	'add_operation'		: 'اضافه کردن به عملیات مشترک',//'&#28155;&#21152;&#21040;&#24120;&#29992;&#25805;&#20316;',

//--------------------------------------------
//static/js/googlemap.js + static/js/editor.js

	'map_title'		: 'نقشه گوگل',//'google图',
	'map_insert'		: 'قرار دادن نقشه گوگل',//'插入google地图',
	'map_insert_tips'	: 'قرار دادن نقشه های گوگل با جستجو آدرس (به طور موقت پشتیبانی فقط با برچسب !)',//'通过搜索插入google地图（暂只支持单点标注）！',
	'map_center_changed'	: 'مرکز نقشه تغییر کرده است!',//'地图中心已经改变！',
	'map_wrong_address'	: 'آدرس اشتباه است! آدرس فعلی یافت نشد',//' 地址错误，未找到当前地址',

//-------------------------------------
//	''	: '',//'',

'fiction'	: '' // This key MUST BE THE LAST row!

};
