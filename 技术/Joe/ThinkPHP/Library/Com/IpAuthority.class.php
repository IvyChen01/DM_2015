<?php

//====================================================
//  FileName:DownLoadsClass.php
//  Summary: 文件下载类
//  Author: zhaoxiace
//  Email:xvpindex@qq.com
//  CreateTime: 2012-10-16
//  LastModifed:
//  copyright (c)2012  [email]xvpindex@qq.com[/email]
//  使用范例：
//  $download=new download('php,exe,html',false);
//  $attachName = "附件名";
//  $attachUrl = $_SERVER['DOCUMENT_ROOT']."/Public/Data/PY2LX521002EIYK43DD1@1CCFC.rar";
//  if(!$download->downloadFile($attachName,$attachUrl)))
//  {
//    echo $download->geterrormsg();
//  }
//====================================================

namespace Com;

class IpAuthority extends SqlHelper {

    var $debug = true;
    var $errormsg = '';
    var $Filter = array();
    var $filename = '';
    var $mineType = 'text/plain';
    var $xlq_filetype = array();

    public function __construct($fileFilter = '', $isdebug = true) {
        $this->setFilter($fileFilter);
        $this->setdebug($isdebug);
        $this->setfiletype();
    }

    public function __destruct() {
        
    }

    function setFilter($fileFilter) {
        include($_SERVER["DOCUMENT_ROOT"] . "/co_connection.php");
        $userIp = $_SERVER['REMOTE_ADDR'];
        $per_sql = "SELECT Ip FROM ims_common_permitip WHERE Ip = '$userIp'";
        $per_rows = mysql_fetch_row(mysql_query($per_sql));
        if ($per_rows == 0) {
            if ($_SESSION["authorizeCode"] != "" and $_GET["authorizeCode"] == $_SESSION["authorizeCode"]) {
                
            } else {
                echo '<div class="no_permitIp">
          <br>您的IP地址：' . $userIp . '<br>对不起，您未使用授权范围内的电脑登陆！<br>请使用Email获取授权登陆地址或联系：010-57968663
          <form name="EmailForm" method="POST" action="/Public/Plugins/Email/EmailSend.php">
          您的Email地址：<input type="text" name="Email" value="" />
          <input type="submit" name="getAuthorize" value="获取授权地址" onclick="return isEmail()" />
          </form></div>';
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
