<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_notification.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(

	'type_wall' => 'ຝາກຂໍ້ຄວາມ',
	'type_piccomment' => 'ຄວາມຄິດເຫັນໃນຮູບພາບ',
	'type_blogcomment' => 'ຄວາມຄິດເຫັນໃນບລ໋ອກ',
	'type_clickblog' => 'ຄວາມຮູ້ສຶກໃນບລ໋ອກ',
	'type_clickarticle' => 'ຄວາມຮູ້ສຶກໃນບົດຄວາມ',
	'type_clickpic' => 'ຄວາມຮູ້ສຶກໃນຮູບພາບ',
	'type_sharecomment' => 'ຄວາມຄິດເຫັນໃນຂໍ້ມູນທີ່ນຳມາແບ່ງປັນ',
	'type_doing' => 'ທັກທາຍ',
	'type_friend' => 'ໝູ່',
	'type_credit' => 'ເງິນ',
	'type_bbs' => 'ເວັບບອດ',
	'type_system' => 'ລະບົບ',
	'type_thread' => 'ກະທູ້',
	'type_task' => 'ກິດຈະກຳ',
	'type_group' => 'ກຸ່ມ',

	'mail_to_user' => 'ຂໍ້ຄວາມໃໝ່',
	'showcredit' => '{actor} ສະເໜີ {credit} ກີບ ເພື່ອຈັດອັນດັບໃຫ້ກັບເຈົ້າ ສະໜັບສະໜູນການຈັດອັນດັບໄດ້ທີ່ <a href="misc.php?mod=ranklist&type=member" target="_blank">ລາຍການຈັດອັນດັບ</a>',
	'share_space' => '{actor} ແບ່ງປັນໂປຣໄຟຣຂອງເຈົ້າ',
	'share_blog' => '{actor} ແບ່ງປັນບລ໋ອກ <a href="{url}" target="_blank">{subject}</a> ຂອງເຈົ້າ',
	'share_album' => '{actor} ແບ່ງປັນອະລະບ້ຳ <a href="{url}" target="_blank">{albumname}</a> ຂອງເຈົ້າ',
	'share_pic' => '{actor} ແບ່ງປັນ<a href="{url}" target="_blank"> ຮູບພາບ</a>ໃນອະລະບ້ຳ {albumname} ຂອງເຈົ້າ',
	'share_thread' => '{actor} ແບ່ງປັນກະທູ້ <a href="{url}" target="_blank">{subject}</a> ຂອງເຈົ້າ',
	'share_article' => '{actor} ແບ່ງປັນບົດຄວາມ <a href="{url}" target="_blank">{subject}</a> ຂອງເຈົ້າ',
	'magic_present_note' => 'ມອບໄອເທັມ <a href="{url}" target="_blank">{name}</a> ໃຫ້ກັບເຈົ້າ',
	'friend_add' => '{actor} ໄດ້ເພີ່ມເຈົ້າເປັນໝູ່ຮຽບຮ້ອຍແລ້ວ',
	'friend_request' => '{actor} ຂໍເພີ່ມເຈົ້າເປັນໝູ່ {note}&nbsp;&nbsp;<a onclick="showWindow(this.id, this.href, \'get\', 0);" class="xw1" id="afr_{uid}" href="{url}">ຮັບເປັນໝູ່</a>',
	'doing_reply' => '{actor} ຕອບກັບ <a href="{url}" target="_blank">ຂໍ້ຄວາມທັກທາຍ</a> ຂອງເຈົ້າ',
	'wall_reply' => '{actor} ຕອບກັບ <a href="{url}" target="_blank">ຂໍ້ຄວາມ</a> ຂອງເຈົ້າ',
	'pic_comment_reply' => '{actor} ຕອບກັບ <a href="{url}" target="_blank">ຄວາມຄິດເຫັນໃນຮູບພາບ</a> ຂອງເຈົ້າ',
	'blog_comment_reply' => '{actor} ຕອບກັບ <a href="{url}" target="_blank">ຄວາມຄິດເຫັນໃນບລ໋ອກ</a> ຂອງເຈົ້າ',
	'share_comment_reply' => '{actor} ຕອບກັບ <a href="{url}" target="_blank">ຄວາມຄິດເຫັນໃນການແບ່ງປັນ</a> ຂອງເຈົ້າ',
	'wall' => '{actor} ຝາກຂໍ້ຄວາມເຖິງເຈົ້າ <a href="{url}" target="_blank">ອ່ານຂໍ້ຄວາມ</a>',
	'pic_comment' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນ <a href="{url}" target="_blank">ຮູບພາບ</a> ຂອງເຈົ້າ',
	'blog_comment' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນ <a href="{url}" target="_blank">{subject}</a> ຂອງເຈົ້າ',
	'share_comment' => '{actor} ສະແດງຄວາມຄິດເຫັນໃນ <a href="{url}" target="_blank">ແບ່ງປັນ</a> ຂອງເຈົ້າ',
	'click_blog' => '{actor} ສະແດງຄວາມຮູ້ສຶກໃນບລ໋ອກ <a href="{url}" target="_blank">{subject}</a> ຂອງເຈົ້າ',
	'click_pic' => '{actor} ສະແດງຄວາມຮູ້ສຶກໃນ <a href="{url}" target="_blank">ຮູບພາບ</a> ຂອງເຈົ້າ',
	'click_article' => '{actor} ສະແດງຄວາມຮູ້ສຶກໃນບົດຄວາມ <a href="{url}" target="_blank">{subject}</a> ຂອງເຈົ້າ',
	'show_out' => '{actor} ເຂົ້າຊົມໂປຣໄຟຣຂອງເຈົ້າ ແລະໄດ້ຮັບເງິນສຸດທ້າຍໄປແລ້ວ',
	'puse_article' => 'ຂໍສະແດງຄວາມຍິນດີ ກະທູ້<a href="{url}" target="_blank">{subject}</a>ຂອງເຈົ້າຖືກນຳໄປເປັນບົດຄວາມ <a href="{newurl}" target="_blank">ຄລິກເພື່ອເບິ່ງ</a>',

	'myinvite_request' => 'ຂໍ້ຄວາມແອັບພິເກຊັ່ນໃໝ່<a href="home.php?mod=space&do=notice&view=userapp">ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງໜ້າຂໍ້ມູນແອັບພິເກຊັ່ນທີ່ກ່ຽວຂ້ອງ</a>',


	'group_member_join' => '{actor} ໄດ້ເຂົ້າຮ່ວມກຸ່ມ <a href="forum.php?mod=group&fid={fid}" target="_blank">{groupname}</a> ຂອງເຈົ້າ ຂະນະນີ້ຢູ່ໃນລະຫວ່າງຖ້າການກວດສອບ ກະລຸນາໄປທີ່<a href="{url}" target="_blank">ການຈັດການກຸ່ມ</a> ເພື່ອດຳເນີນການກວດສອບ',
	'group_member_invite' => '{actor} ເຊີນເຈົ້າເຂົ້າຮ່ວມກຸ່ມ <a href="forum.php?mod=group&fid={fid}" target="_blank">{groupname}</a> <a href="{url}" target="_blank">ກົດທີ່ນີ້ເພື່ອເຂົ້າຮ່ວມ</a>',
	'group_member_check' => 'ເຈົ້າໄດ້ຜ່ານການກວດສອບແລະສາມາດເຂົ້າຮ່ວມກຸ່ມ <a href="{url}" target="_blank">{groupname}</a> ໄດ້ແລ້ວ ກະລຸນາ <a href="{url}" target="_blank">ຄລິກເພື່ອເຂົ້າຊົມ</a>',
	'group_member_check_failed' => 'ເຈົ້າບໍ່ຜ່ານການກວດສອບບໍ່ສາມາດເຂົ້າຮ່ວມກຸ່ມ <a href="{url}" target="_blank">{groupname}</a>',
	'group_mod_check' => 'ສ້າງກຸ່ມຂອງເຈົ້າ <a href="{url}" target="_blank">{groupname}</a> ອະນຸມັດແລ້ວ ກະລຸນາ<a href="{url}" target="_blank">ຄລິກບ່ອນນີ້ເພື່ອເຂົ້າຊົມ</a>',

	'reason_moderate' => '{actor} {modaction} ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_merge' => '{actor} {modaction} ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_delete_post' => '{actor} ລຶບກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_delete_comment' => '{actor} ລຶບຕອບກັບຂອງເຈົ້າໃນກະທູ້ <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank">{subject}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_ban_post' => '{actor} {modaction} ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_warn_post' => '{actor} {modaction} ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ {actor} {modaction}<br />
				ຫ້າມໂພສເປັນເວລາ {warningexpiration} ມື້ ເນື່ອງຈາກຖືກເຕືອນຕໍ່ເນື່ອງທັງໝົດ {warninglimit} ເທື່ອ ເຈົ້າຈະຖືກຫ້າມໂພສໂດຍອັດຕະໂນມັດເປັນເວລາ {warningexpiration} ມື້<br />
				ຮອດຕອນນີ້ ເຈົ້າຖືກຕັກເຕືອນ {authorwarnings} ເທື່ອ
				<div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_move' => '{actor} ຍ້າຍກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າໄປທີ່ <a href="forum.php?mod=forumdisplay&fid={tofid}" target="_blank">{toname}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_copy' => '{actor} ຄັດລອກກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າໄປທີ່ <a href="forum.php?mod=viewthread&tid={threadid}" target="_blank">{subject}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_remove_reward' => '{actor} ປົດກະທູ້ລາງວັນ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_stamp_update' => '{actor} ຕິດສະແຕັມ {stamp} ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_stamp_delete' => '{actor} ລອກສະແຕັມອອກຈາກກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_stamplist_update' => '{actor} ໃສ່ໄອຄອນ {stamp} ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_stamplist_delete' => '{actor} ລຶບໄອຄອນອອກຈາກກະທູ້  <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_stickreply' => '{actor} ປັກໝຸດຕອບກັບຂອງເຈົ້າໃນກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_stickdeletereply' => '{actor} ປົດໝຸດຕອບກັບຂອງເຈົ້າໃນກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_quickclear' => '{actor} ໄດ້ລຶບ {cleartype} ອອກ <div class="quote"><blockquote>{reason}</blockquote></div>',

	'reason_live_update' => '{actor} ໄດ້ແນະນຳກະທູ້ຂອງເຈົ້າໃນ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',
	'reason_live_cancle' => '{actor} ໄດ້ຍົກເລີກແນະນຳກະທູ້ຂອງເຈົ້າໃນ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'modthreads_delete' => 'ກະທູ້ {threadsubject} ຂອງເຈົ້າ ບໍ່ຜ່ານການກວດສອບແລະຕອນນີ້ໄດ້ຖືກລຶບອອກໄປແລ້ວ!',

	'modthreads_delete_reason' => 'ກະທູ້ {threadsubject} ຂອງເຈົ້າ ບໍ່ຜ່ານການກວດສອບແລະຕອນນີ້ໄດ້ຖືກລຶບອອກໄປແລ້ວ! <div class="quote"><blockquote>{reason}</blockquote></div>',
	'modthreads_validate' => 'ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{threadsubject}</a> ຂອງເຈົ້າ ຜ່ານການກວດສອບແລະຕອນນີ້ຖືກໂພສລົງໄປແລ້ວ! &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງກະທູ້ &rsaquo;</a>',

	'modreplies_delete' => 'ການໂພສຕອບກັບຂອງເຈົ້າບໍ່ຜ່ານການກວດສອບ ແລະໄດ້ຖືກລຶບອອກໄປແລ້ວ! <p class="summary">ເນື້ອຫາ: <span>{post}</span></p>',

	'modreplies_validate' => 'ການໂພສຕອບກັບຂອງເຈົ້າຜ່ານການກວດສອບແລ້ວ! &nbsp; <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank" class="lit">ເບິ່ງເນື້ອຫາ &rsaquo;</a> <p class="summary">ເນື້ອຫາ: <span>{post}</span></p>',

	'transfer' => 'ເຈົ້າໄດ້ຮັບເງິນຈາກ {actor} ຜ່ານການໂອນເປັນຈຳນວນ {credit} &nbsp; <a href="home.php?mod=spacecp&ac=credit&op=log&suboperation=creditslog" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>
<p class="summary">{actor} ຝາກຂໍ້ຄວາມເຖິງເຈົ້າວ່າ: <span>{transfermessage}</span></p>',

	'addfunds' => 'ການຮ້ອງຂໍແລກປ່ຽນເງິນຂອງເຈົ້າຮຽບຮ້ອຍ ລະບົບໄດ້ສົ່ງລາຍງານການແລກປ່ຽນມາຫາຂໍ້ຄວາມສ່ວນຕົວຂອງເຈົ້າ 
				&nbsp; <a href="home.php?mod=spacecp&ac=credit&op=base" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>
				<p class="summary">ໝາຍເລກ: <span>{orderid}</span></p>
				<p class="summary">ຄ່າໃຊ້ຈ່າຍ: <span>₭ {price}  ກີບ</span></p>
				<p class="summary">ລາຍຮັບ: <span>{value}</span></p>',

	'rate_reason' => '{actor} ໃຫ້ຄະແນນກະທູ້ <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ {ratescore} <div class="quote"><blockquote>{reason}</blockquote></div>',

	'recommend_note_post' => 'ຂໍສະແດງຄວາມຍິນດີ ຂໍ້ຄວາມຂອງເຈົ້າ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ໄດ້ຖືກຕັ້ງເປັນໂພສແນະນຳແລ້ວ',

	'rate_removereason' => '{actor} ລຶບຄະແນນກະທູ້ <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank">{subject}</a> ຂອງເຈົ້າ {ratescore} <div class="quote"><blockquote>{reason}</blockquote></div>',

	'trade_seller_send' => '<a href="home.php?mod=space&uid={buyerid}" target="_blank">{buyer}</a> ຊື້ສິນຄ້າ <a href="forum.php?mod=trade&orderid={orderid}" target="_blank">{subject}</a> ຂອງເຈົ້າ ຜູ້ຊື້ໄດ້ຈ່າຍເງິນແລ້ວ ກຳລັງຖ້າການຈັດສົ່ງສິນຄ້າຂອງເຈົ້າ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'trade_buyer_confirm' => 'ເຈົ້າໄດ້ຊື້ສິນຄ້າ <a href="forum.php?mod=trade&orderid={orderid}" target="_blank">{subject}</a>, <a href="home.php?mod=space&uid={sellerid}" target="_blank">{seller}</a> ຜູ້ຂາຍໄດ້ສົ່ງສິນຄ້າໄປແລ້ວ ກຳລັງຖ້າການຢືນຢັນການຮັບສິນຄ້າ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'trade_fefund_success' => 'ສິນຄ້າ <a href="forum.php?mod=trade&orderid={orderid}" target="_blank">{subject}</a> ມີການຄືນເງິນຮຽບຮ້ອຍແລ້ວ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'trade_success' => 'ສິນຄ້າ <a href="forum.php?mod=trade&orderid={orderid}" target="_blank">{subject}</a> ມີການຊື້ຂາຍປະສົບຄວາມສຳເລັດ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'trade_order_update_sellerid' => 'ຜູ້ຂາຍ <a href="home.php?mod=space&uid={sellerid}" target="_blank">{seller}</a> ປັບປ່ຽນສິນຄ້າ <a href="forum.php?mod=trade&orderid={orderid}" target="_blank">{subject}</a> ແລະລາຍລະອຽດຕ່າງໆ ກະລຸນາກວດສອບ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'trade_order_update_buyerid' => 'ຜູ້ຊື້ <a href="home.php?mod=space&uid={buyerid}" target="_blank">{buyer}</a> ປັບປ່ຽນສິນຄ້າ <a href="forum.php?mod=trade&orderid={orderid}" target="_blank">{subject}</a> ແລະລາຍລະອຽດຕ່າງໆ ກະລຸນາກວດສອບ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'eccredit' => '{actor} ການປະເມີນສິນຄ້າຂອງເຈົ້າ &nbsp; <a href="forum.php?mod=trade&orderid={orderid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'activity_notice' => '{actor} ສະໝັກເຂົ້າຮ່ວມກິດຈະກຳຂອງເຈົ້າ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ກະລຸນາກວດສອບ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'activity_apply' => '{actor} ຜູ້ສະໜັບສະໜູນກິດຈະກຳ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ອະນຸຍາດໃຫ້ເຈົ້າເຂົ້າຮ່ວມໃນກິດຈະກຳນີ້ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'activity_replenish' => '{actor} ຜູ້ສະໜັບສະໜູນກິດຈະກຳ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ແຈ້ງຂໍ້ມູນທີ່ເຈົ້າຕ້ອງໃຊ້ດຳເນີນການໃນການສະໝັກເຂົ້າຮ່ວມ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'activity_delete' => '{actor} ຜູ້ສະໜັບສະໜູນກິດຈະກຳ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ປະຕິເສດການຂໍເຂົ້າຮ່ວມກິດຈະກຳຂອງເຈົ້າ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}"  target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'activity_cancel' => '{actor} ຍົກເລີກການມີສ່ວນຮ່ວມໃນ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ກິດຈະກຳ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}"  target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a> <div class="quote"><blockquote>{reason}</blockquote></div>',

	'activity_notification' => '{actor} ຜູ້ສະໜັບສະໜູນກິດຈະກຳ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a>ສົ່ງການແຈ້ງເຕືອນ&nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດກິດຈະກຳ &rsaquo;</a> <div class="quote"><blockquote>{msg}</blockquote></div>',

	'reward_question' => 'ເຈົ້າໄດ້ຮັບລາງວັນໃນ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a>ເນື່ອງຈາກ {actor} ເລືອກຄຳຕອບ ຂອງເຈົ້າ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'reward_bestanswer' => '{actor} ເລືອກຂໍ້ຄວາມຕອບກັບຂອງເຈົ້າໃນ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ເປັນຄຳຕອບທີ່ຖືກຕ້ອງ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'reward_bestanswer_moderator' => 'ຄຳຕອບຂອງເຈົ້າໃນກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ໄດ້ຮັບເລືອກເປັນຄຳຕອບທີ່ດີທີ່ສຸດ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'comment_add' => '{actor} ສະແດງຄວາມຄິດເຫັນໂພສຂອງເຈົ້າໃນກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> &nbsp; <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

	'reppost_noticeauthor' => '{actor} ຕອບກະທູ້ <a href="forum.php?mod=redirect&goto=findpost&ptid={tid}&pid={pid}" target="_blank">{subject}</a> &nbsp; <a href="forum.php?mod=redirect&goto=findpost&pid={pid}&ptid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ</a>',

	'task_reward_credit' => 'ຂໍສະແດງຄວາມຍິນດີເຈົ້າໄດ້ເຮັດກິດຈະກຳ: <a href="home.php?mod=task&do=view&id={taskid}" target="_blank">{name}</a> ສຳເລັດ ເຈົ້າໄດ້ຮັບເງິນ {creditbonus} &nbsp; <a href="home.php?mod=spacecp&ac=credit&op=base" target="_blank" class="lit">ເບິ່ງເງິນຂອງຂ້ອຍ &rsaquo;</a></p>',

	'task_reward_magic' => 'ຂໍສະແດງຄວາມຍິນດີເຈົ້າໄດ້ເຮັດກິດຈະກຳ: <a href="home.php?mod=task&do=view&id={taskid}" target="_blank">{name}</a>ສຳເລັດ ເຈົ້າໄດ້ຮັບໄອເທັມ <a href="home.php?mod=magic&action=mybox" target="_blank">{rewardtext}</a> {bonus} ອັນ',

	'task_reward_medal' => 'ຂໍສະແດງຄວາມຍິນດີເຈົ້າໄດ້ເຮັດກິດຈະກຳ: <a href="home.php?mod=task&do=view&id={taskid}" target="_blank">{name}</a>ສຳເລັດ ເຈົ້າໄດ້ຮັບຫຼຽນລາງວັນ <a href="home.php?mod=medal" target="_blank">{rewardtext}</a> ສາມາດໃຊ້ໄດ້ເປັນເວລາ {bonus} ມື້',

	'task_reward_medal_forever' => 'ຂໍສະແດງຄວາມຍິນດີ ເຈົ້າໄດ້ເຮັດກິດຈະກຳ: <a href="home.php?mod=task&do=view&id={taskid}" target="_blank">{name}</a> ສຳເລັດສົມບູນ ເຈົ້າໄດ້ຮັບຫຼຽນ <a href="home.php?mod=medal" target="_blank">{rewardtext}</a> ເປັນລາງວັນແບບຖາວອນ',

	'task_reward_invite' => 'ຂໍສະແດງຄວາມຍິນດີເຈົ້າໄດ້ເຮັດກິດຈະກຳ: <a href="home.php?mod=task&do=view&id={taskid}" target="_blank">{name}</a>ສຳເລັດ ເຈົ້າໄດ້ຮັບໂຄສເຊີນຊວນ<a href="home.php?mod=spacecp&ac=invite" target="_blank">ໂຄສເຊີນຊວນ {rewardtext}</a> ສາມາດໃຊ້ໄດ້ເປັນເວລາ {bonus} ມື້',

	'task_reward_group' => 'ຂໍສະແດງຄວາມຍິນດີເຈົ້າໄດ້ເຮັດກິດຈະກຳ: <a href="home.php?mod=task&do=view&id={taskid}" target="_blank">{name}</a>ສຳເລັດ ເຈົ້າໄດ້ເຂົ້າຮ່ວມກຸ່ມ {rewardtext} ເປັນເວລາ {bonus} ມື້ &nbsp; <a href="home.php?mod=spacecp&ac=usergroup" target="_blank" class="lit">ເບິ່ງລະດັບການໃຊ້ງານຂອງກຸ່ມນີ້ &rsaquo;</a>',

	'user_usergroup' => 'ກຸ່ມສະມາຊິກຂອງເຈົ້າໄດ້ອັບເກຣດເປັນ {usergroup} &nbsp; <a href="home.php?mod=spacecp&ac=usergroup" target="_blank" class="lit">ເບິ່ງລະດັບການໃຊ້ງານຂອງກຸ່ມນີ້ &rsaquo;</a>',

	'grouplevel_update' => 'ຂໍສະແດງຄວາມຍິນດີ ກຸ່ມຂອງເຈົ້າ {groupname} ໄດ້ຮັບການອັບເກຣດໄປຫາ {newlevel}',

	'thread_invite' => '{actor} ເຊີນຊວນເຈົ້າ {invitename} <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',
	'blog_invite' => '{actor} ເຊີນເຈົ້າໃຫ້ເບິ່ງບລ໋ອກ <a href="home.php?mod=space&uid={uid}&do=blog&id={blogid}" target="_blank">{subject}</a> &nbsp; <a href="home.php?mod=space&uid={uid}&do=blog&id={blogid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',
	'article_invite' => '{actor} ເຊີນເຈົ້າໃຫ້ເບິ່ງບົດຄວາມ <a href="portal.php?mod=view&aid={aid}" target="_blank">{subject}</a> &nbsp; <a href="portal.php?mod=view&aid={aid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',
	'invite_friend' => 'ຂໍສະແດງຄວາມຍິນດີຊວນໝູ່ສຳເລັດ {actor} ແລະເຈົ້າເປັນໝູ່ກັນແລ້ວ',

	'poke_request' => '<a href="{fromurl}" class="xi2">{fromusername}</a>: <span class="xw0">{pokemsg}&nbsp;</span><a href="home.php?mod=spacecp&ac=poke&op=reply&uid={fromuid}&from=notice" id="a_p_r_{fromuid}" class="xw1" onclick="showWindow(this.id, this.href, \'get\', 0);">ຕອບກັບການສະກິດ</a><span class="pipe">|</span><a href="home.php?mod=spacecp&ac=poke&op=ignore&uid={fromuid}&from=notice" id="a_p_i_{fromuid}" onclick="showWindow(\'pokeignore\', this.href, \'get\', 0);">ບໍ່ສົນໃຈ</a>',

	'profile_verify_error' => '{verify} ປະຕິເສດຂໍ້ມູນຂອງເຈົ້າ ຕ້ອງພິມຂໍ້ມູນຕໍ່ໄປນີ້:<br/>{profile}<br/>ສາເຫດຂອງການປະຕິເສດ:{reason}',
	'profile_verify_pass' => 'ຂໍສະແດງຄວາມຍິນດີ ຂໍ້ມູນທີ່ເຈົ້າພິມຜ່ານການກວດສອບ ກວດສອບຂໍ້ມູນໂດຍ {verify}',
	'profile_verify_pass_refusal' => 'ຂໍອະໄພ, {verify} ປະຕິເສດຂໍ້ມູນທີ່ເຈົ້າພິມ',
	'member_ban_speak' => '{user} ຖືກແບນຫ້າມໂພສ ເປັນເວລາ: {day} ມື້ (ຖ້າເປັນ 0 ແມ່ນຖືກແບນຖາວອນ) ເຫດຜົນ: {reason}',
	'member_ban_visit' => '{user} ຖືກແບນຫ້າມເຂົ້າຊົມ ເປັນເວລາ: {day} ມື້ (ຖ້າເປັນ 0 ແມ່ນຖືກແບນຖາວອນ) ເຫດຜົນ: {reason}',
	'member_ban_status' => '{user} ຖືກແບນຫ້າມການເຂົ້າເຖິງ: {reason}',
	'member_follow' => 'ມີສະມາຊິກໄດ້ສະແດງຄວາມຄິດເຫັນໃນຕິດຕາມຈຳນວນ {count} ຂໍ້ຄວາມ <a href="home.php?mod=follow">ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງລາຍລະອຽດ</a>',
	'member_follow_add' => '{actor} ເພີ່ມການຕິດຕາມຂອງເຈົ້າ <a href="home.php?mod=follow&do=follower">ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງລາຍລະອຽດ</a>',

	'member_moderate_invalidate' => 'ການກວດສອບຂໍ້ມູນຂອງເຈົ້າລົ້ມເຫຼວ ກະລຸນາ<a href="home.php?mod=spacecp&ac=profile">ສົ່ງຂໍ້ມູນການສະໝັກສະມາຊິກເພື່ອກວດສອບອີກຄັ້ງ</a><br />ຂໍ້ຄວາມຂອງຜູ້ເບິ່ງແຍງ: <b>{remark}</b>',
	'member_moderate_validate' => 'ບັນຊີສະມາຊິກຂອງເຈົ້າຜ່ານການກວດສອບໄດ້ຮັບການອະນຸມັດແລ້ວ<br />ຂໍ້ຄວາມຂອງຜູ້ເບິ່ງແຍງ: <b>{remark}</b>',
	'member_moderate_invalidate_no_remark' => 'ການກວດສອບຂໍ້ມູນຂອງເຈົ້າລົ້ມເຫຼວ ກະລຸນາ<a href="home.php?mod=spacecp&ac=profile">ສົ່ງຂໍ້ມູນການສະໝັກສະມາຊິກເພື່ອກວດສອບອີກຄັ້ງ</a>',
	'member_moderate_validate_no_remark' => 'ບັນຊີສະມາຊິກຂອງເຈົ້າຜ່ານການກວດສອບໄດ້ຮັບການອະນຸມັດແລ້ວ',
	'manage_verifythread' => 'ມີກະທູ້ໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=threads&dateline=all">ກວດສອບຕອນນີ້</a>',
	'manage_verifypost' => 'ມີໂພສໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=replies&dateline=all">ກວດສອບຕອນນີ້</a>',
	'manage_verifyuser' => 'ມີສະມາຊິກໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=members">ກວດສອບຕອນນີ້</a>',
	'manage_verifyblog' => 'ມີບລ໋ອກໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=blogs">ກວດສອບຕອນນີ້</a>',
	'manage_verifydoing' => 'ມີຄຳທັກທາຍໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=doings">ກວດສອບຕອນນີ້</a>',
	'manage_verifypic' => 'ມີຮູບພາບໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=pictures">ກວດສອບຕອນນີ້</a>',
	'manage_verifyshare' => 'ມີການແບ່ງປັນໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=shares">ກວດສອບຕອນນີ້</a>',
	'manage_verifycommontes' => 'ມີຂໍ້ຄວາມ/ຄວາມເຫັນໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=comments">ກວດສອບຕອນນີ້</a>',
	'manage_verifyrecycle' => 'ຖັງຂີ້ເຫຍື້ອມີກະທູ້ໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=recyclebin">ຈັດການຕອນນີ້</a>',
	'manage_verifyrecyclepost' => 'ຖັງຂີ້ເຫຍື້ອມີໂພສໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=recyclebinpost">ຈັດການຕອນນີ້</a>',
	'manage_verifyarticle' => 'ມີບົດຄວາມໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=articles">ກວດສອບຕອນນີ້</a>',
	'manage_verifymedal' => 'ມີຫຼຽນລາງວັນໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=medals&operation=mod">ກວດສອບຕອນນີ້</a>',
	'manage_verifyacommont' => 'ມີຄວາມຄິດເຫັນໃໝ່ໃນບົດຄວາມທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=articlecomments">ກວດສອບຕອນນີ້</a>',
	'manage_verifytopiccommont' => 'ມີຄວາມຄິດເຫັນໃໝ່ໃນຫົວຂໍ້ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=moderate&operation=topiccomments">ກວດສອບຕອນນີ້</a>',
	'manage_verify_field' => 'ມີການພິມ {verifyname} ໃໝ່ທີ່ຖ້າການກວດສອບ <a href="admin.php?action=verify&operation=verify&do={doid}">ຈັດການຕອນນີ້</a>',
	'system_notice' => '{subject}<p class="summary">{message}</p>',
	'system_adv_expiration' => 'ໂຄສະນາເວັບໄຊຂອງເຈົ້າຈະໝົດອາຍຸພາຍໃນ {day} ມື້, ກະລຸນາຮີບດຳເນີນການ: <br />{advs}',
	'report_change_credits' => '{actor} ຈັດການກັບການລາຍງານຂອງເຈົ້າ {creditchange} {msg}',
	'at_message' => '<a href="home.php?mod=space&uid={buyerid}" target="_blank">{buyer}</a> ໄດ້ເວົ້າເຖິງເຈົ້າໃນໂພສຂອງ <a href="forum.php?mod=redirect&goto=findpost&ptid={tid}&pid={pid}" target="_blank">{subject}</a> ว่า: <div class="quote"><blockquote>{message}</blockquote></div><a href="forum.php?mod=redirect&goto=findpost&ptid={tid}&pid={pid}" target="_blank">ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງລາຍລະອຽດ</a>',
	'new_report' => 'ມີການລາຍງານເຂົ້າມາໃໝ່ <a href="admin.php?action=report" target="_blank">ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງແລະດຳເນີນການລາຍງານນີ້</a>',
	'new_post_report' => 'ມີການລາຍງານໃໝ່ທີ່ຖ້າການກວດສອບ <a href="forum.php?mod=modcp&action=report&fid={fid}" target="_blank">ຄລິກບ່ອນນີ້ເພື່ອເຂົ້າສູ່ສູນຈັດການລະບົບ</a>',
	'magics_receive' => '{actor} ໄດ້ມອບໄອເທັມ {magicname} ໃຫ້ກັບເຈົ້າ
			<p class="summary">ແລະ {actor} ໄດ້ຝາກຂໍ້ຄວາມເຖິງເຈົ້າ: <span>{msg}</span></p>
			<p class="mbn"><a href="home.php?mod=magic" target="_blank">ກັບໄປຫາລາຍການໄອເທັມ</a>
			<span class="pipe">|</span><a href="home.php?mod=magic&action=mybox" target="_blank">ເບິ່ງກ່ອງໄອເທັມຂອງຂ້ອຍ</a></p>',
	'invite_collection' => '{actor} ເຊີນເຈົ້າເຂົ້າຮ່ວມໃນຄັງກະທູ້  <a href="forum.php?mod=collection&action=view&ctid={ctid}">{collectionname}</a><br /> <a href="forum.php?mod=collection&action=edit&op=acceptinvite&ctid={ctid}&dateline={dateline}">ຍອມຮັບຄຳເຊີນ</a>',
	'collection_removed' => 'ຄັງກະທູ້ທີ່ເຈົ້າເຂົ້າຮ່ວມຕອນນີ້  <a href="forum.php?mod=collection&action=view&ctid={ctid}">{collectionname}</a> ໄດ້ຖືກລຶບອອກໂດຍ {actor}',
	'exit_collection' => 'ເຈົ້າໄດ້ເຂົ້າຮ່ວມຄັງກະທູ້ກ່ອນໜ້ານີ້ຢູ່ແລ້ວ  <a href="forum.php?mod=collection&action=view&ctid={ctid}">{collectionname}</a>',
	'collection_becommented' => 'ເຈົ້າໄດ້ເຂົ້າສະແດງຄຳເຫັນຈາກຄັງກະທູ້ນີ້  <a href="forum.php?mod=collection&action=view&ctid={ctid}">{collectionname}</a> ຈາກການສະແດງຄວາມຄິດເຫັນໃໝ່',
	'collection_befollowed' => 'ມີສະມາຊິກໄດ້ຕິດຕາມຄັງກະທູ້ <a href="forum.php?mod=collection&action=view&ctid={ctid}">{collectionname}</a> ຂອງເຈົ້າ',
	'collection_becollected' => 'ຂໍສະແດງຄວາມຍິນດີ! ກະທູ້ <a href="forum.php?mod=viewthread&tid={tid}">{threadname}</a> ຂອງເຈົ້າໄດ້ຮັບການຈັດເກັບໃນຄັງກະທູ້ແລ້ວ  <a href="forum.php?mod=collection&action=view&ctid={ctid}">{collectionname}</a>',

	'pmreportcontent'		=> '{pmreportcontent}',

	'thread_hidden' => 'ກະທູ້ຂອງເຈົ້າ <a href="forum.php?mod=viewthread&tid={tid}" target="_blank">{subject}</a> ຖືກຕັ້ງສະຖານະວ່າເປັນສະແປັມຈາກສະມາຊິກຫຼາຍຄົນ ເຮັດໃຫ້ກະທູ້ຖືກເຊື່ອງໄວ້ &nbsp; <a href="forum.php?mod=viewthread&tid={tid}" target="_blank" class="lit">ເບິ່ງລາຍລະອຽດ &rsaquo;</a>',

);

