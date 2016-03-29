<?php
require_once '../init_autoloader.php';

use EvaOAuth\Service as OAuthService;

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
       'facebook' ,'google','twitter','Douban'
);
$url_arr=array('http://www.baidu.com','http://42.96.164.235:5558/LoginOauth/Oauth/examples/access.php','http://bbs.infinixmobility.com/LoginOauth/Oauth/examples/accessGoogle.php');
$oauth = new OAuthService();
$oauth->setOptions(array(
    'callbackUrl' => $url_arr[2],
    'consumerKey' => $oauth_arr[$type[1]]['consumerKey'],
    'consumerSecret' => $oauth_arr[$type[1]]['consumerSecret']
));
$oauth->initAdapter($type[1], 'OAuth2');
$requestTokenUrl = $oauth->getAdapter()->getRequestTokenUrl();
header("location: $requestTokenUrl");  
   
?>
