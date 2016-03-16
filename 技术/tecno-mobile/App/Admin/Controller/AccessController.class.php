<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :权限控制器
* @date: 2015年10月31日 上午10:46:15
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;

class AccessController extends CommonController {

    /**
      +----------------------------------------------------------
     * 管理员列表
      +----------------------------------------------------------
     */
    public function index() {
        $this->assign('thead', D('Access')->thead);
        $list = D("Access")->adminList();
        $this->assign("list", $list['info']);
        $this->assign("page", $list['page']);
        $this->display();
    }

    public function nodeList() {
        $this->assign("list", D("Access")->nodeList());
        $this->display();
    }

    public function roleList() {
        $this->assign("list", D("Access")->roleList());
        $this->display();
    }

    public function addRole() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            $this->ajaxReturn(D("Access")->addRole());
        } else {
            $this->assign("info", $this->getRole());
            $this->display("editRole");
        }
    }

    public function editRole() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            $this->ajaxReturn(D("Access")->editRole());
        } else {
            $M = M("Role");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该角色", U('Access/roleList'));
            }
            $this->assign("info", $this->getRole($info));
            $this->display();
        }
    }

    public function opNodeStatus() {
        header('Content-Type:application/json; charset=utf-8');
        $this->ajaxReturn(D("Access")->opStatus("Node"));
    }

    public function opRoleStatus() {
        header('Content-Type:application/json; charset=utf-8');
        $this->ajaxReturn(D("Access")->opStatus("Role"));
    }

    public function opSort() {
        $M = M("Node");
        $datas['id'] = (int) $this->_post("id");
        $datas['sort'] = (int) $this->_post("sort");
        header('Content-Type:application/json; charset=utf-8');
        if ($M->save($datas)) {
            $this->ajaxReturn(array('status' => 1, 'info' => "处理成功"));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => "处理失败"));
        }
    }

    public function editNode() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            $this->ajaxReturn(D("Access")->editNode());
        } else {
            $M = M("Node");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该节点", U('Access/nodeList'));
            }
            $this->assign("info", $this->getPid($info));
            $this->display();
        }
    }

    public function addNode() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            $this->ajaxReturn(D("Access")->addNode());
        } else {
            $this->assign("info", $this->getPid(array('level' => 1)));
            $this->display("editNode");
        }
    }
    /* 
     * 删除节点
     */
    public function del(){
        $rs =D("Access")->delNode($_GET['id']);
        $this->ajaxReturn($rs);
    }
    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function addAdmin() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            $this->ajaxReturn(D("Access")->addAdmin());
        }  else {
            $this->assign("info", $this->getRoleListOption(array('role_id' => 0)));
            $this->display();
        } 
    }

    public function changeRole() {
        header('Content-Type:application/json; charset=utf-8');
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Access")->changeRole());
        } else {
            $M = M("Role");
            $info = M("Role")->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该用户组", U('Access/roleList'));
            }
            
            //$access = M("Access")->field("CONCAT(`node_id`,':',`level`,':',`pid`) as val")->where("`role_id`=" . $info['id'])->select();
            $access = M("Access")->field("CONCAT(`node_id`) as val")->where("`role_id`=" . $info['id'])->select();
            //$access = M("Access")->field("`rules` as val")->where("`id`=" . $info['id'])->select();
            //var_dump($access);exit;
            //$access = explode(',', $access[0]['val']);
            $info['access'] = count($access) > 0 ? json_encode($access) : json_encode(array());
            //var_dump($info);exit;
            $this->assign("info", $info);
            $nm = D('node');
            $datas = $nm->where(array('level'=>1))->order('sort ASC')->select();
            foreach ($datas as $k => $v) {
                $map['level'] = 2;
                $map['pid'] = $v['id'];
                $datas[$k]['data'] = $nm->where($map)->order('sort ASC')->select();
                foreach ($datas[$k]['data'] as $k1 => $v1) {
                    $map['level'] = 3;
                    $map['pid'] = $v1['id'];
                    $datas[$k]['data'][$k1]['data'] = $nm->where($map)->select();
                }
            }
            $this->assign("nodeList", $datas);
            $this->display("changeRole");
        }
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function editAdmin() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            $this->ajaxReturn(D("Access")->editAdmin());
        } else {
            $M = M("User");
            $uid = (int) $_GET['uid'];
            $pre = C("DB_PREFIX");
            $info = $M->where("`uid`=" . $uid)->join($pre . "auth_group_access ON " . $pre . "user.uid = " . $pre . "auth_group_access.uid")->find();
            
            if (empty($info['uid'])) {
                $this->error("不存在该管理员ID", U('Access/index'));
            }
            if ($info['email'] == C('ADMIN_AUTH_KEY')) {
                $this->error("超级管理员信息不允许操作", U("Access/index"));
                exit;
            }
            
            $this->assign("info", $this->getRoleListOption($info));
            $this->display("addAdmin");
        }
    }

    private function getRole($info = array()) {
        $cat = new \Com\Category('Role', array('id', 'pid', 'title', 'fullname'));
        $list = $cat->getList();               //获取分类结构
        foreach ($list as $k => $v) {
            $disabled = $v['id'] == $info['id'] ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['pid'] ? ' selected="selected"' : "";
            $info['pidOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }

    private function getRoleListOption($info = array()) {
        $cat = new \Com\Category('Role', array('id', 'pid', 'title', 'fullname'));
        $list = $cat->getList();               //获取分类结构
        $info['roleOption'] = "";
        foreach ($list as $v) {
            $disabled = $v['id'] == 1 ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['group_id'] ? ' selected="selected"' : "";
            $info['roleOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }

    private function getPid($info) {
        $arr = array("请选择", "项目", "模块", "操作");
        for ($i = 1; $i < 4; $i++) {
            $selected = $info['level'] == $i ? " selected='selected'" : "";
            $info['levelOption'].='<option value="' . $i . '" ' . $selected . '>' . $arr[$i] . '</option>';
        }
        $level = $info['level'] - 1;
        $cat = new \Com\Category('Node', array('id', 'pid', 'title', 'fullname'));
        $list = $cat->getList();               //获取分类结构
        $option = $level == 0 ? '<option value="0" level="-1">根节点</option>' : '<option value="0" disabled="disabled">根节点</option>';
        foreach ($list as $k => $v) {
            //$disabled = $v['level'] == $level ? "" : ' disabled="disabled"';
            $disabled = $v['level'] == $level ? "" : '';
            $selected = $v['id'] != $info['pid'] ? "" : ' selected="selected"';
            $option.='<option value="' . $v['id'] . '"' . $disabled . $selected . '  level="' . $v['level'] . '">' . $v['fullname'] . '</option>';
        }
        $info['pidOption'] = $option;
        return $info;
    }

}