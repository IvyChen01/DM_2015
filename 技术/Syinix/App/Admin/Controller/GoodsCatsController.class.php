<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品分类控制器
* @date: 2015年10月12日 上午10:17:00
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class GoodsCatsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
	    $m = D('Admin/GoodsCats');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('spfl_02');
    		$object = $m->get(I('id',0));
    	}else{
    		//$this->checkPrivelege('spfl_01');
    		if(I('parentId',0)>0){
    		   $object = $m->get(I('parentId',0));
    		   $object['parentId'] = $object['catId'];
    		   $object['catName'] = '';
    		   $object['catSort'] = 0;
    		   $object['catId'] = 0;
    		}else{
    		   $object = $m->getModel2();
    		}
    	}
    	
    	$this->assign("list", $m->category());
    	$this->assign('object',$object);
		$this->view->display('add');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/GoodsCats');
    	$rs = array();
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('spfl_02');
    		$rs = $m->editGoodsCats();
    	}else{
    		//$this->checkAjaxPrivelege('spfl_01');
    		$rs = $m->insertGoodsCats();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 修改名称
	 */
	public function editName(){
		//$this->isAjaxLogin();
		$m = D('Admin/GoodsCats');
    	$rs = array('status'=>-1);
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('spfl_02');
    		$rs = $m->editName();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 修改名称
	 */
	public function editSort(){
	    //$this->isAjaxLogin();
	    $m = D('Admin/GoodsCats');
	    $rs = array('status'=>-1);
	    if(I('id',0)>0){
	        $rs = $m->editSort();
	    }
	    $this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		$m = D('Admin/GoodsCats');
    	$rs = $m->delGoodsCats($_GET['id']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$m = D('Admin/GoodsCats');
    	$list = $m->category();
    	$this->assign("list", $list);
    	$this->assign('total',count($list));
        $this->display("index");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	//$this->isAjaxLogin();
		$m = D('Admin/GoodsCats');
		$list = $m->queryByList(I('id'));
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 显示商品是否显示/隐藏
	 */
	 public function editIsShow(){
	 	//$this->isAjaxLogin();
	 	//$this->checkAjaxPrivelege('spfl_02');
	 	$m = D('Admin/GoodsCats');
		$rs = $m->editIsShow();
		$this->ajaxReturn($rs);
	 }
};
?>