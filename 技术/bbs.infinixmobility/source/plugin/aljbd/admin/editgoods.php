<?php
if(submitcheck('formhash')){
	
	if(empty($_GET['bid'])){
		showerror(lang('plugin/aljbd','s51'));
	}
	if(empty($_GET['name'])){
		showerror(lang('plugin/aljbd','s52'));
	}
	if($_FILES['pic1']['tmp_name']) {
		$picname = $_FILES['pic1']['name'];
		$picsize = $_FILES['pic1']['size'];
	
		if ($picname != "") {
			$type = strstr($picname, '.');
			if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
				showerror(lang('plugin/aljbd','s19'));
			}
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic1 = "source/plugin/aljbd/images/logo/". $pics;
			if(@copy($_FILES['pic1']['tmp_name'], $pic1)||@move_uploaded_file($_FILES['pic1']['tmp_name'], $pic1)){
				$imageinfo=getimagesize($pic1);
				$w60=$imageinfo[0]<60?$imageinfo[0]:60;
				$h60=$imageinfo[1]<60?$imageinfo[1]:60;
				$w205=$imageinfo[0]<205?$imageinfo[0]:205;
				$h205=$imageinfo[1]<205?$imageinfo[1]:205;
				$w470=$imageinfo[0]<470?$imageinfo[0]:470;
				$h470=$imageinfo[1]<470?$imageinfo[1]:470;
				img2thumb($pic1,$pic1.'.60x60.jpg',$w60,$h60);
				img2thumb($pic1,$pic1.'.205x205.jpg',$w205,$h205);
				img2thumb($pic1,$pic1.'.470x470.jpg',$w470,$h470);
				@unlink($_FILES['pic1']['tmp_name']);
			}
		}
	}
	if($_FILES['pic2']['tmp_name']) {
		$picname = $_FILES['pic2']['name'];
		$picsize = $_FILES['pic2']['size'];
	
		if ($picname != "") {
			$type = strstr($picname, '.');
			
			if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
				showerror(lang('plugin/aljbd','s19'));
			}
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic2 = "source/plugin/aljbd/images/logo/". $pics;
			if(@copy($_FILES['pic2']['tmp_name'], $pic2)||@move_uploaded_file($_FILES['pic2']['tmp_name'], $pic2)){
				$imageinfo=getimagesize($pic2);
				$w60=$imageinfo[0]<60?$imageinfo[0]:60;
				$h60=$imageinfo[1]<60?$imageinfo[1]:60;
				$w205=$imageinfo[0]<205?$imageinfo[0]:205;
				$h205=$imageinfo[1]<205?$imageinfo[1]:205;
				$w470=$imageinfo[0]<470?$imageinfo[0]:470;
				$h470=$imageinfo[1]<470?$imageinfo[1]:470;
				img2thumb($pic2,$pic2.'.60x60.jpg',$w60,$h60);
				img2thumb($pic2,$pic2.'.205x205.jpg',$w205,$h205);
				img2thumb($pic2,$pic2.'.470x470.jpg',$w470,$h470);
				@unlink($_FILES['pic2']['tmp_name']);
			}
		}
	}//debug($pic2);
	if($_FILES['pic3']['tmp_name']) {
		$picname = $_FILES['pic3']['name'];
		$picsize = $_FILES['pic3']['size'];
	
		if ($picname != "") {
			$type = strstr($picname, '.');
			if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
				showerror(lang('plugin/aljbd','s19'));
			}
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic3 = "source/plugin/aljbd/images/logo/". $pics;
			if(@copy($_FILES['pic3']['tmp_name'], $pic3)||@move_uploaded_file($_FILES['pic3']['tmp_name'], $pic3)){
				$imageinfo=getimagesize($pic3);
				$w60=$imageinfo[0]<60?$imageinfo[0]:60;
				$h60=$imageinfo[1]<60?$imageinfo[1]:60;
				$w205=$imageinfo[0]<205?$imageinfo[0]:205;
				$h205=$imageinfo[1]<205?$imageinfo[1]:205;
				$w470=$imageinfo[0]<470?$imageinfo[0]:470;
				$h470=$imageinfo[1]<470?$imageinfo[1]:470;
				img2thumb($pic3,$pic3.'.60x60.jpg',$w60,$h60);
				img2thumb($pic3,$pic3.'.205x205.jpg',$w205,$h205);
				img2thumb($pic3,$pic3.'.470x470.jpg',$w470,$h470);
				@unlink($_FILES['pic3']['tmp_name']);
			}
		}
	}
	if($_FILES['pic4']['tmp_name']) {
		$picname = $_FILES['pic4']['name'];
		$picsize = $_FILES['pic4']['size'];
	
		if ($picname != "") {
			$type = strstr($picname, '.');
			if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
				showerror(lang('plugin/aljbd','s19'));
			}
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic4 = "source/plugin/aljbd/images/logo/". $pics;
			if(@copy($_FILES['pic4']['tmp_name'], $pic4)||@move_uploaded_file($_FILES['pic4']['tmp_name'], $pic4)){
				$imageinfo=getimagesize($pic4);
				$w60=$imageinfo[0]<60?$imageinfo[0]:60;
				$h60=$imageinfo[1]<60?$imageinfo[1]:60;
				$w205=$imageinfo[0]<205?$imageinfo[0]:205;
				$h205=$imageinfo[1]<205?$imageinfo[1]:205;
				$w470=$imageinfo[0]<470?$imageinfo[0]:470;
				$h470=$imageinfo[1]<470?$imageinfo[1]:470;
				img2thumb($pic4,$pic4.'.60x60.jpg',$w60,$h60);
				img2thumb($pic4,$pic4.'.205x205.jpg',$w205,$h205);
				img2thumb($pic4,$pic4.'.470x470.jpg',$w470,$h470);
				@unlink($_FILES['pic4']['tmp_name']);
			}
		}
	}
	if($_FILES['pic5']['tmp_name']) {
		$picname = $_FILES['pic5']['name'];
		$picsize = $_FILES['pic5']['size'];
	
		if ($picname != "") {
			$type = strstr($picname, '.');
			if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
				showerror(lang('plugin/aljbd','s19'));
			}
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic5 = "source/plugin/aljbd/images/logo/". $pics;
			if(@copy($_FILES['pic5']['tmp_name'], $pic5)||@move_uploaded_file($_FILES['pic5']['tmp_name'], $pic5)){
				$imageinfo=getimagesize($pic5);
				$w60=$imageinfo[0]<60?$imageinfo[0]:60;
				$h60=$imageinfo[1]<60?$imageinfo[1]:60;
				$w205=$imageinfo[0]<205?$imageinfo[0]:205;
				$h205=$imageinfo[1]<205?$imageinfo[1]:205;
				$w470=$imageinfo[0]<470?$imageinfo[0]:470;
				$h470=$imageinfo[1]<470?$imageinfo[1]:470;
				img2thumb($pic5,$pic5.'.60x60.jpg',$w60,$h60);
				img2thumb($pic5,$pic5.'.205x205.jpg',$w205,$h205);
				img2thumb($pic5,$pic5.'.470x470.jpg',$w470,$h470);
				@unlink($_FILES['pic5']['tmp_name']);
			}
		}
	}
	$updatearray=array(
		'bid'=>$_GET['bid'],
		'name'=>$_GET['name'],
		'price1'=>$_GET['price1'],
		'price2'=>$_GET['price2'],
		'intro'=>$_GET['intro'],
		'dateline'=>TIMESTAMP,
		'gwurl'=>$_GET['gwurl'],
		'type'=>$_GET['type'],
		'subtype'=>$_GET['subtype'],
	);
	if($pic1){
		$updatearray['pic1']=$pic1;
	}
	if($pic2){
		$updatearray['pic2']=$pic2;
	}
	if($pic3){
		$updatearray['pic3']=$pic3;
	}
	if($pic4){
		$updatearray['pic4']=$pic4;
	}
	if($pic5){
		$updatearray['pic5']=$pic5;
	}
	C::t('#aljbd#aljbd_goods')->update($_GET['gid'],$updatearray);
	cpmsg(lang('plugin/aljbd','s54'), 'action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=goods', 'succeed');
}else{
	//$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_GET['uid']);
	
	$typelist=C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid(0);
	$g=C::t('#aljbd#aljbd_goods')->fetch($_GET['gid']);
	include template('aljbd:editgoods');
}
?>