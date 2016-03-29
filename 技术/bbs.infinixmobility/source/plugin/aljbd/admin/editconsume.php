<?php
	if(submitcheck('formhash')){
		if($_FILES['logo']['tmp_name']) {
			$picname = $_FILES['logo']['name'];
			$picsize = $_FILES['logo']['size'];
		
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
					showerror(lang('plugin/aljbd','s29'));
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$logo = "source/plugin/aljbd/images/consume/". $pics;
				if(@copy($_FILES['logo']['tmp_name'], $logo)||@move_uploaded_file($_FILES['logo']['tmp_name'], $logo)){
					@unlink($_FILES['logo']['tmp_name']);
				}
			}
		}
		$updatearray=array(
			'subject'=>$_GET['name'],
			'bid'=>$_GET['bid'],
			'jieshao'=>$_GET['jieshao'],
			'xianzhi'=>$_GET['xianzhi'],
			'end'=>strtotime($_GET['end']),
			'mianze'=>$_GET['mianze'],
		);
		if($logo){
			$updatearray['pic']=$logo;
		}
		C::t('#aljbd#aljbd_consume')->update($_GET['cid'],$updatearray);
		showmsg(lang('plugin/aljbd','s54'));
	}else{
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_GET['uid']);
		$n=C::t('#aljbd#aljbd_consume')->fetch($_GET['cid']);
		include template('aljbd:admin_consume');
	}
?>