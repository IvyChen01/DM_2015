<?php

namespace Com;

class OnLine extends SqlHelper {

    public $username;

    function __construct($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        $this->DbCommon = new SqlHelper("common");
    }

    public function __destruct() {
        
    }

    public function getOnLine() {

        $update_time = "6000"; //更新的频率(秒)
        $userip = $_SERVER['REMOTE_ADDR'];
        $name = $_SESSION[name];
        $username = $_SESSION[username];
        $dbxiangmu = $_SESSION[dbxiangmu];
        $department = $_SESSION[department];
        $lastactive_time = date("Y-m-d H:i:s");
        $lastactive_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $now = time();

        $sqlStr = "select username from online_list where username='$username'";
        $count = $this->DbCommon->count($sqlStr);
        if ($count != 0) {
            $sqlStr = "update online_list set second_time='$now' , lastactive_time='$lastactive_time' , lastactive_url='$lastactive_url' where username='$username'";
            $this->DbCommon->save($sqlStr);
        } else {
            $sqlStr = "insert into online_list(username,name,xiangmu,department,lastactive_time,userip,online_time,second_time,lastactive_url)values('$username','$name','$dbxiangmu','$department','$lastactive_time','$userip','$now','$now','$lastactive_url')";
            $this->DbCommon->add($sqlStr);
        }

        $del_time = $now - $update_time;
        $sqlStr = "delete from online_list where second_time < '$del_time'";
        $this->DbCommon->delete($sqlStr);
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