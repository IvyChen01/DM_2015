<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :后台用户登陆日志
* @date: 2015年11月18日 上午10:02:19
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\CommonController;
class LoginLogController extends CommonController{
   /**
	 * 查看
	 */
	public function toView(){
		//$this->isLogin();
		//$this->checkPrivelege('dlrz_00');
		$m = D('LogStaffLogins');
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
		//$this->checkPrivelege('dlrz_00');
		$m = D('LogStaffLogins');
		$searchArr = $this->searchKeywords();
		//var_dump($searchArr);exit;
    	$page = $m->queryByPage($searchArr,$_POST['pageCurrent'],$_POST['pageSize']);
    	/* $pager = new \Think\Page($page['total'],$page['pageSize']);
    	$page['pager'] = $pager->show(); */
    	$this->assign('Page',$page);
    	$this->assign('startDate',I('startDate',date('Y-m-d')));
    	$this->assign('endDate',I('endDate',date('Y-m-d')));
    	$this->assign('search', $searchArr);
    	$this->assign('total',$page['total']);
        $this->display("list");
	}
};
?>