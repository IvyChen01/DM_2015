<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :品牌模型
* @date: 2015年10月12日 上午10:21:36
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class BrandsModel extends CommonModel {
    /**
	  * 新增
	  */
	 public function insertBrands(){
	 	$rd = array('status'=>-1);
	 	$id = (int)I("id",0);
	    //$idsStr = I("catIds");
	 	$idsStr = $_POST['catIds'];
	 	$ids = array();
	 	if($idsStr!=''){
	 		//$idsStr = explode(',',$idsStr);
	 		foreach ($idsStr as $key =>$v){
	 			if((int)$v>0)$ids[] = (int)$v;
	 		}
	 	}
	 	//var_dump($ids);exit;
		$data = array();
		$data["brandName"] = I("brandName");
		$data["brandIco"] = I("brandIco");
		$data["brandDesc"] = I("brandDesc");
		$data["createTime"] = date('Y-m-d H:i:s');
		$data["brandFlag"] = 1;
		if($this->checkEmpty($data) && count($ids)>0){
			$m = M('brands');
			$rs = $m->add($data);
		    if(false !== $rs){
		        $m = M('goods_cat_brands');
				foreach ($ids as $key =>$v){
					$d = array();
					$d['catId'] = $v;
					$d['brandId'] = $rs;
					$m->add($d);
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
	  * 修改
	  */
	 public function editBrands($id){
	 	$rd = array('status'=>-1);
	    $idsStr = I("catIds");
	 	$ids = array();
	 	if($idsStr!=''){
	 		//$idsStr = explode(',',$idsStr);
	 		foreach ($idsStr as $key =>$v){
	 			if((int)$v>0)$ids[] = (int)$v;
	 		}
	 	}
	 	$filter = array();
	 	//获取品牌的关联分类
	 	$sql = "select catId from __PREFIX__goods_cat_brands where brandId=".$id;
		$catBrands = $this->query($sql);
		foreach ($catBrands as $key =>$v){
			if(!in_array($v,$ids))$filter[] = $v['catId'];
		}
		//查询指定的分类下是否有品牌被引用了
		if(count($filter)>0){
			$sql = "select count(*) counts from __PREFIX__goods where brandId =".$id." and goodsCatId1 in(".implode(',',$filter).") and goodsFlag=1 ";
			$grs = $this->queryRow($sql);
			if($grs['counts']>0){
				$rd['status'] = -2;
				return $rd;
			}
		}
		$data = array();
		$m = M('brands');
		/* $m->brandName = I("brandName");
		$m->brandIco = I("brandIco");
		$m->brandDesc = I("brandDesc"); */
		$data["brandName"] = I("brandName");
		$data["brandIco"] = I("brandIco");
		$data["brandDesc"] = I("brandDesc");
	    if($this->checkEmpty($data) && count($ids)>0){
			$rs = $m->where("brandId=".$id)->save($data);
			if(false !== $rs){
			    $cm = M('goods_cat_brands');
				$cm->where('brandId='.$id)->delete();
			    foreach ($ids as $key =>$v){
					$d = array();
					$d['catId'] = $v;
					$d['brandId'] = $id;
					$cm->add($d);
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
	  * 获取指定对象
	  */
     public function get($id){
	 	$m = M('brands');
		$rs = $m->where("brandId=".$id)->find();
        //获取关联的分类
		$sql = "select * from __PREFIX__goods_cat_brands where brandId=".$id;
		$catBrands = $this->query($sql);
		if(!empty($catBrands)){
			foreach ($catBrands as $key => $v){
				$rs['catBrands_'.$v['catId']] = 1;
			}
		}
		return $rs;
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage($array,$page,$pageSize){
        $m = M('brands');
        $brandName = $array["brandName"];
        $catId = $array["catId"];
	 	$sql = "select b.* from __PREFIX__brands b";
	    $sql .= ", __PREFIX__goods_cat_brands cb";
	 	$sql .= " where brandFlag=1";
	 	$sql .= " and b.brandId = cb.brandId and cb.catId = $catId";
	 	if($brandName!=""){
	 		$sql .= " and brandName like '%$brandName%'";
	 	}
	 	$sql .= " order by b.brandId desc ";
		return $m->pageQuery($sql,$page,$pageSize);
	 }
	 /**
	  * 获取列表
	  */
	 public function brandsList($condition){
	     $list = $this->getPageList($param = array('modelName' => 'brands', 'field' => '*', 'order' => 'brandId desc', 'listRows' => '20'), $condition);
	     return $list;
	 }

	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('brands');
	     return $m->where('brandFlag=1')->select();
	  }
	  
	 /**
	  * 删除
	  */
	 public function delBrands($id){
	    $rd = array('status'=>-1);
	 	if($id==0)return $rd;
	 	$m = M('brands');
	 	$m->brandFlag = -1;
	 	$rs = $m->where("brandId=".$id)->save();
	    if(false !== $rs){
	        $cm = M('goods_cat_brands');
	        $info=$cm->where('brandId='.$id)->delete();
			$rd['status']= 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
		    $rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 /**
	  * 获取列表
	  */
	 public function queryBrandsByCat($catId){
	     $rs = array('status'=>1);
	     $list = S("WST_BRANDS_002_".$catId);
	     if(!$list){
	         $sql = "select b.brandId,b.brandName from __PREFIX__goods_cat_brands cb,__PREFIX__brands b where cb.brandId=b.brandId and catId=".$catId;
	         $rs['list'] = $this->query($sql);
	         S("WST_BRANDS_002_".$catId,$list,2592000);
	     }
	     return $rs;
	 }

};
?>