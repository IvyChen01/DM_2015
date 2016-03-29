<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_portalcp.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(
	'block_diy_nopreview' => '<p>ໂມດູນນີ້ປະກອບດ້ວຍໂຄສ js ຈະບໍ່ສາມາດສະແດງຕົວຢ່າງໄດ້ທັນທີ</p>',
	'block_diy_summary_html_tag' => 'ຂໍ້ຜິດພາດໃນເນື້ອຫາທີ່ກຳນົດເອງ ແທັກ HTML: ',
	'block_diy_summary_not_closed' => ' ບໍ່ຄືກັນ',
	'block_all_category' => 'ໝວດໝູ່ທັງໝົດ',
	'block_first_category' => 'ໝວດໝູ່ທຳອິດ',
	'block_all_forum' => 'ບອດທັງໝົດ',
	'block_all_group' => 'ກຸ່ມທັງໝົດ',
	'block_all_type' => 'ປະເພດທັງໝົດ',
	'file_size_limit' => 'ໄຟລບໍ່ສາມາດມີຂະໜາດໃຫຍ່ກວ່າ {size} KB ກະລຸນາຍ້ອນກັບ',
	'set_to_conver' => 'ຕັ້ງເປັນຮູບປົກ',
	'small_image' => 'ຮູບຫຍໍ້',
	'insert_small_image' => 'ແທຣກຮູບພາບຂະໜາດນ້ອຍ',
	'insert_large_image' => 'ແທຣກຮູບພາບຂະໜາດໃຫຍ່',
	'insert_file' => 'ແທຣກໄຟລ',
	'delete' => 'ລຶບ',
	'upload_error' => 'ອັບໂຫຼດລົ້ມເຫຼວ',
	'upload_remote_failed' => 'ອັບໂຫຼດໄລຍະໄກລົ້ມເຫຼວ',
	'article_noexist' => 'ບົດຄວາມທີ່ລະບຸໄວ້ບໍ່ມີຢູ່ ກະລຸນາກວດສອບ',
	'article_noallowed' => 'ເຈົ້າບໍ່ໄດ້ຮັບອະນຸຍາດໃຫ້ດຳເນີນການໃດໆກ່ຽວກັບບົດຄວາມ',
	'article_publish_noallowed' => 'ເຈົ້າບໍ່ໄດ້ຮັບອະນຸຍາດໃຫ້ດຳເນີນການເຜີຍແຜ່ບົດຄວາມ',
	'article_category_empty' => 'ຂໍອະໄພ! ໝວດໝູ່ບໍ່ຄວນວ່າງເປົ່າ',
	'article_edit_nopermission' => 'ຂໍອະໄພ! ເຈົ້າບໍ່ໄດ້ຮັບອະນຸຍາດໃຫ້ດຳເນີນການທີ່ກ່ຽວຂ້ອງກັບບົດຄວາມປັດຈຸບັນ',
	'article_publish' => 'ເພີ່ມ',
	'article_manage' => 'ຈັດການ',
	'article_tag' => 'ຄີເວຣີດ ',
	'select_category' => 'ເລືອກໝວດໝູ່',
	'blockstyle_diy' => 'ກຳນົດຮູບແບບດ້ວຍຕົວເອງ',

	'article_pushplus_info' => '<p><center><i><a href="{url}" class="xg1 xs1">ບົດຄວາມນີ້ໂດຍ {author}</a></i></center></p>',

	'diytemplate_name_null' => '[ຊື່ຍາວເກີນໄປ]',
	'portal_view_name' => ' ມຸມມອງແບບໜ້າ',
	'forum_viewthread_name' => ' ມຸມມອງແບບລາຍການ',
	'portal/index' => 'ໜ້າທຳອິດຂອງເວັບໄຊ',
	'portal/list' => 'ໜ້າລາຍການບົດຄວາມ(ສາທາລະນະ)',
	'portal/view' => 'ໜ້າເນື້ອຫາບົດຄວາມ(ສາທາລະນະ)',
	'portal/comment' => 'ໜ້າຄວາມຄິດເຫັນບົດຄວາມ',
	'forum/discuz' => 'ໜ້າເວັບບອດ',
	'forum/viewthread' => 'ໜ້າເນື້ອຫາກະທູ້(ສາທາລະນະ)',
	'forum/forumdisplay' => 'ໜ້າລາຍການກະທູ້(ສາທາລະນະ)',
	'group/index' => 'ໜ້າ'.$_G['setting']['navs'][3]['navname'].'',
	'group/group_my' => 'ໜ້າ'.$_G['setting']['navs'][3]['navname'].' ຂອງຂ້ອຍ',
	'group/group' => 'ໜ້າເນື້ອຫາ'.$_G['setting']['navs'][3]['navname'].'',
	'home/space_home' => 'ໜ້າທຳອິດພື້ນທີ່ສ່ວນຕົວ',
	'home/space_trade' => 'ໜ້າສິນຄ້າ',
	'home/space_top' => 'ໜ້າການຈັດລຳດັບ',
	'home/space_thread' => 'ໜ້າກະທູ້',
	'home/space_reward' => 'ໜ້າລາງວັນ',
	'home/space_share_list' => 'ໜ້າລາຍການຂໍ້ມູນທີ່ນຳມາແບ່ງປັນ',
	'home/space_share_view' => 'ໜ້າເບິ່ງຂໍ້ມູນທີ່ນຳມາແບ່ງປັນ',
	'space_share_view' => 'ໜ້າແບ່ງປັນ',
	'home/space_poll' => 'ໜ້າສຳຫຼວດ',
	'home/space_pm' => 'ໜ້າຂໍ້ຄວາມສ່ວນຕົວ',
	'home/space_notice' => 'ໜ້າຂໍ້ຄວາມແຈ້ງເຕືອນ',
	'home/space_group' => 'ໜ້າ'.$_G['setting']['navs'][3]['navname'].'',
	'home/space_friend' => 'ໜ້າໝູ່',
	'home/space_favorite' => 'ໜ້າລາຍການທີ່ມັກ',
	'home/space_doing' => 'ໜ້າຂໍ້ຄວາມທັກທາຍ',
	'home/space_debate' => 'ໜ້າຫົວຂໍ້ໂຕ້ວາທີ',
	'home/space_blog_view' => 'ໜ້າເນື້ອຫາບລ໋ອກ',
	'home/space_blog_list' => 'ໜ້າລາຍການບລ໋ອກ',
	'home/space_album_view' => 'ໜ້າເບິ່ງອະລະບ້ຳ',
	'home/space_album_pic' => 'ໜ້າເບິ່ງຮູບພາບ',
	'home/space_album_list' => 'ໜ້າລາຍການອະລະບ້ຳ',
	'home/space_activity' => 'ໜ້າກິດຈະກຳ',
	'ranklist/ranklist' => 'ໜ້າລາຍການຈັດອັນດັບ',
	'ranklist/blog' => 'ໜ້າອັນດັບບລ໋ອກ',
	'ranklist/poll' => 'ໜ້າອັນດັບໂພສ',
	'ranklist/activity' => 'ໜ້າອັນດັບກິດຈະກຳ',
	'ranklist/forum' => 'ໜ້າອັນດັບບອດ',
	'ranklist/picture' => 'ໜ້າອັນດັບຮູບພາບ',
	'ranklist/group' => 'ໜ້າອັນດັບຄລັບ',
	'ranklist/thread' => 'ໜ້າອັນດັບກະທູ້',
	'ranklist/member' => 'ໜ້າອັນດັບສະມາຊິກ',
	'other_page' => 'ບໍ່ມີ DIY ໂມດູນ',
	'upload' => 'ອັບໂຫຼດ',
	'remote' => 'ໄລຍະໄກ',
	'portal_index' => 'ໜ້າທຳອິດພອດທໍ',
	'portal_topic_blue' => 'ຮູບແບບສີຟ້າ',
	'portal_topic_green' => 'ຮູບແບບສີຂຽວ',
	'portal_topic_grey' => 'ຮູບແບບສີເທົ່າ',
	'portal_topic_red' => 'ຮູບແບບສີແດງ',

	'itemtypename0' => 'ອັດຕະໂນມັດ',
	'itemtypename1' => '<span style="color: #FF0000">ແກ້ໄຂ</span>',
	'itemtypename2' => '<span style="color: #00BFFF">ໂຕແກ້ໄຂ</span>',
	'itemtypename3' => '<span style="color: #0000FF">ດັນ</span>',

);