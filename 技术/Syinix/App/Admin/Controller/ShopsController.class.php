<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 店铺控制器
* @date: 2015年10月22日 下午4:16:16
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class ShopsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
		//获取商品分类信息
		//$m = D('Admin/GoodsCats');
		//$this->assign('goodsCatsList',$m->queryByList());
		//获取地区信息
		$m = D('Admin/Areas');
		$areaList = $m->queryShowByList(0);
		
		$this->assign('areaList',$areaList);
		//获取银行列表
		$m = D('Admin/Staffs');
		$this->assign('userList',$m->getMemberListByAll());
		//获取商品信息
	    $m = D('Admin/Shops');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('ppgl_02');
    		$object = $m->get();
    	}else{
    		//$this->checkPrivelege('ppgl_01');
    		$object = $m->getModel2();
    	}
    	$this->assign('object',$object);
    	$this->assign('src',I('src','index'));
		$this->view->display('edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/Shops');
    	$rs = array();
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('ppgl_02');
    		$rs = $m->editShops(I('id',0));
    	}else{
    		//$this->checkAjaxPrivelege('ppgl_01');
    		$rs = $m->insertShops();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('ppgl_03');
		$m = D('Admin/Shops');
    	$rs = $m->delShops($_GET['id']);
    	$this->ajaxReturn($rs);
	}
   /**
	 * 查看
	 */
	public function toView(){
		//$this->isLogin();
		//$this->checkPrivelege('ppgl_00');
		$m = D('Admin/Shops');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
		}
		$this->view->display('view');
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isLogin();
		//$this->checkPrivelege('ppgl_00');
		//获取地区信息
		$m = D('Admin/Shops');
		$searchArr = $this->searchKeywords();
    	$page = $m->queryByPage($searchArr,$_POST['pageCurrent'],$_POST['pageSize']);
    	/* $pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    	$page['pager'] = $pager->show(); */
    	//var_dump($page);exit;
    	$this->assign('Page',$page);
    	$this->assign('search', $searchArr);
    	$this->assign('total',$page['total']);
        $this->display("list");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	//$this->isAjaxLogin();
		$m = D('Admin/Shops');
		$list = $m->queryList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 获取待审核的店铺数量
	 */
	public function queryPenddingGoodsNum(){
		$this->isAjaxLogin();
    	$m = D('Admin/Shops');
    	$rs = $m->queryPenddingShopsNum();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 列表查询[获取启用的区域信息]
	 */
	public function queryShowByList(){
	    $m = D('Admin/areas');
	    //var_dump(2);exit;
	    $list = $m->queryShowByList(I('parentId'));
	    $rs = array();
	    $rs['status'] = 1;
	    $rs['list'] = $list;
	    $this->ajaxReturn($rs);
	}
};
?>