<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2012-04-02 15:37
 * @version 1.0
 * @description 字符串加密解密类
 * @usage
 * $EncodeString = new EncodeString();
 * // 普通url地址参数加密解密
 * $url = "id=1&cid=2";
 * echo "原文：" . $url;
 * echo "<br/>";
 * echo "加密：" . $encodeStr = EncodeString::encodeStr($url);
 * echo "<br/>";
 * echo "解密：" . EncodeString::decodeStr($encodeStr);
 * echo "<br/>";
 * $urlParam = EncodeString::getUrlParam($encodeStr);
 * dump($urlParam);
 * echo $urlParam['id'];
 * // Thinkphp地址参数加密解密
 * $tpUrl = 'id/1/cid/2';
 * $encodeStr = EncodeString::encodeStr($tpUrl);
 * $tpUrlParam = EncodeString::getUrlParamBySlash($encodeStr);
 * dump($tpUrlParam);
 * echo $tpUrlParam['cid'];
 */

namespace Com;

class EncodeString {

    public static $encodeKey;

    public function __construct() {
        self::$encodeKey = "zhaoxiace";
    }

    public function __destruct() {
        
    }

    public function keyED($txt) {
        $encrypt_key = md5(self::$encodeKey);
        $ctr = 0;
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            if ($ctr == strlen($encrypt_key))
                $ctr = 0;
            $tmp .= substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1);
            $ctr++;
        }
        return $tmp;
    }

    public function encodeStr($str) {
        return rawurlencode(base64_encode(self::encrypt($str, self::$encodeKey)));
    }

    public function encrypt($txt) {
        $encrypt_key = md5(mt_rand(0, 100));
        $ctr = 0;
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            if ($ctr == strlen($encrypt_key))
                $ctr = 0;
            $tmp .= substr($encrypt_key, $ctr, 1) . ( substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1));
            $ctr++;
        }
        return self::keyED($tmp, self::$encodeKey);
    }

    public function decodeStr($str) {
        return self::decrypt(base64_decode(rawurldecode($str)), self::$encodeKey);
    }

    public function decrypt($txt) {
        $txt = self::keyED($txt, self::$encodeKey);
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            $md5 = substr($txt, $i, 1);
            $i++;
            $tmp .=( substr($txt, $i, 1) ^ $md5 );
        }
        return $tmp;
    }

    // public function geturl($encodeStr) {
    //     $urlString = self::decodeStr($encodeStr);
    //     $url_array = explode('&', $urlString);
    //     if (is_array($url_array)) {
    //         foreach ($url_array as $var) {
    //             $var_array = explode("=", $var);
    //             $vars[$var_array[0]] = $var_array[1];
    //         }
    //     }
    //     return $vars;
    // }

    public function getUrlParam($encodeStr) {
        $urlString = self::decodeStr($encodeStr);
        $url_array = explode('&', $urlString);
        if (is_array($url_array)) {
            foreach ($url_array as $var) {
                $var_array = explode("=", $var);
                $vars[$var_array[0]] = $var_array[1];
            }
        }
        return $vars;
    }

    public function getUrlParamBySlash($encodeStr) {
        $urlString = self::decodeStr($encodeStr);
        $url_array = explode('/', $urlString);
        if (is_array($url_array)) {
            foreach ($url_array as $key => $value) {
                if ($key % 2 == 0) {
                    $var[$url_array[$key]] = $url_array[$key + 1];
                }
            }
        }
        return $var;
    }

    public function __set($propertyName, $propertyValue) {
        $this->$propertyName = $propertyValue;
    }

    public function __get($propertyName) {
        if (isset($this->$propertyName)) {
            return $this->$propertyName;
        } else {
            return null;
        }
    }

}

?>