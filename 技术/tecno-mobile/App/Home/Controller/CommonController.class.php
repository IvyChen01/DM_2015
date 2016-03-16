<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :
* @date: 2015年11月4日 上午11:30:30
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;
use Common\Model\CommonModel;
use Admin\Model\ChannelModel;

class CommonController extends Controller {

    function _initialize() {
    	$this->channelModel = D('Admin/Channel');
        $this->channelDetail = $this->channelModel->getChannelDetailById(I('get.cid'));
    }

}

?>