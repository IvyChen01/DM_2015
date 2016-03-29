<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: favthread.php 27451 2012-02-01 05:48:47Z monkey $
 */
if (! defined('IN_MOBILE_API')) {
    exit('Access Denied');
}
define('APPTYPEID', 1);
define('CURSCRIPT', 'home');

require_once './source/class/class_core.php';
require_once './source/function/function_home.php';

C::app()->init();

$id = $_GET['id'];
DB::result_first("DELETE FROM " . DB::table('home_notification') . " WHERE id='$id'");

$variable = array();
$return = mobile_core::variable($variable);
$result = DB::result_first("SELECT * FROM " . DB::table('home_notification') . " WHERE id='$id'");

if (! empty($result)||$id=='') {
    $return['Message'] = array(
        'messageval' => 'fail',
        'messagestr' => 'fail'
    );
} else {
    $return['Message'] = array(
        'messageval' => 'delete succsess',
        'messagestr' => 'delete succsess'
    );
}
mobile_core::result($return);

?>