<?php
require_once './source/class/class_core.php';
$discuz = & discuz_core::instance();
$discuz->init();
list($w,$h)=explode("x",$_GET['size']);
$m=0;
if($w==0&&$h==0){
	$m=5;
}elseif ($h==0){
	$m=3;
}elseif ($w==0){
	$m=4;
}
/*
$w=100;//宽度
$h=75;//高度
$m=0;//缩略图模式
	//mode=0为固定宽高，画质裁切不变形
	//mode=1为固定宽高，画质会拉伸变形
	//mode=2为可变宽高，宽高不超过指定大小
	//mode=3为固定宽度，高度随比例变化
*/

//$nopic='./static/image/common/nophotosmall.gif';//缺省图片

$tid=intval($_GET['tid']);
$aid=intval($_GET['aid']);
if($tid){
$dir="data/tidpic/";
$subdir=$dir."/{$w}x{$h}x{$m}/";
$thumbfile=$subdir."/".$tid.".jpg";
if(file_exists($thumbfile)){
	header("location:{$thumbfile}");
	die();
}
$tableid=substr($tid,-1,1);

if($_GET['cover']){
	$attach=DB::fetch_first("SELECT * FROM  ".DB::table("forum_threadimage")." WHERE  `tid` ='{$tid}' LIMIT 0 , 1");
}
if(!$_GET['cover']||($_GET['cover']&&!$attach)){
	$attach=DB::fetch_first("SELECT a.tid,a.attachment,a.remote
FROM ".DB::table("forum_attachment_{$tableid}")." a
WHERE a.`tid` ='$tid'
AND a.`isimage`<>0
order by a.aid asc
limit 0,1");
}

if($attach){
	$attachurl=$attach['remote']?$_G['setting']['ftp']['attachurl']:$_G['setting']['attachurl'];
	$attachfile=$attachurl."/forum/".$attach['attachment'];
	
	if($m==5){
		header("location:{$attachfile}");
		die();
	}
	if(!is_dir($dir)) @mkdir($dir);
	if(!is_dir($subdir)) @mkdir($subdir);
	dzthumb($attachfile,$thumbfile,$w,$h,$m);
	if(file_exists($attachfile)){
		header("location:{$thumbfile}");
	}else{
		header("location:{$attachfile}");
	}
	die();
}else{
	header("location:$nopic");
	die();
}
}

//文章
if($aid){
	$dir="data/atidpic/";
	$subdir=$dir."/{$w}x{$h}x{$m}/";
	$thumbfile=$subdir."/".$aid.".jpg";
	if(file_exists($thumbfile)){
		header("location:{$thumbfile}");
		die();
	}
	$attach=DB::fetch_first("SELECT * FROM  ".DB::table("portal_attachment")." WHERE  `aid` ='{$aid}' and isimage!=0 LIMIT 0 , 1");
	if($attach){
	$attachurl=$attach['remote']?$_G['setting']['ftp']['attachurl']:$_G['setting']['attachurl'];
	$attachfile=$attachurl."/portal/".$attach['attachment'];
	if($m==5){
		header("location:{$attachfile}");
		die();
	}
	if(!is_dir($dir)) @mkdir($dir);
	if(!is_dir($subdir)) @mkdir($subdir);
	dzthumb($attachfile,$thumbfile,$w,$h,$m);
	if(file_exists($attachfile)){
		header("location:{$thumbfile}");
	}else{
		header("location:{$attachfile}");
	}
	die();
}else{
	header("location:$nopic");
	die();
}
	
}


function dzthumb($srcfile,$dstfile,$dstw,$dsth=0,$mode=0,$data=''){
	//mode=0为固定宽高，画质裁切不变形
	//mode=1为固定宽高，画质会拉伸变形
	//mode=2为可变宽高，宽高不超过指定大小
	//mode=3为固定宽度，高度随比例变化
	$data=$data==''?@GetImageSize($srcfile):$data;
	if(!$data) return false;
	if($data[2]==2) $im=@ImageCreateFromJPEG($srcfile);
	elseif ($data[2]==1) $im=@ImageCreateFromGIF($srcfile);
	elseif($data[2]==3) $im=@ImageCreateFromPNG($srcfile);
	list($img_w, $img_h) = $data;
	if($dsth==0) $mode=3;
	if($mode==0){
		$imgratio = $img_w / $img_h;
		$thumbratio = $dstw / $dsth;
		if($imgratio >= 1 && $imgratio >= $thumbratio || $imgratio < 1 && $imgratio > $thumbratio) {
			$cuty = $img_h;
			$cutx = $cuty * $thumbratio;
		} elseif($imgratio >= 1 && $imgratio <= $thumbratio || $imgratio < 1 && $imgratio < $thumbratio) {
			$cutx = $img_w;
			$cuty = $cutx / $thumbratio;
		}
		$cx = $cutx;
		$cy = $cuty;
	}elseif($mode==1){
		$cx = $img_w;
		$cy = $img_h;
	}elseif ($mode==2){
		$cx = $img_w;
		$cy = $img_h;
		$bit=$img_w/$img_h;
		if($dstw/$dsth>$bit){
			$dstw=($img_w/$img_h)*$dsth;
		}else{
			$dsth=($img_h/$img_w)*$dstw;
		}
	}
	elseif($mode==3){
		$cx = $img_w;
		$cy = $img_h;
		$dsth=$dstw * $img_h / $img_w;
	}
	elseif ($mode==4){
		$cx = $img_w;
		$cy = $img_h;
		$dstw=$dsth * $img_w / $img_h;
	}
	$ni=imagecreatetruecolor($dstw,$dsth);
	ImageCopyResampled($ni,$im,0,0,0,0,$dstw,$dsth, $cx, $cy);
	clearstatcache();
	if($data[2]==2) ImageJPEG($ni,$dstfile,100);
	elseif($data[2]==1) ImageGif($ni,$dstfile);
	elseif($data[2]==3) ImagePNG($ni,$dstfile);
	return true;
}

?>