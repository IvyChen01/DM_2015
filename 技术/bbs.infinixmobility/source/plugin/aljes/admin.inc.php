<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(!file_exists("source/plugin/aljes/template/com/admin.php")){
	echo lang('plugin/aljes','admin_8');
	exit;
}
require_once libfile('function/discuzcode');
require_once 'source/plugin/aljes/function/function_core.php';
include_once libfile('function/editor');
$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];	
}
$pluginid='aljes';
$typelist = explode ("\n", str_replace ("\r", "", $config ['pinpai']));
foreach($typelist as $key=>$value){
	$arr=explode('=',$value);
	$types[$arr[0]]=$arr[1];
}
$zufangtype = $types;
$new_list = explode ("\n", str_replace ("\r", "", $config ['new']));
foreach($new_list as $key=>$value){
	$new_arr=explode('=',$value);
	$new_types[$new_arr[0]]=$new_arr[1];
}
$wanted_list = explode ("\n", str_replace ("\r", "", $config ['gongqiu']));
foreach($wanted_list as $key=>$value){
	$new_arr=explode('=',$value);
	$wanted_types[$new_arr[0]]=$new_arr[1];
}
$regions = C::t('#aljes#aljes_region')->range();
$shengming=str_replace ("{sitename}", $_G['setting']['bbname'], $config ['shengming']);
if($_GET['act']=='edit'){
	if(submitcheck('formhash')){
		
		if (empty($_GET['title'])) {
            showerror(lang('plugin/aljes','aljes_2'));
        }
        for ($i = 1; $i <= 8; $i++) {
            $pic = 'pic' . $i;
            if ($_FILES[$pic]['tmp_name']) {
                $picname = $_FILES[$pic]['name'];
                $picsize = $_FILES[$pic]['size'];
				if ($picsize/1024>$config['img_size']) {
					showerror(lang('plugin/aljes','aljes_26').$config['img_size'].'K');
				}
                if ($picname != "") {
                    $type = strstr($picname, '.');
                    if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
                        showerror(lang('plugin/aljes','aljes_3'));
                    }
                    $rand = rand(100, 999);
                    $pics = date("YmdHis") . $rand . $type;
                    $img_dir = 'source/plugin/aljes/images/logo/';
                    if (!is_dir($img_dir)) {
                        mkdir($img_dir);
                    }
                    $$pic = $img_dir . $pics;
                    if (@copy($_FILES[$pic]['tmp_name'], $$pic) || @move_uploaded_file($_FILES[$pic]['tmp_name'], $$pic)) {
                        $imageinfo = getimagesize($$pic);
                        $w64 = $imageinfo[0] < 64 ? $imageinfo[0] : 64;
                        $h64 = $imageinfo[1] < 64 ? $imageinfo[1] : 64;

                        $w640 = $imageinfo[0] < 640 ? $imageinfo[0] : 640;
                        $h480 = $imageinfo[1] < 480 ? $imageinfo[1] : 480;
                        img2thumb($$pic, $$pic . '.64x64.jpg', $w64, $h64);
                        img2thumb($$pic, $$pic . '.640x480.jpg', $w640, $h480);
                        @unlink($_FILES[$pic]['tmp_name']);
                    }
                }
            }
        }


        $insertarray = array(
            'wanted' => $_GET['wanted'],
            'title' => $_GET['title'],
            'zufangtype' => $_GET['zufangtype'],
            'qq' => $_GET['qq'],
            'new' => $_GET['new'],
            'lxr' => $_GET['lxr'],
            'zujin' => $_GET['zujin'],
            'content' => $_GET['content'],
            
            'region' => $_GET['region'],
            'region1' => $_GET['region1'],
            'region2' => $_GET['region2'],
            'contact' => $_GET['contact'],
            
            
            'updatetime' => TIMESTAMP,
        );
        for ($i = 1; $i <= 8; $i++) {
            $pic = 'pic' . $i;
            if ($$pic) {
                if (empty($$pic)) {
                    $$pic = $_GET[$pic];
                }
                $insertarray[$pic] = $$pic;
            }
        }
        C::t('#aljes#aljes')->update($_GET['lid'], $insertarray);
        C::t('#aljes#aljes_user')->update_updatecount_by_uid($_G['uid']);
       
		cpmsg(lang('plugin/aljes','admin_1'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin', 'succeed');
	}else{
		$rs = C::t('#aljes#aljes_region')->fetch_all_by_upid(0);
        $lp = C::t('#aljes#aljes')->fetch($_GET['lid']);
        $ps = explode(',', $lp['peizhi']);
        if ($lp['region']) {
            $rrs = C::t('#aljes#aljes_region')->fetch_all_by_upid($lp['region']);
        }
		include template('aljes:edit');
	}
}else if($_GET['act']=='commentlist'){
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=10;
		$start=($currpage-1)*$perpage;
		$num=C::t('#aljes#aljes_comment')->count_by_bid_all($_GET['lid']);
		$commentlist=C::t('#aljes#aljes_comment')->fetch_all_by_bid_page($_GET['lid'],$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljes&pmod=admin&act=commentlist&lid='.$_GET['lid'], 0, 11, false, false);
		include template('aljes:admincommentlist');
}else if($_GET['act']=='deletecomment'){
		C::t('#aljes#aljes_comment')->delete($_GET['cid']);
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=10;
		$num=C::t('#aljes#aljes_comment')->count_by_bid_all($_GET['lid']);
		$commentlist=C::t('#aljes#aljes_comment')->fetch_all_by_bid_page($_GET['lid'],$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljes&pmod=admin&act=commentlist&lid='.$_GET['lid'], 0, 11, false, false);
		include template('aljes:admincommentlist');
}else{
	if($config['isreview']){
		include template('aljes:admin_nav');
	}else{
		$_GET['state']='audited';
	}
	
	if($_GET['state']=='audited'){
		if(!submitcheck('submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page']."&search=".$_GET['search']);
			showtableheader('<form  enctype="multipart/form-data" action="plugins&operation=config&identifier='.$pluginid.'&pmod=admin&state='.$_GET['state'].'" method="post" type="2" >
	<input type="hidden" name="formhash" value="'.FORMHASH.'"><input type="text" name="search" value="'.$_GET['search'].'"><input type="submit" >
	</form>');
			showsubtitle(array('',lang('plugin/aljes','admin_2'),lang('plugin/aljes','admin_3'), lang('plugin/aljes','admin_4'),lang('plugin/aljes','admin_5'),lang('plugin/aljes','admin_6')));
			echo '<script>disallowfloat = "newthread";</script>';
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$con=" where state=0";
			if($_GET['search']){
				$search='%' . addcslashes($_GET['search'], '%_') . '%';
				$con=" and title like '$search'";
			}
			$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljes')." $con");
			
			$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin&search=".$_GET['search'], 0, 10, false, false);
			$query = DB::query("SELECT * FROM ".DB::table('aljes')." $con ORDER BY id desc limit $start,$perpage");
			while($row = DB::fetch($query)) {
				if($row[tuijian]){
					$che[$row[id]]='checked="checked"';
				}
				$start=date('Y-m-d H:i:s',$row['addtime']);
				$end=date('Y-m-d H:i:s',$row['updatetime']);
				showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(
								"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
								'<a href="plugin.php?id=aljes&act=view&lid='.$row[id].'" target="_blank">'.$row['title'].'</a>',	
								$start,	
								$end,		
								$row['zujin']>0?$row['zujin']:lang('plugin/aljes','aljes_23'),			
								'<input class="checkbox" type="checkbox" name="tuijian['.$row[id].']" '.$che[$row[id]].' value="1">&nbsp;&nbsp;&nbsp;<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&act=edit&lid='.$row[id].'&uid='.$row[uid].'">'.lang('plugin/aljes','admin_7').'</a> <a href="admin.php?action=plugins&operation=config&identifier=aljes&pmod=admin&act=commentlist&lid='.$row[id].'" onclick="showWindow(\'edit\',this.href)">'.lang('plugin/aljes','aljes_32').'</a>',		
								));
				
			}
			
			showsubmit('submit', 'submit', 'del','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			//debug($_POST);
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					$user=C::t('#aljes#aljes')->fetch($id);
					for ($i = 1; $i <= 8; $i++) {
						$pic = 'pic' . $i;
						if ($user[$pic]) {
							unlink($user[$pic]);
							unlink($user[$pic].'.64x64.jpg');
							unlink($user[$pic].'.640x480.jpg');
						}
					}
					C::t('#aljes#aljes')->delete($id);
				}
			}
			
			foreach($_POST['myid'] as $id) {
				DB::update('aljes',array('tuijian'=>$_POST['tuijian'][$id]),'id='.$id);
			}
			
			cpmsg(lang('plugin/aljes','admin_1'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page'], 'succeed');
		}
	}else{
		if(!submitcheck('submit')&&!submitcheck('del_submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page']."&search=".$_GET['search']);
			showtableheader('<form  enctype="multipart/form-data" action="plugins&operation=config&identifier='.$pluginid.'&pmod=admin" method="post" type="2" >
	<input type="hidden" name="formhash" value="'.FORMHASH.'"><input type="text" name="search" value="'.$_GET['search'].'"><input type="submit" >
	</form>');
			showsubtitle(array('',lang('plugin/aljes','admin_2'),lang('plugin/aljes','admin_3'), lang('plugin/aljes','admin_4'),lang('plugin/aljes','admin_5'),lang('plugin/aljes','admin_15')));
			echo '<script>disallowfloat = "newthread";</script>';
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$con=" where state=1";
			if($_GET['search']){
				$search='%' . addcslashes($_GET['search'], '%_') . '%';
				$con=" and title like '$search'";
			}
			$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljes')." $con");
			
			$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin&search=".$_GET['search'], 0, 10, false, false);
			$query = DB::query("SELECT * FROM ".DB::table('aljes')." $con ORDER BY id desc limit $start,$perpage");
			while($row = DB::fetch($query)) {
				if($row[tuijian]){
					$che[$row[id]]='checked="checked"';
				}
				$start=date('Y-m-d H:i:s',$row['addtime']);
				$end=date('Y-m-d H:i:s',$row['updatetime']);
				showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(
								"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
								'<a href="plugin.php?id=aljes&act=view&lid='.$row[id].'" target="_blank">'.$row['title'].'</a>',	
								$start,	
								$end,		
								$row['zujin']>0?$row['zujin']:lang('plugin/aljes','aljes_23'),			
								'<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&act=edit&lid='.$row[id].'&uid='.$row[uid].'">'.lang('plugin/aljes','admin_7').'</a>',		
								));
				
			}
			
			showsubmit('submit', lang('plugin/aljzp','admin_16'), '<input type="checkbox" onclick="checkAll(\'prefix\', this.form, \'delete\')" class="checkbox" id="chkallGnMF" name="chkall"><label for="chkallGnMF">'.lang('plugin/aljzp','admin_17').'</label>','<input type="submit" value="'.lang('plugin/aljzp','admin_18').'" name="del_submit" class="btn"/>','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			//debug($_POST);
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					$user=C::t('#aljes#aljes')->fetch($id);
					if(submitcheck('del_submit')){
						for ($i = 1; $i <= 8; $i++) {
							$pic = 'pic' . $i;
							if ($user[$pic]) {
								unlink($user[$pic]);
								unlink($user[$pic].'.64x64.jpg');
								unlink($user[$pic].'.640x480.jpg');
							}
						}
						if($user['tid']){
							DB::update('forum_post', array('invisible'=>'-1'), "tid=".$user['tid']);
							DB::update('forum_thread', array('displayorder'=>'-1'), "tid=".$user['tid']);
						}
						C::t('#aljes#aljes')->delete($id);
					}else{
						if (file_exists("source/plugin/aljes/template/com/tongbu.php")&&$config['isreview']) {
							$_GET['wanted']=$user['wanted'];
							$_GET['title']=$user['title'];
							$_GET['zufangtype']=$user['zufangtype'];
							$_GET['new']=$user['new'];
							$_GET['contact']=$user['contact'];
							$_GET['zujin']=$user['zujin'];
							$_GET['qq']=$user['qq'];
							$_GET['lxr']=$user['lxr'];
							$_GET['region1']=$user['region1'];
							$_GET['region']=$user['region'];
							$_GET['region2']=$user['region2'];
							$_GET['content']=$user['content'];
							$_G['uid']=$user['uid'];
							$_G['clientip']=$user['clientip'];
							$insertid=$user['id'];
							include 'source/plugin/aljes/template/com/tongbu.php';
						}
						DB::update('aljes',array('state'=>0),'id='.$id);
					}
				}
			}
			cpmsg(lang('plugin/aljes','admin_1'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page'], 'succeed');
		}
	}
}
function showmsg($msg,$close){
	if($close){
		$str="parent.hideWindow('$close');";
	}else{
		$str="parent.location=parent.location;";
	}
	include template('aljes:showmsg');
	exit;
}
function showerror($msg){
	include template('aljes:showerror');
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