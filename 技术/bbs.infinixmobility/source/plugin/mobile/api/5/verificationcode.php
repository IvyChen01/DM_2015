<?php
use Zend\Stdlib\ParameterObjectInterface;
/**
 * Copyright @ 2013 Infinix.
 * All rights reserved.
 * ==============================================
 * @Description :手机注册获取验证码
 * @date: 2015年7月1日 上午11:21:37
 * 
 * @author : yanhui.chen
 * @version :
 *         
 */
if (! defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

define('APPTYPEID', 0);
define('CURSCRIPT', 'member');

require './source/class/class_core.php';

C::app()->init();

$variable = array();
global $_G;
if (isset($_GET['flag'])) {
    if ($_GET['flag'] == 1) {
        
        $phoneVerify = mt_rand(10000, 99999);
        $tel = $_GET['tel'];
        if(strpos($tel, '0') === 0){
            $tel = substr($tel, 1);
        }
        $phoneNum = intval($_GET['internationalCode']) . $tel;
        
        C::t('common_phone_code')->delete_by_phone($phoneNum);
        $data = array(
            'phone' => $tel,
            'vcode' => $phoneVerify,
            'time' => time()
        );
       
        
        $url = 'https://rest.nexmo.com/sms/json';
        $post_data = array(
            "api_key" => "86abab34",
            "api_secret" => "1fe8a6f6",
            "from" => "Xclub",
            "to" => $phoneNum,
            "text" => 'your verification code is ' . $phoneVerify
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(json_encode($post_data)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        
        $res_message = json_decode($result, true);
        
        C::t('common_phone_code')->insert($data);
        $code = $res_message['messages'][0]['status'];
        
    }
}

$variable['phonecode'] = $code;
$variable['message'] = getCodeMessage($code) ? getCodeMessage($code) : $code = $res_message['messages'][0]['error-text'];

function getCodeMessage($code)
{
    $message = array(
        '0' => 'succeed',
        '2' => 'param wrong',
        '6' => 'unrecognized prefix for the phone number',
        '-10' => 'invalid ip',
        '-14' => 'the phone num over 3 times today',
        '-12' => 'not fund the verification code',
        '-11' => 'code expired ',
        '-1' => 'code not invalid'
    );
    return $message[$code];
}
mobile_core::result(mobile_core::variable($variable));

?>
