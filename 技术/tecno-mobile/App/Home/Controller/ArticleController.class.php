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

    public function index() {
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        $this->assign('articleCatList', $articleCatList);
        $articleList = $this->model->where(array('cid'=>'38','isDel'=>'0','lang'=>$lang))->select();
        //$compaignsNews = $this->model->where(array('cid'=>'39','isDel'=>'0'))->order('id desc')->select();
        $this->assign('articleList', $articleList);
        //$this->assign('compaignsNews', $compaignsNews);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->display('news');
    }
    public function articleCatDetail() {
        $id = I('get.catId');
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        
        $articleList = $this->model->where(array('cid'=>$id,'isDel'=>'0','lang'=>$lang))->select();
        
        $this->assign('articleList', $articleList);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('id',$id);
        $this->assign('articleCatList', $articleCatList);
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
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $cid = I('get.cid');
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        
        $articleList = $this->model->where(array('cid'=>$cid,'isDel'=>'0','lang'=>$lang))->select();
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        $this->assign('articleCatList', $articleCatList);
        $this->assign('articleList', $articleList);
        $this->assign('articleDetail', $articleDetail);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('front', $this->model->getFront($id));
        $this->assign('after', $this->model->getAfter($id));
        
        $this->display("news_contact");
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