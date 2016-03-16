<?php


namespace Admin\Model;

use Think\Model;

class WebinfoModel extends Model {

    public function getWebInfoByType($infoType) {
        $Model = M('Config');
        return $list = $Model->where('infoType=' . $infoType)->order('id desc')->select();
    }

}

?>
