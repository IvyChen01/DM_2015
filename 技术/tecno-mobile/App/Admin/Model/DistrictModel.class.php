<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :地区模型
* @date: 2015年10月27日 下午12:11:20
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class DistrictModel extends CommonModel {
	 /**
	  * 获取指定对象
	  */
     public function get($id){
	 	$m = M('district');
	 	$id = (I('id')!='')?I('id'):$id;
		return $m->where("areaId=".(int)$id)->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('district');
        $parentId = I("parentId",0);
	 	$sql = "select * from __PREFIX__district where parentId=".(int)$parentId." and areaFlag=1 order by districtort asc,areaId asc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList($parentId){
	     $m = M('district');
		 return $m->where('upid='.$parentId)->select();
	  }
     /**
	  * 获取列表[获取启用的区域信息]
	  */
	  public function queryShowByList($parentId){
	     $m = M('district');
		 return $m->where('upid='.$parentId)->select();
	  }
     /**
	  * 获取列表[带社区]
	  */
	  public function queryAreaAndCommunitysByList($parentId){
	     $m = M('district');
		 $rs = $m->where('upid='.$parentId)->select();
		 if(count($rs)>0){
		 	$m = M('communitys');
		 	foreach ($rs as $key =>$v){
		 		$r = $m->where('communityFlag=1 and areaId3='.$v['areaId'])->select();
		 		if(!empty($r))$rs[$key]['communitys'] = $r;
		 	}
		 }
		 return $rs;
	  }
	 /**
	  * 迭代获取下级
	  */
	 public function getChild($ids = array(),$pids = array()){
	 	$m = M('district');
	 	$sql = "select areaId from __PREFIX__district where areaFlag=1 and parentId in(".implode(',',$pids).")";
	 	$rs = $m->query($sql);
	 	if(count($rs)>0){
	 		$cids = array();
		 	foreach ($rs as $key =>$v){
		 		$cids[] = $v['areaId'];
		 	}
		 	$ids = array_merge($ids,$cids);
		 	return $this->getChild($ids,$cids);
		 	
	 	}else{
	 		return $ids;
	 	}
	 }
	 /**
	  * 显示分类是否显示/隐藏
	  */
	 public function editiIsShow(){
	 	$rd = array('status'=>-1);
	 	if(I('id',0)==0)return $rd;
	 	//获取子集
		$ids = array();
		$ids[] = (int)I('id');
		$ids = $this->getChild($ids,$ids);
	 	$m = M('district');
	 	$m->isShow = (I('isShow')==1)?1:0;
	 	$rs = $m->where("areaId in(".implode(',',$ids).")")->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }
};
?>