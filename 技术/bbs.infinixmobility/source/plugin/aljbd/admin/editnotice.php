<?php
	if(submitcheck('formhash')){
		if(empty($_GET['bid'])){
			showerror(lang('plugin/aljbd','s51'));
		}
		if(empty($_GET['subject'])){
			showerror(lang('plugin/aljbd','aljbd_1'));
		}
		if(empty($_GET['intro'])){
			showerror(lang('plugin/aljbd','aljbd_2'));
		}
		$updatearray=array(
			'bid'=>$_GET['bid'],
			'username'=>$_G['username'],
			'subject'=>$_GET['subject'],
			'content'=>$_GET['intro'],
			'dateline'=>TIMESTAMP,
		);
		C::t('#aljbd#aljbd_notice')->update($_GET['nid'],$updatearray);
		showmsg(lang('plugin/aljbd','s54'));
	}else{
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$n=C::t('#aljbd#aljbd_notice')->fetch($_GET['nid']);
		include template('aljbd:editnotice');
	}
?>