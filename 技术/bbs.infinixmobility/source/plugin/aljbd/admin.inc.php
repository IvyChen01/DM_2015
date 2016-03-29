<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];	
}
$pluginid='aljbd';
$bdlist=C::t('#aljbd#aljbd')->range();
if($_GET['act']!='mark'){
	include template('aljbd:admin_nav');
}
$businesstype = explode ("\n", str_replace ("\r", "", $config ['businesstype']));
foreach($businesstype as $key=>$value){
	$arr=explode('=',$value);
	$businesstypearr[$arr[0]]=$arr[1];
}
if($_GET['brand']=='yhzqx'){
	
	include_once 'source/plugin/aljbd/com/yhzqx.php';
	
}else if($_GET['brand']=='seo'){
	
	include_once 'source/plugin/aljbd/com/seo.php';
	
}else if($_GET['brand']=='attestation'){
	
	include_once 'source/plugin/aljbd/admin/attestation.inc.php';
	
}else if($_GET['brand']=='consume'){
		if($_GET['act']=='comment_consume'){
			if($_GET['del']=='yes'){
				C::t('#aljbd#aljbd_comment_consume')->delete($_GET['cid']);
			}
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$num=C::t('#aljbd#aljbd_comment_consume')->count_by_bid_all($_GET['nid']);
			$commentlist=C::t('#aljbd#aljbd_comment_consume')->fetch_all_by_bid_page($_GET['nid'],$start,$perpage);
			
			$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=consume&act=comment_consume&nid='.$_GET['nid'], 0, 11, false, false);
			include template('aljbd:admin_comment_consume');
		}else if($_GET['act']=='editconsume'){
			include_once 'source/plugin/aljbd/admin/editconsume.php';
		}else if($_GET['act']=='addconsume'){
			include_once 'source/plugin/aljbd/admin/addconsume.php';
		}else{
			if(!submitcheck('submit')) {
				showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=consume');
				showtableheader();
				showsubtitle(array('',lang('plugin/aljbd','admin_14'),lang('plugin/aljbd','admin_2'), lang('plugin/aljbd','admin_3'),lang('plugin/aljbd','admin_4'),lang('plugin/aljbd','t1').lang('plugin/aljbd','admin_5')));
				$currpage=$_GET['page']?$_GET['page']:1;
				$perpage=10;
				$start=($currpage-1)*$perpage;
				echo '<script>disallowfloat = \'newthread\';</script>';
				$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljbd_consume'));
				$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin&brand=consume", 0, 10, false, false);
				$query = DB::query("SELECT * FROM ".DB::table('aljbd_consume')." ORDER BY id desc limit $start,$perpage");
				while($row = DB::fetch($query)) {
					if($row[sign]){
						$che[$row[id]]='checked="checked"';
					}
					$start=date('Y-m-d H:i:s',$row['dateline']);
					showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(							
									"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
									'<a target="_blank" href="plugin.php?id=aljbd&act=consumeview&bid='.$row['bid'].'&cid='.$row['id'].'">'.$row['subject'].'</a>',	
									$bdlist[$row['bid']]['name'],	
									$row['username'],			
									$start,		
									'<input class="checkbox" type="checkbox" name="sign['.$row[id].']" '.$che[$row[id]].' value="1">&nbsp;&nbsp;&nbsp;<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=consume&act=editconsume&cid='.$row[id].'&uid='.$row[uid].'" >'.lang('plugin/aljbd','admin_6').'</a>&nbsp;<a href="admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=consume&act=comment_consume&nid='.$row[id].'" onclick="showWindow(\'edit\',this.href)">'.lang('plugin/aljbd','admin_7').'</a>',		
									));
					
				}
				echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=consume&act=addconsume" class="addtr">'.lang('plugin/aljbd','index_5').'</a></div></td></tr>';
				showsubmit('submit', 'submit', 'del','',$paging);
				showtablefooter();
				showformfooter();
				
				
			}else{
				
				if(is_array($_POST['delete'])) {
					foreach($_POST['delete'] as $id) {
						C::t('#aljbd#aljbd_consume')->delete($id);
					}
				}
				foreach($_POST['myid'] as $id) {
					DB::update('aljbd_consume',array('sign'=>$_POST['sign'][$id]),'id='.$id);
				}
				cpmsg(lang('plugin/aljbd','s13'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=consume', 'succeed');
			}
		}
	
}else if($_GET['brand']=='notice'){
		if($_GET['act']=='comment_notice'){
			if($_GET['del']=='yes'){
				C::t('#aljbd#aljbd_comment_notice')->delete($_GET['cid']);
			}
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$num=C::t('#aljbd#aljbd_comment_notice')->count_by_bid_all($_GET['nid']);
			$commentlist=C::t('#aljbd#aljbd_comment_notice')->fetch_all_by_bid_page($_GET['nid'],$start,$perpage);
			
			$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=notice&act=comment_notice&nid='.$_GET['nid'], 0, 11, false, false);
			include template('aljbd:admin_comment_notice');
		}else if($_GET['act']=='editnotice'){
			include_once 'source/plugin/aljbd/admin/editnotice.php';
		}else if($_GET['act']=='addnotice'){
			include_once 'source/plugin/aljbd/admin/addnotice.php';
		}else{
			if(!submitcheck('submit')) {
				showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=notice');
				showtableheader();
				showsubtitle(array('',lang('plugin/aljbd','admin_1'),lang('plugin/aljbd','admin_2'), lang('plugin/aljbd','admin_3'),lang('plugin/aljbd','admin_4'),lang('plugin/aljbd','t1').lang('plugin/aljbd','admin_5')));
				$currpage=$_GET['page']?$_GET['page']:1;
				$perpage=10;
				$start=($currpage-1)*$perpage;
				echo '<script>disallowfloat = \'newthread\';</script>';
				$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljbd_notice'));
				$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin&brand=notice", 0, 10, false, false);
				$query = DB::query("SELECT * FROM ".DB::table('aljbd_notice')." ORDER BY id desc limit $start,$perpage");
				while($row = DB::fetch($query)) {
					if($row[sign]){
						$che[$row[id]]='checked="checked"';
					}
					$start=date('Y-m-d H:i:s',$row['dateline']);
					showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(							
									"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
									'<a target="_blank" href="plugin.php?id=aljbd&act=noticeview&bid='.$row['bid'].'&nid='.$row['id'].'">'.$row['subject'].'</a>',	
									$bdlist[$row['bid']]['name'],	
									$row['username'],			
									$start,		
									'<input class="checkbox" type="checkbox" name="sign['.$row[id].']" '.$che[$row[id]].' value="1">&nbsp;&nbsp;&nbsp;<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=notice&act=editnotice&nid='.$row[id].'&uid='.$row[uid].'">'.lang('plugin/aljbd','admin_6').'</a>&nbsp;<a href="admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=notice&act=comment_notice&nid='.$row[id].'" onclick="showWindow(\'edit\',this.href)">'.lang('plugin/aljbd','admin_7').'</a>',		
									));
					
				}
				echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=notice&act=addnotice" class="addtr">'.lang('plugin/aljbd','index_6').'</a></div></td></tr>';
				showsubmit('submit', 'submit', 'del','',$paging);
				showtablefooter();
				showformfooter();
				
				
			}else{
				
				if(is_array($_POST['delete'])) {
					foreach($_POST['delete'] as $id) {
						C::t('#aljbd#aljbd_notice')->delete($id);
					}
				}
				foreach($_POST['myid'] as $id) {
					DB::update('aljbd_notice',array('sign'=>$_POST['sign'][$id]),'id='.$id);
				}
				cpmsg(lang('plugin/aljbd','s13'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=notice', 'succeed');
			}
		}
	
}else if($_GET['brand']=='album'){
	if($_GET['act']=='admin_fm'){
		$apic=C::t('#aljbd#aljbd_album_attachments')->fetch($_GET['atid']);
		DB::query("UPDATE ".DB::table('aljbd_album')." SET subjectimage='".$apic['pic']."' WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
		showmsg(lang('plugin/aljbd','s53'));
	}else if($_GET['act']=='adminaedit'){
		
		if(submitcheck('formhash')){
			if(empty($_GET['bid'])){
				showerror(lang('plugin/aljbd','s51'));
			}
			if(empty($_GET['albumname'])){
				showerror(lang('plugin/aljbd','album_1'));
			}
			$updatearray=array(
				'bid'=>$_GET['bid'],
				'username'=>$_G['username'],
				'albumname'=>$_GET['albumname'],
				'description'=>$_GET['description'],
				'dateline'=>TIMESTAMP,
				'displayorder'=>'100',
			);
			C::t('#aljbd#aljbd_album')->update($_GET['aid'],$updatearray);
			showmsg(lang('plugin/aljbd','s53'));
		}else{
			$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','','');
			$a=C::t('#aljbd#aljbd_album')->fetch($_GET['aid']);
			include template('aljbd:admin_addalbum');
		}
	}else if($_GET['act']=='admin_addimg'){
		
		if(submitcheck('formhash')){
			if(empty($_GET['aid'])){
				showerror(lang('plugin/aljbd','album_2'));
			}
			if($_FILES['pic']['tmp_name']) {
				$picname = $_FILES['pic']['name'];
				$picsize = $_FILES['pic']['size'];
			
				if ($picname != "") {
					$type = strstr($picname, '.');
					if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
						showerror(lang('plugin/aljbd','s19'));
					}
					$rand = rand(100, 999);
					$pics = date("YmdHis") . $rand . $type;
					$pic1 = "source/plugin/aljbd/images/album/". $pics;
					if(@copy($_FILES['pic']['tmp_name'], $pic1)||@move_uploaded_file($_FILES['pic']['tmp_name'], $pic1)){
						$imageinfo=getimagesize($pic1);
						$w60=$imageinfo[0]<72?$imageinfo[0]:72;
						$h60=$imageinfo[1]<72?$imageinfo[1]:72;
						$w205=$imageinfo[0]<100?$imageinfo[0]:100;
						$h205=$imageinfo[1]<100?$imageinfo[1]:100;
						$w470=$imageinfo[0]<550?$imageinfo[0]:550;
						$h470=$imageinfo[1]<550?$imageinfo[1]:550;
						img2thumb($pic1,$pic1.'.72x72.jpg',$w60,$h60);
						img2thumb($pic1,$pic1.'.100x100.jpg',$w205,$h205);
						img2thumb($pic1,$pic1.'.550x550.jpg',$w470,$h470);
						@unlink($_FILES['pic']['tmp_name']);
					}
				}
			}else{
				showerror(lang('plugin/aljbd','album_3'));
			}
			//debug($pic1);
			$apic=C::t('#aljbd#aljbd_album')->fetch($_GET['aid']);
			if(!$apic['subjectimage']){
				DB::query("UPDATE ".DB::table('aljbd_album')." SET subjectimage='".$pic1."' WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
			}
			DB::query("UPDATE ".DB::table('aljbd_album')." SET picnum=picnum+1 WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
			DB::query("UPDATE ".DB::table('aljbd_album')." SET lastpost=".$_G['timestamp']." WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
			C::t('#aljbd#aljbd_album_attachments')->insert(array(
					'bid'=>$_GET['bid'],
					'uid'=>$_GET['uid'],
					'aid'=>$_GET['aid'],
					'pic'=>$pic1,
					'dateline'=>TIMESTAMP,
					'displayorder'=>'100',
					'alt'=>$_GET['alt'],
			));
			showmsg(lang('plugin/aljbd','s53'));
		}else{
			if($_GET['bid']){
				$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
			}
			$alist=C::t('#aljbd#aljbd_album')->range();
			include template('aljbd:admin_addimg');
		}
	}else if($_GET['act']=='editalbum'){
		if(!submitcheck('submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album&act=editalbum&aid='.$_GET['aid']);
			showtableheader('<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album">'.lang('plugin/aljbd','admin_9').'</a>');
			showsubtitle();
			
			$a=C::t('#aljbd#aljbd_album')->range();
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=20;
			$allpage=ceil($num/$perpage);
			$start=($currpage-1)*$perpage;
			$num=C::t('#aljbd#aljbd_album_attachments')->count_by_uid_bid('',$_GET['aid']);
			$alist=C::t('#aljbd#aljbd_album_attachments')->fetch_all_by_uid_bid('',$_GET['aid'],$start,$perpage);
			$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album&act=editalbum&aid='.$_GET['aid'], 0, 11, false, false);
			include template('aljbd:adminalbumall');
			
			//showsubmit('submit', 'submit', 'del','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					$al=C::t('#aljbd#aljbd_album_attachments')->fetch($id);
					if($al){
						unlink($al['pic']);
						unlink($al['pic'].'.72x72.jpg');
						unlink($al['pic'].'.100x100.jpg');
						unlink($al['pic'].'.550x550.jpg');
						C::t('#aljbd#aljbd_album_attachments')->delete($id);
					}
					DB::query("UPDATE ".DB::table('aljbd_album')." SET picnum=picnum-1 WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
					if(!DB::result_first("select count(*) from ".DB::table('aljbd_album_attachments')." where aid=".$_GET['aid'])){
						DB::query("UPDATE ".DB::table('aljbd_album')." SET subjectimage='' WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
						DB::query("UPDATE ".DB::table('aljbd_album')." SET picnum=0 WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
					}
				}
			}
			cpmsg(lang('plugin/aljbd','admin_8'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album&act=editalbum&aid='.$_GET['aid'], 'succeed');
		}
	}else{
		if(!submitcheck('submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album');
			showtableheader();
			showsubtitle();
			echo '<script>disallowfloat = \'newthread\';</script>';
			$bdlist=C::t('#aljbd#aljbd')->range();
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=20;
			$allpage=ceil($num/$perpage);
			$start=($currpage-1)*$perpage;
			$num=C::t('#aljbd#aljbd_album')->count_by_uid_bid('','');
			$alist=C::t('#aljbd#aljbd_album')->fetch_all_by_uid_bid('','',$start,$perpage);
			$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album', 0, 11, false, false);
			include template('aljbd:adminalbumlist');
			
			//showsubmit('submit', 'submit', 'del','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					//C::t('#aljbd#aljbd_album')->delete($id);
					if(C::t('#aljbd#aljbd_album_attachments')->conut_by_aid($id)){
						foreach(C::t('#aljbd#aljbd_album_attachments')->fetch_all_by_status(' where aid='.$id) as $atid){
							unlink($atid['pic']);
							unlink($atid['pic'].'.72x72.jpg');
							unlink($atid['pic'].'.100x100.jpg');
							unlink($atid['pic'].'.550x550.jpg');
							C::t('#aljbd#aljbd_album_attachments')->delete($atid['id']);
						}
					}
					C::t('#aljbd#aljbd_album')->delete($id);
				}
			}
			cpmsg(lang('plugin/aljbd','admin_8'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=album', 'succeed');
		}
	}
}else if($_GET['brand']=='goods'){
	if($_GET['act']=='editgoods'){
		include_once 'source/plugin/aljbd/admin/editgoods.php';
	}else if($_GET['act']=='addshop'){
		include_once 'source/plugin/aljbd/admin/addshop.php';
	}else{
		if(!submitcheck('submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=goods');
			showtableheader();
			showsubtitle(array('',lang('plugin/aljbd','admin_10'),lang('plugin/aljbd','admin_2'), lang('plugin/aljbd','admin_11'),lang('plugin/aljbd','admin_12'),lang('plugin/aljbd','admin_13'),lang('plugin/aljbd','t1').lang('plugin/aljbd','admin_5')));
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljbd_goods'));
			$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin&brand=goods", 0, 10, false, false);
			$query = DB::query("SELECT * FROM ".DB::table('aljbd_goods')." ORDER BY id desc limit $start,$perpage");
			while($row = DB::fetch($query)) {
				if($row[sign]){
					$che[$row[id]]='checked="checked"';
				}
				$start=date('Y-m-d H:i:s',$row['dateline']);
				showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(							
								"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
								'<a target="_blank" href="plugin.php?id=aljbd&act=goodview&bid='.$row['bid'].'&gid='.$row['id'].'">'.$row['name'].'</a>',	
								$bdlist[$row['bid']]['name'],	
								$row['price1'],		
								$row['price2'],		
								$start,		
								'<input class="checkbox" type="checkbox" name="sign['.$row[id].']" '.$che[$row[id]].' value="1">&nbsp;&nbsp;&nbsp;<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=goods&act=editgoods&gid='.$row[id].'&uid='.$row[uid].'">'.lang('plugin/aljbd','admin_6').'</a>',		
								));
				
			}
			echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="admin.php?action=plugins&operation=config&identifier=aljbd&pmod=admin&brand=goods&act=addshop" class="addtr">'.lang('plugin/aljbd','index_7').'</a></div></td></tr>';
			showsubmit('submit', 'submit', 'del','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			//debug($_POST);
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					C::t('#aljbd#aljbd_goods')->delete($id);
				}
			}
			foreach($_POST['myid'] as $id) {
				DB::update('aljbd_goods',array('sign'=>$_POST['sign'][$id]),'id='.$id);
			}
			
			cpmsg(lang('plugin/aljbd','s13'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&brand=goods', 'succeed');
		}
	}
}else{
	if($_GET['act']=='yes'){
		if(!submitcheck('submit')) {
			$typelist=C::t('#aljbd#aljbd_type')->range();
			$rlist=C::t('#aljbd#aljbd_region')->range();
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=$config['page'];
			$num=C::t('#aljbd#aljbd')->count_by_status(1);
			$start=($currpage-1)*$perpage;
			$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,$start,$perpage);
			$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=yes', 0, 11, false, false);
			include template('aljbd:admin');
		}else{
			
			if(is_array($_POST['displayorder'])) {
				foreach($_POST['displayorder'] as $k=>$id) {
					C::t('#aljbd#aljbd')->update_displayorder_by_id($k,$id);
				}
			}
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					C::t('#aljbd#aljbd')->delete($id);
				}
			}
			cpmsg(lang('plugin/aljbd','s41'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&act=yes', 'succeed');
			
		}
	}else if($_GET['act']=='pass'){
		C::t('#aljbd#aljbd')->update_status_by_id($_GET['bid'],1);
		cpmsg(lang('plugin/aljbd','s11'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin', 'succeed');
	}else if($_GET['act']=='refuse'){
		C::t('#aljbd#aljbd')->update_status_by_id($_GET['bid'],0);
		cpmsg(lang('plugin/aljbd','s11'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=yes', 'succeed');
	}else if($_GET['act']=='recommend'){
		C::t('#aljbd#aljbd')->update_recommend_by_id($_GET['bid'],1);
		cpmsg(lang('plugin/aljbd','s11'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=yes', 'succeed');
	}else if($_GET['act']=='unrecommend'){
		C::t('#aljbd#aljbd')->update_recommend_by_id($_GET['bid'],0);
		cpmsg(lang('plugin/aljbd','s11'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=yes', 'succeed');
	}else if($_GET['act']=='delete'){
		if($_GET['bid']){
			C::t('#aljbd#aljbd')->delete($_GET['bid']);
		}
		cpmsg(lang('plugin/aljbd','s50'),'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=yes');
	}else if($_GET['act']=='edit'){
		if(submitcheck('submit')){
			if($_FILES['logo']['tmp_name']) {
				$picname = $_FILES['logo']['name'];
				$picsize = $_FILES['logo']['size'];
			
				if ($picname != "") {
					$type = strstr($picname, '.');
					if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
						showerror(lang('plugin/aljbd','s12'));
					}
					$rand = rand(100, 999);
					$pics = date("YmdHis") . $rand . $type;
					$logo = "source/plugin/aljbd/images/logo/". $pics;
					if(@copy($_FILES['logo']['tmp_name'], $logo)||@move_uploaded_file($_FILES['logo']['tmp_name'], $logo)){
						@unlink($_FILES['logo']['tmp_name']);
					}
				}
			}
			$updatearray=array(
				'username'=>$_GET['username'],
				'uid'=>$_GET['uid'],
				'name'=>$_GET['name'],
				'tel'=>$_GET['tel'],
				'addr'=>$_GET['addr'],
				'intro'=>$_GET['intro'],
				'other'=>$_GET['other'],
				'type'=>$_GET['type'],
				'subtype'=>$_GET['subtype'],
				'region'=>$_GET['region'],
				'region1'=>$_GET['region1'],
				'subregion'=>$_GET['subregion'],
				'qq'=>$_GET['qq'],
				'wurl'=>$_GET['wurl'],
			);
			if($logo){
				$updatearray['logo']=$logo;
			}
			C::t('#aljbd#aljbd')->update($_GET['bid'],$updatearray);
			cpmsg(lang('plugin/aljbd','s13'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=edit&bid='.$_GET['bid'], 'succeed');
		}else{
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
			$typelist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
			$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid();
			include template('aljbd:aedit');
		}
	}else if($_GET['act']=='addbrand'){
		if(submitcheck('submit')){
			$bd=C::t('#aljbd#aljbd')->fetch_by_uid($_G['uid']);
			if(!$_GET['name']){
				cpmsg(lang('plugin/aljbd','aljbd_3'));
			}
			if(!$_GET['type']){
				cpmsg(lang('plugin/aljbd','aljbd_4'));
			}
			if(!$_GET['region']){
				cpmsg(lang('plugin/aljbd','aljbd_5'));
			}
			if($_FILES['logo']['tmp_name']) {
				$picname = $_FILES['logo']['name'];
				$picsize = $_FILES['logo']['size'];
			
				if ($picname != "") {
					$type = strstr($picname, '.');
					if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
						cpmsg(lang('plugin/aljbd','s19'));
					}
					if (($picsize/1024)>$config['img_size']) {
						cpmsg(lang('plugin/aljbd','img1').$config['img_size'].'KB');
					}
					$rand = rand(100, 999);
					$pics = date("YmdHis") . $rand . $type;
					$logo = "source/plugin/aljbd/images/logo/". $pics;
					if(@copy($_FILES['logo']['tmp_name'], $logo)||@move_uploaded_file($_FILES['logo']['tmp_name'], $logo)){
						@unlink($_FILES['logo']['tmp_name']);
					}
				}
			}
			
			if($config['islogo']){
				if(!$_FILES['logo']['tmp_name']) {
					cpmsg(lang('plugin/aljbd','logo'));
				}
			}
			if(in_array($_G['groupid'],unserialize($config['mgroups']))){
				$status=1;
			}
			if($config['yushe']){
				$_GET['intro']=str_replace ("\r\n", "<br/>", $_GET['intro']);
			}
			$insertarray=array(
				'username'=>$_G['username'],
				'uid'=>$_G['uid'],
				'name'=>$_GET['name'],
				'tel'=>$_GET['tel'],
				'logo'=>$logo,
				'addr'=>$_GET['addr'],
				'intro'=>$_GET['intro'],
				'other'=>$_GET['other'],
				'type'=>$_GET['type'],
				'subtype'=>$_GET['subtype'],
				'region'=>$_GET['region'],
				'region1'=>$_GET['region1'],
				'subregion'=>$_GET['subregion'],
				'qq'=>$_GET['qq'],
				'wurl'=>$_GET['wurl'],
				'business_hours'=>$_GET['business_hours'],
				'bus_routes'=>$_GET['bus_routes'],
				'status'=>$status,
				'dateline'=>TIMESTAMP
			);
			$insertid =C::t('#aljbd#aljbd')->insert($insertarray, true);
			cpmsg(lang('plugin/aljbd','s13'), 'action=plugins&operation=config&identifier=aljbd&pmod=admin&act='.$_GET['act'], 'succeed');
		}else{
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
			$typelist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
			$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid();
			include template('aljbd:aedit');
		}
	}else if($_GET['act']=='addbrand'){
		if(submitcheck('submit')){
			$bd=C::t('#aljbd#aljbd')->fetch_by_uid($_G['uid']);
			if(!$_GET['name']){
				cpmsg(lang('plugin/aljbd','aljbd_3'));
			}
			if(!$_GET['type']){
				cpmsg(lang('plugin/aljbd','aljbd_4'));
			}
			if(!$_GET['region']){
				cpmsg(lang('plugin/aljbd','aljbd_5'));
			}
			if($_FILES['logo']['tmp_name']) {
				$picname = $_FILES['logo']['name'];
				$picsize = $_FILES['logo']['size'];
			
				if ($picname != "") {
					$type = strstr($picname, '.');
					if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
						cpmsg(lang('plugin/aljbd','s19'));
					}
					if (($picsize/1024)>$config['img_size']) {
						cpmsg(lang('plugin/aljbd','img1').$config['img_size'].'KB');
					}
					$rand = rand(100, 999);
					$pics = date("YmdHis") . $rand . $type;
					$logo = "source/plugin/aljbd/images/logo/". $pics;
					if(@copy($_FILES['logo']['tmp_name'], $logo)||@move_uploaded_file($_FILES['logo']['tmp_name'], $logo)){
						@unlink($_FILES['logo']['tmp_name']);
					}
				}
			}
			
			if($config['islogo']){
				if(!$_FILES['logo']['tmp_name']) {
					cpmsg(lang('plugin/aljbd','logo'));
				}
			}
			if(in_array($_G['groupid'],unserialize($config['mgroups']))){
				$status=1;
			}
			if($config['yushe']){
				$_GET['intro']=str_replace ("\r\n", "<br/>", $_GET['intro']);
			}
			$insertarray=array(
				'username'=>$_G['username'],
				'uid'=>$_G['uid'],
				'name'=>$_GET['name'],
				'tel'=>$_GET['tel'],
				'logo'=>$logo,
				'addr'=>$_GET['addr'],
				'intro'=>$_GET['intro'],
				'other'=>$_GET['other'],
				'type'=>$_GET['type'],
				'subtype'=>$_GET['subtype'],
				'region'=>$_GET['region'],
				'region1'=>$_GET['region1'],
				'subregion'=>$_GET['subregion'],
				'qq'=>$_GET['qq'],
				'business_hours'=>$_GET['business_hours'],
				'bus_routes'=>$_GET['bus_routes'],
				'wurl'=>$_GET['wurl'],
				'status'=>$status,
				'dateline'=>TIMESTAMP
			);
			$insertid =C::t('#aljbd#aljbd')->insert($insertarray, true);
			cpmsg(lang('plugin/aljbd','s13'), 'action=plugins&operation=config&identifier=aljbd&pmod=admin&act='.$_GET['act'], 'succeed');
		}else{
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
			$typelist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
			$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid();
			include template('aljbd:aedit');
		}
	}else if($_GET['act']=='dianping'){
		include template('aljbd:dianping');
	}else if($_GET['act']=='commentlist'){
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=10;
		$start=($currpage-1)*$perpage;
		$num=C::t('#aljbd#aljbd_comment')->count_by_bid_all($_GET['bid']);
		$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_page($_GET['bid'],$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=commentlist&bid='.$_GET['bid'], 0, 11, false, false);
		include template('aljbd:admincommentlist');
	}else if($_GET['act']=='deletecomment'){
		C::t('#aljbd#aljbd_comment')->delete($_GET['cid']);
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=10;
		$num=C::t('#aljbd#aljbd_comment')->count_by_bid_all($_GET['bid']);
		$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_page($_GET['bid'],$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin&act=commentlist&bid='.$_GET['bid'], 0, 11, false, false);
		include template('aljbd:commentlist');
	}else if($_GET['act']=='adv'){
		if(submitcheck('formhash')){
			for($i=1;$i<=3;$i++){
				if($_FILES['adv']['tmp_name'][$i]) {
					$picname = $_FILES['adv']['name'][$i];
					$picsize = $_FILES['adv']['size'][$i];
				
					if ($picname != "") {
						$type = strstr($picname, '.');
						if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
							showerror(lang('plugin/aljbd','s12'));
						}
						$rand = rand(100, 999);
						$pics = date("YmdHis") . $rand . $type;
						$dir='source/plugin/aljbd/images/adv/';
						if(!is_dir($dir)) {
							@mkdir($dir, 0777);
						}
						$adv[$i] = $dir. $pics;
						if(@copy($_FILES['adv']['tmp_name'][$i], $adv[$i])||@move_uploaded_file($_FILES['adv']['tmp_name'][$i], $adv[$i])){
							@unlink($_FILES['adv']['tmp_name'][$i]);
						}
					}
				}
			}
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
			$badv=unserialize($bd['adv']);
			$badvurl=unserialize($bd['advurl']);
			if($_GET['advdelete']){
				foreach($_GET['advdelete'] as $k=>$d){
					unset($badv[$k]);
				}
			}
			if(empty($adv)){
				$adv=$badv;
			}
			C::t('#aljbd#aljbd')->update($_GET['bid'],array('advurl'=>serialize($_GET['advurl']),'adv'=>serialize($adv)));
			showmsg(lang('plugin/aljbd','s14'),'edit');
		}
		$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		$adv=unserialize($bd['adv']);
		$advurl=unserialize($bd['advurl']);
		include template('aljbd:adminadv');
	}else if($_GET['act']=='gg'){
		if(submitcheck('formhash')){
			C::t('#aljbd#aljbd')->update($_GET['bid'],array('gg'=>$_GET['gg']));
			showmsg(lang('plugin/aljbd','s15'),'edit');
		}
		$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		include template('aljbd:admingg');
	}else if($_GET['act']=='mark'){
		$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		//debug();
		if(submitcheck('formhash','get')){
			if($bd['uid']!=$_G['uid']&&$_G['groupid']!=1){
				C::t('#aljbd#aljbd_point')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'bid'=>$_GET['bid'],'name'=>$bd['name'],'x'=>$_GET['x'],'y'=>$_GET['y'],'dateline'=>TIMESTAMP));
				echo lang('plugin/aljbd','s16');
			}else{
				C::t('#aljbd#aljbd')->update($_GET['bid'],array('x'=>$_GET['x'],'y'=>$_GET['y']));
				echo lang('plugin/aljbd','s17');
			}
		}else{
			include template('aljbd:adminmark');
		}
	}else if($_GET['act']=='iwantclaim'){
		if(submitcheck('formhash')){
			if(empty($_GET['name'])){
				showerror(lang('plugin/aljbd','s47'));
			}
			$user=C::t('common_member')->fetch_by_username($_GET['name']);
			if(empty($user)){
				showerror(lang('plugin/aljbd','s48'));
			}
			C::t('#aljbd#aljbd')->update($_GET['bid'],array('uid'=>$user['uid'],'username'=>$_GET['name']));
			DB::update('aljbd_album',array('uid'=>$user['uid'],'username'=>$_GET['name']),'bid='.$_GET['bid']);
			DB::update('aljbd_consume',array('uid'=>$user['uid'],'username'=>$_GET['name']),'bid='.$_GET['bid']);
			DB::update('aljbd_notice',array('uid'=>$user['uid'],'username'=>$_GET['name']),'bid='.$_GET['bid']);
			DB::update('aljbd_goods',array('uid'=>$user['uid']),'bid='.$_GET['bid']);
			DB::update('aljbd_album_attachments',array('uid'=>$user['uid']),'bid='.$_GET['bid']);
			showmsg(lang('plugin/aljbd','s49'));
		}else{
			include template('aljbd:adminiwantclaim');
		}
	}else{

		if(!submitcheck('sh_submit')&&!submitcheck('del_submit')) {
			$typelist=C::t('#aljbd#aljbd_type')->range();
			$rlist=C::t('#aljbd#aljbd_region')->range();
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=$config['page'];
			$num=C::t('#aljbd#aljbd')->count_by_status(0);
			$start=($currpage-1)*$perpage;
			$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(0,$start,$perpage);
			$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=admin', 0, 11, false, false);	
			include template('aljbd:admin');
			
		}else{
			if(submitcheck('del_submit')){
				if(is_array($_POST['delete'])) {
					foreach($_POST['delete'] as $id) {
						C::t('#aljbd#aljbd')->delete($id);
					}
				}
			}
			if(submitcheck('sh_submit')){
				if(is_array($_POST['delete'])) {
					foreach($_POST['delete'] as $id) {
						C::t('#aljbd#aljbd')->update_status_by_id($id,1);
					}
				}
			}
			
			cpmsg(lang('plugin/aljbd','s41'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin', 'succeed');
		}
	}
}
function showmsg($msg,$close){
	if($close){
		$str="parent.hideWindow('$close');";
	}else{
		$str="parent.location=parent.location;";
	}
	include template('aljbd:showmsg');
	exit;
}
function showerror($msg){
	include template('aljbd:showerror');
	exit;
}
function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
    if(!is_file($src_img))
    {
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;

    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
    {
        $proportion = 1;
    }
    if($width> $src_w)
    {
        $dst_w = $width = $src_w;
    }
    if($height> $src_h)
    {
        $dst_h = $height = $src_h;
    }

    if(!$width && !$height && !$proportion)
    {
        return false;
    }
    if(!$proportion)
    {
        if($cut == 0)
        {
            if($dst_w && $dst_h)
            {
                if($dst_w/$src_w> $dst_h/$src_h)
                {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                }
                else
                {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            }
            else if($dst_w xor $dst_h)
            {
                if($dst_w && !$dst_h)  
                {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h  = $src_h * $propor;
                }
                else if(!$dst_w && $dst_h)  
                {
                    $propor = $dst_h / $src_h;
                    $width  = $dst_w = $src_w * $propor;
                }
            }
        }
        else
        {
            if(!$dst_h)  
            {
                $height = $dst_h = $dst_w;
            }
            if(!$dst_w)  
            {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int)round($src_w * $propor);
            $dst_h = (int)round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    }
    else
    {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width  = $dst_w = $src_w * $proportion;
    }

    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    if(function_exists('imagecopyresampled'))
    {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    else
    {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}
?>