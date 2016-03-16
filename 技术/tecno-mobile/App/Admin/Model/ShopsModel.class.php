<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :店铺模型
* @date: 2015年10月22日 下午4:19:43
* @author: yanhui.chen
* @version:
*/
 namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class ShopsModel extends CommonModel {
     /**
	  * 查询登录关键字
	  */
	 public function checkLoginKey($val,$id = 0){
	 	$sql = " (loginName ='%s' or userPhone ='%s' or userEmail='%s') ";
	 	$keyArr = array($val,$val,$val);
	 	if($id>0)$sql.=" and userId!=".$id;
	 	$m = M('users');
	 	$rs = $m->where($sql,$keyArr)->count();
	    if($rs==0)return 1;
	    return 0;
	 }
    /**
	  * 新增
	  */
	 public function insertShops(){
	 	$rd = array('status'=>-1);
	 	/* //先建立账号
	 	$hasLoginName = self::checkLoginKey(I("loginName"));
	 	$hasUserPhone = self::checkLoginKey(I("userPhone"));
	 	if($hasLoginName==0 || $hasUserPhone==0){
	 		$rd = array('status'=>-2);
	 		return $rd;
	 	} */
	 	
		
		//店铺资料
		$sdata = array();
		//$sdata["userId"] = I("staffsId");
		//$sdata["shopSn"] = I("shopSn");
		$sdata["areaId1"] = I("areaId1");
		$sdata["areaId2"] = I("areaId2");
		//$sdata["areaId3"] = I("areaId3");
		$sdata["shopName"] = I("shopName");
		$sdata["shopAddress"] = I("shopAddress");
		$sdata["longitude"] = (float)I("longitude");
		$sdata["latitude"] = (float)I("latitude");
		$sdata["mapLevel"] = (int)I("mapLevel",13);
		$sdata["createTime"] = date('Y-m-d H:i:s');
		$sdata["shopTel"] = I("shopTel");
		if($this->checkEmpty($sdata,true)){ 
		        $sdata["shopEmail"] = I("shopEmail");
		        $sdata["lang"] = I("lang");
				$m = M('shops');
				$shopId = $m->add($sdata);
				if(false !== $shopId){
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
	 public function editShops($id){
	 	$rd = array('status'=>-1);
	 	$shopId = $id;
	 	if($shopId==0)return $rd;
	 	$m = M('shops');
	 	//获取店铺资料
	 	$shops = $m->where("shopId=".$shopId)->find();
	    
	    /* //检测手机号码是否存在
	 	if(I("userPhone")!=''){
	 		$hasUserPhone = self::checkLoginKey(I("userPhone"),$shops['userId']);
	 		if($hasUserPhone==0){
	 			$rd = array('status'=>-2);
	 		    return $rd;
	 		}
	 	} */
	    $data = array();
		//$data["shopSn"] = I("shopSn");
		$data["areaId1"] = I("areaId1");
		$data["areaId2"] = I("areaId2");
		//$data["areaId3"] = I("areaId3");
		//$data["goodsCatId1"] = I("goodsCatId1");
		//$data["isSelf"] = I("isSelf",0);
		$data["shopName"] = I("shopName");
		//$sdata["userId"] = I("staffsId");
		//$data["shopCompany"] = I("shopCompany");
		//$data["shopImg"] = I("shopImg");
		$data["shopAddress"] = I("shopAddress");
		$data["longitude"] = (float)I("longitude");
		$data["latitude"] = (float)I("latitude");
		//$data["mapLevel"] = (int)I("mapLevel",13);
		if($this->checkEmpty($data,true)){
			$data["shopTel"] = I("shopTel");
			$data["shopEmail"] = I("shopEmail");
			$data["lang"] = I("lang");
			$rs = $m->where("shopId=".$shopId)->save($data);
				$rd['status']= 1;
				$rd['statusCode'] = 200;
				$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
				$rd['closeCurrent'] = true;
		        return $rd;
	    } 
	}
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('shops');
		$rs = $m->where("shopId=".I('id'))->find();
		
		$m = M('Staffs');
		$us = $m->where("staffId=".$rs['userId'])->find();
		$rs['userName'] = $us['userName'];
		$rs['userPhone'] = $us['mobile'];
		//获取店铺社区关系
		/* $m = M('shops_communitys');
		$rc = $m->where('shopId='.I('id'))->select();
		$relateArea = array();
		$relateCommunity = array(); */
		/* if(count($rc)>0){
			foreach ($rc as $v){
				if($v['communityId']==0 && !in_array($v['areaId3'],$relateArea))$relateArea[] = $v['areaId3'];
				if(!in_array($v['communityId'],$relateCommunity))$relateCommunity[] = $v['communityId'];
			}
		}
		$rs['relateArea'] = implode(',',$relateArea);
		$rs['relateCommunity'] = implode(',',$relateCommunity); */
		return $rs;
	 }
	 
	 /**
	  * 分页列表
	  */
     public function queryByPage($array,$page,$pageSize){
        $m = M('shops');
        /* $areaId1 = I('areaId1',0);
     	$areaId2 = I('areaId2',0); */
        $shopName = $array['shopName'];
        $shopSn = $array['shopSn'];
	 	$sql = "select shopId,shopSn,shopName,shopAtive,shopStatus,shopAddress from __PREFIX__shops  
	 	     where shopFlag=1 ";
	 	if($shopName!='')$sql.=" and shopName like '%".$shopName."%'";
	 	if($shopSn!='')$sql.=" and shopSn like '%".$shopSn."%'";
	 	/* if($areaId1>0)$sql.=" and areaId1=".$areaId1;
	 	if($areaId2>0)$sql.=" and areaId2=".$areaId2; */
	 	$sql.=" order by shopId desc";
	 	
		return $m->pageQuery($sql,$page,$pageSize);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('shops');
	     $sql = "select * from __PREFIX__shops where shopFlag=1 order by shopId desc";
		 $rs = $m->query($sql);
		 return $rs;
	  }
	  /**
	   * 获取列表
	   */
	  public function queryByListlang($lang=0){
	      $m = M('shops');
	      $sql = "select * from __PREFIX__shops where shopFlag=1 and lang='$lang' order by shopId desc";
	      $rs = $m->query($sql);
	      return $rs;
	  }
	 /**
	  * 删除
	  */
	 public function delShops($id){
	    $rd = array('status'=>-1);
	 	$m = M('shops');
	    $data = array();
		$data["shopFlag"] = -1;
	 	$rs = $m->where("shopId=".$id)->save($data);
	    if(false !== $rs){
			$rd['status']= 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
			$rd['closeCurrent'] = false;
		}
		return $rd;
		
	 }
	 public function queryShopListById($areaId,$lang){
	     $m = M('shops');
	     if ($areaId==0){
	         $rs= $m->where(array('shopFlag'=>1,'lang'=>$lang))->select();
	     }else {
	         $rs= $m->where(array('shopFlag'=>1,'areaId2'=>$areaId,'lang'=>$lang))->select();
	     }
		 return $rs;
	 }
};
?>