<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商城栏目管理
* @date: 2015年11月19日 下午12:17:48
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;

class ChannelController extends CommonController {

    public function index2() {
        $M = M("Channel");
        $list = $M->order("oid asc")->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function index() {
        if (IS_POST) {
            $this->ajaxReturn(D("Channel")->category());
        } else {
            $this->assign("list", D("Channel")->category());
            $this->display('category');
        }
    }

    public function add() {
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Channel")->addNews());
        } else {
            $this->assign("list", D("Channel")->category());
            $this->display();
        }
    }

    public function checkNewsTitle() {
        $M = M("Channel");
        $where = "title='" . $this->_get('title') . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            $this->ajaxReturn(array("status" => 0, "info" => "已经存在，请修改标题"));
        } else {
            $this->ajaxReturn(array("status" => 1, "info" => "可以使用"));
        }
    }

    public function edit() {
        $M = M("Channel");
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Channel")->edit());
        } else {
            $info = $M->where("cid=" . (int) $_GET['cid'])->find();
            if ($info['cid'] == '') {
                $this->error("不存在该记录");
            }
            $info["action"] = "edit";
            $this->assign("info", $info);
            $this->display("add");
        }
    }

    public function del() {
        $condition = "cid=" . I('get.id', 0, 'intval');
        $this->ajaxReturn(D("Channel")->remove($condition));
     /*    
        if (M("Channel")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
//            $this->ajaxReturn(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        } */
    }

}