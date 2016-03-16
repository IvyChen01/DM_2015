<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 文章控制器
* @date: 2015年11月4日 上午11:28:42
* @author: yanhui.chen
* @version:
*/
namespace Home\Controller;

use Think\Controller;

class ArticleController extends CommonController {

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
        $this->goodsCatsModel = D('Admin/GoodsCats');
        $this->adsModel = D('Admin/Ads');
        $this->articleCatsModel = D('Admin/ArticleCats');
        $this->goodsModel = D('Admin/goods');
    }

    public function api() {
        $randList = $this->model->getRandList();
        foreach ($randList['info'] as $k => $v) {
            $randList['info'][$k]['url'] = U('Article/detail@www.ewsd.cn', 'id=' . $v['id']);
        }
        $this->ajaxReturn($randList);
    }

    public function getApiData() {

        $content = json_decode(file_get_contents('http://localhost:86/Article/api'));
        foreach ($content->info as $k => $v) {
            echo '<li><a target="_blank" href="' . $v->url . '">' . $v->title . '</a></li>';
        }
    }

    public function index() {

        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        $newsCatList = $this->articleCatsModel->queryByList(32);
        $adsList = $this->adsModel->queryByList(-1);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        //var_dump($adsList);exit;
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('newsCatList', $newsCatList);
        $this->assign('adsList', $adsList);
        $Article = M('Article');
        $hotNews = $Article->where(array('cid'=>'36','isDel'=>'0'))->select();
        $lastestNews = $Article->where(array('cid'=>'33','isDel'=>'0'))->order('id desc')->select();
        $eventNews = $Article->where(array('cid'=>'37','isDel'=>'0'))->order('id desc')->select();
        $this->assign('hotNews', $hotNews);
        $this->assign('lastestNews', $lastestNews);
        $this->assign('eventNews', $eventNews);
        $this->display('news');
    }
    /**
      +----------------------------------------------------------
     * 文章查询
      +----------------------------------------------------------
     */
    public function search() {

        $randList = $this->model->getRandList();
        $articleMap['title|content'] = array('LIKE', '%' . I('get.keyWords') . '%');
        $articleList = $this->model->getListbyAll($order = 'uTime DESC', $articleMap);
        
        $this->assign('randList', $randList['info']);
        $this->assign('articleList', $articleList["info"]);
        $this->assign('page', $articleList["page"]);
        $this->display();
    }

    public function articleList() {

        $this->commonList();
        $this->display();
    }

    public function page() {

        $this->display();
    }

    public function _before_detail() {

        $condition['id'] = I('get.id');
        $this->model->toSetInc($param = array('modelName' => 'Article'), 'visitNums', 1, $condition);
    }

    public function detail() {
        $id = I('get.id');
        $this->model->visitNumAdd($id);
        //$randList = $this->model->getRandList();
        $articleDetail = $this->model->getDetailById($id);
        
        //$this->assign('randList', $randList['info']);
        $this->assign('articleDetail', $articleDetail);

        $this->assign('front', $this->model->getFront($id));
        $this->assign('after', $this->model->getAfter($id));
        
        $this->display();
    }

    public function articleSearch() {

        $articleMap['cid'] = $channelDetail["id"];
        $articleList = $this->model->getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'id DESC', 'listRows' => '10'), $articleMap);

        $this->assign('articleList', $articleList["info"]);
        $this->assign('page', $articleList["page"]);
        $this->display("articleList");
    }

}

?>