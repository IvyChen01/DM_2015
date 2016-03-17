<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 修改密码模型
* @date: 2015年11月3日 下午2:08:45
* @author: yanhui.chen
* @version:
*/
namespace Admin\Model;

use Think\Model;

class IndexModel extends Model {

    public function myInfo($datas) {
        $M = M("Staffs");
        if (md5($datas['pwd0'] . $_SESSION['myInfo']['secretKey']) != $_SESSION['myInfo']['pwd']) {
            return array('status' => 0, 'info' => "旧密码错误");
        }
        $data['staffId'] = $_SESSION['myInfo']['staffId'];
        $data['loginPwd'] = md5($datas['pwd'] . $_SESSION['myInfo']['secretKey']);
        if ($M->save($data)) {
            setcookie("$this->loginMarked", NULL, -3600, "/");
            unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
            return array('status' => 1, 'info' => "你的密码已经成功修改，请重新登录", 'url' => U('Access/index'));
        } else {
            return array('status' => 0, 'info' => "密码修改失败");
        }
    }

}

?>
