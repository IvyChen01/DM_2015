<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
$_GET=dhtmlspecialchars($_GET);
require_once libfile('function/discuzcode');
require_once 'source/plugin/aljlp/function/function_core.php';
include_once libfile('function/editor');
require_once DISCUZ_ROOT.'source/plugin/aljlp/class/qrcode.class.php';
if (file_exists("source/plugin/aljlp/template/com/qrcode.php")) {
	if (!file_exists("source/plugin/aljlp/images/qrcode/aljlp_qrcode.jpg")) {
		include 'source/plugin/aljlp/template/com/qrcode.php';
	}
}
if($_GET['act']&&$_GET['act']!='view'&&$_GET['act']!='ask'){
	if(!$_G['uid']){
		showmessage(lang('plugin/aljlp','aljlp_1'), '', array(), array('login' => true));
	}
}
//用户表
if ($_G['uid']) {
    if (!C::t('#aljlp#aljlp_user')->fetch($_G['uid'])) {
        C::t('#aljlp#aljlp_user')->insert(array('uid' => $_G['uid'], 'username' => $_G['username'], 'dateline' => TIMESTAMP, 'last' => TIMESTAMP));
    } else {
        C::t('#aljlp#aljlp_user')->update_last_by_uid($_G['uid']);
    }
}
//用户访问记录
if (!C::t('#aljlp#aljlp_log')->fetch(gmdate('Ymd', TIMESTAMP))) {
    C::t('#aljlp#aljlp_log')->insert(array('day' => gmdate('Ymd', TIMESTAMP), 'views' => 1));
} else {
    C::t('#aljlp#aljlp_log')->update_views_by_day(gmdate('Ymd', TIMESTAMP));
}
$config = $_G['cache']['plugin']['aljlp'];
//$wanted = array(0 => lang('plugin/aljlp','aljlp_2'), 1 => lang('plugin/aljlp','aljlp_3'));
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
$arealist = explode ("\n", str_replace ("\r", "", $config ['mianji']));
foreach($arealist as $key=>$value){
	$arr=explode('=',$value);
	$area_types[$arr[0]]=$arr[1];
}
$paylist = explode ("\n", str_replace ("\r", "", $config ['pay']));
foreach($paylist as $key=>$value){
	$arr=explode('=',$value);
	$pay_types[$arr[0]]=$arr[1];
}
$r_pay=explode('|',$config['r_pay']);
$_G['setting']['switchwidthauto'] = 0;
$_G['setting']['allowwidthauto'] = 1;
$regions = C::t('#aljlp#aljlp_region')->range();
$shengming=str_replace ("{sitename}", $_G['setting']['bbname'], $config ['shengming']);
if($_GET['act'] == 'attes'){
	if (file_exists("source/plugin/aljlp/template/com/attes.php")) {
        include 'source/plugin/aljlp/template/com/attes.php';
    }	
}else if ($_GET['act'] == 'post') {
    if (submitcheck('formhash')) {
        if (empty($_GET['title'])) {
			if($_GET['sj']){
				echo "<script>parent.tips('".lang('plugin/aljlp','aljlp_6')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljlp','aljlp_6'));
			}
        }
		
		if (empty($_GET['region'])) {
			if($_GET['sj']){
				echo "<script>parent.tips('".lang('plugin/aljlp','aljlp_38')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljlp','aljlp_38'));
			}
        }
		if (empty($_GET['contact'])) {
			if($_GET['sj']){
				echo "<script>parent.tips('".lang('plugin/aljlp','aljlp_39')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljlp','aljlp_39'));
			}
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

		if($config['isreview']){
			$state=1;
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
            'uid' => $_G['uid'],
            'username' => $_G['username'],
            'addtime' => TIMESTAMP,
            'updatetime' => TIMESTAMP,
            'qq' =>  $_GET['qq'],
            'lxr' =>  $_GET['lxr'],
            'area' =>  $_GET['area'],
            'jingjiren' =>  $_GET['jingjiren'],
            'phone' =>  $_G['mobile'],
			'state' =>  $state,
			'clientip' => $_G['clientip'],
        );
        for ($i = 1; $i <= 8; $i++) {
            $pic = 'pic' . $i;
            if ($$pic) {
                $insertarray[$pic] = $$pic;
            }
        }
		if (file_exists("source/plugin/aljlp/template/com/release.php")) {
			include 'source/plugin/aljlp/template/com/release.php';
		}
        $insertid = C::t('#aljlp#aljlp')->insert($insertarray, true);
		if (file_exists("source/plugin/aljlp/template/com/tongbu.php")&&!$config['isreview']) {
			include 'source/plugin/aljlp/template/com/tongbu.php';
		}
		
        C::t('#aljlp#aljlp_user')->update_count_by_uid($_G['uid']);
		if($_GET['sj']){
			echo "<script>parent.tips('".str_replace('\\','',lang('plugin/aljlp','aljlp_8'))."',function(){parent.location.href='plugin.php?id=aljlp&act=view&lid=".$insertid."';});</script>";
		}else{
			showmsg(str_replace('\\','',lang('plugin/aljlp','aljlp_8')), 2, $insertid);
		}
    } else {
		//允许提问用户组
		if(!in_array($_G['groupid'],unserialize($config['lj_groups']))){
				showmessage($config['lj_tsy']);
		}
		if (file_exists("source/plugin/aljlp/template/com/release.php")) {
			if (getuserprofile('extcredits' . $config['releaseextcredit']) < $config['releasepay']) {
				showmessage($_G['setting']['extcredits'][$config['releaseextcredit']]['title'] . lang('plugin/aljlp','top_1'));
			}
		}
		//$regions = C::t('#aljlp#aljlp_region')->range();
        $rs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid(0);
		//$rrs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid($_GET['rid']);
        include template('aljlp:post');
    }
} else if ($_GET['act'] == 'edit') {
    if (submitcheck('formhash')) {
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
		showmsg(str_replace('\\','',lang('plugin/aljlp','aljlp_9')), 2, $_GET['lid']);
		
    } else {
        $rs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid(0);
        $lp = C::t('#aljlp#aljlp')->fetch($_GET['lid']);
		if($lp['uid']!=$_G['uid']&&$_G['groupid']!=1){
			showmessage(lang('plugin/aljlp','aljlp_34'));
		}
        $ps = explode(',', $lp['peizhi']);
        if ($lp['region']) {
            $rrs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid($lp['region']);
        }
        include template('aljlp:post');
    }
} else if ($_GET['act'] == 'reflash') {
    if (file_exists("source/plugin/aljlp/template/com/reflash.php")) {
        include 'source/plugin/aljlp/template/com/reflash.php';
    }
} else if ($_GET['act'] == 'top') {
    if (file_exists("source/plugin/aljlp/template/com/top.php")) {
        include 'source/plugin/aljlp/template/com/top.php';
    }
} else if ($_GET['act'] == 'view') {
    if (empty($_GET['lid'])) {
        showmessage(lang('plugin/aljlp','aljlp_10'));
    }
	$lp = C::t('#aljlp#aljlp')->fetch($_GET['lid']);
	if (empty($lp)) {
        showmessage(lang('plugin/aljlp','aljlp_10'));
    }
    C::t('#aljlp#aljlp')->update_views_by_id($_GET['lid']);
    $pics = array('pic1', 'pic2', 'pic3', 'pic4', 'pic5', 'pic6', 'pic7', 'pic8');
    $regions = C::t('#aljlp#aljlp_region')->range();
	
    if (file_exists("source/plugin/aljlp/template/com/qrcode.php")) {
		if(!file_exists('source/plugin/aljlp/images/qrcode/'.$lp['qrcode'])||!$lp['qrcode']){
			$file = dgmdate(TIMESTAMP, 'YmdHis').random(18).'.jpg';	 QRcode::png($_G['siteurl'].'plugin.php?id=aljlp&act=view&lid='.$_GET['lid'], 'source/plugin/aljlp/images/qrcode/'.$file, QR_MODE_STRUCTURE, 8);
			DB::update('aljlp', array('qrcode'=>$file), "id=".$_GET['lid']);
		}
	}
	if($config['isyouke']){
		$tel=hidtel($lp['contact']);
	}
    $lp = dhtmlspecialchars($lp);
	$cod=$regions[$lp['region']]['subject'].$regions[$lp['region1']]['subject'].$lp['region2'];
	if($_G['charset']=='gbk'){
		$cod=diconv($cod,'gbk','utf-8'); 
	}
	$url=urlencode($cod);
	$qita = DB::fetch_all("SELECT * FROM ".DB::table('aljlp')." where state=0 and uid=".$lp[uid]." ORDER BY id desc limit 0,".$config['qitanum']);
	foreach($qita as $k=>$v){
		$qita[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
	$commentlist=C::t('#aljlp#aljlp_comment')->fetch_all_by_upid(0,$_GET['lid']);
	$commentlist=dhtmlspecialchars($commentlist);
    $navtitle = $lp['title'] . '-' . $config['title'];
    $metakeywords = $lp['title'];
    $metadescription = $lp['title'];
    if($_G['mobile']) {
		include template('aljlp:aljlp_view');
	} else {
		include template('diy:aljlp_view', null, 'source/plugin/aljlp/template');
	}
} else if ($_GET['act'] == 'delete') {
	$user=C::t('#aljlp#aljlp')->fetch($_GET['lid']);
	if($user['uid']!=$_G['uid']&&$_G['groupid']!=1){
		showmessage(lang('plugin/aljlp','aljlp_34'));
	}
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
    C::t('#aljlp#aljlp')->delete($_GET['lid']);
    showmessage(lang('plugin/aljlp','aljlp_11'), 'plugin.php?id=aljlp&act=member');
} else if($_GET['act'] == 'ask'){
	if(submitcheck('formhash')){
		if (empty($_G['uid'])) {
			showerror(lang('plugin/aljlp','aljlp_1'));
		}
		if (empty($_GET['message'])) {
			showerror(lang('plugin/aljlp','aljlp_35'));
		}
		$insertarray=array(
			'content'=>$_GET['message'],	
			'uid'=>$_G['uid'],	
			'username'=>$_G['username'],	
			'lid'=>$_GET['lid'],
			'dateline'=>TIMESTAMP,
		);
		C::t('#aljlp#aljlp_comment')->insert($insertarray);
		if($config['is_ping']){
			$lp=C::t('#aljlp#aljlp')->fetch($_GET['lid']);
			notification_add($lp['uid'], 'system',lang('plugin/aljlp','tongzhi_1').' <a target="_blank" href="plugin.php?id=aljlp&act=view&lid='.$_GET['lid'].'">'.$lp['title'].'</a> '.lang('plugin/aljlp','tongzhi_2').' <a href="plugin.php?id=aljlp&act=view&lid='.$_GET['lid'].'" target="_blank">'.lang('plugin/aljlp','tongzhi_3').'</a>');
		}
		showmsg(lang('plugin/aljlp','aljlp_36'));
	}
}else if($_GET['act'] == 'reply'){
	if(submitcheck('formhash')){
		if (empty($_G['uid'])) {
			showerror(lang('plugin/aljlp','aljlp_1'));
		}
		if (empty($_GET['message'])) {
			showerror(lang('plugin/aljlp','aljlp_35'));
		}
		$insertarray=array(
			'content'=>$_GET['message'],	
			'uid'=>$_G['uid'],	
			'username'=>$_G['username'],	
			'lid'=>$_GET['lid'],
			'dateline'=>TIMESTAMP,
			'upid'=>$_GET['upid'],
		);
		C::t('#aljlp#aljlp_comment')->insert($insertarray);
		if($config['is_ping']){
			$lp=C::t('#aljlp#aljlp_comment')->fetch($_GET['upid']);
			notification_add($lp['uid'], 'system',lang('plugin/aljlp','tongzhi_4').$config['daohang'].lang('plugin/aljlp','tongzhi_5').' <a href="plugin.php?id=aljlp&act=view&lid='.$_GET['lid'].'" target="_blank">'.lang('plugin/aljlp','tongzhi_3').'</a>');
		}
		showmsg(lang('plugin/aljlp','aljlp_36'));
	}
}else if($_GET['act'] == 'commentdel'){
	if($_GET['formhash']==formhash()){
		if (empty($_G['uid'])) {
			showerror(lang('plugin/aljlp','aljlp_1'));
		}
		$upid=DB::fetch_all(" select * from %t where upid=%d",array('aljlp_comment',$_GET['cid']));
		if($upid){
			foreach($upid as $id){
				C::t('#aljlp#aljlp_comment')->delete($id['id']);
			}
		}
		C::t('#aljlp#aljlp_comment')->delete($_GET['cid']);
		showmessage(lang('plugin/aljlp','aljlp_11'),'plugin.php?id=aljlp&act=view&lid='.$_GET['lid']);
	}
}else if ($_GET['act'] == 'getregion') {
	
    if ($_GET['rid']) {
        $rs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid($_GET['rid']);
    }
	
    include template('aljlp:getregion');
} else if ($_GET['act'] == 'member') {
    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = $config['page'];
    $num = C::t('#aljlp#aljlp')->count_by_status($_GET['search']);
    $start = ($currpage - 1) * $perpage;
    if($_G['groupid']!=1){
		$conndtion = array(
			'uid' => $_G['uid'],
		);
	}
    $lplist = C::t('#aljlp#aljlp')->fetch_all_by_addtime($start, $perpage, $conndtion);
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljlp&act=member', 0, 11, false, false);
    include template('aljlp:member');
} else if ($_GET['act'] == 'adminlp') {
    if (file_exists("source/plugin/aljlp/template/com/admin.php")) {
        include 'source/plugin/aljlp/template/com/admin.php';
    }
} else if ($_GET['act'] == 'adminuser') {
    if (file_exists("source/plugin/aljlp/template/com/user.php")) {
        include 'source/plugin/aljlp/template/com/user.php';
    }
} else if ($_GET['act'] == 'adminreflash') {
    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = 10;
    $num = C::t('#aljlp#aljlp_reflashlog')->count();
    $start = ($currpage - 1) * $perpage;

    $logs = C::t('#aljlp#aljlp_reflashlog')->range($start, $perpage, 'desc');
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljlp&act=adminreflash', 0, 11, false, false);
    include template('aljlp:adminreflash');
} else if ($_GET['act'] == 'admintop') {
    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = $config['page'];
    $num = C::t('#aljlp#aljlp_toplog')->count();
    $start = ($currpage - 1) * $perpage;

    $logs = C::t('#aljlp#aljlp_toplog')->range($start, $perpage, 'desc');
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljlp&act=admintop', 0, 11, false, false);
    include template('aljlp:admintop');
}else if($_GET['act'] == 'all'){
	if (file_exists("source/plugin/aljlp/template/com/qita.php")) {
        include 'source/plugin/aljlp/template/com/qita.php';
    }
} else {
    $todayviews = C::t('#aljlp#aljlp_log')->fetch_all_by_day();
    $regions = C::t('#aljlp#aljlp_region')->range();
	
    $rs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid(0);
    $rrs = C::t('#aljlp#aljlp_region')->fetch_all_by_upid($_GET['rid']);

    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = $config['page'];
	if($_GET['mobile']=='1'||$_GET['mobile']=='2'){
		if($_G['charset']=='gbk'){ $_GET['fangxing']=diconv($_GET['fangxing'],'utf-8','gbk');}
	}
    $start = ($currpage - 1) * $perpage;
    $conndtion = array(
        'search' => $_GET['search'],
        'rid' => $_GET['rid'],
        'subrid' => $_GET['subrid'],
        'zufangtype' => $_GET['zufangtype'],
        'pay1' => $_GET['pay1'],
        'pay2' => $_GET['pay2'],
        'fangxing' => $_GET['fangxing'],
        'wanted' => $_GET['wanted'],
        'area1' => $_GET['area1'],
        'area2' => $_GET['area2'],
    );
	
	$num = C::t('#aljlp#aljlp')->count_by_status($conndtion);
	$total_page = ceil($num/$perpage);
	//debug($num);
	//第一页的时候没有上一页	
	if($total_page>1){
		if($currpage > 1){
			$shangyiye='<a href="plugin.php?id=aljlp&page='.($currpage-1).'&search='.$_GET['search'].'&rid='.$_GET['rid'].'&subrid='.$_GET['subrid'].'&zufangtype='.$_GET['zufangtype'].'&pay1='.$_GET['pay1'].'&pay2='.$_GET['pay2'].'&fangxing='.$_GET['fangxing'].'&wanted='.$_GET['wanted'].'">'.lang('plugin/aljlp','sj_1').'</a>&nbsp;&nbsp;';
		}else{
			$shangyiye='<span>'.lang('plugin/aljlp','sj_1').'</span>';
		}
		//尾页的时候不显示下一页
		if($currpage < $total_page){
			//debug(123);
			$xiayiye= '<a href="plugin.php?id=aljlp&page='.($currpage+1).'&search='.$_GET['search'].'&rid='.$_GET['rid'].'&subrid='.$_GET['subrid'].'&zufangtype='.$_GET['zufangtype'].'&pay1='.$_GET['pay1'].'&pay2='.$_GET['pay2'].'&fangxing='.$_GET['fangxing'].'&wanted='.$_GET['wanted'].'">'.lang('plugin/aljlp','sj_2').'</a>&nbsp;&nbsp;';
			//debug($xiayiye);
		}else{
			$xiayiye='<span>'.lang('plugin/aljlp','sj_2').'</span>';
		}
	}
	//debug($conndtion);
    $lplist = C::t('#aljlp#aljlp')->fetch_all_by_addtime($start, $perpage, $conndtion);
	foreach($lplist as $k=>$v){
		
		if(TIMESTAMP>$v['topetime']&&$v['topetime']){
			DB::update('aljlp',array('topstime'=>'','topetime'=>''),'id='.$v[id]);
		}
		$lplist[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
    $lplist = dhtmlspecialchars($lplist);
	$tuijian = DB::fetch_all("SELECT * FROM ".DB::table('aljlp')." where state=0 and tuijian=1 ORDER BY id desc limit 0,9");
	foreach($tuijian as $k=>$v){
		$tuijian[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljlp&rid='.$_GET['rid'].'&subrid='.$_GET['subrid'].'&zufangtype='.$_GET['zufangtype'].'&pay1='.$_GET['pay1'].'&pay2='.$_GET['pay2'].'&fangxing='.$_GET['fangxing'].'&wanted='.$_GET['wanted'].'&search='.$_GET['search'], 0, 11, false, false);
    $toplist = C::t('#aljlp#aljlp_toplog')->fetch_all_by_dateline();
    $navtitle = $config['title'];
    $metakeywords = $config['keywords'];
    $metadescription = $config['description'];
	//debug(template('diy:aljlp_index', null, 'source/plugin/aljlp/template'));
    if($_G['mobile']) {
		include template('aljlp:aljlp_index');
	} else {
		include template('diy:aljlp_index', null, 'source/plugin/aljlp/template');
	}
}

function showmsg($msg, $close, $id) {
    if ($close == 1) {
        $str = "parent.hideWindow('$close');";
    } else if ($close == 2) {
        $str = "parent.location.href='plugin.php?id=aljlp&act=view&lid=" . $id . "'";
    } else {
        $str = "parent.location=parent.location;";
    }
    include template('aljlp:showmsg');
    exit;
}

function showerror($msg) {
    include template('aljlp:showerror');
    exit;
}

function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0) {
    if (!is_file($src_img)) {
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;

    if (($width > $src_w && $height > $src_h) || ($height > $src_h && $width == 0) || ($width > $src_w && $height == 0)) {
        $proportion = 1;
    }
    if ($width > $src_w) {
        $dst_w = $width = $src_w;
    }
    if ($height > $src_h) {
        $dst_h = $height = $src_h;
    }

    if (!$width && !$height && !$proportion) {
        return false;
    }
    if (!$proportion) {
        if ($cut == 0) {
            if ($dst_w && $dst_h) {
                if ($dst_w / $src_w > $dst_h / $src_h) {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                } else {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            } else if ($dst_w xor $dst_h) {
                if ($dst_w && !$dst_h) {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h = $src_h * $propor;
                } else if (!$dst_w && $dst_h) {
                    $propor = $dst_h / $src_h;
                    $width = $dst_w = $src_w * $propor;
                }
            }
        } else {
            if (!$dst_h) {
                $height = $dst_h = $dst_w;
            }
            if (!$dst_w) {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int) round($src_w * $propor);
            $dst_h = (int) round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    } else {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width = $dst_w = $src_w * $proportion;
    }

    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    if (function_exists('imagecopyresampled')) {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    } else {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}
function hidtel($phone)
{
    $IsWhat = preg_match('/([0-9][0-9]{2,3}[\-]?[1-9][0-9]{6,7}[\-]?[0-9]?)/i',$phone); //固定电话
	
    if($IsWhat == 1)
    {
        return preg_replace('/([0-9][0-9]{2,3}[\-]?[1-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$phone);
    }
    else
    {
        return  preg_replace('/([0-9][0-9]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
    }
}
?>