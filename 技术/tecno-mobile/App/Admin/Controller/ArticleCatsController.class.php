<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :文章栏目控制器
* @date: 2015年10月9日 上午10:45:53
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;
class ArticleCatsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
	    $m = D('Admin/ArticleCats');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('wzfl_02');
    		$object = $m->get();
    	}else{
    		//$this->checkPrivelege('wzfl_01');
    		$object = $m->getModel2();
    		$object['parentId'] = I('parentId',0);
    	}
    	$this->assign('object',$object);
		$this->view->display('add');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/ArticleCats');
    	$rs = array();
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('wzfl_02');
    		$rs = $m->editCats(I('id',0));
    	}else{
    		//$this->checkAjaxPrivelege('wzfl_01');
    		$rs = $m->insertCats();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 修改名称
	 */
	public function editName(){
		//$this->isAjaxLogin();
		$m = D('Admin/ArticleCats');
    	$rs = array('status'=>-1);
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('wzfl_02');
    		$rs = $m->editName();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 修改名称
	 */
	public function editSort(){
	    //$this->isAjaxLogin();
	    $m = D('Admin/ArticleCats');
	    $rs = array('status'=>-1);
	    if(I('id',0)>0){
	        //$this->checkAjaxPrivelege('wzfl_02');
	        $rs = $m->editSort();
	    }
	    $this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('wzfl_03');
		$m = D('Admin/ArticleCats');
		$id = $_GET['id']?$_GET['id']:$_POST['id'];
    	$rs = $m->delCats($id);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isLogin();
		//$this->checkPrivelege('wzfl_00');
	    /* if (IS_POST) {
	        $this->ajaxReturn(D("ArticleCats")->category());
	    } else {
	        $this->assign("list", D("ArticleCats")->category());
	        $this->display();
	    } */
		$m = D('Admin/ArticleCats');
    	$list = $m->category();
        $this->assign("list", $m->category());
    	$this->assign('total',count($list));
        $this->display("index");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	//$this->isAjaxLogin();
		$m = D('Admin/ArticleCats');
		$list = $m->queryByList(I('id',0));
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 显示分类是否显示/隐藏
	 */
	 public function editiIsShow(){
	 	//$this->isAjaxLogin();
	 	//$this->checkAjaxPrivelege('wzfl_02');
	 	$m = D('Admin/ArticleCats');
		$rs = $m->editiIsShow();
		$this->ajaxReturn($rs);
	 }

};
?>