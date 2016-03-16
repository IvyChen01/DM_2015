<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :后台首页控制器
* @date: 2015年11月10日 下午6:00:48
* @author: yanhui.chen
* @version:
*/

namespace Admin\Controller;

use Think\Controller;
use Common\Controller\CommonController;
use Common\Model\CommonModel;

class IndexController extends CommonController {

    public function index(){

        $leftMenu = CommonModel::leftMenu();
        $this->assign('level',$leftMenu['level']);
        $this->assign('leftMenu',$leftMenu['menu']);
        $this->display();
    }

    public function desk() {
        //pre($_SESSION['my_info']);
        //服务器信息
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
        } else {
            $gd = "不支持";
        }
        $info = array(
            '操作系统' => PHP_OS,
            '主机名IP端口' => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            '程序目录' => WEB_ROOT,
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            'GD库版本' => $gd,
            //'MYSQL版本' => mysql_get_server_info(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '采集函数检测' => ini_get('allow_url_fopen') ? '支持' : '不支持',
            'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : "OFF",
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? 'YES' : 'NO',
        );
        $this->assign('server_info', $info);
        $this->display();
    }

    public function myInfo() {
        if (IS_POST) {
            $this->checkToken();
            $this->ajaxReturn(D("staffs")->editPass());
        } else {
            $this->assign('info', $_SESSION['myInfo']);
            $this->display('changePwd');
        }
    }
    public function barChart(){

        $chartData = array(
            tooltip => array(
                trigger=> "axis"
            ),
            legend=> array(
                data=>array("发布量")
            ),
            toolbox=> array(
                show => true,
                feature => array(
                    mark => array(show=> true),
                    dataView => array(show=> true, readOnly=> false),
                    magicType => array(show=> true, type=> array("bar", "line")),
                    restore => array(show=> true),
                    saveAsImage => array(show=> true)
                )
            ),
            calculable => true,
            xAxis => array(
                array(
                    type => "category",
                    data => array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月")
                )
            ),
            yAxis => array(
                array(
                    type => "value"
                )
            ),
            series => array(
                array(
                    name=>"发布量",
                    type=>"bar",
                    data=>array(20, 40, 70, 23, 25, 76, 135, 162, 32, 20, 60, 30),
                    markPoint => array(
                        data => array(
                            array(type => "max", name=> "最大值"),
                            array(type => "min", name=> "最小值")
                        )
                    ),
                    markLine => array(
                        data => array(
                            array(type => "average", name=> "平均值")
                        )
                    )
                ),
            )
        );
        $this->ajaxReturn($chartData);
    }

    public function lineChart(){

        $chartData = array(
            tooltip => array(
                trigger=> "axis"
            ),
            legend=> array(
                data=>array("男","女")
            ),
            toolbox=> array(
                show => true,
                feature => array(
                    mark => array(show=> true),
                    dataView => array(show=> true, readOnly=> false),
                    magicType => array(show=> true, type=> array("line", "bar")),
                    restore => array(show=> true),
                    saveAsImage => array(show=> true)
                )
            ),
            calculable => true,
            xAxis => array(
                array(
                    type => "category",
                    boundaryGap => false,
                    data => array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月")
                )
            ),
            yAxis => array(
                array(
                    type => "value",
                    axisLabel => array(
                        formatter=> ""
                    )
                )
            ),
            series => array(
                array(
                    name=>"男",
                    type=>"line",
                    data=>array(15, 15, 14, 12, 16, 13, 15, 17, 15, 16, 13, 15),
                    markPoint => array(
                        data => array(
                            array(type => "max", name=> "最大值"),
                            array(type => "min", name=> "最小值")
                        )
                    ),
                    markLine => array(
                        data => array(
                            array(type => "average", name=> "平均值")
                        )
                    )
                ),
                array(
                    name=>"女",
                    type=>"line",
                    data=>array(5, 8, 6, 4, 7, 5, 3, 4, 5, 8, 10, 6),
                    markPoint => array(
                        data => array(
                            array(type => "max", name=> "最大值"),
                            array(type => "min", name=> "最小值")
                        )
                    ),
                    markLine => array(
                        data => array(
                            array(type => "average", name => "平均值")
                        )
                    )
                )
            )
        );
        $this->ajaxReturn($chartData);
    }

    public function cache() {
//        $caches = array(
//            "allCache" => WEB_CACHE_PATH,
//            "allRunCache" => WEB_CACHE_PATH . "Runtime/",
//            "allAdminRunCache" => WEB_CACHE_PATH . "Runtime/Admin/",
//            "allHomeRunCache" => WEB_CACHE_PATH . "Runtime/Home/",
//            "allHomeRunCache" => WEB_CACHE_PATH . "Runtime/Home/",
//        );
        $caches = array(
            "HomeCache" => array("name" => "网站前台缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Cache/Home/"),
            "AdminCache" => array("name" => "网站后台缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Cache/Admin/"),
            "HomeData" => array("name" => "网站前台数据库字段缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Data/Home/"),
            "AdminData" => array("name" => "网站后台数据库字段缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Data/Admin/"),
            "HomeLog" => array("name" => "网站前台日志缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Logs/Home"),
            "AdminLog" => array("name" => "网站后台日志缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Logs/Admin"),
            "HomeTemp" => array("name" => "网站前台临时缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Temp/Home/"),
            "AdminTemp" => array("name" => "网站后台临时缓存文件", "path" => WEB_CACHE_PATH . "Runtime/Temp/Admin"),
            /* "Homeruntime" => array("name" => "网站前台runtime.php缓存文件", "path" => WEB_CACHE_PATH . "Runtime/~runtime.php"),
            "Adminruntime" => array("name" => "网站后台runtime.php缓存文件", "path" => WEB_CACHE_PATH . "Runtime/~runtime.php"),
            "MinFiles" => array("name" => "JS\CSS压缩缓存文件", "path" => WEB_CACHE_PATH . "MinFiles/") */
        );
        if (IS_POST) {
            //var_dump($_POST['cache']);exit;
            foreach ($_POST['cache'] as $path) {
                if (isset($caches[$path]))
                    delDirAndFile($caches[$path]['path']);
            }
//            pre($_POST);
//            $this->checkToken();
            $this->ajaxReturn(array("status" => 1,"statusCode"=>200, "message" => "缓存文件已清除",'closeCurrent'=>true));
        } else {
            $this->assign("caches", $caches);
            $this->display();
        }
    }

}