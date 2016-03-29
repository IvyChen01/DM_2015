<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$aljbd_seo = dunserialize($_G['setting']['aljbd_seo']);
$_G['setting']['switchwidthauto']=0;
$_G['setting']['allowwidthauto']=1;
$config = $_G['cache']['plugin']['aljbd'];
$admingroups = unserialize($config['managegroups']);
require_once DISCUZ_ROOT.'source/plugin/aljbd/class/qrcode.class.php';
if (file_exists("source/plugin/aljbd/com/qrcode.php")) {
	if (!file_exists("source/plugin/aljbd/images/qrcode/aljbd_qrcode.jpg")) {
		include 'source/plugin/aljbd/com/qrcode.php';
	}
}
$businesstype = explode ("\n", str_replace ("\r", "", $config ['businesstype']));
foreach($businesstype as $key=>$value){
	$arr=explode('=',$value);
	$businesstypearr[$arr[0]]=$arr[1];
}

$ress=array(
	'brand_index.html'=>'plugin.php?id=aljbd',
	'brand.html'=>'plugin.php?id=aljbd&act=dianpu',
	'goods.html'=>'plugin.php?id=aljbd&act=goods',
	'notice.html'=>'plugin.php?id=aljbd&act=nlist',
	'consume.html'=>'plugin.php?id=aljbd&act=clist',
);
$index_dh = explode ("\n", str_replace ("\r", "", $config ['index_dh']));
foreach($index_dh as $key=>$value){
	$arr=explode('|',$value);
	$index_dh_types[$arr[0]]=$arr[1];
}
if ($_SERVER ['HTTP_X_REWRITE_URL']) {
	$the_uri = isset($_SERVER ['HTTP_X_REWRITE_URL']) ? $_SERVER ['HTTP_X_REWRITE_URL'] : '';
} else {
	$the_uri = isset($_SERVER ['REQUEST_URI']) ? $_SERVER ['REQUEST_URI'] : '';
}
$act = $_GET['act'];
$the_uri=ltrim($the_uri,'/');
$url_dh=ltrim($_SERVER['PHP_SELF'].'?'.$_SERVER["QUERY_STRING"],'/');
//debug($the_uri);
$aljbd=C::t('#aljbd#aljbd')->range();
$mygroup=C::t('#aljbd#aljbd_usergroup')->fetch($_G['groupid']);
$yindao = explode ("\n", str_replace ("\r", "", $config ['yindao']));
	foreach($yindao as $key=>$value){
		$arr=explode('|',$value);
		
		$yd_types[]=$arr;
	}
