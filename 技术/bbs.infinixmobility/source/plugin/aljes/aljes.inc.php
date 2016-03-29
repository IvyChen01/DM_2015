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
require_once 'source/plugin/aljes/function/function_core.php';
include_once libfile('function/editor');
require_once DISCUZ_ROOT.'source/plugin/aljes/class/qrcode.class.php';
if (file_exists("source/plugin/aljes/template/com/qrcode.php")) {
	if (!file_exists("source/plugin/aljes/images/qrcode/aljes_qrcode.jpg")) {
		include 'source/plugin/aljes/template/com/qrcode.php';
	}
}
if($_GET['act']&&$_GET['act']!='view'&&$_GET['act']!='ask'){
	if(!$_G['uid']){
		showmessage(lang('plugin/aljes','aljes_1'), '', array(), array('login' => true));
	}
}
//用户表
if ($_G['uid']) {
    if (!C::t('#aljes#aljes_user')->fetch($_G['uid'])) {
        C::t('#aljes#aljes_user')->insert(array('uid' => $_G['uid'], 'username' => $_G['username'], 'dateline' => TIMESTAMP, 'last' => TIMESTAMP));
    } else {
        C::t('#aljes#aljes_user')->update_last_by_uid($_G['uid']);
    }
}
//用户访问记录
if (!C::t('#aljes#aljes_log')->fetch(gmdate('Ymd', TIMESTAMP))) {
    C::t('#aljes#aljes_log')->insert(array('day' => gmdate('Ymd', TIMESTAMP), 'views' => 1));
} else {
    C::t('#aljes#aljes_log')->update_views_by_day(gmdate('Ymd', TIMESTAMP));
}
$config = $_G['cache']['plugin']['aljes'];
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
$paylist = explode ("\n", str_replace ("\r", "", $config ['jg']));
foreach($paylist as $key=>$value){
	$arr=explode('=',$value);
	$pay_types[$arr[0]]=$arr[1];
}
$regions = C::t('#aljes#aljes_region')->range();
$shengming=str_replace ("{sitename}", $_G['setting']['bbname'], $config ['shengming']);
$_G['setting']['switchwidthauto'] = 0;
$_G['setting']['allowwidthauto'] = 1;
$wanted_list = explode ("\n", str_replace ("\r", "", $config ['gongqiu']));
foreach($wanted_list as $key=>$value){
	$new_arr=explode('=',$value);
	$wanted_types[$new_arr[0]]=$new_arr[1];
}
//$wanted = array(1=> lang('plugin/aljes','aljes_11'), 2=> lang('plugin/aljes','aljes_12'));
if ($_GET['act'] == 'post') {
    if (submitcheck('formhash')) {
        if (empty($_GET['title'])) {
			if($_GET['sj']){
				echo "<script>parent.tips('".lang('plugin/aljes','aljes_2')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljes','aljes_2'));
			}
        }
		
		if (empty($_GET['region'])) {
			if($_GET['sj']){
				echo "<script>parent.tips('".lang('plugin/aljes','aljes_24')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljes','aljes_24'));
			}
        }
		if (empty($_GET['contact'])) {
			if($_GET['sj']){
				echo "<script>parent.tips('".lang('plugin/aljes','aljes_25')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljes','aljes_25'));
			}
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
		if($config['isreview']){
			$state=1;
		}	
        $insertarray = array(
            'wanted' => $_GET['wanted'],
            'title' => $_GET['title'],
            'zufangtype' => $_GET['zufangtype'],
            'qq' => $_GET['qq'],
            'new' => $_GET['new'],
            'zujin' => $_GET['zujin'],
            'content' => $_GET['content'],
            'lxr' => $_GET['lxr'],
            'region' => $_GET['region'],
            'region1' => $_GET['region1'],
            'region2' => $_GET['region2'],
            'contact' => $_GET['contact'],
            'phone' =>  $_G['mobile'],
            'uid' => $_G['uid'],
            'username' => $_G['username'],
            'addtime' => TIMESTAMP,
            'updatetime' => TIMESTAMP,
			'state' =>  $state,
			'clientip' => $_G['clientip'],
        );
        for ($i = 1; $i <= 8; $i++) {
            $pic = 'pic' . $i;
            if ($$pic) {
                $insertarray[$pic] = $$pic;
            }
        }
		if (file_exists("source/plugin/aljes/template/com/release.php")) {
			include 'source/plugin/aljes/template/com/release.php';
		}
        $insertid = C::t('#aljes#aljes')->insert($insertarray, true);
		if (file_exists("source/plugin/aljes/template/com/tongbu.php")&&!$config['isreview']) {
			include 'source/plugin/aljes/template/com/tongbu.php';
		}
		
        C::t('#aljes#aljes_user')->update_count_by_uid($_G['uid']);
		if($_GET['sj']){
			echo "<script>parent.tips('".str_replace('\\','',lang('plugin/aljes','aljes_4'))."',function(){parent.location.href='plugin.php?id=aljes&act=view&lid=".$insertid."';});</script>";
		}else{
			showmsg(str_replace('\\','',lang('plugin/aljes','aljes_4')), 2, $insertid);
		}
    } else {
		if(!$_G['uid']){
			showmessage(lang('plugin/aljes','aljes_1'), '', array(), array('login' => true));
		}
		//允许提问用户组
		if(!in_array($_G['groupid'],unserialize($config['lj_groups']))){
				showmessage($config['lj_tsy']);
		}
		if (file_exists("source/plugin/aljes/template/com/release.php")) {
			if (getuserprofile('extcredits' . $config['releaseextcredit']) < $config['releasepay']) {
				showmessage($_G['setting']['extcredits'][$config['releaseextcredit']]['title'] . lang('plugin/aljes','top_1'));
			}
		}
        $rs = C::t('#aljes#aljes_region')->fetch_all_by_upid(0);
        include template('aljes:post');
    }
} else if ($_GET['act'] == 'edit') {
    if (submitcheck('formhash')) {
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
        showmsg(str_replace('\\','',lang('plugin/aljes','aljes_5')), 2, $_GET['lid']);
    } else {
        $rs = C::t('#aljes#aljes_region')->fetch_all_by_upid(0);
        $lp = C::t('#aljes#aljes')->fetch($_GET['lid']);
		if($lp['uid']!=$_G['uid']&&$_G['groupid']!=1){
			showmessage(lang('plugin/aljesf','aljes_8'));
		}
        $ps = explode(',', $lp['peizhi']);
        if ($lp['region']) {
            $rrs = C::t('#aljes#aljes_region')->fetch_all_by_upid($lp['region']);
        }
        include template('aljes:post');
    }
} else if ($_GET['act'] == 'reflash') {
    if (file_exists("source/plugin/aljes/template/com/reflash.php")) {
        include 'source/plugin/aljes/template/com/reflash.php';
    }
} else if ($_GET['act'] == 'top') {
    if (file_exists("source/plugin/aljes/template/com/top.php")) {
        include 'source/plugin/aljes/template/com/top.php';
    }
} else if ($_GET['act'] == 'view') {
    if (empty($_GET['lid'])) {
        showmessage(lang('plugin/aljes','aljes_6'));
    }
    C::t('#aljes#aljes')->update_views_by_id($_GET['lid']);
    $pics = array('pic1', 'pic2', 'pic3', 'pic4', 'pic5', 'pic6', 'pic7', 'pic8');
    $regions = C::t('#aljes#aljes_region')->range();
    $lp = C::t('#aljes#aljes')->fetch($_GET['lid']);
	if (file_exists("source/plugin/aljes/template/com/qrcode.php")) {
		if(!file_exists('source/plugin/aljes/images/qrcode/'.$lp['qrcode'])||!$lp['qrcode']){
			$file = dgmdate(TIMESTAMP, 'YmdHis').random(18).'.jpg';	 QRcode::png($_G['siteurl'].'plugin.php?id=aljes&act=view&lid='.$_GET['lid'], 'source/plugin/aljes/images/qrcode/'.$file, QR_MODE_STRUCTURE, 8);
			DB::update('aljes', array('qrcode'=>$file), "id=".$_GET['lid']);
		}
	}
    $lp = dhtmlspecialchars($lp);
	if($config['isyouke']){
		$tel=hidtel($lp['contact']);
	}
	$cod=$regions[$lp['region']]['subject'].$regions[$lp['region1']]['subject'].$lp['region2'];
	if($_G['charset']=='gbk'){
		$cod=diconv($cod,'gbk','utf-8');
	}
	$url=urlencode($cod);
	$qita = DB::fetch_all("SELECT * FROM ".DB::table('aljes')." where state=0 and uid=".$lp[uid]." ORDER BY id desc limit 0,".$config['qitanum']);
	foreach($qita as $k=>$v){
		$qita[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
	$commentlist=C::t('#aljes#aljes_comment')->fetch_all_by_upid(0,$_GET['lid']);
	$commentlist=dhtmlspecialchars($commentlist);
    $navtitle = $lp['title'] . '-' . $config['title'];
    $metakeywords = $lp['title'];
    $metadescription = $lp['title'];
	if($_G['mobile']) {
		include template('aljes:view');
	} else {
		include template('diy:aljes_view', null, 'source/plugin/aljes/template');
	}
    
} else if ($_GET['act'] == 'delete') {
	$user=C::t('#aljes#aljes')->fetch($_GET['lid']);
	if($user['uid']!=$_G['uid']&&$_G['groupid']!=1){
		showmessage(lang('plugin/aljes','aljes_8'));
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
    C::t('#aljes#aljes')->delete($_GET['lid']);
    showmessage(lang('plugin/aljes','aljes_7'), 'plugin.php?id=aljes&act=member');
}else if($_GET['act'] == 'ask'){
	
	if(submitcheck('formhash')){
		if (empty($_G['uid'])) {
			showerror(lang('plugin/aljes','aljes_1'));
		}
		if (empty($_GET['message'])) {
			showerror(lang('plugin/aljes','aljes_9'));
		}
		$insertarray=array(
			'content'=>$_GET['message'],	
			'uid'=>$_G['uid'],	
			'username'=>$_G['username'],	
			'lid'=>$_GET['lid'],
			'dateline'=>TIMESTAMP,
		);
		C::t('#aljes#aljes_comment')->insert($insertarray);
		if($config['is_ping']){
			$lp=C::t('#aljes#aljes')->fetch($_GET['lid']);
			notification_add($lp['uid'], 'system',lang('plugin/aljes','aljes_27').' <a target="_blank" href="plugin.php?id=aljes&act=view&lid='.$_GET['lid'].'">'.$lp['title'].'</a> '.lang('plugin/aljes','aljes_28').' <a href="plugin.php?id=aljes&act=view&lid='.$_GET['lid'].'" target="_blank">'.lang('plugin/aljes','aljes_29').'</a>');
		}
		showmsg(lang('plugin/aljes','aljes_10'));
	}
}else if($_GET['act'] == 'reply'){
	if(submitcheck('formhash')){
		if (empty($_G['uid'])) {
			showerror(lang('plugin/aljes','aljes_1'));
		}
		if (empty($_GET['message'])) {
			showerror(lang('plugin/aljes','aljes_9'));
		}
		$insertarray=array(
			'content'=>$_GET['message'],	
			'uid'=>$_G['uid'],	
			'username'=>$_G['username'],	
			'lid'=>$_GET['lid'],
			'dateline'=>TIMESTAMP,
			'upid'=>$_GET['upid'],
		);
		C::t('#aljes#aljes_comment')->insert($insertarray);
		if($config['is_ping']){
			$lp=C::t('#aljes#aljes_comment')->fetch($_GET['upid']);
			notification_add($lp['uid'], 'system',lang('plugin/aljes','aljes_30').$config['daohang'].lang('plugin/aljes','aljes_31').' <a href="plugin.php?id=aljes&act=view&lid='.$_GET['lid'].'" target="_blank">'.lang('plugin/aljes','aljes_29').'</a>');
		}
		showmsg(lang('plugin/aljes','aljes_10'));
	}
}else if($_GET['act'] == 'commentdel'){
	if($_GET['formhash']==formhash()){
		if (empty($_G['uid'])) {
			showerror(lang('plugin/aljes','aljes_1'));
		}
		$upid=DB::fetch_all(" select * from %t where upid=%d",array('aljes_comment',$_GET['cid']));
		if($upid){
			foreach($upid as $id){
				C::t('#aljes#aljes_comment')->delete($id['id']);
			}
		}
		C::t('#aljes#aljes_comment')->delete($_GET['cid']);
		showmessage(lang('plugin/aljes','aljes_7'),'plugin.php?id=aljes&act=view&lid='.$_GET['lid']);
	}
}else if ($_GET['act'] == 'getregion') {
    if ($_GET['rid']) {
        $rs = C::t('#aljes#aljes_region')->fetch_all_by_upid($_GET['rid']);
    }

    include template('aljes:getregion');
} else if ($_GET['act'] == 'member') {
    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = $config['page'];
    $num = C::t('#aljes#aljes')->count_by_status($_GET['search']);
    $start = ($currpage - 1) * $perpage;
	if($_G['groupid']!=1){
		$conndtion = array(
			'uid' => $_G['uid'],
		);
	}
    
    $lplist = C::t('#aljes#aljes')->fetch_all_by_addtime($start, $perpage, $conndtion);
	//debug($lplist);
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljes&act=member', 0, 11, false, false);
    include template('aljes:member');
} else if ($_GET['act'] == 'adminlp') {
    if (file_exists("source/plugin/aljes/template/com/admin.php")) {
        include 'source/plugin/aljes/template/com/admin.php';
    }
} else if ($_GET['act'] == 'adminuser') {
    if (file_exists("source/plugin/aljes/template/com/user.php")) {
        include 'source/plugin/aljes/template/com/user.php';
    }
} else if ($_GET['act'] == 'adminreflash') {
    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = 10;
    $num = C::t('#aljes#aljes_reflashlog')->count();
    //$num = DB::result_first(" select count(*) from ".DB::table('aljes_reflashlog')." where title!=null ");
    $start = ($currpage - 1) * $perpage;

    $logs = C::t('#aljes#aljes_reflashlog')->range($start, $perpage, 'desc');
    //$logs = DB::fetch_all(" select * from ".DB::table('aljes_reflashlog')." where title!=null order by id desc limit $start,$perpage");
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljes&act=adminreflash', 0, 11, false, false);
    include template('aljes:adminreflash');
} else if ($_GET['act'] == 'admintop') {
    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = $config['page'];
    $num = C::t('#aljes#aljes_toplog')->count();
    $start = ($currpage - 1) * $perpage;

    $logs = C::t('#aljes#aljes_toplog')->range($start, $perpage, 'desc');
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljes&act=admintop', 0, 11, false, false);
    include template('aljes:admintop');
}else if($_GET['act'] == 'all'){
	if (file_exists("source/plugin/aljes/template/com/qita.php")) {
        include 'source/plugin/aljes/template/com/qita.php';
    }
} else {
    $todayviews = C::t('#aljes#aljes_log')->fetch_all_by_day();
    $regions = C::t('#aljes#aljes_region')->range();
    $rs = C::t('#aljes#aljes_region')->fetch_all_by_upid(0);
    $rrs = C::t('#aljes#aljes_region')->fetch_all_by_upid($_GET['rid']);

    $currpage = $_GET['page'] ? $_GET['page'] : 1;
    $perpage = $config['page'];
   
    $start = ($currpage - 1) * $perpage;
    $conndtion = array(
        'search' => $_GET['search'],
        'rid' => $_GET['rid'],
        'subrid' => $_GET['subrid'],
        'zufangtype' => $_GET['zufangtype'],
        'pay1' => $_GET['pay1'],
        'pay2' => $_GET['pay2'],
        'wanted' => $_GET['wanted'],
        'new' => $_GET['new'],
    );
	$num = C::t('#aljes#aljes')->count_by_status($conndtion);
	$total_page = ceil($num/$perpage);
	//debug($num);
	//第一页的时候没有上一页		
	if($total_page>1){
		if($currpage > 1){
			$shangyiye='<a href="plugin.php?id=aljes&page='.($currpage-1).'&search='.$_GET['search'].'&rid='.$_GET['rid'].'&subrid='.$_GET['subrid'].'&pay1='.$_GET['pay1'].'&pay2='.$_GET['pay2'].'&zufangtype='.$_GET['zufangtype'].'&new='.$_GET['new'].'">'.lang('plugin/aljes','sj_1').'</a>&nbsp;&nbsp;';
		}else{
			$shangyiye='<span>'.lang('plugin/aljes','sj_1').'</span>';
		}
		//尾页的时候不显示下一页
		if($currpage < $total_page){
			//debug(123);
			$xiayiye= '<a href="plugin.php?id=aljes&page='.($currpage+1).'&search='.$_GET['search'].'&rid='.$_GET['rid'].'&subrid='.$_GET['subrid'].'&pay1='.$_GET['pay1'].'&pay2='.$_GET['pay2'].'&zufangtype='.$_GET['zufangtype'].'&new='.$_GET['new'].'">'.lang('plugin/aljes','sj_2').'</a>&nbsp;&nbsp;';
			//debug($xiayiye);
		}else{
			$xiayiye='<span>'.lang('plugin/aljes','sj_2').'</span>';
		}
	}
    $lplist = C::t('#aljes#aljes')->fetch_all_by_addtime($start, $perpage, $conndtion);
	foreach($lplist as $k=>$v){
		if(TIMESTAMP>$v['topetime']&&$v['topetime']){
			DB::update('aljes',array('topstime'=>'','topetime'=>''),'id='.$v[id]);
		}
		$lplist[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
    $lplist = dhtmlspecialchars($lplist);
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljes&search='.$_GET['search'].'&rid='.$_GET['rid'].'&subrid='.$_GET['subrid'].'&pay1='.$_GET['pay1'].'&pay2='.$_GET['pay2'].'&zufangtype='.$_GET['zufangtype'].'&new='.$_GET['new'].'&view='.$_GET['view'], 0, 11, false, false);
	$tuijian = DB::fetch_all("SELECT * FROM ".DB::table('aljes')." where state=0 and tuijian=1 ORDER BY id desc limit 0,9");
	foreach($tuijian as $k=>$v){
		$tuijian[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
    $toplist = C::t('#aljes#aljes_toplog')->fetch_all_by_dateline();
	foreach($toplist as $k=>$v){
		$toplist[$k]['rewrite']=str_replace ("{id}", $v['id'], $config ['re_view']);
	}
	
    $navtitle = $config['title'];
    $metakeywords = $config['keywords'];
    $metadescription = $config['description'];
	if($_G['mobile']) {
		include template('aljes:index');
	} else {
		include template('diy:aljes_index', null, 'source/plugin/aljes/template');
	}
}

function showmsg($msg, $close, $id) {
    if ($close == 1) {
        $str = "parent.hideWindow('$close');";
    } else if ($close == 2) {
        $str = "parent.location.href='plugin.php?id=aljes&act=view&lid=" . $id . "'";
    } else {
        $str = "parent.location=parent.location;";
    }
    include template('aljes:showmsg');
    exit;
}

function showerror($msg) {
    include template('aljes:showerror');
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