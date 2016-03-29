<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_post.php by Valery Votintsev, codersclub.org
 *	Translated to Persian by Discuz.ir
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'post_name'				=> 'وظیفه ارسال انجمن',//'论坛帖子类任务',
	'post_desc'				=> 'ساخت ارسال برای تکمیل فرایند.فعال کردن شرایط انجمن.',//'通过发帖回帖完成任务，活跃论坛的氛围',
	'post_complete_var_act'			=> 'نوع',//'动作',
	'post_complete_var_act_newthread'	=> 'ساخت یک موضوع جدید',//'发新主题',
	'post_complete_var_act_newreply'	=> 'ارسال پاسخ جدید',//'发新回复',
	'post_complete_var_act_newpost'		=> 'ارسال موضوع /پاس جدید',//'发新主题/回复',
	'post_complate_var_forumid'		=> 'مقصد انجمن',//'版块限制',
	'post_complate_var_forumid_comment'	=> 'انجمنی را که کاربران بتوانند در آن فرایند را تکمیل کنند تنظیم کنید',//'设置会员只能在某个版块完成任务',
	'post_complate_var_threadid'		=> 'مقد موضوعات',//'回复指定主题',
	'post_complate_var_threadid_comment'	=> 'ID موضوعات که در آن کاربران می توانند  فرایند را در آن تکمیل کنند را وارد کنید',//'设置会员只有回复该主题才能完成任务，请填写主题的 TID',
	'post_complate_var_author'		=> 'مقصد نویسنده',//'回复指定作者',
	'post_complate_var_author_comment'	=> 'تنظیم نام نویسنده، پاسخ به موضوعات فقط برای تکمیل فرایند.',//'设置会员只有回复该作者发表的主题才能完成任务，请填写作者的用户名',
	'post_complete_var_num'			=> 'حداقل  تعداد دفعات برای انجام عمل',//'执行动作次数下限',
	'post_complete_var_num_comment'		=> 'کاربران خداقل برای انجام این کار به اقدام مناسب نیاز دارند',//'会员需要执行相应动作的最少次数',
	'post_complete_var_time'		=> 'محدودیت زمان (ساعت)',//'时间限制(小时)',
	'post_complete_var_time_comment'	=> 'Set the time restrictions to comlete the task. If a member can not complete the task in this time range, the task marked as failed and no award given. Set to 0 or leave blank for no limits.',//'设置会员从申请任务到完成任务的时间限制，会员在此时间内未能完成任务则不能领取奖励并标记任务失败，0 或留空为不限制',

	'task_complete_forumid'			=> 'در انجمن{value} ',//'在版块 {value} ',
	'task_complete_act_newthread'		=> 'ساختن {num} موضوع جدید.',//'题发新主 {num} 次',
	'task_complete_act_newpost'		=> 'ارسال  پاسخ/موضوع جدید {num} دفعه.',//'发新主题/回复 {num} 次',
	'task_complete_act_newreply_thread'	=> 'دفعه "{value}" {num} پاسخ به موضوعات.',//'在“{value}”回复主题 {num} 次',
	'task_complete_act_newreply_author'	=> 'Replied the thread of "{value}" {num} times.',//'回复作者“{value}”的主题 {num} 次',
);

