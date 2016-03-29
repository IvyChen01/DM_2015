<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *	$Id: lang_exif.php by Valery Votintsev, codersclub.org
 *	Lao language by Do_Thavisak, http://www.deklao.com/
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(

	'unknown' => 'ບໍ່ຮູ້ຈັກ',
	'resolutionunit' => array('', '', 'ນິ້ວ', 'ຊັງຕີແມັດ'),
	'exposureprogram' => array('ບໍ່ກຳນົດ', 'ກຳນົດເອງ', 'ມາດຕະຖານ', 'ເປີດລະດັບຄວາມສຳຄັນ', 'ລະດັບຄວາມໄວທີ່ສຳຄັນ', 'ຄວາມເລິກ', 'ໂໝດສະປອດ', 'ໂໝດແນວຕັ້ງ', 'ໂໝດແນວນອນ'),
	'meteringmode'	=> array(
		'0'		=> 'ບໍ່ຮູ້ຈັກ',
		'1'		=> 'ໂດຍສະເລ່ຍ',
		'2'		=> 'ການວັດແສງສະເລ່ຍຖ່ວງນ້ຳໜັກ',
		'3'		=> 'ຄະແນນແບບສຳຫຼວດ',
		'4'		=> 'ພື້ນທີ່',
		'5'		=> 'ການປະເມີນ',
		'6'		=> 'ທີ່ຢູ່',
		'255'		=> 'ອື່ນໆ'
		),
	'lightsource'	=> array(
		'0'		=> 'ບໍ່ຮູ້ຈັກ',
		'1'		=> 'ແສງອາທິດ',
		'2'		=> 'ແສງຈັນ',
		'3'		=> 'ແສງໄຟນີອອນ',
		'10'		=> 'ແສງໄຟແຟລັດ',
		'17'		=> 'ແສງໄຟມາດຕະຖານ A',
		'18'		=> 'ແສງໄຟມາດຕະຖານ B',
		'19'		=> 'ແສງໄຟມາດຕະຖານ C',
		'20'		=> 'D55',
		'21'		=> 'D65',
		'22'		=> 'D75',
		'255'	=> 'ອື່ນໆ'
		),
	'img_info' => array ('ຂໍ້ມູນຂອງຟາຍ' => 'ບໍ່ມີຂໍ້ມູນ EXIF ຂອງຮູບພາບ'),

	'FileName' => 'ຊື່ຟາຍ',
	'FileType' => 'ປະເພດຟາຍ',
	'MimeType' => 'ຮູບແບບຟາຍ',
	'FileSize' => 'ຂະໜາດຟາຍ',
	'FileDateTime' => 'ເວລາ',
	'ImageDescription' => 'ຄຳອະທິບາຍຮູບຖ່າຍ',
	'auto'     => 'ອັດຕະໂນມັດ',
	'Make'     => 'ຜູ້ຜະລິດ',
	'Model'    => 'ແບບຈຳລອງ',
	'Orientation' => 'ທິດທາງ',
	'XResolution' => 'ຄວາມລະອຽດແນວນອນ',
	'YResolution' => 'ຄວາມລະອຽດແນວຕັ້ງ',
	'Software'    => 'ຊ໋ອບແວ',
	'DateTime'    => 'ເວລາທີ່ປັບປ່ຽນ',
	'Artist'      => 'ຜູ້ຂຽນ',
	'YCbCrPositioning' => 'YCbCr ຄວບຄຸມຕຳແໜ່ງ',
	'Copyright'   => 'ລິຂະສິດ',
	'Photographer'=> 'ຊ່າງພາບ',
	'Editor'      => 'ແກ້ໄຂລິຂະສິດ',
	'ExifVersion' => 'Exif ເວີຊັ່ນ',
	'FlashPixVersion' => 'FlashPix ເວີຊັ່ນ',
	'DateTimeOriginal' => 'ວັນເວລາຕົ້ນສະບັບ',
	'DateTimeDigitized'=> 'ເວລາດີຈີຕໍ',
	'Height'  => 'ຄວາມລະອຽດຂອງຄວາມສູງ',
	'Width'   => 'ຄວາມລະອຽດຂອງຄວາມກວ້າງ',
	'ApertureValue' => 'ແສງ',
	'ShutterSpeedValue' => 'ຄວາມໄວຊັດເຕີ້',
	'ApertureFNumber'   => 'ຈຳນວນຮູຮັບແສງ',
	'MaxApertureValue'  => 'ແສງ ສູງສຸດ',
	'ExposureTime'      => 'ເວລາຂອງການເປີດຮັບແສງ',
	'FNumber'		=> 'F-Number',
	'MeteringMode'      => 'ໂໝດການວັດ',
	'LightSource'       => 'ແສງຕົ້ນສະບັບ',
	'Flash'             => 'ແຟລັດ',
	'ExposureMode'		=> 'ໂໝດການເປີດຮັບແສງ',
	'manual'            => 'ກຳນົດເອງ',
	'WhiteBalance'      => 'ປັບສົມດຸນຂອງແສງ',
	'ExposureProgram'   => 'ໂປຣແກຣມການເປີດຮັບແສງ',
	'ExposureBiasValue' => 'ຄ່າຊົດເຊີຍການເປີດຮັບແສງ',
	'ISOSpeedRatings'   => 'ISO ອັນດັບຄວາມໄວ',
	'ComponentsConfiguration' => 'ກຳນົດຄ່າອົງປະກອບ',
	'CompressedBitsPerPixel'  => 'ອັດຕາສ່ວນການບີບອັດຮູບພາບ',
	'FocusDistance'     => 'ໄລຍະໂຟກັດ',
	'FocalLength'       => 'ຄວາມຍາວໂຟກັດ',
	'FocalLengthIn35mmFilm' => 'ຄວາມຍາວໂຟກັດທຽບເທົ່າ 35 ມິນລີແມັດ',
	'UserCommentEncoding' => 'ລະຫັດຄວາມຄິດເຫັນຂອງຜູ້ໃຊ້',
	'UserComment'		=> 'ຄວາມຄິດເຫັນຂອງຜູ້ໃຊ້',
	'ColorSpace'		=> 'ສີພື້ນທີ່',
	'ExifImageLength'   => 'ຄວາມກວ້າງຂອງຮູບພາບ',
	'ExifImageWidth'    => 'ຄວາມສູງຂອງຮູບພາບ',
	'FileSource'        => 'ຟາຍຕົ້ນສະບັບ',
	'SceneType'			=> 'ປະເພດຂອງສາກ',
	'ThumbFileType'     => 'ຮູບແບບຟາຍຂອງຮູບຂະໜາດຫຍໍ້',
	'ThumbMimeType'     => 'ຮູບຂະໜາດຫຍໍ້'
);

