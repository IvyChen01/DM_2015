<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品属性控制器
* @date: 2015年11月11日 下午2:07:52
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class AttributesController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isShopLogin();
		
	    $m = D('Attributes');
    	$object = array();
    	if(I('id',0)>0){
    		$object = $m->get(I('id',0));
    	}else{
    		$object = $m->getModel2();
    		$object['catId'] = (int)I('catId');
    	}
    	$m = D('Admin/GoodsCats');
		$this->assign('goodsCatList',$m->queryByList(0));
    	$this->assign('object',$object);
		$this->view->display('Attributes/edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isShopAjaxLogin();
		$m = D('Attributes');
    	$rs = array();
    	$rs = $m->editAttr(I('id',0));
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isShopAjaxLogin();
		$m = D('Attributes');
    	$rs = $m->delAttr($_GET['id']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isShopLogin();
		$m = D('Admin/GoodsCats');
		$this->assign('goodsCatList',$m->queryByList(0));
		$m = D('Attributes');
    	//$list = $m->queryByPage();
    	$searchArr = $this->searchKeywords();
    	if ($searchArr['catId']>0){
    	    $list = $m->queryByPage($searchArr,$_POST['pageCurrent'],$_POST['pageSize']);
    	}else {
    	    $condition = $this->searchCondition();
    	    $list = $m->attrList($condition);
    	}
    	
    	$this->assign('list',$list['info']);
    	$this->assign('total',$list['total']);
        $this->display("list");
	}
	
	/**
	 * 获取列表
	 */
	public function getAttributes(){
		$m = D('Attributes');
    	$list = $m->queryByListForGoods();
    	$rs = array('status'=>1,'list'=>$list);
    	$this->ajaxReturn($rs);
	}
};
?>