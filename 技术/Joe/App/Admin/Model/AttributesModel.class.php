<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :商品属性模型
* @date: 2015年11月11日 下午2:30:41
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel; 
class AttributesModel extends CommonModel {

    /**
     * 保存属性记录
     */
    function editAttr($id)
    {
        $m = M('attributes');
        $rd = array(
            'status' => - 1
        );
        $catId = (int) I('catId');
        $attrName = trim(I('attrName'));
        if ($attrName == '')
            continue;
        $data = array();
        $data['catId'] = $catId;
        if ($id > 0) {
            $data['attrName'] = $attrName;
            $data['isPriceAttr'] = (int) I('isPriceAttr');
            $data['attrType'] = (int) I('attrType');
            if ($data['attrType'] == 1 || $data['attrType'] == 2)
                $data['attrContent'] = trim(I('attrContent'));
            $data['attrSort'] = (int) I('attrSort');
            $m->where(' catId=' . $catId . ' and attrId=' . $id)->save($data);
        } else {
            $data['attrName'] = $attrName;
            $data['isPriceAttr'] = (int) I('isPriceAttr');
            $data['attrType'] = (int) I('attrType');
            if ($data['attrType'] == 1 || $data['attrType'] == 2)
                $data['attrContent'] = trim(I('attrContent'));
            $data['attrSort'] = (int) I('attrSort');
            $data['attrFlag'] = 1;
            $data['createTime'] = date('Y-m-d H:i:s');
            $rs = $m->add($data);
        }
        $rd['status']= 1;
        $rd['statusCode'] = 200;
        $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
        $rd['closeCurrent'] = true;
	 	return $rd;
	 }
	 /**
	  * 获取指定对象
	  */
     public function get($id){
     	$m = M('attributes');
		return $m->where(" attrId=".$id)->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage($array,$page,$pageSize){
     	 //$catId = (int)I('catId');
     	 $m = M('attributes');
     	 $attrName = $array["attrName"];
     	 $catId = $array["catId"];
     	 $sql = "select * from __PREFIX__attributes ";
     	 $sql .= " where attrFlag=1";
     	 $sql .= " and catId = $catId";
     	 if($attrName!=""){
     	     $sql .= " and attrName like '%$attrName%'";
     	 }
     	 $sql .= " order by attrId desc ";
     	 return $m->pageQuery($sql,$page,$pageSize);
     	 
		 //return $m->where(' attrFlag=1')->order('attrSort asc,attrId asc')->select();
	 }
	 /**
	  * 获取列表
	  */
	 public function attrList($condition){
	     $list = $this->getPageList($param = array('modelName' => 'attributes', 'field' => '*', 'order' => 'attrId desc', 'listRows' => '20'), $condition);
	     return $list;
	 }
	 
	 
	 /**
	  * 下拉列表
	  */
     public function queryByList(){
     	 $catId = (int)I('catId');
     	 $m = M('attributes');
     	 $shopId = (int)session('WST_USER.shopId');
		 return $m->where('shopId='.$shopId.' and attrFlag=1 and catId='.$catId)->order('attrSort asc,attrId asc')->select();
	 }
	 
     /**
	  * 下拉列表2
	  */
     public function queryByListForGoods(){
     	 $catId = (int)I('catId');
     	 $m = M('attributes');
     	 
		 $rs = $m->where(' attrFlag=1 and catId='.$catId)->order('attrSort asc,attrId asc')->select();
         foreach ($rs as $key => $v){
		     //分解下拉和多选的选项
		     if($rs[$key]['attrType']==1 || $rs[$key]['attrType']==2){
				$rs[$key]['opts']['txt'] = explode(',',$rs[$key]['attrContent']);
		     }
		     
		}
		return $rs;
	 }
	 
	 /**
	  * 删除
	  */
	 public function delAttr($id){
	    $rd = array('status'=>-1);
	    if($id==0)return $rd;
	    /* $m = M('goods_attributes');
		//删除相关商品的属性
		$m->where(" attrId in(".implode(',',$ids).")")->delete(); */
	    //删除属性
	    $m = M('attributes');
	    $m->attrFlag = -1;
	    $rs = $m->where("attrId=".$id)->save();
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