<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Admin\Model;

use Think\Model;

class OrderModel extends Model {

    public function getOrderListByAll() {

        return M("Order")->order('id desc')->select();
    }

    public function getOrderListByUid() {

        $map["uid"] = $_SESSION["uid"];
        return M("Order")->where($map)->order('id desc')->select();
    }

    public function edit() {
        $M = M("Order");
        $data = $_POST['info'];
        $data['update_time'] = time();
        if ($M->save($data)) {
            return array('status' => 1, 'info' => "已经更新", 'url' => U('Member/index'));
        } else {
            return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
        }
    }

}

?>
