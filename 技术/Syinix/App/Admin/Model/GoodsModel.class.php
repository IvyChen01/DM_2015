<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品模型
* @date: 2015年10月12日 上午10:21:36
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;
class GoodsModel extends CommonModel {
    /**
     * 新增商品
     */
    public function insertGoods(){
        $rd = array('status'=>-1);
        //查询商家状态
        /* $sql = "select shopStatus from __PREFIX__shops where shopFlag = 1 and shopId=".(int)session('WST_USER.shopId');
        $shopStatus = $this->query($sql);
        if(empty($shopStatus)){
            $rd['status'] = -2;
            return $rd;
        } */
        $data = array();
        $data["goodsSn"] = I("goodsSn");
        $data["goodsName"] = I("goodsName");
        $data["goodsImg"] = I("goodsImg");
        //$data["goodsThums"] = I("goodsThumbs");
        //$data["shopId"] = session('WST_USER.shopId');
        $data["marketPrice"] = (float)I("marketPrice");
        $data["shopPrice"] = (float)I("shopPrice");
        $data["goodsStock"] = (int)I("goodsStock");
        $data["isBook"] = (int)I("isBook");
        $data["bookQuantity"] = (int)I("bookQuantity");
        $data["warnStock"] = (int)I("warnStock");
        $data["goodsUnit"] = I("goodsUnit");
        $data["isBest"] = (int)I("isBest");
        $data["isRecomm"] = (int)I("isRecomm");
        $data["isNew"] = (int)I("isNew");
        $data["isHot"] = (int)I("isHot");
        //如果商家状态不是已审核则所有商品只能在仓库中
        /* if($shopStatus[0]['shopStatus']==1){ */
            $data["isSale"] = (int)I("isSale");
       /*  }else{
            $data["isSale"] = 0;
        } */
        $data["goodsCatId1"] = (int)I("goodsCatId1");
        
        $data["goodsCatId2"] = (int)I("goodsCatId2");
        $data["goodsCatId3"] = (int)I("goodsCatId3");
        $data["shopCatId1"] = (int)I("shopCatId1");
        $data["shopCatId2"] = (int)I("shopCatId2");
        $data["goodsDesc"] = stripslashes(htmlspecialchars_decode($_POST['goodsDesc']));
        $data["attrCatId"] = (int)I("attrCatId");
        $data["isShopRecomm"] = 0;
        $data["isIndexRecomm"] = 0;
        $data["isActivityRecomm"] = 0;
        $data["isInnerRecomm"] = 0;
        $data["goodsStatus"] = ($GLOBALS['CONFIG']['isGoodsVerify']==1)?0:1;
        $data["goodsFlag"] = 1;
        $data["createTime"] = date('Y-m-d H:i:s');
        //var_dump($data);exit;
        if($this->checkEmpty($data,true)){
            $data["brandId"] = (int)I("brandId");
            $data["goodsSpec"] = stripslashes(htmlspecialchars_decode($_POST['goodsSpec']));
            $data["goodsKeywords"] = I("goodsKeywords");
            $m = M('goods');
            $goodsId = $m->add($data);
            if(false !== $goodsId){
                /* if($shopStatus[0]['shopStatus']==1){ */
                    $rd['status']= 1;
                    $rd['statusCode'] = 200;
                    $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
                    $rd['closeCurrent'] = true;
                /* }else{ 
                    $rd['status'] = -3;
                 } */
                //规格属性
                if($data["attrCatId"]>0){
                    $m = M('goods_attributes');
                    //获取商品类型属性
                    $sql = "select attrId,attrName,isPriceAttr from __PREFIX__attributes where attrFlag=1
					       and catId=".$data["attrCatId"];
                    $attrRs = $m->query($sql);
                    if(!empty($attrRs)){
                        $priceAttrId = 0;
                        foreach ($attrRs as $key =>$v){
                            if($v['isPriceAttr']==1){
                                $priceAttrId = $v['attrId'];
                                continue;
                            }else{
                                $attr = array();
                                
                                $attr['goodsId'] = $goodsId;
                                $attr['attrId'] = $v['attrId'];
                                $attr['attrVal'] = I('attr_name_'.$v['attrId']);
                                $m->add($attr);
                            }
                        }
                        if($priceAttrId>0){
                            $no = (int)I('goodsPriceNo');
                            $no = $no>50?50:$no;
                            $totalStock = 0;
                            for ($i=0;$i<=$no;$i++){
                                $name = trim(I('price_name_'.$priceAttrId."_".$i));
                                if($name=='')continue;
                                $attr = array();
                                //$attr['shopId'] = session('WST_USER.shopId');
                                $attr['goodsId'] = $goodsId;
                                $attr['attrId'] = $priceAttrId;
                                $attr['attrVal'] = $name;
                                $attr['attrPrice'] = (float)I('price_price_'.$priceAttrId."_".$i);
                                /* $attr['isRecomm'] = (int)I('price_isRecomm_'.$priceAttrId."_".$i);
                                $attr['attrStock'] = (int)I('price_stock_'.$priceAttrId."_".$i); */
                                /* $totalStock = $totalStock + (int)$attr['attrStock']; */
                                $m->add($attr);
                            }
                            /* //更新商品总库存
                            $sql = "update __PREFIX__goods set goodsStock=".$totalStock." where goodsId=".$goodsId;
                            $m->query($sql); */
                        }
                    }
                }
                //保存相册
                $gallery = I("gallery");
                //var_dump($gallery);exit;
                if($gallery!=''){
                    $str = explode(',',$gallery);
                    foreach ($str as $k => $v){
                        if($v=='')continue;
                        $str1 = explode('@',$v);
                        $data = array();
                        //$data['shopId'] = session('WST_USER.shopId');
                        $data['goodsId'] = $goodsId;
                        $data['goodsImg'] = $str1[0];
                        $data['goodsThumbs'] = $str1[1];
                        $m = M('goods_gallerys');
                        $m->add($data);
                    }
                }
            }
        }
        return $rd;
    }
    
