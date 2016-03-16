<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :
* @date: 2015年11月4日 上午11:30:04
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;

// 本类由系统自动生成，仅供测试用途
class BaseController extends CommonController {

    public function demoRegion() {
        $province = M('Region')->where(array('pid' => 1))->select();
        $this->assign('province', $province);
        $this->display();
    }

    public function getRegion() {
        $Region = M("Region");
        $map['pid'] = $_REQUEST["pid"];
        $map['type'] = $_REQUEST["type"];
        $list = $Region->where($map)->select();
        echo json_encode($list);
    }

}