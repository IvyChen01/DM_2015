<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :会员控制器
* @date: 2015年11月4日 上午11:31:32
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;

class MemberController extends CommonController {

    public function reg() {

        if ($_POST) {
            if ($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！！');
            }
            load('extend');
            $Member = D("Admin/Member");
            if ($data = $Member->create()) {
                $data["reg_ip"] = get_client_ip();
                $data["reg_date"] = time();
                $data["passwd"] = md5($data["passwd"]);
                if (false !== $Member->add($data)) {
                    $this->success('注册成功！');
                } else {
                    $this->error('注册失败！');
                }
            } else {
                header("Content-Type:text/html; charset=utf-8");
                echo($Member->getError());
            }
        } else {
            $this->display();
        }
    }

    public function login() {

        if ($_POST) {
            $email = $_POST["email"];
            $password = $_POST["passwd"];
            $w['email'] = array('eq', $email);
            $rset = M("Member")->where($w)->find();
            if (!$rset) {
                $this->error('邮箱帐户不存在，请重试！');
                return false;
            } else {
                if ($rset['passwd'] == md5($password)) {
                    $_SESSION['uid'] = $rset['uid']; //设置登录session
                    $_SESSION['email'] = $_POST['email']; //设置登录session
                    $_SESSION['name'] = $rset['name']; //设置管理员session
                    $_SESSION['mobile'] = $rset['mobile'];
                    //Cookie::set('user_a',$_POST['name'],time()+3600);  之前是用cookie登录
                    //Cookie::set('ifadmin',$rset['ifadmin'],time()+3600);
                    //$this->assign("jumpUrl", "__APP__/Index");
                    $this->success("登录成功！", "userCenter");
                } else {
                    $this->error('密码错误！！！,忘记密码请找管理员.');
                }
            }
        } else {
            $this->display();
        }
    }

    public function loginOut() {

        session_destroy();
        $this->redirect("login");
    }

    //用户中心
    public function userCenter() {

        $this->isMemberLoginIn();
        $this->assign("profileList", D("Admin/Member")->getMemberDetailByUid($_SESSION["uid"]));

        $this->display();
    }

    //个人资料
    public function profile() {

        if (IS_POST) {
            $M = M("Member");
            $data = $_POST['info'];
            $data['update_time'] = time();
            if ($M->save($data)) {
                $this->success("修改成功！", "profile");
            } else {
                $this->error("修改失败，请重试！", "profile");
            }
        } else {
            $this->isMemberLoginIn();
            $this->assign("profileList", D("Admin/Member")->getMemberDetailByUid($_SESSION["uid"]));

            $this->display();
        }
    }

    //判断前台用户是否登陆进系统
    public function isMemberLoginIn() {
        if (!isset($_SESSION["uid"])) {
            $this->error("请先登陆！", "login");
        }
    }

    //餐位预订
    public function canWeiYuDing() {
        if ($_POST) {
            $Order = M("order");
            $data = $Order->create();
            if ($data["canWeiHao"] == "" or $_POST["dinnerDate"] == "" or $_POST["dinnerTimeHour"] == "" or $_POST["dinnerTimeMinute"] == "" or $data["submitter"] == "" or $data["mobile"] == "") {
                $this->error("预订失败，请将信息填写完全再提交！", "canWeiYuDing");
            }
            $data["uid"] = $_SESSION["uid"];
            $data["orderNo"] = date("YmdHis") . rand(1000, 9999);
            $data["yongCanTime"] = $_POST["dinnerDate"] . " " . $_POST["dinnerTimeHour"] . ":" . $_POST["dinnerTimeMinute"];
            $data["subTime"] = date("Y-m-d H:i:s");
            if ($Order->add($data)) {
                //给前台客服发送短信提醒
                $smsText = '您有一条订单需要处理，预订餐位号：' . $data["canWeiHao"] . ',预订人：' . $data["submitter"] . '，电话：' . $data["mobile"] . '【益竹餐饮】';
                D("Admin/Common")->sendSMS($this->siteConfig["SITE_INFO"]["mobilephone"], $smsText);
                //给客户发送短信提醒
                $customerText = '您的订餐信息已成功提交，请等待前台客服与您联系确认！【益竹餐饮】';
                D("Admin/Common")->sendSMS($data["mobile"], $customerText);

                $this->success("预订成功！请等待前台与您电话联系确认", "userCenter");
            } else {
                $this->error("预订失败！", "userCenter");
            }
        } else {
            if ($_GET["type"] == "huiyuan") {
                $this->isMemberLoginIn();
            }
            $this->display();
        }
    }

}

?>