<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :登陆日志模型
* @date: 2015年11月18日 上午10:05:45
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class LogStaffLoginsModel extends CommonModel {
     /**
	  * 新增
	  */
	 public function insertLog(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["loginId"] = I("loginId");
		$data["staffId"] = I("staffId");
		$data["loginTime"] = date('Y-m-d H:i:s');
		$data["loginIp"] = get_client_ip();;
		foreach ($data as $key=>$v){
			if(trim($v)==''){
				$rd['status'] = -2;
				return $rd;
			}
		}
		$m = M('log_staff_logins');
		$rs = $m->add($data);
		if($rs){
			$rd['status']= 1;
		}
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('log_staff_logins');
		return $m->where("loginId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage($array,$page,$pageSize){
        $m = M('log_staff_logins');
        $startDate = $array["startDate"];
        $endDate = $array["endDate"];
	 	$sql = "select loginId,loginName,staffName,loginTime,loginIp from __PREFIX__log_staff_logins l,__PREFIX__staffs s where l.staffId=s.staffId ";
	 	if($startDate!="" && $endDate !=""){
	 	    $sql .= " and loginTime between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'";
	 	}
	 	$sql .= " order by loginId desc ";
	 	//var_dump($pageSize);exit;
		return $m->pageQuery($sql,$page,$pageSize);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	    $m = M('log_logins');
	     $sql = "select * from __PREFIX__log_logins order by loginId desc";
		 return $m->find($sql);
	  }
};
?>