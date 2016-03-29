<?php
define('APPTYPEID', 100);
define('CURSCRIPT', 'access');
require '../../../source/class/class_core.php';
require "../../../source/class/class_member.php";
$oauth_arr=array(
    'facebook' => array(
       //'consumerKey' => '820218674726761',
        //'consumerSecret' => '535c40e6825517087eb6ac4b8fec9c06'
        'consumerKey' => '803066846466999',
        'consumerSecret' => '65284460a64ca339e96ab161350b0289'
    ),
    'google' => array(
        'consumerKey' => '1003928351754-b7qj2mclj0qn6apskcgojkv9ba3trv0v.apps.googleusercontent.com',
        'consumerSecret' => 'MRlcTCEygF1v0h_UAfRs1NHb'
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
$url_arr=array('http://www.baidu.com','http://42.96.164.235:5558/Oauth/examples/access.php','http://bbs.infinixmobility.com/LoginOauth/Oauth/examples/accessFacebook.php');

$url = "https://graph.facebook.com/oauth/access_token?client_id=".$oauth_arr[$type[0]]['consumerKey']."&client_secret=".$oauth_arr[$type[0]]['consumerSecret']."&redirect_uri=".$url_arr[2]."&code=".$_GET['code']; 
//$url = "https://www.googleapis.com/plus/v1/people/me?access_token=ya29.2wAjtgFfLEH5NvEUMVYycrfLeLns6SqKU6Q1sAVFtKUSInUktwL8G6VqRHyBNSdIUWsQCwCUq3NGkw";
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
//echo $output;
$outArr = explode("&",$output);
$access_token_str = $outArr[0];
$access_token = explode("=",$access_token_str)[1];

$url = 'https://graph.facebook.com/me?fields=id,name,email&access_token='.$access_token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // ����Referer

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);	// https�� ������hosts
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$userinfo = curl_exec($ch);
curl_close($ch);
$obj = json_decode($userinfo);
header("location: ../../../member.php?mod=registerOutsideLogin&oauthid=".$obj->id."&email=".$obj->email."&nickname=".$obj->name."&flag=login");  


?>

