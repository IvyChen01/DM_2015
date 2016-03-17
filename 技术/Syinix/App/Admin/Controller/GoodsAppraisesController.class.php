<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品评价控制器
* @date: 2015年11月17日 上午11:37:13
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class GoodsAppraisesController extends CommonController{
	
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		$m = D('Admin/Goods_appraises');
    	$rs = $m->delAppraises();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 跳到编辑界面
	 */
	public function toEdit(){
		//$this->isLogin();
		$m = D('Admin/Goods_appraises');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
		}
		$this->view->display('edit');
	}
	/**
	 * 修改商品评价
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/Goods_appraises');
    	$rs = $m->editAppraises();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		//$this->isLogin();
		//获取地区信息
		/* $m = D('Admin/Areas');
		$this->assign('areaList',$m->queryShowByList(0)); */
		$m = D('Admin/Goods_appraises');
		$searchArr = $this->searchKeywords();
		$list = $m->queryByPage($searchArr,$_POST['pageCurrent'],$_POST['pageSize']);
		
    	/* $page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);
    	$page['pager'] = $pager->show(); */
    	$this->assign('Page',$list);
    	/* $this->assign('areaId1',I('areaId1',0));
    	$this->assign('areaId2',I('areaId2',0)); */
    	$this->assign('search', $searchArr);
    	$this->assign('total',$list['total']);
        $this->display("list");
	}
};
?>