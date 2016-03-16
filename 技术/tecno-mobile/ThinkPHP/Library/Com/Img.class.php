<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-16  17:01:00
 * @version 1.0
 * @description 公用图片模型
 */

namespace Com;

class Img {

    /**
     * 下载远程图片到本地
     *
     * @param string $txt 用户输入的文字，可能包含有图片的url
     * @param string $keywords 网站域名关键字，路径中含有这个关键字的图片(即本网站图片)跳过
     * @return string
     */
    public function getImageToLocal($txt, $keywords = 'xxx.com') {

        $matches = array();
        preg_match_all('/<img.+?src=(.+?)\s/is', $txt, $matches);
        if (!is_array($matches))
            return $txt;
        $curl = new curl();
        $curl->setHeader(true);
        foreach ($matches[1] as $k => $v) {
            $url = trim($v, "\"'");
            $ext = '';
            if (strpos($url, $keywords) === false && substr($url, 0, 7) == 'http://') { //非本站地址,需要下载图片
                $curl->setUrl($url);
                $curl->setTimeout(5);
                $data = $curl->send();
                list($header, $imageData) = explode("\n\n", $data);
                if ($ext = $this->getImageExtension($header)) {
                    $file = IMAGE_SAVE_DIR . date('YmdHis') . rand(1, 100) . $k . '.' . $ext;
                    @file_put_contents($file, $imageData);
                    if (is_file($file))
                        $txt = str_replace($v, '"' . str_replace(ROOT, '', $file) . '"', $txt);
                }
            }
        }
        return $txt;
    }

    /**
     * 从HTTP头分离出图片的扩展名
     *
     * @param string $header HTTP头
     * @return string
     */
    function getImageExtension($header) {
        $arr = explode("\n", $header);
        foreach ($arr as $k => $v) {
            $line = explode(':', $v);
            if ($line[0] == 'Content-Type')
                return str_replace('image/', '', trim($line[1]));
        }
        return '';
    }

}

?>
