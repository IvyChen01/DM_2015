<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :品牌管理器
* @date: 2015年10月12日 上午10:18:53
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class BrandsController extends CommonController{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		//$this->isLogin();
		//获取品牌
		$m = D('Admin/GoodsCats');
    	$cats = $m->queryByList(0);
    	$this->assign('cats',$cats);
	    $m = D('Admin/Brands');
    	$object = array();
    	if(I('id',0)>0){
    		//$this->checkPrivelege('ppgl_02');
    		$object = $m->get(I('id',0));
    	}else{
    		//$this->checkPrivelege('ppgl_01');
    		$object = $m->getModel2();
    	}
    	$this->assign('object',$object);
		$this->view->display('add');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		//$this->isAjaxLogin();
		$m = D('Admin/Brands');
    	$rs = array();
    	//var_dump(I('id',0));exit;
    	if(I('id',0)>0){
    		//$this->checkAjaxPrivelege('ppgl_02');
    		$rs = $m->editBrands(I('id',0));
    	}else{
    		//$this->checkAjaxPrivelege('ppgl_01');
    		$rs = $m->insertBrands();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		//$this->isAjaxLogin();
		//$this->checkAjaxPrivelege('ppgl_03');
		$m = D('Admin/Brands');
    	$rs = $m->delBrands($_GET['id']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$m = D('Admin/GoodsCats');
		$cats = $m->queryByList(0);
		$this->assign('cats',$cats);
		//self::WSTAssigns();
		$m = D('Admin/Brands');
		
		$searchArr = $this->searchKeywords();
		if ($searchArr['catId']>0){
		    $list = $m->queryByPage($searchArr,$_POST['pageCurrent'],$_POST['pageSize']);
		}else {
		    $condition = $this->searchCondition();
		    $condition['brandFlag'] = 1;
		    $list = $m->brandsList($condition);
		}
    	foreach ($list['info'] as &$value) {
    		$value['brandDesc'] = html_entity_decode(stripslashes($value['brandDesc']));
    	}
    	//var_dump($list);exit;
    	$this->assign('search', $searchArr);
    	$this->assign('list', $list['info']);
    	$this->assign('total', $list['total']);
        $this->view->display("index");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	//$this->isAjaxLogin();
		$m = D('Admin/Brands');
		$list = $m->queryList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
	
	/**
	 * 列表查询
	 */
	public function getBrands(){
	    $m = D('Admin/Brands');
	    $brandslist = $m->queryBrandsByDistrict();
	    cookie("bstreesAreaId3",I("areaId3"));
	    $this->ajaxReturn($brandslist);
	}
	/**
	 * 获取品牌列表
	 */
	public function queryBrandsByCat(){
	    $m = D('Admin/Brands');
	    $brandslist = $m->queryBrandsByCat((int)I('catId'));
	    $this->ajaxReturn($brandslist);
	}
	
};
?>