<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :会员控制器
* @date: 2015年10月7日 下午3:37:18
* @author: yanhui.chen
* @version:
*/

namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;

class UsersController extends CommonController {

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        parent::_initialize();
        $this->model = D('Users');
    }

    public function index() {
        $condition = $this->searchCondition();
        //var_dump($condition);exit;
        $condition['userFlag'] = 1;
        //$list = $this->model->index($condition);
        $list = $this->model->usersList($condition);
        $this->assign('search', $this->searchKeywords());
        //$this->assign('tableFields', $this->model->tableFields);
        $this->assign('total', $list['total']);
        $this->assign('list', $list['info']);
        $this->display();
    }
    /**
      +----------------------------------------------------------
     * 详情
      +----------------------------------------------------------
     */
    public function detail() {
        $condition = "userId=" . I('get.uid', 0, 'intval');
        $this->assign("info", $this->model->detail($condition));
        $this->display("addUser");
    }
    /**
         * @Description: 添加会员
         * @param variable
         * @return return_type
         * @author : yanhui.chen
         * @date: 2015年10月8日 上午11:01:14
         */
        
    public function addUser(){
        $M=M("Users");
        if (IS_POST) {
            //$this->checkToken();
            $this->ajaxReturn(D("Users")->insertUser());
        }else {
            $this->display("addUser");
        }
    }
    /**
         * @Description: 修改会员信息
         * @param variable
         * @return return_type
         * @author : yanhui.chen
         * @date: 2015年10月8日 上午11:01:54
         */
        
    public function edit() {
        $M = M("Users");
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Users")->editUser());
        } else {
            $info = D("Admin/Users")->get($_GET['uid']);
            if ($info['userId'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->display("addUser");
        }
    }
    /**
         * @Description: 删除会员
         * @param variable
         * @return return_type
         * @author : yanhui.chen
         * @date: 2015年10月8日 上午11:02:12
         */
        
    public function del(){
        $m = D('Admin/Users');
        $rs = $m->delUser($_GET['uid']);
        /* if ($rs['status']==1){
            $this->redirect(U('index'));
        } */
        $this->ajaxReturn($rs);
    }
    
    public function birthday() {
        import("Calendar");
        $Calendar = new Calendar;
        $today = date("Y-m-d");
        //公历转农历
        $nl = date("Y-m-d", $Calendar->S2L($today));
        //农历转公历
        $gl = date("Y-m-d", $Calendar->L2S($nl));
        echo "今天公历是:$today<br/>";
        echo "转为农历是:$nl<br/>";
        echo "转回公历是:$gl<br/>";
    }

    public function phpmail() {
        import("PHPMailer");
        require_once("class.smtp.php");
        $mail = new PHPMailer();

        $mail->CharSet = "UTF-8";                 //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
        $mail->IsSMTP();                            // 设定使用SMTP服务
        $mail->SMTPAuth = true;                   // 启用 SMTP 验证功能
        $mail->SMTPSecure = "ssl";                  // SMTP 安全协议
        $mail->Host = "smtp.sina.com";       // SMTP 服务器
        $mail->Port = 25;                    // SMTP服务器的端口号
        $mail->Username = "zhaoxiace";  // SMTP服务器用户名
        $mail->Password = "sina12345678";        // SMTP服务器密码
        $mail->SetFrom('zhaoxiace@sina.com', '发件人名称');    // 设置发件人地址和名称
        $mail->AddReplyTo("邮件回复人地址", "邮件回复人名称");
        // 设置邮件回复人地址和名称
        $mail->Subject = '邮件标题';                     // 设置邮件标题
        $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
        // 可选项，向下兼容考虑
        $mail->MsgHTML('');                         // 设置邮件内容
        $mail->AddAddress('xvpindex@qq.com', "收件人名称");
        //$mail->AddAttachment("images/phpmailer.gif"); // 附件 
        if (!$mail->Send()) {
            echo "发送失败：" . $mail->ErrorInfo;
        } else {
            echo "恭喜，邮件发送成功！";
        }
    }

}