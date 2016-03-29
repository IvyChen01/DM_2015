<?php

if($_G['forum_threadlist']){
	require_once(DISCUZ_ROOT."./source/function/function_post.php");
	foreach ($_G['forum_threadlist'] as $key=>$thread){
		$_G['forum_threadlist'][$key]['message']=DB::result_first("select message from ".DB::table("forum_post")." where tid='{$thread['tid']}' and first=1 limit 1");
	}
}
function mmsgtaglist($tag,$message,$num){
	if(preg_match_all("/\[$tag.*\](.*)\[\/$tag\]/isU",$message,$reg)){
		$array=array();
		foreach ($reg[1] as $k=>$v){
			if($k>=$num) break;
			$array[]=$v;
		}
		return $array;
	}
	return array();
}
 
function threadip($tid,$orderby){
	$ip=DB::result_first("select useip from ".DB::table("forum_post")." where tid='$tid' order by dateline $orderby limit 1");
	$ips=explode(".",$ip);
	return "{$ips[0]}.{$ips[1]}.{$ips[2]}.x";
}

function threadpics($tid,$num=1){
	$tableid=substr($tid,-1,1);
	$array=array();
	$rs=DB::query("SELECT aid, attachment  FROM  ".DB::table("forum_attachment_{$tableid}")." WHERE  `tid` ='$tid' AND  `isimage` =1 AND `price`=0 order by aid asc LIMIT 0 , $num");
	while ($rw=DB::fetch($rs)){
		$ra=explode("/",$rw['attachment']);
		$rb=end($ra);
		$rc=explode(".",$rb);
		$rw['filename']=$rc[0];
		$array[]=$rw;
	}
	return $array;
}

function picthreads($fids,$num,$and='',$orderby='',$msglength=100){
	require_once libfile('function/post');
	$array=array();
	$rs=DB::query("SELECT t.*,f.name,p.message 
FROM  ".DB::table("forum_thread")." t
left join ".DB::table("forum_forum")." f on f.fid=t.fid
left join ".DB::table("forum_post")." p on p.tid=t.tid and p.first=1
WHERE  t.`fid` in ($fids) $and
and t.displayorder>=0 and t.attachment=2
$orderby
LIMIT 0 , $num");
	while ($rw=DB::fetch($rs)){
		$rw['message']=messagecutstr($rw['message'],$msglength);
		$array[]=$rw;
	}
	return $array;
}

function delubb($a){
	$a=preg_replace("/\[music\].*\[\/music\]/isU","",$a);
	$a=preg_replace("/\[media\].*\[\/media\]/isU","",$a);
	$a=preg_replace("/\[price\].*\[\/price\]/isU","",$a);
	$a=preg_replace("/\[bmusic\].*\[\/bmusic\]/isU","",$a);
	return $a;
}

?>