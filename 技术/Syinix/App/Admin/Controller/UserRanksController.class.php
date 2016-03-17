<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :会员等级控制器
* @date: 2015年10月8日 下午3:30:14
* @author: yanhui.chen
* @version:
*/
 namespace Admin\Controller;
 
 use Think\Controller;
 use Common\Controller\CommonController;
class UserRanksController extends CommonController{
    /**
     +----------------------------------------------------------
     * 初始化
     +----------------------------------------------------------
     */
    public function _initialize() {
        parent::_initialize();
        $this->model = D('UserRanks');
    }
    /**
     * 会员等级列表
     */
    public function index() {
        $condition = $this->searchCondition();
        $list = $this->model->userRanksList($condition);
        $this->assign('search', $this->searchKeywords());
        $this->assign('total', $list['total']);
        $this->assign('list', $list['info']);
        //$this->assign('list', $list);
        $this->display();
    }
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
	    $m = D('Admin/UserRanks');
    	$info = array();
    	if(I('rankId',0)>0){
    		//$this->checkPrivelege('hydj_02');
    		$info = $m->get(I('rankId',0));
    	}else{
    		//$this->checkPrivelege('hydj_01');
    		$info = $m->getModel2();
    		//var_dump($info);exit;
    	}
    	$this->assign('info',$info);
		$this->display('addRank');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/UserRanks');
    	$rs = array();
    	if(I('rankId',0)>0){
    		//$this->checkAjaxPrivelege('hydj_02');
    		$rs = $m->editRanks(I('rankId',0));
    	}else{
    		//$this->checkAjaxPrivelege('hydj_01');
    		$rs = $m->insertRanks();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('hydj_03');
		$m = D('Admin/UserRanks');
    	$rs = $m->delRanks($_GET['rankId']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	/* public function index(){
		$this->isLogin();
		$this->checkPrivelege('hydj_00');
		$m = D('Admin/UserRanks');
    	$page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
        $this->display("/userranks/list");
	} */
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	$this->isAjaxLogin();
		$m = D('Admin/UserRanks');
		$list = $m->queryByList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
};
?>