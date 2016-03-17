<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :购物车控制器
* @date: 2015年11月4日 上午11:32:18
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;

class ShopcartController extends CommonController {

    //加入购物车
    public function addShopcartRecord() {

        A("Member")->isMemberLoginIn();
        $Article = M('Article');
        $map['id'] = $_GET['id'];
        $articleList = $Article->where($map)->find();

        $Shopcart = M('Shopcart');
        $data["productId"] = $map["id"];
        $data["uid"] = $_SESSION["uid"];
        $data["title"] = $articleList["title"];
        $data["content"] = $articleList["content"];
        $data["price"] = $articleList["price"];
        $data["num"] = $articleList["num"];
        $data["subTime"] = time();
        if ($Shopcart->add($data)) {
            $this->success("添加成功!");
        } else {
            $this->error("添加失败!");
        }
    }

    //购物车产品列表
    public function shopcartList() {

        if ($_POST) {
            $Order = M("order");
            $orderData["orderNo"] = date("YmdHis") . rand(1000, 9999);
            $orderData["mobile"] = $_POST["mobile"];
            $orderData["dinnerPlace"] = $_POST["dinnerPlace"];
            $orderData["dinnerTime"] = $_POST["dinnerDate"] . " " . $_POST["dinnerTimeHour"] . ":" . $_POST["dinnerTimeMinute"] . ":00";
            $orderData["dinnerNum"] = $_POST["dinnerNum"];
            $orderData["submitter"] = $_SESSION["name"];
            $orderData["subTime"] = time();
            $orderId = $Order->add($orderData);
            $idArr = $_POST["checkbox"];
            foreach ($idArr as $key => $value) {
                $Shopcart = M("shopcart");
                $shopcartMap["id"] = $value;
                $shopcartData["orderId"] = $orderId;
                $Shopcart->where($shopcartMap)->save($shopcartData);
            }
            $this->success("订单提交成功！", U("/Order/orderList"));
        } else {
            A("Member")->isMemberLoginIn();
            $this->assign("shopcartList", D("Admin/Shopcart")->getShopcartListByUid($_SESSION['uid'], 0));

            $this->display();
        }
    }

    public function del() {

        A("Member")->isMemberLoginIn();
        if (M("Shopcart")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
//echo json_encode(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

}

?>