    /**
     * 编辑商品信息
     */
    public function editGoods(){
        $rd = array('status'=>-1);
        $goodsId = I("id",0);
        //$shopId = (int)session('WST_USER.shopId');
        //查询商家状态
       /*  $sql = "select shopStatus from __PREFIX__shops where shopFlag = 1 and shopId=".$shopId;
        $shopStatus = $this->query($sql);
        if(empty($shopStatus)){
            $rd['status'] = -2;
            return $rd;
        } */
        //加载商品信息
        $m = M('goods');
        $goods = $m->where('goodsId='.$goodsId)->find();
        if(empty($goods))return array();
        $data = array();
    
        $data["goodsSn"] = I("goodsSn");
        $data["goodsName"] = I("goodsName");
        $data["goodsImg"] = I("goodsImg");
        //$data["goodsThums"] = I("goodsThumbs");
        $data["marketPrice"] = (float)I("marketPrice");
        $data["shopPrice"] = (float)I("shopPrice");
        $data["goodsStock"] = (int)I("goodsStock");
        $data["isBook"] = (int)I("isBook");
        $data["bookQuantity"] = (int)I("bookQuantity");
        $data["warnStock"] = (int)I("warnStock");
        $data["goodsUnit"] = I("goodsUnit");
        $data["isBest"] = (int)I("isBest");
        $data["isRecomm"] = (int)I("isRecomm");
        $data["isNew"] = (int)I("isNew");
        $data["isHot"] = (int)I("isHot");
    
        //如果商家状态不是已审核则所有商品只能在仓库中
        /* if($shopStatus[0]['shopStatus']==1){ */
            $data["isSale"] = (int)I("isSale");
        /* }else{
            $data["isSale"] = 0;
        } */
        $data["goodsCatId1"] = (int)I("goodsCatId1");
        $data["goodsCatId2"] = (int)I("goodsCatId2");
        $data["goodsCatId3"] = (int)I("goodsCatId3");
        $data["shopCatId1"] = (int)I("shopCatId1");
        $data["shopCatId2"] = (int)I("shopCatId2");
        $data["goodsDesc"] = stripslashes(htmlspecialchars_decode($_POST['goodsDesc']));
        $data["goodsStatus"] = ($GLOBALS['CONFIG']['isGoodsVerify']['fieldValue']==1)?0:1;
        $data["attrCatId"] = (int)I("attrCatId");
        if($this->checkEmpty($data,true)){
            $data["goodsKeywords"] =  I("goodsKeywords");
            $data["brandId"] = (int)I("brandId");
            $data["goodsSpec"] = stripslashes(htmlspecialchars_decode($_POST['goodsSpec']));
            	
            	
            $rs = $m->where('goodsId='.$goods['goodsId'])->save($data);
            if(false !== $rs){
                /* if($shopStatus[0]['shopStatus']==1){ */
                    $rd['status']= 1;
                    $rd['statusCode'] = 200;
                    $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
                    $rd['closeCurrent'] = true;
                /* }else{
                    $rd['status']= -3;
                } */
                //规格属性
                if($data["attrCatId"]>0){
                    $m = M('goods_attributes');
                    //删除属性记录
                    //$m->query("delete from __PREFIX__goods_attributes where goodsId=".$goodsId);
                    $m->where(array("goodsId"=>$goodsId))->delete();
                    //获取商品类型属性列表
                    $sql = "select attrId,attrName,isPriceAttr from __PREFIX__attributes where attrFlag=1
					       and catId=".$data["attrCatId"];
                    $attrRs = $m->query($sql);
                    if(!empty($attrRs)){
                        $priceAttrId = 0;
                        $recommPrice = 0;
                        foreach ($attrRs as $key =>$v){
                            if($v['isPriceAttr']==1){
                                $priceAttrId = $v['attrId'];
                                continue;
                            }else{
                                //新增
                                $attr = array();
                                $attr['attrVal'] =  trim(I('attr_name_'.$v['attrId']));
                                $attr['attrPrice'] = 0;
                                $attr['attrStock'] = 0;
                                //$attr['shopId'] = session('WST_USER.shopId');
                                $attr['goodsId'] = $goodsId;
                                $attr['attrId'] = $v['attrId'];
                                $m->add($attr);
                            }
                        }
                        if($priceAttrId>0){
                            $no = (int)I('goodsPriceNo');
                            $no = $no>50?50:$no;
                            $totalStock = 0;
                            	
                            for ($i=0;$i<=$no;$i++){
                                $name = trim(I('price_name_'.$priceAttrId."_".$i));
                                if($name=='')continue;
                                $attr = array();
                                //$attr['shopId'] = session('WST_USER.shopId');
                                $attr['goodsId'] = $goodsId;
                                $attr['attrId'] = $priceAttrId;
                                $attr['attrVal'] = $name;
                                $attr['attrPrice'] = (float)I('price_price_'.$priceAttrId."_".$i);
                                /* $attr['isRecomm'] = (int)I('price_isRecomm_'.$priceAttrId."_".$i);
                                if($attr['isRecomm']==1){
                                    $recommPrice = $attr['attrPrice'];
                                }
                                $attr['attrStock'] = (int)I('price_stock_'.$priceAttrId."_".$i);
                                $totalStock = $totalStock + (int)$attr['attrStock']; */
                                $m->add($attr);
                            }
                            //更新商品总库存
                            /* $sql = "update __PREFIX__goods set goodsStock=".$totalStock;
                            if($recommPrice>0){
                                $sql .= ",shopPrice=".$recommPrice;
                            }
                            $sql .= " where goodsId=".$goodsId;
                            $m->query($sql); */
                        }
                    }
                }
    
                //保存相册
                $gallery = I("gallery");
                if($gallery!=''){
                    $str = explode(',',$gallery);
                    $m = M('goods_gallerys');
                    //删除相册信息
                    $m->where('goodsId='.$goods['goodsId'])->delete();
                    //保存相册信息
                    foreach ($str as $k => $v){
                        if($v=='')continue;
                        $str1 = explode('@',$v);
                        $data = array();
                        $data['shopId'] = $goods['shopId'];
                        $data['goodsId'] = $goods['goodsId'];
                        $data['goodsImg'] = $str1[0];
                        $data['goodsThumbs'] = $str1[1];
                        $m->add($data);
                    }
                }
            }
        }
        return $rd;
    }
    /**
     * 删除商品
     */
    public function delGoods($id){
        $rd = array('status'=>-1);
        $m = M('goods');
        //$shopId = (int)session('WST_USER.shopId');
        $data = array();
        $data["goodsFlag"] = -1;
        $rs = $m->where("goodsId=".$id)->save($data);
        if(false !== $rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
            $rd['closeCurrent'] = false;
        }
        return $rd;
    }
    
