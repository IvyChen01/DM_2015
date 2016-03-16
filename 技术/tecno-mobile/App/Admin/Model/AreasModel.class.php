<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :地区模型
* @date: 2015年11月20日 上午11:48:25
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class AreasModel extends CommonModel {
    /**
	  * 新增
	  */
	 public function insertAreas(){
	 	$areaType = 0;
	 	if(I("parentId",0)>0){
		 	$prs = $this->get(I("parentId",0));
		 	$areaType = $prs['areaType']+1;
		}
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$child = I('addChild');
		$data["parentId"] = I("parentId",0);
		$data["areaName"] = I("areaName");
		$data["isShow"] = I("isShow",1);
		$data["areaSort"] = I("areaSort",0);
		//$data["areaKey"] = I("areaKey");
		$data["areaType"] = $areaType;
		$data["areaFlag"] = 1;
	    if($this->checkEmpty($data,true)){
			$m = M('areas');
			$rs = $m->add($data);
		    if(false !== $rs){
				$rd['status']= 1;
				$rd['statusCode'] = 200;
				$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
				if ($child){
				    $rd['closeCurrent'] = true;
				}else {
				    $rd['closeCurrent'] = false;
				}
				
			}
		}
		return $rd;
	 } 
     /**
	  * 修改
	  */
	 public function editAreas(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["areaName"] = I("areaName");
		$data["isShow"] = I("isShow",1);
		$data["areaSort"] = I("areaSort",0);
		if($this->checkEmpty($data,true)){	
			$m = M('areas');
		    $rs = $m->where("areaId=".I('id',0))->save($data);
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
     public function get($id){
	 	$m = M('areas');
	 	$id = (I('id')!='')?I('id'):$id;
		return $m->where("areaId=".(int)$id)->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('areas');
        $parentId = I("parentId",0);
	 	$sql = "select * from __PREFIX__areas where parentId=".(int)$parentId." and areaFlag=1 order by areaSort asc,areaId asc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList($parentId){
	     $m = M('areas');
		 return $m->where('areaFlag=1 and parentId='.$parentId)->select();
	  }
     /**
	  * 获取列表[获取启用的区域信息]
	  */
	  public function queryShowByList($parentId){
	     
	      $m = M('areas');
		  $rs = $m->where('areaFlag=1 and isShow = 1 and parentId='.$parentId)->select();
		 return $rs;
	  }
     /**
	  * 获取列表[带社区]
	  */
	  public function queryAreaAndCommunitysByList($parentId){
	     $m = M('areas');
		 $rs = $m->where('areaFlag=1 and parentId='.$parentId)->select();
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
	  * 删除
	  */
	 public function delAreas($id){
	 	$rd = array('status'=>-1);
	 	if($id==0)return $rd;
        //获取子集
		$ids = array();
		$ids[] = $id;
		$ids = $this->getChild($ids,$ids);
		$m = M('areas');
	 	$data = array();
		$data["areaFlag"] = -1;
	    $rs = $m->where("areaId in(".implode(',',$ids).")")->save($data);
	    if(false !== $rs){
			$rd['status']= 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
			$rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 /**
	  * 迭代获取下级
	  */
	 public function getChild($ids = array(),$pids = array()){
	 	$m = M('areas');
	 	$sql = "select areaId from __PREFIX__areas where areaFlag=1 and parentId in(".implode(',',$pids).")";
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
	 	$m = M('areas');
	 	$m->isShow = (I('isShow')==1)?1:0;
	 	$rs = $m->where("areaId in(".implode(',',$ids).")")->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }
	 public function category() {
	    $condition['areaFlag'] = 1;
	    $cat = new \Com\Category('areas', array('areaId', 'parentId', 'areaName', 'areaName'));
	    return $cat->getList($condition, $cid = 0, $orderby = 'areaSort asc');               //获取分类结构
	 }
	 /**
	  * 修改名称
	  */
	 public function editName(){
	     $rd = array('status'=>-1);
	     $id = I("id",0);
	     $data = array();
	     $data["areaName"] = I("areaName");
	     if($this->checkEmpty($data)){
	         $m = M('areas');
	         $rs = $m->where("areaFlag=1 and areaId=".I('id'))->save($data);
	         if(false !== $rs){
	             $rd['status']= 1;
	         }
	     }
	     return $rd;
	 }
	 /**
	  * 修改排序
	  */
	 public function editSort(){
	     $rd = array('status'=>-1);
	     $id = I("id",0);
	     $data = array();
	     $data["areaSort"] = I("areaSort");
	     if($this->checkEmpty($data)){
	         $m = M('areas');
	         $rs = $m->where("areaFlag=1 and areaId=".I('id'))->save($data);
	         if(false !== $rs){
	             $rd['status']= 1;
	         }
	     }
	     return $rd;
	 }
};
?>