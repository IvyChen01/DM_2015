<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :导航控制器
* @date: 2015年10月28日 下午6:41:06
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class NavsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
		//获取地区信息
		$m = D('Admin/Areas');
		$this->assign('areaList',$m->queryShowByList(0));
		//获取商品分类
		$m = D('Admin/GoodsCats');
		$this->assign('goodsCatList',$m->queryByList(0));
	    $m = D('Admin/Navs');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('dhgl_02');
    		$object = $m->get();
    	}else{
    		//$this->checkPrivelege('dhgl_03');
    		$object = $m->getModel();
    	}
    	$this->assign('object',$object);
		$this->view->display('edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/Navs');
    	$rs = array();
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('dhgl_02');
    		$rs = $m->edit();
    	}else{
    		//$this->checkAjaxPrivelege('dhgl_01');
    		$rs = $m->insert();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('dhgl_03');
		$m = D('Admin/Navs');
    	$rs = $m->del();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isLogin();
		//$this->checkAjaxPrivelege('dhgl_00');
		$m = D('Admin/Navs');
    	$page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
    	$a = D('Admin/District');
    	$this->assign('areaList',$a->queryShowByList(0));
    	$this->assign('areaId1',I('areaId1'));
    	$this->assign('areaId2',I('areaId2'));
        $this->display("list");
	}
	/**
	 * 是否显示/隐藏
	 */
	 public function editiIsShow(){
	 	$this->isAjaxLogin();
	 	$this->checkAjaxPrivelege('dhgl_02');
	 	$m = D('Admin/Navs');
		$rs = $m->editiIsShow();
		$this->ajaxReturn($rs);
	 }
    /**
	 * 是否新窗口打开
	 */
	 public function editiIsOpen(){
	 	$this->isAjaxLogin();
	 	$this->checkAjaxPrivelege('dhgl_02');
	 	$m = D('Admin/Navs');
		$rs = $m->editiIsOpen();
		$this->ajaxReturn($rs);
	 }
};
?>