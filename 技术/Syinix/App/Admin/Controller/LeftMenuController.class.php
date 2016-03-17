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

class LeftMenuController extends CommonController {

    public function index2() {
        $M = M("Channel");
        $list = $M->order("oid asc")->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function index() {
        $m = D('Admin/Leftmenu');
        //var_dump($m->category());exit;
        if (IS_POST) {
            $this->ajaxReturn($m->category());
        } else {
            $this->assign("list", $m->category());
            $this->assign('total',count($m->category()));
            $this->display('index');
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
    
    /**
     * 修改名称
     */
    public function editName(){
        //$this->isAjaxLogin();
        $m = D('Admin/Leftmenu');
        $rs = array('status'=>-1);
        if(I('id',0)>0){
            //$this->checkAjaxPrivelege('spfl_02');
            $rs = $m->editName();
        }
        $this->ajaxReturn($rs);
    }
    /**
     * 修改名称
     */
    public function editSort(){
        //$this->isAjaxLogin();
        $m = D('Admin/Leftmenu');
        $rs = array('status'=>-1);
        if(I('id',0)>0){
            $rs = $m->editSort();
        }
        $this->ajaxReturn($rs);
    }
    /**
     * 修改pid
     */
    public function editPid(){
        //$this->isAjaxLogin();
        $m = D('Admin/Leftmenu');
        $rs = array('status'=>-1);
        if(I('id',0)>0){
            $rs = $m->editPid();
        }
        $this->ajaxReturn($rs);
    }
    /**
     * 删除操作
     */
    public function delMenu(){
        $m = D('Admin/Leftmenu');
        $rs = $m->delMenu($_GET['id']);
        $this->ajaxReturn($rs);
    }

}