<?php
 /**
 * Copyright @ 2013 Infinix. All rights reserved.
 * ==============================================
 * @Description :角色控制器
 * @date: 2015年10月30日 下午5:22:27
 * @author: yanhui.chen
 * @version:
 */
namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;
class RoleController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
	    $m = D('Admin/Role');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('jsgl_02');
    		$object = $m->get(I('id',0));
    	}else{
    		//$this->checkPrivelege('jsgl_01');
    		$object = $m->getModel2();
    	}
    	
    	$this->assign('info',$object);
		$this->view->display('editRole');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/Role');
    	$rs = array();
    	if(I('id',0)>0){
    		$rs = $m->editRole();
    	}else{
    		$rs = $m->insertRole();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('jsgl_03');
		$m = D('Admin/Role');
    	$rs = $m->delRole($_GET['id']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isLogin();
		//$this->checkPrivelege('jsgl_00');
		$m = D('Admin/Role');
		$condition = $this->searchCondition();
		$list = $m->roleList($condition);
    	/* $page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    	$page['pager'] = $pager->show(); */
    	$this->assign('Page',$list);
    	$this->assign('total',$list['total']);
        $this->display("roleList");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
        //$this->isAjaxLogin();
		$m = D('Admin/Role');
		$list = $m->queryList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
};
?>