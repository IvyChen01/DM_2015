<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品分类模型
* @date: 2015年10月12日 上午10:21:36
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class GoodsCatsModel extends CommonModel {
    /**
	  * 新增
	  */
	 public function insertGoodsCats(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
	 	$child = I('addChild');
		$data = array();
		$data["catName"] = I("catName");
		$data["parentId"] = I("parentId",0);
		$data["isShow"] = 1;
		$data["catSort"] = I("catSort",0);
		$data["catFlag"] = 1;
		$data["lang"] = I("lang");
		if($this->checkEmpty($data,true)){
			$m = M('goods_cats');
			$data["goodsCatImg"] = I("goodsCatImg");
			$data["goodsCatDesc"] = stripslashes(htmlspecialchars_decode($_POST['goodsCatDesc']));
			$rs = $m->add($data);
			if($rs){
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
	 public function editGoodsCats(){
	 	$rd = array('status'=>-1);
	 	$id = (int)I("id",0);
		$data = array();
		$data["catName"] = I("catName");
		$data["lang"] = I("lang");
	    if($this->checkEmpty($data)){
	    	$data["isShow"] = I("isShow",0);
	    	$data["catSort"] = I("catSort",0);
	    	$data["goodsCatImg"] = I("goodsCatImg");
	    	$data["goodsCatDesc"] = stripslashes(htmlspecialchars_decode($_POST['goodsCatDesc']));
	    	$m = M('goods_cats');
			$rs = $m->where("catFlag=1 and catId=".I('id'))->save($data);
			if(false !== $rs){
				if ($data['isShow'] == 0) {//修改子栏目是否隐藏
					$this->editIsShow();
				}
				$rd['status']= 1;
				$rd['statusCode'] = 200;
				$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
				$rd['closeCurrent'] = true;
			}
		}
		return $rd;
	 } 
	 /**
	  * 修改名称
	  */
	 public function editName(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["catName"] = I("catName");
	    if($this->checkEmpty($data)){
	    	$m = M('goods_cats');
			$rs = $m->where("catFlag=1 and catId=".I('id'))->save($data);
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
	     $data["catSort"] = I("catSort");
	     if($this->checkEmpty($data)){
	         $m = M('goods_cats');
	         $rs = $m->where("catFlag=1 and catId=".I('id'))->save($data);
	         if(false !== $rs){
	             $rd['status']= 1;
	         }
	     }
	     return $rd;
	 }
	 /**
	  * 获取指定对象
	  */
     public function get($id){
	 	$m = M('goods_cats');
		return $m->where("catId=".$id)->find();
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList($pid = 0){
	     $m = M('goods_cats');
	     $rs = $m->where('catFlag=1 and parentId='.$pid)->select(); 
		 return $rs;
	  }
	  /**
	   * 获取列表
	   */
	  public function queryByListlang($pid = 0,$lang=0){
	      $m = M('goods_cats');
	      $rs = $m->where(array('catFlag'=>1,'parentId'=>$pid,'lang'=>$lang))->select();
	      return $rs;
	  }
	  /**
	   * 根据catID获取父级信息
	   */
	  public function getParentById($id){
	      $m = M('goods_cats');
	      $parentId = $m->field('parentId')->where('catFlag=1 and catId='.$id)->find();
	      $rs = array();
	      if ($parentId['parentId'] != 0){
	          $rs = $m->where('catFlag=1 and parentId='.$parentId['parentId'])->select();
	      }
	      return $rs;
	  }
	  /**
	   * 获取树形分类
	   */
	  public function getCatAndChild(){
	  	  $m = M('goods_cats');
	  	  //获取第一级分类
	  	  $sql = "select * from __PREFIX__goods_cats where catFlag=1 and parentId =0 order by catSort asc";
	  	  $rs1 = $m->query($sql);
	  	  if(count($rs1)>0){
	  	  	 $ids = array();
	  	  	 foreach ($rs1 as $key =>$v){
	  	  	 	$ids[] = $v['catId'];
	  	  	 }
	  	  	 //获取第二级分类
	  	     $sql = "select * from __PREFIX__goods_cats where catFlag=1 and parentId in (".implode(',',$ids).")  order by catSort asc";
	  	     $rs2 = $m->query($sql);
	  	     if(count($rs2)>0){
	  	     	 $ids = array();
		  	  	 foreach ($rs2 as $key =>$v){
		  	  	 	$ids[] = $v['catId'];
		  	  	 }
		  	  	 //获取第三级分类
		  	     $sql = "select * from __PREFIX__goods_cats where catFlag=1 and parentId in (".implode(',',$ids).")  order by catSort asc";
		  	     $rs3 = $m->query($sql);
		  	     $tmpArr = array();
		  	     if(count($rs3)>0){
			  	     foreach ($rs3 as $key =>$v){
			  	  	 	$tmpArr[$v['parentId']][] = $v;
			  	  	 }
		  	     }
		  	     //把第三级归类到第二级下
		  	     foreach ($rs2 as $key =>$v){
		  	     	$rs2[$key]['child'] = $tmpArr[$v['catId']];
		  	     	$rs2[$key]['childNum'] = count($tmpArr[$v['catId']]);
		  	     }
		  	     $tmpArr = array();
	  	         foreach ($rs2 as $key =>$v){
			  	  	 $tmpArr[$v['parentId']][] = $v;
			  	 }
		  	 }
		  	 //把二季归类到第一级下
	  	     foreach ($rs1 as $key =>$v){
	  	  	 	$rs1[$key]['child'] = $tmpArr[$v['catId']];
	  	  	 	$rs1[$key]['childNum'] = count($tmpArr[$v['catId']]);
	  	  	 }
	  	  }
	  	  return $rs1;
	  }
	 /**
	  * 迭代获取下级
	  */
	 public function getChild($ids = array(),$pids = array()){
	 	$m = M('goods_cats');
	 	$sql = "select catId from __PREFIX__goods_cats where catFlag=1 and parentId in(".implode(',',$pids).")";
	 	$rs = $m->query($sql);
	 	if(count($rs)>0){
	 		$cids = array();
		 	foreach ($rs as $key =>$v){
		 		$cids[] = $v['catId'];
		 	}
		 	$ids = array_merge($ids,$cids);
		 	return $this->getChild($ids,$cids);
		 	
	 	}else{
	 		return $ids;
	 	}
	 }
	 /**
	  * 删除
	  */
	 public function delGoodsCats($id){
	 	$rd = array('status'=>-1);
	 	//获取子集
	 	$ids = array();
		$ids[] = (int)$id;
	 	$ids = $this->getChild($ids,$ids);
	 	$m = M('goods_cats');
	 	/* //把相关的商品下架了
	 	$sql = "update __PREFIX__goods set isSale=0 where goodsCatId1 in(".implode(',',$ids).")";
	 	$m->query($sql);
	 	$sql = "update __PREFIX__goods set isSale=0 where goodsCatId2 in(".implode(',',$ids).")";
	 	$m->query($sql);
	 	$sql = "update __PREFIX__goods set isSale=0 where goodsCatId3 in(".implode(',',$ids).")";
	 	$m->query($sql);  */
	 	//设置商品分类为删除状态
	 	$m->catFlag = -1;
		$rs = $m->where(" catId in(".implode(',',$ids).")")->save();
	    if(false !== $rs){
	        $gm = D('goods');
	        $data = array();
	        $data['isSale'] = 0;
	        $gm->where(" goodsCatId1 in(".implode(',',$ids).")")->save($data);
	        $gm->where(" goodsCatId2 in(".implode(',',$ids).")")->save($data);
	        $gm->where(" goodsCatId3 in(".implode(',',$ids).")")->save($data);
	        
		   $rd['status']= 1;
		   $rd['statusCode'] = 200;
		   $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
		   $rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 /**
	  * 显示分类是否显示/隐藏
	  */
	 public function editIsShow(){
	 	$rd = array('status'=>-1);
	 	if(I('id',0)==0)return $rd;
	 	$isShow = (int)I('isShow');
	 	//获取子集
	 	$ids = array();
		$ids[] = (int)I('id');
	 	$ids = $this->getChild($ids,$ids);
	 	$m = M('goods_cats');
	 	if($isShow!=1){
	 		$gm = D('goods');
			$data = array();
			$data['isSale'] = 0;
			$gm->where(" goodsCatId1 in(".implode(',',$ids).")")->save($data);
			$gm->where(" goodsCatId2 in(".implode(',',$ids).")")->save($data);
			$gm->where(" goodsCatId3 in(".implode(',',$ids).")")->save($data);
	 	}
	 	$m->isShow = ($isShow==1)?1:0;
	 	$rs = $m->where("catId in(".implode(',',$ids).")")->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }
	 /* 
	  * 获取分类
	  *  
	  */
	 public function category() {
	     if (IS_POST) {
	         $act = $_POST[act];
	         $data = $_POST['data'];
	         $data['name'] = addslashes($data['name']);
	         if ($data["model"] == "article") {
	             $data["url"] = "/Article/index/code/" . $data["code"];
	         } else if ($data["model"] == "product") {
	             $data["url"] = "/Product/index/code/" . $data["code"];
	         } else if ($data["model"] == "page") {
	             $data["url"] = "/Article/page/code/" . $data["code"];
	         } else {
	             if ($data["url"]) {
	                 $data["url"] = $data["url"];
	             } else {
	                 unset($data["url"]);
	             }
	         }
	         $M = M("goods_cats");
	         if ($act == "add") { //添加分类
	             unset($data[cid]);
	             $data["status"] = "1";
	             $data["position"] = "2";
	             if ($M->where($data)->count() == 0) {
	                 return ($M->add($data)) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功添加到系统中') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 添加失败');
	             } else {
	                 return array('statusCode' => 200, 'message' => '系统中已经存在分类' . $data['name']);
	             }
	         } else if ($act == "edit") { //修改分类
	             if (empty($data['name'])) {
	                 unset($data['name']);
	             }
	             if ($data['fid'] == $data['cid']) {
	                 unset($data['fid']);
	             }
	             return ($M->save($data)) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功更新') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 更新失败');
	         } else if ($act == "del") { //删除分类
	             unset($data['fid'], $data['name'], $data['model'], $data['code'], $data['position'], $data['url'], $data['oid']);
	             return ($M->where($data)->delete()) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功删除') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 删除失败');
	             echo $M->getlastsql();
	         }
	     } else {
	         $condition['catFlag'] = 1;
	         $Category = new \Com\Category('goods_cats', array('catId', 'parentId', 'catName', 'catName'));
	         return $Category->getList($condition, $cid = 0, $orderby = 'catSort asc'); //获取分类结构
	     }
	 }
	 /* 
	  * 根据名称查询分类信息
	  */
	 public function searchByName($condition){
	     $m = M('goods_cats');
	     $rs = $m->where($condition)->find();
	     return $rs;
	 }
	 
};
?>