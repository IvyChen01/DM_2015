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

class CategoryController extends CommonController {

    /**
      +----------------------------------------------------------
     * 定义
      +----------------------------------------------------------
     */
    protected $model;

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        parent::_initialize();
        $this->model = D('Category');
        $this->searchConditionStr = $this->model->model . 'SearchConditionStr';
        $this->searchConditionArr = $this->model->model . 'SearchConditionArr';
    }

    public function index() {
        if (IS_POST) {
            $this->ajaxReturn($this->model->category());
        } else {
            $this->assign("list", $this->model->category());
            $this->display();
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
        if (M("Channel")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
//            $this->ajaxReturn(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

    /**
      +----------------------------------------------------------
     * 分类查找带回
      +----------------------------------------------------------
     */
    public function lookup() {

        $condition = $this->searchCondition();
        $condition['type'] = I('get.type');
        $list = $this->model->getPageList($param = array('modelName' => 'Category', 'field' => 'cid,name,description', 'order' => 'cid ASC', 'listRows' => '2', 'tablePrefix' => 'eo_', 'connection' => 'DB_ADMIN'), $condition);
        $this->assign('search', $this->searchKeywords());
        $this->assign('list', $list['info']);
        $this->assign('total', $list['total']);
        $this->display();
    }

}