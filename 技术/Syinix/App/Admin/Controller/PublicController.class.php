<?php
namespace Admin\Controller;

use Think\Controller;

class PublicController extends Controller {

    public $loginMarked;

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        header('Content-Type:application/json; charset=utf-8');
        $loginMarked = C("TOKEN");
        $this->loginMarked = md5($loginMarked['admin_marked']);
    }

    /**
      +----------------------------------------------------------
     * 验证token信息
      +----------------------------------------------------------
     */
    private function checkToken() {
        if (!M("Staffs")->autoCheckToken($_POST)) {
            die(json_encode(array('status' => 0, 'info' => '令牌验证失败')));
        }
        unset($_POST[C("TOKEN_NAME")]);
    }

    public function index() {
        if (IS_POST) {
            $this->checkToken();
            $returnLoginInfo = D("Public")->auth();
            //生成认证条件
            if ($returnLoginInfo['statusCode'] == 200) {
                /* $map = array();
                // 支持使用绑定帐号登录
                $map['username'] = $_POST["username"];
                import('ORG.Util.RBAC');
                $RBAC = new \Org\Util\Rbac();
                $authInfo = $RBAC->authenticate($map);
                var_dump($authInfo);exit;
                $_SESSION[C('USER_AUTH_KEY')] = $authInfo['staffId'];
                $_SESSION['username'] = $authInfo['loginName'];
                if ($authInfo['loginName'] == C('ADMIN_AUTH_KEY')) {
                    $_SESSION[C('ADMIN_AUTH_KEY')] = true;
                }
                // 缓存访问权限
                $RBAC->saveAccessList(); */
                $this->ajaxReturn($returnLoginInfo);
            }
            
        } else {
            
            if (isset($_COOKIE[$this->loginMarked])) {
                
                $this->redirect("Index/index");
            }

            $this->display("Common:login");
        }
    }

    /**
    +----------------------------------------------------------
    * 显示验证码
    +----------------------------------------------------------
    */
    public function verify_code() {
        $config = array(
            'fontSize' => 12, // 验证码字体大小    
            'length' => 4, // 验证码位数    
            'useNoise' => false, // 关闭验证码杂点
            'imageW' => 110,
            'imageH' => 34,
            'codeSet' => '0123456789',
            'fontSize' => 16,
            'fontttf' => '4.ttf'
        );
        ob_clean();
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    /**
    +----------------------------------------------------------
    * 退出登陆
    +----------------------------------------------------------
    */
    public function loginOut() {
        setcookie("$this->loginMarked", NULL, -3600, "/");
        unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION);
            session_destroy();
        }
        $this->redirect("Index/index");
    }

    public function findPwd() {
        $M = M("Admin");
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("Public")->findPwd());
        } else {
            setcookie("$this->loginMarked", NULL, -3600, "/");
            unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
            $cookie = $this->_get('code');
            $shell = substr($cookie, -32);
            $aid = (int) str_replace($shell, '', $cookie);
            $info = $M->where("`aid`='$aid'")->find();
            if ($info['status'] == 0) {
                $this->error("你的账号被禁用，有疑问联系管理员吧", __APP__);
            }
            if (md5($info['find_code']) == $shell) {
                $this->assign("info", $info);
                $_SESSION['aid'] = $aid;
                $siteConfig = include APP_PATH . 'Common/Conf/siteConfig.php';
                $this->assign("siteConfig", $siteConfig);
                $this->display("Common:findPwd");
            } else {
                $this->error("验证地址不存在或已失效", __APP__);
            }
        }
    }

}