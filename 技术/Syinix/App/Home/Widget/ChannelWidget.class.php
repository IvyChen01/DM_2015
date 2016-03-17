<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-11-22 13:12
 * @version 1.0
 * @description
 */

namespace Home\Widget;

use Think\Controller;
use Common\Model\CommonModel;


class ChannelWidget extends Controller {

    /**
      +----------------------------------------------------------
     * 获取栏目信息
     * @param  string  $field  要获取的字段名
     * @return   string  返回信息
      +----------------------------------------------------------
     */
    public function getChannelInfo($field) {
        $condition['cid'] = I('get.cid',0,'intval');
        $channelInfo = CommonModel::getDetail($param = array('modelName' => 'Channel'), $condition);
        echo  $channelInfo[$field];
    }

    /**
      +----------------------------------------------------------
     * 生成头部导航菜单
     * @param  string  $field  要获取的字段名
     * @return   string  返回信息
      +----------------------------------------------------------
     */
    public function menu(){
        
        $condition['status'] = 1;
        $cate = CommonModel::getList($param = array('modelName' => 'Channel', 'field' => '*', 'order' => 'oid ASC'), $condition);
        foreach ($cate as $k => $v) {
            if ($v['model'] == 'article') {
                $cate[$k]["link"] = '<a href="'.C('WEB_ROOT').'/index-' . $v['fid'] . '-' . $v['cid'] . '.html">' . $v['name'] . '</a>';
            } else if ($v['model'] == 'product') {
                $cate[$k]["link"] = '<a href="' . U("Product/index", 'cid=' . $v['cid']) . '">' . $v['name'] . '</a>';
            } else if ($v['model'] == 'page') {
                $cate[$k]["link"] = '<a href="'.C('WEB_ROOT').'/page-' . $v['fid'] . '-' . $v['cid'] . '.html">' . $v['name'] . '</a>';
            } else if ($v['model'] == 'link') {
                $cate[$k]["link"] = '<a href="'.C('WEB_ROOT') . $v['url']. '" target="_blank">' . $v['name'] . '</a>';
            } else {
                $cate[$k]["link"] = '<a href="' .C('WEB_ROOT'). $v['url'] . '">' . $v['name'] . '</a>';
            }
        }
        //var_dump($cate);exit;
        $this->cate = \Com\Category::unlimitedCateForLayer($cate, $name = 'child', $fid = 0);
        $this->display('Widget:menu');
    }

    /**
      +----------------------------------------------------------
     * 调出当前栏目同级子栏目
     * @param  string  $field  要获取的字段名
     * @return   string  返回信息
      +----------------------------------------------------------
     */
    public function brotherMenu() {

        $condition['status'] = 1;
        $cate = CommonModel::getList($param = array('modelName' => 'Channel', 'field' => '*', 'order' => 'oid ASC'), $condition);
        foreach ($cate as $k => $v) {
            if ($v['model'] == 'article') {
                $cate[$k]["link"] = C('WEB_ROOT').'/index-' . $v['fid'] . '-' . $v['cid'] . '.html';
            } else if ($v['model'] == 'product') {
                $cate[$k]["link"] = C('WEB_ROOT').'/index-' . $v['fid'] . '-' . $v['cid'] . '.html';
            } else if ($v['model'] == 'page') {
                $cate[$k]["link"] = C('WEB_ROOT').'/page-' . $v['fid'] . '-' . $v['cid'] . '.html';
            } else if ($v['model'] == 'link') {
                $cate[$k]["link"] = $v['url'];
            } else {
                $cate[$k]["link"] = $v['url'];
            }
        }
        $fid = I('get.pid');
        $this->brotherMenu = \Com\Category::getChilds($cate, $fid);
        $this->display('Widget:brotherMenu');
    }

    /**
      +----------------------------------------------------------
     * 显示当前栏目的所有父级分类
     * @param  string  $field  要获取的字段名
     * @return   string  返回信息
      +----------------------------------------------------------
     */
    public function linkMenu() {
        $condition['status'] = 1;
        $cate = CommonModel::getList($param = array('modelName' => 'Channel', 'field' => '*', 'order' => 'oid ASC'), $condition);
        foreach ($cate as $k => $v) {
            if ($v['model'] == 'article') {
                $cate[$k]["link"] = C('WEB_ROOT').'/index-' . $v['fid'] . '-' . $v['cid'] . '.html';
            } else if ($v['model'] == 'product') {
                $cate[$k]["link"] = C('WEB_ROOT').'/index-' . $v['fid'] . '-' . $v['cid'] . '.html';
            } else if ($v['model'] == 'page') {
                $cate[$k]["link"] = C('WEB_ROOT').'/page-' . $v['fid'] . '-' . $v['cid'] . '.html';
            } else if ($v['model'] == 'link') {
                $cate[$k]["link"] = $v['url'];
            } else {
                $cate[$k]["link"] = $v['url'];
            }
        }
        $cid = I('get.cid');
        $this->linkMenu = \Com\Category::getParents($cate, $cid);
        $this->display('Widget:linkMenu');
    }


}

?>