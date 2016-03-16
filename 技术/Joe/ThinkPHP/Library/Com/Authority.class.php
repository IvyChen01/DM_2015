<?php

namespace Com;

class Authority {

    public $uid;
    public $userShell;
    public $mid;
    public $authLongUrl;
    public $authShortUrl;

    function __construct($outPutPara) {
        
    }

    public function __destruct() {
        
    }

    public function loginCheck($profile, $userShell) {
        $us = is_array($profile);
        $shell = $us ? $userShell == md5($profile[username] . $profile[password] . "PHP100") : FALSE;
        if (!$shell) {
            //echo '<script>window.parent.location="http://' . $_SERVER['HTTP_HOST'] . '/index.php";</script>';
            echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/index.php">请先登陆，如果使用的是中核二三协同办公平台，请在“个人设置--第三方用户设置”中填写设计公司系统用户名及密码提交即可。</a>';
            exit();
        }
    }

    public function user_mktime($onlinetime) {
        $new_time = mktime();
        if ($new_time - $onlinetime > '28800') {
            //echo '<script>window.parent.location="http://' . $_SERVER['HTTP_HOST'] . '/index.php";</script>';
            session_destroy();
        } else {
            $_SESSION[times] = mktime();
        }
    }

    function authCheck($nameUsername, $authLongUrl, $authShortUrl) {


        $pri_rows = $authLongUrl;

        if (!is_array($pri_rows)) {
            $pri_rows = $authShortUrl;
        }
        if (is_array($pri_rows)) {
            $private_ren = $pri_rows['private_ren'];
            $isinclude = strstr($private_ren, $nameUsername);
            if (!$isinclude) {
                echo '<div style="text-align:center"><span style="display:block;margin:150px auto;border: solid 5px #839c04;width:400px;height:200px;background-image:url(/Tpl/default/Home/Public/Images/Default/no_private.jpg);"></span></div>';
                exit();
            }
        }
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