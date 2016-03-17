<?php
namespace Admin\Model;

use Think\Model;
use Common\Model\CommonModel;
class RoleModel extends CommonModel {
    /**
	  * 新增
	  */
	 public function insertRole(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
	 	
		$data = array();
		$data["name"] = I("title");
		$data["status"] = 1;
		$data["remark"] = I("remark");
	    if($this->checkEmpty($data)){
			$m = M('role');
			$rs = $m->add($data);
			if(false !== $rs){
				$rd['status']= 1;
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
	 public function editRole(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
	 	$m = M('role');
		$data = array();
		$data["name"] = I("title");
		$data["status"] = I('status');
		$data["remark"] = I("remark");
	    if($this->checkEmpty($data)){
			$rs = $m->where("id=".$id)->save($data);
			if(false !== $rs){
				$rd['status']= 1;
				$rd['statusCode'] = 200;
				$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
				$rd['closeCurrent'] = true;
				//实时更新当前用户权限
				/* if(session('WST_STAFF.staffRoleId')==$id){
					$WST_STAFF = session('WST_STAFF');
					$WST_STAFF['grant'] = explode(',',I("grant"));
					session('WST_STAFF',$WST_STAFF);
				} */
			}
		}
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('role');
		return $m->where("id=".I('id'))->find();
	 }
	 /**
	  * 获取指定对象
	  */
	 public function getRoleNameById($id){
	     $m = M('role');
	     $mrs = M('role_staffs');
	     $role_id = $mrs->field('role_id')->where(array('user_id'=>$id))->find();
	     $role_name = $m->field('name')->where(array('id'=>$role_id['role_id']))->find();
	     return $role_name['name'];
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('role');
	 	$sql = "select * from __PREFIX__role order by id asc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	 public function roleList($condition){
	     $list = $this->getPageList($param = array('modelName' => 'role', 'field' => '*', 'order' => 'id asc', 'listRows' => '20'), $condition);
	     return $list;
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('role');
		 return $m->select();
	  }
	  
	 /**
	  * 删除
	  */
	 public function delRole($id){
	 	$rd = array('status'=>-1);
	 	$m = M('role');
	    $rs = $m->delete($id);
		if(false !== $rs){
			$rd['status']= 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
			$rd['closeCurrent'] = false;
		}
		return $rd;
	 }
};
?>