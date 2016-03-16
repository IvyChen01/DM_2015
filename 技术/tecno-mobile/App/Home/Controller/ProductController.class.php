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
        $this->goodsCatsModel = D('Admin/GoodsCats');
        $this->adsModel = D('Admin/Ads');
        $this->goodsModel = D('Admin/goods');
        $this->articleCatsModel = D('Admin/ArticleCats');
    }


    public function index() {
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        $this->assign('articleCatList', $articleCatList);
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        $goodsList = $this->goodsModel->queryByListlang($lang);
        //var_dump($goodsList);exit;
        $this->assign('goodsList', $goodsList);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->display('products');
    }
    


     /* public function _before_detail() {

        $condition['id'] = I('get.cid');
        var_dump($condition['id']);exit;
        $this->model->toSetInc($param = array('modelName' => 'Article'), 'visitNums', 1, $condition);
    }  */

    public function goodsCatDetail() {
        $id = I('get.cid');
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        $this->assign('articleCatList', $articleCatList);
        $goodsList = $this->goodsModel->getGoodsByPid($id,$lang);
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('goodsList', $goodsList);
        $this->assign('id',$id);
        $this->display('products');
    }

    public function getGoodsDetail() {
        $goodsId = I('get.goodsId');
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $goodsDetail = $this->goodsModel->getGoodsDetailById($goodsId);
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        $goodsImgs = $this->goodsModel->getGoodsImgsById($goodsId);
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        $this->assign('articleCatList', $articleCatList);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('goodsImgs', $goodsImgs);
        $this->assign('goodsDetail', $goodsDetail);
        $this->display('products_contact');
    }
	    //获取对比产品数据
    public function comparedetails(){
        $ids = I('selsected');
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        foreach ($ids as $k=>$v){
            $goodsDetail[$k] = $this->goodsModel->getGoodsDetailById($v);
        }
        $this->ajaxReturn($goodsDetail);
        
    }

}

?>