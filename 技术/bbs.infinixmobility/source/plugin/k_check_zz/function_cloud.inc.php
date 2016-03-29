<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('KCLOUD_URL', 'aHR0cDovL3d3dy5rdW96aGFuLm5ldC9kZXYtaW5kZXguaHRtbA==');

function convertUrlQuery($query){ 
    $queryParts = explode('&', $query); 
    $params = array(); 
    foreach ($queryParts as $param) { 
        $item = explode('=', $param); 
        $params[$item[0]] = $item[1]; 
    } 
    return $params; 
}
 
function getUrlQuery($array_query){
    $tmp = array();
    foreach($array_query as $k=>$param){
        $tmp[] = $k.'='.$param;
    }
    $params = implode('&',$tmp);
    return $params;
}

function kcloud_url($extra) {
	global $_G;
	require_once DISCUZ_ROOT.'./source/discuz_version.php';
	//include DISCUZ_ROOT.'./config/config_ucenter.php';
	$uniqueid = $_G['setting']['siteuniqueid'] ? $_G['setting']['siteuniqueid'] : C::t('common_setting')->fetch('siteuniqueid');
	$uniqueid = md5($uniqueid);
	$siteqq = $_G['setting']['siteqq'] ? $_G['setting']['siteqq'] : C::t('common_setting')->fetch('site_qq');
	$data = 'siteuniqueid='.rawurlencode($uniqueid).'&siteurl='.rawurlencode($_G['siteurl']).'&mysiteid='.$_G['setting']['my_siteid'].'&siteqq='.$siteqq/*.'&myuckey='.UC_KEY*/;
	$param = 'data='.rawurlencode(base64_encode($data));
	$param .= '&md5hash='.substr(md5($data.TIMESTAMP), 8, 8).'&timestamp='.TIMESTAMP;
	return base64_decode(KCLOUD_URL).'?'.$param.$extra;
}



?>