<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_portalcp.php by Valery Votintsev, codersclub.org
 *	Translated to Persian by Discuz.ir
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(
	'block_diy_nopreview'		=> '<p>This block contain js, you cannot preview it, please save to view.</p>',//'<p>此模块内容包含js代码，不能立即预览，请点击保存后查看</p>',
	'block_diy_summary_html_tag'	=> 'Custom content errors, HTML tags:',//'自定义内容错误，HTML标签：',
	'block_diy_summary_not_closed'	=> ' یکی نیست',//' 不匹配',
	'block_all_category'		=> 'همه موضوع ها',//'全部分类',
	'block_first_category'		=> 'برترین موضوعات',//'顶级分类',
	'block_all_forum'		=> 'تمام انجمن',//'全部版块',
	'block_all_group'		=> 'تمام گروه های کاربری',//'全部用户组',
	'block_all_type'		=> 'همه نوع',//'全部分类',
	'file_size_limit'		=> 'File exceed the limit {size} kb, please return.',//'文件不能大于 {size} kb，请返回．',
	'set_to_conver'			=> 'قرار دادن به عنوان کاور',//'设为封面',
	'small_image'			=> 'عکس کوچک',//'小图',
	'insert_small_image'		=> 'قرار دادن عکس کوچک',//'插入小图',
	'insert_large_image'		=> 'قرار دادن عکس بزرگ',//'插入大图',
	'insert_file'			=> 'قرار دادن فایل',//'插入文件',
	'delete'			=> 'حدف',//'删除',
	'upload_error'			=> 'اپلود ناموفق',//'上传失败',
	'upload_remote_failed'		=> 'اپلود ناموفق',//'远程上传失败',
	'article_noexist'		=> 'مقاله مورد نظر یافت نشد ',//'指定的文章不存在，请检查',
	'article_noallowed'		=> 'شما دسترسی مشاهده این مقاله را ندارید',//'你没有权限对指定的文章进行操作',
	'article_publish_noallowed'	=> 'شما دسترسی انتشار این مقاله را ندارید',//'你没有权限进行文章发布操作',
	'article_category_empty'	=> 'متاسفانه دسته بتدی شما پر است',//'抱歉，栏目不能为空',
	'article_edit_nopermission'	=> 'متاسفانه شما دسترسی ویرایش این مقاله را ندارید',//'抱歉，您没有权限进行当前文章操作',
	'article_publish'		=> 'انتشار مقاله',//'发布文章',
	'article_manage'		=> 'مدیریت مقاله',//'管理文章',
	'article_tag'			=> 'کلمات کلیدی',//'标签',
	'select_category'		=> 'انتخاب دسته بندی',//'选择分类',
	'blockstyle_diy'		=> 'پوسته دستی',//'自定义模板',

	'article_pushplus_info'		=> '<p><center><i><a href="{url}" class="xg1 xs1">This article provided by the {author}</a></i><center></p>',

	'diytemplate_name_null'		=> '[کامل نشده]',//'[未填写]',
	'portal_view_name'		=> ' مشاهده صفحه مقاله',//' 文章查看页',
	'forum_viewthread_name'		=> ' مشاهده صفحه ارسال',//' 帖子查选择看页',
	'portal/index'			=> 'خانه مقاله ها',//'文章首页',
	'portal/list'			=> 'صفحه لیست مقاله ها(public)',//'文章列表页(公共)',
	'portal/view'			=> 'صفحه نمایش مقاله (public)',//'文章查看页(公共)',
	'portal/comment'		=> 'صفحه نظر های مقاله',//'文章评论页',
	'forum/discuz'			=> 'خانه انجمن',//'论坛首页',
	'forum/viewthread'		=> 'مشاهده صفحه تاپیک (public)',//'帖子查看页(公共)',
	'forum/forumdisplay'		=> 'انمایش انجمن (public)',//'版块列表页(公共)',
	'group/index'			=> 'خانه گروه',//$_G['setting']['navs'][3]['navname'].'首页',
	'group/group_my'		=> 'خانه گروه های من',//'我的'.$_G['setting']['navs'][3]['navname'].'首页',
	'group/group'			=> 'خانه گروهها',//$_G['setting']['navs'][3]['navname'].'内容页',
	'home/space_home'		=> 'صفحه اصلی پروفایل',//'空间首页',
	'home/space_trade'		=> 'صفحه محصولات پروفایل',//'空间商品页',
	'home/space_top'		=> 'لیست برترین پروفایل ها',//'空间排行榜',
	'home/space_thread'		=> 'صفحه موضوع پروفایل',//'空间帖子页',
	'home/space_reward'		=> 'Space offering a reward page',//'空间悬赏页',
	'home/space_share_list'		=> 'صفحه لیست اشتراک گذاری های پروفایل',//'空间分享列表页',
	'home/space_share_view'		=> 'مشاهده صفحه اشتراک گذاری های پروفایل',//'空间分享查看页',
	'space_share_view'		=> 'مشاهده صفحه اشتراک گذاری های پروفایل',//'空间分享查看页',
	'home/space_poll'		=> 'صفحه نظرسنجی های پروفیل',//'空间投票页',
	'home/space_pm'			=> 'صفحه پیغام های کوتاه پروفایل',//'空间短消息页',
	'home/space_notice'		=> 'Space reminder Page',//'空间提醒页',
	'home/space_group'		=> 'صفحه گروه های پروفیل',//'空间'.$_G['setting']['navs'][3]['navname'].'页',
	'home/space_friend'		=> 'صفحه دوستان پروفیل',//'空间好友页',
	'home/space_favorite'		=> 'صفحه علاقه مندی ها پروفایل',//'空间收藏页',
	'home/space_doing'		=> 'Space Twits page',//'空间记录页',
	'home/space_debate'		=> 'Space debates page',//'空间辩论页',
	'home/space_blog_view'		=> 'نمایش صفحه وبلاگ پروفایل',//'空间日志查看页',
	'home/space_blog_list'		=> 'صفحه لیست وبلاگ پروفایل',//'空间日志列表页',
	'home/space_album_view'		=> 'صفحه لیست تصاویر پروفایل',//'空间相册查看页',
	'home/space_album_pic'		=> 'صفحه تصاویر آلبوم پروفایل',//'空间图片查看页',
	'home/space_album_list'		=> 'صفحه لیست آلبوم پروفایل',//'空间相册列表页',
	'home/space_activity'		=> 'Space Events Page',//'空间活动页',
	'ranklist/ranklist'		=> 'همه رتبه ها',//'全部排行榜页',
	'ranklist/blog'			=> 'برترین بلاگ ها',//'日志排行榜页',
	'ranklist/poll'			=> 'یرترین نظر سنجی ها',//'投票排行榜页',
	'ranklist/activity'		=> 'برترین رویداد ها',//'活动排行榜页',
	'ranklist/forum'		=> 'برترین انجمن ها',//'版块排行榜页',
	'ranklist/picture'		=> 'برترین عکس ها',//'图片排行榜页',
	'ranklist/group'		=> 'برترین گروه ها',//'群组排行榜页',
	'ranklist/thread'		=> 'برترین موضوع ها',//'帖子排行榜页',
	'ranklist/member'		=> 'برترین کاربران',//'用户排行榜页',
	'other_page'			=> 'non-DIY modules',//'非DIY模块',
	'upload'			=> 'آپلود',//'上传',
	'remote'			=> 'Remote',//'远程',
	'portal_index'			=> 'سردر',//'门户首页',
	'portal_topic_blue'		=> 'پوسته ابی',//'蓝色调专题',
	'portal_topic_green'		=> 'پوسته سبز',//'绿色调专题',
	'portal_topic_grey'		=> 'پوسته خاکستری',//'灰色调专题',
	'portal_topic_red'		=> 'پوسته قرمز',//'红色调专题',

	'itemtypename0'			=> 'Auto',//'自动',
	'itemtypename1'			=> '<span style="color: #FF0000">Fixed</span>',//'<span style="color: #FF0000">固定</span>',
	'itemtypename2'			=> '<span style="color: #00BFFF">ویرایش</span>',//'<span style="color: #00BFFF">编辑</span>',
	'itemtypename3'			=> '<span style="color: #0000FF">Push</span>',//'<span style="color: #0000FF">推送</span>',

);