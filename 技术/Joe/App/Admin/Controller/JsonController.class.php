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

class JsonController extends CommonController {

    public function index() {
        $M = M("Article");
        $count = $M->count();
        $page = new \Think\Page($count, 20);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $this->assign("list", D("Article")->listArticle($page->firstRow, $page->listRows));
        $this->display();
    }

    public function getMemberList() {
        $this->ajaxReturn(D("Json")->getMemberList());
    }

    public function add() {
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Article")->addArticle());
        } else {
            $this->assign("list", D("Channel")->category());
            $this->display();
        }
    }

    public function checkArticleTitle() {
        $M = M("Article");
        $where = "title='" . $_GET['title'] . "'";
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
        $M = M("Article");
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Article")->edit());
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->assign("list", D("Channel")->category());
            $this->display("add");
        }
    }

    public function del() {
        if (M("Article")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
//            $this->ajaxReturn(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

}