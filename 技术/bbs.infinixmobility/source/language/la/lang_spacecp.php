<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_spacecp.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(

	'by' => 'ໂດຍ',
	'tab_space'		=> ' ',

	'share' => 'ແບ່ງປັນ',
	'share_action' => 'ແບ່ງປັນ',

	'pm_comment' => 'ຕອບຄວາມຄິດເຫັນ',
	'pm_thread_about' => 'ສົ່ງຂໍ້ຄວາມສ່ວນຕົວຫາເຈົ້າຈາກກະທູ້ [{subject}]',

	'wall_pm_subject' => 'ສະບາຍດີ ຂ້ອຍໄດ້ຝາກຂໍ້ຄວາມໄວ້ໃນໂປຣໄຟລຂອງເຈົ້າ',
	'wall_pm_message' => 'ຂ້ອຍໄດ້ຝາກຂໍ້ຄວາມໄວ້ໃນໂປຣໄຟລຂອງເຈົ້າ [url=\\1]ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງຂໍ້ຄວາມ[/url]',
	'reward' => 'ລາງວັນ',
	'reward_info' => 'ໂຫວດແລະໄດ້ຮັບ  \\1 ກີບ',
	'poll_separator'	=> ', ',//'"、"',

	'pm_report_content' => '<a href="home.php?mod=space&uid={reporterid}" target="_blank">{reportername}</a>ລາຍງານຂໍ້ຄວາມສ່ວນຕົວ:<br>ຈາກຂໍ້ຄວາມສ່ວນຕົວຂອງ<a href="home.php?mod=space&uid={uid}" target="_blank">{username}</a><br>ເນື້ອຫາ:{message}',
	'message_can_not_send_1' => 'ສົ່ງລົ້ມເຫຼວ ຈຳນວນຄັ້ງໃນການສົ່ງຂໍ້ຄວາມຄົບຕາມທີ່ລະບົບກຳນົດໄວ້ແລ້ວ ພາຍໃນ 24 ຊົ່ວໂມງ ເຈົ້າຈຶ່ງຈະສາມາດສົ່ງຂໍ້ຄວາມໄດ້ອີກຄັ້ງ',
	'message_can_not_send_2' => 'ເຈົ້າສົ່ງຂໍ້ຄວາມຕິດຕໍ່ກັນໄວເກີນໄປ ກະລຸນາຖ້າແປັບໜຶ່ງແລ້ວຄ່ອຍສົ່ງໃໝ່ອີກຄັ້ງ',
	'message_can_not_send_3' => 'ຂໍອະໄພ! ເຈົ້າບໍ່ສາມາດສົ່ງຂໍ້ຄວາມສ່ວນຕົວຈຳນວນຫຼາຍໃຫ້ໝູ່',
	'message_can_not_send_4' => 'ຂໍອະໄພ! ເຈົ້າບໍ່ສາມາດໃຊ້ຟັງຊັ່ນການສົ່ງຂໍ້ຄວາມສ່ວນຕົວ',
	'message_can_not_send_5' => 'ການສົນທະນາກຸ່ມຂອງເຈົ້າຄົບຕາມທີ່ລະບົບກຳນົດໄວ້ແລ້ວ ພາຍໃນ 24 ຊົ່ວໂມງ ເຈົ້າຈຶ່ງຈະສາມາດສົນທະນາກຸ່ມໄໄດ້ອີກຄັ້ງ',
	'message_can_not_send_6' => 'ຜູ້ຮັບບລັອກຂໍ້ຄວາມຂອງເຈົ້າ',
	'message_can_not_send_7' => 'ຜູ້ຮ່ວມສົນທະນາໃນກຸ່ມເກີນຈຳນວນຈຳກັດ',
	'message_can_not_send_8' => 'ຂໍອະໄພ! ເຈົ້າບໍ່ສາມາດສົ່ງຂໍ້ຄວາມໃຫ້ຕົວເອງ',
	'message_can_not_send_9' => 'ຂໍ້ຄວາມວ່າງ ຫຼືຜູ້ຮັບບລັອກຂໍ້ຄວາມຂອງເຈົ້າ',
	'message_can_not_send_10' => 'ການສົນທະນາກຸ່ມຕ້ອງມີຜູ້ຮ່ວມສົນທະນາບໍ່ໜ້ອຍກວ່າ 2 ຄົນ',
	'message_can_not_send_11' => 'ເຊດຊັ່ນບໍ່ມີຢູ່',
	'message_can_not_send_12' => 'ຂໍອະໄພ! ເຈົ້າບໍ່ມີສິດໃນການດຳເນີນການນີ້',
	'message_can_not_send_13' => 'ນີ້ບໍ່ແມ່ນຂໍ້ຄວາມສົນທະນາກຸ່ມ',
	'message_can_not_send_14' => 'ນີ້ບໍ່ແມ່ນຂໍ້ຄວາມສ່ວນຕົວ',
	'message_can_not_send_15' => 'ຂໍ້ມູນບໍ່ຖືກຕ້ອງ',
	'message_can_not_send_16' => 'ເຈົ້າມີການສົ່ງຂໍ້ຄວາມສ່ວນຕົວກາຍຈຳນວນເທື່ອທີ່ມີການກຳນົດໃນຮອບ 24 ຊົ່ວໂມງແລ້ວ',
	'message_can_not_send_onlyfriend' => 'ສະມາຊິກນີ້ຮັບສະເພາະຂໍ້ຄວາມຈາກໝູ່ເທົ່ານັ້ນ',


	'friend_subject' => '<a href="{url}" target="_blank">{username} ສົ່ງຄຳຂໍເພີ່ມເຈົ້າເປັນໝູ່</a>',
	'friend_request_note' => ' ປ.ລ.:{note}',
	'comment_friend' =>'<a href="\\2" target="_blank">\\1 ສົ່ງຂໍ້ຄວາມຫາເຈົ້າ</a>',
	'photo_comment' => '<a href="\\2" target="_blank">\\1 ສະແດງຄວາມຄິດເຫັນກ່ຽວກັບຮູບພາບຂອງເຈົ້າ</a>',
	'blog_comment' => '<a href="\\2" target="_blank">\\1 ສະແດງຄວາມຄິດເຫັນກ່ຽວກັບບລ໋ອກຂອງເຈົ້າ</a>',
	'poll_comment' => '<a href="\\2" target="_blank">\\1 ສະແດງຄວາມຄິດເຫັນກ່ຽວກັບສຳຫຼວດຂອງເຈົ້າ</a>',
	'share_comment' => '<a href="\\2" target="_blank">\\1 ສະແດງຄວາມຄິດເຫັນກ່ຽວກັບການແບ່ງປັນຂອງເຈົ້າ</a>',
	'friend_pm' => '<a href="\\2" target="_blank">\\1 ສົ່ງຂໍ້ຄວາມສ່ວນຕົວຫາເຈົ້າ</a>',
	'poke_subject' => '<a href="\\2" target="_blank">\\1 ສົ່ງການສະກິດຫາເຈົ້າ</a>',
	'mtag_reply' => '<a href="\\2" target="_blank">\\1 ຕອບກັບກະທູ້ຂອງຂ້ອຍ</a>',
	'event_comment' => '<a href="\\2" target="_blank">\\1 ສະແດງຄວາມຄິດເຫັນກ່ຽວກັບກິດຈະກຳຂອງເຈົ້າ</a>',

	'friend_pm_reply' => '\\1 ຕອບກັບຂໍ້ຄວາມສ່ວນຕົວຂອງເຈົ້າ',
	'comment_friend_reply' => '\\1 ຕອບກັບຂໍ້ຄວາມຂອງເຈົ້າ',
	'blog_comment_reply' => '\\1 ຕອບກັບຄວາມຄິດເຫັນໃນບລ໋ອກຂອງເຈົ້າ',
	'photo_comment_reply' => '\\1 ຕອບກັບຄວາມຄິດເຫັນໃນຮູບພາບຂອງເຈົ້າ',
	'poll_comment_reply' => '\\1 ຕອບກັບຄວາມຄິດເຫັນໃນສຳຫຼວດຂອງເຈົ້າ',
	'share_comment_reply' => '\\1 ຕອບກັບຄວາມຄິດເຫັນໃນການແບ່ງປັນຂອງເຈົ້າ',
	'event_comment_reply' => '\\1 ຕອບກັບຄວາມຄິດເຫັນໃນກິດຈະກຳຂອງເຈົ້າ',

	'mail_my' => 'ແຈ້ງເຕືອນການໂຕ້ຕອບລະຫວ່າງຂ້ອຍແລະໝູ່',
  	'mail_system' => 'ແຈ້ງເຕືອນຈາກລະບົບ',

	'invite_subject' => '{username} ເຊີນເຈົ້າເຂົ້າຮ່ວມແລະເປັນໝູ່ໃນ {sitename}',
	'invite_massage'	=> '<table border="0">
				<tr>
				<td valign="top">{avatar}</td>
				<td valign="top">
				<h3>ສະບາຍດີ ຂ້ອຍຊື່ {username} ຂໍເຊີນເຈົ້າເຂົ້າຮ່ວມແລະເປັນໝູ່ກັບຂ້ອຍໃນ {sitename}</h3><br>
				 ກະລຸນາເຂົ້າຮ່ວມແລະເປັນໝູ່ກັບຂ້ອຍ ເຈົ້າສາມາດຕິດຕາມການອັບເດດ ອ່ານບລ໋ອກ ເບິ່ງຮູບພາບ ແລກປ່ຽນຄວາມຮູ້/ປະສົບການໃໝ່ໆ ແລະຕິດຕໍ່ກັບຂ້ອຍໄດ້ຕະຫຼອດເວລາ<br>
				<br>
				ຫາກເຈົ້າຍິນດີຍອມຮັບຄຳເຊີນ:<br>{saymsg}
				<br><br>
				<strong>ກະລຸນາຄລິກທີ່ລິ້ງດ້ານລຸ່ມນີ້ ເພື່ອຍອມຮັບຄຳເຊີນ:</strong><br>
				<a href="{inviteurl}">{inviteurl}</a><br>
				<br>
				<strong>ຖ້າເຈົ້າເປັນສະມາຊິກຂອງ {sitename} ຢູ່ແລ້ວ ກະລຸນາຄລິກທີ່ລິ້ງດ້ານລຸ່ມເພື່ອເຂົ້າຊົມໂປຣໄຟລຂອງເຈົ້າ:</strong><br>
				<a href="{siteurl}home.php?mod=space&uid={uid}">{siteurl}home.php?mod=space&uid={uid}</a><br>
				</td></tr></table>',

	'app_invite_subject' => '{username} ເຊີນເຈົ້າເຂົ້າຮ່ວມມ່ວນກັບ {appname} ໃນ {sitename}',
	'app_invite_massage'	=> '<table border="0">
				<tr>
				<td valign="top">{avatar}</td>
				<td valign="top">
				<h3>ສະບາຍດີ ຂ້ອຍຊື່ {username}  ຢູ່ທີ່ {sitename} ມີ {appname} ໃຫ້ຮ່ວມສະໜຸກສະໜານ ຂ້ອຍຢາກຈະເຊີນເຈົ້າເຂົ້າມາຮ່ວມມ່ວນນຳກັນ</h3><br>
				<br>
				ຫາກເຈົ້າຍິນດີຍອມຮັບຄຳເຊີນ:<br>
				{saymsg}
				<br><br>
				<strong>ກະລຸນາຄລິກທີ່ລິ້ງດ້ານລຸ່ມ ເພື່ອຍອມຮັບຄຳເຊີນແລະຮ່ວມມ່ວນກັບ {appname} ນຳກັນ:</strong><br>
				<a href="{inviteurl}">{inviteurl}</a><br>
				<br>
				<strong>ຖ້າເຈົ້າເປັນສະມາຊິກຂອງ {sitename} ຢູ່ແລ້ວ ກະລຸນາຄລິກທີ່ລິ້ງດ້ານລຸ່ມເພື່ອເຂົ້າຊົມໂປຣໄຟລຂອງຂ້ອຍ:</strong><br>
				<a href="{siteurl}home.php?mod=space&uid={uid}">{siteurl}home.php?mod=space&uid={uid}</a><br>
				</td></tr></table>',

	'person' => 'ຄົນ',
	'delete' => 'ລຶບ',

	'space_update' => '{actor} ອັບເດດໂປຣໄຟລສ່ວນຕົວ',

	'active_email_subject' => 'ເປີດໃຊ້ງານອີເມວຂອງເຈົ້າ',
	'active_email_msg' => 'ກະລຸນາຄັດລອກລິ້ງເປີດໃຊ້ງານຕໍ່ໄປນີ້ລົງໃນບຣາວເຊີ້ ເພື່ອເປີດການໃຊ້ງານອີເມວຂອງເຈົ້າ<br>ລິ້ງສຳລັບເປີດໃຊ້ງານອີເມວ:<br><a href="{url}" target="_blank">{url}</a>',
	'share_space' => 'ແບ່ງປັນໂປຣໄຟລ',
	'share_blog' => 'ແບ່ງປັນບລ໋ອກ',
	'share_album' => 'ແບ່ງປັນອະລະບ້ຳ',
	'default_albumname' => 'ອະລະບ້ຳເລີ່ມຕົ້ນ',
	'share_image' => 'ແບ່ງປັນຮູບພາບ',
	'share_article' => 'ແບ່ງປັນບົດຄວາມ',
	'album' => 'ອະລະບ້ຳ',
	'share_thread' => 'ແບ່ງປັນກະທູ້',
	'mtag' => '{$_G[setting][navs][3][navname]}',
	'share_mtag' => 'ແບ່ງປັນ {$_G[setting][navs][3][navname]}',
	'share_mtag_membernum' => 'ສະມາຊິກທີ່ມີຢູ່ {membernum} ຄົນ',
	'share_tag' => 'ແບ່ງປັນຄີເວີດ',
	'share_tag_blognum' => 'ບລ໋ອກທີ່ມີຢູ່ {blognum} ບລ໋ອກ',
	'share_link' => 'ແບ່ງປັນເວັບໄຊ',
	'share_video' => 'ແບ່ງປັນວີດີໂອ',
	'share_music' => 'ແບ່ງປັນເພງ',
	'share_flash' => 'ແບ່ງປັນແຟລັດ Flash',
	'share_event' => 'ແບ່ງປັນກິດຈະກຳ',
	'share_poll' => 'ແບ່ງປັນສຳຫຼວດ \\1',
	'event_time' => 'ເວລາ',
	'event_location' => 'ສະຖານທີ່',
	'event_creator' => 'ຜູ້ສະໜັບສະໜູນ',
	'the_default_style' => 'ຮູບແບບເລີ່ມຕົ້ນ',
	'the_diy_style' => 'ສ້າງຮູບແບບຂອງຂ້ອຍເອງ',

	'thread_edit_trail' => '<ins class="modify">[ແກ້ໄຂກະທູ້ \\1 ໃນ \\2 ]</ins>',
	'create_a_new_album' => 'ສ້າງອະລະບ້ຳໃໝ່',
	'not_allow_upload' => 'ເຈົ້າບໍ່ໄດ້ຮັບອະນຸຍາດໃຫ້ອັບໂຫຼດຮູບພາບ',
	'not_allow_upload_extend' => 'ໄຟລປະເພດ {extend} ບໍ່ອະນຸຍາດໃຫ້ອັບໂຫຼດ',
	'files_can_not_exceed_size' => 'ໄຟລປະເພດ {extend} ບໍ່ສາມາດມີຂະໜາດກາຍ {size} ໄດ້',
	'get_passwd_subject' => 'ຄຳຂໍປ່ຽນລະຫັດຜ່ານໃໝ່',
	'get_passwd_message' => 'ຄລິກລິ້ງດ້ານລຸ່ມນີ້ເພື່ອຕັ້ງຄ່າລະຫັດຜ່ານຂອງເຈົ້າ ລິ້ງນີ້ຈະມີອາຍຸພຽງ 3 ມື້ເທົ່ານັ້ນ:<br />\\1<br />(ໃຫ້ເຮັດການຄັດລອກລິ້ງແລ້ວວາງທີ່ບຣາວເຊີ້ຫາກລິ້ງບໍ່ສາມາດຄລິກໄດ້)<br />ເມື່ອໄປຫາລິ້ງທີ່ສົ່ງມາແລ້ວ ພິມລະຫັດຜ່ານໃໝ່ ຫຼັງຈາກນັ້ນເຈົ້າສາມາດໃຊ້ລະຫັດຜ່ານໃໝ່ເພື່ອເຂົ້າສູ່ລະບົບ',
	'file_is_too_big' => 'ໄຟລຂະໜາດໃຫຍ່ເກີນໄປ',

	'take_part_in_the_voting' => '{actor} ໂຫວດສຳຫຼວດ <a href="{url}" target="_blank">{subject}</a> ຂອງ {touser} ໄດ້ຮັບ {reward} ',
	'lack_of_access_to_upload_file_size' => 'ບໍ່ສາມາດອັບໂຫຼດ ເນື່ອງຈາກພື້ນທີ່ໂປຣໄຟລຂອເຈົ້າເຕັມ',
	'only_allows_upload_file_types' => 'ໄຟລຮູບພາບຈະຕ້ອງເປັນຮູບແບບ jpg, jpeg, gif, png ເທົ່ານັ້ນ',
	'unable_to_create_upload_directory_server' => 'ບໍ່ສາມາດສ້າງໂຟນເດີ້ທີ່ອັບໂຫຼດໂປຣໄຟລເກັບໄວ້ໃນເຊີບເວີໄດ້',
	'inadequate_capacity_space' => 'ຄວາມບັນຈຸຂອງພື້ນທີ່ບໍ່ພຽງພໍ ບໍ່ສາມາດອັບໂຫຼດໄຟລໃໝ່',
	'mobile_picture_temporary_failure' => 'ບໍ່ສາມາດຍ້າຍໄຟລທີ່ລະບຸໄປຫາໂຟນເດີ້ຊົ່ວຄາວໃນເຊີບເວີໄດ້',
	'ftp_upload_file_size' => 'ອັບໂຫຼດຮູບພາບໄລຍະໄກລົ້ມເຫຼວ',
	'comment' => 'ສະແດງຄວາມຄິດເຫັນ',
	'upload_a_new_picture' => 'ອັບໂຫຼດຮູບພາບໃໝ່',
	'upload_album' => 'ອະລະບ້ຳອັບເດດຫຼ້າສຸດ',
	'the_total_picture' => 'ທັງໝົດ \\1 ຮູບພາບ',

	'space_open_subject' => 'ແຈ້ງເຕືອນ ໃຫ້ເບິ່ງແຍງແລະອັບເດດໂປຣໄຟລສ່ວນຕົວຂອງເຈົ້າ',
	'space_open_message' => 'ສະບາຍດີ ມື້ນີ້ຂ້ອຍໄດ້ໄປເຂົ້າຊົມໂປຣໄຟລສ່ວນຕົວຂອງເຈົ້າ ພົບວ່າເຈົ້າບໍ່ເບິ່ງແຍງໂປຣໄຟລຂອງໂຕເອງ ເຈົ້າໜ້າຈະໄປເບິ່ງແຍງແລະອັບເດດໂປຣໄຟລຂອງເຈົ້າແດ່ ໂປຣໄຟລຂອງເຈົ້າແມ່ນ:\\1space.php',



	'apply_mtag_manager' => 'ຕ້ອງການໃຫ້ <a href="\\1" target="_blank">\\2</a> ເປັນຄລັບຫຼັກ ເຫດຜົນ:\\3 <a href="\\1" target="_blank">(ຄລິກບ່ອນນີ້ເພື່ອເຂົ້າສູ່ການຈັດການ)</a>',


	'magicunit' => 'ອັນ',
	'magic_note_wall' => '{actor}<a href="{url}" target="_blank">ຝາກຂໍ້ຄວາມ</a>ຫາເຈົ້າ',
	'magic_call' => 'ມີຫຍັງຈະບອກເຈົ້າ<a href="{url}" target="_blank">ຄລິກບ່ອນນີ້ເພື່ອເບິ່ງ</a>',


	'present_user_magics' => 'ເຈົ້າໄດ້ຮັບໄອເທັມ \\1 ເປັນຂອງຂວັນຈາກຜູ້ເບິ່ງແຍງລະບົບ',
	'has_not_more_doodle' => 'ເຈົ້າບໍ່ໄດ້ແຕ້ມຮູບ',

	'do_stat_login' => 'ເຂົ້າສູ່ລະບົບ',
	'do_stat_mobilelogin' => 'ເຂົ້າສູ່ລະບົບຜ່ານອຸປະກອນເຄື່ອນທີ່',
	'do_stat_connectlogin' => 'ເຂົ້າສູ່ລະບົບດ້ວຍບັນຊີ QQ',
	'do_stat_register' => 'ສະໝັກສະມາຊິກໃໝ່',
	'do_stat_invite' => 'ຊວນໝູ່',
	'do_stat_appinvite' => 'ເຊີນໃຫ້ເຂົ້າຮ່ວມແອັບພິເກຊັ່ນ',
	'do_stat_add' => 'ເຜີຍແຜ່',
	'do_stat_comment' => 'ໂຕ້ຕອບ',
	'do_stat_space' => 'ຂໍ້ມູນເຊີນໂຕ້ຕອບ',
	'do_stat_doing' => 'ທັກທາຍ',
	'do_stat_blog' => 'ບລ໋ອກ',
	'do_stat_activity' => 'ກິດຈະກຳ',
	'do_stat_reward' => 'ລາງວັນ',
	'do_stat_debate' => 'ໂຕ້ວາທີ',
	'do_stat_trade' => 'ສິນຄ້າ',
	'do_stat_group' => "ສ້າງ{$_G[setting][navs][3][navname]}",
	'do_stat_tgroup' => "{$_G[setting][navs][3][navname]}",
	'do_stat_home' => "{$_G[setting][navs][4][navname]}",
	'do_stat_forum' => "{$_G[setting][navs][2][navname]}",
	'do_stat_groupthread' => 'ກະທູ້ຂອງຄລັບ',
	'do_stat_post' => 'ຕອບກັບ',
	'do_stat_grouppost' => 'ຕອບກັບຂອງຄລັບ',
	'do_stat_pic' => 'ຮູບພາບ',
	'do_stat_poll' => 'ສຳຫຼວດ',
	'do_stat_event' => 'ກິດຈະກຳ',
	'do_stat_share' => 'ແບ່ງປັນ',
	'do_stat_thread' => 'ກະທູ້',
	'do_stat_docomment' => 'ຄວາມຄິດເຫັນທັກທາຍ',
	'do_stat_blogcomment' => 'ຄວາມຄິດເຫັນບລ໋ອກ',
	'do_stat_piccomment' => 'ຄວາມຄິດເຫັນຮູບພາບ',
	'do_stat_pollcomment' => 'ຄວາມຄິດເຫັນສຳຫຼວດ',
	'do_stat_pollvote' => 'ຮ່ວມໂຫວດ',
	'do_stat_eventcomment' => 'ຄວາມຄິດເຫັນກິດຈະກຳ',
	'do_stat_eventjoin' => 'ເຂົ້າຮ່ວມກິດຈະກຳ',
	'do_stat_sharecomment' => 'ຄວາມຄິດເຫັນແບ່ງປັນ',
//vot	'do_stat_post' => 'ຕອບກັບ',
	'do_stat_click' => 'ສະແດງຄວາມຮູ້ສຶກ',
	'do_stat_wall' => 'ຝາກຂໍ້ຄວາມ',
	'do_stat_poke' => 'ສະກິດ',
	'do_stat_sendpm' => 'ສົ່ງ PM',
	'do_stat_addfriend' => 'ຂໍເປັນໝູ່',
	'do_stat_friend' => 'ຮັບເປັນໝູ່',
	'do_stat_post_number' => 'ຈຳນວນໂພສ',
	'do_stat_statistic' => 'ສະຖິຕິໂດຍລວມ',
	'logs_credit_update_INDEX'	=> array('TRC','RTC','RAC','MRC','BMC','TFR','RCV','CEC','ECU','SAC','BAC','PRC','RSC','STC','BTC','AFD','UGP','RPC','ACC','RCT','RCA','RCB','CDC','RGC','BGC','AGC','RKC','BME','RPR','RPZ','FCP','BGC'),
	'logs_credit_update_TRC' => 'ຮ່ວມກິດຈະກຳຂອງເວັບໄຊ',
	'logs_credit_update_RTC' => 'ຕັ້ງກະທູ້ລາງວັນ',
	'logs_credit_update_RAC' => 'ຕອບຄຳຖາມຖືກຕ້ອງ',
	'logs_credit_update_MRC' => 'ສຸມໃຊ້ໄອເທັມ',
	'logs_credit_update_BMC' => 'ຊື້ໄອເທັມ',
	'logs_credit_update_TFR' => 'ໂອນຍ້າຍ',
	'logs_credit_update_RCV' => 'ໄດ້ຮັບຈາກການໂອນ',
	'logs_credit_update_CEC' => 'ແລກປ່ຽນເງິນ',
	'logs_credit_update_ECU' => 'ແລກປ່ຽນເງິນພາຍໃນ UCenter',
	'logs_credit_update_SAC' => 'ຂາຍໄຟລແນບ',
	'logs_credit_update_BAC' => 'ຊື້ໄຟລແນບ',
	'logs_credit_update_PRC' => 'ໄດ້ຄະແນນໂພສ',
	'logs_credit_update_RSC' => 'ໃຫ້ຄະແນນໂພສ',
	'logs_credit_update_STC' => 'ຂາຍກະທູ້',
	'logs_credit_update_BTC' => 'ຊື້ກະທູ້',
	'logs_credit_update_AFD' => 'ຊື້ເງິນ',
	'logs_credit_update_UGP' => 'ຊື້ກຸ່ມຜູ້ໃຊ້ເພີ່ມຕື່ມ',
	'logs_credit_update_RPC' => 'ໄດ້ລາງວັນຈາກການລາຍງານ',
	'logs_credit_update_ACC' => 'ເຂົ້າຮ່ວມກິດຈະກຳ',
	'logs_credit_update_RCT' => 'ໃຫ້ລາງວັນຕອບກະທູ້',
	'logs_credit_update_RCA' => 'ໄດ້ຮັບລາງວັນຕອບກະທູ້',
	'logs_credit_update_RCB' => 'ໄດ້ຮັບໂບນັດເງິນຈາກການຕອບກັບ',
	'logs_credit_update_CDC' => 'ລະຫັດກາຣດເງິນ',
	'logs_credit_update_RGC' => 'ຮຽກຄືນເງິນ',
	'logs_credit_update_BGC' => 'ແຈກເງິນ',
	'logs_credit_update_AGC' => 'ໄດ້ຮັບເງິນ',
	'logs_credit_update_RKC' => 'ຮ່ວມຈັດອັນດັບ',
	'logs_credit_update_BME' => 'ຊື້ຫຼຽນ',
	'logs_credit_update_RPR' => 'ເງິນສະສົມ',
	'logs_credit_update_RPZ' => 'ປະຫວັດເງິນ',
	'logs_credit_update_FCP'	=> 'Pay the forum',//'付费版块',
	'logs_credit_update_BGR'	=> 'Build Group',//'创建群组',
	'buildgroup'			=> 'View already built groups',//'查看已创建的群组',
	'logs_credit_update_reward_clean' => 'ລ້າງ',
	'logs_select_operation' => 'ກະລຸນາເລືອກປະເພດຂອງການດຳເນີນການ',
	'task_credit' => 'ລາງວັນເງິນພາລະກິດ',
	'special_3_credit' => 'ຫັກເງິນສຳລັບການຕອບ',
	'special_3_best_answer' => 'ເງິນລາງວັນສຳລັບຄຳຕອບທີ່ດີທີ່ສຸດ',
	'magic_credit' => 'ສຸມໄອເທັມເພື່ອຮັບເງິນ',
	'magic_space_gift' => 'ໃສ່ອັງເປົ່າໄວ້ໃນໜ້າທຳອິດຂອງພື້ນທີ່ສ່ວນຕົວຂອງເຈົ້າ',
	'magic_space_re_gift' => 'ກູ້ຄືນອັງເປົ່າ',
	'magic_space_get_gift' => 'ຮັບອັງເປົ່າ',
	'credit_transfer' => 'ໂອນເງິນ',
	'credit_transfer_tips' => 'ເງິນຮັບມາ',
	'credit_exchange_tips_1' => 'ແລກປ່ຽນເງິນ ',
	'credit_exchange_to' => 'ແລກປ່ຽນ',
	'credit_exchange_center' => 'ແລກປ່ຽນໂດຍໃຊ້ Ucenter',
	'attach_sell' => 'ຂາຍ',
	'attach_sell_tips' => 'ໄດ້ຮັບຈາກໄຟລແນບ',
	'attach_buy' => 'ຊື້',
	'attach_buy_tips' => 'ສູນເສຍຈາກໄຟລແນບ',
	'grade_credit' => 'ໄດ້ຮັບເງິນຈາກຄະແນນ',
	'grade_credit2' => 'ເງິນຖືກຫັກຈາກຄະແນນໂພສ',
	'thread_credit' => 'ໄດ້ຮັບເງິນການຂາຍກະທູ້',
	'thread_credit2' => 'ສູນເສຍເງິນກະທູ້',
	'buy_credit' => 'ຕື່ມເງິນ',
	'buy_usergroup' => 'ຕື່ມເງິນກຸ່ມຜູ້ໃຊ້',
	'buy_medal' => 'ຊື້ຫຼຽນ',
	'buy_forum'			=> 'Buy a paid forum access permissions',//'购买付费版块的访问权限',
	'report_credit' => 'ລາຍງານເງິນ',
	'join' => 'ເຂົ້າຮ່ວມ',
	'activity_credit' => 'ຫັກເງິນຄ່າກິດຈະກຳ',
	'thread_send' => 'ຫັກຄ່າສົ່ງ',
	'replycredit' => 'ເງິນທີ່ຈ່າຍ',
	'add_credit' => 'ເພີ່ມເງິນ',
	'recovery' => 'ກູ້ຄືນ',
	'replycredit_post' => 'ລາງວັນການຕອບກັບ',
	'replycredit_thread' => 'ລາງວັນສຳລັບກະທູ້',
	'card_credit' => 'ກາຣດຕື່ມເງິນ',
	'ranklist_top' => 'ໃຊ້ເງິນເພື່ອເຂົ້າຮ່ວມການປະມູນອັນດັບ',
	'admincp_op_credit' => 'ການດຳເນີນການເງິນ',
	'credit_update_reward_clean' => 'ລ້າງ',

	'profile_unchangeable' => 'ຂໍ້ມູນນີ້ບໍ່ສາມາດປ່ຽນແປງໄດ້ໃນພາຍຫຼັງຈາກທີ່ບັນທຶກ',
	'profile_is_verifying' => 'ຂໍ້ມູນນີ້ຈະຖືກກວດສອບກ່ອນທີ່ຈະເຜີຍແຜ່',
	'profile_mypost' => 'ໂພສຂອງຂ້ອຍ',
	'profile_need_verifying' => 'ຂໍ້ມູນນີ້ຈະຖືກກວດສອບຫຼັງຈາກທີ່ບັນທຶກ',
	'profile_edit' => 'ແກ້ໄຂ',
	'profile_censor' => '(ກອງຄຳຫຍາບ)',
	'profile_verify_modify_error' => '{verify} ການຮັບຮອງບໍ່ອະນຸຍາດໃຫ້ແກ້ໄຂ',
	'profile_verify_verifying' => 'ຂໍ້ມູນ {verify} ຂອງເຈົ້າໄດ້ຖືກສົ່ງຮຽບຮ້ອຍແລ້ວ ກະລຸນາຖ້າການກວດສອບ',

	'district_level_1' => '-ແຂວງ-',
	'district_level_2' => '-ເມືອງ-',
	'district_level_3' => '-ບ້ານ-',
	'district_level_4' => '-ໝູ່ບ້ານ-',
	'invite_you_to_visit' => '{user} ເຊີນເຈົ້າໃຫ້ເຂົ້າຊົມ {bbname}',

	'portal' => 'ພອດທໍ',
	'group' => 'ຄລັບ',
	'follow' => 'ຕິດຕາມ',
	'collection' => 'ຄັງກະທູ້',
	'guide' => 'ກະທູ້ແນະນຳ',
	'feed' => 'ຟີດຂ່າວ',
	'blog' => 'ບລ໋ອກ',
	'doing' => 'ທັກທາຍ',
	'wall' => 'ຂໍ້ຄວາມ',
	'homepage' => 'ໜ້າທຳອິດ',
	'ranklist' => 'ລາຍການອັນດັບ',
	'select_the_navigation_position' => 'ເລືອກປະເພດ {type} ເມນູນຳທາງ',
	'close_module' => 'ປິດປະເພດໂມດູນ {type}',

	'follow_add_remark' => 'ເພີ່ມໝາຍໃນການຕິດຕາມ',
	'follow_modify_remark' => 'ແກ້ໄຂໝາຍການຕິດຕາມ',
	'follow_specified_group' => 'ລະບຸຄລັບສຳລັບການຕິດຕາມ',
	'follow_specified_forum' => 'ລະບຸເວັບບອດສຳລັບການຕິດຕາມ',

	'filesize_lessthan' => 'ຂະໜາດໄຟລຄວນຈະໜ້ອຍກວ່າ',

	'spacecp_message_prompt' => '(ສະໜັບສະໜູນຕັ້ງແຕ່ {msg} ໂຕອັກສອນ ຈົນເຖິງສູງສຸດ 1000 ໂຕອັກສອນ)',
	'card_update_doing' => ' <a class="xi2" href="###">[ອັບເດດຂໍ້ຄວາມທັກທາຍ]</a>',
	'email_acitve_message' => '<img src="{imgdir}/mail_inactive.png" alt="ຍັງບໍ່ໄດ້ຢືນຢັນ" class="vm" />
						<span class="xi1">ອີເມວ ({newemail}) ຂອງເຈົ້າຍັງບໍ່ໄດ້ຢືນຢັນ...</span><br />
						ລະບົບໄດ້ສົ່ງໂຄສຢືນຢັນໄປຫາອີເມວທີ່ເຈົ້າໃຊ້ສະໝັກສະມາຊິກແລ້ວ ກະລຸນາກວດສອບເພື່ອຢືນຢັນແລະເປີດໃຊ້ງານ<br>
						ຖ້າເຈົ້າບໍ່ໄດ້ຮັບ ເຈົ້າສາມາດປ່ຽນອີເມວໃໝ່ ຫຼື<a href="home.php?mod=spacecp&ac=profile&op=password&resend=1" class="xi2">ຄລິກບ່ອນນີ້ເພື່ອຂໍຮັບການຢືນຢັນອີກຄັ້ງ</a>',
	'qq_set_status' => 'ຂ້ອຍກຳນົດຄ່າສະຖານະ QQ ຂອງຂ້ອຍເປັນອອນລາຍ',
	'qq_dialog' => 'ເລີ່ມການແຊັດດ້ວຍ QQ',

);

