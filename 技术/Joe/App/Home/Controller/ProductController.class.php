<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 产品控制器
* @date: 2015年11月4日 上午11:28:42
* @author: yanhui.chen
* @version:
*/
namespace Home\Controller;

use Think\Controller;

class ProductController extends CommonController {

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
        $this->productModel = D('Admin/goods');
        $this->goodsCatsModel = D('Admin/GoodsCats');
        $this->adsModel = D('Admin/Ads');
        $this->goodsModel = D('Admin/goods');
    }


    public function index() {

        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        //$newsCatList = $this->articleCatsModel->queryByList(32);
        $adsList = $this->adsModel->queryByList(0);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        $this->assign('goodsCatslist', $goodsCatslist);
        //$this->assign('newsCatList', $newsCatList);
        $this->assign('adsList', $adsList);
        $this->display('products');
    }
    


     /* public function _before_detail() {

        $condition['id'] = I('get.cid');
        var_dump($condition['id']);exit;
        $this->model->toSetInc($param = array('modelName' => 'Article'), 'visitNums', 1, $condition);
    }  */

    public function goodsCatDetail() {
        $id = I('get.cid');
        //$randList = $this->model->getRandList();
        $falg = false;
        $goodsCatDetail = $this->goodsCatsModel->queryByList($id)?$this->goodsCatsModel->queryByList($id):$this->goodsCatsModel->getParentById($id);
        //var_dump($goodsCatDetail);
        if ($goodsCatDetail[0]['parentId'] != $id){
            $catId = $id;
        }else{
            $catId = $goodsCatDetail[0]['catId'];
        }
		//
        //$catId = $goodsCatDetail[0]['catId']?$goodsCatDetail[0]['catId']:$id;
        if ($goodsCatDetail[0]['parentId']!=$id){
            $goodsCat = $this->goodsCatsModel->get($id);
            $catName = $goodsCat['catName'];
        }else{
            $catName = $goodsCatDetail[0]['catName'];
        }
        $goodsList =$this->productModel->getGoodsByPid($catId);
		//var_dump($goodsList);exit;
        /* foreach ($goodsList as $k=>$v){
            $goodsList[$k]['goodsSpec'] = strip_tags($v['goodsSpec']);
        } */
        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        foreach ($goodsCatslist as $k=>$v){
            $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
            $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
            unset($goodsSubCatslist);
        }
        $adsList = $this->adsModel->queryByList($id);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        
        $this->assign('goodsCatslist', $goodsCatslist);
       
        $this->assign('adsList', $adsList);
         
        $this->assign('goodsCatDetail', $goodsCatDetail);
        $this->assign('goodsList', $goodsList);
        $this->assign('catName', $catName);
        $this->assign('id', $id);
        
        $this->display('tele');
    }

    public function getGoodsDetail() {
        $goodsId = I('get.goodsId');
        //$goodsDetail = $this->productModel->getGoodsById($goodsId);
        //$condition['id'] = I('get.goodsId');
        $goodsDetail = $this->goodsModel->getGoodsDetailById($goodsId);
        $goodsCatslist = $this->goodsCatsModel->queryByList(0);
        foreach ($goodsCatslist as $k=>$v){
            $goodsSubCatslist = $this->goodsCatsModel->queryByList($v['catId']);
            $goodsCatslist[$k]['goodsSubCatslist'] = $goodsSubCatslist;
            unset($goodsSubCatslist);
        }
        $goodsImgs = $this->goodsModel->getGoodsImgsById($goodsId);
		foreach ($goodsImgs as $k=>$img){
            $imginfo = getimagesize($img['goodsImg']);
            if ($imginfo && $imginfo[0] < 900){
                $mobImg[] = $goodsImgs[$k];
				unset($goodsImgs[$k]);
            }
        }
        $adsList = $this->adsModel->queryByList(-1);
        $recommGoodsList = $this->goodsModel->getRecommGoods();
        
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('goodsImgs', $goodsImgs);
		$this->assign('goodsMobImgs', $mobImg);
        $this->assign('adsList', $adsList);
        $this->assign('goodsDetail', $goodsDetail);
        //var_dump($goodsDetail);exit;
        $this->display('telecont');
    }

}

?>