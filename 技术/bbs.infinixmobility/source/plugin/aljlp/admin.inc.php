<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(!file_exists("source/plugin/aljlp/template/com/admin.php")){
	echo lang('plugin/aljlp','admin_8');
	exit;
}
require_once libfile('function/discuzcode');
require_once 'source/plugin/aljlp/function/function_core.php';
include_once libfile('function/editor');
$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];	
}
$pluginid='aljlp';
$wanted = explode ("\n", str_replace ("\r", "", $config ['gongqiu']));
foreach($wanted as $key=>$value){
	$arr=explode('=',$value);
	$gq_wanted[$arr[0]]=$arr[1];
}
//$zufangtype = array(2 => lang('plugin/aljlp','aljlp_4'), 1 => lang('plugin/aljlp','aljlp_5'), 3 => lang('plugin/aljlp','aljlp_12'));
$typelist = explode ("\n", str_replace ("\r", "", $config ['zf_type']));
foreach($typelist as $key=>$value){
	$arr=explode('=',$value);
	$types[$arr[0]]=$arr[1];
}
$zufangtype = $types;
$peizhi = array(lang('plugin/aljlp','aljlp_13'),lang('plugin/aljlp','aljlp_14'), lang('plugin/aljlp','aljlp_15'), lang('plugin/aljlp','aljlp_16'), lang('plugin/aljlp','aljlp_17'), lang('plugin/aljlp','aljlp_18'), lang('plugin/aljlp','aljlp_19'), lang('plugin/aljlp','aljlp_20'), lang('plugin/aljlp','aljlp_21'), lang('plugin/aljlp','aljlp_22'), lang('plugin/aljlp','aljlp_23'));
$chaoxiang = array(lang('plugin/aljlp','aljlp_24'), lang('plugin/aljlp','aljlp_25'), lang('plugin/aljlp','aljlp_26'), lang('plugin/aljlp','aljlp_27'), lang('plugin/aljlp','aljlp_28'), lang('plugin/aljlp','aljlp_29'), lang('plugin/aljlp','aljlp_30'),lang('plugin/aljlp','aljlp_31'), lang('plugin/aljlp','aljlp_32'), lang('plugin/aljlp','aljlp_33'));
$fx_list = explode ("\n", str_replace ("\r", "", $config ['fx']));
$regions = C::t('#aljlp#aljlp_region')->range();
$shengming=str_replace ("{sitename}", $_G['setting']['bbname'], $config ['shengming']);
if($_GET['act']=='edit'){
	if(submitcheck('formhash')){
		
		if (empty($_GET['title'])) {
            showerror(lang('plugin/aljlp','aljlp_6'));
        }
        for ($i = 1; $i <= 8; $i++) {
            $pic = 'pic' . $i;
            if ($_FILES[$pic]['tmp_name']) {
                $picname = $_FILES[$pic]['name'];
                $picsize = $_FILES[$pic]['size'];
				if ($picsize/1024>$config['img_size']) {
					showerror(lang('plugin/aljlp','aljlp_40').$config['img_size'].'K');
				}
                if ($picname != "") {
                    $type = strstr($picname, '.');
                    if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
                        showerror(lang('plugin/aljlp','aljlp_7'));
                    }
                    $rand = rand(100, 999);
                    $pics = date("YmdHis") . $rand . $type;
                    $img_dir = 'source/plugin/aljlp/images/logo/';
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
            'fangxing' => $_GET['fangxing'],
            'louceng' => $_GET['louceng'],
            'zujin' => $_GET['zujin'],
            'content' => $_GET['content'],
            'xiaoqu' => $_GET['xiaoqu'],
            'region' => $_GET['region'],
            'region1' => $_GET['region1'],
            'region2' => $_GET['region2'],
            'contact' => $_GET['contact'],
            'chaoxiang' => $_GET['chaoxiang'],
            'zhuangxiu' => $_GET['zhuangxiu'],
            'peizhi' => implode(',', $_GET['peizhi']),
            'pay' => $_GET['pay'],
            'zuqi' => $_GET['zuqi'],
            'updatetime' => TIMESTAMP,
			'qq' =>  $_GET['qq'],
            'lxr' =>  $_GET['lxr'],
            'area' =>  $_GET['area'],
			'jingjiren' =>  $_GET['jingjiren'],
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
        C::t('#aljlp#aljlp')->update($_GET['lid'], $insertarray);
        C::t('#aljlp#aljlp_user')->update_updatecount_by_uid($_G['uid']);
       
		cpmsg(lang('plugin/aljlp','admin_1'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin', 'succeed');
	}else{
		$rs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid(0);
        $lp = C::t('#aljlp#aljlp')->fetch($_GET['lid']);
        $ps = explode(',', $lp['peizhi']);
        if ($lp['region']) {
            $rrs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid($lp['region']);
        }
		include template('aljlp:edit');
	}
}else if($_GET['act']=='commentlist'){
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=10;
		$start=($currpage-1)*$perpage;
		$num=C::t('#aljlp#aljlp_comment')->count_by_bid_all($_GET['lid']);
		$commentlist=C::t('#aljlp#aljlp_comment')->fetch_all_by_bid_page($_GET['lid'],$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljlp&pmod=admin&act=commentlist&lid='.$_GET['lid'], 0, 11, false, false);
		include template('aljlp:admincommentlist');
}else if($_GET['act']=='deletecomment'){
		C::t('#aljlp#aljlp_comment')->delete($_GET['cid']);
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=10;
		$num=C::t('#aljlp#aljlp_comment')->count_by_bid_all($_GET['lid']);
		$commentlist=C::t('#aljlp#aljlp_comment')->fetch_all_by_bid_page($_GET['lid'],$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljlp&pmod=admin&act=commentlist&lid='.$_GET['lid'], 0, 11, false, false);
		include template('aljlp:admincommentlist');
}else{
	if($config['isreview']){
		include template('aljlp:admin_nav');
	}else{
		$_GET['state']='audited';
	}
	
	if($_GET['state']=='audited'){
		if(!submitcheck('submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page']);
			showtableheader('<form  enctype="multipart/form-data" action="plugins&operation=config&identifier='.$pluginid.'&pmod=admin&state='.$_GET['state'].'" method="post" type="2" >
	<input type="hidden" name="formhash" value="'.FORMHASH.'"><input type="text" name="search" value="'.$_GET['search'].'"><input type="submit" >
	</form>');
			showsubtitle(array('',lang('plugin/aljlp','admin_2'),lang('plugin/aljlp','admin_3'), lang('plugin/aljlp','admin_4'),lang('plugin/aljlp','admin_5'),lang('plugin/aljlp','admin_6')));
			echo '<script>disallowfloat = "newthread";</script>';
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$con=" where state=0";
			if($_GET['search']){
				$search='%' . addcslashes($_GET['search'], '%_') . '%';
				$con.=" and title like '$search'";
			}
			$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljlp')." $con");
			$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin", 0, 10, false, false);
			$query = DB::query("SELECT * FROM ".DB::table('aljlp')." $con ORDER BY id desc limit $start,$perpage");
			while($row = DB::fetch($query)) {
				if($row[tuijian]){
					$che[$row[id]]='checked="checked"';
				}
				$start=date('Y-m-d H:i:s',$row['addtime']);
				$end=date('Y-m-d H:i:s',$row['updatetime']);
				showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(
								"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
								'<a href="plugin.php?id=aljlp&act=view&lid='.$row[id].'" target="_blank">'.$row['title'].'</a>',	
								$start,	
								$end,		
								$row['username'],			
								'<input class="checkbox" type="checkbox" name="tuijian['.$row[id].']" '.$che[$row[id]].' value="1">&nbsp;&nbsp;&nbsp;<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&act=edit&lid='.$row[id].'&uid='.$row[uid].'">'.lang('plugin/aljlp','admin_7').'</a> <a href="admin.php?action=plugins&operation=config&identifier=aljlp&pmod=admin&act=commentlist&lid='.$row[id].'" onclick="showWindow(\'edit\',this.href)">'.lang('plugin/aljlp','aljlp_41').'</a>',		
								));
				
			}
			
			showsubmit('submit', 'submit', 'del','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			//debug($_POST);
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					$user=C::t('#aljlp#aljlp')->fetch($id);
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
					C::t('#aljlp#aljlp')->delete($id);
				}
			}
			
			foreach($_POST['myid'] as $id) {
				DB::update('aljlp',array('tuijian'=>$_POST['tuijian'][$id]),'id='.$id);
			}
			
			cpmsg(lang('plugin/aljlp','admin_1'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page'], 'succeed');
		}
	}else{
		if(!submitcheck('submit')&&!submitcheck('del_submit')) {
			showformheader('plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page']);
			showtableheader();
			showsubtitle(array('',lang('plugin/aljlp','admin_2'),lang('plugin/aljlp','admin_3'), lang('plugin/aljlp','admin_4'),lang('plugin/aljlp','admin_5'),lang('plugin/aljlp','admin_15')));
			echo '<script>disallowfloat = "newthread";</script>';
			$currpage=$_GET['page']?$_GET['page']:1;
			$perpage=10;
			$start=($currpage-1)*$perpage;
			$con=" where state=1";
			if($_GET['search']){
				$search='%' . addcslashes($_GET['search'], '%_') . '%';
				$con.=" and title like '$search'";
			}
			$num=DB::result_first("SELECT count(*) FROM ".DB::table('aljlp')." $con");
			$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&identifier=".$pluginid."&pmod=admin", 0, 10, false, false);
			$query = DB::query("SELECT * FROM ".DB::table('aljlp')." $con ORDER BY id desc limit $start,$perpage");
			while($row = DB::fetch($query)) {
				if($row[tuijian]){
					$che[$row[id]]='checked="checked"';
				}
				$start=date('Y-m-d H:i:s',$row['addtime']);
				$end=date('Y-m-d H:i:s',$row['updatetime']);
				showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(
								"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\"><input type=\"hidden\" value=\"$row[id]\" name=\"myid[]\" >",	
								'<a href="plugin.php?id=aljlp&act=view&lid='.$row[id].'" target="_blank">'.$row['title'].'</a>',	
								$start,	
								$end,		
								$row['username'],			
								'<a href="admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&act=edit&lid='.$row[id].'&uid='.$row[uid].'">'.lang('plugin/aljlp','admin_7').'</a>',		
								));
				
			}
			
			showsubmit('submit', lang('plugin/aljzp','admin_16'), '<input type="checkbox" onclick="checkAll(\'prefix\', this.form, \'delete\')" class="checkbox" id="chkallGnMF" name="chkall"><label for="chkallGnMF">'.lang('plugin/aljzp','admin_17').'</label>','<input type="submit" value="'.lang('plugin/aljzp','admin_18').'" name="del_submit" class="btn"/>','',$paging);
			showtablefooter();
			showformfooter();
			
			
		}else{
			//debug($_POST);
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					$user=C::t('#aljlp#aljlp')->fetch($id);
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
						C::t('#aljlp#aljlp')->delete($id);
					}else{
						if (file_exists("source/plugin/aljlp/template/com/tongbu.php")&&$config['isreview']) {
							$_GET['wanted']=$user['wanted'];
							$_GET['title']=$user['title'];
							$_GET['zufangtype']=$user['zufangtype'];
							$_GET['new']=$user['new'];
							$_GET['louceng']=$user['louceng'];
							$_GET['xiaoqu']=$user['xiaoqu'];
							$_GET['contact']=$user['contact'];
							$_GET['zujin']=$user['zujin'];
							$_GET['fangxing']=$user['fangxing'];
							$_GET['zhuangxiu']=$user['zhuangxiu'];
							$_GET['peizhi']=explode(',',$user['peizhi']);
							$_GET['pay']=$user['pay'];
							$_GET['qq']=$user['qq'];
							$_GET['lxr']=$user['lxr'];
							$_GET['region1']=$user['region1'];
							$_GET['region']=$user['region'];
							$_GET['region2']=$user['region2'];
							$_GET['content']=$user['content'];
							$_G['uid']=$user['uid'];
							$_G['clientip']=$user['clientip'];
							$insertid=$user['id'];
							include 'source/plugin/aljlp/template/com/tongbu.php';
						}
						DB::update('aljlp',array('state'=>0),'id='.$id);
					}
				}
			}
			
			cpmsg(lang('plugin/aljlp','admin_1'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=admin&page='.$_GET['page'], 'succeed');
		}
	}
}
function showmsg($msg,$close){
	if($close){
		$str="parent.hideWindow('$close');";
	}else{
		$str="parent.location=parent.location;";
	}
	include template('aljlp:showmsg');
	exit;
}
function showerror($msg){
	include template('aljlp:showerror');
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