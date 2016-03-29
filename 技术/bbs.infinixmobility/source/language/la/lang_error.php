<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_error.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'System Message' => 'ຂໍ້ມູນກ່ຽວກັບໄຊ',

	'config_notfound' => 'ບໍ່ພົບໄຟລການຕັ້ງຄ່າຂອງ "config_global.php" ຫຼືບໍ່ສາມາດເຂົ້າເຖິງໄດ້ ກວດສອບໃຫ້ແນ່ໃຈວ່າເຈົ້າຕິດຕັ້ງດິດຄັສແບບຖືກຕ້ອງແລ້ວ?',
	'template_notfound' => 'ບໍ່ພົບເທັມເພຣດ ຫຼືບໍ່ສາມາດເຂົ້າເຖິງໄດ້',
	'directory_notfound' => 'ບໍ່ພົບໂຟນເດີ້ ຫຼືບໍ່ສາມາດເຂົ້າເຖິງໄດ້',
	'request_tainting' => 'ການຮ້ອງຂໍປະກອບຄວາມເຫັນຂອງເຈົ້າປະກອບດ້ວຍອັກສອນບໍ່ຖືກຕ້ອງ ໄດ້ຮັບການປະຕິເສດໂດຍລະບົບ',
	'db_help_link' => 'ຄລິກບ່ອນນີ້ເພື່ອຂໍຄວາມຊ່ວຍເຫຼືອ',
	'db_error_message' => 'ຂໍ້ຄວາມສະແດງຂໍ້ຜິດພາດ',
	'db_error_sql'			=> '<b>SQL</b>: $sql<br />',//'<b>SQL</b>: $sql<br />',
	'db_error_backtrace'		=> '<b>Backtrace</b>: $backtrace<br />',
	'db_error_no' => 'ລະຫັດຂໍ້ຜິດພາດ',
	'db_notfound_config' => 'ບໍ່ພົບໄຟລການຕັ້ງຄ່າຂອງ "config_global.php" ຫຼືບໍ່ສາມາດເຂົ້າເຖິງໄດ້',
	'db_notconnect' => 'ບໍ່ສາມາດເຊື່ອມຕໍ່ໄປຫາເຊີບເວີຖານຂໍ້ມູນ',
	'db_security_error' => 'ຄຳແນະນຳການຄົ້ນຫາກ່ຽວກັບການຖືກຄຸກຄາມດ້ານຄວາມປອດໄພ',
	'db_query_sql' => 'ຄຳແນະນຳໃນການຄົ້ນຫາ',
	'db_query_error' => 'ຂໍ້ຜິດພາດໃນການຄົ້ນຫາ',
	'db_config_db_not_found' => 'ຂໍ້ຜິດພາດໃນການກຳນົດຄ່າຖານຂໍ້ມູນ ກະລຸນາກວດສອບໄຟລ config_global.php',
	'system_init_ok' => 'ການເລີ່ມຕົ້ນລະບົບເວັບໄຊສຳເລັດສົມບູນ ກະລຸນາ<a href="index.php">ຄລິກບ່ອນນີ້ເພື່ອເຂົ້າສູ່ເວັບໄຊ</a>',
	'backtrace' => 'ຂໍ້ມູນການດຳເນີນການ',
	'error_end_message' => '<a href="http://{host}">{host}</a> ຂໍ້ຄວາມສະແດງຂໍ້ຜິດພາດນີ້ໄດ້ຖືກບັນທຶກໄວ້ໃນລາຍລະອຽດ ຂໍອະໄພໃນຄວາມບໍ່ສະດວກໃນການເຂົ້າເຖິງ',
	'mobile_error_end_message' => 'ເກີດຂໍ້ຜິດພາດ <a href="http://{host}">{host}</a> ຂໍອະໄພໃນຄວາມບໍ່ສະດວກ',

	'file_upload_error_-101' => 'ອັບໂຫຼດລົ້ມເຫຼວ! ໄຟລທີ່ຈະອັບໂຫຼດບໍ່ຢູ່ ຫຼືບໍ່ຖືກຕ້ອງ ກະລຸນາຍ້ອນກັບ',
	'file_upload_error_-102' => 'ອັບໂຫຼດລົ້ມເຫຼວ! ຮູບແບບຂອງໄຟລບໍ່ຖືກຕ້ອງ ກະລຸນາຍ້ອນກັບ',
	'file_upload_error_-103' => 'ອັບໂຫຼດລົ້ມເຫຼວ! ບໍ່ສາມາດຂຽນໄປຫາໄຟລ ຫຼືຂຽນລົ້ມເຫຼວ ກະລຸນາຍ້ອນກັບ',
	'file_upload_error_-104' => 'ອັບໂຫຼດລົ້ມເຫຼວ! ຮູບແບບໄຟລຂອງຮູບພາບບໍ່ຖືກຕ້ອງ ກະລຸນາຍ້ອນກັບ',
);

