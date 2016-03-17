<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :广告模型
* @date: 2015年11月1日 下午2:28:52
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class AdsModel extends CommonModel {
    public $model = 'ads';
    /**
	  * 新增
	  */
	 public function insertAds(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["adPositionId"] = I("adPositionId");
		$data["adFile"] = I("adPic");
		$data["adStartDate"] = I("adStartDate");
		$data["adEndDate"] = I("adEndDate");
		$data["adSort"] = I("adSort",0);
		$data["adDesc"] = stripslashes(htmlspecialchars_decode($_POST['adDesc']));
		$data["adPhoneImg"] = I("adPhoneImg");
		if($this->checkEmpty($data,true)){
			$data["adName"] = I("adName");
		    $data["adURL"] = I("adURL");
		    $data["adVideo"] = I("adVideo");
			/* $data["areaId1"] = I("areaId1");
			$data["areaId2"] = I("areaId2"); */
		    $m = M('ads');
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
	 public function editAds(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data["adPositionId"] = I("adPositionId");
		$data["adFile"] = I("adPic");
		$data["adStartDate"] = I("adStartDate");
		$data["adEndDate"] = I("adEndDate");
		$data["adSort"] = I("adSort",0);
		$data["adDesc"] = stripslashes(htmlspecialchars_decode($_POST['adDesc']));
		$data["adPhoneImg"] = I("adPhoneImg");
	    if($this->checkEmpty($data,true)){	
	    	$data["adName"] = I("adName");
			$data["adURL"] = I("adURL");
			$data["adVideo"] = I("adVideo");
	    	/* $data["areaId1"] = I("areaId1");
			$data["areaId2"] = I("areaId2"); */
			$m = M('ads');
		    $rs = $m->where("adId=".I('id',0))->save($data);
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
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('ads');
		return $m->where("adId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
     	$adPositionId = I('adPositionId');
     	$adDateRange = I('adDateRange');
     	$adName = I('adName');
        $m = M('ads');
	 	$sql = "select a.*,a1.areaName areaName1,a2.areaName areaName2
	 	        from __PREFIX__ads a left join __PREFIX__areas a1 on a.areaId1=a1.areaId 
	 	        left join __PREFIX__areas a2 on a.areaId2 = a2.areaId where 1=1 ";
	 	if($adPositionId!="")$sql.="  and adPositionId=".$adPositionId;
	 	if($adName!=""){
	 		$sql.="  and a.adName like '%$adName%'";
	 	}
	 	$sql.=' order by adId desc';

		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList($id){
	    $m = M('ads');
	    return $m->order('adSort asc')->where(array('adPositionId'=>$id))->select();
	     //$sql = "select * from __PREFIX__ads order by adId desc";
		// return $m->find($sql);
	  }
	  /**
	   * 获取列表
	   */
	  public function adsList($condition){
	      //$Users = M("UserRanks");
	      //$list = $Users->order('rankId')->select();
	      $list = $this->getPageList($param = array('modelName' => $this->model, 'field' => '*', 'order' => 'adId desc', 'listRows' => '20'), $condition);
	      return $list;
	  }
	 /**
	  * 删除
	  */
	 public function delAds($id){
	    $rd = array('status'=>-1);
	    $m = M('ads');
	    $rs = $m->delete($id);
		if(false !== $rs){
		   $rd['status']= 1;
		   $rd['statusCode'] = 200;
		   $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
		   $rd['closeCurrent'] = false;
		}
		return $rd;
	 }
};
?>