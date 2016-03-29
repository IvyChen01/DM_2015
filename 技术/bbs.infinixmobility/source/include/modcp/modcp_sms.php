<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 版主发送短信给用户
* @date: 2015�?�?�?下午2:34:24
* @author: yanhui.chen
* @version:
*/

if(!defined('IN_DISCUZ') || !defined('IN_MODCP')) {
	exit('Access Denied');
}
$flag = false;
if($op == 'addsms' && submitcheck('submit')) {
	$newmessage = nl2br(dhtmlspecialchars(trim($_GET['newmessage'])));
	if (empty($newmessage)){
	    showmessage("Please fill the message!",'forum.php?mod=modcp&action=sms');
	    return ;
	}
	$remark = $_GET['remark'];
	$nation_id = $_GET['nation'];
	$nation = getNationByTypeid($nation_id);
	$user_infos = C::t('common_member_profile')->fetch_info_by_nation($nation);
	$price_info = C::t('common_sms_price_list')->fetch_priceinfo_by_nation($nation);
	
	foreach ($user_infos as $user_info){
	    $phone_infos[$user_info['uid']] = $user_info['mobile']; 
	}
	
	foreach ($phone_infos as $k=>$phone){
	    if (strpos($phone, '0') === 0 && strlen($phone) <=11){
	        $phone = substr($phone, 1);
	        $to = $price_info['prefix'].$phone;
	    }else {
	        $to = $phone;
	    }
	    $url = 'https://rest.nexmo.com/sms/json';
	    $post_data = array(
	        "api_key"    =>"86abab34",
	        "api_secret" => "1fe8a6f6",
	        "from"       => "Xclub",
	        "to"         => $to,
	        "text"       => $newmessage,
	    );
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_POST, 1 );
	    curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(json_encode($post_data)));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    $result = curl_exec($ch);
	    curl_close($ch);
	    
	    $res_message = json_decode($result,true);
	   
	    if ($res_message['message'][0]['status'] != 0){
	       showerror($res_message['message'][0]['error-text']);
	    }

            $data = array(
	        'date' => time(),
	        'username' => $k,
	        'nation'  => $nation,
	        'phone'   => $to,
	        'moderator' => $_G['uid'],
	        'remark' => $remark,
	    );
	    
	    C::t('common_sms_list')->insert($data);

	    ++$i; 
	}
	
	$total = $i * $price_info['price'];
	$flag = true;
	
}
$messagelist =  C::t('common_sms_list')->fetch_all();

$lpp = empty($_GET['lpp']) ? 20 : intval($_GET['lpp']);
$page = max(1, intval($_G['page']));

$start = ($page - 1) * $lpp;
$num = count($messagelist);
$multipage = multi($num, $lpp, $page, "$cpscript?mod=modcp&action=sms");
//搜索数据
$search_data=C::t('common_sms_list')->fetch_all_search($start,$lpp);
foreach ($search_data as $k=>$v){
    $search_data[$k]['date'] = dgmdate($v['date'],'Y-m-d');
}
/**
 * 根据get的国家typeid获取name
 */
function getNationByTypeid($id){
	$nations=array(
		20 =>'Cote dIvoire',
		9  =>'Egypt',
		10 =>'France',
	    11 => 'Ghana',
	    12 => 'Kenya',
	    13 => 'Morocco',
	    14 => 'Nigeria',
	    15 => 'Pakistan',
	    16 => 'Saudi Arabia',
	    17 => 'United Arab Emirates'
	);
	return $nations[$id];
}
?>