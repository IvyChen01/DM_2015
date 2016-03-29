<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_feed.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(

	'feed_blog_password' => '{actor} ຂຽນບລ໋ອກ {subject} ເກັບໄວ້ເປັນບລ໋ອກສ່ວນຕົວ',
	'feed_blog_title' => '{actor} ຂຽນບລ໋ອກໃໝ່',
	'feed_blog_body'	=> '<b>{subject}</b><br />{summary}',//'<b>{subject}</b><br />{summary}',
	'feed_album_title' => '{actor} ອັບເດດອະລະບ້ຳ',
	'feed_album_body' => '<b>{album}</b><br />ທັງໝົດ {picnum} ພາບ',
	'feed_pic_title' => '{actor} ອັບໂຫຼດພາບໃໝ່',
	'feed_pic_body' => '{title}',



	'feed_poll' => '{actor} ສ້າງສຳຫຼວດໃໝ່',

	'feed_comment_space' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນໂປຣໄຟຣຂອງ {touser}',
	'feed_comment_image' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນຮູບພາບຂອງ {touser}',
	'feed_comment_blog' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນບລ໋ອກ {blog} ຂອງ {touser}',
	'feed_comment_poll' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນສຳຫຼວດ {poll} ຂອງ {touser}',
	'feed_comment_event' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນກິດຈະກຳ {event} ຂອງ {touser}',
	'feed_comment_share' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນການແບ່ງປັນ {share} ຂອງ {touser}',

	'feed_showcredit' => '{actor} ສະເໜີ {credit} ກີບ ເພື່ອຈັດອັນດັບໃຫ້ກັບ {fusername} ຮ່ວມຈັດອັນດັບໄດ້ທີ່<a href="misc.php?mod=ranklist&type=member" target="_blank">ລາຍການຈັດອັນດັບ</a>',
	'feed_showcredit_self' => '{actor} ສະເໜີ {credit} ກີບ ເພື່ອຈັດອັນດັບໃຫ້ຕົວເອງ ຮ່ວມຈັດອັນດັບໄດ້ທີ່<a href="misc.php?mod=ranklist&type=member" target="_blank">ລາຍການຈັດອັນດັບ</a>',
	'feed_doing_title' => '{actor}: {message}',
	'feed_friend_title' => '{actor} และ {touser} ເປັນໝູ່ກັນແລ້ວ',



	'feed_click_blog' => '{actor} ສະແດງຄວາມຮູ້ສຶກ “{click}” ໃນບລ໋ອກ {subject} ຂອງ {touser}',
	'feed_click_thread' => '{actor} ສະແດງຄວາມຮູ້ສຶກ “{click}” ໃນຫົວຂໍ້ {subject} ຂອງ {touser}',
	'feed_click_pic' => '{actor} ສະແດງຄວາມຮູ້ສຶກ “{click}” ໃນຮູບພາບຂອງ {touser}',
	'feed_click_article' => '{actor} ສະແດງຄວາມຮູ້ສຶກ “{click}” ໃນບົດຄວາມ {subject} ຂອງ {touser}',


	'feed_task' => '{actor} ເຂົ້າຮ່ວມກິດຈະກຳ {task} ສຳເລັດແລະຮັບລາງວັນຮຽບຮ້ອຍແລ້ວ',
	'feed_task_credit' => '{actor} ເຂົ້າຮ່ວມກິດຈະກຳ {task} ສຳເລັດແລະຮັບລາງວັນ {credit} ກີບ',

	'feed_profile_update_base' => '{actor} ອັບເດດຂໍ້ມູນພື້ນຖານຂອງເຂົາໃໝ່',
	'feed_profile_update_contact' => '{actor} ອັບເດດຂໍ້ມູນທີ່ຕິດຕໍ່ຂອງເຂົາໃໝ່',
	'feed_profile_update_edu' => '{actor} ອັບເດດຂໍ້ມູນການຮຽນຂອງເຂົາໃໝ່',
	'feed_profile_update_work' => '{actor} ອັບເດດຂໍ້ມູນການເຮັດວຽກຂອງເຂົາໃໝ່',
	'feed_profile_update_info' => '{actor} ອັບເດດຂໍ້ມູນສ່ວນຕົວຂອງເຂົາໃໝ່',
	'feed_profile_update_bbs' => '{actor} ອັບເດດຂໍ້ມູນສ່ວນຕົວ',
	'feed_profile_update_verify' => '{actor} ອັບເດດຂໍ້ມູນກ່ຽວກັບການຮັບຮອງຂອງເຂົາໃໝ່',

	'feed_add_attachsize' => '{actor} ແລກ {credit} ກັບຄວາມບັນຈຸພື້ນທີ່ເກັບຟາຍແນບ {size} ເພື່ອສາມາດອັບໂຫຼດຮູບພາບໄດ້ຫຼາຍຂື້ນ (<a href="home.php?mod=spacecp&ac=credit&op=addsize">ຂ້ອຍຕ້ອງການແລກປ່ຽນ</a>)',

	'feed_invite' => '{actor} ຍອມຮັບຄຳເຊີນ ແລະເປັນໝູ່ກັບ {username}',

	'magicuse_thunder_announce_title' => '<strong>{username} ໂປຣໂໝດໂປຣໄຟຣ</strong>',
	'magicuse_thunder_announce_body' => 'ສະບາຍດີ ຂ້ອຍຢາກຈະຊວນໝູ່ໄປເຂົ້າຊົມໂປຣໄຟຣຂອງຂ້ອຍ<br /><a href="home.php?mod=space&uid={uid}" target="_blank">ຄລິກບ່ອນນີ້ເພື່ອເຂົ້າຊົມໂປຣໄຟຮຂອງຂ້ອຍ</a>',


	'feed_thread_title' =>			'{actor} ຕັ້ງກະທູ້ໃໝ່',
	'feed_thread_message'		=> '<b>{subject}</b><br />{message}',//'<b>{subject}</b><br />{message}',

	'feed_reply_title' =>			'{actor} ຕອບກະທູ້ {subject} ຂອງ {author} ',
	'feed_reply_title_anonymous' =>		'{actor} ຕອບກະທູ້ {subject}',
	'feed_reply_message'		=> '',

	'feed_thread_poll_title' =>		'{actor} ສ້າງສຳຫຼວດໃໝ່',
	'feed_thread_poll_message'	=> '<b>{subject}</b><br />{message}',

	'feed_thread_votepoll_title' =>		'{actor} ເຈົ້າຮ່ວມໂຫວດສຳຫຼວດ {subject}',
	'feed_thread_votepoll_message'	=> '',

	'feed_thread_goods_title' =>		'{actor} ຂາຍສິນຄ້າໃໝ່',
	'feed_thread_goods_message_1' =>	'<b>{itemname}</b><br />ລາຄາ {itemprice} ກີບ ເພີ່ມຕື່ມ {itemcredit}{creditunit}',
	'feed_thread_goods_message_2' =>	'<b>{itemname}</b><br />ລາຄາ {itemprice} ກີບ',
	'feed_thread_goods_message_3' =>	'<b>{itemname}</b><br />ລາຄາ {itemcredit}{creditunit}',

	'feed_thread_reward_title' =>		'{actor} ແຈກລາງວັນໃໝ່',
	'feed_thread_reward_message' =>		'<b>{subject}</b><br />ລາງວັນ {rewardprice}{extcredits}',

	'feed_reply_reward_title' =>		'{actor} ຕອບຄຳຖາມ {subject} ຖືກຕ້ອງ ແລະຮັບລາງວັນ',
	'feed_reply_reward_message'	=> '',

	'feed_thread_activity_title' =>		'{actor} ຈັດກິດຈະກຳໃໝ່',
	'feed_thread_activity_message' =>	'<b>{subject}</b><br />ເລີ່ມເວລາ: {starttimefrom}<br />ສະຖານທີ່ຈັດກິດຈະກຳ: {activityplace}<br />{message}',

	'feed_reply_activity_title' =>		'{actor} ສະໝັກເຂົ້າຮ່ວມກິດຈະກຳ {subject}',
	'feed_reply_activity_message' =>	'',

	'feed_thread_debate_title' =>		'{actor} ເປີດປະເດັນໂຕ້ວາທີໃໝ່',
	'feed_thread_debate_message' =>		'<b>{subject}</b><br />ເຫັນນຳ: {affirmpoint}<br />ບໍ່ເຫັນນຳ: {negapoint}<br />{message}',

	'feed_thread_debatevote_title_1' =>	'{actor} ເຂົ້າຮ່ວມໂຕ້ວາທີທີ່ເຫັນນຳໃນ {subject}',
	'feed_thread_debatevote_title_2' =>	'{actor} ເຂົ້າຮ່ວມໂຕ້ວາທີທີ່ບໍ່ເຫັນນຳໃນ {subject}',
	'feed_thread_debatevote_title_3' =>	'{actor} ເຂົ້າຮ່ວມໂຕ້ວາທີທີ່ເປັນກາງໃນ {subject}',
	'feed_thread_debatevote_message_1'	=> '',
	'feed_thread_debatevote_message_2'	=> '',
	'feed_thread_debatevote_message_3'	=> '',

);

