<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_attachmentlist.php by Valery Votintsev, codersclub.org
 *	Translated to Persian by Discuz.ir
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'attachmentlist_name'			=> 'لیست فایل پیوست',//'论坛附件列表',
	'attachmentlist_desc'			=> 'نشان دادن لیست فایل پیوستی',//'论坛附件列表调用',
	'attachmentlist_fids'			=> 'انجمنها',//'所在版块',
	'attachmentlist_fids_comment'		=> 'مجموعه انجمنهایی که میتواند مورد استفاده قرار بگیرد از CTRL برای انتخاب همزمان چند انجمن استفاده کنید',//'设置允许参与图片调用的版块，可以按住 CTRL 多选，全选或全不选均为不做限制',
	'attachmentlist_tids'			=> 'موضوعات ویژه',//'指定主题',
	'attachmentlist_tids_comment'		=> 'آی دی موضوعات را وارد کنید از "," برای جدا کردن استفاده کنید',//'指定主题ID，多个ID之间用逗号分隔',
	'attachmentlist_startrow'		=> 'ردیف آغز',//'起始数据行数',
	'attachmentlist_startrow_comment'	=> 'اگر نیاز دارید ردیف آغز را مسخص کنید عددی را وارد کنید 0 اولین شماره است',//'如需设定起始的数据行数，请输入具体数值，0 为从第一行开始，以此类推',
	'attachmentlist_items'			=> 'ردیفها',//'显示数据条数',
	'attachmentlist_items_comment'		=> 'تعداد ردیفهایی که میخواهید نمایش داده شود را وارد کنید باید 0 یا بیشتر باشد',//'设置一次显示的图片主题条目数，请设置为大于 0 的整数',
	'attachmentlist_titlelength'		=> 'طول عنوان',//'标题长度',
	'attachmentlist_titlelength_comment'	=> 'بیشترین طول عنوان فایل پیوست را وارد کنید',//'设置当附件名称/帖子标题显示的最大长度',
	'attachmentlist_summarylength'		=> 'خلاصه عنوان',//'内容长度',
	'attachmentlist_summarylength_comment'	=> 'اندازه خلاصه عنوان را وارد کنید',//'设置附件介绍/帖子内容显示的最大长度',
	'attachmentlist_maxwidth'		=> 'بالاترین عرض عکس برحسب پیکسل (px)',//'图片最大宽度(像素)',
	'attachmentlist_maxwidth_comment'	=> 'حداکثر اندازه را برای زوم خودکار وارد کنید اگر 0 باشد غیر فعال است',//'设置是否自动缩小或放大图片的尺寸到本设定的宽度，0 为不自动缩放',
	'attachmentlist_maxheight'		=> 'بیشترین ارتفاع بر حسب پیکسل',//'图片最大高度(像素)',
	'attachmentlist_maxheight_comment'	=> 'حداکثر ارتفاع را برای زوم خودکار وارد کنید اگر 0 باشد غیر فعال است',//'设置是否自动缩小或放大图片的尺寸到本设定的高度，0 为不自动缩放',
	'attachmentlist_threadmethod'		=> 'روش پیوست کردن در موضوعات',//'主题方式调用',
	'attachmentlist_threadmethod_comment'	=> 'Select "Yes" will be invoked in accordance with thread attachment, a thread will display an attachment; "No" in accordance with an attachment called',//'选择“是”将按照主题方式调用附件，一个主题显示一个附件；选择“否”将按照附件方式调用',
	'attachmentlist_digest'			=> 'Digest Filter',//'精华帖过滤',
	'attachmentlist_digest_comment'		=> 'Select specific thread range. Note: Select All or None for disable filtering',//'设置特定的主题范围。注意: 全选或全不选均为不进行任何过滤',
	'attachmentlist_digest_0'		=> 'General thread',//'普通主题',
	'attachmentlist_digest_1'		=> 'Digest I',//'精华 I',
	'attachmentlist_digest_2'		=> 'Digest II',//'精华 II',
	'attachmentlist_digest_3'		=> 'Digest III',//'精华 III',
	'attachmentlist_special'		=> 'Special thread filter',//'特殊主题过滤',
	'attachmentlist_special_comment'	=> 'Select specific thread range. Note: Select All or None for disable filtering',//'设置特定的主题范围。注意: 全选或全不选均为不进行任何过滤',
	'attachmentlist_special_1'		=> 'Poll thread',//'投票主题',
	'attachmentlist_special_2'		=> 'Market thread',//'商品主题',
	'attachmentlist_special_3'		=> 'Award thread',//'悬赏主题',
	'attachmentlist_special_4'		=> 'Event thread',//'活动主题',
	'attachmentlist_special_5'		=> 'Debate thread',//'辩论主题',
	'attachmentlist_special_0'		=> 'General thread',//'普通主题',
	'attachmentlist_special_reward'		=> 'Reward Filter',//'悬赏主题过滤',
	'attachmentlist_special_reward_comment'	=> 'Select specific types of reward',//'设置特定类型的悬赏主题',
	'attachmentlist_special_reward_0'	=> 'All',//'全部',
	'attachmentlist_special_reward_1'	=> 'Finished',//'已解决',
	'attachmentlist_special_reward_2'	=> 'Active',//'未解决',
	'attachmentlist_dateline'		=> 'Upload time',//'附件上传时间',
	'attachmentlist_dateline_nolimit'	=> 'No limit',//'不限制',
	'attachmentlist_dateline_hour'		=> 'Last hour',//'最近1小时',
	'attachmentlist_dateline_day'		=> 'Last day',//'最近24小时',
	'attachmentlist_dateline_week'		=> 'Last week',//'最近1周',
	'attachmentlist_dateline_month'		=> 'Last month',//'最近1月',
	'attachmentlist_highlight'		=> 'Highlight found words',//'获得高亮值',

);

