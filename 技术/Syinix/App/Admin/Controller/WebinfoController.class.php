<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;
use Common\Model\BaseModel;
use Common\Model\CommonModel;

// 本类设置项目一些常用信息
class WebinfoController extends CommonController {

    /**
      +----------------------------------------------------------
     * 配置网站信息
      +----------------------------------------------------------
     */
    public function index2() {
        $this->checkSystemConfig();
    }

    public function index() {
        if (IS_POST) {
            $id = I('post.id');
            $type = I('post.type');
            $name = I('post.info');
            $code = I('post.code');
            $value = I('post.value');
            $desc = I('post.desc');
            dump($name['name']);
            $M = M('Config');
            foreach ($id as $k => $v) {
                $data['id'] = $v;
                $data['type'] = $type[$k];
                $data['name'] = $name[$k];
                $data['code'] = $code[$k];
                $data['value'] = $value[$k];
                $data['desc'] = $desc[$k];
                $result = $M->save($data);
            }
            if($result) {
                CommonModel::writeSiteConfig();
                $this->ajaxReturn(array('statusCode' => 200, 'message' => '更新成功'));
            } else {
                $this->ajaxReturn(array('statusCode' => 300, 'message' => '更新失败'));
            }
        } else {
            $list = BaseModel::getPageList($param = array('modelName' => 'Config', 'field' => '*', 'order' => 'id ASC', 'listRows' => '10'), $condition = '');
            $this->assign('list', $list['info']);
            $this->assign('page', $list['page']);
            $this->display();
        }
    }

    /**
      +----------------------------------------------------------
     * 配置网站邮箱信息
      +----------------------------------------------------------
     */
    public function setEmailConfig() {
        $this->checkSystemConfig("SYSTEM_EMAIL");
    }

    /**
      +----------------------------------------------------------
     * 配置网站信息
      +----------------------------------------------------------
     */
    public function setSafeConfig() {
        $this->checkSystemConfig("TOKEN");
    }

    /**
      +----------------------------------------------------------
     * 网站配置信息保存操作等
      +----------------------------------------------------------
     */
    private function checkSystemConfig($obj = "SITE_INFO") {
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/config_site.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $config = array_merge($config, array("$obj" => $_POST));
            //$str = $obj == "SITE_INFO" ? "网站配置信息" : $obj == "SYSTEM_EMAIL" ? "系统邮箱配置" : "安全设置";
            //if (F("config_site", $config, APP_PATH . "Common/Conf/")) {
            $content = '<?php return ' . var_export($config, true) . ';';
            if(file_put_contents(APP_PATH . "Common/Conf/config_site.php", $content)) {
                delDirAndFile(WEB_CACHE_PATH . "Runtime/Admin/~runtime.php");
                if ($obj == "TOKEN") {
                    unset($_SESSION, $_COOKIE);
                    $this->ajaxReturn(array('statusCode' => 200, 'message' => $str . '已更新，你需要重新登录', 'url' => __APP__ . '?' . time()));
                } else {
                    $this->ajaxReturn(array('statusCode' => 200, 'message' => $str . '已更新'));
                }
            } else {
                $this->ajaxReturn(array('statusCode' => 300, 'message' => $str . '失败，请检查', 'url' => __ACTION__));
            }
        } else {
            $this->display();
        }
    }

    /**
      +----------------------------------------------------------
     * 测试邮件账号是否配置正确
      +----------------------------------------------------------
     */
    public function testEmailConfig() {
        C('TOKEN_ON', false);
        $return = send_mail($_POST['test_email'], "", "测试配置是否正确", "这是一封测试邮件，如果收到了说明配置没有问题", "", $_POST);
        if ($return == 1) {
            $this->ajaxReturn(array('statusCode' => 200, 'message' => "测试邮件已经发往你的邮箱" . $_POST['test_email'] . "中，请注意查收"));
        } else {
            $this->ajaxReturn(array('statusCode' => 300, 'message' => "$return"));
        }
    }

}

?>