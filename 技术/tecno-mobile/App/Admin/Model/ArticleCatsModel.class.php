<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :文章栏目模型
* @date: 2015年10月9日 上午10:43:23
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;
use Think\Model;
use Common\Model\CommonModel;

class ArticleCatsModel extends CommonModel {
    
    public $model = 'ArticleCats';
    /**
	  * 新增
	  */
	 public function insertCats(){
	 	$rd = array('status'=>-1);
	 	//$id = I("id",0);
	 	$child = I('addChild');
		$data = array();
		$data["parentId"] = I("parentId");
		$data["catType"] = I("catType",0);
		$data["isShow"] = I("isShow",1);
		$data["catName"] = I("catName");
		$data["catSort"] = I("catSort",0);
		$data["catFlag"] = 1;
		$data["lang"] = I("lang");
	    if($this->checkEmpty($data,true)){
			$m = M('article_cats');
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
	 public function editCats($id){
	 	$rd = array('status'=>-1);
		$data = array();
		$data["isShow"] = I("isShow");
		$data["catName"] = I("catName");
		$data["catSort"] = I("catSort");
		$data["lang"] = I("lang");
	    if($this->checkEmpty($data)){	
			$m = M('article_cats');
		    $rs = $m->where("catId=".$id)->save($data);
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
	  * 修改名称
	  */
	 public function editName(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["catName"] = I("catName");
	    if($this->checkEmpty($data)){
	    	$m = M('article_cats');
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
	         $m = M('article_cats');
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
     public function get(){
	 	$m = M('article_cats');
		return $m->where("catId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('article_cats');
	 	$sql = "select * from __PREFIX__article_cats order by catSort asc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList($pid){
	     $m = M('article_cats');
	     return $m->where('catFlag=1 and parentId='.$pid)->order('catSort asc,catId asc')->select(); 
	  }
	 /**
	  * 迭代获取下级
	  */
	 public function getChild($ids = array(),$pids = array()){
	 	$m = M('article_cats');
	 	$sql = "select catId from __PREFIX__article_cats where catFlag=1 and parentId in(".implode(',',$pids).")";
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
	 public function delCats($id){
	 	$rd = array('status'=>-1);
	 	//获取子集
	 	$ids = array();
		$ids[] = $id;
	 	$ids = $this->getChild($ids,$ids);
	 	//var_dump($ids);exit;
	 	$m = M('article_cats');
	 	$m->catFlag = -1;
		$rs = $m->where(" catId in(".implode(',',$ids).")")->save();
	    if(false !== $rs){
		   $rd['status']= 1;
		   $rd['statusCode'] = 200;
		   $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
		   $rd['closeCurrent'] = false;
		}
		return $rd;
	 }
	 /**
	  * 显示商品是否显示/隐藏
	  */
	 public function editiIsShow(){
	 	$rd = array('status'=>-1);
	 	if(I('id',0)==0)return $rd;
	 	//获取子集
	 	$ids = array();
		$ids[] = (int)I('id');
	 	$ids = $this->getChild($ids,$ids);
	 	$m = M('article_cats');
	 	$m->isShow = (I('isShow')==1)?1:0;
	 	$rs = $m->where("catId in(".implode(',',$ids).")")->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }

	 /**
	  * 获取所有的类别，并且添加层级
	  */
	 public function getCatLists(){	
	 	$sql = "select * from ec_article_cats where catFlag = 1 order by catSort asc";
	 	$catList = $this->query($sql);

	 	if ($catList !== false) {	 		
	 		$catList = self::unlimitedForLevel($catList);	 		
	 	}
	 	return $catList;
	 }
	 
	 /**
	  * 获取所有的类别，并且添加层级
	  */
	 public function getCatListslang($lang){
	     $sql = "select * from ec_article_cats where catFlag = 1 and lang= ".$lang." order by catSort asc";
	     $catList = $this->query($sql);
	     if ($catList !== false) {
	         $catList = self::unlimitedForLevel($catList);
	     }
	     return $catList;
	 }
     
	 Static Public function unlimitedForLevel($cate,$html='&nbsp;&nbsp;',$parentId=0,$level=0){
		$arr = array();
		foreach ($cate as $v) {
			if ($v['parentId'] == $parentId) {
				$v['level'] = $level + 1;
				$html2 = $level==0 ? '' : '|--';//生成目录|--
				$v['html'] = str_repeat($html,$level).$html2;
				$v['catName'] = $v['html'].$v['catName'];
				$arr[]=$v;
				$arr = array_merge($arr,self::unlimitedForLevel($cate,$html,$v['catId'],$level + 1));
			}
		}
		return $arr;
	}
	public function category() {
	    if (IS_POST) {
	        $act = $_POST[act];
	        $data = $_POST['data'];
	        $data['name'] = addslashes($data['name']);
	        $M = M("Category");
	        if ($act == "add") { //添加分类
	            unset($data[cid]);
	            if ($M->where($data)->count() == 0) {
	                return ($M->add($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功添加到系统中', 'url' => U('Article/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 添加失败');
	            } else {
	                return array('status' => 0, 'info' => '系统中已经存在分类' . $data['name']);
	            }
	        } else if ($act == "edit") { //修改分类
	            if (empty($data['name'])) {
	                unset($data['name']);
	            }
	            if ($data['pid'] == $data['cid']) {
	                unset($data['pid']);
	            }
	            if (empty($data['status'])) {
	                $data['status'] == 0;
	            }
	            return ($M->save($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功更新', 'url' => U('Article/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 更新失败');
	        } else if ($act == "del") { //删除分类
	            unset($data['pid'], $data['name'], $data['oid'], $data['type'], $data['status']);
	            return ($M->where($data)->delete()) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功删除', 'url' => U('Article/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 删除失败');
	        }
	    } else {
	        $condition['catFlag'] = 1;
	        $cat = new \Com\Category('article_cats', array('catId', 'parentId', 'catName', 'catName'));
	        return $cat->getList($condition, $cid = 0, $orderby = 'catSort asc');               //获取分类结构
	    }
	}
}
?>