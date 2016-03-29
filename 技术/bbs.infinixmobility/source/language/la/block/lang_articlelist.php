<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_articlelist.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'articlelist_aids' => 'ກຳນົດບົດຄວາມ',
	'articlelist_aids_comment' => 'ກຳນົດ ID(aid) ຂອງບົດຄວາມທີ່ຕ້ອງການສະແດງຂໍ້ມູນ, ຫາກມີຫຼາຍກວ່າໜຶ່ງ ID ກະລຸນາໃຊ້ເຄື່ອງໝາຍຄອມມ່າ “,” ເພື່ອເປັນຕົວຂັ້ນຫຼືແຍກແຕ່ລະ ID',
	'articlelist_uids' => 'UID ຜູ້ຂຽນ',
	'articlelist_uids_comment' => 'ກຳນົດ ID(uid) ຜູ້ຂຽນ, ຫາກມີຫຼາຍກວ່າໜຶ່ງ ID ກະລຸນາໃຊ້ເຄື່ອງໝາຍຄອມມ່າ “,” ເພື່ອເປັນຕົວຂັ້ນຫຼືແຍກແຕ່ລະ ID',
	'articlelist_startrow' => 'ຈຳນວນແຖວເລີ່ມຕົ້ນຂອງຂໍ້ມູນ',
	'articlelist_startrow_comment' => 'ຖ້າຈຳເປັນຕ້ອງຕັ້ງຄ່າແຖວຂອງຈຳນວນຂໍ້ມູນເລີ່ມຕົ້ນ, ກະລຸນາໃສ່ຄ່າທີ່ຕ້ອງການ, 0 ຄືຈະເລີ່ມການເຮັດວຽກຈາກແຖວທຳອິດ, ເປັນຕົ້ນ',
	'articlelist_tag' => 'ຄີເວີດ',
	'articlelist_tag_comment' => 'ລະບຸຄີເວີດ',
	'articlelist_titlelength' => 'ຄວາມຍາວຊື່',
	'articlelist_titlelength_comment' => 'ຕັ້ງຄ່າຄວາມຍາວສູງສຸດຂອງຊື່ເລື່ອງ',
	'articlelist_summarylength' => 'ຄວາມຍາວເນື້ອຫາ',
	'articlelist_summarylength_comment' => 'ຕັ້ງຄ່າຄວາມຍາວສູງສຸດຂອງຄວາມຍາວເນື້ອຫາ',
	'articlelist_starttime' => 'ເວລາເລີ່ມຕົ້ນ',
	'articlelist_starttime_comment' => 'ຕັ້ງຄ່າວັນເວລາເລີ່ມຕົ້ນ',
	'articlelist_endtime' => 'ເວລາສິ້ນສຸດ',
	'articlelist_endtime_comment' => 'ຕັ້ງຄ່າວັນເວລາສິ້ນສຸດ',
	'articlelist_catid' => 'ໝວດໝູ່ບົດຄວາມ',
	'articlelist_catid_comment' => 'ເລືອກໝວດໝູ່ຂອງບົດຄວາມ',
	'articlelist_picrequired' => 'ກອງສະເພາະບົດຄວາມທີ່ມີຮູບພາບໜ້າປົກ',
	'articlelist_picrequired_comment' => 'ກອງຫຼືເລືອກໃຫ້ສະແດງສະເພາະບົດຄວາມທີ່ມີຮູບພາບໜ້າປົກ',
	'articlelist_orderby' => 'ການຈັດລຽງລຳດັບບົດຄວາມ',
	'articlelist_orderby_comment' => 'ຕັ້ງຄ່າການຈັດລຽງລຳດັບຂອງບົດຄວາມ',
	'articlelist_orderby_dateline' => 'ຈັດລຽງຕາມມື້ທີ່ເຜີຍແຜ່',
	'articlelist_orderby_viewnum' => 'ຈັດລຽງຕາມຈຳນວນການເຂົ້າເບິ່ງ/ເບິ່ງ',
	'articlelist_orderby_commentnum' => 'ຈັດລຽງຕາມຈຳນວນຄວາມຄິດເຫັນ',
	'articlelist_orderby_click' => 'ຈັດລຽງຕາມຈຳນວນຄົນໂຫວດ {clickname}',
	'articlelist_publishdateline' => 'ບົດຄວາມທີ່ເຜີຍແຜ່',
	'articlelist_publishdateline_nolimit' => 'ບໍ່ຈຳກັດ',
	'articlelist_publishdateline_hour' => 'ຫຼ້າສຸດ 1 ຊົ່ວໂມງ',
	'articlelist_publishdateline_day' => 'ຫຼ້າສຸດ 24 ຊົ່ວໂມງ',
	'articlelist_publishdateline_week' => 'ຫຼ້າສຸດ 1 ອາທິດ',
	'articlelist_publishdateline_month' => 'ຫຼ້າສຸດ 1 ເດືອນ',
	'articlelist_keyword' => 'ແທັກຂອງຫົວຂໍ້',
	'articlelist_keyword_comment' => 'ຕັ້ງຄ່າແທັກຂອງກະທູ້ ໝາຍເຫດ: ປ່ອຍວ່າງໄວ້ຫາກບໍ່ມີແທັກໃດໆ ສາມາດໃຊ້ສັນຍາລັກ * ແທນແທັກຫຼັກ ຄົ້ນຫາໂດຍແທັກຫຼັກເພີ່ມເຕີມ, ສາມາດໃຊ້ຊ່ອງຫວ່າງລະຫວ່າງຄຳ ຫຼື AND ໃນການເຊື່ອມຕໍ່ ເຊັ່ນ win32 AND unix ແລະສາມາດໃຊ້ | ຫຼື OR ເພື່ອໃຫ້ຖືກກັບແທັກຫຼັກທີ່ຫຼາຍກວ່າໜຶ່ງຄຳ,  ເຊັ່ນ win32 OR unix',
);

