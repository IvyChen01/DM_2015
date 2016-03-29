<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];	
}
$pluginid='aljbd';
if($_GET['act']=='edit'){
	if(submitcheck('submit')) {
		$insertarray = array(
			'name' => $_GET['name'],
			'id_card' => $_GET['id_card'],
			'qiyename' => $_GET['qiyename'],
			'email' => $_GET['email'],
			'tel' => $_GET['tel'],
			'jieshao' => $_GET['jieshao'],
			'timestamp' => TIMESTAMP,
		);
		if ($_FILES['pic']['tmp_name']) {
			$picname = $_FILES['pic']['name'];
			$picsize = $_FILES['pic']['size'];
			if ($picsize/1024>$config['img_size']) {
				showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
			}
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
					showerror(lang('plugin/aljbd','s19'));
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$img_dir = 'source/plugin/aljbd/images/logo/';
				if (!is_dir($img_dir)) {
					mkdir($img_dir);
				}
				$$pic = $img_dir . $pics;
				if (@copy($_FILES['pic']['tmp_name'], $$pic) || @move_uploaded_file($_FILES['pic']['tmp_name'], $$pic)) {
					@unlink($_FILES['pic']['tmp_name']);
				}
			}
		}
		
		if($$pic){
			$insertarray['pic'] = $$pic;
		}
		unset($$pic);
		unset($picsize);
		unset($type);
		if ($_FILES['id_pic']['tmp_name']) {
			$picname = $_FILES['id_pic']['name'];
			$picsize = $_FILES['id_pic']['size'];
			if ($picsize/1024>$config['img_size']) {
				showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
			}
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
					showerror(lang('plugin/aljbd','s19'));
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$img_dir = 'source/plugin/aljbd/images/logo/';
				if (!is_dir($img_dir)) {
					mkdir($img_dir);
				}
				$$pic = $img_dir . $pics;
				if (@copy($_FILES['id_pic']['tmp_name'], $$pic) || @move_uploaded_file($_FILES['id_pic']['tmp_name'], $$pic)) {
					
					@unlink($_FILES['id_pic']['tmp_name']);
				}
			}
		}
		
		if($$pic){
			$insertarray['id_pic'] = $$pic;
		}
		unset($$pic);
		unset($picsize);
		unset($type);
		if ($_FILES['id_pic1']['tmp_name']) {
			$picname = $_FILES['id_pic1']['name'];
			$picsize = $_FILES['id_pic1']['size'];
			if ($picsize/1024>$config['img_size']) {
				showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
			}
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
					showerror(lang('plugin/aljbd','s19'));
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$img_dir = 'source/plugin/aljbd/images/logo/';
				if (!is_dir($img_dir)) {
					mkdir($img_dir);
				}
				$$pic = $img_dir . $pics;
				if (@copy($_FILES['id_pic1']['tmp_name'], $$pic) || @move_uploaded_file($_FILES['id_pic1']['tmp_name'], $$pic)) {
					
					@unlink($_FILES['id_pic1']['tmp_name']);
				}
			}
		}
		
		if($$pic){
			$insertarray['id_pic1'] = $$pic;
		}
		unset($$pic);
		unset($picsize);
		unset($type);
		if ($_FILES['ban_pic']['tmp_name']) {
			$picname = $_FILES['ban_pic']['name'];
			$picsize = $_FILES['ban_pic']['size'];
			if ($picsize/1024>$config['img_size']) {
				showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
			}
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
					showerror(lang('plugin/aljbd','s19'));
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$img_dir = 'source/plugin/aljbd/images/logo/';
				if (!is_dir($img_dir)) {
					mkdir($img_dir);
				}
				$$pic = $img_dir . $pics;
				if (@copy($_FILES['ban_pic']['tmp_name'], $$pic) || @move_uploaded_file($_FILES['ban_pic']['tmp_name'], $$pic)) {
					
					@unlink($_FILES['ban_pic']['tmp_name']);
				}
			}
		}
		
		if($$pic){
			$insertarray['ban_pic'] = $$pic;
		}
		C::t('#aljbd#aljbd_attestation')->update($_GET['uid'], $insertarray);
		cpmsg(lang('plugin/aljbd','s41'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=attestation', 'succeed');
	}else{
		$lp	=C::t('#aljbd#aljbd_attestation')->fetch($_GET['bid']);
		include template('aljbd:attesedit');
	}
}else if($_GET['act']=='yes'){
	if(!submitcheck('submit')) {
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=$config['page'];
		$num=C::t('#aljbd#aljbd_attestation')->count_by_status(1);
		$start=($currpage-1)*$perpage;
		$atlist=C::t('#aljbd#aljbd_attestation')->fetch_all_by_status(1,$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=attestation&act=yes', 0, 11, false, false);
		include template('aljbd:admin_attes');
	}else{
		if(is_array($_POST['delete'])) {
			foreach($_POST['delete'] as $id) {
				C::t('#aljbd#aljbd_attestation')->delete($id);
			}
		}
		cpmsg(lang('plugin/aljbd','s41'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=attestation&act=yes', 'succeed');
		
	}
}else{

	if(!submitcheck('sh_submit')&&!submitcheck('del_submit')) {
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=$config['page'];
		$num=C::t('#aljbd#aljbd_attestation')->count_by_status(0);
		$start=($currpage-1)*$perpage;
		$atlist=C::t('#aljbd#aljbd_attestation')->fetch_all_by_status(0,$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=attestation', 0, 11, false, false);	
		include template('aljbd:admin_attes');
		
	}else{
		if(submitcheck('del_submit')){
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					C::t('#aljbd#aljbd_attestation')->delete($id);
				}
			}
		}
		if(submitcheck('sh_submit')){
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					DB::update('aljbd_attestation',array('sign'=>1),'uid='.$id);
				}
			}
		}
		
		cpmsg(lang('plugin/aljbd','s41'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=attestation', 'succeed');
	}
}

?>