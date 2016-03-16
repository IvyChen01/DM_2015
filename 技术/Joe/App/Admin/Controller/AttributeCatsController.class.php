<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品分类属性
* @date: 2015年11月11日 下午2:05:58
* @author: yanhui.chen
* @version:
*/
 namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class AttributeCatsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		$this->isShopLogin();
	    $m = D('Home/AttributeCats');
    	$object = array();
    	if(I('id',0)>0){
    		$object = $m->get();
    	}else{
    		$object = $m->getModel2();
    	}
    	$this->assign('object',$object);
    	$this->assign('umark',"AttributeCats");
		$this->view->display('default/shops/attributecats/edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		$this->isShopAjaxLogin();
		$m = D('Home/AttributeCats');
    	$rs = array();
    	if(I('id',0)>0){
    		$rs = $m->editAttrCats();
    	}else{
    		$rs = $m->insertAttrCats();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		$this->isShopAjaxLogin();
		$m = D('Home/AttributeCats');
    	$rs = $m->delAttrCats();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isShopLogin();
		$m = D('Home/AttributeCats');
		$list = $m->queryByList();
    	$this->assign('List',$list);
    	$this->assign('umark',"AttributeCats");
        $this->display("attributecats/list");
	}
	
	/**
	 * 获取属性分类列表
	 */
	public function queryByList(){
		//获取商品属性分类信息
		$m = D('Home/AttributeCats');
		$list = $m->queryByList();
		$rs = array('status'=>1,'list'=>$list);
    	$this->ajaxReturn($rs);
	}
};
?>