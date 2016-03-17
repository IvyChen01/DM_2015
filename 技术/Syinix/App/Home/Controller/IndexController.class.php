<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :
* @date: 2015年11月4日 上午11:30:44
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController {

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
        $this->goodsCatsModel = D('Admin/GoodsCats');
        $this->adsModel = D('Admin/Ads');
        $this->articleCatsModel = D('Admin/ArticleCats');
        $this->goodsModel = D('Admin/goods');
        //$this->articleModel = D('Admin/Article');
    }

   
    public function index() {
        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        foreach ($goodsCatslist as $k=>$v){
            $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
            $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
            unset($goodsSubCatslist);
        }
        $newsCatList = $this->articleCatsModel->queryByList(32);
        $adsList = $this->adsModel->queryByList(-1);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        //var_dump($adsList);exit;
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('newsCatList', $newsCatList);
        $this->assign('adsList', $adsList);
        $this->assign('recommGoodsList', $recommGoodsList);
        $this->display('home');
    }
    public function aboutUs(){
        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        foreach ($goodsCatslist as $k=>$v){
            $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
            $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
            unset($goodsSubCatslist);
        }
        $newsCatList = $this->articleCatsModel->queryByList(32);
        $adsList = $this->adsModel->queryByList(1);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        //var_dump($adsList);exit;
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('newsCatList', $newsCatList);
        $this->assign('adsList', $adsList);
        $this->assign('recommGoodsList', $recommGoodsList);
        $this->display('aboutus');
    }
    public function service(){
        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        foreach ($goodsCatslist as $k=>$v){
            $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
            $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
            unset($goodsSubCatslist);
        }
        $newsCatList = $this->articleCatsModel->queryByList(32);
        $adsList = $this->adsModel->queryByList(3);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        //var_dump($adsList);exit;
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('newsCatList', $newsCatList);
        $this->assign('adsList', $adsList);
        $this->assign('recommGoodsList', $recommGoodsList);
        $this->display('service');
    }
    public function support(){
        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        foreach ($goodsCatslist as $k=>$v){
            $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
            $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
            unset($goodsSubCatslist);
        }
        $newsCatList = $this->articleCatsModel->queryByList(32);
        $adsList = $this->adsModel->queryByList(2);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        //var_dump($adsList);exit;
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('newsCatList', $newsCatList);
        $this->assign('adsList', $adsList);
        $this->assign('recommGoodsList', $recommGoodsList);
        $this->display('support');
    }
    public function index3() {

    	$articleMap['title|content'] = array('LIKE', '%' . I('get.kw') . '%');
        $articleList = $this->articleModel->getListbyAll($order = 'uTime DESC', $articleMap);
        $this->ajaxReturn($articleList);

    }
    /* 
     *  查询 
     */
    public function search() {
        $searchWords = array('LIKE', '%' . I('post.kw') . '%');
        $goodsCatsMap['catName'] = $searchWords;
        $goodsMap['goodsName'] =  $searchWords;
        $goodsCat = $this->goodsCatsModel->searchByName($goodsCatsMap);
        if (!empty($goodsCat)){
            if ($goodsCat['parentId'] == 0){
                $goodsCatDetail = $this->goodsCatsModel->queryByList($goodsCat['catId']);
                $goodsList =$this->goodsModel->getGoodsByPid($goodsCatDetail[0]['catId']);
            }else {
                $goodsList =$this->goodsModel->getGoodsByPid($goodsCat['catId']);
            }
            $catName = $goodsCat['catName'];
            $goodsCatslist = $this->goodsCatsModel->queryByList($goodsCat['catId']);
            $nav = $this->goodsCatsModel->queryByList(0);
            foreach ($nav as $k=>$v){
                $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
                $nav[$k]['goodsSubCatslist'] = $goodsSubCatslist;
                unset($goodsSubCatslist);
            }
            $this->assign('goodsCatDetail', $goodsCatslist);
            $this->assign('goodsCatslist', $nav);
            $this->assign('catName', $catName);
            $this->assign('goodsList', $goodsList);
            $this->display('Product/tele');
        }else{
            $goodsDetail = $this->goodsModel->getDetailByName($goodsMap);
            if (!empty($goodsDetail)){
                $goodsCatslist = $this->goodsCatsModel->queryByList(0);
                foreach ($goodsCatslist as $k=>$v){
                    $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
                    $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
                    unset($goodsSubCatslist);
                }
                $goodsImgs = $this->goodsModel->getGoodsImgsById($goodsDetail['goodsId']);
                $this->assign('goodsCatslist', $goodsCatslist);
                $this->assign('goodsDetail', $goodsDetail);
                $this->assign('goodsImgs', $goodsImgs);
                $this->display('Product/telecont');
            }else {
                $this->error('find nothing!');
            }
            
        }
        
    
    }

}

?>