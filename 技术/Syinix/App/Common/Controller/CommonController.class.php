<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : common控制器
* @date: 2015年10月28日 上午10:45:08
* @author: yanhui.chen
* @version:
*/
namespace Common\Controller;

use Think\Controller;
use Common\Model\CommonModel;

class CommonController extends Controller {

    public $loginMarked;
    public $myInfo;

    /**
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
     */
    public function _initialize() {

        $this->loginMarked = md5(C('TOKEN.admin_marked'));
        $this->checkLogin();
        //$this->getQRCode();
        if(C('USER_AUTH_ON')&&!in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))){
            //导入RBAC类，开始验证
            import('ORG.Util.RBAC');
            $RBAC = new \Org\Util\Rbac();
            //通过accessDecision获取权限信息
           // var_dump($_SESSION['_ACCESS_LIST']);exit;
           // var_dump($RBAC->getAccessList());exit;
            if(!$RBAC->AccessDecision()){
                //没有获取到权限信息时需要执行的代码
                /* //1、用户没有登录
                 if(!$_SESSION[C('USER_AUTH_KEY')]){
                 $url= U('Public/login');
                 $this->error("您还没有登录不能访问",$url);
                 } */
               $this->error("您没有操作权限");
           } 
        }
        $this->myInfo = $_SESSION['myInfo'];
        $this->assign("myInfo", $_SESSION['myInfo']);
    }

    /**
      +----------------------------------------------------------
     * 查询关键词
      +----------------------------------------------------------
     */
    public function searchKeywords() {
        $searchArr = $_POST['search'];
        return $searchArr;
    }

    /**
      +----------------------------------------------------------
     * 生成查询条件
      +----------------------------------------------------------
     */
    public function searchCondition() {
        foreach ($this->searchKeywords() as $k => $v) {
            $condition[$k] = array('like', '%' . $v . '%');
        }
        return $condition;
    }

    protected function getQRCode($url = NULL) {
        if (IS_POST) {
            $this->assign("QRcodeUrl", "");
        } else {
//            $url = empty($url) ? C('WEB_ROOT') . $_SERVER['REQUEST_URI'] : $url;
            $url = empty($url) ? C('WEB_ROOT') . U(MODULE_NAME . '/' . ACTION_NAME) : $url;
            /**
              import('QRCode');
              $QRCode = new QRCode('', 80);
              $QRCodeUrl = $QRCode->getUrl($url);
              $this->assign("QRcodeUrl", $QRCodeUrl);
             */
        }
    }

    public function checkLogin() {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['admin_timeout'])) {
                setcookie("$this->loginMarked", NULL, -3600, "/");
                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                $this->error("登录超时，请重新登录", U("Admin/Public/index"));
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie("$this->loginMarked", $cookie[0] . "_" . time(), 0, "/");
                } else {
                    //setcookie("$this->loginMarked", NULL, -3600, "/");
                    //unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    //$this->error("帐号异常，请重新登录", U("Public/index"));
                }
            }
        } else {
            $this->redirect("Admin/Public/index");
        }
        return TRUE;
    }

    /**
     * 验证token信息
     */
    protected function checkToken() {
        if (IS_POST) {
            if (!M("Staffs")->autoCheckToken($_POST)) {
                die(json_encode(array('status' => 0, 'info' => '令牌验证失败')));
            }
            unset($_POST[C("TOKEN_NAME")]);
        }
    }

    /**
     * 显示一级菜单
     */
    private function show_menu() {
        $cache = C('admin_big_menu');
        $count = count($cache);
        $i = 1;
        $menu = "";
        foreach ($cache as $url => $name) {
            if ($i == 1) {
                $css = $url == CONTROLLER_NAME || !$cache[CONTROLLER_NAME] ? "fisrt_current" : "fisrt";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else if ($i == $count) {
                $css = $url == CONTROLLER_NAME ? "end_current" : "end";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else {
                $css = $url == CONTROLLER_NAME ? "current" : "";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            }
            $i++;
        }
        return $menu;
    }

    /**
     * 显示二级菜单
     */
    private function show_sub_menu() {
        $big = CONTROLLER_NAME == "Index" ? "Common" : CONTROLLER_NAME;
        $cache = C('admin_sub_menu');
        $sub_menu = array();
        if ($cache[$big]) {
            $cache = $cache[$big];
            foreach ($cache as $url => $title) {
                $url = $big == "Common" ? $url : "$big/$url";
                $sub_menu[] = array('url' => U("$url"), 'title' => $title);
            }
            return $sub_menu;
        } else {
            return $sub_menu[] = array('url' => '#', 'title' => "该菜单组不存在");
        }
    }
    /**
	 * 单个上传图片
	 */
    public function uploadPic(){
	   $config = array(
		        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		        'exts'          =>  array('jpg','png','gif','jpeg'), //允许上传的文件后缀
		        'rootPath'      =>  './Uploads/', //保存根路径
		        'driver'        =>  'LOCAL', // 文件上传驱动
		        'subName'       =>  array('date', 'Y-m'),
		        'savePath'      =>  I('dir','uploads')."/"
		);
	   
	    $folder = I("folder");
		$upload = new \Think\Upload($config);
		$rs = $upload->upload($_FILES);
		$Filedata = key($_FILES);
		if(!$rs){
			$this->error($upload->getError());
		}else{
			$images = new \Think\Image();
			$images->open('./Uploads/'.$rs[$Filedata]['savepath'].$rs[$Filedata]['savename']);
			$newsavename = str_replace('.','_thumb.',$rs[$Filedata]['savename']);
			$vv = $images->thumb(I('width',100), I('height',100))->save('./Uploads/'.$rs[$Filedata]['savepath'].$newsavename);
	        $rs[$Filedata]['savepath'] = "Uploads/".$rs[$Filedata]['savepath'];
			$rs[$Filedata]['savethumbname'] = $newsavename;
			$rs['status'] = 1;
			
			if($folder=="Filedata"){
				$sfilename = I("sfilename");
				$fname = I("fname");
				$srcpath = $rs[$Filedata]['savepath'].$rs[$Filedata]['savename'];
				$thumbpath = $rs[$Filedata]['savepath'].$rs[$Filedata]['savethumbname'];
				echo "<script>parent.getUploadFilename('$sfilename','$srcpath','$thumbpath','$fname');</script>";
			}else{
				echo json_encode($rs);
			}
			
		}	
    }
    /*
     * 图片上传
     *
     */
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $rd['statusCode'] = 200;
            $rd['message'] = C('ALERT_MSG.EXECUTE_SUCCESS');
            $rd['filename'] = './Uploads/'.$info['file']['savepath'].$info['file']['savename'];
            $this->ajaxReturn($rd);
        }
    }

}