<?php
	if(submitcheck('formhash')){
		if($_FILES['logo']['tmp_name']) {
			$picname = $_FILES['logo']['name'];
			$picsize = $_FILES['logo']['size'];
		
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
					showerror(lang('plugin/aljbd','s19'));
				}
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$logo = "source/plugin/aljbd/images/consume/". $pics;
				if(@copy($_FILES['logo']['tmp_name'], $logo)||@move_uploaded_file($_FILES['logo']['tmp_name'], $logo)){
					@unlink($_FILES['logo']['tmp_name']);
				}
			}
		}else{
			showerror(lang('plugin/aljbd','logo'));
		}
		
		
		$insertarray=array(
			'username'=>$_G['username'],
			'uid'=>$_G['uid'],
			'subject'=>$_GET['name'],
			'bid'=>$_GET['bid'],
			'pic'=>$logo,
			'jieshao'=>$_GET['jieshao'],
			'xianzhi'=>$_GET['xianzhi'],
			'start'=>TIMESTAMP,
			'end'=>strtotime($_GET['end']),
			'mianze'=>$_GET['mianze'],
			'dateline'=>TIMESTAMP,
			'type'=>$_GET['type'],
			'subtype'=>$_GET['subtype'],
		);
		C::t('#aljbd#aljbd_consume')->insert($insertarray);
		showmsg(lang('plugin/aljbd','s53'));
	}else{
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$typelist=C::t('#aljbd#aljbd_type_consume')->fetch_all_by_upid(0);
		$n=C::t('#aljbd#aljbd_consume')->fetch($_GET['cid']);
		include template('aljbd:admin_consume');
	}
?>