if($_GET['act']=='fl'){
	$navtitle = lang('plugin/aljbd','sj_4').$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	include template('aljbd:fenlei');
}else if($_GET['act']=='dq'){
	$navtitle = lang('plugin/aljbd','sj_5').$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	include template('aljbd:diqu');
}else if($_GET['act']=='order'){
	$navtitle = lang('plugin/aljbd','sj_6').$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	include template('aljbd:order');
}else if($_GET['act']=='dianping'){
	$navtitle = lang('plugin/aljbd','sj_7').$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	include template('aljbd:dianping');
}else if($_GET['act']=='dianpu'){
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	$typecount=C::t('#aljbd#aljbd')->count_by_type();
	//debug($typecount);
	foreach($typecount as $tc){
		$tcs[$tc['type']]=$tc['num'];
	}
	//debug($tcs);
	if($_GET['type']){
		$subtypecount=C::t('#aljbd#aljbd')->count_by_type($_GET['type']);
	}
	$aljbd=C::t('#aljbd#aljbd')->fetch_by_uid($_G['uid']);
	//debug($aljbd);
	$config=$_G['cache']['plugin']['aljbd'];
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$titlelist=C::t('#aljbd#aljbd_region')->range();
	$tlist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
	$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid(0);
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=$config['page'];
	$recommendlist=C::t('#aljbd#aljbd')->fetch_all_by_recommend(1,0,6);
	$recommendlist_goods=C::t('#aljbd#aljbd_goods')->fetch_all_by_recommend(1,0,10);
	
	if($_G['charset']=='gbk'&&!defined('IN_MOBILE')&&$config['is_daohang']||defined('IN_MOBILE')&&!$_GET['sj']){
		$_GET['kw']=diconv($_GET['kw'],'utf-8','gbk');
	}
	$num=C::t('#aljbd#aljbd')->count_by_status(1,'',$_GET['type'],$_GET['subtype'],$_GET['region'],$_GET['subregion'],$_GET['kw'],'',$_GET['region1']);
	
	$total_page = ceil($num/$perpage);
//debug($currpage > 1);
		//第一页的时候没有上一页
	if($total_page>1){
		if($currpage > 1){
			$shangyiye='<a href="plugin.php?id=aljbd&act=dianpu&page='.($currpage-1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&region='.$_GET['region'].'&subregion='.$_GET['subregion'].'&order='.$_GET['order'].'">'.lang('plugin/aljbd','sj_3').'</a>&nbsp;&nbsp;';
		}else{
			$shangyiye='<span>'.lang('plugin/aljbd','sj_3').'</span>';
		}
		//尾页的时候不显示下一页
		if($currpage < $total_page){
			//debug(123);
			$xiayiye= '<a href="plugin.php?id=aljbd&act=dianpu&page='.($currpage+1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&region='.$_GET['region'].'&subregion='.$_GET['subregion'].'&order='.$_GET['order'].'">'.lang('plugin/aljbd','sj_2').'</a>&nbsp;&nbsp;';
			//debug($xiayiye);
		}else{
			$xiayiye='<span>'.lang('plugin/aljbd','sj_2').'</span>';
		}
	}
	$allpage=ceil($num/$perpage);
	$start=($currpage-1)*$perpage;
	
	
	if($config['isrewrite']&&!$_GET['page']){
		if($_GET['order']=='1'){
			$_GET['order']='view';
		}else if($_GET['order']=='2'){
			$_GET['order']='dateline';
		}else{
			$_GET['order']='';
		}
		if($_GET['view']=='3'){
			$_GET['view']="pic";
		}else if($_GET['view']=='4'){
			$_GET['view']="list";
		}else{
			$_GET['view']='';
		}
	}
	if(!$_GET['order']&&$config['paixu']){
		if($config['paixu']==1){
			$_GET['order']='view';
		}else if($config['paixu']==2){
			$_GET['order']='dateline';
		}
	}
	
	$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,$start,$perpage,'',$_GET['type'],$_GET['subtype'],$_GET['region'],$_GET['subregion'],$_GET['order'],$_GET['kw'],'',$_GET['region1']);
	//
	foreach($bdlist as $k=>$v){
		$bdlist[$k]['c']=C::t('#aljbd#aljbd_comment')->fetch_by_bid($v['id']);
		$bdlist[$k]['q']=str_replace('{qq}',$v['qq'],$config['qq']);
		$bdlist[$k]['intro']=preg_replace("/\<img src=.*? alt=.*?\/\>/is","",preg_replace('/\[img.*?\].*?\[\/img\]/is','',$v['intro']));
		//$bdlist[$k]['intro']=preg_replace("/\<img src=.*? alt=.*?\/\>/is","",$v['intro']);
	}
	//$bdlist=dhtmlspecialchars($bdlist);
	//debug($bdlist);
	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',0,9);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=dianpu&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&region='.$_GET['region'].'&subregion='.$_GET['subregion'].'&order='.$_GET['order'].'&kw='.$_GET['kw'].'&view='.$_GET['view'].'&region1='.$_GET['region1'], 0, 11, false, false);
	if($_GET['region']){
		$title=$titlelist[$_GET['region']]['name'];
	}
	if($_GET['subregion']){
		$title=$titlelist[$_GET['subregion']]['name'];
		
	}
	if($_GET['region1']){
		$title=$titlelist[$_GET['region1']]['name'];
	}
	if($_GET['type']){
		$cat=$typelist[$_GET['type']]['subject'];
	}
	if($_GET['subtype']){
		$cat=$typelist[$_GET['subtype']]['subject'];
	}
	$navtitle = $title.lang('plugin/aljbd','s44').$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	if($aljbd_seo['list']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname'],'cat'=>$cat,'region'=>$title);
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['list']);
	}
	include template('aljbd:dianpu');
}else if($_GET['act']=='goods'){
	if(file_exists('source/plugin/aljbd/com/good.php')){
		if($_GET['ac']=='fl'){
			$navtitle = lang('plugin/aljbd','sj_8').$config['title'];
			$metakeywords =  $config['keywords'];
			$metadescription = $config['description'];
			include template('aljbd:fenlei_goods');
		}else if($_GET['ac']=='order'){
			$navtitle = lang('plugin/aljbd','sj_9').$config['title'];
			$metakeywords =  $config['keywords'];
			$metadescription = $config['description'];
			include template('aljbd:order_goods');
		}else{
			$navtitle = lang('plugin/aljbd','s57').$config['title'];
			$metakeywords =  $config['keywords'];
			$metadescription = $config['description'];
			
			$typecount=C::t('#aljbd#aljbd_goods')->count_by_type();
			//debug($typecount);
			foreach($typecount as $tc){
				$tcs[$tc['type']]=$tc['num'];
			}
			//debug($tcs);
			if($_GET['type']){
				$subtypecount=C::t('#aljbd#aljbd_goods')->count_by_type($_GET['type']);
			}
			$aljbd=C::t('#aljbd#aljbd')->range();
			//debug($aljbd);
			$config=$_G['cache']['plugin']['aljbd'];
			$typelist=C::t('#aljbd#aljbd_type_goods')->range();
			$tlist=C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid(0);
			//$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid(0);
			$currpage=intval($_GET['page'])?intval($_GET['page']):1;
			$perpage=$config['page'];
			if($_G['charset']=='gbk'&&!defined('IN_MOBILE')&&$config['is_daohang']||defined('IN_MOBILE')&&!$_GET['sj']){
				$_GET['kw']=diconv($_GET['kw'],'utf-8','gbk');
			}
			$num=C::t('#aljbd#aljbd_goods')->count_by_status('','',$_GET['type'],$_GET['subtype'],$_GET['region'],$_GET['subregion'],$_GET['kw']);
			
			$total_page = ceil($num/$perpage);
			//第一页的时候没有上一页
			if($total_page>1){
				if($currpage > 1){
					$shangyiye='<a href="plugin.php?id=aljbd&act=goods&page='.($currpage-1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&order='.$_GET['order'].'">'.lang('plugin/aljbd','sj_3').'</a>&nbsp;&nbsp;';
				}else{
					$shangyiye='<span>'.lang('plugin/aljbd','sj_3').'</span>';
				}
				//尾页的时候不显示下一页
				if($currpage < $total_page){
					//debug(123);
					$xiayiye= '<a href="plugin.php?id=aljbd&act=goods&page='.($currpage+1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&order='.$_GET['order'].'">'.lang('plugin/aljbd','sj_2').'</a>&nbsp;&nbsp;';
					//debug($xiayiye);
				}else{
					$xiayiye='<span>'.lang('plugin/aljbd','sj_2').'</span>';
				}
			}
			$allpage=ceil($num/$perpage);
			$start=($currpage-1)*$perpage;
			$recommendlist=C::t('#aljbd#aljbd')->fetch_all_by_recommend(1,0,10);
			$recommendlist_goods=C::t('#aljbd#aljbd_goods')->fetch_all_by_recommend(1,0,10);
			if($config['isrewrite']&&!$_GET['page']){
				if($_GET['order']=='1'){
					$_GET['order']='view';
				}else if($_GET['order']=='2'){
					$_GET['order']='price1';
				}else{
					$_GET['order']='';
				}
				if($_GET['view']=='3'){
					$_GET['view']="pic";
				}else if($_GET['view']=='4'){
					$_GET['view']="list";
				}else{
					$_GET['view']='';
				}
			}
			
			$bdlist=C::t('#aljbd#aljbd_goods')->fetch_all_by_status('',$start,$perpage,'',$_GET['type'],$_GET['subtype'],$_GET['region'],$_GET['subregion'],$_GET['order'],$_GET['kw']);
			//
			$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',0,9);
			$clist=dhtmlspecialchars($clist);
			foreach($bdlist as $k=>$v){
				$bdlist[$k]['c']=C::t('#aljbd#aljbd_comment')->fetch_by_bid($v['id']);
				$bdlist[$k]['q']=str_replace('{qq}',$v['qq'],$config['qq']);
			}
			//$bdlist=dhtmlspecialchars($bdlist);
			
			$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=goods&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&order='.$_GET['order'].'&kw='.$_GET['kw'].'&view='.$_GET['view'], 0, 11, false, false);
			if($aljbd_seo['good_list']['seotitle']){
				if($_GET['type']){
					$cat=$typelist[$_GET['type']]['subject'];
				}
				if($_GET['subtype']){
					$cat=$typelist[$_GET['subtype']]['subject'];
				}
				$seodata = array('bbname' => $_G['setting']['bbname'],'cat'=>$cat);
				list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['good_list']);
			}
			include template('aljbd:list_goods');
		}
	}else{
		showmessage(lang('plugin/aljbd','good'));
	}
}else if($_GET['act']=='clist'){
	if(file_exists('source/plugin/aljbd/com/consume.php')){
		require_once libfile('function/discuzcode');
		$navtitle = lang('plugin/aljbd','index_1').$config['title'];
		$metakeywords =  $config['keywords'];
		$metadescription = $config['description'];
		$typecount=C::t('#aljbd#aljbd_consume')->count_by_type();
		foreach($typecount as $tc){
			$tcs[$tc['type']]=$tc['num'];
		}
		if($_GET['type']){
			$subtypecount=C::t('#aljbd#aljbd_consume')->count_by_type($_GET['type']);
		}
		$aljbd=C::t('#aljbd#aljbd')->range();
		$config=$_G['cache']['plugin']['aljbd'];
		$typelist=C::t('#aljbd#aljbd_type_consume')->range();
		$tlist=C::t('#aljbd#aljbd_type_consume')->fetch_all_by_upid(0);
		//$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid(0);
		$currpage=intval($_GET['page'])?intval($_GET['page']):1;
		$perpage=12;
		if($_G['charset']=='gbk'&&!defined('IN_MOBILE')&&$config['is_daohang']||defined('IN_MOBILE')&&!$_GET['sj']){
			$_GET['kw']=diconv($_GET['kw'],'utf-8','gbk');
		}
		$num=C::t('#aljbd#aljbd_consume')->count_by_uid_bid('','',$_GET['type'],$_GET['subtype'],$_GET['kw']);
		$total_page = ceil($num/$perpage);
		//第一页的时候没有上一页
		if($total_page>1){
			if($currpage > 1){
				$shangyiye='<a href="plugin.php?id=aljbd&act=clist&page='.($currpage-1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'">'.lang('plugin/aljbd','sj_3').'</a>&nbsp;&nbsp;';
			}else{
				$shangyiye='<span>'.lang('plugin/aljbd','sj_3').'</span>';
			}
			//尾页的时候不显示下一页
			if($currpage < $total_page){
				//debug(123);
				$xiayiye= '<a href="plugin.php?id=aljbd&act=clist&page='.($currpage+1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'">'.lang('plugin/aljbd','sj_2').'</a>&nbsp;&nbsp;';
				//debug($xiayiye);
			}else{
				$xiayiye='<span>'.lang('plugin/aljbd','sj_2').'</span>';
			}
		}
		$allpage=ceil($num/$perpage);
		$start=($currpage-1)*$perpage;
		$recommendlist=C::t('#aljbd#aljbd')->fetch_all_by_recommend(1,0,10);
		$recommendlist_goods=C::t('#aljbd#aljbd_goods')->fetch_all_by_recommend(1,0,10);
		if($config['isrewrite']){
			if($_GET['order']=='1'){
				$_GET['order']='view';
			}else if($_GET['order']=='2'){
				$_GET['order']='price1';
			}else{
				$_GET['order']='';
			}
			if($_GET['view']=='3'){
				$_GET['view']="pic";
			}else if($_GET['view']=='4'){
				$_GET['view']="list";
			}else{
				$_GET['view']='';
			}
		}
		
		$clist=C::t('#aljbd#aljbd_consume')->fetch_all_by_uid_bid('','',$start,$perpage,$_GET['type'],$_GET['subtype'],$_GET['kw']);
		$clist=dhtmlspecialchars($clist);
		//
		$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',0,9);
		$nlist=dhtmlspecialchars($nlist);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=clist&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&kw='.$_GET['kw'], 0, 11, false, false);
		if($aljbd_seo['consume_list']['seotitle']){
			if($_GET['type']){
				$cat=$typelist[$_GET['type']]['subject'];
			}
			if($_GET['subtype']){
				$cat=$typelist[$_GET['subtype']]['subject'];
			}
			$seodata = array('bbname' => $_G['setting']['bbname'],'cat'=>$cat);
			list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['consume_list']);
		}
		include template('aljbd:list_consume');
	}else{
		showmessage(lang('plugin/aljbd','consume'));
	}
}else if($_GET['act']=='nlist'){
	if(file_exists('source/plugin/aljbd/com/notice.php')){
		$navtitle = lang('plugin/aljbd','index_2').$config['title'];
		$metakeywords =  $config['keywords'];
		$metadescription = $config['description'];
		
		$typecount=C::t('#aljbd#aljbd_notice')->count_by_type();
		//debug($typecount);
		foreach($typecount as $tc){
			$tcs[$tc['type']]=$tc['num'];
		}
		//debug($tcs);
		if($_GET['type']){
			$subtypecount=C::t('#aljbd#aljbd_notice')->count_by_type($_GET['type']);
		}
		$aljbd=C::t('#aljbd#aljbd')->range();
		//debug($aljbd);
		$config=$_G['cache']['plugin']['aljbd'];
		$typelist=C::t('#aljbd#aljbd_type_notice')->range();
		$tlist=C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid(0);
		//$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid(0);
		$currpage=intval($_GET['page'])?intval($_GET['page']):1;
		$perpage=12;
		if($_G['charset']=='gbk'&&!defined('IN_MOBILE')&&$config['is_daohang']||defined('IN_MOBILE')&&!$_GET['sj']){
			$_GET['kw']=diconv($_GET['kw'],'utf-8','gbk');
		}
		$num=C::t('#aljbd#aljbd_notice')->count_by_uid_bid('','',$_GET['type'],$_GET['subtype'],$_GET['kw']);
		$total_page = ceil($num/$perpage);
		//第一页的时候没有上一页
		if($total_page>1){
			if($currpage > 1){
				$shangyiye='<a href="plugin.php?id=aljbd&act=nlist&page='.($currpage-1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'">'.lang('plugin/aljbd','sj_3').'</a>&nbsp;&nbsp;';
			}else{
				$shangyiye='<span>'.lang('plugin/aljbd','sj_3').'</span>';
			}
			//尾页的时候不显示下一页
			if($currpage < $total_page){
				//debug(123);
				$xiayiye= '<a href="plugin.php?id=aljbd&act=nlist&page='.($currpage+1).'&kw='.$_GET['kw'].'&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'">'.lang('plugin/aljbd','sj_2').'</a>&nbsp;&nbsp;';
				//debug($xiayiye);
			}else{
				$xiayiye='<span>'.lang('plugin/aljbd','sj_2').'</span>';
			}
		}
		$allpage=ceil($num/$perpage);
		$start=($currpage-1)*$perpage;
		$recommendlist=C::t('#aljbd#aljbd')->fetch_all_by_recommend(1,0,10);
		$recommendlist_goods=C::t('#aljbd#aljbd_goods')->fetch_all_by_recommend(1,0,10);
		$day = date('d');
		$mon = date('m');
		$year = date('Y');
		$today = date('N');
		$qiday = date('Y-m-d', mktime(0, 0, 0, $mon, $day - $today + 1, $year));
		
		$san = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon, $day - $today + 3, $year));
		
		if($_GET['order']=='1'){
			$order='view';
		}else if($_GET['order']=='2'){
			$order=' and dateline >='.strtotime(date('Y-m-d 00:00:00'));
		}else if($_GET['order']=='3'){
			$order=' and dateline >='.strtotime($san);
		}else if($_GET['order']=='4'){
			$order=' and dateline >='.strtotime($qiday);
		}
		
		$nlist=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',$start,$perpage,$_GET['type'],$_GET['subtype'],$order,$_GET['kw']);
		
		
		foreach($nlist as $k=>$v){
			preg_match_all("/<img.*?src=[\\\'| \\\"](.*?(?:[\.gif|\.jpg]))[\\\'|\\\"].*?[\/]?>/",$v[content],$arr); 
			
			$nlist[$k]['pic']=$arr[1][0];
			
		}
		
		
		$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',0,9);
		
		$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=nlist&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&order='.$_GET['order'], 0, 11, false, false);
		if($aljbd_seo['notice_list']['seotitle']){
			if($_GET['type']){
				$cat=$typelist[$_GET['type']]['subject'];
			}
			if($_GET['subtype']){
				$cat=$typelist[$_GET['subtype']]['subject'];
			}
			$seodata = array('bbname' => $_G['setting']['bbname'],'cat'=>$cat);
			list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['notice_list']);
		}
		include template('aljbd:list_notice');
	}else{
		showmessage(lang('plugin/aljbd','notice'));
	}
}else if($_GET['act']=='ajax'){
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=20;
	$num=C::t('#aljbd#aljbd_album')->count();
	$total_page = ceil($num/$perpage);
	for($i=1;$i<$total_page;$i++){
		if($currpage==$i){
			$class='class="p_curpage"';
		}else{
			$class='class="p_num"';
		}
		$url.='<a '.$class.' href="plugin.php?id=aljbd&act=ajax&page='.$i.'">'.$i.'</a>&nbsp;';
	}
	$allpage=ceil($num/$perpage);
	$start=($currpage-1)*$perpage;
	$alist=C::t('#aljbd#aljbd_album')->range($start,$perpage,'desc');
	include template('aljbd:ajax');
}else if($_GET['act']=='alist'){
	if(file_exists('source/plugin/aljbd/com/album.php')){
		$navtitle = lang('plugin/aljbd','index_9').$config['title'];
		$metakeywords =  $config['keywords'];
		$metadescription = $config['description'];
		$typecount=C::t('#aljbd#aljbd_notice')->count_by_type();
		foreach($typecount as $tc){
			$tcs[$tc['type']]=$tc['num'];
		}
		if($_GET['type']){
			$subtypecount=C::t('#aljbd#aljbd_notice')->count_by_type($_GET['type']);
		}
		$aljbd=C::t('#aljbd#aljbd')->range();
		$config=$_G['cache']['plugin']['aljbd'];
		$typelist=C::t('#aljbd#aljbd_type_notice')->range();
		$tlist=C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid(0);
		//$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid(0);
		if($_G['charset']=='gbk'&&!defined('IN_MOBILE')&&$config['is_daohang']||defined('IN_MOBILE')&&!$_GET['sj']){
			$_GET['kw']=diconv($_GET['kw'],'utf-8','gbk');
		}
		$recommendlist=C::t('#aljbd#aljbd')->fetch_all_by_recommend(1,0,10);
		$recommendlist_goods=C::t('#aljbd#aljbd_goods')->fetch_all_by_recommend(1,0,10);
		$currpage=intval($_GET['page'])?intval($_GET['page']):1;
		$perpage=20;
		$num=C::t('#aljbd#aljbd_album')->count();
		$total_page = floor($num/$perpage);
		$allpage=ceil($num/$perpage);
		$start=($currpage-1)*$perpage;
		$alist=C::t('#aljbd#aljbd_album')->range($start,$perpage,'desc');
		$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',0,9);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=alist&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&order='.$_GET['order'], 0, 11, false, false);
		include template('aljbd:list_album');
	}else{
		showmessage(lang('plugin/aljbd','album'));
	}
}else if($_GET['act']=='attend'){
	
	if(submitcheck('submit')){
		$bd=C::t('#aljbd#aljbd')->fetch_by_uid($_G['uid']);
		/*if($bd&&$_G['groupid']!=1){
			showerror(lang('plugin/aljbd','s18'));
		}*/
		
		if(!$_GET['name']){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','aljbd_3')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','aljbd_3'));
			}
			
		}
		if(!$_GET['type']){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','aljbd_4')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','aljbd_4'));
			}
		}
		if(!$_GET['region']){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','aljbd_5')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','aljbd_5'));
			}
		}
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
				$logo = "source/plugin/aljbd/images/logo/". $pics;
				if(@copy($_FILES['logo']['tmp_name'], $logo)||@move_uploaded_file($_FILES['logo']['tmp_name'], $logo)){
					@unlink($_FILES['logo']['tmp_name']);
				}
			}
		}
		
		if($config['islogo']){
			if(!$_FILES['logo']['tmp_name']) {
				showerror(lang('plugin/aljbd','logo'));
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
			'status'=>$status,
			'businesstype'=>implode(',', $_GET['businesstype']),
			'dateline'=>TIMESTAMP,
			'business_hours'=>$_GET['business_hours'],
			'bus_routes'=>$_GET['bus_routes'],
		);
		$insertid =C::t('#aljbd#aljbd')->insert($insertarray, true);
		if($config['money']&&$config['money_lx']){
			updatemembercount($_G['uid'], array($config['money_lx'] => '-' . $config['money']));
		}
		if(defined('IN_MOBILE')){
			if(in_array($_G['groupid'],unserialize($config['mgroups']))){
				echo "<script>parent.tips('".lang('plugin/aljbd','mgroups')."',function(){parent.location.href='plugin.php?id=aljbd&act=view&bid=" . $insertid . "';});</script>";
				exit;
			}else{
				echo "<script>parent.tips('".lang('plugin/aljbd','s20')."',function(){parent.location.href='plugin.php?id=aljbd&act=view&bid=" . $insertid . "';});</script>";
				exit;
			}
			
		}else{
			if(in_array($_G['groupid'],unserialize($config['mgroups']))){
				showmsg(lang('plugin/aljbd','mgroups'));
			}else{
				showmsg(lang('plugin/aljbd','s20'));
			}
		}
		
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s21'));
		}
		if($config['money']&&$config['money_lx']){
			if (getuserprofile('extcredits' . $config['money_lx']) < $config['money']) {
				showmessage($_G['setting']['extcredits'][$config['money_lx']]['title'] . lang('plugin/aljbd','index_4'));
			}
		}
		$navtitle = $config['title'];
		$metakeywords =  $config['keywords'];
		$metadescription = $config['description'];
		$typelist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid();
		$brandnum=C::t('#aljbd#aljbd_usergroup')->fetch($_G['groupid']);
		$bnum=C::t('#aljbd#aljbd')->count_by_status('',$_G['uid']);
		if($brandnum['brand']){
			if($bnum>=$brandnum['brand']&&file_exists('source/plugin/aljbd/com/yhzqx.php')){
				showmessage(lang('plugin/aljbd','groups_1').$brandnum['brand'].lang('plugin/aljbd','groups_2'));
			}
		}
		include template('aljbd:adddp');
	}
}else if($_GET['act']=='glmsg'){
	$num=C::t('#aljbd#aljbd')->count_by_status(1,$_GET['uid']);
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=$config['page'];
	$num=C::t('#aljbd#aljbd')->count_by_status(1,$_GET['uid']);
	$start=($currpage-1)*$perpage;
	$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,$start,$perpage,$_GET['uid']);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=glmsg&username='.$_GET['username'], 0, 11, false, false);
	include template('aljbd:glmsg');
}else if($_GET['act']=='member'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s22'));
	}
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=$config['page'];
	$num=C::t('#aljbd#aljbd')->count_by_status(1,$_G['uid']);
	$start=($currpage-1)*$perpage;
	$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,$start,$perpage,$_G['uid']);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=member', 0, 11, false, false);
	include template('aljbd:member');
}else if($_GET['act']=='yes'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s23'));
	}
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=$config['page'];
	$num=C::t('#aljbd#aljbd')->count_by_status(0,$_G['uid']);
	$start=($currpage-1)*$perpage;
	$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(0,$start,$perpage,$_G['uid']);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=member', 0, 11, false, false);
	include template('aljbd:member');
} else if ($_GET['act'] == 'attestation') {
	if (file_exists("source/plugin/aljbd/com/attestation.php")) {
        include 'source/plugin/aljbd/com/attestation.php';
    }
}else if($_GET['act']=='gg'){
	if(file_exists('source/plugin/aljbd/com/gg.php')){
		include_once 'source/plugin/aljbd/com/gg.php';
	}
}else if($_GET['act']=='intro'){
	if(file_exists('source/plugin/aljbd/com/intro.php')){
		include_once 'source/plugin/aljbd/com/intro.php';
	}
}else if($_GET['act']=='adv'){
	if(submitcheck('formhash')){
		for($i=1;$i<=3;$i++){
			if($_FILES['adv']['tmp_name'][$i]) {
				$picname = $_FILES['adv']['name'][$i];
				$picsize = $_FILES['adv']['size'][$i];
			
				if ($picname != "") {
					$type = strstr($picname, '.');
					if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
						showerror(lang('plugin/aljbd','s25'));
					}
					if (($picsize/1024)>$config['img_size']) {
						showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
				unlink($badv[$k]);
				unset($badv[$k]);
				
			}
		}
		if($badv){
			for($i=1;$i<=3;$i++){
				if($adv[$i]){
					$badv[$i]=$adv[$i];
				}
			}
			$adv=$badv;
		}
		
		
		C::t('#aljbd#aljbd')->update($_GET['bid'],array('advurl'=>serialize($_GET['advurl']),'adv'=>serialize($adv)));
		showmsg(lang('plugin/aljbd','s27'),'edit');
	}
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	$adv=unserialize($bd['adv']);
	$advurl=unserialize($bd['advurl']);
	include template('aljbd:adv');
}else if($_GET['act']=='winfo'){
	if(file_exists('source/plugin/aljbd/com/winfo.php')){
		include_once 'source/plugin/aljbd/com/winfo.php';
	}
}else if($_GET['act']=='winfolist'){
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=1;
	$start=($currpage-1)*$perpage;
	$num=C::t('#aljbd#aljbd_winfo')->count_by_bid($_GET['bid']);
	$winfolist=C::t('#aljbd#aljbd_winfo')->fetch_all_by_bid($_GET['bid'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=winfolist&bid='.$_GET['bid'], 0, 11, false, false);
	include template('aljbd:winfolist');
}else if($_GET['act']=='commentlist'){
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=10;
	$start=($currpage-1)*$perpage;
	$num=C::t('#aljbd#aljbd_comment')->count_by_bid_all($_GET['bid']);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_page($_GET['bid'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=commentlist&bid='.$_GET['bid'], 0, 11, false, false);
	include template('aljbd:commentlist');
}else if($_GET['act']=='deletecomment'){
	C::t('#aljbd#aljbd_comment')->delete($_GET['cid']);
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=10;
	$num=C::t('#aljbd#aljbd_comment')->count_by_bid_all($_GET['bid']);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_page($_GET['bid'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=commentlist&bid='.$_GET['bid'], 0, 11, false, false);
	include template('aljbd:commentlist');
}else if($_GET['act']=='edit'){
	if(submitcheck('submit')){
		if($_FILES['logo']['tmp_name']) {
			$picname = $_FILES['logo']['name'];
			$picsize = $_FILES['logo']['size'];
		
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
					showerror(lang('plugin/aljbd','s29'));
				}
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
			'name'=>$_GET['name'],
			'tel'=>$_GET['tel'],
			'addr'=>$_GET['addr'],
			'intro'=>$_GET['intro'],
			'qq'=>$_GET['qq'],
			'wurl'=>$_GET['wurl'],
			'other'=>$_GET['other'],
			'type'=>$_GET['type'],
			'subtype'=>$_GET['subtype'],
			'region'=>$_GET['region'],
			'region1'=>$_GET['region1'],
			'subregion'=>$_GET['subregion'],
			'businesstype'=>implode(',', $_GET['businesstype']),
			
		);
		$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		if($logo){
			unlink($bd['logo']);
			$updatearray['logo']=$logo;
		}
		C::t('#aljbd#aljbd')->update($_GET['bid'],$updatearray);
		showmsg(lang('plugin/aljbd','s30'));
	}else{
		$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		$typelist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid();
		include template('aljbd:adddp');
	}
}else if($_GET['act']=='gettype'){
	if($_GET['upid']){
		if($_GET['type']=='goods'){
			$typelist=C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid($_GET['upid']);
		}else if($_GET['type']=='consume'){
			$typelist=C::t('#aljbd#aljbd_type_consume')->fetch_all_by_upid($_GET['upid']);
		}else if($_GET['type']=='notice'){
			$typelist=C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid($_GET['upid']);
		}else{
			$typelist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid($_GET['upid']);
		}
	}
	include template('aljbd:gettype');
}else if($_GET['act']=='admingetregion'){
	if($_GET['upid']){
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($_GET['upid']);
	}
	include template('aljbd:admingetregion');
}else if($_GET['act']=='admingetregion1'){
	if($_GET['upid']){
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($_GET['upid']);
	}
	include template('aljbd:admingetregion1');
}else if($_GET['act']=='getregion'){
	
	if($_GET['upid']){
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid('','',$_GET['upid']);
	}
	include template('aljbd:getregion');
}else if($_GET['act']=='getregion1'){
	if($_GET['upid']){
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid('','',$_GET['upid']);
	}
	include template('aljbd:getregion1');
}else if($_GET['act']=='view'){
	if(empty($_GET['bid'])){
		showmessage(lang('plugin/aljbd','noexists'));
	}
	$check=C::t('#aljbd#aljbd_username')->fetch_by_uid_bid($_G['uid'],$_GET['bid']);
	//$check=C::t('#aljbd#aljbd_user')->fetch($_G['uid']);
	if(empty($check)&&$_G['uid']){
		C::t('#aljbd#aljbd_username')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'bid'=>$_GET['bid']));
	}
	C::t('#aljbd#aljbd')->update_view_by_bid($_GET['bid']);
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	foreach($khf[0] as $k=>$v){
		$khf[0][$k]=intval($v);
	}
	
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$commentcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,0);
	$askcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,1);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,0);
	$commentlist=dhtmlspecialchars($commentlist);
	$asklist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,1);
	$asklist=dhtmlspecialchars($asklist);
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	if($config['isgo'] && $bd['wurl']){
		header('Location: '.$bd['wurl']);
	}
	//$bustype=explode(',',$bd['businesstype']);
	//debug($bustype[0]);
	$tell=str_replace('{qq}',$bd['qq'],str_replace('{tel}',$bd['tel'],$config['tel']));
	$qq=str_replace('{qq}',$bd['qq'],$config['qq']);
	require_once libfile('function/discuzcode');
	if(!file_exists('source/plugin/aljbd/com/intro.php')){
		$bd['intro']=discuzcode($bd['intro']);
	}
	$avg=C::t('#aljbd#aljbd_comment')->count_avg_by_bid($bd['id']);
	$avg=intval($avg);
	$gg=explode("\n",str_replace(array("\r\n","\r"),array("\n","\n"),discuzcode($bd['gg'])));
	$adv=unserialize($bd['adv']);
	$advurl=unserialize($bd['advurl']);
	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid($bd['uid'],$_GET['bid'],0,9);
	$navtitle = $bd['name'].'-'.$config['title'];
	$metakeywords =  $bd['other']?$bd['other']:$config['keywords'];
	$metadescription = $config['description'];
	//$t=C::t('#aljbd#aljbd_goods')->fetch_all_by_uid_bid_view('',$_GET['bid'],0,3);
	$t=C::t('#aljbd#aljbd_goods')->fetch_all_by_uid_bid_view($bd['uid'],$_GET['bid'],0,3);
	
	if (file_exists("source/plugin/aljbd/com/qrcode.php")) {
		if(!file_exists('source/plugin/aljbd/images/qrcode/'.$bd['qrcode'])||!$bd['qrcode']){
			$file = dgmdate(TIMESTAMP, 'YmdHis').random(18).'.jpg';	 QRcode::png($_G['siteurl'].'plugin.php?id=aljbd&act=view&bid='.$_GET['bid'], 'source/plugin/aljbd/images/qrcode/'.$file, QR_MODE_STRUCTURE, 8);
			DB::update('aljbd', array('qrcode'=>$file), "id=".$_GET['bid']);
		}
	}	
	if($aljbd_seo['view']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname'],'subject'=>$bd['name'],'message'=>mb_substr(strip_tags(preg_replace('/\<img.*?\>/is', '', $bd['intro'])),0,80,$_G['charset']));
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['view']);
	}
	//$pagelist = DB::fetch_all('select * from %t where bid = %d',array('aljbd_page',$_GET['bid']));
	include template('aljbd:view');
}else if($_GET['act']=='comment'){
	if(submitcheck('formhash')){
		
		if(empty($_GET['commentmessage_1'])){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','s31')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','s31'));
			}
		}
		if(empty($_G['uid'])){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','s21')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','s21'));
			}
			
		}
		
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_1'],
			'bid'=>$_GET['bid'],
			'displayorder'=>$_GET['isprivate'],
			'dateline'=>TIMESTAMP,
			'upid'=>0,
		);
		if(defined('IN_MOBILE')){
			$insertarray['k']=$_GET['k'];
			$insertarray['h']=$_GET['h'];
			$insertarray['f']=$_GET['f'];
		}else{
			$cs=explode('@',$_GET['commentscorestr']);
			foreach($cs as $k=>$v){
				if($v==11){
					$insertarray['k']=$cs[$k+1];
				}elseif($v==12){
					$insertarray['h']=$cs[$k+1];
				}elseif($v==13){
					$insertarray['f']=$cs[$k+1];
				}	
			}
		}
		
		if($insertarray['k']){
			$insertarray['avg']=$insertarray['k'];
		}else if($insertarray['k']&&$insertarray['h']){
			$insertarray['avg']=intval(($insertarray['k']+$insertarray['h'])/2);
		}else if($insertarray['k']&&$insertarray['h']&&$insertarray['f']){
			$insertarray['avg']=intval(($insertarray['k']+$insertarray['h']+$insertarray['f'])/3);
		}else{
			$insertarray['avg']=intval(($insertarray['h']+$insertarray['f'])/2);
		}
		//$insertarray['avg']=intval(($insertarray['k']+$insertarray['h']+$insertarray['f'])/3);
		C::t('#aljbd#aljbd')->update_comment_by_bid($_GET['bid']);
		C::t('#aljbd#aljbd_comment')->insert($insertarray);
		if(defined('IN_MOBILE')){
			echo "<script>parent.tips('".lang('plugin/aljbd','s32')."',function(){parent.location.href='plugin.php?id=aljbd&act=view&bid=" . $_GET['bid'] . "';});</script>";
		}else{
			showmsg(lang('plugin/aljbd','s32'));
		}
	}
}else if($_GET['act']=='ask'){
	if(submitcheck('formhash')){
		if(empty($_GET['commentmessage_2'])){
			showerror(lang('plugin/aljbd','s33'));
		}
		if(empty($_G['uid'])){
			showerror(lang('plugin/aljbd','s21'));
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_2'],
			'bid'=>$_GET['bid'],
			'displayorder'=>$_GET['isprivate'],
			'dateline'=>TIMESTAMP,
			'upid'=>0,
			'ask'=>$_GET['ask']
		);
		C::t('#aljbd#aljbd_comment')->insert($insertarray);
		showmsg(lang('plugin/aljbd','s34'));
	}
}else if($_GET['act']=='reply'){
	if(submitcheck('formhash')){
		if(empty($_GET['commentmessage_1'])){
			showerror(lang('plugin/aljbd','s35'));
		}
		if(empty($_G['uid'])){
			showerror(lang('plugin/aljbd','s21'));
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_1'],
			'bid'=>$_GET['bid'],
			'displayorder'=>$_GET['isprivate'],
			'dateline'=>TIMESTAMP,
			'upid'=>$_GET['upid'],
		);
		C::t('#aljbd#aljbd_comment')->insert($insertarray);
		showmsg(lang('plugin/aljbd','s36'));
	}
}else if($_GET['act']=='map'){
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	$navtitle = $bd['name'].'-'.$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	include template('aljbd:map');
}else if($_GET['act']=='mark'){
	if(file_exists('source/plugin/aljbd/com/mark.php')){
		include_once 'source/plugin/aljbd/com/mark.php';
	}
}else if($_GET['act']=='point'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=10;
	$start=($currpage-1)*$perpage;
	$num=C::t('#aljbd#aljbd_point')->count_by_buid($_G['uid']);
	$pointlist=C::t('#aljbd#aljbd_point')->fetch_all_by_buid($_G['uid'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=point', 0, 11, false, false);
	include template('aljbd:point');
}else if($_GET['act']=='pointok'){
	if(empty($_G['uid'])){
		showerror(lang('plugin/aljbd','s40'));
	}
	C::t('#aljbd#aljbd')->update($_GET['bid'],array('x'=>$_GET['x'],'y'=>$_GET['y']));
	C::t('#aljbd#aljbd_point')->delete($_GET['pid']);
	showmsg(lang('plugin/aljbd','s41'));
}else if($_GET['act']=='pointdel'){
	if(empty($_G['uid'])){
		showerror(lang('plugin/aljbd','s42'));
	}
	C::t('#aljbd#aljbd_point')->delete($_GET['pid']);
	showmsg(lang('plugin/aljbd','s43'));
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
		include template('aljbd:iwantclaim');
	}
}else if($_GET['act']=='delete'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	if($_GET['bid']){
		$bdlist=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		if($bdlist['uid']!=$_G['uid']){
			showmessage(lang('plugin/aljbd','aljbd_7'));
		}
		unlink($bdlist['logo']);
		C::t('#aljbd#aljbd')->delete($_GET['bid']);
	}
	showmessage(lang('plugin/aljbd','s50'),'plugin.php?id=aljbd&act=member');
}else if($_GET['act']=='goodslist'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd')->range();
	$glist=C::t('#aljbd#aljbd_goods')->fetch_all_by_uid_bid($_G['uid'],$_GET['bid']);
	include template('aljbd:goodslist');
}else if($_GET['act']=='good'){
	if(file_exists('source/plugin/aljbd/com/good.php')){
		if(empty($_GET['bid'])){
			showmessage(lang('plugin/aljbd','nopage'));
		}
		//$pagelist = DB::fetch_all('select * from %t where bid = %d',array('aljbd_page',$_GET['bid']));
		include_once 'source/plugin/aljbd/com/good.php';
	}
}else if($_GET['act']=='goodview'){
	if(empty($_GET['gid'])){
		showmessage(lang('plugin/aljbd','nogoodsexists'));
	}
	C::t('#aljbd#aljbd_goods')->update_view_by_gid($_GET['gid']);
	$cgood = C::t('#aljbd#aljbd_goods')->fetch($_GET['gid']);
	$_GET['bid'] = $cgood['bid'];
	
	//$check=C::t('#aljbd#aljbd_user')->fetch($_G['uid']);
	if($_GET['bid']){
		$check=C::t('#aljbd#aljbd_username')->fetch_by_uid_bid($_G['uid'],$_GET['bid']);
	}
	
	if(empty($check)&&$_G['uid']){
		C::t('#aljbd#aljbd_username')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'bid'=>$_GET['bid']));
	}
	C::t('#aljbd#aljbd')->update_view_by_bid($_GET['bid']);
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	foreach($khf[0] as $k=>$v){
		$khf[0][$k]=intval($v);
	}
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$commentcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,0);
	$askcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,1);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,0);
	$asklist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,1);
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	require_once libfile('function/discuzcode');
	if(!file_exists('source/plugin/aljbd/com/intro.php')){
		$bd['intro']=discuzcode($bd['intro']);
	}
	$avg=C::t('#aljbd#aljbd_comment')->count_avg_by_bid($bd['id']);
	$avg=intval($avg);
	$qq=str_replace('{qq}',$bd['qq'],$config['qq']);
	$adv=unserialize($bd['adv']);
	$advurl=unserialize($bd['advurl']);
	$bdlist=C::t('#aljbd#aljbd')->range();
	$g=C::t('#aljbd#aljbd_goods')->fetch($_GET['gid']);
	
	$t=C::t('#aljbd#aljbd_goods')->fetch_all_by_uid_bid_view($g['uid'],$_GET['bid'],0,6);

	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid($bd['uid'],$_GET['bid'],0,9);
	$navtitle = $g['name'].'-'.$bd['name'].'-'.$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	if($aljbd_seo['good_view']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname'],'bdname'=>$bd['name'],'message'=>mb_substr(strip_tags(preg_replace('/\<img.*?\>/is', '', $g['intro'])),0,80,$_G['charset']),'subject'=>$g['name']);
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['good_view']);
	}
	include template('aljbd:goodview');
}else if($_GET['act']=='addgoods'){

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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
		}else{
			showerror(lang('plugin/aljbd','s56'));
		}
		if($_FILES['pic2']['tmp_name']) {
			$picname = $_FILES['pic2']['name'];
			$picsize = $_FILES['pic2']['size'];
		
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
		}
		if($_FILES['pic3']['tmp_name']) {
			$picname = $_FILES['pic3']['name'];
			$picsize = $_FILES['pic3']['size'];
		
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
		C::t('#aljbd#aljbd_goods')->insert(array(
				'bid'=>$_GET['bid'],
				'uid'=>$_G['uid'],
				'name'=>$_GET['name'],
				'price1'=>$_GET['price1'],
				'price2'=>$_GET['price2'],
				'pic1'=>$pic1,
				'pic2'=>$pic2,
				'pic3'=>$pic3,
				'pic4'=>$pic4,
				'pic5'=>$pic5,
				'intro'=>$_GET['intro'],
				'gwurl'=>$_GET['gwurl'],
				'dateline'=>TIMESTAMP,
				'type'=>$_GET['type'],
				'subtype'=>$_GET['subtype'],
				'amount'=>$_GET['amount'],
				'endtime'=>strtotime($_GET['endtime']),
		));
		showmsg(lang('plugin/aljbd','s53'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		if($_GET['bid']){
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		}
		$typelist=C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid(0);
		//$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid();
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$brandnum=C::t('#aljbd#aljbd_usergroup')->fetch($_G['groupid']);
		$bnum=C::t('#aljbd#aljbd_goods')->count_by_status('',$_G['uid']);
		if($brandnum['good']&&file_exists('source/plugin/aljbd/com/yhzqx.php')){
			if($bnum>=$brandnum['good']){
				showmessage(lang('plugin/aljbd','groups_1').$brandnum['good'].lang('plugin/aljbd','groups_3'));
			}
		}
		include template('aljbd:addgoods');
	}
}else if($_GET['act']=='editgoods'){
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
		}
		if($_FILES['pic3']['tmp_name']) {
			$picname = $_FILES['pic3']['name'];
			$picsize = $_FILES['pic3']['size'];
		
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
			'uid'=>$_G['uid'],
			'name'=>$_GET['name'],
			'price1'=>$_GET['price1'],
			'price2'=>$_GET['price2'],
			'intro'=>$_GET['intro'],
			'gwurl'=>$_GET['gwurl'],
			'dateline'=>TIMESTAMP,
			'type'=>$_GET['type'],
			'subtype'=>$_GET['subtype'],
			'amount'=>$_GET['amount'],
			'endtime'=>strtotime($_GET['endtime']),
		);
		$g=C::t('#aljbd#aljbd_goods')->fetch($_GET['gid']);
		if($pic1){
			unlink($g['pic1']);
			unlink($g['pic1'].'.60x60.jpg');
			unlink($g['pic1'].'.205x205.jpg');
			unlink($g['pic1'].'.470x470.jpg');
			$updatearray['pic1']=$pic1;
		}
		if($pic2){
			unlink($g['pic2']);
			unlink($g['pic2'].'.60x60.jpg');
			unlink($g['pic2'].'.205x205.jpg');
			unlink($g['pic2'].'.470x470.jpg');
			$updatearray['pic2']=$pic2;
		}
		if($pic3){
			unlink($g['pic3']);
			unlink($g['pic3'].'.60x60.jpg');
			unlink($g['pic3'].'.205x205.jpg');
			unlink($g['pic3'].'.470x470.jpg');
			$updatearray['pic3']=$pic3;
		}
		if($pic4){
			unlink($g['pic4']);
			unlink($g['pic4'].'.60x60.jpg');
			unlink($g['pic4'].'.205x205.jpg');
			unlink($g['pic4'].'.470x470.jpg');
			$updatearray['pic4']=$pic4;
		}
		if($pic5){
			unlink($g['pic5']);
			unlink($g['pic5'].'.60x60.jpg');
			unlink($g['pic5'].'.205x205.jpg');
			unlink($g['pic5'].'.470x470.jpg');
			$updatearray['pic5']=$pic5;
		}
		C::t('#aljbd#aljbd_goods')->update($_GET['gid'],$updatearray);
		showmsg(lang('plugin/aljbd','s54'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$typelist=C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid(0);
		$g=C::t('#aljbd#aljbd_goods')->fetch($_GET['gid']);
		include template('aljbd:addgoods');
	}
}else if($_GET['act']=='deletegoods'){
	if($_GET['formhash']!=FORMHASH){
		exit('Access Denied!');
	}
	if($_GET['gid']){
		$bdlist=C::t('#aljbd#aljbd_goods')->fetch($_GET['gid']);
		if($bdlist['uid']!=$_G['uid']){
			showmessage(lang('plugin/aljbd','aljbd_7'));
		}
		for ($i = 1; $i <= 5; $i++) {
            $pic = 'pic' . $i;
			unlink($bdlist[$pic]);
			unlink($bdlist[$pic].'.60x60.jpg');
			unlink($bdlist[$pic].'.205x205.jpg');
			unlink($bdlist[$pic].'.470x470.jpg');
		}
		C::t('#aljbd#aljbd_goods')->delete($_GET['gid']);
	}
	showmsg(lang('plugin/aljbd','s55'));
}else if($_GET['act']=='consume'){
	if(file_exists('source/plugin/aljbd/com/consume.php')){
		if(empty($_GET['bid'])){
			showmessage(lang('plugin/aljbd','nopage'));
		}
		//$pagelist = DB::fetch_all('select * from %t where bid = %d',array('aljbd_page',$_GET['bid']));
		include_once 'source/plugin/aljbd/com/consume.php';
	}
}else if($_GET['act']=='consumeview'){
	C::t('#aljbd#aljbd_consume')->update_view_by_gid($_GET['cid']);
	//$check=C::t('#aljbd#aljbd_user')->fetch($_G['uid']);
	$check=C::t('#aljbd#aljbd_username')->fetch_by_uid_bid($_G['uid'],$_GET['bid']);
	if(empty($check)&&$_G['uid']){
		C::t('#aljbd#aljbd_username')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'bid'=>$_GET['bid']));
	}
	C::t('#aljbd#aljbd')->update_view_by_bid($_GET['bid']);
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	foreach($khf[0] as $k=>$v){
		$khf[0][$k]=intval($v);
	}
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$commentcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,0);
	$askcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,1);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,0);
	$asklist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,1);
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	require_once libfile('function/discuzcode');
	if(!file_exists('source/plugin/aljbd/com/intro.php')){
		$bd['intro']=discuzcode($bd['intro']);
	}
	$avg=C::t('#aljbd#aljbd_comment')->count_avg_by_bid($bd['id']);
	$avg=intval($avg);
	
	$adv=unserialize($bd['adv']);
	$advurl=unserialize($bd['advurl']);
	
	$bdlist=C::t('#aljbd#aljbd')->range();
	$c=C::t('#aljbd#aljbd_consume')->fetch($_GET['cid']);
	$c['xianzhi']=discuzcode($c['xianzhi']);
	//$t=C::t('#aljbd#aljbd_goods')->fetch_all_by_uid_bid_view($g['uid'],$_GET['bid'],0,6);
	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid($bd['uid'],$_GET['bid'],0,9);
	$navtitle = $c['subject'].'-'.$bd['name'].'-'.$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	if($aljbd_seo['consume_view']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname'],'bdname'=>$bd['name'],'message'=>mb_substr(strip_tags(preg_replace('/\<img.*?\>/is', '', $c['jieshao'])),0,80,$_G['charset']),'subject'=>$c['subject']);
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['consume_view']);
	}
	include template('aljbd:consumeview');
}else if($_GET['do']=='print') {
	$c=C::t('#aljbd#aljbd_consume')->fetch($_GET['cid']);
	DB::query('UPDATE '.DB::table('aljbd_consume').' SET downnum=downnum+1 WHERE id=\''.$_GET['cid'].'\'');
	echo '<body onload="window.print()"><img src="'.$c['pic'].'"></body>';
	exit();
}else if($_GET['do']=='draw') {
	/*$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	$c=C::t('#aljbd#aljbd_consume')->fetch($_GET['cid']);
	DB::query('UPDATE '.DB::table('aljbd_consume').' SET draw=draw+1 WHERE id=\''.$_GET['cid'].'\'');
	$orderid = dgmdate(TIMESTAMP, 'YmdHis').random(18);
	C::t('#aljbd#aljbd_consume_draw')->insert(array(
		'bid' =>$_GET['bid'],
		'cid' =>$_GET['cid'],
		'orderid' => $orderid,
		'bname' => $bd['name'],
		'cname' => $c['subject'],
		'uid' => $_G['uid'],
		'username' => $_G['username'],
		'timestamp' => TIMESTAMP
	));
	showmsg('领取成功！优惠码'.$orderid);*/
}else if($_GET['act']=='consumelist'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd')->range();
	$nlist=C::t('#aljbd#aljbd_consume')->fetch_all_by_uid_bid($_G['uid'],$_GET['bid']);
	include template('aljbd:consumelist');
}else if($_GET['act']=='cask'){
	if(submitcheck('formhash')){
		if(empty($_GET['commentmessage_2'])){
			showerror(lang('plugin/aljbd','s33'));
		}
		if(empty($_G['uid'])){
			showerror(lang('plugin/aljbd','s21'));
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_2'],
			'bid'=>$_GET['bid'],
			'dateline'=>TIMESTAMP,
			'upid'=>0,
			'cid'=>$_GET['cid']
		);
		C::t('#aljbd#aljbd_comment_consume')->insert($insertarray);
		showmsg(lang('plugin/aljbd','s34'));
	}
}else if($_GET['act']=='creply'){
	if(submitcheck('formhash')){
		if(empty($_GET['commentmessage_1'])){
			showerror(lang('plugin/aljbd','s35'));
		}
		if(empty($_G['uid'])){
			showerror(lang('plugin/aljbd','s21'));
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_1'],
			'bid'=>$_GET['bid'],
			'cid'=>$_GET['cid'],
			'dateline'=>TIMESTAMP,
			'upid'=>$_GET['upid'],
		);
		C::t('#aljbd#aljbd_comment_consume')->insert($insertarray);
		showmsg(lang('plugin/aljbd','s36'));
	}
}else if($_GET['act']=='addconsume'){
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
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		$typelist=C::t('#aljbd#aljbd_type_consume')->fetch_all_by_upid(0);
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$brandnum=C::t('#aljbd#aljbd_usergroup')->fetch($_G['groupid']);
		$bnum=C::t('#aljbd#aljbd_consume')->count_by_uid_bid($_G['uid']);
		if($brandnum['consume']&&file_exists('source/plugin/aljbd/com/yhzqx.php')){
			if($bnum>=$brandnum['consume']){
				showmessage(lang('plugin/aljbd','groups_1').$brandnum['consume'].lang('plugin/aljbd','groups_4'));
			}
		}
		include template('aljbd:addconsume');
	}
}else if($_GET['act']=='editconsume'){
	if(submitcheck('formhash')){
		if($_FILES['logo']['tmp_name']) {
			$picname = $_FILES['logo']['name'];
			$picsize = $_FILES['logo']['size'];
		
			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
					showerror(lang('plugin/aljbd','s29'));
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
		}
		
		$updatearray=array(
			'subject'=>$_GET['name'],
			'bid'=>$_GET['bid'],
			'jieshao'=>$_GET['jieshao'],
			'xianzhi'=>$_GET['xianzhi'],
			'end'=>strtotime($_GET['end']),
			'mianze'=>$_GET['mianze'],
			'type'=>$_GET['type'],
			'subtype'=>$_GET['subtype'],
		);
		$c=C::t('#aljbd#aljbd_consume')->fetch($_GET['cid']);
		if($logo){
			unlink($c['pic']);
			$updatearray['pic']=$logo;
		}
		C::t('#aljbd#aljbd_consume')->update($_GET['cid'],$updatearray);
		showmsg(lang('plugin/aljbd','s54'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$n=C::t('#aljbd#aljbd_consume')->fetch($_GET['nid']);
		//debug($bdlist);
		include template('aljbd:addconsume');
	}
}else if($_GET['act']=='deleteconsume'){
	if($_GET['formhash']!=FORMHASH){
		exit('Access Denied!');
	}
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd_consume')->fetch($_GET['nid']);
	if($bdlist['uid']!=$_G['uid']){
		showmessage(lang('plugin/aljbd','aljbd_7'));
	}
	unlink($bdlist['pic']);
	if($_GET['nid']){
		C::t('#aljbd#aljbd_consume')->delete($_GET['nid']);
	}
	showmsg(lang('plugin/aljbd','s55'));
}else if($_GET['act']=='deletenotice'){
	if($_GET['formhash']!=FORMHASH){
		exit('Access Denied!');
	}
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd_notice')->fetch($_GET['nid']);
	if($bdlist['uid']!=$_G['uid']){
		showmessage(lang('plugin/aljbd','aljbd_7'));
	}
	//unlink($bdlist['pic']);
	if($_GET['nid']){
		C::t('#aljbd#aljbd_notice')->delete($_GET['nid']);
	}
	showmsg(lang('plugin/aljbd','s55'));
}else if($_GET['act']=='noticeview'){
	C::t('#aljbd#aljbd_notice')->update_view_by_gid($_GET['nid']);
	//$check=C::t('#aljbd#aljbd_user')->fetch($_G['uid']);
	$check=C::t('#aljbd#aljbd_username')->fetch_by_uid_bid($_G['uid'],$_GET['bid']);
	if(empty($check)&&$_G['uid']){
		C::t('#aljbd#aljbd_username')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'bid'=>$_GET['bid']));
	}
	C::t('#aljbd#aljbd')->update_view_by_bid($_GET['bid']);
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	foreach($khf[0] as $k=>$v){
		$khf[0][$k]=intval($v);
	}
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$commentcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,0);
	$askcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,1);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,0);
	$asklist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,1);
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	require_once libfile('function/discuzcode');
	if(!file_exists('source/plugin/aljbd/com/intro.php')){
		$bd['intro']=discuzcode($bd['intro']);
	}
	$avg=C::t('#aljbd#aljbd_comment')->count_avg_by_bid($bd['id']);
	$avg=intval($avg);
	
	$adv=unserialize($bd['adv']);
	$advurl=unserialize($bd['advurl']);
	$bdlist=C::t('#aljbd#aljbd')->range();
	$n=C::t('#aljbd#aljbd_notice')->fetch($_GET['nid']);
	$t=C::t('#aljbd#aljbd_goods')->fetch_all_by_uid_bid_view($g['uid'],$_GET['bid'],0,6);
	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid($bd['uid'],$_GET['bid'],0,9);
	$navtitle = $n['subject'].'-'.$bd['name'].'-'.$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	if($aljbd_seo['notice_view']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname'],'bdname'=>$bd['name'],'message'=>mb_substr(strip_tags(preg_replace('/\<img.*?\>/is', '', $n['intro'])),0,80,$_G['charset']),'subject'=>$n['subject']);
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['notice_view']);
	}
	include template('aljbd:noticeview');
}else if($_GET['act']=='noticelist'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd')->range();
	$nlist=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid($_G['uid'],$_GET['bid']);
	include template('aljbd:noticelist');
}else if($_GET['act'] == 'viewpage'){
	$nid = intval($_GET['nid']);
	if(empty($nid)){
		showmessage(lang('plugin/aljbd','nopage'));
	}
	
	//$page = DB::fetch_first('select * from %t where id = %d',array('aljbd_page',$nid));
	$bd = C::t('#aljbd#aljbd') ->fetch($page['bid']);
	//$pagelist = DB::fetch_all('select * from %t where bid = %d order by displayorder desc',array('aljbd_page',$page['bid']));
	include template('aljbd:viewpage');
}else if($_GET['act']=='addnotice'){
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
		C::t('#aljbd#aljbd_notice')->insert(array(
				'bid'=>$_GET['bid'],
				'uid'=>$_G['uid'],
				'username'=>$_G['username'],
				'subject'=>$_GET['subject'],
				'content'=>$_GET['intro'],
				'dateline'=>TIMESTAMP,
				'type'=>$_GET['type'],
				'subtype'=>$_GET['subtype'],
		));
		showmsg(lang('plugin/aljbd','s53'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		if($_GET['bid']){
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		}
		$typelist=C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid(0);
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$brandnum=C::t('#aljbd#aljbd_usergroup')->fetch($_G['groupid']);
		$bnum=C::t('#aljbd#aljbd_notice')->count_by_uid_bid($_G['uid']);
		if($brandnum['notice']&&file_exists('source/plugin/aljbd/com/yhzqx.php')){
			if($bnum>=$brandnum['notice']){
				showmessage(lang('plugin/aljbd','groups_1').$brandnum['notice'].lang('plugin/aljbd','groups_5'));
			}
		}
		include template('aljbd:addnotice');
	}
}else if($_GET['act']=='editnotice'){
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
			'subject'=>$_GET['subject'],
			'content'=>$_GET['intro'],
			'type'=>$_GET['type'],
			'subtype'=>$_GET['subtype'],
		);
		C::t('#aljbd#aljbd_notice')->update($_GET['nid'],$updatearray);
		showmsg(lang('plugin/aljbd','s54'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		$typelist=C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid(0);
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$n=C::t('#aljbd#aljbd_notice')->fetch($_GET['nid']);
		include template('aljbd:addnotice');
	}
}else if($_GET['act']=='notice'){
	if(file_exists('source/plugin/aljbd/com/notice.php')){
		if(empty($_GET['bid'])){
			showmessage(lang('plugin/aljbd','nopage'));
		}
		//$pagelist = DB::fetch_all('select * from %t where bid = %d',array('aljbd_page',$_GET['bid']));
		include_once 'source/plugin/aljbd/com/notice.php';
	}
}else if($_GET['act']=='replynotice'){
	$n=C::t('#aljbd#aljbd_notice')->fetch($_GET['nid']);
	$num=DB::result_first(" select count(*) from ".DB::table('aljbd_comment_notice')." where nid=".$n['id']." and bid=".$n['bid']);
		
	$total_page = ceil($num/$perpage);
	//第一页的时候没有上一页
	if($total_page>1){
		if($currpage > 1){
			$shangyiye='<a href="plugin.php?id=aljbd&act=replynotice&page='.($currpage-1).'">'.lang('plugin/aljbd','sj_3').'</a>&nbsp;&nbsp;';
		}else{
			$shangyiye='<span>'.lang('plugin/aljbd','sj_3').'</span>';
		}
		//尾页的时候不显示下一页
		if($currpage < $total_page){
			//debug(123);
			$xiayiye= '<a href="plugin.php?id=aljbd&act=replynotice&page='.($currpage+1).'">'.lang('plugin/aljbd','sj_2').'</a>&nbsp;&nbsp;';
			//debug($xiayiye);
		}else{
			$xiayiye='<span>'.lang('plugin/aljbd','sj_2').'</span>';
		}
	}
	$allpage=ceil($num/$perpage);
	$start=($currpage-1)*$perpage;
	$nask=DB::fetch_all(" select * from ".DB::table('aljbd_comment_notice')." where nid=".$n['id']." and bid=".$n['bid']);
	include template('aljbd:replynotice');
}else if($_GET['act']=='pagelist'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd')->range();
	//$nlist=C::t('#aljbd#aljbd_page')->fetch_all_by_uid_bid($_G['uid'],$_GET['bid']);
	include template('aljbd:pagelist');
}else if($_GET['act']=='addpage'){
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
		C::t('#aljbd#aljbd_page')->insert(array(
				'bid'=>$_GET['bid'],
				'uid'=>$_G['uid'],
				'username'=>$_G['username'],
				'subject'=>$_GET['subject'],
				'content'=>$_GET['intro'],
				'dateline'=>TIMESTAMP,
				'type'=>$_GET['type'],
				'subtype'=>$_GET['subtype'],
				'displayorder'=>$_GET['displayorder'],
		));
		showmsg(lang('plugin/aljbd','s53'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		if($_GET['bid']){
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		}
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		
		include template('aljbd:addpage');
	}
}else if($_GET['act']=='editpage'){
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
			'subject'=>$_GET['subject'],
			'content'=>$_GET['intro'],
			'type'=>$_GET['type'],
			'subtype'=>$_GET['subtype'],
			'displayorder'=>$_GET['displayorder'],
		);
		//C::t('#aljbd#aljbd_page')->update($_GET['nid'],$updatearray);
		showmsg(lang('plugin/aljbd','s54'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		//$n=C::t('#aljbd#aljbd_page')->fetch($_GET['nid']);
		include template('aljbd:addpage');
	}
}else if($_GET['act']=='deletepage'){
	if($_GET['formhash']!=FORMHASH){
		exit('Access Denied!');
	}
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	//$bdlist=C::t('#aljbd#aljbd_page')->fetch($_GET['nid']);
	if($bdlist['uid']!=$_G['uid']){
		showmessage(lang('plugin/aljbd','aljbd_7'));
	}
	//unlink($bdlist['pic']);
	if($_GET['nid']){
		//C::t('#aljbd#aljbd_page')->delete($_GET['nid']);
	}
	showmessage(lang('plugin/aljbd','s55'),'plugin.php?id=aljbd&act=pagelist');
}else if($_GET['act']=='nask'){
	if(submitcheck('formhash')){
		
		if(empty($_GET['commentmessage_2'])){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','s33')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','s33'));
			}
		}
		if(empty($_G['uid'])){
			if(defined('IN_MOBILE')){
				echo "<script>parent.tips('".lang('plugin/aljbd','s21')."','');</script>";
				exit;
			}else{
				showerror(lang('plugin/aljbd','s21'));
			}
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_2'],
			'bid'=>$_GET['bid'],
			'dateline'=>TIMESTAMP,
			'upid'=>0,
			'nid'=>$_GET['nid']
		);
		C::t('#aljbd#aljbd_comment_notice')->insert($insertarray);
		if(defined('IN_MOBILE')){
			echo "<script>parent.tips('".lang('plugin/aljbd','s34')."',function(){parent.location.href=parent.location.href;});</script>";
			exit;
		}else{
			showmsg(lang('plugin/aljbd','s34'));
		}
	}
}else if($_GET['act']=='nreply'){
	if(submitcheck('formhash')){
		if(empty($_GET['commentmessage_1'])){
			showerror(lang('plugin/aljbd','s35'));
		}
		if(empty($_G['uid'])){
			showerror(lang('plugin/aljbd','s21'));
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'content'=>$_GET['commentmessage_1'],
			'bid'=>$_GET['bid'],
			'nid'=>$_GET['nid'],
			'dateline'=>TIMESTAMP,
			'upid'=>$_GET['upid'],
		);
		C::t('#aljbd#aljbd_comment_notice')->insert($insertarray);
		showmsg(lang('plugin/aljbd','s36'));
	}
}else if($_GET['act']=='albumlist'){
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	$bdlist=C::t('#aljbd#aljbd')->range();
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=9;
	$allpage=ceil($num/$perpage);
	$start=($currpage-1)*$perpage;
	$num=C::t('#aljbd#aljbd_album')->count_by_uid_bid($_G['uid'],$_GET['bid']);
	$alist=C::t('#aljbd#aljbd_album')->fetch_all_by_uid_bid($_G['uid'],$_GET['bid'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=notice&bid='.$_GET['bid'], 0, 11, false, false);
	include template('aljbd:albumlist');
}else if($_GET['act']=='album'){
	if(file_exists('source/plugin/aljbd/com/album.php')){
		if(empty($_GET['bid'])){
			showmessage(lang('plugin/aljbd','nopage'));
		}
		//$pagelist = DB::fetch_all('select * from %t where bid = %d',array('aljbd_page',$_GET['bid']));
		include_once 'source/plugin/aljbd/com/album.php';
	}
}else if($_GET['act']=='addalbum'){
	if(submitcheck('formhash')){
		if(empty($_GET['bid'])){
			showerror(lang('plugin/aljbd','s51'));
		}
		if(empty($_GET['albumname'])){
			showerror(lang('plugin/aljbd','album_1'));
		}
		
		C::t('#aljbd#aljbd_album')->insert(array(
				'bid'=>$_GET['bid'],
				'uid'=>$_G['uid'],
				'username'=>$_G['username'],
				'albumname'=>$_GET['albumname'],
				'description'=>$_GET['description'],
				'dateline'=>TIMESTAMP,
				'displayorder'=>'100',
		));
		showmsg(lang('plugin/aljbd','s53'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		if($_GET['bid']){
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		}
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$brandnum=C::t('#aljbd#aljbd_usergroup')->fetch($_G['groupid']);
		$bnum=C::t('#aljbd#aljbd_album')->count_by_uid_bid($_G['uid']);
		if($brandnum['album']&&file_exists('source/plugin/aljbd/com/yhzqx.php')){
			if($bnum>=$brandnum['album']){
				showmessage(lang('plugin/aljbd','groups_1').$brandnum['album'].lang('plugin/aljbd','groups_6'));
			}
		}
		include template('aljbd:addalbum');
	}
}else if($_GET['act']=='delalbum'){
	if(!$_GET['aid']){
		showmessage(lang('plugin/aljbd','aljbd_6'));
	}
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	if($_GET['formhash']!=formhash()){
		showmessage(lang('plugin/aljbd','aljbd_7'));
	}
	if(C::t('#aljbd#aljbd_album_attachments')->conut_by_aid($_GET['aid'])){
		foreach(C::t('#aljbd#aljbd_album_attachments')->fetch_all_by_status(' where aid='.$_GET['aid']) as $atid){
			unlink($atid['pic']);
			unlink($atid['pic'].'.72x72.jpg');
			unlink($atid['pic'].'.100x100.jpg');
			unlink($atid['pic'].'.550x550.jpg');
			C::t('#aljbd#aljbd_album_attachments')->delete($atid['id']);
		}
	}
	C::t('#aljbd#aljbd_album')->delete($_GET['aid']);
	showmessage(lang('plugin/aljbd','admin_8'),'plugin.php?id=aljbd&act=albumlist');
}else if($_GET['act']=='delalbum_1'){
	if(!$_GET['aaid']){
		showmessage(lang('plugin/aljbd','aljbd_6'));
	}
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s39'));
	}
	if($_GET['formhash']!=formhash()){
		showmessage(lang('plugin/aljbd','aljbd_7'));
	}
	$al=C::t('#aljbd#aljbd_album_attachments')->fetch($_GET['aaid']);
	if($al){
		unlink($al['pic']);
		unlink($al['pic'].'.72x72.jpg');
		unlink($al['pic'].'.100x100.jpg');
		unlink($al['pic'].'.550x550.jpg');
		C::t('#aljbd#aljbd_album_attachments')->delete($_GET['aaid']);
	}
	
	DB::query("UPDATE ".DB::table('aljbd_album')." SET picnum=picnum-1 WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
	if(!DB::result_first("select count(*) from ".DB::table('aljbd_album_attachments')." where aid=".$_GET['aid'])){
		DB::query("UPDATE ".DB::table('aljbd_album')." SET subjectimage='' WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
		DB::query("UPDATE ".DB::table('aljbd_album')." SET picnum=0 WHERE id='".$_GET['aid']."'", 'UNBUFFERED');
	}
	showmessage(lang('plugin/aljbd','admin_8'),'plugin.php?id=aljbd&act=albumall&aid='.$_GET['aid']);
}else if($_GET['act']=='editalbum'){
	if(submitcheck('formhash')){
		if(empty($_GET['bid'])){
			showerror(lang('plugin/aljbd','s51'));
		}
		if(empty($_GET['albumname'])){
			showerror(lang('plugin/aljbd','album_1'));
		}
		$updatearray=array(
			'bid'=>$_GET['bid'],
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'albumname'=>$_GET['albumname'],
			'description'=>$_GET['description'],
			'dateline'=>TIMESTAMP,
			'displayorder'=>'100',
		);
		C::t('#aljbd#aljbd_album')->update($_GET['aid'],$updatearray);
		showmsg(lang('plugin/aljbd','s53'));
	}else{
		if(empty($_G['uid'])){
			showmessage(lang('plugin/aljbd','s39'));
		}
		if($_GET['bid']){
			$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
		}
		$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,'','',$_G['uid']);
		$a=C::t('#aljbd#aljbd_album')->fetch($_GET['aid']);
		include template('aljbd:addalbum');
	}
}else if($_GET['act']=='albumall'){
	$a=C::t('#aljbd#aljbd_album')->range();
	$currpage=intval($_GET['page'])?intval($_GET['page']):1;
	$perpage=9;
	$allpage=ceil($num/$perpage);
	$start=($currpage-1)*$perpage;
	$num=C::t('#aljbd#aljbd_album_attachments')->count_by_uid_bid($_G['uid'],$_GET['aid']);
	$alist=C::t('#aljbd#aljbd_album_attachments')->fetch_all_by_uid_bid($_G['uid'],$_GET['aid'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&act=notice&bid='.$_GET['bid'], 0, 11, false, false);
	include template('aljbd:albumall');
}else if($_GET['act']=='addalbumimg'){
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
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
				}
				if (($picsize/1024)>$config['img_size']) {
					showerror(lang('plugin/aljbd','img1').$config['img_size'].'KB');
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
				'uid'=>$_G['uid'],
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
		$num=C::t('#aljbd#aljbd_album_attachments')->count_by_uid_bid($bd['uid'],$_GET['aid']);
		
		if($num>=$config['albumnum']&&$config['albumnum']){
			showmessage(lang('plugin/aljbd','album_4').$config['albumnum'].lang('plugin/aljbd','album_5'));
		}
		include template('aljbd:addalbumimg');
	}
}else if($_GET['act']=='albumview'){
	if(empty($_GET['aid'])){
		showmessage(lang('plugin/aljbd','nopage'));
	}
	C::t('#aljbd#aljbd_notice')->update_view_by_gid($_GET['nid']);
	//$check=C::t('#aljbd#aljbd_user')->fetch($_G['uid']);
	$check=C::t('#aljbd#aljbd_username')->fetch_by_uid_bid($_G['uid'],$_GET['bid']);
	if(empty($check)&&$_G['uid']){
		C::t('#aljbd#aljbd_username')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'bid'=>$_GET['bid']));
	}
	C::t('#aljbd#aljbd')->update_view_by_bid($_GET['bid']);
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	foreach($khf[0] as $k=>$v){
		$khf[0][$k]=intval($v);
	}
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$rlist=C::t('#aljbd#aljbd_region')->range();
	$commentcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,0);
	$askcount=C::t('#aljbd#aljbd_comment')->count_by_bid_upid($_GET['bid'],0,1);
	$commentlist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,0);
	$asklist=C::t('#aljbd#aljbd_comment')->fetch_all_by_bid_upid($_GET['bid'],0,1);
	$bd=C::t('#aljbd#aljbd')->fetch($_GET['bid']);
	require_once libfile('function/discuzcode');
	if(!file_exists('source/plugin/aljbd/com/intro.php')){
		$bd['intro']=discuzcode($bd['intro']);
	}
	$avg=C::t('#aljbd#aljbd_comment')->count_avg_by_bid($bd['id']);
	$avg=intval($avg);
	
	$adv=unserialize($bd['adv']);
	$advurl=unserialize($bd['advurl']);
	
	$bdlist=C::t('#aljbd#aljbd')->range();
	$num=C::t('#aljbd#aljbd_album_attachments')->count_by_uid_bid($bd['uid'],$_GET['aid']);
	$alist=C::t('#aljbd#aljbd_album_attachments')->fetch_all_by_uid_bid($bd['uid'],$_GET['aid'],$start,$perpage);
	//debug($_GET['aid']);
	$ab=C::t('#aljbd#aljbd_album')->fetch($_GET['aid']);
	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid($bd['uid'],$_GET['bid'],0,9);
	
	$navtitle = $ab['albumname'].'-'.$bd['name'].'-'.$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	if($aljbd_seo['album_view']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname'],'bdname'=>$bd['name'],'subject'=>$ab['albumname']);
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['album_view']);
	}
	include template('aljbd:albumview');
}else if($_GET['act'] == 'orderlist'){
	$page = intval($_GET['page']);
	$currpage = $page?$page:1;
	$perpage = 10;
	$start = ($currpage-1)*$perpage;
	$bids = DB::fetch_all('select id from %t where uid = %d',array('aljbd',$_G['uid']));
	foreach($bids as $bid){
		$ids[] = $bid['id'];
	}
	$bids = implode(',',$ids);
	if(in_array($_G['groupid'],$admingroups)){
		$num = DB::result_first('select count(*) from %t',array('aljbd_order'));
		$orderlist = DB::fetch_all('select * from %t order by submitdate desc limit %d,%d',array('aljbd_order',$start,$perpage));
	}else if($bids){
		$num = DB::result_first('select count(*) from %t a left join %t b on a.sid = b.id where b.bid in(%i) or a.uid = %d',array('aljbd_order','aljbd_goods',$bids,$_G['uid']));
		$orderlist = DB::fetch_all('select * from %t a left join %t b on a.sid = b.id where b.bid in(%i) or a.uid = %d order by a.submitdate desc limit %d,%d',array('aljbd_order','aljbd_goods',$bids,$_G['uid'],$start,$perpage));
	}else{
		$num = DB::result_first('select count(*) from %t where uid = %d',array('aljbd_order',$_G['uid']));
		$orderlist = DB::fetch_all('select * from %t where uid = %d order by submitdate desc limit %d,%d',array('aljbd_order',$_G['uid'],$start,$perpage));
	}
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd:member&act=orderlist', 0, 11, false, false);
	include template('aljbd:orderlist');
}else if($_GET['act'] == 'deleteorder'){
	if($_GET['orderid']){
		$order = C::t('#aljbd#aljbd_order') -> fetch($_GET['orderid']);
		if($order['uid'] == $_G['uid'] || in_array($_G['groupid'],$admingroups)){
			C::t('#aljbd#aljbd_order') -> delete($_GET['orderid']);
		}
		
	}
	
	showmessage(lang('plugin/aljbd','sc7'),'plugin.php?id=aljbd&act=orderlist');
}else if ($_GET['act'] == 'trade') {
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','s21'), '', array(), array('login' => true));
	}
	$gid = intval($_GET['gid']);
	if($_GET['gid']){
		$good = C::t('#aljbd#aljbd_goods') -> fetch($gid);
	}else{
		showmessage(lang('plugin/aljbd','nogoodsexists'));
	}
	$user = C::t('#aljbd#aljbd_user') -> fetch($_G['uid']);
	include template('aljbd:trade');
	
}else if ($_GET['act'] == 'addr') {
	if(empty($_G['uid'])){
		showmessage(lang('plugin/aljbd','tg17'), '', array(), array('login' => true));
	}
    $uid = $_G['uid'];
	$gid = intval($_GET['gid']);
    if (submitcheck('submit')) {
        if (C::t('#aljbd#aljbd_user')->fetch($uid)) {
            $updatearray = array(
				'username' => $_GET['name'],
                'qq' => $_GET['qq'],
                'tel' => $_GET['tel'],
                'addr' => $_GET['addr'],
            );
            C::t('#aljbd#aljbd_user')->update($uid, $updatearray);
			
			echo "<script>parent.showDialog('".lang('plugin/aljbd','tg18')."','right','',function(){parent.location.href=parent.location.href;});</script>";
			
        } else {
            $insertarray = array(
                'uid' => $uid,
                'username' => $_GET['name'],
                'qq' => $_GET['qq'],
                'tel' => $_GET['tel'],
                'addr' => $_GET['addr'],
            );
            C::t('#aljbd#aljbd_user')->insert($insertarray);
			echo "<script>parent.showDialog('".lang('plugin/aljbd','tg19')."','right','',function(){parent.location.href=parent.location.href;});</script>";
			
        }
    } else {
        $user = C::t('#aljbd#aljbd_user')->fetch($uid);
        include template('aljbd:addr');
    }
}else if($act == 'viewaddr'){
	$order = C::t('#aljbd#aljbd_order') -> fetch($_GET['orderid']);
	$uid = $order['uid'];
	$user = C::t('#aljbd#aljbd_user')->fetch($uid);
    include template('aljbd:viewaddr');
} else if($act == 'settle'){
	$cur = DB::result_first('select sum(amount*price) from %t where uid = %d and status >= 2 group by uid',array('aljbd_order',$_G['uid'])) * (1-$config['per']);
	$cur = $cur - DB::result_first('select sum(settleprice) from %t where uid = %d and status < 2 group by uid',array('aljbd_settle',$_G['uid']));
	$cur = sprintf("%.3f",$cur);
	if (submitcheck('formhash')){
		if ($cur < $config['min']) {
			showerror(lang('plugin/aljbd','tg32'));
			exit;
		}
		$settleid = dgmdate(TIMESTAMP, 'YmdHis').random(18);
		C::t('#aljbd#aljbd_settle') -> insert(array(
			'uid' => $_G['uid'],
			'settleid' => $settleid,
			'settleprice' => $_GET['settleprice'],
			'username' => $_GET['username'],	
			'account' => $_GET['account'],	
			'payment' => $config['payment'],	
			'status' => 0,	
			'applytime' => TIMESTAMP,	
		));
		showmsg(lang('plugin/aljbd','tg33'));
	} else{
		include template('aljbd:settle');
	}
} else if($act == 'editsettle'){
	$settleid = htmlspecialchars($_GET['settleid']);
	$cur = DB::result_first('select sum(amount*price) from %t where uid = %d and status >= 2 group by uid',array('aljbd_order',$_G['uid'])) * (1-$config['per']);
	$cur = $cur - DB::result_first('select sum(settleprice) from %t where uid = %d and status < 2 and settleid != %s group by uid',array('aljbd_settle',$_G['uid'],$settleid));
	if (submitcheck('formhash')){
		if (empty($settleid)) {
			showerror(lang('plugin/aljbd','tg34'));
			exit;
		}
		$settle = C::t('#aljbd#aljbd_settle') -> fetch($_GET['settleid']);
		if ($settle['uid'] != $_G['uid'] && !in_array($_G['groupid'],$admingroups)) {
			showerror(lang('plugin/aljbd','tg35'));
			exit;
		}
		if ($settle['status'] != 0) {
			showerror(lang('plugin/aljbd','tg36'));
			exit;
		}
		if ($cur < $config['min']) {
			showerror(lang('plugin/aljbd','tg37'));
			exit;
		}
		C::t('#aljbd#aljbd_settle') -> update($_GET['settleid'],array(
			'settleprice' => $_GET['settleprice'],
			'username' => $_GET['username'],	
			'account' => $_GET['account'],	
			'payment' => $config['payment'],	
			'status' => 0,	
			'applytime' => TIMESTAMP,	
		));
		showmsg(lang('plugin/aljbd','tg38'));
	} else{
		if (empty($settleid)){
			showmessage(lang('plugin/aljbd','tg39'));
		}
		$settle = C::t('#aljbd#aljbd_settle') -> fetch($_GET['settleid']);
		if ($settle['uid'] != $_G['uid'] && !in_array($_G['groupid'],$admingroups)) {
			showmessage(lang('plugin/aljbd','tg40'));
			exit;
		}
		include template('aljbd:settle');
	}
} else if ($act == 'settlelist'){
	$page = intval($_GET['page']);
	$currpage = $page?$page:1;
	$perpage = 10;
	$start = ($currpage-1)*$perpage;
	if(in_array($_G['groupid'],$admingroups)){
		$num = DB::result_first('select count(*) from %t',array('aljbd_settle'));
		$settlelist = DB::fetch_all('select * from %t order by applytime desc limit %d,%d',array('aljbd_settle',$start,$perpage));
	}else{
		$num = DB::result_first('select count(*) from %t where uid = %d',array('aljbd_settle',$_G['uid']));
		$settlelist = DB::fetch_all('select * from %t where uid = %d order by applytime desc limit %d,%d',array('aljbd_settle',$_G['uid'],$start,$perpage));
	}
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd:member&act=settlelist', 0, 11, false, false);
	include template('aljbd:settlelist');
} else if($act == 'deletesettle'){
	if (!in_array($_G['groupid'],$admingroups)){
		showmessage(lang('plugin/aljbd','tg41'));
	}
	if ($_GET['settleid']){
		C::t('#aljbd#aljbd_settle') -> delete($_GET['settleid']);
	}
	showmessage(lang('plugin/aljbd','tg42'),'plugin.php?id=aljbd&act=settlelist');
} else if($act == 'agreesettle'){
	if (!in_array($_G['groupid'],$admingroups)){
		showmessage(lang('plugin/aljbd','tg43'));
	}
	if ($_GET['settleid']){
		DB::query('update %t set status = 1,dateline = %d where settleid = %s',array('aljbd_settle',TIMESTAMP,$_GET['settleid']));
	}
	showmessage(lang('plugin/aljbd','tg44'),'plugin.php?id=aljbd&act=settlelist');
} else if($act == 'disagreesettle'){
	if (!in_array($_G['groupid'],$admingroups)){
		showmessage(lang('plugin/aljbd','tg45'));
	}
	if ($_GET['settleid']){
		DB::query('update %t set status = 2,dateline = %d where settleid = %s',array('aljbd_settle',TIMESTAMP,$_GET['settleid']));
	}
	showmessage(lang('plugin/aljbd','tg46'),'plugin.php?id=aljbd&act=settlelist');
} else if ($act == 'viewwuliu') {
	$wuliu = C::t('#aljbd#aljbd_wuliu')->fetch($_GET['orderid']);
	include template('aljbd:viewwuliu');
} else if($_GET['act'] == 'wuliu'){
	if(submitcheck('formhash')){
		if(C::t('#aljbd#aljbd_wuliu')->fetch($_GET['orderid'])){
			C::t('#aljbd#aljbd_wuliu')->update($_GET['orderid'],array(
				'companyname' => $_GET['companyname'],
				'worderid' => $_GET['worderid'],
				'updatetime' => TIMESTAMP,
			));
			C::t('#aljbd#aljbd_order')->update_status_by_orderid($_GET['orderid']);
			showmessage(lang('plugin/aljbd','sc1'), 'plugin.php?id=aljbd&act=orderlist');
		}else{
			C::t('#aljbd#aljbd_wuliu')->insert(array(
				'orderid' => $_GET['orderid'],
				'type' => 1,
				'companyname' => $_GET['companyname'],
				'worderid' => $_GET['worderid'],
				'dateline' => TIMESTAMP,
			));
			C::t('#aljbd#aljbd_order')->update_status_by_orderid($_GET['orderid']);
			showmessage(lang('plugin/aljbd','tg44'), 'plugin.php?id=aljbd&act=orderlist');
		}
	}else{
		$wuliu = C::t('#aljbd#aljbd_wuliu')->fetch($_GET['orderid']);
		$_GET['type'] = 2;
		include template('aljbd:wuliu');
	}
}else{	
	$sj_index_dh = explode ("\n", str_replace ("\r", "", $config ['sj_index_dh']));
	foreach($sj_index_dh as $key=>$value){
		$arr=explode('|',$value);
		$sj_index_dh_types[]=$arr;
	}
	$sjlz = explode ("\n", str_replace ("\r", "", $config ['sj_img_1']));
	foreach($sjlz as $key=>$value){
		$arr=explode('|',$value);
		$lz_types[$arr[0]]=$arr[1];
	}
	$navtitle = lang('plugin/aljbd','s44').$config['title'];
	$metakeywords =  $config['keywords'];
	$metadescription = $config['description'];
	if($aljbd_seo['index']['seotitle']){
		$seodata = array('bbname' => $_G['setting']['bbname']);
		list($navtitle, $metadescription, $metakeywords) = get_seosetting('', $seodata, $aljbd_seo['index']);
	}
	$khf=C::t('#aljbd#aljbd_comment')->count_by_bid($_GET['bid']);
	$typecount=C::t('#aljbd#aljbd')->count_by_type();
	//debug($typecount);
	foreach($typecount as $tc){
		$tcs[$tc['type']]=$tc['num'];
	}
	//debug($tcs);
	if($_GET['type']){
		$subtypecount=C::t('#aljbd#aljbd')->count_by_type($_GET['type']);
	}
	$aljbd=C::t('#aljbd#aljbd')->fetch_by_uid($_G['uid']);
	//debug($aljbd);
	$config=$_G['cache']['plugin']['aljbd'];
	$typelist=C::t('#aljbd#aljbd_type')->range();
	$tlist=C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
	$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid(0);
	$currpage=$_GET['page']?$_GET['page']:1;
	$perpage=$config['page'];
	
	if(defined('IN_MOBILE')){
		if($_G['charset']=='gbk'){
			$_GET['kw']=diconv($_GET['kw'],'utf-8','gbk');
		}
		
	}
	
	$num=C::t('#aljbd#aljbd')->count_by_status(1,'',$_GET['type'],$_GET['subtype'],$_GET['region'],$_GET['subregion'],$_GET['kw'],'',$_GET['region1']);
	
	$total_page = ceil($num/$perpage);
//debug($currpage > 1);
		//第一页的时候没有上一页
	if($total_page>1){
		if($currpage > 1){
			$shangyiye='<a href="plugin.php?id=aljbd&page='.($currpage-1).'&kw='.$_GET['kw'].'">'.lang('plugin/aljbd','sj_3').'</a>&nbsp;&nbsp;';
		}else{
			$shangyiye='<span>'.lang('plugin/aljbd','sj_3').'</span>';
		}
		//尾页的时候不显示下一页
		if($currpage < $total_page){
			//debug(123);
			$xiayiye= '<a href="plugin.php?id=aljbd&page='.($currpage+1).'&kw='.$_GET['kw'].'">'.lang('plugin/aljbd','sj_2').'</a>&nbsp;&nbsp;';
			//debug($xiayiye);
		}else{
			$xiayiye='<span>'.lang('plugin/aljbd','sj_2').'</span>';
		}
	}
	$allpage=ceil($num/$perpage);
	$start=($currpage-1)*$perpage;
	$viewslist=C::t('#aljbd#aljbd')->fetch_all_by_view(1,0,6,'view');
	
	$timelist=C::t('#aljbd#aljbd')->fetch_all_by_view(1,0,6,'dateline');
	$recommendlist=C::t('#aljbd#aljbd')->fetch_all_by_recommend(1,0,6);
	$recommendlist_goods=C::t('#aljbd#aljbd_goods')->fetch_all_by_recommend(1,0,10);
	if($config['isrewrite']){
		if($_GET['order']=='1'){
			$_GET['order']='view';
		}else if($_GET['order']=='2'){
			$_GET['order']='dateline';
		}else{
			$_GET['order']='';
		}
		if($_GET['view']=='3'){
			$_GET['view']="pic";
		}else if($_GET['view']=='4'){
			$_GET['view']="list";
		}else{
			$_GET['view']='';
		}
	}
	if(!$_GET['order']&&$config['paixu']){
		if($config['paixu']==1){
			$_GET['order']='view';
		}else if($config['paixu']==2){
			$_GET['order']='dateline';
		}
	}
	$bdlist=C::t('#aljbd#aljbd')->fetch_all_by_status(1,$start,$perpage,'',$_GET['type'],$_GET['subtype'],$_GET['region'],$_GET['subregion'],$_GET['order'],$_GET['kw'],'',$_GET['region1']);
	
	foreach($bdlist as $k=>$v){
		$bdlist[$k]['c']=C::t('#aljbd#aljbd_comment')->fetch_by_bid($v['id']);
		$bdlist[$k]['q']=str_replace('{qq}',$v['qq'],$config['qq']);
	}//debug($bdlist);
	$notice=C::t('#aljbd#aljbd_notice')->fetch_all_by_uid_bid('','',0,9);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljbd&type='.$_GET['type'].'&subtype='.$_GET['subtype'].'&region='.$_GET['region'].'&subregion='.$_GET['subregion'].'&order='.$_GET['order'].'&kw='.$_GET['kw'].'&view='.$_GET['view'].'&region1='.$_GET['region1'], 0, 11, false, false);
	
	include template('aljbd:list');
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