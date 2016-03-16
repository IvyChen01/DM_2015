<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 广告管理
* @date: 2015年10月28日 下午5:36:36
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class AdsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
		//获取地区信息
		/* $m = D('Admin/district');
		$this->assign('areaList',$m->queryShowByList(0)); */
		//获取商品分类
		$m = D('Admin/GoodsCats');
		
		$this->assign('goodsCatList',$m->category());
	    $m = D('Admin/Ads');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('gggl_02');
    		$object = $m->get();
    	}else{
    		//$this->checkPrivelege('gggl_01');
    		$object = $m->getModel2();
    		$object['adStartDate'] = date('Y-m-d');
    		$object['adEndDate'] = date('Y-m-d');
    	}
    	$this->assign('object',$object);
		$this->view->display('edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/Ads');
    	$rs = array();
    	//var_dump(I('id',0));exit;
    	if(I('id',0)>0){
    	   
    		//$this->checkAjaxPrivelege('gggl_02');
    		$rs = $m->editAds();
    	}else{
    		//$this->checkAjaxPrivelege('gggl_01');
    		$rs = $m->insertAds();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('gggl_03');
		$m = D('Admin/Ads');
    	$rs = $m->delAds($_GET['id']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isLogin();
		//$this->checkAjaxPrivelege('gggl_00');
		//self::WSTAssigns();
		//获取商品分类
	    
	    $m = D('Admin/Ads');
	    $gm = D('Admin/GoodsCats');
	    $condition = $this->searchCondition();
	    $goodsCatList = $gm->category();
	    $list = $m->adsList($condition);
	    $this->assign('goodsCatList',$goodsCatList);
	    $this->assign('search', $this->searchKeywords());
	    $this->assign('total', $list['total']);
	    $this->assign('list', $list['info']);
        $this->display("list");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	$this->isAjaxLogin();
		$m = D('Admin/Ads');
		$list = $m->queryByList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
};
?>