<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forumindex.php 27451 2012-02-01 05:48:47Z monkey $
 */
if (! defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

define('APPTYPEID', 0);
define('CURSCRIPT', 'search');

require './source/class/class_core.php';

C::app()->init();
global $_G;
$hotsearch = array();

if ($_G['setting']['srchhotkeywords']) {
    foreach ($_G['setting']['srchhotkeywords'] as $k=>$val) {
        $val = trim($val);
        if ($val) {
            $hotsearch[$k]['keyword'] = $val;
            $hotsearch[$k]['url'] = $_G['siteurl'] . 'index.php?module=searchthread&srchtxt=' . rawurlencode($val) . '&version=' . (empty($_GET['secversion']) ? '5' : $_GET['secversion']);
        }
    }
}
$variable = array(
    'hotsearch' => $hotsearch
);
mobile_core::result(mobile_core::variable($variable));

?>