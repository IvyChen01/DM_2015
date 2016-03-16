<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品控制器
* @date: 2015年10月12日 上午10:15:36
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class GoodsController extends CommonController{
    /**
     * 跳到新增/编辑商品
     */
    public function toEdit(){
        //$this->isShopLogin();
        //$USER = session('WST_USER');
        //获取商品分类信息
        $m = D('GoodsCats');
        $this->assign('goodsCatsList',$m->queryByList());
        /* //获取商家商品分类
        $m = D('ShopsCats');
        $this->assign('shopCatsList',$m->queryByList($USER['shopId'],0)); */
       /*  //获取商品类型
        $m = D('Home/AttributeCats');
        $this->assign('attributeCatsCatsList',$m->queryByList()); */
        $m = D('Goods');
        $object = array();
        if(I('id',0)>0){
            $object = $m->get();
            
        }else{
            $object = $m->getModel2();
        }
        $this->assign('object',$object);
        $this->display("add");
    }
    /**
     * 编辑/添加商品
     */
    public function edit(){
        //$this->isShopLogin();
        $m = D('Goods');
        $rs = array();
        if(I('id',0)>0){
            $rs = $m->editGoods();
        }else{
            $rs = $m->insertGoods();
        }
        $this->ajaxReturn($rs);
    }
    /**
     * 删除商品
     */
    public function del(){
        //$this->isShopLogin();
        $m = D('Goods');
        $rs = $m->delGoods($_GET['id']);
        $this->ajaxReturn($rs);
    }
    /**
     * 批量删除商品
     */
    public function batchDel(){
        //$this->isShopLogin();
        $m = D('Admin/Goods');
        $rs = $m->batchDel($_GET['ids']);
        $this->ajaxReturn($rs);
    }
   /**
	 * 查看
     */
	public function toView(){
		//$this->isLogin();
		$m = D('Admin/Goods');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
		}else{
			die("商品不存在!");
		}
		$this->view->display('view');
	}
    /**
	 * 查看
	 */
	public function toPenddingView(){
		//$this->isLogin();
		$m = D('Admin/Goods');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
			//获取商品分类信息
			$m = D('Admin/GoodsCats');
			$this->assign('goodsCatsList',$m->queryByList());
			//获取商家商品分类
			$m = D('Admin/ShopsCats');
			$this->assign('shopCatsList',$m->queryByList($object['shopId'],0));
		}else{
			die("商品不存在!");
		}
		$this->view->display('view_pendding');
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//获取地区信息
		$m = D('Admin/Areas');
		/* $this->assign('areaList',$m->queryShowByList(0)); */
		$m = D('Admin/Goods');
		
		$search = $_POST['goodsName'];
		
		if (empty($_POST['pageCurrent'])){
            $pageCurrent = 1;
            session('pageCurrent',1);
        }else {
            $pageCurrent = $_POST['pageCurrent'];
        }
        if (empty($_POST['pageSize'])){
            $pageSize = 20;
            session('pageSize',20);
        }else {
            $pageSize = $_POST['pageSize'];
        }
        $page = $m->queryByPage($search, $pageCurrent, $pageSize);
    	foreach ($page['info'] as $k=>$v){
    	    $gc = D('Admin/GoodsCats');
    	    $catName1 = $gc->get($v['goodsCatId1']);
    	    $page['info'][$k]['catName'] = $catName1['catName'];
    	    if (!empty($v['goodsCatId2'])){
    	        $catName2 = $gc->get($v['goodsCatId2']);
    	        $page['info'][$k]['catName'] .= '_'.$catName2['catName'];
    	        if (!empty($v['goodsCatId3'])){
    	            $catName3 = $gc->get($v['goodsCatId3']);
    	            $page['info'][$k]['catName'] .= '_'.$catName3['catName3'];
    	        }
    	    }
    	}
    	$this->assign('Page',$page);
    	$this->assign('shopName',I('shopName'));
    	$this->assign('goodsName',I('goodsName'));
    	$this->assign('areaId1',I('areaId1',0));
    	$this->assign('areaId2',I('areaId2',0));
    	$this->assign('total', $page['total']);
        $this->display("list");
	}
    /**
	 * 分页查询
	 */
	public function queryPenddingByPage(){
		//$this->isLogin();
		$this->checkPrivelege('spsh_00');
		//获取地区信息
		$m = D('Admin/Areas');
		$this->assign('areaList',$m->queryShowByList(0));
		$m = D('Admin/Goods');
    	$page = $m->queryPenddingByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    	$pager->setConfig('header','个会员');
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
    	$this->assign('shopName',I('shopName'));
    	$this->assign('goodsName',I('goodsName'));
    	$this->assign('areaId1',I('areaId1',0));
    	$this->assign('areaId2',I('areaId2',0));
        $this->display("list_pendding");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	//$this->isAjaxLogin();
		$m = D('Admin/Goods');
		$list = $m->queryByList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 列表查询[获取启用的区域信息]
	 */
    public function queryShowByList(){
    	//$this->isAjaxLogin();
		$m = D('Admin/Goods');
		$list = $m->queryShowByList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
	/**
	 * 修改待审核商品状态
	 */
	public function changePenddingGoodsStatus(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('spsh_04');
		$m = D('Admin/Goods');
		$rs = $m->changeGoodsStatus();
		$this->ajaxReturn($rs);
	}
    /**
	 * 修改商品状态
	 */
	public function changeGoodsStatus(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('splb_04');
		$m = D('Admin/Goods');
		$rs = $m->changeGoodsStatus();
		$this->ajaxReturn($rs);
	}
    /**
	 * 获取待审核的商品数量
	 */
	public function queryPenddingGoodsNum(){
		//$this->isAjaxLogin();
    	$m = D('Admin/Goods');
    	$rs = $m->queryPenddingGoodsNum();
    	$this->ajaxReturn($rs);
	}
    /**
	 * 批量设置精品
	 */
	public function changeBestStatus(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('splb_04');
		$m = D('Admin/Goods');
		$rs = $m->changeBestStatus($_GET['ids']);
		$this->ajaxReturn($rs);
	}
	/**
	 * 批量设置精品
	 */
	public function changeBestStatusN(){
	    //$this->isAjaxLogin();
	    //$this->checkAjaxPrivelege('splb_04');
	    $m = D('Admin/Goods');
	    $rs = $m->changeBestStatusN($_GET['ids']);
	    $this->ajaxReturn($rs);
	}
    /**
	 * 批量设置推荐
	 */
	public function changeRecomStatus(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('splb_04');
		$m = D('Admin/Goods');
		$rs = $m->changeRecomStatus($_GET['ids']);
		$this->ajaxReturn($rs);
	}
	/**
	 * 批量设置推荐
	 */
	public function changeRecomStatusN(){
	    //$this->isAjaxLogin();
	    //$this->checkAjaxPrivelege('splb_04');
	    $m = D('Admin/Goods');
	    $rs = $m->changeRecomStatusN($_GET['ids']);
	    $this->ajaxReturn($rs);
	}
	/**
	 * 批量设置推荐
	 */
	public function unSale(){
	    //$this->isAjaxLogin();
	    //$this->checkAjaxPrivelege('splb_04');
	    $m = D('Admin/Goods');
	    $rs = $m->unSale($_GET['ids']);
	    $this->ajaxReturn($rs);
	}
	
};
?>