<?php
require_once '../init_autoloader.php';

use EvaOAuth\Service as OAuthService;

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
       'facebook' ,'google','twitter','Douban'
);
$url_arr=array('http://www.baidu.com','http://42.96.164.235:5558/LoginOauth/Oauth/examples/access.php','http://bbs.infinixmobility.com/LoginOauth/Oauth/examples/accessFacebook.php');
$oauth = new OAuthService();
$oauth->setOptions(array(
    'callbackUrl' => $url_arr[2],
    'consumerKey' => $oauth_arr[$type[0]]['consumerKey'],
    'consumerSecret' => $oauth_arr[$type[0]]['consumerSecret'],
    'scope' =>'public_profile, email'
));
$oauth->initAdapter($type[0], 'OAuth2');
$requestTokenUrl = $oauth->getAdapter()->getRequestTokenUrl();
header("location: $requestTokenUrl");  
   
?>
