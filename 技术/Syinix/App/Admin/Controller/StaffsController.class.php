<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 内部工作人员控制器
* @date: 2015年10月28日 上午10:43:21
* @author: yanhui.chen
* @version:
*/
namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;

class StaffsController extends CommonController {

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        parent::_initialize();
        $this->model = D('Staffs');
    }

    public function index() {
        $condition = $this->searchCondition();
        //$condition['isDel'] = 0;
        $condition['staffFlag'] = 1;
        $list = $this->model->index($condition);
        
        foreach ($list['info'] as $k=>$v){
            $role = D('Role');
            $roleName = $role->getRoleNameById($v['staffId']);
            $list['info'][$k]['roleName'] = $roleName;
            $list['info'][$k]['status'] = ($v['staffStatus']=='1')?'启用':'停用';
        }
        $this->assign('search', $this->searchKeywords());
        //$this->assign('tableFields', $this->model->tableFields);
        $this->assign('list', $list['info']);
        $this->assign('total', $list['total']);
        $this->display();
        
        
    }
    /**
     * 跳到新增/编辑页面
     */
    public function toEdit(){
        $r = D('Admin/Access');
        $m = M('role_staffs');
        $object = array();
        if(I('staffId',0)>0){
            $object = $this->model->get(I('staffId',0));
            $role_id = $m->field('role_id')->where('user_id ='.I('staffId',0))->find();
            $object['staffRoleId'] = $role_id['role_id'];
        }else{
            $object = $this->model->getModel2();
            $object['staffStatus'] = 1;
        }
        $this->assign('roleList',$r->roleList());
        $this->assign('object',$object);
        $this->display('add');
    }
    /**
     * 新增/修改操作
     */
    public function edit(){
        //$this->isAjaxLogin();
        $rs = array();
        if(I('id',0)>0){
            //$this->checkAjaxPrivelege('hydj_02');
            $rs = $this->model->editStaffs();
        }else{
            //$this->checkAjaxPrivelege('hydj_01');
            $rs = $this->model->insertStaffs();
        }
        $this->ajaxReturn($rs);
    }
    /**
     * 删除操作
     */
    public function del(){
        //$this->isAjaxLogin();
        //$this->checkAjaxPrivelege('hydj_03');
        $rs = $this->model->delStaffs($_GET['staffId']);
        $this->ajaxReturn($rs);
    }
    /**
     * 查询用户账号
     */
    public function checkLoginKey(){
        $m = D('Admin/Staffs');
        $rs = $m->checkLoginKey();
        $this->ajaxReturn($rs);
    }
    /**
      +----------------------------------------------------------
     * 详情
      +----------------------------------------------------------
     */
    public function detail() {
        var_dump(2);exit;
        $condition = "uid=" . I('get.uid', 0, 'intval');
        $this->assign("info", $this->model->detail($condition));
        $this->display();
    }

   /*  public function edit() {
        $M = M("Staffs");
        if (IS_POST) {
            //$this->checkToken();
            $this->ajaxReturn(D("Staffs")->edit());
        } else {
            $info = D("Admin/Staffs")->getMemberDetailByUid((int) $_GET['uid']);
            //var_dump($info);exit;
            if ($info['uid'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->display("add");
        }
    } */
    
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