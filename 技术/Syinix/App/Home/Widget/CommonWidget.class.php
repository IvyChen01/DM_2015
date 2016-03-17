<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-11-22 13:33
 * @version 1.0
 * @description  公用Widget
 */

namespace Home\Widget;

use Think\Controller;
use Common\Model\CommonModel;


class CommonWidget extends Controller {

    /**
      +----------------------------------------------------------
     * 根据主键id获取详细信息
     * @param  string  $modelName  模块名称
     * @param  int  $id  表id值
     * @param  string  $field  要获取的字段名
     * @return   string  返回信息
      +----------------------------------------------------------
     */
    public function getDetail($modelName,$id,$field) {
        $condition['cid'] = $id;
        $info = CommonModel::getDetail($param = array('modelName' => $modelName), $condition);
        return $info[$field];
    }


}

?>