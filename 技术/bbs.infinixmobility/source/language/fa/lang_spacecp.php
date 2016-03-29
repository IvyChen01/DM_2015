<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_spacecp.php by Valery Votintsev, codersclub.org
 *	Translated to Persian by Discuz.ir
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(

	'by'			=> 'پذیرفتن توسط',//'通过',
	'tab_space'		=> ' ',

	'share'			=> 'اشتراک گذاری ها',//'分享',
	'share_action'		=> 'به اشتراک گذاشته شده',//'分享了',

	'pm_comment'		=> 'پاسخ پیام',//'答复点评',
	'pm_thread_about'	=> 'درباره پست خود در "{موضوع}"',//'关于你在“{subject}”的帖子',

	'wall_pm_subject'	=> 'پیام جدید در دیوار',//'您好，我给您留言了',
	'wall_pm_message'	=> 'سلام،  یک پیام جدید در دیوار شما، [URL = \ \ 1]برای مشاهده اینجا کلیک کنید[/ URL]',//'我在您的留言板给你留言了，[url=\\1]点击这里去留言板看看吧[/url]',
	'reward'		=> 'پاداش',//'悬赏',
	'reward_info'		=> 'یک اعتبار دریافت کردید: + \\1 امتیاز.',//'参与投票可获得  \\1 积分',
	'poll_separator'	=> ', ',//'"、"',

	'pm_report_content'		=> '<a href="home.php?mod=space&uid={reporterid}" target="_blank">{reportername}</a> گزارش پیام:<br>از<a href="home.php?mod=space&uid={uid}" target="_blank">{username}</a> پیام کوتاه<br>محتوا: {message}',//'<a href="home.php?mod=space&uid={reporterid}" target="_blank">{reportername}</a>举报短消息：<br>来自<a href="home.php?mod=space&uid={uid}" target="_blank">{username}</a>的短消息<br>内容：{message}',
	'message_can_not_send_1'	=> 'ارسال پیام ناموفق. ظرفیت ارسال پیام شما در 24 ساعت بیش از حدت مجاز است',//'发送失败，您当前超出了24小时内两人会话的上限',
	'message_can_not_send_2'	=> 'صبر کنید-شما یک پیام کوتاه را بیش از حد سریع ارسال کردید',//'两次发送短消息太快，请稍候再发送',
	'message_can_not_send_3'	=> 'پوزش!شما نمیتوانید به غیر از دوستانتان پیام بفرستید',//'抱歉，您不能给非好友批量发送短消息',
	'message_can_not_send_4'	=> 'پوزش.در حال حاضر شما نمیتوانید پیامی ارسال کنید',//'抱歉，您目前还不能使用发送短消息功能',
	'message_can_not_send_5'	=> 'You have exceeded the group chat number of messages within 24 hours session',//'您超出了24小时内群聊会话的上限',
	'message_can_not_send_6'	=> 'دریافت کننده پیام شما را مسدود کرده است',//'对方屏蔽了您的短消息',
	'message_can_not_send_7'	=> 'The group chat maximum number of messages exceeded',//'超过了群聊人数上限',
	'message_can_not_send_8'	=> 'پوزش.شما نمیتوانید به خودتان پیام بفرستید',//'抱歉，您不能给自己发短消息',
	'message_can_not_send_9'	=> 'The message is empty or the recipient blocked your message',//'收件人为空或对方屏蔽了您的短消息',
	'message_can_not_send_10'	=> 'برای شروع چت گروهی حداقل دو عضو لازم است',//'发起群聊人数不能小于两人',
	'message_can_not_send_11'	=> 'جلسه ای وجود ندارد',//'该会话不存在',
	'message_can_not_send_12'	=> 'با عرض پوزش، شما اجازه دسترسی به این عملیات ندارید',//'抱歉，您没有权限操作',
	'message_can_not_send_13'	=> 'این یک پیام گروهی نیست',//'这不是群聊消息',
	'message_can_not_send_14'	=> 'این یک پیام خصوصی نیست',//'这不是私人消息',
	'message_can_not_send_15'	=> 'اطلاعات اشتباه',//'数据有误',
	'message_can_not_send_16'	=> 'You have exceeded the maximum number of PM within 24 hours',//'您超出了24小时内发短消息数量的上限',
	'message_can_not_send_onlyfriend'	=> 'کاربر فقط میتواند از دوستان پیام دریافت کند',//'该用户只接收好友发送的短消息',


	'friend_subject'	=> '<a href="{url}" target="_blank">{username} میخواهد که شما را به لیست دوستانش اضافه کند</a>',//'<a href="{url}" target="_blank">{username} 请求加你为好友</a>',
	'friend_request_note'	=> ', پانوشت: {note}',//'，附言：{note}',
	'comment_friend'	=> '<a href="\\2" target="_blank">\\1 نادیده گرفتن یک پیام به شما</a>',//'<a href="\\2" target="_blank">\\1 给你留言了</a>',
	'photo_comment'		=> '<a href="\\2" target="_blank">\\1 نظر برای تصویر شما</a>',//'<a href="\\2" target="_blank">\\1 评论了你的照片</a>',
	'blog_comment'		=> '<a href="\\2" target="_blank">\\1  نظر برای بلاگ شما</a>',//'<a href="\\2" target="_blank">\\1 评论了你的日志</a>',
	'poll_comment'		=> '<a href="\\2" target="_blank">\\1  نظر برای نظر سنجی شما</a>',//'<a href="\\2" target="_blank">\\1 评论了你的投票</a>',
	'share_comment'		=> '<a href="\\2" target="_blank">\\1  نظر برای به اشتراک گذاری شما </a>',//'<a href="\\2" target="_blank">\\1 评论了你的分享</a>',
	'friend_pm'		=> '<a href="\\2" target="_blank">\\1 پیام ارسال شده به شما</a>',//'<a href="\\2" target="_blank">\\1 给你发私信了</a>',
	'poke_subject'		=> '<a href="\\2" target="_blank">\\1  پیام تبریک به شما</a>',//'<a href="\\2" target="_blank">\\1 向你打招呼</a>',
	'mtag_reply'		=> '<a href="\\2" target="_blank">\\1 پاسخ به تاپیک گروهی شما</a>',//'<a href="\\2" target="_blank">\\1 回复了你的话题</a>',
	'event_comment'		=> '<a href="\\2" target="_blank">\\1 نظر برای رویداد های شما</a>',//'<a href="\\2" target="_blank">\\1 评论了你的活动</a>',

	'friend_pm_reply'	=> '\\1 پاسخ به پیام خصوصی شما',//'\\1 回复了你的私信',
	'comment_friend_reply'	=> '\\1 پاسخ به پیام شما',//'\\1 回复了你的留言',
	'blog_comment_reply'	=> '\\1  پاسخ به نظر در بلاگ شما',//'\\1 回复了你的日志评论',
	'photo_comment_reply'	=> '\\1  پاسخ به نظر در مورد تصویر شما',//'\\1 回复了你的照片评论',
	'poll_comment_reply'	=> '\\1 پاسخ به نظر در نظر سنجی شما',//'\\1 回复了你的投票评论',
	'share_comment_reply'	=> '\\1 پاسخ به نظر در مورد به اشتراک گذاری شما',//'\\1 回复了你的分享评论',
	'event_comment_reply'	=> '\\1 پاسخ به نظر در مورد رویداد های شما',//'\\1 回复了你的活动评论',

	'mail_my'		=> 'یادآوری در مورد تعامل با دوستان من',//'好友与我的互动提醒',
	'mail_system'		=> 'سیستم هشدار ها',//'系统提醒',

	'invite_subject'	=> '{username} از شما دعوت کرده به پیوستن به {sitename}, و اضافه شدن به لیست دوستان',//'{username}邀请您加入{sitename}，并成为好友',
	'invite_massage'	=> '<table border="0">
				<tr>
				<td valign="top">{avatar}</td>
				<td valign="top">
				<h3>سلام, من {username} هستم. من شمارا به پیوستن به (sitename) و اضافه شدن به دوستان من دعوت میکنم</h3><br>
				لطفا به لیست دوستان من ملحق شوید, و شما میتوانید از وضع کنونی من مطلع شوید ,ارتباط با من, و با من در هر زمان تماس بگیرید<br>
				<br>
				Invite P.S.:<br>{saymsg}
				<br><br>
				<strong>Please click the link below to receive the Friend Invite:</strong><br>
				<a href="{inviteurl}">{inviteurl}</a><br>
				<br>
				<strong>If you have an account at {sitename}, please click the following link to see my personal page:</strong><br>
				<a href="{siteurl}home.php?mod=space&uid={uid}">{siteurl}home.php?mod=space&uid={uid}</a><br>
				</td></tr></table>',

	'app_invite_subject'	=> '{username}شما را دعوت کرده به {sitename}و باز با {appname}',//'{username}邀请您加入{sitename}，一起来玩{appname}',
	'app_invite_massage'	=> '<table border="0">
				<tr>
				<td valign="top">{avatar}</td>
				<td valign="top">
				<h3>سلام, من{username} هستم  از  {sitename}. و شما را به بازی دونفره &quot;{appname}&quot; دعوت میکنم</h3><br>
				<br>
				Invite P.S.:<br>
				{saymsg}
				<br><br>
				<strong>Please click the link below to receive the invite to play with {appname}:</strong><br>
				<a href="{inviteurl}">{inviteurl}</a><br>
				<br>
				<strong>if you have an account at {sitename}, please click the following link to see my personal page:</strong><br>
				<a href="{siteurl}home.php?mod=space&uid={uid}">{siteurl}home.php?mod=space&uid={uid}</a><br>
				</td></tr></table>',

	'person'		=> 'مردم',//'人',
	'delete'		=> 'حذف کردن',//'删除',

	'space_update'		=> '{actor} پروفایل بروز رسانی شده',//'{actor} 被SHOW了一下',

	'active_email_subject'	=> 'ایمیل فعال سازی',//'您的邮箱激活邮件',
	'active_email_msg'	=> 'Please copy the following link to your browser in order to activate your mailbox.<br>E-mail activation link:<br><a href="{url}" target="_blank">{url}</a>',//'请复制下面的激活链接到浏览器进行访问，以便激活你的邮箱。<br>邮箱激活链接:<br><a href="{url}" target="_blank">{url}</a>',
	'share_space'		=> 'به اشتراک گذاری پروفایل ',//'分享了一个用户',
	'share_blog'		=> 'به اشتراک گذاری بلاگ',//'分享了一篇日志',
	'share_album'		=> 'به اشتراک گذاری آلبوم',//'分享了一个相册',
	'default_albumname'	=> 'آلبوم پیش فرض',//'默认相册',
	'share_image'		=> 'به اشتراک گذاری تصویر',//'分享了一张图片',
	'share_article'		=> 'به اشتراک گذاشتن مقاله',//'分享了一篇文章',
	'album'			=> 'آلبوم ها',//'相册',
	'share_thread'		=> 'به اشتراک گذاشتن موضوع',//'分享了一个帖子',
	'mtag'			=> 'گروه ها',
	'share_mtag'		=> 'به اشتراک گذاشتن گروه',
	'share_mtag_membernum'	=> 'has (membernum) members',//'现有 {membernum} 名成员',
	'share_tag'		=> 'اشتراک گذاری برچسب',//'分享了一个标签',
	'share_tag_blognum'	=> 'استفاده شده در {blognum} بلاگ ها',//'现有 {blognum} 篇日志',
	'share_link'		=> 'اشتراک گذاری لینک',//'分享了一个网址',
	'share_video'		=> 'اشتراک گذاری ویدیو',//'分享了一个视频',
	'share_music'		=> 'اشتراک گذاری موزیک',//'分享了一个音乐',
	'share_flash'		=> 'اشتراک گذاری فلش',//'分享了一个 Flash',
	'share_event'		=> 'اشتراک گذاری رویداد',//'分享了一个活动',
	'share_poll'		=> 'اشتراک گذاری نظر سنجی \\1',//'分享了一个\\1投票',
	'event_time'		=> 'زمان',//'活动时间',
	'event_location'	=> 'موقعیت',//'活动地点',
	'event_creator'		=> 'سازنده',//'发起人',
	'the_default_style'	=> 'قالب پیش فرض',//'默认风格',
	'the_diy_style'		=> 'قالب انتخابی',//'自定义风格',

	'thread_edit_trail'		=> '<ins class="modify">[موضوع ویرایش شده توسط \\1 در \\2]</ins>',//'<ins class="modify">[本话题由 \\1 于 \\2 编辑]</ins>',
	'create_a_new_album'		=> 'ساختن یک آلبوم جدید',//'创建了新相册',
	'not_allow_upload'		=> 'شما اجازه آپلود کردن عکس را ندارید',//'您现在没有权限上传图片',
	'not_allow_upload_extend'	=> 'It is not allowed to upload images of {extend} type',//'不允许上传{extend}类型的图片',
	'files_can_not_exceed_size'	=> '{extend} type files can not exceed the {size}',//'{extend}类文件不能超过{size}',
	'get_passwd_subject'		=> 'بازیابی رمز عبور توسط ایمیل',//'取回密在没码邮件',
	'get_passwd_message'		=> 'You should use the link below to reset your password in 3 days:<br />\\1<br />If clicking the URL in this message does not work, just copy and paste it into the address bar of your browser.<br />At the page opened just enter your new password and submit. After this you can login with new password.',//'您只需在提交请求后的三天之内，通过点击下面的链接重置您的密码：<br />\\1<br />(如果上面不是链接形式，请将地址手工粘贴到浏览器地址栏再访问)<br />上面的页面打开后，输入新的密码后提交，之后您即可使用新的密码登录了。',
	'file_is_too_big'		=> 'حجم فایل زیاد است',//'文件过大',

	'take_part_in_the_voting'		=> '{actor} voted the {touser} poll  <a href="{url}" target="_blank">{subject}</a> and get reward {reward} points.',//'{actor} 参与了 {touser} 的{reward}投票 <a href="{url}" target="_blank">{subject}</a>',
	'lack_of_access_to_upload_file_size'	=> 'Unable to get uploaded file size',//'无法获取上传文件大小',
	'only_allows_upload_file_types'		=> 'پسوند فایل های مجاز عکس برای آپلود: jpg,jpeg,gif,png',//'只允许上传jpg、jpeg、gif、png标准格式的图片',
	'unable_to_create_upload_directory_server'	=> 'Unable to create upload directory at the server',//'服务器无法创建上传目录',
	'inadequate_capacity_space'		=> 'Can not upload new attachments, insufficient space capacity.',//'空间容量不足，不能上传新附件',
	'mobile_picture_temporary_failure'	=> 'Can not move temporary files to specified server directory',//'无法转移临时文件到服务器指定目录',
	'ftp_upload_file_size'		=> 'Remote FTP upload failed (file size)',//'远程上传图片失败',
	'comment'			=> 'نظر',//'评论',
	'upload_a_new_picture'		=> 'آپلود عکس جدید',//'上传了新图片',
	'upload_album'			=> 'آلبوم به روز شد',//'更新了相册',
	'the_total_picture'		=> ' \\1 عکس نهایی',//'共 \\1 张图片',

	'space_open_subject'	=> 'Come to your personal page and take care about it',//'快来打理一下您的个人主页吧',
	'space_open_message'	=> 'Hi, today I visited your personal page and found out you do not customize it. Take a look! The address is: \\1space.php',//'hi，我今天去拜访了一下您的个人主页，发现您自己还没有打理过呢。赶快来看看吧。地址是：\\1space.php',



	'apply_mtag_manager'	=> 'Want to be a moderator of the group <a href="\\1" target="_blank">\\2</a>. The reason:\\3 <br><a href="\\1" target="_blank">(click here to manage)</a>',//'想申请成为 <a href="\\1" target="_blank">\\2</a> 的群主，理由如下:\\3。<a href="\\1" target="_blank">(点击这里进入管理)</a>',


	'magicunit'		=> 'ones',//'个',
	'magic_note_wall'	=> 'left a message on your <a href="{url}" target="_blank">Wall</a>',//'在留言板上给你<a href="{url}" target="_blank">留言</a>',
	'magic_call'		=> 'mid-pointed your name in blog, <a href="{url}" target="_blank">click here to view</a>',//'在日志中点了你的名，<a href="{url}" target="_blank">快去看看吧</a>',


	'present_user_magics'	=> 'شما یک کارت هدیه جادویی دریافت کرده اید \\1 from administrator',//'您收到了管理员赠送的道具：\\1',
	'has_not_more_doodle'	=> 'You have no Graffiti.',//'您没有涂鸦板了',

	'do_stat_login'		=> 'ورود ها',//'来访用户',
	'do_stat_mobilelogin'	=> 'ورود موبایل',//'手机访问',
	'do_stat_connectlogin'	=> 'QQ ورود',//'QQ登录访问',
	'do_stat_register'	=> 'ثبت نام',//'新注册用户',
	'do_stat_invite'	=> 'دعوت دوستان',//'好友邀请',
	'do_stat_appinvite'	=> 'برنامه های دعوت',//'应用邀请',
	'do_stat_add'		=> 'انتشار اطلاعات',//'信息发布',
	'do_stat_comment'	=> 'پاسخ اطلاعات',//'信息互动',
	'do_stat_space'		=> 'ارتباط کاربران',//'用户互动',
	'do_stat_doing'		=> 'اعمال',//'记录',
	'do_stat_blog'		=> 'بلاگ ها',//'日志',
	'do_stat_activity'	=> 'رویداد ها',//'活动',
	'do_stat_reward'	=> 'پاداش ها',//'悬赏',
	'do_stat_debate'	=> 'بحث ها',//'辩论',
	'do_stat_trade'		=> 'فروش ها',//'商品',
	'do_stat_group'		=> 'گروه ها',//"创建{$_G[setting][navs][3][navname]}",
	'do_stat_tgroup'	=> 'گروه ها',//"{$_G[setting][navs][3][navname]}",
	'do_stat_home'		=> 'پروفایل',//"{$_G[setting][navs][4][navname]}",
	'do_stat_forum'		=> 'انجمن',//"{$_G[setting][navs][2][navname]}",
	'do_stat_groupthread'	=> 'موضوع های گروه',//'群组主题',
	'do_stat_post'		=> 'پاسخ ها',//'主题回复',
	'do_stat_grouppost'	=> 'پساخ های گروه',//'群组息发回复',
	'do_stat_pic'		=> 'تصاویر',//'图片',
	'do_stat_poll'		=> 'نظر سنجی ها',//'投票',
	'do_stat_event'		=> 'رویداد ها',//'活动',
	'do_stat_share'		=> 'اشتراک گذاری ها',//'分享',
	'do_stat_thread'	=> 'موضوعات',//'主题',
	'do_stat_docomment'	=> 'نوع نظر ها',//'记录回复',
	'do_stat_blogcomment'	=> 'نظر های بلاگ',//'日志评论',
	'do_stat_piccomment'	=> 'نظر های تصاویر',//'图片评论',
	'do_stat_pollcomment'	=> 'نظر های نظر سنجی',//'投票评论',
	'do_stat_pollvote'	=> 'اعتبار های نظر سنجی',//'参与投票',
	'do_stat_eventcomment'	=> 'نظر های رویداد',//'活动评论',
	'do_stat_eventjoin'	=> 'پویستن رویداد',//'参加活动',
	'do_stat_sharecomment'	=> 'اشتراک گذاری نظر ها',//'分享评论',
//vot	'do_stat_post'		=> 'Replies',//'主题回帖',
	'do_stat_click'		=> 'Sticks',//'表态',
	'do_stat_wall'		=> 'دیوار',//'留言',
	'do_stat_poke'		=> 'پیام های تبریک',//'打招呼',
	'do_stat_sendpm'	=> 'ارسال پیام',//'发短消息',
	'do_stat_addfriend'	=> 'دعوت نامه دوستی',//'好友请求',
	'do_stat_friend'	=> 'دوست شدن',//'成为好友',
	'do_stat_post_number'	=> 'شمارش پست ',//'发帖量',
	'do_stat_statistic'	=> 'ادغام آمار',//'合并统计',
	'logs_credit_update_INDEX'	=> array('TRC','RTC','RAC','MRC','BMC','TFR','RCV','CEC','ECU','SAC','BAC','PRC','RSC','STC','BTC','AFD','UGP','RPC','ACC','RCT','RCA','RCB','CDC','RGC','BGC','AGC','RKC','BME','RPR','RPZ','FCP','BGC'),
	'logs_credit_update_TRC'	=> 'پاداش کار',//'任务奖励',
	'logs_credit_update_RTC'	=> 'پاداش تاپیک',//'悬赏主题',
	'logs_credit_update_RAC'	=> 'جایزه بهترین پاسخ',//'最佳答案',
	'logs_credit_update_MRC'	=> 'دریافت تصادفی جادو ',//'道具随机获取',
	'logs_credit_update_BMC'	=> 'خرید جادو',//'购买道具',
	'logs_credit_update_TFR'	=> 'بازگشت انتقال',//'转账转出',
	'logs_credit_update_RCV'	=> 'بازگشت دریافت',//'转账接收',
	'logs_credit_update_CEC'	=> 'باز خریدن امتیازات',//'积分兑换',
	'logs_credit_update_ECU'	=> 'UCenter points Exchange Spending',//'UCenter积分兑换支出',
	'logs_credit_update_SAC'	=> 'پیوست فروش',//'出售附件',
	'logs_credit_update_BAC'	=> 'پیوست خرید',//'购买附件',
	'logs_credit_update_PRC'	=> 'اعتبار به این پست داده شده',//'帖子被评分',
	'logs_credit_update_RSC'	=> 'اعتبار پست',//'帖子评分',
	'logs_credit_update_STC'	=> 'موضوع های فروخته شده',//'出售主题',
	'logs_credit_update_BTC'	=> 'خرید موضوع',//'购买主题',
	'logs_credit_update_AFD'	=> 'خرید امتیازات',//'购买积分',//?????????
	'logs_credit_update_UGP'	=> 'خرید دسترسی گروه',//'购买扩展用户组',
	'logs_credit_update_RPC'	=> 'گزارش پاداش',//'举报奖惩',
	'logs_credit_update_ACC'	=> 'شرکت در فعالیت ها',//'参与活动',
	'logs_credit_update_RCT'	=> 'ایجاد جایزه پاسخ ها',//'回帖奖励',
	'logs_credit_update_RCA'	=> 'پاسخ ها برنده',//'回帖中奖',
	'logs_credit_update_RCB'	=> 'پازگشت جایزه پاسخ ها',//'返还回帖奖励积分',
	'logs_credit_update_CDC'	=> 'Recharge card secret',//'卡密充值',
	'logs_credit_update_RGC'	=> 'حذف هدیه',//'回收红包',
	'logs_credit_update_BGC'	=> 'بازگشت هدیه',//'埋下红包',
	'logs_credit_update_AGC'	=> 'دریافت هدیه',//'获得红包',
	'logs_credit_update_RKC'	=> 'پیشنهاد رتبه',//'竞价排名',
	'logs_credit_update_BME'	=> 'خرید مدال',//'购买勋章',
	'logs_credit_update_RPR'	=> 'سابقه امتیازات پاداش و مجازات ها',//'后台积分奖惩',
	'logs_credit_update_RPZ'	=> 'Background points rewards and punishments clean',//'后台积分奖惩清零',
	'logs_credit_update_FCP'	=> 'پرداخت انجمن',//'付费版块',
	'logs_credit_update_BGR'	=> 'ساختن گروه',//'创建群组',
	'buildgroup'			=> 'مشاهده گروه های ساخته شده در حال حاظر',//'查看已创建的群组',
	'logs_credit_update_reward_clean'	=> 'پاک کردن',//'清零',
	'logs_select_operation'		=> 'لطفا نوع عملیات را انتخاب کنید',//'请选择操作类型',
	'task_credit'			=> 'امتیاز های پاداش کار',//'任务奖励积分',
	'special_3_credit'		=> 'Reward Topic points deduction',//'悬赏主题扣除积分',
	'special_3_best_answer'		=> 'امتیاز پاداش دریافت بهترین پاسخ',//'最佳答案获取悬赏积分',
	'magic_credit'			=> 'Magic random get points',//'道具随机获取积分',
	'magic_space_gift'		=> 'Own Space red envelopes',//'在自已空间首页埋下红包',
	'magic_space_re_gift'		=> 'Gift recycling can not run for the red envelope',//'回收还没有用完的红包',
	'magic_space_get_gift'		=> 'دسترسی به پروفایل برای دریافت هدیه',//'访问空间领取的红包',
	'credit_transfer'		=> 'انتقال امتیاز',//'进行积分转帐',
	'credit_transfer_tips'		=> 'درآمد نقل و انتقالات',//'的转账收入',
	'credit_exchange_tips_1'	=> 'Perform the points exchange',//'执行积分对兑换操作,将 ',
	'credit_exchange_to'		=> 'تبدیل به',//'兑换成',
	'credit_exchange_center'	=> 'UCenter Exchange Points Center',//'通过UCenter兑换积分',
	'attach_sell'			=> 'فروش',//'出售',
	'attach_sell_tips'		=> 'گرفتن امتیاز برای پیوست',//'的附件获机获得积分',
	'attach_buy'			=> 'خرید',//'购买',
	'attach_buy_tips'		=> 'پرداخت امتیاز برای پیوست',//'的附件支出积分',
	'grade_credit'			=> 'امتیازات به دست آمده توسط رتبه',//'被评分获得的积分',
	'grade_credit2'			=> 'Posts rating deducted points',//'帖子评分扣除的积分',
	'thread_credit'			=> 'گرفتن امتیاز برای دسترسی به موضوع',//'主题获得积分',
	'thread_credit2'		=> 'پرداختن امتیاز برای دسترسی به موضوع',//'主题支出积分',
	'buy_credit'			=> 'Recharge points',//'对积分充值',
	'buy_usergroup'			=> 'پرداخت امتیاز برای خرید دسترسی گروه',//'购买扩展用户组支出积分',
	'buy_medal'			=> 'خرید مدال',//'购买勋章',
	'buy_forum'			=> 'Buy a paid forum access permissions',//'购买付费版块的访问权限',
	'report_credit'			=> 'Rewards and punishments report',//'举报功能中的奖惩',
	'join'				=> 'ملحق شدن',//'参与',
	'activity_credit'		=> 'Activity points deducted',//'活动扣除积分',
	'thread_send'			=> 'Post thread deduct points',//'扣除发表',
	'replycredit'			=> 'پاسخ امتیازات',//'散发的积分',
	'add_credit'			=> 'پاداش امتیازات',//'奖励积分',
	'recovery'			=> 'بهبود',//'回收',
	'replycredit_post'		=> 'Replies award',//'回帖奖励',
	'replycredit_thread'		=> 'ایجاد امتیاز موضوع',//'散发的帖子',
	'card_credit'			=> 'Points obtained by recharge card',//'卡密充值获得的积分',
	'ranklist_top'			=> 'پرداخت امتیاز برای شرکت در رتبه بندی',//'参加竞价排名消费积分',
	'admincp_op_credit'		=> 'پاداش های اعتباری و عملیات مجازات',//'后台积分奖惩操作',
	'credit_update_reward_clean'	=> 'پاک سازی',//'清零',

	'profile_unchangeable'		=> 'این اطلاعات بعد از ثبت نمیتواند ویرایش شود',//'此项资料提交后不可修改',
	'profile_is_verifying'		=> 'این اطلاعات مورد تایید است',//'此项资料正在审核中',
	'profile_mypost'		=> 'پست های من',//'我提交的内容',
	'profile_need_verifying'	=> 'این اطلاعات باید تایید بشود',//'此项资料提交后需要审核',
	'profile_edit'			=> 'ویرایش',//'修改',
	'profile_censor'		=> '(کلمات بد)',//'（含有敏感词汇）',
	'profile_verify_modify_error'	=> '{بررسی} تایید شد. اصلاح غیر فعال شده است.',//'{verify}已经认证通过不允许修改',
	'profile_verify_verifying'	=> 'اطلاعات {تایید} شما ارسال شده است، لطفا برای تأیید صبر کنید.',//'您的{verify}信息已提交，请耐心等待核查。',

	'district_level_1'		=> '- کشور -',//'-国家-',
	'district_level_2'		=> '- ملیت -',//'-省份-',
	'district_level_3'		=> '- شهر -',//'-城市-',
	'district_level_4'		=> '- شهرستان / روستا -',//'-州县/乡镇-',
	'invite_you_to_visit'		=> '{user} شما را به {bbname} دعوت کرده',//'{user}邀请您访问{bbname}',
//vot	'district_level_0'		=> '- Country -',//'-国家-',
	'portal'		=> 'سردر',//'门户',
	'group'			=> 'گروه ها',//'群组',
	'follow'		=> 'دنبال کردن',//'广播',
	'collection'		=> 'مجموعه',//'淘帖',
	'guide'			=> 'راهنما',//'导读',
	'feed'			=> 'خوراک ها',//'动态',
	'blog'			=> 'بلاگ ها',//'日志',
	'doing'			=> 'فعالیت ها',//'记录',
	'wall'			=> 'دیوار',//'留言板',
	'homepage'		=> 'پروفایل شخصی',//'个人主页',
	'ranklist'		=> 'فهرست رتبه',//'排行榜',
	'select_the_navigation_position'	=> 'انتخاب {type}موفعیت ناوبری',//'选择{type}导航位置',
	'close_module'		=> 'بستن {type} افزونه',//'关闭{type}功能',

	'follow_add_remark'		=> 'اضافه کردن نظر',//'添加备注',
	'follow_modify_remark'		=> 'ویرایش نظر',//'修改备注',
	'follow_specified_group'	=> 'دنبال کردن گروه  ویژه',//'广播专区',
	'follow_specified_forum'	=> 'دنبال کردن انجمن ویژه',//'广播专版',

	'filesize_lessthan'		=> 'File size should be less than ',//'文件大小应该小于',

	'spacecp_message_prompt'	=> '(supported {msg} code, maximum 1000 characters)',//'(支持 {msg} 代码,最大 1000 字)',
	'card_update_doing'		=> ' <a class="xi2" href="###">[update doings]</a>',//' <a class="xi2" href="###">[更新记录]</a>',
	'email_acitve_message'		=> '<img src="{imgdir}/mail_inactive.png" alt="Unverified" class="vm" />
						<span class="xi1">ایمیل جدید({newemail})برای اعتبار سنجی صبر کنید ...</span><br />
						The system has sent a verification email to you, please check your mailbox for activate this e-mail.<br>
						If you did not receive the verification message, you can replace a mailbox, or <a href="home.php?mod=spacecp&ac=profile&op=password&resend=1" class="xi2">Re-send the verification message</a>',
	'qq_set_status'		=> 'I set my QQ online status',//'设置我的QQ在线状态',
	'qq_dialog'		=> 'Start QQ chat',//'发起QQ聊天',

);

