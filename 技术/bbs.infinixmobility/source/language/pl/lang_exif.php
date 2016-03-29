<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *		$ID: lang_exif.php by Valery Votintsev at 
 *      polish language pack by kaaleth ( kaaleth-discuzpl@windowslive.com )
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(

	'unknown'		=> 'Nieznany',//'未知',
	'resolutionunit'	=> array('', '', 'cali', 'cm'),//array('', '', '英寸', '厘米'),
	'exposureprogram'	=> array('Niezdefiniowany', 'Ręczny', 'Procedura standardowa', 'Aperture Priority', 'Shutter Priority', 'Depth of pre-field', 'Tryb sportowy', 'Tryb portretowy', 'Tryb krajobrazowy'),//array('未定义', '手动', '标准程序', '光圈先决', '快门先决', '景深先决', '运动模式', '肖像模式', '风景模式'),
	'meteringmode'	=> array(
		'0'		=> 'Nieznany',//'未知',
		'1'		=> 'Średnia',//'平均',
		'2'		=> 'The central focus of the average metering',//'中央重点平均测光',
		'3'		=> 'Punkty pomiarowe',//'点测',
		'4'		=> 'Zoning',//'分区',
		'5'		=> 'Dostęp',//'评估',
		'6'		=> 'Część',//'局部',
		'255'		=> 'Inny'//'其他'
		),
	'lightsource'	=> array(
		'0'		=> 'Nieznany',//'未知',
		'1'		=> 'Światło słoneczne',//'日光',
		'2'		=> 'Fluorescencyjny',//'荧光灯',
		'3'		=> 'Tungsten',//'钨丝灯',
		'10'		=> 'Flash',//'闪光灯',
		'17'		=> 'Standardowe światło A',//'标准灯光A',
		'18'		=> 'Standardowe światło B',//'标准灯光B',
		'19'		=> 'Standardowe światło C',//'标准灯光C',
		'20'		=> 'D55',//'D55',
		'21'		=> 'D65',//'D65',
		'22'		=> 'D75',//'D75',
		'255'		=> 'Inny'//'其他'
		),
	'img_info'	=> array ('Informacje o pliku'	=> 'Brak informacji EXIF'),//array ('文件信息' => '没有图片EXIF信息'),
	
	'FileName'		=> 'Nazwa',//'文件名',
	'FileType'		=> 'Typ',//'文件类型',
	'MimeType'		=> 'Mime Type',//'文件格式',
	'FileSize'		=> 'Rozmiar',//'文件大小',
	'FileDateTime'		=> 'Data',//'时间戳',
	'ImageDescription'	=> 'Opis obrazka',//'图片说明',
	'auto'			=> 'Auto',//'自动',
	'Make'			=> 'Producent',//'制造商',
	'Model'			=> 'Model',//'型号',
	'Orientation'		=> 'Orientacja',//'方向',
	'XResolution'		=> 'Szerokość',//'水平分辨率',
	'YResolution'		=> 'Wysokość',//'垂直分辨率',
	'Software'		=> 'Oprogramowanie',//'创建软件',
	'DateTime'		=> 'Data modyfikacji',//'修改时间',
	'Artist'		=> 'Autor',//'作者',
	'YCbCrPositioning'	=> 'Pozycjonowanie YCbCr',//'YCbCr位置控制',
	'Copyright'		=> 'Prawa autorskie',//'版权',
	'Photographer'		=> 'Fotograf',//'摄影版权',
	'Editor'		=> 'Edytur',//'编辑版权',
	'ExifVersion'		=> 'Wersja Exif',//'Exif版本',
	'FlashPixVersion'	=> 'Wersja FlashPix',//'FlashPix版本',
	'DateTimeOriginal'	=> 'Data utworzenia',//'拍摄时间',
	'DateTimeDigitized'	=> 'Data przetworzenia',//'数字化时间',
	'Height'		=> 'Wysokość',//'拍摄分辨率高',
	'Width'			=> 'Szerokość',//'拍摄分辨率宽',
	'ApertureValue'		=> 'Aperture',//'光圈',
	'ShutterSpeedValue'	=> 'Shutter speed',//'快门速度',
	'ApertureFNumber'	=> 'Shutter aperture',//'快门光圈',
	'MaxApertureValue'	=> 'Maximum aperture value',//'最大光圈值',
	'ExposureTime'		=> 'Exposure time',//'曝光时间',
	'FNumber'		=> 'F-Number',//'F-Number',
	'MeteringMode'		=> 'Metering Mode',//'测光模式',
	'LightSource'		=> 'Źródło światła',//'光源',
	'Flash'			=> 'Flash',//'闪光灯',
	'ExposureMode'		=> 'Exposure mode',//'曝光模式',
	'manual'		=> 'Ręczne',//'手动',
	'WhiteBalance'		=> 'Balans bieli',//'白平衡',
	'ExposureProgram'	=> 'Ekspozycja',//'曝光程序',
	'ExposureBiasValue'	=> 'Exposure Compensation',//'曝光补偿',
	'ISOSpeedRatings'	=> 'Czułość ISO',//'ISO感光度',
	'ComponentsConfiguration'	=> 'Konfiguracja komponentów',//'分量配置',
	'CompressedBitsPerPixel'	=> 'Image compression ratio',//'图像压缩率',
	'FocusDistance'		=> 'Focus Distance',//'对焦距离',
	'FocalLength'		=> 'Focal Length',//'焦距',
	'FocalLengthIn35mmFilm'	=> 'Equivalent 35mm focal length',//'等价35mm焦距',
	'UserCommentEncoding'	=> 'Kodowanie komentarza',//'用户注释编码',
	'UserComment'		=> 'Komentarz',//'用户注释',
	'ColorSpace'		=> 'Color Space',//'色彩空间',
	'ExifImageLength'	=> 'Szerokość Exif',//'Exif图像宽度',
	'ExifImageWidth'	=> 'Wysokość Exif',//'Exif图像高度',
	'FileSource'		=> 'Źródło',//'文件来源',
	'SceneType'		=> 'Scena',//'场景类型',
	'ThumbFileType'		=> 'Format miniatury',//'缩略图文件格式',
	'ThumbMimeType'		=> 'Typ miniatury',//'缩略图Mime格式'
);

