<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :会员等级模型
* @date: 2015年10月8日 下午3:39:23
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;

use Think\Model;
use Common\Model\CommonModel;
class UserRanksModel extends CommonModel {
    /**
	  * 新增
	  */
    public $model = 'user_ranks';
	 public function insertRanks(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["rankName"] = I("rankName");
		$data["startScore"] = I("startScore");
		$data["endScore"] = I("endScore");
		$data["rebate"] = I("rebate");
		$data["createTime"] = date('Y-m-d H:i:s');
		if($this->checkEmpty($data)){
			$m = M('user_ranks');
			$rs = $m->add($data);
			if(false !== $rs){
				//$rd['status']= 1;
				$rd['statusCode'] = 200;
				$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
				$rd['closeCurrent'] = true;
			}
		}
		return $rd;
	 } 
     /**
	  * 修改
	  */
	 public function editRanks($id){
	 	$rd = array('status'=>-1);
	 	//$id = I("rankId",0);
		$m = M('user_ranks');
		$data = array();
		$data['rankName'] = I("rankName");
		$data['startScore'] = I("startScore");
		$data['endScore'] = I("endScore");
		$data['rebate'] = I("rebate");
		if($this->checkEmpty($data)){
			$rs = $m->where("rankId=".$id)->save($data);
			if(false !== $rs){
				//$rd['status']= 1;
				$rd['statusCode'] = 200;
				$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
				$rd['closeCurrent'] = true;
			}
		}
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get($id){
	 	$m = M('user_ranks');
		return $m->where("rankId=".$id)->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('user_ranks');
	 	$sql = "select * from __PREFIX__user_ranks order by rankId desc";
		$rs = $m->pageQuery($sql);
		return $rs;
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	    $m = M('user_ranks');
	     $sql = "select * from __PREFIX__user_ranks order by rankId desc";
		 $rs = $m->find($sql);
	  }
	  /**
	   * 获取会员等级列表
	   */
	  public function userRanksList($condition){
	      //$Users = M("UserRanks");
	      //$list = $Users->order('rankId')->select();
	      
	      $list = $this->getPageList($param = array('modelName' => $this->model, 'field' => '*', 'order' => 'rankId ASC', 'listRows' => '20'), $condition);
	      
	      return $list;
	  }
	 /**
	  * 删除
	  */
	 public function delRanks($id){
	 	$rd = array('status'=>-1);
		$m = M('user_ranks');
	    $rs = $m->delete($id);
		if($rs){
			//$rd['status']= 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
			$rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 public function getModel2($tables = ''){
	     $tables = ($tables!='')?$tables:$this->getTableName();
	     $rs =  $this->query('show columns FROM `'.$tables."`");
	     $obj =  array();
	     if($rs){
	         foreach($rs as $key => $v) {
	             $obj[$v['Field']] = $v['Default'];
	         }
	     }
	     return $obj;
	 }
};
?>