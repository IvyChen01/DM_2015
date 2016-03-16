<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :common模型
* @date: 2015年11月3日 上午11:07:12
* @author: yanhui.chen
* @version:
*/

namespace Common\Model;

use Think\Model;

class CommonModel extends BaseModel {


    /**
      +----------------------------------------------------------
     * 发送短信
      +----------------------------------------------------------
     */
    public function sendSMS($smsMob, $smsText) {
        if (strlen($smsMob) == 11) {
            $Uid = 'xvpindex';
            $Key = 'd412c80ca0bb6f5ddc72';
            //$smsMob = "18910886243";
            //$smsText = '您有一条订单需要处理，预订餐位号：' . $data["canWeiHao"] . ',预订人：' . $data["submitter"] . '，电话：' . $data["mobile"] . '【益竹餐饮】';
            $url = 'http://utf8.sms.webchinese.cn/?Uid=' . $Uid . '&Key=' . $Key . '&smsMob=' . $smsMob . '&smsText=' . $smsText;

            if (function_exists('file_get_contents')) {
                $file_contents = file_get_contents($url);
            } else {
                $ch = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $file_contents = curl_exec($ch);
                curl_close($ch);
            }
            return $file_contents;
        }
    }

    /**
     +----------------------------------------------------------
     * 左侧导航菜单
     +----------------------------------------------------------
     */
    public function leftMenu() {
        $M = M("Leftmenu");
        $condition1['pid'] = 0;
        $condition1['status'] = 1;
        $list['level'] = $M->field('id,pid,name,fullname')->where($condition1)->order('oid ASC')->select();

        $condition['status'] = 1;
        foreach ($list['level'] as $k => $v) {
            $condition['id'] = array('neq', $v['id']);
            $condition['pid'] = $v['id'];
            $list['menu'][$k] = $M->where($condition)->order('oid ASC')->select();
        }
        //var_dump($list['menu']);exit;
        return $list;
    }

    /**
     +----------------------------------------------------------
     * 获取站点配置
     +----------------------------------------------------------
     */
    public static function getSiteConfig() {
        $siteConfigArr = parent::getList($param = array('modelName' => 'Config', 'field' => '*', 'order' => 'id ASC'), $condition = '');
        foreach ($siteConfigArr as $k => $v) {
            if($v['code'] == 'counter')
                $siteConfig[$v['code']] = htmlspecialchars_decode($v['value']);
            else
                $siteConfig[$v['code']] = $v['value'];
        }
        return $siteConfig;
    }

    /**
      +----------------------------------------------------------
     * 将数据库站点配置写入文件中
      +----------------------------------------------------------
     */
    public static function writeSiteConfig() {
        $siteConfig = self::getSiteConfig();
        $siteConfig['TOKEN']['admin_marked'] = "xvpindex@qq.com";
        $siteConfig['TOKEN']['admin_timeout'] = 3600;
        $siteConfig['TOKEN']['member_marked'] = "http://www.topstack.cn";
        $siteConfig['TOKEN']['member_timeout'] = 3600;
        //F("config_site", $siteConfig, APP_PATH . "Common/Conf/");
        $content = '<?php return ' . var_export($siteConfig, true) . ';';
        file_put_contents(APP_PATH . "Common/Conf/config_site.php", $content);
        if (is_dir(WEB_ROOT . "install/")) {
            delDirAndFile(WEB_ROOT . "install/", TRUE);
        }
    }

    /**
      +----------------------------------------------------------
     * 根据用户uid获取用户姓名
      +----------------------------------------------------------
     */
    public static function getUserFullNameByUid($uid, $type) {
        $condition['staffId'] = $uid;
        $list = parent::getDetail($param = array('modelName' => 'Staffs', 'field' => 'staffId,loginName'), $condition);
        return isset($type) ? $list['loginName'] : '<a href="' . U("Admin/Staffs/detail?uid=". $list['staffId']) . '" data-toggle="modal" data-target="#myModal">' . $list['loginName'] . '</a>';
    }

    /**
      +----------------------------------------------------------
     * 列表中根据步骤编号获取步骤名称
      +----------------------------------------------------------
     */
    public static function getStepNameByStepNo($condition, $type) {
        $list = parent::getList($param = array('modelName' => 'Process', 'field' => '*', 'order' => 'stepNo ASC'), $condition);
        foreach ($list as $k => $v) {
            if(isset($type))
                $list[$v['stepNo']] = $v['stepName'];
            else
                $list[$v['stepNo']] = '<a href="/Admin/Process/index/moduleName/' . $v['moduleName'] . '/stepNo/' . $v['stepNo'] . '" data-toggle="modal" data-target="#myModal">' . $v['stepName'] . '</a>';
        }
        return $list;
    }

}

?>
