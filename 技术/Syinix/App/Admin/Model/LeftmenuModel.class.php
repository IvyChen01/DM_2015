<?php
/**
 * Copyright @ 2013 Infinix. All rights reserved.
 * ==============================================
 * @Description :后台栏目模型
 * @date: 2015年11月19日 下午2:44:43
 * @author: yanhui.chen
 * @version:
 */
namespace Admin\Model;
use Common\Model\CommonModel;
class LeftmenuModel extends CommonModel {
    /* 
     * 获取分类
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
            $M = M("Channel");
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
            $condition['status'] = 1;
            $Category = new \Com\Category('Leftmenu', array('id', 'pid', 'name', 'fullname'));
            //var_dump($Category->getList($condition, $id = 0, $orderby = 'oid asc'));exit; //获取分类结构
             return $Category->getList($condition, $id = 0, $orderby = 'oid asc');
        }
    }
    /* 
     * 修改数据
     *  
     *  
     */
    public function edit() {
        $M = M("Channel");
        $data = $_POST['info'];
        $data['uTime'] = time();
        if ($M->save($data)) {
            return array('statusCode' => 200, 'message' => "已经更新", 'closeCurrent' => true);
        } else {
            return array('statusCode' => 300, 'message' => "更新失败，请刷新页面尝试操作".$M->getlastsql());
        }
    }
    /**
     +----------------------------------------------------------
     * 数据删除
     * @param  array  $condition  删除条件
     * @return  array  返回执行结果
     +----------------------------------------------------------
     */
    public function remove($condition) {
        //return array('statusCode' => 200, 'message' => '没有真的删除成功');
        return $this->del($param = array('modelName' => 'Channel'), $condition);
    }
    /**
     * 修改名称
     */
    public function editName(){
        $rd = array('status'=>-1);
        $id = I("id",0);
        $data = array();
        $data["name"] = I("menuName");
        if($this->checkEmpty($data)){
            $m = M('leftmenu');
            $rs = $m->where(array("status"=>1,"id"=>$id))->save($data);
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
        $data["oid"] = I("menuSort");
        if($this->checkEmpty($data)){
            $m = M('leftmenu');
            $rs = $m->where(array("status"=>1,"id"=>$id))->save($data);
            if(false !== $rs){
                $rd['status']= 1;
            }
        }
        return $rd;
    }
    /**
     * 修改pid
     */
    public function editPid(){
        $rd = array('status'=>-1);
        $id = I("id",0);
        $data = array();
        $data["pid"] = I("menuPid");
        if($this->checkEmpty($data)){
            $m = M('leftmenu');
            $rs = $m->where(array("status"=>1,"id"=>$id))->save($data);
            if(false !== $rs){
                $rd['status']= 1;
            }
        }
        return $rd;
    }
    /* 删除栏目  */
    public function delMenu($id) {
        $rd = array('status'=>-1);
        $m = M('leftmenu');
        //获取子集
        $ids = array();
        $ids[] = (int)$id;
        $ids = $this->getChild($ids,$ids);
        $data = array();
        $data["status"] = 0;
        //$rs = $m->where(" catId in(".implode(',',$ids).")")->save();
        $rs = $m->where(" id in(".implode(',',$ids).")")->save($data);
        if(false !== $rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.DELETE_SUCCESS');
            $rd['closeCurrent'] = false;
        }
        return $rd;
    }
    
    /**
     * 迭代获取下级
     */
    public function getChild($ids = array(),$pids = array()){
        $m = M('leftmenu');
        $sql = "select id from __PREFIX__leftmenu where status=1 and pid in(".implode(',',$pids).")";
        $rs = $m->query($sql);
        if(count($rs)>0){
            $cids = array();
            foreach ($rs as $key =>$v){
                $cids[] = $v['id'];
            }
            $ids = array_merge($ids,$cids);
            return $this->getChild($ids,$cids);
    
        }else{
            return $ids;
        }
    }
    
}