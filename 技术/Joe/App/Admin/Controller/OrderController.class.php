<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;

class OrderController extends CommonController {

    public function index() {

        $this->assign("orderList", D("Admin/Order")->getOrderListByAll());
        $this->display();
    }

    public function edit() {
        $M = M("Order");
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Order")->edit());
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->display("add");
        }
    }

}