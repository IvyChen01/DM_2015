<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :获取欢迎页面列表页图片
* @date: 2015年6月24日 下午12:13:47
* @author: yanhui.chen
* @version:
*/
if (!defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');

require './source/class/class_core.php';
require './source/function/function_forum.php';

C::app()->init();


$variable = array();
// 获取首页广告
$width = $_GET ['thumb_image_width'] ? $_GET ['thumb_image_width'] : null;
$pic_list = get_forum_ad_list($width);
$variable ['ad_list'] = $pic_list['index'];
$variable['welcome'] = $pic_list['welcome']['images'];
$variable['tw'] = $pic_list['tw']['images'];
mobile_core::result(mobile_core::variable($variable));


/**
 * 获取首页广告列表
 * @author someday
 * @return unknown
 */
function get_forum_ad_list($dw = null) {
    //$name = '手机客户端首页广告';
    //$ad_custom = C::t('common_advertisement_custom')->fetch_by_name($name);
    $cache_time = 86400;
    global $_G;
    $ad_custom_welcome = C::t('common_advertisement_custom')->fetch_by_id(1);
    $ad_custom_index = C::t('common_advertisement_custom')->fetch_by_id(2);
    $tw_custom_index = C::t('common_advertisement_custom')->fetch_by_id(4);
    
    
    $title = '';
    $starttime = 0;
    $endtime = 0;
    $type = 'custom';
    $target = '';
    $orderby = '';
    $start_limit = 0;
    $advppp = 100;
    $ads = C::t('common_advertisement')->fetch_all_search($title, $starttime, $endtime, $type, $target, $orderby, $start_limit, $advppp);
   
    $ad_list = array();
    if(is_array($ads) && $ads) {
        foreach($ads as $key => $val) {
            $parameters = unserialize($val['parameters']);
            //welcome图片
            if(isset($ad_custom_welcome['id'])) {
                if(isset($parameters['extra']['customid']) &&  $parameters['extra']['customid'] == $ad_custom_welcome['id']) {
                    $thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['welcome'] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt']);
                }
            } else {
                if(isset($parameters['link']) && isset($parameters['url']) && isset($parameters['alt'])) {
                    $thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['welcome'] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt']);
                }
            }
            
            //首页广告图
            if(isset($ad_custom_index['id'])) {
                if(isset($parameters['extra']['customid']) &&  $parameters['extra']['customid'] == $ad_custom_index['id']) {
                    $thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['index'][] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt']);
                }
            } else {
                if(isset($parameters['link']) && isset($parameters['url']) && isset($parameters['alt'])) {
                    $thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['index'][] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt']);
                }
            }
            //twitter图片
            if(isset($tw_custom_index['id'])) {
                if(isset($parameters['extra']['customid']) &&  $parameters['extra']['customid'] == $tw_custom_index['id']) {
                    $thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['tw'] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt']);
                }
            } else {
                if(isset($parameters['link']) && isset($parameters['url']) && isset($parameters['alt'])) {
                    $thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['tw'] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt']);
                }
            }
            
             
            if(count($ad_list['index']) >= 4) {
                break;
            }
             
        }
    }
    return $ad_list;
}

function get_ad_thumb($image_url, $dw = null) {
    global $_G;
    $type = !empty($_GET['type']) ? $_GET['type'] : 'fixnone';
    // 	$type = 1;

    if(empty($dw)) {
        return $image_url;
    }
    if(strpos($image_url, $_SERVER['SERVER_NAME']) === false) {
        return $image_url;
    }
    $daid = md5($image_url, true);
    $dh = $dw;
    // 	$thumbfile = 'image/'.helper_attach::makethumbpath($daid, $dw, $dh);
    $thumbfile = 'image/'.md5($image_url).'_'.$dw.'.jpg';
    $attachurl = helper_attach::attachpreurl();
    if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
        return $attachurl.$thumbfile;
    }
    $image_dir = substr($image_url, strlen("http://".$_SERVER['SERVER_NAME']."/data/attachment/"));
    $filename = $_G['setting']['attachdir'].$image_dir;
    require_once libfile('class/image');
    $img = new image;
    if($rs = $img->Thumb($filename, $thumbfile, $dw, $dh, $type)) {
        return $attachurl.$thumbfile;
    } else {
        return $image_url;
        // 		return $image_url.";5;".$rs.";".$filename.$thumbfile.":".$attachurl.$thumbfile;
    }
}
?>