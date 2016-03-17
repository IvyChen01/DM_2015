<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品评价模型
* @date: 2015年11月17日 上午11:40:02
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class GoodsAppraisesModel extends CommonModel {
     /**
	  * 修改
	  */
	 public function editAppraises(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$m = M('goods_appraises');
		$data["goodsScore"] = I("goodsScore");
		$data["serviceScore"] = I("serviceScore");
		$data["timeScore"] = I("timeScore");
		$data["content"] = I("content");
		$data["isShow"] = I("isShow",1);
		//var_dump($data);exit;
		if($this->checkEmpty($data)){	
			$rs = $m->where("id=".I('id'))->save($data);
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
	 	$id = (int)I('id');
		$sql = "select gp.*,o.orderNo,u.loginName,g.goodsName,g.goodsThums from __PREFIX__goods_appraises gp 
		         left join __PREFIX__goods g on gp.goodsId=g.goodsId
		         left join __PREFIX__orders o on gp.orderId=o.orderId 
		         left join __PREFIX__users u on u.userId=gp.userId 
		         where gp.id=".$id;
		return $this->queryRow($sql);
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage($array,$page,$pageSize){
     	$shopName = $array['shopName'];
     	$goodsName = $array['goodsName'];
     	$areaId1 = $array['areaId1'];
     	$areaId2 =$array['areaId2'];
        $m = M('goods_appraises');
	 	$sql = "select gp.*,g.goodsName,g.goodsThums,u.loginName from __PREFIX__goods_appraises gp
	 	         left join __PREFIX__goods g on gp.goodsId=g.goodsId
		         left join __PREFIX__users u on u.userId=gp.userId 
	 	        where gp.goodsId=g.goodsId ";
	 	if($areaId1>0)$sql.=" and p.areaId1=".$areaId1;
	 	if($areaId2>0)$sql.=" and p.areaId2=".$areaId2;
	 	if($shopName!='')$sql.=" and (p.shopName like '%".$shopName."%' or p.shopSn like '%'".$shopName."%')";
	 	if($goodsName!='')$sql.=" and (g.goodsName like '%".$goodsName."%' or g.goodsSn like '%".$goodsName."%')";
	 	$sql.="  order by id desc";
		$rs = $m->pageQuery($sql,$page,$pageSize);
		return $rs;
	 }
	  
	 /**
	  * 删除
	  */
	 public function delAppraises(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods_appraises');
		$rs = $m->delete(I('id'));
		if($rs){
		   $rd['status']= 1;
		   $rd['statusCode'] = 200;
		   $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
		   $rd['closeCurrent'] = false;
		}
		return $rd;
	 }
};
?>