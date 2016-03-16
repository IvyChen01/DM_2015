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


class UserWidget extends Controller {

    /**
      +----------------------------------------------------------
     * 获取用户信息
     * @param  int  $uid  用户uid
     * @param  string  $field  要获取的字段名
     * @return   string  返回信息
      +----------------------------------------------------------
     */
    public function userInfo($uid,$field) {

        $userInfo = CommonModel::getDetail($param = array('modelName' => 'User'), $condition);
        return $userInfo[$field];
    }


}

?>