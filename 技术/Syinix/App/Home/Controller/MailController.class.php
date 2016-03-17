<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :
* @date: 2015年11月4日 上午11:30:58
* @author: yanhui.chen
* @version:
*/

namespace Home\Controller;

use Think\Controller;

// 本类由系统自动生成，仅供测试用途
class IndexController extends Controller {

    public function index() {
        import('QRCode');
        $QRCode = new QRCode('', 150);
        $img_url = $QRCode->getUrl("http://blog.51edm.org");
        echo '<img src="' . $img_url . '" />';
    }

    public function mail() {
        send_mail("652806154@qq.com", "cyh", "测试邮箱", "测试邮件是否能正常发送");
    }

}