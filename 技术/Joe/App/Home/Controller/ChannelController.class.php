<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :
* @date: 2015年11月4日 上午11:30:15
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;

class ChannelController extends CommonController {

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
        $this->model = D('Admin/Article');
    }

    public function index() {

        $this->display();
    }

    public function singlePage() {

        $this->display();
    }

    public function commonDetail() {

        //$this->assign('articleDetail', D("Admin/Article")->getArticleDetailById($_GET["id"]));
        $articleMap['id'] = I('get.id');
        $this->assign('articleDetail', $this->model->getDetail('Article', $articleMap));
    }

    public function articleList() {

        $randList = $this->model->getRandList();
        $this->assign('randList', $randList['info']);

        $articleList = $this->model->getListByCode();
        $this->assign('articleList', $articleList['info']);
        $this->assign('page', $articleList['page']);
        $this->display();
    }

    public function articleDetail() {

        $this->commonDetail();
        $this->display();
    }

    public function articleSearch() {

        $articleMap['cid'] = $channelDetail["id"];
        $articleList = $this->model->getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'id DESC', 'listRows' => '10'), $articleMap);

        $this->assign('articleList', $articleList["info"]);
        $this->assign('page', $articleList["page"]);
        $this->display("articleList");
    }

    public function productList() {

        $randList = $this->model->getRandList();
        $articleList = $this->model->getListByCode();

        $this->assign('randList', $randList['info']);
        $this->assign('articleList', $articleList['info']);
        $this->assign('page', $articleList['page']);
        $this->display('');
    }

    public function productDetail() {

        $this->commonDetail();
        $this->display();
    }

    public function productSearch() {

        $articleMap['cid'] = $channelDetail["id"];
        $articleList = $this->model->getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'id DESC', 'listRows' => '10'), $articleMap);

        $this->assign('articleList', $articleList["info"]);
        $this->assign('page', $articleList["page"]);
        $this->display("productList");
    }

}

?>