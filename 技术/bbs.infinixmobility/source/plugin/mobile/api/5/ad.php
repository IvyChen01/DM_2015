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
$variable['app_version'] = $pic_list['app_version'];
mobile_core::result(mobile_core::variable($variable));


/**
 * 获取首页广告列表
 * @author someday
 * @return unknown
 */
function get_forum_ad_list($dw = null) {
    //$ad_custom = C::t('common_advertisement_custom')->fetch_by_name($name);
    $cache_time = 86400;
    global $_G;
    $ad_custom_app_version = C::t('common_advertisement_custom')->fetch_by_id(3);
    
    
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
            //app version检测
            if(isset($ad_custom_app_version['id'])) {
                if(isset($parameters['extra']['customid']) &&  $parameters['extra']['customid'] == $ad_custom_app_version['id']) {
                    //$thumb = get_ad_thumb($parameters['url'], $dw);
         
                    $ad_list['app_version'] = array('link'=>$parameters['link'], 'version'=>$parameters['title'],'message'=>$parameters['message']);
                }
            } else {
                if(isset($parameters['link']) && isset($parameters['url']) && isset($parameters['alt'])) {
                    //$thumb = get_ad_thumb($parameters['url'], $dw);
                    $ad_list['app_version'] = array('link'=>$parameters['link'], 'images'=>$thumb, 'title'=>$parameters['alt'],'message'=>$parameters['message']);
                }
            }
             
        }
    }
    return $ad_list;
}



?>