    /**
     * 批量删除商品
     */
    public function batchDel($ids){
        $rd = array('status'=>-1);
        $m = M('goods');
        //$shopId = (int)session('WST_USER.shopId');
        $data = array();
        $data["goodsFlag"] = -1;
        $rs = $m->where(" goodsId in(".$ids.")")->save($data);
        if(false !== $rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
            $rd['closeCurrent'] = false;
        }
        return $rd;
    }
	/**
	 * 获取商品信息
	 */
	 public function get(){
	 	$m = M('goods');
	 	$id = I('id',0);
		$goods = $m->where("goodsId=".$id)->find();
		//相册
		$m = M('goods_gallerys');
		$goods['gallery'] = $m->where('goodsId='.$id)->select();
		//商城分类
		$sql = "select c1.catName goodsName1,c2.catName goodsName2,c3.catName goodsName3
		        from __PREFIX__goods_cats c3 , __PREFIX__goods_cats c2,__PREFIX__goods_cats c1
		        where c3.parentId=c2.catId and c2.parentId=c1.catId and c3.catId=".$goods['goodsCatId3'];
		$rs = $this->query($sql);
		$goods['goodsCats'] = $rs[0];
		//店铺分类
		$sql = "select c1.catName goodsName1,c2.catName goodsName2
		        from __PREFIX__shops_cats c2 ,__PREFIX__shops_cats c1
		        where c2.parentId=c1.catId and c2.catId=".$goods['shopCatId2'];
		$rs = $this->query($sql);
		$goods['shopCats'] = $rs[0];
		//属性
		if($goods['attrCatId']>0){
			$sql = "select catName from __PREFIX__attribute_cats where catId=".$goods['attrCatId'];
			$rs = $this->query($sql);
		    $goods['attrCatName'] = $rs[0]['catName'];
		    
			//获取规格属性
			$sql = "select ga.attrVal,ga.attrPrice,ga.attrStock,a.attrId,a.attrName,a.isPriceAttr,ga.isRecomm
			            ,ga.isRecomm from __PREFIX__attributes a 
			            left join __PREFIX__goods_attributes ga on ga.attrId=a.attrId and ga.goodsId=".$id." where  
						a.attrFlag=1 and a.catId=".$goods['attrCatId']." and a.shopId=".$goods['shopId'];
			$attrRs = $m->query($sql);
			if(!empty($attrRs)){
				$priceAttr = array();
				$attrs = array();
				foreach ($attrRs as $key =>$v){
					if($v['isPriceAttr']==1){
						$goods['priceAttrName'] = $v['attrName'];
						$priceAttr[] = $v;
					}else{
						$v['attrContent'] = $v['attrVal'];
						$attrs[] = $v;
					}
				}
				$goods['priceAttrs'] = $priceAttr;
				$goods['attrs'] = $attrs;
			}
		}
		return $goods;
	 }
	 /**
	  * 分页列表[获取待审核列表]
	  */
     public function queryPenddingByPage(){
        $m = M('goods');
        $shopName = I('shopName');
     	$goodsName = I('goodsName');
     	$areaId1 = I('areaId1',0);
     	$areaId2 = I('areaId2',0);
	 	$sql = "select g.*,gc.catName,sc.catName shopCatName from __PREFIX__goods g 
	 	      left join __PREFIX__goods_cats gc on g.goodsCatId3=gc.catId 
	 	      left join __PREFIX__shops_cats sc on sc.catId=g.shopCatId2,__PREFIX__shops p 
	 	      where goodsStatus=0 and goodsFlag=1 and p.shopId=g.shopId ";
	 	if($areaId1>0)$sql.=" and p.areaId1=".$areaId1;
	 	if($areaId2>0)$sql.=" and p.areaId2=".$areaId2;
	 	if($shopName!='')$sql.=" and (p.shopName like '%".$shopName."%' or p.shopSn like '%'".$shopName."%')";
	 	if($goodsName!='')$sql.=" and (g.goodsName like '%".$goodsName."%' or g.goodsSn like '%".$goodsName."%')";
	 	$sql.="  order by goodsId desc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 分页列表[获取已审核列表]
	  */
     public function queryByPage($search,$page,$pageSize){
        $m = M('goods');
        //$shopName = I('shopName');
     	$goodsName = $search;
     	//$areaId1 = I('areaId1',0);
     	//$areaId2 = I('areaId2',0);
	 	$sql = "select g.*,gc.catName from __PREFIX__goods g 
	 	      left join __PREFIX__goods_cats gc on g.goodsCatId3=gc.catId 
	 	      
	 	      where goodsStatus=1 and goodsFlag=1 ";
	 	//if($areaId1>0)$sql.=" and p.areaId1=".$areaId1;
	 	//if($areaId2>0)$sql.=" and p.areaId2=".$areaId2;
	 	//if($shopName!='')$sql.=" and (p.shopName like '%".$shopName."%' or p.shopSn like '%".$shopName."%')";
	 	if($goodsName!='')$sql.=" and (g.goodsName like '%".$goodsName."%' or g.goodsSn like '%".$goodsName."%')";
	 	$sql.="  order by goodsId desc"; 
		return $m->pageQuery($sql,$page,$pageSize);
	 }
	 
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('goods');
	     $sql = "select * from __PREFIX__goods order by goodsId desc";
		 return $m->find($sql);
	  }
	  /**
	   * 获取同一分类的商品
	   */
	  public function getGoodsByPid($id){
	     $m = M('goods');
	     $map['goodsCatId2|goodsCatId1'] = $id;
	     $map['goodsStatus'] = 1;
	     $map['goodsFlag'] = 1;
	     $rs = $m->where($map)->select(); 
		 return $rs;
	  }
	 /**
	  * 修改商品状态
	  */
	 public function changeGoodsStatus(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$id = (int)I('id',0);
	 	$m->goodsStatus = I('status',0);
		$rs = $m->where('goodsId='.$id)->save();
		if(false !== $rs){
			$sql = "select goodsName,userId from __PREFIX__goods g,__PREFIX__shops s where g.shopId=s.shopId and g.goodsId=".$id;
			$goods = $this->query($sql);
			$msg = "";
			if(I('status',0)==0){
				$msg = "商品[".$goods[0]['goodsName']."]已被商城下架";
			}else{
				$msg = "商品[".$goods[0]['goodsName']."]已通过审核";
			}
			$yj_data = array(
				'msgType' => 0,
				'sendUserId' => session('WST_STAFF.staffId'),
				'receiveUserId' => $goods[0]['userId'],
				'msgContent' => $msg,
				'createTime' => date('Y-m-d H:i:s'),
				'msgStatus' => 0,
				'msgFlag' => 1,
			);
			M('messages')->add($yj_data);
			$rd['status'] = 1;
		}
		return $rd;
	 }
	 /**
	  * 获取待审核的商品数量
	  */
	 public function queryPenddingGoodsNum(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$sql="select count(*) counts from __PREFIX__goods where goodsStatus=0 and goodsFlag=1";
	 	$rs = $this->query($sql);
	 	$rd['num'] = $rs[0]['counts'];
	 	return $rd;
	 }
	 /**
	  * 批量修改精品状态
	  */
	 public function changeBestStatus($ids){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	//$id = I('id',0);
	 	$m->isAdminBest = 1;
		$rs = $m->where('goodsId in('.$ids.")")->save();
		if(false !== $rs){
			$rd['status'] = 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
			$rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 /**
	  * 批量修改精品状态
	  */
	 public function changeBestStatusN($ids){
	     $rd = array('status'=>-1);
	     $m = M('goods');
	     //$id = I('id',0);
	     $m->isAdminBest = 0;
	     $rs = $m->where('goodsId in('.$ids.")")->save();
	     if(false !== $rs){
	         $rd['status'] = 1;
	         $rd['statusCode'] = 200;
	         $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
	         $rd['closeCurrent'] = false;
	     }
	     return $rd;
	 }
     /**
	  * 批量修改推荐状态
	  */
	 public function changeRecomStatus($ids){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	//$id = I('id',0);
	 	$m->isAdminRecom = '1';
		$rs = $m->where('goodsId in('.$ids.")")->save();
		if(false !== $rs){
			$rd['status'] = 1;
			$rd['statusCode'] = 200;
			$rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
			$rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 /**
	  * 批量修改推荐状态
	  */
	 public function changeRecomStatusN($ids){
	     $rd = array('status'=>-1);
	     $m = M('goods');
	     //$id = I('id',0);
	     $m->isAdminRecom = '0';
	     $rs = $m->where('goodsId in('.$ids.")")->save();
	     if(false !== $rs){
	         $rd['status'] = 1;
	         $rd['statusCode'] = 200;
	         $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
	         $rd['closeCurrent'] = false;
	     }
	     return $rd;
	 }
	 /**
	  * 批量修改推荐状态
	  */
	 public function unSale($ids){
	     $rd = array('status'=>-1);
	     $m = M('goods');
	     //$id = I('id',0);
	     $m->isSale = '0';
	     $rs = $m->where('goodsId in('.$ids.")")->save();
	     if(false !== $rs){
	         $rd['status'] = 1;
	         $rd['statusCode'] = 200;
	         $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
	         $rd['closeCurrent'] = false;
	     }
	     return $rd;
	 }
	 /* 
	  * 获取推荐商品 
	  */
	 public function getRecommGoods(){
	     $m = M('goods');
	     $rs = $m->where(array('goodsStatus'=>1,'goodsFlag'=>1,'isRecomm'=>1))->select(); 
		 return $rs;
	 }
	 /* 
	  * 根据id获取商品详情信息
	  */
	 public function getGoodsById($id){
	     $m = M('goods');
	     $rs = $m->where(array('goodsId'=>$id))->find();
	     return $rs;
	 }
	 /**
	  +----------------------------------------------------------
	  * 根据ID获取商品详情
	  +----------------------------------------------------------
	  */
	 public function getDetailById($id) {
	 
	     $condition['id'] = $id;
	     $goodsList = parent::getDetail($param = array('modelName' => 'goods'), $condition);
	 
	     /* $channelDetail = ChannelModel::getChannelDetailById($articleList["cid"]);
	     $articleList["channelName"] = $channelDetail['name']; */
	     return $goodsList;
	 }
	 /**
	  +----------------------------------------------------------
	  * 根据名称获取详情
	  +----------------------------------------------------------
	  */
	 public function getDetailByName($condition) {
	 
	     $goodsList = parent::getDetail($param = array('modelName' => 'goods'), $condition);
	     unset($goodsList['cacheInfo']);
	     return $goodsList;
	 }
	 /* 
	  * 根据id获取图片 
	  *  
	  */
	 public function getGoodsImgsById($id){
	    $m = D('goods_gallerys');
	    $rs = $m->where(array('goodsId'=>$id))->order('id asc')->select();
	    return $rs;
	 }
	 /**
	  +----------------------------------------------------------
	  * 根据ID获取商品详情
	  +----------------------------------------------------------
	  */
	 public function getGoodsDetailById($id){
	     $m = D('goods');
	     $rs = $m->where(array('goodsId'=>$id))->find();
	     return $rs;
	 }
};
?>