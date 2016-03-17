<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :职员模型
* @date: 2015年10月29日 下午12:08:06
* @author: yanhui.chen
* @version:
*/

namespace Admin\Model;

use Think\Model;
use Common\Model\CommonModel;

class StaffsModel extends CommonModel {

    /**
      +----------------------------------------------------------
     * 定义
      +----------------------------------------------------------
     */
    public $model = 'Staffs';

    public $tableFields = array(
      'staffId' => array('name'=>'UID', 'order'=>'1'),
      'loginName' => array('name'=>'账号', 'order'=>'1'),
      'staffName' => array('name'=>'姓名', 'order'=>'1'),
      'staffStatus' => array('name'=>'状态', 'order'=>'1'),
      'oprations' =>array('name'=>'操作', 'order'=>'0')
    );

    protected $_validate = array(
      array('loginName', 'require', '姓名必填！'),
      array('loginPwd', 'require', '密码必填！'),
      array('repasswd', 'passwd', '确认密码不正确 ', 0, 'confirm'),
      array('email', 'require', '邮箱必填！'),
      array('email', 'email', '邮箱格式错误！', 2),
      array('loginName', '', '姓名已存在！', 0, 'unique', self::MODEL_INSERT),
    );

    protected $_auto = array(
      array('pass', 'md5', 3, 'function'),
      array('ifadmin', '0', self::MODEL_INSERT),
      array('ip', 'get_client_ip', 3, 'function'),
      array('createtime', 'time', 3, 'function'),
    );

    /**
      +----------------------------------------------------------
     * 管理员列表
      +----------------------------------------------------------
     */
    public function index($condition) {

        $list = $this->getPageList($param = array('modelName' => 'Staffs', 'field' => '*', 'order' => 'staffId ASC', 'listRows' => '20'), $condition);
        return $list;
    }
    /**
     * 新增
     */
    public function insertStaffs(){
        $rd = array('status'=>-1);
        $id = I("id",0);
        $data = array();
        $sdata = array();
        $data["loginName"] = I("loginName");
        $data["secretKey"] = rand(1000,9999);
        $data["loginPwd"] = md5(I("loginPwd").$data["secretKey"]);
        $data["staffName"] = I("staffName");
        //$data["staffRoleId"] = I("staffRoleId");
        $data["workStatus"] = I("workStatus");
        $data["staffStatus"] = I("staffStatus");
        $data["staffFlag"] = 1;
        $data["createTime"] = date('Y-m-d H:i:s');
        if($this->checkEmpty($data,true)){
            $data["staffNo"] = I("staffNo");
            $data["staffPhoto"] = I("staffPic");
            $m = M('staffs');
            $rs = $m->add($data);
            if(false !== $rs){
                $sdata['role_id'] = I("staffRoleId");
                $sdata['user_id'] = $rs;
                M('role_staffs')->add($sdata);
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
    public function editStaffs(){
        $rd = array('status'=>-1);
        $id = I("id",0);
        $m = M('staffs');
        $data = array();
        $sdata = array();
        $data["loginName"] = I("loginName");
        $data["staffName"] = I("staffName");
        //$data["staffRoleId"] = I("staffRoleId");
        $data["workStatus"] = I("workStatus");
        $data["staffStatus"] = I("staffStatus");
        if($this->checkEmpty($data)){
            $data["staffNo"] = I("staffNo");
            $data["staffPhoto"] = I("staffPic");
            $rs = $m->where("staffId=".I('id'))->save($data);
            if(false !== $rs){
                $sdata['role_id'] = I("staffRoleId");
                M('role_staffs')->where("user_id=".I('id'))->save($sdata);
                $rd['status']= 1;
                $rd['statusCode'] = 200;
                $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
                $rd['closeCurrent'] = true;
                $staffId = (int)session('WST_STAFF.staffId');
                if($staffId==$id){
                    session('WST_STAFF.loginName',$data["loginName"]);
                    session('WST_STAFF.staffName',$data["staffName"]);
                    session('WST_STAFF.staffRoleId',$data["staffRoleId"]);
                    session('WST_STAFF.workStatus',$data["workStatus"]);
                    session('WST_STAFF.staffStatus',$data["staffStatus"]);
                    session('WST_STAFF.staffNo',$data["staffNo"]);
                    session('WST_STAFF.staffPhoto',$data["staffPhoto"]);
                }
    
            }
        }
        return $rd;
    }
    /**
     * 删除
     */
    public function delStaffs($id){
        $rd = array('status'=>-1);
        if($id==session('WST_STAFF.staffId'))return $rd;
        $m = M('staffs');
        $data = array();
        $data["staffFlag"] = -1;
        $rs = $m->where("staffId=".$id)->save($data);
        if(false !== $rs){
            $rd['status']= 1;
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
            $rd['closeCurrent'] = false;
        }
        return $rd;
    }
    /**
     * 显示否显示/隐藏
     */
    public function editStatus(){
        $rd = array('status'=>-1);
        if(I('id',0)==0)return $rd;
        $m = M('staffs');
        $m->staffStatus = (I('staffStatus')==1)?1:0;
        $rs = $m->where("staffId=".I('id',0))->save();
        if(false !== $rs){
            $rd['status']= 1;
        }
        return $rd;
    }
    /**
     * 修改职员密码
     */
    public function editPass($id = ''){
        $id = ($id == '') ? I('staffId') : $id;
        $rd = array('status'=>-1);
        $data = array();
        $newPass = I('pwd');
        $reNewPass = I('pwd1');
        
        if ($newPass == $reNewPass) {
            $data['loginPwd'] = $newPass;
            if ($this->checkEmpty($data,true)) {
                $rs = $this->where('staffId=%d',$id)->find();
                if ($rs['loginPwd']==md5(I("pwd0").$rs['secretKey'])) {
                    
                    $data["loginPwd"] = md5($newPass.$rs['secretKey']);
                    $rs = $this->where("staffId = %d",$id)->save($data);
                    if ($rs !== false) {
                        setcookie("$this->loginMarked", NULL, -3600, "/");
                        unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
                        $rd['status']= 1;
                        $rd['statusCode'] = 200;
                        $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
                        $rd['closeCurrent'] = true;
                    }
                }
            }
        }
        
        return $rd;
    }

    /**
      +----------------------------------------------------------
     * 数据详情
      +----------------------------------------------------------
     */
    public function detail($condition){
        return $this->getDetail($param = array('modelName' => $this->model), $condition);
    }

    //protected $trueTableName = 'top_user';
    //获得用户详情
    public function getMemberDetailByUid($uid) {
        if (isset($uid)) {
            $map["uid"] = $uid;
            return M("Staffs")->where($map)->find();
        }
    }

    //获得用户列表
    public function getMemberListByAll() {
        return M("Staffs")->select();
    }
    /**
     * 获取指定对象
     */
    public function get($id){
        $m = M('staffs');
        return $m->where("staffId=".$id)->find();
    }
    //编辑用户
    public function edit() {
        $M = M("Staffs");
        $data = $_POST['info'];
        $data['update_time'] = time();
        if ($M->save($data)) {
            return array('status' => 1, 'info' => "已经更新", 'url' => U('Member/index'));
        } else {
            return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
        }
    }
    /**
     * 查询登录关键字
     */
    public function checkLoginKey(){
        $rd = array('status'=>-1);
        $key = I('clientid');
        if($key!=''  && I($key)=='')return $rd;
        $m = M('staffs');
        $rs = $m->where(" loginName ='%s'",array(I("loginName")))->count();
        if($rs==0) $rd['status'] = 1;
        return $rd;
    }
}
?>
