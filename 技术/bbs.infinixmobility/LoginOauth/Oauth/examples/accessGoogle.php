<?php
define('APPTYPEID', 100);
define('CURSCRIPT', 'access');
require '../../../source/class/class_core.php';
require "../../../source/class/class_member.php";
$oauth_arr=array(
    'facebook' => array(
        'consumerKey' => '728047490618148',
        'consumerSecret' => 'ed2fd573b80abf1939be220719ef8d98'
    ),
    'google' => array(
        'consumerKey' => '1094305928016-hb7e7gfnk58pof6hrij59j4166d7dovb.apps.googleusercontent.com',
        'consumerSecret' => 'Eh-RhV0fJH9EKT4gwDMRuIs5'
    ),
    'twitter' => array(
        'consumerKey' => 'ScubmCRZGX9wz0dUBuYYKDUQ2',
        'consumerSecret' => 'r2bI1S0TJ80WD5zrsNTcdIQ2yM0F6o1hR1urWM9eB9Ta6BkPCI'
    ),
     'Douban' => array(
        'consumerKey' => '02adc684816950a30809538d843bf1e9',
        'consumerSecret' => 'a2c15aee1f1311cc'
    )
);
$type=array(
        'facebook','google','twitter','Douban'
);
$url_arr=array('http://www.baidu.com','http://42.96.164.235:5558/Oauth/examples/access.php','http://bbs.infinixmobility.com/LoginOauth/Oauth/examples/accessGoogle.php');

$query_arr = array(
    'code' => $_GET['code'],
    'client_id' => $oauth_arr[$type[1]]['consumerKey'],
    'client_secret' => $oauth_arr[$type[1]]['consumerSecret'],
    'redirect_uri' => $url_arr[2],
    'grant_type' => 'authorization_code'
);

$query_data = http_build_query($query_arr,"&");
$url = 'https://www.googleapis.com/oauth2/v3/token';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); 
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)'); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); 
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS,$query_data); 
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); 
    curl_setopt($curl, CURLOPT_HEADER, 0); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    $result_data  = curl_exec($curl); 
    curl_close($curl);    
$obj=json_decode($result_data); 
$url='https://www.googleapis.com/plus/v1/people/me?access_token='.$obj->access_token;  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$output = curl_exec($ch);
curl_close($ch);
$obj=json_decode($output);
header("location: ../../../member.php?mod=registerOutsideLogin&oauthid=".$obj->id."&flag=login");  

?>

