<?php

$message = urlencode($_POST['message']);
$url = 'http://openapi.baidu.com/public/2.0/bmt/translate?client_id=z9RHKphkeBQbjhxjW99BVc6D&q=' . $message . '&from=auto&to=en';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));
$result = curl_exec($ch);
curl_close($ch);
$res_message = json_decode($result);
$text = $res_message->trans_result;
$trans_res = '';
if (count($text)>1){
    foreach ($text as $k=>$v){
        $trans_res .= $v->dst.'<br/>';
    }
    if (preg_match('/[^\x00-\x7F]/', $trans_res )){
        $trans_res = '';
    }
    echo $trans_res;
}else {
    $trans_res2 =  $text[0]->dst;
    if (preg_match('/[^\x00-\x7F]/', $trans_res2 )){
        $trans_res2 = '';
    }
    echo $trans_res2;
}

?>

