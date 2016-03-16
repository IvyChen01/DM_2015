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
        $this->articleModel = D('Admin/Article');
        $this->areasModel = D('Admin/Areas');
        $this->shopModel = D('Admin/Shops');
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
        $articleList = $this->articleModel->getListByCidlang(38,$lang);
        foreach ($articleList['info'] as $key=>$value){
            $articleList['info'][$key]['day'] = date('j',$value['cTime']);
            $articleList['info'][$key]['mon'] = date('M',$value['cTime']);
            $articleList['info'][$key]['year'] = date('y',$value['cTime']);
        }
        $articleList2 = $this->articleModel->getListByCidlang(39,$lang);
        $articleList3 = $this->articleModel->getListByCidlang(40,$lang);
        $adsList = $this->adsModel->queryByList(-1);
        $recommGoodsList = $this->goodsModel->getRecommGoodslang($lang);
        
        $articleCatList = $this->articleCatsModel->getCatListslang($lang);
        
        //import('ORG.Net.IpLocation');// 导入IpLocation类
       /*  $ip2 = get_client_ip();
       require_once(WEB_ROOT.'./Thinkphp/Library/Org/Net/geoipcity.inc');
       $ipdatafile = WEB_ROOT.'./Thinkphp/Library/Org/Net/GeoLiteCity.dat';
       $gi = geoip_open($ipdatafile,GEOIP_STANDARD);
       //$ip = getIPaddress();
       $record= geoip_record_by_addr($gi, '41.234.81.221'); */
       //var_dump($record);exit;
       // $Ip = new \Org\Net\IpLocation('UTFWry.dat');  // 实例化类 参数表示IP地址库文件
        //$area = $Ip->getlocation('197.211.52.19');
        //header("Content-type:text/html;charset=utf-8"); // 获取某个IP地址所在的位置
        //var_dump($adsList);exit;
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->assign('articleList', $articleList['info']);
        $this->assign('articleList2', $articleList2['info']);
        $this->assign('articleList3', $articleList3['info']);
        $this->assign('adsList', $adsList);
        $this->assign('articleCatList', $articleCatList);
        $this->assign('recommGoodsList', $recommGoodsList);
        $this->display('home');
    }
    public function contact(){
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
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->display('contact');
    }
    public function service(){
        if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
        $goodsCatslist = $this->goodsCatsModel->queryByListlang(0,$lang);
        
        $areaList = $this->areasModel->queryShowByList(0);
		$shopList = $this->shopModel->queryByListlang($lang);
		$articleCatList = $this->articleCatsModel->getCatListslang($lang);
		$this->assign('articleCatList', $articleCatList);
		$this->assign('areaList',$areaList);
		$this->assign('shopList',$shopList);
        $this->assign('goodsCatslist', $goodsCatslist);
        $this->display('experience');
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
/**
	 * 列表查询[获取启用的区域信息]
	 */
	public function queryShowByList(){
	    $m = D('Admin/areas');
	    $parentId = I('parentId',0)?I('parentId',0):0;
	    $list = $m->queryShowByList($parentId);
	    $rs = array();
	    $rs['status'] = 1;
	    $rs['list'] = $list;
	    $this->ajaxReturn($rs);
	}
	/**
	 * 列表查询[获取启用的区域信息]
	 */
	public function queryShopList(){
	    $m = D('Admin/areas');
	    $list = $m->queryShowByList(I('parentId',0));
	    $rs = array();
	    $rs['status'] = 1;
	    $rs['list'] = $list;
	    $this->ajaxReturn($rs);
	}
	public function queryShopListById(){
	    if (LANG_SET=='ar-aa'){
            $lang = 2;
        }elseif (LANG_SET=='fr-fr'){
            $lang = 1;
        }else {
            $lang=0;
        }
	    $m = D('Admin/Shops');
	    $list = $m->queryShopListById(I('areaId',0),$lang);
	    $rs = array();
	    $rs['status'] = 1;
	    $rs['list'] = $list;
	    $this->ajaxReturn($rs);
	}
}

?>