<?php
/**
 * Copyright @ 2013 Infinix. All rights reserved.
 * ==============================================
 * @Description :获取帖子分类
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
$variable['typeid_arr'] = C::t('forum_threadclass')->fetch_typeid_by_fid(41);
mobile_core::result(mobile_core::variable($variable));
