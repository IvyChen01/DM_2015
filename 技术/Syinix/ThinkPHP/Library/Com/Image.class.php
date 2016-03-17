<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-12-09
 * @version 1.0
 * @description 下载文远程图片到本地
 * @usage
 * $content = '这里是文章内容，这里插入一张图片测试 <img src="http://www.yanue.net/wp-content/uploads/2012/03/48ef3a3e1f30e9246abc40834c086e061c95f7521.jpg"> <img src="http://pic.cr173.com/up/2011-5/2011520162813.jpg"> <img src="/Uploads/image/20141209/20140511164535_94263.jpg"> <img src="/Uploads/image/20141209/20140511164536_26303.jpg">';
 * $Img = new Image($savePath = '/Uploads/image/', $domain = 'ewsd.cn');
 * echo $Img->getImageToLocal($content);
 */

namespace Com;

class Image {

    /**
     * 初始化
     * @param string $savePath 图片保存地址，相对于根目录，如：/Uploads/image/
     * @param string $domain 网站域名关键字，路径中含有这个关键字的图片(即本网站图片)跳过
     */
    public $savePath;
    public $domain;

    function __construct($savePath = '/Uploads/image/', $domain = '') {
        $this->savePath = $savePath . date('Y') . '/' . date('m') .'/' . date('d');
        $this->domain = !empty($domain) ? $domain : $_SERVER['HTTP_HOST'];
    }

    /**
     * 循环创建目录
     * @param string $content 用户输入的文字，可能包含有图片的url
     * @return string $content 返回替换地址后的内容
     */
    function getImageToLocal($content){
        // 删除由 addslashes() 函数添加的反斜杠
        $content = stripslashes($content);
        $img_array = array();
        // 匹配所有远程图片
        //$pattern = "/(src|SRC)=["|'|]{0,}(http://(.*).(gif|jpg|jpeg|bmp|png))/isU";
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.jpeg|\.bmp|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern, $content, $img_array);

        // 匹配出来的不重复图片
        $img_array = array_unique($img_array[1]);

        // 时间无限制
        set_time_limit(0);

        foreach ($img_array as $key => $value) {
            $value = trim($value);
            //非本站地址,需要下载图片
            if (strpos($value, $this->domain) === false && substr($value, 0, 7) == 'http://') {
                // 检查并创建文件夹
                $realPath = $_SERVER['DOCUMENT_ROOT'] . $this->savePath;
                $this->makeDir($realPath);
                // 读取远程图片
                $get_file = @file_get_contents($value);
                // 保存到本地图片名称
                $imgname = date("YmdHis") . '_' . rand (10000, 99999) . "." . substr($value, -3,3);
                // 保存到本地的实际文件地址（包含路径和名称）
                $fileName = $realPath . '/' . $imgname;
                // 实际访问的地址
                $fileurl = $this->savePath . "/" . $imgname;
                // 文件写入
                if ($get_file) {
                    $fp = @fopen($fileName, "w");
                    @fwrite ($fp, $get_file);
                    @fclose ($fp);
                }
                // 替换原来的图片地址
                $content = str_replace($value, $fileurl, $content);
            }
        }
        return $content;
    }

    /**
     * 循环创建目录
     * @param string $path 要创建的目录路径
     * @return bool 创建成功返回true
     */
    function makeDir($path) {
        return is_dir($path) or ($this->makeDir(dirname($path)) and @mkdir($path, 0777));
    }

}

?>